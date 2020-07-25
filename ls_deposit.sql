-- -------------------------------------------------------------
-- TablePlus 3.4.0(304)
--
-- https://tableplus.com/
--
-- Database: ls_deposit
-- Generation Time: 2020-05-07 16:28:28.9520
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_bind`;
CREATE TABLE `order_bind` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bind_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单号',
  `bind_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '机器标题',
  `bind_sn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '机器SN',
  `bind_merch` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '机器商编',
  `bind_active` int(11) NOT NULL DEFAULT '0' COMMENT '是否激活!',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_bind_bind_no_unique` (`bind_no`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_pay`;
CREATE TABLE `order_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝资金授权订单号',
  `out_trade_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '交易流水号',
  `ali_trade_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝交易流水号',
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '解冻转支付标题',
  `pay_amount` int(11) NOT NULL DEFAULT '0' COMMENT '结算支付金额',
  `sellerId` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '卖家支付宝账户pid',
  `buyerid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '买家支付宝账户pid',
  `body` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '可填写备注信息',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'init' COMMENT '状态 init 初始化 error 错误 wait 等待异步通知 success 成功',
  `buyerloginid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '买家支付宝登录帐号',
  `gmt_payment` timestamp NULL DEFAULT NULL COMMENT '交易处理时间',
  `invoice_amount` int(11) NOT NULL DEFAULT '0',
  `point_amount` int(11) NOT NULL DEFAULT '0',
  `receipt_amount` int(11) NOT NULL DEFAULT '0',
  `total_amount` int(11) NOT NULL DEFAULT '0',
  `bak` text COLLATE utf8mb4_unicode_ci COMMENT '支付宝返回的json',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `order_thaw`;
CREATE TABLE `order_thaw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝资金授权订单号',
  `out_order_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商户的授权资金订单号',
  `operation_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝资金操作流水号',
  `out_request_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝资金授权订单号',
  `thaw_amount` int(11) NOT NULL DEFAULT '0' COMMENT '本次操作解冻的金额',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '解冻附言描述',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '解冻附言描述',
  `gmt_trans` timestamp NULL DEFAULT NULL COMMENT '授权资金解冻成功时间',
  `credit_amount` int(11) NOT NULL DEFAULT '0' COMMENT '本次解冻操作中信用解冻金额',
  `fund_amount` int(11) NOT NULL DEFAULT '0' COMMENT '本次解冻操作中自有资金解冻金额',
  `bak` text COLLATE utf8mb4_unicode_ci COMMENT '支付宝返回的json',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=650 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '预授权订单号',
  `order_request_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '预授权请求流水号',
  `alipay_auth_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝资金授权订单号',
  `alipay_operation_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付宝的资金操作流水号',
  `order_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单标题',
  `order_amount` int(11) NOT NULL DEFAULT '0' COMMENT '订单金额',
  `order_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单会员',
  `order_user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单会员姓名',
  `order_parent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '订单会员的邀请人帐号,可以同一个人扫不同人的二维码',
  `order_mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '付款方手机号',
  `extra_param_outStoreAlias` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '业务信息,支付宝信息展示页展示',
  `alipay_operation_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '资金操作类型FREEZE, UNFREEZE, PAY',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT '本次操作冻结的金额',
  `alipay_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '资金预授权明细的状态 INIT SUCCESS CLOSED',
  `alipay_gmt_create` timestamp NULL DEFAULT NULL COMMENT '操作创建时间',
  `alipay_gmt_trans` timestamp NULL DEFAULT NULL COMMENT '操作处理完成时间',
  `alipay_payer_logon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '付款方支付宝账号登录号',
  `alipay_payer_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '付款方支付宝账号UID',
  `alipay_payee_logon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '收款方支付宝账号登陆号',
  `alipay_payee_user` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '收款方支付宝账号UID',
  `total_freeze_amount` int(11) NOT NULL DEFAULT '0' COMMENT '累计冻结金额',
  `total_unfreeze_amount` int(11) NOT NULL DEFAULT '0' COMMENT '累计解冻金额',
  `total_pay_amount` int(11) NOT NULL DEFAULT '0' COMMENT '累计支付金额',
  `rest_amount` int(11) NOT NULL DEFAULT '0' COMMENT '剩余冻结金额',
  `pre_auth_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '预授权类型CREDIT_AUTH(信用预授权 没有真实冻结资金)',
  `alipay_pay_return` text COLLATE utf8mb4_unicode_ci COMMENT '支付宝支付返回JSON',
  `platform` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_no_unique` (`order_no`),
  UNIQUE KEY `orders_order_request_no_unique` (`order_request_no`)
) ENGINE=InnoDB AUTO_INCREMENT=2447 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ismanage` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform_role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groups` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '小组',
  `isLeader` tinyint(4) DEFAULT NULL COMMENT '是不是组长',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `zfbusers`;
CREATE TABLE `zfbusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_certified` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_student_certified` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alipayid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Alipay',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '平台信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `zfbusers_openid_unique` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=1328 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `zfconfig`;
CREATE TABLE `zfconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `private_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `alipay_pub_key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gatewayUrl` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charset` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '收款方登录号',
  `platform_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `platform_code` (`platform_code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;