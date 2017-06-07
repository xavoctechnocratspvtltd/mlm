/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100118
 Source Host           : localhost
 Source Database       : dsmarketing

 Target Server Type    : MariaDB
 Target Server Version : 100118
 File Encoding         : utf-8

 Date: 06/07/2017 17:15:38 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `mlm_closing`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_closing`;
CREATE TABLE `mlm_closing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_distributor`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_distributor`;
CREATE TABLE `mlm_distributor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `introducer_id` int(11) DEFAULT NULL,
  `left_id` int(11) DEFAULT NULL,
  `right_id` int(11) DEFAULT NULL,
  `pin_id` int(11) DEFAULT NULL,
  `path` text,
  `introducer_path` text,
  `side` varchar(2) DEFAULT NULL,
  `kit_item_id` int(11) DEFAULT NULL,
  `capping` int(11) DEFAULT NULL,
  `IFCS_Code` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `kyc_no` int(11) DEFAULT NULL,
  `kyc_id` int(11) DEFAULT NULL,
  `address_proof_id` int(11) DEFAULT NULL,
  `nominee_name` varchar(255) DEFAULT NULL,
  `relation_with_nominee` varchar(255) DEFAULT NULL,
  `nominee_email` varchar(255) DEFAULT NULL,
  `nominee_age` varchar(255) DEFAULT NULL,
  `weekly_intros_amount` int(11) DEFAULT NULL,
  `total_intros_amount` int(11) DEFAULT NULL,
  `weekly_left_sv` int(11) DEFAULT NULL,
  `weekly_right_sv` int(11) DEFAULT NULL,
  `total_left_sv` int(11) DEFAULT NULL,
  `total_right_sv` int(11) DEFAULT NULL,
  `monthly_left_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `monthly_right_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `total_pairs` int(11) DEFAULT NULL,
  `carried_amount` decimal(10,2) DEFAULT NULL,
  `greened_on` datetime DEFAULT NULL,
  `ansestors_updated` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_generation_business`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_generation_business`;
CREATE TABLE `mlm_generation_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) DEFAULT NULL,
  `introduced_id` int(11) DEFAULT NULL,
  `introduced_path` text,
  `bv_sum` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_kit`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_kit`;
CREATE TABLE `mlm_kit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `bv` int(11) DEFAULT NULL,
  `sv` int(11) DEFAULT NULL,
  `capping` int(11) DEFAULT NULL,
  `introducer_income` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `display_sequence` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `mlm_kit_item_asso`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_kit_item_asso`;
CREATE TABLE `mlm_kit_item_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mlm_kit_id` int(11) DEFAULT NULL,
  `mlm_item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
