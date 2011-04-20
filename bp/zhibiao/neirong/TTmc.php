

<!--显示前几名的，
每队取前几名的成绩进行计算，
团队队员不够数的计算方法（是否也计算，并在备注中标注） 
获取数据：bsinfo xuanshous tuanduis
-->
<style type="text/css">
<!--
.biaoti{
	font-family:"黑体";
	font-size:26px;
    
}
.content {
    width:600px;
	text-align:center;
}
.bold {
    font-weight: bold;
}
a,td,th,input,select {
	font-size: 20px;
	text-align: center;
}
.hang td {	padding-top:6px;	padding-bottom:6px;}
.hang:hover {
    background-color:#FFFF99;
}

.printtime {  font-size:smaller;  }

.xianshou{
}
.houshou {
}
.jifen {
}

-->
</style>
<div class="S" align="center">
    <div name="A4" class="A4S">
		 <a name="1" id="1" class="maodian"></a><!--锚点设置，从1开始 -->
			<table class="content" width="600px" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="3">
						<div style="padding:8px;font-family:'黑体';font-size:26px;text-align:center;">
							队员（个人）总分制团体赛团体名次
						</div>
						<div style="padding-bottom:8px;font-family:'宋体';font-size:16px;">
								 【<?php echo $bsinfo['bs_id'];?>】《<?php echo $bsinfo['bs_biaoti']?$bsinfo['bs_biaoti']:'无标题';?>》
								 <?php echo '<br>组别：',$bsinfo['bs_zubie'],'&nbsp;&nbsp;队员数：',$duiyuanshu; ?>&nbsp;&nbsp;
								 缺队员的<?php echo !$chuque?'也':'不';?>参与排名&nbsp;	
						</div>			    
					</td>
				</tr>
				<tr>
				<td colspan="3">
						<table class="shujutable" width="100%" border="1" cellspacing="0" cellpadding="0">
								<tr>
									<th width="120" height="56">名次</th>
									<th width="auto">单位</th>
									<th width="90">名次分</th>
									<th width="90">最高个<br />人名次</th>
									<th width="110">备注</th>
								  </tr>
						  <?php 
						  if ($xianshu) {
						  	//print_r($tuanduis[1]);
						  $mingcizi=array('一','二','三','四','五','六','七','八','九','十',
						  				'十一','十二','十三','十四','十五','十六','十七','十八','十九','二十',);
						  		foreach ($tuanduis as $key => $value){
						  	//key是数字键名会被重新索引。 
						  ?>
								  <tr class="hang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
									<td class="xianshou">第<?php echo isset($mingcizi[$key])?$mingcizi[$key]:'&nbsp;'.($key+1).'&nbsp;'; ?>名 </td>
									<td class="houshou"><?php echo $tuanduis[$key]['duiming']; ?></td>
									<td class="jifen"><?php echo $tuanduis[$key]['fen']; ?> </td>
									<td >
									<?php
									if ($tuanduis[$key]['fen']==$tuanduis[$key-1]['fen']||$tuanduis[$key]['fen']==$tuanduis[$key+1]['fen']){
									 	echo $tuanduis[$key]['zuihaomc']; 
									}
									 ?>
									</td>
									<td >&nbsp;</td>
								  </tr>
						  <?php
								}
						  }else{
						  ?>
						       <tr>
								  <td colspan="6">
								  无任何数据，可能是所有的团队的队员数都不够且不计算队员数不够的团队的名次！
								  </td>
							   </tr>
						  <?php
						  }
						  ?>
							</table>
				 </td>
				</tr>
				<tr>
					<td colspan="3" height="8px">
					</td>
				</tr>
				<tr>
					<td width="30%">
					裁判长：
					<?php echo $bsinfo['bs_caipanzhang']?$bsinfo['bs_caipanzhang']:''; ?>
					</td>
					<td width="30%">
					编排：
					<?php echo $bsinfo['bs_bianpaiyuan']?$bsinfo['bs_bianpaiyuan']:''; ?>
					</td>
					<td width="40%">
					<div class="printtime" align="right">
					打印时间：
					<?php 
					date_default_timezone_set('PRC');
					echo date("m月d日  H:i");
					?>
					</div>
					</td>
				</tr>
			</table>
	</div>
</div>
