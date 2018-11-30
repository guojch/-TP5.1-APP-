/**
2018.11.30更新
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
-- Records of basic2_basic_config
-- ----------------------------
INSERT INTO `basic2_basic_config` VALUES ('1', 'user_agreement', '\r\n用户（购买服务或商品）协议\r\n\r\n\r\n\r\n用户：指注册时同意本协议内容的人\r\n\r\n1.请您在使用“家通达”平台服务之前，务必认真阅读本“购买协议”（简称“本规则”），且充分理解各条款内容，特别是涉及免除或限制责任条款。当您进入“家通达”服务平台，接受或使用平台各项服务时，即表示您已知悉并同意本规则的全部内容，如您不同意本规则中任何一条款，应当立即停止使用。\r\n\r\n2.您必须具备完全行为能力才能使用平台服务。若您不具备前述行为能力，则您本人及您的监护人、代理人应依法承担因此导致的全部法律责任。\r\n\r\n3. 我们的平台：指“家通达”服务平台（以下简称“平台”），是由深圳市家通达电子商务有限公司开发并运行的，包括官网（http://www.jiatd.com）、手机APP、官方客服电话、第三方网页链接、微信、短消息等在内的综合信息平台，可以向用户提供相关的需求服务信息。\r\n\r\n4. 我们的服务：在我们的平台，用户可以实现提出和获取相关服务的需求信息，以及查询相关的订单记录、费用结算、评价等活动。\r\n\r\n5. 我们的用户：依法具有完全行为能力的自然人、法人或接受平台服务的用户。\r\n\r\n一、', 'client', '用户协议');
INSERT INTO `basic2_basic_config` VALUES ('2', 'register_agreement', '\r\n用户（购买服务或商品）协议\r\n\r\n\r\n\r\n用户：指注册时同意本协议内容的人\r\n\r\n1.请您在使用“家通达”平台服务之前，务必认真阅读本“购买协议”（简称“本规则”），且充分理解各条款内容，特别是涉及免除或限制责任条款。当您进入“家通达”服务平台，接受或使用平台各项服务时，即表示您已知悉并同意本规则的全部内容，如您不同意本规则中任何一条款，应当立即停止使用。\r\n\r\n2.您必须具备完全行为能力才能使用平台服务。若您不具备前述行为能力，则您本人及您的监护人、代理人应依法承担因此导致的全部法律责任。\r\n\r\n3. 我们的平台：指“家通达”服务平台（以下简称“平台”），是由深圳市家通达电子商务有限公司开发并运行的，包括官网（http://www.jiatd.com）、手机APP、官方客服电话、第三方网页链接、微信、短消息等在内的综合信息平台，可以向用户提供相关的需求服务信息。\r\n\r\n4. 我们的服务：在我们的平台，用户可以实现提出和获取相关服务的需求信息，以及查询相关的订单记录、费用结算、评价等活动。\r\n\r\n5. 我们的用户：依法具有完全行为能力的自然人、法人或接受平台服务的用户。\r\n\r\n一、', 'client', '注册协议');
INSERT INTO `basic2_basic_config` VALUES ('3', 'version', '1.0', 'version', '版本');
INSERT INTO `basic2_basic_config` VALUES ('4', 'version_android', '2', 'version', 'android内部版本');
INSERT INTO `basic2_basic_config` VALUES ('5', 'version_android_explain', '版本1', 'version', 'android版本说明');
INSERT INTO `basic2_basic_config` VALUES ('6', 'version_android_url', 'http://renren.yxsoft.net/apk/Wandoujia_307595_web_direct_binded.apk', 'version', 'android下载地址');
INSERT INTO `basic2_basic_config` VALUES ('7', 'version_ios', '1.0.0', 'version', 'ios版本');
INSERT INTO `basic2_basic_config` VALUES ('8', 'version_ios_url', '', 'version', 'ios下载地址');
INSERT INTO `basic2_basic_config` VALUES ('9', 'telephone', '13063054219', 'client', '客服电话');
INSERT INTO `basic2_basic_config` VALUES ('10', 'company', '厦门xxxx公司', 'client', '公司名称');

-- ----------------------------
-- Table structure for `basic_user`
-- ----------------------------
CREATE TABLE `basic_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `sec_code` varchar(50) NOT NULL COMMENT '安全码',
  `access_token` varchar(100) NOT NULL COMMENT '登录Token',
  `mobile` varchar(50) NOT NULL COMMENT '手机号码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `avatar` text NOT NULL COMMENT '头像',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态 1：正常 0：封禁',
  `reg_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` varchar(20) NOT NULL COMMENT '注册IP',
  `reg_channel` tinyint(4) NOT NULL DEFAULT '1' COMMENT '注册渠道：默认1-APP注册',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `last_login_ip` varchar(20) NOT NULL COMMENT '最后登录IP',
  `qq` varchar(20) NOT NULL COMMENT 'QQ号码',
  `weixin` varchar(20) NOT NULL COMMENT '微信账号',
  `weibo` varchar(20) NOT NULL COMMENT '微博帐号',
  `alipay` varchar(50) NOT NULL COMMENT '支付宝帐号',
  `wxpay` varchar(50) NOT NULL COMMENT '微信支付帐号',
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
  `file_name` varchar(200) NOT NULL COMMENT '文件原名',
  `save_name` varchar(200) NOT NULL COMMENT '保存后文件名',
  `ext` varchar(20) NOT NULL COMMENT '后缀类型',
  `size` varchar(20) NOT NULL COMMENT '文件大小',
  `bucket` varchar(20) NOT NULL COMMENT '存储空间',
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
  `type` varchar(30) NOT NULL COMMENT '类型：qq、wechat、weibo',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `bind_mobile` varchar(30) NOT NULL COMMENT '绑定手机号',
  `oauth_sn` varchar(100) NOT NULL COMMENT '第三方用户唯一标识',
  `openid` varchar(100) NOT NULL COMMENT '微信/qq：open_id，微博：uid',
  `on_time` int(11) NOT NULL DEFAULT '0' COMMENT '绑定时间',
  `source` varchar(100) NOT NULL COMMENT '设备',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0-未知，1-男，2-女',
  `avatar` varchar(256) NOT NULL COMMENT '头像',
  `delete_time` int(11) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`oauth_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='第三方绑定表';

-- ----------------------------
-- Table structure for `basic_verify_code`
-- ----------------------------
CREATE TABLE `basic_verify_code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL COMMENT '验证码',
  `targetno` varchar(50) NOT NULL COMMENT '手机号码或者邮箱帐号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0-未处理，1-验证通过，2-验证失败',
  `auth_time` int(11) NOT NULL DEFAULT '0' COMMENT '处理时间',
  `auth_type` varchar(60) NOT NULL COMMENT 'register_mobile手机号码注册，login_mobile手机号码登录，find_password_mobile手机找回密码，bind_mobile绑定手机，bind_email绑定邮箱，change_mobile更换绑定手机号码',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '关联用户ID',
  `ip` varchar(100) NOT NULL COMMENT 'IP',
  `source` enum('web','app','wx_mini') NOT NULL DEFAULT 'app' COMMENT '来源设备',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间（以阿里云为准）',
  PRIMARY KEY (`code_id`),
  KEY `targetno` (`targetno`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';