<?php
/**
* FILE_NAME : zhgl.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\zhgl.php
* 账号管理
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

if ($_SESSION['bp_user']&&$_SESSION['bp_userid']) {
	if ($_POST['tijiao']) {	//更新账号信息
	   require_once(CLASS_PATH."class_user.php");
	   $user=new USER();
	   $userinfo=$user->userinfo($_SESSION['bp_userid']);
	   
	   if(md5($_POST['oldpas']) != $userinfo['u_pas']){
	   		$msg = '<p style="color:red"> 旧密码不正确！ 请重试</p>';
	   } else {
		   $data=array();
		   foreach ($_POST as $key => $value) {
		   	   if ($key!='submit'&&$key!='tijiao'&&$key!='reset'&&$key!='name'&&$key!='oldpas'&&!empty($value)) {	//用户名不能修改！
		   	   	   $data['u_'.$key]=$value;
		   	   }
		   }
		   if ( $user->zigai($_SESSION['bp_userid'], $data) ) {
		   		 //exit('<script>alert("信息更新成功！"); window.history.back();</script>');
			     $msg = '<p style="color:green">信息更新成功！</p>';
			     exit('<script>alert("信息更新成功！"); location.href="/bp/user/zhgl.php";</script>');
			 } else {
			 	$msg = '<p style="color:red">信息更新失败！</p>';
			 }
	   }
	} else {
		//查询
		 require_once(CLASS_PATH."class_user.php");
	     $user=new USER();
		 $userinfo=$user->userinfo($_SESSION['bp_userid']);
	}
} else {
	exit('<script>alert("你还没有登陆，请先登录你的账号！"); window.history.back(); //location.href="/bp/user/saishi.php"</script>');
}

$title = '用户账号管理 -比赛编排管理系统';          //页面的标题
$zhutibiaoti = '用户账号管理-信息修改';    //主体左侧窗口内容的标题
//$zhutizuoce = '此功能未开放，请重新注册账号，或联系作者';     //主体左侧的内容，即zhutibiaoti下面

//主体左侧的内容，即zhutibiaoti下面
$zhutizuoce='<form  method="post" action="">
				<br>
					<table border="1" style="margin:auto;">
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td width="180">账号(不能修改）：</td>
						<td width="160"> '.$userinfo[u_name].' </td>
					  </tr>
					  <tr>
						<td>旧  密  码：</td>
						<td><input type="password" name="oldpas"></td>
					  </tr>
					  <tr>
						<td>密  码：</td>
						<td><input type="password" name="pas"></td>
					  </tr>
					  <tr>
						<td>重复密码：</td>
						<td><input type="password" id="pas_pas" onblur="zhuceyanzheng(this)"></td>
					  </tr>
					  <tr>
						<td>邮  箱：</td>
						<td><input type="text" name="email" value="'.$userinfo[u_email].'" ></td>
					  </tr>
					  <tr>
						<td>Q  Q:</td>
						<td><input type="text" name="qq" value="'.$userinfo[u_qq].'" ></td>
					  </tr>
					  <tr>
						<td>联系方式：</td>
						<td><input type="text" name="lianxi" value="'.$userinfo[u_lianxi].'" ></td>
					  </tr>
					  <tr>
						<td>&nbsp;<input type="hidden" name="signon_ip" value=""></td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan="2" align="center">
						    <input name="tijiao" type="submit" value="提交">&nbsp;&nbsp;
						    <input name="reset" type="reset" value="重置">
						</td>
					  </tr>
					</table>
								<br>'.$msg.'
	           </form>
	           <script>
	           function zhuceyanzheng (thisdom) {
		           switch (thisdom.getAttribute("name")) {
		              case "":
		              
		              	break;
		              case "name":
		           		username=document.getElementsByName("name")[0];
		           		if (username.value.length<6||username.value.length>20) {
		           			//alert("账号名须在6至20个字符之间！");
		           			username="";
		           		}else if (!isChrandNum(username.value)) {
		           			alert("只能是字母或数字！");
		           			username="";
		           		}
		              	break;
		              case "":
		              
		              	break;
		              default:
		              	break;
		           	}
	             	 if (thisdom.getAttribute("id")==="pas_pas") {
		              	pas1=document.getElementsByName("pas")[0];
		           		pas2=document.getElementById("pas_pas");
		           		if (pas1.value!=pas2.value) {
		           			alert("两次密码不相同！");
		           		}
	           		 }
	           }	           		
	           //判断是否是数字和字母的组合
				function isChrandNum( cCharacter ) {
					str=cCharacter;
					for(ilen=0;ilen<str.length;ilen++) {
						if(str.charAt(ilen) < "0" || str.charAt(ilen) > "9" ) {
							if(str.charAt(ilen) < "a" || str.charAt(ilen) > "z" ) {
								if(str.charAt(ilen) < "A" || str.charAt(ilen) > "Z" ) {
									return false;
								}
							} 
						}
					}
					return true;
				}  
	           </script>
               ';    
//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>