<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME="Keywords" CONTENT="比赛,编排,软件,系统,积分编排,中国象棋,棋类">

<META NAME="Description" CONTENT="在线比赛编排管理系统，可进行积分编排，<?php echo '《',$title,'》比赛，简介：',$bsinfo['bs_guicheng'];?>">
<META NAME="Generator" CONTENT="LiBowen's HTML Generator">
<META NAME="Robots" CONTENT="all">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php $title?print $title:print '无标题';?></title>

<link href="/bp/css/<?php $css?print $css:print 'shuchu';?>.css" rel="stylesheet" type="text/css">
<script src="/bp/js/<?php $js?print $js:print 'shuchu';?>.js" type="text/javascript" language="javascript"></script>

<!--工具盒相关配置：
第二div的class= A4H 或 A4S；
数据tr中的 class="hang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)"；
页码区域的class=yemaquyu；比赛时间的class=bisaishijian；比赛地点的class=bisaididian；打印时间的class=printtime；比赛组别的class=bisaizubie；
以上5个均在div内；
锚点的增加；主体字体大小必有【a, td, th, input, select】 否则FF无效；
先手背景色class=xianshou；后手背景色class=houshou；每轮积分背景色class=jifen；
纸张内的第一层table的id=content；
数据行的第一层table的class="shujutable"；

标题需另外控制；
id=content是必须有的，不然纸张的第一层table无上下边距，或者另外控制
table不能含有 </tbody>；
可能需控制表头的样式不变；
shujutable的table下有注释的ff也算一个节点，IE也会出错！！！
必须在css中定义过的选择器才能被rules（IE）cssRules(FF)记录 如.xianshou .jifen等
按数据里的不同增加.hang td {	padding-top:4px;	padding-bottom:4px;}====可考虑同一控制

A4中已增加的：
打印样式的写法<style type="text/css" media="print" title="print">
和js修改方法  +	.jifen {}
				.xianshou {}
				.houshou {}
				.hang {}

-->
<style type="text/css">
<!--
/*工具盒相关的样式*/
.gongjuhe {
	width: 660px;
	height: 193px;/* IE8需要确切的值 */
	border: 2px solid red;
	background-color: #EFEFEF;
	 right:0;
	 bottom:0; 
	z-index: 9999;	 
}

.gongjuhe table {
	width:100%;
	height:100%;
}
.gongju table {
	height:120px;
}
.gongjuhe a,.gongjuhe td,.gongjuhe th,.gongjuhe input,.gongjuhe select {
	font-size: 16px!important;
	text-align: center;
}

.gongju input,.gongju,.gongju td{
    font-size:14px!important ;
}

.zhongjian {
	width:33%;
	height:auto;
}
.zhongjian,.zhongjian input{
text-align:left;
}

.dibiao {
text-align:center;
font-weight:bold;
vertical-align:middle;
}
/*工具盒相关的样式*/


-->
</style>


</head>

<body align="center">
   <div class="maomao" style="width:0;height:0"><a name="maotop" id="maotop">&nbsp</a></div><!--锚点设置，从1开始 -->
     <?php 
	 if($neirong){
		 echo $neirong;
	 }else{
		 if($neirongFile){
		 	include_once(ROOT_PATH.'zhibiao/neirong/'.$neirongFile);
		 }else{
	     //没有赋值，应该输出相应的空表！
		 }
	 }
	  ?> 
   <div class="maomao" style="width:0;height:0"><a name="maobutton" id="maobutton">&nbsp</a></div><!--锚点设置，从1开始。加div为了打印输出不留空白页。a用display无效 -->

