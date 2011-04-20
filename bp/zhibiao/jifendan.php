<?php
/**
* FILE_NAME : jifendan.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\jifendan.php
* ....书写本页代码的说明
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");


//$_SESSION['bp_userid']&&
if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=$_GET['bsid']=$bsid=$_GET['bsid']:$bsid=$_GET['bsid']:63;
        $_GET['paimingmoshi']=$_GET['paimingmoshi']?$_GET['paimingmoshi']:'ACDEFH';
	    //权限，不是管理员不能操作
	     $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
        	//qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
		
		$zuiduokey=0;
		$zuiduoshu=0;
		foreach ($xuanshous as $key => $value) {
			//寻找towhos个数最多的项，如是fenshus，则有可能是登分后马上被处理掉的
			if (substr_count($value['xs_towhos'],',')>$zuiduoshu) {
				$zuiduoshu=substr_count($value['xs_towhos'],',');
				$zuiduokey=$key;
			}
		}
		//要获取到的轮数;0也是有效的
		$dijilun=$_GET['dijilun']&&is_numeric($_GET['dijilun'])?$_GET['dijilun']:substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2;
		foreach ($xuanshous as $key => $value) {
			$taihaolie=explode(',,',trim($value['xs_taihaos'],','));
		    $bentaihao=$taihaolie[$dijilun-1];    //有可能为空；不可能为0；如果为空，直接去除！
			if($bentaihao){
				$xianhoulie=str_split($value['xs_xianhous'],1);
				if ($xianhoulie[$dijilun-1]=='+') {   //不再兼容新旧两种格式的xianshus，目前是没逗号的
					$taicis[$bentaihao-1][0]=$value; //key是从0开始算的，且要取倒数第二项，所以减2
				}else{
					$taicis[$bentaihao-1][1]=$value; //taicis保存时都>0
				}
			}
		}
}else{
    $bsinfo=array();
	switch ($_GET['moshi']){
		case 1:     //对局积分卡（计分单） 简约表
		 $taicis=array(array(),array(),array(),array(),array());  //根据moshi来确定个数
			break;
		case 2:     //对局积分卡（计分单） 横表
		 $taicis=array(array(),array(),array(),array(),array(),array(),array(),array());  //根据moshi来确定个数
			break;
		default:    //对局积分卡（计分单） 简约表 默认
		 $taicis=array(array(),array(),array(),array(),array(),array(),array(),array());  //根据moshi来确定个数
			break;				
	}
   
    $title=$zhutibiaoti='对局积分卡（计分单）=空单';
}

//$title $zhutibiaoti $taicis $bsinfo $dijilun ;
$title=$zhutibiaoti='对局积分卡（计分单）_['.$bsinfo[bs_id].']《'.$bsinfo['bs_biaoti'].'》第'.$dijilun.'轮';
	switch ($_GET['moshi']){
		case 1:     //对局积分卡（计分单） 简约表
		$neirongFile='jifendan1.php';
			break;
		case 2:     //对局积分卡（计分单） 横表
		$neirongFile='jifendan2.php';
			break;
		default:    //对局积分卡（计分单） 简约表 默认
		$neirongFile='jifendan2.php';
			break;				
	}
//$title='['.$bsinfo[bs_id].']《'.$bsinfo[bs_biaoti].'》第'.$dijilun.'轮&nbsp;编排纪录表（配对表）';


include(ROOT_PATH."zhibiao/moban/A4.php");
?>