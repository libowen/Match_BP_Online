<?php
/**
* FILE_NAME : TTmc.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\TTmc.php
* 团体名次表
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
		
		$tuanduis=array();
		if ($_GET['duiyuanshu']>0) {
			$qianji=$_GET['qianji'];
			$duiyuanshu=$_GET['duiyuanshu'];
			$chuque=($_GET['chuque']!='')&&isset($_GET['chuque'])?$_GET['chuque']:1;  //默认去除不够队员数的团队
			foreach ($xuanshous as $key => $value){
				$shiyong=0;
				for ($i=0;$i<count($tuanduis);$i++){
					if ($value['xs_danwei']) { //单位为空的不进行排名
						if ($tuanduis[$i]['duiming']==$value['xs_danwei']){
							$tuanduis[$i]['duiyuan'][]=$value;
							$shiyong=1;
							break;
						}
					}else{
						$shiyong=1;
						break;
					}
				}
				if (!$shiyong){
					$linshi=array();
					$linshi['duiming']=$value['xs_danwei'];
					$linshi['duiyuan'][0]=$value;
					$tuanduis[]=$linshi;
				}
			}
	
			$mcfens=array();
			$zuihaomcs=array();
			if (!$_GET['momingci']) {
				$jishu=0;
				foreach ($xuanshous as $value) {
					if ($value['xs_xuhao']>0&&$value['xs_name']!="空号"&&$value['xs_name']!="空") {
						$jishu++;
					}
				}
				$momingci=$jishu;     //参赛人数（空号不算）
			}else{
				$momingci=$_GET['momingci'];
			}
			
			foreach ($tuanduis as $key => $value) {
				$mcs=array();
				$mingcifen=0;
				for ($i=0;$i<count($value['duiyuan']);$i++) {
					$mcs[]=$value['xs_paiming'];
				}
				if ($mcs[1]){
					array_multisort($mcs,$tuanduis[$key]['duiyuan']);
				}
				for ($i=0;$i<$duiyuanshu;$i++) {
					if (isset($tuanduis[$key]['duiyuan'][$i])){
						$mingcifen+=$tuanduis[$key]['duiyuan'][$i]['xs_paiming'];
					}else{  //如果不够队员数，再判断是否需计算排名
						if ($chuque){  //不计算其排名
							unset($tuanduis[$key]);
						}else{   //补足队员数并计算排名，所补队员名次=参赛人数（空号不算）
							$tuanduis[$key]['duiyuan'][]=array('xs_paiming'=>$momingci);
							$mingcifen+=$momingci;
						}
					}
				}
				if ($tuanduis[$key]) {
				$mcfens[]=$tuanduis[$key]['fen']=$mingcifen;
				$zuihaomcs[]=$tuanduis[$key]['zuihaomc']=$tuanduis[$key]['duiyuan'][0]['xs_paiming'];
				}
			}
			if ($tuanduis) {
				array_multisort($mcfens,$zuihaomcs,$tuanduis);//数字键名会被重新索引
			}
			if ($qianji) {
				$tuanduis=array_slice($tuanduis,0,$qianji);//只显示前几名的排名！！？？如果大于实际长度呢？？！！
			}
			$xianshu=count($tuanduis);
			$neirongFile='TTmc.php';
		}else{
			exit('<script>alert("队员数小于0 或不规范！返回原页面"); window.history.back();</script>');  
		}
}else{
	exit('<script>alert("没指定赛事ID或非正整数！即将返回原页面"); window.history.back();</script>');
}
$title='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》组别：'.$bsinfo['bs_zubie'].' *团体排名*  队员数：'.$duiyuanshu;

//必须已经保存了个人排名的
//bsid，前几名qianji=1-，队员数duiyuanshu=2-，不够队员的团队是否计算团体成绩chuque=0/1，momingci=最后名次的设定

include(ROOT_PATH."zhibiao/moban/A4.php");
?>