<div id="gongjuhe" class="gongjuhe" style="position: absolute;" >
	  <div style="width:100%; height:24px; font-size:14px; text-align:center;">
			  
			<table border="0" bgcolor="#FF9900" cellspacing="0" cellpadding="0">
		  <tr>
		    <td title="页面刷新后本设置无效，需重新设置" 
			    style="width:80px; font-family:'黑体'; font-size:16px;cursor:hand; cursor:pointer; " 
			    onclick="suofang()">
				如意盒
			</td>
			<td onclick="getAllSheets()">-比赛编排管理系统-
			&nbsp;&nbsp;&nbsp;
			<a href="#" onclick="goToNewUrl('dijilun','<?php echo $_GET['dijilun']?($_GET['dijilun']-1):($dijilun-1);?>',0)">
				上轮
			</a>
			<input onblur="goToNewUrl('dijilun','1',0,this)"  ondblclick="goToNewUrl('dijilun','1',0,this)" 
			     value="<?php echo $_GET['dijilun']?$_GET['dijilun']:$dijilun;?>" 
			     size="2"/>
			<a href="#" onclick="goToNewUrl('dijilun','<?php echo $_GET['dijilun']?(1+$_GET['dijilun']):(1+$dijilun);?>',0)">
				下轮
			</a>
			</td>
			<td><!--统计代码 -->
				<script type="text/javascript">
				var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
				document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F1b3c161953b2b3f01dab7a4d523176c6' type='text/javascript'%3E%3C/script%3E"));
				</script> 
				<script src="http://s13.cnzz.com/stat.php?id=2052676&web_id=2052676&show=pic1" language="JavaScript"></script>
			</td>
			<td>&nbsp;<a title="交流论坛，欢迎共同探讨比赛编排的相关问题" style="font-weight:900;" href="http://ruyihe.com/bbs/" target="_blank">》交流论坛《</a></td>
			<td title="隐藏/显示" style="width:50px; color:#FFFFFF; font-weight:bolder; cursor:hand; cursor:pointer;" onclick="suofang()">
			—&nbsp;□
			</td>
		  </tr>
		</table>
		
	  </div>
	  <?php if ($GRcjform){echo $GRcjform;}?>
	  <div class="gongju" id="gongju">
			<table border="1" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="zhongjian">
			
				<table border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td><input id="printtime" type="text" value="打印时间：" size="26" /></td>
					</tr>
				  <tr>
					<td><input id="bisaishijian" type="text" value="比赛时间：" size="26" /></td>
					</tr>
				  <tr>
					<td><input id="bisaididian" type="text" value="比赛地点：" size="26" /></td>
					</tr>
				  <tr>
					<td><input id="bisaizubie" type="text" value="组别：" size="26" /></td>
					</tr>
				<tr>
					<td title="显示“第_页（共_页）”的区域"><input id="yemaquyu" type="text" value="页码：" size="26" /></td>
				</tr>
				</table>
			
			</td>
			<td class="zhongjian">
				<table border="1" cellspacing="0" cellpadding="0">
				  <tr>
					<td>主体字体大小
					  <input id="zitidaxiao" type="text" size="3" value="" />
					  px</td>
					</tr>
				  <tr>
					<td>条件分页每页
					  <input id="meiyetiaoshu" type="text" size="3" />
		条 </td>
					</tr>
				  <tr>
					<td title="默认是全部，如只填一个，则只显示一页，请填写整数，从1开始">只显示第
					  <input id="xianshiyema1" type="text" size="3" style="width:36px;" />
		-
		<input id="xianshiyema2" type="text" size="3" style="width:36px;"  />
		页 </td>
					</tr>
				  <tr>
					<td title="启用后，打印时同时打印当前显示的背景色(需打印机设置打印背景)；否则将不使用背景色">背景色渲染：
					行<input type="checkbox" id="fusexuanranH" value="0" onchange="javascript:if(this.value==1){this.value=0;}else{this.value=1;}" />
					对手<input type="checkbox" id="fusexuanranD" value="0" onchange="javascript:if(this.value==1){this.value=0;}else{this.value=1;}" />
					  </td>
					</tr>				  
					<td>外部样式表
					  <!--<input id="waibucss"  type="file" size="2" value="" /> -->
					  </td>
					</tr>
				</table>
			</td>
			<td class="zhongjian">
				<table border="1" cellspacing="0" cellpadding="0">
				  <tr>
					<td>第<input id="tiaozhiyema" type="text" size="2" />页 
					  <a onclick="yematiaozhuan()" style="cursor:pointer; color:blue; font-weight:bold;">GO</a>
					  共<input id="yezongshu" type="text" size="3" value="2" />
					  </td>
					</tr>
				  <tr>
					<td title="具体页码不提示！"><a href="#maotop">首页</a>&nbsp;&nbsp;<a style="cursor:pointer; color:blue;" onclick="fanye(-1)">上页</a>&nbsp;&nbsp;<a style="cursor:pointer; color:blue;" onclick="fanye(1)">下页</a>&nbsp;&nbsp;<a href="#maobutton">末页</a> 
					
					<input id="dangqianyema" type="hidden" value="1" />
					</td>
					</tr>
				  <tr>
					<td title="启用后，鼠标所在行可点击来改变行的颜色-左击添色、双击去色，
								打印时可选择是否显示；
								去勾可清除所有已标注行的背景色">
					启用行标注<input type="checkbox" id="hangbiaozhu" value="1" onchange="DOhangbiaozhu(this)" checked="checked" />
					色值<input title="默认为绿色，可填入英文颜色名或标准色值；或“suiji”几种随机颜色；字数必须大于2" id="hangsezhi" type="text" value="suiji" size="6" />
					</td>
					</tr>
				  <tr>
					<td title="依次是 先手肤色、后手肤色、积分肤色；
							   可填写英文颜色名或颜色值或suiji；
							   修改后双击文字即可，特别是suiji时可随机改变颜色直到满意为止！">
					<input ondblclick="liefuse(this)" title="先手 的对手序号背景色数值" id="xiansezhi" type="text" value="#66FF00" size="6" />
					<input ondblclick="liefuse(this)" title="后手 的对手序号背景色数值" id="housezhi" type="text" value="#CCCCCC" size="6" />
					<input ondblclick="liefuse(this)" title="每轮积分背景色数值" id="fensezhi" type="text" value="suiji" size="4" style="width:42px;"  />
					</td>
					</tr>
				  <tr>
					<td>自适宽度<input type="checkbox" id="zishikuandu" value="0" onchange="zishikuan(this)" />
					&nbsp;<input title="只作为临时的备忘录，没有其他用途" type="text" value="临时记录：" size="12" />
					</td>
					</tr>					
				</table>
			</td>
		  </tr>
		  <tr>
			<td class="dibiao" height="20px">内容修改&nbsp;
				<a style="cursor:pointer; color:blue;" onclick="neirongxiugai()">修改</a>	</td>
			<td class="dibiao">打印预设&nbsp; <a style="cursor:pointer; color:blue;" onclick="dayinyushe()">确定</a></td>
			<td class="dibiao">查看设置</td>
		  </tr>
		</table>
	
	  </div>
	
	
