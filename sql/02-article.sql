CREATE TABLE IF NOT EXISTS `product_category`
(
    `category_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(100) NOT NULL UNIQUE,
    `description` TEXT,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `product`
(
    `product_id` INT AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(255) NOT NULL,
    `content`    TEXT         NOT NULL,
    `quantity`   INT          NOT NULL DEFAULT 0,
    `author_id`  INT          NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `category_id` INT NOT NULL,
    FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `product_category` (`category_id`) ON DELETE CASCADE
);

INSERT INTO permission (role_name) VALUES ('product_view');
INSERT INTO permission (role_name) VALUES ('product_edit');
INSERT INTO permission (role_name) VALUES ('product_delete');
INSERT INTO permission (role_name) VALUES ('product_create');
INSERT INTO permission (role_name) VALUES ('product_category_view');
INSERT INTO permission (role_name) VALUES ('product_category_edit');
INSERT INTO permission (role_name) VALUES ('product_category_delete');
INSERT INTO permission (role_name) VALUES ('product_category_create');



