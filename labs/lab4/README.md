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

### Lab 4

#### Task 1: Understanding Session Management in a PHP Web Application

##### 1.a. Deploy and test sessiontest.php

This shows my session is working

![First Visit](<Screenshot 2025-07-15 205149.png>)

![Visited Twice](image.png)

![First Time on Firefox](image-1.png)

![Up to 3 on Firefox](image-2.png)

##### 1.b. Observe the Session-Handshaking using Wireshark (6 pts)

Here is the first session on Firefox:

![firefox first session](<Screenshot 2025-07-15 205631.png>)

The response assigns an id for the cookie, PHPSESSID:

![Mmmmm Cookies](image-4.png)

You can see the second GET request now has a cookie:

![Cookie Use](image-3.png)

You can see the server recognizes the session and replies without setting a new cookie

##### 1.c. Understanding Session Hijacking (2 pts)

![Chrome Cookie](image-5.png)

![before refresh](image-6.png)

![after refresh (it decremented to the chrome cookie)](image-7.png)

#### Task 2: Insecure Session Authentication

##### 2.a. Revised Login System with Session Management (10 pts)

![login required (chrome)](image-8.png)

![grab the cookie](image-10.png)

![login required (firefox)](image-9.png)

![Access granted (firefox without signin)](image-11.png)

#### Task 3 

##### 3.a. Data Protection and HTTPS Setup (10 pts)

![make some certs](image-12.png)

![No cookies :(](image-13.png)

##### 3.b.

![so secure](image-15.png)


##### 3.c.

![caught ya!](image-14.png)