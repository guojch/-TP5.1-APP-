/**
2019.3.26更新
 */

-- ----------------------------
-- Table structure for `basic_basic_config`
-- ----------------------------
CREATE TABLE `basic_basic_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL COMMENT '存储键名',
  `value` varchar(500) NOT NULL COMMENT '存储键值',
  `type` varchar(20) NOT NULL COMMENT '配置类型',
  `explain` varchar(200) NOT NULL COMMENT '说明',
  PRIMARY KEY (`config_id`),
  KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';
-- ----------------------------
-- Records of basic_basic_config
-- ----------------------------
INSERT INTO `basic_basic_config` VALUES ('1', 'user_agreement', '\r\n用户（购买服务或商品）协议\r\n\r\n\r\n\r\n用户：指注册时同意本协议内容的人\r\n\r\n1.请您在使用“家通达”平台服务之前，务必认真阅读本“购买协议”（简称“本规则”），且充分理解各条款内容，特别是涉及免除或限制责任条款。当您进入“家通达”服务平台，接受或使用平台各项服务时，即表示您已知悉并同意本规则的全部内容，如您不同意本规则中任何一条款，应当立即停止使用。\r\n\r\n2.您必须具备完全行为能力才能使用平台服务。若您不具备前述行为能力，则您本人及您的监护人、代理人应依法承担因此导致的全部法律责任。\r\n\r\n3. 我们的平台：指“家通达”服务平台（以下简称“平台”），是由深圳市家通达电子商务有限公司开发并运行的，包括官网（http://www.jiatd.com）、手机APP、官方客服电话、第三方网页链接、微信、短消息等在内的综合信息平台，可以向用户提供相关的需求服务信息。\r\n\r\n4. 我们的服务：在我们的平台，用户可以实现提出和获取相关服务的需求信息，以及查询相关的订单记录、费用结算、评价等活动。\r\n\r\n5. 我们的用户：依法具有完全行为能力的自然人、法人或接受平台服务的用户。\r\n\r\n一、', 'client', '用户协议');
INSERT INTO `basic_basic_config` VALUES ('2', 'register_agreement', '\r\n用户（购买服务或商品）协议\r\n\r\n\r\n\r\n用户：指注册时同意本协议内容的人\r\n\r\n1.请您在使用“家通达”平台服务之前，务必认真阅读本“购买协议”（简称“本规则”），且充分理解各条款内容，特别是涉及免除或限制责任条款。当您进入“家通达”服务平台，接受或使用平台各项服务时，即表示您已知悉并同意本规则的全部内容，如您不同意本规则中任何一条款，应当立即停止使用。\r\n\r\n2.您必须具备完全行为能力才能使用平台服务。若您不具备前述行为能力，则您本人及您的监护人、代理人应依法承担因此导致的全部法律责任。\r\n\r\n3. 我们的平台：指“家通达”服务平台（以下简称“平台”），是由深圳市家通达电子商务有限公司开发并运行的，包括官网（http://www.jiatd.com）、手机APP、官方客服电话、第三方网页链接、微信、短消息等在内的综合信息平台，可以向用户提供相关的需求服务信息。\r\n\r\n4. 我们的服务：在我们的平台，用户可以实现提出和获取相关服务的需求信息，以及查询相关的订单记录、费用结算、评价等活动。\r\n\r\n5. 我们的用户：依法具有完全行为能力的自然人、法人或接受平台服务的用户。\r\n\r\n一、', 'client', '注册协议');
INSERT INTO `basic_basic_config` VALUES ('3', 'version', '1.0', 'version', '版本');
INSERT INTO `basic_basic_config` VALUES ('4', 'version_android', '2', 'version', 'android内部版本');
INSERT INTO `basic_basic_config` VALUES ('5', 'version_android_explain', '版本1', 'version', 'android版本说明');
INSERT INTO `basic_basic_config` VALUES ('6', 'version_android_url', 'http://renren.yxsoft.net/apk/Wandoujia_307595_web_direct_binded.apk', 'version', 'android下载地址');
INSERT INTO `basic_basic_config` VALUES ('7', 'version_ios', '1.0.0', 'version', 'ios版本');
INSERT INTO `basic_basic_config` VALUES ('8', 'version_ios_url', '', 'version', 'ios下载地址');
INSERT INTO `basic_basic_config` VALUES ('9', 'telephone', '13063054219', 'client', '客服电话');
INSERT INTO `basic_basic_config` VALUES ('10', 'company', '厦门xxxx公司', 'client', '公司名称');

-- ----------------------------
-- Table structure for `basic_user`
-- ----------------------------
CREATE TABLE `basic_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `sec_code` varchar(50) NOT NULL DEFAULT '' COMMENT '安全码',
  `access_token` varchar(100) NOT NULL DEFAULT '' COMMENT '登录Token',
  `mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `avatar` text NOT NULL COMMENT '头像',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 1：正常 0：封禁',
  `reg_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册IP',
  `reg_channel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '注册渠道：默认1-APP注册',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `qq` varchar(20) NOT NULL DEFAULT '' COMMENT 'QQ号码',
  `weixin` varchar(20) NOT NULL DEFAULT '' COMMENT '微信账号',
  `weibo` varchar(20) NOT NULL DEFAULT '' COMMENT '微博帐号',
  `alipay` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝帐号',
  `wxpay` varchar(50) NOT NULL DEFAULT '' COMMENT '微信支付帐号',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `username` (`username`) USING BTREE,
  KEY `mobile` (`mobile`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for `basic_feedback`
-- ----------------------------
CREATE TABLE `basic_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '反馈类型：1、功能异常；2、其他问题',
  `content` text NOT NULL COMMENT '反馈内容',
  `on_time` int(11) NOT NULL DEFAULT '0' COMMENT '反馈时间',
  `remark` varchar(200) NOT NULL COMMENT '跟进备注',
  `deal_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '跟进状态：0-待处理，1-已处理',
  `deal_time` int(11) NOT NULL DEFAULT '0' COMMENT '处理时间',
  PRIMARY KEY (`feedback_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='反馈表';

