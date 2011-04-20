<?php
/**
* FILE_NAME : xinjian.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\xinjian.php
* 新建赛事：创建赛事，并录入基本信息和设定具体的编排方式/模式
*
* @copyright Copyright (c) 2010
* 备注：权限??根据用户等级，能创建的比赛数量有所限制
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

if (1==1||$_SESSION['bp_userid']) {  //暂时允许游客查看新建比赛的页面
	if ($_POST['tijiao']&&$_SESSION['bp_userid']) {
		$data=array();
	    foreach ($_POST as $key => $value) {
	   	   if ($key!='submit'&&$key!='tijiao'&&$key!='reset') {  ///&&(!empty($value)||$value===0)
	   	   	   $data['bs_'.$key]=$value;
	   	   }
	    }
	    isset($_POST['TTbuyu'])?'':$data['bs_TTbuyu']=0;
		isset($_POST['SXtiao'])?'':$data['bs_SXtiao']=0;
		isset($_POST['Jliansan'])?'':$data['bs_Jliansan']=0;
		isset($_POST['kongbufen'])?'':$data['bs_kongbufen']=0;
		isset($_POST['guobufen'])?'':$data['bs_guobufen']=0;
		
		$data['bs_luruyuan']=$_SESSION['bp_user']; //如是外用户是有前缀的，内用户没有，便于区分
		date_default_timezone_set('PRC');
		$data['bs_jianliriqi']=date("Y-m-d");
		
		if (isset($_SESSION['bp_huji'])&&$_SESSION['bp_huji']!='NEI') {
			$data['bs_waiid']=$_SESSION['bp_userid'];
		} else {
			$data['bs_neiid']=$_SESSION['bp_userid'];
		}
		
	    //var_dump($data);
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		//根据会员等级，创建的数量有所限制？里面可以判断内外会员
		$user->xinjianquanxian($_SESSION['bp_userid']);
		if ($bsid=$user->xinjianbs($data)) {
			//如果新建比赛成功
			$message='恭喜新建比赛成功！';
			//新建成功则可以减去相关的积分或金币，或增加经验等
			$user->xinjiandaijia ($_SESSION['bp_userid'],'','',-1);
			//跳转到比赛基本信息修改页面
			echo '<script>location.href="saishi.php?bsid='.$bsid.'"</script>';
		}else{
			$message='新建比赛失败，请重试！';
		}
	} elseif ($_POST['tijiao']&&!$_SESSION['bp_userid']) {
		exit('<script>alert("新建赛事需要先登录账户，请先登录！返回原页面");window.history.back();</script>');  
	}
	$title='比赛编排管理系统——创建新赛事';          //页面的标题
	$zhutibiaoti='创建新赛事';    //主体左侧窗口内容的标题
	//主体左侧的内容，即zhutibiaoti下面
	$zhutizuoce='<form action="" method="post">
					<table class="Lxinjian" border="1"> 
							  <tr> 
								<td>*赛事标题</td> 
								<td colspan="5">
								  <input name="biaoti" type="text" value="" size="50" />
							    </td> 
							  </tr> 
							  <tr> 
								<td width="13%">组别</td> 
								<td width="20%"><input name="zubie" type="text" value="" size="14"/></td> 
								<td width="13%">比赛地点</td> 
								<td width="20%"><input name="didian" type="text" value="" size="14"/></td> 
								<td width="14%">比赛时间</td> 
								<td width="20%"><input name="shijian" type="text" value="" size="14"/></td> 
							  </tr> 
							  <tr> 
								<td>性质</td> 
								<td><input name="xingzhi" type="text" value="" size="14"/></td> 
								<td>裁判长</td> 
								<td><input name="caipanzhang" type="text" value="" size="14"/></td> 
								<td>编排员</td> 
								<td><input name="bianpaiyuan" type="text" value="" size="14"/></td> 
							  </tr> 
							   
							  <tr>
							    <td>项目</td>
							    <td>
									<select name="BSxiangmu">
									  <option value="1" selected>中国象棋</option>
									  <option value="2">国际象棋</option>
									  <option value="3">围棋</option>
									  <option value="4">五子棋</option>
									  <option value="5">其它等等</option>
									</select>					    </td>
							    <td>赛制</td>
							    <td><select name="saizhi">
		                          <option value="1">个人团体混合</option>
		                          <option value="2">个人赛</option>
		                          <option value="3">团体赛</option>
		                        </select></td>
							    <td>编排类型</td>
							    <td title="注意：目前系统只考虑积分编排，其他方式暂不支持！">
									<select name="BPleixing">
										  <option value="1" selected>积分编排</option>
										  <!--<option value="2">大循环</option>
										  <option value="3">单淘汰</option>
										  <option value="4">双淘汰</option>
										  <option value="5">积分末位淘汰</option>-->
									</select>						</td>
				      </tr>
							  <tr>
							    <td>总轮数</td>
							    <td><input name="zonglunshu" type="text" value="9" size="4"/></td>
							    <td>局分模式</td>
							    <td><select name="jufenmoshi">
							      <option value="2:1:0:2:1:0" selected> 2:1:0:2:1:0 </option>
							      <option value="3:1:0:3:2:0"> 3:1:0:3:2:0 </option>
							      <option value="1:0.5:0:1:0.5:0">1:0.5:0:1:0.5:0</option>
		                                                                                                                        </select>																														</td>
							    <td>先后手</td>
							    <td>
								<select name="PHxianhou">
		                          <option value="1" selected>平衡先后手</option>
		                          <option value="2">#自然调节法</option>
		                        </select>						</td>
				      </tr>
							
							    <tr>
							    <td colspan="2">连续弃权
							      <input name="lianqi" type="text" value="2" size="3" value="2">
							      轮不编排</td>
							    <td colspan="2">第
							      X
							      轮未得
							      Y
							      分淘汰&nbsp;XxY=<input name="dilunfen" type="text" value="0x0" size="6"></td>
							    <td colspan="2">前
							      X
							      轮得
							      Y
							      分不排&nbsp;XxY=<input name="qianlunfen" type="text" value="0x0" size="6"></td>
				      </tr>
					    
					    <tr>
							    <td colspan="2">第一轮配对模式<br>
							        <select name="peiduimoshi">
							          <option value="1">临近</option>
							          <option value="2">首尾</option>
							          <option value="3" selected>拦腰</option>
							          <option value="4">随机</option>
						            </select>
							    </td>
							    <td colspan="2">第一轮先后手模式<br>					      
						            <select name="xianhoumoshi">
						              <option value="1">上半区为先，下半区为后</option>
						              <option value="2" selected>台次单数小号先，双数大号先</option>
						              <option value="3">序号单数先，双数后</option>
						              <option value="4">抽签决定，或者竞猜</option>
						              <option value="5">上半区执后，下半区执先</option>
						              <option value="6">台次单数小号后，双数大号先</option>
						              <option value="7">单数序号后，双数序号先</option>
						              <option value="8">全部小号先</option>
						              <option value="9">全部大号先</option>
						              <option value="10">1-2,4-3,5-6,8-7</option>
					                </select>
							    </td>
							    <td colspan="2">后三轮配对后，优先平衡多
							      <input name="chafengaoping" type="text" value="0.5" size="3">
						        分（含）一方的先后走
						        </td>
				      </tr>
							  <tr>
							    <td colspan="3">个人名次计算的方式
							        <select name="GRpaiming">
							            <option value="1" selected>小分不转化为大分</option>
							            <option value="2">小分转化为大分</option>
						            </select>
		                        </td>
							    <td colspan="3">团体名次计算的方式
									<select name="TTpaiming">
									  <option value="1" selected>按个人名次总和</option>
									  <option value="2">按个人积分总和</option>
								      </select>
		                        </td>
				     	 </tr> 
				      	 <tr>
							    <td colspan="6">
							    个人排名的模式： <input title="双击打开高级填写模式和详细说明。
							                                代号说明：A 对手分（所对弈过的全部对手的积分之和）；B 累进分（每轮积分相加总和）；C 胜局；D 犯规；E 后胜局（后手胜局）；F 后手局（后手局数）；G 先手胜局；H 直胜局（只比较仅有两人同分的情况）；I 胜手和（所胜对手积分之和）；J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；" name="grpm_moshi" type="text" value="ACDEF" size="12" dbonclick="tianxie(this)" >
							    轮空模式：默认 未轮空过的最低分项；最低分的轮空次数最少的项
							    </td>
				    	  </tr>
							  <tr>
							    <td colspan="6">&nbsp;&nbsp;同队不相遇
							      <input type="checkbox" name="TTbuyu" value="1" checked>
							     &nbsp;&nbsp;调整上下调：
		                          <input type="checkbox" name="SXtiao" value="1" checked>
		                         &nbsp;&nbsp;&nbsp;禁3先/后：
		                         <input type="checkbox" name="Jliansan" value="1" checked>
		                         &nbsp;&nbsp;&nbsp;因淘汰轮空补小分
		                         <input type="checkbox" name="kongbufen" value="1" checked> 
		                         &nbsp;&nbsp;&nbsp;过关补小分
		                         <input type="checkbox" name="guobufen" value="1" checked></td>
				      </tr>
							  <tr> 
								<td>赛事简介<br>
								  <500字
								</td> 
								<td colspan="5">
								  <textarea name="guicheng" cols="100%" rows="3"></textarea>
								</td> 
							  </tr> 
							  <tr> 
								<td>管理员</td> 
								<td>'.$_SESSION['bp_user'].'  </td> 
								<td>创建日期</td> 
								<td>当前日期</td> 
								<td>备注</td> 
								<td><input name="beizhu" type="text" value="" size="14"/></td> 
							  </tr>
							  <tr> 
								<td colspan="6">
									'.$message.'
									  <input type="submit" name="tijiao" value="提交" />			  
									  &nbsp;&nbsp;&nbsp;
									  <input type="reset" id="Reset" value="重置" />
									</td> 
							  </tr> 
							  <tr> 
								<td colspan="8" height="3"></td> 
							  </tr> 
					  </table> 
			     </form>';

			//比赛配置信息录入和显示，上面是旧的暂时保留（不兼容新的），新的更换为以下：
			$zhutizuoce='';  
			$zhutizuoceFile='xiugaibs.php';

}else{
	exit('<script>alert("新建赛事需要先登录账户，请先登录！返回原页面");window.history.back();</script>');  
}

//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>