<!--修改比赛页面的显示内容，同时也是新建赛事的显示界面了-->
<style type="text/css">
#bisaipeizhi_form {
}
#bisaipeizhi_form td{
padding:5px 0px;
font-size: 14px;
}
#bisaipeizhi_form select,#bisaipeizhi_form input {
text-align:center;
font-size:14px;
}

</style>
<form id="bisaipeizhi_form" class="bisaipeizhi_form" action="" method="post">
	<table border="1" class="Lxinjian" > 
		<tr> 
				<td>*赛事标题</td> 
				<td colspan="5" class="biaoti">
				  《<input type="text" size="50" value="<?php echo $bsinfo['bs_biaoti'],'"'; echo $bsinfo?'disabled':'name="biaoti"';?>/>》
				</td> 
		</tr> 
		<tr> 
				<td width="13%">组别</td> 
				<td width="20%"><input name="zubie" type="text" value="<?php echo $bsinfo['bs_zubie'];?>" size="14"/></td> 
				<td width="13%">比赛地点</td> 
				<td width="20%"><input name="didian" type="text" value="<?php echo $bsinfo['bs_didian'];?>" size="14"/></td> 
				<td width="14%">比赛时间</td> 
				<td width="20%"><input name="shijian" type="text" value="<?php echo $bsinfo['bs_shijian'];?>" size="14"/></td> 
		</tr> 
		<tr> 
				<td>性质</td> 
				<td><input name="xingzhi" type="text" value="<?php echo $bsinfo['bs_xingzhi'];?>" size="14"/></td> 
				<td>裁判长</td> 
				<td><input name="caipanzhang" type="text" value="<?php echo $bsinfo['bs_caipanzhang'];?>" size="14"/></td> 
				<td>编排员</td> 
				<td><input name="bianpaiyuan" type="text" value="<?php echo $bsinfo['bs_bianpaiyuan'];?>" size="14"/></td> 
		 </tr> 
		 <tr>
				<td>项目</td>
				<td>
					<select name="BSxiangmu">
					  <option value="1" <?php $bsinfo['bs_BSxiangmu']==1?print('selected'): '';?>>中国象棋</option>
					  <option value="2" <?php $bsinfo['bs_BSxiangmu']==2?print('selected'): '';?>>国际象棋</option>
					  <option value="3" <?php $bsinfo['bs_BSxiangmu']==3?print('selected'): '';?>>围   棋</option>
					  <option value="4" <?php $bsinfo['bs_BSxiangmu']==4?print('selected'): '';?>>五 子 棋</option>
					  <option value="5"  <?php $bsinfo['bs_BSxiangmu']==5?print('selected'): '';?>>其它等等</option>
					</select>					    </td>
				<td>赛制</td>
				<td><select name="saizhi">
				  <option value="1" <?php $bsinfo['bs_saizhi']==1?print('selected'): '';?>>个人团体混合</option>
				  <option value="2" <?php $bsinfo['bs_saizhi']==2?print('selected'): '';?>>个人赛</option>
				  <option value="3" <?php $bsinfo['bs_saizhi']==3?print('selected'): '';?>>团体赛</option>
				</select></td>
				<td>编排类型</td>
				<td title="注意：目前系统只考虑积分编排，其他方式暂不支持！">
					<select name="BPleixing">
						  <option value="1" <?php $bsinfo['bs_BPleixing']==1?print('selected'): '';?>>积分编排</option>
