USE `bde-api`;

DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (

    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(64),
    email_verified_at TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
    created_at TIMESTAMP DEFAULT NOW(),
    last_updated_at TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
    role_id INT,
    center_id INT

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS roles;

CREATE TABLE IF NOT EXISTS roles (

    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS centers;

CREATE TABLE IF NOT EXISTS centers (

     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR(255)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE users ADD CONSTRAINT user_role_fk   FOREIGN KEY users(role_id)   REFERENCES roles(id),
                  ADD CONSTRAINT user_center_fk FOREIGN KEY users(center_id) REFERENCES centers(id);

INSERT INTO centers (`name`)
VALUES ('Lille'),
       ('Arras'),
       ('Brest'),
       ('Caen'),
       ('Rouen'),
       ('Reims'),
       ('Nanterre'),
       ('Nancy'),
       ('Strasbourg'),
       ('Saint-Nazaire'),
       ('Nantes'),
       ('Dijon'),
       ('La-Rochelle'),
       ('Angoulème'),
       ('Lyon'),
       ('Grenoble'),
       ('Bordeaux'),
       ('Pau'),
       ('Toulouse'),
       ('Montpellier'),
       ('Aix-en-Provence'),
       ('Nice');

INSERT INTO roles (`name`)
VALUES ('Student'),
       ('BDE-Staff'),
       ('CESI-Staff'),
       ('Admin');

INSERT INTO users (`name`, `email`, `password`, `center_id`, `role_id`)
VALUES ('Admin1',   'admin1@exemple.com',   '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y', 22, 4),
       ('Admin2',   'admin2@exemple.com',   '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y', 22, 4),
       ('Student1', 'student1@exemple.com', '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y', 22, 1),
       ('BDE1',     'bde1@exemple.com',     '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y', 22, 2),
       ('CESI1',    'cesi1@exemple.com',    '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y', 22, 3);