<!--查询恢复：恢复前x轮的编排结果，主要是解决当编排结果不满意又意外保存了编排结果时，回复到前面轮次的编排结果。可选择是否保留那轮的成绩-->
<style type="text/css">
<!--
.cxhf {
	margin:0px auto;
}
.cxhf table {
	border-color:#DDDDDD;
	margin:0px auto;
	width:660px;
}
.cxhf th {
	background-color:#CCCCCC;
	font-size:18px;
	padding:5px 0px;
}
.cxhf td {
	padding:5px 0px;
}



-->
</style>

<table class="cxhf" border="0" cellspacing="0" cellpadding="0">
  <tr>
	  <td height="8px">
	  </td>
  </tr>
  <tr>
    <td>		
			<form method="post" action="">
				<table border="1" class="huifutable">
				  <tr>
					<th colspan="2">
						恢复&nbsp;到指定轮次
					</th>
				  </tr>
			  	  <tr>
					<td colspan="2">
					<?php 
					//还要找出本轮是第几轮的，但是不一定是[0]，所以还要遍寻
					if (!$xuanshous[1]) {
						  $user=new USER();
						  $bsid=$_GET['bsid'];
						  $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
					}
						$zuiduokey=0;
						$zuiduoshu=0;
						foreach ($xuanshous as $key => $value) {
							//寻找towhos个数最多的项，不能是fenshus，
							if (substr_count($value['xs_towhos'],',')>$zuiduoshu) {
								$zuiduoshu=substr_count($value['xs_towhos'],',');
								$zuiduokey=$key;
							}
						}
						$dijilun=substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2;        //当前进行录入前或保存的后的轮次
				        $fenshulun=substr_count($xuanshous[$zuiduokey]['xs_fenshus'],',')/2;   
						$xuanshous[0]=$xuanshous[$zuiduokey];
					//////////////////////////////////////////////////
					?>
					  赛事预设总轮数：<?php echo $bsinfo['bs_zonglunshu'];?> 轮&nbsp;&nbsp;
					  目前共 <?php echo substr_count($xuanshous[0]['xs_towhos'],',')/2;?> 轮&nbsp;&nbsp;
					  当轮成绩<?php 
					          //[0]不一定就是标准号！？
							  if (substr_count($xuanshous[0]['xs_towhos'],',')==substr_count($xuanshous[0]['xs_fenshus'],',')
							    &&substr_count($xuanshous[0]['xs_fenshus'],',')) {
								echo '已';
							  }else{
								echo '未';
							  } ?>录入
					</td>
				  </tr>
				  <tr>
					<td colspan="2">
							恢复到前
							<input type="text" name="zonglunshu" size="3">轮&nbsp;(整数，空无效)
					</td>
				  </tr>
				  <tr>
					<td colspan="2">
							保留成绩
							<input type="checkbox" name="chengji" value="1" checked>
							(不打勾则不保留)
					</td>
				  </tr>
				  <tr>
					<td colspan="2" align="center">
					    <input name="tijiao" type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;
					    <input name="reset" type="reset" value="重置">
					</td>
				  </tr>
			  	  <tr>
					<td colspan="2">
					 指定选手退赛、犯规记录都无法同过此方法恢复，请到
					 <a href="xsgl.php?bsid=<?php echo $_GET['bsid'];?>" style="font-size:14px;color:blue;">修改选手信息页面</a>
					 另外设置
					</td>
				  </tr>
				</table>
			</form>
			<hr>
	    </td>
	</tr>
	<tr>
		<td>
		
			<table id="chaxunbp" border="1" cellpadding="0" cellspacing="0">
			  <tr>
				<th colspan="3" scope="col" >编排纪录（对阵）详细参数&nbsp;查询</th>
			  </tr>
			  <tr>
				<td>比赛ID：
			    	<input id="bp_bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="5" maxlength="8" />
			    </td>
				<td>轮次：
			    	<input id="bp_dijilun" title="留空，默认是当前轮" type="text" value="" size="5" maxlength="8" />
			    </td>
				<td>
					<input type="button" value="查询" onclick="chaxun('chaxunbp',1)" />
				</td>
			  </tr>
			</table>
		<hr>
		</td>
	</tr>
	<tr>
		<td>
			<table border="1" cellspacing="0" cellpadding="0">
			  <tr>
			    <th colspan="7" scope="col">选手详细信息和技术统计  查询</th>
			  </tr>
			  <tr>
			    <td>比赛ID</td>
			    <td><input id="xs_bsid" type="text" value="<?php echo $_GET['bsid'];?>" size="8" /></td>
			    <td>选手序号</td>
			    <td>
				<input type="text" value="" size="8" id="xs_xuhao"/></td>
			
			    <td>选手姓名</td>
			    <td><input type="text" value="" size="18" id="xs_name"/></td>
			    <td width="130">
			    	<input type="button" value="查询" onclick="chaxun('chaxunxs',1)"/>
			    </td>
			  </tr>
			</table>
		<hr>
		</td>
	</tr>
</table>

<script type="text/javascript" >
function chaxun(leixing,target) {
	url=location.href;
	newurl='';
	switch (leixing) {
		case 'chaxunbp':
		//fanwei=document.getElementById('chaxunbp');
		//bsid=fanwei.getElementsByName('bsid')[0].value;
		bsid=document.getElementById('bp_bsid').value;
		dijilun=document.getElementById('bp_dijilun').value;
		url='/bp/user/xiugaibp.php?bsid='.concat(bsid).concat('&lunci=').concat(dijilun);
			break;
		case 'chaxunxs':
		bsid=document.getElementById('xs_bsid').value;
		xsxuhao=document.getElementById('xs_xuhao').value;
		xsname=document.getElementById('xs_name').value;
		url='/bp/user/xuanshou.php?bsid='.concat(bsid).concat('&xsxuhao=').concat(xsxuhao).concat('&name=').concat(xsname);
			break;
		case 'chaxuncj':
		
			break;
		case 'chaxunzh'://综合
		
			break;
		default:
		
			break;		
	}
	newurl=url;
	if (target) { //新窗口
		window.open(newurl);
	} else {  //本窗口
		location.href=newurl;
	}
}


</script>