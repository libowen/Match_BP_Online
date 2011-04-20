<!--修改编排结果的显示界面-->
<style type="text/css">
<!--
#bp_form table {
	border-color:#CCCCCC;
}
/* 编排结果对阵表的宽度 */
.Lbianpai {
	width:660px;
}

/* 整体的字体和内距地控制显示 */
.xiugaibp { width:100%; }
.xiugaibp td,.xiugaibp th{  padding:5px 0px; 	font-size:14px; 	text-align:center; }
.xiugaibp a { font-size:14px; }

/* 行的显示效果  */
.hangtr td { /* border-bottom:medium double #999999; */ }
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
.zongfen {
	color:red;
	font-weight:bold;
	cursor: hand;
	cursor: pointer;
}
.zongfen:hover { background-color: #0000FF;  color:#FFFFFF; }
#wancheng { font-weight:bold; }

.left {
	text-algin:left;
}
.right {
	text-align:right;
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
			<?php
	  			if (1) {
	  				$linshi=$_GET['lunci']&&$_GET['lunci']>0?$_GET['lunci']:$dijilun;
	  				echo '<a style="color:blue;text-decoration:underline;font-size:14px;" href="?bsid='.$_GET['bsid'].'&lunci='.($linshi-1).'">上轮</a>&nbsp;';
	  			}
	  		?>
			&nbsp; 第 <?php echo $_GET['lunci']?$_GET['lunci']:($fenshulun+1); //$dijilun;?> 轮&nbsp;
	  		<?php
	  			if ($_GET['lunci']&&$_GET['lunci']<$dijilun) {
	  				echo '&nbsp;<a style="color:blue;text-decoration:underline;font-size:14px;" href="?bsid='.$_GET['bsid'].'&lunci='.(1+$_GET['lunci']).'">下轮</a>';
	  			}
  			?>		      
		</td>
	  </tr>
	  <tr>
		<td height="2" colspan="3"></td>
	  </tr>
	  <tr><!--编排结果显示区域-->
		<td colspan="3">
               <table class="xiugaibp" border="1" align="center">
				  <tr style="background-color:#AAAAAA;">
					<th width="26" rowspan="2" scope="col">台<br>
					次</th>
					<th colspan="6" scope="col">红方</th>
					<th width="12px" rowspan="2" scope="col">&nbsp;</th>
					<th colspan="6" scope="col">黑方</th>
				  </tr>
				  <tr style="background-color:#AAAAAA;">
				    <!--
					<td width="auto">先后</td>
					<td width="auto">积分</td>
					<td width="110">姓名</td>
					<td width="30">序号</td>
					-->
					<td width="auto">单位</td>
					<td width="auto">姓名</td>
					<td width="32">序号</td>
					<td width="38">上下<br>调差</td>
					<td width="38">上轮<br>先后</td>
					<td width="auto">上轮<br>积分</td>
					
					<td width="auto">上轮<br>积分</td>
					<td width="38">上轮<br>先后</td>
					<td width="38">上下<br>调差</td>
				  	<td width="30">序号</td>
					<td width="auto">姓名</td>
					<td width="auto">单位</td>
					<!--
					<td width="30">序号</td>
					<td width="110">姓名</td>
					<td width="auto">积分</td>
					<td width="auto">先后</td>
					-->
				  </tr>
				<?php 
					if ($taicis) {
						for($i=0;$i<count($taicis);$i++) {
						  if ($dijilun==$fenshulun+1||$_GET['lunci']) {	///如果是已经保存了本轮编排结果的，先去除一轮的结果再输出
						  		if ($_GET['lunci']) {
						  			$lunci=$_GET['lunci']-1;
						  		} else {
						  			$lunci=$fenshulun;
						  		}
						  		//主要是zongfen、towhos、xianhous、shangxias、fenshus、taihaos、lianqis、
						  		$red['xs_zongfen']='&nbsp;';
							  	$red['xs_xianhous']='&nbsp;';
							  	$red['xs_xianhous']='&nbsp;';
							  	for ($k=0;$k<2;$k++) {  //取fenshulun轮次的数据
							  			$linshi=explode(",,",trim($taicis[$i][$k]['xs_fenshus'],','));
							  		$taicis[$i][$k]['xs_zongfen']=array_sum(array_slice($linshi,0,$lunci));
							  		  $taicis[$i][$k]['xs_fenshus']=implode(',,',array_slice($linshi,0,$lunci));
							  		$taicis[$i][$k]['xs_fenshus']=$taicis[$i][$k]['xs_fenshus']?','.$taicis[$i][$k]['xs_fenshus'].',':'';
							  			$linshi=explode(",,",trim($taicis[$i][$k]['xs_towhos'],','));
							  		  $taicis[$i][$k]['xs_towhos']=implode(',,',array_slice($linshi,0,$lunci));
							  		$taicis[$i][$k]['xs_towhos']=$taicis[$i][$k]['xs_towhos']?','.$taicis[$i][$k]['xs_towhos'].',':'';
							  			
							  			$linshi=str_split(trim($taicis[$i][$k]['xs_xianhous']),1);
							  		$taicis[$i][$k]['xs_xianhous']=implode('',array_slice($linshi,0,$lunci));
							  			$linshi=str_split(trim($taicis[$i][$k]['xs_shangxias']),1);
							  		$taicis[$i][$k]['xs_shangxias']=implode('',array_slice($linshi,0,$lunci));
							  	}
						  }
						  $taihao=$i+1;
						  $red=$taicis[$i][0];
						  $black=$taicis[$i][1];
						  //验证下，因为是按台号来分的，可能对到的是空号（显示保存的编排结果，非编排）为空值
						  if (!$red) {
							  	$red['xs_xuhao']=0;
							  	$red['xs_name']='空号';
							  	$red['xs_zongfen']='&nbsp;';
							  	$red['xs_xianhous']='&nbsp;';
						  }
						  if (!$black) {
							  	$black['xs_xuhao']=0;
							  	$black['xs_name']='空号';
							  	$black['xs_zongfen']='&nbsp;';
							  	$black['xs_xianshous']='&nbsp;';
						  }
				 ?>
						  <tr class="hangtr  <?php echo $i%2?' dantr':'';?>">
							<td id="XS<?php echo $taihao;?>" onclick="huanpeidui(this)" class="taihao">[<?php echo $taihao;?>]</td>
							
							<td id="XS<?php echo $taihao;?>=1=3" class="danwei"><?php echo $red['xs_danwei'];?></td>
							<td id="XS<?php echo $taihao;?>=1=2">
								<a title="单位：<?php echo $red['xs_danwei'],' 上轮对手列表：',$red['xs_towhos'];?>" 
								   href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $red['xs_xuhao'];?>">
									     <?php echo $red['xs_name'];?>
								</a>
							</td>
							<td id="XS<?php echo $taihao;?>=1=1" onclick="huanpeidui(this)" class="xuhao">
								<span title="<?php  echo '姓名：',$red['xs_name'],'   单位：',$red['xs_danwei'],'  上轮对手列表：',$red['xs_towhos'];?>" >
									<?php echo $red['xs_xuhao'];?>
								</span>
							</td>
							
							<td class="shangxiatiao" id="XS<?php echo $taihao;?>=1=6">
								<span title="上轮上下调列表：<?php echo $red['xs_shangxias'];?>"><?php
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
								?></span>
							</td>
							<td id="XS<?php echo $taihao;?>=1=5">
								<span title="上轮先后手列表：<?php echo $red['xs_xianhous'];?>"><?php
										//echo $red['xs_xianhous'];
										$duoxian=substr_count($red['xs_xianhous'],'+')-substr_count($red['xs_xianhous'],'-');
										if ($duoxian>0) {
											echo '+',$duoxian;
										} elseif ($duoxian<0) {
											echo $duoxian;
										} else {
											echo '&nbsp;&nbsp;';
										}
								?></span>
							</td>
							<td id="XS<?php echo $taihao;?>=1=4" class="zongfen" onclick="huanpeidui(this)" ><span title="<?php  echo '姓名：',$red['xs_name'],'   单位：',$red['xs_danwei'],'  上轮对手列表：',$red['xs_towhos'];?>" ><?php 
								echo $red['xs_zongfen'];?></span></td>
							
							<td width="auto">
				                 &nbsp;
							</td>
							
							<td id="XS<?php echo $taihao;?>=2=4" class="zongfen" onclick="huanpeidui(this)" ><span title="<?php echo '姓名：',$black['xs_name'],'   单位：',$black['xs_danwei'],'  上轮对手列表：',$black['xs_towhos'];?>"><?php 
								echo $black['xs_zongfen'];?></span></td>
							<td id="XS<?php echo $taihao;?>=2=5" >
								 <span title="上轮先后手序列：<?php echo $black['xs_xianhous'];?>"><?php
									//echo $black['xs_xianhous'];
									$duoxian=substr_count($black['xs_xianhous'],'+')-substr_count($black['xs_xianhous'],'-');
									if ($duoxian>0) {
										echo '+',$duoxian;
									} elseif ($duoxian<0) {
										echo $duoxian;
									} else {
										echo '&nbsp;&nbsp;';
									}
								?></span>
							 </td>
							 <td class="shangxiatiao" id="XS<?php echo $taihao;?>=2=6" >
									 <span title="上轮上下调列表：<?php echo $black['xs_shangxias'];?>"><?php
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
									?></span>
							</td>
							
							<td id="XS<?php echo $taihao;?>=2=1" onclick="huanpeidui(this)" class="xuhao">
								<span title="<?php echo '姓名：',$black['xs_name'],'   单位：',$black['xs_danwei'],'  上轮对手列表：',$black['xs_towhos'];?>">
									<?php echo $black['xs_xuhao'];?>
								</span>
							</td>
							<td id="XS<?php echo $taihao;?>=2=2" >
								 <a title="单位：<?php echo $black['xs_danwei'],'  上轮对手列表：',$black['xs_towhos'];?>"
								    href="xuanshou.php?bsid=<?php echo $_GET['bsid'];?>&xsxuhao=<?php echo $black['xs_xuhao'];?>">
								 		<?php echo $black['xs_name'];?>
								 </a>
							 </td>
							<td id="XS<?php echo $taihao;?>=2=3" class="danwei"><?php echo $black['xs_danwei'];?></td>
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
					<td width="auto">
					      比赛地点：<?php echo $bsinfo['bs_didian'];?>
			   		</td>
				</tr>
			</table>
		</td>
	  </tr>
 	   <tr><!--提交按钮-->
		 <td colspan="3">
		    <br />
		    <input type="hidden" name="lunci" value="<?php echo $_GET['dijilun']?$_GET['dijilun']:($_GET['lunci']?$_GET['lunci']:$dijilun);	//$dijilun对应的是最多towhos的！因为编排的保存特殊，必须dijilun才行，对应其相关判断！
		    ?>" />
		   	<input type="hidden" name="duizhen" value="<?php echo $_POST['duizhen'];?>" />
		   	<input type="hidden" name="action" value="xiugaibp" />
		   	&nbsp;&nbsp;
		    <?php
		    if ($dijilun==$fenshulun) {  //本轮的编排结果未保存的
		    } else {  //本轮的编排结果已经保存了的
			   echo '<input title="3：黑体无线模式；2：黑体有线模式；1：宋体有线模式" type="button" 
				     value="打印对阵表" onClick="javascript:url=\'/bp/zhibiao/bpjilu.php?bsid='.$_GET['bsid'].'&moshi=\';url=url.concat(document.getElementById(\'pdbmoshi\').value);window.open(url)"><input id="pdbmoshi" type="text" size="1" value="2"/>
				     &nbsp;&nbsp;
				    <input title="1：横式记分单；2：节约模式" type="button"
				     value="打印记分单" onClick="javascript:url=\'/bp/zhibiao/jifendan.php?bsid='.$_GET['bsid'].'&moshi=\';url=url.concat(document.getElementById(\'jfdmoshi\').value);window.open(url)"><input id="jfdmoshi" type="text" size="1" value="1"/>
				     ';
		    }
		    ?>
		    &nbsp;&nbsp;
		     <input id="wancheng" type="button" value="修改完成"  onclick="wancheng_xiugaibp(this)"/>
		     &nbsp;&nbsp;
			 <input id="tijiao" type="submit" name="tijiao" value="提交保存" disabled="disabled"/>
		     &nbsp;&nbsp;
		     <input type="button" <?php
		     echo ($dijilun==$fenshulun)?'disabled="disabled"':'';
		     ?> value="录入成绩" onClick="javascript:location.href='dengfen.php?bsid=<?php echo $_GET['bsid'];?>'">
			
		 </td>
	  </tr><!--提交按钮-->
	  <tr> 
	    <td colspan="3" style="font-size:14px">
	       <br />
	      <?php echo $message;//目前是修改编排保存数据的对阵中有多次相遇或要求同队不遇同队相遇的信息?>
		  <?php if ($_GET['lunci']) {
		  			echo '<br>';
		        } elseif ($dijilun==$fenshulun) {
					echo '本轮的编排结果未保存到库中。修改后，请及时保存数据。';
				}else{
					echo '本轮已保存编排结果，修改后直接保存即可覆盖本轮的编排结果。保存后不可恢复，请仔细操作。';
				}?>
	     </td>
	  </tr>
	  <tr>
		<td colspan="3" height="5"></td>
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
<script type="text/javascript">
//
var TAIzt=0;  //交换选手位置时，取1 放0 的状态
var TAIlastdom; //上次获取的
var XUzt=0;  //交换选手位置时，取1 放0 的状态
var XUlastdom; //上次获取的
function huanpeidui (thisdom) {
	xiugaile=0;
	//交换位置
	if (thisdom.className=='taihao') {  //交换行的位置，即台号，应该台号不变，行上的其他数据交换
		//判断是取还是放
		if (TAIzt) {  //已经获取 的状态；可以进行放的动作
//			TAIlastdom.style.border='';
			TAIlastdom.style.backgroundColor="";  //#FFFF99
			TAIlastdom.parentNode.style.backgroundColor="";  //#FFFF99
//			TAIlastdom.parentNode.style.border='';
			
			TAIlastid=TAIlastdom.getAttribute('id');
			thisid=thisdom.getAttribute('id');
			ids=new Array('=1=6','=1=5','=1=4','=1=3','=1=2','=1=1','=2=1','=2=2','=2=3','=2=4','=2=5','=2=6');
			for (key in ids) {
				zhongjie=document.getElementById(thisid.concat(ids[key])).innerHTML;//由于innerHTML，所以会以外多处空格和换行符
				document.getElementById(thisid.concat(ids[key])).innerHTML=document.getElementById(TAIlastid.concat(ids[key])).innerHTML;
				document.getElementById(TAIlastid.concat(ids[key])).innerHTML=zhongjie;
			}
			TAIzt=0;
			xiugaile=1;
			TAIlastdom='';
		} else {   //已经放下 的状态；可以进行取的动作
//			thisdom.style.border='#FF0000 groove 3px';
			thisdom.style.backgroundColor="red";  //#FFFF99
			thisdom.parentNode.style.backgroundColor="#CCFFFF";  //#FFFF99
//			thisdom.parentNode.style.border='#FF0000 groove 3px';
			
			TAIlastdom=thisdom;
			TAIzt=1;
		}
	} else if (thisdom.className=='xuhao'||thisdom.className=='zongfen') {
		//判断是取还是放
		if (XUzt) {  //已经获取 的状态；可以进行放的动作
//			XUlastdom.style.border='';
//			XUlastdom.parentNode.style.backgroundColor="";  //#FFFF99
			XUlastdom.style.backgroundColor="";
			XUlastdom.style.color="";			

			XUlastid=XUlastdom.getAttribute('id').split('=');
			XUlastid=XUlastid[0].concat('=').concat(XUlastid[1]);
			
			thisid=thisdom.getAttribute('id').split('=');
			thisid=thisid[0].concat('=').concat(thisid[1]);
			ids=new Array('=6','=5','=4','=3','=2','=1');
			for (key in ids) {
				zhongjie=document.getElementById(thisid.concat(ids[key])).innerHTML;//由于innerHTML，所以会以外多处空格和换行符
				document.getElementById(thisid.concat(ids[key])).innerHTML=document.getElementById(XUlastid.concat(ids[key])).innerHTML;
				document.getElementById(XUlastid.concat(ids[key])).innerHTML=zhongjie;
			}
			if (XUlastid!=thisid) {
				//换过的选手的姓名变随即颜色，但交换的两个一定同色
				se1=Math.round(Math.random()*140+100);	se2=Math.round(Math.random()*195+60);	se3=Math.round(Math.random()*110+140);
	//			thisdom.style.color="rgb(se1, se2, se3)";
				///交换过的两个姓名随机颜色相同 =2
				document.getElementById(XUlastid.concat('=2')).getElementsByTagName('a')[0].style.backgroundColor='rgb('+se1+','+se2+','+se3+')';
				document.getElementById(thisid.concat('=2')).getElementsByTagName('a')[0].style.backgroundColor='rgb('+se1+','+se2+','+se3+')';
//alert(document.getElementById(XUlastid.concat('=2')).getElementsByTagName('a')[0].innerHTML);
//document.getElementById(XUlastid.concat('=2')).getElementsByTagName('a')[0].style.backgroundColor='red';
			}
//			XUlastdom.style.color="rgb(se1, se2, se3)";		

///交换后，单位相同的一台背景颜色变（以后再考虑实现）
//thisdom.parentNode.style.backgroundColor="#DFDFDF";

			XUzt=0;
			xiugaile=1;
			XUlastdom='';
		} else {   //已经放下 的状态；可以进行取的动作
//			thisdom.style.border='#FF0000 groove 3px';
//			thisdom.parentNode.style.backgroundColor="#CCFFFF";  //#FFFF99
			thisdom.style.backgroundColor="red";
			thisdom.style.color="white";
//alert(thisdom.style.color);
			XUlastdom=thisdom;
			XUzt=1;
		}
	}
	if (xiugaile) {  //数据修改了，点一次还没修改，要真正的修改才执行
		document.getElementById('wancheng').style.color='';
		document.getElementsByName('tijiao')[0].disabled='disabled';
		document.getElementById('wancheng').disabled=false;
		document.getElementsByName('tijiao')[0].style.fontWeight='';
	}
}

//获取新的编排结果，并写入到duizhen中（以英文逗号分隔）
function wancheng_xiugaibp(thisdom) {
	thisdom.style.color='#CCCCCC';
	thisdom.disabled='disabled';
	document.getElementsByName('tijiao')[0].style.fontWeight='bold';
	document.getElementsByName('tijiao')[0].disabled=false;
	duizhendom=document.getElementsByName('duizhen')[0];
	duizhens = new Array();
	i=1;
	k=0;
	while (document.getElementById('XS'.concat(i))){
		duizhens[k] = document.getElementById('XS'.concat(i).concat('=1=1')).getElementsByTagName('span')[0].innerHTML;
		k++;
		duizhens[k] = document.getElementById('XS'.concat(i).concat('=2=1')).getElementsByTagName('span')[0].innerHTML;
		k++;
		i++;
		//由于innerHTML，所以会以外多处空格和换行符
	}
//alert(document.getElementById('XS1=1=1').innerHTML);
//alert(document.getElementById('XS1=1=1').getElementsByTagName('span')[0].innerHTML);
	for(key in duizhens) {
		duizhens[key] = Number(duizhens[key]);//因为对阵的都是序号，所以可以先转换成数字来去除空格、换行符
	}
	duizhendom.value=duizhens.join(',');    //不知是否可行？？！！linshi为空时一定不行！
//	alert(duizhendom.value);
	thisdom.disabled='disabled';
}
</script>
