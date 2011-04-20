<?php
/*$newbslist=20;
include("../config.inc.php");*/
if ($newbslist&&is_numeric($newbslist)&&$newbslist>2) {
		if (!$user) {
			require_once(CLASS_PATH."class_user.php");
			$user=new USER();
		}
		if (!$bslist) {
			if ($_SESSION['bp_user']) {
				$sql='SELECT bs_id,bs_biaoti,bs_luruyuan,bs_didian,bs_shijian FROM bp_bisai WHERE bs_luruyuan="'.$_SESSION['bp_user'].'" ORDER BY bs_id DESC LIMIT 0,'.$newbslist;
				$bslist=$user->select($sql);	
			}
			if (!$bslist) {
				$sql='SELECT bs_id,bs_biaoti,bs_luruyuan,bs_didian,bs_shijian FROM bp_bisai ORDER BY bs_id DESC LIMIT 0,'.$newbslist;
				$bslist=$user->select($sql);
			}
			if ($bslist) {
?>
<tr valign="top"> 
    <td width="7" bgcolor="#D2D2D2"></td>
    <td height="auto"> <!--赛事新闻 -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="8"></td>
        </tr>
        <tr> 
          <td><a href="baoliuweizhi"><img src="/bp/image/zuixinsaishi.gif" alt="最新赛事" width="197" height="22" border="0" usemap="#Map2MapMap"></a></td>
        </tr>

        <tr> 
          <td height="5" bgcolor="#FFFFFF"></td>
        </tr>
        <tr> 
          <td height="auto" valign="top" bgcolor="#FFFFFF">
          	  <table width="100%" cellpadding="0" cellspacing="0" >
			<?php
			foreach ($bslist as $key => $value) {
			?>
				<tr>
	          	  	<td colspan="2" style="text-align:left;padding:1px 0px;padding:1px 2px;text-overflow:ellipsis;white-space:normal;" 
	          	  	 title="【<?php echo $value['bs_id'];?>】《<?php echo $value['bs_biaoti'];?>》比赛时间：<?php echo $value['bs_shijian'];?>。地点：<?php echo $value['bs_didian'];?>。管理员：<?php echo $value['bs_luruyuan'];?>。"
	          	  	 > 
		          	  	<img src="/bp/image/arrow2.gif" width="12" height="16">
		          	  		<a href="/bp/user/saishi.php?bsid=<?php echo $value['bs_id'];?>"><?php echo $value['bs_biaoti'];?></a>
	          	  	</td>
          	  	</tr>
          	  
            <?php
			}
		    ?>
          	 </table>
          	 <script language="javascript" type="text/javascript">
          	 function dbgoto(thisD) {
          	 	window.open(thisD.getAttribute("link"));
          	 }
          	 </script>
          </td>
        </tr>
        <tr> 
          <td height="5"><img src="/bp/image/twdesign_0046.gif" width="197" height="5"></td>
        </tr>
      </table>
    </td>                        <!--赛事新闻 -->
    <td width="7" bgcolor="#D2D2D2"></td>
  </tr>
  
<?php
			}
		}
}
?>
