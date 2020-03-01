/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-25 02:05:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_shop_classify
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_classify`;
CREATE TABLE `cmf_shop_classify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `status` int(11) DEFAULT '1' COMMENT '分类状态',
  `sort` int(11) DEFAULT '1000' COMMENT '分类排序',
  `classify_id` int(11) DEFAULT '0' COMMENT '所属分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
