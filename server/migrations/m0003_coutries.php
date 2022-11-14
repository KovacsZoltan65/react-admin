<?php

/**
 * m0003_countries.php
 * User: kzoltan
 * Date: 2022-06-20
 * Time: 13:45
 */

/**
 * Description of m0003_coutries
 *
 * @author kzoltan
 */
class m0003_coutries
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "
        # -------------------------------
        # countries
        # -------------------------------        
        CREATE TABLE mvc_framework.countries (
            id                INT(11) UNSIGNED NOT NULL COMMENT 'Rekord azonosító',
            lang_hu           VARCHAR(50) DEFAULT NULL COMMENT 'nyelv magyarul',
            lang_orig         VARCHAR(50) DEFAULT NULL COMMENT 'nyelv eredeti',
            country_hu        VARCHAR(50) DEFAULT NULL COMMENT 'ország magyarul',
            country_orig      VARCHAR(50) DEFAULT NULL COMMENT 'ország eredeti',
            country_short     VARCHAR(4) DEFAULT NULL COMMENT 'ország rövid',
            currency          VARCHAR(3) DEFAULT NULL COMMENT 'Pénznem',
            vat_region        INT(11) DEFAULT NULL COMMENT '0: Belföld, 1: EU, 3: EU-n kívül',
            in_select         INT(1) NOT NULL DEFAULT 1 COMMENT 'Select választóban; 0: nem; 1: igen',
            status            TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id          INT(11) NOT NULL COMMENT 'módosító azonosítója',
            in_select         INT(1) NOT NULL DEFAULT '1' COMMENT 'Listában szerepel',
            uuid              VARCHAR(36) DEFAULT NULL COMMENT 'Globális rekord azonosító',
            checksum          VARCHAR(32) DEFAULT NULL COMMENT 'ellenörző összeg',
            created_at        TIMESTAMP NULL DEFAULT NULL COMMENT 'rekord készült',
            updated_at        TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó frissítés',
            status_changed_at TIMESTAMP NULL DEFAULT NULL COMMENT 'státusz változás',
            syncronized_at    TIMESTAMP NULL DEFAULT NULL COMMENT 'utolsó szinkronizálás',
            deleted_at        TIMESTAMP NULL DEFAULT NULL COMMENT 'Törlés dátuma',
            PRIMARY KEY (id)
          )
        ENGINE = INNODB,
        CHARACTER SET utf8,
        COLLATE utf8_general_ci;
        
        # -------------------------------
        # countries_tl
        # -------------------------------
        CREATE TABLE mvc_framework.countries_tl (
            tl_id INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            mod_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Módosító azonosítója',
            mod_op ENUM('I','U','SD','R','D') DEFAULT NULL COMMENT 'Módosítás típusa I = insert; U = update; SD = soft delete; R = restore; D = delete',
            id INT(11) UNSIGNED NOT NULL COMMENT 'Rekord azonosító',
            lang_hu VARCHAR(50) DEFAULT NULL COMMENT 'nyelv magyarul',
            lang_orig VARCHAR(50) DEFAULT NULL COMMENT 'nyelv eredeti',
            country_hu VARCHAR(50) DEFAULT NULL COMMENT 'ország magyarul',
            country_orig VARCHAR(50) DEFAULT NULL COMMENT 'ország eredeti',
            country_short VARCHAR(4) DEFAULT NULL COMMENT 'ország rövid',
            currency VARCHAR(3) DEFAULT NULL COMMENT 'Pénznem',
            vat_region INT(11) DEFAULT NULL COMMENT '0: Belföld, 1: EU, 3: EU-n kívül',
            status TINYINT(4) DEFAULT 1 COMMENT 'Státusz; 0 = törölt; 1 = aktív',
            mod_u_id INT(11) NOT NULL COMMENT 'módosító azonosítója',
            in_select INT(1) NOT NULL DEFAULT 1 COMMENT 'Listában szerepel; 0: nem; 1: igen',
            uuid VARCHAR(36) DEFAULT NULL COMMENT 'Globális rekord azonosító',
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

        # -------------------------------
        # countries_BEFORE_INSERT
        # -------------------------------
        DELIMITER $$
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.countries_BEFORE_INSERT BEFORE INSERT ON mvc_framework.countries
        FOR EACH ROW
        BEGIN
          SET NEW.created_at = UTC_TIMESTAMP();
          SET NEW.updated_at = UTC_TIMESTAMP();
          SET NEW.uuid = UUID();
          SET NEW.checksum = md5(
            concat(
                IF(NEW.lang_hu IS  NULL, '', NEW.lang_hu), 
              IF(NEW.lang_orig IS NULL, '', NEW.lang_hu), NEW.country_hu, NEW.country_orig, NEW.country_short, NEW.vat_region, NEW.in_select
            )
          );
        END$$
        
        DELIMITER ;
        
        # -------------------------------
        # countries_BEFORE_UPDATE
        # -------------------------------
        DELIMITER $$

        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.countries_BEFORE_UPDATE
            BEFORE UPDATE
            ON countries
            FOR EACH ROW
        BEGIN

        IF ( OLD.status <> NEW.status ) THEN
            SET NEW.status_changed_at = UTC_TIMESTAMP();
        END IF;

        IF ( NEW.status = 0 ) THEN
            SET NEW.deleted_at = UTC_TIMESTAMP();
        ELSEIF ( NEW.status = 1 ) THEN
            SET NEW.deleted_at = NULL;
        END IF;

        SET NEW.checksum = md5(
            concat(
                IF(NEW.lang_hu IS  NULL, '', NEW.lang_hu), 
                IF(NEW.lang_orig IS NULL, '', NEW.lang_hu), 
                NEW.country_hu, NEW.country_orig, NEW.country_short, NEW.vat_region, NEW.in_select
            )
          );

          IF ( OLD.checksum <> @new_checksum ) THEN
            SET NEW.updated_at = UTC_TIMESTAMP();
            SET NEW.checksum = @new_checksum;
          END IF;

        END$$

        DELIMITER ;
        
        # -------------------------------
        # countries_BEFORE_DELETE
        # -------------------------------
        DELIMITER $$
        
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.countries_BEFORE_DELETE
            BEFORE DELETE
            ON countries
            FOR EACH ROW
        BEGIN
          IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
            INSERT INTO countries_tl SELECT NULL, UTC_TIMESTAMP(), 5, c.* FROM countries c WHERE c.id = OLD.id;
          END IF;
        END

        DELIMITER ;

        # -------------------------------
        # countries_AFTER_INSERT
        # -------------------------------
        DELIMITER $$
        
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.countries_AFTER_INSERT
            AFTER INSERT
            ON countries
            FOR EACH ROW
        BEGIN
            IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                INSERT INTO countries_tl SELECT NULL, UTC_TIMESTAMP(), 1, c.* FROM countries c WHERE c.id = NEW.id;
            END IF;
        END$$

        DELIMITER ;


        # -------------------------------
        # countries_AFTER_UPDATE
        # -------------------------------
        DELIMITER $$
        
        CREATE DEFINER=`root`@`localhost` TRIGGER mvc_framework.countries_AFTER_UPDATE
            AFTER UPDATE
            ON countries
            FOR EACH ROW
        BEGIN
            IF @disable_trigger IS NULL OR @disable_trigger = 0 THEN
                INSERT INTO countries_tl SELECT NULL, UTC_TIMESTAMP(), 1, c.* FROM countries c WHERE c.id = NEW.id;
            END IF;
        END$$

        DELIMITER;";
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        
        $query = "";
        $db->pdo->exec($query);
    }
}
