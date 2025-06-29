-- database-data.sql
USE secure_app;

-- Drop the table if it exists to start fresh
DROP TABLE IF EXISTS Users;

-- Recreate the table
CREATE TABLE Users (
  username VARCHAR(50) NOT NULL PRIMARY KEY,
  password VARCHAR(100) NOT NULL
);

-- Insert a user with an md5 hashed password
INSERT INTO Users (username, password) VALUES ('admin', md5('pass'));