<!--						  <option value="2" <?php $bsinfo['bs_BPleixing']==2?print('selected'): '';?>>大循环</option>-->
<!--						  <option value="3" <?php $bsinfo['bs_BPleixing']==3?print('selected'): '';?>>单淘汰</option>-->
<!--						  <option value="4" <?php $bsinfo['bs_BPleixing']==4?print('selected'): '';?>>双淘汰</option>-->
<!--						  <option value="5" <?php $bsinfo['bs_BPleixing']==5?print('selected'): '';?>>积分末位淘汰</option>-->
					</select>
			    </td>
		  </tr>
		  <tr>
					<td>总轮数</td>
					<td><input name="zonglunshu" type="text" value="<?php echo $bsinfo?$bsinfo['bs_zonglunshu']:'9';?>" size="4"/></td>
					<td>局分模式</td>
					<td>
					<input name="jufenmoshi" title="局分模式：比赛采用的分制，以英文冒号分隔，分别对应——先手胜、和、负，后手胜、和、负。共6项，小数只支持1:0.5:0:1:0.5:0！！整数无限制" onfocus="tianxie(this)" type="text" value="<?php echo $bsinfo['bs_jufenmoshi']; echo $bsinfo?'':'2:1:0:2:1:0';?>" size="16"/>
					<!--<select name="jufenmoshi">
						  <option value="2:1:0:2:1:0" <?php $bsinfo['bs_jufenmoshi']=='2:1:0:2:1:0'?print('selected'): '';?>> 2:1:0:2:1:0 </option>
						  <option value="3:1:0:3:2:0" <?php $bsinfo['bs_jufenmoshi']=='3:1:0:3:2:0'?print('selected'): '';?>> 3:1:0:3:2:0 </option>
						  <option value="1:0.5:0:1:0.5:0" <?php $bsinfo['bs_jufenmoshi']=='1:0.5:0:1:0.5:0'?print('selected'): '';?>>1:0.5:0:1:0.5:0</option>
						</select>	-->																													</td>
					<td>先后手</td>
					<td>
					<select name="PHxianhou">
					  <option value="1" <?php $bsinfo['bs_PHxianhou']==1?print('selected'): '';?>>平衡先后手</option>
					  <option value="2" <?php $bsinfo['bs_PHxianhou']==2?print('selected'): '';?>>.自然调节法.</option>
					</select>				</td>
		  </tr>
		  <tr>
					<td colspan="2">连续弃权
					  <input name="lianqi" type="text" value="<?php echo $bsinfo?$bsinfo['bs_lianqi']:'2';?>" size="3">
					  轮不编排</td>
					<td colspan="2" title="中间必须是小写字母“x”">第
					  X
					  轮未得
					  Y
					  分淘汰&nbsp;XxY=<input name="dilunfen" type="text" value="<?php echo $bsinfo?$bsinfo['bs_dilunfen']:'0x0';?>" size="6"></td>
					<td colspan="2" title="中间必须是小写字母“x”">前
					  X
					  轮得
					  Y
					  分不排&nbsp;XxY=<input name="qianlunfen" type="text" value="<?php echo $bsinfo?$bsinfo['bs_qianlunfen']:'0x0';?>" size="6"></td>
		  </tr>
		  <tr>
					<td colspan="2">首轮配对模式
						<select name="peiduimoshi">
						  <option value="3" <?php $bsinfo['bs_peiduimoshi']==3?print('selected'): '';?>>拦腰配对</option>
						  <option value="1" <?php $bsinfo['bs_peiduimoshi']==1?print('selected'): '';?>>临近配对</option>
						  <option value="2" <?php $bsinfo['bs_peiduimoshi']==2?print('selected'): '';?>>首尾配对</option>
						  <option value="4" <?php $bsinfo['bs_peiduimoshi']==4?print('selected'): '';?>>随机配对</option>
						  <option value="5" <?php $bsinfo['bs_peiduimoshi']==5?print('selected'): '';?>>上下半区</option>
						</select>				</td>
					<td colspan="2">首轮
						<select name="xianhoumoshi" title="第一轮先后手模式，不选则保持默认为——根据所选配对模式的默认先后">
						  <option title="根据所选配对模式的默认先后" value="11" <?php $bsinfo['bs_xianhoumoshi']==11?print('selected'): '';?>>-首轮先后手模式-</option>
						  <option value="1" <?php $bsinfo['bs_xianhoumoshi']==1?print('selected'): '';?>>上半区先，下半区后</option>
						  <option value="2" <?php $bsinfo['bs_xianhoumoshi']==2?print('selected'): '';?>>台号单小号先，双大号先</option>
						  <option value="3" <?php $bsinfo['bs_xianhoumoshi']==3?print('selected'): '';?>>单数序号先，双数序号后</option>
						  <option value="4" <?php $bsinfo['bs_xianhoumoshi']==4?print('selected'): '';?>>抽签决定，或者竞猜</option>
						  <option value="5" <?php $bsinfo['bs_xianhoumoshi']==5?print('selected'): '';?>>上半区后，下半区先</option>
						  <option value="6" <?php $bsinfo['bs_xianhoumoshi']==6?print('selected'): '';?>>台号单小号后，双大号先</option>
						  <option value="7" <?php $bsinfo['bs_xianhoumoshi']==7?print('selected'): '';?>>单数序号后，双数序号先</option>
						  <option value="8" <?php $bsinfo['bs_xianhoumoshi']==8?print('selected'): '';?>>全部小号先</option>
						  <option value="9" <?php $bsinfo['bs_xianhoumoshi']==9?print('selected'): '';?>>全部大号先</option>
						  <option value="10" <?php $bsinfo['bs_xianhoumoshi']==10?print('selected'): '';?>>1-2,4-3,5-6,8-7</option>
						</select>				</td>
					<td colspan="2">后三轮配对优先平衡条件
					  <input title="后三轮配对后，优先平衡多？分（含）一方的先后走" name="chafengaoping" type="text" value="<?php echo $bsinfo?$bsinfo['bs_chafengaoping']:'0.5';?>" size="3">
					分			
					</td>
		  </tr>
		  <tr>
					<td colspan="6">&nbsp;&nbsp;同队不相遇
					  <input type="checkbox" name="TTbuyu" value="1" <?php $bsinfo['bs_TTbuyu']==1?print('checked'): ''; echo $bsinfo?'':'checked';?>>
					 &nbsp;&nbsp;调整上下调：
					  <input type="checkbox" name="SXtiao" value="1" <?php $bsinfo['bs_SXtiao']==1?print('checked'): ''; echo $bsinfo?'':'checked';?>>
					 &nbsp;&nbsp;&nbsp;禁3先/后：
					 <input type="checkbox" name="Jliansan" value="1" <?php $bsinfo['bs_Jliansan']==1?print('checked'): ''; echo $bsinfo?'':'checked';?>>
					 &nbsp;&nbsp;&nbsp;因淘汰轮空补小分
					 <input type="checkbox" name="kongbufen" value="1" <?php $bsinfo['bs_kongbufen']==1?print('checked'): ''; echo $bsinfo?'':'checked';?>> 
					 &nbsp;&nbsp;&nbsp;过关补小分
					 <input type="checkbox" name="guobufen" value="1" <?php $bsinfo['bs_guobufen']==1?print('checked'): ''; echo $bsinfo?'':'checked';?>>
					 <hr style="color:blue; height:2px; width:90%">
					 </td>
		  </tr>
	      <tr>
			  <td colspan="2">个人排名模式 
	          <input title="双击打开高级填写模式和详细说明。  代号说明：A 对手分（所对弈过的全部对手的积分之和）；B 累进分（每轮积分相加总和）；C 胜局；D 犯规；E 后胜局（后手胜局）；F 后手局（后手局数）；G 先手胜局；H 直胜局（只比较仅有两人同分的情况）；I 胜手和（所胜对手积分之和）；J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；" 
						 name="grpm_moshi" type="text" value="<?php echo $bsinfo['bs_grpm_moshi']; echo $bsinfo?'':'ACDEF';?>" size="12" onfocus="tianxie(this)" />
	          
	          </td>	          
			  <td colspan="2">个人名次计算
				  <select name="GRpaiming">
		            <option value="1">-个人名次计算-</option>
		            <option value="1" <?php $bsinfo['bs_GRpaiming']==1?print('selected'): '';?>>小分不转化为大分</option>
		            <option value="2" <?php $bsinfo['bs_GRpaiming']==2?print('selected'): '';?>>小分转化为大分</option>
		          </select>
	          </td>
			  <td colspan="2">轮空模式
				  <select name="lunkongmoshi" title="当有需轮空时的轮空选手确定准则：未曾轮空过的最低分项；最低分项中的轮空次数最少的项">
		            <option value="0" title="默认是：未曾轮空过的最低分">--轮空模式--</option>
		            <option value="0" <?php $bsinfo&&$bsinfo['bs_lunkongmoshi']==0?print('selected'): '';?>>未曾轮空过的最低分</option>
		            <option value="1" <?php $bsinfo['bs_lunkongmoshi']==1?print('selected'): '';?>>最低分中轮空最少的</option>
		          </select>
	          </td>
		  </tr>
	          <tr>
	          <td colspan="4">
	          以上未区分名次，则从
		      <select name="dir" title="推荐：累进分模式选 首轮；对手分模式选 末轮。累进分-扣除第一轮积分，还相同、再扣除第二轮，依此类推；对手分-比较倒数第二轮积分，依此类推">
                <option value="1" <?php echo $bsinfo['bs_dir']==1?'selected':'';?>>首轮</option>
                <option value="2" <?php echo $bsinfo['bs_dir']==2?'selected':'';?>>末轮</option>
              </select>
		        起去除一轮积分再判断，以后以此类推
	          </td>
	          <td  colspan="2">
	          空号总分=
   		      <select name="konghaofen" title="计算对手分时，空号的积分指定：本比赛所有选手的最低积分 或 零分">
                <option value="0" <?php echo $bsinfo['bs_konghaofen']<=1?'selected':'';?>>全部计零分</option>
                <option value="1" <?php echo $bsinfo['bs_konghaofen']==1?'selected':'';?>>选手最低分</option>
              </select>
	          </td>
	          </tr>
		  <tr>
				<td colspan="3">团体名次计算
					<select name="TTpaiming">
	                  <option value="1">-团体名次计算的方式-</option>
	                  <option value="1" <?php $bsinfo['bs_TTpaiming']==1?print('selected'): '';?>>按个人名次总和</option>
	                  <option value="2" <?php $bsinfo['bs_TTpaiming']==2?print('selected'): '';?>>按个人积分总和</option>
	                </select>
                </td>
				<td colspan="3">
				   <select name="tongxianhou">
					  <option value="2">-第二轮起先后走序列相同时，先手的确定-</option>
	                  <option value="2" <?php echo $bsinfo['bs_tongxianhou']==2?'"selected"':'';?>>奇数轮小号先行，偶数轮大号先行</option>
	                  <option value="1" <?php echo $bsinfo['bs_tongxianhou']==1?'"selected"':'';?>>两选手号之和，奇数小号先，偶数大号先</option>
	               </select>
                </td>
		  </tr>
		  <tr>
			      <td colspan="2">每队（单位）队员数
			      	<input title="计算团体成绩时，每队（单位）的队员数，实际多的队取最好成绩，实际缺的队可以设置允许排名（缺员的名次也有2种选择）或不。。。" name="duiyuanshu" type="text" value="<?php echo $bsinfo?$bsinfo['bs_duiyuanshu']:4;?>" size="4"/>
		          </td>
			      <td colspan="2">本赛管理密码：
		            <input name="key" title="如设置，其他账号可通过密码管理本比赛（除比赛配置外）的选手、编排信息；留空不设置则禁止此功能"
						 value="<?php echo $bsinfo['bs_key'];?>" size="12" type="text" />
		          </td>
			      <td colspan="2">查看权限
		            <select name="quanxian" title="比赛查看的权限：默认为0公开，1会员可见，100私人可见">
		              <option value="0" <?php echo !$bsinfo['bs_quanxian']?'"selected"':'';?>>公开</option>
		              <option value="1" <?php echo $bsinfo['bs_quanxian']>=1&&$bsinfo['bs_quanxian']<100?'"selected"':'';?>>会员</option>
		              <option value="100" <?php echo $bsinfo['bs_quanxian']>=100?'"selected"':'';?>>私有</option>
		            </select>
		          </td>
	      </tr>
		  <tr> 
					<td>赛事规程<br><500字</td> 
					<td colspan="5">
					  <textarea name="guicheng" cols="100%" rows="3"><?php echo $bsinfo['bs_guicheng'];?></textarea>
					</td> 
		 </tr> 
		 <tr> 
					<td>管理员</td> 
					<td>
						<?php echo $bsinfo?$bsinfo['bs_luruyuan']:$_SESSION['bp_user'];?>
						<?php echo $bsinfo?'<input name="action" type="hidden" value="bianji"/>':'';?>
					</td> 
					<td>创建日期</td> 
					<td><?php echo $bsinfo['bs_jianliriqi']; echo $bsinfo?'':'今天日期'; ?></td> 
					<td>备注</td> 
					<td>
						<input name="beizhu" type="text" value="<?php echo $bsinfo['bs_beizhu'];?>" size="14"/>
					</td> 
		 </tr>
		 <tr> 
					<td colspan="6">
						  <?php echo $bsinfo?'':$message;?>
						  <input type="submit" name="tijiao" value="提交" />			  
						  &nbsp;&nbsp;&nbsp;
						  <input name="reset" type="reset" value="重置" />
				   </td> 
		</tr> 
				  
		 <tr> 
					<td colspan="8" height="3">

