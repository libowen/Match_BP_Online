<?php   
/** 需要修改的部分： ***** 星号部分为你自己的个人配置信息，必须修改 **/
define("UserName", "*****");							  //数据库连接用户名
define("PassWord", "*****");							  //数据库连接密码
define("ServerName", "localhost");					      //数据库服务器的名称
define("DBName","*****");								  //数据库名称
/****/
if(UserName == '*****'){
	exit('你没有完成配置文件的修改，请修改config.inc.php文件！');
}
	
	
define("ERRFILE","err.php");							  //错误处理显示文件
define('ROOT_PATH', dirname(__FILE__) . '/');			  //定义根目录路径
define('INCLUDE_PATH', ROOT_PATH . 'include/');			  //定义包含文件目录路径
define('CLASS_PATH', ROOT_PATH . 'class/');			  //定义包含文件目录路径

//echo 	$_SESSION['bp_app_user'],$_SESSION['bp_app_userid'],$_SESSION['bp_app_huji'],$_SESSION['bp_app_yanma'];
if ((isset($_SESSION['bp_app_user'])&&$_SESSION['bp_app_yanma']=='ruyihe.com')
   ||($_SESSION['bp_huji']=='WAI')) {  
   	        //如果是外来的账号（传递来的是SESSION值）

	if ($_SESSION['bp_huji']!='WAI'||!isset($_SESSION['bp_userid'])||!$_SESSION['bp_userid']) {
		$app_user=$_SESSION['bp_app_user'];			//当前用户的用户名；<br>
		$app_userid=$_SESSION['bp_app_userid'];		//当前用户的UID；<br>
		$app_huji=$_SESSION['bp_app_huji'];			//要传递的户籍，表明是哪里的会员
		$app_yanma=$_SESSION['bp_app_yanma'];		//此站点的验证码
															//		$app_jinbi=$_SESSION['bp_app_jinbi'];		//此站点指定的消耗货币字段
															//		$app_jifen=$_SESSION['bp_app_jifen'];		//此站点指定的积分字段
															//		$app_jingyan=$_SESSION['bp_app_jingyan'];	//此站点指定的经验字段
															//		$app_dengji=$_SESSION['bp_app_dengji'];		//此站点指定的等级字段
		//session_destroy();  //清除大量外站传递来的其他SESSION！好像不能使用，否则后面也得不到值
		$_SESSION['bp_app_user']=$_SESSION['bp_app_userid']=$_SESSION['bp_app_huji']=$_SESSION['bp_app_yanma']=$_SESSION['bp_app_jinbi']=$_SESSION['bp_app_jifen']=$_SESSION['bp_app_jingyan']=$_SESSION['bp_app_dengji']='';  //清除部分传递过程的临时数据
		$_SESSION['bp_user']='ruyihe_'.$app_user;  //为便于区别内外站的会员，故规定内部会员不能使用_字符注册，外站会员必带'域名_'
		$_SESSION['bp_userid']=$app_userid;
		$_SESSION['bp_huji']='WAI';
		//$_SESSION['bp_huji']=$app_huji;
															//由于是同一数据库中的数据表，不需要下面：
															/*
															define("BP_WDB_HOST", "");	//外站的数据库主机
															define("BP_WDB_USER", "");	//外站的数据库用户名
															define("BP_WDB_PASSWORD", "");	//外站的数据库用户对应的密码
															define("BP_WDB_NAME", "");	//外站的数据库名
															define("BP_WTABLE_USER", "");	//外站的会员信息表
															*/
		define("BP_HUJI", "WAI");	//户籍，从外站来的用户为WAI，内站的为空或NEI
	}

							define("BP_WJinBi", "");	//外站的消耗类货币，互通使用的
							define("BP_WJiFen", "");	//外站的用户积分
							define("BP_WJingYan", "");	//外站的经验值
							define("BP_WDengJi", "");	//外站的用户等级
} else {
	define("BP_HUJI", "NEI");	//户籍，从外站来的用户为WAI，内站的为空或NEI
}
//echo '<br>',$_SESSION['bp_user'],$_SESSION['bp_userid'],$_SESSION['bp_huji'];
//exit;	
?>