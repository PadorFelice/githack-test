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
$operation = $_GET['operation'];
if($operation == 'del') {
   if ($_GET['formhash'] == FORMHASH) {
	$lid = intval($_GET['lid']);
	if($lid) {
		$upcid = DB::result_first("SELECT upid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$lid'");
		if($upcid) {
			$subid = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$upcid'");
			$subarr = explode(",", $subid);
			foreach($subarr as $key=>$value) {
				if($value == $lid) {
					unset($subarr[$key]);
					break;
				}
			}
			DB::query("UPDATE ".DB::table('plugin_mini_pet_area')." SET subid='".implode(",", $subarr)."' WHERE id='$upcid'");
		}
		DB::query("DELETE FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$lid'");
	}
	mini_pet_updatacache();
	cpmsg(lang('plugin/mini_pet', 'shanchuok'), 'action=plugins&operation=config&identifier=mini_pet&pmod=mini_pet_area', 'succeed');
  }
}
if(!submitcheck('editsubmit')) {
?>
<script type="text/JavaScript">
var rowtypedata = [
	[[1,'<input type="text" class="txt" name="newlocalorder[]" value="0" />', 'td25'], [2, '<input name="newlocal[]" value="" size="20" type="text" class="txt" />']],
	[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsublocal[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
	];
</script>
<?php
	showformheader('plugins&operation=config&identifier=mini_pet&pmod=mini_pet_area');
	showtableheader('');
	showsubtitle(array(lang('plugin/mini_pet', 'areapaixu'),lang('plugin/mini_pet', 'areafenleimingcheng'),lang('plugin/mini_pet', 'areacaozuo')));
	$plugin_mini_pet_area = array();
	$query = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE upid='0' ORDER BY displayorder ASC,id ASC");
	while($row = DB::fetch($query)) {
		$plugin_mini_pet_area[$row['id']] = $row;
		$squery = DB::query("SELECT * FROM ".DB::table('plugin_mini_pet_area')." WHERE upid='$row[id]' ORDER BY displayorder ASC,id ASC");
		while($srow = DB::fetch($squery)) {
			$plugin_mini_pet_area[$row['id']]['sublocal'][$srow['id']] = $srow;
		}
	}
	if($plugin_mini_pet_area) {
		foreach($plugin_mini_pet_area as $id=>$local) {
			$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$local['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$local['subject'].'"></div></td>';
			if(!$local['subid']) {
				$show .= '<td><a href="?action=plugins&operation=config&identifier=mini_pet&pmod=mini_pet_area&operation=del&formhash='.FORMHASH.'&lid='.$id.'">'.lang('plugin/mini_pet', 'shanchu').'</td></tr>';
			} else {
				$show .= '<td>&nbsp;</td></tr>';
			}
			echo $show;
			if($local['sublocal']) {
				foreach($local['sublocal'] as $subid=>$slocal) {
					echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$slocal['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$slocal['subject'].'"></div></td><td><a href="?action=plugins&operation=config&identifier=mini_pet&pmod=mini_pet_area&operation=del&formhash='.FORMHASH.'&lid='.$slocal['id'].'">'.lang('plugin/mini_pet', 'shanchu').'</td></tr>';
				}
			}
			echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.lang('plugin/mini_pet', 'areatianjiazifenlei').'</a></div></td></tr>';
		}	
	}
	echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/mini_pet', 'areatianjiafenlei').'</a></div></td></tr>';
	showsubmit('editsubmit');
	showtablefooter();/*Dism_taobao-com*/
	showformfooter();
} else {
	$order = $_GET['order'];
	$name = $_GET['name'];
	$newsublocal = $_GET['newsublocal'];
	$newlocal = $_GET['newlocal'];
	$newsuborder = $_GET['newsuborder'];
	$newlocalorder = $_GET['newlocalorder'];
	if(is_array($order)) {
		foreach($order as $id=>$value) {
			DB::update('plugin_mini_pet_area', array('displayorder' => intval($order[$id]), 'subject' => daddslashes($name[$id])), "id='$id'");
		}
	}
	if(is_array($newlocal)) {
		foreach($newlocal as $key=>$name) {
			if(empty($name)) {
				continue;
			}
			$cid = DB::insert('plugin_mini_pet_area', array('upid' => '0', 'subject' => daddslashes($name), 'displayorder' => intval($newlocalorder[$key])), 1);
		}
	}
	if(is_array($newsublocal)) {
		foreach($newsublocal as $cid=>$sublocal) {
			$subtype = DB::result_first("SELECT subid FROM ".DB::table('plugin_mini_pet_area')." WHERE id='$cid'");
			foreach($sublocal as $key=>$name) {
				$subid = DB::insert('plugin_mini_pet_area', array('upid' => $cid, 'subject' => daddslashes($name), 'displayorder' => intval($newsuborder[$cid][$key])), 1);
				$subtype .= $subtype ? ','.$subid : $subid;
			}
			DB::query("UPDATE ".DB::table('plugin_mini_pet_area')." SET subid='$subtype' WHERE id='$cid'");
		}
	}
	mini_pet_updatacache();
	cpmsg(lang('plugin/mini_pet', 'gengxinok'), 'action=plugins&operation=config&identifier=mini_pet&pmod=mini_pet_area', 'succeed');	
}
function  mini_pet_updatacache(){
	require_once libfile('function/cache');
    $typeareaquery = DB::query("SELECT * FROM " . DB::table('plugin_mini_pet_area') . " WHERE  upid='0' ORDER BY displayorder ASC,id ASC");
    $typeareadata = array();
    $upidareadata = array();
    while ($typearea = DB::fetch($typeareaquery)) {
        $typeareadata[$typearea['id']] = $typearea;
        $upidareaquery = DB::query("SELECT * FROM " . DB::table('plugin_mini_pet_area') . " where upid = " . $typearea['id'] . "  ORDER BY displayorder ASC,id ASC");
        while ($upidarea = DB::fetch($upidareaquery)) {
            $upidareadata[$typearea['id']][$upidarea['id']] = $upidarea;
        }
    }
	writetocache('mini_pet_areacachedata', getcachevars(array('typeareadata' => $typeareadata,  'upidareadata' => $upidareadata)));
}
//From: Dism_taobao-com
?>