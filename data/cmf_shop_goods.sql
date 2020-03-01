/*
Navicat MySQL Data Transfer

Source Server         : MYSQL57
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : demo

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-02-25 02:48:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cmf_shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `cmf_shop_goods`;
CREATE TABLE `cmf_shop_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `thumb` text COMMENT '商品首图',
  `title` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `description` text COMMENT '商品简介',
  `content` text COMMENT '商品内容',
  `thumbs` text COMMENT '商品图组',
  `cost` double DEFAULT '0' COMMENT '商品现价',
  `cost_origin` double DEFAULT '0' COMMENT '商品原价',
  `stock` int(11) DEFAULT '0' COMMENT '商品库存',
  `status` int(11) DEFAULT '1' COMMENT '商品状态',
  `sort` int(11) DEFAULT '1000' COMMENT '商品排序',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
  `classify_id` int(11) DEFAULT '0' COMMENT '所属分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
