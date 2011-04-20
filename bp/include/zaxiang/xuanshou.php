
<style type="text/css">
<!--
.xuanshouxinxi {
	width:600px;
	margin:0px auto;
	padding:0px auto;
	font-size:14px;
}
.xuanshouxinxi table{
	width:100%;
	border-color:#DDDDDD;
}
.xuanshouxinxi table table td{
	border-bottom:3px double #CCCCCC; padding:4px 0px;
}
.xuanshouxinxi table table tr:hover {
	background-color:gold;
}
.xuanshouxinxi td,.xuanshouxinxi th {
	padding:4px 0px;
}
.xuanshouxinxi a {
	color:blue;
	font-weight:normal;
	text-decoration:underline;
}

.biaotou {
	background-color:#DDDDDD;
}

.xulie:hover {
	background-color:gold;
}
.duishouqianfen,.jifen {
	color:green;
}
-->
</style>

<div class="xuanshouxinxi">
<br>
<form action="xuanshou.php" method="get">
<table border="1" cellspacing="0" cellpadding="0">
  <tr class="biaotou">
    <th colspan="6" scope="col">选手查询</th>
  </tr>
  <tr>
    <td>比赛ID</td>
    <td><input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="8" /></td>
    <td>选手序号</td>
    <td>
	<input type="text" value="<?php //echo $xs['xs_xuhao'];?>" size="8" name="xsxuhao"/></td>

    <td>选手姓名</td>
    <td><input type="text" value="<?php //echo $xs['xs_name'];?>" size="18" name="name"/></td>
  </tr>
  <tr>
    <td colspan="6">
    	<input type="submit" value="查询" />
    </td>
  </tr>
</table>
</form>
<br>
<form action="xuanshou.php?bsid=<?php echo $_GET['bsid']?$_GET['bsid']:$xs['xs_bs_id'];?>" method="post">

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th class="biaotou" colspan="7" scope="col">
    （<?php echo $xs['xs_xuhao'];?>）<?php echo $xs['xs_name'];?>&nbsp;
    _信息修改</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="100">选手姓名</td>
    <td width="400" colspan="5">（<?php echo $xs['xs_xuhao'];?>）<input type="text" value="<?php echo $xs['xs_name'];?>" size="20" disabled="disabled" /> 
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="hidden" value="<?php echo $xs['xs_xuhao'];?>" name='xuhao' />
	<select onchange="gotoxs(<?php echo $_GET['bsid'];?>,'',this)">
	<?php 
		if ($xss) {
			foreach ($xss as $value) {
	?>
      		<option value="<?php echo $value['xs_xuhao'],'">（',$value['xs_xuhao'],'）',$value['xs_name'];?></option>
    <?php 
			}
		} else {
			echo '<option value="1">-无选择-</option>';
		}
     ?>
    </select>
	</td>
  </tr>
  <tr>
    <td>所属单位</td>
    <td width="90"><input name="danwei" type="text" size="14" value="<?php echo $xs['xs_danwei'];?>" /></td>
    <td width="38">性别</td>
    <td width="90"><select name="sex">
      <option value="0">男</option>
      <option value="1" <?php $xs['xs_sex']?print 'selected="selected"':'';?>>女</option>
    </select></td>
    <td width="38">半区</td>
    <td width="90">
	  <select name="banqu">
	    <option value="0" <?php !$xs['xs_banqu']?print 'selected="selected"':'';?>>不区分</option>
	    <option value="1" <?php $xs['xs_banqu']==1?print 'selected="selected"':'';?>>上半区</option>
	    <option value="2" <?php $xs['xs_banqu']==2?print 'selected="selected"':'';?>>下半区</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>犯规</td>
    <td>
	<input name="fangui" type="text" size="6" value="<?php echo $xs['xs_fangui'];?>"></td>
    <td>退赛</td>
    <td><input name="tuichu" type="checkbox" value="1" <?php $xs['xs_tuichu']?print 'checked="checked"':'';?> /></td>
    <td>总分</td>
    <td><input name="zongfen" type="text" size="6" value="<?php echo $xs['xs_zongfen'];?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="center">
<?php if ($xs['xs_xuhao']>1&&$xs['xs_xuhao']<=count($xuanshous)) {?>
    <a href="/bp/user/xuanshou.php?bsid=<?php
     	echo  $_GET['bsid'],'&xsxuhao=',($xs['xs_xuhao']-1); 	echo $_GET['lunci']?'&lunci='.$_GET['lunci']:'';
    ?>">
    上个选手
    </a>
<?php }?>
    &nbsp;<a style="color:black;text-decoration:none;">（<?php echo $xs['xs_xuhao'];?>）</a>&nbsp;