</div>
	
	
<style title="print" media="print" type="text/css">
<!--
/*打印的样式变动，似乎遨游要放在最后才起作用，其他浏览器未知@import url("dayinshuchu.css") print;*/
	.S{
		margin:0;
		padding:0;
		width: auto;
		height:auto;
	}
	.A4S{
		width: auto;
		height: auto;
		border-bottom:0;
	}
	.H{
		margin:0;
		padding:0;
		width: auto;
		height:auto;
	}
	.A4H{
		width: auto;
		height: auto;
		border-bottom:0;
	}
	.content {
		margin:0;
	}
	#content {
		margin: 0;
    }
    .maomao {
		display: none;
	}
		.shujutable {
			margin:0mm;
		}
     #gongju{
    display:none;
    } 
    .gongju{
    display:none;
    }
	#gongjuhe{
    display:none;
    } 
    .gongjuhe{
    display:none;
    }
	.jifen {}
	.xianshou {}
	.houshou {}
	.hang {}
-->
</style>


<script language="javascript" type="text/javascript">
function fudong(){
		if (document.documentElement.clientHeight) {  //IE6和IE8的临时兼容，某些情况可能还不正确！
			needdom=document.documentElement;
		} else {
			needdom=document.body;
		}
		//scrollT=needdom.scrollTop;
		//scrollL=needdom.scrollLeft;
		//clientH=needdom.clientHeight;
		//clientW=needdom.clientWidth;

	document.getElementById("gongjuhe").style.top=(needdom.scrollTop+needdom.clientHeight-document.getElementById("gongjuhe").offsetHeight)+"px";
	document.getElementById("gongjuhe").style.left=(needdom.scrollLeft+needdom.clientWidth-document.getElementById("gongjuhe").offsetWidth)+"px";
		//alert(scrollT+'----'+clientH);
	//alert(document.getElementById("gongjuhe").style.top+'==='+document.documentElement.scrollTop+'ddd'+document.body.scrollTop+'ddd'+document.documentElement.clientHeight+'hhh'+document.getElementById("gongjuhe").offsetHeight+'ppp'+document.body.clientHeight);
	//document.getElementById("gongjuhe").style.top="-100px";
	//document.getElementById("gongjuhe").style.left="-100px";
	//alert(document.documentElement.scrollTop);
	//alert(document.body.clientHeight);
}

/*工具盒的缩放*/
function suofang(){
	if(document.getElementById("gongju").style.display!='none'){
	     document.getElementById("gongjuhe").style.height='25px';
	     document.getElementById("gongju").style.display='none';
    }else{
	     document.getElementById("gongjuhe").style.height='193px';
	     document.getElementById("gongju").style.display='block';
	}
	if(window.ActiveXObject){
	     fudong();
	}
}
function scall(){
	 if(window.ActiveXObject){
        fudong();
	 }
}
window.onscroll=scall;
window.onresize=scall;
window.onload=zairu;
function zairu () {
	 if(window.ActiveXObject){
	 	scall();
		//alert('');
	 }else{
	   	document.getElementById("gongjuhe").setAttribute('style','float:left; position:fixed;');
	 }
}
</script>
<script type="text/javascript" src="/bp/js/goto.js"></script>

</body>
</html>


