-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Hospital_Reservation_DB
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Admin_Name` varchar(10) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `Mail` varchar(30) NOT NULL,
  `FailTime` int(1) NOT NULL,
  `LastLogInTime` datetime DEFAULT NULL,
  `isSuper` int(1) DEFAULT '0',
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (1,'SuperAdmin','20eabe5d64b0e216796e834f52d61fd0b70332fc','a@b.com',0,'2014-12-23 23:08:53',1),(2,'Operator1','7c4a8d09ca3762af61e59520943dc26494f8941b','',0,'2014-12-23 00:50:32',0),(6,'op2','7c4a8d09ca3762af61e59520943dc26494f8941b','',0,NULL,0);
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Area`
--

DROP TABLE IF EXISTS `Area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Area` (
  `Area_ID` int(11) NOT NULL,
  `Province_ID` int(2) NOT NULL,
  `Area_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Area_ID`),
  KEY `Province_ID` (`Province_ID`),
  CONSTRAINT `Area_ibfk_1` FOREIGN KEY (`Province_ID`) REFERENCES `Province` (`Province_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Area`
--

LOCK TABLES `Area` WRITE;
/*!40000 ALTER TABLE `Area` DISABLE KEYS */;
INSERT INTO `Area` VALUES (1,0,'东城区'),(2,0,'西城区'),(3,0,'崇文区'),(4,0,'宣武区'),(5,0,'朝阳区'),(6,0,'丰台区'),(7,0,'石景山区'),(8,0,'海淀区'),(9,0,'门头沟区'),(10,0,'房山区'),(11,0,'通州区'),(12,0,'顺义区'),(13,0,'昌平区'),(14,0,'大兴区'),(15,0,'怀柔区'),(16,0,'平谷区'),(17,0,'延庆县'),(18,0,'密云县'),(101,1,'滨海新区'),(102,1,'和平区'),(103,1,'河北区'),(104,1,'河东区'),(105,1,'河西区'),(106,1,'南开区'),(107,1,'红桥区'),(108,1,'东丽区'),(109,1,'西青区'),(110,1,'津南区'),(111,1,'北辰区'),(112,1,'武清区'),(113,1,'宝坻区'),(114,1,'蓟县'),(115,1,'静海县'),(116,1,'宁河县'),(201,2,'黄浦区'),(202,2,'徐汇区'),(203,2,'长宁区'),(204,2,'静安区'),(205,2,'普陀区'),(206,2,'闸北区'),(207,2,'虹口区'),(208,2,'杨浦区'),(209,2,'闵行区'),(210,2,'宝山区'),(211,2,'嘉定区'),(212,2,'浦东新区'),(213,2,'金山区'),(214,2,'松江区'),(215,2,'青浦区'),(216,2,'奉贤区'),(217,2,'崇明县'),(301,3,'万州区'),(302,3,'黔江区'),(303,3,'涪陵区'),(304,3,'渝中区'),(305,3,'大渡口区'),(306,3,'江北区'),(307,3,'沙坪坝区'),(308,3,'九龙坡区'),(309,3,'南岸区'),(310,3,'北碚区'),(311,3,'渝北区'),(312,3,'巴南区'),(313,3,'长寿区'),(314,3,'江津区'),(315,3,'合川区'),(316,3,'永川区'),(317,3,'南川区'),(318,3,'綦江区'),(319,3,'大足区'),(401,4,'石家庄市'),(402,4,'唐山市'),(403,4,'秦皇岛市'),(404,4,'邯郸市'),(405,4,'邢台市'),(406,4,'保定市'),(407,4,'张家口市'),(408,4,'承德市'),(409,4,'沧州市'),(410,4,'廊坊市'),(411,4,'衡水市'),(501,5,'郑州市'),(502,5,'开封市'),(503,5,'洛阳市'),(504,5,'平顶山市'),(505,5,'安阳市'),(506,5,'鹤壁市'),(507,5,'新乡市'),(508,5,'焦作市'),(509,5,'濮阳市'),(510,5,'许昌市'),(511,5,'漯河市'),(512,5,'三门峡市'),(513,5,'商丘市'),(514,5,'周口市'),(515,5,'驻马店市'),(516,5,'南阳市'),(517,5,'信阳市'),(518,5,'济源市'),(601,6,'昆明市'),(602,6,'昭通市'),(603,6,'曲靖市'),(604,6,'玉溪市'),(605,6,'普洱市'),(606,6,'保山市'),(607,6,'丽江市'),(608,6,'临沧市'),(609,6,'楚雄彝族自治州'),(610,6,'红河哈尼族彝族自治州'),(611,6,'文山壮族苗族自治州'),(612,6,'西双版纳傣族自治州'),(613,6,'大理白族自治州'),(614,6,'德宏傣族景颇族自治州'),(615,6,'怒江僳僳族自治州'),(616,6,'迪庆藏族自治州'),(701,7,'沈阳市'),(702,7,'大连市'),(703,7,'鞍山市'),(704,7,'抚顺市'),(705,7,'本溪市'),(706,7,'丹东市'),(707,7,'锦州市'),(708,7,'营口市'),(709,7,'阜新市'),(710,7,'辽阳市'),(711,7,'盘锦市'),(712,7,'铁岭市'),(713,7,'朝阳市'),(714,7,'葫芦岛市'),(801,8,'哈尔滨市'),(802,8,'齐齐哈尔市'),(803,8,'牡丹江市'),(804,8,'佳木斯市'),(805,8,'大庆市'),(806,8,'伊春市'),(807,8,'鸡西市'),(808,8,'鹤岗市'),(809,8,'双鸭山市'),(810,8,'七台河市'),(811,8,'绥化市'),(812,8,'黑河市'),(813,8,'大兴安岭地区'),(901,9,'长沙市'),(902,9,'株洲市'),(903,9,'湘潭市'),(904,9,'衡阳市'),(905,9,'邵阳市'),(906,9,'岳阳市'),(907,9,'张家界市'),(908,9,'益阳市'),(909,9,'常德市'),(910,9,'娄底市'),(911,9,'郴州市'),(912,9,'永州市'),(913,9,'怀化市'),(914,9,'湘西土家族苗族自治州'),(1001,10,'合肥市'),(1002,10,'芜湖市'),(1003,10,'蚌埠市'),(1004,10,'淮南市'),(1005,10,'马鞍山市'),(1006,10,'淮北市'),(1007,10,'铜陵市'),(1008,10,'安庆市'),(1009,10,'黄山市'),(1010,10,'阜阳市'),(1011,10,'宿州市'),(1012,10,'滁州市'),(1013,10,'六安市'),(1014,10,'宣城市'),(1015,10,'池州市'),(1016,10,'亳州市'),(1101,11,'济南市'),(1102,11,'青岛市'),(1103,11,'淄博市'),(1104,11,'枣庄市'),(1105,11,'东营市'),(1106,11,'烟台市'),(1107,11,'潍坊市'),(1108,11,'济宁市'),(1109,11,'泰安市'),(1110,11,'威海市'),(1111,11,'日照市'),(1112,11,'滨州市'),(1113,11,'德州市'),(1114,11,'聊城市'),(1115,11,'临沂市'),(1116,11,'菏泽市'),(1117,11,'莱芜市'),(1201,12,'乌鲁木齐市'),(1202,12,'克拉玛依市'),(1203,12,'昌吉回族自治州'),(1204,12,'博尔塔拉蒙古自治州'),(1205,12,'伊犁哈萨克自治州'),(1206,12,'巴音郭楞蒙古自治州'),(1207,12,'克孜勒苏柯尔克孜自治州'),(1208,12,'塔城地区'),(1209,12,'阿勒泰地区'),(1210,12,'吐鲁番地区'),(1211,12,'哈密地区'),(1212,12,'阿克苏地区'),(1213,12,'喀什地区'),(1214,12,'和田地区'),(1301,13,'南京市'),(1302,13,'无锡市'),(1303,13,'徐州市'),(1304,13,'常州市'),(1305,13,'苏州市'),(1306,13,'南通市'),(1307,13,'连云港市'),(1308,13,'淮安市'),(1309,13,'盐城市'),(1310,13,'扬州市'),(1311,13,'镇江市'),(1312,13,'泰州市'),(1313,13,'宿迁市'),(1401,14,'杭州市'),(1402,14,'宁波市'),(1403,14,'温州市'),(1404,14,'绍兴市'),(1405,14,'湖州市'),(1406,14,'嘉兴市'),(1407,14,'金华市'),(1408,14,'衢州市'),(1409,14,'台州市'),(1410,14,'丽水市'),(1411,14,'舟山市'),(1500,15,'萍乡市'),(1501,15,'南昌市'),(1502,15,'赣州市'),(1503,15,'宜春市'),(1504,15,'吉安市'),(1505,15,'上饶市'),(1506,15,'抚州市'),(1507,15,'九江市'),(1508,15,'景德镇市'),(1510,15,'新余市'),(1511,15,'鹰潭市'),(1601,16,'武汉市'),(1602,16,'黄石市'),(1603,16,'十堰市'),(1604,16,'荆州市'),(1605,16,'宜昌市'),(1606,16,'襄阳市'),(1607,16,'鄂州市'),(1608,16,'荆门市'),(1609,16,'黄冈市'),(1610,16,'孝感市'),(1611,16,'咸宁市'),(1612,16,'随州市'),(1613,16,'恩施土家族苗族自治州'),(1701,17,'南宁市'),(1702,17,'柳州市'),(1703,17,'桂林市'),(1704,17,'梧州市'),(1705,17,'北海市'),(1706,17,'崇左市'),(1707,17,'来宾市'),(1708,17,'贺州市'),(1709,17,'玉林市'),(1710,17,'百色市'),(1711,17,'河池市'),(1712,17,'钦州市'),(1713,17,'防城港市'),(1714,17,'贵港市'),(1801,18,'兰州市'),(1802,18,'嘉峪关市'),(1803,18,'金昌市'),(1804,18,'白银市'),(1805,18,'天水市'),(1806,18,'酒泉市'),(1807,18,'张掖市'),(1808,18,'武威市'),(1809,18,'定西市'),(1810,18,'陇南市'),(1811,18,'平凉市'),(1812,18,'庆阳市'),(1813,18,'临夏回族自治州'),(1814,18,'甘南藏族自治州'),(1901,19,'太原市'),(1902,19,'大同市'),(1903,19,'阳泉市'),(1904,19,'长治市'),(1905,19,'晋城市'),(1906,19,'朔州市'),(1907,19,'忻州市'),(1908,19,'吕梁市'),(1909,19,'晋中市'),(1910,19,'临汾市'),(1911,19,'运城市'),(2001,20,'呼和浩特市'),(2002,20,'包头市'),(2003,20,'乌海市'),(2004,20,'赤峰市'),(2005,20,'呼伦贝尔市'),(2006,20,'通辽市'),(2007,20,'乌兰察布市'),(2008,20,'鄂尔多斯市'),(2009,20,'巴彦淖尔市'),(2010,20,'兴安盟'),(2011,20,'锡林郭勒盟'),(2012,20,'阿拉善盟'),(2101,21,'西安市'),(2102,21,'铜川市'),(2103,21,'宝鸡市'),(2104,21,'咸阳市'),(2105,21,'渭南市'),(2106,21,'汉中市'),(2107,21,'安康市'),(2108,21,'商洛市'),(2109,21,'延安市'),(2110,21,'榆林市'),(2201,22,'长春市'),(2202,22,'吉林市'),(2203,22,'四平市'),(2204,22,'辽源市'),(2205,22,'通化市'),(2206,22,'白山市'),(2207,22,'白城市'),(2208,22,'松原市'),(2209,22,'延边朝鲜族自治州'),(2301,23,'福州市'),(2302,23,'莆田市'),(2303,23,'泉州市'),(2304,23,'厦门市'),(2305,23,'漳州市'),(2306,23,'龙岩市'),(2307,23,'三明市'),(2308,23,'南平市'),(2309,23,'宁德市'),(2401,24,'贵阳市'),(2402,24,'六盘水市'),(2403,24,'遵义市'),(2404,24,'铜仁市'),(2405,24,'毕节市'),(2406,24,'安顺市'),(2407,24,'黔西南布依族苗族州'),(2408,24,'黔东南苗族侗族州'),(2409,24,'黔南布依族苗族州'),(2501,25,'广州市'),(2502,25,'深圳市'),(2503,25,'珠海市'),(2504,25,'汕头市'),(2505,25,'佛山市'),(2506,25,'韶关市'),(2507,25,'湛江市'),(2508,25,'肇庆市'),(2509,25,'江门市'),(2510,25,'茂名市'),(2511,25,'惠州市'),(2512,25,'梅州市'),(2513,25,'汕尾市'),(2514,25,'河源市'),(2515,25,'阳江市'),(2516,25,'清远市'),(2517,25,'东莞市'),(2518,25,'中山市'),(2519,25,'潮州市'),(2520,25,'揭阳市'),(2521,25,'云浮市'),(2601,26,'西宁市'),(2602,26,'海东市'),(2603,26,'海北藏族自治州'),(2604,26,'黄南藏族自治州'),(2605,26,'海南藏族自治州'),(2606,26,'果洛藏族自治州'),(2607,26,'玉树藏族自治州'),(2608,26,'海西蒙古族藏族自治州'),(2701,27,'拉萨市'),(2702,27,'日喀则市'),(2703,27,'昌都地区'),(2704,27,'山南地区'),(2705,27,'那曲地区'),(2706,27,'阿里地区'),(2707,27,'林芝地区'),(2801,28,'成都市'),(2802,28,'绵阳市'),(2803,28,'自贡市'),(2804,28,'攀枝花市'),(2805,28,'泸州市'),(2806,28,'德阳市'),(2807,28,'广元市'),(2808,28,'遂宁市'),(2809,28,'内江市'),(2810,28,'乐山市'),(2811,28,'资阳市'),(2812,28,'宜宾市'),(2813,28,'南充市'),(2814,28,'达州市'),(2815,28,'雅安市'),(2816,28,'广安市'),(2817,28,'巴中市'),(2818,28,'眉山市'),(2819,28,'阿坝藏族羌族自治州'),(2820,28,'甘孜藏族自治州'),(2821,28,'凉山彝族自治州'),(2901,29,'银川市'),(2902,29,'石嘴山市'),(2903,29,'吴忠市'),(2904,29,'固原市'),(2905,29,'中卫市'),(3001,30,'海口市'),(3002,30,'三亚市'),(3003,30,'三沙市'),(3101,31,'台北市'),(3102,31,'新北市'),(3103,31,'台中市'),(3104,31,'台南市'),(3105,31,'高雄市'),(3201,32,'中西区'),(3202,32,'东区'),(3203,32,'九龙城区'),(3204,32,'观塘区'),(3205,32,'南区'),(3206,32,'深水埗区'),(3207,32,'黄大仙区'),(3208,32,'湾仔区'),(3209,32,'油尖旺区'),(3210,32,'离岛区'),(3211,32,'葵青区'),(3212,32,'北区'),(3213,32,'西贡区'),(3214,32,'沙田区'),(3215,32,'屯门区'),(3216,32,'大埔区'),(3217,32,'荃湾区'),(3218,32,'元朗区'),(3301,33,'花地玛堂区'),(3302,33,'圣安多尼堂区'),(3303,33,'大堂区'),(3304,33,'望德堂区'),(3305,33,'风顺堂区'),(3306,33,'嘉模堂区'),(3307,33,'圣方济各堂区');
/*!40000 ALTER TABLE `Area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Depart`
--

DROP TABLE IF EXISTS `Depart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Depart` (
  `Depart_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hospital_ID` int(11) NOT NULL,
  `Depart_Name` varchar(10) NOT NULL,
  PRIMARY KEY (`Depart_ID`),
  KEY `Hospital_ID` (`Hospital_ID`),
  CONSTRAINT `Depart_ibfk_1` FOREIGN KEY (`Hospital_ID`) REFERENCES `Hospital` (`Hospital_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Depart`
--

LOCK TABLES `Depart` WRITE;
/*!40000 ALTER TABLE `Depart` DISABLE KEYS */;
INSERT INTO `Depart` VALUES (1,1,'北医三院'),(5,3,'眼科'),(6,3,'耳鼻喉科'),(7,3,'神经外科'),(8,3,'神经内科'),(9,3,'肛肠科');
/*!40000 ALTER TABLE `Depart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Doctor`
--

DROP TABLE IF EXISTS `Doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doctor` (
  `Doctor_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Depart_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(10) NOT NULL,
  `Doctor_Level` int(2) DEFAULT NULL,
  `Doctor_Fee` decimal(4,2) DEFAULT NULL,
  `Doctor_Limit` int(2) DEFAULT NULL,
  `Doctor_Major` varchar(30) DEFAULT NULL,
  `Doctor_Picture_Url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Doctor_ID`),
  KEY `Depart_ID` (`Depart_ID`),
  CONSTRAINT `Doctor_ibfk_1` FOREIGN KEY (`Depart_ID`) REFERENCES `Depart` (`Depart_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doctor`
--

LOCK TABLES `Doctor` WRITE;
/*!40000 ALTER TABLE `Doctor` DISABLE KEYS */;
INSERT INTO `Doctor` VALUES (1,1,'DB',1,10.00,1,'Death','none'),(2,9,'宋子明',1,0.01,10,'优雅','http://hospital.qiniudn.com/pic_1418976697025'),(4,6,'test',1,1.00,3,'','http://hospital.qiniudn.com/pic_1418986248045'),(5,5,'耿金坤',1,2.00,3,'眼科','http://hospital.qiniudn.com/pic_1419005374183'),(6,5,'123',1,11.00,11,'123123',''),(7,5,'1233',1,11.00,11,'123123','http://hospital.qiniudn.com/pic_1419260221058');
/*!40000 ALTER TABLE `Doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Doctor_Time`
--

DROP TABLE IF EXISTS `Doctor_Time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doctor_Time` (
  `Doctor_ID` int(11) NOT NULL,
  `Duty_Time` int(2) NOT NULL,
  PRIMARY KEY (`Doctor_ID`,`Duty_Time`),
  CONSTRAINT `Doctor_Time_ibfk_1` FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doctor_Time`
--

LOCK TABLES `Doctor_Time` WRITE;
/*!40000 ALTER TABLE `Doctor_Time` DISABLE KEYS */;
INSERT INTO `Doctor_Time` VALUES (5,11),(5,12),(5,21),(5,22),(5,31),(5,32),(5,41),(5,42),(5,51),(5,52),(5,61),(5,62),(5,71),(5,72),(7,11),(7,31);
/*!40000 ALTER TABLE `Doctor_Time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `History_Reservation`
--

DROP TABLE IF EXISTS `History_Reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `History_Reservation` (
  `History_Reservation_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `History_Reservation_Time` date DEFAULT NULL,
  `History_Reservation_Symptom` varchar(50) DEFAULT NULL,
  `History_Reservation_Paied` int(1) NOT NULL,
  `History_Pay_Time` datetime DEFAULT NULL,
  `History_Operation_Time` datetime NOT NULL,
  `Duty_Time` int(2) NOT NULL,
  PRIMARY KEY (`History_Reservation_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Doctor_ID` (`Doctor_ID`),
  CONSTRAINT `History_Reservation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`User_ID`) ON UPDATE CASCADE,
  CONSTRAINT `History_Reservation_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `History_Reservation`
--

LOCK TABLES `History_Reservation` WRITE;
/*!40000 ALTER TABLE `History_Reservation` DISABLE KEYS */;
INSERT INTO `History_Reservation` VALUES (1,2,5,'2014-11-30','SRF Saaby',32,'0000-00-00 00:00:00','2014-11-30 00:10:00',2014);
/*!40000 ALTER TABLE `History_Reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hospital`
--

DROP TABLE IF EXISTS `Hospital`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hospital` (
  `Hospital_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Area_ID` int(11) NOT NULL,
  `Hospital_Level` int(2) DEFAULT NULL,
  `Hospital_Introduction` varchar(500) DEFAULT NULL,
  `Hospital_Name` varchar(30) NOT NULL,
  `Hospital_Location` varchar(50) DEFAULT NULL,
  `Reservation_Start_Time` datetime DEFAULT NULL,
  `Reservation_End_Time` datetime DEFAULT NULL,
  `Hospital_Picture_Url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Hospital_ID`),
  KEY `Area_ID` (`Area_ID`),
  CONSTRAINT `Hospital_ibfk_1` FOREIGN KEY (`Area_ID`) REFERENCES `Area` (`Area_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hospital`
--

LOCK TABLES `Hospital` WRITE;
/*!40000 ALTER TABLE `Hospital` DISABLE KEYS */;
INSERT INTO `Hospital` VALUES (1,1,0,'nothing','北医三院','北航周边','0000-00-00 08:54:30','0000-00-00 20:54:30','http://hospital.qiniudn.com/pic_1419265098813'),(3,1,31,'北京同仁医院创建于1886年（清光绪12年），是一所以眼科、耳鼻咽喉科和心血管疾病诊疗为重点的大型综合性医院。','北京同仁医院',' 北京市东城区东交民巷1号 电话：(010)58269911','0000-00-00 07:00:00','0000-00-00 15:00:00','http://hospital.qiniudn.com/pic_1419177505405'),(7,1,31,'','东城区人民医院','','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(8,2,31,'','西城区人民医院','','0000-00-00 00:00:00','0000-00-00 00:00:00',''),(9,5,31,'test','test','test','0000-00-00 00:00:00','0000-00-00 00:00:00','http://hospital.qiniudn.com/pic_1419255970442'),(10,1,31,'123123','12312','213123213','0000-00-00 00:00:00','0000-00-00 00:00:00','http://hospital.qiniudn.com/pic_1419259650874');
/*!40000 ALTER TABLE `Hospital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Manage`
--

DROP TABLE IF EXISTS `Manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Manage` (
  `Hospital_ID` int(11) NOT NULL,
  `Admin_ID` int(11) NOT NULL,
  PRIMARY KEY (`Hospital_ID`,`Admin_ID`),
  KEY `Admin_ID` (`Admin_ID`),
  CONSTRAINT `Manage_ibfk_1` FOREIGN KEY (`Hospital_ID`) REFERENCES `Hospital` (`Hospital_ID`) ON UPDATE CASCADE,
  CONSTRAINT `Manage_ibfk_2` FOREIGN KEY (`Admin_ID`) REFERENCES `Admin` (`Admin_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Manage`
--

LOCK TABLES `Manage` WRITE;
/*!40000 ALTER TABLE `Manage` DISABLE KEYS */;
INSERT INTO `Manage` VALUES (3,2),(3,6),(9,6);
/*!40000 ALTER TABLE `Manage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Province`
--

DROP TABLE IF EXISTS `Province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Province` (
  `Province_ID` int(2) NOT NULL,
  `Province_Name` varchar(10) NOT NULL,
  PRIMARY KEY (`Province_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Province`
--

LOCK TABLES `Province` WRITE;
/*!40000 ALTER TABLE `Province` DISABLE KEYS */;
INSERT INTO `Province` VALUES (0,'北京市'),(1,'天津市'),(2,'上海市'),(3,'重庆市'),(4,'河北省'),(5,'河南省'),(6,'云南省'),(7,'辽宁省'),(8,'黑龙江省'),(9,'湖南省'),(10,'安徽省'),(11,'山东省'),(12,'新疆维吾尔族自治区'),(13,'江苏省'),(14,'浙江省'),(15,'江西省'),(16,'湖北省'),(17,'广西壮族自治区'),(18,'甘肃省'),(19,'山西省'),(20,'内蒙古自治区'),(21,'陕西省'),(22,'吉林省'),(23,'福建省'),(24,'贵州省'),(25,'广东省'),(26,'青海省'),(27,'西藏自治区'),(28,'四川省'),(29,'宁夏回族自治区'),(30,'海南省'),(31,'台湾'),(32,'香港'),(33,'澳门');
/*!40000 ALTER TABLE `Province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservation`
--

DROP TABLE IF EXISTS `Reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reservation` (
  `User_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Reservation_Time` date DEFAULT NULL,
  `Reservation_Symptom` varchar(50) DEFAULT NULL,
  `Reservation_Payed` int(1) NOT NULL,
  `Reservation_PayTime` datetime DEFAULT NULL,
  `Reservation_PayAmount` decimal(4,2) DEFAULT NULL,
  `Operation_Time` datetime NOT NULL,
  `Duty_Time` int(2) NOT NULL,
  PRIMARY KEY (`Reservation_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Doctor_ID` (`Doctor_ID`),
  CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `User` (`User_ID`) ON UPDATE CASCADE,
  CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservation`
--

LOCK TABLES `Reservation` WRITE;
/*!40000 ALTER TABLE `Reservation` DISABLE KEYS */;
INSERT INTO `Reservation` VALUES (1,5,1,'2014-11-30','ss',1,'2014-11-30 00:49:08',12.00,'2014-11-30 00:49:13',12),(2,5,13,'2014-12-22','123',0,NULL,2.00,'2014-12-22 14:26:06',11),(2,5,14,'2014-12-22','212312',1,'2014-12-22 14:30:12',2.00,'2014-12-22 14:29:45',11),(2,5,15,'2014-12-23','123',0,NULL,2.00,'2014-12-22 14:36:46',22),(2,5,16,'2014-12-23','123',0,NULL,2.00,'2014-12-22 14:36:53',22),(2,5,17,'2014-12-24','123',1,'2014-12-22 14:41:45',2.00,'2014-12-22 14:36:53',32);
/*!40000 ALTER TABLE `Reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reset_Pwd_Security`
--

DROP TABLE IF EXISTS `Reset_Pwd_Security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reset_Pwd_Security` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `resetLink` varchar(200) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `genTime` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reset_Pwd_Security`
--

LOCK TABLES `Reset_Pwd_Security` WRITE;
/*!40000 ALTER TABLE `Reset_Pwd_Security` DISABLE KEYS */;
/*!40000 ALTER TABLE `Reset_Pwd_Security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Area_ID` int(11) NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `isChecked` int(1) NOT NULL DEFAULT '0',
  `Identity_ID` varchar(30) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `Credit_Rank` int(2) NOT NULL DEFAULT '3',
  `Appointment_Limit` int(2) NOT NULL DEFAULT '3',
  `Amount` decimal(7,2) NOT NULL DEFAULT '0.00',
  `Sex` int(1) NOT NULL,
  `Birthday` datetime NOT NULL,
  `Location` varchar(30) NOT NULL,
  `Mail` varchar(30) NOT NULL,
  `LastLogInTime` datetime DEFAULT NULL,
  `Phone` varchar(20) NOT NULL,
  `FailTime` int(1) NOT NULL,
  PRIMARY KEY (`User_ID`),
  KEY `Area_ID` (`Area_ID`),
  CONSTRAINT `User_ibfk_1` FOREIGN KEY (`Area_ID`) REFERENCES `Area` (`Area_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,1,'szmdb',0,'111','',3,3,0.00,1,'2014-11-30 00:48:18','www','aaa','2014-12-18 21:22:19','123',3),(2,1101,'耿金坤',1,'371581199409060051','20eabe5d64b0e216796e834f52d61fd0b70332fc',7,3,198.00,1,'1994-09-05 08:00:00','BUAA','steam1994@163.com','2014-12-24 00:05:21','13260129923',0);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-24  1:09:33
