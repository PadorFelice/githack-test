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
$catecachefile = DISCUZ_ROOT.'data/sysdata/cache_mini_pet_catecachedata.php';
if(file_exists($catecachefile)){@unlink($catecachefile);}
$areacachefile = DISCUZ_ROOT.'data/sysdata/cache_mini_pet_areacachedata.php';
if(file_exists($areacachefile)){@unlink($areacachefile);}
$sql = <<<EOF
DROP TABLE IF EXISTS `pre_plugin_mini_pet_item`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_img`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_cate`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_area`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_post`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_favorites`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_record`;
DROP TABLE IF EXISTS `pre_plugin_mini_pet_banner`;
EOF;
runquery($sql);
$finish = TRUE;
?>