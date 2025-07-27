-- database-setup.sql

-- Create the database and user (if not already done)
CREATE DATABASE IF NOT EXISTS waph;
CREATE USER IF NOT EXISTS 'cannoni1'@'localhost' IDENTIFIED BY 'pass';
GRANT ALL ON waph.* TO 'cannoni1'@'localhost';
FLUSH PRIVILEGES;

USE waph;

-- Drop the old table to recreate it with new columns
DROP TABLE IF EXISTS users;

-- Create the new table with name and email fields
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100)
);

-- Insert a test user
INSERT INTO users (username, password, name, email) VALUES ('admin', md5('pass'), 'Admin User', 'admin@example.com');
