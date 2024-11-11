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
/*
 * Created on 20:31 2011-8-2
 * Author : LKK , http://lianq.net
 * 使用方法：
 *$resizeimage = new myThumbClass($file_name,120,90,$thumb,0,0);  //生成120x90大小
 *$resizeimage = new myThumbClass($file_name,1,2,$thumb,1,233);   //生成高,宽之中最大233
 *$resizeimage = new myThumbClass($file_name,660,1,$thumb,-1,0);  //生成宽度660
 *$resizeimage = new myThumbClass($file_name,1,660,$thumb,-1,0);  //生成高度660
 *注意：新高度或新宽度都不能为0
*/

class myThumbClass{

	public $sur_file;	//读取的原图片
	public $des_file;	//生成目标图片
	public $tem_file;	//临时图片
	public $tag;		//缩略标签  0,默认,按固定的高宽生成  1,按比列或固定最大长度生成  -1,按某个宽度或某个高度缩小
	public $resize_width;		//$tag为0时,目标文件宽
	public $resize_height;		//$tag为0时,目标文件高
	public $sca_max;	//$tag为1时,<0$sca_max<1时为缩小比例;$sca_max>1时为最大长度(高或宽之中的最大值)

	public $type;		//图片类型
	public $width;		//原图片宽
	public $height;		//原图片高

	//构造函数
	public function __construct($surpic, $reswid, $reshei, $despic, $mark, $scamax){
		$this->sur_file = $surpic;
		$this->resize_width = $reswid;
		$this->resize_height = $reshei;
		$this->tag = $mark;
		$this->sca_max = $scamax;

		$this->type = strtolower(substr(strrchr($this->sur_file,"."),1));	//获取图片类型
		$this->init_img();	//初始化图片
		$this->des_file = $despic;	//目标图片地址
		$this->width = imagesx($this->tem_file);
		$this->height = imagesy($this->tem_file);
		$this->new_img();
		imagedestroy($this->tem_file);
	}

	//图片初始化函数
	private function init_img(){
		if($this->type == 'jpeg'){
			$this->tem_file = imagecreatefromjpeg($this->sur_file);
		}elseif($this->type == 'jpg'){
			$this->tem_file = imagecreatefromjpeg($this->sur_file);
		}elseif($this->type == 'gif'){
            $this->tem_file = imagecreatefromgif($this->sur_file);
		}elseif($this->type == 'png'){
            $this->tem_file = imagecreatefrompng($this->sur_file);
		}elseif($this->type == 'bmp'){
            $this->tem_file = imagecreatefrombmp($this->sur_file);	
		}
	}

	//图片生成函数
	private function new_img(){
		$ratio = ($this->width)/($this->height);	//原图比例
		$resize_ratio = ($this->resize_width)/($this->resize_height);	//缩略后比例
		$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);//生成新图片

		if($this->tag == 0){	//按固定高宽截取缩略图
			$newimg = imagecreatetruecolor($this->resize_width,$this->resize_height);//生成新图片
			if($ratio>=$resize_ratio){//即等比例下,缩略图的高比原图长,因此高不变
				imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, $this->resize_width,$this->resize_height, (($this->height)*$resize_ratio), $this->height);
			}elseif($ratio<$resize_ratio){//即等比例下,缩略图的宽比原图长,因此宽不变
				imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, $this->resize_width,$this->resize_height, $this->width, (($this->width)/$resize_ratio));
			}
		}elseif($this->tag == 1){	//按固定比例或最大长度缩小
			if($this->sca_max < 1){	//按比例缩小
				$newimg = imagecreatetruecolor((($this->width)*($this->sca_max)),(($this->height)*($this->sca_max)));//生成新图片
				imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, (($this->width)*($this->sca_max)), (($this->height)*($this->sca_max)), $this->width, $this->height);

			}elseif($this->sca_max > 1){	//按某个最大长度缩小
				if($ratio>=1){	//宽比高长
					$newimg = imagecreatetruecolor($this->sca_max,($this->sca_max/$ratio));//生成新图片
					imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, $this->sca_max,($this->sca_max/$ratio), $this->width, $this->height);
				}else{
					$newimg = imagecreatetruecolor(($this->sca_max*$ratio),$this->sca_max);//生成新图片
					imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, ($this->sca_max*$ratio),$this->sca_max, $this->width, $this->height);
				}
			}
		}elseif($this->tag == -1){	//按某个宽度或某个高度缩小
		  if($resize_ratio>=1){//新高小于新宽,则图片按新宽度缩小
		    $newimg = imagecreatetruecolor($this->resize_width,($this->resize_width/$ratio));//生成新图片
			imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, $this->resize_width,($this->resize_width/$ratio), $this->width, $this->height);
		  }elseif($resize_ratio<1){//新宽小于新高,则图片按新高度缩小
		    $newimg = imagecreatetruecolor(($this->resize_height*$ratio),$this->resize_height);//生成新图片
					imagecopyresampled($newimg, $this->tem_file, 0, 0, 0, 0, ($this->resize_height*$ratio),$this->resize_height, $this->width, $this->height);
		  }
		}
		

		//输出新图片
		if($this->type == 'jpeg' || $this->type == 'jpg'){
			imagejpeg($newimg,$this->des_file);
		}elseif($this->type == 'gif'){
			imagegif($newimg,$this->des_file);
		}elseif($this->type == 'png'){
			imagepng($newimg,$this->des_file);
		}elseif($this->type == 'bmp'){
			imagebmp($newimg,$this->des_file);//bmp.php中包含
		}

	}#function new_img() end

}#end class

?>