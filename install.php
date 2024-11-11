<?php
/*
 * CopyRight  : [DisM!] (C)2001-2099 DisM Inc.
 * Created on : 2020-02-11,11:00:52
 * Author     : DisM!应用中心 dism.taobao.com $
 * Description: 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!.
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sql = <<<EOF
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_item` (
	  `id` int(11) NOT NULL auto_increment,
	  `diynum` int(11) NOT NULL,
	  `uid` int(11) NOT NULL,
	  `author` varchar(80) NOT NULL,
	  `hr` tinyint(1)  NOT NULL,
	  `title` text NOT NULL,
	  `pic` text NOT NULL,
	  `cate` int(11) NOT NULL,
	  `petname` text NOT NULL,
	  `area` int(11) NOT NULL,
	  `address` text NOT NULL,
	  `xingbie` tinyint(1) NOT NULL,
	  `nianling` text NOT NULL,
	  `tizhong` text NOT NULL,
	  `shengao` text NOT NULL,
	  `maose` text NOT NULL,
	  `xingge` text NOT NULL,
	  `sd1` text NOT NULL,
	  `sd2` text NOT NULL,
	  `sd3` text NOT NULL,
	  `sd4` text NOT NULL,
	  `sd5` text NOT NULL,
	  `info` text NOT NULL,
	  `price` int(11) NOT NULL,
	  `zhuangtai` tinyint(1) NOT NULL,
   	  `xingming` text NOT NULL,
   	  `tel` text NOT NULL,
   	  `qq` text NOT NULL,
	  `weixin` varchar(80) NOT NULL,
   	  `qitalianxi` text NOT NULL,
	  `baomi` tinyint(1)  NOT NULL,
	  `view` int(11) NOT NULL,
      `tuijian` tinyint(1) NOT NULL,
	  `top` tinyint(1)  NOT NULL,
	  `topdateline` int(11) NOT NULL,
      `display` tinyint(1) NOT NULL,
	  `updateline` int(11) NOT NULL,
	  `dateline` int(11) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_cate` (
	  `id` int(11) NOT NULL auto_increment,
	  `upid` int(11) NOT NULL,
	  `subid` text NOT NULL,
	  `subject` varchar(255) NOT NULL,
	  `displayorder` int(11) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_area` (
	  `id` int(11) NOT NULL auto_increment,
	  `upid` int(11) NOT NULL,
	  `subid` text NOT NULL,
	  `subject` varchar(255) NOT NULL,
	  `displayorder` int(11) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_img` (
	  `id` int(11) NOT NULL auto_increment,
	  `aid` int(11) NOT NULL,
	  `uid` int(11) NOT NULL,
  	  `title` text NOT NULL,
	  `img` text NOT NULL,
	  `dateline` int(10) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;
   CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_post` (
	  `id` int(11) NOT NULL auto_increment,
	  `sid` int(11) NOT NULL,
	  `uid` int(11) NOT NULL,
  	  `author` varchar(50) NOT NULL,
  	  `message` text NOT NULL,
  	  `reply` text NOT NULL,
  	  `display` tinyint(1) NOT NULL,
 	  `dateline` int(11) NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM;
   CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_favorites` (
   	  `id` int(11) NOT NULL auto_increment,
 	  `sid` int(11) NOT NULL,
   	  `uid` int(11) NOT NULL,
   	  `author` varchar(100) NOT NULL,
   	  `title` varchar(100) NOT NULL,
   	  `dateline` int(11) NOT NULL,
      PRIMARY KEY  (`id`)
   ) ENGINE=MyISAM;
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_record` (
	  `id` int(11) NOT NULL auto_increment,
      `sid` int(11) NOT NULL,
   	  `uid` int(11) NOT NULL,
   	  `author` varchar(100) NOT NULL,
   	  `title` text NOT NULL,
   	  `day` int(11) NOT NULL,
   	  `pay` int(11) NOT NULL,
   	  `moneytype` text NOT NULL,
   	  `endtime` int(11) NOT NULL,
   	  `xftype` tinyint(1) NOT NULL,
   	  `dateline` int(11) NOT NULL,
       PRIMARY KEY  (`id`)
   ) ENGINE=MyISAM;
	CREATE TABLE IF NOT EXISTS `pre_plugin_mini_pet_banner` (
	  `id` int(11) NOT NULL auto_increment,
	  `title` varchar(100) NOT NULL,
	  `pic` text NOT NULL,
	  `url` text NOT NULL,
	  `dateline` int(11) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM;
INSERT INTO `pre_plugin_mini_pet_cate` (`id`, `upid`, `subid`, `subject`, `displayorder`) VALUES
(1, 0, '3,4,6,11', '$installlang[cate1]', 0),
(2, 0, '5,12', '$installlang[cate2]', 0),
(3, 1, '', '$installlang[cate7]', 0),
(4, 1, '', '$installlang[cate8]', 0),
(5, 2, '', '$installlang[cate11]', 0),
(6, 1, '', '$installlang[cate9]', 0),
(7, 0, '', '$installlang[cate3]', 0),
(8, 0, '', '$installlang[cate4]', 0),
(9, 0, '', '$installlang[cate5]', 0),
(10, 0, '', '$installlang[cate6]', 0),
(11, 1, '', '$installlang[cate10]', 0),
(12, 2, '', '$installlang[cate12]', 0);
EOF;
runquery($sql);
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_SC_GBK.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_SC_UTF8.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_TC_BIG5.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_TC_UTF8.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/upgrade.php');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/install.php');
$finish =true;
?>