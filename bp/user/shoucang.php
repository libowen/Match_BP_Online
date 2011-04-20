<?php
/**
* FILE_NAME : shoucang.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\shoucang.php
* 我的收藏
*
* @copyright Copyright (c) 2010
* 备注：如何添加收藏呢？！
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

if ($_SESSION['bp_userid']&&$_SESSION['bp_user']) {
		//先查询请求者的账号内的收藏序列，检查重复、数量；
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
        //权限，会员都可以自由收藏和移除
        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");     	
        
        $userinfo=$user->getInfo($_SESSION['bp_userid'],"bp_user","u_id");  ///！另userinfo($userid='',$username='')是获得数组的[0]
        $bsids=explode(',',trim($userinfo['u_shoucang'],','));
        $bsshu=count($bsids);
        
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
		if ($_GET['action']) {
			if ($_GET['action']=='yichu') {   //移除比赛操作
				    $linshi=array_search($_GET['bsid'],$bsids);
					if ($linshi!==false) {
						unset($bsids[$linshi]);
						$shuju=join(',',$bsids);
						$shuju?$shuju.=',':'';
						$sql="UPDATE  bp_user  SET u_shoucang='".$shuju."' WHERE u_id='".$_SESSION['bp_userid']."'";
//echo '$sql=',$sql,'<br>$shuju=',$shuju;
						if ($user->update($sql)) {
							
							exit('<script>alert("移除成功。目前共收藏了'.($bsshu-1).'个比赛。"); window.close();</script>');  
						} else {
							
							exit('<script>alert("移除失败！发生在数据库操作时！目前共收藏了'.$bsshu.'个比赛。"); window.close();</script>');  
						}
					} else {
						exit('<script>alert("移除失败！你没有收藏过本比赛！目前共收藏了'.$bsshu.'个比赛。"); window.close();</script>');  
					}
			} elseif ($_GET['action']=='shoucang'||$_GET['action']=='cang') {  ///收藏比赛操作
				if ($bsshu>=30) {
					exit('<script>alert("你的账户值最多收藏30个比赛！你已经收藏了'.$bsshu.'个"); window.close();</script>');  
				}
				///必须数字，单个英文逗号分隔 	//先检查是否存在，不存在才增加
					if (array_search($_GET['bsid'],$bsids)===false) {
						$sql="UPDATE  bp_user  SET u_shoucang=CONCAT(u_shoucang,'".$_GET['bsid'].",') WHERE u_id='".$_SESSION['bp_userid']."'";
//echo '$sql=',$sql,'<br>',array_search($_GET['bsid'],$bsids);
						if ($user->update($sql)) {
							exit('<script>alert("收藏成功。目前共收藏了'.($bsshu-1+2).'个比赛。"); window.close();</script>');  
						} else {
							exit('<script>alert("收藏失败，原因未明！目前共收藏了'.$bsshu.'个比赛。"); window.close();</script>');  
						}
					} else {
						exit('<script>alert("你已经收藏过本比赛了！目前共收藏了'.$bsshu.'个比赛。"); window.close();</script>');  
					}
			}
		} 
	} else {
		//查询个人收藏的比赛，显示账户所收藏的比赛的列表
		$bisais=$user->idschaxun($bsids,'bp_bisai','bs_id','0,30');   ////只显示前30个
		 $title=$userinfo['u_name'].' 所收藏的赛事 =我的收藏= 比赛编排管理系统';
	     $zhutibiaoti='=我的收藏= 共 '.$bsshu.' 个';;
		$zhutizuoceFile='shoucang.php';
//print_r($bisais);
//exit('<script>alert("请指定比赛ID！"); window.close();</script>');  
	}
} else {
	exit('<script>alert("没有登录本站账号，不能收藏比赛！"); window.history.back();</script>');  
//	exit('<script>alert("没有登录本站账号，不能收藏比赛！");alert(history.length);window.history.back();window.close();</script>');  
}

//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>