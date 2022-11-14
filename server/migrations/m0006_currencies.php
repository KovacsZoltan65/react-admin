<?php

class m0006_currencies
{
    public function up()
    {
        $db = Application::$app->db;
        
        $query = "DROP TABLE IF EXISTS currencies;
        CREATE TABLE `currencies` (
            `cu_currency` VARCHAR(50) NOT NULL COMMENT 'Pénznem azonosítója',
            `cu_decimal` INT(11) NOT NULL DEFAULT '2' COMMENT 'TIzedesek száma megjelenítésnél',
            `cu_balance_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Váltható erre a cég egyenlege',
            `cu_card_payment_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Kártyás fizetés engedélyezve ezzel a pénznemmel',
            `cu_invoice_payment_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Utalásos fizetés engedélyezve ezzel a pénznemmel',
            `cu_currency_symbol` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            `status` TINYINT(4) DEFAULT NULL COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            `mod_u_id` INT(11) NOT NULL COMMENT 'módosító azonosítója',
            `in_select` INT(1) NOT NULL DEFAULT 1 COMMENT 'Listában szerepel; 0: nem; 1: igen',
            `uuid` varchar(36) DEFAULT NULL COMMENT 'Globális azonosító',
            `checksum` varchar(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            `created_at` timestamp NULL DEFAULT NULL COMMENT 'rekord készült',
            `updated_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            `status_changed_at` timestamp NULL DEFAULT NULL COMMENT 'státusz változás',
            `syncronized_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (`cu_currency`) USING BTREE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;
                
        DROP TABLE IF EXISTS currencies_tl;
        CREATE TABLE `currencies_tl` (
            `tl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            `mod_at` timestamp NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            `mod_op` enum('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            `cu_currency` VARCHAR(50) NOT NULL COMMENT 'Pénznem azonosítója',
            `cu_decimal` INT(11) NOT NULL DEFAULT '2' COMMENT 'TIzedesek száma megjelenítésnél',
            `cu_balance_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Váltható erre a cég egyenlege',
            `cu_card_payment_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Kártyás fizetés engedélyezve ezzel a pénznemmel',
            `cu_invoice_payment_enable` BIT(1) NULL DEFAULT 0 COMMENT 'Utalásos fizetés engedélyezve ezzel a pénznemmel',
            `cu_currency_symbol` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            `status` TINYINT(4) DEFAULT NULL COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            `mod_u_id` INT(11) NOT NULL COMMENT 'módosító azonosítója',
            `in_select` INT(1) NOT NULL DEFAULT 1 COMMENT 'Listában szerepel; 0: nem; 1: igen',
            `uuid` varchar(36) DEFAULT NULL COMMENT 'Globális azonosító',
            `checksum` varchar(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            `created_at` timestamp NULL DEFAULT NULL COMMENT 'rekord készült',
            `updated_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            `status_changed_at` timestamp NULL DEFAULT NULL COMMENT 'státusz változás',
            `syncronized_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (`tl_id`) USING BTREE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB;
                
        DROP TRIGGER IF EXISTS currencies_AFTER_INSERT;
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.currencies_AFTER_INSERT AFTER INSERT ON mvc_framework.currencies 
        FOR EACH ROW
        BEGIN
           INSERT INTO currencies_tl SELECT NEW.mod_u_id, UTC_TIMESTAMP(), 1, c.* FROM currencies c WHERE c.cu_currency = NEW.cu_currency;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;
        
        DROP TRIGGER IF EXISTS currencies_AFTER_UPDATE;
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER currencies_AFTER_UPDATE
           AFTER UPDATE
           ON currencies
           FOR EACH ROW
        BEGIN
        
         IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
           set @mod_op = 2;
           # ha törölték a rekordot, akkor ...
           IF OLD.status = 1 AND NEW.status = 0 THEN
             # A módosítási opciót 3-ra (SD delete) állítom
             set @mod_op = 3;
           ELSEIF OLD.status = 0 AND NEW.status = 1 THEN
             # A módosítási opciót 4-re (R restore) állítom
             set @mod_op = 4;
           END IF;
        
           INSERT INTO currencies_tl SELECT NULL, UTC_TIMESTAMP(), @mod_op, c.* FROM currencies c WHERE c.cu_currency = NEW.cu_currency;
        
         END IF;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;
                
        DROP TRIGGER IF EXISTS currencies_BEFORE_DELETE;
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.currencies_BEFORE_DELETE
           BEFORE DELETE
           ON mvc_framework.currencies
           FOR EACH ROW
        BEGIN
         IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
           INSERT INTO currencies_tl SELECT NULL, UTC_TIMESTAMP(), 5, c.* FROM currencies c WHERE c.cu_currency = OLD.cu_currency;
         END IF;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;
                
        DROP TRIGGER IF EXISTS currencies_BEFORE_INSERT;
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.currencies_BEFORE_INSERT BEFORE INSERT ON mvc_framework.currencies
        FOR EACH ROW
        BEGIN
         SET NEW.created_at = UTC_TIMESTAMP();
         SET NEW.updated_at = UTC_TIMESTAMP();
         SET NEW.uuid = UUID();
         SET NEW.checksum = MD5(
           CONCAT(
               NEW.cu_currency, 
               NEW.cu_decimal, 
               NEW.cu_balance_enable, 
               NEW.cu_card_payment_enable, 
               NEW.cu_currency_symbol
           )
         );
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;
                
        DROP TRIGGER IF EXISTS currencies_BEFORE_UPDATE;
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.currencies_BEFORE_UPDATE
           BEFORE UPDATE
           ON currencies
           FOR EACH ROW
        BEGIN
        
         IF ( OLD.status <> NEW.status ) THEN
           SET NEW.status_changed_at = UTC_TIMESTAMP();
         END IF;
        
         SET @new_checksum = MD5(
           CONCAT(
               NEW.cu_currency, 
               NEW.cu_decimal, 
               NEW.cu_balance_enable, 
               NEW.cu_card_payment_enable, 
               NEW.cu_currency_symbol
           )
         );
        
         IF ( OLD.checksum <> @new_checksum ) THEN
           SET NEW.updated_at = UTC_TIMESTAMP();
           SET NEW.checksum = @new_checksum;
         END IF;
        
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;";

        $db->pdo->exec($query);
    }

    public function down(){}
}