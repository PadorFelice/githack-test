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
$sql = <<<EOT

EOT;
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_SC_GBK.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_SC_UTF8.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_TC_BIG5.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/discuz_plugin_mini_pet_TC_UTF8.xml');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/install.php');
@unlink(DISCUZ_ROOT.'source/plugin/mini_pet/upgrade.php');
runquery($sql);
$finish = TRUE;
?>