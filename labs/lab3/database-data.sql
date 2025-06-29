-- database-data.sql
USE secure_app;

CREATE TABLE Users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

INSERT INTO Users (username, password) VALUES
  ('alice', '$2y$10$abcdefghijklmnopqrstuv'),  -- example bcrypt hashes
  ('bob',   '$2y$10$1234567890abcdefghijklmnopqrstuvwxyz');

echo password_hash('alice_password', PASSWORD_BCRYPT), "\n";
