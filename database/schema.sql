SET NAMES 'utf8';
SET CHARACTER SET 'utf8';
SET SESSION collation_connection = 'utf8_general_ci';

CREATE TABLE `groups` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `figures` (
      `id` INT(11) UNSIGNED NOT NULL,
      `name` VARCHAR(20) NOT NULL,
      PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `figures` (id, name) VALUES (1, 'Треугольник'), (2, 'Круг'), (3, 'Квадрат');

CREATE TABLE `results` (
        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `group_id` INT(11) UNSIGNED,
        `figure_id` INT(11) UNSIGNED,
        `size` INT(2),
        `color` VARCHAR(20),
        PRIMARY KEY (`id`),
        FOREIGN KEY  (`group_id`) REFERENCES `groups`(`id`) ON DELETE CASCADE,
        FOREIGN KEY  (`figure_id`) REFERENCES `figures`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;