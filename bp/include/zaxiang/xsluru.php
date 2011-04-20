<!--批量录入选手、导入选手的界面-->
<script language="javascript" type="text/javascript">
function daoru(anniu){
  	document.getElementById("xuanshouluru").value=document.getElementById("xuanshoudaoru").value;
  	document.getElementById("submit").disabled=false;
  	//alert(anniu.style.color);
  	if(anniu.style.color=="green") {
  		anniu.style.color="blue";
  	}else {
  		anniu.style.color="green";
  	}
  	//anniu.disabled="disabled";
}
function chongzhi(){
	document.getElementById("xuanshouluru").value="";
    document.getElementById("submit").disabled="disabled";
  	//document.getElementById("wancheng").disabled=false;
}
</script>
<form action="" method="post">
<table class="Ltable" width="100%" border="1" align="center">
  <tr>
<!--	<th scope="col">文本格式化批量导入[分隔号为英文,;]</th>-->
<!--	<th scope="col">选手录入说明：</th>-->
  </tr>
  <tr>
	<td>	
	<h3>文本格式化批量导入[分隔号为英文,;]</h3>
	格式：[序号],[姓名],[单位],[性别],[半区],[备注],[犯规],[退赛];
<!--	<br />括号为注释，每人以分号结束，可只设置前几项，必须英文逗号和分号分割-->
<!--	<br />例如：1,编排系统,如意盒,1,0;2,编排系统,如意盒,1,0,备注,1,0;-->
	<textarea style="font-size:16px" id="xuanshoudaoru" cols="80" rows="10" ondblclick="javascript:if(this.getAttribute('rows')==10){ this.setAttribute('rows',30) } else { this.setAttribute('rows',10) }" title="双击：放大或缩小本输入框"></textarea>
	<br />“逐个增加”“快速模式化录入”都是通过计算修改栏内内容。都要点击“完成增加导入”再“提交保存”
	</td>
	<td>
	<!-- <input name="textfield" type="text" size="28" value=""/>
									<br />注：你的权限不支持此项
	-->
	<!-- 
	<p># 批量导入格式：[序号],[姓名],[单位],[性别],[半区],[备注],[犯规],[退赛]; 使用英文的逗号和分号，每个选手一行，每行末须有英文分号，序号可不填写，默认性别为男，默认不区分上下半区。</p>
	<p># 其他两种方式是通过相应的计算修改批量导入的结果。</p>
	<p># 填写逐个增加所需的内容：序号、姓名、单位、性别、半区、备注，再点击“逐个增加”按钮即可生成一条规则到批量导入栏中。</p>
	<p># 填写：总人数、姓名模式（姓名前缀+自动数字+姓名后缀）、每队人数、单位总数、单位名称模式（单位前缀+自动数字+单位后缀），点击“快速模式化录入”按钮，此操作会先清空批量导入栏中的数据再写入（注意）</p>
	<p># 当批量导入栏中的数据确定好后，点击“完成增加导入”，再点击“提交保存”，新增选手信息才上传服务器进行保存</p>
	<p># 如果你想清空本次比赛的所有选手的信息，可以使用“清空已存选手”，一旦执行不可恢复！</p>
	<p># 如果想修改选手信息，请点击“查看/编辑已录选手信息”按钮进入选手管理页面，</p>
	<p># 原则上非单位的选手，单位名称不要与其他的相同，可以是“个人+数字”的形式；因为如果设置禁止同队相遇的话，只以单位名称来辨别是否同队</p>
	-->
	</td>
  </tr>
  <tr>
	<td colspan="2">
	 
		<table width="100%" height="46px" title="增加完成后不自动保存，还需点击[完成]，再[提交保存]">
			<tr>	
			    <td width="20px"></td>
				<td>
				序号<br /><input type="text" value="" size="3" name="xuhao"/>	</td>
				<td>
				姓名<br /><input type="text" value="" size="16" name="name"/></td>
				<td>
				单位<br /><input type="text" value="" size="16" name="danwei"/></td>
				<td>性别<br />
				  <select name="sex">
				    <option value="0">男</option>
				    <option value="1">女</option>
			      </select>    </td>
				<td>半区<br />
				  <select name="banqu">
				    <option selected="selected" value="0">不区分</option>
				    <option value="1">上半区</option>
				    <option value="2">下半区</option>
			      </select>	
			    </td>
				<td>备注<br /><input type="text" value="" size="10" name="beizhu"/></td>
			    <td>操作<br />
			    <input type="button" value="逐个增加" onclick="xszhuzeng(this)"/>
			    <!--增加：数据按格式写入批量录入框内，序号自动增1，姓名清空-->
			    <script type="text/javascript" language="javascript">
			    //逐个增加录入选手
			    function xszhuzeng(thisDOM) {
			    	if(document.getElementsByName("name")[0].value) {
				    	xuhaoz=document.getElementsByName("xuhao")[0].value;
				    	namez=document.getElementsByName("name")[0].value;
				    	danweiz=document.getElementsByName("danwei")[0].value;
				    	sexz=document.getElementsByName("sex")[0].value;
				    	banquz=document.getElementsByName("banqu")[0].value;
				    	beizhuz=document.getElementsByName("beizhu")[0].value;
				    	
				    	xsinfo=String(xuhaoz)+','+namez+','+danweiz+','+sexz+','+banquz+','+beizhuz+';\n';
				    	document.getElementById("xuanshoudaoru").value=xsinfo+document.getElementById("xuanshoudaoru").value;
				    	document.getElementsByName("xuhao")[0].value++;
				    	document.getElementsByName("name")[0].value="";
				    	document.getElementsByName("name")[0].focus () ;
			    	}else{
			    		alert('姓名不能为空！');
			    	}
			    }
			    </script>
			    </td>
			    <td width="20px"></td>
			  </tr>
		 </table>
	</td>
  </tr>
   <tr>
	<td colspan="2" style="padding:8px 0;">总人数:<input id="zongrenshu" type="text" value="16" size="3"/>&nbsp;&nbsp;
	    姓名模式:<input id="nameqian" type="text" value="选手" size="3"/>数字<input id="namehou" type="text" value="选手" size="3"/>&nbsp;&nbsp;
	    每队人数:<input id="meiduirenshu" type="text" value="1" size="3"/>&nbsp;&nbsp;
	    单位数:<input id="danweishu" type="text" value="16" size="3"/>&nbsp;&nbsp;
	    单位模式:<input id="danweiqian" type="text" value="单位" size="3"/>数字<input id="danweihou" type="text" value="单位" size="3"/>
	    <br>
		<input type="button" value="快捷模式化录入" onclick="moshiluru(this)" />
	<script type="text/javascript" >
	//快捷模式化录入
	function moshiluru (thisdom) {
		zongrenshuV=document.getElementById('zongrenshu').value;
		nameqianV=document.getElementById('nameqian').value;
		namehouV=document.getElementById('namehou').value;
		
		meiduirenshuV=document.getElementById('meiduirenshu').value;
		danweishuV=document.getElementById('danweishu').value;
		danweiqianV=document.getElementById('danweiqian').value;
		danweihouV=document.getElementById('danweihou').value;
		
		lie='';
		k=1;
		//计算总共有多少单位是足人数，其余均为一人的单位
		zudanweiren=Math.round((zongrenshuV-danweishuV)/(meiduirenshuV-1))*meiduirenshuV;
//alert(zudanweiren);
		if (zudanweiren!='NaN') {  //有效
			for (i=1;i<=zongrenshuV;i++) {
				if (zudanweiren>0) {
					lie+=String(i)+','+nameqianV+''+String(i)+''+namehouV+','+danweiqianV+''+String(k)+''+danweihouV+';\n';
					if (i%meiduirenshuV==0) {
						k++;
					} 
//alert(i%meiduirenshuV);
				} else {
					lie+=String(i)+','+nameqianV+''+String(i)+''+namehouV+','+danweiqianV+''+String(k)+''+danweihouV+';\n';
					k++;
				}
				zudanweiren--;
			}
		} else {
			lie+=String(i)+','+nameqianV+''+String(i)+''+namehouV+','+danweiqianV+''+String(i)+''+danweihouV+';\n ';
		}
		//document.getElementById('xuanshoudaoru').innerHTML=lie;  //必须使用value才可以体现\n换行！
		document.getElementById('xuanshoudaoru').value=lie;
	}
	</script>
	</td>
  </tr>
   <tr>
	<td colspan="2" style="padding:8px 0;">
	<input type="button" style="color:red" value="清空已存选手" title="一次删除已存在的所有选手" onclick="javascript:if(confirm('删除已存在的所有选手？删除后不可恢复，请慎用')) {
			location.href='/bp/user/xsgl.php?bsid=<?php echo $_GET['bsid'];?>&action=qingkong';
			}"/>
	     &nbsp;&nbsp;
	     <input id="reset" type="reset" value="重置" onclick="chongzhi()"/>
	     &nbsp;&nbsp;
	     <input style="color:green;font-weight:bold" id="wancheng" type="button" value="完成增加导入" onclick="daoru(this)"/>
	     &nbsp;=>&nbsp;
	     <input type="hidden" name="xuanshouluru" id="xuanshouluru" value=""/>
	     <input name="tijiao" id="submit" type="submit" value="提交保存" disabled="disabled" />&nbsp;&nbsp;&nbsp;
	     <input style="color:blue;" type="button" value="查看/编辑已录选手信息" onclick="javascript:location.href='xsgl.php?bsid=<?php echo $_GET['bsid'];?>'">
	</td>
  </tr>
  <tr>
	<td colspan="2">
	     <?php echo $xuhaoliebiao;?>
	</td>
  </tr>
</table>
</form>
