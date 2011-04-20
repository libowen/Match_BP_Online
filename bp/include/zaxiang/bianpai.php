<!--编排显示的界面-->
<style type="text/css">
<!--
#bp_form th {
	padding: 3px 0px; 
}

#bp_form table {
	border-color:#CCCCCC;
}
/* 编排结果对阵表的宽度 */
.Lbianpai {
	width:660px;
}

/* 行的显示效果  */
.hangtr td {
	/* border-bottom:3px double #999999;  */
	padding:5px 0px; 
}
.hangtr:hover { background-color:#ffff99; }



/* 台号的显示样式 */
.taihao {  font-weight:bold;}
.taihao:hover { background-color:#660099; 	color:#FFFFFF; }

/* 序号的显示样式 */
.xuhao {
	color:blue;
	font-weight: bold;
}
.xuhao:hover { background-color: #0000FF;  color:#FFFFFF; }

/* 总分的显示样式 */
.zongfen { color:red; 	font-weight:bold; }

.right {
	text-align:right;
}
.left {
	text-align:left;
}
-->
</style>

<form id="bp_form" name="bp_form" method="post" action="">
	<table border="0" align="center" width="660px">
	  <tr>
		<td height="6" colspan="3"></td>
	  </tr>
	  <tr>
		<td width="34%" class="left">
		      组别：<?php echo $bsinfo['bs_zubie'];?>
		</td >
		<td width="33%">分制：[<?php echo $bsinfo['bs_jufenmoshi'];?>]</td>
		<td width="33%" class="right">
				第 <?php $jushu=substr_count($taicis[0][0]['xs_towhos'],',')/2; 
		       			//如果上下相等，说明已经本轮保存过编排结束了；$dijilun==$jushu+1说明没有保存本轮的编排结果！
		       			echo $dijilun;	
		       			//echo $jushu;
		       ?> 轮
		</td>
	  </tr>
	  <tr>
		<td height="2" colspan="3"></td>
	  </tr>
	  <tr><!--编排结果显示区域-->
		<td colspan="3">
               <table class="Lbianpai" border="1" align="center">
				  <tr style="background-color:#AAAAAA;">
					<th width="26" rowspan="2" scope="col">台<br>
					次</th>
					<th colspan="6" scope="col">红方</th>
					<th width="12px" rowspan="2" scope="col">&nbsp;</th>
					<th colspan="6" scope="col">黑方</th>
				  </tr>
				  <tr style="background-color:#AAAAAA;">
					<td width="30">序号</td>
					<td width="auto">姓名</td>
					<td width="auto">单位</td>
					<td width="38">上下<br>调差</td>
					<td width="38"><?php echo $dijilun==$jushu?'最新':'当前';?><br>先后</td>
					<td width="auto">上轮<br>积分</td>
					<td width="auto">上轮<br>积分</td>
					<td width="38"><?php echo $dijilun==$jushu?'最新':'当前';?><br>先后</td>
					<td width="38">上下<br>调差</td>
					<td width="auto">单位</td>
					<td width="auto">姓名</td>
					<td width="32">序号</td>
				  </tr>
				<?php 
					if($taicis){
						$duizhen='';
						for($i=0;$i<count($taicis);$i++) {
						  $red=$taicis[$i][0];
						  $black=$taicis[$i][1];
						  //验证下，因为是按台号来分的，可能对到的是空号（显示保存的编排结果，非编排）为空值
						  if (!$red) {
						  	$red['xs_xuhao']=0;
						  	$red['xs_name']='空号';
						  }
						  if (!$black) {
						  	$black['xs_xuhao']=0;
						  	$black['xs_name']='空号';
						  }
						  if ($red['xs_danwei']==$black['xs_danwei']) {	///单位相同的提示下						  	
						  	 $red['xs_danwei']='<span style="background-color:#DDDDDD">'.$red['xs_danwei'].'</span>';	
						  	 $black['xs_danwei']='<span style="background-color:#DDDDDD">'.$black['xs_danwei'].'</span>';	
						  }				  
						  $duizhen.=$red['xs_xuhao'].','.$black['xs_xuhao'];
						  if($i<count($taicis)-1){ $duizhen.=','; }
				 ?>
						  <tr class="hangtr  <?php echo $i%2?' dantr':'';?>">
							<td class="taihao">[<?php echo $i+1;?>]</td>
							<td class="xuhao"><?php echo $red['xs_xuhao'];?></td>
							<td title="<?php echo $dijilun==$jushu?'最新':'当前';?>对手列表：<?php echo $red['xs_towhos'];?>"><a href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $red['xs_xuhao'];?>"><?php echo $red['xs_name'];?></a></td>
							<td class="danwei"><a  ><?php echo $red['xs_danwei'];?></a></td>
							<td title="<?php echo $dijilun==$jushu?'最新上下调列表：':'当前上下调列表：'; echo $red['xs_shangxias'];?>" ><?php
							$shang=substr_count($red['xs_shangxias'],'A');
							$xia=substr_count($red['xs_shangxias'],'V');
							$linshi=$shang-$xia;
								if ($linshi) {
									if ($linshi>0) {
										echo '↑',$linshi;
									} else {
										echo '↓',abs($linshi);
									}
								} else {
									if ($shang) {	//上下调过后又平衡的
										echo '==';
									}else {
										echo '&nbsp;&nbsp;';
									}
								}
							?></td>
							<td title="<?php echo '先后手序列：',$red['xs_xianhous'];?>"><?php
							//echo $red['xs_xianhous'];
							$duoxian=substr_count($red['xs_xianhous'],'+')-substr_count($red['xs_xianhous'],'-');
							if ($duoxian>0) {
								echo '+',$duoxian;
							} elseif ($duoxian<0) {
								echo $duoxian;
							}
							?></td>
							<td class="zongfen" title="<?php echo '序号：[',$red['xs_xuhao'],']  姓名：',$red['xs_name']; echo $dijilun==$jushu?'  最新对手列表：':'  当前对手列表：'; echo $red['xs_towhos'];?>" ><?php echo $red['xs_zongfen'];?></td>
							<td>
				                 &nbsp;
							</td>
							<td class="zongfen" title="<?php echo '序号：[',$black['xs_xuhao'],']  姓名：',$black['xs_name']; echo $dijilun==$jushu?'  最新对手列表：':'  当前对手列表：'; echo $black['xs_towhos'];?>" ><?php
							 echo $black['xs_zongfen'];
							 ?></td>
							<td title="<?php echo '先后手序列：',$black['xs_xianhous'];?>"><?php
							//echo $black['xs_xianhous'];
							$duoxian=substr_count($black['xs_xianhous'],'+')-substr_count($black['xs_xianhous'],'-');
							if ($duoxian>0) {
								echo '+',$duoxian;
							} elseif ($duoxian<0) {
								echo $duoxian;
							}
							?></td>
							<td title="<?php echo $dijilun==$jushu?'最新上下调列表：':'当前上下调列表：'; echo $black['xs_shangxias'];?>" ><?php
								$shang=substr_count($black['xs_shangxias'],'A');
								$xia=substr_count($black['xs_shangxias'],'V');
								$linshi=$shang-$xia;
								if ($linshi) {
									if ($linshi>0) {
										echo '↑',$linshi;
									} else {
										echo '↓',abs($linshi);
									}
								} else {
									if ($shang) {	//上下调过后又平衡的
										echo '==';
									}else {
										echo '&nbsp;&nbsp;';
									}
								}
							?></td>
							<td class="danwei"><a   ><?php echo $black['xs_danwei'];?></a></td>
							<td title="<?php echo $dijilun==$jushu?'最新':'当前';?>对手列表：<?php echo $black['xs_towhos'];?>"><a href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $black['xs_xuhao'];?>"><?php echo $black['xs_name'];?></a></td>
							<td class="xuhao"><?php echo $black['xs_xuhao'];?></td>
						  </tr>
			   <?php
						}	
				     }
				?>
				</table>		
		</td>
	  </tr><!--编排结果显示区域-->
	  
	  <tr>
		 <td height="2" colspan="3"></td>
	  </tr>
	  <tr>
		<td width="auto" colspan="3">
			<table width="100%" border="0">
				<tr>
					<td width="auto" class="left">
						   裁判长：<?php echo $bsinfo['bs_caipanzhang'];?>&nbsp;&nbsp;&nbsp;&nbsp;
						   编排人员：<?php echo $bsinfo['bs_bianpaiyuan'];?>
					</td>
					<td width="auto" class="right">
					      比赛地点：<?php echo $bsinfo['bs_didian']?$bsinfo['bs_didian']:'管理员没有设置';?>
			   		</td>
				</tr>
			</table>
		</td>
	  </tr>
 	   <tr><!--提交按钮-->
		 <td colspan="3">
		    <br />
		    <input type="button" value="修改编排" title="跳转到修改编排页面，可修改本轮的编排结果" onclick="javascript:BPform=document.getElementById('bp_form');BPform.setAttribute('action','xiugaibp.php?bsid=<?php echo $_GET['bsid'];?>');BPform.submit()"/>
		    
		    <input type="hidden" name="lunci" value="<?php echo $dijilun;	//这个应该以最多fenshus的分割个数+1；即正在进行的轮次
		    ?>" />
		   	<input type="hidden" name="duizhen" value="<?php echo $duizhen;?>" />
		   	&nbsp;&nbsp;<?php
		    if ($dijilun==$jushu+1) {  //本轮的编排结果未保存的
		    	if ($dijilun<2) {
		    		
		    	}
		       echo '<input type="button" onclick="tiaoshi(this,'.$_GET['bsid'].','.$dijilun.')" value="调试" title="全程调试，一次点击，自动完成全部轮次的编排和成绩随机录入，并打印各个轮次的对阵表盒个人成绩表、团体成绩表等" style="color:red"/>&nbsp;&nbsp;&nbsp;';
		       echo '<script language="javascript" type="text/javascript" src="/bp/js/ajax.js"></script>';
		       echo '<input type="submit" name="tijiao" value="保存编排结果" />';
		    } else {  //本轮的编排结果已经保存了的
			   echo '<input title="重新编排，即撤销本轮保存的编排结果，撤销后无法恢复，但可以重新编排本轮和保存新的编排结果" type="button" 
			         value="撤销保存" onClick="javascript:
			         if(confirm(\'是否撤销本轮（第'.$dijilun.'轮）的编排结果？\')){url=\'cxhf.php?bsid='.$_GET['bsid'].'&action=huifudao&zonglunshu='.($dijilun-1).'\';location.href=url}">
				    &nbsp;&nbsp;
				    <input title="3：黑体无线模式；2：黑体有线模式；1：宋体有线模式" type="button" 
				     value="打印对阵表" onClick="javascript:url=\'/bp/zhibiao/bpjilu.php?bsid='.$_GET['bsid'].'&moshi=\';url=url.concat(document.getElementById(\'pdbmoshi\').value);window.open(url)"><input id="pdbmoshi" type="text" size="1" value="2"/>
				     &nbsp;&nbsp;
				    <input title="1：横式记分单；2：节约模式" type="button"
				     value="打印记分单" onClick="javascript:url=\'/bp/zhibiao/jifendan.php?bsid='.$_GET['bsid'].'&moshi=\';url=url.concat(document.getElementById(\'jfdmoshi\').value);window.open(url)"><input id="jfdmoshi" type="text" size="1" value="1"/>
				     ';
		    }
		    ?>
		     &nbsp;&nbsp;
		     <input type="button" <?php
		     echo ($dijilun==$jushu+1)?'disabled="disabled"':'';
		     ?> value="录入成绩" onClick="javascript:location.href='dengfen.php?bsid=<?php echo $_GET['bsid'];?>'">
		    <?php //echo $duizhen;?>
		 </td>
	  </tr><!--提交按钮-->
	  <tr> 
	    <td colspan="3" style="font-size:12px">
	      <br />
		  <?php if ($dijilun==$jushu+1) {
					echo '本轮系统算出的编排结果！可以保存或修改。';
				}else{
					echo '本轮已进行过编排并保存，可以登录成绩，或修改本轮已存的编排结果。';
				}?>
	     </td>
	  </tr>
	  <tr>
		<td colspan="3" height="5">
		
		</td>
	  </tr>
	  <tr>
		<td colspan="3">
		<?php 
		 if ($qituis) {//如果有退赛的或符合连弃条件的（考虑时）才进行输出显示
		 	$qituicontent=' 》弃权或考虑连弃后符合连弃条件的选手列表：<br>
		 	                <table class="Lbianpai" border="1">
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
		</td>
	  </tr>
	</table>
</form> 
