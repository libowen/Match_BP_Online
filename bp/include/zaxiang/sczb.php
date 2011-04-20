<!--各项表格输出的详细配置，输出首页的显示界面-->
<style type="text/css">
<!--
.biaotou {
	background-color:#CCCCCC;
}
.shuoming input{
	margin:2px 0px;
	width:80%;
	font-size:12px;
	color:green;
}
.scpeizhi table td {
	padding:5px 0px;
}
.scpeizhi table {
	border-color:#DDDDDD;
}
-->
</style>
<table class="scpeizhi" border="0" cellspacing="0" cellpadding="0">
  <tr>
	  <td height="20px">
	  </td>
  </tr>
  <tr>
    <td>
	<form name="duizhenbiao" action="/bp/zhibiao/bpjilu.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="biaotou" colspan="3" scope="col" style="font-size:20px;">编排纪录公告（对阵表）</th>
		  </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" />
		    </td>
			<td>表格样式：
			  <select name="moshi">
			    <option value="1">宋体实线</option>
			    <option value="2" selected="selected">黑体实线</option>
			    <option value="3" >黑体无线</option>
		      </select>
		      </td>
			<td>轮次：
		    <input name="dijilun" title="留空，默认是当前轮" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="button" value="打印预览" onclick="dayin('duizhenbiao')" /></td>
		  </tr>
		</table>
	</form>
	</td>
  </tr>
  <tr>
    <td><hr /><br></td>
  </tr>
  <tr>
    <td>
	<form name="jifendan" action="/bp/zhibiao/jifendan.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="biaotou" colspan="3" scope="col" style="font-size:20px;">对局积分卡（记分单）</th>
		  </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" /></td>
			<td>表格样式：
			  <select name="moshi">
                <option value="1">横式</option>
                <option value="2" selected="selected">节约式</option>
              </select>
		    </td>
			<td>轮次：
            <input name="dijilun" title="留空，默认是当前轮" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input type="button" value="打印预览" onclick="dayin('jifendan')" /></td>
		  </tr>
		</table>
	</form>	
	</td>
  </tr>
  <tr>
    <td><hr /><br></td>
  </tr>
  <tr>
    <td>
	<form name="GRcjbiao" action="/bp/zhibiao/GRcj.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="biaotou" colspan="3" scope="col" style="font-size:20px;">个人成绩表（详表*总表）</th>
		  </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" /></td>
			<td>表格样式：
			  <select name="moshi">
                <option value="1" selected="selected">默认样式</option>
              </select></td>
			<td> 轮次：
		    <input name="dijilun" title="留空，默认是当前轮" type="text" value="" size="5" maxlength="8" /></td>
		    </td>
		  </tr>
		  <tr>
			<td>
			显示<select name="paixu">
                <option value="xhabc">序号升序</option>
                <option value="xhcba" >序号降序</option>
				<option value="pmabc"  selected="selected">排名升序</option>
				<option value="pmcba" >排名降序</option>
				<option value="lunfen" >轮分逆序</option>
              </select>
			  <span disabled="disabled" visibility="hidden" display="none">
			     第<input title="只有前面选择“轮分逆序”本项才有效，指根据指定轮的积分、至当轮的对手分和、序号来排序；留空默认为1" name="lunfenlun" type="text" value="" size="2" maxlength="3" />轮	  
			  </span>		
			</td>
			<td> 
			  <script type="text/javascript" language="javascript" >
              function PMmoshi(thisDOM) {
              	if(thisDOM.value==1) {
              		document.getElementsByName("paimingmoshi")[0].setAttribute("value","ACDEF");//对手分标准
              		//document.getElementsByName("paimingmoshi")[0].value="ACDEF";//对手分标准
              	}
              	if(thisDOM.value==2) {
              		document.getElementsByName("paimingmoshi")[0].setAttribute("value","BCDEF");//对手分标准
              		//document.getElementsByName("paimingmoshi")[0].value="BCDEF";//对手分标准
              	}
              }
              </script>	
             标配排名模式：		    
			  <select id="paimingmoshi2" onchange="PMmoshi(this)">
                <option value="0">—自定义—</option>
                <option value="1" title="对手分方案：(总分)ACDEF">对手分标准</option>
                <option value="2" title="累进分方案：(总分)BCDE">累进分标准</option>
              </select>	
             
            </td>
			<td title="即“破同分项目选择”
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
			   Z 总分；">->自定义：(总分)
			  <input title="默认总分项Z在最前面，一般不要填写总分项" name="paimingmoshi" type="text" value="<?php echo $bsinfo['bs_grpm_moshi']?$bsinfo['bs_grpm_moshi']:'ACDEF';?>" size="10" maxlength="16" />			
			</td>
		  </tr>
		  <tr>
		  <td colspan="3" class="shuoming">
		     排名模式说明：<input type="text" value="A 对手分（所对弈过的全部对手的积分之和）；B 累进分（每轮积分相加总和）；C 胜局；D 犯规；E 后胜局（后手胜局）；F 后手局（后手局数）；G 先手胜局；H 直胜局（只比较仅有两人同分的情况）；I 胜手和（所胜对手积分之和）；J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；Z 总分；"/>
		  </td>
		  </tr>
		  <tr>
		    <td colspan="3">以上还未分出名次，则从
		      <select name="dir" title="推荐：累进分模式选 首轮；对手分模式选 末轮。累进分-扣除第一轮积分，还相同、再扣除第二轮，依此类推；对手分-比较倒数第二轮积分，依此类推">
                <option value="1" <?php echo $bsinfo['bs_dir']==1?'selected':'';?>>首轮</option>
                <option value="2" <?php echo $bsinfo['bs_dir']==2?'selected':'';?>>末轮</option>
              </select>
		        起去除一轮积分再判断，以后以此类推&nbsp;&nbsp;&nbsp;&nbsp;
		        
	        </td>
	      </tr>
		  <tr>
		    <td>只显示：前
		        <input title="留空则显示全部，整数" name="qianji" type="text" value="" size="5" maxlength="8" />
		        名
		    </td>
		    <td>空号总分=
   		      <select name="konghaofen" title="计算对手分时，空号的积分指定：零分 或 本比赛所有选手的最低积分">
                <option value="0" <?php echo $bsinfo['bs_konghaofen']<=1?'selected':'';?>>全部计零分</option>
                <option value="1" <?php echo $bsinfo['bs_konghaofen']==1?'selected':'';?>>选手最低分</option>
              </select>
		    </td>
		    <td><input type="button" value="打印预览" onclick="dayin('GRcjbiao')" /></td>
	      </tr>
		</table>
	</form>
	</td>
  </tr>
  <tr>
	  <td>
	     <hr /><br>
	  </td>
  </tr>
  
  <tr>
    <td>	
	<form name="TTcj" action="/bp/zhibiao/TTcj.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="biaotou" colspan="4" scope="col" style="font-size:20px;">队员总分制团体成绩表</th>
		  </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" /></td>
			<td title="不能留空，整数；小于实际队员数时优先取最好成绩">每队队员数：
              <input name="duiyuanshu" type="text" value="<?php echo $bsinfo['bs_duiyuanshu']?$bsinfo['bs_duiyuanshu']:'4';?>" size="3" maxlength="8" />
              *</td>
			<td>
			除去不够队员数的团队：
              <select name="chuque">
                <option value="1">是</option>
                <option value="0" selected="selected">否</option>
              </select></td>
			<td>最后名次：
            <input name="momingci" title="留空，默认等于参赛人数（包括中途退赛的，不包括虚拟空号）" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td>显示前
              <input name="qianji" title="留空，默认全部显示；整数" type="text" value="8" size="3" maxlength="8" />
