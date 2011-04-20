<?php
/**
* FILE_NAME : index.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\index.php
* 表格输出配置、列表的首页
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");


$title='各项表格输出【】《》第？轮';
$zhutibiaoti='各项表格输出【】《》第？轮';

if ($_SESSION['bp_userid']) {
	if ($_GET['bsid']) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=61;
        //权限，不是管理员不能操作
        $bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
        if (!$bsinfo) {
        	exit('<script>alert("所指定赛事不存在！");location.href="saishi.php"</script>');
        }
        if ($bsinfo['bs_luruyuan']!=$_SESSION['bp_user']) {
        	exit('<script>alert("你不是本赛事的管理员！不能进行下面操作");location.href="saishi.php"</script>');
        }
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
		if (!$xuanshous||$xuanshous['xs_id']) {//也排除只一个选手的情况
			exit('<script>alert("还没有录入选手！");location.href="xsgl.php?bsid='.$bsid.'&&rukou=luru"</script>');
		}
		if ($_POST['tijiao']) { //保存编排结果
	    
		}else{
			
		}
	}
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