/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-25 11:29:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_shop_specs
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_specs`;
CREATE TABLE `cmf_shop_specs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规格编号',
  `name` varchar(255) DEFAULT NULL COMMENT '规格名称',
  `attr` text COMMENT '规格属性',
  `status` int(11) DEFAULT '1' COMMENT '规格状态',
  `sort` int(11) DEFAULT '1000' COMMENT '规格排序',
  `goods_id` int(11) DEFAULT NULL COMMENT '所属商品',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
