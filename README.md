SYSTEM ACCESS GUIDE

Welcome! This guide explains how to access and use the EyeRis Shield: Eye Care Website hosted on the FSKTM server.

Ensure you are connected to the local UTHM network - either via UTHM Wi-Fi or Eduroam on campus.


🌐 Access URL
The system can be accessed via:

1) Web URL: https://10.65.200.6/ai220261/


2) Link to PSM folder & executable:

a)	phpMyAdmin: https://10.65.200.6/phpmyadmin/
b)	File Browser: http://10.65.200.6:3000/filebrowser/

To log in to both services, use the following username and password:
Username: ai220261
Password: ai220261


👁️System Overview

- There are 3 types of users: admin, users/patients, and eye specialists/doctors. 
- All types of users will be directed to the homepage.
- Unauthorised users/patients can access certain features on the homepage. To gain access to all features, they are required to create an account and log in.
- Each type of user is authorised to access the system through an authorised account.
- Only users/patients need to sign up.
- Eye specialists/Doctors can directly log in to the website since their account is created by the admin.
- Admins can directly log in, since they have an account which all admins can access.


🔐 Login Credentials

Admin Panel
Username: admin
Password: admin123


Users/Patients Panel

Register your account via the sign-up page or use:
Username: user21
Password: 123456


Eye specialists/Doctors Panel
example: Username (Password)

kavitha (Kavitha123)
LimYL (LimYL123)
YipCW (YipCW123)
peter (Peter123)
LiuHS (LiuHS123)
alene (Alene123)
robert (Robert123)
WongYM (WongYM123)


📁 Project Structure (Web-Based)

ai220261/
│
├── index.php 
├── signup.php
├── login.php 
├── password.php
├── (other files....)
|
├── images/
│   └── 
├── uploads/
│   └── 
├── sounds/
│   └── alarm.mp3
└── config/
    └── db.php
