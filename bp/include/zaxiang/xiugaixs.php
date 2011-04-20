<!--修改指定比赛中选手的信息（一次只能一个），只能修改选手的个人信息，
非比赛编排信息。(序号,姓名,单位,性别,半区,备注,)。但是新增和删除是比较不寻常的！-->
<style type="text/css">

.Lxsliebiao {
	border-color:#DDDDDD;
}
.Lxsliebiao .hanghao {
	color:blue;
}
.Lxsliebiao #chouqian {
	color:red;
}
.tablehead th,.tablehead td {
	background-color:#AAAAAA;
	padding:5px 0px;
}
.hangtr td {
 	border-color:#DDDDDD;
 	padding:5px 0px;
}
.hangtr input,.hangtr select {
	border-width:1px;
	border-color:#EEEEEE;
}
.dantr td input,.dantr td select {
	background-color:#EEEEEE;
}
</style>
<table border="1" width="100%" class="Lxsliebiao">
  <tr class="tablehead">
	<th scope="col">行号</th>
	<th scope="col">序号</th>
	<th scope="col">姓名</th>
	<th scope="col">单位</th>
	<th scope="col">性别</th>
	<th scope="col">半区</th>
	<th scope="col">备注</th>
	<th scope="col">犯规</th>
	<th scope="col">退赛</th>
	<th scope="col">操作</th>
  </tr>
  <?php
  if ($xuanshous) {   //是否按某因素排序呢？？？
  	$xuhaodom=array();
  	foreach ($xuanshous as $key => $val) {
  		$xuhaodom[]=$val['xs_xuhao'];
  	}
  	array_multisort($xuhaodom,$xuanshous);
  	foreach ($xuanshous as $key => $val) {?>
  <tr class="hangtr <?php echo $key%2?'dantr':'';?>">
  	<td class="hanghao" style="color:blue"><?php echo $key+1;?></td>
	<td>
	<input name="id" type="hidden" value="<?php echo $val['xs_id'];?>">
	<input name="xuhao" type="text" size="3" value="<?php echo $val['xs_xuhao'];?>">	</td>
	<td><input name="name" type="text" size="16" value="<?php echo $val['xs_name'];?>"></td>
	<td><input name="danwei" type="text" size="16" value="<?php echo $val['xs_danwei'];?>" /></td>
	<td>
	  <select name="sex">
	    <option value="0">男</option>
	    <option value="1" <?php $val['xs_sex']?print 'selected="selected"':'';?>>女</option>
      </select>    </td>
	<td>
	  <select name="banqu">
	    <option value="0" <?php !$val['xs_banqu']?print 'selected="selected"':'';?>>不区分</option>
	    <option value="1" <?php $val['xs_banqu']==1?print 'selected="selected"':'';?>>上半区</option>
	    <option value="2" <?php $val['xs_banqu']==2?print 'selected="selected"':'';?>>下半区</option>
      </select>				    </td>
	<td><input name="beizhu" type="text" size="10" value="<?php echo $val['xs_beizhu'];?>"></td>
	<td><input name="fangui" type="text" size="4" value="<?php echo $val['xs_fangui'];?>"></td>
	<td><input name="tuichu" type="checkbox" value="1" <?php $val['xs_tuichu']?print 'checked="checked"':'';?> /></td>
	<td>
	  <!--<a href="xsgl.php?bsid=<?php echo $bsid;?>&&xuhao=<?php echo $val['xs_xuhao'];?>">修改</a>&nbsp;  -->
      <a href="xsgl.php?bsid=<?php echo $bsid;?>&&action=shanchu&xuhao=<?php echo $val['xs_xuhao'];?>&xsid=<?php echo $val['xs_id'];?>">删除</a>
	</td>
  </tr>
  <?php }}?>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="10">
	<form name="form1" method="post" action="">
	  <input type="hidden" name="XSxiugai" value="">
	  <input style="color:green;font-weight:bold" id="quedingcaozuo" type="button" value="确定以上修改" onclick="xiugaixs(this)">&nbsp;-&gt;&nbsp;
	  <input type="submit" name="tijiao" value="提交修改" disabled="disabled">&nbsp;&nbsp;
	  <!--<input type="reset" name="reset" value="重置" onclick="chongzhi(this)">-->
  	  &nbsp;&nbsp;
  	  
  	  <select onchange="chouqianmoshi(this)" id="chouqian" title="重新排列序号的执行模式：
						  	 其中“人工录抽签号”在以上直接修改保存即可；
						  	“随机重排序号”根据需要打乱原排序再电脑随机排序；
						  	“录入顺序排序”按原来选手录入的前后顺序来排列序号；
						  	“根据抽签排序”根据目前的序号从小到大重新排列并重置序号；
						  	“根据单位排序”同队成员连续，单位整体随机重新排列并重置序号（一般首轮使用栏腰配对）；
						  	“同半区内随机”同一半区的随机聚合一起，且按照“上半区-不区分-下半区”来排（一般首轮使用首位配对）">
	  	  <option title="选择你想要的序号安排（抽签排序）模式，也可以不选择" value="">
	  	  -序号安排模式-
	  	  </option>
	  	   <option title="随机重排序号，根据需要打乱原排序再电脑随机排序" value="suiji">
	  	  随机重排序号
	  	  </option>
	  	  <option title="录入顺序排序，按原来选手录入的前后顺序来排列序号" value="luru">
	  	  录入顺序排序
	  	  </option>
	  	  <option title="录入逆序排序，按原来选手录入的逆序来排列序号" value="luruni">
	  	  录入逆序排序
	  	  </option>
	  	  <option title="根据抽签排序，根据目前的序号从小到大重新排列并重置序号" value="chouqian">
	  	  根据抽签排序
	  	  </option>
	  	  <option title="根据单位排序，同队成员连续，单位整体随机重新排列并重置序号（一般首轮使用栏腰配对）" value="danwei">
	  	  根据单位排序
	  	  </option>
	  	  <option title="同半区内随机，同一半区的随机聚合一起，且按照“上半区-不区分-下半区”来排（一般首轮使用首位配对）" value="banqu">
	  	  同半区内随机
	  	  </option>
  	  </select>
  	  
  	  
  	  
	  <!--
  	  <input title="智能自动抽签，打乱重排选手的序号，可以防止序号重复，序号从1开始" style="color:red;" type="button" value="随机重排序号" onclick="
  				javascript:
  				if(confirm('智能自动抽签，重新排列选手的序号，执行后不可恢复！')){
	  				if(confirm('使首轮同队不能相遇？推荐“确定”；可以相遇选“取消”。注意：只根据当前的首轮相关设置来处理！')){
	  					location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&&action=chongpai&&TTbuyu=1';
	  				}else{
	  					location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&&action=chongpai&&TTbuyu=0';
	  				}
  				}">
  	  -->
  				&nbsp;&nbsp;
	  <input style="color:blue;" type="button" value="批量新增/删除选手页面" onclick="javascript:location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&&rukou=luru'">
    </form>	</td>
  </tr>
  <tr>
	  <td colspan="10">
	     <div id="tongji" style="display:none"></div>
	  </td>
  </tr>
