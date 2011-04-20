<table width="988" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="8" rowspan="3">
    <h1 style="display:none;"><?php echo $title?$title:'比赛编排管理系统-适合积分编排、条件淘汰等赛制';?></h1>
    <img class="logo" src="/bp/image/twdesign_0002.gif" width="8" height="132">
    </td>
    <td width="971" height="89" background="/bp/image/twdesign_0006.gif"> <table width="971" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td class="logoimage" height="85" width="260" align="center"><img height="64" width="174" src="/bp/image/logo.gif"/></td>
          <td width="597" align="center"><img src="/bp/image/twdesign_0001.jpg" width="586" height="73"></td>
          <td width="114" height="68" align="center" valign="middle">
             <a href="http://ruyihe.com/" class="China-12-FFFFFF-20">主 站 首 页</a><br>
	         <a href="http://ruyihe.com/bbs/" class="China-12-FFFFFF-20">交 流 论 坛</a><br>
             <a href="http://ruyihe.com/blog/" class="China-12-FFFFFF-20">站 长 博 客</a></td>
        </tr>
      </table></td>
    <td width="8" rowspan="3"><img src="/bp/image/twdesign_0003.gif" width="9" height="132"></td>
  </tr>
  <tr> 
    <td height="5" bgcolor="#5C5C5C"></td>
  </tr>
  <tr> 
    <td height="38" align="center" background="/bp/image/twdesign_0004.gif"> <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="15%">
 <table width="950" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'index.php')?print '-checked':'';?>">
          <a href="/bp/index.php">频道首页</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'zhgl.php')?print '-checked':'';?>">
         	 <a href="/bp/user/zhgl.php">账号管理</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'shoucang.php')?print '-checked':'';?>">
         	 <a href="/bp/user/shoucang.php">我的收藏</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'saishi.php')&&!strstr($_SERVER['REQUEST_URI'],'?bsid')?print '-checked':'';?>">
          	<a title="显示自己创建的所有赛事，可编辑指定赛事的基本信息或删除，点击标题可进入对应的比赛编排，" href="/bp/user/saishi.php">我的赛事</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="78" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'xinjian.php')?print '-checked':'';?>">
          	<a href="/bp/user/xinjian.php">新建赛事</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="78" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'saishi.php?bsid')?print '-checked':'';?>">
          	<a title="当前比赛的相关管理：比赛基本信息维护，退赛选手列表，淘汰选手列表，编排进度，问题提交，意见反馈" href="/bp/user/saishi.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">赛事配置</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="78" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'xsgl.php')?print '-checked':'';?>">
         	 <a title="当前比赛的选手信息管理，增删选手，另外可以指定选手的退赛、犯规记录" href="/bp/user/xsgl.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">选手管理</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="78" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'bianpai.php')?print '-checked':'';?>">
          	<a title="当前比赛的当前轮次的对阵编排（有已保存和未保存之分）" href="/bp/user/bianpai.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">比赛编排</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'dengfen.php')?print '-checked':'';?>">
         	 <a title="当前比赛的当前轮次的选手成绩录入" href="/bp/user/dengfen.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">比赛登分</a>
          </td>
          <td width="2" ><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'cxhf.php')?print '-checked':'';?>">
         	 <a title="已指定比赛的，可选择恢复到任意轮次（可选是否保存当轮成绩）的编排记录；如没指定比赛，则先指定"  href="/bp/user/cxhf.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">查询恢复</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="79" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'sczb.php')?print '-checked':'';?>">
         	 <a title="已指定比赛的，可选择输出的各种编排记录公布表；如没指定比赛，得先指定" href="/bp/user/sczb.php<?php $_GET['bsid']?print('?bsid='.$_GET['bsid']):''; ?>">输出制表</a>
          </td>
          <td width="2"><img src="/bp/image/twdesign_0007.gif" width="2" height="38"></td>
          <td width="77" align="center" class="China-12-333333-20<?php strstr($_SERVER['REQUEST_URI'],'syjc.php')?print '-checked':'';?>">
          	
         	 <a title="本系统的使用教程，逐步完善中，拟使用图文并茂、音像视频、在线互动等方式方法" href="http://ruyihe.com/bbs/forum-67-1.html" target="_blank">使用教程</a>
         	 <!-- 
         	 <a title="本系统的使用教程，逐步完善中，拟使用图文并茂、音像视频、在线互动等方式方法" href="/bp/user/syjc.php" target="_blank">使用教程</a> 
         	 -->
          </td>
        </tr>
      </table>
          </td>
        </tr>
      </table></td>
  </tr>
</table>