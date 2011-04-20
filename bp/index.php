<?php
/**
* FILE_NAME : index.php   FILE_PATH : F:\PHPnow\htdocs\bp\index.php
* 频道首页：会员排名、最热赛事、新闻、使用说明等；可能导航要另外修改！
*
* @copyright Copyright (c) 2010
*/
session_start();
include("config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");


$title='比赛编排管理系统-用于棋类比赛积分编排等赛制';          //页面的标题
$zhutibiaoti='比赛编排管理系统-用于棋类比赛积分编排等赛制';    //主体左侧窗口内容的标题

//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////
 		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
			$bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id"); //获得指定比赛的基本信息
			//权限，所指定赛事的管理员才能操作；权限，只能修改、删除自己创建的比赛
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
		}
			$data=array();
			if ($_POST['tijiao']) {  //条件查询（只有条件查询才提交此字段）
				$title='比赛编排管理 赛事=查询';             //页面的标题
				$zhutibiaoti='赛事高级查询——比赛列表只显示比赛的部分配置';    //主体左侧窗口内容的标题
				
				$_POST['biaoti']?$data['bs_biaoti']=$_POST['biaoti']:'';
				$_POST['BSxiangmu']?$data['bs_BSxiangmu']=$_POST['BSxiangmu']:'';
				$_POST['didian']?$data['bs_didian']=$_POST['didian']:'';
				$_POST['shijian']?$data['bs_shijian']=$_POST['shijian']:'';
				$_POST['luruyuan']?$data['bs_luruyuan']=$_POST['luruyuan']:'';
				//是否要先检查日期的正确性呢？！
				$_POST['jianliriqi1']?$data['bs_jianliriqi1']=$_POST['jianliriqi1']:'';
				$_POST['jianliriqi2']?$data['bs_jianliriqi2']=$_POST['jianliriqi2']:'';
					$limit='0,30';                //限制每页显示的数量，好像难于获取总数量！
					//$fenye='注意：每页最多10条，可能未完全显示！';
					$bisais=$user->chaxunbs($_SESSION['bp_user'],$data,$limit);  ///session没作用
				    $pagetitle='chaxun';
					if ($bisais['bs_id']) {  ///如果是只一个不用重新排序
						$linshi=$bisais;
						$bisais=array();
						$bisais[0]=$linshi;
					} else {
						$bsids=array();
						foreach ($bisais as $value){
							$bsids[]=$value['bs_id'];
						}
						array_multisort($bsids,SORT_DESC,$bisais);
					}
			
			} else {   //一般显示，我的赛事列表
				$title='比赛编排管理系统 频道首页';             //页面的标题
				$zhutibiaoti='最新比赛信息 和 随机比赛';    //主体左侧窗口内容的标题
				$limit='0,10';                //限制每页显示的数量，好像难于获取总数量！
				$sql='SELECT * FROM `bp_bisai` ORDER BY `bs_id` DESC LIMIT '.$limit;
					$bisais=$user->select($sql);     //最新的赛事 前10个
					
				$idsdata=array();
				$maxshu=$bisais[0]['bs_id'];
				$minshu=$bisais[0]['bs_id']-2000;
				$minshu<=1?$minshu=1:'';
				for ($k=0;$k<20;$k++) {
					$idsdata[]=rand($minshu,$maxshu);
				}
					$suijibisais=$user->idschaxun($idsdata,'bp_bisai','bs_id','0,10');	//随机的10个比赛
			}
					
		    //主体左侧的内容，即zhutibiaoti下面
			$zhutizuoceFile='index.php';

//载入首页模板
include(INCLUDE_PATH."moban/user.php");    //暂时载入user专用模板，将来更换成首页的模板
?>