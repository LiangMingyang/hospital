/**
 * Created by 明阳 on 2014/11/30.
 * 初始数据，直接use Hospital_Reservation_DB后执行 SOURCE initSql.sql就可以了
 */
INSERT INTO `Hospital` (`Area_ID`, `Hospital_Level`, `Hospital_Introduction`, `Hospital_Name`, `Hospital_Location`, `Reservation_Start_Time`, `Reservation_End_Time`, `Hospital_Picture_url`) VALUES ('1', '1', 'nothing', '北医三院', '北航周边', '2014-11-30 00:33:10', '2014-11-30 00:33:15', 'nothing');
INSERT INTO `Depart` (`Hospital_ID`, `Depart_Name`) VALUES ('1', '北医三院');
INSERT INTO `Doctor` (`Depart_ID`, `Doctor_Name`, `Doctor_Level`, `Doctor_Fee`, `Doctor_Limit`, `Doctor_Major`, `Doctor_Picture_url`) VALUES ('1', 'DB', '1', '10', '1', 'Death', 'none');
INSERT INTO `User` (`Area_ID`, `UserName`, `Identity_ID`, `PASSWORD`, `Sex`, `Birthday`, `Location`, `Mail`, `Phone`, `FailTime`) VALUES ('1', 'szmdb', '111', '111', '1', '2014-11-30 00:48:18', 'www', 'aaa', '123', '0');
INSERT INTO `Reservation` (`User_ID`, `Doctor_ID`, `Reservation_Time`, `Reseration_Symptom`, `Reservation_Payed`, `Reservation_PayTime`, `Reservation_PayAmount`, `Operation_Time`) VALUES ('1', '1', '2014-11-30 00:48:58', 'ss', '1', '2014-11-30 00:49:08', '12', '2014-11-30 00:49:13');
INSERT INTO `Admin` (`Admin_ID`, `Admin_Name`, `PASSWORD`, `Mail`, `FailTime`, `LastLogInTime`, `isSuper`) VALUES ('1', 'SuperAdmin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'a@b.com', '0', '2014-12-04 23:04:26', '1')