-- ----------------------------
-- Table structure for `basic_file`
-- ----------------------------
CREATE TABLE `basic_file` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '附件ID',
  `file_name` varchar(200) NOT NULL DEFAULT '' COMMENT '文件原名',
  `save_name` varchar(200) NOT NULL DEFAULT '' COMMENT '保存后文件名',
  `ext` varchar(20) NOT NULL DEFAULT '' COMMENT '后缀类型',
  `size` varchar(20) NOT NULL DEFAULT '' COMMENT '文件大小',
  `bucket` varchar(20) NOT NULL DEFAULT '' COMMENT '存储空间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '文件状态 1-正常',
  `on_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Table structure for `basic_user_bind_oauth`
-- ----------------------------
CREATE TABLE `basic_user_bind_oauth` (
  `oauth_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型：qq、wechat、weibo',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `bind_mobile` varchar(30) NOT NULL DEFAULT '' COMMENT '绑定手机号',
  `oauth_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方用户唯一标识',
  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '微信/qq：open_id，微博：uid',
  `on_time` int(11) NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `source` varchar(100) NOT NULL DEFAULT '' COMMENT '设备',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0-未知，1-男，2-女',
  `avatar` varchar(256) NOT NULL DEFAULT '' COMMENT '头像',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`oauth_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方绑定表';

