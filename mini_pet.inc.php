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
require_once libfile('function/discuzcode');
require_once 'source/plugin/mini_pet/function/function_core.php';
global $_G;
if (!isset($_G['cache']['plugin'])) {loadcache('plugin');}
$plyes=($_G['cache']['plugin']['mini_pet']);
foreach($plyes as $key=>$value){ 
 $$key=$value;
}
if($_G['mobile']) {
  $footad=$mobilefootad ? $mobilefootad : $footad;
}
$diysd = explode ("\n", str_replace ("\r", "", $diysd));
$appurl=$_G['siteurl']."plugin.php?id=mini_pet";
$fabuset= unserialize($groups);
$jglist = parconfig($jg);
$groupso = $groupso ? $groupso : '1';
$admins = explode(",", $groupso);
$defaultpic = $defaultpic ? $defaultpic : 'source/plugin/mini_pet/images/nopic.jpg';
$navtitle = $title;
$mod = $_GET['mod'] ? $_GET['mod'] : 'index';
if($mod == 'index') {
    $where=$pageadd="";
	$key=stripsearchkey($_GET['key']);
    $keytype = intval($_GET['keytype']);
    if($_GET['key']){
	    if($keytype==0){ 
		    $where="title like '%".addcslashes($key, '%_')."%' AND";
	    }elseif($keytype==1){ 
		    $where="id='$key' AND";
	    }elseif($keytype==2){ 
		    $where="author='$key' AND";
	    }elseif($keytype==3){ 
		    $where="title like '%".addcslashes($key, '%_')."%' OR info like '%".addcslashes($key, '%_')."%' OR petname like '%".addcslashes($key, '%_')."%' OR xingge like '%".addcslashes($key, '%_')."%' OR sd5 like '%".addcslashes($key, '%_')."%'OR sd4 like '%".addcslashes($key, '%_')."%' OR sd3 like '%".addcslashes($key, '%_')."%' OR sd2 like '%".addcslashes($key, '%_')."%' OR sd1 like '%".addcslashes($key, '%_')."%' OR address like '%".addcslashes($key, '%_')."%' AND";
	    }
	    $keync=urlencode($key);
	    $pageadd="&keytype=$keytype&key=$keync";
    }
    $cate_id = intval($_GET['a']);
    if($cate_id){ 
        $mcate = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_cate') . " WHERE id = '$cate_id'");
	    $subids = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_cate')." WHERE id='$cate_id'");
	    if($subids){
		    $wb="cate IN ($cate_id,$subids) AND"; 
	    }else{
		    $wb="cate=$cate_id AND"; 
	    }
	    $pageadds="&a=$cate_id";
    }
    $sd = intval($_GET['b']);
    if($sd){ 
        $mcateb = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_cate') . " WHERE id = '$sd'");
	    $wc="cate='$sd' AND"; 
	    $pageaddx="&b=$sd";
    }
    $area_id = intval($_GET['bc']);
    if($area_id){ 
        $marea = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_area') . " WHERE id = '$area_id'");
	    $subids = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$area_id'");
	    if($subids){
		    $b_area="area IN ($subids) AND"; 
	    }else{
		    $b_area="area=$area_id AND"; 
	    }
	    $pageaddbc="&bc=$area_id";
    }
    $s_area_id = intval($_GET['sc']);
    if($s_area_id){ 
        $mareab = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_area') . " WHERE id = '$s_area_id'");
	    $s_area="area='$s_area_id' AND"; 
	    $pageaddsc="&sc=$s_area_id";
    }	
    $zhuangtai = intval($_GET['z']);
    if ($zhuangtai){
	    if ($zhuangtai==1){
		    $sz[] = "zhuangtai = 1";
		    $pageaddz="&z=1";
	    }elseif($zhuangtai==2) {
		    $sz[] = "zhuangtai = 2";
		    $pageaddz="&z=2";
        }
    }
    if ($sz){ $fz = "" . implode(" AND ", $sz) . " AND";}

    $money = dhtmlspecialchars($_GET['c']);
    if ($money=='mianyi'){
            $price = "price < '0' AND";
		    $pagejg="&money=$money";
    }elseif ($money=='free'){
		 $price = "price = '0' AND";
		 $pagejg="&money=$money";
    }elseif ($money){
	     $jgarr=explode('~',$money);
         if ($jgarr[0]==''){
		   $price = "(price <= '$jgarr[1]' AND price != '0') AND";
         }elseif ($jgarr[0]!='' && $jgarr[1]!=''){
		   $price = "(price >= '$jgarr[0]' AND price <= '$jgarr[1]') AND";
         }elseif ($jgarr[1]==''){
		   $price = "price >= '$jgarr[0]' AND";
         }
		$pagejg="&money=$money";
    }else{
        $money = 0;
    }

    $hr = intval($_GET['hr']);
    if ($hr){
	    if ($hr==1){
		    $sh[] = "hr = 1";
		    $pageaddu="&hr=1";
	    }elseif($hr==2) {
		    $sh[] = "hr = 2";
		    $pageaddu="&hr=2";
        }
    }
    if ($sh){ $fhr = "" . implode(" AND ", $sh) . " AND"; }

	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_item')." WHERE $where $price  $fhr $fz  $wb $wc $b_area $s_area display!='0'");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $eacha;
	if($counts) { 
		$sql = "SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE $where $wb $wc $price $fhr $fz $b_area $s_area  display!='0' ORDER BY top DESC,topdateline DESC,diynum DESC,updateline DESC LIMIT $starts,$eacha";
		$query = DB::query($sql);
		$mythread = $mythreads = array();
		while($mythread = DB::fetch($query)){
		    $piccount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_img')." WHERE aid='$mythread[id]'"); 
            $zizhutop = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE  topdateline <= ".time());
            if ($zizhutop){DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET `topdateline` = '0' WHERE topdateline <= ".time());}
			$cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$mythread[cate]'");
			    if($cate['upid']!=0){
				      $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
			          $mythread['cate'] = $cate['subject'];
				}else{
			          $mythread['cate'] = $cate['subject'];
		        }
			$area = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$mythread[area]'");
			    if($area['upid']!=0){
				      $area_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$area[upid]'");
			          $mythread['area'] = $area_t['subject']." ".$area['subject'];
				}else{
			          $mythread['area'] = $area['subject'];
		        }
	        $mythread['piccount']=$piccount;
        	$mythread['info'] = str_replace('&nbsp;','',cutstr(strip_tags(discuzcode($mythread['info']),"<b><p><i><s>"), 200, '...'));
			$mythreads[] = $mythread;
		}
		$mythreads = dhtmlspecialchars($mythreads);
	}
	$multis = "<div class='pages cl'>".multi($counts, $eacha, $pages, $appurl.$pageadds.$pageadd.$pageaddu.$pageaddz.$pageaddbc.$pageaddsc.$pageaddx)."</div>";
	   
	$r_id = intval($_GET['a']);
	$subid = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_cate')." WHERE id='$r_id'");
	if($subid) { 
		$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id IN ($subid) ORDER BY displayorder ASC,id ASC"); 
		while($ros = DB::fetch($query)) {
			$locals[$ros['id']] = $ros;
		}
	}	
	$bc_id = intval($_GET['bc']);
	$bc_subid = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$bc_id'");
	if($bc_subid) {
		$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id IN ($bc_subid) ORDER BY displayorder ASC,id ASC");
		while($ros = DB::fetch($query)) {
			$local_sc[$ros['id']] = $ros;
		}
	}
	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE tuijian ='1' AND display!='0' ORDER BY dateline DESC LIMIT 10");
	$tuijian = $tuijians = array();
	while($tuijian = DB::fetch($query)){
				$cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$tuijian[cate]'");
				   if($cate['upid']!=0){
				      $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
			          $tuijian['cate'] = "[".$cate_t['subject']."] ".$cate['subject'];
				   }else{
			          $tuijian['cate'] = $cate['subject'];
		           }
		$tuijians[] = $tuijian;
	}
	$tuijians = dhtmlspecialchars($tuijians);

	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE view !='0' AND display!='0' ORDER BY view DESC LIMIT 10");
	$hot = $hots = array();
	while($hot = DB::fetch($query)){
				$cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$hot[cate]'");
				   if($cate['upid']!=0){
				      $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
			          $hot['cate'] = "[".$cate_t['subject']."] ".$cate['subject'];
				   }else{
			          $hot['cate'] = $cate['subject'];
		           }
		$hots[] = $hot;
	}
	$hots = dhtmlspecialchars($hots);

	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_banner')." WHERE id ORDER BY id DESC");
	$banner = $banners = array();
	while($banner = DB::fetch($query)){
		$banners[] = $banner;
	}

    if ($cate_id!='0') {
      if ($sd!='0') {
           $catenav = $mcate['subject'] . "-" . $mcateb['subject']. "-";
      } else {
           $catenav = $mcate['subject']. "-";
      }
    }
    if ($area_id!='0') {
      if ($s_area_id!='0') {
           $areanav = $marea['subject'] . "-" . $mareab['subject']. "-";
      } else {
           $areanav = $marea['subject']. "-";
      }
    }
    $navtitle = $catenav . $areanav.$title;

	include template('mini_pet:list');
}elseif($_GET['mod']=='view'){
	$sid = intval($_GET['sid']);
	$uid = intval($_G['uid']);
    $mythread = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE id = '$sid' and display!='0'");
    !$mythread ? showmessage(lang('plugin/mini_pet', 'error'),"plugin.php?id=mini_pet") : '';
	DB::query("update ".DB::table('plugin_mini_pet_item')." set view=view+1 where id='$sid'");
	$mythread['dinfo'] = discuzcode($mythread['info']);
	$mythread['sellcounts']= DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_item')." WHERE uid='$mythread[uid]' and  hr='1' and  display!='0'");
	$mythread['buycounts']= DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_item')." WHERE uid='$mythread[uid]' and  hr='2' and  display!='0'");
	$favorites = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_favorites') . " WHERE sid = '$sid' AND uid = '$uid'");
	$cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$mythread[cate]'");
	if($cate['upid']!=0){
		$cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
		$mythread['cate_s'] = $cate_t['subject']." / ".$cate['subject'];
	}else{
		$mythread['cate_s'] = $cate['subject'];
	}
	    $area = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$mythread[area]'");
	if($area['upid']!=0){
		$area_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$area[upid]'");
		$mythread['area_s'] = $area_t['subject']." ".$area['subject'];
	}else{
		$mythread['area_s'] = $area['subject'];
    }
    if(submitcheck('applysubmit')){	
	    if($youkepinglunset==1){
            !$_G['uid'] ? $_G['username'] = $_G['clientip'] :'';
        }else{
	        if(!$_G['uid']){
				showmessage(lang('plugin/mini_pet', 'youkewuquanxianpinglun'), dreferer());
	        }
        }
	    if(empty($_GET['message'])){
	        showmessage(lang('plugin/mini_pet', 'wupinglunneirong'), dreferer());
	    }else{
		    $author = $_G['username'];
		    $message = strip_tags(addslashes($_GET['message']),"<b><p><i><s>");
		    $display = intval($display) == 1 ? 1 : 0; 
		    DB::insert('plugin_mini_pet_post',array('id' => '','sid' => $sid,'uid' => $uid,'author' => $author,'message' => $message,'display' => $display,'dateline' => $_G['timestamp']));
	    }
	    if(intval($display) == 0){
		    showmessage(lang('plugin/mini_pet', 'pinglundengdaishenhezhong'),dreferer());
	    }else{
		    showmessage(lang('plugin/mini_pet', 'tijiaochenggong'),dreferer());
	    }
	}
	$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_post')." WHERE sid='$sid' AND display!='0'");
	$page = intval($_GET['page']);
	$page = max($page, 1);
	$start = ($page - 1) * $each;
	
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_post')." WHERE sid='$sid' AND display!='0' ORDER BY dateline DESC LIMIT $start,$each");
		$pl = $pls = array();
		while($pl = DB::fetch($query)) {
			$pls[] = $pl;
		}
		$pls = dhtmlspecialchars($pls);
	}
	$multi =multi($count, $each, $page,'plugin.php?id=mini_pet&mod=view&sid='.$sid.'');
	
    if($_GET['pinglun'] == 'del'){
	    if($_G['groupid']!=1 && !in_array($_G['uid'], $admins)){
		    showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	    }
	    $sid = intval($_GET['sid']);
	    $did = intval($_GET['did']); 
        if($_GET['formhash'] == FORMHASH) {
            $pl = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_post')." where id = '$did'");
	        if($pl){
	            DB::delete('plugin_mini_pet_post',array('id'=> $did));
	            showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
	        }else{
				showmessage(lang('plugin/mini_pet', 'caozuocuowu'), dreferer());
            }
        }
    }
	$imgquery = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_img')." WHERE aid='$sid' ORDER BY id DESC,dateline DESC");
	$imglist = $imglists = array();
	while($imglist = DB::fetch($imgquery)){
        $pic = getimagesize($imglist['img']);
		$imglist['wdith'] = $pic[0];
		$imglist['height'] = $pic[1];
		$imglistid[] = $imglist['id'];
		$imglists[] = $imglist;
    }
	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE tuijian ='1' AND display!='0' ORDER BY dateline DESC LIMIT 10");
	$tuijian = $tuijians = array();
	while($tuijian = DB::fetch($query)){
	    $cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$tuijian[cate]'");
		    if($cate['upid']!=0){
			    $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
			    $tuijian['cate'] = "[".$cate_t['subject']."] ".$cate['subject'];
			}else{
			    $tuijian['cate'] = $cate['subject'];
		    }
		$tuijians[] = $tuijian;
	}
	$tuijians = dhtmlspecialchars($tuijians);

	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE view >'1' AND display!='0' ORDER BY view DESC LIMIT 10");
	$hot = $hots = array();
	while($hot = DB::fetch($query)){
		$cate = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$hot[cate]'");
		if($cate['upid']!=0){
		    $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$cate[upid]'");
		    $hot['cate'] = "[".$cate_t['subject']."] ".$cate['subject'];
		}else{
		    $hot['cate'] = $cate['subject'];
		}
		$hots[] = $hot;
	}
	$hots = dhtmlspecialchars($hots);

    $navtitle = $mythread['title']." - ".$mythread['cate_s']." - ".$mythread['area_s']." - ".$title;	
	$metadescription = str_replace('&nbsp;','',cutstr(strip_tags($mythread['info'],"<b><p><i><s>"), 100, '...'));
	$metakeywords = $mythread['title'].",".$mythread['cate_s'].",".$mythread['petname'].",".$metakeywords;
	include template('mini_pet:view');

}elseif($_GET['mod'] == 'reply'){
    $id = intval($_GET['did']);
	$sid = intval($_GET['sid']);
    $uid = intval($_G['uid']);
    $item = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id = '$sid'");
	if($item['uid']==$uid){
        $pl = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_post') . " WHERE id = '$id'");
	    $pl['message'] = discuzcode($pl['message']);
	    if(submitcheck('applysubreply')){
	        $reply = dhtmlspecialchars($_GET['reply']);
		    DB::update('plugin_mini_pet_post', array('reply' => $reply), "id='$id'");
	        showmessage(lang('plugin/mini_pet', 'tijiaochenggong'),dreferer());
    	}
    }else{
		showmessage(lang('plugin/mini_pet', 'faburencainenghuifu'), array(), array('alert' => error));
	}
	include template('mini_pet:reply');
}elseif($_GET['mod']=='freshen'){
    if(!$_G['uid']) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
	$sid = intval($_GET['sid']);
	$timestamp = $_G['timestamp'];
	$now = date('Y-m-d',$timestamp);
    $info = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id = '$sid'");
	$uid = intval($info['uid']);
    $updateline = date('Y-m-d',$info['updateline']);
    if($_GET['formhash'] == FORMHASH) {
	    if($uid==$_G['uid']||$_G['groupid']=="1"||in_array($_G['uid'], $admins)){
	        if($now==$updateline){
	            showmessage(lang('plugin/mini_pet', 'shuaxinshibai'), '', array(), array('alert' => error));
            }else{
	            DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET `updateline` = '$timestamp' WHERE `id` = '$sid'");
                DB::insert('plugin_mini_pet_record',array('id' => '','sid' => $sid,'uid' => $_G['uid'],'author' => $_G['username'],'title' => $info['title'],'xftype' => '3','dateline' =>$_G['timestamp']));
	            showmessage(lang('plugin/mini_pet', 'shuaxinok'), '', array(), array('alert' => right));
            }
	    }else{
	        showmessage(lang('plugin/mini_pet', 'caozuocuowu'), dreferer());
	    }
    }
} elseif ($_GET['mod'] == 'zhiding') {
    if(!$_G['uid']) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
    if($creditc == '0'||!$paytypec){showmessage(lang('plugin/mini_pet', 'zhidinggongnengweikaifang'));}
	$sid = intval($_GET['sid']);
    $item = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id = '$sid'");
    if($item['top']=="1"){
		showmessage(lang('plugin/mini_pet', 'yizhiding'), array(), array('alert' => error));
	}
	$daytime = intval($_GET['day']);
	$time = ($daytime * 86400)+$_G['timestamp']; 
    $newcreditc = $daytime * $creditc; 
    $moneytypec = $_G['setting']['extcredits'][$paytypec]['title'];
    $paymoney = getuserprofile('extcredits'."$paytypec");
	if(submitcheck('applysubzhiding')){
		  if($_GET['day']<="0"){	
		      showmessage(lang('plugin/mini_pet', 'zhidingtianshuweitianxie'), dreferer());
	      }else{
              if($paymoney<$newcreditc){
                 $tixing= lang('plugin/mini_pet', 'zhidingxiaohaotishi').$newcreditc.$moneytypec;
        	     showmessage(lang('plugin/mini_pet', $tixing));
              }else{
                 DB::insert('plugin_mini_pet_record',array('id' => '','sid' => $sid,'uid' => $_G['uid'],'author' => $_G['username'],'title' => $item['title'],'day' => $daytime,'pay' => $newcreditc,'moneytype' => $moneytypec,'endtime' => $time,'xftype' => '2','dateline' =>$_G['timestamp']));
			     DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET `topdateline` = '$time' WHERE `id` = '$sid'");
			     updatemembercount($_G['uid'], array($paytypec => -$newcreditc));
              }
		      showmessage(lang('plugin/mini_pet', 'tijiaochenggong'),dreferer());
          }
	}
		include template('mini_pet:zhiding');
} elseif ($_GET['mod'] == 'favorites') {
    if(!$_G['uid']) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
    if ($_GET['formhash'] == FORMHASH) {
        $sid = intval($_GET['sid']);
        $uid = intval($_G['uid']);
        $info = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id = '$sid'");
        $favorites = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_favorites') . " WHERE sid = '$sid' AND uid = '$uid'");
        if ($favorites) {
            DB::query("DELETE FROM " . DB::table('plugin_mini_pet_favorites') . " WHERE sid = '$sid' and uid = '$uid'");
			if($_G['mobile']) {
                 showmessage(lang('plugin/mini_pet', 'quxiaoshoucang'),dreferer());
			} else {
                showmessage(lang('plugin/mini_pet', 'quxiaoshoucang') , '', array() , array('alert' => right));
			}
        } else {
            DB::insert('plugin_mini_pet_favorites', array('id' => '','sid' => $sid,'uid' => $uid,'title' => $info['title'],'dateline' => $_G['timestamp']));
			if($_G['mobile']) {
                 showmessage(lang('plugin/mini_pet', 'shoucangchenggong'),dreferer());
			} else {
                showmessage(lang('plugin/mini_pet', 'shoucangchenggong') , '', array() , array('alert' => right));
			}
            
        }
    }
} elseif ($_GET['mod'] == 'delpic') {
    if(!$_G['uid']) {
        showmessage('not_loggedin', NULL, array(), array('login' => 1));
    }
    $uid = intval($_G['uid']);
    $picsrc = addslashes($_GET['picsrc']);
	if($_GET['formhash'] == FORMHASH){
       $img = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_img') . " WHERE img='$picsrc'");
       if($img) {
		   if ($_G['groupid'] == 1 || in_array($_G['uid'], $admins)||$img['uid']==$uid) {
			   DB::query("DELETE FROM ".DB::table('plugin_mini_pet_img')." WHERE img = '$picsrc'");
	    	   unlink($picsrc);
		   }
       }
	}
}
function parconfig($str){
	$return = array();
	$array = explode("\n",str_replace("\r","",$str));
	foreach ($array as $v){
	   $t = explode("=",$v);
	   $t[0] = trim($t[0]);
	   $return[$t[0]] = $t[1];
	}
	return $return;
} 
?>