<?php
/**
* FILE_NAME : bianpai.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\bianpai.php
* 进行比赛编排
*
* @copyright Copyright (c) 2010
*/
session_start();
include("config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

$zhutizuoce='

<style type="text/css">
<!--
.Fline {
margin:5px auto;		
}
/* 友情链接的样式表 */
.Fline td div {
	margin:3px;
	text-align:left;
}
.Fline td div a {
	font-size:14px;
}
.Fline td div img {
	width:88px;
	height:31px;
	border-width:1px;
	border-color:#DDDDDD;
}
.Fline td div  img,.Fline td div a {
	cursor:hand;
	corsor:pointer;
}
-->
</style>
<!--友情链接 -->
<table class="Fline" width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="8"><img src="/bp/image/twdesign_0008.gif" width="8" height="8"></td>
    <td width="971" height="8" background="/bp/image/twdesign_0009.gif"></td>
    <td width="9"><img src="/bp/image/twdesign_0010.gif" width="9" height="8"></td>
  </tr>
  <tr> 
    <td width="8" height="auto" background="/bp/image/twdesign_0011.gif"> </td>
    <td width="auto" valign="baseline" bgcolor="#FFFFFF">
    <div>
             <a target="_blank" href="http://ruyihe.com/bp/"><img src="/bp/image/Fline/bp_logo.gif"/></a>  
			  <a target="_blank" href="http://ruyihe.com/blog/"><img src="/bp/image/Fline/blog_logo.gif"/></a>
			  <a target="_blank" href="http://ruyihe.com/bbs/"><img src="/bp/image/Fline/ruyihe_bbs.gif"/></a> 
			  
			  <a target="_blank" href="http://www.xiangqi.org.cn/"><img src="/bp/image/Fline/chinaqiyuan.jpg"/></a> 
			  <a target="_blank" href="http://sports.sina.com.cn/chess/"><img src="/bp/image/Fline/sinaqipai.gif"/></a> 
			  <a target="_blank" href="http://chess.ourgame.com/"><img src="/bp/image/Fline/lianzhong.gif"/></a>  
			  
  			  <a target="_blank" href="http://www.gdchess.com/"><img src="/bp/image/Fline/gdchess.gif"/></a> 
			  <a target="_blank" href="http://www.stqiyuan.com/"><img src="/bp/image/Fline/stqiyuan.gif"/></a>  
			  <a target="_blank" href="http://www.zjchess.com/"><img src="/bp/image/Fline/zjchess.gif"/></a>  
			  <a target="_blank" href="http://www.sdqipai.com/"><img src="/bp/image/Fline/sdqipai.gif"/></a> 

			  <a target="_blank" href="http://www.hgchess.com/"><img src="/bp/image/Fline/hgchess.gif"/></a>  
  			  <a target="_blank" href="http://www.qiuyuye.net.cn/"><img src="/bp/image/Fline/qiuyuye.gif"/></a>  
			  <a target="_blank" href="http://www.qiluyiyou.com/"><img src="/bp/image/Fline/qiluyiyou.gif"/></a>  
   
			  <a target="_blank" href="http://www.xiangqi.com.cn/"><img src="/bp/image/Fline/xiangqi.gif"/></a>  
			  <a target="_blank" href="http://www.xqmaster.com/"><img src="/bp/image/Fline/xqmaster.gif"/></a>  
			    
			  <hr>
				<a target="_blank" href="http://www.hychess.com/bbs/">[泓弈象棋网]</a> 
				<a target="_blank" href="http://dyqy.5d6d.com/">[东营市象棋论坛]</a> 
				<a target="_blank" href="http://www.rsjy.net/index.php">[日升家园]</a> 
				<a target="_blank" href="http://xqcyfzlm.5d6d.com/bbs.php">[象棋产业发展联盟]</a> 
				<!--<a target="_blank" href="http://www.kxxqlm.com/index.asp">[象棋乐园]</a> -->
				<!--<a target="_blank" href="http://xiaoshu.game.topzj.com/">[笑书联盟]</a -->>  
				<a target="_blank" href="http://www.gjjq.com/">[国际军棋网]</a>
	</div> 
	</td>
    <td width="8" background="/bp/image/twdesign_0012.gif"> </td>
  </tr>
  <tr> 
    <td><img src="/bp/image/twdesign_0013.gif" width="8" height="7"></td>
    <td height="7" background="/bp/image/twdesign_0015.gif"></td>
    <td><img src="/bp/image/twdesign_0014.gif" width="9" height="7"></td>
  </tr>
</table>
';
$title=$zhutibiaoti='友情链接_比赛编排管理系统';

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>