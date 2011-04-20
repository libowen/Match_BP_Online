<table width="988" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="8"><img src="/bp/image/twdesign_0008.gif" width="8" height="8"></td>
    <td width="971" height="8" background="/bp/image/twdesign_0009.gif"></td>
    <td width="9"><img src="/bp/image/twdesign_0010.gif" width="9" height="8"></td>
  </tr>
  <tr> 
    <td width="8" height="auto" background="/bp/image/twdesign_0011.gif"> </td>
    <td width="977" valign="baseline" bgcolor="#FFFFFF">
	<table width="971" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="762" height="100%" align="center" valign="top"><!--左侧大窗口 -->
				<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="3">
				  <tr> 
					<td width="100%"> 
						  <TABLE WIDTH="756px" HEIGHT="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
							<TR> 
							  <TD width="6" height="29"><IMG SRC="/bp/image/0005_01.gif" WIDTH=6 HEIGHT=29 ALT=""></TD>
							  <TD width="744" height="29" background="/bp/image/0005_02.gif"> 
								<table width="100%" border="0" cellspacing="0" cellpadding="2">
								  <tr> 
									<td width="5%"><img src="/bp/image/twdesign_0034.gif" width="17" height="17"></td>
									<td width="90%" align="center">
										<h2 class="biaoti" style="margin:0px;padding:0px;font-family:黑体;font-size:18px;font-weight:normal;">
										<?php $zhutibiaoti?print $zhutibiaoti:print '[比赛号]《无标题》比赛 第x轮 编排/登分（赛事配置）';?>
										</h2>
									</td>
									<td width="5%"><a title="跳转到“我的赛事”列表" href="saishi.php"><img src="/bp/image/twdesign_0036.gif" width="48" height="16" border="0"></a></td>
								  </tr>
								</table>
							  </TD>
							  <TD width="6" height="29"><IMG SRC="/bp/image/0005_03.gif" WIDTH=6 HEIGHT=29 ALT=""></TD>
							</TR>
							<TR> 
							  <TD width="6" height="6"> <IMG SRC="/bp/image/0005_04.jpg" WIDTH=6 HEIGHT=6 ALT=""></TD>
							  <TD width="744" height="6" background="/bp/image/0005_05.gif"></TD>
							  <TD width="6" height="6"> <IMG SRC="/bp/image/0005_06.gif" WIDTH=6 HEIGHT=6 ALT=""></TD>
							</TR>
							<TR> 
							  <TD background="/bp/image/0005_07.gif"></TD>
							  <TD id="LeftContent" valign="top" align="center"><!--主体左侧内容-->
							  <?php 
							  if ($zhutizuoce) {      //输出变量
							  	echo $zhutizuoce;
							  }
							  if ($zhutizuoceFile) {  //载入文件
							  	include_once(INCLUDE_PATH."zaxiang/".$zhutizuoceFile);
							  }
							  ?>
							  </TD><!--主体左侧内容-->
							  <TD background="/bp/image/0005_09.gif"></TD>
							</TR>
							<TR> 
							  <TD height="6"> <IMG SRC="/bp/image/0005_10.gif" WIDTH=6 HEIGHT=6 ALT=""></TD>
							  <TD height="6" background="/bp/image/0005_11.gif"></TD>
							  <TD height="6"> <IMG SRC="/bp/image/0005_12.gif" WIDTH=6 HEIGHT=6 ALT=""></TD>
							</TR>
						  </TABLE>
					</td>
				  </tr>
				</table>
		  </td>                                       <!--左侧大窗口 -->
		  
          <td width="209" valign="top" bgcolor="#D2D2D2"><!-- 右侧大窗口 -->
            <table width="209" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td height="12" colspan="3"><img src="/bp/image/twdesign_0019.gif" width="209" height="12"></td>
              </tr>
              <tr> 
                <td width="7" height="108" bgcolor="#D2D2D2"></td>
                <td width="195" align="center" bgcolor="#F2F2F2"><!--用户信息窗口 -->
                    <?php include(INCLUDE_PATH.'bufen/userEnter.php');?>
                  </td>                                           <!--用户信息窗口 -->
                <td width="7" bgcolor="#D2D2D2"></td>
              </tr>
              <tr> 
                <td height="4" colspan="3"><img src="/bp/image/twdesign_0020.gif" width="209" height="4"></td>
              </tr>
              <?php 
                 if ($xinwen) {//true:显示赛事新闻 
  					include(INCLUDE_PATH."bufen/xinwen.php");
           		 }
$newbslist=isset($newbslist)?$newbslist:16;  //保证可以设置成0
           		 if ($newbslist) {//最新创建的前$newbslist个比赛
           		 	include(INCLUDE_PATH."bufen/newbslist.php");
           		 }
                 if ($diaocha) {//true:进行在线调查 
					include(INCLUDE_PATH."bufen/diaocha.php");
                 }?>
			  <tr>
			  <td height="6" colspan="3">
			  </td>
			  </tr>
            </table>
		  </td>                                 <!-- 右侧大窗口 -->
        </tr>
      </table>
	
	</td>
    <td width="8" background="/bp/image/twdesign_0012.gif"> </td>
  </tr>
  <tr> 
    <td><img src="/bp/image/twdesign_0013.gif" width="8" height="7"></td>
    <td height="7" background="/bp/image/twdesign_0015.gif"></td>
    <td><img src="/bp/image/twdesign_0014.gif" width="9" height="7"></td>
  </tr>
</table>
<?php
	             if ($yqlianjie) {//true:显示友情链接 
					include(INCLUDE_PATH."bufen/Fline.php");
				 } 
?>