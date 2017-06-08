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

 Date: 06/08/2017 12:33:11 PM
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
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `transaction_detail` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_ifsc_code` varchar(255) DEFAULT NULL,
  `cheque_number` int(11) DEFAULT NULL,
  `dd_number` int(11) DEFAULT NULL,
  `cheque_date` datetime DEFAULT NULL,
  `dd_date` datetime DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  `generation_a_business` int(11) DEFAULT NULL,
  `generation_b_business` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_generation_income_slab`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_generation_income_slab`;
CREATE TABLE `mlm_generation_income_slab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_id` int(11) DEFAULT NULL,
  `generation_1` int(11) DEFAULT NULL,
  `generation_2` int(11) DEFAULT NULL,
  `generation_3` int(11) DEFAULT NULL,
  `generation_4` int(11) DEFAULT NULL,
  `generation_5` int(11) DEFAULT NULL,
  `generation_6` int(11) DEFAULT NULL,
  `generation_7` int(11) DEFAULT NULL,
  `generation_8` int(11) DEFAULT NULL,
  `generation_9` int(11) DEFAULT NULL,
  `generation_10` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `distributor_id` int(11) DEFAULT NULL,
  `closing_date` datetime DEFAULT NULL,
  `previous_carried_amount` decimal(10,2) DEFAULT NULL,
  `binary_income` decimal(10,2) DEFAULT NULL,
  `introduction_amount` decimal(10,2) DEFAULT NULL,
  `retail_profit` decimal(10,2) DEFAULT NULL,
  `repurchase_bonus` decimal(10,2) DEFAULT NULL,
  `generation_income` decimal(10,2) DEFAULT NULL,
  `loyalty_bonus` decimal(10,2) DEFAULT NULL,
  `leadership_bonus` decimal(10,2) DEFAULT NULL,
  `gross_payment` decimal(10,2) DEFAULT NULL,
  `tds` decimal(10,2) DEFAULT NULL,
  `net_payment` decimal(10,2) DEFAULT NULL,
  `carried_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_re_purchase_bonus_slab`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_re_purchase_bonus_slab`;
CREATE TABLE `mlm_re_purchase_bonus_slab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slab_percentage` int(11) DEFAULT NULL,
  `from_bv` int(11) DEFAULT NULL,
  `to_bv` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
