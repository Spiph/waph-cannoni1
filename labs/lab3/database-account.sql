-- database-account.sql
CREATE DATABASE secure_app;
CREATE USER 'webuser'@'localhost' IDENTIFIED BY 'YOUR_PASSWORD';
GRANT ALL PRIVILEGES ON secure_app.* TO 'webuser'@'localhost';
FLUSH PRIVILEGES;
