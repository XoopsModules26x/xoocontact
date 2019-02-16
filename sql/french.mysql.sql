CREATE TABLE `xoocontact_fields` (
  `xoocontact_id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `xoocontact_description` TEXT         NOT NULL,
  `xoocontact_value`       TEXT         NOT NULL,
  `xoocontact_formtype`    VARCHAR(15)  NOT NULL,
  `xoocontact_valuetype`   VARCHAR(10)  NOT NULL,
  `xoocontact_default`     VARCHAR(255) NOT NULL,
  `xoocontact_min_width`   SMALLINT(3)  NOT NULL,
  `xoocontact_max_width`   SMALLINT(3)  NOT NULL,
  `xoocontact_required`    TINYINT(1)   NOT NULL DEFAULT '1',
  `xoocontact_display`     TINYINT(1)   NOT NULL DEFAULT '1',
  `xoocontact_order`       TINYINT(3)   NOT NULL,
  PRIMARY KEY (`xoocontact_id`)
)
  ENGINE = MyISAM;

INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (1, 'Title', 'a:3:{i:1;s:4:"Mlle";i:2;s:3:"Mme";i:3;s:2:"Mr";}', 'radio', 'int', '0', 0, 0, 1, 1, 1);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (2, 'Name', '', 'textbox', 'string', '', 100, 200, 1, 1, 2);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (3, 'Firstname', '', 'textbox', 'string', '', 50, 100, 1, 1, 3);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (4, 'Email', '', 'mail', 'string', '', 150, 100, 1, 1, 4);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (5, 'Website', '', 'url', 'string', 'http://', 100, 100, 1, 1, 5);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (6, 'Subject', '', 'textbox', 'string', '', 200, 200, 1, 1, 6);
INSERT INTO `xoocontact_fields` (`xoocontact_id`, `xoocontact_description`, `xoocontact_value`, `xoocontact_formtype`, `xoocontact_valuetype`, `xoocontact_default`, `xoocontact_min_width`, `xoocontact_max_width`, `xoocontact_required`, `xoocontact_display`, `xoocontact_order`)
VALUES (7, 'Message', '', 'textarea', 'string', '', 5, 50, 1, 1, 7);
