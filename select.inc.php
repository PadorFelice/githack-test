<?php
/*
 * CopyRight  : [DisM!] (C)2001-2099 DisM Inc.
 * Created on : 2020-02-11,11:00:52
 * Author     : DisM!应用中心 dism.taobao.com $
 * Description: 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!.
 * 本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 * 如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$action = addslashes($_GET['action']);
$bl_name= addslashes($_GET['bl']);
$lid = intval($_GET['lid']);
	if($action == 'cate') {
		$show = '';
		if($lid) {
			$subid = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_cate')." WHERE id='{$lid}'");
			if($subid) {
				$show = '<select class="ps" name="'.$bl_name.'" id="'.$bl_name.'"><option value=""></option>';
				$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id IN ($subid)");
				while($row = DB::fetch($query)) {
					$show .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
				}
				$show .= '</select>';
			} else {
				$show = '';
			}
		}
	}elseif($action=='area'){
		$show = '';
		if($lid) {
			$subid = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='{$lid}'");
			if($subid) {
				$show = '<select class="ps" name="'.$bl_name.'" id="'.$bl_name.'"><option value=""></option>';
				$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id IN ($subid)");
				while($row = DB::fetch($query)) {
					$show .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
				}
				$show .= '</select>';
			} else {
				$show = '';
			}
		}
	}
include template("mini_pet:select");
?>