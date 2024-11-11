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
loadcache('plugin');
$plyes=($_G['cache']['plugin']['mini_pet']);
foreach($plyes as $key=>$value){ 
 $$key=$value;
}
$picdx=$picdx*1024;
$newpicwidth=1000;
$navtitle = $title;
$diysd = explode ("\n", str_replace ("\r", "", $diysd));
$fabuset= unserialize($groups);
$mianshenhe= unserialize($mianshenhe);
$groupso = $groupso ? $groupso : '1';
$admins = explode(",", $groupso);
$p = $_GET['p'] ? $_GET['p'] : 'index';
if(!$_G['uid']) {
    showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
if($p=='index'||$p=='mylist'){
	$uid = intval($_G['uid']);
	$counts = DB::result_first("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE uid = '$uid' AND display!='0' ORDER BY id DESC");
	$countr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_item')." WHERE uid='$uid'");
	$pager = intval($_GET['page']);
	$pager = max($pager, 1);
	$starts = ($pager - 1) * 20;
		if($countr) {
			$rs=DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE uid='$uid' ORDER BY dateline DESC LIMIT $starts,20");
			while ($rw=DB::fetch($rs)){
		        $pa = DB::fetch(DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$rw[cate]'"));
		            if($pa['upid']!=0){
		                $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$pa[upid]'");
		               	$rw['cate'] = $cate_t['subject']." - ".$pa['subject'];
		            }else{
		               	$rw['cate'] = $pa['subject'];
		            }
		        $pb = DB::fetch(DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$rw[area]'"));
		            if($pb['upid']!=0){
		                $area_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$pb[upid]'");
		               	$rw['area'] = $area_t['subject']." - ".$pb['subject'];
		            }else{
		               	$rw['area'] = $pb['subject'];
		            }
				$manylist[]=$rw;
			}
			    $manylist = dhtmlspecialchars($manylist);
		}
	$moneytype = $_G['setting']['extcredits'][$paytype]['title'];
    $paymoney = getuserprofile('extcredits'."$paytype");
	$moneytypeb = $_G['setting']['extcredits'][$paytypeb]['title'];
    $paymoneyb = getuserprofile('extcredits'."$paytypeb");
	$appurl=$_G['siteurl']."plugin.php?id=mini_pet:mini_pet_user&p=".$p;
	$multir = "<div class='pages cl' style='margin-top:10px;'>".multi($countr, 20, $pager, $appurl.$pageadd)."</div>";
}elseif($p=='adminalllist'){
    if($_G['groupid']==1||in_array($_G['uid'], $admins)){
	    $counts = DB::result_first("SELECT * FROM ".DB::table('plugin_mini_pet_item'));
		$countr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_item'));
		$pager = intval($_GET['page']);
		$pager = max($pager, 1);
		$starts = ($pager - 1) * 20;
		if($countr) {
			$rs=DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." ORDER BY dateline DESC LIMIT $starts,20");
			while ($rw=DB::fetch($rs)){
		        $rw['title'] = cutstr($rw['title'], 70, '...');
	            $sqla = "SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$rw[cate]'";
		        $pa = DB::fetch(DB::query($sqla));
		            if($pa['upid']!=0){
		                $cate_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE id = '$pa[upid]'");
		                $rw['cate'] = $cate_t['subject']." - ".$pa['subject'];
		            }else{
		               	$rw['cate'] = $pa['subject'];
		            }
		         $sqlb = "SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$rw[area]'";
		         $pb = DB::fetch(DB::query($sqlb));
		            if($pb['upid']!=0){
		               	$area_t = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE id = '$pb[upid]'");
		               	$rw['area'] = $area_t['subject']." - ".$pb['subject'];
		            }else{
		               	$rw['area'] = $pb['subject'];
		         }
				$manylist[]=$rw;
			}
			    $manylist = dhtmlspecialchars($manylist);
		}
		$appurl=$_G['siteurl']."plugin.php?id=mini_pet:mini_pet_user&p=adminalllist";
		$multir = "<div class='pages cl' style='margin-top:10px;'>".multi($countr, 20, $pager, $appurl.$pageadd)."</div>";
        if(submitcheck('applysubmsh')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET display='1' WHERE id='$aid' LIMIT 1");
			    $nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());	
	    }elseif(submitcheck('applysubmqxsh')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
		        $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET display='0' WHERE id='$aid' LIMIT 1");
			    $nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());
        }elseif(submitcheck('applysubmtj')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET tuijian='1' WHERE id='$aid' LIMIT 1");
			    $nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());
	    }elseif(submitcheck('applysubmqxtj')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET tuijian='0' WHERE id='$aid' LIMIT 1");
			    $nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());	
        }elseif(submitcheck('applysubmzd')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET top='1' WHERE id='$aid' LIMIT 1");
			    $nums++;
	 	    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());
	    }elseif(submitcheck('applysubmqxzd')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET top='0' WHERE id='$aid' LIMIT 1");
			    $nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());	
        }elseif(submitcheck('applysubmdel')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
			    $aid = intval($aid);
			    $active=DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE id ='$aid'LIMIT 0 , 1");
	                $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_img')." WHERE aid = '$aid'");
	                $delz = $delzs = array();
	                while($delz = DB::fetch($query)){
		            if ($delz["img"]!=false){
			           unlink($delz["img"]);
		              }
		             $delzs[] = $delz;
	                }
			        if ($active["pic"]!=false){
			           unlink($active["pic"]);
			        }
                DB::query("DELETE a,b,c,d FROM ".DB::table('plugin_mini_pet_item')." AS a LEFT JOIN ".DB::table('plugin_mini_pet_favorites')." AS b ON a.id = b.sid LEFT JOIN ".DB::table('plugin_mini_pet_img')." AS c ON a.id = c.aid LEFT JOIN ".DB::table('plugin_mini_pet_post')." AS d ON a.id = d.sid  WHERE a.id = '$aid' ");$nums++;
		    }
            showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());	
        }
	}else{
	    showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif($p=='adminpic'){
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
	    $countr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_img'));
		$pager = intval($_GET['page']);
		$pager = max($pager, 1);
		$starts = ($pager - 1) * 10;
		if($countr) {
			$rs=DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_img')." ORDER BY dateline DESC LIMIT $starts,10");
			while ($rw=DB::fetch($rs)){
				$manylist[]=$rw;
			}
			    $manylist = dhtmlspecialchars($manylist);
		}
		$appurl=$_G['siteurl']."plugin.php?id=mini_pet:mini_pet_user&p=adminpic";
		$multir = "<div class='pages cl' style='margin-top:10px;'>".multi($countr, 10, $pager, $appurl.$pageadd)."</div>";
        if(submitcheck('applysubmdel')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $ssd) {
			    $ssd = intval($ssd);
		        $active=DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_img')." WHERE id ='$ssd' LIMIT 0 , 1");
	            unlink($active["img"]);
			    DB::delete('plugin_mini_pet_img',array('id'=> $ssd));
			    $nums++;
		    }
            showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
        }
    }else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif($p=='adminpicdel'){
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
	    $pid = intval($_GET['pid']);
        if($_GET['formhash'] == FORMHASH) {
            $pic = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_img')." where id = '$pid'");
	        DB::delete('plugin_mini_pet_img',array('id'=> $pid));
	        unlink($pic["img"]);
	        showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
        }
	}else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif($p=='add'||$p=='add2'){
	$groups = unserialize($groups);
	if(!in_array($_G['groupid'], $groups)){
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('login' => error));
	}else{
	    include_once 'source/plugin/mini_pet/class/upic.class.php';
        $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE upid='0'");
	    while($row = DB::fetch($query)) {
		    $cates[$row['id']] = $row;
	    }
	    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE upid='0'");
	    while($row = DB::fetch($query)) {
		    $areas[$row['id']] = $row;
	    }
	    $moneytype = $_G['setting']['extcredits'][$paytype]['title'];
	    $moneytypeb = $_G['setting']['extcredits'][$paytypeb]['title'];
        $paymoney = getuserprofile('extcredits'."$paytype");
        $paymoneyb = getuserprofile('extcredits'."$paytypeb");
	    if(submitcheck('applysubmit')){
            if ($p == 'add') {
                if($credit!="0" && $paytype){
                    if($paymoney<$credit){
                        $tixing= lang('plugin/mini_pet', 'xiaohaotishi').$credit.$moneytype;
        	            showmessage(lang('plugin/mini_pet', $tixing), dreferer());
                    }
                }
            }elseif($p == 'add2') {
                if($creditb!="0" && $paytypeb){
                    if($paymoneyb<$creditb){
                        $tixing= lang('plugin/mini_pet', 'xiaohaotishi').$creditb.$moneytypeb;
        	            showmessage(lang('plugin/mini_pet', $tixing), dreferer());
                    }
                }
            }
			$uid = intval($_G['uid']);	
		    $hr=intval($_GET['hr']);
            $title = dhtmlspecialchars(trim($_GET['title']));
            $pic = addslashes(trim($_GET['pic']));
			$cate = intval($_GET['cate_two']) ? intval($_GET['cate_two']) : intval($_GET['cate_1']);
            $petname = dhtmlspecialchars($_GET['petname']);
			$area = intval($_GET['area_two']) ? intval($_GET['area_two']) : intval($_GET['area_1']);
            $address = dhtmlspecialchars($_GET['address']);
			$xingbie = dhtmlspecialchars($_GET['xingbie']);
		    $nianling = dhtmlspecialchars($_GET['nianling']);
		    $tizhong = dhtmlspecialchars($_GET['tizhong']);
			$shengao = dhtmlspecialchars($_GET['shengao']);
		    $maose = dhtmlspecialchars($_GET['maose']);
			$xingge = dhtmlspecialchars($_GET['xingge']);
		    $sd1 = dhtmlspecialchars($_GET['sd1']);
			$sd2 = dhtmlspecialchars($_GET['sd2']);
			$sd3 = dhtmlspecialchars($_GET['sd3']);
			$sd4 = dhtmlspecialchars($_GET['sd4']);
			$sd5 = dhtmlspecialchars($_GET['sd5']);
            $info = addslashes(trim($_GET['info']));
			$price = intval($_GET['price']);
			$zhuangtai = intval($_GET['zhuangtai']); 
            $xingming = dhtmlspecialchars($_GET['xingming']);
            $tel = dhtmlspecialchars($_GET['tel']);
            $weixin = dhtmlspecialchars($_GET['weixin']);
            $qq = intval($_GET['qq']);
            $qitalianxi = dhtmlspecialchars($_GET['qitalianxi']);
			$baomi = intval($_GET['baomi']); 
			$tuijian=intval($_GET['tuijian']);
			$top=intval($_GET['top']);
            if ($_G['groupid']=="1"||in_array($_G['groupid'], $mianshenhe)){
                $display =1; 
            }else{
			    $display =0; 
            }
			$diynum=intval($_GET['diynum']);
			$timestamp = $_G['timestamp'];
			if($_FILES['file']['error']==0){
				$filesize = $_FILES['file']['size'] <= $picdx ;   
				$filetype = array("jpg", "jpeg", "gif", "png","JPG","JPEG","GIF","PNG");
				$arr=explode(".", $_FILES["file"]["name"]);
				$hz=$arr[count($arr)-1];
				    if(!in_array($hz, $filetype)){
					    showmessage(lang('plugin/mini_pet', 'tupiangeshibuzhengque'));	
					}
				$filepath = "source/plugin/mini_pet/logo/".date("Ymd")."/";
				$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
				if(!file_exists($filepath)){ mkdir($filepath); }
					if($filesize){ 
						if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
							 @unlink($_FILES['file']['tmp_name']);
						}
					}else{
						showmessage(lang('plugin/mini_pet', 'chaochudaxiao'));	
					}
					$pic = "source/plugin/mini_pet/logo/".date("Ymd")."/".$randname."";
					$resizeimage = new myThumbClass($pic,260,1,$pic,-1,0); 
							
				 }
				 DB::insert('plugin_mini_pet_item',array('id' => '','uid' => $uid,'author' => $_G['username'],'hr' => $hr,'title' => $title,'pic' => $pic,'cate' =>$cate,'petname' =>$petname,'area' => $area,'address' =>$address,'xingbie' => $xingbie,'nianling' => $nianling,'tizhong' => $tizhong,'shengao' => $shengao,'maose' => $maose,'xingge' => $xingge,'sd1' => $sd1,'sd2' => $sd2,'sd3' => $sd3,'sd4' => $sd4,'sd5' => $sd5,'info' => $info,'price' => $price,'zhuangtai' => $zhuangtai,'xingming' => $xingming,'tel' => $tel,'qq' => $qq,'qitalianxi' => $qitalianxi,'baomi' => $baomi,'tuijian' => $tuijian,'top' => $top,'display' => $display,'diynum' => $diynum,'dateline' => $timestamp,'updateline' => $timestamp));
		            $aid = DB::insert_id();
		            $countz = count($_GET['filelist']);
			        for($i=0;$i<$countz;$i++){
	                  	$img = addslashes($_GET['filelist'][$i]);
						 DB::insert('plugin_mini_pet_img',array('id' => '','aid' => $aid,'uid' => $uid,'title' => $title,'img' => $img,'dateline' => $timestamp));
			        } 
				 if ($p == 'add') {
				     if($credit!="0" && $paytype){
	                     updatemembercount($_G['uid'], array($paytype => -$credit));
			             DB::insert('plugin_mini_pet_record',array('id' => '','sid' => $aid,'uid' => $_G['uid'],'author' => $_G['username'],'title' => $title,'pay' => $credit,'moneytype' => $moneytype,'xftype' => '1','dateline' =>$timestamp));
                     }
                 }elseif($p == 'add2') {
                     if($creditb!="0" && $paytypeb){
	                     updatemembercount($_G['uid'], array($paytypeb => -$creditb));
			             DB::insert('plugin_mini_pet_record',array('id' => '','sid' => $aid,'uid' => $_G['uid'],'author' => $_G['username'],'title' => $title,'pay' => $creditb,'moneytype' => $moneytypeb,'xftype' => '1','dateline' =>$timestamp));
                     }
                 }
		         if($_G['groupid']=="1"||in_array($_G['groupid'], $mianshenhe)){
				     showmessage(lang('plugin/mini_pet', 'fabuchenggong'), 'plugin.php?id=mini_pet:mini_pet_user&p=mylist', array(), array('alert' => right));
			     }else{
			         for($i=0;$i<count($admins);$i++){
				         $message ='<a href="plugin.php?id=mini_pet&#58;mini_pet_user&p=adminalllist" target="_blank">'.lang('plugin/mini_pet', 'yonghufabuxinxinxi').'</a>';
				         notification_add($admins[$i], 'system',$message,  $notevars = array(), $system = 0);
			         }
				     showmessage(lang('plugin/mini_pet', 'fabudengdaishenhe'), 'plugin.php?id=mini_pet:mini_pet_user&p=mylist', array(), array('alert' => right));
		         }
			}
	    }
}elseif($p=='edit'){
	$id = intval($_GET['sid']);
	$active = DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_item')." WHERE id='$id'");
	$uid = intval($active['uid']);
	if($active['uid']==$_G['uid']||$_G['groupid']=="1"||in_array($_G['uid'], $admins)){
	    include_once 'source/plugin/mini_pet/class/upic.class.php';
	    $cate = DB::result_first("SELECT upid FROM ".DB::table('plugin_mini_pet_cate')." WHERE id='$active[cate]'");
	    if($cate) {
		    $catetwoshow = '<select name="cate_two" >';
		    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE upid='$cate'");
		    while($row = DB::fetch($query)) {
			    if($row['id'] == $active['cate']) {
				    $catetwoshow .= '<option value="'.$row['id'].'" selected >'.$row['subject'].'</option>';
			    } else {
				    $catetwoshow .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
			    }
		    }
		    $catetwoshow .= '</select>';
	    } else {
		    $cate = $active['cate'];
	    }
	    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_cate')." WHERE upid='0'");
	    while($row = DB::fetch($query)) {
		    $cates[$row['id']] = $row;
	    }
		$cates = dhtmlspecialchars($cates);

	    $areaid = DB::result_first("SELECT upid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$active[area]'");	
	    if($areaid) {
		    $areatwoshow = '<select name="area_two" >';
		    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE upid='$areaid'");
		    while($row = DB::fetch($query)) {
			    if($row['id'] == $active['area']) {
				    $areatwoshow .= '<option value="'.$row['id'].'" selected >'.$row['subject'].'</option>';
			    } else {
				    $areatwoshow .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
			    }
		    }
		    $areatwoshow .= '</select>';
	    } else {
		    $areaid = $active['area'];
	    }
	    $areaid = dhtmlspecialchars($areaid);
		
	    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE upid='0'");
	    while($row = DB::fetch($query)) {
		    $areas[$row['id']] = $row;
	    }
	    $areas = dhtmlspecialchars($areas);

	    $psql = "SELECT * FROM ".DB::table('plugin_mini_pet_img')." WHERE aid='$id'ORDER BY id DESC,dateline DESC";
	    $query = DB::query($psql);
	    $pser = $psers = array();
	    while($pser = DB::fetch($query)){
	    	$psers[] = $pser;
	    }
	    $psers = dhtmlspecialchars($psers);

	    if(submitcheck('applysubmit')){
		    $sid = intval($_GET['sid']);
		    $title = dhtmlspecialchars(trim($_GET['title']));
		    $pic = addslashes(trim($_GET['pic']));
		    $cate = intval($_GET['cate_two']) ? intval($_GET['cate_two']) : intval($_GET['cate_1']);
		    $petname = dhtmlspecialchars($_GET['petname']);
		    $area = intval($_GET['area_two']) ? intval($_GET['area_two']) : intval($_GET['area_1']);
		    $address = dhtmlspecialchars($_GET['address']);
		    $xingbie = dhtmlspecialchars($_GET['xingbie']);
		    $nianling = dhtmlspecialchars($_GET['nianling']);
		    $tizhong = dhtmlspecialchars($_GET['tizhong']);
		    $shengao = dhtmlspecialchars($_GET['shengao']);
			$maose = dhtmlspecialchars($_GET['maose']);
			$xingge = dhtmlspecialchars($_GET['xingge']);
			$sd1 = dhtmlspecialchars($_GET['sd1']);
		    $sd2 = dhtmlspecialchars($_GET['sd2']);
		    $sd3 = dhtmlspecialchars($_GET['sd3']);
		    $sd4 = dhtmlspecialchars($_GET['sd4']);
		    $sd5 = dhtmlspecialchars($_GET['sd5']);
		    $info = dhtmlspecialchars(trim($_GET['info']));
		    $price = intval($_GET['price']);
		    $zhuangtai = intval($_GET['zhuangtai']); 
		    $xingming = dhtmlspecialchars($_GET['xingming']);
		    $tel = dhtmlspecialchars($_GET['tel']);
		    $weixin = dhtmlspecialchars($_GET['weixin']);
		    $qq = intval($_GET['qq']);
		    $qitalianxi = dhtmlspecialchars($_GET['qitalianxi']);
		    $baomi = intval($_GET['baomi']); 
		    $tuijian=intval($_GET['tuijian']);
		    $top=intval($_GET['top']);
		    if ($_G['groupid']=="1"||in_array($_G['groupid'], $mianshenhe)){
		        $display =1; 
            }else{
				$display = 0 ; 
            }	
		    $diynum=intval($_GET['diynum']);
		    $timestamp = $_G['timestamp'];
		    if($_FILES['file']['error']==0){
		        if ($active["pic"]!=false){
		            unlink($active["pic"]);
	            }
				$filesize = $_FILES['file']['size'] <= $picdx ;   
				$filetype = array("jpg", "jpeg", "gif", "png","JPG","JPEG","GIF","PNG");
				$arr=explode(".", $_FILES["file"]["name"]);
				$hz=$arr[count($arr)-1];
			    if(!in_array($hz, $filetype)){
					showmessage(lang('plugin/mini_pet', 'tupiangeshibuzhengque'));	
				}
				$filepath = "source/plugin/mini_pet/logo/".date("Ymd")."/";
				$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
				if(!file_exists($filepath)){ mkdir($filepath); }
				if($filesize){ 
					if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
						@unlink($_FILES['file']['tmp_name']);
				    }
				}else{
					showmessage(lang('plugin/mini_pet', 'chaochudaxiao'));	
				}
				$pic = "source/plugin/mini_pet/logo/".date("Ymd")."/".$randname."";
				$resizeimage = new myThumbClass($pic,260,1,$pic,-1,0); 
			}	
			DB::update('plugin_mini_pet_item',array('title' => $title,'pic' => $pic,'cate' =>$cate,'petname' =>$petname,'area' => $area,'address' =>$address,'xingbie' => $xingbie,'nianling' => $nianling,'tizhong' => $tizhong,'shengao' => $shengao,'maose' => $maose,'xingge' => $xingge,'sd1' => $sd1,'sd2' => $sd2,'sd3' => $sd3,'sd4' => $sd4,'sd5' => $sd5,'info' => $info,'price' => $price,'zhuangtai' => $zhuangtai,'xingming' => $xingming,'tel' => $tel,'weixin' => $weixin,'qq' => $qq,'qitalianxi' => $qitalianxi,'baomi' => $baomi,'tuijian' => $tuijian,'top' => $top,'display' => $display,'diynum' => $diynum),"id='$sid'");
        	DB::query("delete from ".DB::table('plugin_mini_pet_img')." where aid='$sid' and uid='$uid'");
			$countz = count($_GET['filelist']);
				for($i=0;$i<$countz;$i++){
				     $img = addslashes($_GET['filelist'][$i]);
                     DB::insert('plugin_mini_pet_img',array('id' => '','aid' => $sid,'uid' => $uid,'title' => $title,'img' => $img,'dateline' => $timestamp));
				}  
		    showmessage(lang('plugin/mini_pet', 'gengxinok'),"plugin.php?id=mini_pet:mini_pet_user&p=edit&sid=".$sid, array(), array('alert' => right));	
	    }
	}else{
		showmessage(lang('plugin/mini_pet', 'caozuocuowu'), '', array(), array('login' => true));
	}
}elseif($p=='consumption'){	
	$uid = intval($_G['uid']);
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_record')." WHERE uid='$uid'");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * 20;
    if($counts) {
        $query=DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_record')." WHERE uid='$uid' ORDER BY id DESC LIMIT $starts,20");
	    $xiaofei = $xiaofeis = array();
	    while($xiaofei = DB::fetch($query)){
		    $xiaofeis[] = $xiaofei;
	    }
		$xiaofeis = dhtmlspecialchars($xiaofeis);
    }
	$multis = "<div class='pages cl'>".multi($counts, 20, $pages,"plugin.php?id=mini_pet:mini_pet_user&p=".$p.$pageadd)."</div>";
}elseif($p=='favorites'){	
	$uid = intval($_G['uid']);
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_favorites')." WHERE uid='$uid'");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * 20;
    if($counts) {
	    $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_favorites')." WHERE uid = '$uid' ORDER BY dateline DESC LIMIT $starts,20");
	    $sc = $scs = array();
	    while($sc = DB::fetch($query)){
		   $scs[] = $sc;
	    }
	    $scs = dhtmlspecialchars($scs);
    }
	$multis = "<div class='pages cl'>".multi($counts, 20, $pages,"plugin.php?id=mini_pet:mini_pet_user&p=".$p.$pageadd)."</div>";
}elseif ($p=='favoritesdel'){
	$id=intval($_GET['sid']);
	$uid = intval($_G['uid']);
    if($_GET['formhash'] == FORMHASH) {
	    DB::query("DELETE FROM ".DB::table('plugin_mini_pet_favorites')." WHERE id = '$id' and uid = '$uid'");
        showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
    }
}elseif($p=='plshenheok'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id = intval($_GET['sid']);
	    if($_GET['formhash'] == FORMHASH) {
		    DB::query("UPDATE ".DB::table('plugin_mini_pet_post')." SET display='1' WHERE id='$id'");
            showmessage(lang('plugin/mini_pet', 'shenheok'), dreferer());
	    }
	}else{
		   showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
	}
}elseif($p=='plqxshenhe'){	
    if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id = intval($_GET['sid']);
	    if($_GET['formhash'] == FORMHASH) {
		    DB::query("UPDATE ".DB::table('plugin_mini_pet_post')." SET display='0' WHERE id='$id'");
		    showmessage(lang('plugin/mini_pet', 'qxshenhe'), dreferer());
	    }
	}else{
		   showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
	}
}elseif($p=='adminpinglun'){
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
		$counts = DB::result_first("SELECT * FROM ".DB::table('plugin_mini_pet_post'));
		$countr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('plugin_mini_pet_post'));
		$pager = intval($_GET['page']);
		$pager = max($pager, 1);
		$starts = ($pager - 1) * 20;
		if($countr) {
			$rs=DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_item')." a, ".DB::table('plugin_mini_pet_post')." b WHERE  a.id = b.sid ORDER BY b.dateline DESC LIMIT $starts,20");
			while ($rw=DB::fetch($rs)){
				$manylist[]=$rw;
			}
			    $manylist = dhtmlspecialchars($manylist);
		}
		$appurl=$_G['siteurl']."plugin.php?id=mini_pet:mini_pet_user&p=adminpinglun";
		$multir = "<div class='pages cl' style='margin-top:10px;'>".multi($countr, 20, $pager, $appurl.$pageadd)."</div>";
	    if(submitcheck('applysubmsh')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
		        $aid = intval($aid);
		    	DB::query("UPDATE ".DB::table('plugin_mini_pet_post')." SET display='1' WHERE id='$aid' LIMIT 1");
		    	$nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());	
        }elseif(submitcheck('applysubmqxsh')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $aid) {
		    	$aid = intval($aid);
		    	DB::query("UPDATE ".DB::table('plugin_mini_pet_post')." SET display='0' WHERE id='$aid' LIMIT 1");
		    	$nums++;
		    }
		    showmessage(lang('plugin/mini_pet', 'gengxinok'), dreferer());
	    }elseif(submitcheck('applysubmdel')){
		    $pl_id = implode('|', $_GET['piliang']);
		    $deid = explode('|', $pl_id);
		    $nums = 0;
		    foreach($deid as $ssd) {
		    	$ssd = intval($ssd);
		    	DB::delete('plugin_mini_pet_post',array('id'=> $ssd));
		    	$nums++;
		    }
            showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
		}
	}else{
		   showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
	}
}elseif($p=='shenheok'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id = intval($_GET['sid']);
	    if($_GET['formhash'] == FORMHASH) {
		   DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET display='1' WHERE id='$id'");
           showmessage(lang('plugin/mini_pet', 'shenheok'), dreferer());
        }
	}else{
		   showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
	}
}elseif($p=='qxshenhe'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id = intval($_GET['sid']);
	    if($_GET['formhash'] == FORMHASH) {
		   DB::query("UPDATE ".DB::table('plugin_mini_pet_item')." SET display='0' WHERE id='$id'");
           showmessage(lang('plugin/mini_pet', 'qxshenhe'), dreferer());
        }
	}else{
		   showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
	}
} elseif ($p == 'yizhaodao') {
    $uid = intval($_G['uid']);
    $sid = intval($_GET['sid']);
    $active = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id='$sid'");
    if ($active['uid']==$uid || $_G['groupid'] == 1 || in_array($_G['uid'], $admins)) {
        if ($_GET['formhash'] == FORMHASH) {
            if ($active['zhuangtai']==1) {
                DB::query("UPDATE " . DB::table('plugin_mini_pet_item') . " SET zhuangtai='2' WHERE id='$sid'");
            } else {
                DB::query("UPDATE " . DB::table('plugin_mini_pet_item') . " SET zhuangtai='1' WHERE id='$sid'");
            }
                showmessage(lang('plugin/mini_pet', 'gengxinok') , dreferer());
        }
    } else {
        showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
    }showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
}elseif ($p=='del'){
    $id = intval($_GET['sid']);
    $uid = intval($_G['uid']);
    $active = DB::fetch_first("SELECT * FROM " . DB::table('plugin_mini_pet_item') . " WHERE id ='$id'");
    if ($_G['groupid'] == 1 || in_array($_G['uid'], $admins)||$active['uid']==$uid) {
        if($_GET['formhash'] == FORMHASH) {
	        $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_img')." WHERE aid = '$id'");
	        $delz = $delzs = array();
	        while($delz = DB::fetch($query)){
		        if ($delz["img"]!=false){
			       unlink($delz["img"]);
	            }
		        $delzs[] = $delz;
	        }
		    if ($active["pic"]!=false){
		        unlink($active["pic"]);
		    }
		    DB::query("DELETE a,b,c,d FROM ".DB::table('plugin_mini_pet_item')." AS a LEFT JOIN ".DB::table('plugin_mini_pet_favorites')." AS b ON a.id = b.sid LEFT JOIN ".DB::table('plugin_mini_pet_img')." AS c ON a.id = c.aid LEFT JOIN ".DB::table('plugin_mini_pet_post')." AS d ON a.id = d.sid  WHERE a.id = '$id' ");
		    showmessage(lang('plugin/mini_pet', 'shanchuok'), dreferer());
        }
    }else{
	       showmessage(lang('plugin/mini_pet', 'caozuocuowu'));
    }
//banner
}elseif($p=='banneradd'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
	    if(submitcheck('addbannersubmit')){
            $title = dhtmlspecialchars($_GET['title']);
            $pic = addslashes($_GET['pic']);
            $url = addslashes($_GET['url']);
            $timestamp = $_G['timestamp'];
			if($_FILES['file']['error']==0){
			    $filetype = array("jpg", "jpeg", "gif", "png","JPG","JPEG","GIF","PNG");
				$arr=explode(".", $_FILES["file"]["name"]);
				$hz=$arr[count($arr)-1];
				if(!in_array($hz, $filetype)){
					showmessage(lang('plugin/mini_pet', 'tupiangeshibuzhengque'));	
				}
			    $filepath = "source/plugin/mini_pet/banner/".date("Ymd")."/";
				$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
				if(!file_exists($filepath)){ mkdir($filepath); }			
				if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
					 @unlink($_FILES['file']['tmp_name']);
				}
				$pic = "source/plugin/mini_pet/banner/".date("Ymd")."/".$randname."";
			}
		DB::insert('plugin_mini_pet_banner',array('id' => '','title' => $title,'pic' => $pic,'url' => $url, 'dateline' => $timestamp));
		showmessage(lang('plugin/mini_pet', 'fabuchenggong'), "plugin.php?id=mini_pet:mini_pet_user&p=banner", array(), array('alert' => right));
	    }
	}else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif($p=='banneredit'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id=intval($_GET['bid']);
	    $active=DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_banner')." WHERE id ='$id'");
	    if(submitcheck('editbannersubmit')){
            $title = dhtmlspecialchars($_GET['title']);
            $pic = addslashes($_GET['pic']);
            $url = addslashes($_GET['url']);
			if($_FILES['file']['error']==0){
			    if (isset($active['pic'])){
	                unlink($active["pic"]);
	            }
			    $filetype = array("jpg", "jpeg", "gif", "png","JPG","JPEG","GIF","PNG");
			    $arr=explode(".", $_FILES["file"]["name"]);
			    $hz=$arr[count($arr)-1];
			    if(!in_array($hz, $filetype)){
				    showmessage(lang('plugin/mini_pet', 'tupiangeshibuzhengque'));	
			    }
			    $filepath = "source/plugin/mini_pet/banner/".date("Ymd")."/";
			    $randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
			    if(!file_exists($filepath)){ mkdir($filepath); }
			    if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
				    @unlink($_FILES['file']['tmp_name']);
			    }
			}
			$pic = "source/plugin/mini_pet/banner/".date("Ymd")."/".$randname."";
	    }
		DB::update('plugin_mini_pet_banner',array('title' => $title,'pic' => $pic,'url' => $url),"id='$id'");
		showmessage(lang('plugin/mini_pet', 'fabuchenggong'), dreferer());
	}else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif($p=='banner'){	
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $perpage = 10;
        $page = max(1, intval($_GET['page']));
        $start_limit = ($page - 1) * $perpage;
        $count = DB::result_first("SELECT count(*) FROM ".DB::table('plugin_mini_pet_banner'));
        $multipage = multi($count, $perpage, $page, "plugin.php?id=mini_pet:mini_pet_user&p=banner");
        $query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_banner'). " ORDER BY id DESC LIMIT $start_limit, $perpage");
	    $banner = $banners = array();
	    while($banner = DB::fetch($query)){
		    $banner['dateline'] = gmdate('Y-m-d', $banner['dateline'] + $_G['setting']['timeoffset'] * 3600); 
		    $banners[] = $banner;
	    }
	    $banners = dhtmlspecialchars($banners);
	}else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}elseif ($p=='bannerdel'){
	if($_G['groupid']==1||in_array($_G['uid'], $admins)){
        $id=intval($_GET['bid']);
        if($_GET['formhash'] == FORMHASH) {
			$active=DB::fetch_first("SELECT * FROM ".DB::table('plugin_mini_pet_banner')." WHERE id ='$id'");
			if ($active["pic"]!=false){
		    unlink($active["pic"]);
	        }
	       DB::query("DELETE FROM ".DB::table('plugin_mini_pet_banner')." WHERE id = '$id'");
           showmessage(lang('plugin/mini_pet', 'shanchuok'), 'plugin.php?id=mini_pet:mini_pet_user&p=banner', array(), array('alert' => right));
        }
	}else{
		showmessage(lang('plugin/mini_pet', 'wuquanxiancaozuo'), '', array(), array('alert' => error));
	}
}
include(template("mini_pet:mini_pet_user"));
?>