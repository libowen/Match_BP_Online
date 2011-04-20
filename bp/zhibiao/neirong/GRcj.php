

<!--积分，为使积分的显示比较整齐，在0.5分制时，进行补点补零！积分、总分、对手分、累进分
.towho 和.jifen 针对性样式控制；

 -->

<style type="text/css">
<!--

/*个人成绩表的界面 GRcj*/
.biaoti{
	font-family:"黑体";
	font-size:26px;
    
}
/* 打印纸的打印区域宽度 */
.content {
	width:257mm;
}
/* 重置表格的边线颜色 */
.content table,.content table tr,.content table td {
	border-color:#CCCCCC;
}
.content table td:hover {
	background-color:gold; 
}
a,td,th,input,select{
	font-size: 16px;
	text-align: center;
}

a {
	text-decoration:none;
	cursor:pointer;
	cursor:hand;
}
.hang td {
	padding-top:4px;
	padding-bottom:3px;
}
.xianshou {
width:26px;
font-family:"黑体";
font-weight:bold;
text-align:right;
/* background-color:#ffff99; */
}
.houshou {
width:26px;
font-family:"宋体";
text-align:right;
/* background-color:#CCCCCC; */
}
.jifen {
width:26px;
text-align:right;
	color:red;
}
.xuhao {
text-align:right;
}

.dsjfbiaoti {
   font-size:smaller;/* 每轮的对手和积分的标题 */
}

.hang:hover {
	background-color:#ffff99;
}
    .zongfen {
	width:30px;
	display:"";
	}
	.duishoufen {
	width:30px;
	display:"";
	}
	.leijinfen {
	width:30px;
	display:"";
	}
	.shengju {
	width:30px;
	display:"";
	}
	.fangui {
	width:30px;
	display:"";
	}
	.houshengju {
	width:30px;
	display:"";
	}
	.houshouju {
	width:30px;
	display:none;
	}
	.xianshengju {
	width:30px;
	display:none;
	}
	.zhisheng {
	width:30px;
	display:none;
	}
	.shengshouhe {
	width:30px;
	display:none;
	}
	.heshouhe {
	width:30px;
	display:none;
	}
	.fushouhe {
	width:30px;
	display:none;
	}

	.yicunpaiming {
	font-size:smaller;
	color:blue;
	width:30px;
	display:none;
	}
	.mingci {
	font-weight:bold;
	}
-->
</style>