<style type="text/css">
<!--

#grpm_div  {
	width:660px;
	height:auto;
	position:absolute;
	left:130px;
	top:130px;
	background-color:white;
	border:8px ridge blue;
	z-index:99999;
	display:none;
}

#grpm_div table {
	border-color:#CCCCCC;
}
/* 整体的字体和内距地控制显示 */
.xiugaibp { width:100%; }
.xiugaibp td,.xiugaibp th{  padding:4px 0px; 	font-size:14px; 	text-align:center; }
.xiugaibp a { font-size:14px; }

/* 行的显示效果  */
.hangtr td { border-bottom:medium double #999999; }
.hangtr:hover { background-color:#ffff99; }

/* 台号的显示样式 */
.taihao {  font-weight:bold;	cursor: pointer; 	cursor: hand; }
.taihao:hover { background-color:#660099; 	color:#FFFFFF; }

/* 序号的显示样式 */
.xuhao {
	color:blue;
	font-weight: bold;
	cursor: hand;
	cursor: pointer;
}
.xuhao:hover { background-color: #0000FF;  color:#FFFFFF; }

-->
</style>
<div class="grpm_div" id="grpm_div" >
<table class="xiugaibp" align="center" border="1">
				  <tbody><tr style="background-color: rgb(245, 245, 245);">
					<th rowspan="2" scope="col" width="36">
					行号					</th>
					<th colspan="3" scope="col">候选破同分选项</th>
					<th rowspan="2" scope="col" width="20">&gt;&gt;</th>
					<th colspan="3" scope="col">当前破同分选项</th>
				  </tr>
				  <tr style="background-color: rgb(245, 245, 245);">
					<td width="240">详细说明</td>
					<td width="70">选项名称</td>
					<td width="36">代号</td>
					
				  	<td width="36">代号</td>
					<td width="70">选项名称</td>
					<td width="240">详细说明</td>
				  </tr>
		  <tr class="hangtr">
							<td id="XS1" onclick="jiaohuan(this)" class="taihao">[1]</td>
							
							<td id="XS1=1=3" class="danwei">其全部对手的积分之和</td>
							<td id="XS1=1=2">
							对手分							</td>
							<td id="XS1=1=1" onclick="jiaohuan(this)" class="xuhao">
								A
							</td>
							
							<td>&nbsp;</td>
							
							<td id="XS1=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
							<td id="XS1=2=2">&nbsp;</td>
	  <td id="XS1=2=3" class="danwei">&nbsp;</td>
				    </tr>
		  <tr class="hangtr">
		    <td id="XS2" onclick="jiaohuan(this)" class="taihao">[2]</td>
		    <td id="XS2=1=3" class="danwei">每轮积分相加总和</td>
		    <td id="XS2=1=2">累进分</td>
		    <td id="XS2=1=1" onclick="jiaohuan(this)" class="xuhao">B</td>
		    <td>&nbsp;</td>
		    <td id="XS2=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS2=2=2">&nbsp;</td>
		    <td id="XS2=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS3" onclick="jiaohuan(this)" class="taihao">[3]</td>
		    <td id="XS3=1=3" class="danwei">&nbsp;</td>
		    <td id="XS3=1=2">胜局</td>
		    <td id="XS3=1=1" onclick="jiaohuan(this)" class="xuhao">C</td>
		    <td>&nbsp;</td>
		    <td id="XS3=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS3=2=2">&nbsp;</td>
		    <td id="XS3=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS4" onclick="jiaohuan(this)" class="taihao">[4]</td>
		    <td id="XS4=1=3" class="danwei">&nbsp;</td>
		    <td id="XS4=1=2">犯规</td>
		    <td id="XS4=1=1" onclick="jiaohuan(this)" class="xuhao">D</td>
		    <td>&nbsp;</td>
		    <td id="XS4=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS4=2=2">&nbsp;</td>
		    <td id="XS4=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS5" onclick="jiaohuan(this)" class="taihao">[5]</td>
		    <td id="XS5=1=3" class="danwei">执后手获胜的局数</td>
		    <td id="XS5=1=2">后胜局</td>
		    <td id="XS5=1=1" onclick="jiaohuan(this)" class="xuhao">E</td>
		    <td>&nbsp;</td>
		    <td id="XS5=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS5=2=2">&nbsp;</td>
		    <td id="XS5=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS6" onclick="jiaohuan(this)" class="taihao">[6]</td>
		    <td id="XS6=1=3" class="danwei">执后手的局数</td>
		    <td id="XS6=1=2">后手局</td>
		    <td id="XS6=1=1" onclick="jiaohuan(this)" class="xuhao">F</td>
		    <td>&nbsp;</td>
		    <td id="XS6=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS6=2=2">&nbsp;</td>
		    <td id="XS6=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS7" onclick="jiaohuan(this)" class="taihao">[7]</td>
		    <td id="XS7=1=3" class="danwei">执先手获胜的局数</td>
		    <td id="XS7=1=2">先手胜局</td>
		    <td id="XS7=1=1" onclick="jiaohuan(this)" class="xuhao">G</td>
		    <td>&nbsp;</td>
		    <td id="XS7=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS7=2=2">&nbsp;</td>
		    <td id="XS7=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS8" onclick="jiaohuan(this)" class="taihao">[8]</td>
		    <td id="XS8=1=3" class="danwei">(只比较仅有两人同分的情况)</td>
		    <td id="XS8=1=2">直胜局</td>
		    <td id="XS8=1=1" onclick="jiaohuan(this)" class="xuhao">H</td>
		    <td>&nbsp;</td>
		    <td id="XS8=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS8=2=2">&nbsp;</td>
		    <td id="XS8=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS9" onclick="jiaohuan(this)" class="taihao">[9]</td>
		    <td id="XS9=1=3" class="danwei">所胜对手积分之和</td>
		    <td id="XS9=1=2">胜手和</td>
		    <td id="XS9=1=1" onclick="jiaohuan(this)" class="xuhao">I</td>
		    <td>&nbsp;</td>
		    <td id="XS9=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS9=2=2">&nbsp;</td>
		    <td id="XS9=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS10" onclick="jiaohuan(this)" class="taihao">[10]</td>
		    <td id="XS10=1=3" class="danwei">所和对手积分之和</td>
		    <td id="XS10=1=2">和手和</td>
		    <td id="XS10=1=1" onclick="jiaohuan(this)" class="xuhao">J</td>
		    <td>&nbsp;</td>
		    <td id="XS10=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS10=2=2">&nbsp;</td>
		    <td id="XS10=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS11" onclick="jiaohuan(this)" class="taihao">[11]</td>
		    <td id="XS11=1=3" class="danwei">所负对手积分之和</td>
		    <td id="XS11=1=2">负手和</td>
		    <td id="XS11=1=1" onclick="jiaohuan(this)" class="xuhao">K</td>
		    <td>&nbsp;</td>
		    <td id="XS11=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS11=2=2">&nbsp;</td>
		    <td id="XS11=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS12" onclick="jiaohuan(this)" class="taihao">[12]</td>
		    <td id="XS12=1=3" class="danwei">&nbsp;</td>
		    <td id="XS12=1=2">&nbsp;</td>
		    <td id="XS12=1=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td>&nbsp;</td>
		    <td id="XS12=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS12=2=2">&nbsp;</td>
		    <td id="XS12=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr class="hangtr">
		    <td id="XS13" onclick="jiaohuan(this)" class="taihao">[13]</td>
		    <td id="XS13=1=3" class="danwei"><span style="color:#FF0000">（棋类比赛不要增加这个）</span></td>
		    <td id="XS13=1=2">总分</td>
		    <td id="XS13=1=1" onclick="jiaohuan(this)" class="xuhao">Z</td>
		    <td>&nbsp;</td>
		    <td id="XS13=2=1" onclick="jiaohuan(this)" class="xuhao">&nbsp;</td>
		    <td id="XS13=2=2">&nbsp;</td>
		    <td id="XS13=2=3" class="danwei">&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="8">以上还未分出名次，则从
              <select id="dir" title="推荐：累进分模式选 首轮；对手分模式选 末轮。累进分-扣除第一轮积分，还相同、再扣除第二轮，依此类推；对手分-比较倒数第二轮积分，依此类推">
                <option value="1">首轮</option>
                <option value="2">末轮</option>
              </select>
起去除一轮积分再判断，以后以此类推
			<br>
			说明：对手分推荐模式：总分+ACDEF ； 累进分推荐模式：总分+BCDE （棋类比赛不使用Z!)
			</td>
		    </tr>
		  <tr>
		    <td colspan="8">
		    <input type="button" value="确定破同分模式" onclick="wancheng_grpm(this)"/>
		    <input type="button" value="取消本次操作" onclick="quxiao_grpm(this)"/>
		    </td>
		    </tr>
  </tbody>
</table>
</div>
<script type="text/javascript">
//
var TAIzt=0;  //交换选手位置时，取1 放0 的状态
var TAIlastdom; //上次获取的
var XUzt=0;  //交换选手位置时，取1 放0 的状态
var XUlastdom; //上次获取的
function jiaohuan (thisdom) {
	xiugaile=0;//交换位置
	if (thisdom.className=='taihao') {  //交换行的位置，即台号，应该台号不变，行上的其他数据交换
		//判断是取还是放
		if (TAIzt) {  //已经获取 的状态；可以进行放的动作
			TAIlastdom.style.backgroundColor="";  //#FFFF99
			TAIlastdom.parentNode.style.backgroundColor="";  //#FFFF99
			
			TAIlastid=TAIlastdom.getAttribute('id');
			thisid=thisdom.getAttribute('id');
			ids=new Array('=1=3','=1=2','=1=1','=2=1','=2=2','=2=3');
			for (key in ids) {
				zhongjie=document.getElementById(thisid.concat(ids[key])).innerHTML;
				document.getElementById(thisid.concat(ids[key])).innerHTML=document.getElementById(TAIlastid.concat(ids[key])).innerHTML;
				document.getElementById(TAIlastid.concat(ids[key])).innerHTML=zhongjie;
			}
			TAIzt=0;
			xiugaile=1;
			TAIlastdom='';
		} else {   //已经放下 的状态；可以进行取的动作
			thisdom.style.backgroundColor="red";  //#FFFF99
			thisdom.parentNode.style.backgroundColor="#CCFFFF";  //#FFFF99
			
			TAIlastdom=thisdom;
			TAIzt=1;
		}
	} else if (thisdom.className=='xuhao'
				||thisdom.className=='daihao'
				||thisdom.className=='mingcheng') {
		//判断是取还是放
		if (XUzt) {  //已经获取 的状态；可以进行放的动作
			XUlastdom.style.backgroundColor="";
			XUlastdom.style.color="";			

			XUlastid=XUlastdom.getAttribute('id').split('=');
			XUlastid=XUlastid[0].concat('=').concat(XUlastid[1]);
			
			thisid=thisdom.getAttribute('id').split('=');
			thisid=thisid[0].concat('=').concat(thisid[1]);
			ids=new Array('=3','=2','=1');
			for (key in ids) {
				zhongjie=document.getElementById(thisid.concat(ids[key])).innerHTML;
				document.getElementById(thisid.concat(ids[key])).innerHTML=document.getElementById(XUlastid.concat(ids[key])).innerHTML;
				document.getElementById(XUlastid.concat(ids[key])).innerHTML=zhongjie;
			}

			XUzt=0;
			xiugaile=1;
			XUlastdom='';
		} else {   //已经放下 的状态；下面进行取的动作
			thisdom.style.backgroundColor="red";
			thisdom.style.color="white";
			XUlastdom=thisdom;
			XUzt=1;
		}
	}
}
//
function wancheng_grpm(thisdom) {
	moshidom=document.getElementsByName('grpm_moshi')[0];
	linshi='';
	shuju='';
	i=1;
	do {
	  	linshi=document.getElementById('XS'.concat(i).concat('=2=1')).innerHTML;
		linshi=linshi.replace(/\s*/g,"");	//可以去除匹配任何空白字符，包括空格、制表符、换页符等等。等价于 [ \f\n\r\t\v]。
	  	if (linshi&&linshi!='&nbsp;') {
		shuju+=linshi;
		}
	} while (document.getElementById('XS'.concat(++i)))
	moshidom.value=shuju;    //不知是否可行？？！！linshi为空时一定不行！
	document.getElementsByName('dir')[0].value=document.getElementById('dir').value;
	document.getElementById('grpm_div').style.display='none';
	document.getElementById('safeDiv').style.display='none';
}
function quxiao_grpm(thisdom) {
	document.getElementById('grpm_div').style.display='none';
	document.getElementById('safeDiv').style.display='none';
}
</script>
					</td> 
		</tr> 
	</table> 
</form>
<script type="text/javascript" language="javascipt">


function tianxie (thisdom) {
	//alert('d');
	//生成屏蔽div和根据name来显示提交等  //目前暂时不考虑
	//tianxiedom=thisdom;
	domname=thisdom.getAttribute('name');
	
	if (domname=='grpm_moshi') {  //个人排名的模式，即破铜粉项目选择
		moshidom=document.getElementById('grpm_div');
		moshidom.style.display='block';
		moshidom.style.left='150px';
		moshidom.style.top='230px';  //以鼠标位置为准较好！
		document.getElementById('safeDiv').style.display='block';
	} else if (domname=='jufenmoshi') { //局分模式
		
	}
	
}

</script>