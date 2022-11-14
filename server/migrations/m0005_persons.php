<?php

use app\core\Application;

/**
 * m0005_persons.php
 * User: kzoltan
 * Date: 2022-11-10
 * Time: 07:20
 */

class m0005_persons
{
    public function up()
    {
        $db = Application::$app->db;
        
        $query = "
        # -------------------
        # persons
        # -------------------
        DROP TABLE IF EXISTS persons;
        CREATE TABLE IF NOT EXISTS `persons` (
            `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            `name` varchar(255) NOT NULL COMMENT 'név',
            `company_id` int(11) NOT NULL COMMENT 'cég azonosító',
            `country_id` int(11) NOT NULL COMMENT 'ország azonosító',
            `lang_id` int(11) NOT NULL COMMENT 'nyelv azonosító',
            `status` tinyint(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            `mod_u_id` int(11) NOT NULL COMMENT 'módosító azonosítója',
            `in_select` INT(1) NOT NULL DEFAULT 1 COMMENT 'Listában szerepel; 0: nem; 1: igen',
            `uuid` varchar(36) DEFAULT NULL COMMENT 'Globális rekord azonosító',
            `checksum` varchar(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            `created_at` timestamp NULL DEFAULT NULL COMMENT 'rekord készült',
            `updated_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            `status_changed_at` timestamp NULL DEFAULT NULL COMMENT 'státusz változás',
            `syncronized_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        # -------------------
        # persons_tl
        # -------------------
        DROP TABLE IF EXISTS persons_tl;
        CREATE TABLE IF NOT EXISTS `persons_tl` (
            `tl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            `mod_at` timestamp NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            `mod_op` enum('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            `id` int(11) NOT NULL COMMENT 'Rekord azonosító',
            `name` varchar(255) NOT NULL COMMENT 'név',
            `company_id` int(11) NOT NULL COMMENT 'cég azonosító',
            `country_id` int(11) NOT NULL COMMENT 'ország azonosító',
            `lang_id` int(11) NOT NULL COMMENT 'nyelv azonosító',
            `status` tinyint(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            `mod_u_id` int(11) NOT NULL COMMENT 'módosító azonosítója',
            `in_select` INT(1) NOT NULL DEFAULT 1 COMMENT 'Listában szerepel; 0: nem; 1: igen',
            `uuid` varchar(36) DEFAULT NULL COMMENT 'Globális rekord azonosító',
            `checksum` varchar(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            `created_at` timestamp NULL DEFAULT NULL COMMENT 'rekord készült',
            `updated_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            `status_changed_at` timestamp NULL DEFAULT NULL COMMENT 'státusz változás',
            `syncronized_at` timestamp NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            PRIMARY KEY (`tl_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        # --------------------
        # persons_after_insert
        # --------------------
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.persons_AFTER_INSERT AFTER INSERT ON mvc_framework.persons 
        FOR EACH ROW
        BEGIN
            INSERT INTO persons_tl SELECT NEW.mod_u_id, UTC_TIMESTAMP(), 1, u.* FROM user u WHERE u.u_id = NEW.id;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;

        # -------------------
        # persons_after_update
        # -------------------
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER persons_AFTER_UPDATE
        AFTER UPDATE
        ON persons
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

                INSERT INTO persons_tl SELECT NULL, UTC_TIMESTAMP(), @mod_op, u.* FROM persons u WHERE u.id = NEW.id;

            END IF;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;

        # ---------------------
        # persons_before_delete
        # ---------------------
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.persons_BEFORE_DELETE
        BEFORE DELETE
        ON mvc_framework.persons
        FOR EACH ROW
        BEGIN
            IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                INSERT INTO persons_tl SELECT NULL, UTC_TIMESTAMP(), 5, u.* FROM persons u WHERE u.id = OLD.id;
            END IF;
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;

        # ---------------------
        # persons_before_insert
        # ---------------------
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.persons_BEFORE_INSERT BEFORE INSERT ON mvc_framework.persons
        FOR EACH ROW
        BEGIN
            SET NEW.created_at = UTC_TIMESTAMP();
            SET NEW.updated_at = UTC_TIMESTAMP();
            SET NEW.uuid = UUID();
            SET NEW.checksum = MD5(
                CONCAT(
                    NEW.name, 
                    NEW.company_id, 
                    NEW.country_id, 
                    NEW.lang_id, 
                    NEW.status
                )
            );
        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;

        # ---------------------
        # persons_before_update
        # ---------------------
        SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
        DELIMITER //
        CREATE TRIGGER mvc_framework.persons_BEFORE_UPDATE
        BEFORE UPDATE
        ON persons
        FOR EACH ROW
        BEGIN
            IF ( OLD.status <> NEW.status ) THEN
                SET NEW.status_changed_at = UTC_TIMESTAMP();
            END IF;

            SET @new_checksum = MD5(
                CONCAT(
                    NEW.name, 
                    NEW.company_id, 
                    NEW.country_id, 
                    NEW.lang_id, 
                    NEW.status
                )
            );

            IF ( OLD.checksum <> @new_checksum ) THEN
                SET NEW.updated_at = UTC_TIMESTAMP();
                SET NEW.checksum = @new_checksum;
            END IF;

        END//
        DELIMITER ;
        SET SQL_MODE=@OLDTMP_SQL_MODE;";
    }

        public function down(){}
}