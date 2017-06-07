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

 Date: 06/07/2017 22:13:59 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

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
  `pv` int(11) DEFAULT NULL,
  `bv` int(11) DEFAULT NULL,
  `sv` int(11) DEFAULT NULL,
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
  `day_left_sv` int(11) DEFAULT NULL,
  `day_right_sv` int(11) DEFAULT NULL,
  `day_pairs` int(11) DEFAULT NULL,
  `week_pairs` int(11) DEFAULT NULL,
  `total_left_sv` int(11) DEFAULT NULL,
  `total_right_sv` int(11) DEFAULT NULL,
  `monthly_left_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `monthly_right_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `total_pairs` int(11) DEFAULT NULL,
  `carried_amount` decimal(10,2) DEFAULT NULL,
  `greened_on` datetime DEFAULT NULL,
  `ansestors_updated` tinyint(4) DEFAULT NULL,
  `temp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_kyc`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_kyc`;
CREATE TABLE `mlm_kyc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pan_no` varchar(255) DEFAULT NULL,
  `pan_image_id` int(11) DEFAULT NULL,
  `aadhar_no` varchar(255) DEFAULT NULL,
  `aadhar_image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `mlm_payout`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_payout`;
CREATE TABLE `mlm_payout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
