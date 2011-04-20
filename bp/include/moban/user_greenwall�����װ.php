<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title?$title:'比赛编排管理系统=如意盒出品';?></title>
	<meta name="keywords" content="">
	<meta name="description" content=" 如意盒论坛  - Discuz! Board">
	<meta name="generator" content="Discuz! 7.2">
	<meta name="author" content="Discuz! Team and Comsenz UI Team">
	<meta name="copyright" content="2001-2009 Comsenz Inc.">
	<meta name="MSSmartTagsPreventParsing" content="True">
	<meta http-equiv="MSThemeCompatible" content="Yes">
	<meta http-equiv="x-ua-compatible" content="ie=7">
		<link rel="archives" title="比赛编排管理系统" href="http://localhost/g/bbs/archiver/">
		<link rel="alternate" type="application/rss+xml" title="如意盒论坛" href="http://localhost/g/bbs/rss.php?auth=0">
		
  <link rel="stylesheet" id="style_line" type="text/css" href="/bp/css/greenwall.css">
  
<!--<script type="text/javascript">var STYLEID = '3', IMGDIR = 'images/greenwall', VERHASH = 'LuX', charset = 'UTF-8', discuz_uid = 0, cookiedomain = '', cookiepath = '/', attackevasive = '0', disallowfloat = 'login|register|sendpm|newthread|reply|viewratings|viewwarning|viewthreadmod|viewvote|tradeorder|activity|debate|nav|usergroups|task', creditnotice = '1|威望|,2|金钱|', gid = parseInt('0'), fid = parseInt('0'), tid = parseInt('0')</script> -->

</head>

<body id="index" onkeydown="if(event.keyCode==27) return false;">

<div id="append_parent"></div>

<div id="ajaxwaitid"></div>

<div id="header">
<div class="wrap s_clear">
<h2><a href="http://localhost/g/bbs/index.php" title="如意盒论坛"><img src="/bp/images/greenwall/logo_bp.gif" alt="如意盒论坛" border="0"></a></h2>
<div id="umenu">
<a href="http://localhost/g/bbs/register.php" onclick="showWindow('register', this.href);return false;" class="noborder">注册</a>
<a href="http://localhost/g/bbs/logging.php?action=login" onclick="showWindow('login', this.href);return false;">登录</a></div>
<div class="" id="ad_headerbanner">大哥大哥回来看见广告歌
打飞机开房间</div>
<div id="menu">
<ul>
<li class="current"><a href="http://localhost/g/bbs/index.php" hidefocus="true" id="mn_index">论坛</a></li>
<li class="menu_2"><a href="http://localhost/g/bbs/search.php" hidefocus="true" id="mn_search">搜索</a></li>
<li><a id="mn_plink_userapp" href="http://localhost/g/bbs/userapp.php">应用程序</a></li>
<li class="menu_4"><a href="http://localhost/g/bbs/faq.php" hidefocus="true" id="mn_faq">帮助</a></li>
<li class="menu_5"><a href="http://localhost/g/bbs/misc.php?action=nav" hidefocus="true" onclick="showWindow('nav', this.href);return false;">导航</a></li>
<li class="menu_6"><a href="#" hidefocus="true" target="_blank" id="mn_#" style="color: orange;">菜的</a></li>
</ul>
</div>
<script type="text/javascript">
function setstyle(thisDOM) {

stylename=thisDOM.getAttribute("title");
styleDOM=document.getElementById("style_line");
styleURL=document.getElementById("style_line").getAttribute("href");

newURL=styleURL.replace(/css/,"d");
alert(newURL);
//alert('dd');
/*
str = unescape('');
str = str.replace(/(^|&)styleid=\d+/ig, '');
str = (str != '' ? str + '&' : '') + 'styleid=' + styleid;
location.href = 'index.php?' + str;
*/
}
</script>
<ul id="style_switch"><li><a onclick="setstyle(this)" title="grenwall" style="background: rgb(30, 75, 126) none repeat scroll 0% 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;">greenwall</a></li>
</ul>
</div>
<div id="myprompt_menu" style="display: none;" class="promptmenu">
<div class="promptcontent">
	<ul class="s_clear"><li style="display: none;"><a id="prompt_pm" href="http://localhost/g/bbs/pm.php?filter=newpm" target="_blank">私人消息 (0)</a></li><li style="display: none;"><a id="prompt_announcepm" href="http://localhost/g/bbs/pm.php?filter=announcepm" target="_blank">公共消息 (0)</a></li><li style="display: none;"><a id="prompt_systempm" href="http://localhost/g/bbs/notice.php?filter=systempm" target="_blank">系统消息 (0)</a></li><li style="display: none;"><a id="prompt_friend" href="http://localhost/g/bbs/notice.php?filter=friend" target="_blank">好友消息 (0)</a></li><li style="display: none;"><a id="prompt_threads" href="http://localhost/g/bbs/notice.php?filter=threads" target="_blank">帖子消息 (0)</a></li><li style="display: none;"><a id="prompt_mynotice" href="http://localhost/g/bbs/userapp.php?script=notice" target="_blank">应用通知 (0)</a></li><li style="display: none;"><a id="prompt_myinvite" href="http://localhost/g/bbs/userapp.php?script=notice&amp;action=invite" target="_blank">应用邀请 (0)</a></li></ul>
