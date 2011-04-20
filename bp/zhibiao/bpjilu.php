<?php
/**
* FILE_NAME : bpjilu.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\bpjilu.php
* 编排记录公告表（对阵表）的打印输出：没有指定比赛的输出一个空表;moshi=传来的值，指定显示的模式，默认无线黑体3，其它1宋体有线，2黑体有线
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

//$bsid ; $moshi ; dijilun ; cj ;
if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
		//$bsid=$_GET['bsid']=63;
	    //权限，不是管理员不能操作
	     $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
        	qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
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
		$dijilun=$_GET['dijilun']?$_GET['dijilun']:substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2;
		$cj=$_GET['cj'];
			foreach ($xuanshous as $key => $value) {
				$taihaolie=explode(',,',trim($value['xs_taihaos'],','));
			    $bentaihao=$taihaolie[$dijilun-1];    //有可能为空；不可能为0；如果为空，直接去除！
				if($bentaihao){
					$fenshulie=explode(',,',trim($value['xs_fenshus'],','));
				    $fengeshu=$dijilun-1;   //积分取比编排少一轮的总分
					if($fengeshu<count($fenshulie)){
						$value['xs_zongfen']=array_sum(array_slice($fenshulie,0,$fengeshu));
					}
					if($cj){                //true则显示指定轮次的当轮得分
						$value['xs_defen']=$fenshulie[$fengeshu];
					}
					$xianhoulie=str_split($value['xs_xianhous'],1);
					if ($xianhoulie[$dijilun-1]=='+') {   //不再兼容新旧两种格式的xianshus，目前是没逗号的
						$taicis[$bentaihao-1][0]=$value; //key是从0开始算的，且要取倒数第二项，所以减2
					}else{
						$taicis[$bentaihao-1][1]=$value; //taicis保存时都>0
					}
				}
			}
}else{
	require_once(CLASS_PATH."class_user.php");
	$user=new USER();
	$bsid=$_GET['bsid'];
	//$bsid=$_GET['bsid']=63;
    //权限，不是管理员不能操作
    $bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
    $dijilun='';
	$xuanshous=array();  //个数不能确定呢！
	$taicis=array('','','','','','','','','','',
	              '','','','','','','','');     //个数不能确定呢！过不了赋值空号的那关
    $taicis[0][0]=array();
    $bsinfo['bs_biaoti']='_';
}
	switch ($_GET['moshi']){
		case 1:     //有线宋体
		$neirongFile='bpjilu.php';
			break;
		case 2:     //有线黑体
		$neirongFile='bpjilu2.php';
			break;
		default:    //无线黑体
		$neirongFile='bpjilu3.php';
			break;				
	}
	$title='['.$bsinfo[bs_id].']《'.$bsinfo[bs_biaoti].'》第'.$dijilun.'轮&nbsp;编排纪录表（配对表）';
/*	$title;
	$css='';
	$taicis;
	$dijilun;*/

include(ROOT_PATH."zhibiao/moban/A4.php");
?>