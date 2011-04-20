<?php
/**
  * 放到外站的app文件  http://localhost/g/bbs/plugins/bisai_bp/bp.php
 **/
session_start();

require_once '../../include/common.inc.php';
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//session_destroy();  //不可以使用，否则无法获取后面的SESSION

if ($discuz_userss&&$discuz_uid&&is_numeric($discuz_uid)) {
	$_SESSION['bp_app_user']=$discuz_userss;		//当前用户的用户名；<br>
	$_SESSION['bp_app_userid']=$discuz_uid;		//当前用户的UID；<br>
	$_SESSION['bp_app_huji']='ruyihe.com';		//要传递的户籍，表明是哪里的会员
	
	$_SESSION['bp_app_yanma']='ruyihe.com';		//此站点的验证码
	$_SESSION['bp_app_jinbi']='';		//此站点指定的消耗货币字段
	$_SESSION['bp_app_jifen']='';		//此站点指定的积分字段
	$_SESSION['bp_app_jingyan']='';		//此站点指定的经验字段
	$_SESSION['bp_app_dengji']='';		//此站点指定的等级字段
	
	define('TO_BP_URL','http://localhost/bp/user/saishi.php');   
	//定义外站链接到bp站的默认入口，原则上其他页面也可以，
	
	header('Location: '.TO_BP_URL);
} else {
	exit('你没有登录或此站的配置链接有误！<script>window.history.back();</script>');
}



/*
$bbname<br>
$discuz_userss：当前用户的用户名；<br>
$discuz_uid：当前用户的UID；<br>
$bbname：论坛名称；<br>
$boardurl：论坛地址；<br>
$adminid：论坛管理组的数字ID编号，如：1是管理员，2是超版，3是版主；<br>
$version：论坛的版本号；<br>
$groupid：用户组ID编号；<br>
*/
?>
