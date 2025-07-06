-- database-data.sql
USE waph;

-- Drop the table if it exists to start fresh
drop table if exists users;

-- Recreate the table
create table users(
username varchar(50) PRIMARY KEY,
password varchar(100) NOT NULL);

-- Insert a user with an md5 hashed password
INSERT INTO users(username, password) VALUES ('admin', md5('pass'));