</div>
</div>
</div>
<div id="nav"><a href="http://localhost/g/bbs/index.php">如意盒论坛</a> ? 首页</div>
<div id="ad_text"></div>

<div id="wrap" class="wrap s_clear">
	<div style="width:762px; margin:0 auto; padding:10px 0;">
		<?php
			  if ($zhutizuoce) {      //输出变量
				echo $zhutizuoce;
			  }
			  if ($zhutizuoceFile) {  //载入文件
				include_once(INCLUDE_PATH."zaxiang/".$zhutizuoceFile);
			  }
		?>
	</div>
</div>
<div class="ad_footerbanner" id="ad_footerbanner1">
    大幅度就赶快老规矩<img src="images/greewall/logo_003.gif">dgdg
</div>
<div id="ad_footerbanner2"></div>
<div id="ad_footerbanner3"></div>

<div id="footer">
	<div class="wrap s_clear">
	<div id="footlink">
	<p>
	<strong><a href="http://ruyihe.com/" target="_blank">如意盒</a></strong>
	<span class="pipe">|</span><a href="mailto:ruyihe@163.com">联系我们</a>
	<span class="pipe">|</span><a href="http://localhost/g/bbs/archiver/" target="_blank">Archiver</a><span class="pipe">|</span><a href="http://localhost/g/bbs/wap/" target="_blank">WAP</a></p>
	<p class="smalltext">
	GMT+8, 2010-5-5 09:12, <span id="debuginfo">Processed in 11.409044 second(s), 18 queries</span>.
	</p>
	</div>
	<div id="rightinfo">
	<p>Powered by <strong><a href="http://www.discuz.net/" target="_blank">Discuz!</a></strong> <em>7.2</em></p>
	<p class="smalltext">? 2001-2009 <a href="http://www.comsenz.com/" target="_blank">Comsenz Inc.</a></p>
	</div></div>
</div>

<!--<script type="text/javascript">
function showads(unavailables, filters) {
var ad, re;
var hideads = $('hide_ads').getElementsByTagName('div');
for(var i = 0; i < hideads.length; i++) {
if(hideads[i].id.substr(0, 8) == 'hide_ad_' && (ad = $(hideads[i].id.substr(5))) && hideads[i].innerHTML && trim(ad.innerHTML) == '') {
ad.innerHTML = hideads[i].innerHTML;
ad.className = hideads[i].className;
}
}
}
showads();
$('hide_ads').parentNode.removeChild($('hide_ads'));
</script> -->

</body></html>