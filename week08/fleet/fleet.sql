CREATE DATABASE wp;
USE wp;
CREATE TABLE fleet
(
    id serial primary key,
    make varchar(20),
    model varchar(30),
    manufactured year
);
SHOW TABLES;
DESCRIBE fleet;

INSERT INTO fleet
VALUES
    (null, 'Toyota', 'Corolla', 2020);

