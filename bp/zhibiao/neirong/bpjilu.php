
<!--编排纪录公告（对阵表）；同时可作为本轮的成绩显示表，字体大小最小20px，最大28px；
20px时一页A4纸容入恰好27台（和裁判）；
22px时一页A4纸容入恰好24-25台（和裁判）；
24px时一页A4纸容入恰好22-23台（和裁判）；
26px时一页A4纸容入恰好20台（和裁判）；A4纸内容高790px以上
28px时，刚好19台和裁判；
需去掉链接
-->


<style type="text/css">
<!--

/*编排的界面 Lbianpai1*/
.content{
    width: 170mm;
}
a,td,th,input,select {
	font-size: 22px;
	text-align: center;
}
.hang td {	padding-top:4px;	padding-bottom:4px;}
.hang:hover {
    background-color:#FFFF99;
}
-->
</style>

<div class="S" align="center">
    <div name="A4" class="A4S">
		 <a name="1" id="1" class="maodian"></a><!--锚点设置，从1开始 -->
		<table name="content" class="content" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" height="5px"></td>
  </tr>
  <tr>
    <td colspan="3" style="font-size:26px;font-weight:bold;padding:5px 0px;">
	<?php echo $bsinfo['bs_biaoti']?$bsinfo['bs_biaoti']:'无标题';
	 echo $bsinfo['bs_zubie']?'（'.$bsinfo['bs_zubie'].'）':''; ?>
	 </td>
  </tr>
  <tr>
    <td colspan="3" height="5px"></td>
  </tr>
  <tr>
    <td width="34%"><div class="bisaizubie" align="left">组别：<?php echo $bsinfo['bs_zubie']?$bsinfo['bs_zubie']:''; ?></div></td>
    <td width="33%">第 <?php echo $dijilun?$dijilun:'&nbsp;';?> 轮&nbsp;&nbsp;</td>
    <td width="33%">
   <!-- <div align="right">&nbsp;&nbsp;月&nbsp;&nbsp;日&nbsp;&nbsp;时&nbsp;&nbsp;分</div>-->
    <div align="right" class="yemaquyu">第&nbsp;1&nbsp;页（共&nbsp;1&nbsp;页）</div>
    </td>
  </tr>
  <tr>
    <td colspan="3" height="3px"></td>
  </tr>
  <tr>
   
    <td colspan="3"> 
		<table class="shujutable" border="1" align="center" width="660px" cellspacing="0">
			<tr>
			  <th scope="col" width="54" rowspan="2">
				台<br />
				次			</th>
			  <th scope="col" colspan="3">红方</th>
			  <th scope="col" width="80" rowspan="2">结果</th>
			  <th scope="col" colspan="3">黑方</th>
			</tr>
			<tr>
			  <td width="50">序号</td>
			  <td width="140">姓名</td>
			  <td width="auto">上轮<br />积分</td>
			  <td width="auto">上轮<br />积分</td>
			  <td width="140">姓名</td>
			  <td width="50">序号</td>
			</tr>
			<?php 
			if($taicis){
				//$duizhen='';
				for($i=0;$i<count($taicis);$i++) {
				  $red=$taicis[$i][0];
				  $black=$taicis[$i][1];
				  if ($taicis[0][0]['xs_xuhao']) {
					  //验证下，因为是按台号来分的，可能对到的是空号（显示保存的编排结果，非编排）为空值
					  //只有最后一台能对到空号
					  if (!$red) {
					  	$red['xs_xuhao']=0;
					  	$red['xs_name']='空号';
					  }
					  if (!$black) {
					  	$black['xs_xuhao']=0;
					  	$black['xs_name']='空号';
					  }
				  }					  
				  //$duizhen.=$red['xs_xuhao'].','.$red['xs_xianshu'].','.$black['xs_xuhao'].','.$black['xs_xianshu'];
				  //if($i<count($taicis)-1){ $duizhen.=','; }
			?>
			
			<tr class="hang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
			  <td>[<?php echo $i+1;?>]</td>
			  <td class="xianshou">（<?php echo $red['xs_xuhao'];?>）</td>
			  <td><?php echo $red['xs_name'];?></td>
			  <td class="jifen"><?php echo $red['xs_zongfen'];?></td>
			  <td><?php echo $red['xs_defen'];?>:<?php echo $black['xs_defen'];?></td>
			  <td class="jifen"><?php echo $black['xs_zongfen'];?></td>
			  <td><?php echo $black['xs_name'];?></td>
			  <td class="houshou">（<?php echo $black['xs_xuhao'];?>）</td>
			</tr>
		    <?php
					}	
			     }
			?>
		</table> 
		<!--编排结果显示区域-->	</td>
  </tr>
  <!--编排结果显示区域-->
  <tr>
     <td colspan="3" height="6"></td>
  </tr>
  <tr>
    <td>
	    <div align="left">裁判长：<?php echo $bsinfo['bs_caipanzhang']?$bsinfo['bs_caipanzhang']:''; ?></div>	</td>
	<td colspan="2">
	    编排：<?php echo $bsinfo['bs_bianpaiyuan']?$bsinfo['bs_bianpaiyuan']:''; ?>
	</td>
  </tr>
</table>
	</div>
	
</div>