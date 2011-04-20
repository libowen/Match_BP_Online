<style type="text/css">
<!--
/* 赛事列表table */
.Lssliebiao th{
	padding: 4px 0px; 
}
.Lssliebiao .hangtr td {
	border-bottom:3px inset #999999;
	padding: 3px 0px; 
}
.Lssliebiao {
	border-color:#DDDDDD;
	width:auto;  /* 配合这个IE6和FF的显示才一样：div内全显示 */
	margin:0px auto;
	background-color:white;
}

/* 收藏赛事的列表的外框 */
.shoucangliebiao {
	/* border:medium double blue; */
	width:100%;
	height:auto;
	overflow:auto;
}

.bsid {
	font-weight:bold;
}

/* 删除收藏比赛的按钮的样式 */
.yichucang {
	width:25px;
	text-align:center;
	font-size:14px;
	margin:0px;
	padding:0px;
}
.yichucang:hover {
	color:blue;
}

/* 查询填表的样式 */
form table td,form table th {
	border-color:#666666;
}
-->
</style>
<script type="text/javascript">
/* 收藏的处理js */
function cang (thisdom,bsid) {
	thisdom.parentNode.parentNode.style.backgroundColor="gold";
	window.open("/bp/user/shoucang.php?action=cang&bsid=".concat(bsid));
}
function yichucang (thisdom,bsid) {
	thisdom.parentNode.parentNode.style.backgroundColor="#DDDDDD";
	window.open("/bp/user/shoucang.php?action=yichu&bsid=".concat(bsid));
}
</script>
<div style="background-color:#F9F9F9;width:99%">
		<div class="shoucangliebiao">
		<table border="1" class="Lssliebiao">
			  <tr>
			    <th width="36" scope="col">编号</th>
			    <th width="auto" scope="col">标题</th>
			    <th width="60" scope="col">项目</th>
			    <th width="60" scope="col">组别</th>
			    <th width="88" scope="col">比赛地点</th>
			    <th width="72" scope="col">比赛时间</th>
			    <th width="60" scope="col">编排类型</th>
		<!--	    <th width="30" scope="col">轮数</th>-->
			    <th width="72" scope="col">创建日期</th>
			    <th width="118" scope="col" colspan="2">
			    <a target="_blank"  style="font-size:14px;" href="#" title="查看赛事的基本信息或收藏指定赛事">操作</a>
			    </th>
			  </tr>
		<?php
			if ($bisais[0]) {
				foreach ($bisais as $key => $value) {
						$BSxiangmu='';
						$BPleixing='';
						switch ($value['bs_BSxiangmu']){
							case 1:
							$BSxiangmu='中国象棋';	
							 break;
							case 2:
							$BSxiangmu='国际象棋';	
							 break;
							case 3:
							$BSxiangmu='围棋';	
							 break;
							case 4:
							$BSxiangmu='五子棋';	
							 break;
							case 5:
							$BSxiangmu='其它';	
							 break;
							default:
							$BSxiangmu='中国象棋';
							 break;
						}
						switch ($value['bs_BPleixing']){
							case 1:
							$BPleixing='积分编排';	
							 break;
							case 2:
							$BPleixing='大循环';	
							 break;
							case 3:
							$BPleixing='单淘汰';	
							 break;
							case 4:
							$BPleixing='双淘汰';	
							 break;
							case 5:
							$BPleixing='积分末位淘汰';	
							 break;
							default:
							$BSxiangmu='积分编排';
							 break;
						}
		?>
			     <tr class="hangtr">
				    <td class="bsid" title="点击进行表格输出。比赛备注：<?php echo $value['bs_beizhu'];?>"><a target="_blank"  href="/bp/user/sczb.php?bsid=<?php echo $value['bs_id'];?>"><?php echo '[',$value['bs_id'],']';?></a></td>
				    <td title="点击进行比赛编排。"><a target="_blank"  href="/bp/user/bianpai.php?bsid=<?php echo $value['bs_id'];?>"><?php echo $value['bs_biaoti'];?></a></td>
				    <td><?php echo $BSxiangmu;?></td>
				    <td><?php echo $value['bs_zubie'];?></td>
				    <td><?php echo $value['bs_didian'];?></td>
				    <td><?php echo $value['bs_shijian'];?></td>
				    <td title="总轮数：<?php echo $value['bs_zonglunshu'];?>"><?php echo $BPleixing;?></td>
		<!--		    <td><?php echo $value['bs_zonglunshu'];?></td>-->
				    <td title=" 管理员：<?php echo $value['bs_luruyuan'];?>"><?php echo $value['bs_jianliriqi'];?></td>
				    <td><nobr>
					    <a target="_blank"  title="修改比赛的基本信息，编排配置信息" href="/bp/user/saishi.php?bsid=<?php echo $value['bs_id'];?>">配置</a>&nbsp;
					    <a target="_blank"  title="比赛参赛选手的录入、修改序号、犯规次数、指定退赛、删除等" href="/bp/user/xsgl.php?bsid=<?php echo $value['bs_id'];?>">选手</a>
					    </nobr>
					    <br />
					    <a target="_blank"  title="对本比赛进行编排，默认进行下轮编排，或显示当轮已保存的编排结果（未录入成绩时）" href="/bp/user/bianpai.php?bsid=<?php echo $value['bs_id'];?>">编排</a>&nbsp;
					    <a target="_blank"  title="各式表格的输出，可先进行相关配置" href="/bp/user/sczb.php?bsid=<?php echo $value['bs_id'];?>">制表</a>
				    </td>
				    <td>
				    	<input class="yichucang" type="button" value="删" onclick="yichucang(this,<?php echo $value['bs_id'];?>)" />
				    </td>
				  </tr>
			<?php					
				}
			}else{
			?>
			  <tr>
			  <td colspan="11">
			  	<h4>
			  	你还没有创建任何赛事，请点击 <a target="_blank"  href="/bp/user/xinjian.php">新建赛事</a> 进行创建
			  	</h4>
		  	  </td>
			  </tr>
			<?php
			}
			?>
		</table>
		</div>   
		<hr><form name="form_chaxun" method="post" action="/bp/index.php">									
				<table border="1" width="100%">
				 <tr>
				   	 <th colspan="6">查询</th>
				  </tr>
				
		          <tr>
		            <td>标题(1个词)</td>
		            <td><input type="text" name="biaoti"  size="26" /></td>
		            <td>管理员(精确)</td>
		            <td><input name="luruyuan" type="text" size="12" /></td>
		            <td>项目</td>
		            <td>
		             <select name="BSxiangmu">
					  <option value="0" selected>全部</option>
					  <option value="1">中国象棋</option>
					  <option value="2">国际象棋</option>
					  <option value="3">围   棋</option>
					  <option value="4">五 子 棋</option>
					  <option value="5">其它等等</option>
					</select>
		            </td>
		          </tr>
		          <tr>
		            <td>录入日期(时间段)</td>
		            <td><input name="jianliriqi1" type="text" size="10" value="2010-05-05" />
		              到
		              <input name="jianliriqi2" type="text" size="10" value="2012-06-07" /></td>
		            <td>比赛地点(1个词)</td>
		            <td><input name="didian" type="text" size="12" /></td>
		            <td>比赛时间(1个词)</td>
		            <td><input name="shijian" type="text" size="12" /></td>
		          </tr>
		          <tr>
		            <td>性质(1个词)</td>
		            <td><input name="xingzhi" type="text" size="26" /></td>
		            <td>裁判员</td>
		            <td><input name="caipanyuan" type="text" size="12" />
		            <td>编排员</td>
		            <td><input name="bianpaiyuan" type="text" size="12" /></td>
		          </tr>
		          <tr>
		            <td colspan="6">
					  <input type="submit" name="tijiao" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;
		              <input type="reset" name="reset" value="重置" />
					</td>
		            </tr>
		        </table>
				</form>
</div>	