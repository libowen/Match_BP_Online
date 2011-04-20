<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>输出首页的显示界面</title>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<form name="duizhenbiao" action="/bp/zhibiao/bpjilu.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th colspan="3" scope="col">编排纪录公告（对阵表）</th>
		  </tr>
		  <tr>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="" size="5" maxlength="8" />			</td>
			<td>表格样式：
			  <select name="moshi">
			    <option value="1">宋体实线</option>
			    <option value="2">黑体实线</option>
			    <option value="3" selected="selected">黑体无线</option>
		      </select>		    </td>
			<td>轮次：
		    <input name="dijilun" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td colspan="3">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input name="tijiao" type="submit" id="submit" value="提交" /></td>
		  </tr>
		</table>

		
		
	</form>
	</td>
  </tr>
  <tr>
    <td height="5px">&nbsp;</td>
  </tr>
  <tr>
    <td>
	<form name="jifendan" action="/bp/zhibiao/jifendan.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th colspan="3" scope="col">对局积分卡（记分单）</th>
		  </tr>
		  <tr>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="" size="5" maxlength="8" /></td>
			<td>表格样式：
			  <select name="moshi">
                <option value="1">横式</option>
                <option value="2" selected="selected">节约式</option>
              </select>
		    </td>
			<td>轮次：
            <input name="dijilun2" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td colspan="3">&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input name="submit2" type="submit" id="submit2" value="提交" /></td>
		  </tr>
		</table>

	</form>	
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<form name="GRcjbiao" action="/bp/zhibiao/GRcj.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th colspan="3" scope="col">个人成绩表（详表*总表）</th>
		  </tr>
		  <tr>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="" size="5" maxlength="8" /></td>
			<td>表格样式：
			  <select name="moshi">
                <option value="1">-未选择-</option>
                <option value="1" selected="selected">默认样式</option>
              </select></td>
			<td>排序：
			  <select name="paixu">
                <option value="xhabc" selected="selected">序号升序</option>
                <option value="xhcba" >序号降序</option>
				<option value="pmabc" >排名升序</option>
				<option value="pmcba" >排名降序</option>
				<option value="lunfen" >轮分</option>
              </select>
			  
			  <span id="lunfenlun" disabled="disabled" visibility="hidden">
			     第<input name="lunfenlun" type="text" value="" size="3" maxlength="3" />轮	  
			  </span> ?			  
		    </td>
		  </tr>
		  <tr title="
			   说明：
			   A 对手分（所对弈过的全部对手的积分之和）；
			   B 累进分（每轮积分相加总和）；
			   C 胜局；
			   D 犯规；
			   E 后胜局（后手胜局）；
			   F 后手局（后手局数）；
			   G 先手胜局；
			   H 直胜局（只比较仅有两人同分的情况）；
			   I 胜手和（所胜对手积分之和）；
			   J 和手和（所和对手积分之和）；
			   K 负手和（所负对手积分之和）；
                                ">
			<td>排名模式：		    
			  <select name="paimingmoshi2" onchange="paimingmoshi(this)">
                <option value="0">——未选择——</option>
                <option value="1">对手分标准模式</option>
                <option value="2">累进分标准模式</option>
              </select></td>
			<td>
			   <a href="#" title="
			   说明：
			   A 对手分（所对弈过的全部对手的积分之和）；
			   B 累进分（每轮积分相加总和）；
			   C 胜局；
			   D 犯规；
			   E 后胜局（后手胜局）；
			   F 后手局（后手局数）；
			   G 先手胜局；
			   H 直胜局（只比较仅有两人同分的情况）；
			   I 胜手和（所胜对手积分之和）；
			   J 和手和（所和对手积分之和）；
			   K 负手和（所负对手积分之和）；
                                " style="text-decoration: none;" >排名模式：</a>
			  
			  <input name="paimingmoshi" type="text" value="ACDEF" size="10" maxlength="16" />			 </td>
			<td>
				对手分方案：总分-A-C-D-E-F<br />
				累进分方案：总分-B-C-D-E			</td>
		  </tr>
		  <tr>
		    <td colspan="3">以上还未分出高下，则从
		      <select name="select">
                <option value="1">-未选择-</option>
                <option value="1">首轮</option>
                <option value="2">末轮</option>
              </select>
	        起去除一轮积分再判断，以后以此类推&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 显示：
	        <input name="qianji" type="text" value="" size="5" maxlength="8" />
	        名 </td>
	      </tr>
		  <tr>
		    <td colspan="3">&nbsp;</td>
	      </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    <td><input name="submit3" type="submit" id="submit3" value="提交" /></td>
	      </tr>
		</table>

		
		
	</form>
	</td>
  </tr>
</table>



<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div  style="width:200px; height:160px; float:left; position:fixed; right:0;  bottom:0; z-index:1; ">此处显示新 Div 标签的内容  IE浏览器未支持！！</div>
</body>
</html>
