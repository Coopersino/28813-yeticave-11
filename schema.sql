 CREATE DATABASE yeticave_base
     DEFAULT CHARACTER SET utf8
     DEFAULT COLLATE utf8_general_ci;
     USE yeticave_base;

 CREATE TABLE categories (
     id    INT AUTO_INCREMENT PRIMARY KEY,
     categor_name  VARCHAR(128) NOT NULL,
     categor_code  VARCHAR(128) NOT NULL
 );

 CREATE TABLE advertisements (
     id               INT AUTO_INCREMENT PRIMARY KEY,
     dt_add           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     adv_name         VARCHAR(128) NOT NULL,
     description      VARCHAR (256),
     img_url          VARCHAR (2083),
     cost             DECIMAL NOT NULL,
     expiration_date  TIMESTAMP NOT NULL,
     rate_step        DECIMAL,
     autor_id         INT NOT NULL,
     winner_id        INT DEFAULT 0,
     category_id      VARCHAR(128) NOT NULL
 );

 CREATE TABLE rates (
     id         INT AUTO_INCREMENT PRIMARY KEY,
     dt_add     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     rate_value DECIMAL NOT NULL,
     user_id    INT NOT NULL,
     advert_id  INT NOT NULL
 );

 CREATE TABLE users (
     id         INT AUTO_INCREMENT PRIMARY KEY,
     dt_add     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     email      VARCHAR(128) NOT NULL,
     user_name       VARCHAR(128) NOT NULL,
     user_password   CHAR(64) NOT NULL,
     contacts   VARCHAR(128) NOT NULL,
     advert_id  INT,
     rate_id    INT
 );

CREATE UNIQUE INDEX advert_name ON advertisements(adv_name);
CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX user_name ON users(user_name);
CREATE INDEX cat_name ON categories(categor_name);
CREATE INDEX start_value ON rates(rate_value);
CREATE INDEX cost ON advertisements(cost);

CREATE INDEX adv_description ON advertisements(description);
CREATE INDEX adv_title ON advertisements(adv_name);
CREATE FULLTEXT INDEX adv_fulltext_search ON advertisements(adv_name, description);