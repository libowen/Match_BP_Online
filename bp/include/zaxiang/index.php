<!--显示界面：我的赛事，个人创建的比赛：显示列表，有编辑跳转按钮（跳转）和删除按钮（需再次确定）；-->
<style type="text/css">
<!--
table,td,th {
	border-color:#DDDDDD;
}
/* 赛事列表table */
.Lssliebiao th{
	padding: 4px 0px; 
	background-color:#CCCCCC;
}
.Lssliebiao .hangtr td {
	/* border-bottom:3px inset #999999; */
	padding: 3px 0px; 
}
.Lssliebiao {
	border-color:#DDDDDD;
	width:auto;  /* 配合这个IE6和FF的显示才一样：div内全显示 */
	margin:0px auto;
	background-color:white;
}

/* 最新赛事或查询到的赛事的列表的外框 */
.saishiliebiao {
	margin:0px auto;
	/* border:medium double black; */
	width:99%;
	height:auto;	/* height:200px; */
	overflow:auto;
}

/* 随机赛事的列表的外框 */
.suijisaishi {
	margin:0px auto;
	border:medium double black;
	width:99%;
	height:auto;
	overflow:auto;
}

.bsid {
	font-weight:bold;
}
/* 隔行上色 */
.dantr {
	background-color:#EEEEEE;
}

/* 收藏按钮的样式 */
.cang {
	width:25px;
	text-align:center;
	font-size:14px;
	padding:0px;
	margin:0px;
}
.cang:hover {
	color:blue;
}

/* h3等文章内小标题的样式 */
.xiaobiao {
	padding:0px 0px 5px 0px;
	margin:0px;
	text-align:center;
}

/* jianjie比赛编排管理系统功能与教程简介的控制样式 */
.jianjie {
margin:0px auto;
	width:99%;
	height:auto;
	/* border:medium double black; */
	overflow:auto;
	font-size:12px;
}
.jianjieneirong {
	height:auro;
	text-align:left;
	margin:4px;
	font-size:12px;
	line-height:20px;
}
.jianjieneirong a {
	font-size:12px;
	color:blue;
}
form table td,form table th {
	border-color:#666666;
}


-->
</style>
<?php 
if ($pagetitle!='chaxun') {
?>
<!--<div class="jianjie" onclick="suofang(this,1)" ondblclick="suofang(this,2)" title="单击显示全部内容或双击隐藏">-->
<div class="jianjie">
	&nbsp;<h3 class="xiaobiao">《比赛编排管理系统》功能与教程简介</h3>
	<div class="jianjieneirong" >
		<strong>一、系统简介</strong><br />
		   &nbsp;&nbsp;<strong>中文名：</strong>比赛编排管理系统 &nbsp;&nbsp;&nbsp;&nbsp; <strong>英文名：</strong>Match BP Online &nbsp;&nbsp;&nbsp;&nbsp;<strong>联系作者：</strong>ruyihe@126.com &nbsp;&nbsp;&nbsp;&nbsp; <strong>测试账号：</strong>test 密码：test <br />
		   &nbsp;&nbsp;<strong>主要功能：</strong>实现比赛的定位积分编排（又称瑞士制、积分循环制或积分编排制），拥有完善的比赛编排、管理、发布、查询、共享和协同功能，实现了电脑智能编排、可对比及修改编排结果、进行多种表格输出。系统还结合了论坛社区，形成比赛编排、管理、储存、发布、交流和互动的一体化平台。适合各类比赛使用（中国象棋、围棋、五子棋、国际象棋、拖拉机、扑克升级等赛事进行积分编排制的比赛）<br /> 
		   &nbsp;&nbsp;<strong>未来版本计划：</strong>增加office Excel文件（和TXT、其他电子表格等）的数据导出和导入功能（最好是智能识别）；完善牌类拖拉机、扑克升级比赛（目前只是在破同分中增加了总分选项，有点勉强）的编排管理等；增强系统与论坛社区的融合。<br /> 
		   
		
		<strong>二、创新与特色</strong><br />
		&nbsp;&nbsp;1、实现了电脑智能按积分编排规则进行比赛编排配对并输出<br />
		&nbsp;&nbsp;2、实现远程管理，协同管理，网上展示，储存等，编排员可以足不出户远程管理 <br />
		&nbsp;&nbsp;3、方便的管理、打印方式。传统编排程序需要同时携带一台电脑和一台打印机，还需要电源；而本程序只需有打印店在附近，或有智能手机，即可登分、编排并打印结果或手机上网查看编排结果，利于中小型比赛的开展，比赛裁判工作更加公开，传播速度更快速便捷<br />
		&nbsp;&nbsp;4、灵活直观的打印输出，表格显示完全模仿打印预览设计，可以上色标注，修改字体大小、每页行数、比赛地点、时间等信息<br />
		&nbsp;&nbsp;5、网上比赛编排管理在国内/国际上都几近空白；还可增加SNS元素、会员管理功能；<br />
		<strong> <a href="http://ruyihe.com/bbs/forum-67-1.html" target="_blank">《比赛编排管理系统》使用教程和交流</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="http://ruyihe.com/bbs/forum-attachment-aid-MTEyfDA3MWNiZjBlfDEzMDI2MDcyODR8NA%3D%3D.html" target="_blank">《积分编排制方法详解》文档下载</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="http://ruyihe.com/bbs/thread-130-1-1.html" target="_blank">视频教程</a> &nbsp;&nbsp;&nbsp;&nbsp; <a href="http://ruyihe.com/bbs/home-space-uid-4-do-album-id-20.html" target="_blank">效果图</a></strong>

	</div>
</div>
<hr>
<?php }?>

