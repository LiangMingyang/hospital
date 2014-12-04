/**
 * 运行如下语句执行
 * mysql -u test < hostpital_tables.sql
 */

DROP DATABASE IF EXISTS Hospital_Reservation_DB;

CREATE DATABASE Hospital_Reservation_DB CHARACTER SET utf8;

USE Hospital_Reservation_DB;

CREATE TABLE Province (
    Province_ID INT (2) NOT NULL AUTO_INCREMENT,
    Province_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Province_ID)
);

CREATE TABLE Area (
    Area_ID INT (11) NOT NULL AUTO_INCREMENT,
    Province_ID INT (2) NOT NULL,
    Area_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Area_ID),
    FOREIGN KEY (Province_ID) REFERENCES Province(Province_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Hospital (
    Hospital_ID INT (11) NOT NULL AUTO_INCREMENT,
    Area_ID INT (11) NOT NULL,
    Hospital_Level INT (2),
    Hospital_Introduction VARCHAR (200),
    Hospital_Name VARCHAR (30) NOT NULL,
    Hospital_Location VARCHAR (20),
    Reservation_Start_Time datetime,
    Reservation_End_Time datetime,
    Hospital_Picture_url VARCHAR (50),
    PRIMARY KEY (Hospital_ID),
    FOREIGN KEY (Area_ID) REFERENCES Area(Area_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Depart (
    Depart_ID INT (11) NOT NULL AUTO_INCREMENT,
    Hospital_ID INT (11) NOT NULL,
    Depart_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Depart_ID),
    FOREIGN KEY (Hospital_ID) REFERENCES Hospital(Hospital_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Doctor (
    Doctor_ID INT (11) NOT NULL AUTO_INCREMENT,
    Depart_ID INT (11) NOT NULL,
    Doctor_Name VARCHAR (10) NOT NULL,
    Doctor_Level INT (2),
    Doctor_Fee DECIMAL (4, 2),
    Doctor_Limit INT (2),
    Doctor_Major VARCHAR (30),
    Doctor_Picture_url VARCHAR (50),
    PRIMARY KEY (Doctor_ID),
    FOREIGN KEY (Depart_ID) REFERENCES Depart(Depart_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE User (
    User_ID INT (11) NOT NULL AUTO_INCREMENT,
    Area_ID INT (11) NOT NULL,
    UserName VARCHAR (20) NOT NULL,
    isChecked INT (1) NOT NULL DEFAULT 0,
    Identity_ID VARCHAR (30) NOT NULL,
    PASSWORD VARCHAR (20) NOT NULL,
    Credit_Rank INT (2) NOT NULL DEFAULT 3,
    Appointment_Limit INT (2) NOT NULL DEFAULT 3,
    Amount DECIMAL (7, 2) NOT NULL DEFAULT 0.00,
    Sex INT (1) NOT NULL,
    Birthday datetime NOT NULL,
    Location VARCHAR (30) NOT NULL,
    Mail VARCHAR (30) NOT NULL,
    FailTime datetime NOT NULL,
    LastLogInTime datetime NOT NULL,
    Phone VARCHAR (20) NOT NULL,
    FailTime INT (1) NOT NULL,
    PRIMARY KEY (User_ID),
    FOREIGN KEY (Area_ID) REFERENCES Area(Area_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Admin (
    Admin_ID INT (11) NOT NULL AUTO_INCREMENT,
    Admin_Name VARCHAR (10),
    PASSWORD VARCHAR (20),
    Mail VARCHAR(30) NOT NULL,
    FailTime datetime NOT NULL,
    LastLogInTime datetime NOT NULL,
    isSuper INT (1) DEFAULT 0,
    PRIMARY KEY (Admin_ID)
);

CREATE TABLE Manage (
    Hospital_ID INT (11) NOT NULL,
    Admin_ID INT (11) NOT NULL,
    PRIMARY KEY (Hospital_ID, Admin_ID),
    FOREIGN KEY (Hospital_ID) REFERENCES Hospital(Hospital_ID) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID) ON UPDATE CASCADE
);

CREATE TABLE Reservation (
    User_ID INT (11) NOT NULL,
    Doctor_ID INT (11) NOT NULL,
    Reservation_ID INT (11) NOT NULL AUTO_INCREMENT,
    Reservation_Time datetime NOT NULL,
    Reseration_Symptom VARCHAR (50),
    Reservation_Payed INT (1) NOT NULL,
    Reservation_PayTime datetime,
    Reservation_PayAmount DECIMAL (4, 2),
    Operation_Time datetime NOT NULL,
    PRIMARY KEY (Reservation_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE History_Reservation (
    History_Reservation_ID INT (11) NOT NULL AUTO_INCREMENT,
    User_ID INT (11) NOT NULL,
    Doctor_ID INT (11) NOT NULL,
    History_Reservation_Time datetime NOT NULL,
    History_Reservation_Symptom VARCHAR (50),
    History_Reservation_Paied INT (1) NOT NULL,
    History_Pay_Time datetime,
    History_Operation_Time datetime NOT NULL,
    PRIMARY KEY (History_Reservation_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Reset_Pwd_Security (
    ID INT (11) NOT NULL AUTO_INCREMENT,
    resetLink VARCHAR (200) NOT NULL,
    STATUS INT (1) NOT NULL,
    genTime datetime NOT NULL,
    PRIMARY KEY (ID)
);
