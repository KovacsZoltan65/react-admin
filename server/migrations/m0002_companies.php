<?php

/**
 * m0002_companies.php
 * User: kzoltan
 * Date: 2022-06-18
 * Time: 14:00
 */

class m0002_companies
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "
        # ---------------
        # companies table
        # ---------------
        CREATE TABLE mvc_framework.companies (
            id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            name VARCHAR(255) NOT NULL COMMENT 'email cím',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
            in_select INT(1) NOT NULL DEFAULT '1' COMMENT 'Listában szerepel',
            uuid VARCHAR(36) DEFAULT NULL COMMENT 'globális azonosító',
            checksum VARCHAR(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            created_at TIMESTAMP NULL DEFAULT NULL COMMENT 'rekord készült',
            updated_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            status_changed_at TIMESTAMP NULL DEFAULT NULL COMMENT 'státusz változás',
            syncronized_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (id)
        )
        ENGINE = INNODB,
        CHARACTER SET utf8,
        COLLATE utf8_general_ci;

        # ------------------
        # companies tl table
        # ------------------
        CREATE TABLE mvc_framework.companies_tl (
            tl_id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            mod_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            mod_op ENUM('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            id INT(11) NOT NULL COMMENT 'Rekord azonosító',
            name VARCHAR(255) NOT NULL COMMENT 'cég megnevezése',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
            in_select INT(1) NOT NULL DEFAULT '1' COMMENT 'Listában szerepel',
            uuid VARCHAR(36) DEFAULT NULL COMMENT 'globális azonosító',
            checksum VARCHAR(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            created_at TIMESTAMP NULL DEFAULT NULL COMMENT 'rekord készült',
            updated_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            status_changed_at TIMESTAMP NULL DEFAULT NULL COMMENT 'státusz változás',
            syncronized_at TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (tl_id)
          )
        ENGINE = INNODB,
        CHARACTER SET utf8,
        COLLATE utf8_general_ci;

        # -------------
        # before_insert
        # -------------
        DELIMITER $$
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.companies_BEFORE_INSERT 
        BEFORE INSERT ON companies
        FOR EACH ROW
        BEGIN
            SET NEW.created_at = UTC_TIMESTAMP();
            SET NEW.updated_at = UTC_TIMESTAMP();
            SET NEW.uuid = UUID();
            SET NEW.checksum = md5(concat(NEW.name, NEW.status));
        END$$
        DELIMITER ;

        # -------------
        # after insert
        # -------------
        DELIMITER $$
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.companies_AFTER_INSERT
            AFTER INSERT
            ON mvc_framework.companies
            FOR EACH ROW
        BEGIN
            IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                INSERT INTO companies_tl SELECT NULL, UTC_TIMESTAMP(), 1, c.* FROM companies c WHERE c.id = NEW.id;
            END IF;
        END$$
        DELIMITER ;

        DELIMITER $$
        # -------------
        # before update
        # -------------
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.companies_BEFORE_UPDATE
            BEFORE UPDATE
            ON mvc_framework.companies
            FOR EACH ROW
        BEGIN
        
          IF ( OLD.status <> NEW.status ) THEN
            SET NEW.status_changed_at = UTC_TIMESTAMP();
          END IF;
        
          SET @new_checksum = MD5(CONCAT(NEW.name, NEW.status));
        
          IF ( OLD.checksum <> @new_checksum ) THEN
            SET NEW.updated_at = UTC_TIMESTAMP();
            SET NEW.checksum = @new_checksum;
          END IF;
        
        END$$
        DELIMITER ;

        DELIMITER $$
        # -------------
        # after update
        # -------------
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.companies_AFTER_UPDATE
            AFTER UPDATE
            ON mvc_framework.companies
            FOR EACH ROW
        BEGIN
        
          IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
            set @mod_op = 2;
            # ha törölték a rekordot, akkor ...
            IF OLD.status = 1 AND NEW.status = 0 THEN
              # A módosítási opciót 3-ra (SD soft delete) állítom
              set @mod_op = 3;
            # ha visszaállították a rekordot, akkor 4-re (R restore) állítom
            ELSEIF OLD.status = 0 AND NEW.status = 1 THEN
              # A módosítási opciót 4-re (R restore) állítom
              set @mod_op = 4;
            END IF;
        
            SET @new_checksum = MD5(CONCAT(NEW.name, NEW.status));
        
            IF ( OLD.checksum <> @new_checksum ) THEN
              INSERT INTO companies_tl SELECT NULL, UTC_TIMESTAMP(), @mod_op, c.* FROM companies c WHERE c.id = NEW.id;
            END IF;
        
          END IF;
        END$$
        
        DELIMITER ;

        DELIMITER $$
        # -------------
        # before delete
        # -------------
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.companies_BEFORE_DELETE
            BEFORE DELETE
            ON mvc_framework.companies
            FOR EACH ROW
        BEGIN
          IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
            INSERT INTO companies_tl SELECT NULL, UTC_TIMESTAMP(), 5, c.* FROM companies c WHERE c.id = OLD.id;
          END IF;
        END$$
        DELIMITER ;";
        
        $db->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        
        $query = "";
        
        $db->exec($query);
    }
}