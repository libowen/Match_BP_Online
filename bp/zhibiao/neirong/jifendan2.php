<!--记分单_竖式_节约式_列表_A4-->

<style type="text/css">
<!--
.shujutable {
	margin:26mm 0mm;/* 不能在打印样式后定义，除非使用important */
}
.hang tr:hover {
    background-color:#FFFF99;
}
-->
</style>

<div class="S" align="center">
    <div class="A4S">
		    <a name="1" id="1" class="maodian"></a><!--锚点设置，从1开始 -->
			<table class="shujutable" border="0" style="font-weight:bold" cellspacing="0" cellpadding="0">
				  <tr><!-- 记分单_简式-->
					<td colspan="3" height="2px"></td>
				  </tr>
				  
		<?php if ($taicis) {
			for ($i=0;$i<count($taicis);$i++){
				if (!($i%2)) {
					if ($taicis[$i][0]) {
						$taihao=$i+1;
					}else{
						$taihao='';
					}
		?>
				  <tr class="hang" onclick="trbiaozhu(this,1)" ondblclick="trbiaozhu(this,2)">
					<td width="327px">
					   <table class="jifendanJS" align="center" width="330px" border="1" cellspacing="0" cellpadding="0">
						  <tr>
							<td height="38px" colspan="4">
								<?php echo $bsinfo['bs_zubie']?$bsinfo['bs_zubie']:'&nbsp;&nbsp;&nbsp;';?>&nbsp;
								<?php echo '《',$bsinfo[bs_biaoti],'》';?><br />
								第&nbsp;<?php echo $taihao?$taihao:'&nbsp;&nbsp;';?>&nbsp;台
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								第&nbsp;<?php echo $dijilun?$dijilun:'&nbsp;&nbsp;';?>&nbsp;轮
							</td>
						 </tr>
						  <tr>
							<td width="45" height="24">&nbsp;</td>
							<td width="140">红&nbsp;&nbsp;方</td>
							<td width="2">&nbsp;</td>
							<td width="140">黑&nbsp;&nbsp;方</td>
						  </tr>
						  <tr>
							<td height="26">姓名</td>
							<td>
							<?php
							    echo $taicis[$i][0]['xs_xuhao']?'['.$taicis[$i][0]['xs_xuhao'].']':'';
							    echo $taicis[$i][0]['xs_name'];
							?>
							</td>
							<td>&nbsp;</td>
							<td>
							<?php
							    echo $taicis[$i][1]['xs_xuhao']?'['.$taicis[$i][1]['xs_xuhao'].']':'';
							    echo $taicis[$i][1]['xs_name'];
							?>
							</td>
						  </tr>
						  <tr>
							<td height="26">用时</td>
							<td>&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
							<td>&nbsp;</td>
							<td>&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
						 </tr>
						  <tr>
							<td height="30">签名</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						 </tr>
						  <tr>
							<td height="30">结果</td>
							<td colspan="3">&nbsp;</td>
						 </tr>
												  <tr>
							<td>裁判<br />签名</td>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;&nbsp;月&nbsp;&nbsp;日&nbsp;&nbsp;时&nbsp;&nbsp;分</td>
						 </tr>
					 </table>	
					<div style="height:3px; width:100%; border-top: thin solid #000000;"><!-- 尾部-->
					</div>		    
					</td>
					<td width="2px">
					</td>
					
<td width="327px">
					   <table class="jifendanJS" align="center" width="330px" border="1" cellspacing="0" cellpadding="0">
						  <tr>
							<td height="38px" colspan="4">
								<?php echo $bsinfo['bs_zubie']?$bsinfo['bs_zubie']:'&nbsp;&nbsp;&nbsp;';?>&nbsp;
								<?php echo '《',$bsinfo[bs_biaoti],'》';?><br />
								第&nbsp;<?php echo is_numeric($taihao)?$taihao+1:'&nbsp;&nbsp;';?>&nbsp;台
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								第&nbsp;<?php echo $dijilun?$dijilun:'&nbsp;&nbsp;';?>&nbsp;轮
						 </tr>
						  <tr>
							<td width="45" height="24">&nbsp;</td>
							<td width="140">红&nbsp;&nbsp;方</td>
							<td width="2" height="3px">&nbsp;</td>
							<td width="140">黑&nbsp;&nbsp;方</td>
						  </tr>
						  <tr>
							<td height="26">姓名</td>
							<td>
							<?php
							    echo $taicis[$i+1][0]['xs_xuhao']?'['.$taicis[$i+1][0]['xs_xuhao'].']':'';
							    echo $taicis[$i+1][0]['xs_name'];
							?>
							</td>
							<td>&nbsp;</td>
							<td>
							<?php
							    echo $taicis[$i+1][1]['xs_xuhao']?'['.$taicis[$i+1][1]['xs_xuhao'].']':'';
							    echo $taicis[$i+1][1]['xs_name'];
							?>
						  </tr>
						  <tr>
							<td height="26">用时</td>
							<td>&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
							<td>&nbsp;</td>
							<td>&nbsp;&nbsp;时&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;秒</td>
						 </tr>
						  <tr>
							<td height="30">签名</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						 </tr>
						  <tr>
							<td height="30">结果</td>
							<td colspan="3">&nbsp;</td>
						 </tr>
												  <tr>
							<td>裁判<br />签名</td>
							<td>&nbsp;</td>
							<td colspan="2">&nbsp;&nbsp;月&nbsp;&nbsp;日&nbsp;&nbsp;时&nbsp;&nbsp;分</td>
						 </tr>
					 </table>
					<div style="height:3px; width:100%; border-top: thin solid #000000;"><!-- 尾部-->
					</div>			    
					</td>
				 </tr>
		<?php
				}
			}
		}?>
				  
			</table>
	</div>
	
</div>