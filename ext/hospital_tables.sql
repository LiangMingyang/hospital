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
    PRIMARY KEY (Hospital_ID)
);

CREATE TABLE Depart (
    Depart_ID INT (11) NOT NULL AUTO_INCREMENT,
    Hospital_ID INT (11),
    -- Hospital_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Hospital_ID) REFERENCES Hospital(Hospital_ID) ON UPDATE CASCADE,
    Depart_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Depart_ID)
);

CREATE TABLE Doctor (
    Doctor_ID INT (11) NOT NULL AUTO_INCREMENT,
    Depart_ID INT (11),
    -- Depart_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Depart_ID) REFERENCES Depart(Depart_ID) ON UPDATE CASCADE,
    Doctor_Name VARCHAR (10) NOT NULL,
    Doctor_Level INT (2),
    Doctor_Fee FLOAT (4, 2),
    Doctor_Limit INT (2),
    Doctor_Major VARCHAR (30),
    Doctor_Picture_url VARCHAR (50),
    PRIMARY KEY (Doctor_ID)
);

CREATE TABLE Province (
    Province_ID INT (2) NOT NULL AUTO_INCREMENT,
    Province_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Province_ID)
);

CREATE TABLE Area (
    Area_ID INT (11) NOT NULL AUTO_INCREMENT,
    Province_ID INT (2) NOT NULL,
    -- Province_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Province_ID) REFERENCES Province(Province_ID) ON UPDATE CASCADE,
    Area_Name VARCHAR (10) NOT NULL,
    PRIMARY KEY (Area_ID)
);

CREATE TABLE USER (
    User_ID INT (11) NOT NULL AUTO_INCREMENT,
    Area_ID INT (11) NOT NULL,
    -- Area_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Area_ID) REFERENCES Area(Area_ID) ON UPDATE CASCADE,
    UserName VARCHAR (20) NOT NULL,
    isChecked INT (1) NOT NULL DEFAULT 0,
    Identity_ID VARCHAR (30) NOT NULL,
    PASSWORD VARCHAR (20) NOT NULL,
    Credit_Rank INT (2) NOT NULL DEFAULT 3,
    Appointment_Limit INT (2) NOT NULL DEFAULT 3,
    Birthday VARCHAR (10) NOT NULL,
    Location VARCHAR (30) NOT NULL,
    Mail VARCHAR (30) NOT NULL,
    Phone VARCHAR (20) NOT NULL,
    FailTime INT (1) NOT NULL,
    PRIMARY KEY (User_ID)
);

CREATE TABLE Admin (
    Admin_ID INT (11) NOT NULL AUTO_INCREMENT,
    Admin_Name VARCHAR (10),
    PASSWORD VARCHAR (20),
    isSuper INT (1),
    PRIMARY KEY (Admin_ID)
);

CREATE TABLE Manage (
    Hospital_ID INT (11) NOT NULL,
    -- Hospital_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Hospital_ID) REFERENCES Hospital(Hospital_ID) ON UPDATE CASCADE,
    Admin_ID INT (11) NOT NULL,
    -- Admin_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID) ON UPDATE CASCADE,
    PRIMARY KEY (Hospital_ID, Admin_ID)
);

CREATE TABLE Reservation (
    User_ID INT (11) NOT NULL,
    -- User_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (User_ID) REFERENCES User(User_ID) ON UPDATE CASCADE,
    Doctor_ID INT (11) NOT NULL,
    -- Doctor_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID) ON UPDATE CASCADE,
    Reservation_ID INT (11) NOT NULL,
    Reservation_Time datetime NOT NULL,
    Reseration_Symptom VARCHAR (50),
    Reservation_Payed INT (1) NOT NULL,
    Reservation_PayTime datetime,
    Reservation_PayAmount FLOAT (4, 2),
    Operation_Time datetime NOT NULL,
    PRIMARY KEY (User_ID, Doctor_ID)
);

CREATE TABLE History_Reservation (
    History_Reservation_ID INT (11) NOT NULL AUTO_INCREMENT,
    User_ID INT (11),
    -- User_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (User_ID) REFERENCES User(User_ID) ON UPDATE CASCADE,
    Doctor_ID INT (11),
    -- Doctor_ID应该添加外键约束，级联更新可选，级联删除待考虑
    -- FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID) ON UPDATE CASCADE,
    History_Reservation_Time datetime NOT NULL,
    History_Reservation_Symptom VARCHAR (50),
    History_Reservation_Paied INT (1) NOT NULL,
    History_Pay_Time datetime,
    History_Operation_Time datetime NOT NULL,
    PRIMARY KEY (History_Reservation_ID)
);

CREATE TABLE Reset_Pwd_Security (
    ID INT (11) NOT NULL AUTO_INCREMENT,
    resetLink VARCHAR (200) NOT NULL,
    STATUS INT (1) NOT NULL,
    genTime datetime NOT NULL,
    PRIMARY KEY (ID)
);
