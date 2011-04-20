<?php
/**
 * 功能：会员登录验证
 */
session_start();
include("../../config.inc.php");
include(INCLUDE_PATH."yanzheng.php");
if (!isset($_SESSION['bp_userid'])) {
	if ($_POST['name']) {
		require_once(CLASS_PATH."class_user.php");
        $user=new USER();
		if ($userinfo=$user->denglu($_POST['name'],$_POST['pas'])) {
			$_SESSION['bp_user']=$userinfo['u_name'];
			$_SESSION['bp_userid']=$userinfo['u_id'];
			
			exit('<script>if (confirm("登录成功！你现在可以点击【确定】则返回原页面，【取消】则跳转到个人赛事列表")) { if(document.referrer){location.href=document.referrer; } else { location.href="/bp/user/saishi.php"; }  } else { location.href="/bp/user/saishi.php"; }</script>');
		}else{
			$message='登录错误！可能是账号或密码不匹配，请重试。';
			echo $message;
			echo '<script>alert("登录错误，请重新登录！");location.href="/bp/index.php"</script>';
			exit;
		}
	}else{
		$message='登录错误！可能是账号或密码不匹配，请重试。';
		echo $message;
		echo '<script>alert("登录错误，用户名不能为空！");location.href="/bp/index.php"</script>';
		exit;
	}
}else{
	
	exit('<script>if (confirm("你已经登录可以点击【确定】则返回原页面，【取消】则跳转到个人赛事列表")) { window.history.back(); } else { location.href="/bp/user/saishi.php"; }</script>');  
}
?>