-- ----------------------------
-- Table structure for `basic_verify_code`
-- ----------------------------
CREATE TABLE `basic_verify_code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL DEFAULT '' COMMENT '验证码',
  `targetno` varchar(50) NOT NULL DEFAULT '' COMMENT '手机号码或者邮箱帐号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0-未处理，1-验证通过，2-验证失败',
  `auth_time` int(11) NOT NULL DEFAULT '0' COMMENT '处理时间',
  `auth_type` varchar(60) NOT NULL DEFAULT '' COMMENT 'register_mobile手机号码注册，login_mobile手机号码登录，find_password_mobile手机找回密码，bind_mobile绑定手机，bind_email绑定邮箱，change_mobile更换绑定手机号码',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户ID',
  `ip` varchar(100) NOT NULL DEFAULT '' COMMENT 'IP',
  `source` enum('web','app','wx_mini') NOT NULL DEFAULT 'app' COMMENT '来源设备',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间（以阿里云为准）',
  PRIMARY KEY (`code_id`),
  KEY `targetno` (`targetno`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';

-- ----------------------------
-- Table structure for `basic_admin`
-- ----------------------------
CREATE TABLE `basic_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '员工编号',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '员工姓名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '密码',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `access_token` varchar(100) NOT NULL DEFAULT '' COMMENT 'token',
  `group_id` int(11) NOT NULL DEFAULT '1' COMMENT '组别ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '员工状态：1、正常',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '手机号',
  `last_login_ip` varchar(50) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `basic_admin`(`id`, `username`, `password`, `access_token`) VALUES (1, 'admin', '218dbb225911693af03a713581a7227f', '1ac2fc424c64cdf80db98a246f439287');

-- ----------------------------
-- Table structure for `basic_admin_rule`
-- ----------------------------
CREATE TABLE `basic_admin_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('menu','file') NOT NULL DEFAULT 'file' COMMENT 'menu为菜单,file为权限节点',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '规则名称',
  `icon` varchar(50) NOT NULL DEFAULT '' COMMENT '图标',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为菜单',
  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (1, 'file', 0, '#', '管理员及权限', '', '', 1, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (2, 'file', 1, 'admin/admin/index', '管理员管理', '', '', 1, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (3, 'file', 1, 'admin/group/index', '权限管理', '', '', 1, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (4, 'file', 1, 'admin/rule/index', '菜单管理', '', '', 1, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (5, 'file', 2, 'admin/admin/add', '新增', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (6, 'file', 2, 'admin/admin/edit', '编辑', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (7, 'file', 2, 'admin/admin/delete', '删除', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (8, 'file', 2, 'admin/admin/state', '更新管理员状态', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (9, 'file', 2, 'admin/index/editpwd', '修改密码', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (10, 'file', 3, 'admin/group/add', '新增', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (11, 'file', 3, 'admin/group/edit', '编辑', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (12, 'file', 3, 'admin/group/view', '查看', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (13, 'file', 3, 'admin/group/delete', '删除', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (14, 'file', 3, 'admin/group/giveAccess', '权限分配', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (15, 'file', 3, 'admin/group/state', '权限状态变更', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (16, 'file', 4, 'admin/rule/add', '新增', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (17, 'file', 4, 'admin/rule/edit', '编辑', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (18, 'file', 4, 'admin/rule/view', '查看', '', '', 0, 0, 1, 1553847125, 0, 0);
INSERT INTO `basic_admin_rule`(`id`, `type`, `pid`, `name`, `title`, `icon`, `remark`, `ismenu`, `weigh`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (19, 'file', 4, 'admin/rule/delete', '删除', '', '', 0, 0, 1, 1553847125, 0, 0);


-- ----------------------------
-- Table structure for `basic_admin_group`
-- ----------------------------
CREATE TABLE `basic_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `rules` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '规则',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1：开启',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `basic_admin_group`(`id`, `title`, `rules`) VALUES (1, '超级管理员', '1,2,3,4,5');

-- ----------------------------
-- Table structure for `basic_admin_group_access`
-- ----------------------------
CREATE TABLE `basic_admin_group_access` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '组别ID',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `basic_admin_group_access`(`uid`, `group_id`) VALUES (1, 1);