</table>

<script language="javascript" type="text/javascript">
	//数值排序必须的，否则无参数按字符编码顺序排序！但a或b不为数字时，a-b IE6会报错终止，FF不会，所以换成此形式！
	function sortNumber(a,b) { 
		if (isNaN(a)||isNaN(b)) {  //有至少一个非数字
			return -999;
		} else {
			return a - b;
		}
	}

	function xiugaixs(queding){
		tiaochu=0;
		xiugai="";
		//id  xuhao  name danwei sex banqu  beizhu fangui tuichu caozuo
		iddom=document.getElementsByName('id');
		xuhaodom=document.getElementsByName('xuhao');
		namedom=document.getElementsByName('name');
		danweidom=document.getElementsByName('danwei');
/*		for (i=0;i<xuhaodom.length;i++) {
			for (k=i+1;k<xuhaodom.length;k++) {
				if (xuhaodom[i].value==xuhaodom[k].value) {
					if ( confirm("至少有一个序号重复！序号：["+xuhaodom[k].value+"]  是否继续") ) {

					} else {
						return false;
					}
					tiaochu=1;
					break;
				}
				if (tiaochu) {
					break;
				}
			}
		}*/
		
		////////////////////////////新增的//////////
		//没有1号或中间断号；有0号或负号；非数字整数；姓名重复；
		//生成：单位列表；单位数量；选手列表（含序号）；总人数；姓名重复；
		zongrenshu=namedom.length; 		//总人数
		feizhengxuhaoshu=0;          	//非正数序号的个数
		feizhengxuhaolie=''; 				//非正数字序号行号列表
		xuhaochongfu=0; 				//序号重复数
		xuhaochongfulie='';					//重复序号行号列表
		xuhaochongfus=new Array();  	//重复序号的储存数组
		xuhaos=new Array();             //序号储存数组
		namechongfu=0;   				//姓名重复数
		namechongfulie='';					//重复姓名行号列表
		namechongfus=new Array();   	//重复姓名的储存数组！因为如果有重复一般需要知道在哪里是哪个重复以便修正
		names=new Array(); 				//姓名储存的数组
		danweis=new Array();			//单位名称储存的数组
		danweichengyuan=new Array();
		for (i=0;i<xuhaodom.length;i++) {
			//序号非正数
			if (isNaN(xuhaodom[i].value||xuhaodom[i].value<=0)) { 
				feizhengxuhaoshu++;	
				feizhengxuhaolie+='（'+(i-1+1+1)+'）';
			}
			//序号储存数组
			xuhaos[i]=xuhaodom[i].value;
			
			//姓名储存数组，不包括重复的处理
			names[i]=namedom[i].value;

			//单位相关的处理
			if (danweis) { 
			    butong=1;
				for(d=0;d<danweis.length;d++) {
					if (danweidom[i].value==danweis[d]) {
						danweichengyuan[d][danweichengyuan[d].length+1]='['+xuhaodom[i].value+']'+namedom[i].value;
						butong=0;
						break;
					}
				}
				if (butong) {  //和前面的所有已存单位不同
					danweis[d]=danweidom[i].value;
					danweichengyuan[d]=new Array();
					danweichengyuan[d][0]='['+xuhaodom[i].value+']'+namedom[i].value; //其中d经过for已经是等于danweis.length的了
				}
			} else {
				danweis[0]=danweidom[i].value;
				danweichengyuan[0][0]='['+xuhaodom[i].value+']'+namedom[i].value;
			}
			
			//序号重复计算
			if (xuhaos) { 
				for(d=0;d<xuhaos.length-1;d++) {
					if (xuhaodom[i].value==xuhaos[d]) {
						xuhaochongfus[xuhaochongfu]=xuhaodom[i].value;
						xuhaochongfu++;
						xuhaochongfulie+='（'+(i-1+1+1)+'）';
						break;
					}
				}
			}
			//姓名重复计算
			if (names) { 
				//alert(namedom[i].value+'=='+namechongfus[0]);
				for(d=0;d<names.length-1;d++) {
					if (namedom[i].value==names[d]) {
						namechongfus[namechongfu]=namedom[i].value;
						namechongfu++;
						namechongfulie+='（'+(i-1+1+1)+'）';
						break;
					}
				}
			}
			/*
			for (k=i+1;k<namedom.length;k++) {
				if (namedom[i].value==namedom[k].value) {  //姓名重复数
					namechongfus[namechongfu]=namedom[i].value;
					namechongfu++;
					namechongfulie+='（'+(i-1+1+1)+'）';
					break;
				}
			}
			*/
		}
		
		var TJneirong='';
		TJneirong='  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">  <tr> <th height="40" colspan="4" bgcolor="#CCCCCC" scope="col">选手信息统计（当前页面数据为准）</th> </tr> <tr> <td width="15%" height="36">单位列表</td> <td width="35%"> <select onchange="danweixinxi(this)" id="TJdanweiliebiao">';
		TJneirong+='        <option value="-1" selected="selected">比赛共有'+danweis.length+'个单位</option>';
		for (key in danweis) {
			TJneirong+='    <option value="'+danweis[key]+'">[次序'+key+'] '+danweis[key]+'</option>';
		}
		TJneirong+='     </select>  </td> <td width="15%">》单位成员 </td> <td width="35%"> <select id="TJdanweixinxi"> <option value="-1" selected="selected">未选择任何单位</option> ';
		TJneirong+='      </select> </td> </tr> <tr> <td height="5px" colspan="4"></td> </tr> <tr> <td height="36">选手列表</td> <td> <select onchange="xuanshouxinxi(this)" id="TJxuanshouliebiao"> <option value="-1" selected="selected">比赛共有'+names.length+'位选手</option> ';
		for (key in names) {
			TJneirong+='     <option value="'+key+'">[序号'+xuhaos[key]+'] '+names[key]+'</option>';
		}
		TJneirong+='       </select> </td> <td>》选手单位</td> <td> <select id="TJxuanshoudanwei"> <option value="-1" selected="selected">未选择任何选手</option> </select> </td> </tr> <tr> <td height="5px" colspan="4"></td> </tr> <tr><td colspan="4"> <div id="paicuotishi">';
			TJneirong8='';
			if (feizhengxuhaoshu) {
				TJneirong8+='非正数字序号'+feizhengxuhaoshu+'个；行号'+feizhengxuhaolie+'<br>';
			}
			if (xuhaochongfu) {
				TJneirong8+='序号重复'+xuhaochongfu+'次；行号'+xuhaochongfulie+'<br>';
			}
			if (namechongfu) {
				TJneirong8+='姓名重复'+namechongfus.length+'次；行号'+namechongfulie+'<br>重复姓名：<select> ';
				for (key in namechongfus) {
					TJneirong8+='<option>'+namechongfus[key]+'</option>';
				}
				TJneirong8+='</select>';
			}
			//检查中间断号，输出断号的序号
			xuhaos.sort(sortNumber);  //如果xuhaos其中有非数字，IE6会跳出错误！终止执行
			jilu=1;
			duanhaolie='';
			for (i=1;i<=xuhaos.length;i++) {
				while (xuhaos[i-1]>jilu&&jilu<xuhaos.length) {  //jilu是1开始的，
//					duanhaos[]=jilu;
					duanhaolie+='['.concat(jilu)+']、';
					jilu++;
				}
				if (xuhaos[i-1]==jilu) {
					jilu++;  //相等，说明此数字已存在，jilu增1；记录小于序号，说明是重复、序号为负数或0导致的，可以不处理；
				} 
			}
			
			if (TJneirong8||duanhaolie) {
				if (TJneirong8) {
					TJneirong+=TJneirong8;
				}
				if (duanhaolie) {
					TJneirong+='<div style="white-space:normal">中断的序号：'+duanhaolie+'</div>';
				}
				
			} else {
				TJneirong+='排错提示：数据比较规范，无常规错误。 ';
			}
		
		TJneirong+='</div> </td> </tr> </table>';
		
//		newdiv=document.createElement("div");
//		newdiv.setAttribute('id','tongji');
		newdiv=document.getElementById('tongji');
		newdiv.style.display='block';
		newdiv.innerHTML=TJneirong;		
		
		////////////////////////////新增的//////////
		
		
		namedom=document.getElementsByName('name');
		danweidom=document.getElementsByName('danwei');
		sexs=document.getElementsByName('sex');
		banqus=document.getElementsByName('banqu');
		beizhus=document.getElementsByName('beizhu');
		   fanguis=document.getElementsByName('fangui');           //新增
		   tuichus=document.getElementsByName('tuichu');           //新增
		for(i=0;i<iddom.length;i++){
			   tuichus[i].checked?tuichuvalue=1:tuichuvalue=0;     //由于多选框，需特别处理
			xiugai+=iddom[i].value+','+xuhaodom[i].value+','
			        +namedom[i].value+','+danweidom[i].value+','
			        +sexs[i].value+','+banqus[i].value+','+beizhus[i].value+','
			        +fanguis[i].value+','+tuichuvalue;  //新增
			if(i<iddom.length-1){
				xiugai+=';';
			}
		}
		document.getElementsByName('XSxiugai')[0].value=xiugai;
		//queding.disabled=true;
		document.getElementsByName('tijiao')[0].disabled=false;
		if(queding.style.color=="green"){
			queding.style.color="blue";
		} else {
			queding.style.color="green";
		}
		//document.getElementById("quedingcaozuo").disabled="disabled";
	}
	//查看选择单位后，右侧列表显示此单位的所有成员
	function danweixinxi(thisdom) {
		xinxidom=document.getElementById('TJdanweixinxi');
		if (thisdom.value=='-1') {
			neirong='<option selected="selected" value="-1">未选择任何单位</option>';
		} else {
			namedom=document.getElementsByName('name');
			xuhaodom=document.getElementsByName('xuhao');
			danweidom=document.getElementsByName('danwei');
			neirong='';
			xinxidom.innerHTML='';
			
				firstoption=document.createElement('option');
				firstoption.value='-2';
				firsttext=document.createTextNode('共有 0 个成员');
				firstoption.appendChild(firsttext);
				firstoption=xinxidom.appendChild(firstoption);
				chengyuanshu=0;
//			for (key in danweidom) {
			for (key=0;key<danweidom.length;key++) {
				if (thisdom.value==danweidom[key].value) {
					newoption=document.createElement('option');
					newoption.value=xuhaodom[key].value;
					newtext=document.createTextNode('['+(key-1+2)+'行]'+namedom[key].value);
					newoption.appendChild(newtext);
				    xinxidom.appendChild(newoption);
				    chengyuanshu++;
					//neirong+='<option value="'+xuhaodom[key].value+'">['+(key-1+2)+'行]'+namedom[key].value+'</option>';
				}
			}
			firstoption.innerHTML='共有 '+chengyuanshu+' 个成员';
		}
		//xinxidom.innerHTML=neirong;
	}
	//查看选择选手后，右侧显示此选手的单位
	function xuanshouxinxi(thisdom) {
		xinxidom=document.getElementById('TJxuanshoudanwei');
		if (thisdom.value=='-1') {
			neirong='<option selected="selected" value="-1">未选择任何选手</option>';
		} else {
			xinxidom.innerHTML='';
			key=thisdom.value;
				newoption=document.createElement('option');
				newoption.value=danweidom[key].value;
				newtext=document.createTextNode(danweidom[key].value);
				newoption.appendChild(newtext);
			    xinxidom.appendChild(newoption);
		}
	}
	
	
	function chongzhi(){   //这个管不了列表数据，所以没什么用
		document.getElementsByName('XSxiugai')[0].value="";
	    document.getElementsByName('tijiao')[0].disabled="disabled";
	  	document.getElementById("quedingcaozuo").style.color="green";
	  	//document.getElementById("quedingcaozuo").disabled=false;
	}
	
	//按照选择的抽签排序模式安排序号
	function chouqianmoshi(thisdom) {
		optiondoms=thisdom.options;
		//moshis=new Array('','suiji','luru','chouqian','danwei');
		moshis=new Array();
		for (key in optiondoms) {  //key还会在最后有一个length值，很奇怪！！
			if (!isNaN(key)) {
				moshis[key]=optiondoms[key].value;
			}
		}
		//optiondom=thisdom.getElementsByName('option')[0];
		
		for (key in moshis) {
			if (moshis[key]==thisdom.value) {
				optiontitle=optiondoms[key].getAttribute('title');
			}
		}
		if (thisdom.value);
//		optiontitle=
		if (thisdom.value) {
			if(confirm(optiontitle.concat('。执行后不可恢复！'))){
				if (thisdom.value=='suiji') {
					if(confirm('使首轮同队不能相遇？推荐“确定”；可以相遇选“取消”。注意：只根据当前的首轮相关设置来处理！')){
						location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&action=chongpai&TTbuyu=1&moshi=suiji';
					}else{
						location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&action=chongpai&TTbuyu=0&moshi=suiji';
					}
				} else {
					location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>&action=chongpai&moshi='+thisdom.value;
				}
			}
		}
	}
</script>