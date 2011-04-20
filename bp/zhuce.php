<?php
/**
* FILE_NAME : zhuce.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhuce.php
* 会员注册
*
* @copyright Copyright (c) 2010
*/
session_start();
include("config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

if (!$_SESSION['bp_user']&&$_SESSION['bp_userid']) {
	
	exit('<script>location.href="/bp/user/saishi.php"</script>');
}else{
	if ($_POST['tijiao']) {
		//先检查数据中是否已存在此账号
	   require_once(CLASS_PATH."class_user.php");
	   $user=new USER();
		   $dbname = 'bp_user';
		   $name = $_POST['name'];
		   if($user->checkname($name, $dbname, "u_name")){
		   	 exit('<script>alert("此账号已存在，请换个名字注册！"); window.history.back(); </script>');
		   }
	   $data=array();
	   foreach ($_POST as $key => $value) {
	   	   if ($key!='submit'&&$key!='tijiao'&&$key!='reset'&&!empty($value)) {
	   	   	   $data['u_'.$key]=$value;
	   	   }
	   }
	   
	   if ($i=$user->zhuce($data)) {
	   	  $_SESSION['bp_userid']=$i;
	   	  $_SESSION['bp_user']=$data['u_name'];
	   }
	   
	   exit('<script>if (confirm("注册并登录成功！你现在可以点击【确定】则返回原页面，【取消】则跳转到个人赛事列表")) { window.history.back(); } else { location.href="/bp/user/saishi.php"; }</script>');
	}
}

$title='会员注册';          //页面的标题
$zhutibiaoti='会员注册';    //主体左侧窗口内容的标题
//主体左侧的内容，即zhutibiaoti下面
$zhutizuoce='
	            <form  method="post" action="">
				<br>
					<table border="1" style="margin:auto;">
					  <tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td width="180">账号(6-20字母或数字)：</td>
						<td width="160"><input type="text" name="name" maxsize="20" onblur="zhuceyanzheng(this)"></td>
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
						<td><input type="text" name="email"></td>
					  </tr>
					  <tr>
						<td>Q  Q:</td>
						<td><input type="text" name="qq"></td>
					  </tr>
					  <tr>
						<td>联系方式：</td>
						<td><input type="text" name="lianxi"></td>
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
								<br>
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

include(INCLUDE_PATH."moban/user.php");
?>