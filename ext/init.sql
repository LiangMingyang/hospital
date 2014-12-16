/*
Navicat MySQL Data Transfer

Source Server         : test
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : hospital_reservation_db

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2014-12-16 21:04:02
*/
DROP DATABASE IF EXISTS Hospital_Reservation_DB;

CREATE DATABASE Hospital_Reservation_DB CHARACTER SET utf8;

USE Hospital_Reservation_DB;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Admin_Name` varchar(10) DEFAULT NULL,
  `PASSWORD` varchar(100) DEFAULT NULL,
  `Mail` varchar(30) NOT NULL,
  `FailTime` int(1) NOT NULL,
  `LastLogInTime` datetime DEFAULT NULL,
  `isSuper` int(1) DEFAULT '0',
  PRIMARY KEY (`Admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'SuperAdmin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'a@b.com', '0', '2014-12-04 23:04:26', '1');

-- ----------------------------
-- Table structure for area
-- ----------------------------
DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `Area_ID` int(11) NOT NULL,
  `Province_ID` int(2) NOT NULL,
  `Area_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Area_ID`),
  KEY `Province_ID` (`Province_ID`),
  CONSTRAINT `area_ibfk_1` FOREIGN KEY (`Province_ID`) REFERENCES `province` (`Province_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of area
-- ----------------------------
INSERT INTO `area` VALUES ('1', '0', '东城区');
INSERT INTO `area` VALUES ('2', '0', '西城区');
INSERT INTO `area` VALUES ('3', '0', '崇文区');
INSERT INTO `area` VALUES ('4', '0', '宣武区');
INSERT INTO `area` VALUES ('5', '0', '朝阳区');
INSERT INTO `area` VALUES ('6', '0', '丰台区');
INSERT INTO `area` VALUES ('7', '0', '石景山区');
INSERT INTO `area` VALUES ('8', '0', '海淀区');
INSERT INTO `area` VALUES ('9', '0', '门头沟区');
INSERT INTO `area` VALUES ('10', '0', '房山区');
INSERT INTO `area` VALUES ('11', '0', '通州区');
INSERT INTO `area` VALUES ('12', '0', '顺义区');
INSERT INTO `area` VALUES ('13', '0', '昌平区');
INSERT INTO `area` VALUES ('14', '0', '大兴区');
INSERT INTO `area` VALUES ('15', '0', '怀柔区');
INSERT INTO `area` VALUES ('16', '0', '平谷区');
INSERT INTO `area` VALUES ('17', '0', '延庆县');
INSERT INTO `area` VALUES ('18', '0', '密云县');
INSERT INTO `area` VALUES ('101', '1', '滨海新区');
INSERT INTO `area` VALUES ('102', '1', '和平区');
INSERT INTO `area` VALUES ('103', '1', '河北区');
INSERT INTO `area` VALUES ('104', '1', '河东区');
INSERT INTO `area` VALUES ('105', '1', '河西区');
INSERT INTO `area` VALUES ('106', '1', '南开区');
INSERT INTO `area` VALUES ('107', '1', '红桥区');
INSERT INTO `area` VALUES ('108', '1', '东丽区');
INSERT INTO `area` VALUES ('109', '1', '西青区');
INSERT INTO `area` VALUES ('110', '1', '津南区');
INSERT INTO `area` VALUES ('111', '1', '北辰区');
INSERT INTO `area` VALUES ('112', '1', '武清区');
INSERT INTO `area` VALUES ('113', '1', '宝坻区');
INSERT INTO `area` VALUES ('114', '1', '蓟县');
INSERT INTO `area` VALUES ('115', '1', '静海县');
INSERT INTO `area` VALUES ('116', '1', '宁河县');
INSERT INTO `area` VALUES ('201', '2', '黄浦区');
INSERT INTO `area` VALUES ('202', '2', '徐汇区');
INSERT INTO `area` VALUES ('203', '2', '长宁区');
INSERT INTO `area` VALUES ('204', '2', '静安区');
INSERT INTO `area` VALUES ('205', '2', '普陀区');
INSERT INTO `area` VALUES ('206', '2', '闸北区');
INSERT INTO `area` VALUES ('207', '2', '虹口区');
INSERT INTO `area` VALUES ('208', '2', '杨浦区');
INSERT INTO `area` VALUES ('209', '2', '闵行区');
INSERT INTO `area` VALUES ('210', '2', '宝山区');
INSERT INTO `area` VALUES ('211', '2', '嘉定区');
INSERT INTO `area` VALUES ('212', '2', '浦东新区');
INSERT INTO `area` VALUES ('213', '2', '金山区');
INSERT INTO `area` VALUES ('214', '2', '松江区');
INSERT INTO `area` VALUES ('215', '2', '青浦区');
INSERT INTO `area` VALUES ('216', '2', '奉贤区');
INSERT INTO `area` VALUES ('217', '2', '崇明县');
INSERT INTO `area` VALUES ('301', '3', '万州区');
INSERT INTO `area` VALUES ('302', '3', '黔江区');
INSERT INTO `area` VALUES ('303', '3', '涪陵区');
INSERT INTO `area` VALUES ('304', '3', '渝中区');
INSERT INTO `area` VALUES ('305', '3', '大渡口区');
INSERT INTO `area` VALUES ('306', '3', '江北区');
INSERT INTO `area` VALUES ('307', '3', '沙坪坝区');
INSERT INTO `area` VALUES ('308', '3', '九龙坡区');
INSERT INTO `area` VALUES ('309', '3', '南岸区');
INSERT INTO `area` VALUES ('310', '3', '北碚区');
INSERT INTO `area` VALUES ('311', '3', '渝北区');
INSERT INTO `area` VALUES ('312', '3', '巴南区');
INSERT INTO `area` VALUES ('313', '3', '长寿区');
INSERT INTO `area` VALUES ('314', '3', '江津区');
INSERT INTO `area` VALUES ('315', '3', '合川区');
INSERT INTO `area` VALUES ('316', '3', '永川区');
INSERT INTO `area` VALUES ('317', '3', '南川区');
INSERT INTO `area` VALUES ('318', '3', '綦江区');
INSERT INTO `area` VALUES ('319', '3', '大足区');
INSERT INTO `area` VALUES ('401', '4', '石家庄市');
INSERT INTO `area` VALUES ('402', '4', '唐山市');
INSERT INTO `area` VALUES ('403', '4', '秦皇岛市');
INSERT INTO `area` VALUES ('404', '4', '邯郸市');
INSERT INTO `area` VALUES ('405', '4', '邢台市');
INSERT INTO `area` VALUES ('406', '4', '保定市');
INSERT INTO `area` VALUES ('407', '4', '张家口市');
INSERT INTO `area` VALUES ('408', '4', '承德市');
INSERT INTO `area` VALUES ('409', '4', '沧州市');
INSERT INTO `area` VALUES ('410', '4', '廊坊市');
INSERT INTO `area` VALUES ('411', '4', '衡水市');
INSERT INTO `area` VALUES ('501', '5', '郑州市');
INSERT INTO `area` VALUES ('502', '5', '开封市');
INSERT INTO `area` VALUES ('503', '5', '洛阳市');
INSERT INTO `area` VALUES ('504', '5', '平顶山市');
INSERT INTO `area` VALUES ('505', '5', '安阳市');
INSERT INTO `area` VALUES ('506', '5', '鹤壁市');
INSERT INTO `area` VALUES ('507', '5', '新乡市');
INSERT INTO `area` VALUES ('508', '5', '焦作市');
INSERT INTO `area` VALUES ('509', '5', '濮阳市');
INSERT INTO `area` VALUES ('510', '5', '许昌市');
INSERT INTO `area` VALUES ('511', '5', '漯河市');
INSERT INTO `area` VALUES ('512', '5', '三门峡市');
INSERT INTO `area` VALUES ('513', '5', '商丘市');
INSERT INTO `area` VALUES ('514', '5', '周口市');
INSERT INTO `area` VALUES ('515', '5', '驻马店市');
INSERT INTO `area` VALUES ('516', '5', '南阳市');
INSERT INTO `area` VALUES ('517', '5', '信阳市');
INSERT INTO `area` VALUES ('518', '5', '济源市');
INSERT INTO `area` VALUES ('601', '6', '昆明市');
INSERT INTO `area` VALUES ('602', '6', '昭通市');
INSERT INTO `area` VALUES ('603', '6', '曲靖市');
INSERT INTO `area` VALUES ('604', '6', '玉溪市');
INSERT INTO `area` VALUES ('605', '6', '普洱市');
INSERT INTO `area` VALUES ('606', '6', '保山市');
INSERT INTO `area` VALUES ('607', '6', '丽江市');
INSERT INTO `area` VALUES ('608', '6', '临沧市');
INSERT INTO `area` VALUES ('609', '6', '楚雄彝族自治州');
INSERT INTO `area` VALUES ('610', '6', '红河哈尼族彝族自治州');
INSERT INTO `area` VALUES ('611', '6', '文山壮族苗族自治州');
INSERT INTO `area` VALUES ('612', '6', '西双版纳傣族自治州');
INSERT INTO `area` VALUES ('613', '6', '大理白族自治州');
INSERT INTO `area` VALUES ('614', '6', '德宏傣族景颇族自治州');
INSERT INTO `area` VALUES ('615', '6', '怒江僳僳族自治州');
INSERT INTO `area` VALUES ('616', '6', '迪庆藏族自治州');
INSERT INTO `area` VALUES ('701', '7', '沈阳市');
INSERT INTO `area` VALUES ('702', '7', '大连市');
INSERT INTO `area` VALUES ('703', '7', '鞍山市');
INSERT INTO `area` VALUES ('704', '7', '抚顺市');
INSERT INTO `area` VALUES ('705', '7', '本溪市');
INSERT INTO `area` VALUES ('706', '7', '丹东市');
INSERT INTO `area` VALUES ('707', '7', '锦州市');
INSERT INTO `area` VALUES ('708', '7', '营口市');
INSERT INTO `area` VALUES ('709', '7', '阜新市');
INSERT INTO `area` VALUES ('710', '7', '辽阳市');
INSERT INTO `area` VALUES ('711', '7', '盘锦市');
INSERT INTO `area` VALUES ('712', '7', '铁岭市');
INSERT INTO `area` VALUES ('713', '7', '朝阳市');
INSERT INTO `area` VALUES ('714', '7', '葫芦岛市');
INSERT INTO `area` VALUES ('801', '8', '哈尔滨市');
INSERT INTO `area` VALUES ('802', '8', '齐齐哈尔市');
INSERT INTO `area` VALUES ('803', '8', '牡丹江市');
INSERT INTO `area` VALUES ('804', '8', '佳木斯市');
INSERT INTO `area` VALUES ('805', '8', '大庆市');
INSERT INTO `area` VALUES ('806', '8', '伊春市');
INSERT INTO `area` VALUES ('807', '8', '鸡西市');
INSERT INTO `area` VALUES ('808', '8', '鹤岗市');
INSERT INTO `area` VALUES ('809', '8', '双鸭山市');
INSERT INTO `area` VALUES ('810', '8', '七台河市');
INSERT INTO `area` VALUES ('811', '8', '绥化市');
INSERT INTO `area` VALUES ('812', '8', '黑河市');
INSERT INTO `area` VALUES ('813', '8', '大兴安岭地区');
INSERT INTO `area` VALUES ('901', '9', '长沙市');
INSERT INTO `area` VALUES ('902', '9', '株洲市');
INSERT INTO `area` VALUES ('903', '9', '湘潭市');
INSERT INTO `area` VALUES ('904', '9', '衡阳市');
INSERT INTO `area` VALUES ('905', '9', '邵阳市');
INSERT INTO `area` VALUES ('906', '9', '岳阳市');
INSERT INTO `area` VALUES ('907', '9', '张家界市');
INSERT INTO `area` VALUES ('908', '9', '益阳市');
INSERT INTO `area` VALUES ('909', '9', '常德市');
INSERT INTO `area` VALUES ('910', '9', '娄底市');
INSERT INTO `area` VALUES ('911', '9', '郴州市');
INSERT INTO `area` VALUES ('912', '9', '永州市');
INSERT INTO `area` VALUES ('913', '9', '怀化市');
INSERT INTO `area` VALUES ('914', '9', '湘西土家族苗族自治州');
INSERT INTO `area` VALUES ('1001', '10', '合肥市');
INSERT INTO `area` VALUES ('1002', '10', '芜湖市');
INSERT INTO `area` VALUES ('1003', '10', '蚌埠市');
INSERT INTO `area` VALUES ('1004', '10', '淮南市');
INSERT INTO `area` VALUES ('1005', '10', '马鞍山市');
INSERT INTO `area` VALUES ('1006', '10', '淮北市');
INSERT INTO `area` VALUES ('1007', '10', '铜陵市');
INSERT INTO `area` VALUES ('1008', '10', '安庆市');
INSERT INTO `area` VALUES ('1009', '10', '黄山市');
INSERT INTO `area` VALUES ('1010', '10', '阜阳市');
INSERT INTO `area` VALUES ('1011', '10', '宿州市');
INSERT INTO `area` VALUES ('1012', '10', '滁州市');
INSERT INTO `area` VALUES ('1013', '10', '六安市');
INSERT INTO `area` VALUES ('1014', '10', '宣城市');
INSERT INTO `area` VALUES ('1015', '10', '池州市');
INSERT INTO `area` VALUES ('1016', '10', '亳州市');
INSERT INTO `area` VALUES ('1101', '11', '济南市');
INSERT INTO `area` VALUES ('1102', '11', '青岛市');
INSERT INTO `area` VALUES ('1103', '11', '淄博市');
INSERT INTO `area` VALUES ('1104', '11', '枣庄市');
INSERT INTO `area` VALUES ('1105', '11', '东营市');
INSERT INTO `area` VALUES ('1106', '11', '烟台市');
INSERT INTO `area` VALUES ('1107', '11', '潍坊市');
INSERT INTO `area` VALUES ('1108', '11', '济宁市');
INSERT INTO `area` VALUES ('1109', '11', '泰安市');
INSERT INTO `area` VALUES ('1110', '11', '威海市');
INSERT INTO `area` VALUES ('1111', '11', '日照市');
INSERT INTO `area` VALUES ('1112', '11', '滨州市');
INSERT INTO `area` VALUES ('1113', '11', '德州市');
INSERT INTO `area` VALUES ('1114', '11', '聊城市');
INSERT INTO `area` VALUES ('1115', '11', '临沂市');
INSERT INTO `area` VALUES ('1116', '11', '菏泽市');
INSERT INTO `area` VALUES ('1117', '11', '莱芜市');
INSERT INTO `area` VALUES ('1201', '12', '乌鲁木齐市');
INSERT INTO `area` VALUES ('1202', '12', '克拉玛依市');
INSERT INTO `area` VALUES ('1203', '12', '昌吉回族自治州');
INSERT INTO `area` VALUES ('1204', '12', '博尔塔拉蒙古自治州');
INSERT INTO `area` VALUES ('1205', '12', '伊犁哈萨克自治州');
INSERT INTO `area` VALUES ('1206', '12', '巴音郭楞蒙古自治州');
INSERT INTO `area` VALUES ('1207', '12', '克孜勒苏柯尔克孜自治州');
INSERT INTO `area` VALUES ('1208', '12', '塔城地区');
INSERT INTO `area` VALUES ('1209', '12', '阿勒泰地区');
INSERT INTO `area` VALUES ('1210', '12', '吐鲁番地区');
INSERT INTO `area` VALUES ('1211', '12', '哈密地区');
INSERT INTO `area` VALUES ('1212', '12', '阿克苏地区');
INSERT INTO `area` VALUES ('1213', '12', '喀什地区');
INSERT INTO `area` VALUES ('1214', '12', '和田地区');
INSERT INTO `area` VALUES ('1301', '13', '南京市');
INSERT INTO `area` VALUES ('1302', '13', '无锡市');
INSERT INTO `area` VALUES ('1303', '13', '徐州市');
INSERT INTO `area` VALUES ('1304', '13', '常州市');
INSERT INTO `area` VALUES ('1305', '13', '苏州市');
INSERT INTO `area` VALUES ('1306', '13', '南通市');
INSERT INTO `area` VALUES ('1307', '13', '连云港市');
INSERT INTO `area` VALUES ('1308', '13', '淮安市');
INSERT INTO `area` VALUES ('1309', '13', '盐城市');
INSERT INTO `area` VALUES ('1310', '13', '扬州市');
INSERT INTO `area` VALUES ('1311', '13', '镇江市');
INSERT INTO `area` VALUES ('1312', '13', '泰州市');
INSERT INTO `area` VALUES ('1313', '13', '宿迁市');
INSERT INTO `area` VALUES ('1401', '14', '杭州市');
INSERT INTO `area` VALUES ('1402', '14', '宁波市');
INSERT INTO `area` VALUES ('1403', '14', '温州市');
INSERT INTO `area` VALUES ('1404', '14', '绍兴市');
INSERT INTO `area` VALUES ('1405', '14', '湖州市');
INSERT INTO `area` VALUES ('1406', '14', '嘉兴市');
INSERT INTO `area` VALUES ('1407', '14', '金华市');
INSERT INTO `area` VALUES ('1408', '14', '衢州市');
INSERT INTO `area` VALUES ('1409', '14', '台州市');
INSERT INTO `area` VALUES ('1410', '14', '丽水市');
INSERT INTO `area` VALUES ('1411', '14', '舟山市');
INSERT INTO `area` VALUES ('1500', '15', '萍乡市');
INSERT INTO `area` VALUES ('1501', '15', '南昌市');
INSERT INTO `area` VALUES ('1502', '15', '赣州市');
INSERT INTO `area` VALUES ('1503', '15', '宜春市');
INSERT INTO `area` VALUES ('1504', '15', '吉安市');
INSERT INTO `area` VALUES ('1505', '15', '上饶市');
INSERT INTO `area` VALUES ('1506', '15', '抚州市');
INSERT INTO `area` VALUES ('1507', '15', '九江市');
INSERT INTO `area` VALUES ('1508', '15', '景德镇市');
INSERT INTO `area` VALUES ('1510', '15', '新余市');
INSERT INTO `area` VALUES ('1511', '15', '鹰潭市');
INSERT INTO `area` VALUES ('1601', '16', '武汉市');
INSERT INTO `area` VALUES ('1602', '16', '黄石市');
INSERT INTO `area` VALUES ('1603', '16', '十堰市');
INSERT INTO `area` VALUES ('1604', '16', '荆州市');
INSERT INTO `area` VALUES ('1605', '16', '宜昌市');
INSERT INTO `area` VALUES ('1606', '16', '襄阳市');
INSERT INTO `area` VALUES ('1607', '16', '鄂州市');
INSERT INTO `area` VALUES ('1608', '16', '荆门市');
INSERT INTO `area` VALUES ('1609', '16', '黄冈市');
INSERT INTO `area` VALUES ('1610', '16', '孝感市');
INSERT INTO `area` VALUES ('1611', '16', '咸宁市');
INSERT INTO `area` VALUES ('1612', '16', '随州市');
INSERT INTO `area` VALUES ('1613', '16', '恩施土家族苗族自治州');
INSERT INTO `area` VALUES ('1701', '17', '南宁市');
INSERT INTO `area` VALUES ('1702', '17', '柳州市');
INSERT INTO `area` VALUES ('1703', '17', '桂林市');
INSERT INTO `area` VALUES ('1704', '17', '梧州市');
INSERT INTO `area` VALUES ('1705', '17', '北海市');
INSERT INTO `area` VALUES ('1706', '17', '崇左市');
INSERT INTO `area` VALUES ('1707', '17', '来宾市');
INSERT INTO `area` VALUES ('1708', '17', '贺州市');
INSERT INTO `area` VALUES ('1709', '17', '玉林市');
INSERT INTO `area` VALUES ('1710', '17', '百色市');
INSERT INTO `area` VALUES ('1711', '17', '河池市');
INSERT INTO `area` VALUES ('1712', '17', '钦州市');
INSERT INTO `area` VALUES ('1713', '17', '防城港市');
INSERT INTO `area` VALUES ('1714', '17', '贵港市');
INSERT INTO `area` VALUES ('1801', '18', '兰州市');
INSERT INTO `area` VALUES ('1802', '18', '嘉峪关市');
INSERT INTO `area` VALUES ('1803', '18', '金昌市');
INSERT INTO `area` VALUES ('1804', '18', '白银市');
INSERT INTO `area` VALUES ('1805', '18', '天水市');
INSERT INTO `area` VALUES ('1806', '18', '酒泉市');
INSERT INTO `area` VALUES ('1807', '18', '张掖市');
INSERT INTO `area` VALUES ('1808', '18', '武威市');
INSERT INTO `area` VALUES ('1809', '18', '定西市');
INSERT INTO `area` VALUES ('1810', '18', '陇南市');
INSERT INTO `area` VALUES ('1811', '18', '平凉市');
INSERT INTO `area` VALUES ('1812', '18', '庆阳市');
INSERT INTO `area` VALUES ('1813', '18', '临夏回族自治州');
INSERT INTO `area` VALUES ('1814', '18', '甘南藏族自治州');
INSERT INTO `area` VALUES ('1901', '19', '太原市');
INSERT INTO `area` VALUES ('1902', '19', '大同市');
INSERT INTO `area` VALUES ('1903', '19', '阳泉市');
INSERT INTO `area` VALUES ('1904', '19', '长治市');
INSERT INTO `area` VALUES ('1905', '19', '晋城市');
INSERT INTO `area` VALUES ('1906', '19', '朔州市');
INSERT INTO `area` VALUES ('1907', '19', '忻州市');
INSERT INTO `area` VALUES ('1908', '19', '吕梁市');
INSERT INTO `area` VALUES ('1909', '19', '晋中市');
INSERT INTO `area` VALUES ('1910', '19', '临汾市');
INSERT INTO `area` VALUES ('1911', '19', '运城市');
INSERT INTO `area` VALUES ('2001', '20', '呼和浩特市');
INSERT INTO `area` VALUES ('2002', '20', '包头市');
INSERT INTO `area` VALUES ('2003', '20', '乌海市');
INSERT INTO `area` VALUES ('2004', '20', '赤峰市');
INSERT INTO `area` VALUES ('2005', '20', '呼伦贝尔市');
INSERT INTO `area` VALUES ('2006', '20', '通辽市');
INSERT INTO `area` VALUES ('2007', '20', '乌兰察布市');
INSERT INTO `area` VALUES ('2008', '20', '鄂尔多斯市');
INSERT INTO `area` VALUES ('2009', '20', '巴彦淖尔市');
INSERT INTO `area` VALUES ('2010', '20', '兴安盟');
INSERT INTO `area` VALUES ('2011', '20', '锡林郭勒盟');
INSERT INTO `area` VALUES ('2012', '20', '阿拉善盟');
INSERT INTO `area` VALUES ('2101', '21', '西安市');
INSERT INTO `area` VALUES ('2102', '21', '铜川市');
INSERT INTO `area` VALUES ('2103', '21', '宝鸡市');
INSERT INTO `area` VALUES ('2104', '21', '咸阳市');
INSERT INTO `area` VALUES ('2105', '21', '渭南市');
INSERT INTO `area` VALUES ('2106', '21', '汉中市');
INSERT INTO `area` VALUES ('2107', '21', '安康市');
INSERT INTO `area` VALUES ('2108', '21', '商洛市');
INSERT INTO `area` VALUES ('2109', '21', '延安市');
INSERT INTO `area` VALUES ('2110', '21', '榆林市');
INSERT INTO `area` VALUES ('2201', '22', '长春市');
INSERT INTO `area` VALUES ('2202', '22', '吉林市');
INSERT INTO `area` VALUES ('2203', '22', '四平市');
INSERT INTO `area` VALUES ('2204', '22', '辽源市');
INSERT INTO `area` VALUES ('2205', '22', '通化市');
INSERT INTO `area` VALUES ('2206', '22', '白山市');
INSERT INTO `area` VALUES ('2207', '22', '白城市');
INSERT INTO `area` VALUES ('2208', '22', '松原市');
INSERT INTO `area` VALUES ('2209', '22', '延边朝鲜族自治州');
INSERT INTO `area` VALUES ('2301', '23', '福州市');
INSERT INTO `area` VALUES ('2302', '23', '莆田市');
INSERT INTO `area` VALUES ('2303', '23', '泉州市');
INSERT INTO `area` VALUES ('2304', '23', '厦门市');
INSERT INTO `area` VALUES ('2305', '23', '漳州市');
INSERT INTO `area` VALUES ('2306', '23', '龙岩市');
INSERT INTO `area` VALUES ('2307', '23', '三明市');
INSERT INTO `area` VALUES ('2308', '23', '南平市');
INSERT INTO `area` VALUES ('2309', '23', '宁德市');
INSERT INTO `area` VALUES ('2401', '24', '贵阳市');
INSERT INTO `area` VALUES ('2402', '24', '六盘水市');
INSERT INTO `area` VALUES ('2403', '24', '遵义市');
INSERT INTO `area` VALUES ('2404', '24', '铜仁市');
INSERT INTO `area` VALUES ('2405', '24', '毕节市');
INSERT INTO `area` VALUES ('2406', '24', '安顺市');
INSERT INTO `area` VALUES ('2407', '24', '黔西南布依族苗族州');
INSERT INTO `area` VALUES ('2408', '24', '黔东南苗族侗族州');
INSERT INTO `area` VALUES ('2409', '24', '黔南布依族苗族州');
INSERT INTO `area` VALUES ('2501', '25', '广州市');
INSERT INTO `area` VALUES ('2502', '25', '深圳市');
INSERT INTO `area` VALUES ('2503', '25', '珠海市');
INSERT INTO `area` VALUES ('2504', '25', '汕头市');
INSERT INTO `area` VALUES ('2505', '25', '佛山市');
INSERT INTO `area` VALUES ('2506', '25', '韶关市');
INSERT INTO `area` VALUES ('2507', '25', '湛江市');
INSERT INTO `area` VALUES ('2508', '25', '肇庆市');
INSERT INTO `area` VALUES ('2509', '25', '江门市');
INSERT INTO `area` VALUES ('2510', '25', '茂名市');
INSERT INTO `area` VALUES ('2511', '25', '惠州市');
INSERT INTO `area` VALUES ('2512', '25', '梅州市');
INSERT INTO `area` VALUES ('2513', '25', '汕尾市');
INSERT INTO `area` VALUES ('2514', '25', '河源市');
INSERT INTO `area` VALUES ('2515', '25', '阳江市');
INSERT INTO `area` VALUES ('2516', '25', '清远市');
INSERT INTO `area` VALUES ('2517', '25', '东莞市');
INSERT INTO `area` VALUES ('2518', '25', '中山市');
INSERT INTO `area` VALUES ('2519', '25', '潮州市');
INSERT INTO `area` VALUES ('2520', '25', '揭阳市');
INSERT INTO `area` VALUES ('2521', '25', '云浮市');
INSERT INTO `area` VALUES ('2601', '26', '西宁市');
INSERT INTO `area` VALUES ('2602', '26', '海东市');
INSERT INTO `area` VALUES ('2603', '26', '海北藏族自治州');
INSERT INTO `area` VALUES ('2604', '26', '黄南藏族自治州');
INSERT INTO `area` VALUES ('2605', '26', '海南藏族自治州');
INSERT INTO `area` VALUES ('2606', '26', '果洛藏族自治州');
INSERT INTO `area` VALUES ('2607', '26', '玉树藏族自治州');
INSERT INTO `area` VALUES ('2608', '26', '海西蒙古族藏族自治州');
INSERT INTO `area` VALUES ('2701', '27', '拉萨市');
INSERT INTO `area` VALUES ('2702', '27', '日喀则市');
INSERT INTO `area` VALUES ('2703', '27', '昌都地区');
INSERT INTO `area` VALUES ('2704', '27', '山南地区');
INSERT INTO `area` VALUES ('2705', '27', '那曲地区');
INSERT INTO `area` VALUES ('2706', '27', '阿里地区');
INSERT INTO `area` VALUES ('2707', '27', '林芝地区');
INSERT INTO `area` VALUES ('2801', '28', '成都市');
INSERT INTO `area` VALUES ('2802', '28', '绵阳市');
INSERT INTO `area` VALUES ('2803', '28', '自贡市');
INSERT INTO `area` VALUES ('2804', '28', '攀枝花市');
INSERT INTO `area` VALUES ('2805', '28', '泸州市');
INSERT INTO `area` VALUES ('2806', '28', '德阳市');
INSERT INTO `area` VALUES ('2807', '28', '广元市');
INSERT INTO `area` VALUES ('2808', '28', '遂宁市');
INSERT INTO `area` VALUES ('2809', '28', '内江市');
INSERT INTO `area` VALUES ('2810', '28', '乐山市');
INSERT INTO `area` VALUES ('2811', '28', '资阳市');
INSERT INTO `area` VALUES ('2812', '28', '宜宾市');
INSERT INTO `area` VALUES ('2813', '28', '南充市');
INSERT INTO `area` VALUES ('2814', '28', '达州市');
INSERT INTO `area` VALUES ('2815', '28', '雅安市');
INSERT INTO `area` VALUES ('2816', '28', '广安市');
INSERT INTO `area` VALUES ('2817', '28', '巴中市');
INSERT INTO `area` VALUES ('2818', '28', '眉山市');
INSERT INTO `area` VALUES ('2819', '28', '阿坝藏族羌族自治州');
INSERT INTO `area` VALUES ('2820', '28', '甘孜藏族自治州');
INSERT INTO `area` VALUES ('2821', '28', '凉山彝族自治州');
INSERT INTO `area` VALUES ('2901', '29', '银川市');
INSERT INTO `area` VALUES ('2902', '29', '石嘴山市');
INSERT INTO `area` VALUES ('2903', '29', '吴忠市');
INSERT INTO `area` VALUES ('2904', '29', '固原市');
INSERT INTO `area` VALUES ('2905', '29', '中卫市');
INSERT INTO `area` VALUES ('3001', '30', '海口市');
INSERT INTO `area` VALUES ('3002', '30', '三亚市');
INSERT INTO `area` VALUES ('3003', '30', '三沙市');
INSERT INTO `area` VALUES ('3101', '31', '台北市');
INSERT INTO `area` VALUES ('3102', '31', '新北市');
INSERT INTO `area` VALUES ('3103', '31', '台中市');
INSERT INTO `area` VALUES ('3104', '31', '台南市');
INSERT INTO `area` VALUES ('3105', '31', '高雄市');
INSERT INTO `area` VALUES ('3201', '32', '中西区');
INSERT INTO `area` VALUES ('3202', '32', '东区');
INSERT INTO `area` VALUES ('3203', '32', '九龙城区');
INSERT INTO `area` VALUES ('3204', '32', '观塘区');
INSERT INTO `area` VALUES ('3205', '32', '南区');
INSERT INTO `area` VALUES ('3206', '32', '深水埗区');
INSERT INTO `area` VALUES ('3207', '32', '黄大仙区');
INSERT INTO `area` VALUES ('3208', '32', '湾仔区');
INSERT INTO `area` VALUES ('3209', '32', '油尖旺区');
INSERT INTO `area` VALUES ('3210', '32', '离岛区');
INSERT INTO `area` VALUES ('3211', '32', '葵青区');
INSERT INTO `area` VALUES ('3212', '32', '北区');
INSERT INTO `area` VALUES ('3213', '32', '西贡区');
INSERT INTO `area` VALUES ('3214', '32', '沙田区');
INSERT INTO `area` VALUES ('3215', '32', '屯门区');
INSERT INTO `area` VALUES ('3216', '32', '大埔区');
INSERT INTO `area` VALUES ('3217', '32', '荃湾区');
INSERT INTO `area` VALUES ('3218', '32', '元朗区');
INSERT INTO `area` VALUES ('3301', '33', '花地玛堂区');
INSERT INTO `area` VALUES ('3302', '33', '圣安多尼堂区');
INSERT INTO `area` VALUES ('3303', '33', '大堂区');
INSERT INTO `area` VALUES ('3304', '33', '望德堂区');
INSERT INTO `area` VALUES ('3305', '33', '风顺堂区');
INSERT INTO `area` VALUES ('3306', '33', '嘉模堂区');
INSERT INTO `area` VALUES ('3307', '33', '圣方济各堂区');

-- ----------------------------
-- Table structure for depart
-- ----------------------------
DROP TABLE IF EXISTS `depart`;
CREATE TABLE `depart` (
  `Depart_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Hospital_ID` int(11) NOT NULL,
  `Depart_Name` varchar(10) NOT NULL,
  PRIMARY KEY (`Depart_ID`),
  KEY `Hospital_ID` (`Hospital_ID`),
  CONSTRAINT `depart_ibfk_1` FOREIGN KEY (`Hospital_ID`) REFERENCES `hospital` (`Hospital_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of depart
-- ----------------------------
INSERT INTO `depart` VALUES ('1', '1', '北医三院');

-- ----------------------------
-- Table structure for doctor
-- ----------------------------
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor` (
  `Doctor_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Depart_ID` int(11) NOT NULL,
  `Doctor_Name` varchar(10) NOT NULL,
  `Doctor_Level` int(2) DEFAULT NULL,
  `Doctor_Fee` decimal(4,2) DEFAULT NULL,
  `Doctor_Limit` int(2) DEFAULT NULL,
  `Doctor_Major` varchar(30) DEFAULT NULL,
  `Doctor_Picture_url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Doctor_ID`),
  KEY `Depart_ID` (`Depart_ID`),
  CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`Depart_ID`) REFERENCES `depart` (`Depart_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doctor
-- ----------------------------
INSERT INTO `doctor` VALUES ('1', '1', 'DB', '1', '10.00', '1', 'Death', 'none');

-- ----------------------------
-- Table structure for doctor_time
-- ----------------------------
DROP TABLE IF EXISTS `doctor_time`;
CREATE TABLE `doctor_time` (
  `Doctor_ID` int(11) NOT NULL,
  `Duty_Time` int(2) NOT NULL,
  PRIMARY KEY (`Doctor_ID`,`Duty_Time`),
  CONSTRAINT `doctor_time_ibfk_1` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doctor_time
-- ----------------------------

-- ----------------------------
-- Table structure for history_reservation
-- ----------------------------
DROP TABLE IF EXISTS `history_reservation`;
CREATE TABLE `history_reservation` (
  `History_Reservation_ID` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `History_Reservation_Time` datetime NOT NULL,
  `History_Reservation_Symptom` varchar(50) DEFAULT NULL,
  `History_Reservation_Paied` int(1) NOT NULL,
  `History_Pay_Time` datetime DEFAULT NULL,
  `History_Operation_Time` datetime NOT NULL,
  PRIMARY KEY (`History_Reservation_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Doctor_ID` (`Doctor_ID`),
  CONSTRAINT `history_reservation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON UPDATE CASCADE,
  CONSTRAINT `history_reservation_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of history_reservation
-- ----------------------------

-- ----------------------------
-- Table structure for hospital
-- ----------------------------
DROP TABLE IF EXISTS `hospital`;
CREATE TABLE `hospital` (
  `Hospital_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Area_ID` int(11) NOT NULL,
  `Hospital_Level` int(2) DEFAULT NULL,
  `Hospital_Introduction` varchar(200) DEFAULT NULL,
  `Hospital_Name` varchar(30) NOT NULL,
  `Hospital_Location` varchar(20) DEFAULT NULL,
  `Reservation_Start_Time` datetime DEFAULT NULL,
  `Reservation_End_Time` datetime DEFAULT NULL,
  `Hospital_Picture_url` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Hospital_ID`),
  KEY `Area_ID` (`Area_ID`),
  CONSTRAINT `hospital_ibfk_1` FOREIGN KEY (`Area_ID`) REFERENCES `area` (`Area_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of hospital
-- ----------------------------
INSERT INTO `hospital` VALUES ('1', '1', '1', 'nothing', '北医三院', '北航周边', '2014-11-30 00:33:10', '2014-11-30 00:33:15', 'nothing');

-- ----------------------------
-- Table structure for manage
-- ----------------------------
DROP TABLE IF EXISTS `manage`;
CREATE TABLE `manage` (
  `Hospital_ID` int(11) NOT NULL,
  `Admin_ID` int(11) NOT NULL,
  PRIMARY KEY (`Hospital_ID`,`Admin_ID`),
  KEY `Admin_ID` (`Admin_ID`),
  CONSTRAINT `manage_ibfk_1` FOREIGN KEY (`Hospital_ID`) REFERENCES `hospital` (`Hospital_ID`) ON UPDATE CASCADE,
  CONSTRAINT `manage_ibfk_2` FOREIGN KEY (`Admin_ID`) REFERENCES `admin` (`Admin_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of manage
-- ----------------------------

-- ----------------------------
-- Table structure for province
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `Province_ID` int(2) NOT NULL,
  `Province_Name` varchar(10) NOT NULL,
  PRIMARY KEY (`Province_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of province
-- ----------------------------
INSERT INTO `province` VALUES ('0', '北京市');
INSERT INTO `province` VALUES ('1', '天津市');
INSERT INTO `province` VALUES ('2', '上海市');
INSERT INTO `province` VALUES ('3', '重庆市');
INSERT INTO `province` VALUES ('4', '河北省');
INSERT INTO `province` VALUES ('5', '河南省');
INSERT INTO `province` VALUES ('6', '云南省');
INSERT INTO `province` VALUES ('7', '辽宁省');
INSERT INTO `province` VALUES ('8', '黑龙江省');
INSERT INTO `province` VALUES ('9', '湖南省');
INSERT INTO `province` VALUES ('10', '安徽省');
INSERT INTO `province` VALUES ('11', '山东省');
INSERT INTO `province` VALUES ('12', '新疆维吾尔族自治区');
INSERT INTO `province` VALUES ('13', '江苏省');
INSERT INTO `province` VALUES ('14', '浙江省');
INSERT INTO `province` VALUES ('15', '江西省');
INSERT INTO `province` VALUES ('16', '湖北省');
INSERT INTO `province` VALUES ('17', '广西壮族自治区');
INSERT INTO `province` VALUES ('18', '甘肃省');
INSERT INTO `province` VALUES ('19', '山西省');
INSERT INTO `province` VALUES ('20', '内蒙古自治区');
INSERT INTO `province` VALUES ('21', '陕西省');
INSERT INTO `province` VALUES ('22', '吉林省');
INSERT INTO `province` VALUES ('23', '福建省');
INSERT INTO `province` VALUES ('24', '贵州省');
INSERT INTO `province` VALUES ('25', '广东省');
INSERT INTO `province` VALUES ('26', '青海省');
INSERT INTO `province` VALUES ('27', '西藏自治区');
INSERT INTO `province` VALUES ('28', '四川省');
INSERT INTO `province` VALUES ('29', '宁夏回族自治区');
INSERT INTO `province` VALUES ('30', '海南省');
INSERT INTO `province` VALUES ('31', '台湾');
INSERT INTO `province` VALUES ('32', '香港');
INSERT INTO `province` VALUES ('33', '澳门');

-- ----------------------------
-- Table structure for reservation
-- ----------------------------
DROP TABLE IF EXISTS `reservation`;
CREATE TABLE `reservation` (
  `User_ID` int(11) NOT NULL,
  `Doctor_ID` int(11) NOT NULL,
  `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Reservation_Time` datetime NOT NULL,
  `Reseration_Symptom` varchar(50) DEFAULT NULL,
  `Reservation_Payed` int(1) NOT NULL,
  `Reservation_PayTime` datetime DEFAULT NULL,
  `Reservation_PayAmount` decimal(4,2) DEFAULT NULL,
  `Operation_Time` datetime NOT NULL,
  PRIMARY KEY (`Reservation_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `Doctor_ID` (`Doctor_ID`),
  CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON UPDATE CASCADE,
  CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Doctor_ID`) REFERENCES `doctor` (`Doctor_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of reservation
-- ----------------------------
INSERT INTO `reservation` VALUES ('1', '1', '1', '2014-11-30 00:48:58', 'ss', '1', '2014-11-30 00:49:08', '12.00', '2014-11-30 00:49:13');

-- ----------------------------
-- Table structure for reset_pwd_security
-- ----------------------------
DROP TABLE IF EXISTS `reset_pwd_security`;
CREATE TABLE `reset_pwd_security` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `resetLink` varchar(200) NOT NULL,
  `STATUS` int(1) NOT NULL,
  `genTime` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of reset_pwd_security
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
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
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`Area_ID`) REFERENCES `area` (`Area_ID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '1', 'szmdb', '0', '111', '111', '3', '3', '0.00', '1', '2014-11-30 00:48:18', 'www', 'aaa', null, '123', '0');
