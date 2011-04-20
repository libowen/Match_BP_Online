
<style type="text/css">
<!--
.biaoti{
	font-family:"黑体";
	font-size:26px;
    
}
.content {
    width:660px;
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
.xianshou{
}
.houshou {
}
.jifen {
}
-->
</style>


<!--个人成绩简表=名次表 -->
<div class="S" align="center">
    <div name="A4" class="A4S">
		 <a name="1" id="1" class="maodian"></a><!--锚点设置，从1开始 -->
			<table class="content" border="0" cellspacing="0">
				<tr>
				    <td colspan="3">
					<div style="margin-top:8px; font-family:'黑体';font-size:26px;text-align:center;">
						个人成绩(简表=名次表)
						<div align="right" style="margin:6px;font-family:'宋体';font-size:16px;">
							 《<?php echo $bsinfo['bs_biaoti']?$bsinfo['bs_biaoti']:'无标题';?>》-<?php echo $bsinfo['bs_zubie']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;						
						</div>
					</div>			    
					</td>
			   </tr>
				<tr>
					<td colspan="3">
			
						<table style="shujutable" width="100%" border="1" cellspacing="0" cellpadding="0">
						  <tr>
							<th width="30" >组别</th>
							<th width="90">名次</th>
							<th width="auto">单位</th>
							<th width="auto">姓名</th>
							<th width="60">总分</th>
							<th width="80">对手分<br />
							  累进分</th>
							<th width="60">胜局</th>
							<th width="110">备注</th>
						  </tr>
						  <tr class="hang">
							<td class="bold" rowspan="8" width="30">
							<?php echo $bsinfo['bs_zubie']; ?>							</td>
							<td class="xianhou">第一名 </td>
							<td >门头沟区 </td>
							<td class="houshou">大大富大贵</td>
							<td class="jifen">4 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第二名 </td>
							<td >朝阳区 </td>
							<td >&nbsp;</td>
							<td >10 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第三名 </td>
							<td >昌平区 </td>
							<td >&nbsp;</td>
							<td >12 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第四名 </td>
							<td >海淀区 </td>
							<td >&nbsp;</td>
							<td >19 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第五名 </td>
							<td >顺义区 </td>
							<td >&nbsp;</td>
							<td >24 </td>
							<td >5 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第六名 </td>
							<td >房山区 </td>
							<td >&nbsp;</td>
							<td >24 </td>
							<td >7</td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第七名 </td>
							<td >怀柔区 </td>
							<td >&nbsp;</td>
							<td >32 </td>
							<td >12 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						  <tr class="hang">
							<td >第八名 </td>
							<td >通州区 </td>
							<td >&nbsp;</td>
							<td >32 </td>
							<td >14 </td>
							<td >&nbsp;</td>
							<td >&nbsp;</td>
						  </tr>
						</table>
			
					</td>
				</tr>
				<tr>
					<td colspan="3" height="5px">
					</td>
				</tr>
				<tr>
					<td width="30%" style="text-align:left">
					裁判长：
					<?php echo $bsinfo['bs_caipanzhang']?$bsinfo['bs_caipanzhang']:''; ?>
					</td>
					<td width="30%" style="text-align:left">
					编排：
					<?php echo $bsinfo['bs_bianpaiyuan']?$bsinfo['bs_bianpaiyuan']:''; ?>
					</td>
					<td width="40%">
					<div class="printtime" align="right">
					打印时间：&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;日
					</div>
					</td>
				</tr>
			</table>

	</div>
</div>
