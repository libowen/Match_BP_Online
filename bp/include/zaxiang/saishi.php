<!--显示界面：我的赛事，个人创建的比赛：显示列表，有编辑跳转按钮（跳转）和删除按钮（需再次确定）；-->
<style type="text/css">
<!--
.Lssliebiao th{
	padding: 4px 0px; 
}
.Lssliebiao .hangtr td {
	border-bottom:3px double #999999;
	padding: 3px 0px; 
}
.Lssliebiao {
	border-color:#DDDDDD;
}

-->
</style>
<table border="1" class="Lssliebiao" width="100%">
	  <tr>
	    <th width="30" scope="col">编号</th>
	    <th width="auto" scope="col">标题</th>
	    <th width="60" scope="col">项目</th>
	    <th width="60" scope="col">组别</th>
	    <th width="88" scope="col">比赛地点</th>
	    <th width="72" scope="col">比赛时间</th>
	    <th width="60" scope="col">编排类型</th>
<!--	    <th width="30" scope="col">轮数</th>-->
	    <th width="72" scope="col">创建日期</th>
	    <th width="100" scope="col">
	    <a style="font-size:14px;" href="#" title="编辑赛事的基本信息或删除指定赛事">操作</a>
	    </th>
	  </tr>
         <?php //echo $bisaisliebiao;?>
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
		    <td title="点击进行表格输出。比赛备注：<?php echo $value['bs_beizhu'];?>"><a target="_blank"  href="sczb.php?bsid=<?php echo $value['bs_id'];?>"><?php echo $value['bs_id'];?></a></td>
		    <td title="点击进行比赛编排。"><a target="_blank"  href="bianpai.php?bsid=<?php echo $value['bs_id'];?>"><?php echo $value['bs_biaoti'];?></a></td>
		    <td><?php echo $BSxiangmu;?></td>
		    <td><?php echo $value['bs_zubie'];?></td>
		    <td><?php echo $value['bs_didian'];?></td>
		    <td><?php echo $value['bs_shijian'];?></td>
		    <td title="总轮数：<?php echo $value['bs_zonglunshu'];?>    管理员：<?php echo $value['bs_luruyuan'];?>"><?php echo $BPleixing;?></td>
<!--		    <td><?php echo $value['bs_zonglunshu'];?></td>-->
		    <td title=" 管理员：<?php echo $value['bs_luruyuan'];?>"><?php echo $value['bs_jianliriqi'];?></td>
		    <td><nobr>
			    <a target="_blank"  title="修改比赛的基本信息，编排配置信息" href="?bsid=<?php echo $value['bs_id'];?>">配置</a>&nbsp;
			    <a target="_blank"  title="比赛参赛选手的录入、修改序号、犯规次数、指定退赛、删除等" href="xsgl.php?bsid=<?php echo $value['bs_id'];?>">选手</a>&nbsp;
			    <a  title="删除本比赛，不可恢复。点击后有提示，此时如不想删除还可以点击取消" style="color:red;" href="#" onclick='javascript:if(confirm("删除比赛【<?php echo $value['bs_id'];?>】《<?php echo $value['bs_biaoti'];?>》")){location.href="?bsid=<?php echo $value['bs_id'];?>&&action=shanchu"}'>删除</a>
			    </nobr>
			    <br />
			    <a target="_blank"  title="对本比赛进行登分，默认进行当前轮登分，或显示当轮已保存的成绩结果（未保存下轮的编排结果时）" href="dengfen.php?bsid=<?php echo $value['bs_id'];?>">登分</a>&nbsp;
			    <a target="_blank"  title="对本比赛进行编排，默认进行下轮编排，或显示当轮已保存的编排结果（未录入成绩时）" href="bianpai.php?bsid=<?php echo $value['bs_id'];?>">编排</a>&nbsp;
			    <a target="_blank"  title="各式表格的输出，可先进行相关配置" href="sczb.php?bsid=<?php echo $value['bs_id'];?>">制表</a>
		    </td>
		  </tr>
	<?php					
		}
	}else{
	?>
	  <tr><td colspan="10">你还没有创建任何赛事，请点击 <a target="_blank"  href="xinjian.php">新建赛事</a> 进行创建</td></tr>
	<?php
	}
	?>
	  <tr>
	   	 <td colspan="10">&nbsp;<?php echo $fenye;?></td>
	  </tr>
	  <tr>
		    <td colspan="10">
			    <form name="form_chaxun" method="post" action="">									
				<table border="1" width="100%">
		          <tr>
		            <td>标题(1个词)</td>
		            <td><input type="text" name="biaoti"  size="26" /></td>
		            <td>_____(1个词)</td>
		            <td><input name="" type="text" size="12" /></td>
		            <td>项目</td>
		            <td>
		             <select name="BSxiangmu">
					  <option value="0" selected>全部</option>
					  <option value="1">中国象棋</option>
					  <option value="2">国际象棋</option>
					  <option value="3">围棋</option>
					  <option value="4">五子棋</option>
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
		              这里只能查询自己创建的比赛！
		              &nbsp;&nbsp;
		              <a target="_blank"  href="saishi.php" style="font-size:14px;color:blue;">显示全部</a>&nbsp;&nbsp;
					  <input type="submit" name="tijiao" value="查询" />&nbsp;&nbsp;&nbsp;&nbsp;
		              <input type="reset" name="reset" value="重置" />
					</td>
		            </tr>
		        </table>
				</form>
		    </td>
	  </tr>
</table>


