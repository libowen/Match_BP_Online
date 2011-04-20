

<!--
队员总分制团体计分表 
获取数据：bsinfo tuanduis duiyuanshu chuque qianji
其中：tuanduis[团队号数][duiming/fen/zuihaomc/duiyuan/duimc]，duiyuan为数组
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
	font-size: 18px;
	text-align: center;
}
.hangtr td {	padding-top:6px;	padding-bottom:6px;}
.hangtr:hover {
    background-color:#FFFF99;
}
.firsthang td {
 border-top:medium double #999999; padding:4px 0px; 
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
						<div style="padding:8px;font-family:'黑体';font-size:24px;text-align:center;">
							队员（个人）总分制团体计分表
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
									<th width="32" height="56">单位</th>
									<th width="auto" colspan="2">姓&nbsp;名</th>
									<th width="50">积分</th>
									<th width="50">个人<br />名次</th>
									<th width="70">名次分</th>
									<th width="70">最高个<br />人名次</th>
									<th width="50">全队<br />犯规</th>
									<th width="50">团体<br />名次</th>
								  </tr>
						  <?php 
						  
						  $duiyuanshu?'':$duiyuanshu=1;
						  
						  if ($xianshu) {
						  	//print_r($tuanduis[1]);
						  $mingcizi=array('一','二','三','四','五','六','七','八','九','十');
						  	 foreach ($tuanduis as $key => $value){
						  	 //key是数字键名会被重新索引。 
							      for ($ke=0;$ke<$duiyuanshu;$ke++) {
								  //foreach ($value['duiyuan'] as $ke => $val){
								  $val=$value['duiyuan'][$ke];
								      if (!$ke) {  //第一个队员
						  ?>
								  <tr class="hangtr firsthang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
									<td rowspan="<?php echo $duiyuanshu;?>">
										<?php echo $tuanduis[$key]['duiming']; ?>
									</td>
									<td width="50" class="xianshou">
										<?php echo $val['xs_xuhao'];?>
									</td>
									<td>
										<?php echo $val['xs_name'];?>
									</td>
									<td>
										<?php echo $val['xs_zongfen'];?>
									</td>
									<td class="houshou" >
										<?php echo $val['xs_paiming'];?>
									</td>
									<td rowspan="<?php echo $duiyuanshu;?>">
										<?php echo $tuanduis[$key]['fen']; ?>
									</td>
									<td rowspan="<?php echo $duiyuanshu;?>">
										<?php
									//if ($tuanduis[$key]['fen']==$tuanduis[$key-1]['fen']||$tuanduis[$key]['fen']==$tuanduis[$key+1]['fen']){
									 	echo $tuanduis[$key]['zuihaomc']; 
									//}
									 	?>
									 </td>
									<td rowspan="<?php echo $duiyuanshu;?>">
										<?php
									 	echo $tuanduis[$key]['duifangui']; 
									 	?>
									</td>
									<td class="jifen" rowspan="<?php echo $duiyuanshu;?>">
									<?php
									$linshi=$tuanduis[$key]['duimc']-1;
									echo isset($mingcizi[$linshi])?$mingcizi[$linshi]:$tuanduis[$key]['duimc'];
									 ?>
									</td>
								  </tr>
						  <?php
						               }else{
						  ?>		   
								 <tr class="hangtr" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
									<td class="xianshou" width="50">
										<?php echo $val['xs_xuhao'];?>
									</td>
									<td>
										<?php echo $val['xs_name'];?>
									</td>
									<td>
										<?php echo $val['xs_zongfen'];?>
									</td>
									<td class="houshou" >
										<?php echo $val['xs_paiming'];?>
									</td>
								  </tr>
						  <?php		   
									   }
								 }
							 }
						  }else{
						  ?>
						       <tr>
								  <td colspan="10">
								  无任何数据，可能是所有的团队的队员数都不够且不计算队员数不够的团队的名次！								  </td>
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
					<td width="30%" >
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
