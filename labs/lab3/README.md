# WAPH-Web Application Programming and Hacking

## Instructor: Dr. Phu Phung

## Student

**Name**: Ian Cannon

**Email**: [mailto:cannoni1@udayton.edu](cannoni1@udayton.edu)

**Short-bio**: Ian Cannon interests in Reinforcement Learning for Autonomous Control. 

![Ian's headshot](../../images/headshot.jpg)

## Repository Information

Respository's URL: [https://github.com/Spiph/WebAppDev](https://github.com/Spiph/WebAppDev)

This is a public repository for Ian Cannon to store all code from the course. The organization of this repository is as follows.

### Lab 3

#### a. Database Setup and Management 

I created `secure_app` and the non-root user `webuser`

[database-account](database-account.sql)

Then I created an admin account

[database-data](database-data.sql)

![here is the output for verification](image.png)


#### b. A Simple (Insecure) Login System with PHP/MySQL

[form](form.php) 

[index](index.php)

#### c. Performing XSS and SQL Injection Attacks

Following the instructions from the checkin, here is my attack: `admin' #<script>alert(document.cookie)</script>`

![scripting attack](<Screenshot 2025-06-29 190028.png>)

And the output from the attack

![Attacked!](<Screenshot 2025-06-29 190012.png>)