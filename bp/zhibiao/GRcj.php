<?php
/**
* FILE_NAME : GRcj.php   FILE_PATH : F:\PHPnow\htdocs\bp\zhibiao\GRcj.php
* ....书写本页代码的说明
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");
require_once(INCLUDE_PATH."tiaoshimoshi.php");
require_once(INCLUDE_PATH."function.php");

//$bsid 指定的比赛; $paimingmoshi 排名的模式 ; $paixu 重新排序的方式[pmabc，pmcba，xhabc，xhcba，lunfen1-11当轮的积分（大于默认最大）， ; $qianji 显示前几名的选手;$dir 1 从首轮除起 2 从尾轮除起；konghaofen计算对手分时，空号的积分指定：本比赛所有选手的最低积分 或 零分
/*
A 对手分（所对弈过的全部对手的积分之和）；B 累进分（每轮积分相加总和）；C胜局；D 犯规；E后胜局（后手胜局）；F后手局（后手局数）；
  G 先手胜局 H 直胜局（只比较仅有两人同分的情况）
I 胜手和（所胜对手积分之和）；J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；
标准对手分方案：总分-A-C-D-E-F；标准累进分方案：总分-B-C-D-E-F；对手分方案：总分-A-C-D-E-F-H
*/ 
//$_SESSION['bp_userid']&&
if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=$_GET['bsid']=$bsid=$_GET['bsid']:$bsid=$_GET['bsid']:63;
	    //权限，不是管理员不能操作
	     $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
        	//qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
		
        $linshi=fenshulun($xuanshous);        
		$wanchenglun=$linshi[0];			//当前已经完成的轮数
		
    	//如果有lunci传入，那么lunci>0且lunci<zonglunshu时；只取截至轮次（含）前的数据
    	if (isset($_GET['dijilun']) && $_GET['dijilun'] && !is_numeric($_GET['dijilun'])) {
    		exit('<script>alert("你请求的dijilun不是数字！返回原页面");window.history.back();</script>');  
    	}elseif ($_GET['dijilun']>0&&$_GET['dijilun']<$bsinfo['bs_zonglunshu']) {
    		$xuanshous=anlunhuoqu($xuanshous,$_GET['dijilun'],1);
    	}        	
		$linshi=bianpailun($xuanshous);        
		$dijilun=$linshi[0];			//当前已经编排和保存编排结果的轮数
		$linshi=fenshulun($xuanshous);     
		$fenshulun=$linshi[0];			//当前已经录入成绩的轮数
		$zuiduokey=$linshi[1];

		if (!$_GET['paimingmoshi']) {  //paimingmoshi可能会没传递
			if ($bsinfo['bs_grpm_moshi']) {
				$_GET['paimingmoshi']=$bsinfo['bs_grpm_moshi'];
			} else {
				$_GET['paimingmoshi']=='ACDEFH';
			}
		}
		
		//是否比赛结束？或指定没结束页显示当前排名
		if ($bsinfo['bs_zonglunshu']==$fenshulun||$fenshulun>1) {//分数轮大于1的也计算成绩和排名
			if ($_POST['tijiao']) {//保存计算出来的排名xuanshou和排名规则bisai
				$linshi=explode(",",$_POST['mcsline']);
				foreach ($linshi as $key => $value){
					if ($key%2){
						$data['xs_paiming']=$value;
						if ($user){
							if (!$user->xiugaiXS($xsid,$data)){
								exit('保存错误！请重试'); 
							}
						}
					} else {
						$xsid=$value;
					}
				}
				//保存bisai的grpm_moshi
				$data=array();
				$_POST['grpm_moshi']?$data['bs_grpm_moshi']=$_POST['grpm_moshi']:'';
				$data['bs_dir']=$_POST['dir']?$_POST['dir']:'1';
				$data['bs_konghaofen']=$_POST['konghaofen']?$_POST['konghaofen']:'0';
				$user->xiugaibs($_GET['bsid'],$data);
				
				tiaoshimoshi('GRcj',1);
				
				exit('成功保存排名。正在跳转中...<script>location.href=""</script>');
			}else{
	            //if ($bsinfo['bs_zonglunshu']==$fenshulun) {
	           
				//比赛结束，计算成绩，排名，按不同因素重新排序，选取前几名显示，
	            include_once("GRcj_paiming.php");
	            
				tiaoshimoshi('GRcj',1);
				
	             //$mcsline;//选手ID和排名的数据列  //必须在引入文件后
				$GRcjform='<div style="width:100%;font-size:14px;text-align:center">
								<script language="javascript" type="text/javascript">
								function xianyin(thisDOM) {
									if(thisDOM.checked) {
										selector=".".concat(thisDOM.getAttribute("id"));
										changecss(selector,"display","");
									}else{
										selector=".".concat(thisDOM.getAttribute("id"));
										changecss(selector,"display","none");
									}
								}
								</script>
								<form style="padding:0;margin:0;" name="form" method="post" action="">
									<input type="hidden" name="mcsline" value="'.$mcsline.'" />
									<input type="hidden" name="grpm_moshi" value="'.$_GET['paimingmoshi'].'" />
									<input type="hidden" name="dir" value="'.$_GET['dir'].'" />
									<input type="hidden" name="konghaofen" value="'.$_GET['konghaofen'].'" />
									';
						$GRcjform.=$yibaocunpaiming?'<input type="button" onclick="javascript:
						if(this.value==\'显示已存排名\') {
						changecss(\'.yicunpaiming\',\'display\',\'\');
						this.value=\'隐藏已存排名\';
						} else {
						changecss(\'.yicunpaiming\',\'display\',\'none\');
						this.value=\'显示已存排名\';
						} " value="显示已存排名" />&nbsp;':'';
						$GRcjform.='<input type="submit" name="tijiao" value=
									"';
						$GRcjform.=$yibaocunpaiming?'保存最新排名':'首次保存排名';
						$GRcjform.='" />
						        <input title="显示/隐藏：总分" id="zongfen" type="checkbox" onclick="xianyin(this)" value="0" checked/>
						        <input title="显示/隐藏：对手分" id="duishoufen" type="checkbox" onclick="xianyin(this)" value="0" checked/>
								<input title="显示/隐藏：累进分" id="leijinfen" type="checkbox" onclick="xianyin(this)" value="0"  checked/>
								<input title="显示/隐藏：胜局" id="shengju" type="checkbox" onclick="xianyin(this)" value="0"  checked/>
								<input title="显示/隐藏：犯规" id="fangui" type="checkbox" onclick="xianyin(this)" value="0"  checked/>
								<input title="显示/隐藏：后胜局" id="houshengju" type="checkbox" onclick="xianyin(this)" value="0"  checked/>
								<input title="显示/隐藏：后手局" id="houshouju" type="checkbox" onclick="xianyin(this)" value="0"/>
								<input title="显示/隐藏：先胜局" id="xianshengju" type="checkbox" onclick="xianyin(this)" value="0"/>
								<input title="显示/隐藏：直胜" id="zhisheng" type="checkbox" onclick="xianyin(this)" value="0"/>
						        <input title="显示/隐藏：胜手和" id="shengshouhe" type="checkbox" onclick="xianyin(this)" value="0"/>
						        <input title="显示/隐藏：和手和" id="heshouhe" type="checkbox" onclick="xianyin(this)" value="0"/>
						        <input title="显示/隐藏：负手和" id="fushouhe" type="checkbox" onclick="xianyin(this)" value="0"/>
						        <input title="显示/隐藏：名次" id="mingci" type="checkbox" onclick="xianyin(this)" value="0" checked/>
								</form>
							</div>';	
	           // }
			}
		}else{
			//比赛没有结束
			$xss=array();  //重新取序号为键值，并按键值排序，而不改变键值（数字）了
			foreach ($xuanshous as $key => $value) {
				$xss[$value['xs_xuhao']]=$value;
			}
			$xuanshous=''; //释放变量
			ksort($xss);
//print_r($xss);
			foreach ($xss as $key => $value) {
				$xss[$key]['xianhous']=str_split(trim($xss[$key]['xs_xianhous'],','),1);  ///各轮的先后手序列
				$xss[$key]['towhos']=explode(',,',trim($xss[$key]['xs_towhos'],','));     ///各轮的对手序列
				$xss[$key]['fenshus']=explode(',,',trim($xss[$key]['xs_fenshus'],','));   //各轮的得分序列
				$xss[$key]['gelunfens']=array();   ///各轮的当轮积分（不是得分）序列	
				foreach ($xss[$key]['fenshus'] as $ke => $val) {
					$xss[$key]['gelunfens'][]=array_sum(array_slice($xss[$key]['fenshus'],0,$ke+1));
				}
			}
			preg_match("/[\,\;\:]/",$bsinfo['bs_jufenmoshi'],$fengefu);
			$fenzhis=split($fengefu[0],$bsinfo['bs_jufenmoshi']); 
			//得分有小数的，积分、得分、总分、小分都要保留1位小数
			if (round($fenzhis[1])!=$fenzhis[1]) {
				foreach ($xss as $key => $value) {
					//缺补一位小数
					ceil($xss[$key]['xs_zongfen'])==$xss[$key]['xs_zongfen']?$xss[$key]['xs_zongfen'].='.0':'';
					ceil($xss[$key]['xiaofen'])==$xss[$key]['xiaofen']?$xss[$key]['xiaofen'].='.0':'';
					foreach ($value['gelunfens'] as $lun => $jifen) {
						ceil($xss[$key]['gelunfens'][$lun])==$xss[$key]['gelunfens'][$lun]?$xss[$key]['gelunfens'][$lun].='.0':'';
					}
				}
			}			
		}
		
		
}else{
	require_once(CLASS_PATH."class_user.php");
	$user=new USER();
	is_numeric($_GET['bsid'])?$bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id"):'';
	$xss=array();     //个数不能确定呢！过不了赋值空号的那关
    $bsinfo['bs_biaoti']='&nbsp;<script>alert("详细成绩表 没有指定比赛ID！请先指定赛事"); window.close();</script>';
    $title='个人成绩表 没有指定比赛ID';
}
	/*
	switch ($_GET['moshi']){
		case 2:     //个人成绩表 简表
		$neirongFile='GRcj2.php';
			break;
		default:    //个人成绩表 详表
		$neirongFile='GRcj.php';
			break;				
	} */
	$neirongFile='GRcj.php';
/*	$title;
	$css='';
	$bsinfo;
	$xuanshous;
	每轮的对手，每轮的先后手，每轮的成绩，排序的因素，最后一轮的成绩录入后还要计算排名（包括按不同方式进行的排名）
	
	胜局，后手胜局，先手胜局，犯规的比较
	*/
!$title?$title='【'.$bsinfo[bs_id].'】个人成绩《'.$bsinfo[bs_biaoti].'》_':'';

if ($bsinfo['bs_zonglunshu']==$fenshulun&&!isset($_GET['dijilun'])) {  //比赛结束
	$title.='比赛已结束 共'.$bsinfo['bs_zonglunshu'].'轮';
} else {  //比赛没有结束 或 指定了查看的轮次
	if (isset($_GET['dijilun'])) {
		$title.='比赛共'.$bsinfo['bs_zonglunshu'].'轮_已完成'.$wanchenglun.'轮_目前查看第'.$fenshulun.'轮';
	} else {
		$title.='比赛共'.$bsinfo['bs_zonglunshu'].'轮_已完成'.$wanchenglun.'轮';
	}
}


include(ROOT_PATH."zhibiao/moban/A4.php");
?>