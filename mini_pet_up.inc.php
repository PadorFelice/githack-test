<?php
/*
 * CopyRight  : [DisM!] (C)2001-2099 DisM Inc.
 * Created on : 2020-02-11,11:00:52
 * Author     : DisM!Ӧ������ dism.taobao.com $
 * Description: ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!.
 * ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 * ����ַ�������Ȩ��,�뼰ʱ��֪����,���Ǽ���ɾ��!
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once 'source/plugin/mini_pet/class/upic.class.php';
$plyes=($_G['cache']['plugin']['mini_pet']);
foreach($plyes as $key=>$value){ 
 $$key=$value;
}
$uploaddx=$picdx*1024;
$newpicwidth=1000;
if ($_FILES['file']['error']==0 && $_GET['formhash'] == FORMHASH) {
	 $picsize = $_FILES['file']['size'];
	 $imageinfo = getimagesize($_FILES['file']['tmp_name']);
		 if ($imageinfo[0] <= 0) {
             echo json_encode(array("error" =>lang('plugin/mini_pet', 'tupiangeshibuzhengque')));
			 exit ;
		 }
     $filetype = array("jpg","jpeg","gif","png","JPG","JPEG","GIF","PNG");
	 $arr=explode(".", strtolower($_FILES['file']["name"]));
     $hz = $arr[count($arr) - 1];
         if (!in_array($hz, $filetype)) {
             echo json_encode(array("error" => lang('plugin/mini_pet', 'tupiangeshibuzhengque')));
			 exit ;
         }
     $pics =$_POST['name'];
	 $img_dir = "source/plugin/mini_pet/upimg/".date("Ymd")."/";
     if(!file_exists($img_dir)){
      mkdir($img_dir,0777,true);
     }
     $pic = $img_dir . $pics;
        if($picsize <= $uploaddx){
            if (@copy($_FILES['file']['tmp_name'], $pic) || @move_uploaded_file($_FILES['file']['tmp_name'], $pic)) {
             @unlink($_FILES['file']['tmp_name']);
            }
        }else{
             echo json_encode(array("error" =>lang('plugin/mini_pet', 'tupiantaida')));
             exit ;
        }
		if ($imageinfo[0] > $newpicwidth) {
			new myThumbClass($pic,1,2,$pic,1,$newpicwidth); 
		}
	    echo json_encode(array("error" => "0", "pic" => $pic));
}
//From: Dism_taobao-com
?>