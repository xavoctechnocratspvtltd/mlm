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

 Date: 06/11/2017 10:51:47 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `mlm_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_attachment`;
CREATE TABLE `mlm_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) DEFAULT NULL,
  `pan_card_id` int(11) DEFAULT NULL,
  `aadhar_card_id` int(11) DEFAULT NULL,
  `cheque_deposite_receipt_image_id` int(11) DEFAULT NULL,
  `dd_deposite_receipt_image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_closing`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_closing`;
CREATE TABLE `mlm_closing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `closing_id` int(11) DEFAULT NULL,
  `on_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_distributor`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_distributor`;
CREATE TABLE `mlm_distributor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) DEFAULT NULL,
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
  `month_self_bv` int(11) DEFAULT NULL,
  `monthly_left_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `monthly_right_dp_mrp_diff` decimal(10,2) DEFAULT NULL,
  `quarter_bv_saved` int(11) DEFAULT NULL,
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
  `current_rank` varchar(20) DEFAULT NULL,
  `current_rank_id` int(11) DEFAULT NULL,
  `d_account_number` varchar(255) DEFAULT NULL,
  `d_bank_name` varchar(255) DEFAULT NULL,
  `d_bank_ifsc_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_id`),
  KEY `sponsor_id` (`sponsor_id`),
  KEY `introducer_id` (`introducer_id`),
  KEY `left_id` (`left_id`),
  KEY `right_id` (`right_id`),
  KEY `kit_item_id` (`kit_item_id`),
  KEY `greened_on` (`greened_on`),
  FULLTEXT KEY `path` (`path`),
  FULLTEXT KEY `introducer_path` (`introducer_path`)
) ENGINE=InnoDB AUTO_INCREMENT=948 DEFAULT CHARSET=utf8;

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
  `month_bv` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_id`),
  KEY `introduced_id` (`introduced_id`),
  FULLTEXT KEY `introduced_path` (`introduced_path`)
) ENGINE=InnoDB AUTO_INCREMENT=523 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`id`),
  KEY `rank_id` (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_loyalti_bonus_slab`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_loyalti_bonus_slab`;
CREATE TABLE `mlm_loyalti_bonus_slab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank_id` int(11) DEFAULT NULL,
  `distribution_percentage` decimal(10,2) DEFAULT NULL,
  `turnover_criteria` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rank_id` (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `mlm_payout`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_payout`;
CREATE TABLE `mlm_payout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `closing_id` int(11) DEFAULT NULL,
  `distributor_id` int(11) DEFAULT NULL,
  `closing_date` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `previous_carried_amount` decimal(10,2) DEFAULT NULL,
  `binary_income` decimal(10,2) DEFAULT NULL,
  `introduction_amount` decimal(10,2) DEFAULT NULL,
  `retail_profit` decimal(10,2) DEFAULT NULL,
  `rank` varchar(255) DEFAULT NULL,
  `month_self_bv` int(11) DEFAULT NULL,
  `slab_percentage` int(11) DEFAULT '0',
  `actual_generation_a_business` int(11) DEFAULT NULL,
  `actual_generation_b_business` int(11) DEFAULT NULL,
  `generation_a_business` int(11) DEFAULT NULL,
  `generation_b_business` int(11) DEFAULT NULL,
  `re_purchase_income_gross` int(11) DEFAULT NULL,
  `repurchase_bonus` decimal(10,2) DEFAULT NULL,
  `generation_income_1` decimal(10,2) DEFAULT '0.00',
  `generation_income_2` decimal(10,2) DEFAULT '0.00',
  `generation_income_3` decimal(10,2) DEFAULT '0.00',
  `generation_income_4` decimal(10,2) DEFAULT '0.00',
  `generation_income_5` decimal(10,2) DEFAULT '0.00',
  `generation_income_6` decimal(10,2) DEFAULT '0.00',
  `generation_income_7` decimal(10,2) DEFAULT '0.00',
  `generation_income` decimal(10,2) DEFAULT '0.00',
  `loyalty_bonus` decimal(10,2) DEFAULT '0.00',
  `leadership_bonus` decimal(10,2) DEFAULT '0.00',
  `gross_payment` decimal(10,2) DEFAULT NULL,
  `tds` decimal(10,2) DEFAULT NULL,
  `admin_charge` decimal(10,2) DEFAULT NULL,
  `net_payment` decimal(10,2) DEFAULT NULL,
  `carried_amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `distributor_id` (`distributor_id`),
  KEY `closing_date` (`closing_date`),
  KEY `closing_id` (`closing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
