<!--录入选手成绩的显示界面-->
<style type="text/css">
<!--

#dengfen_form table {
	border-color:#CCCCCC;
}

/* 行的显示效果  */
.hangtr td { /* border-bottom:medium double #999999; padding:4px 0px;  */}
.hangtr:hover { background-color:#ffff99; }

/* 台号的显示样式 */
.taihao {  font-weight:bold;	cursor: pointer; 	cursor: hand; }
.taihao:hover { background-color:#660099; 	color:#FFFFFF; }

/* 序号的显示样式 */
.xuhao {
	color:blue;
	font-weight: bold;
	cursor: hand;
	cursor: pointer;
}
.xuhao:hover { background-color: #0000FF;  color:#FFFFFF; }

/* 总分的显示样式 */
.zongfen { color:red; 	font-weight:bold; }

-->
</style>

<form id="dengfen_form" name="dengfen_form" method="post" action="">
	<table width="600px" border="0" align="center">
	  <tr>
		<td height="6" colspan="3"></td>
	  </tr>
	  <tr>
		<td width="34%">
		   <div align="left">
		      组别：<?php echo $bsinfo['bs_zubie'];?>
		   </div>
		</td >
		<td width="33%">分制：[<?php echo $bsinfo['bs_jufenmoshi'];?>]</td>
		<td width="33%">
		   <div align="right">
		       第 <?php echo $dijilun;?> 轮
		   </div>
		</td>
	  </tr>
	  <tr>
		<td height="2" colspan="3"></td>
	  </tr>
	  <tr><!--编排结果显示区域-->
		<td colspan="3">
				<table class="Ldengfen" border="1" align="center">
					  <tr style="background-color:#AAAAAA;">
						<th width="26" rowspan="2" scope="col">台<br>
						次</th>
						<th colspan="3" scope="col">红方</th>
						<th width="100" rowspan="2" scope="col">比赛结果</th>
						<th colspan="3" scope="col">黑方</th>
					  </tr>
					  <?php 
					  if($fenshulun==$dijilun){
						//如果本轮已经录入并保存了成绩，则显示成绩表
						$nalunfen='最新积分';
					  }else{
					    $nalunfen='上轮积分';
					  }?>
					  <tr style="background-color:#AAAAAA;">
						<td width="auto"><?php echo $nalunfen;?></td>
						<td width="100">姓名</td>
						<td width="30">序号</td>
						<td width="30">序号</td>
						<td width="100">姓名</td>
						<td width="auto"><?php echo $nalunfen;?></td>
					  </tr>
					<?php 
					//没处理的成绩默认是红胜的JS处理。$_POST[chengjis]（第一桌红方的序号，第一桌红方得分，第一桌黑方序号，第一桌黑方得分；，，
					if (!$dijilun) {
						echo '<tr><td colspan="8">未进行过编排，请先进行编排！</td></tr>';
					}else{
						if($taicis){
							$duizhen='';
							for($i=0;$i<=count($taicis)-1;$i++)
							{
							  $red=$taicis[$i][0];
							  $black=$taicis[$i][1];
							  //验证下，因为是按台号来分的，可能对到的是空号（显示保存的编排结果，非编排）为空值
							  //录入成绩后的显示和之前的显示一样处理这个
							  if (!$red) {
							  	$red['xs_xuhao']=0;
							  	$red['xs_name']='空号';
							  }
							  if (!$black) {
							  	$black['xs_xuhao']=0;
							  	$black['xs_name']='空号';
							  	$black['xs_zongfen']='0';
							  }
							  $duizhen.=$red['xs_xuhao'].','.$black['xs_xuhao'];
							  if($i!=count($taicis)){ $duizhen.=','; }
					 ?>
							  <tr class="hangtr  <?php echo $i%2?' dantr':'';?>">
							    <td class="taihao">[<?php echo $i+1;?>]</td>
							    <td class="zongfen" title="先后手列表：<?php echo $red['xs_xianhous'];?>"><?php echo $red['xs_zongfen'];?></td>
								<td title="对手列表：<?php echo $red['xs_towhos'];?>"><a href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $red['xs_xuhao'];?>"><?php echo $red['xs_name'];?></a></td>
								<td class="xuhao" title="单位：<?php echo $red['xs_danwei'];?>"><?php echo $red['xs_xuhao'];?></td>
								<td>
					<?php			if($fenshulun==$dijilun){
										//如果本轮已经录入并保存了成绩，则显示成绩表
										$linshi=split(',',$red['xs_fenshus']);
										$red_fenshu=$linshi[count($linshi)-2];
										$linshi=split(',',$black['xs_fenshus']);
										$black_fenshu=$linshi[count($linshi)-2];
										//echo '<p align="center">'.$red_fenshu.'&nbsp;:&nbsp;'.$black_fenshu.'</p>';
										echo $red_fenshu.'&nbsp;:&nbsp;'.$black_fenshu;
									}else{
					?>
									   <select name="jieguo[]">
										  <option value="6" selected="selected">-未选择-</option>
										  <option value="0">红 胜 黑</option>
										  <option value="1">红 和 黑</option>
										  <option value="2">红 负 黑</option>
										  <option value="3">红方弃权</option>
										  <option value="4">黑方弃权</option>
										  <option value="5">双方弃权</option>
									   </select>
				   <?php			 } ?>
								</td>
								<td class="xuhao" title="单位：<?php echo $black['xs_danwei'];?>"><?php echo $black['xs_xuhao'];?></td>
								<td title="对手列表：<?php echo $black['xs_towhos'];?>"><a href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $black['xs_xuhao'];?>"><?php echo $black['xs_name'];?></a></td>
								<td class="zongfen" title="先后手列表：<?php echo $black['xs_xianhous'];?>"><?php echo $black['xs_zongfen'];?></td>
							  </tr>
				   <?php
							}
						}	
					}
					?>
					</table>
		</td>
	  </tr><!--编排结果显示区域-->
	  
	  <tr>
		 <td height="2" colspan="3"></td>
	  </tr>
	  <tr>	<!--尾部信息-->
		<td width="auto" colspan="3">
			<table width="100%" border="0">
				<tr>
					<td width="auto">
						<div align="left" >
						   裁判长：<?php echo $bsinfo['bs_caipanzhang'];?>&nbsp;&nbsp;&nbsp;&nbsp;
						   编排人员：<?php echo $bsinfo['bs_bianpaiyuan'];?>
					   </div>
					</td>
					<td width="auto">
						<div align="right">
					      比赛地点：<input type="text" value="<?php echo $bsinfo['bs_didian'];?>" size="auto"/>
					   </div>
			   		</td>
				</tr>
			</table>
		</td>
	  </tr>  <!--尾部信息-->
	   <tr>  <!--按钮区域-->
		<td colspan="3">
			<input type="hidden" name="lunci" value="<?php echo $dijilun;?>" />
		   	<input type="hidden" name="duizhen" value="<?php echo $duizhen;?>" />
		   	&nbsp;&nbsp;
		   	<?php
//		   	if ($dijilun==$jushu) {  //本轮的编排结果已经保存了的  //错误！
		   	if ($fenshulun==$dijilun) {  //本轮的编排结果已经保存了的
		   	   echo '<input title="撤销本轮成绩，撤销后无法恢复，但可以重新登入本轮成绩和保存新的成绩" type="button" 
			         value="撤销本轮成绩" onClick="javascript:
			         if(confirm(\'是否撤销本轮（第'.$dijilun.'轮）的成绩？\')){url=\'cxhf.php?bsid='.$_GET['bsid'].'&action=huifudao&chengji=0&zonglunshu='.$dijilun.'\';location.href=url}">
				     &nbsp;&nbsp;';
		    } else {  //本轮的编排结果未保存的
			   
		    }
		    ?>
		  	<input type="submit" name="tijiao" value="提交保存成绩" <?php if($fenshulun==$dijilun){echo 'disabled="disabled"';}?> />
		    &nbsp;&nbsp;
		    <input type="button" <?php
				     if($fenshulun!=$dijilun){
				     	echo 'disabled="disabled"';
				     }
		     ?> value="转到下轮编排" onclick="javascript:location.href='bianpai.php?bsid=<?php 
		        echo $_GET['bsid'];
		     ?>'">
		  <?php  //echo '<br>',$duizhen;?></td>
	  </tr>  <!--按钮区域-->
  	  <tr>
		<td colspan="3" height="5"></td>
	  </tr>
	</table>
 </form>
  <?php 
		 if ($qituis) {//如果有退赛的或符合连弃条件的（考虑时）才进行输出显示
		 	$qituicontent=' 》弃权或考虑连弃后符合连弃条件的选手列表：<br>
		 	                <table style="margin:0px auto; width:600px;" border="1">
		 	                  <tr><th>序号</th><th>单位</th><th>姓名</th><th>对手、得分序列</th><th>总得分</th></tr>';
		 	foreach ($qituis as $key => $value) {
		 	  $qituicontent.='<tr><td>('.$value['xs_xuhao'].')</td>
		        <td>'.$value['xs_danwei'].'</td>
		        <td><a href="" title="台号序列：'.$value['xs_taihaos'].'">'.$value['xs_name'].'</a></td>
		        <td><a href="" title="先后手序列：'.$value['xs_xianhous'].'">
		        对手序列：'.$value['xs_towhos'].'
		        <hr>
		        得分序列：'.$value['xs_fenshus'].'
		        </a></td>
		        <td title="弃权情况：'.$value['xs_lianqis'].'">'.$value['xs_zongfen'].'</td></tr>';
		 	}
		 	$qituicontent.='</table>';
		 	echo $qituicontent;
		 }
		?>		
 <?php
     $qiquanhaos=array();
     //本次弃权的会在lianqis中的最后一个是-号；
     if($xuanshous[0]){	//如果没有指定赛事ID则选手为空
	     foreach ($xuanshous as $key => $value) {
	     	$linshi=str_split(trim($value['xs_lianqis']),1);
	//     	$linshi=explode(',,',trim($value['xs_lianqis'],','));
	     	if ($linshi[$dijilun-1]=='-') {
	     		$qiquanhaos[]=$value;
	     	}
	     }
		 if ($qiquanhaos) {//如果有弃权的，显示本次弃权的选手号
		 	$qihaocontent=' 》本次弃权的选手号：<br>
	     	                <table width="600px" border="0" align="center">
	     	                 <tr><td>';
	     	foreach ($qiquanhaos as $key => $value) {
	     		$qihaocontent.='（'.$value['xs_xuhao'].'）<a title="本轮对手序号：'.strrchr(rtrim($value['xs_towhos'],','),',').'">（'.$value['xs_name'].'）</a>、';
	        }
	     	$qihaocontent.='</td></tr></table>';
	     	echo $qihaocontent;
		 }
     }
 ?>

 