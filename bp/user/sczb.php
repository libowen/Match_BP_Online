<?php
/**
* FILE_NAME : sczb.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\sczb.php
* 输出制表：输出各项表格，内有可选择表格的样式和输出的内容（在新窗口打开制表）；计算成绩和排名也在此？？
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

/*个人成绩表（积分编排）  
1、累进分
2、对手分，胜局，犯规，后走胜局，后走局数
*/
/*
空成绩表、成绩表、
编排轮数表、
对局记分卡 = 记分单
台次号卡片、
等级分表、
名单卡片、
名单表、
对局记录表、
团体成绩表、
排序编排表、
综合形式名次成绩表
*/


/*
各轮编排公布表=编排轮数表=对阵表=编排记录公告 （有三种形式：格线宋体，格线黑体，无线黑体）bpjilu

对局记分卡 = 记分单 = 成绩记分单 （有两种形式：横式 节约式）jifendan

个人成绩表（分总表和简表；分别都又可按不同条件排序、列出前几名、根据不同的条件来排名输出）GRcj

团体成绩表（也分总表和简表：可根据不同的条件来排名输出）TTcj

个人（团体）名次表 TTmc  GRmc

姓名签 XMqian??大多没什么用呢
*/
$title=$zhutibiaoti='表格输出首页：打印表格的相关配置';
if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=61;
        //权限，不是管理员不能操作
        $bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
        qingqiuzt($_SESSION['bp_userid'],'bisai',$_GET['bsid']);
        //zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
        
        ///获取指定比赛的配置，并直接显示比赛的配置到制表的默认配置中，$bsinfo；需显示页面的对应显示
	} else {
		$zhutizuoce='<span style="color:red">你未指定比赛！</span>';
	}
}else{
	
	exit('<script>alert("请先登录");location.href="/bp/index.php"</script>');
}

$zhutizuoceFile='sczb.php';




//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>