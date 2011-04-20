
<?php
/**
 * 会员的界面模板
 */

//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面

//决定是否显示的
$usertalbe=0;      //用户的个人信息是否显示
	$xinwen=0;         //是否显示赛事新闻
$diaocha=0;        //是否显示在线调查
$yqlianjie=1;      //是否显示友情链接
	$newbslist=16;		//最新赛事（登录后显示的是自己的最新赛事）的显示个数
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	include(INCLUDE_PATH."bufen/toubu.php");
?>
<body bgcolor="#BEBEBE" leftmargin="0" topmargin="0">
<?php
	include(INCLUDE_PATH."bufen/daohang.php");
	include(INCLUDE_PATH."bufen/zhuti.php");
	include(INCLUDE_PATH."bufen/dibu.php");
							  /*
							  if ($zhutizuoce) {      //输出变量
							  	echo $zhutizuoce;
							  }
							  if ($zhutizuoceFile) {  //载入文件
							  	include_once(INCLUDE_PATH."zaxiang/".$zhutizuoceFile);
							  }
							  */
?>
</body>
</html>

<?php 

/*
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title?$title:'(内容主体)比赛编排管理系统=如意盒出品';?></title>
</head>

<body style="background-color:blue;">
		<?php
			  if ($zhutizuoce) {      //输出变量
				echo $zhutizuoce;
			  }
			  if ($zhutizuoceFile) {  //载入文件
				include_once(INCLUDE_PATH."zaxiang/".$zhutizuoceFile);
			  }
		?>
</body>
</html>
*/
?>