<?php if ($xs['xs_xuhao']>0&&$xs['xs_xuhao']<count($xuanshous)) {?>
    <a href="/bp/user/xuanshou.php?bsid=<?php
     	echo $_GET['bsid'],'&xsxuhao=',(1+$xs['xs_xuhao']); 	echo $_GET['lunci']?'&lunci='.$_GET['lunci']:'';
    ?>">
    下个选手
    </a>
<?php }?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="tijiao" value="提交修改" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="重置" /></td>
  </tr>
  <tr>
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
</table>
</form>
<br>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <th class="biaotou" colspan="10" scope="col">
   	 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    	（<?php echo $xs['xs_xuhao'];?>）<?php echo $xs['xs_name'];?>&nbsp;_的统计信息
    	&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if ($lunci>1&&$lunci<=$fenShuLun) {?>
    	<a href="/bp/user/xuanshou.php?bsid=<?php
     	echo $_GET['bsid'],'&xsxuhao=',$xs['xs_xuhao']; 	echo '&lunci=',($lunci-1);
	    ?>">
	    	上轮
	    </a>
    <?php }?>
	    &nbsp;<a style="color:black;text-decoration:none;">截止第<?php echo $lunci; //有get的lunci使用它，没有则是$lunci ?>轮</a>&nbsp;
	<?php if ($lunci>0&&$lunci<$fenShuLun) {?>
	    <a href="/bp/user/xuanshou.php?bsid=<?php
     	echo $_GET['bsid'],'&xsxuhao=',$xs['xs_xuhao']; 	echo '&lunci=',($lunci+1);
	    ?>">
	    	下轮
	    </a>
	 <?php }?>
    </th>
  </tr>
  <tr>
    <td width="60">轮次</td>
    <td width="50">对手号</td>
    <td width="auto">--对手单位--</td>
    <td width="auto">--对手姓名--</td>
    <td width="40" title="对手在相遇那轮的前一轮的积分">对手<br>前分</td>
    <td width="40">对手<br>总分</td>
    <td width="40">先后</td>
    <td width="40">结果</td>
    <td width="40">当轮<br>得分</td>
    <td width="40">上轮<br>积分</td>
  </tr>
  <tr>
    <td colspan="10">
	    <table width="100%" border="1" cellpadding="0" cellspacing="0">
	    <?php 
	if (count($fenShus)>0) {
	     for ($key=0;$key<$lunci;$key++) {
	    ?>
		      <tr>
		        <td width="60">第<?php echo 1+$key;?>轮</td>
		        <td class="xuhao" width="50"><?php echo $toWhos[$key];?></td>
		        	<td class="danwei" width="auto"><?php echo $duiShouDanWeis[$key];?></td>
		        <td class="xingming" width="auto"><?php echo $duiShouNames[$key];?></td>
		        <td class="duishouqianfen" width="40"><?php echo $duiShouFens[$key]; //使用此对手在相遇时的前一轮积分?></td>
		        	<td class="duishoujifen" width="40"><?php echo $duiShouZongFens[$key]; //使用此对手截止指定轮次的总分?></td>
		        <td width="40"><?php echo $xianHous[$key]=='+'?'先':'后'; ?></td>
		        <td width="40"><?php echo $shengFus[$key];?></td>
		        <td class="defen" width="40"><?php echo $fenShus[$key];?></td>
		        <td class="jifen" width="40"><?php echo $shangLunFens[$key];?></td>
		      </tr>
	      <?php 
	      }
	} else {
		echo '<tr><td>数据为空</td></tr>';
	}
	      ?>
	    </table>
    </td>
  </tr>
  <tr class="biaotou">
    <td colspan="10">【统计】&nbsp;总分：<?php echo $zongFen;?>
    &nbsp;&nbsp;当前累进分：<?php echo $leiJinFen;?>
    &nbsp;&nbsp;当前对手分：<?php echo $duiShouFen;?>
    &nbsp;&nbsp;总成绩：<?php echo $shengShu;?>胜
    &nbsp;<?php echo $heShu;?>和
    &nbsp;<?php echo $fuShu;?>负
    </td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">后手胜局：<?php echo $houShengShu;?>
    &nbsp;&nbsp;后手局数：<?php echo $houShouShu; //犯规次数与轮次无关！！?>
    &nbsp;&nbsp;犯规：<?php echo $xs['xs_fangui']; //犯规次数与轮次无关！！?>
    &nbsp;&nbsp;胜率：<?php echo (number_format(round($shengShu*10000/$lunci)/100,2)).'%';?>
    &nbsp;&nbsp;后手胜率：<?php echo $houShouShu?(number_format(round($houShengShu*10000/$houShouShu)/100,2)).'%':'0.00%';  //后手局数中获胜的概率?>
    </td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮的台号：<?php echo $taiHaoLie;?></td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮对手号：<?php echo $toWhoLie;?></td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮的得分：<?php echo $fenShuLie;?></td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮先后手：<?php echo $xianHouLie;?></td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮上下调：<?php echo $shangXiaLie;?></td>
  </tr>
  <tr>
    <td class="xulie" colspan="10">各轮看弃权：<?php echo $lianQiLie;?></td>
  </tr>
  <tr>
    <td colspan="10">&nbsp;</td>
  </tr>
</table>

</div>
