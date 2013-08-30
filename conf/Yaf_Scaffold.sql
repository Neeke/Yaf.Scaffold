/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50532
Source Host           : localhost:3306
Source Database       : Yaf_Scaffold

Target Server Type    : MYSQL
Target Server Version : 50532
File Encoding         : 65001

Date: 2013-08-25 23:40:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yaf_admin`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_admin`;
CREATE TABLE `yaf_admin` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户名',
  `user_pwd` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户密码',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注信息',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yaf_admin
-- ----------------------------
INSERT INTO `yaf_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'eeeeeeeeeeeeeee');
INSERT INTO `yaf_admin` VALUES ('3', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('6', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('7', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('8', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('9', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('10', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('11', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('12', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('13', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('14', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('15', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('16', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('17', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('18', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('19', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('20', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('21', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('22', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('23', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('24', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('25', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('26', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('27', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('28', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('29', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('30', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('31', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('32', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('33', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('34', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('35', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('36', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('37', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('38', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('39', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('40', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('41', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('42', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('43', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('44', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('45', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('46', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('47', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('48', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('49', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('50', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('51', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('52', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('53', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('54', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('55', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('56', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('57', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('58', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('59', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('60', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('61', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('62', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('63', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('64', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('65', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('66', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('67', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('68', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('69', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('70', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('71', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('72', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('73', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('74', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('75', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('76', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('77', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('78', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('79', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('80', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('81', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('82', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('83', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('84', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('85', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('86', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('87', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('88', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('89', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('90', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('91', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('92', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('93', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('94', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('95', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('96', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('97', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('98', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('99', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('100', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('101', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('102', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('103', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('104', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('105', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('106', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('107', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('108', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('109', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('110', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('111', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('112', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('113', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('114', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('115', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('116', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('117', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('118', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('119', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('120', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('121', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('122', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('123', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('124', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('125', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('126', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('127', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('128', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('129', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('130', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('131', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('132', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('133', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('134', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('135', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('136', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('137', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('138', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('139', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('140', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('141', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('142', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('143', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('144', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('145', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('146', 'test', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('147', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('148', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('149', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('150', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('151', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('152', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('153', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('154', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('155', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('156', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('157', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('158', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('159', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('160', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('161', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('162', '1', 'e10adc3949ba59abbe56e057f20f883e', null);
INSERT INTO `yaf_admin` VALUES ('163', '1', 'e10adc3949ba59abbe56e057f20f883e', null);

-- ----------------------------
-- Table structure for `yaf_scaffold_config`
-- ----------------------------
DROP TABLE IF EXISTS `yaf_scaffold_config`;
CREATE TABLE `yaf_scaffold_config` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '模块名',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
  `table_primary` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '主键名',
  `table_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '表名',
  `columns` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '字段名',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of yaf_scaffold_config
-- ----------------------------
INSERT INTO `yaf_scaffold_config` VALUES ('1', 'Admin_Scaffold', '用户模块脚手架', 'user_id', 'yaf_admin', 'user_name,remark');