<script type="text/javascript">
function suofang( thisdom,danshuang ) {
	if (thisdom.style.height=='auto') {  //存在说明
			if (danshuang>1) {
				if (thisdom.className=='saishiliebiao') {//只列表
					thisdom.style.height='38px';
				} else {
					thisdom.style.height='';
				}
			}
	} else {
		thisdom.style.height='auto';
	}
}

/* 收藏的处理js */
function cang (thisdom,bsid) {
	thisdom.parentNode.parentNode.style.backgroundColor="gold";
	window.open("/bp/user/shoucang.php?action=cang&bsid=".concat(bsid));
}
</script>
<div class="liebiao">
<?php 
$newbslist = 36;	//首页的页面较长
//for($page=0;$page<2;$page++) {
for($page=0;$page<1;$page++) {   //只显示前10最新
	if ($page) {
		if ($suijibisais) {
		$pagetitle='随机赛事 RAND10';
		$bisais=$suijibisais;	
		} else {
			break;
		}		
	} else {
		if ($pagetitle=='chaxun') {
			$pagetitle='查询结果：';
		} else {
			$pagetitle='最新赛事 TOP10';
		}
	}
?>
		&nbsp;<h3 class="xiaobiao"><?php echo $pagetitle;?></h3>
		<div class="saishiliebiao" onclick="suofang(this,1)" ondblclick="suofang(this,2)">
		<table border="1" class="Lssliebiao">
			  <tr>
			    <th width="36" scope="col">编号</th>
			    <th width="auto" scope="col">标题</th>
			    <th width="60" scope="col">项目</th>
			    <th width="60" scope="col">组别</th>
			    <th width="88" scope="col">比赛地点</th>
			    <th width="72" scope="col">比赛时间</th>
			    <th width="60" scope="col">编排类型</th>
		<!--	    <th width="30" scope="col">轮数</th>-->
			    <th width="72" scope="col">创建日期</th>
			    <th width="118" scope="col" colspan="2">
			    <a target="_blank"  style="font-size:14px;" href="#" title="查看赛事的基本信息或收藏指定赛事">操作</a>
			    </th>
			  </tr>
		         <?php //echo $bisaisliebiao;?>
		<?php
			if ($bisais[0]) {
				foreach ($bisais as $key => $value) {
						$BSxiangmu='';
						$BPleixing='';
						switch ($value['bs_BSxiangmu']){
							case 1:
							$BSxiangmu='中国象棋';	
							 break;
							case 2:
							$BSxiangmu='国际象棋';	
							 break;
							case 3:
							$BSxiangmu='围棋';	
							 break;
							case 4:
							$BSxiangmu='五子棋';	
							 break;
							case 5:
							$BSxiangmu='其它';	
							 break;
							default:
							$BSxiangmu='中国象棋';
							 break;
						}
						switch ($value['bs_BPleixing']){
							case 1:
							$BPleixing='积分编排';	
							 break;
							case 2:
							$BPleixing='大循环';	
							 break;
							case 3:
							$BPleixing='单淘汰';	
							 break;
							case 4:
							$BPleixing='双淘汰';	
							 break;
							case 5:
							$BPleixing='积分末位淘汰';	
							 break;
							default:
							$BSxiangmu='积分编排';
							 break;
						}
		?>
			     <tr class="hangtr <?php echo $key%2?' dantr':'';?>">
				    <td class="bsid" title="点击进行表格输出。比赛备注：<?php echo $value['bs_beizhu'];?>"><a target="_blank"  href="/bp/user/sczb.php?bsid=<?php echo $value['bs_id'];?>"><?php echo '[',$value['bs_id'],']';?></a></td>
				    <td title="点击进行比赛编排。"><a target="_blank"  href="/bp/user/bianpai.php?bsid=<?php echo $value['bs_id'];?>"><?php echo $value['bs_biaoti'];?></a></td>
				    <td><?php echo $BSxiangmu;?></td>
				    <td><?php echo $value['bs_zubie'];?></td>
				    <td><?php echo $value['bs_didian'];?></td>
				    <td><?php echo $value['bs_shijian'];?></td>
				    <td title="总轮数：<?php echo $value['bs_zonglunshu'];?>     管理员：<?php echo $value['bs_luruyuan'];?>"><?php echo $BPleixing;?></td>
		<!--		    <td><?php echo $value['bs_zonglunshu'];?></td>-->
				    <td title=" 管理员：<?php echo $value['bs_luruyuan'];?>"><?php echo $value['bs_jianliriqi'];?></td>
				    <td><nobr>
					    <a target="_blank"  title="修改比赛的基本信息，编排配置信息" href="/bp/user/saishi.php?bsid=<?php echo $value['bs_id'];?>">配置</a>&nbsp;
					    <a target="_blank"  title="比赛参赛选手的录入、修改序号、犯规次数、指定退赛、删除等" href="/bp/user/xsgl.php?bsid=<?php echo $value['bs_id'];?>">选手</a>
					    </nobr>
					    <br />
					    <a target="_blank"  title="对本比赛进行编排，默认进行下轮编排，或显示当轮已保存的编排结果（未录入成绩时）" href="/bp/user/bianpai.php?bsid=<?php echo $value['bs_id'];?>">编排</a>&nbsp;
					    <a target="_blank"  title="各式表格的输出，可先进行相关配置" href="/bp/user/sczb.php?bsid=<?php echo $value['bs_id'];?>">制表</a>
				    </td>
				    <td>
				    	<input class="cang" type="button" value="藏" onclick="cang(this,<?php echo $value['bs_id'];?>)" />
				    </td>
				  </tr>
			<?php					
				}
			}else{
			?>
			  <tr>
			  <td colspan="11">
			  	<h4>
			  	你还没有创建任何赛事，请点击 <a target="_blank"  href="/bp/user/xinjian.php">新建赛事</a> 进行创建
			  	</h4>
		  	  </td>
			  </tr>
			<?php
			}
			?>
		</table>
		</div>
<?php } //for结束?>	    
		<hr><form name="form_chaxun" method="post" action="">									
				<table border="1" width="100%">
				 <tr>
				   	 <th colspan="6">高级查询</th>
				  </tr>
				
		          <tr>
		            <td>标题(1个词)</td>
		            <td><input type="text" name="biaoti"  size="26" /></td>
		            <td>管理员(精确)</td>
		            <td><input name="luruyuan" type="text" size="12" /></td>
		            <td>项目</td>
		            <td>
		             <select name="BSxiangmu">
					  <option value="0" selected>全部</option>
					  <option value="1">中国象棋</option>
					  <option value="2">国际象棋</option>
					  <option value="3">围   棋</option>
					  <option value="4">五 子 棋</option>
					  <option value="5">其它等等</option>
					</select>
		            </td>
		          </tr>
		          <tr>
		            <td>录入日期(时间段)</td>
		            <td><input name="jianliriqi1" type="text" size="10" value="2010-05-05" />
		              到
		              <input name="jianliriqi2" type="text" size="10" value="2012-06-07" /></td>
		            <td>比赛地点(1个词)</td>
		            <td><input name="didian" type="text" size="12" /></td>
		            <td>比赛时间(1个词)</td>
		            <td><input name="shijian" type="text" size="12" /></td>
		          </tr>
		          <tr>
		            <td>性质(1个词)</td>
		            <td><input name="xingzhi" type="text" size="26" /></td>
		            <td>裁判员</td>
		            <td><input name="caipanyuan" type="text" size="12" />
		            <td>编排员</td>
		            <td><input name="bianpaiyuan" type="text" size="12" /></td>
		          </tr>
		          <tr>
		            <td colspan="6">
					  <input type="submit" name="tijiao" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;
		              <input type="reset" name="reset" value="重置" />
					</td>
		            </tr>
		        </table>
				</form>
</div>	