<div class="H" align="center">
    <div class="A4H">
    <a name="1" id="1" class="maodian"></a>
		<table name="content" class="content" cellspacing="0" cellpadding="0">
			<tr>
			  <td colspan="2">
			  <div class="biaoti">
			    &nbsp;&nbsp;&nbsp;<?php echo $bsinfo['bs_biaoti'],'成绩表';?><span style="font-size:12px;color:#cccccc">[<?php echo $_GET['paimingmoshi'];?>]</span>
			  </div>
			  </td>
			</tr>
			<tr>
			  <td height="3px"></td>
			  <td></td>
			</tr>
			<tr>
			  <td><div class="bisaizubie" align="left" style="font-family:'黑体'">组别：<?php echo $bsinfo['bs_zubie'];?></div></td>
			  <td><div class="yemaquyu" align="right" style="font-family:'黑体'">第&nbsp;1&nbsp;页（共&nbsp;1&nbsp;页）</div></td>
			</tr>
			<tr>
			  <td><div class="bisaididian" align="left" style="font-family:'黑体'">比赛地点：<?php echo $bsinfo['bs_didian'];?></div></td>
			  <td><div class="bisaishijian" align="right" style="font-family:'黑体'">比赛时间：
			  <?php echo $bsinfo['bs_shijian']?$bsinfo['bs_shijian']:'&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;月&nbsp;&nbsp;日-&nbsp;&nbsp;月&nbsp;&nbsp;日';?>
			  </div></td>
			</tr>
			<tr>
			  <td height="10px"></td>
			  <td></td>
			</tr>
			<tr>
			   <td colspan="2">
				  <table class="shujutable" width="100%" border="1" align="center" cellspacing="0" >
					<tr>
					  <th title="按选手的序号重新排序" rowspan="2" width="26">
					  <?php echo'
					  <a href="?bsid='.$_GET['bsid'].'&paimingmoshi='.$_GET['paimingmoshi']
                         .'&&paixu=';echo $_GET['paixu']=='xhabc'?'xhcba':'xhabc';
                         echo '">序<br />号</a>
                      ';?>
					  </th>
					  <th rowspan="2" width="120">单&nbsp;&nbsp;位</th>
					  <th rowspan="2" width="120">姓&nbsp;&nbsp;名</th>
					  <?php for($i=1;$i<=$bsinfo['bs_zonglunshu'];$i++) {
					  echo '<th title="按本轮次的总分降序、小分降序、序号升序来重新排序"  colspan="2"><nobr><a  href="?bsid='.$_GET['bsid'].'&paimingmoshi='.$_GET['paimingmoshi'].'&&paixu=lunfen&&lunfenlun='.$i.'">第'.$i.'轮</a></nobr></th>';
					  }?>
					  <th rowspan="2" class="zongfen">总分</th>
					  
					<?php 
					$paimingmoshi=$_GET['paimingmoshi'];
					$PMbiaos=str_split(trim($paimingmoshi));
					foreach ($PMbiaos as $ke => $val) {
						switch ($val) {
							case "A":
							$classname='duishoufen';
							$xiaobiao='对<br />手<br />分';
							 break;
							case "B":
							$classname='leijinfen';
							$xiaobiao='累<br />进<br />分';
							 break;
							case "C":
							$classname='shengju';
							$xiaobiao='胜<br />局';
							 break;
							case "D":
							$classname='fangui';
							$xiaobiao='犯<br />规';
							 break;
							case "E":
							$classname='houshengju';
							$xiaobiao='后<br />胜<br />局';
							 break;
							case "F":
							$classname='houshouju';
							$xiaobiao='后<br />手<br />局';
							 break;
							case "G":
							$classname='xianshengju';
							$xiaobiao='先<br />胜<br />局';
							 break;
							case "H":
							$classname='zhisheng';
							$xiaobiao='直<br />胜';
							 break;
							case "I":
							$classname='shengshouhe';
							$xiaobiao='胜<br />手<br />和';
							 break;
							case "J":
							$classname='heshouhe';
							$xiaobiao='和<br />手<br />和';
							 break;
							case "K":
							$classname='fushouhe';
							$xiaobiao='负<br />手<br />和';
							 break;
							default:
							$classname='xiaofen';
							$xiaobiao='小<br />分';
							 break;
						}
						echo '<th rowspan="2" class="',$classname,'">',$xiaobiao,'</th>';
					}
					
					?>						  
					   <th class="yicunpaiming" rowspan="2">
					  已存<br >排名
					  </th>
					  <th class="mingci" title="按选手的名次重新排序" rowspan="2" width="30">
					   <?php echo'
					     <a  href="?bsid='.$_GET['bsid'].'&paimingmoshi='.$_GET['paimingmoshi']
                            .'&&paixu=';echo $_GET['paixu']=='pmabc'?'pmcba':'pmabc';
                            echo '">名次</a>
                         ';?>
					  </th>
					 
					</tr>
					<tr>
			 <?php  for($i=1;$i<=$bsinfo['bs_zonglunshu'];$i++) {?>
					  <td class="dsjfbiaoti">对<br />手</td>
					  <td class="dsjfbiaoti">积<br />分</td>
			 <?php }?>
				    </tr>
			    <?php
			    foreach ($xss as $key => $value) {//以序号为键值，1开始的
			    ?>
					<tr class="hang" <?php echo $key%2?' style="background-color:#E8E8E8;"':'';?>  onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
					  <td class="xuhao"><?php echo $value['xs_xuhao'];?></td>
					  <td class="danwei"><?php echo $value['xs_danwei'];?></td>
					  <td class="xsname"><?php echo $value['xs_name'];?></td>
					  
					  <?php 
					  for($i=0;$i<$bsinfo['bs_zonglunshu'];$i++){
					  		if ($value['xianhous'][$i]=="+") {
					  			$xianhou='xianshou';
					  		}else{
					  			$xianhou='houshou';
					  		}
					  		echo '<td class="',$xianhou,'">',$value['towhos'][$i],'</td>
						          <td class="jifen">',$value['gelunfens'][$i],'</td>';
					  		//$value['fenshus'][$i]不是各轮的积分，而是得分！！！！！！！！
					  }
                      ?>
                    <!-- 按排名的顺序排列，有可能对手分和累进分同时出现的哦；另外能分出名次的后面的因素还要标出吗？？-->
					  <td class="zongfen"><?php echo $value['xs_zongfen'];?></td>
					<?php 
//					$paimingmoshi=$_GET['paimingmoshi'];
//					$PMbiaos=str_split(trim($paimingmoshi));
					foreach ($PMbiaos as $ke => $val) {
						switch ($val) {
							case "A":
							$classname='duishoufen';
							$xiaobiao=$value['duishoufen'];
							 break;
							case "B":
							$classname='leijinfen';
							$xiaobiao=$value['leijinfen'];
							 break;
							case "C":
							$classname='shengju';
							$xiaobiao=$value['shengju'];
							 break;
							case "D":
							$classname='fangui';
							$xiaobiao=$value['xs_fangui'];
							 break;
							case "E":
							$classname='houshengju';
							$xiaobiao=$value['houshengju'];
							 break;
							case "F":
							$classname='houshouju';
							$xiaobiao=$value['houshouju'];
							 break;
							case "G":
							$classname='xianshengju';
							$xiaobiao=$value['xianshengju'];
							 break;
							case "H":
							$classname='zhisheng';
							$xiaobiao=$value['zhisheng'];//暂时不考虑！
							 break;
							case "I":
							$classname='shengshouhe';
							$xiaobiao=$value['shengshouhe'];
							 break;
							case "J":
							$classname='heshouhe';
							$xiaobiao=$value['heshouhe'];
							 break;
							case "K":
							$classname='fushouhe';
							$xiaobiao=$value['fushouhe'];
							 break;
							default:
							$classname='xiaofen';
							$xiaobiao=$value['xiaofen'];
							 break;
						}
						echo '<td class="',$classname,'">',$xiaobiao,'</td>';
					}
					?>	
					  
					  <td class="yicunpaiming"><?php echo $value['xs_paiming'];?></td>
					  <td class="mingci"><?php echo $value['mingci'];?></td>
					</tr>
				
			    <?php	
			    }
				?>
				  </table>	   
			   </td>
			</tr>
			<tr>
			   <td colspan="2">
				  <table width="100%" border="0" align="center">
					<tr>
					  <td height="16px"></td>
					  <td></td>
					  <td></td>
					</tr>
					<tr>
					  <td>裁判长：<?php echo $bsinfo['bs_caipanzhang'];?></td>
					  <td>软件编排：<?php echo $bsinfo['bs_bianpaiyuan'];?></td>
					  <td>
					     <div  class="printtime">打印时间：
					      <?php 
					      date_default_timezone_set('PRC');
					      echo date("Y年m月d日  H:i:s");
					      ?>
					      </div>
					  </td>
					</tr>
				  </table>	   
			   </td>
			</tr>
			<tr>
			   <td colspan="2">
			   </td>
			</tr>
		</table>

	</div>
<!-- <a name="maobutton" id="maobutton" class="maodian"></a> --><!--锚点设置，从1开始 -->
</div>

