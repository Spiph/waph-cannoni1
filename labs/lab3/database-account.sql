-- database-account.sql
CREATE DATABASE waph;
CREATE USER 'cannoni1'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL ON waph.* TO 'cannoni1'@'localhost';
