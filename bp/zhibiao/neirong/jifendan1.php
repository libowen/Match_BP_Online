
<!--记分单_横式==示例-->


<style type="text/css">
<!--
.shujutable {
	margin:26mm 0mm;/* 不能在打印样式后定义，除非使用important */
}
.hang tr table tr:hover {
    background-color:#FFFF99;
}

-->
</style>

<div class="S" align="center">
    <div class="A4S">
		    <a name="1" id="1" class="maodian"></a><!--锚点设置，从1开始 -->
		<table class="shujutable" style="font-weight:bold" border="1" cellspacing="0" cellpadding="0">
		<?php if ($taicis) {
			for ($key=0;$key<count($taicis);$key++){
				$value=$taicis[$key];
				if ($value[0]) {
					$taihao=$key+1;
				}else{
					$taihao='&nbsp;';
				}
        ?>
			 <tr class="hang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
			   <td>
					<table class="jifendanHS" width="600px" border="0" cellspacing="0" cellpadding="0" style="font-size:14px"><!-- 记分单_横式-->
					   <tr>
						<td colspan="3" height="30px">
							★计分单★&nbsp;&nbsp;<?php echo $bsinfo['bs_id']?'['.$bsinfo['bs_id'].']':'';
							echo $bsinfo['bs_biaoti']?'《'.$bsinfo['bs_biaoti'].'》':'';
							?>&nbsp;&nbsp;第&nbsp;<?php echo $dijilun?$dijilun:'&nbsp;&nbsp;';?>&nbsp;轮
								<div style="height:3px;"></div>
						</td>
					   </tr>
					  </tr>
					   <tr>
						<td width="36%">
							<div class="bisaizubie">
							组别：<?php echo $bsinfo['bs_zubie']	;?>
							</div>
						</td>
						<td width="18%">&nbsp;
							
						</td>
						<td width="46%">
						  <div class="printtime">
						  日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;日
						  </div>
						    <div style="height:5px;"></div>
					    </td>
					  </tr>
					   <tr>
						<td colspan="3" height="auto">
						   <table class="jifendanHS" align="center" width="100%" border="1" cellspacing="0" cellpadding="0">
							  <tr height="25px">
								<td  width="60">台次</td>
								<td width="50">先后</td>
								<td width="32">序号</td>
								<td width="110">姓名</td>								
								<td width="60">成绩</td>
								<td width="140">用时</td>
								<td width="45">犯规</td>
								<td width="auto">备注</td>
							  </tr>
							  <tr>
								<td rowspan="2" style="font-size:larger"><?php echo $taihao;?></td>
								<td>红方</td>
								<td height="26px"><?php echo $value[0]['xs_xuhao'];?></td>
								<td><?php echo $value[0]['xs_name'];?></td>
								<td>&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td>黑方</td>
								<td height="26px"><?php echo $value[1]['xs_xuhao'];?></td>
								<td><?php echo $value[1]['xs_name'];?></td>
								<td>&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							  </tr>
						   </table>
						    	<div style="height:5px;"></div>
						</td>
					  </tr>
					   <tr><!--尾部-->
						<td height="28px">  
						（签字）红方：
						</td>  
						<td>
						  黑方： </td>
						<td>
						&nbsp;&nbsp;裁判员： </td>
					  </tr>   <!-- 记分单_横式-->
					</table>
					<div style="height:3px; width:100%; border-top: thin solid #000000;"><!-- 尾部-->
					</div>
			  </td>
			 </tr>
		<?php				
			}
		}?>	
		</table>
	</div>
</div>