-- ----------------------------
-- Table structure for `basic_order`
-- ----------------------------
CREATE TABLE `basic_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_name` varchar(150) NOT NULL DEFAULT '' COMMENT '订单名称',
  `pay_type` enum('alipay','wxpay','balance') NOT NULL COMMENT '订单支付渠道：alipay-支付宝，wxpay-微信，balance-余额',
  `obj_type` varchar(20) NOT NULL DEFAULT '' COMMENT '订单对象类型',
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单对象ID',
  `order_amount` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态：0-待支付，1-已支付',
  `order_body` varchar(200) NOT NULL DEFAULT '' COMMENT '订单内容',
  `order_uid` int(11) NOT NULL DEFAULT '0' COMMENT '订单用户ID',
  `order_username` varchar(100) NOT NULL DEFAULT '' COMMENT '订单用户名称',
  `currency` enum('CNY') NOT NULL DEFAULT 'CNY' COMMENT '订单货币',
  `source` varchar(20) NOT NULL DEFAULT '' COMMENT '订单来源',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`order_id`),
  KEY `order_uid` (`order_uid`),
  KEY `order_username` (`order_username`),
  KEY `obj_type` (`obj_type`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Table structure for `basic_order_charge`
-- ----------------------------
CREATE TABLE `basic_order_charge` (
  `charge_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '渠道订单ID',
  `order_type` varchar(20) NOT NULL DEFAULT '' COMMENT '订单类型',
  `pay_type` varchar(20) NOT NULL DEFAULT '' COMMENT '付款渠道：支付宝-alipay，微信-wxpay',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '内部订单ID',
  `obj_type` varchar(20) NOT NULL DEFAULT '' COMMENT '订单对象',
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单对象ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `amount` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态：0-待支付，1-已支付',
  `currency` enum('CNY') NOT NULL DEFAULT 'CNY' COMMENT '货币',
  `out_trade_no` varchar(200) NOT NULL DEFAULT '' COMMENT '商户订单号',
  `trade_no` varchar(200) NOT NULL DEFAULT '' COMMENT '交易流水号',
  `trade_status` varchar(50) NOT NULL DEFAULT '' COMMENT '商家返回的交易状态',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单付款时间（渠道方回调成功时间）',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单删除时间',
  PRIMARY KEY (`charge_id`),
  KEY `order_type` (`order_type`),
  KEY `order_id` (`order_id`),
  KEY `obj_type` (`obj_type`),
  KEY `obj_id` (`obj_id`),
  KEY `uid` (`uid`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='三方渠道订单表';

-- ----------------------------
-- Table structure for `basic_finance`
-- ----------------------------
CREATE TABLE `basic_finance` (
  `fina_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '财务记录ID',
  `fina_type` enum('in','out') NOT NULL COMMENT '财务进出方向：in，out',
  `fina_action` varchar(30) NOT NULL DEFAULT '' COMMENT '财务操作',
  `fina_cash` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '交易金额',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名称',
  `obj_type` varchar(30) NOT NULL DEFAULT '' COMMENT '对象类型',
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '对象ID',
  `user_balance` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '用户余额',
  `desc` varchar(200) NOT NULL DEFAULT '' COMMENT '财务描述',
  `currency` enum('CNY') NOT NULL DEFAULT 'CNY' COMMENT '币种',
  `source` varchar(10) NOT NULL DEFAULT '' COMMENT '财务来源：web，ios，android',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`fina_id`),
  KEY `fina_type` (`fina_type`),
  KEY `fina_action` (`fina_action`),
  KEY `order_id` (`order_id`),
  KEY `uid` (`uid`),
  KEY `username` (`username`),
  KEY `obj_type` (`obj_type`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户财务记录表';

-- ----------------------------
-- Table structure for `basic_finance_company`
-- ----------------------------
CREATE TABLE `basic_finance_company` (
  `fina_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公司财务记录ID',
  `fina_type` enum('in','out') NOT NULL DEFAULT 'in' COMMENT '财务进出方向：in，out',
  `fina_action` varchar(30) NOT NULL DEFAULT '' COMMENT '财务操作',
  `fina_cash` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '交易金额',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名称',
  `obj_type` varchar(30) NOT NULL DEFAULT '' COMMENT '对象类型',
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '对象ID',
  `desc` varchar(200) NOT NULL DEFAULT '' COMMENT '财务描述',
  `currency` enum('CNY') NOT NULL DEFAULT 'CNY' COMMENT '币种',
  `source` varchar(10) NOT NULL DEFAULT '' COMMENT '财务来源：web，ios，android',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`fina_id`),
  KEY `fina_type` (`fina_type`),
  KEY `fina_action` (`fina_action`),
  KEY `order_id` (`order_id`),
  KEY `obj_type` (`obj_type`),
  KEY `obj_id` (`obj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司财务记录表';