名</td>
			<td colspan="2">&nbsp;</td>
			<td title="需先保存个人排名"><input type="button" value="打印预览" onclick="dayin('TTcj')" /></td>
		  </tr>
		</table>
	</form>	
	</td>
  </tr>
  <tr>
    <td><hr /><br></td>
  </tr>
  <tr>
    <td>
	<form name="TTmc" action="/bp/zhibiao/TTmc.php" method="get">
	    
		<table width="660px" border="1" cellpadding="0" cellspacing="0">
		  <tr>
			<th class="biaotou" colspan="4" scope="col" style="font-size:20px;">队员总分制团体赛团体名次</th>
		  </tr>
		  <tr>
			<td>比赛ID：
		    <input name="bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" /></td>
			<td title="不能留空，整数；小于实际队员数时优先取最好成绩">每队队员数：
              <input name="duiyuanshu" type="text" value="<?php echo $bsinfo['bs_duiyuanshu']?$bsinfo['bs_duiyuanshu']:'4';?>" size="3" maxlength="8" />
              *</td>
			<td>
			除去不够队员数的团队：
              <select name="chuque">
                <option value="1">是</option>
                <option value="0" selected="selected">否</option>
              </select></td>
			<td>最后名次：
            <input name="momingci" title="留空，默认等于参赛人数（包括中途退赛的，不包括空号）" type="text" value="" size="5" maxlength="8" /></td>
		  </tr>
		  <tr>
			<td>显示前
              <input name="qianji" title="留空，默认全部显示；整数" type="text" value="8" size="3" maxlength="8" />
名</td>
			<td colspan="2">&nbsp;</td>
			<td title="需先保存个人排名"><input type="button" value="打印预览" onclick="dayin('TTmc')" /></td>
		  </tr>
		</table>
	</form>
	</td>
  </tr>
  <tr>
    <td><hr /><br></td>
  </tr>
</table>
<script type="text/javascript">

function dayin (biaoming) {
	biaoform=document.getElementsByName(biaoming)[0];
	url=biaoform.getAttribute('action');
	url=url.concat('?');
	//shujus=biaoform.getElementsByTagName('input');//还有select等
	//shujus=biaoform.all;  //只IE可以
	shujus=biaoform.getElementsByTagName('input');
	if (!shujus) {}
	for (i=0;i<shujus.length;i++) {
		shujuname=shujus[i].getAttribute('name');
		if (shujuname) {
			url+=shujuname+'='+shujus[i].value+'&';
		}
	}
	shujus=biaoform.getElementsByTagName('select');
	if (!shujus) {}
	for (i=0;i<shujus.length;i++) {
		shujuname=shujus[i].getAttribute('name');
		if (shujuname) {
			url+=shujuname+'='+shujus[i].value+'&';
		}
	}
	window.open(url);
}

</script>

