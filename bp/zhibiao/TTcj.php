<?php
/**
* FILE_NAME : TTcj.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\TTcj.php
* ....书写本页代码的说明
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

/*
队员总分制团体计分表 
输出数据：bsinfo tuanduis duiyuanshu chuque qianji 
其中：tuanduis[团队号数][duiming/fen/zuihaomc/duiyuan/duimc/duifangui]，duiyuan为数组
*/
//$_SESSION['bp_userid']&&
if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=$_GET['bsid']=$bsid=$_GET['bsid']:$bsid=$_GET['bsid']:63;
        $_GET['paimingmoshi']=$_GET['paimingmoshi']?$_GET['paimingmoshi']:'ACDEFH';
	    //权限，不是管理员不能操作
	    $bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
	    $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
		zuquanxian($_SESSION['bp_user'],'user','xiugaibp','bisai','xuanshou','');
		
		if (!$_GET['duiyuanshu']) {  //当无传递值时，使用下面的默认值
			if ($bsinfo['bs_duiyuanshu']) {
				$_GET['duiyuanshu']=$bsinfo['bs_duiyuanshu'];
			} else {
				$_GET['duiyuanshu']=4;
			}
		}
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
			//赋值duimc和duifangui，但排名没有考虑
			foreach ($tuanduis as $key => $value) {
				$tuanduis[$key]['duimc']=$key+1;
				$duifangui=0;
				foreach ($tuanduis[$key]['duiyuan'] as $ke => $val) {
					$duifangui+=$val['xs_fangui'];
				}
				$tuanduis[$key]['duifangui']=$duifangui;
			}
			if ($qianji) {
				$tuanduis=array_slice($tuanduis,0,$qianji);//只显示前几名的排名！！？？如果大于实际长度呢？？！！
			}
			$xianshu=count($tuanduis);
			$neirongFile='TTcj.php';
		}else{
			exit('<script>alert("队员数小于0 或不规范！返回原页面"); window.history.back();</script>');  
		}
}else{
	exit('<script>alert("没指定赛事ID或非正整数！即将返回原页面"); window.history.back();</script>');
}
$title='【'.$bsinfo['bs_id'].'】团体成绩《'.$bsinfo['bs_biaoti'].'》组别：'.$bsinfo['bs_zubie'].' 队员数：'.$duiyuanshu;

include(ROOT_PATH."zhibiao/moban/A4.php");
?>