<?php 
if ($_SESSION['bp_user']&&$_SESSION['bp_userid']) {//登录后，显示个人账号信息 true  
		if (!$user) {
			require_once(CLASS_PATH."class_user.php");
			$user=new USER();
		}
		if (!$userinfo) {
			$userinfo=$user->getInfo($_SESSION['bp_userid'],"bp_user","u_id");
		}
?>
		<table id="userEnter" class="userEnter" bgcolor="White" width="195px" height="108px" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#FFFF99">
            <td colspan="2" height="3px">&nbsp;</td>
          </tr>
          <tr>
            <td width="50">等级：</td>
            <td width="80"><?php echo $userinfo['u_dengji'];?></td>
            <!--
            <td width="65" rowspan="4" background="/bp/image/T/002.jpg">
                  <img width="60px" height="80px" src="/bp/image/T/<?php echo $userinfo['u_touxiang']?$userinfo['u_touxiang']:'002.jpg';?>">
            </td>
            -->
          </tr>
          <tr bgcolor="#FFFF99">
            <td>单位：</td> 
            <td><?php echo $userinfo['u_jingyan']?$userinfo['u_danwei']:'暂无';?></td>
          </tr>
          <tr>
            <td>账号：</td> 
            <td><?php echo $userinfo['u_name'];?></td>
          </tr>
          <tr bgcolor="#FFFF99">
            <td>短信：</td> 
            <td><?php echo $userinfo['u_duanxinshu']?$userinfo['u_duanxinshu']:0;?></td>
          </tr>
          <tr bgcolor="">
            <td colspan="2" height="3px"><input value="退出" type="button" onclick="javascript:location.href='/bp/tuichu.php'" /></td>
          </tr>
          <!--
          <tr bgcolor="#FFFF99">
            <td colspan="2" height="3px">&nbsp;</td>
          </tr>-->
      </table>
<?php }else{//未登录，显示登录入口  ?>
        <table id="userEnter" class="userEnter" width="100%" border="0" cellspacing="0" cellpadding="0">
            <form name="form_denglu" method="post" action="/bp/include/zaxiang/denglu.php">
              <tr>
                <td colspan="2" align="center"><img src="/bp/image/twdesign_0070.gif"></td>
              </tr>
              <tr> 
                <td height="23" colspan="2" align="center">姓名: 
                  <input name="name" type="text" class="input-1" size="18"></td>
              </tr>
              <tr> 
                <td height="23" colspan="2" align="center">密码: 
                  <input name="pas" type="password" class="input-1" size="18"></td>
              </tr>
              <tr> 
                <td width="50%" align="center">
					<input name="tijiao" type="image" value="提交" src="/bp/image/twdesign_0071.gif" width="79" height="28">
                </td>
                <td width="50%" align="center">
<!--                <input type="button" value="注册" onclick="javascript:location.href='/bp/zhuce.php'" src="/bp/image/twdesign_0072.gif" width="79" height="28">-->
                <img style="cursor:pointer;" onclick="javascript:location.href='/bp/zhuce.php'" src="/bp/image/twdesign_0072.gif" width="79" height="28">
                </td>
              </tr>
            </form>
      </table>
<?php } ?>
