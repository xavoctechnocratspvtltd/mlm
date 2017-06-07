/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : ds

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-06-07 17:02:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account_balance_sheet`
-- ----------------------------
DROP TABLE IF EXISTS `account_balance_sheet`;
CREATE TABLE `account_balance_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `positive_side` varchar(255) DEFAULT NULL,
  `report_name` varchar(25) DEFAULT NULL,
  `show_sub` varchar(255) DEFAULT NULL,
  `subtract_from` varchar(255) DEFAULT NULL,
  `order` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_balance_sheet
-- ----------------------------
INSERT INTO `account_balance_sheet` VALUES ('18', null, 'Share Holder Fund', 'LT', 'BalanceSheet', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('19', null, 'Share Application Money Pending Allotment', 'LT', 'BalanceSheet', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('20', null, 'Non Current Liabilities', 'LT', 'BalanceSheet', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('21', null, 'Current Liabilities', 'LT', 'BalanceSheet', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('22', null, 'Profit & Loss (Opening)', 'LT', 'BalanceSheet', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('23', null, 'Non Current Assets', 'RT', 'BalanceSheet', null, 'DR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('24', null, 'Current Assets', 'RT', 'BalanceSheet', null, 'DR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('25', null, 'Opening Stock', 'LT', 'Trading', null, 'CR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('26', null, 'Sales', 'RT', 'Trading', null, 'CR', '2', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('27', null, 'Direct Expenses', 'LT', 'Trading', null, 'CR', '3', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('28', null, 'Purchase Returns', 'RT', 'Trading', null, 'CR', '4', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('29', null, 'Purchase', 'LT', 'Trading', null, 'DR', '2', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('30', null, 'Closing Stock', 'RT', 'Trading', null, 'DR', '3', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('31', null, 'Sales Returns', 'LT', 'Trading', null, 'DR', '4', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('32', null, 'Direct Income', 'RT', 'Trading', null, 'DR', '4', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('33', null, 'Indirect Expenses', 'LT', 'Profit & Loss', null, 'DR', '1', '2017-05-22');
INSERT INTO `account_balance_sheet` VALUES ('34', null, 'Indirect Income', 'RT', 'Profit & Loss', null, 'CR', '1', '2017-05-22');

-- ----------------------------
-- Table structure for `account_group`
-- ----------------------------
DROP TABLE IF EXISTS `account_group`;
CREATE TABLE `account_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `balance_sheet_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `parent_group_id` int(11) DEFAULT NULL,
  `root_group_id` int(11) DEFAULT NULL,
  `path` text,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `balance_sheet_id` (`balance_sheet_id`) USING BTREE,
  KEY `parent_group_id` (`parent_group_id`) USING BTREE,
  KEY `root_group_id` (`root_group_id`) USING BTREE,
  FULLTEXT KEY `quick_search` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_group
-- ----------------------------
INSERT INTO `account_group` VALUES ('128', null, '18', 'Share Capital', '2017-05-22', null, '128', '.128.');
INSERT INTO `account_group` VALUES ('129', null, '18', 'Reserves & Surplus', '2017-05-22', null, '129', '.129.');
INSERT INTO `account_group` VALUES ('130', null, '18', 'Money Received Against Share Warrants', '2017-05-22', null, '130', '.130.');
INSERT INTO `account_group` VALUES ('131', null, '18', 'Capital Reserves', '2017-05-22', '129', '129', '.129.131.');
INSERT INTO `account_group` VALUES ('132', null, '18', 'Capital Redemption Reserve', '2017-05-22', '129', '129', '.129.132.');
INSERT INTO `account_group` VALUES ('133', null, '18', 'Securities Premium Reserve', '2017-05-22', '129', '129', '.129.133.');
INSERT INTO `account_group` VALUES ('134', null, '18', 'Debenture Redemption Reserve', '2017-05-22', '129', '129', '.129.134.');
INSERT INTO `account_group` VALUES ('135', null, '18', 'Revaluation Reserve', '2017-05-22', '129', '129', '.129.135.');
INSERT INTO `account_group` VALUES ('136', null, '18', 'Share Options Outstanding Account', '2017-05-22', '129', '129', '.129.136.');
INSERT INTO `account_group` VALUES ('137', null, '18', 'Other Reserves', '2017-05-22', '129', '129', '.129.137.');
INSERT INTO `account_group` VALUES ('138', null, '18', 'Surplus', '2017-05-22', '129', '129', '.129.138.');
INSERT INTO `account_group` VALUES ('139', null, '20', 'Long Term Borrowing', '2017-05-22', null, '139', '.139.');
INSERT INTO `account_group` VALUES ('140', null, '20', 'Deffered Tax Liabilities (Net)', '2017-05-22', null, '140', '.140.');
INSERT INTO `account_group` VALUES ('141', null, '20', 'Other Long Term Liabilities', '2017-05-22', null, '141', '.141.');
INSERT INTO `account_group` VALUES ('142', null, '20', 'Long Term Provisions', '2017-05-22', null, '142', '.142.');
INSERT INTO `account_group` VALUES ('143', null, '21', 'Bonds / Debenture', '2017-05-22', '139', '139', '.139.143.');
INSERT INTO `account_group` VALUES ('144', null, '20', 'Term Loans', '2017-05-22', '139', '139', '.139.144.');
INSERT INTO `account_group` VALUES ('145', null, '20', 'Deffered Payment Liabilities', '2017-05-22', '139', '139', '.139.145.');
INSERT INTO `account_group` VALUES ('146', null, '20', 'Deposits (Long Term Liabilities)', '2017-05-22', '139', '139', '.139.146.');
INSERT INTO `account_group` VALUES ('147', null, '20', 'Loans And Advances From Related Parties (Long Term)', '2017-05-22', '139', '139', '.139.147.');
INSERT INTO `account_group` VALUES ('148', null, '20', 'Other Loans And Advances (Long Term Liabilities)', '2017-05-22', '139', '139', '.139.148.');
INSERT INTO `account_group` VALUES ('149', null, '20', 'Term Loans From Bank', '2017-05-22', '144', '139', '.139.144.149.');
INSERT INTO `account_group` VALUES ('150', null, '20', 'Term Loans From Other Parties', '2017-05-22', '144', '139', '.139.144.150.');
INSERT INTO `account_group` VALUES ('151', null, '20', 'Others (Other Long Term Liabilities)', '2017-05-22', '141', '141', '.141.151.');
INSERT INTO `account_group` VALUES ('152', null, '20', 'Provision For Employee Benefits', '2017-05-22', '142', '142', '.142.152.');
INSERT INTO `account_group` VALUES ('153', null, '20', 'Others (Long Term Provisions)', '2017-05-22', '142', '142', '.142.153.');
INSERT INTO `account_group` VALUES ('154', null, '21', 'Short Term Borrowing', '2017-05-22', null, '154', '.154.');
INSERT INTO `account_group` VALUES ('155', null, '21', 'Trade Payables', '2017-05-22', null, '155', '.155.');
INSERT INTO `account_group` VALUES ('156', null, '21', 'Other Current Liabilities', '2017-05-22', null, '156', '.156.');
INSERT INTO `account_group` VALUES ('157', null, '21', 'Short Term Provisions', '2017-05-22', null, '157', '.157.');
INSERT INTO `account_group` VALUES ('158', null, '21', 'Loans Repayable On Demand', '2017-05-22', '154', '154', '.154.158.');
INSERT INTO `account_group` VALUES ('159', null, '21', 'Loans And Advances From Related Parties (Short Term)', '2017-05-22', '154', '154', '.154.159.');
INSERT INTO `account_group` VALUES ('160', null, '21', 'Deposits (Short Term Liabilities)', '2017-05-22', '154', '154', '.154.160.');
INSERT INTO `account_group` VALUES ('161', null, '21', 'Other Loans And Advances (Short Term Liabilities)', '2017-05-22', '154', '154', '.154.161.');
INSERT INTO `account_group` VALUES ('162', null, '21', 'Loans From Banks', '2017-05-22', '158', '154', '.154.158.162.');
INSERT INTO `account_group` VALUES ('163', null, '21', 'Loans From Other Parties', '2017-05-22', '158', '154', '.154.158.163.');
INSERT INTO `account_group` VALUES ('164', null, '21', 'Bank OD', '2017-05-22', '158', '154', '.154.158.164.');
INSERT INTO `account_group` VALUES ('165', null, '21', 'Current Maturities Of Long Term Debt', '2017-05-22', '156', '156', '.156.165.');
INSERT INTO `account_group` VALUES ('166', null, '21', 'Current Maturities Of Financial Lease Obligations', '2017-05-22', '156', '156', '.156.166.');
INSERT INTO `account_group` VALUES ('167', null, '21', 'Interest Accrued But Not Due On Borrowings', '2017-05-22', '156', '156', '.156.167.');
INSERT INTO `account_group` VALUES ('168', null, '21', 'Interest Accrued And Due On Borrowings', '2017-05-22', '156', '156', '.156.168.');
INSERT INTO `account_group` VALUES ('169', null, '21', 'Income Received In Advance', '2017-05-22', '156', '156', '.156.169.');
INSERT INTO `account_group` VALUES ('170', null, '21', 'Unpaid Divindends', '2017-05-22', '156', '156', '.156.170.');
INSERT INTO `account_group` VALUES ('171', null, '21', 'Interest Accrued On Not Alloted Security Money', '2017-05-22', '156', '156', '.156.171.');
INSERT INTO `account_group` VALUES ('172', null, '21', 'Interest Accrued On Unpaid Matured Deposits', '2017-05-22', '156', '156', '.156.172.');
INSERT INTO `account_group` VALUES ('173', null, '21', 'Interest Accrued On Unpaid Matured Debentures', '2017-05-22', '156', '156', '.156.173.');
INSERT INTO `account_group` VALUES ('174', null, '21', 'Other Payables', '2017-05-22', '156', '156', '.156.174.');
INSERT INTO `account_group` VALUES ('175', null, '21', 'Tax Payable', '2017-05-22', '174', '156', '.156.174.175.');
INSERT INTO `account_group` VALUES ('176', null, '21', 'Sundry Creditor', '2017-05-22', '155', '155', '.155.176.');
INSERT INTO `account_group` VALUES ('177', null, '21', 'Others (Short Term Provisions)', '2017-05-22', '157', '157', '.157.177.');
INSERT INTO `account_group` VALUES ('178', null, '23', 'Fixed Assets', '2017-05-22', null, '178', '.178.');
INSERT INTO `account_group` VALUES ('179', null, '23', 'Non Current Investments', '2017-05-22', null, '179', '.179.');
INSERT INTO `account_group` VALUES ('180', null, '23', 'Differed Tax Assets (Net)', '2017-05-22', null, '180', '.180.');
INSERT INTO `account_group` VALUES ('181', null, '23', 'Long Term Loans And Advances', '2017-05-22', null, '181', '.181.');
INSERT INTO `account_group` VALUES ('182', null, '23', 'Other Non Current Assets', '2017-05-22', null, '182', '.182.');
INSERT INTO `account_group` VALUES ('183', null, '23', 'Tangible Assets', '2017-05-22', '178', '178', '.178.183.');
INSERT INTO `account_group` VALUES ('184', null, '23', 'Intangible Assets', '2017-05-22', '178', '178', '.178.184.');
INSERT INTO `account_group` VALUES ('185', null, '23', 'Capital Work In Progress', '2017-05-22', '178', '178', '.178.185.');
INSERT INTO `account_group` VALUES ('186', null, '23', 'Land & Building', '2017-05-22', '183', '178', '.178.183.186.');
INSERT INTO `account_group` VALUES ('187', null, '23', 'Buildings', '2017-05-22', '183', '178', '.178.183.187.');
INSERT INTO `account_group` VALUES ('188', null, '23', 'Plant & Equipment', '2017-05-22', '183', '178', '.178.183.188.');
INSERT INTO `account_group` VALUES ('189', null, '23', 'Furniture & Fixtures', '2017-05-22', '183', '178', '.178.183.189.');
INSERT INTO `account_group` VALUES ('190', null, '23', 'Computers & Printers', '2017-05-22', '183', '178', '.178.183.190.');
INSERT INTO `account_group` VALUES ('191', null, '23', 'Vehicles', '2017-05-22', '183', '178', '.178.183.191.');
INSERT INTO `account_group` VALUES ('192', null, '23', 'Office Equipment', '2017-05-22', '183', '178', '.178.183.192.');
INSERT INTO `account_group` VALUES ('193', null, '23', 'Others (Tangible Assets)', '2017-05-22', '183', '178', '.178.183.193.');
INSERT INTO `account_group` VALUES ('194', null, '23', 'Land (Appreciable)', '2017-05-22', '186', '178', '.178.183.186.194.');
INSERT INTO `account_group` VALUES ('195', null, '23', 'Building (Depreciable)', '2017-05-22', '186', '178', '.178.183.186.195.');
INSERT INTO `account_group` VALUES ('196', null, '23', 'GoodWill', '2017-05-22', '184', '178', '.178.184.196.');
INSERT INTO `account_group` VALUES ('197', null, '23', 'Brand / Trademarks', '2017-05-22', '184', '178', '.178.184.197.');
INSERT INTO `account_group` VALUES ('198', null, '23', 'Computer Software', '2017-05-22', '184', '178', '.178.184.198.');
INSERT INTO `account_group` VALUES ('199', null, '23', 'Mastheads And Publisihing Titles', '2017-05-22', '184', '178', '.178.184.199.');
INSERT INTO `account_group` VALUES ('200', null, '23', 'Mining Rights', '2017-05-22', '184', '178', '.178.184.200.');
INSERT INTO `account_group` VALUES ('201', null, '23', 'Copyrights And Patents', '2017-05-22', '184', '178', '.178.184.201.');
INSERT INTO `account_group` VALUES ('202', null, '23', 'Licences And Franchise', '2017-05-22', '184', '178', '.178.184.202.');
INSERT INTO `account_group` VALUES ('203', null, '23', 'Others (Intangible Assets)', '2017-05-22', '184', '178', '.178.184.203.');
INSERT INTO `account_group` VALUES ('204', null, '23', 'Capital Advances', '2017-05-22', '181', '181', '.181.204.');
INSERT INTO `account_group` VALUES ('205', null, '23', 'Security Deposits', '2017-05-22', '181', '181', '.181.205.');
INSERT INTO `account_group` VALUES ('206', null, '23', 'Loans And Advances To Related Parties (Long Term)', '2017-05-22', '181', '181', '.181.206.');
INSERT INTO `account_group` VALUES ('207', null, '23', 'Other Loans And Advances (Assets)', '2017-05-22', '181', '181', '.181.207.');
INSERT INTO `account_group` VALUES ('208', null, '23', 'Allowance For Bad And Doubtful Advances', '2017-05-22', '181', '181', '.181.208.');
INSERT INTO `account_group` VALUES ('209', null, '23', 'Others (Other Non Current Assets)', '2017-05-22', '182', '182', '.182.209.');
INSERT INTO `account_group` VALUES ('210', null, '23', 'Long Term Trade Receivables', '2017-05-22', '182', '182', '.182.210.');
INSERT INTO `account_group` VALUES ('211', null, '23', 'Unsecured', '2017-05-22', '210', '182', '.182.210.211.');
INSERT INTO `account_group` VALUES ('212', null, '23', 'Secured', '2017-05-22', '210', '182', '.182.210.212.');
INSERT INTO `account_group` VALUES ('213', null, '23', 'Doubtful', '2017-05-22', '210', '182', '.182.210.213.');
INSERT INTO `account_group` VALUES ('214', null, '24', 'Current Investments', '2017-05-22', null, '214', '.214.');
INSERT INTO `account_group` VALUES ('215', null, '24', 'Inventories', '2017-05-22', null, '215', '.215.');
INSERT INTO `account_group` VALUES ('216', null, '24', 'Trade Receivables', '2017-05-22', null, '216', '.216.');
INSERT INTO `account_group` VALUES ('217', null, '24', 'Cash And Cash Equivalents', '2017-05-22', null, '217', '.217.');
INSERT INTO `account_group` VALUES ('218', null, '24', 'Short Term Loan And Advances', '2017-05-22', null, '218', '.218.');
INSERT INTO `account_group` VALUES ('219', null, '24', 'Other Current Assets', '2017-05-22', null, '219', '.219.');
INSERT INTO `account_group` VALUES ('220', null, '24', 'Bank Account', '2017-05-22', '217', '217', '.217.220.');
INSERT INTO `account_group` VALUES ('221', null, '24', 'Cheque, Drafts On Hand', '2017-05-22', '217', '217', '.217.221.');
INSERT INTO `account_group` VALUES ('222', null, '24', 'Cash In Hand', '2017-05-22', '217', '217', '.217.222.');
INSERT INTO `account_group` VALUES ('223', null, '24', 'Others (Cash Equivalents)', '2017-05-22', '217', '217', '.217.223.');
INSERT INTO `account_group` VALUES ('224', null, '24', 'Loans And Advances To Related Parties', '2017-05-22', '218', '218', '.218.224.');
INSERT INTO `account_group` VALUES ('225', null, '24', 'Others (Short Term Loans & Advances)', '2017-05-22', '218', '218', '.218.225.');
INSERT INTO `account_group` VALUES ('226', null, '24', 'Sundry Debtor', '2017-05-22', '216', '216', '.216.226.');
INSERT INTO `account_group` VALUES ('227', null, '24', 'Tax Receivable', '2017-05-22', '219', '219', '.219.227.');
INSERT INTO `account_group` VALUES ('228', null, '25', 'Opening Stock', '2017-05-22', null, '228', '.228.');
INSERT INTO `account_group` VALUES ('229', null, '29', 'Purchase', '2017-05-22', null, '229', '.229.');
INSERT INTO `account_group` VALUES ('230', null, '27', 'Direct Expenses', '2017-05-22', null, '230', '.230.');
INSERT INTO `account_group` VALUES ('231', null, '31', 'Sales Returns', '2017-05-22', null, '231', '.231.');
INSERT INTO `account_group` VALUES ('232', null, '26', 'Sales', '2017-05-22', null, '232', '.232.');
INSERT INTO `account_group` VALUES ('233', null, '28', 'Purchase Returns', '2017-05-22', null, '233', '.233.');
INSERT INTO `account_group` VALUES ('234', null, '30', 'Closing Stock', '2017-05-22', null, '234', '.234.');
INSERT INTO `account_group` VALUES ('235', null, '32', 'Direct Income', '2017-05-22', null, '235', '.235.');
INSERT INTO `account_group` VALUES ('236', null, '33', 'Compensation To Employee (Indirect)', '2017-05-22', null, '236', '.236.');
INSERT INTO `account_group` VALUES ('237', null, '33', 'Rebate & Discount Allowed', '2017-05-22', null, '237', '.237.');
INSERT INTO `account_group` VALUES ('238', null, '33', 'Renumeration To Directors (Indirect)', '2017-05-22', '236', '236', '.236.238.');
INSERT INTO `account_group` VALUES ('239', null, '33', 'Salary (Indirect)', '2017-05-22', '236', '236', '.236.239.');
INSERT INTO `account_group` VALUES ('240', null, '33', 'Commission Given', '2017-05-22', null, '240', '.240.');
INSERT INTO `account_group` VALUES ('241', null, '33', 'Power & Fuel', '2017-05-22', null, '241', '.241.');
INSERT INTO `account_group` VALUES ('242', null, '33', 'Interest Paid', '2017-05-22', null, '242', '.242.');
INSERT INTO `account_group` VALUES ('243', null, '33', 'Other Expenses', '2017-05-22', null, '243', '.243.');
INSERT INTO `account_group` VALUES ('244', null, '33', 'Miscellaneous Expenses', '2017-05-22', '243', '243', '.243.244.');
INSERT INTO `account_group` VALUES ('245', null, '33', 'Shipping Expenses', '2017-05-22', '243', '243', '.243.245.');
INSERT INTO `account_group` VALUES ('246', null, '33', 'Exchange Expenses', '2017-05-22', '243', '243', '.243.246.');
INSERT INTO `account_group` VALUES ('247', null, '33', 'Bank Charges Expenses', '2017-05-22', '243', '243', '.243.247.');
INSERT INTO `account_group` VALUES ('248', null, '34', 'Rebate & Discount Received', '2017-05-22', null, '248', '.248.');
INSERT INTO `account_group` VALUES ('249', null, '34', 'Interest Received', '2017-05-22', null, '249', '.249.');
INSERT INTO `account_group` VALUES ('250', null, '34', 'Commission Received', '2017-05-22', null, '250', '.250.');
INSERT INTO `account_group` VALUES ('251', null, '34', 'Other Income', '2017-05-22', null, '251', '.251.');
INSERT INTO `account_group` VALUES ('252', null, '34', 'Round Income', '2017-05-22', '251', '251', '.251.252.');
INSERT INTO `account_group` VALUES ('253', null, '34', 'Exchange Income', '2017-05-22', '251', '251', '.251.253.');
INSERT INTO `account_group` VALUES ('254', null, '22', 'Profit & Loss (Opening)', '2017-05-22', null, '254', '.254.');
INSERT INTO `account_group` VALUES ('255', null, '33', 'Reimbursement To Employees', '2017-05-22', '236', '236', '.236.255.');
INSERT INTO `account_group` VALUES ('256', null, '34', 'Dedcution From Employees', '2017-05-22', '251', '251', '.251.256.');

-- ----------------------------
-- Table structure for `account_report_layout`
-- ----------------------------
DROP TABLE IF EXISTS `account_report_layout`;
CREATE TABLE `account_report_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `layout` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of account_report_layout
-- ----------------------------

-- ----------------------------
-- Table structure for `account_transaction`
-- ----------------------------
DROP TABLE IF EXISTS `account_transaction`;
CREATE TABLE `account_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `transaction_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `Narration` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` decimal(8,6) DEFAULT NULL,
  `related_id` bigint(20) DEFAULT NULL,
  `related_type` varchar(255) DEFAULT NULL,
  `round_amount` decimal(8,2) DEFAULT NULL,
  `related_transaction_id` int(11) DEFAULT NULL,
  `transaction_template_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `transaction_type_id` (`transaction_type_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_transaction
-- ----------------------------

-- ----------------------------
-- Table structure for `account_transaction_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `account_transaction_attachment`;
CREATE TABLE `account_transaction_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_transaction_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account_transaction_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `account_transaction_row`
-- ----------------------------
DROP TABLE IF EXISTS `account_transaction_row`;
CREATE TABLE `account_transaction_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `ledger_id` int(11) DEFAULT NULL,
  `_amountDr` double DEFAULT NULL,
  `_amountCr` double DEFAULT NULL,
  `side` varchar(255) DEFAULT NULL,
  `accounts_in_side` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `remark` text,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `transaction_id` (`transaction_id`) USING BTREE,
  KEY `ledger_id` (`ledger_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_transaction_row
-- ----------------------------

-- ----------------------------
-- Table structure for `account_transaction_types`
-- ----------------------------
DROP TABLE IF EXISTS `account_transaction_types`;
CREATE TABLE `account_transaction_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `FromAC` varchar(255) DEFAULT NULL,
  `ToAC` varchar(255) DEFAULT NULL,
  `Default_Narration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of account_transaction_types
-- ----------------------------

-- ----------------------------
-- Table structure for `acl`
-- ----------------------------
DROP TABLE IF EXISTS `acl`;
CREATE TABLE `acl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `action_allowed` text,
  `allow_add` tinyint(4) DEFAULT NULL,
  `namespace` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `post_id` (`post_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1090 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of acl
-- ----------------------------
INSERT INTO `acl` VALUES ('1086', null, '5585', 'Webpage', '[]', '1', 'xepan\\cms');
INSERT INTO `acl` VALUES ('1087', null, '5585', 'CarouselCategory', '[]', '1', 'xepan\\cms');
INSERT INTO `acl` VALUES ('1088', null, '5585', 'CarouselImage', '[]', '1', 'xepan\\cms');
INSERT INTO `acl` VALUES ('1089', null, '5585', 'ispmanager_distributor', '[]', '1', 'xavoc\\mlm');

-- ----------------------------
-- Table structure for `activity`
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `related_contact_id` int(11) DEFAULT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `details` text,
  `created_at` datetime DEFAULT NULL,
  `notify_to` varchar(255) DEFAULT NULL,
  `notification` varchar(255) DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `score` decimal(14,6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `related_contact_id` (`related_contact_id`) USING BTREE,
  KEY `related_document_id` (`related_document_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity
-- ----------------------------

-- ----------------------------
-- Table structure for `affiliate`
-- ----------------------------
DROP TABLE IF EXISTS `affiliate`;
CREATE TABLE `affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `narration` text,
  `contact_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of affiliate
-- ----------------------------

-- ----------------------------
-- Table structure for `application`
-- ----------------------------
DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `namespace` varchar(255) DEFAULT '',
  `user_installable` tinyint(4) DEFAULT '1',
  `default_currency_price` double(8,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of application
-- ----------------------------
INSERT INTO `application` VALUES ('12', 'communication', 'xepan\\communication', '1', null);
INSERT INTO `application` VALUES ('13', 'hr', 'xepan\\hr', '1', null);
INSERT INTO `application` VALUES ('14', 'projects', 'xepan\\projects', '1', null);
INSERT INTO `application` VALUES ('15', 'marketing', 'xepan\\marketing', '1', null);
INSERT INTO `application` VALUES ('16', 'accounts', 'xepan\\accounts', '1', null);
INSERT INTO `application` VALUES ('17', 'commerce', 'xepan\\commerce', '1', null);
INSERT INTO `application` VALUES ('18', 'production', 'xepan\\production', '1', null);
INSERT INTO `application` VALUES ('19', 'crm', 'xepan\\crm', '1', null);
INSERT INTO `application` VALUES ('20', 'cms', 'xepan\\cms', '1', null);
INSERT INTO `application` VALUES ('21', 'blog', 'xepan\\blog', '1', null);
INSERT INTO `application` VALUES ('22', 'epanservices', 'xepan\\epanservices', '1', null);
INSERT INTO `application` VALUES ('23', 'mlm', 'xavoc\\mlm', '1', null);

-- ----------------------------
-- Table structure for `attachment`
-- ----------------------------
DROP TABLE IF EXISTS `attachment`;
CREATE TABLE `attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `file_id` (`file_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_comment`
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` text NOT NULL,
  `type` text NOT NULL,
  `blog_post_id` int(11) NOT NULL,
  `comment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_post`
-- ----------------------------
DROP TABLE IF EXISTS `blog_post`;
CREATE TABLE `blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `tag` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` text NOT NULL,
  `type` text NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `anonymous_comment_config` varchar(255) DEFAULT NULL,
  `registered_comment_config` varchar(255) DEFAULT NULL,
  `show_comments` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search_string` (`title`,`description`,`tag`,`meta_title`,`meta_description`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_post
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_post_category`
-- ----------------------------
DROP TABLE IF EXISTS `blog_post_category`;
CREATE TABLE `blog_post_category` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_post_category
-- ----------------------------

-- ----------------------------
-- Table structure for `blog_post_category_association`
-- ----------------------------
DROP TABLE IF EXISTS `blog_post_category_association`;
CREATE TABLE `blog_post_category_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) NOT NULL,
  `blog_post_category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of blog_post_category_association
-- ----------------------------

-- ----------------------------
-- Table structure for `campaign`
-- ----------------------------
DROP TABLE IF EXISTS `campaign`;
CREATE TABLE `campaign` (
  `document_id` int(11) NOT NULL,
  `schedule` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `starting_date` datetime NOT NULL,
  `ending_date` datetime NOT NULL,
  `campaign_type` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `document_id` (`document_id`),
  FULLTEXT KEY `search_string` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of campaign
-- ----------------------------

-- ----------------------------
-- Table structure for `campaign_category_association`
-- ----------------------------
DROP TABLE IF EXISTS `campaign_category_association`;
CREATE TABLE `campaign_category_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marketing_category_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marketing_category_id` (`marketing_category_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `ceated_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of campaign_category_association
-- ----------------------------

-- ----------------------------
-- Table structure for `campaign_category_association_1`
-- ----------------------------
DROP TABLE IF EXISTS `campaign_category_association_1`;
CREATE TABLE `campaign_category_association_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marketing_category_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marketing_category_id` (`marketing_category_id`) USING BTREE,
  KEY `campaign_id` (`campaign_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of campaign_category_association_1
-- ----------------------------

-- ----------------------------
-- Table structure for `campaign_socialuser_association`
-- ----------------------------
DROP TABLE IF EXISTS `campaign_socialuser_association`;
CREATE TABLE `campaign_socialuser_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socialuser_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `social_user_id` (`socialuser_id`) USING BTREE,
  KEY `campaign_id` (`campaign_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of campaign_socialuser_association
-- ----------------------------

-- ----------------------------
-- Table structure for `carouselcategory`
-- ----------------------------
DROP TABLE IF EXISTS `carouselcategory`;
CREATE TABLE `carouselcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of carouselcategory
-- ----------------------------
INSERT INTO `carouselcategory` VALUES ('1', '142438', 'Active', '2017-05-22 11:38:48', 'CarouselCategory', 'MLM Slider');

-- ----------------------------
-- Table structure for `carouselimage`
-- ----------------------------
DROP TABLE IF EXISTS `carouselimage`;
CREATE TABLE `carouselimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carousel_category_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text_to_display` text,
  `alt_text` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of carouselimage
-- ----------------------------
INSERT INTO `carouselimage` VALUES ('1', '1', '142438', '5200', '', '', '', '0', '', '2017-05-22 11:41:03', 'Visible', 'CarouselImage');
INSERT INTO `carouselimage` VALUES ('2', '1', '142438', '5201', '', '', '', '0', '', '2017-05-22 11:41:21', 'Visible', 'CarouselImage');
INSERT INTO `carouselimage` VALUES ('3', '1', '142438', '5202', '', '', '', '0', '', '2017-05-22 11:41:29', 'Visible', 'CarouselImage');
INSERT INTO `carouselimage` VALUES ('4', '1', '142438', '5203', '', '', '', '0', '', '2017-05-22 11:41:38', 'Visible', 'CarouselImage');

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_sequence` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  `custom_link` varchar(255) DEFAULT NULL,
  `cat_image_id` int(11) DEFAULT NULL,
  `is_website_display` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`),
  KEY `parent_category_id` (`parent_category_id`),
  KEY `cat_image_id` (`cat_image_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------

-- ----------------------------
-- Table structure for `category_item_association`
-- ----------------------------
DROP TABLE IF EXISTS `category_item_association`;
CREATE TABLE `category_item_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_document_id` (`item_id`,`category_id`),
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category_item_association
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_editors`
-- ----------------------------
DROP TABLE IF EXISTS `cms_editors`;
CREATE TABLE `cms_editors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `can_edit_template` tinyint(4) DEFAULT NULL,
  `can_edit_page_content` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_editors
-- ----------------------------
INSERT INTO `cms_editors` VALUES ('7', '68', '1', '1');

-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `communication_id` (`communication_id`) USING BTREE,
  KEY `ticket_id` (`ticket_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for `communication`
-- ----------------------------
DROP TABLE IF EXISTS `communication`;
CREATE TABLE `communication` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mailbox` varchar(45) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `from_raw` text,
  `to_raw` text,
  `cc_raw` text,
  `bcc_raw` text,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `communication_type` varchar(45) DEFAULT NULL,
  `flags` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `sub_type` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `reply_to` varchar(255) DEFAULT NULL,
  `detailed` tinyint(4) DEFAULT NULL,
  `is_starred` tinyint(4) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `sent_on` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `extra_info` text,
  `type` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `communication_channel_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `emailsetting_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `to_id_2` (`to_id`,`related_id`,`related_document_id`),
  KEY `related_document_id` (`related_document_id`) USING BTREE,
  KEY `related_id` (`related_id`) USING BTREE,
  KEY `to_id` (`to_id`) USING BTREE,
  KEY `from_id` (`from_id`) USING BTREE,
  KEY `created_at` (`created_at`),
  KEY `communication_type` (`communication_type`),
  KEY `emailsetting_id` (`emailsetting_id`),
  FULLTEXT KEY `search_string` (`title`,`description`,`communication_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of communication
-- ----------------------------

-- ----------------------------
-- Table structure for `communication_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `communication_attachment`;
CREATE TABLE `communication_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `communication_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `communication_id` (`communication_id`) USING BTREE,
  KEY `file_id` (`file_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of communication_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `communication_read_emails`
-- ----------------------------
DROP TABLE IF EXISTS `communication_read_emails`;
CREATE TABLE `communication_read_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `communication_id` int(11) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `communicaiton_id` (`communication_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of communication_read_emails
-- ----------------------------

-- ----------------------------
-- Table structure for `communication_sms_setting`
-- ----------------------------
DROP TABLE IF EXISTS `communication_sms_setting`;
CREATE TABLE `communication_sms_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gateway_url` varchar(255) DEFAULT NULL,
  `sms_username` varchar(255) DEFAULT NULL,
  `sms_password` varchar(255) DEFAULT NULL,
  `sms_user_name_qs_param` varchar(255) DEFAULT NULL,
  `sms_password_qs_param` varchar(255) DEFAULT NULL,
  `sms_number_qs_param` varchar(255) DEFAULT NULL,
  `sm_message_qs_param` varchar(255) DEFAULT NULL,
  `sms_prefix` varchar(255) DEFAULT NULL,
  `sms_postfix` varchar(255) DEFAULT NULL,
  `created_by_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of communication_sms_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_to_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `image_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  `search_string` text,
  `source` varchar(255) DEFAULT NULL,
  `remark` text,
  `freelancer_type` varchar(255) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `related_with` varchar(255) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `image_id` (`image_id`) USING BTREE,
  KEY `type` (`type`),
  FULLTEXT KEY `search_string` (`search_string`),
  CONSTRAINT `fk_epan_id` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142446 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES ('142438', null, null, 'Super', 'User', 'Employee', 'wwwEMP142438', 'Active', null, null, null, null, null, null, null, null, null, '68', '2017-05-22 13:20:28', '2017-05-22 13:20:28', '0', '   0  2017-05-22      Super User', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142439', null, null, 'Company', '', 'Customer', 'dsCUS142439', 'Active', null, null, null, null, null, null, null, null, null, '69', '2017-06-06 12:54:57', '2017-06-06 12:54:57', '0', '  Company                  Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142440', null, null, 'Company', '', 'Customer', 'dsCUS142440', 'Active', null, null, null, null, null, null, null, null, null, '69', '2017-06-07 04:14:39', '2017-06-07 04:18:40', '0', '  Company                  Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142441', null, null, 'Rakesh', 'Sinha', 'Customer', 'dsCUS142441', 'Active', null, null, null, null, null, null, null, null, null, null, '2017-06-07 04:18:01', '2017-06-07 04:19:23', '0', '  Rakesh Sinha                 Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142442', null, null, 'Vijay', 'Mali', 'Customer', 'dsCUS142442', 'Active', null, null, null, null, null, null, null, null, null, null, '2017-06-07 04:18:40', '2017-06-07 04:20:23', '0', '  Vijay Mali                 Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142443', null, null, 'Rakesh 1', 'Sinha', 'Customer', 'dsCUS142443', 'Active', null, null, null, null, null, null, null, null, null, null, '2017-06-07 04:19:23', '2017-06-07 04:19:23', '0', '  Rakesh 1 Sinha                 Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142444', null, null, 'V1', 'Mali', 'Customer', 'dsCUS142444', 'Active', null, null, null, null, null, null, null, null, null, null, '2017-06-07 04:19:51', '2017-06-07 04:19:51', '0', '  V1 Mali                 Customer', null, null, 'Not Applicable', '0', null, null);
INSERT INTO `contact` VALUES ('142445', null, null, 'Vijay1', 'Mali', 'Customer', 'dsCUS142445', 'Active', null, null, null, null, null, null, null, null, null, null, '2017-06-07 04:20:23', '2017-06-07 04:20:23', '0', '  Vijay1 Mali                 Customer', null, null, 'Not Applicable', '0', null, null);

-- ----------------------------
-- Table structure for `contact_info`
-- ----------------------------
DROP TABLE IF EXISTS `contact_info`;
CREATE TABLE `contact_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `head` varchar(45) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_valid` tinyint(4) DEFAULT '1',
  `type` varchar(45) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `type` (`type`),
  KEY `value` (`value`),
  KEY `head` (`head`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contact_info
-- ----------------------------

-- ----------------------------
-- Table structure for `content`
-- ----------------------------
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_255` text NOT NULL,
  `title` text NOT NULL,
  `document_id` int(11) NOT NULL,
  `marketing_category_id` int(11) NOT NULL,
  `is_template` tinyint(1) NOT NULL,
  `message_3000` text NOT NULL,
  `message_blog` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `message_160` text NOT NULL,
  `content_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `marketing_category_id` (`marketing_category_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=453 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of content
-- ----------------------------
INSERT INTO `content` VALUES ('452', 'No Content', 'Empty', '5597', '5596', '1', '', 'No Content', 'xavoc.com', '', null);

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `iso_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'Afghanistan', 'Country', 'AF', 'InActive', null);
INSERT INTO `country` VALUES ('2', 'Albania', 'Country', 'AL', 'InActive', null);
INSERT INTO `country` VALUES ('3', 'Algeria', 'Country', 'DZ', 'InActive', null);
INSERT INTO `country` VALUES ('4', 'American Samoa', 'Country', 'AS', 'InActive', null);
INSERT INTO `country` VALUES ('5', 'Andorra', 'Country', 'AD', 'InActive', null);
INSERT INTO `country` VALUES ('6', 'Angola', 'Country', 'AO', 'InActive', null);
INSERT INTO `country` VALUES ('7', 'Anguilla', 'Country', 'AI', 'InActive', null);
INSERT INTO `country` VALUES ('8', 'Antarctica', 'Country', 'AQ', 'InActive', null);
INSERT INTO `country` VALUES ('9', 'Antigua and Barbuda', 'Country', 'AG', 'InActive', null);
INSERT INTO `country` VALUES ('10', 'Argentina', 'Country', 'AR', 'InActive', null);
INSERT INTO `country` VALUES ('11', 'Armenia', 'Country', 'AM', 'InActive', null);
INSERT INTO `country` VALUES ('12', 'Aruba', 'Country', 'AW', 'InActive', null);
INSERT INTO `country` VALUES ('13', 'Australia', 'Country', 'AU', 'InActive', null);
INSERT INTO `country` VALUES ('14', 'Austria', 'Country', 'AT', 'InActive', null);
INSERT INTO `country` VALUES ('15', 'Azerbaijan', 'Country', 'AZ', 'InActive', null);
INSERT INTO `country` VALUES ('16', 'Bahrain', 'Country', 'BH', 'InActive', null);
INSERT INTO `country` VALUES ('17', 'Bangladesh', 'Country', 'BD', 'InActive', null);
INSERT INTO `country` VALUES ('18', 'Barbados', 'Country', 'BB', 'InActive', null);
INSERT INTO `country` VALUES ('19', 'Belarus', 'Country', 'BY', 'InActive', null);
INSERT INTO `country` VALUES ('20', 'Belgium', 'Country', 'BE', 'InActive', null);
INSERT INTO `country` VALUES ('21', 'Belize', 'Country', 'BZ', 'InActive', null);
INSERT INTO `country` VALUES ('22', 'Benin', 'Country', 'BJ', 'InActive', null);
INSERT INTO `country` VALUES ('23', 'Bermuda', 'Country', 'BM', 'InActive', null);
INSERT INTO `country` VALUES ('24', 'Bhutan', 'Country', 'BT', 'InActive', null);
INSERT INTO `country` VALUES ('25', 'Bolivia', 'Country', 'BO', 'InActive', null);
INSERT INTO `country` VALUES ('26', 'Bosnia and Herzegovina', 'Country', 'BA', 'InActive', null);
INSERT INTO `country` VALUES ('27', 'Botswana', 'Country', 'BW', 'InActive', null);
INSERT INTO `country` VALUES ('28', 'Bouvet Island', 'Country', 'BV', 'InActive', null);
INSERT INTO `country` VALUES ('29', 'Brazil', 'Country', 'BR', 'InActive', null);
INSERT INTO `country` VALUES ('30', 'British Indian Ocean Territory', 'Country', 'IO', 'InActive', null);
INSERT INTO `country` VALUES ('31', 'Virgin Islands, British', 'Country', 'VG', 'InActive', null);
INSERT INTO `country` VALUES ('32', 'Brunei Darussalam', 'Country', 'BN', 'InActive', null);
INSERT INTO `country` VALUES ('33', 'Bulgaria', 'Country', 'BG', 'InActive', null);
INSERT INTO `country` VALUES ('34', 'Burkina Faso', 'Country', 'BF', 'InActive', null);
INSERT INTO `country` VALUES ('35', 'Myanmar', 'Country', 'MM', 'InActive', null);
INSERT INTO `country` VALUES ('36', 'Burundi', 'Country', 'BI', 'InActive', null);
INSERT INTO `country` VALUES ('37', 'Cambodia', 'Country', 'KH', 'InActive', null);
INSERT INTO `country` VALUES ('38', 'Cameroon', 'Country', 'CM', 'InActive', null);
INSERT INTO `country` VALUES ('39', 'Canada', 'Country', 'CA', 'InActive', null);
INSERT INTO `country` VALUES ('40', 'Cape Verde', 'Country', 'CV', 'InActive', null);
INSERT INTO `country` VALUES ('41', 'Cayman Islands', 'Country', 'KY', 'InActive', null);
INSERT INTO `country` VALUES ('42', 'Central African Republic', 'Country', 'CF', 'InActive', null);
INSERT INTO `country` VALUES ('43', 'Chad', 'Country', 'TD', 'InActive', null);
INSERT INTO `country` VALUES ('44', 'Chile', 'Country', 'CL', 'InActive', null);
INSERT INTO `country` VALUES ('45', 'China', 'Country', 'CN', 'InActive', null);
INSERT INTO `country` VALUES ('46', 'Christmas Island', 'Country', 'CX', 'InActive', null);
INSERT INTO `country` VALUES ('47', 'Cocos (Keeling) Islands', 'Country', 'CC', 'InActive', null);
INSERT INTO `country` VALUES ('48', 'Colombia', 'Country', 'CO', 'InActive', null);
INSERT INTO `country` VALUES ('49', 'Comoros', 'Country', 'KM', 'InActive', null);
INSERT INTO `country` VALUES ('50', 'Congo, The Democratic Republic of the', 'Country', 'CD', 'InActive', null);
INSERT INTO `country` VALUES ('51', 'Congo', 'Country', 'CG', 'InActive', null);
INSERT INTO `country` VALUES ('52', 'Cook Islands', 'Country', 'CK', 'InActive', null);
INSERT INTO `country` VALUES ('53', 'Costa Rica', 'Country', 'CR', 'InActive', null);
INSERT INTO `country` VALUES ('54', 'Côte d\'Ivoire', 'Country', 'CI', 'InActive', null);
INSERT INTO `country` VALUES ('55', 'Croatia', 'Country', 'HR', 'InActive', null);
INSERT INTO `country` VALUES ('56', 'Cuba', 'Country', 'CU', 'InActive', null);
INSERT INTO `country` VALUES ('57', 'Cyprus', 'Country', 'CY', 'InActive', null);
INSERT INTO `country` VALUES ('58', 'Czech Republic', 'Country', 'CZ', 'InActive', null);
INSERT INTO `country` VALUES ('59', 'Denmark', 'Country', 'DK', 'InActive', null);
INSERT INTO `country` VALUES ('60', 'Djibouti', 'Country', 'DJ', 'InActive', null);
INSERT INTO `country` VALUES ('61', 'Dominica', 'Country', 'DM', 'InActive', null);
INSERT INTO `country` VALUES ('62', 'Dominican Republic', 'Country', 'DO', 'InActive', null);
INSERT INTO `country` VALUES ('63', 'Timor-Leste', 'Country', 'TL', 'InActive', null);
INSERT INTO `country` VALUES ('64', 'Ecuador', 'Country', 'EC', 'InActive', null);
INSERT INTO `country` VALUES ('65', 'Egypt', 'Country', 'EG', 'InActive', null);
INSERT INTO `country` VALUES ('66', 'El Salvador', 'Country', 'SV', 'InActive', null);
INSERT INTO `country` VALUES ('67', 'Equatorial Guinea', 'Country', 'GQ', 'InActive', null);
INSERT INTO `country` VALUES ('68', 'Eritrea', 'Country', 'ER', 'InActive', null);
INSERT INTO `country` VALUES ('69', 'Estonia', 'Country', 'EE', 'InActive', null);
INSERT INTO `country` VALUES ('70', 'Ethiopia', 'Country', 'ET', 'InActive', null);
INSERT INTO `country` VALUES ('71', 'Falkland Islands (Malvinas)', 'Country', 'FK', 'InActive', null);
INSERT INTO `country` VALUES ('72', 'Faroe Islands', 'Country', 'FO', 'InActive', null);
INSERT INTO `country` VALUES ('73', 'Fiji', 'Country', 'FJ', 'InActive', null);
INSERT INTO `country` VALUES ('74', 'Finland', 'Country', 'FI', 'InActive', null);
INSERT INTO `country` VALUES ('75', 'France', 'Country', 'FR', 'InActive', null);
INSERT INTO `country` VALUES ('76', 'French Guiana', 'Country', 'GF', 'InActive', null);
INSERT INTO `country` VALUES ('77', 'French Polynesia', 'Country', 'PF', 'InActive', null);
INSERT INTO `country` VALUES ('78', 'French Southern Territories', 'Country', 'TF', 'InActive', null);
INSERT INTO `country` VALUES ('79', 'Gabon', 'Country', 'GA', 'InActive', null);
INSERT INTO `country` VALUES ('80', 'Georgia', 'Country', 'GE', 'InActive', null);
INSERT INTO `country` VALUES ('81', 'Germany', 'Country', 'DE', 'InActive', null);
INSERT INTO `country` VALUES ('82', 'Ghana', 'Country', 'GH', 'InActive', null);
INSERT INTO `country` VALUES ('83', 'Gibraltar', 'Country', 'GI', 'InActive', null);
INSERT INTO `country` VALUES ('84', 'Greece', 'Country', 'GR', 'InActive', null);
INSERT INTO `country` VALUES ('85', 'Greenland', 'Country', 'GL', 'InActive', null);
INSERT INTO `country` VALUES ('86', 'Grenada', 'Country', 'GD', 'InActive', null);
INSERT INTO `country` VALUES ('87', 'Guadeloupe', 'Country', 'GP', 'InActive', null);
INSERT INTO `country` VALUES ('88', 'Guam', 'Country', 'GU', 'InActive', null);
INSERT INTO `country` VALUES ('89', 'Guatemala', 'Country', 'GT', 'InActive', null);
INSERT INTO `country` VALUES ('90', 'Guinea', 'Country', 'GN', 'InActive', null);
INSERT INTO `country` VALUES ('91', 'Guinea-Bissau', 'Country', 'GW', 'InActive', null);
INSERT INTO `country` VALUES ('92', 'Guyana', 'Country', 'GY', 'InActive', null);
INSERT INTO `country` VALUES ('93', 'Haiti', 'Country', 'HT', 'InActive', null);
INSERT INTO `country` VALUES ('94', 'Heard Island and McDonald Islands', 'Country', 'HM', 'InActive', null);
INSERT INTO `country` VALUES ('95', 'Holy See (Vatican City State)', 'Country', 'VA', 'InActive', null);
INSERT INTO `country` VALUES ('96', 'Honduras', 'Country', 'HN', 'InActive', null);
INSERT INTO `country` VALUES ('97', 'Hong Kong', 'Country', 'HK', 'InActive', null);
INSERT INTO `country` VALUES ('98', 'Hungary', 'Country', 'HU', 'InActive', null);
INSERT INTO `country` VALUES ('99', 'Iceland', 'Country', 'IS', 'InActive', null);
INSERT INTO `country` VALUES ('100', 'India', 'Country', 'IN', 'Active', null);
INSERT INTO `country` VALUES ('101', 'Indonesia', 'Country', 'ID', 'InActive', null);
INSERT INTO `country` VALUES ('102', 'Iran, Islamic Republic of', 'Country', 'IR', 'InActive', null);
INSERT INTO `country` VALUES ('103', 'Iraq', 'Country', 'IQ', 'InActive', null);
INSERT INTO `country` VALUES ('104', 'Ireland', 'Country', 'IE', 'InActive', null);
INSERT INTO `country` VALUES ('105', 'Israel', 'Country', 'IL', 'InActive', null);
INSERT INTO `country` VALUES ('106', 'Italy', 'Country', 'IT', 'InActive', null);
INSERT INTO `country` VALUES ('107', 'Jamaica', 'Country', 'JM', 'InActive', null);
INSERT INTO `country` VALUES ('108', 'Japan', 'Country', 'JP', 'InActive', null);
INSERT INTO `country` VALUES ('109', 'Jordan', 'Country', 'JO', 'InActive', null);
INSERT INTO `country` VALUES ('110', 'Kazakhstan', 'Country', 'KZ', 'InActive', null);
INSERT INTO `country` VALUES ('111', 'Kenya', 'Country', 'KE', 'InActive', null);
INSERT INTO `country` VALUES ('112', 'Kiribati', 'Country', 'KI', 'InActive', null);
INSERT INTO `country` VALUES ('113', 'Korea, Democratic People\'s Republic of', 'Country', 'KP', 'InActive', null);
INSERT INTO `country` VALUES ('114', 'Korea, Republic of', 'Country', 'KR', 'InActive', null);
INSERT INTO `country` VALUES ('115', 'Kuwait', 'Country', 'KW', 'InActive', null);
INSERT INTO `country` VALUES ('116', 'Kyrgyzstan', 'Country', 'KG', 'InActive', null);
INSERT INTO `country` VALUES ('117', 'Lao People\'s Democratic Republic', 'Country', 'LA', 'InActive', null);
INSERT INTO `country` VALUES ('118', 'Latvia', 'Country', 'LV', 'InActive', null);
INSERT INTO `country` VALUES ('119', 'Lebanon', 'Country', 'LB', 'InActive', null);
INSERT INTO `country` VALUES ('120', 'Lesotho', 'Country', 'LS', 'InActive', null);
INSERT INTO `country` VALUES ('121', 'Liberia', 'Country', 'LR', 'InActive', null);
INSERT INTO `country` VALUES ('122', 'Libyan Arab Jamahiriya', 'Country', 'LY', 'InActive', null);
INSERT INTO `country` VALUES ('123', 'Liechtenstein', 'Country', 'LI', 'InActive', null);
INSERT INTO `country` VALUES ('124', 'Lithuania', 'Country', 'LT', 'InActive', null);
INSERT INTO `country` VALUES ('125', 'Luxembourg', 'Country', 'LU', 'InActive', null);
INSERT INTO `country` VALUES ('126', 'Macao', 'Country', 'MO', 'InActive', null);
INSERT INTO `country` VALUES ('127', 'Macedonia, Republic of', 'Country', 'MK', 'InActive', null);
INSERT INTO `country` VALUES ('128', 'Madagascar', 'Country', 'MG', 'InActive', null);
INSERT INTO `country` VALUES ('129', 'Malawi', 'Country', 'MW', 'InActive', null);
INSERT INTO `country` VALUES ('130', 'Malaysia', 'Country', 'MY', 'InActive', null);
INSERT INTO `country` VALUES ('131', 'Maldives', 'Country', 'MV', 'InActive', null);
INSERT INTO `country` VALUES ('132', 'Mali', 'Country', 'ML', 'InActive', null);
INSERT INTO `country` VALUES ('133', 'Malta', 'Country', 'MT', 'InActive', null);
INSERT INTO `country` VALUES ('134', 'Marshall Islands', 'Country', 'MH', 'InActive', null);
INSERT INTO `country` VALUES ('135', 'Martinique', 'Country', 'MQ', 'InActive', null);
INSERT INTO `country` VALUES ('136', 'Mauritania', 'Country', 'MR', 'InActive', null);
INSERT INTO `country` VALUES ('137', 'Mauritius', 'Country', 'MU', 'InActive', null);
INSERT INTO `country` VALUES ('138', 'Mayotte', 'Country', 'YT', 'InActive', null);
INSERT INTO `country` VALUES ('139', 'Mexico', 'Country', 'MX', 'InActive', null);
INSERT INTO `country` VALUES ('140', 'Micronesia, Federated States of', 'Country', 'FM', 'InActive', null);
INSERT INTO `country` VALUES ('141', 'Moldova', 'Country', 'MD', 'InActive', null);
INSERT INTO `country` VALUES ('142', 'Monaco', 'Country', 'MC', 'InActive', null);
INSERT INTO `country` VALUES ('143', 'Mongolia', 'Country', 'MN', 'InActive', null);
INSERT INTO `country` VALUES ('144', 'Montserrat', 'Country', 'MS', 'InActive', null);
INSERT INTO `country` VALUES ('145', 'Morocco', 'Country', 'MA', 'InActive', null);
INSERT INTO `country` VALUES ('146', 'Mozambique', 'Country', 'MZ', 'InActive', null);
INSERT INTO `country` VALUES ('147', 'Namibia', 'Country', 'NA', 'InActive', null);
INSERT INTO `country` VALUES ('148', 'Nauru', 'Country', 'NR', 'InActive', null);
INSERT INTO `country` VALUES ('149', 'Nepal', 'Country', 'NP', 'InActive', null);
INSERT INTO `country` VALUES ('150', 'Netherlands Antilles', 'Country', 'AN', 'InActive', null);
INSERT INTO `country` VALUES ('151', 'Netherlands', 'Country', 'NL', 'InActive', null);
INSERT INTO `country` VALUES ('152', 'New Caledonia', 'Country', 'NC', 'InActive', null);
INSERT INTO `country` VALUES ('153', 'New Zealand', 'Country', 'NZ', 'InActive', null);
INSERT INTO `country` VALUES ('154', 'Nicaragua', 'Country', 'NI', 'InActive', null);
INSERT INTO `country` VALUES ('155', 'Niger', 'Country', 'NE', 'InActive', null);
INSERT INTO `country` VALUES ('156', 'Nigeria', 'Country', 'NG', 'InActive', null);
INSERT INTO `country` VALUES ('157', 'Niue', 'Country', 'NU', 'InActive', null);
INSERT INTO `country` VALUES ('158', 'Norfolk Island', 'Country', 'NF', 'InActive', null);
INSERT INTO `country` VALUES ('159', 'Northern Mariana Islands', 'Country', 'MP', 'InActive', null);
INSERT INTO `country` VALUES ('160', 'Norway', 'Country', 'NO', 'InActive', null);
INSERT INTO `country` VALUES ('161', 'Oman', 'Country', 'OM', 'InActive', null);
INSERT INTO `country` VALUES ('162', 'Pakistan', 'Country', 'PK', 'InActive', null);
INSERT INTO `country` VALUES ('163', 'Palau', 'Country', 'PW', 'InActive', null);
INSERT INTO `country` VALUES ('164', 'Palestinian Territory, Occupied', 'Country', 'PS', 'InActive', null);
INSERT INTO `country` VALUES ('165', 'Panama', 'Country', 'PA', 'InActive', null);
INSERT INTO `country` VALUES ('166', 'Papua New Guinea', 'Country', 'PG', 'InActive', null);
INSERT INTO `country` VALUES ('167', 'Paraguay', 'Country', 'PY', 'InActive', null);
INSERT INTO `country` VALUES ('168', 'Peru', 'Country', 'PE', 'InActive', null);
INSERT INTO `country` VALUES ('169', 'Philippines', 'Country', 'PH', 'InActive', null);
INSERT INTO `country` VALUES ('170', 'Pitcairn', 'Country', 'PN', 'InActive', null);
INSERT INTO `country` VALUES ('171', 'Poland', 'Country', 'PL', 'InActive', null);
INSERT INTO `country` VALUES ('172', 'Portugal', 'Country', 'PT', 'InActive', null);
INSERT INTO `country` VALUES ('173', 'Puerto Rico', 'Country', 'PR', 'InActive', null);
INSERT INTO `country` VALUES ('174', 'Qatar', 'Country', 'QA', 'InActive', null);
INSERT INTO `country` VALUES ('175', 'Romania', 'Country', 'RO', 'InActive', null);
INSERT INTO `country` VALUES ('176', 'Russian Federation', 'Country', 'RU', 'InActive', null);
INSERT INTO `country` VALUES ('177', 'Rwanda', 'Country', 'RW', 'InActive', null);
INSERT INTO `country` VALUES ('178', 'Reunion', 'Country', 'RE', 'InActive', null);
INSERT INTO `country` VALUES ('179', 'Saint Helena', 'Country', 'SH', 'InActive', null);
INSERT INTO `country` VALUES ('180', 'Saint Kitts and Nevis', 'Country', 'KN', 'InActive', null);
INSERT INTO `country` VALUES ('181', 'Saint Lucia', 'Country', 'LC', 'InActive', null);
INSERT INTO `country` VALUES ('182', 'Saint Pierre and Miquelon', 'Country', 'PM', 'InActive', null);
INSERT INTO `country` VALUES ('183', 'Saint Vincent and the Grenadines', 'Country', 'VC', 'InActive', null);
INSERT INTO `country` VALUES ('184', 'Samoa', 'Country', 'WS', 'InActive', null);
INSERT INTO `country` VALUES ('185', 'San Marino', 'Country', 'SM', 'InActive', null);
INSERT INTO `country` VALUES ('186', 'Saudi Arabia', 'Country', 'SA', 'InActive', null);
INSERT INTO `country` VALUES ('187', 'Senegal', 'Country', 'SN', 'InActive', null);
INSERT INTO `country` VALUES ('188', 'Seychelles', 'Country', 'SC', 'InActive', null);
INSERT INTO `country` VALUES ('189', 'Sierra Leone', 'Country', 'SL', 'InActive', null);
INSERT INTO `country` VALUES ('190', 'Singapore', 'Country', 'SG', 'InActive', null);
INSERT INTO `country` VALUES ('191', 'Slovakia', 'Country', 'SK', 'InActive', null);
INSERT INTO `country` VALUES ('192', 'Slovenia', 'Country', 'SI', 'InActive', null);
INSERT INTO `country` VALUES ('193', 'Solomon Islands', 'Country', 'SB', 'InActive', null);
INSERT INTO `country` VALUES ('194', 'Somalia', 'Country', 'SO', 'InActive', null);
INSERT INTO `country` VALUES ('195', 'South Africa', 'Country', 'ZA', 'InActive', null);
INSERT INTO `country` VALUES ('196', 'South Georgia and the South Sandwich Islands', 'Country', 'GS', 'InActive', null);
INSERT INTO `country` VALUES ('197', 'Spain', 'Country', 'ES', 'InActive', null);
INSERT INTO `country` VALUES ('198', 'Sri Lanka', 'Country', 'LK', 'InActive', null);
INSERT INTO `country` VALUES ('199', 'Sudan', 'Country', 'SD', 'InActive', null);
INSERT INTO `country` VALUES ('200', 'Suriname', 'Country', 'SR', 'InActive', null);
INSERT INTO `country` VALUES ('201', 'Svalbard and Jan Mayen', 'Country', 'SJ', 'InActive', null);
INSERT INTO `country` VALUES ('202', 'Swaziland', 'Country', 'SZ', 'InActive', null);
INSERT INTO `country` VALUES ('203', 'Sweden', 'Country', 'SE', 'InActive', null);
INSERT INTO `country` VALUES ('204', 'Switzerland', 'Country', 'CH', 'InActive', null);
INSERT INTO `country` VALUES ('205', 'Syrian Arab Republic', 'Country', 'SY', 'InActive', null);
INSERT INTO `country` VALUES ('206', 'Sao Tome and Principe', 'Country', 'ST', 'InActive', null);
INSERT INTO `country` VALUES ('207', 'Taiwan', 'Country', 'TW', 'InActive', null);
INSERT INTO `country` VALUES ('208', 'Tajikistan', 'Country', 'TJ', 'InActive', null);
INSERT INTO `country` VALUES ('209', 'Tanzania, United Republic of', 'Country', 'TZ', 'InActive', null);
INSERT INTO `country` VALUES ('210', 'Thailand', 'Country', 'TH', 'InActive', null);
INSERT INTO `country` VALUES ('211', 'Bahamas', 'Country', 'BS', 'InActive', null);
INSERT INTO `country` VALUES ('212', 'Gambia', 'Country', 'GM', 'InActive', null);
INSERT INTO `country` VALUES ('213', 'Togo', 'Country', 'TG', 'InActive', null);
INSERT INTO `country` VALUES ('214', 'Tokelau', 'Country', 'TK', 'InActive', null);
INSERT INTO `country` VALUES ('215', 'Tonga', 'Country', 'TO', 'InActive', null);
INSERT INTO `country` VALUES ('216', 'Trinidad and Tobago', 'Country', 'TT', 'InActive', null);
INSERT INTO `country` VALUES ('217', 'Tunisia', 'Country', 'TN', 'InActive', null);
INSERT INTO `country` VALUES ('218', 'Turkey', 'Country', 'TR', 'InActive', null);
INSERT INTO `country` VALUES ('219', 'Turkmenistan', 'Country', 'TM', 'InActive', null);
INSERT INTO `country` VALUES ('220', 'Turks and Caicos Islands', 'Country', 'TC', 'InActive', null);
INSERT INTO `country` VALUES ('221', 'Tuvalu', 'Country', 'TV', 'InActive', null);
INSERT INTO `country` VALUES ('222', 'Uganda', 'Country', 'UG', 'InActive', null);
INSERT INTO `country` VALUES ('223', 'Ukraine', 'Country', 'UA', 'InActive', null);
INSERT INTO `country` VALUES ('224', 'United Arab Emirates', 'Country', 'AE', 'InActive', null);
INSERT INTO `country` VALUES ('225', 'United Kingdom', 'Country', 'GB', 'InActive', null);
INSERT INTO `country` VALUES ('226', 'United States Minor Outlying Islands', 'Country', 'UM', 'InActive', null);
INSERT INTO `country` VALUES ('227', 'United States', 'Country', 'US', 'InActive', null);
INSERT INTO `country` VALUES ('228', 'Uruguay', 'Country', 'UY', 'InActive', null);
INSERT INTO `country` VALUES ('229', 'Uzbekistan', 'Country', 'UZ', 'InActive', null);
INSERT INTO `country` VALUES ('230', 'Vanuatu', 'Country', 'VU', 'InActive', null);
INSERT INTO `country` VALUES ('231', 'Venezuela', 'Country', 'VE', 'InActive', null);
INSERT INTO `country` VALUES ('232', 'Viet Nam', 'Country', 'VN', 'InActive', null);
INSERT INTO `country` VALUES ('233', 'Virgin Islands, U.S.', 'Country', 'VI', 'InActive', null);
INSERT INTO `country` VALUES ('234', 'Wallis and Futuna', 'Country', 'WF', 'InActive', null);
INSERT INTO `country` VALUES ('235', 'Western Sahara', 'Country', 'EH', 'InActive', null);
INSERT INTO `country` VALUES ('236', 'Yemen', 'Country', 'YE', 'InActive', null);
INSERT INTO `country` VALUES ('237', 'Serbia and Montenegro', 'Country', 'CS', 'InActive', null);
INSERT INTO `country` VALUES ('238', 'Zambia', 'Country', 'ZM', 'InActive', null);
INSERT INTO `country` VALUES ('239', 'Zimbabwe', 'Country', 'ZW', 'InActive', null);
INSERT INTO `country` VALUES ('240', 'Åland Islands', 'Country', 'AX', 'InActive', null);
INSERT INTO `country` VALUES ('241', 'Serbia', 'Country', 'RS', 'InActive', null);
INSERT INTO `country` VALUES ('242', 'Montenegro', 'Country', 'ME', 'InActive', null);
INSERT INTO `country` VALUES ('243', 'Jersey', 'Country', 'JE', 'InActive', null);
INSERT INTO `country` VALUES ('244', 'Guernsey', 'Country', 'GG', 'InActive', null);
INSERT INTO `country` VALUES ('245', 'Isle of Man', 'Country', 'IM', 'InActive', null);

-- ----------------------------
-- Table structure for `credit`
-- ----------------------------
DROP TABLE IF EXISTS `credit`;
CREATE TABLE `credit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `sale_invoice_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `amount` decimal(14,6) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of credit
-- ----------------------------

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `document_id` int(11) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `integer_part` varchar(255) DEFAULT NULL,
  `fractional_part` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `postfix` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1817 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES ('5598', null, 'Default Currency', '1', '1816', null, null, null, null);

-- ----------------------------
-- Table structure for `custom_account_entries_templates`
-- ----------------------------
DROP TABLE IF EXISTS `custom_account_entries_templates`;
CREATE TABLE `custom_account_entries_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `detail` text,
  `is_favourite_menu_lister` tinyint(4) DEFAULT NULL,
  `is_merge_transaction` tinyint(4) DEFAULT NULL,
  `unique_trnasaction_template_code` varchar(255) DEFAULT NULL,
  `is_system_default` tinyint(4) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of custom_account_entries_templates
-- ----------------------------
INSERT INTO `custom_account_entries_templates` VALUES ('55', 'Charges Deduction From Bank', 'Bank amount decreased due to deduction of charges.', '0', null, 'BANKCHARGES', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('56', 'Bank payment against office expenses ', 'Bank payment against office expenses, those are related to non-goods expenses', '0', null, 'EXPENSESBANKPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('57', 'Payment Return To Party (By Bank)', 'Bank Payment return to party/person/supplier whose ledger is maintained. You should do this if you frequently do business with this person and any you may require statement of supplier on any time.', '0', null, 'BANKRETURNTOPARTY', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('58', 'Payment Received From Party (Bank)', 'Payment received from party/ person/customer via Bank whose ledger is maintained. You should do this if you frequently do business with this person and you may require statement of party on any time.', '0', null, 'PARTYBANKRECEIVED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('59', 'Payment Given To Party (Cash)', 'Cash payment given to party/person/supplier whose ledger is maintained. You should do this if you frequently do business with this person and any you may require statement of supplier on any time.', '0', null, 'PARTYCASHPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('60', 'Cash Withdraw From Bank', 'Cash withdrawal from bank.', '0', null, 'CASHWITHDRAWFROMBANK', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('61', 'Salary paid', 'Salary paid entry', '0', null, 'BULKSALARYPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('62', 'Salary payment (without ledger maintain)', 'Cash/Bank payment against salary', '0', null, 'SALARYPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('63', 'Reimbursement payment (without ledger maintain)', 'Cash/Bank payment against reimbursement', '0', null, 'REIMBURSEMENTPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('64', 'Payment Received From Party (Bank)', 'Payment received from party/ person/customer via Bank whose ledger is maintained. You should do this if you frequently do business with this person and you may require statement of party on any time.', '0', null, 'ANYPARTYBANKRECEIVED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('65', 'Payment Received From Party (Cash)', 'Payment received from party/ person/customer via Cash whose ledger is maintained. You should do this if you frequently do business with this person and you may require statement of party on any time.', '0', null, 'PARTYCASHRECEIVED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('66', 'Payment Return From Party (Bank)', 'Payment return recieved from party/ person/customer via Bank whose ledger is maintained. You should do this if you frequently do business with this person and you may require statement of party on any time.', '0', null, 'RETURNFROMPARTYBANK', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('67', 'Salary transferred to ledger account (with due entry)', 'Salary due and paid entry', '0', null, 'SALARYDUEANDPAID', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('68', 'Cash payment against any expenses(like Rent, Commission etc) ', 'Cash payment against any expenses, those are related to business any other expenses', '0', null, 'INDIRECTEXPENSESCASHPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('69', 'Cash Deposit In Bank', 'Cash deposited in bank.', '0', null, 'CASHDEPOSITINBANK', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('70', 'Interest On OverDraft', 'Interest applied on withdraw money, when withdraw limit exeeds.', '0', null, 'INTERESTONOD', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('71', 'Payment To Party (By Bank) / Returning Loan Money.', 'Bank Payment given to party/person/ whose ledger is maintained. You paying this money against loan.', '0', null, 'PAYMENTLOAN', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('72', 'Cash payment against office expenses ', 'Cash payment against office expenses, those are related to non-goods expenses', '0', null, 'EXPENSESCASHPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('73', 'Payment Received From Party (Cash)', 'Payment received from party/ person/customer via Cash whose ledger is maintained. You should do this if you frequently do business with this person and you may require statement of party on any time.', '0', null, 'ANYPARTYCASHRECEIVED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('74', 'Capital Investment (Starting Of Business)', 'Investment in business by cash, cash received in business from bank or from any person ', '0', null, 'CAPITALINVESTMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('75', 'Payment Given To Party (By Bank)', 'Bank Payment given to party/person/supplier whose ledger is maintained. You should do this if you frequently do business with this person and any you may require statement of supplier on any time.', '0', null, 'PARTYBANKPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('76', 'Money recieved against deduction cause of any reason from employees', 'Recieved money as cash or in bank against deduction', '0', null, 'DEDUCTIONRECEIVED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('77', 'Cash payment not done for expenses(like Rent, Commission etc) , so its being due for business', 'Cash payment not done for expenses(like Rent, Commission etc) , so its being due for business', '0', null, 'INDIRECTEXPENSESDUE', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('78', 'Loans Or Advances Taken From Parties', 'Loan taken from any of the person or entity, which can be secure or unsecure', '0', null, 'TAKENLOAN', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('79', 'Fixed Asset Purchased (in cash or credit)', 'Asset purchased for office / factory / plant (like machinery, furniture or computers etc.)', '0', null, 'ASSETPURCHASED', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('80', 'Tax Payment Through Bank', 'Payable taxes paid to government via bank. ', '0', null, 'TAXPAYABLEBANKPAYMENT', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('81', 'Salary Due', 'Salary due \r\n', '0', null, 'SALARYDUE', '0', null);
INSERT INTO `custom_account_entries_templates` VALUES ('82', 'Cash payment against due expenses ', 'Cash payment against outstanding expenses, those are due for business', '0', null, 'DUEEXPENSESCASHPAYMENT', '0', null);

-- ----------------------------
-- Table structure for `custom_account_entries_templates_transaction_row`
-- ----------------------------
DROP TABLE IF EXISTS `custom_account_entries_templates_transaction_row`;
CREATE TABLE `custom_account_entries_templates_transaction_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `side` varchar(255) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `is_include_subgroup_ledger_account` tinyint(4) DEFAULT NULL,
  `parent_group` varchar(255) DEFAULT NULL,
  `ledger` varchar(255) DEFAULT NULL,
  `is_ledger_changable` tinyint(4) DEFAULT NULL,
  `is_allow_add_ledger` tinyint(4) DEFAULT NULL,
  `is_include_currency` tinyint(4) DEFAULT NULL,
  `template_transaction_id` int(11) DEFAULT NULL,
  `balance_sheet` varchar(255) DEFAULT NULL,
  `ledger_type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=406 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of custom_account_entries_templates_transaction_row
-- ----------------------------
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('256', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '70', '', '', 'Bank Charge -1 (Charges applied for any aminity which is given by bank)', 'bank-charges1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('257', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '70', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('258', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '70', '', '', 'Bank Charge -2 (Charges applied for any aminity which is given by bank)', 'bank-charges2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('259', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '71', '', 'Other Expenses', 'Office Expense -1 (for ex - mobile bill, electricity bill, stationery etc.)', 'officeexpense1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('260', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '71', '', 'Indirect Expenses', 'Office Expense -2 (for ex - mobile bill, electricity bill, stationery etc.)', 'officeexpense2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('261', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '71', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('262', 'DR', 'Sundry Debtor', null, '', '', '1', '0', '1', '72', '', '', 'Party you return to', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('263', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '72', '', '', 'Bank Account (And Actual Amount Paid From Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('264', 'CR', 'Rebate & Discount Received', null, '', 'Rebate & Discount Received', '0', '0', '0', '72', '', '', 'Discount Received', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('265', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '72', '', 'TAX Payable', 'Any Tax Deducted by You - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('266', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '72', '', 'TAX Payable', 'Any Tax Deducted by You - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('267', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '72', '', 'TAX Payable', 'Any Tax Deducted by You - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('268', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '72', '', '', 'Any Bank Charges Applied', 'bank-charges');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('269', 'DR', 'Bank Charges Expenses', null, '', '', '1', '1', '0', '73', '', '', 'Bank Charge -1 (& Charges applied)', 'bank-charges1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('270', 'DR', 'Bank Charges Expenses', null, '', '', '1', '1', '0', '73', '', '', 'Bank Charge -2 (& Charges applied)', 'bank-charges2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('271', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '73', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('272', 'CR', 'Sundry Debtor', null, '', '', '1', '0', '1', '74', '', '', 'Party From which you received Payment', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('273', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '74', '', '', 'Bank Account (And Actual Amount Received In Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('274', 'DR', 'Rebate & Discount Allowed', null, '', 'Rebate & Discount Allowed', '0', '0', '0', '74', '', '', 'Any Discount Given', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('275', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '74', '', 'TAX Receivable', 'Any Tax Deducted from Party - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('276', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '74', '', 'TAX Receivable', 'Any Tax Deducted from Party - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('277', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '74', '', 'TAX Receivable', 'Any Tax Deducted from Party - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('278', 'DR', 'Other Expenses', null, '', '', '1', '1', '1', '74', '', '', 'Any External Deduction on payment transfer', 'external_deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('279', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '0', '1', '0', '75', '', '', 'Bank Charges (& Charges applied)', 'bank-charges');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('280', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '75', '', 'Bank', 'Bank Account (And Amount Charged In Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('281', 'DR', 'Sundry Creditor', null, '', '', '1', '0', '0', '76', '', '', 'Party you paid to', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('282', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '76', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('283', 'CR', 'Rebate & Discount Received', null, '', 'Rebate & Discount Received', '0', '0', '0', '76', '', '', 'Discount Received', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('284', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '76', '', 'TAX Payable', 'Any Tax Deducted by You - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('285', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '76', '', 'TAX Payable', 'Any Tax Deducted by You - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('286', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '76', '', 'TAX Payable', 'Any Tax Deducted by You - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('287', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '77', '', '', 'Bank Account (And Actual Amount Withdraw)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('288', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '77', '', '', 'Cash Account ( And Cash increased in business)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('289', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '78', '', '', 'Bank Charge -1 (& Charges applied)', 'bank-charges1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('290', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '0', '0', '78', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('291', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '78', '', '', 'Bank Charge -2 (& Charges applied)', 'bank-charges2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('292', 'DR', 'Sundry Creditor', null, '', '', '1', '0', '0', '79', '', 'Employee', 'SalaryToEmployees', 'employeessalaries');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('293', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '79', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('294', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '79', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('295', 'DR', 'Salary (Indirect)', null, '', 'Salary', '0', '0', '0', '80', '', 'Salary', 'Salary', 'salary');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('296', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '80', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('297', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '80', '', 'Tax Payable', 'TDS cost deduction from salary(if applied)', 'tax');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('298', 'CR', 'Provision For Employee Benefits', null, '', 'Employee PF', '0', '1', '0', '80', '', 'Provision Fund', 'Employee\'s Provident Fund Amount (Actual Amount Deduct)', 'employeebenefitaccounts-1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('299', 'CR', 'Provision For Employee Benefits', null, '', 'ESIC', '0', '1', '0', '80', '', 'Provision Fund', 'ESIC Amount (Actual Amount Deduct)', 'employeebenefitaccounts-2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('300', 'CR', 'Provision For Employee Benefits', null, '', 'Employer PF', '0', '1', '0', '80', '', 'Provision Fund', 'Employer\'s Provident Fund Amount (Actual Amount Deduct)', 'employeebenefitaccounts');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('301', 'CR', 'Provision For Employee Benefits', null, '', '', '1', '1', '0', '80', '', 'Provision Fund', 'Employee\'s Benefit Amount (Actual Amount Deduct)', 'employeebenefitaccounts-3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('302', 'CR', 'Bank Account', null, '', 'Your Default Bank Account', '1', '1', '0', '80', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('303', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '81', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('304', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '81', '', 'Tax Payable', 'TDS cost deduction from salary(if applied)', 'tax');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('305', 'CR', 'Bank Account', null, '', 'Your Default Bank Account', '1', '1', '0', '81', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('306', 'DR', 'Reimbursement To Employees', null, 'Compensation To Employee (Indirect)', 'Reimbursement To Employees', '1', '1', '0', '81', 'Indirect Expenses', 'Reimbursement(Legal Expenses)', 'Reimbursement To Employees', 'reimbursement');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('307', 'CR', 'Sundry Creditor,Sundry Debtor', null, '', '', '1', '0', '1', '82', '', '', 'Party From which you received Payment', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('308', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '82', '', '', 'Bank Account (And Actual Amount Received In Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('309', 'DR', 'Rebate & Discount Allowed', null, '', 'Rebate & Discount Allowed', '0', '0', '0', '82', '', '', 'Any Discount Given', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('310', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '82', '', 'TAX Receivable', 'Any Tax Deducted from Party - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('311', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '82', '', 'TAX Receivable', 'Any Tax Deducted from Party - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('312', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '82', '', 'TAX Receivable', 'Any Tax Deducted from Party - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('313', 'DR', 'Other Expenses', null, '', '', '1', '1', '1', '82', '', '', 'Any External Deduction on payment transfer', 'external_deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('314', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '0', '1', '0', '83', '', '', 'Bank Charges (& Charges applied)', 'bank-charges');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('315', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '83', '', 'Bank', 'Bank Account (And Amount Charged In Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('316', 'CR', 'Sundry Debtor', null, '', '', '1', '0', '1', '84', '', '', 'Party From which you received Payment', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('317', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '84', '', '', 'Cash Account (And Actual Amount Received In Cash)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('318', 'DR', 'Rebate & Discount Allowed', null, '', 'Rebate & Discount Allowed', '0', '0', '0', '84', '', '', 'Any Discount Given', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('319', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '84', '', 'TAX Receivable', 'Any Tax Deducted from Party - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('320', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '84', '', 'TAX Receivable', 'Any Tax Deducted from Party - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('321', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '84', '', 'TAX Receivable', 'Any Tax Deducted from Party - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('322', 'DR', 'Tax Receivable', null, '', '', '1', '1', '1', '84', '', '', 'Any External Deduction on payment transfer', 'external_deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('323', 'CR', 'Sundry Creditor', null, '', '', '1', '0', '1', '85', '', '', 'Party From which you return received Payment', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('324', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '85', '', '', 'Bank Account (And Actual Amount Received In Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('325', 'DR', 'Rebate & Discount Allowed', null, '', 'Rebate & Discount Allowed', '0', '0', '0', '85', '', '', 'Any Discount Given', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('326', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '85', '', 'TAX Receivable', 'Any Tax Deducted from Party - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('327', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '85', '', 'TAX Receivable', 'Any Tax Deducted from Party - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('328', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '85', '', 'TAX Receivable', 'Any Tax Deducted from Party - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('329', 'DR', 'Other Expenses', null, '', '', '1', '1', '1', '85', '', '', 'Any External Deduction on payment transfer', 'external_deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('330', 'DR', 'Salary (Indirect)', null, '', 'Salary', '0', '0', '0', '86', '', 'Salary', 'Due salary amount', 'salary');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('331', 'CR', 'Sundry Creditor', null, '', '', '1', '1', '0', '86', '', 'Employee', 'Employee', 'salarytocreditor');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('332', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '86', '', 'Tax Payable', 'TDS cost deduction from salary(if applied)', 'tax');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('333', 'CR', 'Provision For Employee Benefits', null, '', 'Employee PF', '0', '1', '0', '86', '', 'Provision Fund', 'Employee\'s Provident Fund Amount (Actual Amount Deduct)', 'employeebenefitaccounts-1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('334', 'CR', 'Provision For Employee Benefits', null, '', 'ESIC', '0', '1', '0', '86', '', 'Provision Fund', 'ESIC Amount (Actual Amount Deduct)', 'employeebenefitaccounts-2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('335', 'CR', 'Provision For Employee Benefits', null, '', 'Employer PF', '0', '1', '0', '86', '', 'Provision Fund', 'Employer\'s Provident Fund Amount (Compnay\'s Part)', 'employeebenefitaccounts-3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('336', 'CR', 'Provision For Employee Benefits', null, '', '', '1', '1', '0', '86', '', 'Provision Fund', 'Employee\'s Other Benefit Amount (Actual Amount Deduct)', 'employeebenefitaccounts-4');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('337', 'DR', 'Sundry Creditor', null, '', '', '1', '1', '0', '87', '', 'Employee', 'SalaryToEmployee', 'employeesalaryaccount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('338', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '87', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('339', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '87', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('340', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '88', '', 'Indirect Expenses', 'Expense -1 (for ex - rent, commission etc.)', 'expense1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('341', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '88', '', 'Indirect Expenses', 'Expense -2 (for ex - rent, commission etc.)', 'expense2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('342', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '88', '', '', 'Cash Account ( And Cash In Hand)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('343', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '89', '', '', 'Bank Account (And Actual Amount Deposited)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('344', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '89', '', '', 'Cash Account ( And Cash decreased from business)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('345', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '90', '', '', 'Bank Account (Same As Above Transaction)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('346', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '90', '', '', 'Bank Charge -1 (& Charges applied)', 'bank-charges1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('347', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '90', '', '', 'Bank Charge -2 (& Charges applied)', 'bank-charges2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('348', 'DR', 'Other Expenses', null, '', 'Interest On OD', '0', '0', '0', '91', '', 'Expenses Type', 'Interest applied on od & bank amount decreased', 'interest-on-overdraft');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('349', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '91', '', 'Bank', 'Bank Account (particular bank account in which, amount deduct for interest on od)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('350', 'DR', 'Loans And Advances From Related Parties (Long Term),Sundry Creditor', null, '', '', '1', '0', '1', '92', '', '', 'Party or Entity Name you paid to', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('351', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '92', '', '', 'Bank Account (And Actual Amount Paid From Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('352', 'DR', 'Bank Charges Expenses', null, '', '', '1', '1', '0', '93', '', '', 'Bank Charge -1 (& Charges applied)', 'bank-charges1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('353', 'DR', 'Bank Charges Expenses', null, '', '', '1', '1', '0', '93', '', '', 'Bank Charge -2 (& Charges applied)', 'bank-charges2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('354', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '93', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('355', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '94', '', 'Other Expenses', 'Office Expense -1 (for ex - mobile bill, electricity bill, stationery etc.)', 'officeexpense1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('356', 'DR', 'Other Expenses', null, '', '', '1', '1', '0', '94', '', 'Indirect Expenses', 'Office Expense -2 (for ex - mobile bill, electricity bill, stationery etc.)', 'officeexpense2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('357', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '94', '', '', 'Cash Account ( And Cash In Hand)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('358', 'CR', 'Sundry Creditor,Sundry Debtor', null, '', '', '1', '0', '1', '95', '', '', 'Party From which you received Payment', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('359', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '95', '', '', 'Cash Account (And Actual Amount Received In Cash)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('360', 'DR', 'Rebate & Discount Allowed', null, '', 'Rebate & Discount Allowed', '0', '0', '0', '95', '', '', 'Any Discount Given', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('361', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '95', '', 'TAX Receivable', 'Any Tax Deducted from Party - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('362', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '95', '', 'TAX Receivable', 'Any Tax Deducted from Party - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('363', 'DR', 'Tax Receivable', null, '', '', '1', '1', '0', '95', '', 'TAX Receivable', 'Any Tax Deducted from Party - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('364', 'DR', 'Tax Receivable', null, '', '', '1', '1', '1', '95', '', '', 'Any External Deduction on payment transfer', 'external_deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('365', 'CR', 'Share Capital', null, '', 'Capital Account', '0', '0', '0', '96', '', 'Capital Account', 'Capital ', 'capital');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('366', 'CR', 'Share Capital', null, '', '', '1', '1', '0', '96', '', 'Party Name', 'Party Capital Account', 'capitalfromparty');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('367', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '96', '', 'Bank', 'Bank Account (And Actual Received Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('368', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '96', '', '', 'Cash Account ( And Cash In Hand)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('369', 'DR', 'Sundry Creditor', null, '', '', '1', '0', '1', '97', '', '', 'Party you paid to', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('370', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '97', '', '', 'Bank Account (And Actual Amount Paid From Bank)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('371', 'CR', 'Rebate & Discount Received', null, '', 'Rebate & Discount Received', '0', '0', '0', '97', '', '', 'Discount Received', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('372', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '97', '', 'TAX Payable', 'Any Tax Deducted by You - 1', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('373', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '97', '', 'TAX Payable', 'Any Tax Deducted by You - 2', 'tax2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('374', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '97', '', 'TAX Payable', 'Any Tax Deducted by You - 3', 'tax3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('375', 'DR', 'Bank Charges Expenses', null, '', 'Bank Charges', '1', '1', '0', '97', '', '', 'Any Bank Charges Applied', 'bank-charges');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('376', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '98', '', '', 'Cash Account (Cash In hand) - Actual Amount Paid', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('377', 'DR', 'Tax Payable', null, '', '', '1', '1', '0', '98', '', 'Tax Payable', 'TDS cost deduction from salary(if applied)', 'tax');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('378', 'DR', 'Bank Account', null, '', 'Your Default Bank Account', '1', '1', '0', '98', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('379', 'CR', 'Dedcution From Employees', null, 'Other Income', 'Deduction From Employees', '1', '1', '0', '98', 'Indirect Income', 'Deduction From Employees', 'Deduction From Employees', 'deduction');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('380', 'CR', 'Other Expenses', null, '', '', '1', '1', '0', '99', '', 'Indirect Expenses', 'Expense -1 (for ex - rent, commission etc.)', 'expense1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('381', 'CR', 'Other Expenses', null, '', '', '1', '1', '0', '99', '', 'Indirect Expenses', 'Expense -2 (for ex - rent, commission etc.)', 'expense2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('382', 'DR', 'Deffered Payment Liabilities', null, '', 'Outstanding Expenses', '0', '1', '0', '99', '', 'Outstanding Expenses', 'Expense due & it being outstanding expenses', 'expensedue');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('383', 'DR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '100', '', '', 'Bank Account (And Actual Received Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('384', 'DR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '100', '', '', 'Cash Account ( And Cash In Hand)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('385', 'CR', 'Loans And Advances From Related Parties (Long Term)', null, '', '', '1', '1', '0', '100', '', '', 'Party Or Entity Name', 'party');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('386', 'DR', 'Plant & Equipment,Furniture & Fixtures,Computers & Printers,Vehicles,Office Equipment,Others (Tangible Assets),Land (Appreciable),Building (Depreciable)', null, '', '', '1', '1', '1', '101', '', '', 'Asset (like machinery, furniture, building or computers etc.)', 'fixedasset-1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('387', 'DR', 'Plant & Equipment,Furniture & Fixtures,Computers & Printers,Vehicles,Office Equipment,Others (Tangible Assets),Land (Appreciable),Building (Depreciable)', null, '', '', '1', '1', '1', '101', '', '', 'Asset (like machinery, furniture, building or computers etc.)', 'fixedasset-2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('388', 'DR', 'Plant & Equipment,Furniture & Fixtures,Computers & Printers,Vehicles,Office Equipment,Others (Tangible Assets),Land (Appreciable),Building (Depreciable)', null, '', '', '1', '1', '1', '101', '', '', 'Asset (like machinery, furniture, building or computers etc.)', 'fixedasset-3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('389', 'CR', 'Rebate & Discount Received', null, '', '', '1', '1', '1', '101', '', '', 'Discount recieved on purchasing of asset (like machinery, furniture or computers etc.)', 'discount');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('390', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '1', '101', '', '', 'Cash Account ( And Cash In Hand)', 'cash');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('391', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '1', '101', '', '', 'Bank Account (And Actual Deduct Amount)', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('392', 'CR', 'Sundry Creditor', null, '', '', '1', '1', '1', '101', '', '', 'Party or Entity Name you paid to', 'creditor');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('393', 'DR', 'Tax Payable', null, '', 'Tax Account', '1', '1', '0', '102', '', '', 'Tax Name -1 (which is paid by you to government ) ', 'tax1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('394', 'CR', 'Bank OD,Bank Account', null, '', '', '1', '1', '0', '102', '', '', 'Bank Account, which you using to pay tax', 'bank');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('395', 'DR', 'Tax Payable', null, '', 'Tax Account', '1', '1', '0', '102', '', '', 'Tax Name -2 (which is paid by you to government )', 'tax 2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('396', 'DR', 'Tax Payable', null, '', 'Tax Account', '1', '1', '0', '102', '', '', 'Tax Name -3 (which is paid by you to government )', 'tax 3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('397', 'DR', 'Salary (Indirect)', null, '', 'Salary', '0', '0', '0', '103', '', 'Salary', 'Due salary amount', 'salary');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('398', 'CR', 'Sundry Creditor', null, '', 'SalaryProvision', '1', '1', '0', '103', '', 'Salary Provision', 'Salary Provision', 'salarytopay');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('399', 'CR', 'Tax Payable', null, '', '', '1', '1', '0', '103', '', 'Tax Payable', 'TDS cost deduction from salary(if applied)', 'tax');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('400', 'CR', 'Provision For Employee Benefits', null, '', 'Employee PF', '0', '1', '0', '103', '', 'Provision Fund', 'Employee\'s Provident Fund Amount (Actual Amount Deduct)', 'employeebenefitaccounts-1');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('401', 'CR', 'Provision For Employee Benefits', null, '', 'ESIC', '0', '1', '0', '103', '', 'Provision Fund', 'ESIC Amount (Actual Amount Deduct)', 'employeebenefitaccounts-2');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('402', 'CR', 'Provision For Employee Benefits', null, '', 'Employer PF', '0', '1', '0', '103', '', 'Provision Fund', 'Employer\'s Provident Fund Amount (Compnay\'s Part)', 'employeebenefitaccounts-3');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('403', 'CR', 'Provision For Employee Benefits', null, '', '', '1', '1', '0', '103', '', 'Provision Fund', 'Employee\'s Other Benefit Amount (Actual Amount Deduct)', 'employeebenefitaccounts-4');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('404', 'DR', 'Deffered Payment Liabilities', null, '', 'Outstanding Expenses', '0', '1', '0', '104', '', 'Indirect Expenses', 'Payment against due expenses', 'expenseduepayment');
INSERT INTO `custom_account_entries_templates_transaction_row` VALUES ('405', 'CR', 'Cash In Hand', null, '', 'Cash Account', '0', '0', '0', '104', '', '', 'Cash Account ( And Cash In Hand)', 'cash');

-- ----------------------------
-- Table structure for `custom_account_entries_templates_transactions`
-- ----------------------------
DROP TABLE IF EXISTS `custom_account_entries_templates_transactions`;
CREATE TABLE `custom_account_entries_templates_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of custom_account_entries_templates_transactions
-- ----------------------------
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('70', 'Bank Charges Deduction ', '55', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('71', 'Payment Paid Through Bank Against Office Expenses', '56', 'BankPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('72', 'Return Payment From Bank To Party', '57', 'BankPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('73', 'Bank Charges Deduction', '57', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('74', 'Payment Received In Bank', '58', 'BankReceipt');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('75', 'Bank Charges (If Any)', '58', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('76', 'Cash Payment Paid', '59', 'CashPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('77', 'Cash Withdraw From Bank', '60', 'Contra');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('78', 'Bank Charges (If Any)', '60', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('79', 'Payment Through Bank Or Cash Against Salary Due', '61', 'SalaryPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('80', 'Payment Paid Against Salary', '62', 'SalaryPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('81', 'Payment Paid Against Reimbursement', '63', 'ReimbursementPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('82', 'Payment Received In Bank', '64', 'BankReceipt');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('83', 'Bank Charges (If Any)', '64', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('84', 'Payment Received Via Cash', '65', 'CashReceipt');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('85', 'Payment Return From Party Received In Bank', '66', 'BankReceipt');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('86', 'Salary Due Entry', '67', 'SalaryDue');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('87', 'Payment Through Bank Or Cash Against Salary Due', '67', 'SalaryPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('88', 'Cash Payment Paid Against Indirect Expenses', '68', 'CashPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('89', 'Cash Deposit in Bank', '69', 'Contra');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('90', 'Bank Charges (If Any)', '69', 'BankCharges');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('91', 'Bank Amount Deduction For Interest On OD', '70', 'InterestPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('92', 'Payment Paid From Bank', '71', 'PaymentLoan');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('93', 'Bank Charges Deduction', '71', 'BankPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('94', 'Cash Payment Paid Against Office Expenses', '72', 'CashPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('95', 'Payment Received Via Cash', '73', 'CashReceipt');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('96', 'Business start(capital investment)', '74', 'CapitalInvestment');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('97', 'Payment Paid From Bank', '75', 'BankPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('98', 'Deduction money received from employees', '76', 'DeductionReceived');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('99', 'Expenses Being Due For Business', '77', 'ExpnesesDue');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('100', 'Loan money recieved in cash or bank', '78', 'LoanReciept');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('101', 'Purchasing Of Fixed Asset In Cash Or Credit', '79', 'Asset Purchased');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('102', 'Bank Payment Against Tax Payable', '80', 'BankPaid');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('103', 'Salary Due Entry', '81', 'SalaryDue');
INSERT INTO `custom_account_entries_templates_transactions` VALUES ('104', 'Cash Payment(For Due Expenses)', '82', 'CashPaid');

-- ----------------------------
-- Table structure for `custom_form`
-- ----------------------------
DROP TABLE IF EXISTS `custom_form`;
CREATE TABLE `custom_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `submit_button_name` varchar(255) DEFAULT NULL,
  `form_layout` varchar(255) DEFAULT NULL,
  `custom_form_layout_path` varchar(255) DEFAULT NULL,
  `recieve_email` tinyint(4) DEFAULT NULL,
  `recipient_email` varchar(255) DEFAULT NULL,
  `auto_reply` tinyint(4) DEFAULT NULL,
  `message_body` text,
  `email_subject` text,
  `emailsetting_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of custom_form
-- ----------------------------

-- ----------------------------
-- Table structure for `custom_form_field`
-- ----------------------------
DROP TABLE IF EXISTS `custom_form_field`;
CREATE TABLE `custom_form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_form_id` int(11) DEFAULT NULL,
  `value` text,
  `is_mandatory` tinyint(4) DEFAULT NULL,
  `hint` text,
  `placeholder` text,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `auto_reply` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of custom_form_field
-- ----------------------------

-- ----------------------------
-- Table structure for `custom_form_submission`
-- ----------------------------
DROP TABLE IF EXISTS `custom_form_submission`;
CREATE TABLE `custom_form_submission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_form_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of custom_form_submission
-- ----------------------------

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `contact_id` int(11) NOT NULL,
  `billing_address` varchar(255) DEFAULT '',
  `billing_city` varchar(45) DEFAULT NULL,
  `billing_state_id` int(11) DEFAULT NULL,
  `billing_country_id` int(11) DEFAULT NULL,
  `billing_pincode` varchar(45) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT '',
  `shipping_city` varchar(45) DEFAULT NULL,
  `shipping_state_id` int(11) DEFAULT NULL,
  `shipping_country_id` int(11) DEFAULT NULL,
  `shipping_pincode` varchar(45) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tin_no` varchar(255) DEFAULT '',
  `pan_no` varchar(255) DEFAULT '',
  `currency_id` int(11) DEFAULT NULL,
  `same_as_billing_address` tinyint(4) DEFAULT NULL,
  `is_designer` tinyint(4) DEFAULT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `currency_id` (`currency_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('142439', '', null, null, null, null, '', null, null, null, null, '1', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142440', '', null, null, null, null, '', null, null, null, null, '2', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142441', '', null, null, null, null, '', null, null, null, null, '3', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142442', '', null, null, null, null, '', null, null, null, null, '4', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142443', '', null, null, null, null, '', null, null, null, null, '5', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142444', '', null, null, null, null, '', null, null, null, null, '6', '', '', null, null, '0', null, null);
INSERT INTO `customer` VALUES ('142445', '', null, null, null, null, '', null, null, null, null, '7', '', '', null, null, '0', null, null);

-- ----------------------------
-- Table structure for `customfield_association`
-- ----------------------------
DROP TABLE IF EXISTS `customfield_association`;
CREATE TABLE `customfield_association` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `customfield_generic_id` int(11) DEFAULT NULL,
  `can_effect_stock` tinyint(4) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `is_optional` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `customfield_generic_id` (`customfield_generic_id`) USING BTREE,
  KEY `department_id` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customfield_association
-- ----------------------------

-- ----------------------------
-- Table structure for `customfield_generic`
-- ----------------------------
DROP TABLE IF EXISTS `customfield_generic`;
CREATE TABLE `customfield_generic` (
  `name` varchar(255) NOT NULL,
  `display_type` varchar(255) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sequence_order` int(11) DEFAULT NULL,
  `is_filterable` tinyint(4) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_system` tinyint(4) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sequence_order` (`sequence_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customfield_generic
-- ----------------------------

-- ----------------------------
-- Table structure for `customfield_value`
-- ----------------------------
DROP TABLE IF EXISTS `customfield_value`;
CREATE TABLE `customfield_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `customfield_association_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `highlight_it` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itemcustomassociation_id` (`customfield_association_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customfield_value
-- ----------------------------

-- ----------------------------
-- Table structure for `deduction`
-- ----------------------------
DROP TABLE IF EXISTS `deduction`;
CREATE TABLE `deduction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `amount` decimal(14,6) DEFAULT NULL,
  `narration` text,
  `received_amount` decimal(14,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of deduction
-- ----------------------------

-- ----------------------------
-- Table structure for `department`
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `document_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `production_level` int(11) DEFAULT NULL,
  `is_system` tinyint(4) DEFAULT '0',
  `is_outsourced` tinyint(4) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `simultaneous_no_process_allowed` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('5584', 'Company', '1', '1', '0', '40', null);

-- ----------------------------
-- Table structure for `designer_font`
-- ----------------------------
DROP TABLE IF EXISTS `designer_font`;
CREATE TABLE `designer_font` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `regular_file_id` int(11) DEFAULT NULL,
  `bold_file_id` int(11) DEFAULT NULL,
  `italic_file_id` int(11) DEFAULT NULL,
  `bold_italic_file_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of designer_font
-- ----------------------------

-- ----------------------------
-- Table structure for `designer_image_category`
-- ----------------------------
DROP TABLE IF EXISTS `designer_image_category`;
CREATE TABLE `designer_image_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_library` tinyint(4) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of designer_image_category
-- ----------------------------

-- ----------------------------
-- Table structure for `designer_images`
-- ----------------------------
DROP TABLE IF EXISTS `designer_images`;
CREATE TABLE `designer_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designer_category_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `designer_category_id` (`designer_category_id`) USING BTREE,
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of designer_images
-- ----------------------------

-- ----------------------------
-- Table structure for `discount_voucher`
-- ----------------------------
DROP TABLE IF EXISTS `discount_voucher`;
CREATE TABLE `discount_voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `expire_date` datetime NOT NULL,
  `no_of_person` int(11) NOT NULL,
  `one_user_how_many_time` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `on_category_id` int(11) DEFAULT NULL,
  `on` varchar(255) DEFAULT NULL,
  `include_sub_category` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `based_on` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of discount_voucher
-- ----------------------------

-- ----------------------------
-- Table structure for `discount_voucher_condition`
-- ----------------------------
DROP TABLE IF EXISTS `discount_voucher_condition`;
CREATE TABLE `discount_voucher_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discountvoucher_id` int(11) NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of discount_voucher_condition
-- ----------------------------

-- ----------------------------
-- Table structure for `discount_voucher_used`
-- ----------------------------
DROP TABLE IF EXISTS `discount_voucher_used`;
CREATE TABLE `discount_voucher_used` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qsp_master_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `discountvoucher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of discount_voucher_used
-- ----------------------------

-- ----------------------------
-- Table structure for `dispatch_barcode`
-- ----------------------------
DROP TABLE IF EXISTS `dispatch_barcode`;
CREATE TABLE `dispatch_barcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `is_used` tinyint(4) DEFAULT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `related_document_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of dispatch_barcode
-- ----------------------------

-- ----------------------------
-- Table structure for `document`
-- ----------------------------
DROP TABLE IF EXISTS `document`;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `sub_type` varchar(45) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_by_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `search_string` text,
  PRIMARY KEY (`id`),
  KEY `fk_document_epan1_idx` (`epan_id`),
  FULLTEXT KEY `search_string` (`search_string`)
) ENGINE=InnoDB AUTO_INCREMENT=5599 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of document
-- ----------------------------
INSERT INTO `document` VALUES ('5584', '0', 'Department', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'Active', '  Company');
INSERT INTO `document` VALUES ('5585', '0', 'Post', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'Active', '  CEO 10:00:00 18:00:00');
INSERT INTO `document` VALUES ('5586', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Default MarketingCategory All');
INSERT INTO `document` VALUES ('5587', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Active Affiliate MarketingCategory All');
INSERT INTO `document` VALUES ('5588', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  InActive Affiliate MarketingCategory All');
INSERT INTO `document` VALUES ('5589', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Active Employee MarketingCategory All');
INSERT INTO `document` VALUES ('5590', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  InActive Employee MarketingCategory All');
INSERT INTO `document` VALUES ('5591', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Active Customer MarketingCategory All');
INSERT INTO `document` VALUES ('5592', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  InActive Customer MarketingCategory All');
INSERT INTO `document` VALUES ('5593', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Active Supplier MarketingCategory All');
INSERT INTO `document` VALUES ('5594', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  InActive Supplier MarketingCategory All');
INSERT INTO `document` VALUES ('5595', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  Active OutSourceParty MarketingCategory All');
INSERT INTO `document` VALUES ('5596', '0', 'MarketingCategory', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'All', '  InActive OutSourceParty MarketingCategory All');
INSERT INTO `document` VALUES ('5597', '0', 'Newsletter', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'Draft', '  Empty Newsletter No Content No Content Draft');
INSERT INTO `document` VALUES ('5598', '0', 'Currency', null, null, '2017-05-22 13:20:28', null, '2017-05-22 13:20:28', 'Active', '  Default Currency Currency Active');

-- ----------------------------
-- Table structure for `document_share`
-- ----------------------------
DROP TABLE IF EXISTS `document_share`;
CREATE TABLE `document_share` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `shared_by_id` int(11) NOT NULL,
  `shared_to_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `shared_type` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `can_edit` tinyint(4) DEFAULT NULL,
  `can_delete` tinyint(4) DEFAULT NULL,
  `can_share` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Folder id` (`folder_id`) USING BTREE,
  KEY `File id` (`file_id`) USING BTREE,
  KEY `department` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of document_share
-- ----------------------------

-- ----------------------------
-- Table structure for `emails`
-- ----------------------------
DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of emails
-- ----------------------------

-- ----------------------------
-- Table structure for `emailsetting`
-- ----------------------------
DROP TABLE IF EXISTS `emailsetting`;
CREATE TABLE `emailsetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `created_by_id` varchar(255) NOT NULL,
  `email_transport` varchar(255) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `email_port` varchar(244) DEFAULT NULL,
  `email_username` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `email_reply_to` varchar(255) DEFAULT NULL,
  `email_reply_to_name` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `smtp_auto_reconnect` int(11) DEFAULT NULL,
  `email_threshold` int(11) DEFAULT NULL,
  `emails_in_BCC` int(11) DEFAULT NULL,
  `last_emailed_at` datetime DEFAULT NULL,
  `email_sent_in_this_minute` int(11) DEFAULT NULL,
  `bounce_imap_email_host` varchar(255) DEFAULT NULL,
  `bounce_imap_email_port` varchar(255) DEFAULT NULL,
  `return_path` varchar(255) DEFAULT NULL,
  `bounce_imap_email_password` varchar(255) DEFAULT NULL,
  `bounce_imap_flags` varchar(255) DEFAULT NULL,
  `is_support_email` tinyint(4) DEFAULT NULL,
  `imap_email_host` varchar(255) DEFAULT NULL,
  `imap_email_port` varchar(255) DEFAULT NULL,
  `imap_email_username` varchar(255) DEFAULT NULL,
  `imap_email_password` varchar(255) DEFAULT NULL,
  `imap_flags` varchar(255) DEFAULT NULL,
  `auto_reply` tinyint(4) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_body` longtext,
  `denied_email_subject` varchar(255) DEFAULT NULL,
  `denied_email_body` text,
  `footer` text,
  `is_imap_enabled` tinyint(4) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mass_mail` tinyint(4) unsigned DEFAULT NULL,
  `signature` text,
  `email_threshold_per_month` int(11) DEFAULT NULL,
  `last_email_fetched_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of emailsetting
-- ----------------------------

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `contact_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `notified_till` int(11) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_date` date DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `leaving_date` date DEFAULT NULL,
  `attandance_mode` varchar(255) DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `finacial_permit_limit` int(11) DEFAULT NULL,
  `remark` longtext,
  `graphical_report_id` int(11) DEFAULT NULL,
  `salary_payment_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_contact1_idx` (`contact_id`),
  KEY `fk_employee_post1_idx` (`post_id`),
  KEY `department_id` (`department_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('142438', '5585', '5584', '0', '59', null, '2017-05-22', null, null, 'Web Login', null, null, null, null, null, 'monthly');

-- ----------------------------
-- Table structure for `employee_app_associations`
-- ----------------------------
DROP TABLE IF EXISTS `employee_app_associations`;
CREATE TABLE `employee_app_associations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `installed_app_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employee_app_associations
-- ----------------------------

-- ----------------------------
-- Table structure for `employee_attandance`
-- ----------------------------
DROP TABLE IF EXISTS `employee_attandance`;
CREATE TABLE `employee_attandance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `is_holiday` tinyint(4) DEFAULT NULL,
  `working_unit_count` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_index` (`employee_id`,`from_date`),
  KEY `employee_id_index` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3384 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employee_attandance
-- ----------------------------
INSERT INTO `employee_attandance` VALUES ('3381', '142438', '2017-05-22 09:23:52', null, '1', '1');
INSERT INTO `employee_attandance` VALUES ('3382', '142438', '2017-06-06 12:56:26', null, '1', '1');
INSERT INTO `employee_attandance` VALUES ('3383', '142438', '2017-06-07 07:36:29', null, '1', '1');

-- ----------------------------
-- Table structure for `employee_documents`
-- ----------------------------
DROP TABLE IF EXISTS `employee_documents`;
CREATE TABLE `employee_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `employee_document_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_document_id` (`employee_document_id`) USING BTREE,
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee_documents
-- ----------------------------

-- ----------------------------
-- Table structure for `employee_leave`
-- ----------------------------
DROP TABLE IF EXISTS `employee_leave`;
CREATE TABLE `employee_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by_id` int(11) DEFAULT NULL,
  `emp_leave_allow_id` int(11) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employee_leave
-- ----------------------------

-- ----------------------------
-- Table structure for `employee_leave_allow`
-- ----------------------------
DROP TABLE IF EXISTS `employee_leave_allow`;
CREATE TABLE `employee_leave_allow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `leave_id` int(11) DEFAULT NULL,
  `is_yearly_carried_forward` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_unit_carried_forward` tinyint(4) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `allow_over_quota` tinyint(4) DEFAULT NULL,
  `no_of_leave` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employee_leave_allow
-- ----------------------------

-- ----------------------------
-- Table structure for `employee_movement`
-- ----------------------------
DROP TABLE IF EXISTS `employee_movement`;
CREATE TABLE `employee_movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `movement_at` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `narration` text,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9917 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee_movement
-- ----------------------------
INSERT INTO `employee_movement` VALUES ('9914', '142438', '2017-05-22 09:23:52', null, 'In', null, null);
INSERT INTO `employee_movement` VALUES ('9915', '142438', '2017-06-06 12:56:26', null, 'In', null, null);
INSERT INTO `employee_movement` VALUES ('9916', '142438', '2017-06-07 07:36:29', null, 'In', null, null);

-- ----------------------------
-- Table structure for `employee_row`
-- ----------------------------
DROP TABLE IF EXISTS `employee_row`;
CREATE TABLE `employee_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_abstract_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,4) DEFAULT NULL,
  `presents` int(11) DEFAULT NULL,
  `paid_leaves` int(11) DEFAULT NULL,
  `unpaid_leaves` int(11) DEFAULT NULL,
  `absents` int(11) DEFAULT NULL,
  `paiddays` int(11) DEFAULT NULL,
  `total_working_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of employee_row
-- ----------------------------

-- ----------------------------
-- Table structure for `employee_salary`
-- ----------------------------
DROP TABLE IF EXISTS `employee_salary`;
CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of employee_salary
-- ----------------------------

-- ----------------------------
-- Table structure for `epan`
-- ----------------------------
DROP TABLE IF EXISTS `epan`;
CREATE TABLE `epan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `type` varchar(5) DEFAULT NULL,
  `xepan_template_id` int(11) DEFAULT NULL,
  `valid_till` datetime DEFAULT NULL,
  `is_published` varchar(255) DEFAULT NULL,
  `extra_info` text,
  `aliases` text,
  `epan_dbversion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_category_id` (`epan_category_id`),
  CONSTRAINT `fk_epan_category_id` FOREIGN KEY (`epan_category_id`) REFERENCES `epan_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epan
-- ----------------------------
INSERT INTO `epan` VALUES ('68', '2', 'ds', 'Trial', null, '2017-05-22 13:20:28', 'Epan', null, null, null, null, null, '170');

-- ----------------------------
-- Table structure for `epan_category`
-- ----------------------------
DROP TABLE IF EXISTS `epan_category`;
CREATE TABLE `epan_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epan_category
-- ----------------------------
INSERT INTO `epan_category` VALUES ('2', 'default');

-- ----------------------------
-- Table structure for `epan_config`
-- ----------------------------
DROP TABLE IF EXISTS `epan_config`;
CREATE TABLE `epan_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `head` varchar(255) DEFAULT NULL,
  `value` longtext,
  `application` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of epan_config
-- ----------------------------
INSERT INTO `epan_config` VALUES ('83', null, 'ADMIN_LOGIN_RELATED_EMAIL', '{\"592298ad60eac\":{\"reset_subject\":\"Password Reset Request\",\"reset_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"Logo\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/da82434c-a7ab-4271-b88d-42173fb7e58e\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Password Reset Request<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">{$username},<br\\/>We received a request to reset the password for your account.<br\\/>Here\'s a one-time login link for you to use to access your account and set a new password. Click on the below button to proceed.  <br\\/>This link will expire after a day and nothing will happen if it\'s not used.<br\\/>See you!<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\">\\n                                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" class=\\\"mobile-button-container\\\">\\n                                  <tbody>\\n                                    <tr>\\n                                      <td style=\\\"border-radius: 3px;\\\" align=\\\"center\\\" bgcolor=\\\"#256F9C\\\"><a href=\\\"{$click_here}\\\" target=\\\"_blank\\\" style=\\\"font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;\\\" class=\\\"mobile-button\\\">Click Here \\u2192<\\/a><\\/td>\\n                                    <\\/tr>\\n                                  <\\/tbody>\\n                                <\\/table>\\n                              <\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.in\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\",\"update_subject\":\"Password Update\",\"update_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"Logo\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/da82434c-a7ab-4271-b88d-42173fb7e58e\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Password Updated<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Hi {$username},<br\\/>Your password has been successfully updated.<br\\/>If you are not the person who changed the password, please report it<br\\/>to superuser\\/authority and make sure to reset your password again.<br\\/><strong>Note: Don\'t share your password with anybody.<\\/strong><br\\/><br\\/>Greetings!<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\"><\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.in\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\"}}', 'communication');
INSERT INTO `epan_config` VALUES ('84', null, 'FRONTEND_LOGIN_RELATED_EMAIL', '{\"592298b2ded00\":{\"user_registration_type\":\"self_activated\",\"registration_subject\":\"Registration mail\",\"registration_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"xEpan\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/c55f4326-1714-47eb-9fd0-2f47ee8cf798\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">It\'s Great To Have You<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Dear member,<br\\/>Thank you for registering. {$email_id}! It\\u2019s great to have you in the community.<br\\/>Before you can take advantage of all the great features your account comes with, you\\u2019ll need to verify your email address. <br\\/>Click the button below to verify your email and experience the best.<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\">\\n                                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" class=\\\"mobile-button-container\\\">\\n                                  <tbody>\\n                                    <tr>\\n                                      <td style=\\\"border-radius: 3px;\\\" align=\\\"center\\\" bgcolor=\\\"#256F9C\\\"><a href=\\\"{$url}\\\" target=\\\"_blank\\\" style=\\\"font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;\\\" class=\\\"mobile-button\\\">Click Here \\u2192<\\/a><\\/td>\\n                                    <\\/tr>\\n                                  <\\/tbody>\\n                                <\\/table>\\n                              <\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.i\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\",\"reset_subject\":\"Reset password\",\"reset_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"xEpan\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/da82434c-a7ab-4271-b88d-42173fb7e58e\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Password Reset Request<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">{$username},<br\\/>We received a request to reset the password for your account.<br\\/>Here\'s a one-time login link for you to use to access your account and set a new password. Click on the below button to proceed.  <br\\/>This link will expire after a day and nothing will happen if it\'s not used.<br\\/>See you!<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\">\\n                                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" class=\\\"mobile-button-container\\\">\\n                                  <tbody>\\n                                    <tr>\\n                                      <td style=\\\"border-radius: 3px;\\\" align=\\\"center\\\" bgcolor=\\\"#256F9C\\\"><a href=\\\"{$url}\\\" target=\\\"_blank\\\" style=\\\"font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;\\\" class=\\\"mobile-button\\\">Click Here \\u2192<\\/a><\\/td>\\n                                    <\\/tr>\\n                                  <\\/tbody>\\n                                <\\/table>\\n                              <\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.i\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\",\"verification_subject\":\"Account validated\",\"verification_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"xEpan\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/da82434c-a7ab-4271-b88d-42173fb7e58e\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Account Validated<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">{$username},<br\\/>Your account has been successfully validated.<br\\/>Now you can enjoy the services by just logging in your account.<br\\/>Don\'t forgot to try before you buy a service ! We provide <strong>14 day free<\\/strong><strong>trial.<br\\/><\\/strong><br\\/>Greetings!<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\"><\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.in\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\",\"update_subject\":\"Password updated\",\"update_body\":\"\\n<style type=\\\"text\\/css\\\">\\n  <!--\\n  \\/* CLIENT-SPECIFIC STYLES *\\/\\n  body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;} \\/* Prevent WebKit and Windows mobile changing default text sizes *\\/\\n  table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;} \\/* Remove spacing between tables in Outlook 2007 and up *\\/\\n  img{-ms-interpolation-mode: bicubic;} \\/* Allow smoother rendering of resized image in Internet Explorer *\\/\\n  \\/* RESET STYLES *\\/\\n  img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none;}\\n  table{border-collapse: collapse !important;}\\n  body{height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}\\n  \\/* iOS BLUE LINKS *\\/\\n  a[x-apple-data-detectors] {\\n  color: inherit !important;\\n  text-decoration: none !important;\\n  font-size: inherit !important;\\n  font-family: inherit !important;\\n  font-weight: inherit !important;\\n  line-height: inherit !important;\\n  }\\n  \\/* MOBILE STYLES *\\/\\n  @media screen and (max-width: 525px) {\\n  \\/* ALLOWS FOR FLUID TABLES *\\/\\n  .wrapper {\\n  width: 100% !important;\\n  max-width: 100% !important;\\n  }\\n  \\/* ADJUSTS LAYOUT OF LOGO IMAGE *\\/\\n  .logo img {\\n  margin: 0 auto !important;\\n  }\\n  \\/* USE THESE CLASSES TO HIDE CONTENT ON MOBILE *\\/\\n  .mobile-hide {\\n  display: none !important;\\n  }\\n  .img-max {\\n  max-width: 100% !important;\\n  width: 100% !important;\\n  height: auto !important;\\n  }\\n  \\/* FULL-WIDTH TABLES *\\/\\n  .responsive-table {\\n  width: 100% !important;\\n  }\\n  \\/* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE *\\/\\n  .padding {\\n  padding: 10px 5% 15px 5% !important;\\n  }\\n  .padding-meta {\\n  padding: 30px 5% 0px 5% !important;\\n  text-align: center;\\n  }\\n  .padding-copy {\\n  padding: 10px 5% 10px 5% !important;\\n  text-align: center;\\n  }\\n  .no-padding {\\n  padding: 0 !important;\\n  }\\n  .section-padding {\\n  padding: 50px 15px 50px 15px !important;\\n  }\\n  \\/* ADJUST BUTTONS ON MOBILE *\\/\\n  .mobile-button-container {\\n  margin: 0 auto;\\n  width: 100% !important;\\n  }\\n  .mobile-button {\\n  padding: 15px !important;\\n  border: 0 !important;\\n  font-size: 16px !important;\\n  display: block !important;\\n  }\\n  }\\n  \\/* ANDROID CENTER FIX *\\/\\n  div[style*=\\\"margin: 16px 0;\\\"] { margin: 0 !important; }\\n  -->\\n<\\/style>\\n<!--if gte mso 12\\nstyle(type=\'text\\/css\').\\n  .mso-right {\\n  padding-left: 20px;\\n  }\\n-->\\n<!-- HIDDEN PREHEADER TEXT-->\\n<div style=\\\"display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;\\\"><\\/div>\\n<!-- HEADER-->\\n<table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n  <tbody>\\n    <tr style=\\\"height: 165px;\\\">\\n      <td style=\\\"height: 165px;\\\" align=\\\"center\\\" bgcolor=\\\"#34495E\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <table style=\\\"max-width: 500px;\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"wrapper\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"padding: 15px 0;\\\" align=\\\"center\\\" valign=\\\"top\\\" class=\\\"logo\\\"><a href=\\\"#\\\" target=\\\"_blank\\\"><img caption=\\\"false\\\" alt=\\\"xEpan\\\" src=\\\"blob:http:\\/\\/192.168.1.101\\/da82434c-a7ab-4271-b88d-42173fb7e58e\\\" style=\\\"display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;\\\" border=\\\"0\\\" height=\\\"120\\\" width=\\\"180\\\"\\/><\\/a><\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 10px;\\\">\\n      <td style=\\\"padding: 70px 15px; height: 10px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\" class=\\\"section-padding\\\">\\n        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"500\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td>\\n                <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                  <tbody>\\n                    <tr>\\n                      <td>\\n                        <!-- COPY-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Password Updated<\\/td>\\n                            <\\/tr>\\n                            <tr>\\n                              <td style=\\\"padding: 20px 0px 0px; font-size: 16px; line-height: 25px; font-family: Helvetica,Arial,sans-serif; color: #666666; text-align: left;\\\" align=\\\"center\\\" class=\\\"padding-copy\\\">Hi {$username},<br\\/>Your password has been successfully updated.<br\\/>If you are not the person who changed the password, please make<br\\/>sure to reset your password again.<br\\/><strong>Note: Don\'t share your password with anybody.<\\/strong><br\\/><br\\/>Greetings!<\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                    <tr>\\n                      <td align=\\\"center\\\">\\n                        <!-- BULLETPROOF BUTTON-->\\n                        <table border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\">\\n                          <tbody>\\n                            <tr>\\n                              <td style=\\\"padding-top: 25px;\\\" align=\\\"center\\\" class=\\\"padding\\\"><\\/td>\\n                            <\\/tr>\\n                          <\\/tbody>\\n                        <\\/table>\\n                      <\\/td>\\n                    <\\/tr>\\n                  <\\/tbody>\\n                <\\/table>\\n              <\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n      <\\/td>\\n    <\\/tr>\\n    <tr style=\\\"height: 20px;\\\">\\n      <td style=\\\"padding: 20px 0px; height: 20px;\\\" align=\\\"center\\\" bgcolor=\\\"#ffffff\\\">\\n        <!--if (gte mso 9)|(IE)\\n        table(align=\'center\', border=\'0\', cellspacing=\'0\', cellpadding=\'0\', width=\'500\')\\n          tr\\n            td(align=\'center\', valign=\'top\', width=\'500\')\\n        -->\\n        <!-- UNSUBSCRIBE COPY-->\\n        <table style=\\\"max-width: 500px;\\\" align=\\\"center\\\" border=\\\"0\\\" cellpadding=\\\"0\\\" cellspacing=\\\"0\\\" width=\\\"100%\\\" class=\\\"responsive-table\\\">\\n          <tbody>\\n            <tr>\\n              <td style=\\\"font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color: #666666;\\\" align=\\\"center\\\">+91-9782300801,  +91-8875191258 <a href=\\\"mailto:support@epan.in|\\\">support@epan.in<\\/a> <a href=\\\"mailto:info@epan.i\\\">info@epan.in<\\/a><br\\/>A Xavoc Technocrats Pvt. Ltd. Product<\\/td>\\n            <\\/tr>\\n          <\\/tbody>\\n        <\\/table>\\n        <!--if (gte mso 9)|(IE)-->\\n      <\\/td>\\n    <\\/tr>\\n  <\\/tbody>\\n<\\/table>\"}}', 'communication');
INSERT INTO `epan_config` VALUES ('85', null, 'FIRM_DEFAULT_CURRENCY_ID', '{\"592298b4e4b0b\":{\"currency_id\":\"5598\"}}', 'accounts');

-- ----------------------------
-- Table structure for `experience`
-- ----------------------------
DROP TABLE IF EXISTS `experience`;
CREATE TABLE `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `company_branch` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of experience
-- ----------------------------

-- ----------------------------
-- Table structure for `file`
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `document_id` int(11) NOT NULL,
  `folder_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `mime` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Folder id` (`folder_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of file
-- ----------------------------

-- ----------------------------
-- Table structure for `filestore_file`
-- ----------------------------
DROP TABLE IF EXISTS `filestore_file`;
CREATE TABLE `filestore_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filestore_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'File type',
  `filestore_volume_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Volume',
  `original_filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Original Name',
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Internal Name',
  `filesize` int(11) NOT NULL DEFAULT '0' COMMENT 'File size',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Deleted file',
  PRIMARY KEY (`id`),
  KEY `fk_filestore_file_filestore_type1_idx` (`filestore_type_id`),
  KEY `fk_filestore_file_filestore_volume1_idx` (`filestore_volume_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5204 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of filestore_file
-- ----------------------------
INSERT INTO `filestore_file` VALUES ('5200', '556', '2', 'dmuscbanner0519R1en-US.jpg', '0/20170522114100_0_dmuscbanner0519r1en-us.jpg', '225887', '0');
INSERT INTO `filestore_file` VALUES ('5201', '556', '2', 'dkorebanner0517en-US.jpg', '0/20170522114118_0_dkorebanner0517en-us.jpg', '322743', '0');
INSERT INTO `filestore_file` VALUES ('5202', '556', '2', 'dlavebanner0517R4en-US.jpg', '0/20170522114127_0_dlavebanner0517r4en-us.jpg', '366047', '0');
INSERT INTO `filestore_file` VALUES ('5203', '556', '2', 'dserubanner0517en-US.jpg', '0/20170522114136_0_dserubanner0517en-us.jpg', '268817', '0');

-- ----------------------------
-- Table structure for `filestore_image`
-- ----------------------------
DROP TABLE IF EXISTS `filestore_image`;
CREATE TABLE `filestore_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Original File',
  `thumb_file_id` int(10) unsigned DEFAULT NULL COMMENT 'Thumbnail file',
  PRIMARY KEY (`id`),
  KEY `fk_filestore_image_filestore_file1_idx` (`original_file_id`),
  KEY `fk_filestore_image_filestore_file2_idx` (`thumb_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of filestore_image
-- ----------------------------

-- ----------------------------
-- Table structure for `filestore_type`
-- ----------------------------
DROP TABLE IF EXISTS `filestore_type`;
CREATE TABLE `filestore_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Name',
  `mime_type` varchar(64) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'MIME type',
  `extension` varchar(5) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Filename extension',
  `allow` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=559 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of filestore_type
-- ----------------------------
INSERT INTO `filestore_type` VALUES ('556', 'JPEG', 'image/jpeg', 'jpeg', '1');
INSERT INTO `filestore_type` VALUES ('557', 'JPG', 'image/jpg', 'jpg', '1');
INSERT INTO `filestore_type` VALUES ('558', 'PNG', 'image/png', 'png', '1');

-- ----------------------------
-- Table structure for `filestore_volume`
-- ----------------------------
DROP TABLE IF EXISTS `filestore_volume`;
CREATE TABLE `filestore_volume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Volume name',
  `dirname` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT 'Folder name',
  `total_space` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Total space (not implemented)',
  `used_space` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Used space (not implemented)',
  `stored_files_cnt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Approximate count of stored files',
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Volume enabled?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of filestore_volume
-- ----------------------------
INSERT INTO `filestore_volume` VALUES ('2', 'upload', '', '0', '0', '4', '1');

-- ----------------------------
-- Table structure for `follower_task_association`
-- ----------------------------
DROP TABLE IF EXISTS `follower_task_association`;
CREATE TABLE `follower_task_association` (
  `task_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`) USING BTREE,
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of follower_task_association
-- ----------------------------

-- ----------------------------
-- Table structure for `freelancer_cat_customer_asso`
-- ----------------------------
DROP TABLE IF EXISTS `freelancer_cat_customer_asso`;
CREATE TABLE `freelancer_cat_customer_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `freelancer_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of freelancer_cat_customer_asso
-- ----------------------------

-- ----------------------------
-- Table structure for `freelancer_category`
-- ----------------------------
DROP TABLE IF EXISTS `freelancer_category`;
CREATE TABLE `freelancer_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of freelancer_category
-- ----------------------------

-- ----------------------------
-- Table structure for `graphical_report`
-- ----------------------------
DROP TABLE IF EXISTS `graphical_report`;
CREATE TABLE `graphical_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `permitted_post` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_system` tinyint(4) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of graphical_report
-- ----------------------------
INSERT INTO `graphical_report` VALUES ('200', 'AccountsReport', null, null, '1', 'Accounts analytical report ');
INSERT INTO `graphical_report` VALUES ('201', 'DepartmentReport', null, null, '1', 'Employees department Performance depending upon task status, system use, hr performance , marketing and other factors');
INSERT INTO `graphical_report` VALUES ('202', 'MarketingReport', null, null, '1', 'Widgets includes : lead vs score count, opportunity graph, communication chart, etc.');
INSERT INTO `graphical_report` VALUES ('203', 'EmployeeReport', null, null, '1', 'consist widgets like employee attendance, task, follow up and performance reports widgets');
INSERT INTO `graphical_report` VALUES ('204', 'GlobalReport', null, null, '1', 'Global Performance depending upon task status, system use, hr performance , marketing and other factors');
INSERT INTO `graphical_report` VALUES ('205', 'MyReport', null, null, '1', 'Individual Employees Performance depending upon task status, system use, hr performance , marketing and other factors');
INSERT INTO `graphical_report` VALUES ('206', 'SalesReport', null, null, '1', 'contains analytics of sales ');

-- ----------------------------
-- Table structure for `graphical_report_widget`
-- ----------------------------
DROP TABLE IF EXISTS `graphical_report_widget`;
CREATE TABLE `graphical_report_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `graphical_report_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `class_path` varchar(255) DEFAULT NULL,
  `col_width` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1378 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of graphical_report_widget
-- ----------------------------
INSERT INTO `graphical_report_widget` VALUES ('1322', '200', 'Monthly Tax Information', 'xepan\\accounts\\Widget_MonthlyTaxes', '12', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1323', '201', 'Department workforce available', 'xepan\\hr\\Widget_DepartmentAvailableWorkforce', '4', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1324', '201', 'Department Average Work Hour', 'xepan\\hr\\Widget_DepartmentAverageWorkHour', '6', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1325', '201', 'Department Employee Attendance', 'xepan\\hr\\Widget_DepartmentEmployeeAttendance', '6', '3', '1');
INSERT INTO `graphical_report_widget` VALUES ('1326', '201', 'Department Late Coming', 'xepan\\hr\\Widget_DepartmentLateComing', '6', '4', '1');
INSERT INTO `graphical_report_widget` VALUES ('1327', '201', 'Department Mass Communication Status', 'xepan\\marketing\\Widget_DepartmentMassCommunication', '6', '5', '1');
INSERT INTO `graphical_report_widget` VALUES ('1328', '201', 'Department communication', 'xepan\\marketing\\Widget_DepartmentCommunication', '6', '6', '1');
INSERT INTO `graphical_report_widget` VALUES ('1329', '201', 'Department Sales Status', 'xepan\\marketing\\Widget_DepartmentSaleStatus', '12', '7', '1');
INSERT INTO `graphical_report_widget` VALUES ('1330', '201', 'Department Accountable System Use', 'xepan\\projects\\Widget_DepartmentAccountableSystemUse', '12', '1000', '1');
INSERT INTO `graphical_report_widget` VALUES ('1331', '202', 'Lead VS Score', 'xepan\\marketing\\Widget_LeadAndScore', '12', '6', '1');
INSERT INTO `graphical_report_widget` VALUES ('1332', '202', 'Return On Investment', 'xepan\\marketing\\Widget_ROI', '4', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1333', '202', 'Opportunity Pipeline', 'xepan\\marketing\\Widget_OpportunityPipeline', '4', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1334', '202', 'Engagement By Channel', 'xepan\\marketing\\Widget_EngagementByChannel', '4', '3', '1');
INSERT INTO `graphical_report_widget` VALUES ('1335', '202', 'Employee Day To Day Communication', 'xepan\\marketing\\Widget_DayByDayCommunication', '12', '5', '1');
INSERT INTO `graphical_report_widget` VALUES ('1336', '202', 'Leads added', 'xepan\\base\\Widget_EmployeeContacts', '12', '7', '1');
INSERT INTO `graphical_report_widget` VALUES ('1337', '202', 'Leads Assigned', 'xepan\\marketing\\Widget_LeadsAssigned', '12', '8', '1');
INSERT INTO `graphical_report_widget` VALUES ('1338', '203', 'Employee Attendance', 'xepan\\hr\\Widget_EmployeeMovement', '6', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1339', '203', 'Employee Average Working Hours', 'xepan\\hr\\Widget_AverageWorkHour', '6', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1340', '203', 'Staff accountable system use', 'xepan\\projects\\Widget_AccountableSystemUse', '12', '5', '1');
INSERT INTO `graphical_report_widget` VALUES ('1341', '203', 'Contacts Added', 'xepan\\base\\Widget_EmployeeContacts', '6', '6', '1');
INSERT INTO `graphical_report_widget` VALUES ('1342', '203', 'Lead Assigned', 'xepan\\marketing\\Widget_LeadsAssigned', '6', '7', '1');
INSERT INTO `graphical_report_widget` VALUES ('1343', '203', 'Sales Status', 'xepan\\marketing\\Widget_SaleStaffStatus', '6', '8', '1');
INSERT INTO `graphical_report_widget` VALUES ('1344', '203', 'Sales Communication', 'xepan\\marketing\\Widget_SaleStaffCommunication', '6', '9', '1');
INSERT INTO `graphical_report_widget` VALUES ('1345', '203', 'Activity', 'xepan\\base\\Widget_EmployeeSpecificActivities', '6', '10', '1');
INSERT INTO `graphical_report_widget` VALUES ('1346', '203', 'Company mass Communication', 'xepan\\marketing\\Widget_GlobalMassCommunication', '6', '11', '1');
INSERT INTO `graphical_report_widget` VALUES ('1347', '203', 'Task', 'xepan\\projects\\Widget_TabularTask', '6', '12', '1');
INSERT INTO `graphical_report_widget` VALUES ('1348', '203', 'Followups', 'xepan\\projects\\Widget_GlobalFollowUps', '6', '13', '1');
INSERT INTO `graphical_report_widget` VALUES ('1349', '203', 'Timesheet', 'xepan\\projects\\Widget_EmployeeTimesheet', '12', '14', '1');
INSERT INTO `graphical_report_widget` VALUES ('1350', '204', 'Employees Attendance', 'xepan\\hr\\Widget_EmployeeMovement', '6', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1351', '204', 'Available Workforce', 'xepan\\hr\\Widget_AvailableWorkforce', '6', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1352', '204', 'Employees average working hours', 'xepan\\hr\\Widget_AverageWorkHour', '6', '3', '1');
INSERT INTO `graphical_report_widget` VALUES ('1353', '204', 'Employees average late arrivals', 'xepan\\hr\\Widget_TotalLateComing', '6', '4', '1');
INSERT INTO `graphical_report_widget` VALUES ('1354', '204', 'Staff accountable system use', 'xepan\\projects\\Widget_AccountableSystemUse', '12', '5', '1');
INSERT INTO `graphical_report_widget` VALUES ('1355', '204', 'Employees Day to Day communication', 'xepan\\marketing\\Widget_DayByDayCommunication', '6', '7', '1');
INSERT INTO `graphical_report_widget` VALUES ('1356', '204', 'Sales Staff Status', 'xepan\\marketing\\Widget_SaleStaffStatus', '6', '8', '1');
INSERT INTO `graphical_report_widget` VALUES ('1357', '204', 'Sales Staff Communication', 'xepan\\marketing\\Widget_SaleStaffCommunication', '6', '9', '1');
INSERT INTO `graphical_report_widget` VALUES ('1358', '204', 'Companies mass communication status', 'xepan\\marketing\\Widget_GlobalMassCommunication', '12', '10', '1');
INSERT INTO `graphical_report_widget` VALUES ('1359', '204', 'Global Activities', 'xepan\\base\\Widget_GlobalActivity', '12', '11', '1');
INSERT INTO `graphical_report_widget` VALUES ('1360', '204', 'Global Followups', 'xepan\\projects\\Widget_GlobalFollowUps', '6', '12', '1');
INSERT INTO `graphical_report_widget` VALUES ('1361', '204', 'Overdue Tasks', 'xepan\\projects\\Widget_OverdueTasks', '6', '13', '1');
INSERT INTO `graphical_report_widget` VALUES ('1362', '205', 'Todays Attendance', 'xepan\\hr\\Widget_MyTodaysAttendance', '4', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1363', '205', 'Pending Tickets', 'xepan\\crm\\Widget_PendingTickets', '1', '9', '1');
INSERT INTO `graphical_report_widget` VALUES ('1364', '205', 'Tasks To Receive', 'xepan\\projects\\Widget_TaskToReceive', '1', '6', '1');
INSERT INTO `graphical_report_widget` VALUES ('1365', '205', 'My Mass Comunication', 'xepan\\marketing\\Widget_MyMassCommunication', '6', '1', '1');
INSERT INTO `graphical_report_widget` VALUES ('1366', '205', 'My average working hours', 'xepan\\hr\\Widget_MyAverageWorkHour', '6', '2', '1');
INSERT INTO `graphical_report_widget` VALUES ('1367', '205', 'My Late Arrivals', 'xepan\\hr\\Widget_MyLateComing', '5', '3', '1');
INSERT INTO `graphical_report_widget` VALUES ('1368', '205', 'Unread mails', 'xepan\\communication\\Widget_UnreadMails', '1', '9', '1');
INSERT INTO `graphical_report_widget` VALUES ('1369', '205', 'My day to day communication', 'xepan\\marketing\\Widget_MyDayByDayCommunication', '5', '4', '1');
INSERT INTO `graphical_report_widget` VALUES ('1370', '205', 'My sales status', 'xepan\\marketing\\Widget_MySaleStatus', '6', '5', '1');
INSERT INTO `graphical_report_widget` VALUES ('1371', '205', 'My Communication Graph', 'xepan\\marketing\\Widget_MyCommunication', '5', '7', '1');
INSERT INTO `graphical_report_widget` VALUES ('1372', '205', 'My Accountable System Use', 'xepan\\projects\\Widget_MyAccountableSystemUse', '12', '10', '1');
INSERT INTO `graphical_report_widget` VALUES ('1373', '205', 'My Activities', 'xepan\\base\\Widget_MyActivity', '12', '11', '1');
INSERT INTO `graphical_report_widget` VALUES ('1374', '205', 'My Tasks', 'xepan\\projects\\Widget_MyTask', '6', '12', '1');
INSERT INTO `graphical_report_widget` VALUES ('1375', '205', 'My Followups', 'xepan\\projects\\Widget_FollowUps', '6', '13', '1');
INSERT INTO `graphical_report_widget` VALUES ('1376', '205', 'My Communications', 'xepan\\hr\\Widget_MyCommunication', '12', '14', '1');
INSERT INTO `graphical_report_widget` VALUES ('1377', '206', 'Monthly Invoices', 'xepan\\commerce\\Widget_MonthlyInvoices', '6', '1', '1');

-- ----------------------------
-- Table structure for `installed_application`
-- ----------------------------
DROP TABLE IF EXISTS `installed_application`;
CREATE TABLE `installed_application` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `installed_on` datetime DEFAULT NULL,
  `valid_till` datetime DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `application_id` (`application_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of installed_application
-- ----------------------------
INSERT INTO `installed_application` VALUES ('12', '68', '13', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('13', '68', '12', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('14', '68', '14', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('15', '68', '15', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('16', '68', '16', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('17', '68', '17', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('18', '68', '18', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('19', '68', '19', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('20', '68', '20', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('21', '68', '21', null, '2017-05-22 13:20:28', '2017-05-22 13:20:28', '1');
INSERT INTO `installed_application` VALUES ('22', '68', '23', null, null, null, '1');

-- ----------------------------
-- Table structure for `invoice_transaction_association`
-- ----------------------------
DROP TABLE IF EXISTS `invoice_transaction_association`;
CREATE TABLE `invoice_transaction_association` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `salesinvoice_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `currency` int(11) DEFAULT NULL,
  `exchange_rate` decimal(10,0) DEFAULT NULL,
  `exchange_amount` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`) USING BTREE,
  KEY `saleinvoice_id` (`salesinvoice_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of invoice_transaction_association
-- ----------------------------

-- ----------------------------
-- Table structure for `ip2location-lite-db11`
-- ----------------------------
DROP TABLE IF EXISTS `ip2location-lite-db11`;
CREATE TABLE `ip2location-lite-db11` (
  `ip_from` int(11) DEFAULT NULL,
  `ip_to` int(11) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of ip2location-lite-db11
-- ----------------------------

-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `document_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `original_price` decimal(14,2) DEFAULT NULL,
  `sale_price` decimal(14,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `description` text,
  `stock_availability` tinyint(4) DEFAULT NULL,
  `show_detail` tinyint(1) DEFAULT NULL,
  `show_price` tinyint(1) DEFAULT NULL,
  `display_sequence` int(11) DEFAULT NULL,
  `is_new` tinyint(1) DEFAULT NULL,
  `is_feature` tinyint(1) DEFAULT NULL,
  `is_mostviewed` tinyint(1) DEFAULT NULL,
  `Item_enquiry_auto_reply` tinyint(1) DEFAULT NULL,
  `is_comment_allow` tinyint(1) DEFAULT NULL,
  `comment_api` varchar(255) DEFAULT NULL,
  `add_custom_button` tinyint(1) DEFAULT NULL,
  `custom_button_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `tags` text,
  `is_designable` tinyint(1) DEFAULT NULL,
  `designs` longtext CHARACTER SET utf8,
  `is_party_publish` tinyint(1) DEFAULT NULL,
  `minimum_order_qty` int(11) DEFAULT NULL,
  `maximum_order_qty` int(11) DEFAULT NULL,
  `qty_unit_id` int(11) DEFAULT NULL,
  `is_attachment_allow` tinyint(1) DEFAULT NULL,
  `is_saleable` tinyint(1) DEFAULT NULL,
  `is_downloadable` tinyint(1) DEFAULT NULL,
  `is_rentable` tinyint(1) DEFAULT NULL,
  `is_enquiry_allow` tinyint(1) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT NULL,
  `negative_qty_allowed` varchar(255) DEFAULT NULL,
  `is_visible_sold` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_admin` tinyint(1) DEFAULT NULL,
  `watermark_position` varchar(255) DEFAULT NULL,
  `watermark_opacity` varchar(255) DEFAULT NULL,
  `qty_from_set_only` tinyint(1) DEFAULT NULL,
  `custom_button_label` varchar(255) DEFAULT NULL,
  `is_servicable` tinyint(1) DEFAULT NULL,
  `is_purchasable` tinyint(1) DEFAULT NULL,
  `maintain_inventory` tinyint(1) DEFAULT NULL,
  `website_display` tinyint(1) DEFAULT NULL,
  `allow_negative_stock` tinyint(1) DEFAULT NULL,
  `is_productionable` tinyint(1) DEFAULT NULL,
  `warranty_days` int(11) DEFAULT NULL,
  `terms_and_conditions` text,
  `watermark_text` varchar(255) DEFAULT NULL,
  `duplicate_from_item_id` varchar(255) DEFAULT NULL,
  `is_allowuploadable` tinyint(1) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designer_id` int(11) DEFAULT NULL,
  `is_dispatchable` tinyint(1) DEFAULT NULL,
  `item_specific_upload_hint` text,
  `upload_file_label` text,
  `to_customer_id` int(11) DEFAULT NULL,
  `weight` decimal(10,0) DEFAULT NULL,
  `quantity_group` varchar(255) DEFAULT NULL,
  `upload_file_group` varchar(255) DEFAULT NULL,
  `is_renewable` tinyint(4) DEFAULT NULL,
  `remind_to` varchar(255) DEFAULT NULL,
  `renewable_value` int(11) DEFAULT NULL,
  `renewable_unit` varchar(255) DEFAULT NULL,
  `is_teller_made_item` tinyint(4) DEFAULT NULL,
  `minimum_stock_limit` int(11) DEFAULT NULL,
  `is_serializable` tinyint(4) DEFAULT NULL,
  `nominal_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `duplicate_from_item_id` (`duplicate_from_item_id`) USING BTREE,
  KEY `to_customer_id` (`to_customer_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------

-- ----------------------------
-- Table structure for `item_department_association`
-- ----------------------------
DROP TABLE IF EXISTS `item_department_association`;
CREATE TABLE `item_department_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `can_redefine_qty` tinyint(4) NOT NULL,
  `can_redefine_item` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_department_association
-- ----------------------------

-- ----------------------------
-- Table structure for `item_department_consumption`
-- ----------------------------
DROP TABLE IF EXISTS `item_department_consumption`;
CREATE TABLE `item_department_consumption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `composition_item_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `custom_fields` longtext,
  `item_department_association_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `composition_item_id` (`composition_item_id`) USING BTREE,
  KEY `item_department_association_id` (`item_department_association_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_department_consumption
-- ----------------------------

-- ----------------------------
-- Table structure for `item_department_consumptionconstraint`
-- ----------------------------
DROP TABLE IF EXISTS `item_department_consumptionconstraint`;
CREATE TABLE `item_department_consumptionconstraint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_department_consumption_id` int(11) NOT NULL,
  `item_customfield_asso_id` int(11) NOT NULL,
  `item_customfield_value_id` int(11) NOT NULL,
  `item_customfield_id` int(11) NOT NULL,
  `item_customfield_name` varchar(255) NOT NULL,
  `item_customfield_value_name` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_department_consumptionconstraint
-- ----------------------------

-- ----------------------------
-- Table structure for `item_image`
-- ----------------------------
DROP TABLE IF EXISTS `item_image`;
CREATE TABLE `item_image` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `customfield_value_id` int(11) DEFAULT NULL,
  `title` text,
  `alt_text` text,
  `auto_generated` tinyint(4) DEFAULT NULL,
  `sequence_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `file_id` (`file_id`) USING BTREE,
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `custom_field_value_id` (`customfield_value_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_image
-- ----------------------------

-- ----------------------------
-- Table structure for `item_serial`
-- ----------------------------
DROP TABLE IF EXISTS `item_serial`;
CREATE TABLE `item_serial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `is_return` tinyint(4) DEFAULT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `purchase_invoice_id` int(11) DEFAULT NULL,
  `sale_order_id` int(11) DEFAULT NULL,
  `sale_invoice_id` int(11) DEFAULT NULL,
  `dispatch_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `is_available` tinyint(4) DEFAULT NULL,
  `narration` text,
  `qsp_detail_id` int(11) DEFAULT NULL,
  `purchase_order_detail_id` int(11) DEFAULT NULL,
  `purchase_invoice_detail_id` int(11) DEFAULT NULL,
  `sale_order_detail_id` int(11) DEFAULT NULL,
  `sale_invoice_detail_id` int(11) DEFAULT NULL,
  `transaction_row_id` int(11) DEFAULT NULL,
  `dispatch_row_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_serial
-- ----------------------------

-- ----------------------------
-- Table structure for `item_template_design`
-- ----------------------------
DROP TABLE IF EXISTS `item_template_design`;
CREATE TABLE `item_template_design` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `last_modified` date DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `designs` longtext,
  `contact_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE,
  KEY `contact_id` (`contact_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item_template_design
-- ----------------------------

-- ----------------------------
-- Table structure for `jobcard`
-- ----------------------------
DROP TABLE IF EXISTS `jobcard`;
CREATE TABLE `jobcard` (
  `document_id` int(11) DEFAULT NULL,
  `outsourceparty_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `department_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `parent_jobcard_id` int(11) DEFAULT NULL,
  `assign_to_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `outsource_party_id` (`outsourceparty_id`) USING BTREE,
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `oreder_item_id` (`order_item_id`) USING BTREE,
  KEY `parent_jobcard_id` (`parent_jobcard_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jobcard
-- ----------------------------

-- ----------------------------
-- Table structure for `jobcard_detail`
-- ----------------------------
DROP TABLE IF EXISTS `jobcard_detail`;
CREATE TABLE `jobcard_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` decimal(10,4) DEFAULT NULL,
  `parent_detail_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `jobcard_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_detail_id` (`parent_detail_id`) USING BTREE,
  KEY `jobcard_id` (`jobcard_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jobcard_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `landingresponse`
-- ----------------------------
DROP TABLE IF EXISTS `landingresponse`;
CREATE TABLE `landingresponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `emailsetting_id` int(11) DEFAULT NULL,
  `social_user_id` int(11) DEFAULT NULL,
  `referrersite` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`) USING BTREE,
  KEY `lead_id` (`contact_id`) USING BTREE,
  KEY `opportunity_id` (`opportunity_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of landingresponse
-- ----------------------------

-- ----------------------------
-- Table structure for `lead`
-- ----------------------------
DROP TABLE IF EXISTS `lead`;
CREATE TABLE `lead` (
  `contact_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `fk_lead_contact1_idx` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lead
-- ----------------------------

-- ----------------------------
-- Table structure for `lead_category_association`
-- ----------------------------
DROP TABLE IF EXISTS `lead_category_association`;
CREATE TABLE `lead_category_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `marketing_category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lead_id_3` (`lead_id`,`marketing_category_id`),
  KEY `lead_id` (`lead_id`),
  KEY `marketing_category_id` (`marketing_category_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of lead_category_association
-- ----------------------------

-- ----------------------------
-- Table structure for `lead_category_association_1`
-- ----------------------------
DROP TABLE IF EXISTS `lead_category_association_1`;
CREATE TABLE `lead_category_association_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) NOT NULL,
  `marketing_category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_id` (`lead_id`) USING BTREE,
  KEY `marketing_category_id` (`marketing_category_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lead_category_association_1
-- ----------------------------

-- ----------------------------
-- Table structure for `leave_template`
-- ----------------------------
DROP TABLE IF EXISTS `leave_template`;
CREATE TABLE `leave_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of leave_template
-- ----------------------------

-- ----------------------------
-- Table structure for `leave_template_detail`
-- ----------------------------
DROP TABLE IF EXISTS `leave_template_detail`;
CREATE TABLE `leave_template_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_template_id` int(11) DEFAULT NULL,
  `leave_id` int(11) DEFAULT NULL,
  `is_yearly_carried_forward` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_unit_carried_forward` tinyint(4) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `allow_over_quota` tinyint(4) DEFAULT NULL,
  `no_of_leave` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of leave_template_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `leaves`
-- ----------------------------
DROP TABLE IF EXISTS `leaves`;
CREATE TABLE `leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `is_yearly_carried_forward` tinyint(4) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_unit_carried_forward` tinyint(4) DEFAULT NULL,
  `no_of_leave` decimal(10,0) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `allow_over_quota` tinyint(4) DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of leaves
-- ----------------------------

-- ----------------------------
-- Table structure for `ledger`
-- ----------------------------
DROP TABLE IF EXISTS `ledger`;
CREATE TABLE `ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ledger_type` varchar(255) DEFAULT NULL,
  `LedgerDisplayName` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `OpeningBalanceDr` double DEFAULT NULL,
  `OpeningBalanceCr` double DEFAULT NULL,
  `affectsBalanceSheet` tinyint(4) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `related_id` (`related_id`) USING BTREE,
  FULLTEXT KEY `search_string` (`name`,`ledger_type`,`LedgerDisplayName`)
) ENGINE=InnoDB AUTO_INCREMENT=395 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ledger
-- ----------------------------
INSERT INTO `ledger` VALUES ('371', null, '244', 'Miscellaneous Expenses', 'Expenses', 'Miscellaneous Expenses', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('372', null, '232', 'Sales Account', 'Sales', 'Sales Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('373', null, '229', 'Purchase Account', 'Purchase', 'Purchase Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('374', null, '252', 'Round Account', 'Income', 'Round Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('375', null, '175', 'Tax Account', 'Tax', 'Tax Name', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('376', null, '237', 'Rebate & Discount Allowed', 'Discount', 'Discount Allowed', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('377', null, '248', 'Rebate & Discount Received', 'Discount', 'Discount Received', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('378', null, '245', 'Shipping Account', 'Expenses', 'Shipping Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('379', null, '246', 'Exchange Rate Different Loss', 'Expenses', 'Exchange Loss', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('380', null, '253', 'Exchange Rate Different Gain', 'Income', 'Exchange Gain', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('381', null, '247', 'Bank Charges', 'Bank Charges', 'Bank Charges', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('382', null, '222', 'Cash Account', 'Cash Account', 'Cash Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('383', null, '220', 'Your Default Bank Account', 'Bank', 'Your Default Bank Account', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('384', null, '254', 'Profit & Loss (Opening)', 'Profit & Loss (Opening)', 'Profit & Loss (Opening)', '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('385', null, '239', 'Salary', 'Salary', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('386', null, '152', 'Employee PF', 'Provision Fund', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('387', null, '152', 'ESIC', 'Provision Fund', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('388', null, '152', 'Employer PF', 'Provision Fund', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('389', null, '255', 'Reimbursement To Employees', 'Reimbursement(Legal Expenses)', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('390', null, '243', 'Interest On OD', 'Expenses Type', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('391', null, '128', 'Capital Account', 'Capital Account', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('392', null, '256', 'Deduction From Employees', 'Deduction From Employees', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('393', null, '145', 'Outstanding Expenses', 'Outstanding Expenses', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);
INSERT INTO `ledger` VALUES ('394', null, '176', 'SalaryProvision', 'Salary Provision', null, '1', '0', '0', '1', '2017-05-22', '2017-05-22', null, null, null);

-- ----------------------------
-- Table structure for `lodgement`
-- ----------------------------
DROP TABLE IF EXISTS `lodgement`;
CREATE TABLE `lodgement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,0) DEFAULT NULL,
  `currency` decimal(10,0) DEFAULT NULL,
  `exchange_rate` decimal(10,0) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `account_transaction_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_transaction_id` (`account_transaction_id`) USING BTREE,
  KEY `salesinvoice_id` (`invoice_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lodgement
-- ----------------------------

-- ----------------------------
-- Table structure for `marketingcampaign_socialconfig`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcampaign_socialconfig`;
CREATE TABLE `marketingcampaign_socialconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_app` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `appId` text,
  `secret` text,
  `post_in_groups` tinyint(1) DEFAULT NULL,
  `filter_repeated_posts` tinyint(1) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_by_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketingcampaign_socialconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `marketingcampaign_socialpostings`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcampaign_socialpostings`;
CREATE TABLE `marketingcampaign_socialpostings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `post_type` varchar(255) DEFAULT NULL,
  `postid_returned` varchar(255) DEFAULT NULL,
  `posted_on` datetime DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `likes` varchar(255) DEFAULT NULL,
  `share` varchar(255) DEFAULT NULL,
  `is_monitoring` tinyint(1) DEFAULT NULL,
  `force_monitor` tinyint(1) DEFAULT NULL,
  `return_data` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_campaign_id` (`campaign_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketingcampaign_socialpostings
-- ----------------------------

-- ----------------------------
-- Table structure for `marketingcampaign_socialpostings_activities`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcampaign_socialpostings_activities`;
CREATE TABLE `marketingcampaign_socialpostings_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posting_id` int(11) DEFAULT NULL,
  `activityid_returned` varchar(255) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_on` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `activity_by` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action_allowed` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posting_id` (`posting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketingcampaign_socialpostings_activities
-- ----------------------------

-- ----------------------------
-- Table structure for `marketingcampaign_socialusers`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcampaign_socialusers`;
CREATE TABLE `marketingcampaign_socialusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `access_token` text,
  `access_token_secret` text,
  `access_token_expiry` datetime DEFAULT NULL,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `config_id` int(11) DEFAULT NULL,
  `extra` longtext,
  `post_on_pages` tinyint(4) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `post_on_timeline` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_config_id` (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketingcampaign_socialusers
-- ----------------------------

-- ----------------------------
-- Table structure for `marketingcategory`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcategory`;
CREATE TABLE `marketingcategory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `system` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of marketingcategory
-- ----------------------------
INSERT INTO `marketingcategory` VALUES ('585', 'Default', '5586', '1');
INSERT INTO `marketingcategory` VALUES ('586', 'Active Affiliate', '5587', '1');
INSERT INTO `marketingcategory` VALUES ('587', 'InActive Affiliate', '5588', '1');
INSERT INTO `marketingcategory` VALUES ('588', 'Active Employee', '5589', '1');
INSERT INTO `marketingcategory` VALUES ('589', 'InActive Employee', '5590', '1');
INSERT INTO `marketingcategory` VALUES ('590', 'Active Customer', '5591', '1');
INSERT INTO `marketingcategory` VALUES ('591', 'InActive Customer', '5592', '1');
INSERT INTO `marketingcategory` VALUES ('592', 'Active Supplier', '5593', '1');
INSERT INTO `marketingcategory` VALUES ('593', 'InActive Supplier', '5594', '1');
INSERT INTO `marketingcategory` VALUES ('594', 'Active OutSourceParty', '5595', '1');
INSERT INTO `marketingcategory` VALUES ('595', 'InActive OutSourceParty', '5596', '1');

-- ----------------------------
-- Table structure for `marketingcategory_1`
-- ----------------------------
DROP TABLE IF EXISTS `marketingcategory_1`;
CREATE TABLE `marketingcategory_1` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `system` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of marketingcategory_1
-- ----------------------------

-- ----------------------------
-- Table structure for `mlm_distributor`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mlm_distributor
-- ----------------------------

-- ----------------------------
-- Table structure for `mlm_generation_business`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_generation_business`;
CREATE TABLE `mlm_generation_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) DEFAULT NULL,
  `introduced_id` int(11) DEFAULT NULL,
  `introduced_path` text,
  `bv_sum` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mlm_generation_business
-- ----------------------------

-- ----------------------------
-- Table structure for `mlm_kit`
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mlm_kit
-- ----------------------------

-- ----------------------------
-- Table structure for `mlm_kit_item_asso`
-- ----------------------------
DROP TABLE IF EXISTS `mlm_kit_item_asso`;
CREATE TABLE `mlm_kit_item_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mlm_kit_id` int(11) DEFAULT NULL,
  `mlm_item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mlm_kit_item_asso
-- ----------------------------

-- ----------------------------
-- Table structure for `official_holiday`
-- ----------------------------
DROP TABLE IF EXISTS `official_holiday`;
CREATE TABLE `official_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of official_holiday
-- ----------------------------

-- ----------------------------
-- Table structure for `opportunity`
-- ----------------------------
DROP TABLE IF EXISTS `opportunity`;
CREATE TABLE `opportunity` (
  `document_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `lead_id` int(11) NOT NULL,
  `description` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_to_id` int(11) DEFAULT NULL,
  `fund` decimal(14,0) NOT NULL,
  `discount_percentage` int(11) DEFAULT NULL,
  `closing_date` datetime NOT NULL,
  `narration` text,
  `previous_status` varchar(255) NOT NULL,
  `probability_percentage` decimal(14,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `lead_id` (`lead_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of opportunity
-- ----------------------------

-- ----------------------------
-- Table structure for `order_item_departmental_status`
-- ----------------------------
DROP TABLE IF EXISTS `order_item_departmental_status`;
CREATE TABLE `order_item_departmental_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qsp_detail_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_open` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `qsp_detail_id` (`qsp_detail_id`) USING BTREE,
  KEY `department_id` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_item_departmental_status
-- ----------------------------

-- ----------------------------
-- Table structure for `outsource_party`
-- ----------------------------
DROP TABLE IF EXISTS `outsource_party`;
CREATE TABLE `outsource_party` (
  `contact_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `pan_it_no` varchar(255) NOT NULL,
  `tin_no` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `account_no` int(11) NOT NULL,
  `os_country` varchar(135) NOT NULL,
  `time` datetime NOT NULL,
  `os_address` text NOT NULL,
  `department_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `os_city` varchar(255) NOT NULL,
  `os_state` varchar(255) DEFAULT NULL,
  `os_pincode` varchar(255) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `department_id` (`department_id`) USING BTREE,
  KEY `currency_id` (`currency_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of outsource_party
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_gateway`
-- ----------------------------
DROP TABLE IF EXISTS `payment_gateway`;
CREATE TABLE `payment_gateway` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `default_parameters` text,
  `parameters` text,
  `processing` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `gateway_image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_image_id` (`gateway_image_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_gateway
-- ----------------------------

-- ----------------------------
-- Table structure for `point_system`
-- ----------------------------
DROP TABLE IF EXISTS `point_system`;
CREATE TABLE `point_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) DEFAULT NULL,
  `rule_option_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `score` decimal(10,0) DEFAULT NULL,
  `landing_campaign_id` int(11) DEFAULT NULL,
  `landing_content_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `landing_campaign_id` (`landing_campaign_id`) USING BTREE,
  KEY `landing_content_id` (`landing_content_id`) USING BTREE,
  KEY `created_at` (`created_at`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of point_system
-- ----------------------------

-- ----------------------------
-- Table structure for `post`
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `document_id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_post_id` int(11) DEFAULT NULL,
  `in_time` time NOT NULL,
  `out_time` time NOT NULL,
  `salary_template_id` int(11) DEFAULT NULL,
  `leave_template_id` int(11) DEFAULT NULL,
  `permission_level` varchar(255) DEFAULT NULL,
  `finacial_permit_limit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_department1_idx` (`department_id`),
  KEY `parent_post_id` (`parent_post_id`) USING BTREE,
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('5585', 'CEO', '5584', '34', null, '10:00:00', '18:00:00', null, null, 'Individual', null);

-- ----------------------------
-- Table structure for `post_email_association`
-- ----------------------------
DROP TABLE IF EXISTS `post_email_association`;
CREATE TABLE `post_email_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `emailsetting_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`) USING BTREE,
  KEY `email_settings_id` (`emailsetting_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of post_email_association
-- ----------------------------

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `actual_completion_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by_id` (`created_by_id`) USING BTREE,
  FULLTEXT KEY `quick_search` (`name`,`description`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project
-- ----------------------------

-- ----------------------------
-- Table structure for `projectcomment`
-- ----------------------------
DROP TABLE IF EXISTS `projectcomment`;
CREATE TABLE `projectcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `comment` text,
  `employee_id` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `on_action` int(11) DEFAULT NULL,
  `is_seen_by_creator` tinyint(4) DEFAULT NULL,
  `is_seen_by_assignee` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`) USING BTREE,
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of projectcomment
-- ----------------------------

-- ----------------------------
-- Table structure for `publish_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `publish_schedule`;
CREATE TABLE `publish_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_post_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `is_posted` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of publish_schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `qsp_detail`
-- ----------------------------
DROP TABLE IF EXISTS `qsp_detail`;
CREATE TABLE `qsp_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qsp_master_id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `price` decimal(14,4) NOT NULL,
  `quantity` decimal(14,2) NOT NULL,
  `tax_percentage` decimal(14,4) NOT NULL,
  `narration` text,
  `extra_info` text,
  `shipping_charge` float DEFAULT NULL,
  `taxation_id` int(11) DEFAULT NULL,
  `sale_amount` decimal(14,4) DEFAULT NULL,
  `original_amount` decimal(14,4) DEFAULT NULL,
  `shipping_duration` text,
  `express_shipping_charge` decimal(14,4) DEFAULT NULL,
  `express_shipping_duration` text,
  `item_template_design_id` int(11) DEFAULT NULL,
  `qty_unit_id` int(11) DEFAULT NULL,
  `discount` double(8,4) DEFAULT NULL,
  `recurring_qsp_detail_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qsp_master_id` (`qsp_master_id`),
  KEY `item_id` (`item_id`),
  KEY `taxation_id` (`taxation_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qsp_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `qsp_detail_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `qsp_detail_attachment`;
CREATE TABLE `qsp_detail_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `qsp_detail_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of qsp_detail_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `qsp_master`
-- ----------------------------
DROP TABLE IF EXISTS `qsp_master`;
CREATE TABLE `qsp_master` (
  `document_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `document_no` varchar(45) NOT NULL DEFAULT '',
  `billing_address` text,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state_id` int(11) NOT NULL,
  `billing_country_id` int(11) NOT NULL,
  `billing_pincode` varchar(255) DEFAULT NULL,
  `is_shipping_inclusive_tax` tinyint(4) DEFAULT NULL,
  `is_express_shipping` tinyint(4) DEFAULT NULL,
  `shipping_address` text,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state_id` int(11) DEFAULT NULL,
  `shipping_country_id` int(11) DEFAULT NULL,
  `shipping_pincode` varchar(255) DEFAULT NULL,
  `currency_id` varchar(255) DEFAULT NULL,
  `discount_amount` varchar(255) DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `transaction_response_data` text,
  `narration` text,
  `priority_id` int(11) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `exchange_rate` decimal(14,6) DEFAULT NULL,
  `tnc_id` int(11) DEFAULT NULL,
  `tnc_text` text,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentgateway_id` int(11) DEFAULT NULL,
  `related_qsp_master_id` int(11) DEFAULT NULL,
  `nominal_id` int(11) DEFAULT NULL,
  `outsource_party_id` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `round_amount` decimal(14,2) DEFAULT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document` (`document_id`),
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `priority_id` (`priority_id`) USING BTREE,
  KEY `tnc_id` (`tnc_id`) USING BTREE,
  KEY `payment_gateway_id` (`paymentgateway_id`) USING BTREE,
  KEY `related_qsp_master_id` (`related_qsp_master_id`) USING BTREE,
  KEY `nominal_id` (`nominal_id`) USING BTREE,
  CONSTRAINT `document` FOREIGN KEY (`document_id`) REFERENCES `document` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qsp_master
-- ----------------------------

-- ----------------------------
-- Table structure for `qsp_sales_person`
-- ----------------------------
DROP TABLE IF EXISTS `qsp_sales_person`;
CREATE TABLE `qsp_sales_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `qsp_master_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of qsp_sales_person
-- ----------------------------

-- ----------------------------
-- Table structure for `qualification`
-- ----------------------------
DROP TABLE IF EXISTS `qualification`;
CREATE TABLE `qualification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qualificaton_level` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qualification
-- ----------------------------

-- ----------------------------
-- Table structure for `quantity_condition`
-- ----------------------------
DROP TABLE IF EXISTS `quantity_condition`;
CREATE TABLE `quantity_condition` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `quantity_set_id` int(11) NOT NULL,
  `customfield_value_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `qty_set_id` (`quantity_set_id`) USING BTREE,
  KEY `customfield_value_id` (`customfield_value_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quantity_condition
-- ----------------------------

-- ----------------------------
-- Table structure for `quantity_set`
-- ----------------------------
DROP TABLE IF EXISTS `quantity_set`;
CREATE TABLE `quantity_set` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` float NOT NULL,
  `price` double DEFAULT NULL,
  `old_price` double DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quantity_set
-- ----------------------------

-- ----------------------------
-- Table structure for `reimbursement`
-- ----------------------------
DROP TABLE IF EXISTS `reimbursement`;
CREATE TABLE `reimbursement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reimbursement
-- ----------------------------

-- ----------------------------
-- Table structure for `reimbursement_detail`
-- ----------------------------
DROP TABLE IF EXISTS `reimbursement_detail`;
CREATE TABLE `reimbursement_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(14,6) DEFAULT NULL,
  `reimbursement_id` int(11) DEFAULT NULL,
  `narration` text,
  `paid_amount` decimal(14,6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of reimbursement_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `report_executor`
-- ----------------------------
DROP TABLE IF EXISTS `report_executor`;
CREATE TABLE `report_executor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `widget` varchar(255) DEFAULT NULL,
  `starting_from_date` date DEFAULT NULL,
  `financial_month_start` varchar(255) DEFAULT NULL,
  `time_span` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `data_range` varchar(255) DEFAULT NULL,
  `data_from_date` date DEFAULT NULL,
  `data_to_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of report_executor
-- ----------------------------

-- ----------------------------
-- Table structure for `report_function`
-- ----------------------------
DROP TABLE IF EXISTS `report_function`;
CREATE TABLE `report_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `group_id` text,
  `head_id` text,
  `ledger_id` text,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `list_of` varchar(255) DEFAULT NULL,
  `under` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of report_function
-- ----------------------------

-- ----------------------------
-- Table structure for `rule-options`
-- ----------------------------
DROP TABLE IF EXISTS `rule-options`;
CREATE TABLE `rule-options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of rule-options
-- ----------------------------

-- ----------------------------
-- Table structure for `rules`
-- ----------------------------
DROP TABLE IF EXISTS `rules`;
CREATE TABLE `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of rules
-- ----------------------------

-- ----------------------------
-- Table structure for `salary`
-- ----------------------------
DROP TABLE IF EXISTS `salary`;
CREATE TABLE `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `add_deduction` varchar(255) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `is_reimbursement` tinyint(1) DEFAULT NULL,
  `is_deduction` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of salary
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_abstract`
-- ----------------------------
DROP TABLE IF EXISTS `salary_abstract`;
CREATE TABLE `salary_abstract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by_id` int(11) NOT NULL,
  `updated_by_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of salary_abstract
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_detail`
-- ----------------------------
DROP TABLE IF EXISTS `salary_detail`;
CREATE TABLE `salary_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_id` int(11) NOT NULL,
  `amount` decimal(10,4) DEFAULT NULL,
  `employee_row_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of salary_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_ledger_association`
-- ----------------------------
DROP TABLE IF EXISTS `salary_ledger_association`;
CREATE TABLE `salary_ledger_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ledger_id` int(11) NOT NULL,
  `salary_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of salary_ledger_association
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_template`
-- ----------------------------
DROP TABLE IF EXISTS `salary_template`;
CREATE TABLE `salary_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of salary_template
-- ----------------------------

-- ----------------------------
-- Table structure for `salary_template_details`
-- ----------------------------
DROP TABLE IF EXISTS `salary_template_details`;
CREATE TABLE `salary_template_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_template_id` int(11) DEFAULT NULL,
  `salary_id` int(11) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of salary_template_details
-- ----------------------------

-- ----------------------------
-- Table structure for `schedule`
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `day` varchar(255) NOT NULL,
  `document_id` int(11) NOT NULL,
  `client_event_id` varchar(255) NOT NULL,
  `posted_on` datetime DEFAULT NULL,
  `last_communicated_lead_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaign_id` (`campaign_id`) USING BTREE,
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `shipping_association`
-- ----------------------------
DROP TABLE IF EXISTS `shipping_association`;
CREATE TABLE `shipping_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `shipping_rule_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of shipping_association
-- ----------------------------

-- ----------------------------
-- Table structure for `shipping_rule`
-- ----------------------------
DROP TABLE IF EXISTS `shipping_rule`;
CREATE TABLE `shipping_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `based_on` varchar(255) NOT NULL,
  `priority` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of shipping_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `shipping_rule_row`
-- ----------------------------
DROP TABLE IF EXISTS `shipping_rule_row`;
CREATE TABLE `shipping_rule_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_rule_id` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `shipping_charge` decimal(10,0) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `express_shipping_charge` decimal(10,0) DEFAULT NULL,
  `shipping_duration` text,
  `express_shipping_duration` text,
  `shipping_duration_days` tinyint(4) DEFAULT NULL,
  `express_shipping_duration_days` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of shipping_rule_row
-- ----------------------------

-- ----------------------------
-- Table structure for `socialuser`
-- ----------------------------
DROP TABLE IF EXISTS `socialuser`;
CREATE TABLE `socialuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `configuration` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of socialuser
-- ----------------------------

-- ----------------------------
-- Table structure for `state`
-- ----------------------------
DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `abbreviation` varchar(255) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3715 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of state
-- ----------------------------
INSERT INTO `state` VALUES ('1', 'Alabama', 'State', 'AL', '227', null, 'Active');
INSERT INTO `state` VALUES ('2', 'Alaska', 'State', 'AK', '227', null, 'Active');
INSERT INTO `state` VALUES ('3', 'Arizona', 'State', 'AZ', '227', null, 'Active');
INSERT INTO `state` VALUES ('4', 'Arkansas', 'State', 'AR', '227', null, 'Active');
INSERT INTO `state` VALUES ('5', 'California', 'State', 'CA', '227', null, 'Active');
INSERT INTO `state` VALUES ('6', 'Colorado', 'State', 'CO', '227', null, 'Active');
INSERT INTO `state` VALUES ('7', 'Connecticut', 'State', 'CT', '227', null, 'Active');
INSERT INTO `state` VALUES ('8', 'Delaware', 'State', 'DE', '227', null, 'Active');
INSERT INTO `state` VALUES ('9', 'Florida', 'State', 'FL', '227', null, 'Active');
INSERT INTO `state` VALUES ('10', 'Georgia', 'State', 'GA', '227', null, 'Active');
INSERT INTO `state` VALUES ('11', 'Hawaii', 'State', 'HI', '227', null, 'Active');
INSERT INTO `state` VALUES ('12', 'Idaho', 'State', 'ID', '227', null, 'Active');
INSERT INTO `state` VALUES ('13', 'Illinois', 'State', 'IL', '227', null, 'Active');
INSERT INTO `state` VALUES ('14', 'Indiana', 'State', 'IN', '227', null, 'Active');
INSERT INTO `state` VALUES ('15', 'Iowa', 'State', 'IA', '227', null, 'Active');
INSERT INTO `state` VALUES ('16', 'Kansas', 'State', 'KS', '227', null, 'Active');
INSERT INTO `state` VALUES ('17', 'Kentucky', 'State', 'KY', '227', null, 'Active');
INSERT INTO `state` VALUES ('18', 'Louisiana', 'State', 'LA', '227', null, 'Active');
INSERT INTO `state` VALUES ('19', 'Maine', 'State', 'ME', '227', null, 'Active');
INSERT INTO `state` VALUES ('20', 'Maryland', 'State', 'MD', '227', null, 'Active');
INSERT INTO `state` VALUES ('21', 'Massachusetts', 'State', 'MA', '227', null, 'Active');
INSERT INTO `state` VALUES ('22', 'Michigan', 'State', 'MI', '227', null, 'Active');
INSERT INTO `state` VALUES ('23', 'Minnesota', 'State', 'MN', '227', null, 'Active');
INSERT INTO `state` VALUES ('24', 'Mississippi', 'State', 'MS', '227', null, 'Active');
INSERT INTO `state` VALUES ('25', 'Missouri', 'State', 'MO', '227', null, 'Active');
INSERT INTO `state` VALUES ('26', 'Montana', 'State', 'MT', '227', null, 'Active');
INSERT INTO `state` VALUES ('27', 'Nebraska', 'State', 'NE', '227', null, 'Active');
INSERT INTO `state` VALUES ('28', 'Nevada', 'State', 'NV', '227', null, 'Active');
INSERT INTO `state` VALUES ('29', 'New Hampshire', 'State', 'NH', '227', null, 'Active');
INSERT INTO `state` VALUES ('30', 'New Jersey', 'State', 'NJ', '227', null, 'Active');
INSERT INTO `state` VALUES ('31', 'New Mexico', 'State', 'NM', '227', null, 'Active');
INSERT INTO `state` VALUES ('32', 'New York', 'State', 'NY', '227', null, 'Active');
INSERT INTO `state` VALUES ('33', 'North Carolina', 'State', 'NC', '227', null, 'Active');
INSERT INTO `state` VALUES ('34', 'North Dakota', 'State', 'ND', '227', null, 'Active');
INSERT INTO `state` VALUES ('35', 'Ohio', 'State', 'OH', '227', null, 'Active');
INSERT INTO `state` VALUES ('36', 'Oklahoma', 'State', 'OK', '227', null, 'Active');
INSERT INTO `state` VALUES ('37', 'Oregon', 'State', 'OR', '227', null, 'Active');
INSERT INTO `state` VALUES ('38', 'Pennsylvania', 'State', 'PA', '227', null, 'Active');
INSERT INTO `state` VALUES ('39', 'Rhode Island', 'State', 'RI', '227', null, 'Active');
INSERT INTO `state` VALUES ('40', 'South Carolina', 'State', 'SC', '227', null, 'Active');
INSERT INTO `state` VALUES ('41', 'South Dakota', 'State', 'SD', '227', null, 'Active');
INSERT INTO `state` VALUES ('42', 'Tennessee', 'State', 'TN', '227', null, 'Active');
INSERT INTO `state` VALUES ('43', 'Texas', 'State', 'TX', '227', null, 'Active');
INSERT INTO `state` VALUES ('44', 'Utah', 'State', 'UT', '227', null, 'Active');
INSERT INTO `state` VALUES ('45', 'Vermont', 'State', 'VT', '227', null, 'Active');
INSERT INTO `state` VALUES ('46', 'Virginia', 'State', 'VA', '227', null, 'Active');
INSERT INTO `state` VALUES ('47', 'Washington', 'State', 'WA', '227', null, 'Active');
INSERT INTO `state` VALUES ('48', 'West Virginia', 'State', 'WV', '227', null, 'Active');
INSERT INTO `state` VALUES ('49', 'Wisconsin', 'State', 'WI', '227', null, 'Active');
INSERT INTO `state` VALUES ('50', 'Wyoming', 'State', 'WY', '227', null, 'Active');
INSERT INTO `state` VALUES ('51', 'District of Columbia', 'State', 'DC', '227', null, 'Active');
INSERT INTO `state` VALUES ('52', 'American Samoa', 'State', 'AS', '227', null, 'Active');
INSERT INTO `state` VALUES ('53', 'Guam', 'State', 'GU', '227', null, 'Active');
INSERT INTO `state` VALUES ('54', 'Northern Mariana Islands', 'State', 'MP', '227', null, 'Active');
INSERT INTO `state` VALUES ('55', 'Puerto Rico', 'State', 'PR', '227', null, 'Active');
INSERT INTO `state` VALUES ('56', 'Virgin Islands', 'State', 'VI', '227', null, 'Active');
INSERT INTO `state` VALUES ('57', 'United States Minor Outlying Islands', 'State', 'UM', '227', null, 'Active');
INSERT INTO `state` VALUES ('58', 'Armed Forces Europe', 'State', 'AE', '227', null, 'Active');
INSERT INTO `state` VALUES ('59', 'Armed Forces Americas', 'State', 'AA', '227', null, 'Active');
INSERT INTO `state` VALUES ('60', 'Armed Forces Pacific', 'State', 'AP', '227', null, 'Active');
INSERT INTO `state` VALUES ('61', 'Alberta', 'State', 'AB', '39', null, 'Active');
INSERT INTO `state` VALUES ('62', 'British Columbia', 'State', 'BC', '39', null, 'Active');
INSERT INTO `state` VALUES ('63', 'Manitoba', 'State', 'MB', '39', null, 'Active');
INSERT INTO `state` VALUES ('64', 'New Brunswick', 'State', 'NB', '39', null, 'Active');
INSERT INTO `state` VALUES ('65', 'Newfoundland and Labrador', 'State', 'NL', '39', null, 'Active');
INSERT INTO `state` VALUES ('66', 'Northwest Territories', 'State', 'NT', '39', null, 'Active');
INSERT INTO `state` VALUES ('67', 'Nova Scotia', 'State', 'NS', '39', null, 'Active');
INSERT INTO `state` VALUES ('68', 'Nunavut', 'State', 'NU', '39', null, 'Active');
INSERT INTO `state` VALUES ('69', 'Ontario', 'State', 'ON', '39', null, 'Active');
INSERT INTO `state` VALUES ('70', 'Prince Edward Island', 'State', 'PE', '39', null, 'Active');
INSERT INTO `state` VALUES ('71', 'Quebec', 'State', 'QC', '39', null, 'Active');
INSERT INTO `state` VALUES ('72', 'Saskatchewan', 'State', 'SK', '39', null, 'Active');
INSERT INTO `state` VALUES ('73', 'Yukon Territory', 'State', 'YT', '39', null, 'Active');
INSERT INTO `state` VALUES ('74', 'Maharashtra', 'State', 'MM', '100', null, 'Active');
INSERT INTO `state` VALUES ('75', 'Karnataka', 'State', 'KA', '100', null, 'Active');
INSERT INTO `state` VALUES ('76', 'Andhra Pradesh', 'State', 'AP', '100', null, 'Active');
INSERT INTO `state` VALUES ('77', 'Arunachal Pradesh', 'State', 'AR', '100', null, 'Active');
INSERT INTO `state` VALUES ('78', 'Assam', 'State', 'AS', '100', null, 'Active');
INSERT INTO `state` VALUES ('79', 'Bihar', 'State', 'BR', '100', null, 'Active');
INSERT INTO `state` VALUES ('80', 'Chhattisgarh', 'State', 'CH', '100', null, 'Active');
INSERT INTO `state` VALUES ('81', 'Goa', 'State', 'GA', '100', null, 'Active');
INSERT INTO `state` VALUES ('82', 'Gujarat', 'State', 'GJ', '100', null, 'Active');
INSERT INTO `state` VALUES ('83', 'Haryana', 'State', 'HR', '100', null, 'Active');
INSERT INTO `state` VALUES ('84', 'Himachal Pradesh', 'State', 'HP', '100', null, 'Active');
INSERT INTO `state` VALUES ('85', 'Jammu and Kashmir', 'State', 'JK', '100', null, 'Active');
INSERT INTO `state` VALUES ('86', 'Jharkhand', 'State', 'JH', '100', null, 'Active');
INSERT INTO `state` VALUES ('87', 'Kerala', 'State', 'KL', '100', null, 'Active');
INSERT INTO `state` VALUES ('88', 'Madhya Pradesh', 'State', 'MP', '100', null, 'Active');
INSERT INTO `state` VALUES ('89', 'Manipur', 'State', 'MN', '100', null, 'Active');
INSERT INTO `state` VALUES ('90', 'Meghalaya', 'State', 'ML', '100', null, 'Active');
INSERT INTO `state` VALUES ('91', 'Mizoram', 'State', 'MZ', '100', null, 'Active');
INSERT INTO `state` VALUES ('92', 'Nagaland', 'State', 'NL', '100', null, 'Active');
INSERT INTO `state` VALUES ('93', 'Orissa', 'State', 'OR', '100', null, 'Active');
INSERT INTO `state` VALUES ('94', 'Punjab', 'State', 'PB', '100', null, 'Active');
INSERT INTO `state` VALUES ('95', 'Rajasthan', 'State', 'RJ', '100', null, 'Active');
INSERT INTO `state` VALUES ('96', 'Sikkim', 'State', 'SK', '100', null, 'Active');
INSERT INTO `state` VALUES ('97', 'Tamil Nadu', 'State', 'TN', '100', null, 'Active');
INSERT INTO `state` VALUES ('98', 'Tripura', 'State', 'TR', '100', null, 'Active');
INSERT INTO `state` VALUES ('99', 'Uttaranchal', 'State', 'UL', '100', null, 'Active');
INSERT INTO `state` VALUES ('100', 'Uttar Pradesh', 'State', 'UP', '100', null, 'Active');
INSERT INTO `state` VALUES ('101', 'West Bengal', 'State', 'WB', '100', null, 'Active');
INSERT INTO `state` VALUES ('102', 'Andaman and Nicobar Islands', 'State', 'AN', '100', null, 'Active');
INSERT INTO `state` VALUES ('103', 'Dadra and Nagar Haveli', 'State', 'DN', '100', null, 'Active');
INSERT INTO `state` VALUES ('104', 'Daman and Diu', 'State', 'DD', '100', null, 'Active');
INSERT INTO `state` VALUES ('105', 'Delhi', 'State', 'DL', '100', null, 'Active');
INSERT INTO `state` VALUES ('106', 'Lakshadweep', 'State', 'LD', '100', null, 'Active');
INSERT INTO `state` VALUES ('107', 'Pondicherry', 'State', 'PY', '100', null, 'Active');
INSERT INTO `state` VALUES ('108', 'mazowieckie', 'State', 'MZ', '171', null, 'Active');
INSERT INTO `state` VALUES ('109', 'pomorskie', 'State', 'PM', '171', null, 'Active');
INSERT INTO `state` VALUES ('110', 'dolno?l?skie', 'State', 'DS', '171', null, 'Active');
INSERT INTO `state` VALUES ('111', 'kujawsko-pomorskie', 'State', 'KP', '171', null, 'Active');
INSERT INTO `state` VALUES ('112', 'lubelskie', 'State', 'LU', '171', null, 'Active');
INSERT INTO `state` VALUES ('113', 'lubuskie', 'State', 'LB', '171', null, 'Active');
INSERT INTO `state` VALUES ('114', '?ódzkie', 'State', 'LD', '171', null, 'Active');
INSERT INTO `state` VALUES ('115', 'ma?opolskie', 'State', 'MA', '171', null, 'Active');
INSERT INTO `state` VALUES ('116', 'opolskie', 'State', 'OP', '171', null, 'Active');
INSERT INTO `state` VALUES ('117', 'podkarpackie', 'State', 'PK', '171', null, 'Active');
INSERT INTO `state` VALUES ('118', 'podlaskie', 'State', 'PD', '171', null, 'Active');
INSERT INTO `state` VALUES ('119', '?l?skie', 'State', 'SL', '171', null, 'Active');
INSERT INTO `state` VALUES ('120', '?wi?tokrzyskie', 'State', 'SK', '171', null, 'Active');
INSERT INTO `state` VALUES ('121', 'warmi?sko-mazurskie', 'State', 'WN', '171', null, 'Active');
INSERT INTO `state` VALUES ('122', 'wielkopolskie', 'State', 'WP', '171', null, 'Active');
INSERT INTO `state` VALUES ('123', 'zachodniopomorskie', 'State', 'ZP', '171', null, 'Active');
INSERT INTO `state` VALUES ('124', 'Abu Zaby', 'State', 'AZ', '224', null, 'Active');
INSERT INTO `state` VALUES ('125', '\'Ajman', 'State', 'AJ', '224', null, 'Active');
INSERT INTO `state` VALUES ('126', 'Al Fujayrah', 'State', 'FU', '224', null, 'Active');
INSERT INTO `state` VALUES ('127', 'Ash Shariqah', 'State', 'SH', '224', null, 'Active');
INSERT INTO `state` VALUES ('128', 'Dubayy', 'State', 'DU', '224', null, 'Active');
INSERT INTO `state` VALUES ('129', 'Ra\'s al Khaymah', 'State', 'RK', '224', null, 'Active');
INSERT INTO `state` VALUES ('130', 'Dac Lac', 'State', '33', '232', null, 'Active');
INSERT INTO `state` VALUES ('131', 'Umm al Qaywayn', 'State', 'UQ', '224', null, 'Active');
INSERT INTO `state` VALUES ('132', 'Badakhshan', 'State', 'BDS', '1', null, 'Active');
INSERT INTO `state` VALUES ('133', 'Badghis', 'State', 'BDG', '1', null, 'Active');
INSERT INTO `state` VALUES ('134', 'Baghlan', 'State', 'BGL', '1', null, 'Active');
INSERT INTO `state` VALUES ('135', 'Balkh', 'State', 'BAL', '1', null, 'Active');
INSERT INTO `state` VALUES ('136', 'Bamian', 'State', 'BAM', '1', null, 'Active');
INSERT INTO `state` VALUES ('137', 'Farah', 'State', 'FRA', '1', null, 'Active');
INSERT INTO `state` VALUES ('138', 'Faryab', 'State', 'FYB', '1', null, 'Active');
INSERT INTO `state` VALUES ('139', 'Ghazni', 'State', 'GHA', '1', null, 'Active');
INSERT INTO `state` VALUES ('140', 'Ghowr', 'State', 'GHO', '1', null, 'Active');
INSERT INTO `state` VALUES ('141', 'Helmand', 'State', 'HEL', '1', null, 'Active');
INSERT INTO `state` VALUES ('142', 'Herat', 'State', 'HER', '1', null, 'Active');
INSERT INTO `state` VALUES ('143', 'Jowzjan', 'State', 'JOW', '1', null, 'Active');
INSERT INTO `state` VALUES ('144', 'Kabul', 'State', 'KAB', '1', null, 'Active');
INSERT INTO `state` VALUES ('145', 'Kandahar', 'State', 'KAN', '1', null, 'Active');
INSERT INTO `state` VALUES ('146', 'Kapisa', 'State', 'KAP', '1', null, 'Active');
INSERT INTO `state` VALUES ('147', 'Khowst', 'State', 'KHO', '1', null, 'Active');
INSERT INTO `state` VALUES ('148', 'Konar', 'State', 'KNR', '1', null, 'Active');
INSERT INTO `state` VALUES ('149', 'Kondoz', 'State', 'KDZ', '1', null, 'Active');
INSERT INTO `state` VALUES ('150', 'Laghman', 'State', 'LAG', '1', null, 'Active');
INSERT INTO `state` VALUES ('151', 'Lowgar', 'State', 'LOW', '1', null, 'Active');
INSERT INTO `state` VALUES ('152', 'Nangrahar', 'State', 'NAN', '1', null, 'Active');
INSERT INTO `state` VALUES ('153', 'Nimruz', 'State', 'NIM', '1', null, 'Active');
INSERT INTO `state` VALUES ('154', 'Nurestan', 'State', 'NUR', '1', null, 'Active');
INSERT INTO `state` VALUES ('155', 'Oruzgan', 'State', 'ORU', '1', null, 'Active');
INSERT INTO `state` VALUES ('156', 'Paktia', 'State', 'PIA', '1', null, 'Active');
INSERT INTO `state` VALUES ('157', 'Paktika', 'State', 'PKA', '1', null, 'Active');
INSERT INTO `state` VALUES ('158', 'Parwan', 'State', 'PAR', '1', null, 'Active');
INSERT INTO `state` VALUES ('159', 'Samangan', 'State', 'SAM', '1', null, 'Active');
INSERT INTO `state` VALUES ('160', 'Sar-e Pol', 'State', 'SAR', '1', null, 'Active');
INSERT INTO `state` VALUES ('161', 'Takhar', 'State', 'TAK', '1', null, 'Active');
INSERT INTO `state` VALUES ('162', 'Wardak', 'State', 'WAR', '1', null, 'Active');
INSERT INTO `state` VALUES ('163', 'Zabol', 'State', 'ZAB', '1', null, 'Active');
INSERT INTO `state` VALUES ('164', 'Berat', 'State', 'BR', '2', null, 'Active');
INSERT INTO `state` VALUES ('165', 'Bulqizë', 'State', 'BU', '2', null, 'Active');
INSERT INTO `state` VALUES ('166', 'Delvinë', 'State', 'DL', '2', null, 'Active');
INSERT INTO `state` VALUES ('167', 'Devoll', 'State', 'DV', '2', null, 'Active');
INSERT INTO `state` VALUES ('168', 'Dibër', 'State', 'DI', '2', null, 'Active');
INSERT INTO `state` VALUES ('169', 'Durrsës', 'State', 'DR', '2', null, 'Active');
INSERT INTO `state` VALUES ('170', 'Elbasan', 'State', 'EL', '2', null, 'Active');
INSERT INTO `state` VALUES ('171', 'Fier', 'State', 'FR', '2', null, 'Active');
INSERT INTO `state` VALUES ('172', 'Gramsh', 'State', 'GR', '2', null, 'Active');
INSERT INTO `state` VALUES ('173', 'Gjirokastër', 'State', 'GJ', '2', null, 'Active');
INSERT INTO `state` VALUES ('174', 'Has', 'State', 'HA', '2', null, 'Active');
INSERT INTO `state` VALUES ('175', 'Kavajë', 'State', 'KA', '2', null, 'Active');
INSERT INTO `state` VALUES ('176', 'Kolonjë', 'State', 'ER', '2', null, 'Active');
INSERT INTO `state` VALUES ('177', 'Korcë', 'State', 'KO', '2', null, 'Active');
INSERT INTO `state` VALUES ('178', 'Krujë', 'State', 'KR', '2', null, 'Active');
INSERT INTO `state` VALUES ('179', 'Kuçovë', 'State', 'KC', '2', null, 'Active');
INSERT INTO `state` VALUES ('180', 'Kukës', 'State', 'KU', '2', null, 'Active');
INSERT INTO `state` VALUES ('181', 'Kurbin', 'State', 'KB', '2', null, 'Active');
INSERT INTO `state` VALUES ('182', 'Lezhë', 'State', 'LE', '2', null, 'Active');
INSERT INTO `state` VALUES ('183', 'Librazhd', 'State', 'LB', '2', null, 'Active');
INSERT INTO `state` VALUES ('184', 'Lushnjë', 'State', 'LU', '2', null, 'Active');
INSERT INTO `state` VALUES ('185', 'Malësi e Madhe', 'State', 'MM', '2', null, 'Active');
INSERT INTO `state` VALUES ('186', 'Mallakastër', 'State', 'MK', '2', null, 'Active');
INSERT INTO `state` VALUES ('187', 'Mat', 'State', 'MT', '2', null, 'Active');
INSERT INTO `state` VALUES ('188', 'Mirditë', 'State', 'MR', '2', null, 'Active');
INSERT INTO `state` VALUES ('189', 'Peqin', 'State', 'PQ', '2', null, 'Active');
INSERT INTO `state` VALUES ('190', 'Përmet', 'State', 'PR', '2', null, 'Active');
INSERT INTO `state` VALUES ('191', 'Pogradec', 'State', 'PG', '2', null, 'Active');
INSERT INTO `state` VALUES ('192', 'Pukë', 'State', 'PU', '2', null, 'Active');
INSERT INTO `state` VALUES ('193', 'Sarandë', 'State', 'SR', '2', null, 'Active');
INSERT INTO `state` VALUES ('194', 'Skrapar', 'State', 'SK', '2', null, 'Active');
INSERT INTO `state` VALUES ('195', 'Shkodër', 'State', 'SH', '2', null, 'Active');
INSERT INTO `state` VALUES ('196', 'Tepelenë', 'State', 'TE', '2', null, 'Active');
INSERT INTO `state` VALUES ('197', 'Tiranë', 'State', 'TR', '2', null, 'Active');
INSERT INTO `state` VALUES ('198', 'Tropojë', 'State', 'TP', '2', null, 'Active');
INSERT INTO `state` VALUES ('199', 'Vlorë', 'State', 'VL', '2', null, 'Active');
INSERT INTO `state` VALUES ('200', 'Erevan', 'State', 'ER', '11', null, 'Active');
INSERT INTO `state` VALUES ('201', 'Aragacotn', 'State', 'AG', '11', null, 'Active');
INSERT INTO `state` VALUES ('202', 'Ararat', 'State', 'AR', '11', null, 'Active');
INSERT INTO `state` VALUES ('203', 'Armavir', 'State', 'AV', '11', null, 'Active');
INSERT INTO `state` VALUES ('204', 'Gegarkunik\'', 'State', 'GR', '11', null, 'Active');
INSERT INTO `state` VALUES ('205', 'Kotayk\'', 'State', 'KT', '11', null, 'Active');
INSERT INTO `state` VALUES ('206', 'Lory', 'State', 'LO', '11', null, 'Active');
INSERT INTO `state` VALUES ('207', 'Sirak', 'State', 'SH', '11', null, 'Active');
INSERT INTO `state` VALUES ('208', 'Syunik\'', 'State', 'SU', '11', null, 'Active');
INSERT INTO `state` VALUES ('209', 'Tavus', 'State', 'TV', '11', null, 'Active');
INSERT INTO `state` VALUES ('210', 'Vayoc Jor', 'State', 'VD', '11', null, 'Active');
INSERT INTO `state` VALUES ('211', 'Bengo', 'State', 'BGO', '6', null, 'Active');
INSERT INTO `state` VALUES ('212', 'Benguela', 'State', 'BGU', '6', null, 'Active');
INSERT INTO `state` VALUES ('213', 'Bie', 'State', 'BIE', '6', null, 'Active');
INSERT INTO `state` VALUES ('214', 'Cabinda', 'State', 'CAB', '6', null, 'Active');
INSERT INTO `state` VALUES ('215', 'Cuando-Cubango', 'State', 'CCU', '6', null, 'Active');
INSERT INTO `state` VALUES ('216', 'Cuanza Norte', 'State', 'CNO', '6', null, 'Active');
INSERT INTO `state` VALUES ('217', 'Cuanza Sul', 'State', 'CUS', '6', null, 'Active');
INSERT INTO `state` VALUES ('218', 'Cunene', 'State', 'CNN', '6', null, 'Active');
INSERT INTO `state` VALUES ('219', 'Huambo', 'State', 'HUA', '6', null, 'Active');
INSERT INTO `state` VALUES ('220', 'Huila', 'State', 'HUI', '6', null, 'Active');
INSERT INTO `state` VALUES ('221', 'Luanda', 'State', 'LUA', '6', null, 'Active');
INSERT INTO `state` VALUES ('222', 'Lunda Norte', 'State', 'LNO', '6', null, 'Active');
INSERT INTO `state` VALUES ('223', 'Lunda Sul', 'State', 'LSU', '6', null, 'Active');
INSERT INTO `state` VALUES ('224', 'Malange', 'State', 'MAL', '6', null, 'Active');
INSERT INTO `state` VALUES ('225', 'Moxico', 'State', 'MOX', '6', null, 'Active');
INSERT INTO `state` VALUES ('226', 'Namibe', 'State', 'NAM', '6', null, 'Active');
INSERT INTO `state` VALUES ('227', 'Uige', 'State', 'UIG', '6', null, 'Active');
INSERT INTO `state` VALUES ('228', 'Zaire', 'State', 'ZAI', '6', null, 'Active');
INSERT INTO `state` VALUES ('229', 'Capital federal', 'State', 'C', '10', null, 'Active');
INSERT INTO `state` VALUES ('230', 'Buenos Aires', 'State', 'B', '10', null, 'Active');
INSERT INTO `state` VALUES ('231', 'Catamarca', 'State', 'K', '10', null, 'Active');
INSERT INTO `state` VALUES ('232', 'Cordoba', 'State', 'X', '10', null, 'Active');
INSERT INTO `state` VALUES ('233', 'Corrientes', 'State', 'W', '10', null, 'Active');
INSERT INTO `state` VALUES ('234', 'Chaco', 'State', 'H', '10', null, 'Active');
INSERT INTO `state` VALUES ('235', 'Chubut', 'State', 'U', '10', null, 'Active');
INSERT INTO `state` VALUES ('236', 'Entre Rios', 'State', 'E', '10', null, 'Active');
INSERT INTO `state` VALUES ('237', 'Formosa', 'State', 'P', '10', null, 'Active');
INSERT INTO `state` VALUES ('238', 'Jujuy', 'State', 'Y', '10', null, 'Active');
INSERT INTO `state` VALUES ('239', 'La Pampa', 'State', 'L', '10', null, 'Active');
INSERT INTO `state` VALUES ('240', 'Mendoza', 'State', 'M', '10', null, 'Active');
INSERT INTO `state` VALUES ('241', 'Misiones', 'State', 'N', '10', null, 'Active');
INSERT INTO `state` VALUES ('242', 'Neuquen', 'State', 'Q', '10', null, 'Active');
INSERT INTO `state` VALUES ('243', 'Rio Negro', 'State', 'R', '10', null, 'Active');
INSERT INTO `state` VALUES ('244', 'Salta', 'State', 'A', '10', null, 'Active');
INSERT INTO `state` VALUES ('245', 'San Juan', 'State', 'J', '10', null, 'Active');
INSERT INTO `state` VALUES ('246', 'San Luis', 'State', 'D', '10', null, 'Active');
INSERT INTO `state` VALUES ('247', 'Santa Cruz', 'State', 'Z', '10', null, 'Active');
INSERT INTO `state` VALUES ('248', 'Santa Fe', 'State', 'S', '10', null, 'Active');
INSERT INTO `state` VALUES ('249', 'Santiago del Estero', 'State', 'G', '10', null, 'Active');
INSERT INTO `state` VALUES ('250', 'Tierra del Fuego', 'State', 'V', '10', null, 'Active');
INSERT INTO `state` VALUES ('251', 'Tucuman', 'State', 'T', '10', null, 'Active');
INSERT INTO `state` VALUES ('252', 'Burgenland', 'State', '1', '14', null, 'Active');
INSERT INTO `state` VALUES ('253', 'Kärnten', 'State', '2', '14', null, 'Active');
INSERT INTO `state` VALUES ('254', 'Niederosterreich', 'State', '3', '14', null, 'Active');
INSERT INTO `state` VALUES ('255', 'Oberosterreich', 'State', '4', '14', null, 'Active');
INSERT INTO `state` VALUES ('256', 'Salzburg', 'State', '5', '14', null, 'Active');
INSERT INTO `state` VALUES ('257', 'Steiermark', 'State', '6', '14', null, 'Active');
INSERT INTO `state` VALUES ('258', 'Tirol', 'State', '7', '14', null, 'Active');
INSERT INTO `state` VALUES ('259', 'Vorarlberg', 'State', '8', '14', null, 'Active');
INSERT INTO `state` VALUES ('260', 'Wien', 'State', '9', '14', null, 'Active');
INSERT INTO `state` VALUES ('261', 'Australian Antarctic Territory', 'State', 'AAT', '8', null, 'Active');
INSERT INTO `state` VALUES ('262', 'Australian Capital Territory', 'State', 'ACT', '13', null, 'Active');
INSERT INTO `state` VALUES ('263', 'Northern Territory', 'State', 'NT', '13', null, 'Active');
INSERT INTO `state` VALUES ('264', 'New South Wales', 'State', 'NSW', '13', null, 'Active');
INSERT INTO `state` VALUES ('265', 'Queensland', 'State', 'QLD', '13', null, 'Active');
INSERT INTO `state` VALUES ('266', 'South Australia', 'State', 'SA', '13', null, 'Active');
INSERT INTO `state` VALUES ('267', 'Tasmania', 'State', 'TAS', '13', null, 'Active');
INSERT INTO `state` VALUES ('268', 'Victoria', 'State', 'VIC', '13', null, 'Active');
INSERT INTO `state` VALUES ('269', 'Western Australia', 'State', 'WA', '13', null, 'Active');
INSERT INTO `state` VALUES ('270', 'Naxcivan', 'State', 'NX', '15', null, 'Active');
INSERT INTO `state` VALUES ('271', 'Ali Bayramli', 'State', 'AB', '15', null, 'Active');
INSERT INTO `state` VALUES ('272', 'Baki', 'State', 'BA', '15', null, 'Active');
INSERT INTO `state` VALUES ('273', 'Ganca', 'State', 'GA', '15', null, 'Active');
INSERT INTO `state` VALUES ('274', 'Lankaran', 'State', 'LA', '15', null, 'Active');
INSERT INTO `state` VALUES ('275', 'Mingacevir', 'State', 'MI', '15', null, 'Active');
INSERT INTO `state` VALUES ('276', 'Naftalan', 'State', 'NA', '15', null, 'Active');
INSERT INTO `state` VALUES ('277', 'Saki', 'State', 'SA', '15', null, 'Active');
INSERT INTO `state` VALUES ('278', 'Sumqayit', 'State', 'SM', '15', null, 'Active');
INSERT INTO `state` VALUES ('279', 'Susa', 'State', 'SS', '15', null, 'Active');
INSERT INTO `state` VALUES ('280', 'Xankandi', 'State', 'XA', '15', null, 'Active');
INSERT INTO `state` VALUES ('281', 'Yevlax', 'State', 'YE', '15', null, 'Active');
INSERT INTO `state` VALUES ('282', 'Abseron', 'State', 'ABS', '15', null, 'Active');
INSERT INTO `state` VALUES ('283', 'Agcabadi', 'State', 'AGC', '15', null, 'Active');
INSERT INTO `state` VALUES ('284', 'Agdam', 'State', 'AGM', '15', null, 'Active');
INSERT INTO `state` VALUES ('285', 'Agdas', 'State', 'AGS', '15', null, 'Active');
INSERT INTO `state` VALUES ('286', 'Agstafa', 'State', 'AGA', '15', null, 'Active');
INSERT INTO `state` VALUES ('287', 'Agsu', 'State', 'AGU', '15', null, 'Active');
INSERT INTO `state` VALUES ('288', 'Astara', 'State', 'AST', '15', null, 'Active');
INSERT INTO `state` VALUES ('289', 'Babak', 'State', 'BAB', '15', null, 'Active');
INSERT INTO `state` VALUES ('290', 'Balakan', 'State', 'BAL', '15', null, 'Active');
INSERT INTO `state` VALUES ('291', 'Barda', 'State', 'BAR', '15', null, 'Active');
INSERT INTO `state` VALUES ('292', 'Beylagan', 'State', 'BEY', '15', null, 'Active');
INSERT INTO `state` VALUES ('293', 'Bilasuvar', 'State', 'BIL', '15', null, 'Active');
INSERT INTO `state` VALUES ('294', 'Cabrayll', 'State', 'CAB', '15', null, 'Active');
INSERT INTO `state` VALUES ('295', 'Calilabad', 'State', 'CAL', '15', null, 'Active');
INSERT INTO `state` VALUES ('296', 'Culfa', 'State', 'CUL', '15', null, 'Active');
INSERT INTO `state` VALUES ('297', 'Daskasan', 'State', 'DAS', '15', null, 'Active');
INSERT INTO `state` VALUES ('298', 'Davaci', 'State', 'DAV', '15', null, 'Active');
INSERT INTO `state` VALUES ('299', 'Fuzuli', 'State', 'FUZ', '15', null, 'Active');
INSERT INTO `state` VALUES ('300', 'Gadabay', 'State', 'GAD', '15', null, 'Active');
INSERT INTO `state` VALUES ('301', 'Goranboy', 'State', 'GOR', '15', null, 'Active');
INSERT INTO `state` VALUES ('302', 'Goycay', 'State', 'GOY', '15', null, 'Active');
INSERT INTO `state` VALUES ('303', 'Haciqabul', 'State', 'HAC', '15', null, 'Active');
INSERT INTO `state` VALUES ('304', 'Imisli', 'State', 'IMI', '15', null, 'Active');
INSERT INTO `state` VALUES ('305', 'Ismayilli', 'State', 'ISM', '15', null, 'Active');
INSERT INTO `state` VALUES ('306', 'Kalbacar', 'State', 'KAL', '15', null, 'Active');
INSERT INTO `state` VALUES ('307', 'Kurdamir', 'State', 'KUR', '15', null, 'Active');
INSERT INTO `state` VALUES ('308', 'Lacin', 'State', 'LAC', '15', null, 'Active');
INSERT INTO `state` VALUES ('309', 'Lerik', 'State', 'LER', '15', null, 'Active');
INSERT INTO `state` VALUES ('310', 'Masalli', 'State', 'MAS', '15', null, 'Active');
INSERT INTO `state` VALUES ('311', 'Neftcala', 'State', 'NEF', '15', null, 'Active');
INSERT INTO `state` VALUES ('312', 'Oguz', 'State', 'OGU', '15', null, 'Active');
INSERT INTO `state` VALUES ('313', 'Ordubad', 'State', 'ORD', '15', null, 'Active');
INSERT INTO `state` VALUES ('314', 'Qabala', 'State', 'QAB', '15', null, 'Active');
INSERT INTO `state` VALUES ('315', 'Qax', 'State', 'QAX', '15', null, 'Active');
INSERT INTO `state` VALUES ('316', 'Qazax', 'State', 'QAZ', '15', null, 'Active');
INSERT INTO `state` VALUES ('317', 'Qobustan', 'State', 'QOB', '15', null, 'Active');
INSERT INTO `state` VALUES ('318', 'Quba', 'State', 'QBA', '15', null, 'Active');
INSERT INTO `state` VALUES ('319', 'Qubadli', 'State', 'QBI', '15', null, 'Active');
INSERT INTO `state` VALUES ('320', 'Qusar', 'State', 'QUS', '15', null, 'Active');
INSERT INTO `state` VALUES ('321', 'Saatli', 'State', 'SAT', '15', null, 'Active');
INSERT INTO `state` VALUES ('322', 'Sabirabad', 'State', 'SAB', '15', null, 'Active');
INSERT INTO `state` VALUES ('323', 'Sadarak', 'State', 'SAD', '15', null, 'Active');
INSERT INTO `state` VALUES ('324', 'Sahbuz', 'State', 'SAH', '15', null, 'Active');
INSERT INTO `state` VALUES ('325', 'Salyan', 'State', 'SAL', '15', null, 'Active');
INSERT INTO `state` VALUES ('326', 'Samaxi', 'State', 'SMI', '15', null, 'Active');
INSERT INTO `state` VALUES ('327', 'Samkir', 'State', 'SKR', '15', null, 'Active');
INSERT INTO `state` VALUES ('328', 'Samux', 'State', 'SMX', '15', null, 'Active');
INSERT INTO `state` VALUES ('329', 'Sarur', 'State', 'SAR', '15', null, 'Active');
INSERT INTO `state` VALUES ('330', 'Siyazan', 'State', 'SIY', '15', null, 'Active');
INSERT INTO `state` VALUES ('331', 'Tartar', 'State', 'TAR', '15', null, 'Active');
INSERT INTO `state` VALUES ('332', 'Tovuz', 'State', 'TOV', '15', null, 'Active');
INSERT INTO `state` VALUES ('333', 'Ucar', 'State', 'UCA', '15', null, 'Active');
INSERT INTO `state` VALUES ('334', 'Xacmaz', 'State', 'XAC', '15', null, 'Active');
INSERT INTO `state` VALUES ('335', 'Xanlar', 'State', 'XAN', '15', null, 'Active');
INSERT INTO `state` VALUES ('336', 'Xizi', 'State', 'XIZ', '15', null, 'Active');
INSERT INTO `state` VALUES ('337', 'Xocali', 'State', 'XCI', '15', null, 'Active');
INSERT INTO `state` VALUES ('338', 'Xocavand', 'State', 'XVD', '15', null, 'Active');
INSERT INTO `state` VALUES ('339', 'Yardimli', 'State', 'YAR', '15', null, 'Active');
INSERT INTO `state` VALUES ('340', 'Zangilan', 'State', 'ZAN', '15', null, 'Active');
INSERT INTO `state` VALUES ('341', 'Zaqatala', 'State', 'ZAQ', '15', null, 'Active');
INSERT INTO `state` VALUES ('342', 'Zardab', 'State', 'ZAR', '15', null, 'Active');
INSERT INTO `state` VALUES ('343', 'Federacija Bosna i Hercegovina', 'State', 'BIH', '26', null, 'Active');
INSERT INTO `state` VALUES ('344', 'Republika Srpska', 'State', 'SRP', '26', null, 'Active');
INSERT INTO `state` VALUES ('345', 'Bagerhat zila', 'State', '05', '17', null, 'Active');
INSERT INTO `state` VALUES ('346', 'Bandarban zila', 'State', '01', '17', null, 'Active');
INSERT INTO `state` VALUES ('347', 'Barguna zila', 'State', '02', '17', null, 'Active');
INSERT INTO `state` VALUES ('348', 'Barisal zila', 'State', '06', '17', null, 'Active');
INSERT INTO `state` VALUES ('349', 'Bhola zila', 'State', '07', '17', null, 'Active');
INSERT INTO `state` VALUES ('350', 'Bogra zila', 'State', '03', '17', null, 'Active');
INSERT INTO `state` VALUES ('351', 'Brahmanbaria zila', 'State', '04', '17', null, 'Active');
INSERT INTO `state` VALUES ('352', 'Chandpur zila', 'State', '09', '17', null, 'Active');
INSERT INTO `state` VALUES ('353', 'Chittagong zila', 'State', '10', '17', null, 'Active');
INSERT INTO `state` VALUES ('354', 'Chuadanga zila', 'State', '12', '17', null, 'Active');
INSERT INTO `state` VALUES ('355', 'Comilla zila', 'State', '08', '17', null, 'Active');
INSERT INTO `state` VALUES ('356', 'Cox\'s Bazar zila', 'State', '11', '17', null, 'Active');
INSERT INTO `state` VALUES ('357', 'Dhaka zila', 'State', '13', '17', null, 'Active');
INSERT INTO `state` VALUES ('358', 'Dinajpur zila', 'State', '14', '17', null, 'Active');
INSERT INTO `state` VALUES ('359', 'Faridpur zila', 'State', '15', '17', null, 'Active');
INSERT INTO `state` VALUES ('360', 'Feni zila', 'State', '16', '17', null, 'Active');
INSERT INTO `state` VALUES ('361', 'Gaibandha zila', 'State', '19', '17', null, 'Active');
INSERT INTO `state` VALUES ('362', 'Gazipur zila', 'State', '18', '17', null, 'Active');
INSERT INTO `state` VALUES ('363', 'Gopalganj zila', 'State', '17', '17', null, 'Active');
INSERT INTO `state` VALUES ('364', 'Habiganj zila', 'State', '20', '17', null, 'Active');
INSERT INTO `state` VALUES ('365', 'Jaipurhat zila', 'State', '24', '17', null, 'Active');
INSERT INTO `state` VALUES ('366', 'Jamalpur zila', 'State', '21', '17', null, 'Active');
INSERT INTO `state` VALUES ('367', 'Jessore zila', 'State', '22', '17', null, 'Active');
INSERT INTO `state` VALUES ('368', 'Jhalakati zila', 'State', '25', '17', null, 'Active');
INSERT INTO `state` VALUES ('369', 'Jhenaidah zila', 'State', '23', '17', null, 'Active');
INSERT INTO `state` VALUES ('370', 'Khagrachari zila', 'State', '29', '17', null, 'Active');
INSERT INTO `state` VALUES ('371', 'Khulna zila', 'State', '27', '17', null, 'Active');
INSERT INTO `state` VALUES ('372', 'Kishorganj zila', 'State', '26', '17', null, 'Active');
INSERT INTO `state` VALUES ('373', 'Kurigram zila', 'State', '28', '17', null, 'Active');
INSERT INTO `state` VALUES ('374', 'Kushtia zila', 'State', '30', '17', null, 'Active');
INSERT INTO `state` VALUES ('375', 'Lakshmipur zila', 'State', '31', '17', null, 'Active');
INSERT INTO `state` VALUES ('376', 'Lalmonirhat zila', 'State', '32', '17', null, 'Active');
INSERT INTO `state` VALUES ('377', 'Madaripur zila', 'State', '36', '17', null, 'Active');
INSERT INTO `state` VALUES ('378', 'Magura zila', 'State', '37', '17', null, 'Active');
INSERT INTO `state` VALUES ('379', 'Manikganj zila', 'State', '33', '17', null, 'Active');
INSERT INTO `state` VALUES ('380', 'Meherpur zila', 'State', '39', '17', null, 'Active');
INSERT INTO `state` VALUES ('381', 'Moulvibazar zila', 'State', '38', '17', null, 'Active');
INSERT INTO `state` VALUES ('382', 'Munshiganj zila', 'State', '35', '17', null, 'Active');
INSERT INTO `state` VALUES ('383', 'Mymensingh zila', 'State', '34', '17', null, 'Active');
INSERT INTO `state` VALUES ('384', 'Naogaon zila', 'State', '48', '17', null, 'Active');
INSERT INTO `state` VALUES ('385', 'Narail zila', 'State', '43', '17', null, 'Active');
INSERT INTO `state` VALUES ('386', 'Narayanganj zila', 'State', '40', '17', null, 'Active');
INSERT INTO `state` VALUES ('387', 'Narsingdi zila', 'State', '42', '17', null, 'Active');
INSERT INTO `state` VALUES ('388', 'Natore zila', 'State', '44', '17', null, 'Active');
INSERT INTO `state` VALUES ('389', 'Nawabganj zila', 'State', '45', '17', null, 'Active');
INSERT INTO `state` VALUES ('390', 'Netrakona zila', 'State', '41', '17', null, 'Active');
INSERT INTO `state` VALUES ('391', 'Nilphamari zila', 'State', '46', '17', null, 'Active');
INSERT INTO `state` VALUES ('392', 'Noakhali zila', 'State', '47', '17', null, 'Active');
INSERT INTO `state` VALUES ('393', 'Pabna zila', 'State', '49', '17', null, 'Active');
INSERT INTO `state` VALUES ('394', 'Panchagarh zila', 'State', '52', '17', null, 'Active');
INSERT INTO `state` VALUES ('395', 'Patuakhali zila', 'State', '51', '17', null, 'Active');
INSERT INTO `state` VALUES ('396', 'Pirojpur zila', 'State', '50', '17', null, 'Active');
INSERT INTO `state` VALUES ('397', 'Rajbari zila', 'State', '53', '17', null, 'Active');
INSERT INTO `state` VALUES ('398', 'Rajshahi zila', 'State', '54', '17', null, 'Active');
INSERT INTO `state` VALUES ('399', 'Rangamati zila', 'State', '56', '17', null, 'Active');
INSERT INTO `state` VALUES ('400', 'Rangpur zila', 'State', '55', '17', null, 'Active');
INSERT INTO `state` VALUES ('401', 'Satkhira zila', 'State', '58', '17', null, 'Active');
INSERT INTO `state` VALUES ('402', 'Shariatpur zila', 'State', '62', '17', null, 'Active');
INSERT INTO `state` VALUES ('403', 'Sherpur zila', 'State', '57', '17', null, 'Active');
INSERT INTO `state` VALUES ('404', 'Sirajganj zila', 'State', '59', '17', null, 'Active');
INSERT INTO `state` VALUES ('405', 'Sunamganj zila', 'State', '61', '17', null, 'Active');
INSERT INTO `state` VALUES ('406', 'Sylhet zila', 'State', '60', '17', null, 'Active');
INSERT INTO `state` VALUES ('407', 'Tangail zila', 'State', '63', '17', null, 'Active');
INSERT INTO `state` VALUES ('408', 'Thakurgaon zila', 'State', '64', '17', null, 'Active');
INSERT INTO `state` VALUES ('409', 'Antwerpen', 'State', 'VAN', '20', null, 'Active');
INSERT INTO `state` VALUES ('410', 'Brabant Wallon', 'State', 'WBR', '20', null, 'Active');
INSERT INTO `state` VALUES ('411', 'Hainaut', 'State', 'WHT', '20', null, 'Active');
INSERT INTO `state` VALUES ('412', 'Liege', 'State', 'WLG', '20', null, 'Active');
INSERT INTO `state` VALUES ('413', 'Limburg', 'State', 'VLI', '20', null, 'Active');
INSERT INTO `state` VALUES ('414', 'Luxembourg', 'State', 'WLX', '20', null, 'Active');
INSERT INTO `state` VALUES ('415', 'Namur', 'State', 'WNA', '20', null, 'Active');
INSERT INTO `state` VALUES ('416', 'Oost-Vlaanderen', 'State', 'VOV', '20', null, 'Active');
INSERT INTO `state` VALUES ('417', 'Vlaams-Brabant', 'State', 'VBR', '20', null, 'Active');
INSERT INTO `state` VALUES ('418', 'West-Vlaanderen', 'State', 'VWV', '20', null, 'Active');
INSERT INTO `state` VALUES ('419', 'Bale', 'State', 'BAL', '34', null, 'Active');
INSERT INTO `state` VALUES ('420', 'Bam', 'State', 'BAM', '34', null, 'Active');
INSERT INTO `state` VALUES ('421', 'Banwa', 'State', 'BAN', '34', null, 'Active');
INSERT INTO `state` VALUES ('422', 'Bazega', 'State', 'BAZ', '34', null, 'Active');
INSERT INTO `state` VALUES ('423', 'Bougouriba', 'State', 'BGR', '34', null, 'Active');
INSERT INTO `state` VALUES ('424', 'Boulgou', 'State', 'BLG', '34', null, 'Active');
INSERT INTO `state` VALUES ('425', 'Boulkiemde', 'State', 'BLK', '34', null, 'Active');
INSERT INTO `state` VALUES ('426', 'Comoe', 'State', 'COM', '34', null, 'Active');
INSERT INTO `state` VALUES ('427', 'Ganzourgou', 'State', 'GAN', '34', null, 'Active');
INSERT INTO `state` VALUES ('428', 'Gnagna', 'State', 'GNA', '34', null, 'Active');
INSERT INTO `state` VALUES ('429', 'Gourma', 'State', 'GOU', '34', null, 'Active');
INSERT INTO `state` VALUES ('430', 'Houet', 'State', 'HOU', '34', null, 'Active');
INSERT INTO `state` VALUES ('431', 'Ioba', 'State', 'IOB', '34', null, 'Active');
INSERT INTO `state` VALUES ('432', 'Kadiogo', 'State', 'KAD', '34', null, 'Active');
INSERT INTO `state` VALUES ('433', 'Kenedougou', 'State', 'KEN', '34', null, 'Active');
INSERT INTO `state` VALUES ('434', 'Komondjari', 'State', 'KMD', '34', null, 'Active');
INSERT INTO `state` VALUES ('435', 'Kompienga', 'State', 'KMP', '34', null, 'Active');
INSERT INTO `state` VALUES ('436', 'Kossi', 'State', 'KOS', '34', null, 'Active');
INSERT INTO `state` VALUES ('437', 'Koulpulogo', 'State', 'KOP', '34', null, 'Active');
INSERT INTO `state` VALUES ('438', 'Kouritenga', 'State', 'KOT', '34', null, 'Active');
INSERT INTO `state` VALUES ('439', 'Kourweogo', 'State', 'KOW', '34', null, 'Active');
INSERT INTO `state` VALUES ('440', 'Leraba', 'State', 'LER', '34', null, 'Active');
INSERT INTO `state` VALUES ('441', 'Loroum', 'State', 'LOR', '34', null, 'Active');
INSERT INTO `state` VALUES ('442', 'Mouhoun', 'State', 'MOU', '34', null, 'Active');
INSERT INTO `state` VALUES ('443', 'Nahouri', 'State', 'NAO', '34', null, 'Active');
INSERT INTO `state` VALUES ('444', 'Namentenga', 'State', 'NAM', '34', null, 'Active');
INSERT INTO `state` VALUES ('445', 'Nayala', 'State', 'NAY', '34', null, 'Active');
INSERT INTO `state` VALUES ('446', 'Noumbiel', 'State', 'NOU', '34', null, 'Active');
INSERT INTO `state` VALUES ('447', 'Oubritenga', 'State', 'OUB', '34', null, 'Active');
INSERT INTO `state` VALUES ('448', 'Oudalan', 'State', 'OUD', '34', null, 'Active');
INSERT INTO `state` VALUES ('449', 'Passore', 'State', 'PAS', '34', null, 'Active');
INSERT INTO `state` VALUES ('450', 'Poni', 'State', 'PON', '34', null, 'Active');
INSERT INTO `state` VALUES ('451', 'Sanguie', 'State', 'SNG', '34', null, 'Active');
INSERT INTO `state` VALUES ('452', 'Sanmatenga', 'State', 'SMT', '34', null, 'Active');
INSERT INTO `state` VALUES ('453', 'Seno', 'State', 'SEN', '34', null, 'Active');
INSERT INTO `state` VALUES ('454', 'Siasili', 'State', 'SIS', '34', null, 'Active');
INSERT INTO `state` VALUES ('455', 'Soum', 'State', 'SOM', '34', null, 'Active');
INSERT INTO `state` VALUES ('456', 'Sourou', 'State', 'SOR', '34', null, 'Active');
INSERT INTO `state` VALUES ('457', 'Tapoa', 'State', 'TAP', '34', null, 'Active');
INSERT INTO `state` VALUES ('458', 'Tui', 'State', 'TUI', '34', null, 'Active');
INSERT INTO `state` VALUES ('459', 'Yagha', 'State', 'YAG', '34', null, 'Active');
INSERT INTO `state` VALUES ('460', 'Yatenga', 'State', 'YAT', '34', null, 'Active');
INSERT INTO `state` VALUES ('461', 'Ziro', 'State', 'ZIR', '34', null, 'Active');
INSERT INTO `state` VALUES ('462', 'Zondoma', 'State', 'ZON', '34', null, 'Active');
INSERT INTO `state` VALUES ('463', 'Zoundweogo', 'State', 'ZOU', '34', null, 'Active');
INSERT INTO `state` VALUES ('464', 'Blagoevgrad', 'State', '01', '33', null, 'Active');
INSERT INTO `state` VALUES ('465', 'Burgas', 'State', '02', '33', null, 'Active');
INSERT INTO `state` VALUES ('466', 'Dobric', 'State', '08', '33', null, 'Active');
INSERT INTO `state` VALUES ('467', 'Gabrovo', 'State', '07', '33', null, 'Active');
INSERT INTO `state` VALUES ('468', 'Haskovo', 'State', '26', '33', null, 'Active');
INSERT INTO `state` VALUES ('469', 'Jambol', 'State', '28', '33', null, 'Active');
INSERT INTO `state` VALUES ('470', 'Kardzali', 'State', '09', '33', null, 'Active');
INSERT INTO `state` VALUES ('471', 'Kjstendil', 'State', '10', '33', null, 'Active');
INSERT INTO `state` VALUES ('472', 'Lovec', 'State', '11', '33', null, 'Active');
INSERT INTO `state` VALUES ('473', 'Montana', 'State', '12', '33', null, 'Active');
INSERT INTO `state` VALUES ('474', 'Pazardzik', 'State', '13', '33', null, 'Active');
INSERT INTO `state` VALUES ('475', 'Pernik', 'State', '14', '33', null, 'Active');
INSERT INTO `state` VALUES ('476', 'Pleven', 'State', '15', '33', null, 'Active');
INSERT INTO `state` VALUES ('477', 'Plovdiv', 'State', '16', '33', null, 'Active');
INSERT INTO `state` VALUES ('478', 'Razgrad', 'State', '17', '33', null, 'Active');
INSERT INTO `state` VALUES ('479', 'Ruse', 'State', '18', '33', null, 'Active');
INSERT INTO `state` VALUES ('480', 'Silistra', 'State', '19', '33', null, 'Active');
INSERT INTO `state` VALUES ('481', 'Sliven', 'State', '20', '33', null, 'Active');
INSERT INTO `state` VALUES ('482', 'Smoljan', 'State', '21', '33', null, 'Active');
INSERT INTO `state` VALUES ('483', 'Sofia', 'State', '23', '33', null, 'Active');
INSERT INTO `state` VALUES ('484', 'Stara Zagora', 'State', '24', '33', null, 'Active');
INSERT INTO `state` VALUES ('485', 'Sumen', 'State', '27', '33', null, 'Active');
INSERT INTO `state` VALUES ('486', 'Targoviste', 'State', '25', '33', null, 'Active');
INSERT INTO `state` VALUES ('487', 'Varna', 'State', '03', '33', null, 'Active');
INSERT INTO `state` VALUES ('488', 'Veliko Tarnovo', 'State', '04', '33', null, 'Active');
INSERT INTO `state` VALUES ('489', 'Vidin', 'State', '05', '33', null, 'Active');
INSERT INTO `state` VALUES ('490', 'Vraca', 'State', '06', '33', null, 'Active');
INSERT INTO `state` VALUES ('491', 'Al Hadd', 'State', '01', '16', null, 'Active');
INSERT INTO `state` VALUES ('492', 'Al Manamah', 'State', '03', '16', null, 'Active');
INSERT INTO `state` VALUES ('493', 'Al Mintaqah al Gharbiyah', 'State', '10', '16', null, 'Active');
INSERT INTO `state` VALUES ('494', 'Al Mintagah al Wusta', 'State', '07', '16', null, 'Active');
INSERT INTO `state` VALUES ('495', 'Al Mintaqah ash Shamaliyah', 'State', '05', '16', null, 'Active');
INSERT INTO `state` VALUES ('496', 'Al Muharraq', 'State', '02', '16', null, 'Active');
INSERT INTO `state` VALUES ('497', 'Ar Rifa', 'State', '09', '16', null, 'Active');
INSERT INTO `state` VALUES ('498', 'Jidd Hafs', 'State', '04', '16', null, 'Active');
INSERT INTO `state` VALUES ('499', 'Madluat Jamad', 'State', '12', '16', null, 'Active');
INSERT INTO `state` VALUES ('500', 'Madluat Isa', 'State', '08', '16', null, 'Active');
INSERT INTO `state` VALUES ('501', 'Mintaqat Juzur tawar', 'State', '11', '16', null, 'Active');
INSERT INTO `state` VALUES ('502', 'Sitrah', 'State', '06', '16', null, 'Active');
INSERT INTO `state` VALUES ('503', 'Bubanza', 'State', 'BB', '36', null, 'Active');
INSERT INTO `state` VALUES ('504', 'Bujumbura', 'State', 'BJ', '36', null, 'Active');
INSERT INTO `state` VALUES ('505', 'Bururi', 'State', 'BR', '36', null, 'Active');
INSERT INTO `state` VALUES ('506', 'Cankuzo', 'State', 'CA', '36', null, 'Active');
INSERT INTO `state` VALUES ('507', 'Cibitoke', 'State', 'CI', '36', null, 'Active');
INSERT INTO `state` VALUES ('508', 'Gitega', 'State', 'GI', '36', null, 'Active');
INSERT INTO `state` VALUES ('509', 'Karuzi', 'State', 'KR', '36', null, 'Active');
INSERT INTO `state` VALUES ('510', 'Kayanza', 'State', 'KY', '36', null, 'Active');
INSERT INTO `state` VALUES ('511', 'Makamba', 'State', 'MA', '36', null, 'Active');
INSERT INTO `state` VALUES ('512', 'Muramvya', 'State', 'MU', '36', null, 'Active');
INSERT INTO `state` VALUES ('513', 'Mwaro', 'State', 'MW', '36', null, 'Active');
INSERT INTO `state` VALUES ('514', 'Ngozi', 'State', 'NG', '36', null, 'Active');
INSERT INTO `state` VALUES ('515', 'Rutana', 'State', 'RT', '36', null, 'Active');
INSERT INTO `state` VALUES ('516', 'Ruyigi', 'State', 'RY', '36', null, 'Active');
INSERT INTO `state` VALUES ('517', 'Alibori', 'State', 'AL', '22', null, 'Active');
INSERT INTO `state` VALUES ('518', 'Atakora', 'State', 'AK', '22', null, 'Active');
INSERT INTO `state` VALUES ('519', 'Atlantique', 'State', 'AQ', '22', null, 'Active');
INSERT INTO `state` VALUES ('520', 'Borgou', 'State', 'BO', '22', null, 'Active');
INSERT INTO `state` VALUES ('521', 'Collines', 'State', 'CO', '22', null, 'Active');
INSERT INTO `state` VALUES ('522', 'Donga', 'State', 'DO', '22', null, 'Active');
INSERT INTO `state` VALUES ('523', 'Kouffo', 'State', 'KO', '22', null, 'Active');
INSERT INTO `state` VALUES ('524', 'Littoral', 'State', 'LI', '22', null, 'Active');
INSERT INTO `state` VALUES ('525', 'Mono', 'State', 'MO', '22', null, 'Active');
INSERT INTO `state` VALUES ('526', 'Oueme', 'State', 'OU', '22', null, 'Active');
INSERT INTO `state` VALUES ('527', 'Plateau', 'State', 'PL', '22', null, 'Active');
INSERT INTO `state` VALUES ('528', 'Zou', 'State', 'ZO', '22', null, 'Active');
INSERT INTO `state` VALUES ('529', 'Belait', 'State', 'BE', '32', null, 'Active');
INSERT INTO `state` VALUES ('530', 'Brunei-Muara', 'State', 'BM', '32', null, 'Active');
INSERT INTO `state` VALUES ('531', 'Temburong', 'State', 'TE', '32', null, 'Active');
INSERT INTO `state` VALUES ('532', 'Tutong', 'State', 'TU', '32', null, 'Active');
INSERT INTO `state` VALUES ('533', 'Cochabamba', 'State', 'C', '25', null, 'Active');
INSERT INTO `state` VALUES ('534', 'Chuquisaca', 'State', 'H', '25', null, 'Active');
INSERT INTO `state` VALUES ('535', 'El Beni', 'State', 'B', '25', null, 'Active');
INSERT INTO `state` VALUES ('536', 'La Paz', 'State', 'L', '25', null, 'Active');
INSERT INTO `state` VALUES ('537', 'Oruro', 'State', 'O', '25', null, 'Active');
INSERT INTO `state` VALUES ('538', 'Pando', 'State', 'N', '25', null, 'Active');
INSERT INTO `state` VALUES ('539', 'Potosi', 'State', 'P', '25', null, 'Active');
INSERT INTO `state` VALUES ('540', 'Tarija', 'State', 'T', '25', null, 'Active');
INSERT INTO `state` VALUES ('541', 'Acre', 'State', 'AC', '29', null, 'Active');
INSERT INTO `state` VALUES ('542', 'Alagoas', 'State', 'AL', '29', null, 'Active');
INSERT INTO `state` VALUES ('543', 'Amazonas', 'State', 'AM', '29', null, 'Active');
INSERT INTO `state` VALUES ('544', 'Amapa', 'State', 'AP', '29', null, 'Active');
INSERT INTO `state` VALUES ('545', 'Baia', 'State', 'BA', '29', null, 'Active');
INSERT INTO `state` VALUES ('546', 'Ceara', 'State', 'CE', '29', null, 'Active');
INSERT INTO `state` VALUES ('547', 'Distrito Federal', 'State', 'DF', '29', null, 'Active');
INSERT INTO `state` VALUES ('548', 'Espirito Santo', 'State', 'ES', '29', null, 'Active');
INSERT INTO `state` VALUES ('549', 'Fernando de Noronha', 'State', 'FN', '29', null, 'Active');
INSERT INTO `state` VALUES ('550', 'Goias', 'State', 'GO', '29', null, 'Active');
INSERT INTO `state` VALUES ('551', 'Maranhao', 'State', 'MA', '29', null, 'Active');
INSERT INTO `state` VALUES ('552', 'Minas Gerais', 'State', 'MG', '29', null, 'Active');
INSERT INTO `state` VALUES ('553', 'Mato Grosso do Sul', 'State', 'MS', '29', null, 'Active');
INSERT INTO `state` VALUES ('554', 'Mato Grosso', 'State', 'MT', '29', null, 'Active');
INSERT INTO `state` VALUES ('555', 'Para', 'State', 'PA', '29', null, 'Active');
INSERT INTO `state` VALUES ('556', 'Paraiba', 'State', 'PB', '29', null, 'Active');
INSERT INTO `state` VALUES ('557', 'Pernambuco', 'State', 'PE', '29', null, 'Active');
INSERT INTO `state` VALUES ('558', 'Piaui', 'State', 'PI', '29', null, 'Active');
INSERT INTO `state` VALUES ('559', 'Parana', 'State', 'PR', '29', null, 'Active');
INSERT INTO `state` VALUES ('560', 'Rio de Janeiro', 'State', 'RJ', '29', null, 'Active');
INSERT INTO `state` VALUES ('561', 'Rio Grande do Norte', 'State', 'RN', '29', null, 'Active');
INSERT INTO `state` VALUES ('562', 'Rondonia', 'State', 'RO', '29', null, 'Active');
INSERT INTO `state` VALUES ('563', 'Roraima', 'State', 'RR', '29', null, 'Active');
INSERT INTO `state` VALUES ('564', 'Rio Grande do Sul', 'State', 'RS', '29', null, 'Active');
INSERT INTO `state` VALUES ('565', 'Santa Catarina', 'State', 'SC', '29', null, 'Active');
INSERT INTO `state` VALUES ('566', 'Sergipe', 'State', 'SE', '29', null, 'Active');
INSERT INTO `state` VALUES ('567', 'Sao Paulo', 'State', 'SP', '29', null, 'Active');
INSERT INTO `state` VALUES ('568', 'Tocatins', 'State', 'TO', '29', null, 'Active');
INSERT INTO `state` VALUES ('569', 'Acklins and Crooked Islands', 'State', 'AC', '211', null, 'Active');
INSERT INTO `state` VALUES ('570', 'Bimini', 'State', 'BI', '211', null, 'Active');
INSERT INTO `state` VALUES ('571', 'Cat Island', 'State', 'CI', '211', null, 'Active');
INSERT INTO `state` VALUES ('572', 'Exuma', 'State', 'EX', '211', null, 'Active');
INSERT INTO `state` VALUES ('573', 'Freeport', 'State', 'FP', '211', null, 'Active');
INSERT INTO `state` VALUES ('574', 'Fresh Creek', 'State', 'FC', '211', null, 'Active');
INSERT INTO `state` VALUES ('575', 'Governor\'s Harbour', 'State', 'GH', '211', null, 'Active');
INSERT INTO `state` VALUES ('576', 'Green Turtle Cay', 'State', 'GT', '211', null, 'Active');
INSERT INTO `state` VALUES ('577', 'Harbour Island', 'State', 'HI', '211', null, 'Active');
INSERT INTO `state` VALUES ('578', 'High Rock', 'State', 'HR', '211', null, 'Active');
INSERT INTO `state` VALUES ('579', 'Inagua', 'State', 'IN', '211', null, 'Active');
INSERT INTO `state` VALUES ('580', 'Kemps Bay', 'State', 'KB', '211', null, 'Active');
INSERT INTO `state` VALUES ('581', 'Long Island', 'State', 'LI', '211', null, 'Active');
INSERT INTO `state` VALUES ('582', 'Marsh Harbour', 'State', 'MH', '211', null, 'Active');
INSERT INTO `state` VALUES ('583', 'Mayaguana', 'State', 'MG', '211', null, 'Active');
INSERT INTO `state` VALUES ('584', 'New Providence', 'State', 'NP', '211', null, 'Active');
INSERT INTO `state` VALUES ('585', 'Nicholls Town and Berry Islands', 'State', 'NB', '211', null, 'Active');
INSERT INTO `state` VALUES ('586', 'Ragged Island', 'State', 'RI', '211', null, 'Active');
INSERT INTO `state` VALUES ('587', 'Rock Sound', 'State', 'RS', '211', null, 'Active');
INSERT INTO `state` VALUES ('588', 'Sandy Point', 'State', 'SP', '211', null, 'Active');
INSERT INTO `state` VALUES ('589', 'San Salvador and Rum Cay', 'State', 'SR', '211', null, 'Active');
INSERT INTO `state` VALUES ('590', 'Bumthang', 'State', '33', '24', null, 'Active');
INSERT INTO `state` VALUES ('591', 'Chhukha', 'State', '12', '24', null, 'Active');
INSERT INTO `state` VALUES ('592', 'Dagana', 'State', '22', '24', null, 'Active');
INSERT INTO `state` VALUES ('593', 'Gasa', 'State', 'GA', '24', null, 'Active');
INSERT INTO `state` VALUES ('594', 'Ha', 'State', '13', '24', null, 'Active');
INSERT INTO `state` VALUES ('595', 'Lhuentse', 'State', '44', '24', null, 'Active');
INSERT INTO `state` VALUES ('596', 'Monggar', 'State', '42', '24', null, 'Active');
INSERT INTO `state` VALUES ('597', 'Paro', 'State', '11', '24', null, 'Active');
INSERT INTO `state` VALUES ('598', 'Pemagatshel', 'State', '43', '24', null, 'Active');
INSERT INTO `state` VALUES ('599', 'Punakha', 'State', '23', '24', null, 'Active');
INSERT INTO `state` VALUES ('600', 'Samdrup Jongkha', 'State', '45', '24', null, 'Active');
INSERT INTO `state` VALUES ('601', 'Samtee', 'State', '14', '24', null, 'Active');
INSERT INTO `state` VALUES ('602', 'Sarpang', 'State', '31', '24', null, 'Active');
INSERT INTO `state` VALUES ('603', 'Thimphu', 'State', '15', '24', null, 'Active');
INSERT INTO `state` VALUES ('604', 'Trashigang', 'State', '41', '24', null, 'Active');
INSERT INTO `state` VALUES ('605', 'Trashi Yangtse', 'State', 'TY', '24', null, 'Active');
INSERT INTO `state` VALUES ('606', 'Trongsa', 'State', '32', '24', null, 'Active');
INSERT INTO `state` VALUES ('607', 'Tsirang', 'State', '21', '24', null, 'Active');
INSERT INTO `state` VALUES ('608', 'Wangdue Phodrang', 'State', '24', '24', null, 'Active');
INSERT INTO `state` VALUES ('609', 'Zhemgang', 'State', '34', '24', null, 'Active');
INSERT INTO `state` VALUES ('610', 'Central', 'State', 'CE', '27', null, 'Active');
INSERT INTO `state` VALUES ('611', 'Ghanzi', 'State', 'GH', '27', null, 'Active');
INSERT INTO `state` VALUES ('612', 'Kgalagadi', 'State', 'KG', '27', null, 'Active');
INSERT INTO `state` VALUES ('613', 'Kgatleng', 'State', 'KL', '27', null, 'Active');
INSERT INTO `state` VALUES ('614', 'Kweneng', 'State', 'KW', '27', null, 'Active');
INSERT INTO `state` VALUES ('615', 'Ngamiland', 'State', 'NG', '27', null, 'Active');
INSERT INTO `state` VALUES ('616', 'North-East', 'State', 'NE', '27', null, 'Active');
INSERT INTO `state` VALUES ('617', 'North-West', 'State', 'NW', '27', null, 'Active');
INSERT INTO `state` VALUES ('618', 'South-East', 'State', 'SE', '27', null, 'Active');
INSERT INTO `state` VALUES ('619', 'Southern', 'State', 'SO', '27', null, 'Active');
INSERT INTO `state` VALUES ('620', 'Brèsckaja voblasc\'', 'State', 'BR', '19', null, 'Active');
INSERT INTO `state` VALUES ('621', 'Homel\'skaja voblasc\'', 'State', 'HO', '19', null, 'Active');
INSERT INTO `state` VALUES ('622', 'Hrodzenskaja voblasc\'', 'State', 'HR', '19', null, 'Active');
INSERT INTO `state` VALUES ('623', 'Mahilëuskaja voblasc\'', 'State', 'MA', '19', null, 'Active');
INSERT INTO `state` VALUES ('624', 'Minskaja voblasc\'', 'State', 'MI', '19', null, 'Active');
INSERT INTO `state` VALUES ('625', 'Vicebskaja voblasc\'', 'State', 'VI', '19', null, 'Active');
INSERT INTO `state` VALUES ('626', 'Belize', 'State', 'BZ', '21', null, 'Active');
INSERT INTO `state` VALUES ('627', 'Cayo', 'State', 'CY', '21', null, 'Active');
INSERT INTO `state` VALUES ('628', 'Corozal', 'State', 'CZL', '21', null, 'Active');
INSERT INTO `state` VALUES ('629', 'Orange Walk', 'State', 'OW', '21', null, 'Active');
INSERT INTO `state` VALUES ('630', 'Stann Creek', 'State', 'SC', '21', null, 'Active');
INSERT INTO `state` VALUES ('631', 'Toledo', 'State', 'TOL', '21', null, 'Active');
INSERT INTO `state` VALUES ('632', 'Kinshasa', 'State', 'KN', '50', null, 'Active');
INSERT INTO `state` VALUES ('633', 'Bandundu', 'State', 'BN', '50', null, 'Active');
INSERT INTO `state` VALUES ('634', 'Bas-Congo', 'State', 'BC', '50', null, 'Active');
INSERT INTO `state` VALUES ('635', 'Equateur', 'State', 'EQ', '50', null, 'Active');
INSERT INTO `state` VALUES ('636', 'Haut-Congo', 'State', 'HC', '50', null, 'Active');
INSERT INTO `state` VALUES ('637', 'Kasai-Occidental', 'State', 'KW', '50', null, 'Active');
INSERT INTO `state` VALUES ('638', 'Kasai-Oriental', 'State', 'KE', '50', null, 'Active');
INSERT INTO `state` VALUES ('639', 'Katanga', 'State', 'KA', '50', null, 'Active');
INSERT INTO `state` VALUES ('640', 'Maniema', 'State', 'MA', '50', null, 'Active');
INSERT INTO `state` VALUES ('641', 'Nord-Kivu', 'State', 'NK', '50', null, 'Active');
INSERT INTO `state` VALUES ('642', 'Orientale', 'State', 'OR', '50', null, 'Active');
INSERT INTO `state` VALUES ('643', 'Sud-Kivu', 'State', 'SK', '50', null, 'Active');
INSERT INTO `state` VALUES ('644', 'Bangui', 'State', 'BGF', '42', null, 'Active');
INSERT INTO `state` VALUES ('645', 'Bamingui-Bangoran', 'State', 'BB', '42', null, 'Active');
INSERT INTO `state` VALUES ('646', 'Basse-Kotto', 'State', 'BK', '42', null, 'Active');
INSERT INTO `state` VALUES ('647', 'Haute-Kotto', 'State', 'HK', '42', null, 'Active');
INSERT INTO `state` VALUES ('648', 'Haut-Mbomou', 'State', 'HM', '42', null, 'Active');
INSERT INTO `state` VALUES ('649', 'Kemo', 'State', 'KG', '42', null, 'Active');
INSERT INTO `state` VALUES ('650', 'Lobaye', 'State', 'LB', '42', null, 'Active');
INSERT INTO `state` VALUES ('651', 'Mambere-Kadei', 'State', 'HS', '42', null, 'Active');
INSERT INTO `state` VALUES ('652', 'Mbomou', 'State', 'MB', '42', null, 'Active');
INSERT INTO `state` VALUES ('653', 'Nana-Grebizi', 'State', 'KB', '42', null, 'Active');
INSERT INTO `state` VALUES ('654', 'Nana-Mambere', 'State', 'NM', '42', null, 'Active');
INSERT INTO `state` VALUES ('655', 'Ombella-Mpoko', 'State', 'MP', '42', null, 'Active');
INSERT INTO `state` VALUES ('656', 'Ouaka', 'State', 'UK', '42', null, 'Active');
INSERT INTO `state` VALUES ('657', 'Ouham', 'State', 'AC', '42', null, 'Active');
INSERT INTO `state` VALUES ('658', 'Ouham-Pende', 'State', 'OP', '42', null, 'Active');
INSERT INTO `state` VALUES ('659', 'Sangha-Mbaere', 'State', 'SE', '42', null, 'Active');
INSERT INTO `state` VALUES ('660', 'Vakaga', 'State', 'VR', '42', null, 'Active');
INSERT INTO `state` VALUES ('661', 'Brazzaville', 'State', 'BZV', '51', null, 'Active');
INSERT INTO `state` VALUES ('662', 'Bouenza', 'State', '11', '51', null, 'Active');
INSERT INTO `state` VALUES ('663', 'Cuvette', 'State', '8', '51', null, 'Active');
INSERT INTO `state` VALUES ('664', 'Cuvette-Ouest', 'State', '15', '51', null, 'Active');
INSERT INTO `state` VALUES ('665', 'Kouilou', 'State', '5', '51', null, 'Active');
INSERT INTO `state` VALUES ('666', 'Lekoumou', 'State', '2', '51', null, 'Active');
INSERT INTO `state` VALUES ('667', 'Likouala', 'State', '7', '51', null, 'Active');
INSERT INTO `state` VALUES ('668', 'Niari', 'State', '9', '51', null, 'Active');
INSERT INTO `state` VALUES ('669', 'Plateaux', 'State', '14', '51', null, 'Active');
INSERT INTO `state` VALUES ('670', 'Pool', 'State', '12', '51', null, 'Active');
INSERT INTO `state` VALUES ('671', 'Sangha', 'State', '13', '51', null, 'Active');
INSERT INTO `state` VALUES ('672', 'Aargau', 'State', 'AG', '204', null, 'Active');
INSERT INTO `state` VALUES ('673', 'Appenzell Innerrhoden', 'State', 'AI', '204', null, 'Active');
INSERT INTO `state` VALUES ('674', 'Appenzell Ausserrhoden', 'State', 'AR', '204', null, 'Active');
INSERT INTO `state` VALUES ('675', 'Bern', 'State', 'BE', '204', null, 'Active');
INSERT INTO `state` VALUES ('676', 'Basel-Landschaft', 'State', 'BL', '204', null, 'Active');
INSERT INTO `state` VALUES ('677', 'Basel-Stadt', 'State', 'BS', '204', null, 'Active');
INSERT INTO `state` VALUES ('678', 'Fribourg', 'State', 'FR', '204', null, 'Active');
INSERT INTO `state` VALUES ('679', 'Geneva', 'State', 'GE', '204', null, 'Active');
INSERT INTO `state` VALUES ('680', 'Glarus', 'State', 'GL', '204', null, 'Active');
INSERT INTO `state` VALUES ('681', 'Graubunden', 'State', 'GR', '204', null, 'Active');
INSERT INTO `state` VALUES ('682', 'Jura', 'State', 'JU', '204', null, 'Active');
INSERT INTO `state` VALUES ('683', 'Luzern', 'State', 'LU', '204', null, 'Active');
INSERT INTO `state` VALUES ('684', 'Neuchatel', 'State', 'NE', '204', null, 'Active');
INSERT INTO `state` VALUES ('685', 'Nidwalden', 'State', 'NW', '204', null, 'Active');
INSERT INTO `state` VALUES ('686', 'Obwalden', 'State', 'OW', '204', null, 'Active');
INSERT INTO `state` VALUES ('687', 'Sankt Gallen', 'State', 'SG', '204', null, 'Active');
INSERT INTO `state` VALUES ('688', 'Schaffhausen', 'State', 'SH', '204', null, 'Active');
INSERT INTO `state` VALUES ('689', 'Solothurn', 'State', 'SO', '204', null, 'Active');
INSERT INTO `state` VALUES ('690', 'Schwyz', 'State', 'SZ', '204', null, 'Active');
INSERT INTO `state` VALUES ('691', 'Thurgau', 'State', 'TG', '204', null, 'Active');
INSERT INTO `state` VALUES ('692', 'Ticino', 'State', 'TI', '204', null, 'Active');
INSERT INTO `state` VALUES ('693', 'Uri', 'State', 'UR', '204', null, 'Active');
INSERT INTO `state` VALUES ('694', 'Vaud', 'State', 'VD', '204', null, 'Active');
INSERT INTO `state` VALUES ('695', 'Valais', 'State', 'VS', '204', null, 'Active');
INSERT INTO `state` VALUES ('696', 'Zug', 'State', 'ZG', '204', null, 'Active');
INSERT INTO `state` VALUES ('697', 'Zurich', 'State', 'ZH', '204', null, 'Active');
INSERT INTO `state` VALUES ('698', '18 Montagnes', 'State', '06', '54', null, 'Active');
INSERT INTO `state` VALUES ('699', 'Agnebi', 'State', '16', '54', null, 'Active');
INSERT INTO `state` VALUES ('700', 'Bas-Sassandra', 'State', '09', '54', null, 'Active');
INSERT INTO `state` VALUES ('701', 'Denguele', 'State', '10', '54', null, 'Active');
INSERT INTO `state` VALUES ('702', 'Haut-Sassandra', 'State', '02', '54', null, 'Active');
INSERT INTO `state` VALUES ('703', 'Lacs', 'State', '07', '54', null, 'Active');
INSERT INTO `state` VALUES ('704', 'Lagunes', 'State', '01', '54', null, 'Active');
INSERT INTO `state` VALUES ('705', 'Marahoue', 'State', '12', '54', null, 'Active');
INSERT INTO `state` VALUES ('706', 'Moyen-Comoe', 'State', '05', '54', null, 'Active');
INSERT INTO `state` VALUES ('707', 'Nzi-Comoe', 'State', '11', '54', null, 'Active');
INSERT INTO `state` VALUES ('708', 'Savanes', 'State', '03', '54', null, 'Active');
INSERT INTO `state` VALUES ('709', 'Sud-Bandama', 'State', '15', '54', null, 'Active');
INSERT INTO `state` VALUES ('710', 'Sud-Comoe', 'State', '13', '54', null, 'Active');
INSERT INTO `state` VALUES ('711', 'Vallee du Bandama', 'State', '04', '54', null, 'Active');
INSERT INTO `state` VALUES ('712', 'Worodouqou', 'State', '14', '54', null, 'Active');
INSERT INTO `state` VALUES ('713', 'Zanzan', 'State', '08', '54', null, 'Active');
INSERT INTO `state` VALUES ('714', 'Aisen del General Carlos Ibanez del Campo', 'State', 'AI', '44', null, 'Active');
INSERT INTO `state` VALUES ('715', 'Antofagasta', 'State', 'AN', '44', null, 'Active');
INSERT INTO `state` VALUES ('716', 'Araucania', 'State', 'AR', '44', null, 'Active');
INSERT INTO `state` VALUES ('717', 'Atacama', 'State', 'AT', '44', null, 'Active');
INSERT INTO `state` VALUES ('718', 'Bio-Bio', 'State', 'BI', '44', null, 'Active');
INSERT INTO `state` VALUES ('719', 'Coquimbo', 'State', 'CO', '44', null, 'Active');
INSERT INTO `state` VALUES ('720', 'Libertador General Bernardo O\'Higgins', 'State', 'LI', '44', null, 'Active');
INSERT INTO `state` VALUES ('721', 'Los Lagos', 'State', 'LL', '44', null, 'Active');
INSERT INTO `state` VALUES ('722', 'Magallanes', 'State', 'MA', '44', null, 'Active');
INSERT INTO `state` VALUES ('723', 'Maule', 'State', 'ML', '44', null, 'Active');
INSERT INTO `state` VALUES ('724', 'Region Metropolitana de Santiago', 'State', 'RM', '44', null, 'Active');
INSERT INTO `state` VALUES ('725', 'Tarapaca', 'State', 'TA', '44', null, 'Active');
INSERT INTO `state` VALUES ('726', 'Valparaiso', 'State', 'VS', '44', null, 'Active');
INSERT INTO `state` VALUES ('727', 'Adamaoua', 'State', 'AD', '38', null, 'Active');
INSERT INTO `state` VALUES ('728', 'Centre', 'State', 'CE', '38', null, 'Active');
INSERT INTO `state` VALUES ('729', 'East', 'State', 'ES', '38', null, 'Active');
INSERT INTO `state` VALUES ('730', 'Far North', 'State', 'EN', '38', null, 'Active');
INSERT INTO `state` VALUES ('731', 'North', 'State', 'NO', '38', null, 'Active');
INSERT INTO `state` VALUES ('732', 'South', 'State', 'SW', '38', null, 'Active');
INSERT INTO `state` VALUES ('733', 'South-West', 'State', 'SW', '38', null, 'Active');
INSERT INTO `state` VALUES ('734', 'West', 'State', 'OU', '38', null, 'Active');
INSERT INTO `state` VALUES ('735', 'Beijing', 'State', '11', '45', null, 'Active');
INSERT INTO `state` VALUES ('736', 'Chongqing', 'State', '50', '45', null, 'Active');
INSERT INTO `state` VALUES ('737', 'Shanghai', 'State', '31', '45', null, 'Active');
INSERT INTO `state` VALUES ('738', 'Tianjin', 'State', '12', '45', null, 'Active');
INSERT INTO `state` VALUES ('739', 'Anhui', 'State', '34', '45', null, 'Active');
INSERT INTO `state` VALUES ('740', 'Fujian', 'State', '35', '45', null, 'Active');
INSERT INTO `state` VALUES ('741', 'Gansu', 'State', '62', '45', null, 'Active');
INSERT INTO `state` VALUES ('742', 'Guangdong', 'State', '44', '45', null, 'Active');
INSERT INTO `state` VALUES ('743', 'Guizhou', 'State', '52', '45', null, 'Active');
INSERT INTO `state` VALUES ('744', 'Hainan', 'State', '46', '45', null, 'Active');
INSERT INTO `state` VALUES ('745', 'Hebei', 'State', '13', '45', null, 'Active');
INSERT INTO `state` VALUES ('746', 'Heilongjiang', 'State', '23', '45', null, 'Active');
INSERT INTO `state` VALUES ('747', 'Henan', 'State', '41', '45', null, 'Active');
INSERT INTO `state` VALUES ('748', 'Hubei', 'State', '42', '45', null, 'Active');
INSERT INTO `state` VALUES ('749', 'Hunan', 'State', '43', '45', null, 'Active');
INSERT INTO `state` VALUES ('750', 'Jiangsu', 'State', '32', '45', null, 'Active');
INSERT INTO `state` VALUES ('751', 'Jiangxi', 'State', '36', '45', null, 'Active');
INSERT INTO `state` VALUES ('752', 'Jilin', 'State', '22', '45', null, 'Active');
INSERT INTO `state` VALUES ('753', 'Liaoning', 'State', '21', '45', null, 'Active');
INSERT INTO `state` VALUES ('754', 'Qinghai', 'State', '63', '45', null, 'Active');
INSERT INTO `state` VALUES ('755', 'Shaanxi', 'State', '61', '45', null, 'Active');
INSERT INTO `state` VALUES ('756', 'Shandong', 'State', '37', '45', null, 'Active');
INSERT INTO `state` VALUES ('757', 'Shanxi', 'State', '14', '45', null, 'Active');
INSERT INTO `state` VALUES ('758', 'Sichuan', 'State', '51', '45', null, 'Active');
INSERT INTO `state` VALUES ('759', 'Taiwan', 'State', '71', '45', null, 'Active');
INSERT INTO `state` VALUES ('760', 'Yunnan', 'State', '53', '45', null, 'Active');
INSERT INTO `state` VALUES ('761', 'Zhejiang', 'State', '33', '45', null, 'Active');
INSERT INTO `state` VALUES ('762', 'Guangxi', 'State', '45', '45', null, 'Active');
INSERT INTO `state` VALUES ('763', 'Neia Mongol (mn)', 'State', '15', '45', null, 'Active');
INSERT INTO `state` VALUES ('764', 'Xinjiang', 'State', '65', '45', null, 'Active');
INSERT INTO `state` VALUES ('765', 'Xizang', 'State', '54', '45', null, 'Active');
INSERT INTO `state` VALUES ('766', 'Hong Kong', 'State', '91', '45', null, 'Active');
INSERT INTO `state` VALUES ('767', 'Macau', 'State', '92', '45', null, 'Active');
INSERT INTO `state` VALUES ('768', 'Distrito Capital de Bogotá', 'State', 'DC', '48', null, 'Active');
INSERT INTO `state` VALUES ('769', 'Amazonea', 'State', 'AMA', '48', null, 'Active');
INSERT INTO `state` VALUES ('770', 'Antioquia', 'State', 'ANT', '48', null, 'Active');
INSERT INTO `state` VALUES ('771', 'Arauca', 'State', 'ARA', '48', null, 'Active');
INSERT INTO `state` VALUES ('772', 'Atlántico', 'State', 'ATL', '48', null, 'Active');
INSERT INTO `state` VALUES ('773', 'Bolívar', 'State', 'BOL', '48', null, 'Active');
INSERT INTO `state` VALUES ('774', 'Boyacá', 'State', 'BOY', '48', null, 'Active');
INSERT INTO `state` VALUES ('775', 'Caldea', 'State', 'CAL', '48', null, 'Active');
INSERT INTO `state` VALUES ('776', 'Caquetá', 'State', 'CAQ', '48', null, 'Active');
INSERT INTO `state` VALUES ('777', 'Casanare', 'State', 'CAS', '48', null, 'Active');
INSERT INTO `state` VALUES ('778', 'Cauca', 'State', 'CAU', '48', null, 'Active');
INSERT INTO `state` VALUES ('779', 'Cesar', 'State', 'CES', '48', null, 'Active');
INSERT INTO `state` VALUES ('780', 'Córdoba', 'State', 'COR', '48', null, 'Active');
INSERT INTO `state` VALUES ('781', 'Cundinamarca', 'State', 'CUN', '48', null, 'Active');
INSERT INTO `state` VALUES ('782', 'Chocó', 'State', 'CHO', '48', null, 'Active');
INSERT INTO `state` VALUES ('783', 'Guainía', 'State', 'GUA', '48', null, 'Active');
INSERT INTO `state` VALUES ('784', 'Guaviare', 'State', 'GUV', '48', null, 'Active');
INSERT INTO `state` VALUES ('785', 'La Guajira', 'State', 'LAG', '48', null, 'Active');
INSERT INTO `state` VALUES ('786', 'Magdalena', 'State', 'MAG', '48', null, 'Active');
INSERT INTO `state` VALUES ('787', 'Meta', 'State', 'MET', '48', null, 'Active');
INSERT INTO `state` VALUES ('788', 'Nariño', 'State', 'NAR', '48', null, 'Active');
INSERT INTO `state` VALUES ('789', 'Norte de Santander', 'State', 'NSA', '48', null, 'Active');
INSERT INTO `state` VALUES ('790', 'Putumayo', 'State', 'PUT', '48', null, 'Active');
INSERT INTO `state` VALUES ('791', 'Quindio', 'State', 'QUI', '48', null, 'Active');
INSERT INTO `state` VALUES ('792', 'Risaralda', 'State', 'RIS', '48', null, 'Active');
INSERT INTO `state` VALUES ('793', 'San Andrés, Providencia y Santa Catalina', 'State', 'SAP', '48', null, 'Active');
INSERT INTO `state` VALUES ('794', 'Santander', 'State', 'SAN', '48', null, 'Active');
INSERT INTO `state` VALUES ('795', 'Sucre', 'State', 'SUC', '48', null, 'Active');
INSERT INTO `state` VALUES ('796', 'Tolima', 'State', 'TOL', '48', null, 'Active');
INSERT INTO `state` VALUES ('797', 'Valle del Cauca', 'State', 'VAC', '48', null, 'Active');
INSERT INTO `state` VALUES ('798', 'Vaupés', 'State', 'VAU', '48', null, 'Active');
INSERT INTO `state` VALUES ('799', 'Vichada', 'State', 'VID', '48', null, 'Active');
INSERT INTO `state` VALUES ('800', 'Alajuela', 'State', 'A', '53', null, 'Active');
INSERT INTO `state` VALUES ('801', 'Cartago', 'State', 'C', '53', null, 'Active');
INSERT INTO `state` VALUES ('802', 'Guanacaste', 'State', 'G', '53', null, 'Active');
INSERT INTO `state` VALUES ('803', 'Heredia', 'State', 'H', '53', null, 'Active');
INSERT INTO `state` VALUES ('804', 'Limon', 'State', 'L', '53', null, 'Active');
INSERT INTO `state` VALUES ('805', 'Puntarenas', 'State', 'P', '53', null, 'Active');
INSERT INTO `state` VALUES ('806', 'San Jose', 'State', 'SJ', '53', null, 'Active');
INSERT INTO `state` VALUES ('807', 'Camagey', 'State', '09', '56', null, 'Active');
INSERT INTO `state` VALUES ('808', 'Ciego de `vila', 'State', '08', '56', null, 'Active');
INSERT INTO `state` VALUES ('809', 'Cienfuegos', 'State', '06', '56', null, 'Active');
INSERT INTO `state` VALUES ('810', 'Ciudad de La Habana', 'State', '03', '56', null, 'Active');
INSERT INTO `state` VALUES ('811', 'Granma', 'State', '12', '56', null, 'Active');
INSERT INTO `state` VALUES ('812', 'Guantanamo', 'State', '14', '56', null, 'Active');
INSERT INTO `state` VALUES ('813', 'Holquin', 'State', '11', '56', null, 'Active');
INSERT INTO `state` VALUES ('814', 'La Habana', 'State', '02', '56', null, 'Active');
INSERT INTO `state` VALUES ('815', 'Las Tunas', 'State', '10', '56', null, 'Active');
INSERT INTO `state` VALUES ('816', 'Matanzas', 'State', '04', '56', null, 'Active');
INSERT INTO `state` VALUES ('817', 'Pinar del Rio', 'State', '01', '56', null, 'Active');
INSERT INTO `state` VALUES ('818', 'Sancti Spiritus', 'State', '07', '56', null, 'Active');
INSERT INTO `state` VALUES ('819', 'Santiago de Cuba', 'State', '13', '56', null, 'Active');
INSERT INTO `state` VALUES ('820', 'Villa Clara', 'State', '05', '56', null, 'Active');
INSERT INTO `state` VALUES ('821', 'Isla de la Juventud', 'State', '99', '56', null, 'Active');
INSERT INTO `state` VALUES ('822', 'Pinar del Roo', 'State', 'PR', '56', null, 'Active');
INSERT INTO `state` VALUES ('823', 'Ciego de Avila', 'State', 'CA', '56', null, 'Active');
INSERT INTO `state` VALUES ('824', 'Camagoey', 'State', 'CG', '56', null, 'Active');
INSERT INTO `state` VALUES ('825', 'Holgun', 'State', 'HO', '56', null, 'Active');
INSERT INTO `state` VALUES ('826', 'Sancti Spritus', 'State', 'SS', '56', null, 'Active');
INSERT INTO `state` VALUES ('827', 'Municipio Especial Isla de la Juventud', 'State', 'IJ', '56', null, 'Active');
INSERT INTO `state` VALUES ('828', 'Boa Vista', 'State', 'BV', '40', null, 'Active');
INSERT INTO `state` VALUES ('829', 'Brava', 'State', 'BR', '40', null, 'Active');
INSERT INTO `state` VALUES ('830', 'Calheta de Sao Miguel', 'State', 'CS', '40', null, 'Active');
INSERT INTO `state` VALUES ('831', 'Fogo', 'State', 'FO', '40', null, 'Active');
INSERT INTO `state` VALUES ('832', 'Maio', 'State', 'MA', '40', null, 'Active');
INSERT INTO `state` VALUES ('833', 'Mosteiros', 'State', 'MO', '40', null, 'Active');
INSERT INTO `state` VALUES ('834', 'Paul', 'State', 'PA', '40', null, 'Active');
INSERT INTO `state` VALUES ('835', 'Porto Novo', 'State', 'PN', '40', null, 'Active');
INSERT INTO `state` VALUES ('836', 'Praia', 'State', 'PR', '40', null, 'Active');
INSERT INTO `state` VALUES ('837', 'Ribeira Grande', 'State', 'RG', '40', null, 'Active');
INSERT INTO `state` VALUES ('838', 'Sal', 'State', 'SL', '40', null, 'Active');
INSERT INTO `state` VALUES ('839', 'Sao Domingos', 'State', 'SD', '40', null, 'Active');
INSERT INTO `state` VALUES ('840', 'Sao Filipe', 'State', 'SF', '40', null, 'Active');
INSERT INTO `state` VALUES ('841', 'Sao Nicolau', 'State', 'SN', '40', null, 'Active');
INSERT INTO `state` VALUES ('842', 'Sao Vicente', 'State', 'SV', '40', null, 'Active');
INSERT INTO `state` VALUES ('843', 'Tarrafal', 'State', 'TA', '40', null, 'Active');
INSERT INTO `state` VALUES ('844', 'Ammochostos Magusa', 'State', '04', '57', null, 'Active');
INSERT INTO `state` VALUES ('845', 'Keryneia', 'State', '06', '57', null, 'Active');
INSERT INTO `state` VALUES ('846', 'Larnaka', 'State', '03', '57', null, 'Active');
INSERT INTO `state` VALUES ('847', 'Lefkosia', 'State', '01', '57', null, 'Active');
INSERT INTO `state` VALUES ('848', 'Lemesos', 'State', '02', '57', null, 'Active');
INSERT INTO `state` VALUES ('849', 'Pafos', 'State', '05', '57', null, 'Active');
INSERT INTO `state` VALUES ('850', 'Jiho?eský kraj', 'State', 'JC', '58', null, 'Active');
INSERT INTO `state` VALUES ('851', 'Jihomoravský kraj', 'State', 'JM', '58', null, 'Active');
INSERT INTO `state` VALUES ('852', 'Karlovarský kraj', 'State', 'KA', '58', null, 'Active');
INSERT INTO `state` VALUES ('853', 'Královéhradecký kraj', 'State', 'KR', '58', null, 'Active');
INSERT INTO `state` VALUES ('854', 'Liberecký kraj', 'State', 'LI', '58', null, 'Active');
INSERT INTO `state` VALUES ('855', 'Moravskoslezský kraj', 'State', 'MO', '58', null, 'Active');
INSERT INTO `state` VALUES ('856', 'Olomoucký kraj', 'State', 'OL', '58', null, 'Active');
INSERT INTO `state` VALUES ('857', 'Pardubický kraj', 'State', 'PA', '58', null, 'Active');
INSERT INTO `state` VALUES ('858', 'Plze?ský kraj', 'State', 'PL', '58', null, 'Active');
INSERT INTO `state` VALUES ('859', 'Praha, hlavní m?sto', 'State', 'PR', '58', null, 'Active');
INSERT INTO `state` VALUES ('860', 'St?edo?eský kraj', 'State', 'ST', '58', null, 'Active');
INSERT INTO `state` VALUES ('861', 'Ústecký kraj', 'State', 'US', '58', null, 'Active');
INSERT INTO `state` VALUES ('862', 'Vyso?ina', 'State', 'VY', '58', null, 'Active');
INSERT INTO `state` VALUES ('863', 'Zlínský kraj', 'State', 'ZL', '58', null, 'Active');
INSERT INTO `state` VALUES ('864', 'Baden-Wuerttemberg', 'State', 'BW', '81', null, 'Active');
INSERT INTO `state` VALUES ('865', 'Bayern', 'State', 'BY', '81', null, 'Active');
INSERT INTO `state` VALUES ('866', 'Bremen', 'State', 'HB', '81', null, 'Active');
INSERT INTO `state` VALUES ('867', 'Hamburg', 'State', 'HH', '81', null, 'Active');
INSERT INTO `state` VALUES ('868', 'Hessen', 'State', 'HE', '81', null, 'Active');
INSERT INTO `state` VALUES ('869', 'Niedersachsen', 'State', 'NI', '81', null, 'Active');
INSERT INTO `state` VALUES ('870', 'Nordrhein-Westfalen', 'State', 'NW', '81', null, 'Active');
INSERT INTO `state` VALUES ('871', 'Rheinland-Pfalz', 'State', 'RP', '81', null, 'Active');
INSERT INTO `state` VALUES ('872', 'Saarland', 'State', 'SL', '81', null, 'Active');
INSERT INTO `state` VALUES ('873', 'Schleswig-Holstein', 'State', 'SH', '81', null, 'Active');
INSERT INTO `state` VALUES ('874', 'Berlin', 'State', 'BR', '81', null, 'Active');
INSERT INTO `state` VALUES ('875', 'Brandenburg', 'State', 'BB', '81', null, 'Active');
INSERT INTO `state` VALUES ('876', 'Mecklenburg-Vorpommern', 'State', 'MV', '81', null, 'Active');
INSERT INTO `state` VALUES ('877', 'Sachsen', 'State', 'SN', '81', null, 'Active');
INSERT INTO `state` VALUES ('878', 'Sachsen-Anhalt', 'State', 'ST', '81', null, 'Active');
INSERT INTO `state` VALUES ('879', 'Thueringen', 'State', 'TH', '81', null, 'Active');
INSERT INTO `state` VALUES ('880', 'Ali Sabiah', 'State', 'AS', '60', null, 'Active');
INSERT INTO `state` VALUES ('881', 'Dikhil', 'State', 'DI', '60', null, 'Active');
INSERT INTO `state` VALUES ('882', 'Djibouti', 'State', 'DJ', '60', null, 'Active');
INSERT INTO `state` VALUES ('883', 'Obock', 'State', 'OB', '60', null, 'Active');
INSERT INTO `state` VALUES ('884', 'Tadjoura', 'State', 'TA', '60', null, 'Active');
INSERT INTO `state` VALUES ('885', 'Frederiksberg', 'State', '147', '59', null, 'Active');
INSERT INTO `state` VALUES ('886', 'Copenhagen City', 'State', '101', '59', null, 'Active');
INSERT INTO `state` VALUES ('887', 'Copenhagen', 'State', '015', '59', null, 'Active');
INSERT INTO `state` VALUES ('888', 'Frederiksborg', 'State', '020', '59', null, 'Active');
INSERT INTO `state` VALUES ('889', 'Roskilde', 'State', '025', '59', null, 'Active');
INSERT INTO `state` VALUES ('890', 'Vestsjælland', 'State', '030', '59', null, 'Active');
INSERT INTO `state` VALUES ('891', 'Storstrøm', 'State', '035', '59', null, 'Active');
INSERT INTO `state` VALUES ('892', 'Bornholm', 'State', '040', '59', null, 'Active');
INSERT INTO `state` VALUES ('893', 'Fyn', 'State', '042', '59', null, 'Active');
INSERT INTO `state` VALUES ('894', 'South Jutland', 'State', '050', '59', null, 'Active');
INSERT INTO `state` VALUES ('895', 'Ribe', 'State', '055', '59', null, 'Active');
INSERT INTO `state` VALUES ('896', 'Vejle', 'State', '060', '59', null, 'Active');
INSERT INTO `state` VALUES ('897', 'Ringkjøbing', 'State', '065', '59', null, 'Active');
INSERT INTO `state` VALUES ('898', 'Århus', 'State', '070', '59', null, 'Active');
INSERT INTO `state` VALUES ('899', 'Viborg', 'State', '076', '59', null, 'Active');
INSERT INTO `state` VALUES ('900', 'North Jutland', 'State', '080', '59', null, 'Active');
INSERT INTO `state` VALUES ('901', 'Distrito Nacional (Santo Domingo)', 'State', '01', '62', null, 'Active');
INSERT INTO `state` VALUES ('902', 'Azua', 'State', '02', '62', null, 'Active');
INSERT INTO `state` VALUES ('903', 'Bahoruco', 'State', '03', '62', null, 'Active');
INSERT INTO `state` VALUES ('904', 'Barahona', 'State', '04', '62', null, 'Active');
INSERT INTO `state` VALUES ('905', 'Dajabón', 'State', '05', '62', null, 'Active');
INSERT INTO `state` VALUES ('906', 'Duarte', 'State', '06', '62', null, 'Active');
INSERT INTO `state` VALUES ('907', 'El Seybo [El Seibo]', 'State', '08', '62', null, 'Active');
INSERT INTO `state` VALUES ('908', 'Espaillat', 'State', '09', '62', null, 'Active');
INSERT INTO `state` VALUES ('909', 'Hato Mayor', 'State', '30', '62', null, 'Active');
INSERT INTO `state` VALUES ('910', 'Independencia', 'State', '10', '62', null, 'Active');
INSERT INTO `state` VALUES ('911', 'La Altagracia', 'State', '11', '62', null, 'Active');
INSERT INTO `state` VALUES ('912', 'La Estrelleta [Elias Pina]', 'State', '07', '62', null, 'Active');
INSERT INTO `state` VALUES ('913', 'La Romana', 'State', '12', '62', null, 'Active');
INSERT INTO `state` VALUES ('914', 'La Vega', 'State', '13', '62', null, 'Active');
INSERT INTO `state` VALUES ('915', 'Maroia Trinidad Sánchez', 'State', '14', '62', null, 'Active');
INSERT INTO `state` VALUES ('916', 'Monseñor Nouel', 'State', '28', '62', null, 'Active');
INSERT INTO `state` VALUES ('917', 'Monte Cristi', 'State', '15', '62', null, 'Active');
INSERT INTO `state` VALUES ('918', 'Monte Plata', 'State', '29', '62', null, 'Active');
INSERT INTO `state` VALUES ('919', 'Pedernales', 'State', '16', '62', null, 'Active');
INSERT INTO `state` VALUES ('920', 'Peravia', 'State', '17', '62', null, 'Active');
INSERT INTO `state` VALUES ('921', 'Puerto Plata', 'State', '18', '62', null, 'Active');
INSERT INTO `state` VALUES ('922', 'Salcedo', 'State', '19', '62', null, 'Active');
INSERT INTO `state` VALUES ('923', 'Samaná', 'State', '20', '62', null, 'Active');
INSERT INTO `state` VALUES ('924', 'San Cristóbal', 'State', '21', '62', null, 'Active');
INSERT INTO `state` VALUES ('925', 'San Pedro de Macorís', 'State', '23', '62', null, 'Active');
INSERT INTO `state` VALUES ('926', 'Sánchez Ramírez', 'State', '24', '62', null, 'Active');
INSERT INTO `state` VALUES ('927', 'Santiago', 'State', '25', '62', null, 'Active');
INSERT INTO `state` VALUES ('928', 'Santiago Rodríguez', 'State', '26', '62', null, 'Active');
INSERT INTO `state` VALUES ('929', 'Valverde', 'State', '27', '62', null, 'Active');
INSERT INTO `state` VALUES ('930', 'Adrar', 'State', '01', '3', null, 'Active');
INSERT INTO `state` VALUES ('931', 'Ain Defla', 'State', '44', '3', null, 'Active');
INSERT INTO `state` VALUES ('932', 'Ain Tmouchent', 'State', '46', '3', null, 'Active');
INSERT INTO `state` VALUES ('933', 'Alger', 'State', '16', '3', null, 'Active');
INSERT INTO `state` VALUES ('934', 'Annaba', 'State', '23', '3', null, 'Active');
INSERT INTO `state` VALUES ('935', 'Batna', 'State', '05', '3', null, 'Active');
INSERT INTO `state` VALUES ('936', 'Bechar', 'State', '08', '3', null, 'Active');
INSERT INTO `state` VALUES ('937', 'Bejaia', 'State', '06', '3', null, 'Active');
INSERT INTO `state` VALUES ('938', 'Biskra', 'State', '07', '3', null, 'Active');
INSERT INTO `state` VALUES ('939', 'Blida', 'State', '09', '3', null, 'Active');
INSERT INTO `state` VALUES ('940', 'Bordj Bou Arreridj', 'State', '34', '3', null, 'Active');
INSERT INTO `state` VALUES ('941', 'Bouira', 'State', '10', '3', null, 'Active');
INSERT INTO `state` VALUES ('942', 'Boumerdes', 'State', '35', '3', null, 'Active');
INSERT INTO `state` VALUES ('943', 'Chlef', 'State', '02', '3', null, 'Active');
INSERT INTO `state` VALUES ('944', 'Constantine', 'State', '25', '3', null, 'Active');
INSERT INTO `state` VALUES ('945', 'Djelfa', 'State', '17', '3', null, 'Active');
INSERT INTO `state` VALUES ('946', 'El Bayadh', 'State', '32', '3', null, 'Active');
INSERT INTO `state` VALUES ('947', 'El Oued', 'State', '39', '3', null, 'Active');
INSERT INTO `state` VALUES ('948', 'El Tarf', 'State', '36', '3', null, 'Active');
INSERT INTO `state` VALUES ('949', 'Ghardaia', 'State', '47', '3', null, 'Active');
INSERT INTO `state` VALUES ('950', 'Guelma', 'State', '24', '3', null, 'Active');
INSERT INTO `state` VALUES ('951', 'Illizi', 'State', '33', '3', null, 'Active');
INSERT INTO `state` VALUES ('952', 'Jijel', 'State', '18', '3', null, 'Active');
INSERT INTO `state` VALUES ('953', 'Khenchela', 'State', '40', '3', null, 'Active');
INSERT INTO `state` VALUES ('954', 'Laghouat', 'State', '03', '3', null, 'Active');
INSERT INTO `state` VALUES ('955', 'Mascara', 'State', '29', '3', null, 'Active');
INSERT INTO `state` VALUES ('956', 'Medea', 'State', '26', '3', null, 'Active');
INSERT INTO `state` VALUES ('957', 'Mila', 'State', '43', '3', null, 'Active');
INSERT INTO `state` VALUES ('958', 'Mostaganem', 'State', '27', '3', null, 'Active');
INSERT INTO `state` VALUES ('959', 'Msila', 'State', '28', '3', null, 'Active');
INSERT INTO `state` VALUES ('960', 'Naama', 'State', '45', '3', null, 'Active');
INSERT INTO `state` VALUES ('961', 'Oran', 'State', '31', '3', null, 'Active');
INSERT INTO `state` VALUES ('962', 'Ouargla', 'State', '30', '3', null, 'Active');
INSERT INTO `state` VALUES ('963', 'Oum el Bouaghi', 'State', '04', '3', null, 'Active');
INSERT INTO `state` VALUES ('964', 'Relizane', 'State', '48', '3', null, 'Active');
INSERT INTO `state` VALUES ('965', 'Saida', 'State', '20', '3', null, 'Active');
INSERT INTO `state` VALUES ('966', 'Setif', 'State', '19', '3', null, 'Active');
INSERT INTO `state` VALUES ('967', 'Sidi Bel Abbes', 'State', '22', '3', null, 'Active');
INSERT INTO `state` VALUES ('968', 'Skikda', 'State', '21', '3', null, 'Active');
INSERT INTO `state` VALUES ('969', 'Souk Ahras', 'State', '41', '3', null, 'Active');
INSERT INTO `state` VALUES ('970', 'Tamanghasset', 'State', '11', '3', null, 'Active');
INSERT INTO `state` VALUES ('971', 'Tebessa', 'State', '12', '3', null, 'Active');
INSERT INTO `state` VALUES ('972', 'Tiaret', 'State', '14', '3', null, 'Active');
INSERT INTO `state` VALUES ('973', 'Tindouf', 'State', '37', '3', null, 'Active');
INSERT INTO `state` VALUES ('974', 'Tipaza', 'State', '42', '3', null, 'Active');
INSERT INTO `state` VALUES ('975', 'Tissemsilt', 'State', '38', '3', null, 'Active');
INSERT INTO `state` VALUES ('976', 'Tizi Ouzou', 'State', '15', '3', null, 'Active');
INSERT INTO `state` VALUES ('977', 'Tlemcen', 'State', '13', '3', null, 'Active');
INSERT INTO `state` VALUES ('978', 'Azuay', 'State', 'A', '64', null, 'Active');
INSERT INTO `state` VALUES ('979', 'Bolivar', 'State', 'B', '64', null, 'Active');
INSERT INTO `state` VALUES ('980', 'Canar', 'State', 'F', '64', null, 'Active');
INSERT INTO `state` VALUES ('981', 'Carchi', 'State', 'C', '64', null, 'Active');
INSERT INTO `state` VALUES ('982', 'Cotopaxi', 'State', 'X', '64', null, 'Active');
INSERT INTO `state` VALUES ('983', 'Chimborazo', 'State', 'H', '64', null, 'Active');
INSERT INTO `state` VALUES ('984', 'El Oro', 'State', 'O', '64', null, 'Active');
INSERT INTO `state` VALUES ('985', 'Esmeraldas', 'State', 'E', '64', null, 'Active');
INSERT INTO `state` VALUES ('986', 'Galapagos', 'State', 'W', '64', null, 'Active');
INSERT INTO `state` VALUES ('987', 'Guayas', 'State', 'G', '64', null, 'Active');
INSERT INTO `state` VALUES ('988', 'Imbabura', 'State', 'I', '64', null, 'Active');
INSERT INTO `state` VALUES ('989', 'Loja', 'State', 'L', '64', null, 'Active');
INSERT INTO `state` VALUES ('990', 'Los Rios', 'State', 'R', '64', null, 'Active');
INSERT INTO `state` VALUES ('991', 'Manabi', 'State', 'M', '64', null, 'Active');
INSERT INTO `state` VALUES ('992', 'Morona-Santiago', 'State', 'S', '64', null, 'Active');
INSERT INTO `state` VALUES ('993', 'Napo', 'State', 'N', '64', null, 'Active');
INSERT INTO `state` VALUES ('994', 'Orellana', 'State', 'D', '64', null, 'Active');
INSERT INTO `state` VALUES ('995', 'Pastaza', 'State', 'Y', '64', null, 'Active');
INSERT INTO `state` VALUES ('996', 'Pichincha', 'State', 'P', '64', null, 'Active');
INSERT INTO `state` VALUES ('997', 'Sucumbios', 'State', 'U', '64', null, 'Active');
INSERT INTO `state` VALUES ('998', 'Tungurahua', 'State', 'T', '64', null, 'Active');
INSERT INTO `state` VALUES ('999', 'Zamora-Chinchipe', 'State', 'Z', '64', null, 'Active');
INSERT INTO `state` VALUES ('1000', 'Harjumsa', 'State', '37', '69', null, 'Active');
INSERT INTO `state` VALUES ('1001', 'Hitumea', 'State', '39', '69', null, 'Active');
INSERT INTO `state` VALUES ('1002', 'Ida-Virumsa', 'State', '44', '69', null, 'Active');
INSERT INTO `state` VALUES ('1003', 'Jogevamsa', 'State', '49', '69', null, 'Active');
INSERT INTO `state` VALUES ('1004', 'Jarvamsa', 'State', '51', '69', null, 'Active');
INSERT INTO `state` VALUES ('1005', 'Lasnemsa', 'State', '57', '69', null, 'Active');
INSERT INTO `state` VALUES ('1006', 'Laane-Virumaa', 'State', '59', '69', null, 'Active');
INSERT INTO `state` VALUES ('1007', 'Polvamea', 'State', '65', '69', null, 'Active');
INSERT INTO `state` VALUES ('1008', 'Parnumsa', 'State', '67', '69', null, 'Active');
INSERT INTO `state` VALUES ('1009', 'Raplamsa', 'State', '70', '69', null, 'Active');
INSERT INTO `state` VALUES ('1010', 'Saaremsa', 'State', '74', '69', null, 'Active');
INSERT INTO `state` VALUES ('1011', 'Tartumsa', 'State', '7B', '69', null, 'Active');
INSERT INTO `state` VALUES ('1012', 'Valgamaa', 'State', '82', '69', null, 'Active');
INSERT INTO `state` VALUES ('1013', 'Viljandimsa', 'State', '84', '69', null, 'Active');
INSERT INTO `state` VALUES ('1014', 'Vorumaa', 'State', '86', '69', null, 'Active');
INSERT INTO `state` VALUES ('1015', 'Ad Daqahllyah', 'State', 'DK', '65', null, 'Active');
INSERT INTO `state` VALUES ('1016', 'Al Bahr al Ahmar', 'State', 'BA', '65', null, 'Active');
INSERT INTO `state` VALUES ('1017', 'Al Buhayrah', 'State', 'BH', '65', null, 'Active');
INSERT INTO `state` VALUES ('1018', 'Al Fayym', 'State', 'FYM', '65', null, 'Active');
INSERT INTO `state` VALUES ('1019', 'Al Gharbiyah', 'State', 'GH', '65', null, 'Active');
INSERT INTO `state` VALUES ('1020', 'Al Iskandarlyah', 'State', 'ALX', '65', null, 'Active');
INSERT INTO `state` VALUES ('1021', 'Al Isma illyah', 'State', 'IS', '65', null, 'Active');
INSERT INTO `state` VALUES ('1022', 'Al Jizah', 'State', 'GZ', '65', null, 'Active');
INSERT INTO `state` VALUES ('1023', 'Al Minuflyah', 'State', 'MNF', '65', null, 'Active');
INSERT INTO `state` VALUES ('1024', 'Al Minya', 'State', 'MN', '65', null, 'Active');
INSERT INTO `state` VALUES ('1025', 'Al Qahirah', 'State', 'C', '65', null, 'Active');
INSERT INTO `state` VALUES ('1026', 'Al Qalyublyah', 'State', 'KB', '65', null, 'Active');
INSERT INTO `state` VALUES ('1027', 'Al Wadi al Jadid', 'State', 'WAD', '65', null, 'Active');
INSERT INTO `state` VALUES ('1028', 'Ash Sharqiyah', 'State', 'SHR', '65', null, 'Active');
INSERT INTO `state` VALUES ('1029', 'As Suways', 'State', 'SUZ', '65', null, 'Active');
INSERT INTO `state` VALUES ('1030', 'Aswan', 'State', 'ASN', '65', null, 'Active');
INSERT INTO `state` VALUES ('1031', 'Asyut', 'State', 'AST', '65', null, 'Active');
INSERT INTO `state` VALUES ('1032', 'Bani Suwayf', 'State', 'BNS', '65', null, 'Active');
INSERT INTO `state` VALUES ('1033', 'Bur Sa\'id', 'State', 'PTS', '65', null, 'Active');
INSERT INTO `state` VALUES ('1034', 'Dumyat', 'State', 'DT', '65', null, 'Active');
INSERT INTO `state` VALUES ('1035', 'Janub Sina\'', 'State', 'JS', '65', null, 'Active');
INSERT INTO `state` VALUES ('1036', 'Kafr ash Shaykh', 'State', 'KFS', '65', null, 'Active');
INSERT INTO `state` VALUES ('1037', 'Matruh', 'State', 'MT', '65', null, 'Active');
INSERT INTO `state` VALUES ('1038', 'Qina', 'State', 'KN', '65', null, 'Active');
INSERT INTO `state` VALUES ('1039', 'Shamal Sina\'', 'State', 'SIN', '65', null, 'Active');
INSERT INTO `state` VALUES ('1040', 'Suhaj', 'State', 'SHG', '65', null, 'Active');
INSERT INTO `state` VALUES ('1041', 'Anseba', 'State', 'AN', '68', null, 'Active');
INSERT INTO `state` VALUES ('1042', 'Debub', 'State', 'DU', '68', null, 'Active');
INSERT INTO `state` VALUES ('1043', 'Debubawi Keyih Bahri [Debub-Keih-Bahri]', 'State', 'DK', '68', null, 'Active');
INSERT INTO `state` VALUES ('1044', 'Gash-Barka', 'State', 'GB', '68', null, 'Active');
INSERT INTO `state` VALUES ('1045', 'Maakel [Maekel]', 'State', 'MA', '68', null, 'Active');
INSERT INTO `state` VALUES ('1046', 'Semenawi Keyih Bahri [Semien-Keih-Bahri]', 'State', 'SK', '68', null, 'Active');
INSERT INTO `state` VALUES ('1047', 'Álava', 'State', 'VI', '197', null, 'Active');
INSERT INTO `state` VALUES ('1048', 'Albacete', 'State', 'AB', '197', null, 'Active');
INSERT INTO `state` VALUES ('1049', 'Alicante', 'State', 'A', '197', null, 'Active');
INSERT INTO `state` VALUES ('1050', 'Almería', 'State', 'AL', '197', null, 'Active');
INSERT INTO `state` VALUES ('1051', 'Asturias', 'State', 'O', '197', null, 'Active');
INSERT INTO `state` VALUES ('1052', 'Ávila', 'State', 'AV', '197', null, 'Active');
INSERT INTO `state` VALUES ('1053', 'Badajoz', 'State', 'BA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1054', 'Baleares', 'State', 'PM', '197', null, 'Active');
INSERT INTO `state` VALUES ('1055', 'Barcelona', 'State', 'B', '197', null, 'Active');
INSERT INTO `state` VALUES ('1056', 'Burgos', 'State', 'BU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1057', 'Cáceres', 'State', 'CC', '197', null, 'Active');
INSERT INTO `state` VALUES ('1058', 'Cádiz', 'State', 'CA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1059', 'Cantabria', 'State', 'S', '197', null, 'Active');
INSERT INTO `state` VALUES ('1060', 'Castellón', 'State', 'CS', '197', null, 'Active');
INSERT INTO `state` VALUES ('1061', 'Ciudad Real', 'State', 'CR', '197', null, 'Active');
INSERT INTO `state` VALUES ('1062', 'Cuenca', 'State', 'CU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1063', 'Girona [Gerona]', 'State', 'GE', '197', null, 'Active');
INSERT INTO `state` VALUES ('1064', 'Granada', 'State', 'GR', '197', null, 'Active');
INSERT INTO `state` VALUES ('1065', 'Guadalajara', 'State', 'GU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1066', 'Guipúzcoa', 'State', 'SS', '197', null, 'Active');
INSERT INTO `state` VALUES ('1067', 'Huelva', 'State', 'H', '197', null, 'Active');
INSERT INTO `state` VALUES ('1068', 'Huesca', 'State', 'HU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1069', 'Jaén', 'State', 'J', '197', null, 'Active');
INSERT INTO `state` VALUES ('1070', 'La Coruña', 'State', 'C', '197', null, 'Active');
INSERT INTO `state` VALUES ('1071', 'La Rioja', 'State', 'LO', '197', null, 'Active');
INSERT INTO `state` VALUES ('1072', 'Las Palmas', 'State', 'GC', '197', null, 'Active');
INSERT INTO `state` VALUES ('1073', 'León', 'State', 'LE', '197', null, 'Active');
INSERT INTO `state` VALUES ('1074', 'Lleida [Lérida]', 'State', 'L', '197', null, 'Active');
INSERT INTO `state` VALUES ('1075', 'Lugo', 'State', 'LU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1076', 'Madrid', 'State', 'M', '197', null, 'Active');
INSERT INTO `state` VALUES ('1077', 'Málaga', 'State', 'MA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1078', 'Murcia', 'State', 'MU', '197', null, 'Active');
INSERT INTO `state` VALUES ('1079', 'Navarra', 'State', 'NA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1080', 'Ourense', 'State', 'OR', '197', null, 'Active');
INSERT INTO `state` VALUES ('1081', 'Palencia', 'State', 'P', '197', null, 'Active');
INSERT INTO `state` VALUES ('1082', 'Pontevedra', 'State', 'PO', '197', null, 'Active');
INSERT INTO `state` VALUES ('1083', 'Salamanca', 'State', 'SA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1084', 'Santa Cruz de Tenerife', 'State', 'TF', '197', null, 'Active');
INSERT INTO `state` VALUES ('1085', 'Segovia', 'State', 'SG', '197', null, 'Active');
INSERT INTO `state` VALUES ('1086', 'Sevilla', 'State', 'SE', '197', null, 'Active');
INSERT INTO `state` VALUES ('1087', 'Soria', 'State', 'SO', '197', null, 'Active');
INSERT INTO `state` VALUES ('1088', 'Tarragona', 'State', 'T', '197', null, 'Active');
INSERT INTO `state` VALUES ('1089', 'Teruel', 'State', 'TE', '197', null, 'Active');
INSERT INTO `state` VALUES ('1090', 'Valencia', 'State', 'V', '197', null, 'Active');
INSERT INTO `state` VALUES ('1091', 'Valladolid', 'State', 'VA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1092', 'Vizcaya', 'State', 'BI', '197', null, 'Active');
INSERT INTO `state` VALUES ('1093', 'Zamora', 'State', 'ZA', '197', null, 'Active');
INSERT INTO `state` VALUES ('1094', 'Zaragoza', 'State', 'Z', '197', null, 'Active');
INSERT INTO `state` VALUES ('1095', 'Ceuta', 'State', 'CE', '197', null, 'Active');
INSERT INTO `state` VALUES ('1096', 'Melilla', 'State', 'ML', '197', null, 'Active');
INSERT INTO `state` VALUES ('1097', 'Addis Ababa', 'State', 'AA', '70', null, 'Active');
INSERT INTO `state` VALUES ('1098', 'Dire Dawa', 'State', 'DD', '70', null, 'Active');
INSERT INTO `state` VALUES ('1099', 'Afar', 'State', 'AF', '70', null, 'Active');
INSERT INTO `state` VALUES ('1100', 'Amara', 'State', 'AM', '70', null, 'Active');
INSERT INTO `state` VALUES ('1101', 'Benshangul-Gumaz', 'State', 'BE', '70', null, 'Active');
INSERT INTO `state` VALUES ('1102', 'Gambela Peoples', 'State', 'GA', '70', null, 'Active');
INSERT INTO `state` VALUES ('1103', 'Harari People', 'State', 'HA', '70', null, 'Active');
INSERT INTO `state` VALUES ('1104', 'Oromia', 'State', 'OR', '70', null, 'Active');
INSERT INTO `state` VALUES ('1105', 'Somali', 'State', 'SO', '70', null, 'Active');
INSERT INTO `state` VALUES ('1106', 'Southern Nations, Nationalities and Peoples', 'State', 'SN', '70', null, 'Active');
INSERT INTO `state` VALUES ('1107', 'Tigrai', 'State', 'TI', '70', null, 'Active');
INSERT INTO `state` VALUES ('1108', 'Eastern', 'State', 'E', '73', null, 'Active');
INSERT INTO `state` VALUES ('1109', 'Northern', 'State', 'N', '73', null, 'Active');
INSERT INTO `state` VALUES ('1110', 'Western', 'State', 'W', '73', null, 'Active');
INSERT INTO `state` VALUES ('1111', 'Rotuma', 'State', 'R', '73', null, 'Active');
INSERT INTO `state` VALUES ('1112', 'Chuuk', 'State', 'TRK', '140', null, 'Active');
INSERT INTO `state` VALUES ('1113', 'Kosrae', 'State', 'KSA', '140', null, 'Active');
INSERT INTO `state` VALUES ('1114', 'Pohnpei', 'State', 'PNI', '140', null, 'Active');
INSERT INTO `state` VALUES ('1115', 'Yap', 'State', 'YAP', '140', null, 'Active');
INSERT INTO `state` VALUES ('1116', 'Ain', 'State', '01', '75', null, 'Active');
INSERT INTO `state` VALUES ('1117', 'Aisne', 'State', '02', '75', null, 'Active');
INSERT INTO `state` VALUES ('1118', 'Allier', 'State', '03', '75', null, 'Active');
INSERT INTO `state` VALUES ('1119', 'Alpes-de-Haute-Provence', 'State', '04', '75', null, 'Active');
INSERT INTO `state` VALUES ('1120', 'Alpes-Maritimes', 'State', '06', '75', null, 'Active');
INSERT INTO `state` VALUES ('1121', 'Ardèche', 'State', '07', '75', null, 'Active');
INSERT INTO `state` VALUES ('1122', 'Ardennes', 'State', '08', '75', null, 'Active');
INSERT INTO `state` VALUES ('1123', 'Ariège', 'State', '09', '75', null, 'Active');
INSERT INTO `state` VALUES ('1124', 'Aube', 'State', '10', '75', null, 'Active');
INSERT INTO `state` VALUES ('1125', 'Aude', 'State', '11', '75', null, 'Active');
INSERT INTO `state` VALUES ('1126', 'Aveyron', 'State', '12', '75', null, 'Active');
INSERT INTO `state` VALUES ('1127', 'Bas-Rhin', 'State', '67', '75', null, 'Active');
INSERT INTO `state` VALUES ('1128', 'Bouches-du-Rhône', 'State', '13', '75', null, 'Active');
INSERT INTO `state` VALUES ('1129', 'Calvados', 'State', '14', '75', null, 'Active');
INSERT INTO `state` VALUES ('1130', 'Cantal', 'State', '15', '75', null, 'Active');
INSERT INTO `state` VALUES ('1131', 'Charente', 'State', '16', '75', null, 'Active');
INSERT INTO `state` VALUES ('1132', 'Charente-Maritime', 'State', '17', '75', null, 'Active');
INSERT INTO `state` VALUES ('1133', 'Cher', 'State', '18', '75', null, 'Active');
INSERT INTO `state` VALUES ('1134', 'Corrèze', 'State', '19', '75', null, 'Active');
INSERT INTO `state` VALUES ('1135', 'Corse-du-Sud', 'State', '20A', '75', null, 'Active');
INSERT INTO `state` VALUES ('1136', 'Côte-d\'Or', 'State', '21', '75', null, 'Active');
INSERT INTO `state` VALUES ('1137', 'Côtes-d\'Armor', 'State', '22', '75', null, 'Active');
INSERT INTO `state` VALUES ('1138', 'Creuse', 'State', '23', '75', null, 'Active');
INSERT INTO `state` VALUES ('1139', 'Deux-Sèvres', 'State', '79', '75', null, 'Active');
INSERT INTO `state` VALUES ('1140', 'Dordogne', 'State', '24', '75', null, 'Active');
INSERT INTO `state` VALUES ('1141', 'Doubs', 'State', '25', '75', null, 'Active');
INSERT INTO `state` VALUES ('1142', 'Drôme', 'State', '26', '75', null, 'Active');
INSERT INTO `state` VALUES ('1143', 'Essonne', 'State', '91', '75', null, 'Active');
INSERT INTO `state` VALUES ('1144', 'Eure', 'State', '27', '75', null, 'Active');
INSERT INTO `state` VALUES ('1145', 'Eure-et-Loir', 'State', '28', '75', null, 'Active');
INSERT INTO `state` VALUES ('1146', 'Finistère', 'State', '29', '75', null, 'Active');
INSERT INTO `state` VALUES ('1147', 'Gard', 'State', '30', '75', null, 'Active');
INSERT INTO `state` VALUES ('1148', 'Gers', 'State', '32', '75', null, 'Active');
INSERT INTO `state` VALUES ('1149', 'Gironde', 'State', '33', '75', null, 'Active');
INSERT INTO `state` VALUES ('1150', 'Haut-Rhin', 'State', '68', '75', null, 'Active');
INSERT INTO `state` VALUES ('1151', 'Haute-Corse', 'State', '20B', '75', null, 'Active');
INSERT INTO `state` VALUES ('1152', 'Haute-Garonne', 'State', '31', '75', null, 'Active');
INSERT INTO `state` VALUES ('1153', 'Haute-Loire', 'State', '43', '75', null, 'Active');
INSERT INTO `state` VALUES ('1154', 'Haute-Saône', 'State', '70', '75', null, 'Active');
INSERT INTO `state` VALUES ('1155', 'Haute-Savoie', 'State', '74', '75', null, 'Active');
INSERT INTO `state` VALUES ('1156', 'Haute-Vienne', 'State', '87', '75', null, 'Active');
INSERT INTO `state` VALUES ('1157', 'Hautes-Alpes', 'State', '05', '75', null, 'Active');
INSERT INTO `state` VALUES ('1158', 'Hautes-Pyrénées', 'State', '65', '75', null, 'Active');
INSERT INTO `state` VALUES ('1159', 'Hauts-de-Seine', 'State', '92', '75', null, 'Active');
INSERT INTO `state` VALUES ('1160', 'Hérault', 'State', '34', '75', null, 'Active');
INSERT INTO `state` VALUES ('1161', 'Indre', 'State', '36', '75', null, 'Active');
INSERT INTO `state` VALUES ('1162', 'Ille-et-Vilaine', 'State', '35', '75', null, 'Active');
INSERT INTO `state` VALUES ('1163', 'Indre-et-Loire', 'State', '37', '75', null, 'Active');
INSERT INTO `state` VALUES ('1164', 'Isère', 'State', '38', '75', null, 'Active');
INSERT INTO `state` VALUES ('1165', 'Landes', 'State', '40', '75', null, 'Active');
INSERT INTO `state` VALUES ('1166', 'Loir-et-Cher', 'State', '41', '75', null, 'Active');
INSERT INTO `state` VALUES ('1167', 'Loire', 'State', '42', '75', null, 'Active');
INSERT INTO `state` VALUES ('1168', 'Loire-Atlantique', 'State', '44', '75', null, 'Active');
INSERT INTO `state` VALUES ('1169', 'Loiret', 'State', '45', '75', null, 'Active');
INSERT INTO `state` VALUES ('1170', 'Lot', 'State', '46', '75', null, 'Active');
INSERT INTO `state` VALUES ('1171', 'Lot-et-Garonne', 'State', '47', '75', null, 'Active');
INSERT INTO `state` VALUES ('1172', 'Lozère', 'State', '48', '75', null, 'Active');
INSERT INTO `state` VALUES ('1173', 'Maine-et-Loire', 'State', '49', '75', null, 'Active');
INSERT INTO `state` VALUES ('1174', 'Manche', 'State', '50', '75', null, 'Active');
INSERT INTO `state` VALUES ('1175', 'Marne', 'State', '51', '75', null, 'Active');
INSERT INTO `state` VALUES ('1176', 'Mayenne', 'State', '53', '75', null, 'Active');
INSERT INTO `state` VALUES ('1177', 'Meurthe-et-Moselle', 'State', '54', '75', null, 'Active');
INSERT INTO `state` VALUES ('1178', 'Meuse', 'State', '55', '75', null, 'Active');
INSERT INTO `state` VALUES ('1179', 'Morbihan', 'State', '56', '75', null, 'Active');
INSERT INTO `state` VALUES ('1180', 'Moselle', 'State', '57', '75', null, 'Active');
INSERT INTO `state` VALUES ('1181', 'Nièvre', 'State', '58', '75', null, 'Active');
INSERT INTO `state` VALUES ('1182', 'Nord', 'State', '59', '75', null, 'Active');
INSERT INTO `state` VALUES ('1183', 'Oise', 'State', '60', '75', null, 'Active');
INSERT INTO `state` VALUES ('1184', 'Orne', 'State', '61', '75', null, 'Active');
INSERT INTO `state` VALUES ('1185', 'Paris', 'State', '75', '75', null, 'Active');
INSERT INTO `state` VALUES ('1186', 'Pas-de-Calais', 'State', '62', '75', null, 'Active');
INSERT INTO `state` VALUES ('1187', 'Puy-de-Dôme', 'State', '63', '75', null, 'Active');
INSERT INTO `state` VALUES ('1188', 'Pyrénées-Atlantiques', 'State', '64', '75', null, 'Active');
INSERT INTO `state` VALUES ('1189', 'Pyrénées-Orientales', 'State', '66', '75', null, 'Active');
INSERT INTO `state` VALUES ('1190', 'Rhône', 'State', '69', '75', null, 'Active');
INSERT INTO `state` VALUES ('1191', 'Saône-et-Loire', 'State', '71', '75', null, 'Active');
INSERT INTO `state` VALUES ('1192', 'Sarthe', 'State', '72', '75', null, 'Active');
INSERT INTO `state` VALUES ('1193', 'Savoie', 'State', '73', '75', null, 'Active');
INSERT INTO `state` VALUES ('1194', 'Seine-et-Marne', 'State', '77', '75', null, 'Active');
INSERT INTO `state` VALUES ('1195', 'Seine-Maritime', 'State', '76', '75', null, 'Active');
INSERT INTO `state` VALUES ('1196', 'Seine-Saint-Denis', 'State', '93', '75', null, 'Active');
INSERT INTO `state` VALUES ('1197', 'Somme', 'State', '80', '75', null, 'Active');
INSERT INTO `state` VALUES ('1198', 'Tarn', 'State', '81', '75', null, 'Active');
INSERT INTO `state` VALUES ('1199', 'Tarn-et-Garonne', 'State', '82', '75', null, 'Active');
INSERT INTO `state` VALUES ('1200', 'Val d\'Oise', 'State', '95', '75', null, 'Active');
INSERT INTO `state` VALUES ('1201', 'Territoire de Belfort', 'State', '90', '75', null, 'Active');
INSERT INTO `state` VALUES ('1202', 'Val-de-Marne', 'State', '94', '75', null, 'Active');
INSERT INTO `state` VALUES ('1203', 'Var', 'State', '83', '75', null, 'Active');
INSERT INTO `state` VALUES ('1204', 'Vaucluse', 'State', '84', '75', null, 'Active');
INSERT INTO `state` VALUES ('1205', 'Vendée', 'State', '85', '75', null, 'Active');
INSERT INTO `state` VALUES ('1206', 'Vienne', 'State', '86', '75', null, 'Active');
INSERT INTO `state` VALUES ('1207', 'Vosges', 'State', '88', '75', null, 'Active');
INSERT INTO `state` VALUES ('1208', 'Yonne', 'State', '89', '75', null, 'Active');
INSERT INTO `state` VALUES ('1209', 'Yvelines', 'State', '78', '75', null, 'Active');
INSERT INTO `state` VALUES ('1210', 'Aberdeen City', 'State', 'ABE', '225', null, 'Active');
INSERT INTO `state` VALUES ('1211', 'Aberdeenshire', 'State', 'ABD', '225', null, 'Active');
INSERT INTO `state` VALUES ('1212', 'Angus', 'State', 'ANS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1213', 'Co Antrim', 'State', 'ANT', '225', null, 'Active');
INSERT INTO `state` VALUES ('1214', 'Argyll and Bute', 'State', 'AGB', '225', null, 'Active');
INSERT INTO `state` VALUES ('1215', 'Co Armagh', 'State', 'ARM', '225', null, 'Active');
INSERT INTO `state` VALUES ('1216', 'Bedfordshire', 'State', 'BDF', '225', null, 'Active');
INSERT INTO `state` VALUES ('1217', 'Gwent', 'State', 'BGW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1218', 'Bristol, City of', 'State', 'BST', '225', null, 'Active');
INSERT INTO `state` VALUES ('1219', 'Buckinghamshire', 'State', 'BKM', '225', null, 'Active');
INSERT INTO `state` VALUES ('1220', 'Cambridgeshire', 'State', 'CAM', '225', null, 'Active');
INSERT INTO `state` VALUES ('1221', 'Cheshire', 'State', 'CHS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1222', 'Clackmannanshire', 'State', 'CLK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1223', 'Cornwall', 'State', 'CON', '225', null, 'Active');
INSERT INTO `state` VALUES ('1224', 'Cumbria', 'State', 'CMA', '225', null, 'Active');
INSERT INTO `state` VALUES ('1225', 'Derbyshire', 'State', 'DBY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1226', 'Co Londonderry', 'State', 'DRY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1227', 'Devon', 'State', 'DEV', '225', null, 'Active');
INSERT INTO `state` VALUES ('1228', 'Dorset', 'State', 'DOR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1229', 'Co Down', 'State', 'DOW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1230', 'Dumfries and Galloway', 'State', 'DGY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1231', 'Dundee City', 'State', 'DND', '225', null, 'Active');
INSERT INTO `state` VALUES ('1232', 'County Durham', 'State', 'DUR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1233', 'East Ayrshire', 'State', 'EAY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1234', 'East Dunbartonshire', 'State', 'EDU', '225', null, 'Active');
INSERT INTO `state` VALUES ('1235', 'East Lothian', 'State', 'ELN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1236', 'East Renfrewshire', 'State', 'ERW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1237', 'East Riding of Yorkshire', 'State', 'ERY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1238', 'East Sussex', 'State', 'ESX', '225', null, 'Active');
INSERT INTO `state` VALUES ('1239', 'Edinburgh, City of', 'State', 'EDH', '225', null, 'Active');
INSERT INTO `state` VALUES ('1240', 'Na h-Eileanan Siar', 'State', 'ELS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1241', 'Essex', 'State', 'ESS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1242', 'Falkirk', 'State', 'FAL', '225', null, 'Active');
INSERT INTO `state` VALUES ('1243', 'Co Fermanagh', 'State', 'FER', '225', null, 'Active');
INSERT INTO `state` VALUES ('1244', 'Fife', 'State', 'FIF', '225', null, 'Active');
INSERT INTO `state` VALUES ('1245', 'Glasgow City', 'State', 'GLG', '225', null, 'Active');
INSERT INTO `state` VALUES ('1246', 'Gloucestershire', 'State', 'GLS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1247', 'Gwynedd', 'State', 'GWN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1248', 'Hampshire', 'State', 'HAM', '225', null, 'Active');
INSERT INTO `state` VALUES ('1249', 'Herefordshire', 'State', 'HEF', '225', null, 'Active');
INSERT INTO `state` VALUES ('1250', 'Hertfordshire', 'State', 'HRT', '225', null, 'Active');
INSERT INTO `state` VALUES ('1251', 'Highland', 'State', 'HED', '225', null, 'Active');
INSERT INTO `state` VALUES ('1252', 'Inverclyde', 'State', 'IVC', '225', null, 'Active');
INSERT INTO `state` VALUES ('1253', 'Isle of Wight', 'State', 'IOW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1254', 'Kent', 'State', 'KEN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1255', 'Lancashire', 'State', 'LAN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1256', 'Leicestershire', 'State', 'LEC', '225', null, 'Active');
INSERT INTO `state` VALUES ('1257', 'Midlothian', 'State', 'MLN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1258', 'Moray', 'State', 'MRY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1259', 'Norfolk', 'State', 'NFK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1260', 'North Ayrshire', 'State', 'NAY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1261', 'North Lanarkshire', 'State', 'NLK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1262', 'North Yorkshire', 'State', 'NYK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1263', 'Northamptonshire', 'State', 'NTH', '225', null, 'Active');
INSERT INTO `state` VALUES ('1264', 'Northumberland', 'State', 'NBL', '225', null, 'Active');
INSERT INTO `state` VALUES ('1265', 'Nottinghamshire', 'State', 'NTT', '225', null, 'Active');
INSERT INTO `state` VALUES ('1266', 'Oldham', 'State', 'OLD', '225', null, 'Active');
INSERT INTO `state` VALUES ('1267', 'Omagh', 'State', 'OMH', '225', null, 'Active');
INSERT INTO `state` VALUES ('1268', 'Orkney Islands', 'State', 'ORR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1269', 'Oxfordshire', 'State', 'OXF', '225', null, 'Active');
INSERT INTO `state` VALUES ('1270', 'Perth and Kinross', 'State', 'PKN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1271', 'Powys', 'State', 'POW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1272', 'Renfrewshire', 'State', 'RFW', '225', null, 'Active');
INSERT INTO `state` VALUES ('1273', 'Rutland', 'State', 'RUT', '225', null, 'Active');
INSERT INTO `state` VALUES ('1274', 'Scottish Borders', 'State', 'SCB', '225', null, 'Active');
INSERT INTO `state` VALUES ('1275', 'Shetland Islands', 'State', 'ZET', '225', null, 'Active');
INSERT INTO `state` VALUES ('1276', 'Shropshire', 'State', 'SHR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1277', 'Somerset', 'State', 'SOM', '225', null, 'Active');
INSERT INTO `state` VALUES ('1278', 'South Ayrshire', 'State', 'SAY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1279', 'South Gloucestershire', 'State', 'SGC', '225', null, 'Active');
INSERT INTO `state` VALUES ('1280', 'South Lanarkshire', 'State', 'SLK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1281', 'Staffordshire', 'State', 'STS', '225', null, 'Active');
INSERT INTO `state` VALUES ('1282', 'Stirling', 'State', 'STG', '225', null, 'Active');
INSERT INTO `state` VALUES ('1283', 'Suffolk', 'State', 'SFK', '225', null, 'Active');
INSERT INTO `state` VALUES ('1284', 'Surrey', 'State', 'SRY', '225', null, 'Active');
INSERT INTO `state` VALUES ('1285', 'Mid Glamorgan', 'State', 'VGL', '225', null, 'Active');
INSERT INTO `state` VALUES ('1286', 'Warwickshire', 'State', 'WAR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1287', 'West Dunbartonshire', 'State', 'WDU', '225', null, 'Active');
INSERT INTO `state` VALUES ('1288', 'West Lothian', 'State', 'WLN', '225', null, 'Active');
INSERT INTO `state` VALUES ('1289', 'West Sussex', 'State', 'WSX', '225', null, 'Active');
INSERT INTO `state` VALUES ('1290', 'Wiltshire', 'State', 'WIL', '225', null, 'Active');
INSERT INTO `state` VALUES ('1291', 'Worcestershire', 'State', 'WOR', '225', null, 'Active');
INSERT INTO `state` VALUES ('1292', 'Ashanti', 'State', 'AH', '82', null, 'Active');
INSERT INTO `state` VALUES ('1293', 'Brong-Ahafo', 'State', 'BA', '82', null, 'Active');
INSERT INTO `state` VALUES ('1294', 'Greater Accra', 'State', 'AA', '82', null, 'Active');
INSERT INTO `state` VALUES ('1295', 'Upper East', 'State', 'UE', '82', null, 'Active');
INSERT INTO `state` VALUES ('1296', 'Upper West', 'State', 'UW', '82', null, 'Active');
INSERT INTO `state` VALUES ('1297', 'Volta', 'State', 'TV', '82', null, 'Active');
INSERT INTO `state` VALUES ('1298', 'Banjul', 'State', 'B', '212', null, 'Active');
INSERT INTO `state` VALUES ('1299', 'Lower River', 'State', 'L', '212', null, 'Active');
INSERT INTO `state` VALUES ('1300', 'MacCarthy Island', 'State', 'M', '212', null, 'Active');
INSERT INTO `state` VALUES ('1301', 'North Bank', 'State', 'N', '212', null, 'Active');
INSERT INTO `state` VALUES ('1302', 'Upper River', 'State', 'U', '212', null, 'Active');
INSERT INTO `state` VALUES ('1303', 'Beyla', 'State', 'BE', '90', null, 'Active');
INSERT INTO `state` VALUES ('1304', 'Boffa', 'State', 'BF', '90', null, 'Active');
INSERT INTO `state` VALUES ('1305', 'Boke', 'State', 'BK', '90', null, 'Active');
INSERT INTO `state` VALUES ('1306', 'Coyah', 'State', 'CO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1307', 'Dabola', 'State', 'DB', '90', null, 'Active');
INSERT INTO `state` VALUES ('1308', 'Dalaba', 'State', 'DL', '90', null, 'Active');
INSERT INTO `state` VALUES ('1309', 'Dinguiraye', 'State', 'DI', '90', null, 'Active');
INSERT INTO `state` VALUES ('1310', 'Dubreka', 'State', 'DU', '90', null, 'Active');
INSERT INTO `state` VALUES ('1311', 'Faranah', 'State', 'FA', '90', null, 'Active');
INSERT INTO `state` VALUES ('1312', 'Forecariah', 'State', 'FO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1313', 'Fria', 'State', 'FR', '90', null, 'Active');
INSERT INTO `state` VALUES ('1314', 'Gaoual', 'State', 'GA', '90', null, 'Active');
INSERT INTO `state` VALUES ('1315', 'Guekedou', 'State', 'GU', '90', null, 'Active');
INSERT INTO `state` VALUES ('1316', 'Kankan', 'State', 'KA', '90', null, 'Active');
INSERT INTO `state` VALUES ('1317', 'Kerouane', 'State', 'KE', '90', null, 'Active');
INSERT INTO `state` VALUES ('1318', 'Kindia', 'State', 'KD', '90', null, 'Active');
INSERT INTO `state` VALUES ('1319', 'Kissidougou', 'State', 'KS', '90', null, 'Active');
INSERT INTO `state` VALUES ('1320', 'Koubia', 'State', 'KB', '90', null, 'Active');
INSERT INTO `state` VALUES ('1321', 'Koundara', 'State', 'KN', '90', null, 'Active');
INSERT INTO `state` VALUES ('1322', 'Kouroussa', 'State', 'KO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1323', 'Labe', 'State', 'LA', '90', null, 'Active');
INSERT INTO `state` VALUES ('1324', 'Lelouma', 'State', 'LE', '90', null, 'Active');
INSERT INTO `state` VALUES ('1325', 'Lola', 'State', 'LO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1326', 'Macenta', 'State', 'MC', '90', null, 'Active');
INSERT INTO `state` VALUES ('1327', 'Mali', 'State', 'ML', '90', null, 'Active');
INSERT INTO `state` VALUES ('1328', 'Mamou', 'State', 'MM', '90', null, 'Active');
INSERT INTO `state` VALUES ('1329', 'Mandiana', 'State', 'MD', '90', null, 'Active');
INSERT INTO `state` VALUES ('1330', 'Nzerekore', 'State', 'NZ', '90', null, 'Active');
INSERT INTO `state` VALUES ('1331', 'Pita', 'State', 'PI', '90', null, 'Active');
INSERT INTO `state` VALUES ('1332', 'Siguiri', 'State', 'SI', '90', null, 'Active');
INSERT INTO `state` VALUES ('1333', 'Telimele', 'State', 'TE', '90', null, 'Active');
INSERT INTO `state` VALUES ('1334', 'Tougue', 'State', 'TO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1335', 'Yomou', 'State', 'YO', '90', null, 'Active');
INSERT INTO `state` VALUES ('1336', 'Region Continental', 'State', 'C', '67', null, 'Active');
INSERT INTO `state` VALUES ('1337', 'Region Insular', 'State', 'I', '67', null, 'Active');
INSERT INTO `state` VALUES ('1338', 'Annobon', 'State', 'AN', '67', null, 'Active');
INSERT INTO `state` VALUES ('1339', 'Bioko Norte', 'State', 'BN', '67', null, 'Active');
INSERT INTO `state` VALUES ('1340', 'Bioko Sur', 'State', 'BS', '67', null, 'Active');
INSERT INTO `state` VALUES ('1341', 'Centro Sur', 'State', 'CS', '67', null, 'Active');
INSERT INTO `state` VALUES ('1342', 'Kie-Ntem', 'State', 'KN', '67', null, 'Active');
INSERT INTO `state` VALUES ('1343', 'Litoral', 'State', 'LI', '67', null, 'Active');
INSERT INTO `state` VALUES ('1344', 'Wele-Nzas', 'State', 'WN', '67', null, 'Active');
INSERT INTO `state` VALUES ('1345', 'Achaïa', 'State', '13', '84', null, 'Active');
INSERT INTO `state` VALUES ('1346', 'Aitolia-Akarnania', 'State', '01', '84', null, 'Active');
INSERT INTO `state` VALUES ('1347', 'Argolis', 'State', '11', '84', null, 'Active');
INSERT INTO `state` VALUES ('1348', 'Arkadia', 'State', '12', '84', null, 'Active');
INSERT INTO `state` VALUES ('1349', 'Arta', 'State', '31', '84', null, 'Active');
INSERT INTO `state` VALUES ('1350', 'Attiki', 'State', 'A1', '84', null, 'Active');
INSERT INTO `state` VALUES ('1351', 'Chalkidiki', 'State', '64', '84', null, 'Active');
INSERT INTO `state` VALUES ('1352', 'Chania', 'State', '94', '84', null, 'Active');
INSERT INTO `state` VALUES ('1353', 'Chios', 'State', '85', '84', null, 'Active');
INSERT INTO `state` VALUES ('1354', 'Dodekanisos', 'State', '81', '84', null, 'Active');
INSERT INTO `state` VALUES ('1355', 'Drama', 'State', '52', '84', null, 'Active');
INSERT INTO `state` VALUES ('1356', 'Evros', 'State', '71', '84', null, 'Active');
INSERT INTO `state` VALUES ('1357', 'Evrytania', 'State', '05', '84', null, 'Active');
INSERT INTO `state` VALUES ('1358', 'Evvoia', 'State', '04', '84', null, 'Active');
INSERT INTO `state` VALUES ('1359', 'Florina', 'State', '63', '84', null, 'Active');
INSERT INTO `state` VALUES ('1360', 'Fokis', 'State', '07', '84', null, 'Active');
INSERT INTO `state` VALUES ('1361', 'Fthiotis', 'State', '06', '84', null, 'Active');
INSERT INTO `state` VALUES ('1362', 'Grevena', 'State', '51', '84', null, 'Active');
INSERT INTO `state` VALUES ('1363', 'Ileia', 'State', '14', '84', null, 'Active');
INSERT INTO `state` VALUES ('1364', 'Imathia', 'State', '53', '84', null, 'Active');
INSERT INTO `state` VALUES ('1365', 'Ioannina', 'State', '33', '84', null, 'Active');
INSERT INTO `state` VALUES ('1366', 'Irakleion', 'State', '91', '84', null, 'Active');
INSERT INTO `state` VALUES ('1367', 'Karditsa', 'State', '41', '84', null, 'Active');
INSERT INTO `state` VALUES ('1368', 'Kastoria', 'State', '56', '84', null, 'Active');
INSERT INTO `state` VALUES ('1369', 'Kavalla', 'State', '55', '84', null, 'Active');
INSERT INTO `state` VALUES ('1370', 'Kefallinia', 'State', '23', '84', null, 'Active');
INSERT INTO `state` VALUES ('1371', 'Kerkyra', 'State', '22', '84', null, 'Active');
INSERT INTO `state` VALUES ('1372', 'Kilkis', 'State', '57', '84', null, 'Active');
INSERT INTO `state` VALUES ('1373', 'Korinthia', 'State', '15', '84', null, 'Active');
INSERT INTO `state` VALUES ('1374', 'Kozani', 'State', '58', '84', null, 'Active');
INSERT INTO `state` VALUES ('1375', 'Kyklades', 'State', '82', '84', null, 'Active');
INSERT INTO `state` VALUES ('1376', 'Lakonia', 'State', '16', '84', null, 'Active');
INSERT INTO `state` VALUES ('1377', 'Larisa', 'State', '42', '84', null, 'Active');
INSERT INTO `state` VALUES ('1378', 'Lasithion', 'State', '92', '84', null, 'Active');
INSERT INTO `state` VALUES ('1379', 'Lefkas', 'State', '24', '84', null, 'Active');
INSERT INTO `state` VALUES ('1380', 'Lesvos', 'State', '83', '84', null, 'Active');
INSERT INTO `state` VALUES ('1381', 'Magnisia', 'State', '43', '84', null, 'Active');
INSERT INTO `state` VALUES ('1382', 'Messinia', 'State', '17', '84', null, 'Active');
INSERT INTO `state` VALUES ('1383', 'Pella', 'State', '59', '84', null, 'Active');
INSERT INTO `state` VALUES ('1384', 'Preveza', 'State', '34', '84', null, 'Active');
INSERT INTO `state` VALUES ('1385', 'Rethymnon', 'State', '93', '84', null, 'Active');
INSERT INTO `state` VALUES ('1386', 'Rodopi', 'State', '73', '84', null, 'Active');
INSERT INTO `state` VALUES ('1387', 'Samos', 'State', '84', '84', null, 'Active');
INSERT INTO `state` VALUES ('1388', 'Serrai', 'State', '62', '84', null, 'Active');
INSERT INTO `state` VALUES ('1389', 'Thesprotia', 'State', '32', '84', null, 'Active');
INSERT INTO `state` VALUES ('1390', 'Thessaloniki', 'State', '54', '84', null, 'Active');
INSERT INTO `state` VALUES ('1391', 'Trikala', 'State', '44', '84', null, 'Active');
INSERT INTO `state` VALUES ('1392', 'Voiotia', 'State', '03', '84', null, 'Active');
INSERT INTO `state` VALUES ('1393', 'Xanthi', 'State', '72', '84', null, 'Active');
INSERT INTO `state` VALUES ('1394', 'Zakynthos', 'State', '21', '84', null, 'Active');
INSERT INTO `state` VALUES ('1395', 'Agio Oros', 'State', '69', '84', null, 'Active');
INSERT INTO `state` VALUES ('1396', 'Alta Verapez', 'State', 'AV', '89', null, 'Active');
INSERT INTO `state` VALUES ('1397', 'Baja Verapez', 'State', 'BV', '89', null, 'Active');
INSERT INTO `state` VALUES ('1398', 'Chimaltenango', 'State', 'CM', '89', null, 'Active');
INSERT INTO `state` VALUES ('1399', 'Chiquimula', 'State', 'CQ', '89', null, 'Active');
INSERT INTO `state` VALUES ('1400', 'El Progreso', 'State', 'PR', '89', null, 'Active');
INSERT INTO `state` VALUES ('1401', 'Escuintla', 'State', 'ES', '89', null, 'Active');
INSERT INTO `state` VALUES ('1402', 'Guatemala', 'State', 'GU', '89', null, 'Active');
INSERT INTO `state` VALUES ('1403', 'Huehuetenango', 'State', 'HU', '89', null, 'Active');
INSERT INTO `state` VALUES ('1404', 'Izabal', 'State', 'IZ', '89', null, 'Active');
INSERT INTO `state` VALUES ('1405', 'Jalapa', 'State', 'JA', '89', null, 'Active');
INSERT INTO `state` VALUES ('1406', 'Jutiapa', 'State', 'JU', '89', null, 'Active');
INSERT INTO `state` VALUES ('1407', 'Peten', 'State', 'PE', '89', null, 'Active');
INSERT INTO `state` VALUES ('1408', 'Quetzaltenango', 'State', 'QZ', '89', null, 'Active');
INSERT INTO `state` VALUES ('1409', 'Quiche', 'State', 'QC', '89', null, 'Active');
INSERT INTO `state` VALUES ('1410', 'Reta.thuleu', 'State', 'RE', '89', null, 'Active');
INSERT INTO `state` VALUES ('1411', 'Sacatepequez', 'State', 'SA', '89', null, 'Active');
INSERT INTO `state` VALUES ('1412', 'San Marcos', 'State', 'SM', '89', null, 'Active');
INSERT INTO `state` VALUES ('1413', 'Santa Rosa', 'State', 'SR', '89', null, 'Active');
INSERT INTO `state` VALUES ('1414', 'Solol6', 'State', 'SO', '89', null, 'Active');
INSERT INTO `state` VALUES ('1415', 'Suchitepequez', 'State', 'SU', '89', null, 'Active');
INSERT INTO `state` VALUES ('1416', 'Totonicapan', 'State', 'TO', '89', null, 'Active');
INSERT INTO `state` VALUES ('1417', 'Zacapa', 'State', 'ZA', '89', null, 'Active');
INSERT INTO `state` VALUES ('1418', 'Bissau', 'State', 'BS', '91', null, 'Active');
INSERT INTO `state` VALUES ('1419', 'Bafata', 'State', 'BA', '91', null, 'Active');
INSERT INTO `state` VALUES ('1420', 'Biombo', 'State', 'BM', '91', null, 'Active');
INSERT INTO `state` VALUES ('1421', 'Bolama', 'State', 'BL', '91', null, 'Active');
INSERT INTO `state` VALUES ('1422', 'Cacheu', 'State', 'CA', '91', null, 'Active');
INSERT INTO `state` VALUES ('1423', 'Gabu', 'State', 'GA', '91', null, 'Active');
INSERT INTO `state` VALUES ('1424', 'Oio', 'State', 'OI', '91', null, 'Active');
INSERT INTO `state` VALUES ('1425', 'Quloara', 'State', 'QU', '91', null, 'Active');
INSERT INTO `state` VALUES ('1426', 'Tombali S', 'State', 'TO', '91', null, 'Active');
INSERT INTO `state` VALUES ('1427', 'Barima-Waini', 'State', 'BA', '92', null, 'Active');
INSERT INTO `state` VALUES ('1428', 'Cuyuni-Mazaruni', 'State', 'CU', '92', null, 'Active');
INSERT INTO `state` VALUES ('1429', 'Demerara-Mahaica', 'State', 'DE', '92', null, 'Active');
INSERT INTO `state` VALUES ('1430', 'East Berbice-Corentyne', 'State', 'EB', '92', null, 'Active');
INSERT INTO `state` VALUES ('1431', 'Essequibo Islands-West Demerara', 'State', 'ES', '92', null, 'Active');
INSERT INTO `state` VALUES ('1432', 'Mahaica-Berbice', 'State', 'MA', '92', null, 'Active');
INSERT INTO `state` VALUES ('1433', 'Pomeroon-Supenaam', 'State', 'PM', '92', null, 'Active');
INSERT INTO `state` VALUES ('1434', 'Potaro-Siparuni', 'State', 'PT', '92', null, 'Active');
INSERT INTO `state` VALUES ('1435', 'Upper Demerara-Berbice', 'State', 'UD', '92', null, 'Active');
INSERT INTO `state` VALUES ('1436', 'Upper Takutu-Upper Essequibo', 'State', 'UT', '92', null, 'Active');
INSERT INTO `state` VALUES ('1437', 'Atlantida', 'State', 'AT', '96', null, 'Active');
INSERT INTO `state` VALUES ('1438', 'Colon', 'State', 'CL', '96', null, 'Active');
INSERT INTO `state` VALUES ('1439', 'Comayagua', 'State', 'CM', '96', null, 'Active');
INSERT INTO `state` VALUES ('1440', 'Copan', 'State', 'CP', '96', null, 'Active');
INSERT INTO `state` VALUES ('1441', 'Cortes', 'State', 'CR', '96', null, 'Active');
INSERT INTO `state` VALUES ('1442', 'Choluteca', 'State', 'CH', '96', null, 'Active');
INSERT INTO `state` VALUES ('1443', 'El Paraiso', 'State', 'EP', '96', null, 'Active');
INSERT INTO `state` VALUES ('1444', 'Francisco Morazan', 'State', 'FM', '96', null, 'Active');
INSERT INTO `state` VALUES ('1445', 'Gracias a Dios', 'State', 'GD', '96', null, 'Active');
INSERT INTO `state` VALUES ('1446', 'Intibuca', 'State', 'IN', '96', null, 'Active');
INSERT INTO `state` VALUES ('1447', 'Islas de la Bahia', 'State', 'IB', '96', null, 'Active');
INSERT INTO `state` VALUES ('1448', 'Lempira', 'State', 'LE', '96', null, 'Active');
INSERT INTO `state` VALUES ('1449', 'Ocotepeque', 'State', 'OC', '96', null, 'Active');
INSERT INTO `state` VALUES ('1450', 'Olancho', 'State', 'OL', '96', null, 'Active');
INSERT INTO `state` VALUES ('1451', 'Santa Barbara', 'State', 'SB', '96', null, 'Active');
INSERT INTO `state` VALUES ('1452', 'Valle', 'State', 'VA', '96', null, 'Active');
INSERT INTO `state` VALUES ('1453', 'Yoro', 'State', 'YO', '96', null, 'Active');
INSERT INTO `state` VALUES ('1454', 'Bjelovarsko-bilogorska zupanija', 'State', '07', '55', null, 'Active');
INSERT INTO `state` VALUES ('1455', 'Brodsko-posavska zupanija', 'State', '12', '55', null, 'Active');
INSERT INTO `state` VALUES ('1456', 'Dubrovacko-neretvanska zupanija', 'State', '19', '55', null, 'Active');
INSERT INTO `state` VALUES ('1457', 'Istarska zupanija', 'State', '18', '55', null, 'Active');
INSERT INTO `state` VALUES ('1458', 'Karlovacka zupanija', 'State', '04', '55', null, 'Active');
INSERT INTO `state` VALUES ('1459', 'Koprivnickco-krizevacka zupanija', 'State', '06', '55', null, 'Active');
INSERT INTO `state` VALUES ('1460', 'Krapinako-zagorska zupanija', 'State', '02', '55', null, 'Active');
INSERT INTO `state` VALUES ('1461', 'Licko-senjska zupanija', 'State', '09', '55', null, 'Active');
INSERT INTO `state` VALUES ('1462', 'Medimurska zupanija', 'State', '20', '55', null, 'Active');
INSERT INTO `state` VALUES ('1463', 'Osjecko-baranjska zupanija', 'State', '14', '55', null, 'Active');
INSERT INTO `state` VALUES ('1464', 'Pozesko-slavonska zupanija', 'State', '11', '55', null, 'Active');
INSERT INTO `state` VALUES ('1465', 'Primorsko-goranska zupanija', 'State', '08', '55', null, 'Active');
INSERT INTO `state` VALUES ('1466', 'Sisacko-moelavacka Iupanija', 'State', '03', '55', null, 'Active');
INSERT INTO `state` VALUES ('1467', 'Splitako-dalmatinska zupanija', 'State', '17', '55', null, 'Active');
INSERT INTO `state` VALUES ('1468', 'Sibenako-kninska zupanija', 'State', '15', '55', null, 'Active');
INSERT INTO `state` VALUES ('1469', 'Varaidinska zupanija', 'State', '05', '55', null, 'Active');
INSERT INTO `state` VALUES ('1470', 'VirovitiEko-podravska zupanija', 'State', '10', '55', null, 'Active');
INSERT INTO `state` VALUES ('1471', 'VuRovarako-srijemska zupanija', 'State', '16', '55', null, 'Active');
INSERT INTO `state` VALUES ('1472', 'Zadaraka', 'State', '13', '55', null, 'Active');
INSERT INTO `state` VALUES ('1473', 'Zagrebacka zupanija', 'State', '01', '55', null, 'Active');
INSERT INTO `state` VALUES ('1474', 'Grande-Anse', 'State', 'GA', '93', null, 'Active');
INSERT INTO `state` VALUES ('1475', 'Nord-Est', 'State', 'NE', '93', null, 'Active');
INSERT INTO `state` VALUES ('1476', 'Nord-Ouest', 'State', 'NO', '93', null, 'Active');
INSERT INTO `state` VALUES ('1477', 'Ouest', 'State', 'OU', '93', null, 'Active');
INSERT INTO `state` VALUES ('1478', 'Sud', 'State', 'SD', '93', null, 'Active');
INSERT INTO `state` VALUES ('1479', 'Sud-Est', 'State', 'SE', '93', null, 'Active');
INSERT INTO `state` VALUES ('1480', 'Budapest', 'State', 'BU', '98', null, 'Active');
INSERT INTO `state` VALUES ('1481', 'Bács-Kiskun', 'State', 'BK', '98', null, 'Active');
INSERT INTO `state` VALUES ('1482', 'Baranya', 'State', 'BA', '98', null, 'Active');
INSERT INTO `state` VALUES ('1483', 'Békés', 'State', 'BE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1484', 'Borsod-Abaúj-Zemplén', 'State', 'BZ', '98', null, 'Active');
INSERT INTO `state` VALUES ('1485', 'Csongrád', 'State', 'CS', '98', null, 'Active');
INSERT INTO `state` VALUES ('1486', 'Fejér', 'State', 'FE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1487', 'Gy?r-Moson-Sopron', 'State', 'GS', '98', null, 'Active');
INSERT INTO `state` VALUES ('1488', 'Hajdu-Bihar', 'State', 'HB', '98', null, 'Active');
INSERT INTO `state` VALUES ('1489', 'Heves', 'State', 'HE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1490', 'Jász-Nagykun-Szolnok', 'State', 'JN', '98', null, 'Active');
INSERT INTO `state` VALUES ('1491', 'Komárom-Esztergom', 'State', 'KE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1492', 'Nográd', 'State', 'NO', '98', null, 'Active');
INSERT INTO `state` VALUES ('1493', 'Pest', 'State', 'PE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1494', 'Somogy', 'State', 'SO', '98', null, 'Active');
INSERT INTO `state` VALUES ('1495', 'Szabolcs-Szatmár-Bereg', 'State', 'SZ', '98', null, 'Active');
INSERT INTO `state` VALUES ('1496', 'Tolna', 'State', 'TO', '98', null, 'Active');
INSERT INTO `state` VALUES ('1497', 'Vas', 'State', 'VA', '98', null, 'Active');
INSERT INTO `state` VALUES ('1498', 'Veszprém', 'State', 'VE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1499', 'Zala', 'State', 'ZA', '98', null, 'Active');
INSERT INTO `state` VALUES ('1500', 'Békéscsaba', 'State', 'BC', '98', null, 'Active');
INSERT INTO `state` VALUES ('1501', 'Debrecen', 'State', 'DE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1502', 'Dunaújváros', 'State', 'DU', '98', null, 'Active');
INSERT INTO `state` VALUES ('1503', 'Eger', 'State', 'EG', '98', null, 'Active');
INSERT INTO `state` VALUES ('1504', 'Gy?r', 'State', 'GY', '98', null, 'Active');
INSERT INTO `state` VALUES ('1505', 'Hódmez?vásárhely', 'State', 'HV', '98', null, 'Active');
INSERT INTO `state` VALUES ('1506', 'Kaposvár', 'State', 'KV', '98', null, 'Active');
INSERT INTO `state` VALUES ('1507', 'Kecskemét', 'State', 'KM', '98', null, 'Active');
INSERT INTO `state` VALUES ('1508', 'Miskolc', 'State', 'MI', '98', null, 'Active');
INSERT INTO `state` VALUES ('1509', 'Nagykanizsa', 'State', 'NK', '98', null, 'Active');
INSERT INTO `state` VALUES ('1510', 'Nyiregyháza', 'State', 'NY', '98', null, 'Active');
INSERT INTO `state` VALUES ('1511', 'Pécs', 'State', 'PS', '98', null, 'Active');
INSERT INTO `state` VALUES ('1512', 'Salgótarján', 'State', 'ST', '98', null, 'Active');
INSERT INTO `state` VALUES ('1513', 'Sopron', 'State', 'SN', '98', null, 'Active');
INSERT INTO `state` VALUES ('1514', 'Szeged', 'State', 'SD', '98', null, 'Active');
INSERT INTO `state` VALUES ('1515', 'Székesfehérvár', 'State', 'SF', '98', null, 'Active');
INSERT INTO `state` VALUES ('1516', 'Szekszárd', 'State', 'SS', '98', null, 'Active');
INSERT INTO `state` VALUES ('1517', 'Szolnok', 'State', 'SK', '98', null, 'Active');
INSERT INTO `state` VALUES ('1518', 'Szombathely', 'State', 'SH', '98', null, 'Active');
INSERT INTO `state` VALUES ('1519', 'Tatabánya', 'State', 'TB', '98', null, 'Active');
INSERT INTO `state` VALUES ('1520', 'Zalaegerszeg', 'State', 'ZE', '98', null, 'Active');
INSERT INTO `state` VALUES ('1521', 'Bali', 'State', 'BA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1522', 'Bangka Belitung', 'State', 'BB', '101', null, 'Active');
INSERT INTO `state` VALUES ('1523', 'Banten', 'State', 'BT', '101', null, 'Active');
INSERT INTO `state` VALUES ('1524', 'Bengkulu', 'State', 'BE', '101', null, 'Active');
INSERT INTO `state` VALUES ('1525', 'Gorontalo', 'State', 'GO', '101', null, 'Active');
INSERT INTO `state` VALUES ('1526', 'Irian Jaya', 'State', 'IJ', '101', null, 'Active');
INSERT INTO `state` VALUES ('1527', 'Jambi', 'State', 'JA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1528', 'Jawa Barat', 'State', 'JB', '101', null, 'Active');
INSERT INTO `state` VALUES ('1529', 'Jawa Tengah', 'State', 'JT', '101', null, 'Active');
INSERT INTO `state` VALUES ('1530', 'Jawa Timur', 'State', 'JI', '101', null, 'Active');
INSERT INTO `state` VALUES ('1531', 'Kalimantan Barat', 'State', 'KB', '101', null, 'Active');
INSERT INTO `state` VALUES ('1532', 'Kalimantan Timur', 'State', 'KT', '101', null, 'Active');
INSERT INTO `state` VALUES ('1533', 'Kalimantan Selatan', 'State', 'KS', '101', null, 'Active');
INSERT INTO `state` VALUES ('1534', 'Kepulauan Riau', 'State', 'KR', '101', null, 'Active');
INSERT INTO `state` VALUES ('1535', 'Lampung', 'State', 'LA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1536', 'Maluku', 'State', 'MA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1537', 'Maluku Utara', 'State', 'MU', '101', null, 'Active');
INSERT INTO `state` VALUES ('1538', 'Nusa Tenggara Barat', 'State', 'NB', '101', null, 'Active');
INSERT INTO `state` VALUES ('1539', 'Nusa Tenggara Timur', 'State', 'NT', '101', null, 'Active');
INSERT INTO `state` VALUES ('1540', 'Papua', 'State', 'PA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1541', 'Riau', 'State', 'RI', '101', null, 'Active');
INSERT INTO `state` VALUES ('1542', 'Sulawesi Selatan', 'State', 'SN', '101', null, 'Active');
INSERT INTO `state` VALUES ('1543', 'Sulawesi Tengah', 'State', 'ST', '101', null, 'Active');
INSERT INTO `state` VALUES ('1544', 'Sulawesi Tenggara', 'State', 'SG', '101', null, 'Active');
INSERT INTO `state` VALUES ('1545', 'Sulawesi Utara', 'State', 'SA', '101', null, 'Active');
INSERT INTO `state` VALUES ('1546', 'Sumatra Barat', 'State', 'SB', '101', null, 'Active');
INSERT INTO `state` VALUES ('1547', 'Sumatra Selatan', 'State', 'SS', '101', null, 'Active');
INSERT INTO `state` VALUES ('1548', 'Sumatera Utara', 'State', 'SU', '101', null, 'Active');
INSERT INTO `state` VALUES ('1549', 'Jakarta Raya', 'State', 'JK', '101', null, 'Active');
INSERT INTO `state` VALUES ('1550', 'Aceh', 'State', 'AC', '101', null, 'Active');
INSERT INTO `state` VALUES ('1551', 'Yogyakarta', 'State', 'YO', '101', null, 'Active');
INSERT INTO `state` VALUES ('1552', 'Cork', 'State', 'C', '104', null, 'Active');
INSERT INTO `state` VALUES ('1553', 'Clare', 'State', 'CE', '104', null, 'Active');
INSERT INTO `state` VALUES ('1554', 'Cavan', 'State', 'CN', '104', null, 'Active');
INSERT INTO `state` VALUES ('1555', 'Carlow', 'State', 'CW', '104', null, 'Active');
INSERT INTO `state` VALUES ('1556', 'Dublin', 'State', 'D', '104', null, 'Active');
INSERT INTO `state` VALUES ('1557', 'Donegal', 'State', 'DL', '104', null, 'Active');
INSERT INTO `state` VALUES ('1558', 'Galway', 'State', 'G', '104', null, 'Active');
INSERT INTO `state` VALUES ('1559', 'Kildare', 'State', 'KE', '104', null, 'Active');
INSERT INTO `state` VALUES ('1560', 'Kilkenny', 'State', 'KK', '104', null, 'Active');
INSERT INTO `state` VALUES ('1561', 'Kerry', 'State', 'KY', '104', null, 'Active');
INSERT INTO `state` VALUES ('1562', 'Longford', 'State', 'LD', '104', null, 'Active');
INSERT INTO `state` VALUES ('1563', 'Louth', 'State', 'LH', '104', null, 'Active');
INSERT INTO `state` VALUES ('1564', 'Limerick', 'State', 'LK', '104', null, 'Active');
INSERT INTO `state` VALUES ('1565', 'Leitrim', 'State', 'LM', '104', null, 'Active');
INSERT INTO `state` VALUES ('1566', 'Laois', 'State', 'LS', '104', null, 'Active');
INSERT INTO `state` VALUES ('1567', 'Meath', 'State', 'MH', '104', null, 'Active');
INSERT INTO `state` VALUES ('1568', 'Monaghan', 'State', 'MN', '104', null, 'Active');
INSERT INTO `state` VALUES ('1569', 'Mayo', 'State', 'MO', '104', null, 'Active');
INSERT INTO `state` VALUES ('1570', 'Offaly', 'State', 'OY', '104', null, 'Active');
INSERT INTO `state` VALUES ('1571', 'Roscommon', 'State', 'RN', '104', null, 'Active');
INSERT INTO `state` VALUES ('1572', 'Sligo', 'State', 'SO', '104', null, 'Active');
INSERT INTO `state` VALUES ('1573', 'Tipperary', 'State', 'TA', '104', null, 'Active');
INSERT INTO `state` VALUES ('1574', 'Waterford', 'State', 'WD', '104', null, 'Active');
INSERT INTO `state` VALUES ('1575', 'Westmeath', 'State', 'WH', '104', null, 'Active');
INSERT INTO `state` VALUES ('1576', 'Wicklow', 'State', 'WW', '104', null, 'Active');
INSERT INTO `state` VALUES ('1577', 'Wexford', 'State', 'WX', '104', null, 'Active');
INSERT INTO `state` VALUES ('1578', 'HaDarom', 'State', 'D', '105', null, 'Active');
INSERT INTO `state` VALUES ('1579', 'HaMerkaz', 'State', 'M', '105', null, 'Active');
INSERT INTO `state` VALUES ('1580', 'HaZafon', 'State', 'Z', '105', null, 'Active');
INSERT INTO `state` VALUES ('1581', 'Haifa', 'State', 'HA', '105', null, 'Active');
INSERT INTO `state` VALUES ('1582', 'Tel-Aviv', 'State', 'TA', '105', null, 'Active');
INSERT INTO `state` VALUES ('1583', 'Jerusalem', 'State', 'JM', '105', null, 'Active');
INSERT INTO `state` VALUES ('1584', 'Al Anbar', 'State', 'AN', '103', null, 'Active');
INSERT INTO `state` VALUES ('1585', 'Al Ba,rah', 'State', 'BA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1586', 'Al Muthanna', 'State', 'MU', '103', null, 'Active');
INSERT INTO `state` VALUES ('1587', 'Al Qadisiyah', 'State', 'QA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1588', 'An Najef', 'State', 'NA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1589', 'Arbil', 'State', 'AR', '103', null, 'Active');
INSERT INTO `state` VALUES ('1590', 'As Sulaymaniyah', 'State', 'SW', '103', null, 'Active');
INSERT INTO `state` VALUES ('1591', 'At Ta\'mim', 'State', 'TS', '103', null, 'Active');
INSERT INTO `state` VALUES ('1592', 'Babil', 'State', 'BB', '103', null, 'Active');
INSERT INTO `state` VALUES ('1593', 'Baghdad', 'State', 'BG', '103', null, 'Active');
INSERT INTO `state` VALUES ('1594', 'Dahuk', 'State', 'DA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1595', 'Dhi Qar', 'State', 'DQ', '103', null, 'Active');
INSERT INTO `state` VALUES ('1596', 'Diyala', 'State', 'DI', '103', null, 'Active');
INSERT INTO `state` VALUES ('1597', 'Karbala\'', 'State', 'KA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1598', 'Maysan', 'State', 'MA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1599', 'Ninawa', 'State', 'NI', '103', null, 'Active');
INSERT INTO `state` VALUES ('1600', 'Salah ad Din', 'State', 'SD', '103', null, 'Active');
INSERT INTO `state` VALUES ('1601', 'Wasit', 'State', 'WA', '103', null, 'Active');
INSERT INTO `state` VALUES ('1602', 'Ardabil', 'State', '03', '102', null, 'Active');
INSERT INTO `state` VALUES ('1603', 'Azarbayjan-e Gharbi', 'State', '02', '102', null, 'Active');
INSERT INTO `state` VALUES ('1604', 'Azarbayjan-e Sharqi', 'State', '01', '102', null, 'Active');
INSERT INTO `state` VALUES ('1605', 'Bushehr', 'State', '06', '102', null, 'Active');
INSERT INTO `state` VALUES ('1606', 'Chahar Mahall va Bakhtiari', 'State', '08', '102', null, 'Active');
INSERT INTO `state` VALUES ('1607', 'Esfahan', 'State', '04', '102', null, 'Active');
INSERT INTO `state` VALUES ('1608', 'Fars', 'State', '14', '102', null, 'Active');
INSERT INTO `state` VALUES ('1609', 'Gilan', 'State', '19', '102', null, 'Active');
INSERT INTO `state` VALUES ('1610', 'Golestan', 'State', '27', '102', null, 'Active');
INSERT INTO `state` VALUES ('1611', 'Hamadan', 'State', '24', '102', null, 'Active');
INSERT INTO `state` VALUES ('1612', 'Hormozgan', 'State', '23', '102', null, 'Active');
INSERT INTO `state` VALUES ('1613', 'Iiam', 'State', '05', '102', null, 'Active');
INSERT INTO `state` VALUES ('1614', 'Kerman', 'State', '15', '102', null, 'Active');
INSERT INTO `state` VALUES ('1615', 'Kermanshah', 'State', '17', '102', null, 'Active');
INSERT INTO `state` VALUES ('1616', 'Khorasan', 'State', '09', '102', null, 'Active');
INSERT INTO `state` VALUES ('1617', 'Khuzestan', 'State', '10', '102', null, 'Active');
INSERT INTO `state` VALUES ('1618', 'Kohjiluyeh va Buyer Ahmad', 'State', '18', '102', null, 'Active');
INSERT INTO `state` VALUES ('1619', 'Kordestan', 'State', '16', '102', null, 'Active');
INSERT INTO `state` VALUES ('1620', 'Lorestan', 'State', '20', '102', null, 'Active');
INSERT INTO `state` VALUES ('1621', 'Markazi', 'State', '22', '102', null, 'Active');
INSERT INTO `state` VALUES ('1622', 'Mazandaran', 'State', '21', '102', null, 'Active');
INSERT INTO `state` VALUES ('1623', 'Qazvin', 'State', '28', '102', null, 'Active');
INSERT INTO `state` VALUES ('1624', 'Qom', 'State', '26', '102', null, 'Active');
INSERT INTO `state` VALUES ('1625', 'Semnan', 'State', '12', '102', null, 'Active');
INSERT INTO `state` VALUES ('1626', 'Sistan va Baluchestan', 'State', '13', '102', null, 'Active');
INSERT INTO `state` VALUES ('1627', 'Tehran', 'State', '07', '102', null, 'Active');
INSERT INTO `state` VALUES ('1628', 'Yazd', 'State', '25', '102', null, 'Active');
INSERT INTO `state` VALUES ('1629', 'Zanjan', 'State', '11', '102', null, 'Active');
INSERT INTO `state` VALUES ('1630', 'Austurland', 'State', '7', '99', null, 'Active');
INSERT INTO `state` VALUES ('1631', 'Hofuoborgarsvaeoi utan Reykjavikur', 'State', '1', '99', null, 'Active');
INSERT INTO `state` VALUES ('1632', 'Norourland eystra', 'State', '6', '99', null, 'Active');
INSERT INTO `state` VALUES ('1633', 'Norourland vestra', 'State', '5', '99', null, 'Active');
INSERT INTO `state` VALUES ('1634', 'Reykjavik', 'State', '0', '99', null, 'Active');
INSERT INTO `state` VALUES ('1635', 'Suourland', 'State', '8', '99', null, 'Active');
INSERT INTO `state` VALUES ('1636', 'Suournes', 'State', '2', '99', null, 'Active');
INSERT INTO `state` VALUES ('1637', 'Vestfirolr', 'State', '4', '99', null, 'Active');
INSERT INTO `state` VALUES ('1638', 'Vesturland', 'State', '3', '99', null, 'Active');
INSERT INTO `state` VALUES ('1639', 'Agrigento', 'State', 'AG', '106', null, 'Active');
INSERT INTO `state` VALUES ('1640', 'Alessandria', 'State', 'AL', '106', null, 'Active');
INSERT INTO `state` VALUES ('1641', 'Ancona', 'State', 'AN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1642', 'Aosta', 'State', 'AO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1643', 'Arezzo', 'State', 'AR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1644', 'Ascoli Piceno', 'State', 'AP', '106', null, 'Active');
INSERT INTO `state` VALUES ('1645', 'Asti', 'State', 'AT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1646', 'Avellino', 'State', 'AV', '106', null, 'Active');
INSERT INTO `state` VALUES ('1647', 'Bari', 'State', 'BA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1648', 'Belluno', 'State', 'BL', '106', null, 'Active');
INSERT INTO `state` VALUES ('1649', 'Benevento', 'State', 'BN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1650', 'Bergamo', 'State', 'BG', '106', null, 'Active');
INSERT INTO `state` VALUES ('1651', 'Biella', 'State', 'BI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1652', 'Bologna', 'State', 'BO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1653', 'Bolzano', 'State', 'BZ', '106', null, 'Active');
INSERT INTO `state` VALUES ('1654', 'Brescia', 'State', 'BS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1655', 'Brindisi', 'State', 'BR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1656', 'Cagliari', 'State', 'CA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1657', 'Caltanissetta', 'State', 'CL', '106', null, 'Active');
INSERT INTO `state` VALUES ('1658', 'Campobasso', 'State', 'CB', '106', null, 'Active');
INSERT INTO `state` VALUES ('1659', 'Caserta', 'State', 'CE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1660', 'Catania', 'State', 'CT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1661', 'Catanzaro', 'State', 'CZ', '106', null, 'Active');
INSERT INTO `state` VALUES ('1662', 'Chieti', 'State', 'CH', '106', null, 'Active');
INSERT INTO `state` VALUES ('1663', 'Como', 'State', 'CO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1664', 'Cosenza', 'State', 'CS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1665', 'Cremona', 'State', 'CR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1666', 'Crotone', 'State', 'KR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1667', 'Cuneo', 'State', 'CN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1668', 'Enna', 'State', 'EN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1669', 'Ferrara', 'State', 'FE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1670', 'Firenze', 'State', 'FI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1671', 'Foggia', 'State', 'FG', '106', null, 'Active');
INSERT INTO `state` VALUES ('1672', 'Forlì-Cesena', 'State', 'FC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1673', 'Frosinone', 'State', 'FR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1674', 'Genova', 'State', 'GE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1675', 'Gorizia', 'State', 'GO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1676', 'Grosseto', 'State', 'GR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1677', 'Imperia', 'State', 'IM', '106', null, 'Active');
INSERT INTO `state` VALUES ('1678', 'Isernia', 'State', 'IS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1679', 'L\'Aquila', 'State', 'AQ', '106', null, 'Active');
INSERT INTO `state` VALUES ('1680', 'La Spezia', 'State', 'SP', '106', null, 'Active');
INSERT INTO `state` VALUES ('1681', 'Latina', 'State', 'LT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1682', 'Lecce', 'State', 'LE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1683', 'Lecco', 'State', 'LC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1684', 'Livorno', 'State', 'LI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1685', 'Lodi', 'State', 'LO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1686', 'Lucca', 'State', 'LU', '106', null, 'Active');
INSERT INTO `state` VALUES ('1687', 'Macerata', 'State', 'MC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1688', 'Mantova', 'State', 'MN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1689', 'Massa-Carrara', 'State', 'MS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1690', 'Matera', 'State', 'MT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1691', 'Messina', 'State', 'ME', '106', null, 'Active');
INSERT INTO `state` VALUES ('1692', 'Milano', 'State', 'MI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1693', 'Modena', 'State', 'MO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1694', 'Napoli', 'State', 'NA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1695', 'Novara', 'State', 'NO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1696', 'Nuoro', 'State', 'NU', '106', null, 'Active');
INSERT INTO `state` VALUES ('1697', 'Oristano', 'State', 'OR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1698', 'Padova', 'State', 'PD', '106', null, 'Active');
INSERT INTO `state` VALUES ('1699', 'Palermo', 'State', 'PA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1700', 'Parma', 'State', 'PR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1701', 'Pavia', 'State', 'PV', '106', null, 'Active');
INSERT INTO `state` VALUES ('1702', 'Perugia', 'State', 'PG', '106', null, 'Active');
INSERT INTO `state` VALUES ('1703', 'Pesaro e Urbino', 'State', 'PU', '106', null, 'Active');
INSERT INTO `state` VALUES ('1704', 'Pescara', 'State', 'PE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1705', 'Piacenza', 'State', 'PC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1706', 'Pisa', 'State', 'PI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1707', 'Pistoia', 'State', 'PT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1708', 'Pordenone', 'State', 'PN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1709', 'Potenza', 'State', 'PZ', '106', null, 'Active');
INSERT INTO `state` VALUES ('1710', 'Prato', 'State', 'PO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1711', 'Ragusa', 'State', 'RG', '106', null, 'Active');
INSERT INTO `state` VALUES ('1712', 'Ravenna', 'State', 'RA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1713', 'Reggio Calabria', 'State', 'RC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1714', 'Reggio Emilia', 'State', 'RE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1715', 'Rieti', 'State', 'RI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1716', 'Rimini', 'State', 'RN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1717', 'Roma', 'State', 'RM', '106', null, 'Active');
INSERT INTO `state` VALUES ('1718', 'Rovigo', 'State', 'RO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1719', 'Salerno', 'State', 'SA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1720', 'Sassari', 'State', 'SS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1721', 'Savona', 'State', 'SV', '106', null, 'Active');
INSERT INTO `state` VALUES ('1722', 'Siena', 'State', 'SI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1723', 'Siracusa', 'State', 'SR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1724', 'Sondrio', 'State', 'SO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1725', 'Taranto', 'State', 'TA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1726', 'Teramo', 'State', 'TE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1727', 'Terni', 'State', 'TR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1728', 'Torino', 'State', 'TO', '106', null, 'Active');
INSERT INTO `state` VALUES ('1729', 'Trapani', 'State', 'TP', '106', null, 'Active');
INSERT INTO `state` VALUES ('1730', 'Trento', 'State', 'TN', '106', null, 'Active');
INSERT INTO `state` VALUES ('1731', 'Treviso', 'State', 'TV', '106', null, 'Active');
INSERT INTO `state` VALUES ('1732', 'Trieste', 'State', 'TS', '106', null, 'Active');
INSERT INTO `state` VALUES ('1733', 'Udine', 'State', 'UD', '106', null, 'Active');
INSERT INTO `state` VALUES ('1734', 'Varese', 'State', 'VA', '106', null, 'Active');
INSERT INTO `state` VALUES ('1735', 'Venezia', 'State', 'VE', '106', null, 'Active');
INSERT INTO `state` VALUES ('1736', 'Verbano-Cusio-Ossola', 'State', 'VB', '106', null, 'Active');
INSERT INTO `state` VALUES ('1737', 'Vercelli', 'State', 'VC', '106', null, 'Active');
INSERT INTO `state` VALUES ('1738', 'Verona', 'State', 'VR', '106', null, 'Active');
INSERT INTO `state` VALUES ('1739', 'Vibo Valentia', 'State', 'VV', '106', null, 'Active');
INSERT INTO `state` VALUES ('1740', 'Vicenza', 'State', 'VI', '106', null, 'Active');
INSERT INTO `state` VALUES ('1741', 'Viterbo', 'State', 'VT', '106', null, 'Active');
INSERT INTO `state` VALUES ('1742', 'Aichi', 'State', '23', '108', null, 'Active');
INSERT INTO `state` VALUES ('1743', 'Akita', 'State', '05', '108', null, 'Active');
INSERT INTO `state` VALUES ('1744', 'Aomori', 'State', '02', '108', null, 'Active');
INSERT INTO `state` VALUES ('1745', 'Chiba', 'State', '12', '108', null, 'Active');
INSERT INTO `state` VALUES ('1746', 'Ehime', 'State', '38', '108', null, 'Active');
INSERT INTO `state` VALUES ('1747', 'Fukui', 'State', '18', '108', null, 'Active');
INSERT INTO `state` VALUES ('1748', 'Fukuoka', 'State', '40', '108', null, 'Active');
INSERT INTO `state` VALUES ('1749', 'Fukusima', 'State', '07', '108', null, 'Active');
INSERT INTO `state` VALUES ('1750', 'Gifu', 'State', '21', '108', null, 'Active');
INSERT INTO `state` VALUES ('1751', 'Gunma', 'State', '10', '108', null, 'Active');
INSERT INTO `state` VALUES ('1752', 'Hiroshima', 'State', '34', '108', null, 'Active');
INSERT INTO `state` VALUES ('1753', 'Hokkaido', 'State', '01', '108', null, 'Active');
INSERT INTO `state` VALUES ('1754', 'Hyogo', 'State', '28', '108', null, 'Active');
INSERT INTO `state` VALUES ('1755', 'Ibaraki', 'State', '08', '108', null, 'Active');
INSERT INTO `state` VALUES ('1756', 'Ishikawa', 'State', '17', '108', null, 'Active');
INSERT INTO `state` VALUES ('1757', 'Iwate', 'State', '03', '108', null, 'Active');
INSERT INTO `state` VALUES ('1758', 'Kagawa', 'State', '37', '108', null, 'Active');
INSERT INTO `state` VALUES ('1759', 'Kagoshima', 'State', '46', '108', null, 'Active');
INSERT INTO `state` VALUES ('1760', 'Kanagawa', 'State', '14', '108', null, 'Active');
INSERT INTO `state` VALUES ('1761', 'Kochi', 'State', '39', '108', null, 'Active');
INSERT INTO `state` VALUES ('1762', 'Kumamoto', 'State', '43', '108', null, 'Active');
INSERT INTO `state` VALUES ('1763', 'Kyoto', 'State', '26', '108', null, 'Active');
INSERT INTO `state` VALUES ('1764', 'Mie', 'State', '24', '108', null, 'Active');
INSERT INTO `state` VALUES ('1765', 'Miyagi', 'State', '04', '108', null, 'Active');
INSERT INTO `state` VALUES ('1766', 'Miyazaki', 'State', '45', '108', null, 'Active');
INSERT INTO `state` VALUES ('1767', 'Nagano', 'State', '20', '108', null, 'Active');
INSERT INTO `state` VALUES ('1768', 'Nagasaki', 'State', '42', '108', null, 'Active');
INSERT INTO `state` VALUES ('1769', 'Nara', 'State', '29', '108', null, 'Active');
INSERT INTO `state` VALUES ('1770', 'Niigata', 'State', '15', '108', null, 'Active');
INSERT INTO `state` VALUES ('1771', 'Oita', 'State', '44', '108', null, 'Active');
INSERT INTO `state` VALUES ('1772', 'Okayama', 'State', '33', '108', null, 'Active');
INSERT INTO `state` VALUES ('1773', 'Okinawa', 'State', '47', '108', null, 'Active');
INSERT INTO `state` VALUES ('1774', 'Osaka', 'State', '27', '108', null, 'Active');
INSERT INTO `state` VALUES ('1775', 'Saga', 'State', '41', '108', null, 'Active');
INSERT INTO `state` VALUES ('1776', 'Saitama', 'State', '11', '108', null, 'Active');
INSERT INTO `state` VALUES ('1777', 'Shiga', 'State', '25', '108', null, 'Active');
INSERT INTO `state` VALUES ('1778', 'Shimane', 'State', '32', '108', null, 'Active');
INSERT INTO `state` VALUES ('1779', 'Shizuoka', 'State', '22', '108', null, 'Active');
INSERT INTO `state` VALUES ('1780', 'Tochigi', 'State', '09', '108', null, 'Active');
INSERT INTO `state` VALUES ('1781', 'Tokushima', 'State', '36', '108', null, 'Active');
INSERT INTO `state` VALUES ('1782', 'Tokyo', 'State', '13', '108', null, 'Active');
INSERT INTO `state` VALUES ('1783', 'Tottori', 'State', '31', '108', null, 'Active');
INSERT INTO `state` VALUES ('1784', 'Toyama', 'State', '16', '108', null, 'Active');
INSERT INTO `state` VALUES ('1785', 'Wakayama', 'State', '30', '108', null, 'Active');
INSERT INTO `state` VALUES ('1786', 'Yamagata', 'State', '06', '108', null, 'Active');
INSERT INTO `state` VALUES ('1787', 'Yamaguchi', 'State', '35', '108', null, 'Active');
INSERT INTO `state` VALUES ('1788', 'Yamanashi', 'State', '19', '108', null, 'Active');
INSERT INTO `state` VALUES ('1789', 'Clarendon', 'State', 'CN', '107', null, 'Active');
INSERT INTO `state` VALUES ('1790', 'Hanover', 'State', 'HR', '107', null, 'Active');
INSERT INTO `state` VALUES ('1791', 'Kingston', 'State', 'KN', '107', null, 'Active');
INSERT INTO `state` VALUES ('1792', 'Portland', 'State', 'PD', '107', null, 'Active');
INSERT INTO `state` VALUES ('1793', 'Saint Andrew', 'State', 'AW', '107', null, 'Active');
INSERT INTO `state` VALUES ('1794', 'Saint Ann', 'State', 'AN', '107', null, 'Active');
INSERT INTO `state` VALUES ('1795', 'Saint Catherine', 'State', 'CE', '107', null, 'Active');
INSERT INTO `state` VALUES ('1796', 'Saint Elizabeth', 'State', 'EH', '107', null, 'Active');
INSERT INTO `state` VALUES ('1797', 'Saint James', 'State', 'JS', '107', null, 'Active');
INSERT INTO `state` VALUES ('1798', 'Saint Mary', 'State', 'MY', '107', null, 'Active');
INSERT INTO `state` VALUES ('1799', 'Saint Thomas', 'State', 'TS', '107', null, 'Active');
INSERT INTO `state` VALUES ('1800', 'Trelawny', 'State', 'TY', '107', null, 'Active');
INSERT INTO `state` VALUES ('1801', 'Westmoreland', 'State', 'WD', '107', null, 'Active');
INSERT INTO `state` VALUES ('1802', 'Ajln', 'State', 'AJ', '109', null, 'Active');
INSERT INTO `state` VALUES ('1803', 'Al \'Aqaba', 'State', 'AQ', '109', null, 'Active');
INSERT INTO `state` VALUES ('1804', 'Al Balqa\'', 'State', 'BA', '109', null, 'Active');
INSERT INTO `state` VALUES ('1805', 'Al Karak', 'State', 'KA', '109', null, 'Active');
INSERT INTO `state` VALUES ('1806', 'Al Mafraq', 'State', 'MA', '109', null, 'Active');
INSERT INTO `state` VALUES ('1807', 'Amman', 'State', 'AM', '109', null, 'Active');
INSERT INTO `state` VALUES ('1808', 'At Tafilah', 'State', 'AT', '109', null, 'Active');
INSERT INTO `state` VALUES ('1809', 'Az Zarga', 'State', 'AZ', '109', null, 'Active');
INSERT INTO `state` VALUES ('1810', 'Irbid', 'State', 'JR', '109', null, 'Active');
INSERT INTO `state` VALUES ('1811', 'Jarash', 'State', 'JA', '109', null, 'Active');
INSERT INTO `state` VALUES ('1812', 'Ma\'an', 'State', 'MN', '109', null, 'Active');
INSERT INTO `state` VALUES ('1813', 'Madaba', 'State', 'MD', '109', null, 'Active');
INSERT INTO `state` VALUES ('1814', 'Nairobi Municipality', 'State', '110', '111', null, 'Active');
INSERT INTO `state` VALUES ('1815', 'Coast', 'State', '300', '111', null, 'Active');
INSERT INTO `state` VALUES ('1816', 'North-Eastern Kaskazini Mashariki', 'State', '500', '111', null, 'Active');
INSERT INTO `state` VALUES ('1817', 'Rift Valley', 'State', '700', '111', null, 'Active');
INSERT INTO `state` VALUES ('1818', 'Western Magharibi', 'State', '900', '111', null, 'Active');
INSERT INTO `state` VALUES ('1819', 'Bishkek', 'State', 'GB', '116', null, 'Active');
INSERT INTO `state` VALUES ('1820', 'Batken', 'State', 'B', '116', null, 'Active');
INSERT INTO `state` VALUES ('1821', 'Chu', 'State', 'C', '116', null, 'Active');
INSERT INTO `state` VALUES ('1822', 'Jalal-Abad', 'State', 'J', '116', null, 'Active');
INSERT INTO `state` VALUES ('1823', 'Naryn', 'State', 'N', '116', null, 'Active');
INSERT INTO `state` VALUES ('1824', 'Osh', 'State', 'O', '116', null, 'Active');
INSERT INTO `state` VALUES ('1825', 'Talas', 'State', 'T', '116', null, 'Active');
INSERT INTO `state` VALUES ('1826', 'Ysyk-Kol', 'State', 'Y', '116', null, 'Active');
INSERT INTO `state` VALUES ('1827', 'Krong Kaeb', 'State', '23', '37', null, 'Active');
INSERT INTO `state` VALUES ('1828', 'Krong Pailin', 'State', '24', '37', null, 'Active');
INSERT INTO `state` VALUES ('1829', 'Xrong Preah Sihanouk', 'State', '18', '37', null, 'Active');
INSERT INTO `state` VALUES ('1830', 'Phnom Penh', 'State', '12', '37', null, 'Active');
INSERT INTO `state` VALUES ('1831', 'Baat Dambang', 'State', '2', '37', null, 'Active');
INSERT INTO `state` VALUES ('1832', 'Banteay Mean Chey', 'State', '1', '37', null, 'Active');
INSERT INTO `state` VALUES ('1833', 'Rampong Chaam', 'State', '3', '37', null, 'Active');
INSERT INTO `state` VALUES ('1834', 'Kampong Chhnang', 'State', '4', '37', null, 'Active');
INSERT INTO `state` VALUES ('1835', 'Kampong Spueu', 'State', '5', '37', null, 'Active');
INSERT INTO `state` VALUES ('1836', 'Kampong Thum', 'State', '6', '37', null, 'Active');
INSERT INTO `state` VALUES ('1837', 'Kampot', 'State', '7', '37', null, 'Active');
INSERT INTO `state` VALUES ('1838', 'Kandaal', 'State', '8', '37', null, 'Active');
INSERT INTO `state` VALUES ('1839', 'Kach Kong', 'State', '9', '37', null, 'Active');
INSERT INTO `state` VALUES ('1840', 'Krachoh', 'State', '10', '37', null, 'Active');
INSERT INTO `state` VALUES ('1841', 'Mondol Kiri', 'State', '11', '37', null, 'Active');
INSERT INTO `state` VALUES ('1842', 'Otdar Mean Chey', 'State', '22', '37', null, 'Active');
INSERT INTO `state` VALUES ('1843', 'Pousaat', 'State', '15', '37', null, 'Active');
INSERT INTO `state` VALUES ('1844', 'Preah Vihear', 'State', '13', '37', null, 'Active');
INSERT INTO `state` VALUES ('1845', 'Prey Veaeng', 'State', '14', '37', null, 'Active');
INSERT INTO `state` VALUES ('1846', 'Rotanak Kiri', 'State', '16', '37', null, 'Active');
INSERT INTO `state` VALUES ('1847', 'Siem Reab', 'State', '17', '37', null, 'Active');
INSERT INTO `state` VALUES ('1848', 'Stueng Traeng', 'State', '19', '37', null, 'Active');
INSERT INTO `state` VALUES ('1849', 'Svaay Rieng', 'State', '20', '37', null, 'Active');
INSERT INTO `state` VALUES ('1850', 'Taakaev', 'State', '21', '37', null, 'Active');
INSERT INTO `state` VALUES ('1851', 'Gilbert Islands', 'State', 'G', '112', null, 'Active');
INSERT INTO `state` VALUES ('1852', 'Line Islands', 'State', 'L', '112', null, 'Active');
INSERT INTO `state` VALUES ('1853', 'Phoenix Islands', 'State', 'P', '112', null, 'Active');
INSERT INTO `state` VALUES ('1854', 'Anjouan Ndzouani', 'State', 'A', '49', null, 'Active');
INSERT INTO `state` VALUES ('1855', 'Grande Comore Ngazidja', 'State', 'G', '49', null, 'Active');
INSERT INTO `state` VALUES ('1856', 'Moheli Moili', 'State', 'M', '49', null, 'Active');
INSERT INTO `state` VALUES ('1857', 'Kaesong-si', 'State', 'KAE', '113', null, 'Active');
INSERT INTO `state` VALUES ('1858', 'Nampo-si', 'State', 'NAM', '113', null, 'Active');
INSERT INTO `state` VALUES ('1859', 'Pyongyang-ai', 'State', 'PYO', '113', null, 'Active');
INSERT INTO `state` VALUES ('1860', 'Chagang-do', 'State', 'CHA', '113', null, 'Active');
INSERT INTO `state` VALUES ('1861', 'Hamgyongbuk-do', 'State', 'HAB', '113', null, 'Active');
INSERT INTO `state` VALUES ('1862', 'Hamgyongnam-do', 'State', 'HAN', '113', null, 'Active');
INSERT INTO `state` VALUES ('1863', 'Hwanghaebuk-do', 'State', 'HWB', '113', null, 'Active');
INSERT INTO `state` VALUES ('1864', 'Hwanghaenam-do', 'State', 'HWN', '113', null, 'Active');
INSERT INTO `state` VALUES ('1865', 'Kangwon-do', 'State', 'KAN', '113', null, 'Active');
INSERT INTO `state` VALUES ('1866', 'Pyonganbuk-do', 'State', 'PYB', '113', null, 'Active');
INSERT INTO `state` VALUES ('1867', 'Pyongannam-do', 'State', 'PYN', '113', null, 'Active');
INSERT INTO `state` VALUES ('1868', 'Yanggang-do', 'State', 'YAN', '113', null, 'Active');
INSERT INTO `state` VALUES ('1869', 'Najin Sonbong-si', 'State', 'NAJ', '113', null, 'Active');
INSERT INTO `state` VALUES ('1870', 'Seoul Teugbyeolsi', 'State', '11', '114', null, 'Active');
INSERT INTO `state` VALUES ('1871', 'Busan Gwang\'yeogsi', 'State', '26', '114', null, 'Active');
INSERT INTO `state` VALUES ('1872', 'Daegu Gwang\'yeogsi', 'State', '27', '114', null, 'Active');
INSERT INTO `state` VALUES ('1873', 'Daejeon Gwang\'yeogsi', 'State', '30', '114', null, 'Active');
INSERT INTO `state` VALUES ('1874', 'Gwangju Gwang\'yeogsi', 'State', '29', '114', null, 'Active');
INSERT INTO `state` VALUES ('1875', 'Incheon Gwang\'yeogsi', 'State', '28', '114', null, 'Active');
INSERT INTO `state` VALUES ('1876', 'Ulsan Gwang\'yeogsi', 'State', '31', '114', null, 'Active');
INSERT INTO `state` VALUES ('1877', 'Chungcheongbugdo', 'State', '43', '114', null, 'Active');
INSERT INTO `state` VALUES ('1878', 'Chungcheongnamdo', 'State', '44', '114', null, 'Active');
INSERT INTO `state` VALUES ('1879', 'Gang\'weondo', 'State', '42', '114', null, 'Active');
INSERT INTO `state` VALUES ('1880', 'Gyeonggido', 'State', '41', '114', null, 'Active');
INSERT INTO `state` VALUES ('1881', 'Gyeongsangbugdo', 'State', '47', '114', null, 'Active');
INSERT INTO `state` VALUES ('1882', 'Gyeongsangnamdo', 'State', '48', '114', null, 'Active');
INSERT INTO `state` VALUES ('1883', 'Jejudo', 'State', '49', '114', null, 'Active');
INSERT INTO `state` VALUES ('1884', 'Jeonrabugdo', 'State', '45', '114', null, 'Active');
INSERT INTO `state` VALUES ('1885', 'Jeonranamdo', 'State', '46', '114', null, 'Active');
INSERT INTO `state` VALUES ('1886', 'Al Ahmadi', 'State', 'AH', '115', null, 'Active');
INSERT INTO `state` VALUES ('1887', 'Al Farwanlyah', 'State', 'FA', '115', null, 'Active');
INSERT INTO `state` VALUES ('1888', 'Al Jahrah', 'State', 'JA', '115', null, 'Active');
INSERT INTO `state` VALUES ('1889', 'Al Kuwayt', 'State', 'KU', '115', null, 'Active');
INSERT INTO `state` VALUES ('1890', 'Hawalli', 'State', 'HA', '115', null, 'Active');
INSERT INTO `state` VALUES ('1891', 'Almaty', 'State', 'ALA', '110', null, 'Active');
INSERT INTO `state` VALUES ('1892', 'Astana', 'State', 'AST', '110', null, 'Active');
INSERT INTO `state` VALUES ('1893', 'Almaty oblysy', 'State', 'ALM', '110', null, 'Active');
INSERT INTO `state` VALUES ('1894', 'Aqmola oblysy', 'State', 'AKM', '110', null, 'Active');
INSERT INTO `state` VALUES ('1895', 'Aqtobe oblysy', 'State', 'AKT', '110', null, 'Active');
INSERT INTO `state` VALUES ('1896', 'Atyrau oblyfiy', 'State', 'ATY', '110', null, 'Active');
INSERT INTO `state` VALUES ('1897', 'Batys Quzaqstan oblysy', 'State', 'ZAP', '110', null, 'Active');
INSERT INTO `state` VALUES ('1898', 'Mangghystau oblysy', 'State', 'MAN', '110', null, 'Active');
INSERT INTO `state` VALUES ('1899', 'Ongtustik Quzaqstan oblysy', 'State', 'YUZ', '110', null, 'Active');
INSERT INTO `state` VALUES ('1900', 'Pavlodar oblysy', 'State', 'PAV', '110', null, 'Active');
INSERT INTO `state` VALUES ('1901', 'Qaraghandy oblysy', 'State', 'KAR', '110', null, 'Active');
INSERT INTO `state` VALUES ('1902', 'Qostanay oblysy', 'State', 'KUS', '110', null, 'Active');
INSERT INTO `state` VALUES ('1903', 'Qyzylorda oblysy', 'State', 'KZY', '110', null, 'Active');
INSERT INTO `state` VALUES ('1904', 'Shyghys Quzaqstan oblysy', 'State', 'VOS', '110', null, 'Active');
INSERT INTO `state` VALUES ('1905', 'Soltustik Quzaqstan oblysy', 'State', 'SEV', '110', null, 'Active');
INSERT INTO `state` VALUES ('1906', 'Zhambyl oblysy Zhambylskaya oblast\'', 'State', 'ZHA', '110', null, 'Active');
INSERT INTO `state` VALUES ('1907', 'Vientiane', 'State', 'VT', '117', null, 'Active');
INSERT INTO `state` VALUES ('1908', 'Attapu', 'State', 'AT', '117', null, 'Active');
INSERT INTO `state` VALUES ('1909', 'Bokeo', 'State', 'BK', '117', null, 'Active');
INSERT INTO `state` VALUES ('1910', 'Bolikhamxai', 'State', 'BL', '117', null, 'Active');
INSERT INTO `state` VALUES ('1911', 'Champasak', 'State', 'CH', '117', null, 'Active');
INSERT INTO `state` VALUES ('1912', 'Houaphan', 'State', 'HO', '117', null, 'Active');
INSERT INTO `state` VALUES ('1913', 'Khammouan', 'State', 'KH', '117', null, 'Active');
INSERT INTO `state` VALUES ('1914', 'Louang Namtha', 'State', 'LM', '117', null, 'Active');
INSERT INTO `state` VALUES ('1915', 'Louangphabang', 'State', 'LP', '117', null, 'Active');
INSERT INTO `state` VALUES ('1916', 'Oudomxai', 'State', 'OU', '117', null, 'Active');
INSERT INTO `state` VALUES ('1917', 'Phongsali', 'State', 'PH', '117', null, 'Active');
INSERT INTO `state` VALUES ('1918', 'Salavan', 'State', 'SL', '117', null, 'Active');
INSERT INTO `state` VALUES ('1919', 'Savannakhet', 'State', 'SV', '117', null, 'Active');
INSERT INTO `state` VALUES ('1920', 'Xaignabouli', 'State', 'XA', '117', null, 'Active');
INSERT INTO `state` VALUES ('1921', 'Xiasomboun', 'State', 'XN', '117', null, 'Active');
INSERT INTO `state` VALUES ('1922', 'Xekong', 'State', 'XE', '117', null, 'Active');
INSERT INTO `state` VALUES ('1923', 'Xiangkhoang', 'State', 'XI', '117', null, 'Active');
INSERT INTO `state` VALUES ('1924', 'Beirout', 'State', 'BA', '119', null, 'Active');
INSERT INTO `state` VALUES ('1925', 'El Begsa', 'State', 'BI', '119', null, 'Active');
INSERT INTO `state` VALUES ('1926', 'Jabal Loubnane', 'State', 'JL', '119', null, 'Active');
INSERT INTO `state` VALUES ('1927', 'Loubnane ech Chemali', 'State', 'AS', '119', null, 'Active');
INSERT INTO `state` VALUES ('1928', 'Loubnane ej Jnoubi', 'State', 'JA', '119', null, 'Active');
INSERT INTO `state` VALUES ('1929', 'Nabatiye', 'State', 'NA', '119', null, 'Active');
INSERT INTO `state` VALUES ('1930', 'Ampara', 'State', '52', '198', null, 'Active');
INSERT INTO `state` VALUES ('1931', 'Anuradhapura', 'State', '71', '198', null, 'Active');
INSERT INTO `state` VALUES ('1932', 'Badulla', 'State', '81', '198', null, 'Active');
INSERT INTO `state` VALUES ('1933', 'Batticaloa', 'State', '51', '198', null, 'Active');
INSERT INTO `state` VALUES ('1934', 'Colombo', 'State', '11', '198', null, 'Active');
INSERT INTO `state` VALUES ('1935', 'Galle', 'State', '31', '198', null, 'Active');
INSERT INTO `state` VALUES ('1936', 'Gampaha', 'State', '12', '198', null, 'Active');
INSERT INTO `state` VALUES ('1937', 'Hambantota', 'State', '33', '198', null, 'Active');
INSERT INTO `state` VALUES ('1938', 'Jaffna', 'State', '41', '198', null, 'Active');
INSERT INTO `state` VALUES ('1939', 'Kalutara', 'State', '13', '198', null, 'Active');
INSERT INTO `state` VALUES ('1940', 'Kandy', 'State', '21', '198', null, 'Active');
INSERT INTO `state` VALUES ('1941', 'Kegalla', 'State', '92', '198', null, 'Active');
INSERT INTO `state` VALUES ('1942', 'Kilinochchi', 'State', '42', '198', null, 'Active');
INSERT INTO `state` VALUES ('1943', 'Kurunegala', 'State', '61', '198', null, 'Active');
INSERT INTO `state` VALUES ('1944', 'Mannar', 'State', '43', '198', null, 'Active');
INSERT INTO `state` VALUES ('1945', 'Matale', 'State', '22', '198', null, 'Active');
INSERT INTO `state` VALUES ('1946', 'Matara', 'State', '32', '198', null, 'Active');
INSERT INTO `state` VALUES ('1947', 'Monaragala', 'State', '82', '198', null, 'Active');
INSERT INTO `state` VALUES ('1948', 'Mullaittivu', 'State', '45', '198', null, 'Active');
INSERT INTO `state` VALUES ('1949', 'Nuwara Eliya', 'State', '23', '198', null, 'Active');
INSERT INTO `state` VALUES ('1950', 'Polonnaruwa', 'State', '72', '198', null, 'Active');
INSERT INTO `state` VALUES ('1951', 'Puttalum', 'State', '62', '198', null, 'Active');
INSERT INTO `state` VALUES ('1952', 'Ratnapura', 'State', '91', '198', null, 'Active');
INSERT INTO `state` VALUES ('1953', 'Trincomalee', 'State', '53', '198', null, 'Active');
INSERT INTO `state` VALUES ('1954', 'VavunLya', 'State', '44', '198', null, 'Active');
INSERT INTO `state` VALUES ('1955', 'Bomi', 'State', 'BM', '121', null, 'Active');
INSERT INTO `state` VALUES ('1956', 'Bong', 'State', 'BG', '121', null, 'Active');
INSERT INTO `state` VALUES ('1957', 'Grand Basaa', 'State', 'GB', '121', null, 'Active');
INSERT INTO `state` VALUES ('1958', 'Grand Cape Mount', 'State', 'CM', '121', null, 'Active');
INSERT INTO `state` VALUES ('1959', 'Grand Gedeh', 'State', 'GG', '121', null, 'Active');
INSERT INTO `state` VALUES ('1960', 'Grand Kru', 'State', 'GK', '121', null, 'Active');
INSERT INTO `state` VALUES ('1961', 'Lofa', 'State', 'LO', '121', null, 'Active');
INSERT INTO `state` VALUES ('1962', 'Margibi', 'State', 'MG', '121', null, 'Active');
INSERT INTO `state` VALUES ('1963', 'Maryland', 'State', 'MY', '121', null, 'Active');
INSERT INTO `state` VALUES ('1964', 'Montserrado', 'State', 'MO', '121', null, 'Active');
INSERT INTO `state` VALUES ('1965', 'Nimba', 'State', 'NI', '121', null, 'Active');
INSERT INTO `state` VALUES ('1966', 'Rivercess', 'State', 'RI', '121', null, 'Active');
INSERT INTO `state` VALUES ('1967', 'Sinoe', 'State', 'SI', '121', null, 'Active');
INSERT INTO `state` VALUES ('1968', 'Berea', 'State', 'D', '120', null, 'Active');
INSERT INTO `state` VALUES ('1969', 'Butha-Buthe', 'State', 'B', '120', null, 'Active');
INSERT INTO `state` VALUES ('1970', 'Leribe', 'State', 'C', '120', null, 'Active');
INSERT INTO `state` VALUES ('1971', 'Mafeteng', 'State', 'E', '120', null, 'Active');
INSERT INTO `state` VALUES ('1972', 'Maseru', 'State', 'A', '120', null, 'Active');
INSERT INTO `state` VALUES ('1973', 'Mohale\'s Hoek', 'State', 'F', '120', null, 'Active');
INSERT INTO `state` VALUES ('1974', 'Mokhotlong', 'State', 'J', '120', null, 'Active');
INSERT INTO `state` VALUES ('1975', 'Qacha\'s Nek', 'State', 'H', '120', null, 'Active');
INSERT INTO `state` VALUES ('1976', 'Quthing', 'State', 'G', '120', null, 'Active');
INSERT INTO `state` VALUES ('1977', 'Thaba-Tseka', 'State', 'K', '120', null, 'Active');
INSERT INTO `state` VALUES ('1978', 'Alytaus Apskritis', 'State', 'AL', '124', null, 'Active');
INSERT INTO `state` VALUES ('1979', 'Kauno Apskritis', 'State', 'KU', '124', null, 'Active');
INSERT INTO `state` VALUES ('1980', 'Klaipedos Apskritis', 'State', 'KL', '124', null, 'Active');
INSERT INTO `state` VALUES ('1981', 'Marijampoles Apskritis', 'State', 'MR', '124', null, 'Active');
INSERT INTO `state` VALUES ('1982', 'Panevezio Apskritis', 'State', 'PN', '124', null, 'Active');
INSERT INTO `state` VALUES ('1983', 'Sisuliu Apskritis', 'State', 'SA', '124', null, 'Active');
INSERT INTO `state` VALUES ('1984', 'Taurages Apskritis', 'State', 'TA', '124', null, 'Active');
INSERT INTO `state` VALUES ('1985', 'Telsiu Apskritis', 'State', 'TE', '124', null, 'Active');
INSERT INTO `state` VALUES ('1986', 'Utenos Apskritis', 'State', 'UT', '124', null, 'Active');
INSERT INTO `state` VALUES ('1987', 'Vilniaus Apskritis', 'State', 'VL', '124', null, 'Active');
INSERT INTO `state` VALUES ('1988', 'Diekirch', 'State', 'D', '125', null, 'Active');
INSERT INTO `state` VALUES ('1989', 'GreveNmacher', 'State', 'G', '125', null, 'Active');
INSERT INTO `state` VALUES ('1990', 'Aizkraukles Apripkis', 'State', 'AI', '118', null, 'Active');
INSERT INTO `state` VALUES ('1991', 'Alkanes Apripkis', 'State', 'AL', '118', null, 'Active');
INSERT INTO `state` VALUES ('1992', 'Balvu Apripkis', 'State', 'BL', '118', null, 'Active');
INSERT INTO `state` VALUES ('1993', 'Bauskas Apripkis', 'State', 'BU', '118', null, 'Active');
INSERT INTO `state` VALUES ('1994', 'Cesu Aprikis', 'State', 'CE', '118', null, 'Active');
INSERT INTO `state` VALUES ('1995', 'Daugavpile Apripkis', 'State', 'DA', '118', null, 'Active');
INSERT INTO `state` VALUES ('1996', 'Dobeles Apripkis', 'State', 'DO', '118', null, 'Active');
INSERT INTO `state` VALUES ('1997', 'Gulbenes Aprlpkis', 'State', 'GU', '118', null, 'Active');
INSERT INTO `state` VALUES ('1998', 'Jelgavas Apripkis', 'State', 'JL', '118', null, 'Active');
INSERT INTO `state` VALUES ('1999', 'Jekabpils Apripkis', 'State', 'JK', '118', null, 'Active');
INSERT INTO `state` VALUES ('2000', 'Kraslavas Apripkis', 'State', 'KR', '118', null, 'Active');
INSERT INTO `state` VALUES ('2001', 'Kuldlgas Apripkis', 'State', 'KU', '118', null, 'Active');
INSERT INTO `state` VALUES ('2002', 'Limbazu Apripkis', 'State', 'LM', '118', null, 'Active');
INSERT INTO `state` VALUES ('2003', 'Liepajas Apripkis', 'State', 'LE', '118', null, 'Active');
INSERT INTO `state` VALUES ('2004', 'Ludzas Apripkis', 'State', 'LU', '118', null, 'Active');
INSERT INTO `state` VALUES ('2005', 'Madonas Apripkis', 'State', 'MA', '118', null, 'Active');
INSERT INTO `state` VALUES ('2006', 'Ogres Apripkis', 'State', 'OG', '118', null, 'Active');
INSERT INTO `state` VALUES ('2007', 'Preilu Apripkis', 'State', 'PR', '118', null, 'Active');
INSERT INTO `state` VALUES ('2008', 'Rezaknes Apripkis', 'State', 'RE', '118', null, 'Active');
INSERT INTO `state` VALUES ('2009', 'Rigas Apripkis', 'State', 'RI', '118', null, 'Active');
INSERT INTO `state` VALUES ('2010', 'Saldus Apripkis', 'State', 'SA', '118', null, 'Active');
INSERT INTO `state` VALUES ('2011', 'Talsu Apripkis', 'State', 'TA', '118', null, 'Active');
INSERT INTO `state` VALUES ('2012', 'Tukuma Apriplcis', 'State', 'TU', '118', null, 'Active');
INSERT INTO `state` VALUES ('2013', 'Valkas Apripkis', 'State', 'VK', '118', null, 'Active');
INSERT INTO `state` VALUES ('2014', 'Valmieras Apripkis', 'State', 'VM', '118', null, 'Active');
INSERT INTO `state` VALUES ('2015', 'Ventspils Apripkis', 'State', 'VE', '118', null, 'Active');
INSERT INTO `state` VALUES ('2016', 'Daugavpils', 'State', 'DGV', '118', null, 'Active');
INSERT INTO `state` VALUES ('2017', 'Jelgava', 'State', 'JEL', '118', null, 'Active');
INSERT INTO `state` VALUES ('2018', 'Jurmala', 'State', 'JUR', '118', null, 'Active');
INSERT INTO `state` VALUES ('2019', 'Liepaja', 'State', 'LPX', '118', null, 'Active');
INSERT INTO `state` VALUES ('2020', 'Rezekne', 'State', 'REZ', '118', null, 'Active');
INSERT INTO `state` VALUES ('2021', 'Riga', 'State', 'RIX', '118', null, 'Active');
INSERT INTO `state` VALUES ('2022', 'Ventspils', 'State', 'VEN', '118', null, 'Active');
INSERT INTO `state` VALUES ('2023', 'Ajd?biy?', 'State', 'AJ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2024', 'Al Bu?n?n', 'State', 'BU', '122', null, 'Active');
INSERT INTO `state` VALUES ('2025', 'Al Hiz?m al Akhdar', 'State', 'HZ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2026', 'Al Jabal al Akhdar', 'State', 'JA', '122', null, 'Active');
INSERT INTO `state` VALUES ('2027', 'Al Jif?rah', 'State', 'JI', '122', null, 'Active');
INSERT INTO `state` VALUES ('2028', 'Al Jufrah', 'State', 'JU', '122', null, 'Active');
INSERT INTO `state` VALUES ('2029', 'Al Kufrah', 'State', 'KF', '122', null, 'Active');
INSERT INTO `state` VALUES ('2030', 'Al Marj', 'State', 'MJ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2031', 'Al Marqab', 'State', 'MB', '122', null, 'Active');
INSERT INTO `state` VALUES ('2032', 'Al Qa?r?n', 'State', 'QT', '122', null, 'Active');
INSERT INTO `state` VALUES ('2033', 'Al Qubbah', 'State', 'QB', '122', null, 'Active');
INSERT INTO `state` VALUES ('2034', 'Al W?hah', 'State', 'WA', '122', null, 'Active');
INSERT INTO `state` VALUES ('2035', 'An Nuqa? al Khams', 'State', 'NQ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2036', 'Ash Sh??i\'', 'State', 'SH', '122', null, 'Active');
INSERT INTO `state` VALUES ('2037', 'Az Z?wiyah', 'State', 'ZA', '122', null, 'Active');
INSERT INTO `state` VALUES ('2038', 'Bangh?z?', 'State', 'BA', '122', null, 'Active');
INSERT INTO `state` VALUES ('2039', 'Ban? Wal?d', 'State', 'BW', '122', null, 'Active');
INSERT INTO `state` VALUES ('2040', 'Darnah', 'State', 'DR', '122', null, 'Active');
INSERT INTO `state` VALUES ('2041', 'Ghad?mis', 'State', 'GD', '122', null, 'Active');
INSERT INTO `state` VALUES ('2042', 'Ghary?n', 'State', 'GR', '122', null, 'Active');
INSERT INTO `state` VALUES ('2043', 'Gh?t', 'State', 'GT', '122', null, 'Active');
INSERT INTO `state` VALUES ('2044', 'Jaghb?b', 'State', 'JB', '122', null, 'Active');
INSERT INTO `state` VALUES ('2045', 'Mi?r?tah', 'State', 'MI', '122', null, 'Active');
INSERT INTO `state` VALUES ('2046', 'Mizdah', 'State', 'MZ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2047', 'Murzuq', 'State', 'MQ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2048', 'N?l?t', 'State', 'NL', '122', null, 'Active');
INSERT INTO `state` VALUES ('2049', 'Sabh?', 'State', 'SB', '122', null, 'Active');
INSERT INTO `state` VALUES ('2050', '?abr?tah ?urm?n', 'State', 'SS', '122', null, 'Active');
INSERT INTO `state` VALUES ('2051', 'Surt', 'State', 'SR', '122', null, 'Active');
INSERT INTO `state` VALUES ('2052', 'T?j?r?\' wa an Naw?h? al Arb?h', 'State', 'TN', '122', null, 'Active');
INSERT INTO `state` VALUES ('2053', '?ar?bulus', 'State', 'TB', '122', null, 'Active');
INSERT INTO `state` VALUES ('2054', 'Tarh?nah-Masall?tah', 'State', 'TM', '122', null, 'Active');
INSERT INTO `state` VALUES ('2055', 'W?d? al hay?t', 'State', 'WD', '122', null, 'Active');
INSERT INTO `state` VALUES ('2056', 'Yafran-J?d?', 'State', 'YJ', '122', null, 'Active');
INSERT INTO `state` VALUES ('2057', 'Agadir', 'State', 'AGD', '145', null, 'Active');
INSERT INTO `state` VALUES ('2058', 'Aït Baha', 'State', 'BAH', '145', null, 'Active');
INSERT INTO `state` VALUES ('2059', 'Aït Melloul', 'State', 'MEL', '145', null, 'Active');
INSERT INTO `state` VALUES ('2060', 'Al Haouz', 'State', 'HAO', '145', null, 'Active');
INSERT INTO `state` VALUES ('2061', 'Al Hoceïma', 'State', 'HOC', '145', null, 'Active');
INSERT INTO `state` VALUES ('2062', 'Assa-Zag', 'State', 'ASZ', '145', null, 'Active');
INSERT INTO `state` VALUES ('2063', 'Azilal', 'State', 'AZI', '145', null, 'Active');
INSERT INTO `state` VALUES ('2064', 'Beni Mellal', 'State', 'BEM', '145', null, 'Active');
INSERT INTO `state` VALUES ('2065', 'Ben Sllmane', 'State', 'BES', '145', null, 'Active');
INSERT INTO `state` VALUES ('2066', 'Berkane', 'State', 'BER', '145', null, 'Active');
INSERT INTO `state` VALUES ('2067', 'Boujdour', 'State', 'BOD', '145', null, 'Active');
INSERT INTO `state` VALUES ('2068', 'Boulemane', 'State', 'BOM', '145', null, 'Active');
INSERT INTO `state` VALUES ('2069', 'Casablanca  [Dar el Beïda]', 'State', 'CAS', '145', null, 'Active');
INSERT INTO `state` VALUES ('2070', 'Chefchaouene', 'State', 'CHE', '145', null, 'Active');
INSERT INTO `state` VALUES ('2071', 'Chichaoua', 'State', 'CHI', '145', null, 'Active');
INSERT INTO `state` VALUES ('2072', 'El Hajeb', 'State', 'HAJ', '145', null, 'Active');
INSERT INTO `state` VALUES ('2073', 'El Jadida', 'State', 'JDI', '145', null, 'Active');
INSERT INTO `state` VALUES ('2074', 'Errachidia', 'State', 'ERR', '145', null, 'Active');
INSERT INTO `state` VALUES ('2075', 'Essaouira', 'State', 'ESI', '145', null, 'Active');
INSERT INTO `state` VALUES ('2076', 'Es Smara', 'State', 'ESM', '145', null, 'Active');
INSERT INTO `state` VALUES ('2077', 'Fès', 'State', 'FES', '145', null, 'Active');
INSERT INTO `state` VALUES ('2078', 'Figuig', 'State', 'FIG', '145', null, 'Active');
INSERT INTO `state` VALUES ('2079', 'Guelmim', 'State', 'GUE', '145', null, 'Active');
INSERT INTO `state` VALUES ('2080', 'Ifrane', 'State', 'IFR', '145', null, 'Active');
INSERT INTO `state` VALUES ('2081', 'Jerada', 'State', 'JRA', '145', null, 'Active');
INSERT INTO `state` VALUES ('2082', 'Kelaat Sraghna', 'State', 'KES', '145', null, 'Active');
INSERT INTO `state` VALUES ('2083', 'Kénitra', 'State', 'KEN', '145', null, 'Active');
INSERT INTO `state` VALUES ('2084', 'Khemisaet', 'State', 'KHE', '145', null, 'Active');
INSERT INTO `state` VALUES ('2085', 'Khenifra', 'State', 'KHN', '145', null, 'Active');
INSERT INTO `state` VALUES ('2086', 'Khouribga', 'State', 'KHO', '145', null, 'Active');
INSERT INTO `state` VALUES ('2087', 'Laâyoune (EH)', 'State', 'LAA', '145', null, 'Active');
INSERT INTO `state` VALUES ('2088', 'Larache', 'State', 'LAP', '145', null, 'Active');
INSERT INTO `state` VALUES ('2089', 'Marrakech', 'State', 'MAR', '145', null, 'Active');
INSERT INTO `state` VALUES ('2090', 'Meknsès', 'State', 'MEK', '145', null, 'Active');
INSERT INTO `state` VALUES ('2091', 'Nador', 'State', 'NAD', '145', null, 'Active');
INSERT INTO `state` VALUES ('2092', 'Ouarzazate', 'State', 'OUA', '145', null, 'Active');
INSERT INTO `state` VALUES ('2093', 'Oued ed Dahab (EH)', 'State', 'OUD', '145', null, 'Active');
INSERT INTO `state` VALUES ('2094', 'Oujda', 'State', 'OUJ', '145', null, 'Active');
INSERT INTO `state` VALUES ('2095', 'Rabat-Salé', 'State', 'RBA', '145', null, 'Active');
INSERT INTO `state` VALUES ('2096', 'Safi', 'State', 'SAF', '145', null, 'Active');
INSERT INTO `state` VALUES ('2097', 'Sefrou', 'State', 'SEF', '145', null, 'Active');
INSERT INTO `state` VALUES ('2098', 'Settat', 'State', 'SET', '145', null, 'Active');
INSERT INTO `state` VALUES ('2099', 'Sidl Kacem', 'State', 'SIK', '145', null, 'Active');
INSERT INTO `state` VALUES ('2100', 'Tanger', 'State', 'TNG', '145', null, 'Active');
INSERT INTO `state` VALUES ('2101', 'Tan-Tan', 'State', 'TNT', '145', null, 'Active');
INSERT INTO `state` VALUES ('2102', 'Taounate', 'State', 'TAO', '145', null, 'Active');
INSERT INTO `state` VALUES ('2103', 'Taroudannt', 'State', 'TAR', '145', null, 'Active');
INSERT INTO `state` VALUES ('2104', 'Tata', 'State', 'TAT', '145', null, 'Active');
INSERT INTO `state` VALUES ('2105', 'Taza', 'State', 'TAZ', '145', null, 'Active');
INSERT INTO `state` VALUES ('2106', 'Tétouan', 'State', 'TET', '145', null, 'Active');
INSERT INTO `state` VALUES ('2107', 'Tiznit', 'State', 'TIZ', '145', null, 'Active');
INSERT INTO `state` VALUES ('2108', 'Gagauzia, Unitate Teritoriala Autonoma', 'State', 'GA', '141', null, 'Active');
INSERT INTO `state` VALUES ('2109', 'Chisinau', 'State', 'CU', '141', null, 'Active');
INSERT INTO `state` VALUES ('2110', 'Stinga Nistrului, unitatea teritoriala din', 'State', 'SN', '141', null, 'Active');
INSERT INTO `state` VALUES ('2111', 'Balti', 'State', 'BA', '141', null, 'Active');
INSERT INTO `state` VALUES ('2112', 'Cahul', 'State', 'CA', '141', null, 'Active');
INSERT INTO `state` VALUES ('2113', 'Edinet', 'State', 'ED', '141', null, 'Active');
INSERT INTO `state` VALUES ('2114', 'Lapusna', 'State', 'LA', '141', null, 'Active');
INSERT INTO `state` VALUES ('2115', 'Orhei', 'State', 'OR', '141', null, 'Active');
INSERT INTO `state` VALUES ('2116', 'Soroca', 'State', 'SO', '141', null, 'Active');
INSERT INTO `state` VALUES ('2117', 'Taraclia', 'State', 'TA', '141', null, 'Active');
INSERT INTO `state` VALUES ('2118', 'Tighina [Bender]', 'State', 'TI', '141', null, 'Active');
INSERT INTO `state` VALUES ('2119', 'Ungheni', 'State', 'UN', '141', null, 'Active');
INSERT INTO `state` VALUES ('2120', 'Antananarivo', 'State', 'T', '128', null, 'Active');
INSERT INTO `state` VALUES ('2121', 'Antsiranana', 'State', 'D', '128', null, 'Active');
INSERT INTO `state` VALUES ('2122', 'Fianarantsoa', 'State', 'F', '128', null, 'Active');
INSERT INTO `state` VALUES ('2123', 'Mahajanga', 'State', 'M', '128', null, 'Active');
INSERT INTO `state` VALUES ('2124', 'Toamasina', 'State', 'A', '128', null, 'Active');
INSERT INTO `state` VALUES ('2125', 'Toliara', 'State', 'U', '128', null, 'Active');
INSERT INTO `state` VALUES ('2126', 'Ailinglapalap', 'State', 'ALL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2127', 'Ailuk', 'State', 'ALK', '134', null, 'Active');
INSERT INTO `state` VALUES ('2128', 'Arno', 'State', 'ARN', '134', null, 'Active');
INSERT INTO `state` VALUES ('2129', 'Aur', 'State', 'AUR', '134', null, 'Active');
INSERT INTO `state` VALUES ('2130', 'Ebon', 'State', 'EBO', '134', null, 'Active');
INSERT INTO `state` VALUES ('2131', 'Eniwetok', 'State', 'ENI', '134', null, 'Active');
INSERT INTO `state` VALUES ('2132', 'Jaluit', 'State', 'JAL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2133', 'Kili', 'State', 'KIL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2134', 'Kwajalein', 'State', 'KWA', '134', null, 'Active');
INSERT INTO `state` VALUES ('2135', 'Lae', 'State', 'LAE', '134', null, 'Active');
INSERT INTO `state` VALUES ('2136', 'Lib', 'State', 'LIB', '134', null, 'Active');
INSERT INTO `state` VALUES ('2137', 'Likiep', 'State', 'LIK', '134', null, 'Active');
INSERT INTO `state` VALUES ('2138', 'Majuro', 'State', 'MAJ', '134', null, 'Active');
INSERT INTO `state` VALUES ('2139', 'Maloelap', 'State', 'MAL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2140', 'Mejit', 'State', 'MEJ', '134', null, 'Active');
INSERT INTO `state` VALUES ('2141', 'Mili', 'State', 'MIL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2142', 'Namorik', 'State', 'NMK', '134', null, 'Active');
INSERT INTO `state` VALUES ('2143', 'Namu', 'State', 'NMU', '134', null, 'Active');
INSERT INTO `state` VALUES ('2144', 'Rongelap', 'State', 'RON', '134', null, 'Active');
INSERT INTO `state` VALUES ('2145', 'Ujae', 'State', 'UJA', '134', null, 'Active');
INSERT INTO `state` VALUES ('2146', 'Ujelang', 'State', 'UJL', '134', null, 'Active');
INSERT INTO `state` VALUES ('2147', 'Utirik', 'State', 'UTI', '134', null, 'Active');
INSERT INTO `state` VALUES ('2148', 'Wotho', 'State', 'WTN', '134', null, 'Active');
INSERT INTO `state` VALUES ('2149', 'Wotje', 'State', 'WTJ', '134', null, 'Active');
INSERT INTO `state` VALUES ('2150', 'Bamako', 'State', 'BK0', '132', null, 'Active');
INSERT INTO `state` VALUES ('2151', 'Gao', 'State', '7', '132', null, 'Active');
INSERT INTO `state` VALUES ('2152', 'Kayes', 'State', '1', '132', null, 'Active');
INSERT INTO `state` VALUES ('2153', 'Kidal', 'State', '8', '132', null, 'Active');
INSERT INTO `state` VALUES ('2154', 'Xoulikoro', 'State', '2', '132', null, 'Active');
INSERT INTO `state` VALUES ('2155', 'Mopti', 'State', '5', '132', null, 'Active');
INSERT INTO `state` VALUES ('2156', 'S69ou', 'State', '4', '132', null, 'Active');
INSERT INTO `state` VALUES ('2157', 'Sikasso', 'State', '3', '132', null, 'Active');
INSERT INTO `state` VALUES ('2158', 'Tombouctou', 'State', '6', '132', null, 'Active');
INSERT INTO `state` VALUES ('2159', 'Ayeyarwady', 'State', '07', '35', null, 'Active');
INSERT INTO `state` VALUES ('2160', 'Bago', 'State', '02', '35', null, 'Active');
INSERT INTO `state` VALUES ('2161', 'Magway', 'State', '03', '35', null, 'Active');
INSERT INTO `state` VALUES ('2162', 'Mandalay', 'State', '04', '35', null, 'Active');
INSERT INTO `state` VALUES ('2163', 'Sagaing', 'State', '01', '35', null, 'Active');
INSERT INTO `state` VALUES ('2164', 'Tanintharyi', 'State', '05', '35', null, 'Active');
INSERT INTO `state` VALUES ('2165', 'Yangon', 'State', '06', '35', null, 'Active');
INSERT INTO `state` VALUES ('2166', 'Chin', 'State', '14', '35', null, 'Active');
INSERT INTO `state` VALUES ('2167', 'Kachin', 'State', '11', '35', null, 'Active');
INSERT INTO `state` VALUES ('2168', 'Kayah', 'State', '12', '35', null, 'Active');
INSERT INTO `state` VALUES ('2169', 'Kayin', 'State', '13', '35', null, 'Active');
INSERT INTO `state` VALUES ('2170', 'Mon', 'State', '15', '35', null, 'Active');
INSERT INTO `state` VALUES ('2171', 'Rakhine', 'State', '16', '35', null, 'Active');
INSERT INTO `state` VALUES ('2172', 'Shan', 'State', '17', '35', null, 'Active');
INSERT INTO `state` VALUES ('2173', 'Ulaanbaatar', 'State', '1', '143', null, 'Active');
INSERT INTO `state` VALUES ('2174', 'Arhangay', 'State', '073', '143', null, 'Active');
INSERT INTO `state` VALUES ('2175', 'Bayanhongor', 'State', '069', '143', null, 'Active');
INSERT INTO `state` VALUES ('2176', 'Bayan-Olgiy', 'State', '071', '143', null, 'Active');
INSERT INTO `state` VALUES ('2177', 'Bulgan', 'State', '067', '143', null, 'Active');
INSERT INTO `state` VALUES ('2178', 'Darhan uul', 'State', '037', '143', null, 'Active');
INSERT INTO `state` VALUES ('2179', 'Dornod', 'State', '061', '143', null, 'Active');
INSERT INTO `state` VALUES ('2180', 'Dornogov,', 'State', '063', '143', null, 'Active');
INSERT INTO `state` VALUES ('2181', 'DundgovL', 'State', '059', '143', null, 'Active');
INSERT INTO `state` VALUES ('2182', 'Dzavhan', 'State', '057', '143', null, 'Active');
INSERT INTO `state` VALUES ('2183', 'Govi-Altay', 'State', '065', '143', null, 'Active');
INSERT INTO `state` VALUES ('2184', 'Govi-Smber', 'State', '064', '143', null, 'Active');
INSERT INTO `state` VALUES ('2185', 'Hentiy', 'State', '039', '143', null, 'Active');
INSERT INTO `state` VALUES ('2186', 'Hovd', 'State', '043', '143', null, 'Active');
INSERT INTO `state` VALUES ('2187', 'Hovsgol', 'State', '041', '143', null, 'Active');
INSERT INTO `state` VALUES ('2188', 'Omnogovi', 'State', '053', '143', null, 'Active');
INSERT INTO `state` VALUES ('2189', 'Orhon', 'State', '035', '143', null, 'Active');
INSERT INTO `state` VALUES ('2190', 'Ovorhangay', 'State', '055', '143', null, 'Active');
INSERT INTO `state` VALUES ('2191', 'Selenge', 'State', '049', '143', null, 'Active');
INSERT INTO `state` VALUES ('2192', 'Shbaatar', 'State', '051', '143', null, 'Active');
INSERT INTO `state` VALUES ('2193', 'Tov', 'State', '047', '143', null, 'Active');
INSERT INTO `state` VALUES ('2194', 'Uvs', 'State', '046', '143', null, 'Active');
INSERT INTO `state` VALUES ('2195', 'Nouakchott', 'State', 'NKC', '136', null, 'Active');
INSERT INTO `state` VALUES ('2196', 'Assaba', 'State', '03', '136', null, 'Active');
INSERT INTO `state` VALUES ('2197', 'Brakna', 'State', '05', '136', null, 'Active');
INSERT INTO `state` VALUES ('2198', 'Dakhlet Nouadhibou', 'State', '08', '136', null, 'Active');
INSERT INTO `state` VALUES ('2199', 'Gorgol', 'State', '04', '136', null, 'Active');
INSERT INTO `state` VALUES ('2200', 'Guidimaka', 'State', '10', '136', null, 'Active');
INSERT INTO `state` VALUES ('2201', 'Hodh ech Chargui', 'State', '01', '136', null, 'Active');
INSERT INTO `state` VALUES ('2202', 'Hodh el Charbi', 'State', '02', '136', null, 'Active');
INSERT INTO `state` VALUES ('2203', 'Inchiri', 'State', '12', '136', null, 'Active');
INSERT INTO `state` VALUES ('2204', 'Tagant', 'State', '09', '136', null, 'Active');
INSERT INTO `state` VALUES ('2205', 'Tiris Zemmour', 'State', '11', '136', null, 'Active');
INSERT INTO `state` VALUES ('2206', 'Trarza', 'State', '06', '136', null, 'Active');
INSERT INTO `state` VALUES ('2207', 'Beau Bassin-Rose Hill', 'State', 'BR', '137', null, 'Active');
INSERT INTO `state` VALUES ('2208', 'Curepipe', 'State', 'CU', '137', null, 'Active');
INSERT INTO `state` VALUES ('2209', 'Port Louis', 'State', 'PU', '137', null, 'Active');
INSERT INTO `state` VALUES ('2210', 'Quatre Bornes', 'State', 'QB', '137', null, 'Active');
INSERT INTO `state` VALUES ('2211', 'Vacosa-Phoenix', 'State', 'VP', '137', null, 'Active');
INSERT INTO `state` VALUES ('2212', 'Black River', 'State', 'BL', '137', null, 'Active');
INSERT INTO `state` VALUES ('2213', 'Flacq', 'State', 'FL', '137', null, 'Active');
INSERT INTO `state` VALUES ('2214', 'Grand Port', 'State', 'GP', '137', null, 'Active');
INSERT INTO `state` VALUES ('2215', 'Moka', 'State', 'MO', '137', null, 'Active');
INSERT INTO `state` VALUES ('2216', 'Pamplemousses', 'State', 'PA', '137', null, 'Active');
INSERT INTO `state` VALUES ('2217', 'Plaines Wilhems', 'State', 'PW', '137', null, 'Active');
INSERT INTO `state` VALUES ('2218', 'Riviere du Rempart', 'State', 'RP', '137', null, 'Active');
INSERT INTO `state` VALUES ('2219', 'Savanne', 'State', 'SA', '137', null, 'Active');
INSERT INTO `state` VALUES ('2220', 'Agalega Islands', 'State', 'AG', '137', null, 'Active');
INSERT INTO `state` VALUES ('2221', 'Cargados Carajos Shoals', 'State', 'CC', '137', null, 'Active');
INSERT INTO `state` VALUES ('2222', 'Rodrigues Island', 'State', 'RO', '137', null, 'Active');
INSERT INTO `state` VALUES ('2223', 'Male', 'State', 'MLE', '131', null, 'Active');
INSERT INTO `state` VALUES ('2224', 'Alif', 'State', '02', '131', null, 'Active');
INSERT INTO `state` VALUES ('2225', 'Baa', 'State', '20', '131', null, 'Active');
INSERT INTO `state` VALUES ('2226', 'Dhaalu', 'State', '17', '131', null, 'Active');
INSERT INTO `state` VALUES ('2227', 'Faafu', 'State', '14', '131', null, 'Active');
INSERT INTO `state` VALUES ('2228', 'Gaaf Alif', 'State', '27', '131', null, 'Active');
INSERT INTO `state` VALUES ('2229', 'Gaefu Dhaalu', 'State', '28', '131', null, 'Active');
INSERT INTO `state` VALUES ('2230', 'Gnaviyani', 'State', '29', '131', null, 'Active');
INSERT INTO `state` VALUES ('2231', 'Haa Alif', 'State', '07', '131', null, 'Active');
INSERT INTO `state` VALUES ('2232', 'Haa Dhaalu', 'State', '23', '131', null, 'Active');
INSERT INTO `state` VALUES ('2233', 'Kaafu', 'State', '26', '131', null, 'Active');
INSERT INTO `state` VALUES ('2234', 'Laamu', 'State', '05', '131', null, 'Active');
INSERT INTO `state` VALUES ('2235', 'Lhaviyani', 'State', '03', '131', null, 'Active');
INSERT INTO `state` VALUES ('2236', 'Meemu', 'State', '12', '131', null, 'Active');
INSERT INTO `state` VALUES ('2237', 'Noonu', 'State', '25', '131', null, 'Active');
INSERT INTO `state` VALUES ('2238', 'Raa', 'State', '13', '131', null, 'Active');
INSERT INTO `state` VALUES ('2239', 'Seenu', 'State', '01', '131', null, 'Active');
INSERT INTO `state` VALUES ('2240', 'Shaviyani', 'State', '24', '131', null, 'Active');
INSERT INTO `state` VALUES ('2241', 'Thaa', 'State', '08', '131', null, 'Active');
INSERT INTO `state` VALUES ('2242', 'Vaavu', 'State', '04', '131', null, 'Active');
INSERT INTO `state` VALUES ('2243', 'Balaka', 'State', 'BA', '129', null, 'Active');
INSERT INTO `state` VALUES ('2244', 'Blantyre', 'State', 'BL', '129', null, 'Active');
INSERT INTO `state` VALUES ('2245', 'Chikwawa', 'State', 'CK', '129', null, 'Active');
INSERT INTO `state` VALUES ('2246', 'Chiradzulu', 'State', 'CR', '129', null, 'Active');
INSERT INTO `state` VALUES ('2247', 'Chitipa', 'State', 'CT', '129', null, 'Active');
INSERT INTO `state` VALUES ('2248', 'Dedza', 'State', 'DE', '129', null, 'Active');
INSERT INTO `state` VALUES ('2249', 'Dowa', 'State', 'DO', '129', null, 'Active');
INSERT INTO `state` VALUES ('2250', 'Karonga', 'State', 'KR', '129', null, 'Active');
INSERT INTO `state` VALUES ('2251', 'Kasungu', 'State', 'KS', '129', null, 'Active');
INSERT INTO `state` VALUES ('2252', 'Likoma Island', 'State', 'LK', '129', null, 'Active');
INSERT INTO `state` VALUES ('2253', 'Lilongwe', 'State', 'LI', '129', null, 'Active');
INSERT INTO `state` VALUES ('2254', 'Machinga', 'State', 'MH', '129', null, 'Active');
INSERT INTO `state` VALUES ('2255', 'Mangochi', 'State', 'MG', '129', null, 'Active');
INSERT INTO `state` VALUES ('2256', 'Mchinji', 'State', 'MC', '129', null, 'Active');
INSERT INTO `state` VALUES ('2257', 'Mulanje', 'State', 'MU', '129', null, 'Active');
INSERT INTO `state` VALUES ('2258', 'Mwanza', 'State', 'MW', '129', null, 'Active');
INSERT INTO `state` VALUES ('2259', 'Mzimba', 'State', 'MZ', '129', null, 'Active');
INSERT INTO `state` VALUES ('2260', 'Nkhata Bay', 'State', 'NB', '129', null, 'Active');
INSERT INTO `state` VALUES ('2261', 'Nkhotakota', 'State', 'NK', '129', null, 'Active');
INSERT INTO `state` VALUES ('2262', 'Nsanje', 'State', 'NS', '129', null, 'Active');
INSERT INTO `state` VALUES ('2263', 'Ntcheu', 'State', 'NU', '129', null, 'Active');
INSERT INTO `state` VALUES ('2264', 'Ntchisi', 'State', 'NI', '129', null, 'Active');
INSERT INTO `state` VALUES ('2265', 'Phalomba', 'State', 'PH', '129', null, 'Active');
INSERT INTO `state` VALUES ('2266', 'Rumphi', 'State', 'RU', '129', null, 'Active');
INSERT INTO `state` VALUES ('2267', 'Salima', 'State', 'SA', '129', null, 'Active');
INSERT INTO `state` VALUES ('2268', 'Thyolo', 'State', 'TH', '129', null, 'Active');
INSERT INTO `state` VALUES ('2269', 'Zomba', 'State', 'ZO', '129', null, 'Active');
INSERT INTO `state` VALUES ('2270', 'Aguascalientes', 'State', 'AGU', '139', null, 'Active');
INSERT INTO `state` VALUES ('2271', 'Baja California', 'State', 'BCN', '139', null, 'Active');
INSERT INTO `state` VALUES ('2272', 'Baja California Sur', 'State', 'BCS', '139', null, 'Active');
INSERT INTO `state` VALUES ('2273', 'Campeche', 'State', 'CAM', '139', null, 'Active');
INSERT INTO `state` VALUES ('2274', 'Coahuila', 'State', 'COA', '139', null, 'Active');
INSERT INTO `state` VALUES ('2275', 'Colima', 'State', 'COL', '139', null, 'Active');
INSERT INTO `state` VALUES ('2276', 'Chiapas', 'State', 'CHP', '139', null, 'Active');
INSERT INTO `state` VALUES ('2277', 'Chihuahua', 'State', 'CHH', '139', null, 'Active');
INSERT INTO `state` VALUES ('2278', 'Durango', 'State', 'DUR', '139', null, 'Active');
INSERT INTO `state` VALUES ('2279', 'Guanajuato', 'State', 'GUA', '139', null, 'Active');
INSERT INTO `state` VALUES ('2280', 'Guerrero', 'State', 'GRO', '139', null, 'Active');
INSERT INTO `state` VALUES ('2281', 'Hidalgo', 'State', 'HID', '139', null, 'Active');
INSERT INTO `state` VALUES ('2282', 'Jalisco', 'State', 'JAL', '139', null, 'Active');
INSERT INTO `state` VALUES ('2283', 'Mexico', 'State', 'MEX', '139', null, 'Active');
INSERT INTO `state` VALUES ('2284', 'Michoacin', 'State', 'MIC', '139', null, 'Active');
INSERT INTO `state` VALUES ('2285', 'Morelos', 'State', 'MOR', '139', null, 'Active');
INSERT INTO `state` VALUES ('2286', 'Nayarit', 'State', 'NAY', '139', null, 'Active');
INSERT INTO `state` VALUES ('2287', 'Nuevo Leon', 'State', 'NLE', '139', null, 'Active');
INSERT INTO `state` VALUES ('2288', 'Oaxaca', 'State', 'OAX', '139', null, 'Active');
INSERT INTO `state` VALUES ('2289', 'Puebla', 'State', 'PUE', '139', null, 'Active');
INSERT INTO `state` VALUES ('2290', 'Queretaro', 'State', 'QUE', '139', null, 'Active');
INSERT INTO `state` VALUES ('2291', 'Quintana Roo', 'State', 'ROO', '139', null, 'Active');
INSERT INTO `state` VALUES ('2292', 'San Luis Potosi', 'State', 'SLP', '139', null, 'Active');
INSERT INTO `state` VALUES ('2293', 'Sinaloa', 'State', 'SIN', '139', null, 'Active');
INSERT INTO `state` VALUES ('2294', 'Sonora', 'State', 'SON', '139', null, 'Active');
INSERT INTO `state` VALUES ('2295', 'Tabasco', 'State', 'TAB', '139', null, 'Active');
INSERT INTO `state` VALUES ('2296', 'Tamaulipas', 'State', 'TAM', '139', null, 'Active');
INSERT INTO `state` VALUES ('2297', 'Tlaxcala', 'State', 'TLA', '139', null, 'Active');
INSERT INTO `state` VALUES ('2298', 'Veracruz', 'State', 'VER', '139', null, 'Active');
INSERT INTO `state` VALUES ('2299', 'Yucatan', 'State', 'YUC', '139', null, 'Active');
INSERT INTO `state` VALUES ('2300', 'Zacatecas', 'State', 'ZAC', '139', null, 'Active');
INSERT INTO `state` VALUES ('2301', 'Wilayah Persekutuan Kuala Lumpur', 'State', '14', '130', null, 'Active');
INSERT INTO `state` VALUES ('2302', 'Wilayah Persekutuan Labuan', 'State', '15', '130', null, 'Active');
INSERT INTO `state` VALUES ('2303', 'Wilayah Persekutuan Putrajaya', 'State', '16', '130', null, 'Active');
INSERT INTO `state` VALUES ('2304', 'Johor', 'State', '01', '130', null, 'Active');
INSERT INTO `state` VALUES ('2305', 'Kedah', 'State', '02', '130', null, 'Active');
INSERT INTO `state` VALUES ('2306', 'Kelantan', 'State', '03', '130', null, 'Active');
INSERT INTO `state` VALUES ('2307', 'Melaka', 'State', '04', '130', null, 'Active');
INSERT INTO `state` VALUES ('2308', 'Negeri Sembilan', 'State', '05', '130', null, 'Active');
INSERT INTO `state` VALUES ('2309', 'Pahang', 'State', '06', '130', null, 'Active');
INSERT INTO `state` VALUES ('2310', 'Perak', 'State', '08', '130', null, 'Active');
INSERT INTO `state` VALUES ('2311', 'Perlis', 'State', '09', '130', null, 'Active');
INSERT INTO `state` VALUES ('2312', 'Pulau Pinang', 'State', '07', '130', null, 'Active');
INSERT INTO `state` VALUES ('2313', 'Sabah', 'State', '12', '130', null, 'Active');
INSERT INTO `state` VALUES ('2314', 'Sarawak', 'State', '13', '130', null, 'Active');
INSERT INTO `state` VALUES ('2315', 'Selangor', 'State', '10', '130', null, 'Active');
INSERT INTO `state` VALUES ('2316', 'Terengganu', 'State', '11', '130', null, 'Active');
INSERT INTO `state` VALUES ('2317', 'Maputo', 'State', 'MPM', '146', null, 'Active');
INSERT INTO `state` VALUES ('2318', 'Cabo Delgado', 'State', 'P', '146', null, 'Active');
INSERT INTO `state` VALUES ('2319', 'Gaza', 'State', 'G', '146', null, 'Active');
INSERT INTO `state` VALUES ('2320', 'Inhambane', 'State', 'I', '146', null, 'Active');
INSERT INTO `state` VALUES ('2321', 'Manica', 'State', 'B', '146', null, 'Active');
INSERT INTO `state` VALUES ('2322', 'Numpula', 'State', 'N', '146', null, 'Active');
INSERT INTO `state` VALUES ('2323', 'Niaaea', 'State', 'A', '146', null, 'Active');
INSERT INTO `state` VALUES ('2324', 'Sofala', 'State', 'S', '146', null, 'Active');
INSERT INTO `state` VALUES ('2325', 'Tete', 'State', 'T', '146', null, 'Active');
INSERT INTO `state` VALUES ('2326', 'Zambezia', 'State', 'Q', '146', null, 'Active');
INSERT INTO `state` VALUES ('2327', 'Caprivi', 'State', 'CA', '147', null, 'Active');
INSERT INTO `state` VALUES ('2328', 'Erongo', 'State', 'ER', '147', null, 'Active');
INSERT INTO `state` VALUES ('2329', 'Hardap', 'State', 'HA', '147', null, 'Active');
INSERT INTO `state` VALUES ('2330', 'Karas', 'State', 'KA', '147', null, 'Active');
INSERT INTO `state` VALUES ('2331', 'Khomae', 'State', 'KH', '147', null, 'Active');
INSERT INTO `state` VALUES ('2332', 'Kunene', 'State', 'KU', '147', null, 'Active');
INSERT INTO `state` VALUES ('2333', 'Ohangwena', 'State', 'OW', '147', null, 'Active');
INSERT INTO `state` VALUES ('2334', 'Okavango', 'State', 'OK', '147', null, 'Active');
INSERT INTO `state` VALUES ('2335', 'Omaheke', 'State', 'OH', '147', null, 'Active');
INSERT INTO `state` VALUES ('2336', 'Omusati', 'State', 'OS', '147', null, 'Active');
INSERT INTO `state` VALUES ('2337', 'Oshana', 'State', 'ON', '147', null, 'Active');
INSERT INTO `state` VALUES ('2338', 'Oshikoto', 'State', 'OT', '147', null, 'Active');
INSERT INTO `state` VALUES ('2339', 'Otjozondjupa', 'State', 'OD', '147', null, 'Active');
INSERT INTO `state` VALUES ('2340', 'Niamey', 'State', '8', '155', null, 'Active');
INSERT INTO `state` VALUES ('2341', 'Agadez', 'State', '1', '155', null, 'Active');
INSERT INTO `state` VALUES ('2342', 'Diffa', 'State', '2', '155', null, 'Active');
INSERT INTO `state` VALUES ('2343', 'Dosso', 'State', '3', '155', null, 'Active');
INSERT INTO `state` VALUES ('2344', 'Maradi', 'State', '4', '155', null, 'Active');
INSERT INTO `state` VALUES ('2345', 'Tahoua', 'State', 'S', '155', null, 'Active');
INSERT INTO `state` VALUES ('2346', 'Tillaberi', 'State', '6', '155', null, 'Active');
INSERT INTO `state` VALUES ('2347', 'Zinder', 'State', '7', '155', null, 'Active');
INSERT INTO `state` VALUES ('2348', 'Abuja Capital Territory', 'State', 'FC', '156', null, 'Active');
INSERT INTO `state` VALUES ('2349', 'Abia', 'State', 'AB', '156', null, 'Active');
INSERT INTO `state` VALUES ('2350', 'Adamawa', 'State', 'AD', '156', null, 'Active');
INSERT INTO `state` VALUES ('2351', 'Akwa Ibom', 'State', 'AK', '156', null, 'Active');
INSERT INTO `state` VALUES ('2352', 'Anambra', 'State', 'AN', '156', null, 'Active');
INSERT INTO `state` VALUES ('2353', 'Bauchi', 'State', 'BA', '156', null, 'Active');
INSERT INTO `state` VALUES ('2354', 'Bayelsa', 'State', 'BY', '156', null, 'Active');
INSERT INTO `state` VALUES ('2355', 'Benue', 'State', 'BE', '156', null, 'Active');
INSERT INTO `state` VALUES ('2356', 'Borno', 'State', 'BO', '156', null, 'Active');
INSERT INTO `state` VALUES ('2357', 'Cross River', 'State', 'CR', '156', null, 'Active');
INSERT INTO `state` VALUES ('2358', 'Delta', 'State', 'DE', '156', null, 'Active');
INSERT INTO `state` VALUES ('2359', 'Ebonyi', 'State', 'EB', '156', null, 'Active');
INSERT INTO `state` VALUES ('2360', 'Edo', 'State', 'ED', '156', null, 'Active');
INSERT INTO `state` VALUES ('2361', 'Ekiti', 'State', 'EK', '156', null, 'Active');
INSERT INTO `state` VALUES ('2362', 'Enugu', 'State', 'EN', '156', null, 'Active');
INSERT INTO `state` VALUES ('2363', 'Gombe', 'State', 'GO', '156', null, 'Active');
INSERT INTO `state` VALUES ('2364', 'Imo', 'State', 'IM', '156', null, 'Active');
INSERT INTO `state` VALUES ('2365', 'Jigawa', 'State', 'JI', '156', null, 'Active');
INSERT INTO `state` VALUES ('2366', 'Kaduna', 'State', 'KD', '156', null, 'Active');
INSERT INTO `state` VALUES ('2367', 'Kano', 'State', 'KN', '156', null, 'Active');
INSERT INTO `state` VALUES ('2368', 'Katsina', 'State', 'KT', '156', null, 'Active');
INSERT INTO `state` VALUES ('2369', 'Kebbi', 'State', 'KE', '156', null, 'Active');
INSERT INTO `state` VALUES ('2370', 'Kogi', 'State', 'KO', '156', null, 'Active');
INSERT INTO `state` VALUES ('2371', 'Kwara', 'State', 'KW', '156', null, 'Active');
INSERT INTO `state` VALUES ('2372', 'Lagos', 'State', 'LA', '156', null, 'Active');
INSERT INTO `state` VALUES ('2373', 'Nassarawa', 'State', 'NA', '156', null, 'Active');
INSERT INTO `state` VALUES ('2374', 'Niger', 'State', 'NI', '156', null, 'Active');
INSERT INTO `state` VALUES ('2375', 'Ogun', 'State', 'OG', '156', null, 'Active');
INSERT INTO `state` VALUES ('2376', 'Ondo', 'State', 'ON', '156', null, 'Active');
INSERT INTO `state` VALUES ('2377', 'Osun', 'State', 'OS', '156', null, 'Active');
INSERT INTO `state` VALUES ('2378', 'Oyo', 'State', 'OY', '156', null, 'Active');
INSERT INTO `state` VALUES ('2379', 'Rivers', 'State', 'RI', '156', null, 'Active');
INSERT INTO `state` VALUES ('2380', 'Sokoto', 'State', 'SO', '156', null, 'Active');
INSERT INTO `state` VALUES ('2381', 'Taraba', 'State', 'TA', '156', null, 'Active');
INSERT INTO `state` VALUES ('2382', 'Yobe', 'State', 'YO', '156', null, 'Active');
INSERT INTO `state` VALUES ('2383', 'Zamfara', 'State', 'ZA', '156', null, 'Active');
INSERT INTO `state` VALUES ('2384', 'Boaco', 'State', 'BO', '154', null, 'Active');
INSERT INTO `state` VALUES ('2385', 'Carazo', 'State', 'CA', '154', null, 'Active');
INSERT INTO `state` VALUES ('2386', 'Chinandega', 'State', 'CI', '154', null, 'Active');
INSERT INTO `state` VALUES ('2387', 'Chontales', 'State', 'CO', '154', null, 'Active');
INSERT INTO `state` VALUES ('2388', 'Esteli', 'State', 'ES', '154', null, 'Active');
INSERT INTO `state` VALUES ('2389', 'Jinotega', 'State', 'JI', '154', null, 'Active');
INSERT INTO `state` VALUES ('2390', 'Leon', 'State', 'LE', '154', null, 'Active');
INSERT INTO `state` VALUES ('2391', 'Madriz', 'State', 'MD', '154', null, 'Active');
INSERT INTO `state` VALUES ('2392', 'Managua', 'State', 'MN', '154', null, 'Active');
INSERT INTO `state` VALUES ('2393', 'Masaya', 'State', 'MS', '154', null, 'Active');
INSERT INTO `state` VALUES ('2394', 'Matagalpa', 'State', 'MT', '154', null, 'Active');
INSERT INTO `state` VALUES ('2395', 'Nueva Segovia', 'State', 'NS', '154', null, 'Active');
INSERT INTO `state` VALUES ('2396', 'Rio San Juan', 'State', 'SJ', '154', null, 'Active');
INSERT INTO `state` VALUES ('2397', 'Rivas', 'State', 'RI', '154', null, 'Active');
INSERT INTO `state` VALUES ('2398', 'Atlantico Norte', 'State', 'AN', '154', null, 'Active');
INSERT INTO `state` VALUES ('2399', 'Atlantico Sur', 'State', 'AS', '154', null, 'Active');
INSERT INTO `state` VALUES ('2400', 'Drente', 'State', 'DR', '151', null, 'Active');
INSERT INTO `state` VALUES ('2401', 'Flevoland', 'State', 'FL', '151', null, 'Active');
INSERT INTO `state` VALUES ('2402', 'Friesland', 'State', 'FR', '151', null, 'Active');
INSERT INTO `state` VALUES ('2403', 'Gelderland', 'State', 'GL', '151', null, 'Active');
INSERT INTO `state` VALUES ('2404', 'Groningen', 'State', 'GR', '151', null, 'Active');
INSERT INTO `state` VALUES ('2405', 'Noord-Brabant', 'State', 'NB', '151', null, 'Active');
INSERT INTO `state` VALUES ('2406', 'Noord-Holland', 'State', 'NH', '151', null, 'Active');
INSERT INTO `state` VALUES ('2407', 'Overijssel', 'State', 'OV', '151', null, 'Active');
INSERT INTO `state` VALUES ('2408', 'Utrecht', 'State', 'UT', '151', null, 'Active');
INSERT INTO `state` VALUES ('2409', 'Zuid-Holland', 'State', 'ZH', '151', null, 'Active');
INSERT INTO `state` VALUES ('2410', 'Zeeland', 'State', 'ZL', '151', null, 'Active');
INSERT INTO `state` VALUES ('2411', 'Akershus', 'State', '02', '160', null, 'Active');
INSERT INTO `state` VALUES ('2412', 'Aust-Agder', 'State', '09', '160', null, 'Active');
INSERT INTO `state` VALUES ('2413', 'Buskerud', 'State', '06', '160', null, 'Active');
INSERT INTO `state` VALUES ('2414', 'Finumark', 'State', '20', '160', null, 'Active');
INSERT INTO `state` VALUES ('2415', 'Hedmark', 'State', '04', '160', null, 'Active');
INSERT INTO `state` VALUES ('2416', 'Hordaland', 'State', '12', '160', null, 'Active');
INSERT INTO `state` VALUES ('2417', 'Mire og Romsdal', 'State', '15', '160', null, 'Active');
INSERT INTO `state` VALUES ('2418', 'Nordland', 'State', '18', '160', null, 'Active');
INSERT INTO `state` VALUES ('2419', 'Nord-Trindelag', 'State', '17', '160', null, 'Active');
INSERT INTO `state` VALUES ('2420', 'Oppland', 'State', '05', '160', null, 'Active');
INSERT INTO `state` VALUES ('2421', 'Oslo', 'State', '03', '160', null, 'Active');
INSERT INTO `state` VALUES ('2422', 'Rogaland', 'State', '11', '160', null, 'Active');
INSERT INTO `state` VALUES ('2423', 'Sogn og Fjordane', 'State', '14', '160', null, 'Active');
INSERT INTO `state` VALUES ('2424', 'Sir-Trindelag', 'State', '16', '160', null, 'Active');
INSERT INTO `state` VALUES ('2425', 'Telemark', 'State', '06', '160', null, 'Active');
INSERT INTO `state` VALUES ('2426', 'Troms', 'State', '19', '160', null, 'Active');
INSERT INTO `state` VALUES ('2427', 'Vest-Agder', 'State', '10', '160', null, 'Active');
INSERT INTO `state` VALUES ('2428', 'Vestfold', 'State', '07', '160', null, 'Active');
INSERT INTO `state` VALUES ('2429', 'Ostfold', 'State', '01', '160', null, 'Active');
INSERT INTO `state` VALUES ('2430', 'Jan Mayen', 'State', '22', '160', null, 'Active');
INSERT INTO `state` VALUES ('2431', 'Svalbard', 'State', '21', '160', null, 'Active');
INSERT INTO `state` VALUES ('2432', 'Auckland', 'State', 'AUK', '153', null, 'Active');
INSERT INTO `state` VALUES ('2433', 'Bay of Plenty', 'State', 'BOP', '153', null, 'Active');
INSERT INTO `state` VALUES ('2434', 'Canterbury', 'State', 'CAN', '153', null, 'Active');
INSERT INTO `state` VALUES ('2435', 'Gisborne', 'State', 'GIS', '153', null, 'Active');
INSERT INTO `state` VALUES ('2436', 'Hawkes Bay', 'State', 'HKB', '153', null, 'Active');
INSERT INTO `state` VALUES ('2437', 'Manawatu-Wanganui', 'State', 'MWT', '153', null, 'Active');
INSERT INTO `state` VALUES ('2438', 'Marlborough', 'State', 'MBH', '153', null, 'Active');
INSERT INTO `state` VALUES ('2439', 'Nelson', 'State', 'NSN', '153', null, 'Active');
INSERT INTO `state` VALUES ('2440', 'Northland', 'State', 'NTL', '153', null, 'Active');
INSERT INTO `state` VALUES ('2441', 'Otago', 'State', 'OTA', '153', null, 'Active');
INSERT INTO `state` VALUES ('2442', 'Southland', 'State', 'STL', '153', null, 'Active');
INSERT INTO `state` VALUES ('2443', 'Taranaki', 'State', 'TKI', '153', null, 'Active');
INSERT INTO `state` VALUES ('2444', 'Tasman', 'State', 'TAS', '153', null, 'Active');
INSERT INTO `state` VALUES ('2445', 'waikato', 'State', 'WKO', '153', null, 'Active');
INSERT INTO `state` VALUES ('2446', 'Wellington', 'State', 'WGN', '153', null, 'Active');
INSERT INTO `state` VALUES ('2447', 'West Coast', 'State', 'WTC', '153', null, 'Active');
INSERT INTO `state` VALUES ('2448', 'Ad Dakhillyah', 'State', 'DA', '161', null, 'Active');
INSERT INTO `state` VALUES ('2449', 'Al Batinah', 'State', 'BA', '161', null, 'Active');
INSERT INTO `state` VALUES ('2450', 'Al Janblyah', 'State', 'JA', '161', null, 'Active');
INSERT INTO `state` VALUES ('2451', 'Al Wusta', 'State', 'WU', '161', null, 'Active');
INSERT INTO `state` VALUES ('2452', 'Ash Sharqlyah', 'State', 'SH', '161', null, 'Active');
INSERT INTO `state` VALUES ('2453', 'Az Zahirah', 'State', 'ZA', '161', null, 'Active');
INSERT INTO `state` VALUES ('2454', 'Masqat', 'State', 'MA', '161', null, 'Active');
INSERT INTO `state` VALUES ('2455', 'Musandam', 'State', 'MU', '161', null, 'Active');
INSERT INTO `state` VALUES ('2456', 'Bocas del Toro', 'State', '1', '165', null, 'Active');
INSERT INTO `state` VALUES ('2457', 'Cocle', 'State', '2', '165', null, 'Active');
INSERT INTO `state` VALUES ('2458', 'Chiriqui', 'State', '4', '165', null, 'Active');
INSERT INTO `state` VALUES ('2459', 'Darien', 'State', '5', '165', null, 'Active');
INSERT INTO `state` VALUES ('2460', 'Herrera', 'State', '6', '165', null, 'Active');
INSERT INTO `state` VALUES ('2461', 'Loa Santoa', 'State', '7', '165', null, 'Active');
INSERT INTO `state` VALUES ('2462', 'Panama', 'State', '8', '165', null, 'Active');
INSERT INTO `state` VALUES ('2463', 'Veraguas', 'State', '9', '165', null, 'Active');
INSERT INTO `state` VALUES ('2464', 'Comarca de San Blas', 'State', 'Q', '165', null, 'Active');
INSERT INTO `state` VALUES ('2465', 'El Callao', 'State', 'CAL', '168', null, 'Active');
INSERT INTO `state` VALUES ('2466', 'Ancash', 'State', 'ANC', '168', null, 'Active');
INSERT INTO `state` VALUES ('2467', 'Apurimac', 'State', 'APU', '168', null, 'Active');
INSERT INTO `state` VALUES ('2468', 'Arequipa', 'State', 'ARE', '168', null, 'Active');
INSERT INTO `state` VALUES ('2469', 'Ayacucho', 'State', 'AYA', '168', null, 'Active');
INSERT INTO `state` VALUES ('2470', 'Cajamarca', 'State', 'CAJ', '168', null, 'Active');
INSERT INTO `state` VALUES ('2471', 'Cuzco', 'State', 'CUS', '168', null, 'Active');
INSERT INTO `state` VALUES ('2472', 'Huancavelica', 'State', 'HUV', '168', null, 'Active');
INSERT INTO `state` VALUES ('2473', 'Huanuco', 'State', 'HUC', '168', null, 'Active');
INSERT INTO `state` VALUES ('2474', 'Ica', 'State', 'ICA', '168', null, 'Active');
INSERT INTO `state` VALUES ('2475', 'Junin', 'State', 'JUN', '168', null, 'Active');
INSERT INTO `state` VALUES ('2476', 'La Libertad', 'State', 'LAL', '168', null, 'Active');
INSERT INTO `state` VALUES ('2477', 'Lambayeque', 'State', 'LAM', '168', null, 'Active');
INSERT INTO `state` VALUES ('2478', 'Lima', 'State', 'LIM', '168', null, 'Active');
INSERT INTO `state` VALUES ('2479', 'Loreto', 'State', 'LOR', '168', null, 'Active');
INSERT INTO `state` VALUES ('2480', 'Madre de Dios', 'State', 'MDD', '168', null, 'Active');
INSERT INTO `state` VALUES ('2481', 'Moquegua', 'State', 'MOQ', '168', null, 'Active');
INSERT INTO `state` VALUES ('2482', 'Pasco', 'State', 'PAS', '168', null, 'Active');
INSERT INTO `state` VALUES ('2483', 'Piura', 'State', 'PIU', '168', null, 'Active');
INSERT INTO `state` VALUES ('2484', 'Puno', 'State', 'PUN', '168', null, 'Active');
INSERT INTO `state` VALUES ('2485', 'San Martin', 'State', 'SAM', '168', null, 'Active');
INSERT INTO `state` VALUES ('2486', 'Tacna', 'State', 'TAC', '168', null, 'Active');
INSERT INTO `state` VALUES ('2487', 'Tumbes', 'State', 'TUM', '168', null, 'Active');
INSERT INTO `state` VALUES ('2488', 'Ucayali', 'State', 'UCA', '168', null, 'Active');
INSERT INTO `state` VALUES ('2489', 'National Capital District (Port Moresby)', 'State', 'NCD', '166', null, 'Active');
INSERT INTO `state` VALUES ('2490', 'Chimbu', 'State', 'CPK', '166', null, 'Active');
INSERT INTO `state` VALUES ('2491', 'Eastern Highlands', 'State', 'EHG', '166', null, 'Active');
INSERT INTO `state` VALUES ('2492', 'East New Britain', 'State', 'EBR', '166', null, 'Active');
INSERT INTO `state` VALUES ('2493', 'East Sepik', 'State', 'ESW', '166', null, 'Active');
INSERT INTO `state` VALUES ('2494', 'Enga', 'State', 'EPW', '166', null, 'Active');
INSERT INTO `state` VALUES ('2495', 'Gulf', 'State', 'GPK', '166', null, 'Active');
INSERT INTO `state` VALUES ('2496', 'Madang', 'State', 'MPM', '166', null, 'Active');
INSERT INTO `state` VALUES ('2497', 'Manus', 'State', 'MRL', '166', null, 'Active');
INSERT INTO `state` VALUES ('2498', 'Milne Bay', 'State', 'MBA', '166', null, 'Active');
INSERT INTO `state` VALUES ('2499', 'Morobe', 'State', 'MPL', '166', null, 'Active');
INSERT INTO `state` VALUES ('2500', 'New Ireland', 'State', 'NIK', '166', null, 'Active');
INSERT INTO `state` VALUES ('2501', 'North Solomons', 'State', 'NSA', '166', null, 'Active');
INSERT INTO `state` VALUES ('2502', 'Santaun', 'State', 'SAN', '166', null, 'Active');
INSERT INTO `state` VALUES ('2503', 'Southern Highlands', 'State', 'SHM', '166', null, 'Active');
INSERT INTO `state` VALUES ('2504', 'Western Highlands', 'State', 'WHM', '166', null, 'Active');
INSERT INTO `state` VALUES ('2505', 'West New Britain', 'State', 'WBK', '166', null, 'Active');
INSERT INTO `state` VALUES ('2506', 'Abra', 'State', 'ABR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2507', 'Agusan del Norte', 'State', 'AGN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2508', 'Agusan del Sur', 'State', 'AGS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2509', 'Aklan', 'State', 'AKL', '169', null, 'Active');
INSERT INTO `state` VALUES ('2510', 'Albay', 'State', 'ALB', '169', null, 'Active');
INSERT INTO `state` VALUES ('2511', 'Antique', 'State', 'ANT', '169', null, 'Active');
INSERT INTO `state` VALUES ('2512', 'Apayao', 'State', 'APA', '169', null, 'Active');
INSERT INTO `state` VALUES ('2513', 'Aurora', 'State', 'AUR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2514', 'Basilan', 'State', 'BAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2515', 'Batasn', 'State', 'BAN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2516', 'Batanes', 'State', 'BTN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2517', 'Batangas', 'State', 'BTG', '169', null, 'Active');
INSERT INTO `state` VALUES ('2518', 'Benguet', 'State', 'BEN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2519', 'Biliran', 'State', 'BIL', '169', null, 'Active');
INSERT INTO `state` VALUES ('2520', 'Bohol', 'State', 'BOH', '169', null, 'Active');
INSERT INTO `state` VALUES ('2521', 'Bukidnon', 'State', 'BUK', '169', null, 'Active');
INSERT INTO `state` VALUES ('2522', 'Bulacan', 'State', 'BUL', '169', null, 'Active');
INSERT INTO `state` VALUES ('2523', 'Cagayan', 'State', 'CAG', '169', null, 'Active');
INSERT INTO `state` VALUES ('2524', 'Camarines Norte', 'State', 'CAN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2525', 'Camarines Sur', 'State', 'CAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2526', 'Camiguin', 'State', 'CAM', '169', null, 'Active');
INSERT INTO `state` VALUES ('2527', 'Capiz', 'State', 'CAP', '169', null, 'Active');
INSERT INTO `state` VALUES ('2528', 'Catanduanes', 'State', 'CAT', '169', null, 'Active');
INSERT INTO `state` VALUES ('2529', 'Cavite', 'State', 'CAV', '169', null, 'Active');
INSERT INTO `state` VALUES ('2530', 'Cebu', 'State', 'CEB', '169', null, 'Active');
INSERT INTO `state` VALUES ('2531', 'Compostela Valley', 'State', 'COM', '169', null, 'Active');
INSERT INTO `state` VALUES ('2532', 'Davao', 'State', 'DAV', '169', null, 'Active');
INSERT INTO `state` VALUES ('2533', 'Davao del Sur', 'State', 'DAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2534', 'Davao Oriental', 'State', 'DAO', '169', null, 'Active');
INSERT INTO `state` VALUES ('2535', 'Eastern Samar', 'State', 'EAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2536', 'Guimaras', 'State', 'GUI', '169', null, 'Active');
INSERT INTO `state` VALUES ('2537', 'Ifugao', 'State', 'IFU', '169', null, 'Active');
INSERT INTO `state` VALUES ('2538', 'Ilocos Norte', 'State', 'ILN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2539', 'Ilocos Sur', 'State', 'ILS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2540', 'Iloilo', 'State', 'ILI', '169', null, 'Active');
INSERT INTO `state` VALUES ('2541', 'Isabela', 'State', 'ISA', '169', null, 'Active');
INSERT INTO `state` VALUES ('2542', 'Kalinga-Apayso', 'State', 'KAL', '169', null, 'Active');
INSERT INTO `state` VALUES ('2543', 'Laguna', 'State', 'LAG', '169', null, 'Active');
INSERT INTO `state` VALUES ('2544', 'Lanao del Norte', 'State', 'LAN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2545', 'Lanao del Sur', 'State', 'LAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2546', 'La Union', 'State', 'LUN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2547', 'Leyte', 'State', 'LEY', '169', null, 'Active');
INSERT INTO `state` VALUES ('2548', 'Maguindanao', 'State', 'MAG', '169', null, 'Active');
INSERT INTO `state` VALUES ('2549', 'Marinduque', 'State', 'MAD', '169', null, 'Active');
INSERT INTO `state` VALUES ('2550', 'Masbate', 'State', 'MAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2551', 'Mindoro Occidental', 'State', 'MDC', '169', null, 'Active');
INSERT INTO `state` VALUES ('2552', 'Mindoro Oriental', 'State', 'MDR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2553', 'Misamis Occidental', 'State', 'MSC', '169', null, 'Active');
INSERT INTO `state` VALUES ('2554', 'Misamis Oriental', 'State', 'MSR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2555', 'Mountain Province', 'State', 'MOU', '169', null, 'Active');
INSERT INTO `state` VALUES ('2556', 'Negroe Occidental', 'State', 'NEC', '169', null, 'Active');
INSERT INTO `state` VALUES ('2557', 'Negros Oriental', 'State', 'NER', '169', null, 'Active');
INSERT INTO `state` VALUES ('2558', 'North Cotabato', 'State', 'NCO', '169', null, 'Active');
INSERT INTO `state` VALUES ('2559', 'Northern Samar', 'State', 'NSA', '169', null, 'Active');
INSERT INTO `state` VALUES ('2560', 'Nueva Ecija', 'State', 'NUE', '169', null, 'Active');
INSERT INTO `state` VALUES ('2561', 'Nueva Vizcaya', 'State', 'NUV', '169', null, 'Active');
INSERT INTO `state` VALUES ('2562', 'Palawan', 'State', 'PLW', '169', null, 'Active');
INSERT INTO `state` VALUES ('2563', 'Pampanga', 'State', 'PAM', '169', null, 'Active');
INSERT INTO `state` VALUES ('2564', 'Pangasinan', 'State', 'PAN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2565', 'Quezon', 'State', 'QUE', '169', null, 'Active');
INSERT INTO `state` VALUES ('2566', 'Quirino', 'State', 'QUI', '169', null, 'Active');
INSERT INTO `state` VALUES ('2567', 'Rizal', 'State', 'RIZ', '169', null, 'Active');
INSERT INTO `state` VALUES ('2568', 'Romblon', 'State', 'ROM', '169', null, 'Active');
INSERT INTO `state` VALUES ('2569', 'Sarangani', 'State', 'SAR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2570', 'Siquijor', 'State', 'SIG', '169', null, 'Active');
INSERT INTO `state` VALUES ('2571', 'Sorsogon', 'State', 'SOR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2572', 'South Cotabato', 'State', 'SCO', '169', null, 'Active');
INSERT INTO `state` VALUES ('2573', 'Southern Leyte', 'State', 'SLE', '169', null, 'Active');
INSERT INTO `state` VALUES ('2574', 'Sultan Kudarat', 'State', 'SUK', '169', null, 'Active');
INSERT INTO `state` VALUES ('2575', 'Sulu', 'State', 'SLU', '169', null, 'Active');
INSERT INTO `state` VALUES ('2576', 'Surigao del Norte', 'State', 'SUN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2577', 'Surigao del Sur', 'State', 'SUR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2578', 'Tarlac', 'State', 'TAR', '169', null, 'Active');
INSERT INTO `state` VALUES ('2579', 'Tawi-Tawi', 'State', 'TAW', '169', null, 'Active');
INSERT INTO `state` VALUES ('2580', 'Western Samar', 'State', 'WSA', '169', null, 'Active');
INSERT INTO `state` VALUES ('2581', 'Zambales', 'State', 'ZMB', '169', null, 'Active');
INSERT INTO `state` VALUES ('2582', 'Zamboanga del Norte', 'State', 'ZAN', '169', null, 'Active');
INSERT INTO `state` VALUES ('2583', 'Zamboanga del Sur', 'State', 'ZAS', '169', null, 'Active');
INSERT INTO `state` VALUES ('2584', 'Zamboanga Sibiguey', 'State', 'ZSI', '169', null, 'Active');
INSERT INTO `state` VALUES ('2585', 'Islamabad', 'State', 'IS', '162', null, 'Active');
INSERT INTO `state` VALUES ('2586', 'Baluchistan (en)', 'State', 'BA', '162', null, 'Active');
INSERT INTO `state` VALUES ('2587', 'North-West Frontier', 'State', 'NW', '162', null, 'Active');
INSERT INTO `state` VALUES ('2588', 'Sind (en)', 'State', 'SD', '162', null, 'Active');
INSERT INTO `state` VALUES ('2589', 'Federally Administered Tribal Aresa', 'State', 'TA', '162', null, 'Active');
INSERT INTO `state` VALUES ('2590', 'Azad Rashmir', 'State', 'JK', '162', null, 'Active');
INSERT INTO `state` VALUES ('2591', 'Northern Areas', 'State', 'NA', '162', null, 'Active');
INSERT INTO `state` VALUES ('2592', 'Aveiro', 'State', '01', '172', null, 'Active');
INSERT INTO `state` VALUES ('2593', 'Beja', 'State', '02', '172', null, 'Active');
INSERT INTO `state` VALUES ('2594', 'Braga', 'State', '03', '172', null, 'Active');
INSERT INTO `state` VALUES ('2595', 'Braganca', 'State', '04', '172', null, 'Active');
INSERT INTO `state` VALUES ('2596', 'Castelo Branco', 'State', '05', '172', null, 'Active');
INSERT INTO `state` VALUES ('2597', 'Colmbra', 'State', '06', '172', null, 'Active');
INSERT INTO `state` VALUES ('2598', 'Ovora', 'State', '07', '172', null, 'Active');
INSERT INTO `state` VALUES ('2599', 'Faro', 'State', '08', '172', null, 'Active');
INSERT INTO `state` VALUES ('2600', 'Guarda', 'State', '09', '172', null, 'Active');
INSERT INTO `state` VALUES ('2601', 'Leiria', 'State', '10', '172', null, 'Active');
INSERT INTO `state` VALUES ('2602', 'Lisboa', 'State', '11', '172', null, 'Active');
INSERT INTO `state` VALUES ('2603', 'Portalegre', 'State', '12', '172', null, 'Active');
INSERT INTO `state` VALUES ('2604', 'Porto', 'State', '13', '172', null, 'Active');
INSERT INTO `state` VALUES ('2605', 'Santarem', 'State', '14', '172', null, 'Active');
INSERT INTO `state` VALUES ('2606', 'Setubal', 'State', '15', '172', null, 'Active');
INSERT INTO `state` VALUES ('2607', 'Viana do Castelo', 'State', '16', '172', null, 'Active');
INSERT INTO `state` VALUES ('2608', 'Vila Real', 'State', '17', '172', null, 'Active');
INSERT INTO `state` VALUES ('2609', 'Viseu', 'State', '18', '172', null, 'Active');
INSERT INTO `state` VALUES ('2610', 'Regiao Autonoma dos Acores', 'State', '20', '172', null, 'Active');
INSERT INTO `state` VALUES ('2611', 'Regiao Autonoma da Madeira', 'State', '30', '172', null, 'Active');
INSERT INTO `state` VALUES ('2612', 'Asuncion', 'State', 'ASU', '167', null, 'Active');
INSERT INTO `state` VALUES ('2613', 'Alto Paraguay', 'State', '16', '167', null, 'Active');
INSERT INTO `state` VALUES ('2614', 'Alto Parana', 'State', '10', '167', null, 'Active');
INSERT INTO `state` VALUES ('2615', 'Amambay', 'State', '13', '167', null, 'Active');
INSERT INTO `state` VALUES ('2616', 'Boqueron', 'State', '19', '167', null, 'Active');
INSERT INTO `state` VALUES ('2617', 'Caeguazu', 'State', '5', '167', null, 'Active');
INSERT INTO `state` VALUES ('2618', 'Caazapl', 'State', '6', '167', null, 'Active');
INSERT INTO `state` VALUES ('2619', 'Canindeyu', 'State', '14', '167', null, 'Active');
INSERT INTO `state` VALUES ('2620', 'Concepcion', 'State', '1', '167', null, 'Active');
INSERT INTO `state` VALUES ('2621', 'Cordillera', 'State', '3', '167', null, 'Active');
INSERT INTO `state` VALUES ('2622', 'Guaira', 'State', '4', '167', null, 'Active');
INSERT INTO `state` VALUES ('2623', 'Itapua', 'State', '7', '167', null, 'Active');
INSERT INTO `state` VALUES ('2624', 'Miaiones', 'State', '8', '167', null, 'Active');
INSERT INTO `state` VALUES ('2625', 'Neembucu', 'State', '12', '167', null, 'Active');
INSERT INTO `state` VALUES ('2626', 'Paraguari', 'State', '9', '167', null, 'Active');
INSERT INTO `state` VALUES ('2627', 'Presidente Hayes', 'State', '15', '167', null, 'Active');
INSERT INTO `state` VALUES ('2628', 'San Pedro', 'State', '2', '167', null, 'Active');
INSERT INTO `state` VALUES ('2629', 'Ad Dawhah', 'State', 'DA', '174', null, 'Active');
INSERT INTO `state` VALUES ('2630', 'Al Ghuwayriyah', 'State', 'GH', '174', null, 'Active');
INSERT INTO `state` VALUES ('2631', 'Al Jumayliyah', 'State', 'JU', '174', null, 'Active');
INSERT INTO `state` VALUES ('2632', 'Al Khawr', 'State', 'KH', '174', null, 'Active');
INSERT INTO `state` VALUES ('2633', 'Al Wakrah', 'State', 'WA', '174', null, 'Active');
INSERT INTO `state` VALUES ('2634', 'Ar Rayyan', 'State', 'RA', '174', null, 'Active');
INSERT INTO `state` VALUES ('2635', 'Jariyan al Batnah', 'State', 'JB', '174', null, 'Active');
INSERT INTO `state` VALUES ('2636', 'Madinat ash Shamal', 'State', 'MS', '174', null, 'Active');
INSERT INTO `state` VALUES ('2637', 'Umm Salal', 'State', 'US', '174', null, 'Active');
INSERT INTO `state` VALUES ('2638', 'Bucuresti', 'State', 'B', '175', null, 'Active');
INSERT INTO `state` VALUES ('2639', 'Alba', 'State', 'AB', '175', null, 'Active');
INSERT INTO `state` VALUES ('2640', 'Arad', 'State', 'AR', '175', null, 'Active');
INSERT INTO `state` VALUES ('2641', 'Arges', 'State', 'AG', '175', null, 'Active');
INSERT INTO `state` VALUES ('2642', 'Bacau', 'State', 'BC', '175', null, 'Active');
INSERT INTO `state` VALUES ('2643', 'Bihor', 'State', 'BH', '175', null, 'Active');
INSERT INTO `state` VALUES ('2644', 'Bistrita-Nasaud', 'State', 'BN', '175', null, 'Active');
INSERT INTO `state` VALUES ('2645', 'Boto\'ani', 'State', 'BT', '175', null, 'Active');
INSERT INTO `state` VALUES ('2646', 'Bra\'ov', 'State', 'BV', '175', null, 'Active');
INSERT INTO `state` VALUES ('2647', 'Braila', 'State', 'BR', '175', null, 'Active');
INSERT INTO `state` VALUES ('2648', 'Buzau', 'State', 'BZ', '175', null, 'Active');
INSERT INTO `state` VALUES ('2649', 'Caras-Severin', 'State', 'CS', '175', null, 'Active');
INSERT INTO `state` VALUES ('2650', 'Ca la ras\'i', 'State', 'CL', '175', null, 'Active');
INSERT INTO `state` VALUES ('2651', 'Cluj', 'State', 'CJ', '175', null, 'Active');
INSERT INTO `state` VALUES ('2652', 'Constant\'a', 'State', 'CT', '175', null, 'Active');
INSERT INTO `state` VALUES ('2653', 'Covasna', 'State', 'CV', '175', null, 'Active');
INSERT INTO `state` VALUES ('2654', 'Dambovit\'a', 'State', 'DB', '175', null, 'Active');
INSERT INTO `state` VALUES ('2655', 'Dolj', 'State', 'DJ', '175', null, 'Active');
INSERT INTO `state` VALUES ('2656', 'Galat\'i', 'State', 'GL', '175', null, 'Active');
INSERT INTO `state` VALUES ('2657', 'Giurgiu', 'State', 'GR', '175', null, 'Active');
INSERT INTO `state` VALUES ('2658', 'Gorj', 'State', 'GJ', '175', null, 'Active');
INSERT INTO `state` VALUES ('2659', 'Harghita', 'State', 'HR', '175', null, 'Active');
INSERT INTO `state` VALUES ('2660', 'Hunedoara', 'State', 'HD', '175', null, 'Active');
INSERT INTO `state` VALUES ('2661', 'Ialomit\'a', 'State', 'IL', '175', null, 'Active');
INSERT INTO `state` VALUES ('2662', 'Ias\'i', 'State', 'IS', '175', null, 'Active');
INSERT INTO `state` VALUES ('2663', 'Ilfov', 'State', 'IF', '175', null, 'Active');
INSERT INTO `state` VALUES ('2664', 'Maramures', 'State', 'MM', '175', null, 'Active');
INSERT INTO `state` VALUES ('2665', 'Mehedint\'i', 'State', 'MH', '175', null, 'Active');
INSERT INTO `state` VALUES ('2666', 'Mures', 'State', 'MS', '175', null, 'Active');
INSERT INTO `state` VALUES ('2667', 'Neamt', 'State', 'NT', '175', null, 'Active');
INSERT INTO `state` VALUES ('2668', 'Olt', 'State', 'OT', '175', null, 'Active');
INSERT INTO `state` VALUES ('2669', 'Prahova', 'State', 'PH', '175', null, 'Active');
INSERT INTO `state` VALUES ('2670', 'Satu Mare', 'State', 'SM', '175', null, 'Active');
INSERT INTO `state` VALUES ('2671', 'Sa laj', 'State', 'SJ', '175', null, 'Active');
INSERT INTO `state` VALUES ('2672', 'Sibiu', 'State', 'SB', '175', null, 'Active');
INSERT INTO `state` VALUES ('2673', 'Suceava', 'State', 'SV', '175', null, 'Active');
INSERT INTO `state` VALUES ('2674', 'Teleorman', 'State', 'TR', '175', null, 'Active');
INSERT INTO `state` VALUES ('2675', 'Timis', 'State', 'TM', '175', null, 'Active');
INSERT INTO `state` VALUES ('2676', 'Tulcea', 'State', 'TL', '175', null, 'Active');
INSERT INTO `state` VALUES ('2677', 'Vaslui', 'State', 'VS', '175', null, 'Active');
INSERT INTO `state` VALUES ('2678', 'Valcea', 'State', 'VL', '175', null, 'Active');
INSERT INTO `state` VALUES ('2679', 'Vrancea', 'State', 'VN', '175', null, 'Active');
INSERT INTO `state` VALUES ('2680', 'Adygeya, Respublika', 'State', 'AD', '176', null, 'Active');
INSERT INTO `state` VALUES ('2681', 'Altay, Respublika', 'State', 'AL', '176', null, 'Active');
INSERT INTO `state` VALUES ('2682', 'Bashkortostan, Respublika', 'State', 'BA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2683', 'Buryatiya, Respublika', 'State', 'BU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2684', 'Chechenskaya Respublika', 'State', 'CE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2685', 'Chuvashskaya Respublika', 'State', 'CU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2686', 'Dagestan, Respublika', 'State', 'DA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2687', 'Ingushskaya Respublika', 'State', 'IN', '176', null, 'Active');
INSERT INTO `state` VALUES ('2688', 'Kabardino-Balkarskaya', 'State', 'KB', '176', null, 'Active');
INSERT INTO `state` VALUES ('2689', 'Kalmykiya, Respublika', 'State', 'KL', '176', null, 'Active');
INSERT INTO `state` VALUES ('2690', 'Karachayevo-Cherkesskaya Respublika', 'State', 'KC', '176', null, 'Active');
INSERT INTO `state` VALUES ('2691', 'Kareliya, Respublika', 'State', 'KR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2692', 'Khakasiya, Respublika', 'State', 'KK', '176', null, 'Active');
INSERT INTO `state` VALUES ('2693', 'Komi, Respublika', 'State', 'KO', '176', null, 'Active');
INSERT INTO `state` VALUES ('2694', 'Mariy El, Respublika', 'State', 'ME', '176', null, 'Active');
INSERT INTO `state` VALUES ('2695', 'Mordoviya, Respublika', 'State', 'MO', '176', null, 'Active');
INSERT INTO `state` VALUES ('2696', 'Sakha, Respublika [Yakutiya]', 'State', 'SA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2697', 'Severnaya Osetiya, Respublika', 'State', 'SE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2698', 'Tatarstan, Respublika', 'State', 'TA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2699', 'Tyva, Respublika [Tuva]', 'State', 'TY', '176', null, 'Active');
INSERT INTO `state` VALUES ('2700', 'Udmurtskaya Respublika', 'State', 'UD', '176', null, 'Active');
INSERT INTO `state` VALUES ('2701', 'Altayskiy kray', 'State', 'ALT', '176', null, 'Active');
INSERT INTO `state` VALUES ('2702', 'Khabarovskiy kray', 'State', 'KHA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2703', 'Krasnodarskiy kray', 'State', 'KDA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2704', 'Krasnoyarskiy kray', 'State', 'KYA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2705', 'Primorskiy kray', 'State', 'PRI', '176', null, 'Active');
INSERT INTO `state` VALUES ('2706', 'Stavropol\'skiy kray', 'State', 'STA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2707', 'Amurskaya oblast\'', 'State', 'AMU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2708', 'Arkhangel\'skaya oblast\'', 'State', 'ARK', '176', null, 'Active');
INSERT INTO `state` VALUES ('2709', 'Astrakhanskaya oblast\'', 'State', 'AST', '176', null, 'Active');
INSERT INTO `state` VALUES ('2710', 'Belgorodskaya oblast\'', 'State', 'BEL', '176', null, 'Active');
INSERT INTO `state` VALUES ('2711', 'Bryanskaya oblast\'', 'State', 'BRY', '176', null, 'Active');
INSERT INTO `state` VALUES ('2712', 'Chelyabinskaya oblast\'', 'State', 'CHE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2713', 'Chitinskaya oblast\'', 'State', 'CHI', '176', null, 'Active');
INSERT INTO `state` VALUES ('2714', 'Irkutskaya oblast\'', 'State', 'IRK', '176', null, 'Active');
INSERT INTO `state` VALUES ('2715', 'Ivanovskaya oblast\'', 'State', 'IVA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2716', 'Kaliningradskaya oblast\'', 'State', 'KGD', '176', null, 'Active');
INSERT INTO `state` VALUES ('2717', 'Kaluzhskaya oblast\'', 'State', 'KLU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2718', 'Kamchatskaya oblast\'', 'State', 'KAM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2719', 'Kemerovskaya oblast\'', 'State', 'KEM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2720', 'Kirovskaya oblast\'', 'State', 'KIR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2721', 'Kostromskaya oblast\'', 'State', 'KOS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2722', 'Kurganskaya oblast\'', 'State', 'KGN', '176', null, 'Active');
INSERT INTO `state` VALUES ('2723', 'Kurskaya oblast\'', 'State', 'KRS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2724', 'Leningradskaya oblast\'', 'State', 'LEN', '176', null, 'Active');
INSERT INTO `state` VALUES ('2725', 'Lipetskaya oblast\'', 'State', 'LIP', '176', null, 'Active');
INSERT INTO `state` VALUES ('2726', 'Magadanskaya oblast\'', 'State', 'MAG', '176', null, 'Active');
INSERT INTO `state` VALUES ('2727', 'Moskovskaya oblast\'', 'State', 'MOS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2728', 'Murmanskaya oblast\'', 'State', 'MUR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2729', 'Nizhegorodskaya oblast\'', 'State', 'NIZ', '176', null, 'Active');
INSERT INTO `state` VALUES ('2730', 'Novgorodskaya oblast\'', 'State', 'NGR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2731', 'Novosibirskaya oblast\'', 'State', 'NVS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2732', 'Omskaya oblast\'', 'State', 'OMS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2733', 'Orenburgskaya oblast\'', 'State', 'ORE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2734', 'Orlovskaya oblast\'', 'State', 'ORL', '176', null, 'Active');
INSERT INTO `state` VALUES ('2735', 'Penzenskaya oblast\'', 'State', 'PNZ', '176', null, 'Active');
INSERT INTO `state` VALUES ('2736', 'Permskaya oblast\'', 'State', 'PER', '176', null, 'Active');
INSERT INTO `state` VALUES ('2737', 'Pskovskaya oblast\'', 'State', 'PSK', '176', null, 'Active');
INSERT INTO `state` VALUES ('2738', 'Rostovskaya oblast\'', 'State', 'ROS', '176', null, 'Active');
INSERT INTO `state` VALUES ('2739', 'Ryazanskaya oblast\'', 'State', 'RYA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2740', 'Sakhalinskaya oblast\'', 'State', 'SAK', '176', null, 'Active');
INSERT INTO `state` VALUES ('2741', 'Samarskaya oblast\'', 'State', 'SAM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2742', 'Saratovskaya oblast\'', 'State', 'SAR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2743', 'Smolenskaya oblast\'', 'State', 'SMO', '176', null, 'Active');
INSERT INTO `state` VALUES ('2744', 'Sverdlovskaya oblast\'', 'State', 'SVE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2745', 'Tambovskaya oblast\'', 'State', 'TAM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2746', 'Tomskaya oblast\'', 'State', 'TOM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2747', 'Tul\'skaya oblast\'', 'State', 'TUL', '176', null, 'Active');
INSERT INTO `state` VALUES ('2748', 'Tverskaya oblast\'', 'State', 'TVE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2749', 'Tyumenskaya oblast\'', 'State', 'TYU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2750', 'Ul\'yanovskaya oblast\'', 'State', 'ULY', '176', null, 'Active');
INSERT INTO `state` VALUES ('2751', 'Vladimirskaya oblast\'', 'State', 'VLA', '176', null, 'Active');
INSERT INTO `state` VALUES ('2752', 'Volgogradskaya oblast\'', 'State', 'VGG', '176', null, 'Active');
INSERT INTO `state` VALUES ('2753', 'Vologodskaya oblast\'', 'State', 'VLG', '176', null, 'Active');
INSERT INTO `state` VALUES ('2754', 'Voronezhskaya oblast\'', 'State', 'VOR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2755', 'Yaroslavskaya oblast\'', 'State', 'YAR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2756', 'Moskva', 'State', 'MOW', '176', null, 'Active');
INSERT INTO `state` VALUES ('2757', 'Sankt-Peterburg', 'State', 'SPE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2758', 'Yevreyskaya avtonomnaya oblast\'', 'State', 'YEV', '176', null, 'Active');
INSERT INTO `state` VALUES ('2759', 'Aginskiy Buryatskiy avtonomnyy', 'State', 'AGB', '176', null, 'Active');
INSERT INTO `state` VALUES ('2760', 'Chukotskiy avtonomnyy okrug', 'State', 'CHU', '176', null, 'Active');
INSERT INTO `state` VALUES ('2761', 'Evenkiyskiy avtonomnyy okrug', 'State', 'EVE', '176', null, 'Active');
INSERT INTO `state` VALUES ('2762', 'Khanty-Mansiyskiy avtonomnyy okrug', 'State', 'KHM', '176', null, 'Active');
INSERT INTO `state` VALUES ('2763', 'Komi-Permyatskiy avtonomnyy okrug', 'State', 'KOP', '176', null, 'Active');
INSERT INTO `state` VALUES ('2764', 'Koryakskiy avtonomnyy okrug', 'State', 'KOR', '176', null, 'Active');
INSERT INTO `state` VALUES ('2765', 'Nenetskiy avtonomnyy okrug', 'State', 'NEN', '176', null, 'Active');
INSERT INTO `state` VALUES ('2766', 'Taymyrskiy (Dolgano-Nenetskiy)', 'State', 'TAY', '176', null, 'Active');
INSERT INTO `state` VALUES ('2767', 'Ust\'-Ordynskiy Buryatskiy', 'State', 'UOB', '176', null, 'Active');
INSERT INTO `state` VALUES ('2768', 'Yamalo-Nenetskiy avtonomnyy okrug', 'State', 'YAN', '176', null, 'Active');
INSERT INTO `state` VALUES ('2769', 'Butare', 'State', 'C', '177', null, 'Active');
INSERT INTO `state` VALUES ('2770', 'Byumba', 'State', 'I', '177', null, 'Active');
INSERT INTO `state` VALUES ('2771', 'Cyangugu', 'State', 'E', '177', null, 'Active');
INSERT INTO `state` VALUES ('2772', 'Gikongoro', 'State', 'D', '177', null, 'Active');
INSERT INTO `state` VALUES ('2773', 'Gisenyi', 'State', 'G', '177', null, 'Active');
INSERT INTO `state` VALUES ('2774', 'Gitarama', 'State', 'B', '177', null, 'Active');
INSERT INTO `state` VALUES ('2775', 'Kibungo', 'State', 'J', '177', null, 'Active');
INSERT INTO `state` VALUES ('2776', 'Kibuye', 'State', 'F', '177', null, 'Active');
INSERT INTO `state` VALUES ('2777', 'Kigali-Rural Kigali y\' Icyaro', 'State', 'K', '177', null, 'Active');
INSERT INTO `state` VALUES ('2778', 'Kigali-Ville Kigali Ngari', 'State', 'L', '177', null, 'Active');
INSERT INTO `state` VALUES ('2779', 'Mutara', 'State', 'M', '177', null, 'Active');
INSERT INTO `state` VALUES ('2780', 'Ruhengeri', 'State', 'H', '177', null, 'Active');
INSERT INTO `state` VALUES ('2781', 'Al Batah', 'State', '11', '186', null, 'Active');
INSERT INTO `state` VALUES ('2782', 'Al H,udd ash Shamallyah', 'State', '08', '186', null, 'Active');
INSERT INTO `state` VALUES ('2783', 'Al Jawf', 'State', '12', '186', null, 'Active');
INSERT INTO `state` VALUES ('2784', 'Al Madinah', 'State', '03', '186', null, 'Active');
INSERT INTO `state` VALUES ('2785', 'Al Qasim', 'State', '05', '186', null, 'Active');
INSERT INTO `state` VALUES ('2786', 'Ar Riyad', 'State', '01', '186', null, 'Active');
INSERT INTO `state` VALUES ('2787', 'Asir', 'State', '14', '186', null, 'Active');
INSERT INTO `state` VALUES ('2788', 'Ha\'il', 'State', '06', '186', null, 'Active');
INSERT INTO `state` VALUES ('2789', 'Jlzan', 'State', '09', '186', null, 'Active');
INSERT INTO `state` VALUES ('2790', 'Makkah', 'State', '02', '186', null, 'Active');
INSERT INTO `state` VALUES ('2791', 'Najran', 'State', '10', '186', null, 'Active');
INSERT INTO `state` VALUES ('2792', 'Tabuk', 'State', '07', '186', null, 'Active');
INSERT INTO `state` VALUES ('2793', 'Capital Territory (Honiara)', 'State', 'CT', '193', null, 'Active');
INSERT INTO `state` VALUES ('2794', 'Guadalcanal', 'State', 'GU', '193', null, 'Active');
INSERT INTO `state` VALUES ('2795', 'Isabel', 'State', 'IS', '193', null, 'Active');
INSERT INTO `state` VALUES ('2796', 'Makira', 'State', 'MK', '193', null, 'Active');
INSERT INTO `state` VALUES ('2797', 'Malaita', 'State', 'ML', '193', null, 'Active');
INSERT INTO `state` VALUES ('2798', 'Temotu', 'State', 'TE', '193', null, 'Active');
INSERT INTO `state` VALUES ('2799', 'A\'ali an Nil', 'State', '23', '199', null, 'Active');
INSERT INTO `state` VALUES ('2800', 'Al Bah al Ahmar', 'State', '26', '199', null, 'Active');
INSERT INTO `state` VALUES ('2801', 'Al Buhayrat', 'State', '18', '199', null, 'Active');
INSERT INTO `state` VALUES ('2802', 'Al Jazirah', 'State', '07', '199', null, 'Active');
INSERT INTO `state` VALUES ('2803', 'Al Khartum', 'State', '03', '199', null, 'Active');
INSERT INTO `state` VALUES ('2804', 'Al Qadarif', 'State', '06', '199', null, 'Active');
INSERT INTO `state` VALUES ('2805', 'Al Wahdah', 'State', '22', '199', null, 'Active');
INSERT INTO `state` VALUES ('2806', 'An Nil', 'State', '04', '199', null, 'Active');
INSERT INTO `state` VALUES ('2807', 'An Nil al Abyaq', 'State', '08', '199', null, 'Active');
INSERT INTO `state` VALUES ('2808', 'An Nil al Azraq', 'State', '24', '199', null, 'Active');
INSERT INTO `state` VALUES ('2809', 'Ash Shamallyah', 'State', '01', '199', null, 'Active');
INSERT INTO `state` VALUES ('2810', 'Bahr al Jabal', 'State', '17', '199', null, 'Active');
INSERT INTO `state` VALUES ('2811', 'Gharb al Istiwa\'iyah', 'State', '16', '199', null, 'Active');
INSERT INTO `state` VALUES ('2812', 'Gharb Ba~r al Ghazal', 'State', '14', '199', null, 'Active');
INSERT INTO `state` VALUES ('2813', 'Gharb Darfur', 'State', '12', '199', null, 'Active');
INSERT INTO `state` VALUES ('2814', 'Gharb Kurdufan', 'State', '10', '199', null, 'Active');
INSERT INTO `state` VALUES ('2815', 'Janub Darfur', 'State', '11', '199', null, 'Active');
INSERT INTO `state` VALUES ('2816', 'Janub Rurdufan', 'State', '13', '199', null, 'Active');
INSERT INTO `state` VALUES ('2817', 'Jnqall', 'State', '20', '199', null, 'Active');
INSERT INTO `state` VALUES ('2818', 'Kassala', 'State', '05', '199', null, 'Active');
INSERT INTO `state` VALUES ('2819', 'Shamal Batr al Ghazal', 'State', '15', '199', null, 'Active');
INSERT INTO `state` VALUES ('2820', 'Shamal Darfur', 'State', '02', '199', null, 'Active');
INSERT INTO `state` VALUES ('2821', 'Shamal Kurdufan', 'State', '09', '199', null, 'Active');
INSERT INTO `state` VALUES ('2822', 'Sharq al Istiwa\'iyah', 'State', '19', '199', null, 'Active');
INSERT INTO `state` VALUES ('2823', 'Sinnar', 'State', '25', '199', null, 'Active');
INSERT INTO `state` VALUES ('2824', 'Warab', 'State', '21', '199', null, 'Active');
INSERT INTO `state` VALUES ('2825', 'Blekinge lan', 'State', 'K', '203', null, 'Active');
INSERT INTO `state` VALUES ('2826', 'Dalarnas lan', 'State', 'W', '203', null, 'Active');
INSERT INTO `state` VALUES ('2827', 'Gotlands lan', 'State', 'I', '203', null, 'Active');
INSERT INTO `state` VALUES ('2828', 'Gavleborge lan', 'State', 'X', '203', null, 'Active');
INSERT INTO `state` VALUES ('2829', 'Hallands lan', 'State', 'N', '203', null, 'Active');
INSERT INTO `state` VALUES ('2830', 'Jamtlande lan', 'State', 'Z', '203', null, 'Active');
INSERT INTO `state` VALUES ('2831', 'Jonkopings lan', 'State', 'F', '203', null, 'Active');
INSERT INTO `state` VALUES ('2832', 'Kalmar lan', 'State', 'H', '203', null, 'Active');
INSERT INTO `state` VALUES ('2833', 'Kronoberge lan', 'State', 'G', '203', null, 'Active');
INSERT INTO `state` VALUES ('2834', 'Norrbottena lan', 'State', 'BD', '203', null, 'Active');
INSERT INTO `state` VALUES ('2835', 'Skane lan', 'State', 'M', '203', null, 'Active');
INSERT INTO `state` VALUES ('2836', 'Stockholms lan', 'State', 'AB', '203', null, 'Active');
INSERT INTO `state` VALUES ('2837', 'Sodermanlands lan', 'State', 'D', '203', null, 'Active');
INSERT INTO `state` VALUES ('2838', 'Uppsala lan', 'State', 'C', '203', null, 'Active');
INSERT INTO `state` VALUES ('2839', 'Varmlanda lan', 'State', 'S', '203', null, 'Active');
INSERT INTO `state` VALUES ('2840', 'Vasterbottens lan', 'State', 'AC', '203', null, 'Active');
INSERT INTO `state` VALUES ('2841', 'Vasternorrlands lan', 'State', 'Y', '203', null, 'Active');
INSERT INTO `state` VALUES ('2842', 'Vastmanlanda lan', 'State', 'U', '203', null, 'Active');
INSERT INTO `state` VALUES ('2843', 'Vastra Gotalands lan', 'State', 'Q', '203', null, 'Active');
INSERT INTO `state` VALUES ('2844', 'Orebro lan', 'State', 'T', '203', null, 'Active');
INSERT INTO `state` VALUES ('2845', 'Ostergotlands lan', 'State', 'E', '203', null, 'Active');
INSERT INTO `state` VALUES ('2846', 'Saint Helena', 'State', 'SH', '179', null, 'Active');
INSERT INTO `state` VALUES ('2847', 'Ascension', 'State', 'AC', '179', null, 'Active');
INSERT INTO `state` VALUES ('2848', 'Tristan da Cunha', 'State', 'TA', '179', null, 'Active');
INSERT INTO `state` VALUES ('2849', 'Ajdovscina', 'State', '001', '192', null, 'Active');
INSERT INTO `state` VALUES ('2850', 'Beltinci', 'State', '002', '192', null, 'Active');
INSERT INTO `state` VALUES ('2851', 'Benedikt', 'State', '148', '192', null, 'Active');
INSERT INTO `state` VALUES ('2852', 'Bistrica ob Sotli', 'State', '149', '192', null, 'Active');
INSERT INTO `state` VALUES ('2853', 'Bled', 'State', '003', '192', null, 'Active');
INSERT INTO `state` VALUES ('2854', 'Bloke', 'State', '150', '192', null, 'Active');
INSERT INTO `state` VALUES ('2855', 'Bohinj', 'State', '004', '192', null, 'Active');
INSERT INTO `state` VALUES ('2856', 'Borovnica', 'State', '005', '192', null, 'Active');
INSERT INTO `state` VALUES ('2857', 'Bovec', 'State', '006', '192', null, 'Active');
INSERT INTO `state` VALUES ('2858', 'Braslovce', 'State', '151', '192', null, 'Active');
INSERT INTO `state` VALUES ('2859', 'Brda', 'State', '007', '192', null, 'Active');
INSERT INTO `state` VALUES ('2860', 'Brezovica', 'State', '008', '192', null, 'Active');
INSERT INTO `state` VALUES ('2861', 'Brezica', 'State', '009', '192', null, 'Active');
INSERT INTO `state` VALUES ('2862', 'Cankova', 'State', '152', '192', null, 'Active');
INSERT INTO `state` VALUES ('2863', 'Celje', 'State', '011', '192', null, 'Active');
INSERT INTO `state` VALUES ('2864', 'Cerklje na Gorenjskem', 'State', '012', '192', null, 'Active');
INSERT INTO `state` VALUES ('2865', 'Cerknica', 'State', '013', '192', null, 'Active');
INSERT INTO `state` VALUES ('2866', 'Cerkno', 'State', '014', '192', null, 'Active');
INSERT INTO `state` VALUES ('2867', 'Cerkvenjak', 'State', '153', '192', null, 'Active');
INSERT INTO `state` VALUES ('2868', 'Crensovci', 'State', '015', '192', null, 'Active');
INSERT INTO `state` VALUES ('2869', 'Crna na Koroskem', 'State', '016', '192', null, 'Active');
INSERT INTO `state` VALUES ('2870', 'Crnomelj', 'State', '017', '192', null, 'Active');
INSERT INTO `state` VALUES ('2871', 'Destrnik', 'State', '018', '192', null, 'Active');
INSERT INTO `state` VALUES ('2872', 'Divaca', 'State', '019', '192', null, 'Active');
INSERT INTO `state` VALUES ('2873', 'Dobje', 'State', '154', '192', null, 'Active');
INSERT INTO `state` VALUES ('2874', 'Dobrepolje', 'State', '020', '192', null, 'Active');
INSERT INTO `state` VALUES ('2875', 'Dobrna', 'State', '155', '192', null, 'Active');
INSERT INTO `state` VALUES ('2876', 'Dobrova-Polhov Gradec', 'State', '021', '192', null, 'Active');
INSERT INTO `state` VALUES ('2877', 'Dobrovnik', 'State', '156', '192', null, 'Active');
INSERT INTO `state` VALUES ('2878', 'Dol pri Ljubljani', 'State', '022', '192', null, 'Active');
INSERT INTO `state` VALUES ('2879', 'Dolenjske Toplice', 'State', '157', '192', null, 'Active');
INSERT INTO `state` VALUES ('2880', 'Domzale', 'State', '023', '192', null, 'Active');
INSERT INTO `state` VALUES ('2881', 'Dornava', 'State', '024', '192', null, 'Active');
INSERT INTO `state` VALUES ('2882', 'Dravograd', 'State', '025', '192', null, 'Active');
INSERT INTO `state` VALUES ('2883', 'Duplek', 'State', '026', '192', null, 'Active');
INSERT INTO `state` VALUES ('2884', 'Gorenja vas-Poljane', 'State', '027', '192', null, 'Active');
INSERT INTO `state` VALUES ('2885', 'Gorsnica', 'State', '028', '192', null, 'Active');
INSERT INTO `state` VALUES ('2886', 'Gornja Radgona', 'State', '029', '192', null, 'Active');
INSERT INTO `state` VALUES ('2887', 'Gornji Grad', 'State', '030', '192', null, 'Active');
INSERT INTO `state` VALUES ('2888', 'Gornji Petrovci', 'State', '031', '192', null, 'Active');
INSERT INTO `state` VALUES ('2889', 'Grad', 'State', '158', '192', null, 'Active');
INSERT INTO `state` VALUES ('2890', 'Grosuplje', 'State', '032', '192', null, 'Active');
INSERT INTO `state` VALUES ('2891', 'Hajdina', 'State', '159', '192', null, 'Active');
INSERT INTO `state` VALUES ('2892', 'Hoce-Slivnica', 'State', '160', '192', null, 'Active');
INSERT INTO `state` VALUES ('2893', 'Hodos', 'State', '161', '192', null, 'Active');
INSERT INTO `state` VALUES ('2894', 'Jorjul', 'State', '162', '192', null, 'Active');
INSERT INTO `state` VALUES ('2895', 'Hrastnik', 'State', '034', '192', null, 'Active');
INSERT INTO `state` VALUES ('2896', 'Hrpelje-Kozina', 'State', '035', '192', null, 'Active');
INSERT INTO `state` VALUES ('2897', 'Idrija', 'State', '036', '192', null, 'Active');
INSERT INTO `state` VALUES ('2898', 'Ig', 'State', '037', '192', null, 'Active');
INSERT INTO `state` VALUES ('2899', 'IIrska Bistrica', 'State', '038', '192', null, 'Active');
INSERT INTO `state` VALUES ('2900', 'Ivancna Gorica', 'State', '039', '192', null, 'Active');
INSERT INTO `state` VALUES ('2901', 'Izola', 'State', '040', '192', null, 'Active');
INSERT INTO `state` VALUES ('2902', 'Jesenice', 'State', '041', '192', null, 'Active');
INSERT INTO `state` VALUES ('2903', 'Jezersko', 'State', '163', '192', null, 'Active');
INSERT INTO `state` VALUES ('2904', 'Jursinci', 'State', '042', '192', null, 'Active');
INSERT INTO `state` VALUES ('2905', 'Kamnik', 'State', '043', '192', null, 'Active');
INSERT INTO `state` VALUES ('2906', 'Kanal', 'State', '044', '192', null, 'Active');
INSERT INTO `state` VALUES ('2907', 'Kidricevo', 'State', '045', '192', null, 'Active');
INSERT INTO `state` VALUES ('2908', 'Kobarid', 'State', '046', '192', null, 'Active');
INSERT INTO `state` VALUES ('2909', 'Kobilje', 'State', '047', '192', null, 'Active');
INSERT INTO `state` VALUES ('2910', 'Jovevje', 'State', '048', '192', null, 'Active');
INSERT INTO `state` VALUES ('2911', 'Komen', 'State', '049', '192', null, 'Active');
INSERT INTO `state` VALUES ('2912', 'Komenda', 'State', '164', '192', null, 'Active');
INSERT INTO `state` VALUES ('2913', 'Koper', 'State', '050', '192', null, 'Active');
INSERT INTO `state` VALUES ('2914', 'Kostel', 'State', '165', '192', null, 'Active');
INSERT INTO `state` VALUES ('2915', 'Kozje', 'State', '051', '192', null, 'Active');
INSERT INTO `state` VALUES ('2916', 'Kranj', 'State', '052', '192', null, 'Active');
INSERT INTO `state` VALUES ('2917', 'Kranjska Gora', 'State', '053', '192', null, 'Active');
INSERT INTO `state` VALUES ('2918', 'Krizevci', 'State', '166', '192', null, 'Active');
INSERT INTO `state` VALUES ('2919', 'Krsko', 'State', '054', '192', null, 'Active');
INSERT INTO `state` VALUES ('2920', 'Kungota', 'State', '055', '192', null, 'Active');
INSERT INTO `state` VALUES ('2921', 'Kuzma', 'State', '056', '192', null, 'Active');
INSERT INTO `state` VALUES ('2922', 'Lasko', 'State', '057', '192', null, 'Active');
INSERT INTO `state` VALUES ('2923', 'Lenart', 'State', '058', '192', null, 'Active');
INSERT INTO `state` VALUES ('2924', 'Lendava', 'State', '059', '192', null, 'Active');
INSERT INTO `state` VALUES ('2925', 'Litija', 'State', '060', '192', null, 'Active');
INSERT INTO `state` VALUES ('2926', 'Ljubljana', 'State', '061', '192', null, 'Active');
INSERT INTO `state` VALUES ('2927', 'Ljubno', 'State', '062', '192', null, 'Active');
INSERT INTO `state` VALUES ('2928', 'Ljutomer', 'State', '063', '192', null, 'Active');
INSERT INTO `state` VALUES ('2929', 'Logatec', 'State', '064', '192', null, 'Active');
INSERT INTO `state` VALUES ('2930', 'Loska dolina', 'State', '065', '192', null, 'Active');
INSERT INTO `state` VALUES ('2931', 'Loski Potok', 'State', '066', '192', null, 'Active');
INSERT INTO `state` VALUES ('2932', 'Lovrenc na Pohorju', 'State', '167', '192', null, 'Active');
INSERT INTO `state` VALUES ('2933', 'Luce', 'State', '067', '192', null, 'Active');
INSERT INTO `state` VALUES ('2934', 'Lukovica', 'State', '068', '192', null, 'Active');
INSERT INTO `state` VALUES ('2935', 'Majsperk', 'State', '069', '192', null, 'Active');
INSERT INTO `state` VALUES ('2936', 'Maribor', 'State', '070', '192', null, 'Active');
INSERT INTO `state` VALUES ('2937', 'Markovci', 'State', '168', '192', null, 'Active');
INSERT INTO `state` VALUES ('2938', 'Medvode', 'State', '071', '192', null, 'Active');
INSERT INTO `state` VALUES ('2939', 'Menges', 'State', '072', '192', null, 'Active');
INSERT INTO `state` VALUES ('2940', 'Metlika', 'State', '073', '192', null, 'Active');
INSERT INTO `state` VALUES ('2941', 'Mezica', 'State', '074', '192', null, 'Active');
INSERT INTO `state` VALUES ('2942', 'Miklavz na Dravskern polju', 'State', '169', '192', null, 'Active');
INSERT INTO `state` VALUES ('2943', 'Miren-Kostanjevica', 'State', '075', '192', null, 'Active');
INSERT INTO `state` VALUES ('2944', 'Mirna Pec', 'State', '170', '192', null, 'Active');
INSERT INTO `state` VALUES ('2945', 'Mislinja', 'State', '076', '192', null, 'Active');
INSERT INTO `state` VALUES ('2946', 'Moravce', 'State', '077', '192', null, 'Active');
INSERT INTO `state` VALUES ('2947', 'Moravske Toplice', 'State', '078', '192', null, 'Active');
INSERT INTO `state` VALUES ('2948', 'Mozirje', 'State', '079', '192', null, 'Active');
INSERT INTO `state` VALUES ('2949', 'Murska Sobota', 'State', '080', '192', null, 'Active');
INSERT INTO `state` VALUES ('2950', 'Muta', 'State', '081', '192', null, 'Active');
INSERT INTO `state` VALUES ('2951', 'Naklo', 'State', '082', '192', null, 'Active');
INSERT INTO `state` VALUES ('2952', 'Nazarje', 'State', '083', '192', null, 'Active');
INSERT INTO `state` VALUES ('2953', 'Nova Gorica', 'State', '084', '192', null, 'Active');
INSERT INTO `state` VALUES ('2954', 'Nova mesto', 'State', '085', '192', null, 'Active');
INSERT INTO `state` VALUES ('2955', 'Sveta Ana', 'State', '181', '192', null, 'Active');
INSERT INTO `state` VALUES ('2956', 'Sveti Andraz v Slovenskih goricah', 'State', '182', '192', null, 'Active');
INSERT INTO `state` VALUES ('2957', 'Sveti Jurij', 'State', '116', '192', null, 'Active');
INSERT INTO `state` VALUES ('2958', 'Salovci', 'State', '033', '192', null, 'Active');
INSERT INTO `state` VALUES ('2959', 'Sempeter-Vrtojba', 'State', '183', '192', null, 'Active');
INSERT INTO `state` VALUES ('2960', 'Sencur', 'State', '117', '192', null, 'Active');
INSERT INTO `state` VALUES ('2961', 'Sentilj', 'State', '118', '192', null, 'Active');
INSERT INTO `state` VALUES ('2962', 'Sentjernej', 'State', '119', '192', null, 'Active');
INSERT INTO `state` VALUES ('2963', 'Sentjur pri Celju', 'State', '120', '192', null, 'Active');
INSERT INTO `state` VALUES ('2964', 'Skocjan', 'State', '121', '192', null, 'Active');
INSERT INTO `state` VALUES ('2965', 'Skofja Loka', 'State', '122', '192', null, 'Active');
INSERT INTO `state` VALUES ('2966', 'Skoftjica', 'State', '123', '192', null, 'Active');
INSERT INTO `state` VALUES ('2967', 'Smarje pri Jelsah', 'State', '124', '192', null, 'Active');
INSERT INTO `state` VALUES ('2968', 'Smartno ob Paki', 'State', '125', '192', null, 'Active');
INSERT INTO `state` VALUES ('2969', 'Smartno pri Litiji', 'State', '194', '192', null, 'Active');
INSERT INTO `state` VALUES ('2970', 'Sostanj', 'State', '126', '192', null, 'Active');
INSERT INTO `state` VALUES ('2971', 'Store', 'State', '127', '192', null, 'Active');
INSERT INTO `state` VALUES ('2972', 'Tabor', 'State', '184', '192', null, 'Active');
INSERT INTO `state` VALUES ('2973', 'Tisina', 'State', '010', '192', null, 'Active');
INSERT INTO `state` VALUES ('2974', 'Tolmin', 'State', '128', '192', null, 'Active');
INSERT INTO `state` VALUES ('2975', 'Trbovje', 'State', '129', '192', null, 'Active');
INSERT INTO `state` VALUES ('2976', 'Trebnje', 'State', '130', '192', null, 'Active');
INSERT INTO `state` VALUES ('2977', 'Trnovska vas', 'State', '185', '192', null, 'Active');
INSERT INTO `state` VALUES ('2978', 'Trzic', 'State', '131', '192', null, 'Active');
INSERT INTO `state` VALUES ('2979', 'Trzin', 'State', '186', '192', null, 'Active');
INSERT INTO `state` VALUES ('2980', 'Turnisce', 'State', '132', '192', null, 'Active');
INSERT INTO `state` VALUES ('2981', 'Velenje', 'State', '133', '192', null, 'Active');
INSERT INTO `state` VALUES ('2982', 'Velika Polana', 'State', '187', '192', null, 'Active');
INSERT INTO `state` VALUES ('2983', 'Velika Lasce', 'State', '134', '192', null, 'Active');
INSERT INTO `state` VALUES ('2984', 'Verzej', 'State', '188', '192', null, 'Active');
INSERT INTO `state` VALUES ('2985', 'Videm', 'State', '135', '192', null, 'Active');
INSERT INTO `state` VALUES ('2986', 'Vipava', 'State', '136', '192', null, 'Active');
INSERT INTO `state` VALUES ('2987', 'Vitanje', 'State', '137', '192', null, 'Active');
INSERT INTO `state` VALUES ('2988', 'Vojnik', 'State', '138', '192', null, 'Active');
INSERT INTO `state` VALUES ('2989', 'Vransko', 'State', '189', '192', null, 'Active');
INSERT INTO `state` VALUES ('2990', 'Vrhnika', 'State', '140', '192', null, 'Active');
INSERT INTO `state` VALUES ('2991', 'Vuzenica', 'State', '141', '192', null, 'Active');
INSERT INTO `state` VALUES ('2992', 'Zagorje ob Savi', 'State', '142', '192', null, 'Active');
INSERT INTO `state` VALUES ('2993', 'Zavrc', 'State', '143', '192', null, 'Active');
INSERT INTO `state` VALUES ('2994', 'Zrece', 'State', '144', '192', null, 'Active');
INSERT INTO `state` VALUES ('2995', 'Zalec', 'State', '190', '192', null, 'Active');
INSERT INTO `state` VALUES ('2996', 'Zelezniki', 'State', '146', '192', null, 'Active');
INSERT INTO `state` VALUES ('2997', 'Zetale', 'State', '191', '192', null, 'Active');
INSERT INTO `state` VALUES ('2998', 'Ziri', 'State', '147', '192', null, 'Active');
INSERT INTO `state` VALUES ('2999', 'Zirovnica', 'State', '192', '192', null, 'Active');
INSERT INTO `state` VALUES ('3000', 'Zuzemberk', 'State', '193', '192', null, 'Active');
INSERT INTO `state` VALUES ('3001', 'Banskobystrický kraj', 'State', 'BC', '191', null, 'Active');
INSERT INTO `state` VALUES ('3002', 'Bratislavský kraj', 'State', 'BL', '191', null, 'Active');
INSERT INTO `state` VALUES ('3003', 'Košický kraj', 'State', 'KI', '191', null, 'Active');
INSERT INTO `state` VALUES ('3004', 'Nitriansky kraj', 'State', 'NJ', '191', null, 'Active');
INSERT INTO `state` VALUES ('3005', 'Prešovský kraj', 'State', 'PV', '191', null, 'Active');
INSERT INTO `state` VALUES ('3006', 'Tren?iansky kraj', 'State', 'TC', '191', null, 'Active');
INSERT INTO `state` VALUES ('3007', 'Trnavský kraj', 'State', 'TA', '191', null, 'Active');
INSERT INTO `state` VALUES ('3008', 'Žilinský kraj', 'State', 'ZI', '191', null, 'Active');
INSERT INTO `state` VALUES ('3009', 'Western Area (Freetown)', 'State', 'W', '189', null, 'Active');
INSERT INTO `state` VALUES ('3010', 'Dakar', 'State', 'DK', '187', null, 'Active');
INSERT INTO `state` VALUES ('3011', 'Diourbel', 'State', 'DB', '187', null, 'Active');
INSERT INTO `state` VALUES ('3012', 'Fatick', 'State', 'FK', '187', null, 'Active');
INSERT INTO `state` VALUES ('3013', 'Kaolack', 'State', 'KL', '187', null, 'Active');
INSERT INTO `state` VALUES ('3014', 'Kolda', 'State', 'KD', '187', null, 'Active');
INSERT INTO `state` VALUES ('3015', 'Louga', 'State', 'LG', '187', null, 'Active');
INSERT INTO `state` VALUES ('3016', 'Matam', 'State', 'MT', '187', null, 'Active');
INSERT INTO `state` VALUES ('3017', 'Saint-Louis', 'State', 'SL', '187', null, 'Active');
INSERT INTO `state` VALUES ('3018', 'Tambacounda', 'State', 'TC', '187', null, 'Active');
INSERT INTO `state` VALUES ('3019', 'Thies', 'State', 'TH', '187', null, 'Active');
INSERT INTO `state` VALUES ('3020', 'Ziguinchor', 'State', 'ZG', '187', null, 'Active');
INSERT INTO `state` VALUES ('3021', 'Awdal', 'State', 'AW', '194', null, 'Active');
INSERT INTO `state` VALUES ('3022', 'Bakool', 'State', 'BK', '194', null, 'Active');
INSERT INTO `state` VALUES ('3023', 'Banaadir', 'State', 'BN', '194', null, 'Active');
INSERT INTO `state` VALUES ('3024', 'Bay', 'State', 'BY', '194', null, 'Active');
INSERT INTO `state` VALUES ('3025', 'Galguduud', 'State', 'GA', '194', null, 'Active');
INSERT INTO `state` VALUES ('3026', 'Gedo', 'State', 'GE', '194', null, 'Active');
INSERT INTO `state` VALUES ('3027', 'Hiirsan', 'State', 'HI', '194', null, 'Active');
INSERT INTO `state` VALUES ('3028', 'Jubbada Dhexe', 'State', 'JD', '194', null, 'Active');
INSERT INTO `state` VALUES ('3029', 'Jubbada Hoose', 'State', 'JH', '194', null, 'Active');
INSERT INTO `state` VALUES ('3030', 'Mudug', 'State', 'MU', '194', null, 'Active');
INSERT INTO `state` VALUES ('3031', 'Nugaal', 'State', 'NU', '194', null, 'Active');
INSERT INTO `state` VALUES ('3032', 'Saneag', 'State', 'SA', '194', null, 'Active');
INSERT INTO `state` VALUES ('3033', 'Shabeellaha Dhexe', 'State', 'SD', '194', null, 'Active');
INSERT INTO `state` VALUES ('3034', 'Shabeellaha Hoose', 'State', 'SH', '194', null, 'Active');
INSERT INTO `state` VALUES ('3035', 'Sool', 'State', 'SO', '194', null, 'Active');
INSERT INTO `state` VALUES ('3036', 'Togdheer', 'State', 'TO', '194', null, 'Active');
INSERT INTO `state` VALUES ('3037', 'Woqooyi Galbeed', 'State', 'WO', '194', null, 'Active');
INSERT INTO `state` VALUES ('3038', 'Brokopondo', 'State', 'BR', '200', null, 'Active');
INSERT INTO `state` VALUES ('3039', 'Commewijne', 'State', 'CM', '200', null, 'Active');
INSERT INTO `state` VALUES ('3040', 'Coronie', 'State', 'CR', '200', null, 'Active');
INSERT INTO `state` VALUES ('3041', 'Marowijne', 'State', 'MA', '200', null, 'Active');
INSERT INTO `state` VALUES ('3042', 'Nickerie', 'State', 'NI', '200', null, 'Active');
INSERT INTO `state` VALUES ('3043', 'Paramaribo', 'State', 'PM', '200', null, 'Active');
INSERT INTO `state` VALUES ('3044', 'Saramacca', 'State', 'SA', '200', null, 'Active');
INSERT INTO `state` VALUES ('3045', 'Sipaliwini', 'State', 'SI', '200', null, 'Active');
INSERT INTO `state` VALUES ('3046', 'Wanica', 'State', 'WA', '200', null, 'Active');
INSERT INTO `state` VALUES ('3047', 'Principe', 'State', 'P', '206', null, 'Active');
INSERT INTO `state` VALUES ('3048', 'Sao Tome', 'State', 'S', '206', null, 'Active');
INSERT INTO `state` VALUES ('3049', 'Ahuachapan', 'State', 'AH', '66', null, 'Active');
INSERT INTO `state` VALUES ('3050', 'Cabanas', 'State', 'CA', '66', null, 'Active');
INSERT INTO `state` VALUES ('3051', 'Cuscatlan', 'State', 'CU', '66', null, 'Active');
INSERT INTO `state` VALUES ('3052', 'Chalatenango', 'State', 'CH', '66', null, 'Active');
INSERT INTO `state` VALUES ('3053', 'Morazan', 'State', 'MO', '66', null, 'Active');
INSERT INTO `state` VALUES ('3054', 'San Miguel', 'State', 'SM', '66', null, 'Active');
INSERT INTO `state` VALUES ('3055', 'San Salvador', 'State', 'SS', '66', null, 'Active');
INSERT INTO `state` VALUES ('3056', 'Santa Ana', 'State', 'SA', '66', null, 'Active');
INSERT INTO `state` VALUES ('3057', 'San Vicente', 'State', 'SV', '66', null, 'Active');
INSERT INTO `state` VALUES ('3058', 'Sonsonate', 'State', 'SO', '66', null, 'Active');
INSERT INTO `state` VALUES ('3059', 'Usulutan', 'State', 'US', '66', null, 'Active');
INSERT INTO `state` VALUES ('3060', 'Al Hasakah', 'State', 'HA', '205', null, 'Active');
INSERT INTO `state` VALUES ('3061', 'Al Ladhiqiyah', 'State', 'LA', '205', null, 'Active');
INSERT INTO `state` VALUES ('3062', 'Al Qunaytirah', 'State', 'QU', '205', null, 'Active');
INSERT INTO `state` VALUES ('3063', 'Ar Raqqah', 'State', 'RA', '205', null, 'Active');
INSERT INTO `state` VALUES ('3064', 'As Suwayda\'', 'State', 'SU', '205', null, 'Active');
INSERT INTO `state` VALUES ('3065', 'Dar\'a', 'State', 'DR', '205', null, 'Active');
INSERT INTO `state` VALUES ('3066', 'Dayr az Zawr', 'State', 'DY', '205', null, 'Active');
INSERT INTO `state` VALUES ('3067', 'Dimashq', 'State', 'DI', '205', null, 'Active');
INSERT INTO `state` VALUES ('3068', 'Halab', 'State', 'HL', '205', null, 'Active');
INSERT INTO `state` VALUES ('3069', 'Hamah', 'State', 'HM', '205', null, 'Active');
INSERT INTO `state` VALUES ('3070', 'Jim\'', 'State', 'HI', '205', null, 'Active');
INSERT INTO `state` VALUES ('3071', 'Idlib', 'State', 'ID', '205', null, 'Active');
INSERT INTO `state` VALUES ('3072', 'Rif Dimashq', 'State', 'RD', '205', null, 'Active');
INSERT INTO `state` VALUES ('3073', 'Tarts', 'State', 'TA', '205', null, 'Active');
INSERT INTO `state` VALUES ('3074', 'Hhohho', 'State', 'HH', '202', null, 'Active');
INSERT INTO `state` VALUES ('3075', 'Lubombo', 'State', 'LU', '202', null, 'Active');
INSERT INTO `state` VALUES ('3076', 'Manzini', 'State', 'MA', '202', null, 'Active');
INSERT INTO `state` VALUES ('3077', 'Shiselweni', 'State', 'SH', '202', null, 'Active');
INSERT INTO `state` VALUES ('3078', 'Batha', 'State', 'BA', '43', null, 'Active');
INSERT INTO `state` VALUES ('3079', 'Biltine', 'State', 'BI', '43', null, 'Active');
INSERT INTO `state` VALUES ('3080', 'Borkou-Ennedi-Tibesti', 'State', 'BET', '43', null, 'Active');
INSERT INTO `state` VALUES ('3081', 'Chari-Baguirmi', 'State', 'CB', '43', null, 'Active');
INSERT INTO `state` VALUES ('3082', 'Guera', 'State', 'GR', '43', null, 'Active');
INSERT INTO `state` VALUES ('3083', 'Kanem', 'State', 'KA', '43', null, 'Active');
INSERT INTO `state` VALUES ('3084', 'Lac', 'State', 'LC', '43', null, 'Active');
INSERT INTO `state` VALUES ('3085', 'Logone-Occidental', 'State', 'LO', '43', null, 'Active');
INSERT INTO `state` VALUES ('3086', 'Logone-Oriental', 'State', 'LR', '43', null, 'Active');
INSERT INTO `state` VALUES ('3087', 'Mayo-Kebbi', 'State', 'MK', '43', null, 'Active');
INSERT INTO `state` VALUES ('3088', 'Moyen-Chari', 'State', 'MC', '43', null, 'Active');
INSERT INTO `state` VALUES ('3089', 'Ouaddai', 'State', 'OD', '43', null, 'Active');
INSERT INTO `state` VALUES ('3090', 'Salamat', 'State', 'SA', '43', null, 'Active');
INSERT INTO `state` VALUES ('3091', 'Tandjile', 'State', 'TA', '43', null, 'Active');
INSERT INTO `state` VALUES ('3092', 'Kara', 'State', 'K', '213', null, 'Active');
INSERT INTO `state` VALUES ('3093', 'Maritime (Region)', 'State', 'M', '213', null, 'Active');
INSERT INTO `state` VALUES ('3094', 'Savannes', 'State', 'S', '213', null, 'Active');
INSERT INTO `state` VALUES ('3095', 'Krung Thep Maha Nakhon Bangkok', 'State', '10', '210', null, 'Active');
INSERT INTO `state` VALUES ('3096', 'Phatthaya', 'State', 'S', '210', null, 'Active');
INSERT INTO `state` VALUES ('3097', 'Amnat Charoen', 'State', '37', '210', null, 'Active');
INSERT INTO `state` VALUES ('3098', 'Ang Thong', 'State', '15', '210', null, 'Active');
INSERT INTO `state` VALUES ('3099', 'Buri Ram', 'State', '31', '210', null, 'Active');
INSERT INTO `state` VALUES ('3100', 'Chachoengsao', 'State', '24', '210', null, 'Active');
INSERT INTO `state` VALUES ('3101', 'Chai Nat', 'State', '18', '210', null, 'Active');
INSERT INTO `state` VALUES ('3102', 'Chaiyaphum', 'State', '36', '210', null, 'Active');
INSERT INTO `state` VALUES ('3103', 'Chanthaburi', 'State', '22', '210', null, 'Active');
INSERT INTO `state` VALUES ('3104', 'Chiang Mai', 'State', '50', '210', null, 'Active');
INSERT INTO `state` VALUES ('3105', 'Chiang Rai', 'State', '57', '210', null, 'Active');
INSERT INTO `state` VALUES ('3106', 'Chon Buri', 'State', '20', '210', null, 'Active');
INSERT INTO `state` VALUES ('3107', 'Chumphon', 'State', '86', '210', null, 'Active');
INSERT INTO `state` VALUES ('3108', 'Kalasin', 'State', '46', '210', null, 'Active');
INSERT INTO `state` VALUES ('3109', 'Kamphasng Phet', 'State', '62', '210', null, 'Active');
INSERT INTO `state` VALUES ('3110', 'Kanchanaburi', 'State', '71', '210', null, 'Active');
INSERT INTO `state` VALUES ('3111', 'Khon Kaen', 'State', '40', '210', null, 'Active');
INSERT INTO `state` VALUES ('3112', 'Krabi', 'State', '81', '210', null, 'Active');
INSERT INTO `state` VALUES ('3113', 'Lampang', 'State', '52', '210', null, 'Active');
INSERT INTO `state` VALUES ('3114', 'Lamphun', 'State', '51', '210', null, 'Active');
INSERT INTO `state` VALUES ('3115', 'Loei', 'State', '42', '210', null, 'Active');
INSERT INTO `state` VALUES ('3116', 'Lop Buri', 'State', '16', '210', null, 'Active');
INSERT INTO `state` VALUES ('3117', 'Mae Hong Son', 'State', '58', '210', null, 'Active');
INSERT INTO `state` VALUES ('3118', 'Maha Sarakham', 'State', '44', '210', null, 'Active');
INSERT INTO `state` VALUES ('3119', 'Mukdahan', 'State', '49', '210', null, 'Active');
INSERT INTO `state` VALUES ('3120', 'Nakhon Nayok', 'State', '26', '210', null, 'Active');
INSERT INTO `state` VALUES ('3121', 'Nakhon Pathom', 'State', '73', '210', null, 'Active');
INSERT INTO `state` VALUES ('3122', 'Nakhon Phanom', 'State', '48', '210', null, 'Active');
INSERT INTO `state` VALUES ('3123', 'Nakhon Ratchasima', 'State', '30', '210', null, 'Active');
INSERT INTO `state` VALUES ('3124', 'Nakhon Sawan', 'State', '60', '210', null, 'Active');
INSERT INTO `state` VALUES ('3125', 'Nakhon Si Thammarat', 'State', '80', '210', null, 'Active');
INSERT INTO `state` VALUES ('3126', 'Nan', 'State', '55', '210', null, 'Active');
INSERT INTO `state` VALUES ('3127', 'Narathiwat', 'State', '96', '210', null, 'Active');
INSERT INTO `state` VALUES ('3128', 'Nong Bua Lam Phu', 'State', '39', '210', null, 'Active');
INSERT INTO `state` VALUES ('3129', 'Nong Khai', 'State', '43', '210', null, 'Active');
INSERT INTO `state` VALUES ('3130', 'Nonthaburi', 'State', '12', '210', null, 'Active');
INSERT INTO `state` VALUES ('3131', 'Pathum Thani', 'State', '13', '210', null, 'Active');
INSERT INTO `state` VALUES ('3132', 'Pattani', 'State', '94', '210', null, 'Active');
INSERT INTO `state` VALUES ('3133', 'Phangnga', 'State', '82', '210', null, 'Active');
INSERT INTO `state` VALUES ('3134', 'Phatthalung', 'State', '93', '210', null, 'Active');
INSERT INTO `state` VALUES ('3135', 'Phayao', 'State', '56', '210', null, 'Active');
INSERT INTO `state` VALUES ('3136', 'Phetchabun', 'State', '67', '210', null, 'Active');
INSERT INTO `state` VALUES ('3137', 'Phetchaburi', 'State', '76', '210', null, 'Active');
INSERT INTO `state` VALUES ('3138', 'Phichit', 'State', '66', '210', null, 'Active');
INSERT INTO `state` VALUES ('3139', 'Phitsanulok', 'State', '65', '210', null, 'Active');
INSERT INTO `state` VALUES ('3140', 'Phrae', 'State', '54', '210', null, 'Active');
INSERT INTO `state` VALUES ('3141', 'Phra Nakhon Si Ayutthaya', 'State', '14', '210', null, 'Active');
INSERT INTO `state` VALUES ('3142', 'Phaket', 'State', '83', '210', null, 'Active');
INSERT INTO `state` VALUES ('3143', 'Prachin Buri', 'State', '25', '210', null, 'Active');
INSERT INTO `state` VALUES ('3144', 'Prachuap Khiri Khan', 'State', '77', '210', null, 'Active');
INSERT INTO `state` VALUES ('3145', 'Ranong', 'State', '85', '210', null, 'Active');
INSERT INTO `state` VALUES ('3146', 'Ratchaburi', 'State', '70', '210', null, 'Active');
INSERT INTO `state` VALUES ('3147', 'Rayong', 'State', '21', '210', null, 'Active');
INSERT INTO `state` VALUES ('3148', 'Roi Et', 'State', '45', '210', null, 'Active');
INSERT INTO `state` VALUES ('3149', 'Sa Kaeo', 'State', '27', '210', null, 'Active');
INSERT INTO `state` VALUES ('3150', 'Sakon Nakhon', 'State', '47', '210', null, 'Active');
INSERT INTO `state` VALUES ('3151', 'Samut Prakan', 'State', '11', '210', null, 'Active');
INSERT INTO `state` VALUES ('3152', 'Samut Sakhon', 'State', '74', '210', null, 'Active');
INSERT INTO `state` VALUES ('3153', 'Samut Songkhram', 'State', '75', '210', null, 'Active');
INSERT INTO `state` VALUES ('3154', 'Saraburi', 'State', '19', '210', null, 'Active');
INSERT INTO `state` VALUES ('3155', 'Satun', 'State', '91', '210', null, 'Active');
INSERT INTO `state` VALUES ('3156', 'Sing Buri', 'State', '17', '210', null, 'Active');
INSERT INTO `state` VALUES ('3157', 'Si Sa Ket', 'State', '33', '210', null, 'Active');
INSERT INTO `state` VALUES ('3158', 'Songkhla', 'State', '90', '210', null, 'Active');
INSERT INTO `state` VALUES ('3159', 'Sukhothai', 'State', '64', '210', null, 'Active');
INSERT INTO `state` VALUES ('3160', 'Suphan Buri', 'State', '72', '210', null, 'Active');
INSERT INTO `state` VALUES ('3161', 'Surat Thani', 'State', '84', '210', null, 'Active');
INSERT INTO `state` VALUES ('3162', 'Surin', 'State', '32', '210', null, 'Active');
INSERT INTO `state` VALUES ('3163', 'Tak', 'State', '63', '210', null, 'Active');
INSERT INTO `state` VALUES ('3164', 'Trang', 'State', '92', '210', null, 'Active');
INSERT INTO `state` VALUES ('3165', 'Trat', 'State', '23', '210', null, 'Active');
INSERT INTO `state` VALUES ('3166', 'Ubon Ratchathani', 'State', '34', '210', null, 'Active');
INSERT INTO `state` VALUES ('3167', 'Udon Thani', 'State', '41', '210', null, 'Active');
INSERT INTO `state` VALUES ('3168', 'Uthai Thani', 'State', '61', '210', null, 'Active');
INSERT INTO `state` VALUES ('3169', 'Uttaradit', 'State', '53', '210', null, 'Active');
INSERT INTO `state` VALUES ('3170', 'Yala', 'State', '95', '210', null, 'Active');
INSERT INTO `state` VALUES ('3171', 'Yasothon', 'State', '35', '210', null, 'Active');
INSERT INTO `state` VALUES ('3172', 'Sughd', 'State', 'SU', '208', null, 'Active');
INSERT INTO `state` VALUES ('3173', 'Khatlon', 'State', 'KT', '208', null, 'Active');
INSERT INTO `state` VALUES ('3174', 'Gorno-Badakhshan', 'State', 'GB', '208', null, 'Active');
INSERT INTO `state` VALUES ('3175', 'Ahal', 'State', 'A', '219', null, 'Active');
INSERT INTO `state` VALUES ('3176', 'Balkan', 'State', 'B', '219', null, 'Active');
INSERT INTO `state` VALUES ('3177', 'Dasoguz', 'State', 'D', '219', null, 'Active');
INSERT INTO `state` VALUES ('3178', 'Lebap', 'State', 'L', '219', null, 'Active');
INSERT INTO `state` VALUES ('3179', 'Mary', 'State', 'M', '219', null, 'Active');
INSERT INTO `state` VALUES ('3180', 'Béja', 'State', '31', '217', null, 'Active');
INSERT INTO `state` VALUES ('3181', 'Ben Arous', 'State', '13', '217', null, 'Active');
INSERT INTO `state` VALUES ('3182', 'Bizerte', 'State', '23', '217', null, 'Active');
INSERT INTO `state` VALUES ('3183', 'Gabès', 'State', '81', '217', null, 'Active');
INSERT INTO `state` VALUES ('3184', 'Gafsa', 'State', '71', '217', null, 'Active');
INSERT INTO `state` VALUES ('3185', 'Jendouba', 'State', '32', '217', null, 'Active');
INSERT INTO `state` VALUES ('3186', 'Kairouan', 'State', '41', '217', null, 'Active');
INSERT INTO `state` VALUES ('3187', 'Rasserine', 'State', '42', '217', null, 'Active');
INSERT INTO `state` VALUES ('3188', 'Kebili', 'State', '73', '217', null, 'Active');
INSERT INTO `state` VALUES ('3189', 'L\'Ariana', 'State', '12', '217', null, 'Active');
INSERT INTO `state` VALUES ('3190', 'Le Ref', 'State', '33', '217', null, 'Active');
INSERT INTO `state` VALUES ('3191', 'Mahdia', 'State', '53', '217', null, 'Active');
INSERT INTO `state` VALUES ('3192', 'La Manouba', 'State', '14', '217', null, 'Active');
INSERT INTO `state` VALUES ('3193', 'Medenine', 'State', '82', '217', null, 'Active');
INSERT INTO `state` VALUES ('3194', 'Moneatir', 'State', '52', '217', null, 'Active');
INSERT INTO `state` VALUES ('3195', 'Naboul', 'State', '21', '217', null, 'Active');
INSERT INTO `state` VALUES ('3196', 'Sfax', 'State', '61', '217', null, 'Active');
INSERT INTO `state` VALUES ('3197', 'Sidi Bouxid', 'State', '43', '217', null, 'Active');
INSERT INTO `state` VALUES ('3198', 'Siliana', 'State', '34', '217', null, 'Active');
INSERT INTO `state` VALUES ('3199', 'Sousse', 'State', '51', '217', null, 'Active');
INSERT INTO `state` VALUES ('3200', 'Tataouine', 'State', '83', '217', null, 'Active');
INSERT INTO `state` VALUES ('3201', 'Tozeur', 'State', '72', '217', null, 'Active');
INSERT INTO `state` VALUES ('3202', 'Tunis', 'State', '11', '217', null, 'Active');
INSERT INTO `state` VALUES ('3203', 'Zaghouan', 'State', '22', '217', null, 'Active');
INSERT INTO `state` VALUES ('3204', 'Adana', 'State', '01', '218', null, 'Active');
INSERT INTO `state` VALUES ('3205', 'Ad yaman', 'State', '02', '218', null, 'Active');
INSERT INTO `state` VALUES ('3206', 'Afyon', 'State', '03', '218', null, 'Active');
INSERT INTO `state` VALUES ('3207', 'Ag r', 'State', '04', '218', null, 'Active');
INSERT INTO `state` VALUES ('3208', 'Aksaray', 'State', '68', '218', null, 'Active');
INSERT INTO `state` VALUES ('3209', 'Amasya', 'State', '05', '218', null, 'Active');
INSERT INTO `state` VALUES ('3210', 'Ankara', 'State', '06', '218', null, 'Active');
INSERT INTO `state` VALUES ('3211', 'Antalya', 'State', '07', '218', null, 'Active');
INSERT INTO `state` VALUES ('3212', 'Ardahan', 'State', '75', '218', null, 'Active');
INSERT INTO `state` VALUES ('3213', 'Artvin', 'State', '08', '218', null, 'Active');
INSERT INTO `state` VALUES ('3214', 'Aydin', 'State', '09', '218', null, 'Active');
INSERT INTO `state` VALUES ('3215', 'Bal kesir', 'State', '10', '218', null, 'Active');
INSERT INTO `state` VALUES ('3216', 'Bartin', 'State', '74', '218', null, 'Active');
INSERT INTO `state` VALUES ('3217', 'Batman', 'State', '72', '218', null, 'Active');
INSERT INTO `state` VALUES ('3218', 'Bayburt', 'State', '69', '218', null, 'Active');
INSERT INTO `state` VALUES ('3219', 'Bilecik', 'State', '11', '218', null, 'Active');
INSERT INTO `state` VALUES ('3220', 'Bingol', 'State', '12', '218', null, 'Active');
INSERT INTO `state` VALUES ('3221', 'Bitlis', 'State', '13', '218', null, 'Active');
INSERT INTO `state` VALUES ('3222', 'Bolu', 'State', '14', '218', null, 'Active');
INSERT INTO `state` VALUES ('3223', 'Burdur', 'State', '15', '218', null, 'Active');
INSERT INTO `state` VALUES ('3224', 'Bursa', 'State', '16', '218', null, 'Active');
INSERT INTO `state` VALUES ('3225', 'Canakkale', 'State', '17', '218', null, 'Active');
INSERT INTO `state` VALUES ('3226', 'Cankir', 'State', '18', '218', null, 'Active');
INSERT INTO `state` VALUES ('3227', 'Corum', 'State', '19', '218', null, 'Active');
INSERT INTO `state` VALUES ('3228', 'Denizli', 'State', '20', '218', null, 'Active');
INSERT INTO `state` VALUES ('3229', 'Diyarbakir', 'State', '21', '218', null, 'Active');
INSERT INTO `state` VALUES ('3230', 'Duzce', 'State', '81', '218', null, 'Active');
INSERT INTO `state` VALUES ('3231', 'Edirne', 'State', '22', '218', null, 'Active');
INSERT INTO `state` VALUES ('3232', 'Elazig', 'State', '23', '218', null, 'Active');
INSERT INTO `state` VALUES ('3233', 'Erzincan', 'State', '24', '218', null, 'Active');
INSERT INTO `state` VALUES ('3234', 'Erzurum', 'State', '25', '218', null, 'Active');
INSERT INTO `state` VALUES ('3235', 'Eskis\'ehir', 'State', '26', '218', null, 'Active');
INSERT INTO `state` VALUES ('3236', 'Gaziantep', 'State', '27', '218', null, 'Active');
INSERT INTO `state` VALUES ('3237', 'Giresun', 'State', '28', '218', null, 'Active');
INSERT INTO `state` VALUES ('3238', 'Gms\'hane', 'State', '29', '218', null, 'Active');
INSERT INTO `state` VALUES ('3239', 'Hakkari', 'State', '30', '218', null, 'Active');
INSERT INTO `state` VALUES ('3240', 'Hatay', 'State', '31', '218', null, 'Active');
INSERT INTO `state` VALUES ('3241', 'Igidir', 'State', '76', '218', null, 'Active');
INSERT INTO `state` VALUES ('3242', 'Isparta', 'State', '32', '218', null, 'Active');
INSERT INTO `state` VALUES ('3243', 'Icel', 'State', '33', '218', null, 'Active');
INSERT INTO `state` VALUES ('3244', 'Istanbul', 'State', '34', '218', null, 'Active');
INSERT INTO `state` VALUES ('3245', 'Izmir', 'State', '35', '218', null, 'Active');
INSERT INTO `state` VALUES ('3246', 'Kahramanmaras', 'State', '46', '218', null, 'Active');
INSERT INTO `state` VALUES ('3247', 'Karabk', 'State', '78', '218', null, 'Active');
INSERT INTO `state` VALUES ('3248', 'Karaman', 'State', '70', '218', null, 'Active');
INSERT INTO `state` VALUES ('3249', 'Kars', 'State', '36', '218', null, 'Active');
INSERT INTO `state` VALUES ('3250', 'Kastamonu', 'State', '37', '218', null, 'Active');
INSERT INTO `state` VALUES ('3251', 'Kayseri', 'State', '38', '218', null, 'Active');
INSERT INTO `state` VALUES ('3252', 'Kirikkale', 'State', '71', '218', null, 'Active');
INSERT INTO `state` VALUES ('3253', 'Kirklareli', 'State', '39', '218', null, 'Active');
INSERT INTO `state` VALUES ('3254', 'Kirs\'ehir', 'State', '40', '218', null, 'Active');
INSERT INTO `state` VALUES ('3255', 'Kilis', 'State', '79', '218', null, 'Active');
INSERT INTO `state` VALUES ('3256', 'Kocaeli', 'State', '41', '218', null, 'Active');
INSERT INTO `state` VALUES ('3257', 'Konya', 'State', '42', '218', null, 'Active');
INSERT INTO `state` VALUES ('3258', 'Ktahya', 'State', '43', '218', null, 'Active');
INSERT INTO `state` VALUES ('3259', 'Malatya', 'State', '44', '218', null, 'Active');
INSERT INTO `state` VALUES ('3260', 'Manisa', 'State', '45', '218', null, 'Active');
INSERT INTO `state` VALUES ('3261', 'Mardin', 'State', '47', '218', null, 'Active');
INSERT INTO `state` VALUES ('3262', 'Mugila', 'State', '48', '218', null, 'Active');
INSERT INTO `state` VALUES ('3263', 'Mus', 'State', '49', '218', null, 'Active');
INSERT INTO `state` VALUES ('3264', 'Nevs\'ehir', 'State', '50', '218', null, 'Active');
INSERT INTO `state` VALUES ('3265', 'Nigide', 'State', '51', '218', null, 'Active');
INSERT INTO `state` VALUES ('3266', 'Ordu', 'State', '52', '218', null, 'Active');
INSERT INTO `state` VALUES ('3267', 'Osmaniye', 'State', '80', '218', null, 'Active');
INSERT INTO `state` VALUES ('3268', 'Rize', 'State', '53', '218', null, 'Active');
INSERT INTO `state` VALUES ('3269', 'Sakarya', 'State', '54', '218', null, 'Active');
INSERT INTO `state` VALUES ('3270', 'Samsun', 'State', '55', '218', null, 'Active');
INSERT INTO `state` VALUES ('3271', 'Siirt', 'State', '56', '218', null, 'Active');
INSERT INTO `state` VALUES ('3272', 'Sinop', 'State', '57', '218', null, 'Active');
INSERT INTO `state` VALUES ('3273', 'Sivas', 'State', '58', '218', null, 'Active');
INSERT INTO `state` VALUES ('3274', 'S\'anliurfa', 'State', '63', '218', null, 'Active');
INSERT INTO `state` VALUES ('3275', 'S\'rnak', 'State', '73', '218', null, 'Active');
INSERT INTO `state` VALUES ('3276', 'Tekirdag', 'State', '59', '218', null, 'Active');
INSERT INTO `state` VALUES ('3277', 'Tokat', 'State', '60', '218', null, 'Active');
INSERT INTO `state` VALUES ('3278', 'Trabzon', 'State', '61', '218', null, 'Active');
INSERT INTO `state` VALUES ('3279', 'Tunceli', 'State', '62', '218', null, 'Active');
INSERT INTO `state` VALUES ('3280', 'Us\'ak', 'State', '64', '218', null, 'Active');
INSERT INTO `state` VALUES ('3281', 'Van', 'State', '65', '218', null, 'Active');
INSERT INTO `state` VALUES ('3282', 'Yalova', 'State', '77', '218', null, 'Active');
INSERT INTO `state` VALUES ('3283', 'Yozgat', 'State', '66', '218', null, 'Active');
INSERT INTO `state` VALUES ('3284', 'Zonguldak', 'State', '67', '218', null, 'Active');
INSERT INTO `state` VALUES ('3285', 'Couva-Tabaquite-Talparo', 'State', 'CTT', '216', null, 'Active');
INSERT INTO `state` VALUES ('3286', 'Diego Martin', 'State', 'DMN', '216', null, 'Active');
INSERT INTO `state` VALUES ('3287', 'Eastern Tobago', 'State', 'ETO', '216', null, 'Active');
INSERT INTO `state` VALUES ('3288', 'Penal-Debe', 'State', 'PED', '216', null, 'Active');
INSERT INTO `state` VALUES ('3289', 'Princes Town', 'State', 'PRT', '216', null, 'Active');
INSERT INTO `state` VALUES ('3290', 'Rio Claro-Mayaro', 'State', 'RCM', '216', null, 'Active');
INSERT INTO `state` VALUES ('3291', 'Sangre Grande', 'State', 'SGE', '216', null, 'Active');
INSERT INTO `state` VALUES ('3292', 'San Juan-Laventille', 'State', 'SJL', '216', null, 'Active');
INSERT INTO `state` VALUES ('3293', 'Siparia', 'State', 'SIP', '216', null, 'Active');
INSERT INTO `state` VALUES ('3294', 'Tunapuna-Piarco', 'State', 'TUP', '216', null, 'Active');
INSERT INTO `state` VALUES ('3295', 'Western Tobago', 'State', 'WTO', '216', null, 'Active');
INSERT INTO `state` VALUES ('3296', 'Arima', 'State', 'ARI', '216', null, 'Active');
INSERT INTO `state` VALUES ('3297', 'Chaguanas', 'State', 'CHA', '216', null, 'Active');
INSERT INTO `state` VALUES ('3298', 'Point Fortin', 'State', 'PTF', '216', null, 'Active');
INSERT INTO `state` VALUES ('3299', 'Port of Spain', 'State', 'POS', '216', null, 'Active');
INSERT INTO `state` VALUES ('3300', 'San Fernando', 'State', 'SFO', '216', null, 'Active');
INSERT INTO `state` VALUES ('3301', 'Aileu', 'State', 'AL', '63', null, 'Active');
INSERT INTO `state` VALUES ('3302', 'Ainaro', 'State', 'AN', '63', null, 'Active');
INSERT INTO `state` VALUES ('3303', 'Bacucau', 'State', 'BA', '63', null, 'Active');
INSERT INTO `state` VALUES ('3304', 'Bobonaro', 'State', 'BO', '63', null, 'Active');
INSERT INTO `state` VALUES ('3305', 'Cova Lima', 'State', 'CO', '63', null, 'Active');
INSERT INTO `state` VALUES ('3306', 'Dili', 'State', 'DI', '63', null, 'Active');
INSERT INTO `state` VALUES ('3307', 'Ermera', 'State', 'ER', '63', null, 'Active');
INSERT INTO `state` VALUES ('3308', 'Laulem', 'State', 'LA', '63', null, 'Active');
INSERT INTO `state` VALUES ('3309', 'Liquica', 'State', 'LI', '63', null, 'Active');
INSERT INTO `state` VALUES ('3310', 'Manatuto', 'State', 'MT', '63', null, 'Active');
INSERT INTO `state` VALUES ('3311', 'Manafahi', 'State', 'MF', '63', null, 'Active');
INSERT INTO `state` VALUES ('3312', 'Oecussi', 'State', 'OE', '63', null, 'Active');
INSERT INTO `state` VALUES ('3313', 'Viqueque', 'State', 'VI', '63', null, 'Active');
INSERT INTO `state` VALUES ('3314', 'Changhua', 'State', 'CHA', '207', null, 'Active');
INSERT INTO `state` VALUES ('3315', 'Chiayi', 'State', 'CYQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3316', 'Hsinchu', 'State', 'HSQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3317', 'Hualien', 'State', 'HUA', '207', null, 'Active');
INSERT INTO `state` VALUES ('3318', 'Ilan', 'State', 'ILA', '207', null, 'Active');
INSERT INTO `state` VALUES ('3319', 'Kaohsiung', 'State', 'KHQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3320', 'Miaoli', 'State', 'MIA', '207', null, 'Active');
INSERT INTO `state` VALUES ('3321', 'Nantou', 'State', 'NAN', '207', null, 'Active');
INSERT INTO `state` VALUES ('3322', 'Penghu', 'State', 'PEN', '207', null, 'Active');
INSERT INTO `state` VALUES ('3323', 'Pingtung', 'State', 'PIF', '207', null, 'Active');
INSERT INTO `state` VALUES ('3324', 'Taichung', 'State', 'TXQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3325', 'Tainan', 'State', 'TNQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3326', 'Taipei', 'State', 'TPQ', '207', null, 'Active');
INSERT INTO `state` VALUES ('3327', 'Taitung', 'State', 'TTT', '207', null, 'Active');
INSERT INTO `state` VALUES ('3328', 'Taoyuan', 'State', 'TAO', '207', null, 'Active');
INSERT INTO `state` VALUES ('3329', 'Yunlin', 'State', 'YUN', '207', null, 'Active');
INSERT INTO `state` VALUES ('3330', 'Keelung', 'State', 'KEE', '207', null, 'Active');
INSERT INTO `state` VALUES ('3331', 'Arusha', 'State', '01', '209', null, 'Active');
INSERT INTO `state` VALUES ('3332', 'Dar-es-Salaam', 'State', '02', '209', null, 'Active');
INSERT INTO `state` VALUES ('3333', 'Dodoma', 'State', '03', '209', null, 'Active');
INSERT INTO `state` VALUES ('3334', 'Iringa', 'State', '04', '209', null, 'Active');
INSERT INTO `state` VALUES ('3335', 'Kagera', 'State', '05', '209', null, 'Active');
INSERT INTO `state` VALUES ('3336', 'Kaskazini Pemba', 'State', '06', '209', null, 'Active');
INSERT INTO `state` VALUES ('3337', 'Kaskazini Unguja', 'State', '07', '209', null, 'Active');
INSERT INTO `state` VALUES ('3338', 'Xigoma', 'State', '08', '209', null, 'Active');
INSERT INTO `state` VALUES ('3339', 'Kilimanjaro', 'State', '09', '209', null, 'Active');
INSERT INTO `state` VALUES ('3340', 'Rusini Pemba', 'State', '10', '209', null, 'Active');
INSERT INTO `state` VALUES ('3341', 'Kusini Unguja', 'State', '11', '209', null, 'Active');
INSERT INTO `state` VALUES ('3342', 'Lindi', 'State', '12', '209', null, 'Active');
INSERT INTO `state` VALUES ('3343', 'Manyara', 'State', '26', '209', null, 'Active');
INSERT INTO `state` VALUES ('3344', 'Mara', 'State', '13', '209', null, 'Active');
INSERT INTO `state` VALUES ('3345', 'Mbeya', 'State', '14', '209', null, 'Active');
INSERT INTO `state` VALUES ('3346', 'Mjini Magharibi', 'State', '15', '209', null, 'Active');
INSERT INTO `state` VALUES ('3347', 'Morogoro', 'State', '16', '209', null, 'Active');
INSERT INTO `state` VALUES ('3348', 'Mtwara', 'State', '17', '209', null, 'Active');
INSERT INTO `state` VALUES ('3349', 'Pwani', 'State', '19', '209', null, 'Active');
INSERT INTO `state` VALUES ('3350', 'Rukwa', 'State', '20', '209', null, 'Active');
INSERT INTO `state` VALUES ('3351', 'Ruvuma', 'State', '21', '209', null, 'Active');
INSERT INTO `state` VALUES ('3352', 'Shinyanga', 'State', '22', '209', null, 'Active');
INSERT INTO `state` VALUES ('3353', 'Singida', 'State', '23', '209', null, 'Active');
INSERT INTO `state` VALUES ('3354', 'Tabora', 'State', '24', '209', null, 'Active');
INSERT INTO `state` VALUES ('3355', 'Tanga', 'State', '25', '209', null, 'Active');
INSERT INTO `state` VALUES ('3356', 'Cherkas\'ka Oblast\'', 'State', '71', '223', null, 'Active');
INSERT INTO `state` VALUES ('3357', 'Chernihivs\'ka Oblast\'', 'State', '74', '223', null, 'Active');
INSERT INTO `state` VALUES ('3358', 'Chernivets\'ka Oblast\'', 'State', '77', '223', null, 'Active');
INSERT INTO `state` VALUES ('3359', 'Dnipropetrovs\'ka Oblast\'', 'State', '12', '223', null, 'Active');
INSERT INTO `state` VALUES ('3360', 'Donets\'ka Oblast\'', 'State', '14', '223', null, 'Active');
INSERT INTO `state` VALUES ('3361', 'Ivano-Frankivs\'ka Oblast\'', 'State', '26', '223', null, 'Active');
INSERT INTO `state` VALUES ('3362', 'Kharkivs\'ka Oblast\'', 'State', '63', '223', null, 'Active');
INSERT INTO `state` VALUES ('3363', 'Khersons\'ka Oblast\'', 'State', '65', '223', null, 'Active');
INSERT INTO `state` VALUES ('3364', 'Khmel\'nyts\'ka Oblast\'', 'State', '68', '223', null, 'Active');
INSERT INTO `state` VALUES ('3365', 'Kirovohrads\'ka Oblast\'', 'State', '35', '223', null, 'Active');
INSERT INTO `state` VALUES ('3366', 'Kyivs\'ka Oblast\'', 'State', '32', '223', null, 'Active');
INSERT INTO `state` VALUES ('3367', 'Luhans\'ka Oblast\'', 'State', '09', '223', null, 'Active');
INSERT INTO `state` VALUES ('3368', 'L\'vivs\'ka Oblast\'', 'State', '46', '223', null, 'Active');
INSERT INTO `state` VALUES ('3369', 'Mykolaivs\'ka Oblast\'', 'State', '48', '223', null, 'Active');
INSERT INTO `state` VALUES ('3370', 'Odes \'ka Oblast\'', 'State', '51', '223', null, 'Active');
INSERT INTO `state` VALUES ('3371', 'Poltavs\'ka Oblast\'', 'State', '53', '223', null, 'Active');
INSERT INTO `state` VALUES ('3372', 'Rivnens\'ka Oblast\'', 'State', '56', '223', null, 'Active');
INSERT INTO `state` VALUES ('3373', 'Sums \'ka Oblast\'', 'State', '59', '223', null, 'Active');
INSERT INTO `state` VALUES ('3374', 'Ternopil\'s\'ka Oblast\'', 'State', '61', '223', null, 'Active');
INSERT INTO `state` VALUES ('3375', 'Vinnyts\'ka Oblast\'', 'State', '05', '223', null, 'Active');
INSERT INTO `state` VALUES ('3376', 'Volyos\'ka Oblast\'', 'State', '07', '223', null, 'Active');
INSERT INTO `state` VALUES ('3377', 'Zakarpats\'ka Oblast\'', 'State', '21', '223', null, 'Active');
INSERT INTO `state` VALUES ('3378', 'Zaporiz\'ka Oblast\'', 'State', '23', '223', null, 'Active');
INSERT INTO `state` VALUES ('3379', 'Zhytomyrs\'ka Oblast\'', 'State', '18', '223', null, 'Active');
INSERT INTO `state` VALUES ('3380', 'Respublika Krym', 'State', '43', '223', null, 'Active');
INSERT INTO `state` VALUES ('3381', 'Kyiv', 'State', '30', '223', null, 'Active');
INSERT INTO `state` VALUES ('3382', 'Sevastopol', 'State', '40', '223', null, 'Active');
INSERT INTO `state` VALUES ('3383', 'Adjumani', 'State', '301', '222', null, 'Active');
INSERT INTO `state` VALUES ('3384', 'Apac', 'State', '302', '222', null, 'Active');
INSERT INTO `state` VALUES ('3385', 'Arua', 'State', '303', '222', null, 'Active');
INSERT INTO `state` VALUES ('3386', 'Bugiri', 'State', '201', '222', null, 'Active');
INSERT INTO `state` VALUES ('3387', 'Bundibugyo', 'State', '401', '222', null, 'Active');
INSERT INTO `state` VALUES ('3388', 'Bushenyi', 'State', '402', '222', null, 'Active');
INSERT INTO `state` VALUES ('3389', 'Busia', 'State', '202', '222', null, 'Active');
INSERT INTO `state` VALUES ('3390', 'Gulu', 'State', '304', '222', null, 'Active');
INSERT INTO `state` VALUES ('3391', 'Hoima', 'State', '403', '222', null, 'Active');
INSERT INTO `state` VALUES ('3392', 'Iganga', 'State', '203', '222', null, 'Active');
INSERT INTO `state` VALUES ('3393', 'Jinja', 'State', '204', '222', null, 'Active');
INSERT INTO `state` VALUES ('3394', 'Kabale', 'State', '404', '222', null, 'Active');
INSERT INTO `state` VALUES ('3395', 'Kabarole', 'State', '405', '222', null, 'Active');
INSERT INTO `state` VALUES ('3396', 'Kaberamaido', 'State', '213', '222', null, 'Active');
INSERT INTO `state` VALUES ('3397', 'Kalangala', 'State', '101', '222', null, 'Active');
INSERT INTO `state` VALUES ('3398', 'Kampala', 'State', '102', '222', null, 'Active');
INSERT INTO `state` VALUES ('3399', 'Kamuli', 'State', '205', '222', null, 'Active');
INSERT INTO `state` VALUES ('3400', 'Kamwenge', 'State', '413', '222', null, 'Active');
INSERT INTO `state` VALUES ('3401', 'Kanungu', 'State', '414', '222', null, 'Active');
INSERT INTO `state` VALUES ('3402', 'Kapchorwa', 'State', '206', '222', null, 'Active');
INSERT INTO `state` VALUES ('3403', 'Kasese', 'State', '406', '222', null, 'Active');
INSERT INTO `state` VALUES ('3404', 'Katakwi', 'State', '207', '222', null, 'Active');
INSERT INTO `state` VALUES ('3405', 'Kayunga', 'State', '112', '222', null, 'Active');
INSERT INTO `state` VALUES ('3406', 'Kibaale', 'State', '407', '222', null, 'Active');
INSERT INTO `state` VALUES ('3407', 'Kiboga', 'State', '103', '222', null, 'Active');
INSERT INTO `state` VALUES ('3408', 'Kisoro', 'State', '408', '222', null, 'Active');
INSERT INTO `state` VALUES ('3409', 'Kitgum', 'State', '305', '222', null, 'Active');
INSERT INTO `state` VALUES ('3410', 'Kotido', 'State', '306', '222', null, 'Active');
INSERT INTO `state` VALUES ('3411', 'Kumi', 'State', '208', '222', null, 'Active');
INSERT INTO `state` VALUES ('3412', 'Kyenjojo', 'State', '415', '222', null, 'Active');
INSERT INTO `state` VALUES ('3413', 'Lira', 'State', '307', '222', null, 'Active');
INSERT INTO `state` VALUES ('3414', 'Luwero', 'State', '104', '222', null, 'Active');
INSERT INTO `state` VALUES ('3415', 'Masaka', 'State', '105', '222', null, 'Active');
INSERT INTO `state` VALUES ('3416', 'Masindi', 'State', '409', '222', null, 'Active');
INSERT INTO `state` VALUES ('3417', 'Mayuge', 'State', '214', '222', null, 'Active');
INSERT INTO `state` VALUES ('3418', 'Mbale', 'State', '209', '222', null, 'Active');
INSERT INTO `state` VALUES ('3419', 'Mbarara', 'State', '410', '222', null, 'Active');
INSERT INTO `state` VALUES ('3420', 'Moroto', 'State', '308', '222', null, 'Active');
INSERT INTO `state` VALUES ('3421', 'Moyo', 'State', '309', '222', null, 'Active');
INSERT INTO `state` VALUES ('3422', 'Mpigi', 'State', '106', '222', null, 'Active');
INSERT INTO `state` VALUES ('3423', 'Mubende', 'State', '107', '222', null, 'Active');
INSERT INTO `state` VALUES ('3424', 'Mukono', 'State', '108', '222', null, 'Active');
INSERT INTO `state` VALUES ('3425', 'Nakapiripirit', 'State', '311', '222', null, 'Active');
INSERT INTO `state` VALUES ('3426', 'Nakasongola', 'State', '109', '222', null, 'Active');
INSERT INTO `state` VALUES ('3427', 'Nebbi', 'State', '310', '222', null, 'Active');
INSERT INTO `state` VALUES ('3428', 'Ntungamo', 'State', '411', '222', null, 'Active');
INSERT INTO `state` VALUES ('3429', 'Pader', 'State', '312', '222', null, 'Active');
INSERT INTO `state` VALUES ('3430', 'Pallisa', 'State', '210', '222', null, 'Active');
INSERT INTO `state` VALUES ('3431', 'Rakai', 'State', '110', '222', null, 'Active');
INSERT INTO `state` VALUES ('3432', 'Rukungiri', 'State', '412', '222', null, 'Active');
INSERT INTO `state` VALUES ('3433', 'Sembabule', 'State', '111', '222', null, 'Active');
INSERT INTO `state` VALUES ('3434', 'Sironko', 'State', '215', '222', null, 'Active');
INSERT INTO `state` VALUES ('3435', 'Soroti', 'State', '211', '222', null, 'Active');
INSERT INTO `state` VALUES ('3436', 'Tororo', 'State', '212', '222', null, 'Active');
INSERT INTO `state` VALUES ('3437', 'Wakiso', 'State', '113', '222', null, 'Active');
INSERT INTO `state` VALUES ('3438', 'Yumbe', 'State', '313', '222', null, 'Active');
INSERT INTO `state` VALUES ('3439', 'Baker Island', 'State', '81', '226', null, 'Active');
INSERT INTO `state` VALUES ('3440', 'Howland Island', 'State', '84', '226', null, 'Active');
INSERT INTO `state` VALUES ('3441', 'Jarvis Island', 'State', '86', '226', null, 'Active');
INSERT INTO `state` VALUES ('3442', 'Johnston Atoll', 'State', '67', '226', null, 'Active');
INSERT INTO `state` VALUES ('3443', 'Kingman Reef', 'State', '89', '226', null, 'Active');
INSERT INTO `state` VALUES ('3444', 'Midway Islands', 'State', '71', '226', null, 'Active');
INSERT INTO `state` VALUES ('3445', 'Navassa Island', 'State', '76', '226', null, 'Active');
INSERT INTO `state` VALUES ('3446', 'Palmyra Atoll', 'State', '95', '226', null, 'Active');
INSERT INTO `state` VALUES ('3447', 'Wake Ialand', 'State', '79', '226', null, 'Active');
INSERT INTO `state` VALUES ('3448', 'Artigsa', 'State', 'AR', '228', null, 'Active');
INSERT INTO `state` VALUES ('3449', 'Canelones', 'State', 'CA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3450', 'Cerro Largo', 'State', 'CL', '228', null, 'Active');
INSERT INTO `state` VALUES ('3451', 'Colonia', 'State', 'CO', '228', null, 'Active');
INSERT INTO `state` VALUES ('3452', 'Durazno', 'State', 'DU', '228', null, 'Active');
INSERT INTO `state` VALUES ('3453', 'Flores', 'State', 'FS', '228', null, 'Active');
INSERT INTO `state` VALUES ('3454', 'Lavalleja', 'State', 'LA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3455', 'Maldonado', 'State', 'MA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3456', 'Montevideo', 'State', 'MO', '228', null, 'Active');
INSERT INTO `state` VALUES ('3457', 'Paysandu', 'State', 'PA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3458', 'Rivera', 'State', 'RV', '228', null, 'Active');
INSERT INTO `state` VALUES ('3459', 'Rocha', 'State', 'RO', '228', null, 'Active');
INSERT INTO `state` VALUES ('3460', 'Salto', 'State', 'SA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3461', 'Soriano', 'State', 'SO', '228', null, 'Active');
INSERT INTO `state` VALUES ('3462', 'Tacuarembo', 'State', 'TA', '228', null, 'Active');
INSERT INTO `state` VALUES ('3463', 'Treinta y Tres', 'State', 'TT', '228', null, 'Active');
INSERT INTO `state` VALUES ('3464', 'Toshkent (city)', 'State', 'TK', '229', null, 'Active');
INSERT INTO `state` VALUES ('3465', 'Qoraqalpogiston Respublikasi', 'State', 'QR', '229', null, 'Active');
INSERT INTO `state` VALUES ('3466', 'Andijon', 'State', 'AN', '229', null, 'Active');
INSERT INTO `state` VALUES ('3467', 'Buxoro', 'State', 'BU', '229', null, 'Active');
INSERT INTO `state` VALUES ('3468', 'Farg\'ona', 'State', 'FA', '229', null, 'Active');
INSERT INTO `state` VALUES ('3469', 'Jizzax', 'State', 'JI', '229', null, 'Active');
INSERT INTO `state` VALUES ('3470', 'Khorazm', 'State', 'KH', '229', null, 'Active');
INSERT INTO `state` VALUES ('3471', 'Namangan', 'State', 'NG', '229', null, 'Active');
INSERT INTO `state` VALUES ('3472', 'Navoiy', 'State', 'NW', '229', null, 'Active');
INSERT INTO `state` VALUES ('3473', 'Qashqadaryo', 'State', 'QA', '229', null, 'Active');
INSERT INTO `state` VALUES ('3474', 'Samarqand', 'State', 'SA', '229', null, 'Active');
INSERT INTO `state` VALUES ('3475', 'Sirdaryo', 'State', 'SI', '229', null, 'Active');
INSERT INTO `state` VALUES ('3476', 'Surxondaryo', 'State', 'SU', '229', null, 'Active');
INSERT INTO `state` VALUES ('3477', 'Toshkent', 'State', 'TO', '229', null, 'Active');
INSERT INTO `state` VALUES ('3478', 'Xorazm', 'State', 'XO', '229', null, 'Active');
INSERT INTO `state` VALUES ('3479', 'Diatrito Federal', 'State', 'A', '231', null, 'Active');
INSERT INTO `state` VALUES ('3480', 'Anzoategui', 'State', 'B', '231', null, 'Active');
INSERT INTO `state` VALUES ('3481', 'Apure', 'State', 'C', '231', null, 'Active');
INSERT INTO `state` VALUES ('3482', 'Aragua', 'State', 'D', '231', null, 'Active');
INSERT INTO `state` VALUES ('3483', 'Barinas', 'State', 'E', '231', null, 'Active');
INSERT INTO `state` VALUES ('3484', 'Carabobo', 'State', 'G', '231', null, 'Active');
INSERT INTO `state` VALUES ('3485', 'Cojedes', 'State', 'H', '231', null, 'Active');
INSERT INTO `state` VALUES ('3486', 'Falcon', 'State', 'I', '231', null, 'Active');
INSERT INTO `state` VALUES ('3487', 'Guarico', 'State', 'J', '231', null, 'Active');
INSERT INTO `state` VALUES ('3488', 'Lara', 'State', 'K', '231', null, 'Active');
INSERT INTO `state` VALUES ('3489', 'Merida', 'State', 'L', '231', null, 'Active');
INSERT INTO `state` VALUES ('3490', 'Miranda', 'State', 'M', '231', null, 'Active');
INSERT INTO `state` VALUES ('3491', 'Monagas', 'State', 'N', '231', null, 'Active');
INSERT INTO `state` VALUES ('3492', 'Nueva Esparta', 'State', 'O', '231', null, 'Active');
INSERT INTO `state` VALUES ('3493', 'Portuguesa', 'State', 'P', '231', null, 'Active');
INSERT INTO `state` VALUES ('3494', 'Tachira', 'State', 'S', '231', null, 'Active');
INSERT INTO `state` VALUES ('3495', 'Trujillo', 'State', 'T', '231', null, 'Active');
INSERT INTO `state` VALUES ('3496', 'Vargas', 'State', 'X', '231', null, 'Active');
INSERT INTO `state` VALUES ('3497', 'Yaracuy', 'State', 'U', '231', null, 'Active');
INSERT INTO `state` VALUES ('3498', 'Zulia', 'State', 'V', '231', null, 'Active');
INSERT INTO `state` VALUES ('3499', 'Delta Amacuro', 'State', 'Y', '231', null, 'Active');
INSERT INTO `state` VALUES ('3500', 'Dependencias Federales', 'State', 'W', '231', null, 'Active');
INSERT INTO `state` VALUES ('3501', 'An Giang', 'State', '44', '232', null, 'Active');
INSERT INTO `state` VALUES ('3502', 'Ba Ria - Vung Tau', 'State', '43', '232', null, 'Active');
INSERT INTO `state` VALUES ('3503', 'Bac Can', 'State', '53', '232', null, 'Active');
INSERT INTO `state` VALUES ('3504', 'Bac Giang', 'State', '54', '232', null, 'Active');
INSERT INTO `state` VALUES ('3505', 'Bac Lieu', 'State', '55', '232', null, 'Active');
INSERT INTO `state` VALUES ('3506', 'Bac Ninh', 'State', '56', '232', null, 'Active');
INSERT INTO `state` VALUES ('3507', 'Ben Tre', 'State', '50', '232', null, 'Active');
INSERT INTO `state` VALUES ('3508', 'Binh Dinh', 'State', '31', '232', null, 'Active');
INSERT INTO `state` VALUES ('3509', 'Binh Duong', 'State', '57', '232', null, 'Active');
INSERT INTO `state` VALUES ('3510', 'Binh Phuoc', 'State', '58', '232', null, 'Active');
INSERT INTO `state` VALUES ('3511', 'Binh Thuan', 'State', '40', '232', null, 'Active');
INSERT INTO `state` VALUES ('3512', 'Ca Mau', 'State', '59', '232', null, 'Active');
INSERT INTO `state` VALUES ('3513', 'Can Tho', 'State', '48', '232', null, 'Active');
INSERT INTO `state` VALUES ('3514', 'Cao Bang', 'State', '04', '232', null, 'Active');
INSERT INTO `state` VALUES ('3515', 'Da Nang, thanh pho', 'State', '60', '232', null, 'Active');
INSERT INTO `state` VALUES ('3516', 'Dong Nai', 'State', '39', '232', null, 'Active');
INSERT INTO `state` VALUES ('3517', 'Dong Thap', 'State', '45', '232', null, 'Active');
INSERT INTO `state` VALUES ('3518', 'Gia Lai', 'State', '30', '232', null, 'Active');
INSERT INTO `state` VALUES ('3519', 'Ha Giang', 'State', '03', '232', null, 'Active');
INSERT INTO `state` VALUES ('3520', 'Ha Nam', 'State', '63', '232', null, 'Active');
INSERT INTO `state` VALUES ('3521', 'Ha Noi, thu do', 'State', '64', '232', null, 'Active');
INSERT INTO `state` VALUES ('3522', 'Ha Tay', 'State', '15', '232', null, 'Active');
INSERT INTO `state` VALUES ('3523', 'Ha Tinh', 'State', '23', '232', null, 'Active');
INSERT INTO `state` VALUES ('3524', 'Hai Duong', 'State', '61', '232', null, 'Active');
INSERT INTO `state` VALUES ('3525', 'Hai Phong, thanh pho', 'State', '62', '232', null, 'Active');
INSERT INTO `state` VALUES ('3526', 'Hoa Binh', 'State', '14', '232', null, 'Active');
INSERT INTO `state` VALUES ('3527', 'Ho Chi Minh, thanh pho [Sai Gon]', 'State', '65', '232', null, 'Active');
INSERT INTO `state` VALUES ('3528', 'Hung Yen', 'State', '66', '232', null, 'Active');
INSERT INTO `state` VALUES ('3529', 'Khanh Hoa', 'State', '34', '232', null, 'Active');
INSERT INTO `state` VALUES ('3530', 'Kien Giang', 'State', '47', '232', null, 'Active');
INSERT INTO `state` VALUES ('3531', 'Kon Tum', 'State', '28', '232', null, 'Active');
INSERT INTO `state` VALUES ('3532', 'Lai Chau', 'State', '01', '232', null, 'Active');
INSERT INTO `state` VALUES ('3533', 'Lam Dong', 'State', '35', '232', null, 'Active');
INSERT INTO `state` VALUES ('3534', 'Lang Son', 'State', '09', '232', null, 'Active');
INSERT INTO `state` VALUES ('3535', 'Lao Cai', 'State', '02', '232', null, 'Active');
INSERT INTO `state` VALUES ('3536', 'Long An', 'State', '41', '232', null, 'Active');
INSERT INTO `state` VALUES ('3537', 'Nam Dinh', 'State', '67', '232', null, 'Active');
INSERT INTO `state` VALUES ('3538', 'Nghe An', 'State', '22', '232', null, 'Active');
INSERT INTO `state` VALUES ('3539', 'Ninh Binh', 'State', '18', '232', null, 'Active');
INSERT INTO `state` VALUES ('3540', 'Ninh Thuan', 'State', '36', '232', null, 'Active');
INSERT INTO `state` VALUES ('3541', 'Phu Tho', 'State', '68', '232', null, 'Active');
INSERT INTO `state` VALUES ('3542', 'Phu Yen', 'State', '32', '232', null, 'Active');
INSERT INTO `state` VALUES ('3543', 'Quang Binh', 'State', '24', '232', null, 'Active');
INSERT INTO `state` VALUES ('3544', 'Quang Nam', 'State', '27', '232', null, 'Active');
INSERT INTO `state` VALUES ('3545', 'Quang Ngai', 'State', '29', '232', null, 'Active');
INSERT INTO `state` VALUES ('3546', 'Quang Ninh', 'State', '13', '232', null, 'Active');
INSERT INTO `state` VALUES ('3547', 'Quang Tri', 'State', '25', '232', null, 'Active');
INSERT INTO `state` VALUES ('3548', 'Soc Trang', 'State', '52', '232', null, 'Active');
INSERT INTO `state` VALUES ('3549', 'Son La', 'State', '05', '232', null, 'Active');
INSERT INTO `state` VALUES ('3550', 'Tay Ninh', 'State', '37', '232', null, 'Active');
INSERT INTO `state` VALUES ('3551', 'Thai Binh', 'State', '20', '232', null, 'Active');
INSERT INTO `state` VALUES ('3552', 'Thai Nguyen', 'State', '69', '232', null, 'Active');
INSERT INTO `state` VALUES ('3553', 'Thanh Hoa', 'State', '21', '232', null, 'Active');
INSERT INTO `state` VALUES ('3554', 'Thua Thien-Hue', 'State', '26', '232', null, 'Active');
INSERT INTO `state` VALUES ('3555', 'Tien Giang', 'State', '46', '232', null, 'Active');
INSERT INTO `state` VALUES ('3556', 'Tra Vinh', 'State', '51', '232', null, 'Active');
INSERT INTO `state` VALUES ('3557', 'Tuyen Quang', 'State', '07', '232', null, 'Active');
INSERT INTO `state` VALUES ('3558', 'Vinh Long', 'State', '49', '232', null, 'Active');
INSERT INTO `state` VALUES ('3559', 'Vinh Phuc', 'State', '70', '232', null, 'Active');
INSERT INTO `state` VALUES ('3560', 'Yen Bai', 'State', '06', '232', null, 'Active');
INSERT INTO `state` VALUES ('3561', 'Malampa', 'State', 'MAP', '230', null, 'Active');
INSERT INTO `state` VALUES ('3562', 'Penama', 'State', 'PAM', '230', null, 'Active');
INSERT INTO `state` VALUES ('3563', 'Sanma', 'State', 'SAM', '230', null, 'Active');
INSERT INTO `state` VALUES ('3564', 'Shefa', 'State', 'SEE', '230', null, 'Active');
INSERT INTO `state` VALUES ('3565', 'Tafea', 'State', 'TAE', '230', null, 'Active');
INSERT INTO `state` VALUES ('3566', 'Torba', 'State', 'TOB', '230', null, 'Active');
INSERT INTO `state` VALUES ('3567', 'A\'ana', 'State', 'AA', '184', null, 'Active');
INSERT INTO `state` VALUES ('3568', 'Aiga-i-le-Tai', 'State', 'AL', '184', null, 'Active');
INSERT INTO `state` VALUES ('3569', 'Atua', 'State', 'AT', '184', null, 'Active');
INSERT INTO `state` VALUES ('3570', 'Fa\'aaaleleaga', 'State', 'FA', '184', null, 'Active');
INSERT INTO `state` VALUES ('3571', 'Gaga\'emauga', 'State', 'GE', '184', null, 'Active');
INSERT INTO `state` VALUES ('3572', 'Gagaifomauga', 'State', 'GI', '184', null, 'Active');
INSERT INTO `state` VALUES ('3573', 'Palauli', 'State', 'PA', '184', null, 'Active');
INSERT INTO `state` VALUES ('3574', 'Satupa\'itea', 'State', 'SA', '184', null, 'Active');
INSERT INTO `state` VALUES ('3575', 'Tuamasaga', 'State', 'TU', '184', null, 'Active');
INSERT INTO `state` VALUES ('3576', 'Va\'a-o-Fonoti', 'State', 'VF', '184', null, 'Active');
INSERT INTO `state` VALUES ('3577', 'Vaisigano', 'State', 'VS', '184', null, 'Active');
INSERT INTO `state` VALUES ('3578', 'Crna Gora', 'State', 'CG', '237', null, 'Active');
INSERT INTO `state` VALUES ('3579', 'Srbija', 'State', 'SR', '237', null, 'Active');
INSERT INTO `state` VALUES ('3580', 'Kosovo-Metohija', 'State', 'KM', '237', null, 'Active');
INSERT INTO `state` VALUES ('3581', 'Vojvodina', 'State', 'VO', '237', null, 'Active');
INSERT INTO `state` VALUES ('3582', 'Abyan', 'State', 'AB', '236', null, 'Active');
INSERT INTO `state` VALUES ('3583', 'Adan', 'State', 'AD', '236', null, 'Active');
INSERT INTO `state` VALUES ('3584', 'Ad Dali', 'State', 'DA', '236', null, 'Active');
INSERT INTO `state` VALUES ('3585', 'Al Bayda\'', 'State', 'BA', '236', null, 'Active');
INSERT INTO `state` VALUES ('3586', 'Al Hudaydah', 'State', 'MU', '236', null, 'Active');
INSERT INTO `state` VALUES ('3587', 'Al Mahrah', 'State', 'MR', '236', null, 'Active');
INSERT INTO `state` VALUES ('3588', 'Al Mahwit', 'State', 'MW', '236', null, 'Active');
INSERT INTO `state` VALUES ('3589', 'Amran', 'State', 'AM', '236', null, 'Active');
INSERT INTO `state` VALUES ('3590', 'Dhamar', 'State', 'DH', '236', null, 'Active');
INSERT INTO `state` VALUES ('3591', 'Hadramawt', 'State', 'HD', '236', null, 'Active');
INSERT INTO `state` VALUES ('3592', 'Hajjah', 'State', 'HJ', '236', null, 'Active');
INSERT INTO `state` VALUES ('3593', 'Ibb', 'State', 'IB', '236', null, 'Active');
INSERT INTO `state` VALUES ('3594', 'Lahij', 'State', 'LA', '236', null, 'Active');
INSERT INTO `state` VALUES ('3595', 'Ma\'rib', 'State', 'MA', '236', null, 'Active');
INSERT INTO `state` VALUES ('3596', 'Sa\'dah', 'State', 'SD', '236', null, 'Active');
INSERT INTO `state` VALUES ('3597', 'San\'a\'', 'State', 'SN', '236', null, 'Active');
INSERT INTO `state` VALUES ('3598', 'Shabwah', 'State', 'SH', '236', null, 'Active');
INSERT INTO `state` VALUES ('3599', 'Ta\'izz', 'State', 'TA', '236', null, 'Active');
INSERT INTO `state` VALUES ('3600', 'Eastern Cape', 'State', 'EC', '195', null, 'Active');
INSERT INTO `state` VALUES ('3601', 'Free State', 'State', 'FS', '195', null, 'Active');
INSERT INTO `state` VALUES ('3602', 'Gauteng', 'State', 'GT', '195', null, 'Active');
INSERT INTO `state` VALUES ('3603', 'Kwazulu-Natal', 'State', 'NL', '195', null, 'Active');
INSERT INTO `state` VALUES ('3604', 'Mpumalanga', 'State', 'MP', '195', null, 'Active');
INSERT INTO `state` VALUES ('3605', 'Northern Cape', 'State', 'NC', '195', null, 'Active');
INSERT INTO `state` VALUES ('3606', 'Limpopo', 'State', 'NP', '195', null, 'Active');
INSERT INTO `state` VALUES ('3607', 'Western Cape', 'State', 'WC', '195', null, 'Active');
INSERT INTO `state` VALUES ('3608', 'Copperbelt', 'State', '08', '238', null, 'Active');
INSERT INTO `state` VALUES ('3609', 'Luapula', 'State', '04', '238', null, 'Active');
INSERT INTO `state` VALUES ('3610', 'Lusaka', 'State', '09', '238', null, 'Active');
INSERT INTO `state` VALUES ('3611', 'North-Western', 'State', '06', '238', null, 'Active');
INSERT INTO `state` VALUES ('3612', 'Bulawayo', 'State', 'BU', '239', null, 'Active');
INSERT INTO `state` VALUES ('3613', 'Harare', 'State', 'HA', '239', null, 'Active');
INSERT INTO `state` VALUES ('3614', 'Manicaland', 'State', 'MA', '239', null, 'Active');
INSERT INTO `state` VALUES ('3615', 'Mashonaland Central', 'State', 'MC', '239', null, 'Active');
INSERT INTO `state` VALUES ('3616', 'Mashonaland East', 'State', 'ME', '239', null, 'Active');
INSERT INTO `state` VALUES ('3617', 'Mashonaland West', 'State', 'MW', '239', null, 'Active');
INSERT INTO `state` VALUES ('3618', 'Masvingo', 'State', 'MV', '239', null, 'Active');
INSERT INTO `state` VALUES ('3619', 'Matabeleland North', 'State', 'MN', '239', null, 'Active');
INSERT INTO `state` VALUES ('3620', 'Matabeleland South', 'State', 'MS', '239', null, 'Active');
INSERT INTO `state` VALUES ('3621', 'Midlands', 'State', 'MI', '239', null, 'Active');
INSERT INTO `state` VALUES ('3622', 'South Karelia', 'State', 'SK', '74', null, 'Active');
INSERT INTO `state` VALUES ('3623', 'South Ostrobothnia', 'State', 'SO', '74', null, 'Active');
INSERT INTO `state` VALUES ('3624', 'Etelä-Savo', 'State', 'ES', '74', null, 'Active');
INSERT INTO `state` VALUES ('3625', 'Häme', 'State', 'HH', '74', null, 'Active');
INSERT INTO `state` VALUES ('3626', 'Itä-Uusimaa', 'State', 'IU', '74', null, 'Active');
INSERT INTO `state` VALUES ('3627', 'Kainuu', 'State', 'KA', '74', null, 'Active');
INSERT INTO `state` VALUES ('3628', 'Central Ostrobothnia', 'State', 'CO', '74', null, 'Active');
INSERT INTO `state` VALUES ('3629', 'Central Finland', 'State', 'CF', '74', null, 'Active');
INSERT INTO `state` VALUES ('3630', 'Kymenlaakso', 'State', 'KY', '74', null, 'Active');
INSERT INTO `state` VALUES ('3631', 'Lapland', 'State', 'LA', '74', null, 'Active');
INSERT INTO `state` VALUES ('3632', 'Tampere Region', 'State', 'TR', '74', null, 'Active');
INSERT INTO `state` VALUES ('3633', 'Ostrobothnia', 'State', 'OB', '74', null, 'Active');
INSERT INTO `state` VALUES ('3634', 'North Karelia', 'State', 'NK', '74', null, 'Active');
INSERT INTO `state` VALUES ('3635', 'Nothern Ostrobothnia', 'State', 'NO', '74', null, 'Active');
INSERT INTO `state` VALUES ('3636', 'Northern Savo', 'State', 'NS', '74', null, 'Active');
INSERT INTO `state` VALUES ('3637', 'Päijät-Häme', 'State', 'PH', '74', null, 'Active');
INSERT INTO `state` VALUES ('3638', 'Satakunta', 'State', 'SK', '74', null, 'Active');
INSERT INTO `state` VALUES ('3639', 'Uusimaa', 'State', 'UM', '74', null, 'Active');
INSERT INTO `state` VALUES ('3640', 'South-West Finland', 'State', 'SW', '74', null, 'Active');
INSERT INTO `state` VALUES ('3641', 'Åland', 'State', 'AL', '74', null, 'Active');
INSERT INTO `state` VALUES ('3642', 'Limburg', 'State', 'LI', '151', null, 'Active');
INSERT INTO `state` VALUES ('3643', 'Central and Western', 'State', 'CW', '97', null, 'Active');
INSERT INTO `state` VALUES ('3644', 'Eastern', 'State', 'EA', '97', null, 'Active');
INSERT INTO `state` VALUES ('3645', 'Southern', 'State', 'SO', '97', null, 'Active');
INSERT INTO `state` VALUES ('3646', 'Wan Chai', 'State', 'WC', '97', null, 'Active');
INSERT INTO `state` VALUES ('3647', 'Kowloon City', 'State', 'KC', '97', null, 'Active');
INSERT INTO `state` VALUES ('3648', 'Kwun Tong', 'State', 'KU', '97', null, 'Active');
INSERT INTO `state` VALUES ('3649', 'Sham Shui Po', 'State', 'SS', '97', null, 'Active');
INSERT INTO `state` VALUES ('3650', 'Wong Tai Sin', 'State', 'WT', '97', null, 'Active');
INSERT INTO `state` VALUES ('3651', 'Yau Tsim Mong', 'State', 'YT', '97', null, 'Active');
INSERT INTO `state` VALUES ('3652', 'Islands', 'State', 'IS', '97', null, 'Active');
INSERT INTO `state` VALUES ('3653', 'Kwai Tsing', 'State', 'KI', '97', null, 'Active');
INSERT INTO `state` VALUES ('3654', 'North', 'State', 'NO', '97', null, 'Active');
INSERT INTO `state` VALUES ('3655', 'Sai Kung', 'State', 'SK', '97', null, 'Active');
INSERT INTO `state` VALUES ('3656', 'Sha Tin', 'State', 'ST', '97', null, 'Active');
INSERT INTO `state` VALUES ('3657', 'Tai Po', 'State', 'TP', '97', null, 'Active');
INSERT INTO `state` VALUES ('3658', 'Tsuen Wan', 'State', 'TW', '97', null, 'Active');
INSERT INTO `state` VALUES ('3659', 'Tuen Mun', 'State', 'TM', '97', null, 'Active');
INSERT INTO `state` VALUES ('3660', 'Yuen Long', 'State', 'YL', '97', null, 'Active');
INSERT INTO `state` VALUES ('3661', 'Manchester', 'State', 'MR', '107', null, 'Active');
INSERT INTO `state` VALUES ('3662', 'Al Man?mah (Al ‘??imah)', 'State', '13', '16', null, 'Active');
INSERT INTO `state` VALUES ('3663', 'Al Jan?b?yah', 'State', '14', '16', null, 'Active');
INSERT INTO `state` VALUES ('3664', 'Al Wus?á', 'State', '16', '16', null, 'Active');
INSERT INTO `state` VALUES ('3665', 'Ash Sham?l?yah', 'State', '17', '16', null, 'Active');
INSERT INTO `state` VALUES ('3666', 'Jenin', 'State', '_A', '164', null, 'Active');
INSERT INTO `state` VALUES ('3667', 'Tubas', 'State', '_B', '164', null, 'Active');
INSERT INTO `state` VALUES ('3668', 'Tulkarm', 'State', '_C', '164', null, 'Active');
INSERT INTO `state` VALUES ('3669', 'Nablus', 'State', '_D', '164', null, 'Active');
INSERT INTO `state` VALUES ('3670', 'Qalqilya', 'State', '_E', '164', null, 'Active');
INSERT INTO `state` VALUES ('3671', 'Salfit', 'State', '_F', '164', null, 'Active');
INSERT INTO `state` VALUES ('3672', 'Ramallah and Al-Bireh', 'State', '_G', '164', null, 'Active');
INSERT INTO `state` VALUES ('3673', 'Jericho', 'State', '_H', '164', null, 'Active');
INSERT INTO `state` VALUES ('3674', 'Jerusalem', 'State', '_I', '164', null, 'Active');
INSERT INTO `state` VALUES ('3675', 'Bethlehem', 'State', '_J', '164', null, 'Active');
INSERT INTO `state` VALUES ('3676', 'Hebron', 'State', '_K', '164', null, 'Active');
INSERT INTO `state` VALUES ('3677', 'North Gaza', 'State', '_L', '164', null, 'Active');
INSERT INTO `state` VALUES ('3678', 'Gaza', 'State', '_M', '164', null, 'Active');
INSERT INTO `state` VALUES ('3679', 'Deir el-Balah', 'State', '_N', '164', null, 'Active');
INSERT INTO `state` VALUES ('3680', 'Khan Yunis', 'State', '_O', '164', null, 'Active');
INSERT INTO `state` VALUES ('3681', 'Rafah', 'State', '_P', '164', null, 'Active');
INSERT INTO `state` VALUES ('3682', 'Brussels', 'State', 'BRU', '20', null, 'Active');
INSERT INTO `state` VALUES ('3683', 'Distrito Federal', 'State', 'DIF', '139', null, 'Active');
INSERT INTO `state` VALUES ('3684', 'North West', 'State', 'NW', '195', null, 'Active');
INSERT INTO `state` VALUES ('3685', 'Tyne and Wear', 'State', 'TWR', '225', null, 'Active');
INSERT INTO `state` VALUES ('3686', 'Greater Manchester', 'State', 'GTM', '225', null, 'Active');
INSERT INTO `state` VALUES ('3687', 'Co Tyrone', 'State', 'TYR', '225', null, 'Active');
INSERT INTO `state` VALUES ('3688', 'West Yorkshire', 'State', 'WYK', '225', null, 'Active');
INSERT INTO `state` VALUES ('3689', 'South Yorkshire', 'State', 'SYK', '225', null, 'Active');
INSERT INTO `state` VALUES ('3690', 'Merseyside', 'State', 'MSY', '225', null, 'Active');
INSERT INTO `state` VALUES ('3691', 'Berkshire', 'State', 'BRK', '225', null, 'Active');
INSERT INTO `state` VALUES ('3692', 'West Midlands', 'State', 'WMD', '225', null, 'Active');
INSERT INTO `state` VALUES ('3693', 'West Glamorgan', 'State', 'WGM', '225', null, 'Active');
INSERT INTO `state` VALUES ('3694', 'Greater London', 'State', 'LON', '225', null, 'Active');
INSERT INTO `state` VALUES ('3695', 'Carbonia-Iglesias', 'State', 'CI', '106', null, 'Active');
INSERT INTO `state` VALUES ('3696', 'Olbia-Tempio', 'State', 'OT', '106', null, 'Active');
INSERT INTO `state` VALUES ('3697', 'Medio Campidano', 'State', 'VS', '106', null, 'Active');
INSERT INTO `state` VALUES ('3698', 'Ogliastra', 'State', 'OG', '106', null, 'Active');
INSERT INTO `state` VALUES ('3699', 'Bonaire', 'State', 'BON', '150', null, 'Active');
INSERT INTO `state` VALUES ('3700', 'Curaçao', 'State', 'CUR', '150', null, 'Active');
INSERT INTO `state` VALUES ('3701', 'Saba', 'State', 'SAB', '150', null, 'Active');
INSERT INTO `state` VALUES ('3702', 'St. Eustatius', 'State', 'EUA', '150', null, 'Active');
INSERT INTO `state` VALUES ('3703', 'St. Maarten', 'State', 'SXM', '150', null, 'Active');
INSERT INTO `state` VALUES ('3704', 'Jura', 'State', '39', '75', null, 'Active');
INSERT INTO `state` VALUES ('3705', 'Barletta-Andria-Trani', 'State', 'Bar', '106', null, 'Active');
INSERT INTO `state` VALUES ('3706', 'Fermo', 'State', 'Fer', '106', null, 'Active');
INSERT INTO `state` VALUES ('3707', 'Monza e Brianza', 'State', 'Mon', '106', null, 'Active');
INSERT INTO `state` VALUES ('3708', 'Clwyd', 'State', 'CWD', '225', null, 'Active');
INSERT INTO `state` VALUES ('3709', 'Dyfed', 'State', 'DFD', '225', null, 'Active');
INSERT INTO `state` VALUES ('3710', 'South Glamorgan', 'State', 'SGM', '225', null, 'Active');
INSERT INTO `state` VALUES ('3711', 'Artibonite', 'State', 'AR', '93', null, 'Active');
INSERT INTO `state` VALUES ('3712', 'Centre', 'State', 'CE', '93', null, 'Active');
INSERT INTO `state` VALUES ('3713', 'Nippes', 'State', 'NI', '93', null, 'Active');
INSERT INTO `state` VALUES ('3714', 'Nord', 'State', 'ND', '93', null, 'Active');

-- ----------------------------
-- Table structure for `store_transaction`
-- ----------------------------
DROP TABLE IF EXISTS `store_transaction`;
CREATE TABLE `store_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `related_document_id` int(11) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `from_warehouse_id` int(11) DEFAULT NULL,
  `to_warehouse_id` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `jobcard_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `delivery_via` varchar(255) DEFAULT NULL,
  `delivery_reference` varchar(255) DEFAULT NULL,
  `shipping_address` text,
  `shipping_charge` double(8,4) DEFAULT NULL,
  `narration` text,
  `tracking_code` text,
  `related_transaction_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `related_doc_id` (`related_document_id`) USING BTREE,
  KEY `from_warehouse_id` (`from_warehouse_id`) USING BTREE,
  KEY `to_warehouse_id` (`to_warehouse_id`) USING BTREE,
  KEY `jobcard_id` (`jobcard_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_transaction
-- ----------------------------

-- ----------------------------
-- Table structure for `store_transaction_row`
-- ----------------------------
DROP TABLE IF EXISTS `store_transaction_row`;
CREATE TABLE `store_transaction_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `store_transaction_id` int(11) DEFAULT NULL,
  `qsp_detail_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` double(8,4) DEFAULT NULL,
  `jobcard_detail_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `extra_info` longtext,
  `related_transaction_row_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `epan_id` (`epan_id`) USING BTREE,
  KEY `store_transaction_id` (`store_transaction_id`) USING BTREE,
  KEY `qsp_detail_id` (`qsp_detail_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of store_transaction_row
-- ----------------------------

-- ----------------------------
-- Table structure for `store_transaction_row_custom_field_value`
-- ----------------------------
DROP TABLE IF EXISTS `store_transaction_row_custom_field_value`;
CREATE TABLE `store_transaction_row_custom_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customfield_generic_id` int(11) DEFAULT NULL,
  `customfield_value_id` int(11) DEFAULT NULL,
  `store_transaction_row_id` int(11) DEFAULT NULL,
  `custom_name` varchar(255) DEFAULT NULL,
  `custom_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of store_transaction_row_custom_field_value
-- ----------------------------

-- ----------------------------
-- Table structure for `supplier`
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `contact_id` int(11) NOT NULL,
  `tin_no` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pan_no` varchar(255) NOT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_id` (`contact_id`),
  KEY `currency_id` (`currency_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `support_ticket`
-- ----------------------------
DROP TABLE IF EXISTS `support_ticket`;
CREATE TABLE `support_ticket` (
  `document_id` int(11) NOT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `communication_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `from_raw` text,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `to_raw` text,
  `cc_raw` text,
  `bcc_raw` text,
  `subject` varchar(255) DEFAULT NULL,
  `message` longtext,
  `priority` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE,
  KEY `contact_id` (`contact_id`) USING BTREE,
  KEY `communication_id` (`communication_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of support_ticket
-- ----------------------------

-- ----------------------------
-- Table structure for `task`
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `task_name` varchar(255) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `assign_to_id` int(11) DEFAULT NULL,
  `description` text,
  `starting_date` datetime DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `priority` varchar(255) DEFAULT NULL,
  `estimate_time` varchar(255) DEFAULT NULL,
  `set_reminder` tinyint(4) DEFAULT NULL,
  `remind_via` varchar(255) DEFAULT NULL,
  `remind_value` decimal(10,0) DEFAULT NULL,
  `remind_unit` varchar(255) DEFAULT NULL,
  `is_recurring` tinyint(4) DEFAULT NULL,
  `recurring_span` varchar(255) DEFAULT NULL,
  `is_reminded` tinyint(4) DEFAULT NULL,
  `notify_to` varchar(255) DEFAULT NULL,
  `is_reminder_only` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reminder_time_compare_with` varchar(255) DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `received_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `reopened_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `snooze_duration` int(11) DEFAULT NULL,
  `reminder_time` datetime DEFAULT NULL,
  `last_comment_time` datetime DEFAULT NULL,
  `comment_count` int(11) DEFAULT NULL,
  `creator_unseen_comment_count` int(11) DEFAULT NULL,
  `assignee_unseen_comment_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_to_id` (`assign_to_id`),
  KEY `created_by_id` (`created_by_id`),
  KEY `starting_date` (`starting_date`),
  KEY `deadline` (`deadline`),
  KEY `status` (`status`),
  FULLTEXT KEY `task_title_full_text` (`task_name`,`description`,`status`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of task
-- ----------------------------

-- ----------------------------
-- Table structure for `task_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `task_attachment`;
CREATE TABLE `task_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`) USING BTREE,
  KEY `file_id` (`file_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of task_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `taxation`
-- ----------------------------
DROP TABLE IF EXISTS `taxation`;
CREATE TABLE `taxation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `percentage` decimal(14,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `sub_tax` text,
  PRIMARY KEY (`id`),
  KEY `created_by_id` (`created_by_id`) USING BTREE,
  FULLTEXT KEY `search_string` (`name`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of taxation
-- ----------------------------

-- ----------------------------
-- Table structure for `taxation_association`
-- ----------------------------
DROP TABLE IF EXISTS `taxation_association`;
CREATE TABLE `taxation_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `taxation_rule_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of taxation_association
-- ----------------------------

-- ----------------------------
-- Table structure for `taxation_rule`
-- ----------------------------
DROP TABLE IF EXISTS `taxation_rule`;
CREATE TABLE `taxation_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of taxation_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `taxation_rule_row`
-- ----------------------------
DROP TABLE IF EXISTS `taxation_rule_row`;
CREATE TABLE `taxation_rule_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taxation_id` int(11) NOT NULL,
  `taxation_rule_id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of taxation_rule_row
-- ----------------------------

-- ----------------------------
-- Table structure for `team_project_association`
-- ----------------------------
DROP TABLE IF EXISTS `team_project_association`;
CREATE TABLE `team_project_association` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`) USING BTREE,
  KEY `project_id` (`project_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of team_project_association
-- ----------------------------

-- ----------------------------
-- Table structure for `ticket_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `ticket_attachment`;
CREATE TABLE `ticket_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `attachment_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `timesheet`
-- ----------------------------
DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE `timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`) USING BTREE,
  KEY `employee_id` (`employee_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of timesheet
-- ----------------------------

-- ----------------------------
-- Table structure for `tnc`
-- ----------------------------
DROP TABLE IF EXISTS `tnc`;
CREATE TABLE `tnc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET latin1 COLLATE latin1_general_cs,
  `name` varchar(255) DEFAULT NULL,
  `document_id` int(11) NOT NULL,
  `is_default_for_quotation` tinyint(4) DEFAULT NULL,
  `is_default_for_sale_order` tinyint(4) DEFAULT NULL,
  `is_default_for_sale_invoice` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tnc
-- ----------------------------

-- ----------------------------
-- Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of unit
-- ----------------------------

-- ----------------------------
-- Table structure for `unit_conversion`
-- ----------------------------
DROP TABLE IF EXISTS `unit_conversion`;
CREATE TABLE `unit_conversion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `one_of_id` int(11) NOT NULL,
  `multiply_with` decimal(10,0) DEFAULT NULL,
  `to_become_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of unit_conversion
-- ----------------------------

-- ----------------------------
-- Table structure for `unit_group`
-- ----------------------------
DROP TABLE IF EXISTS `unit_group`;
CREATE TABLE `unit_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of unit_group
-- ----------------------------

-- ----------------------------
-- Table structure for `unsubscribe`
-- ----------------------------
DROP TABLE IF EXISTS `unsubscribe`;
CREATE TABLE `unsubscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` text,
  `created_at` datetime DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of unsubscribe
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `status` varchar(255) DEFAULT '1',
  `epan_id` int(11) DEFAULT NULL,
  `scope` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_epan1_idx` (`epan_id`),
  KEY `created_by_id` (`created_by_id`) USING BTREE,
  FULLTEXT KEY `search_string` (`username`,`type`,`scope`),
  CONSTRAINT `fk_user_epan1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('68', 'management@xavoc.com', '21232f297a57a5a743894a0e4a801fc3', 'Active', null, 'SuperUser', 'User', null, '2017-06-07 07:36:29', '0');
INSERT INTO `user` VALUES ('69', 'admin@company.com', '21232f297a57a5a743894a0e4a801fc3', 'Active', null, 'WebsiteUser', 'User', null, null, '0');

-- ----------------------------
-- Table structure for `webpage`
-- ----------------------------
DROP TABLE IF EXISTS `webpage`;
CREATE TABLE `webpage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `is_template` tinyint(4) DEFAULT NULL,
  `is_muted` tinyint(4) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `parent_page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of webpage
-- ----------------------------
INSERT INTO `webpage` VALUES ('1', 'Home', 'index.html', null, '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('2', 'About Us', 'about.html', null, '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('3', 'Contact Us', 'contact.html', null, '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('4', 'Registration', 'registration.html', null, '0', '1', '1', null);
INSERT INTO `webpage` VALUES ('5', 'default', 'default.html', null, '1', null, '1', null);
INSERT INTO `webpage` VALUES ('6', 'distributorpanel', 'distributorpanel.html', null, '1', null, '1', null);
INSERT INTO `webpage` VALUES ('7', 'distributor dashboard', 'dashboard.html', '6', '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('8', 'genology', 'genology.html', '6', '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('9', 'mypayouts', 'mypayouts.html', '6', '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('10', 'mywallet', 'mywallet.html', '6', '0', '0', '1', null);
INSERT INTO `webpage` VALUES ('11', 'panelregistration', 'panelregistration.html', '6', '0', '0', '1', null);

-- ----------------------------
-- Table structure for `webpage_snapshot`
-- ----------------------------
DROP TABLE IF EXISTS `webpage_snapshot`;
CREATE TABLE `webpage_snapshot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `content` longtext,
  `page_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of webpage_snapshot
-- ----------------------------

-- ----------------------------
-- Table structure for `xepan_cms_image_gallery_categories`
-- ----------------------------
DROP TABLE IF EXISTS `xepan_cms_image_gallery_categories`;
CREATE TABLE `xepan_cms_image_gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of xepan_cms_image_gallery_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `xepan_cms_image_gallery_images`
-- ----------------------------
DROP TABLE IF EXISTS `xepan_cms_image_gallery_images`;
CREATE TABLE `xepan_cms_image_gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `gallery_cat_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of xepan_cms_image_gallery_images
-- ----------------------------

-- ----------------------------
-- Table structure for `xepan_template`
-- ----------------------------
DROP TABLE IF EXISTS `xepan_template`;
CREATE TABLE `xepan_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `tags` text,
  `description` text,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xepan_template
-- ----------------------------

-- ----------------------------
-- Table structure for `xmarketingcampaign_googlebloggerconfig`
-- ----------------------------
DROP TABLE IF EXISTS `xmarketingcampaign_googlebloggerconfig`;
CREATE TABLE `xmarketingcampaign_googlebloggerconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `appId` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `blogid` varchar(255) DEFAULT NULL,
  `access_token` text,
  `access_token_secret` text,
  `refresh_token` text,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xmarketingcampaign_googlebloggerconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `xshop_item_images`
-- ----------------------------
DROP TABLE IF EXISTS `xshop_item_images`;
CREATE TABLE `xshop_item_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_image_id` int(10) unsigned DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `customefieldvalue_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customefieldvalue_id` (`customefieldvalue_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_image_id` (`item_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xshop_item_images
-- ----------------------------

-- ----------------------------
-- Table structure for `xshop_item_quantity_set_conditions`
-- ----------------------------
DROP TABLE IF EXISTS `xshop_item_quantity_set_conditions`;
CREATE TABLE `xshop_item_quantity_set_conditions` (
  `id` int(11) NOT NULL,
  `quantityset_id` int(11) DEFAULT NULL,
  `custom_field_value_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `customfield_id` int(11) DEFAULT NULL,
  `department_phase_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quantityset_id` (`quantityset_id`),
  KEY `fk_custom_field_value_id` (`custom_field_value_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_department_phase_id` (`department_phase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xshop_item_quantity_set_conditions
-- ----------------------------
