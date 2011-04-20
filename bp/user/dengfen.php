<?php
/**
* FILE_NAME : dengfen.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\dengfen.php
* 成绩登录和显示:成绩录入，录入当前编排好的轮次成绩；录入成绩而没编排的，显示上轮的对阵和成绩（0轮除外）并提示；可当作成绩修改页面（当轮有效）？
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");
require_once(INCLUDE_PATH."tiaoshimoshi.php");

if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		$bsid=$_GET['bsid'];
//$bsid=61;
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();        
        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");		//获取指定比赛的基本信息
        	qingqiuzt($_SESSION['bp_userid'],'bisai',$_GET['bsid']);				//所指定的比赛是否存在
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
        	qingqiuzt($_SESSION['bp_userid'],'xuanshou',$_GET['bsid']);
        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');		//权限验证：
		
		//还要找出本轮是第几轮的，但是不一定是[0]，所以还要遍寻
		$zuiduokey=$zuiduoshu=0;
		foreach ($xuanshous as $key => $value) { 	//寻找towhos个数最多的项，
			if (substr_count($value['xs_towhos'],',')>$zuiduoshu) {
				$zuiduoshu=substr_count($value['xs_towhos'],',');
				$zuiduokey=$key;
			}
		}
			$dijilun=substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2;        //当前已经编排和保存编排结果的轮数
        $zuiduokey=$zuiduoshu=0;
		foreach ($xuanshous as $key => $value) { 	//寻找fenshus个数最多的项，
			if (substr_count($value['xs_fenshus'],',')>$zuiduoshu) {
				$zuiduoshu=substr_count($value['xs_fenshus'],',');
				$zuiduokey=$key;
			}
		}
			$fenshulun=substr_count($xuanshous[$zuiduokey]['xs_fenshus'],',')/2;     //当前已经录入成绩的轮数
		
        //提交成绩表，
		if ($_POST['tijiao']&&$fenshulun+1==$dijilun&&$fenshulun+1==$_POST['lunci']) {//加入了防刷新或多次提交同个页面的意外；其中POST['lunci']是已编排的轮数
			//兼容多种jifenmoshi写入的格式
			if (!preg_match("/[\,\;\:]/",$bsinfo['bs_jufenmoshi'],$fengefu)) {
				echo '局分模式分割的符号不正确！';
			}
			$fenzhis=split($fengefu[0],$bsinfo['bs_jufenmoshi']);  //分制： 红方- 胜 和 负；黑方- 胜和负
			$linshi = count($fenzhis);
			if ($linshi == 4 || $linshi == 6) {
				if ($linshi == 4) {
					//如果为四位模式，则统一转化成6位模式
					$fenzhis[4] = $fenzhis[2];
					$fenzhis[5] = $fenzhis[3];
					$fenzhis[2] = $fenzhis[3];
					$fenzhis[3] = $fenzhis[0];					
				}
			} else {
				exit('<script>alert("你设置的局分模式不符合规范！必须如1:0.5:0:1:0.5:0 或 1:0.5:0.5:0模式。返回原页面");window.history.back();</script>');  
			}
			$xuhaos=split(',',trim($_POST['duizhen']));    ////可以有数据库自动生成！
//			￥$xuhao=array();
//			foreach ($xuanshous as $key => $value) {
//				if (  $value['xs_towhos']) {
//					$xuhao[  $value['xs_taihaos']-1)*2]
//				}
//			}
			
			$chengjis='';
			$jieguos=$_POST['jieguo'];       //数组

//测试阶段：如果全部未选则随机成绩！！！！
if (!isset($_POST['jieguo'])||!$_POST['jieguo']) {	//如果jieguo没有提交就可能是调试模式
	for ($i=0;$i<count($xuhaos)/2;$i++) {
		$jieguos[]=6;
	}
}
$busuiji=0;
foreach($jieguos as $key => $value){
	if ($value!=6){
		$busuiji=1;
		break;
	}
}
if (!$busuiji){
$jieguos=sjchengji($jieguos,$xuhaos);    //随机成绩，而且也设置了一定的概率分布
}
			foreach($jieguos as $key => $value){
			  		switch($value){
			  			case 0:  //红胜
			  			$chengjis.=$xuhaos[$key*2].',=,'.$fenzhis[0].',';
			  			$chengjis.=$xuhaos[$key*2+1].',=,'.$fenzhis[5];
			  			break;
			  			case 1:  //红和
			  			$chengjis.=$xuhaos[$key*2].',=,'.$fenzhis[1].',';
			  			$chengjis.=$xuhaos[$key*2+1].',=,'.$fenzhis[4];
			  			break;
			  			case 2:  //红负
			  			$chengjis.=$xuhaos[$key*2].',=,'.$fenzhis[2].',';
			  			$chengjis.=$xuhaos[$key*2+1].',=,'.$fenzhis[3];
			  			break;
			  			case 3:  //红弃权
			  			$chengjis.=$xuhaos[$key*2].',-,'.$fenzhis[2].',';
			  			$chengjis.=$xuhaos[$key*2+1].',+,'.$fenzhis[3];
			  			break;
			  			case 4:   //黑弃权
			  			$chengjis.=$xuhaos[$key*2].',+,'.$fenzhis[0].',';
			  			$chengjis.=$xuhaos[$key*2+1].',-,'.$fenzhis[5];
			  			break;
			  			case 5:   //双方弃权
			  			$chengjis.=$xuhaos[$key*2].',-,'.$fenzhis[2].',';
			  			$chengjis.=$xuhaos[$key*2+1].',-,'.$fenzhis[5];
			  			break;
			  			case 6://没处理的成绩默认是红胜处理。且双方都没弃权
			  			$chengjis.=$xuhaos[$key*2].',=,'.$fenzhis[0].',';
			  			$chengjis.=$xuhaos[$key*2+1].',=,'.$fenzhis[5];
			  			break;
			  		}
			  		if ($key<count($jieguos)-1) {
			  			$chengjis.=',';
			  		}
		  	}
			//$chengjis（第一桌红方的序号，第一桌红方得分，第一桌黑方序号，第一桌黑方得分；，，
			//$data 需要生成fenshus 一项;zongfen fenshus 两项是自动生成了
			$chengjis=split(',',$chengjis);
			$xs_xuhao='';
			for ($i=0;$i<count($chengjis);$i+=3){
				$xs_xuhao=$chengjis[$i];
				//兼容空号：空号格式 序号为0 且只有一个
				if ($xs_xuhao) {
					$data['xs_lianqis']=$chengjis[$i+1]; //选手的本次lianqi状态：正常=、弃权-、对方弃权+
					$data['xs_defen']=$chengjis[$i+2];  //选手的本次得分
					if (!$user->baocunBP($bsid,$xs_xuhao,$data)) {
						echo '保存成绩错误！';/////万一是保存了一半才发生错误呢！！！！
						exit;
					}
				}
			}
			$fenshulun++;    //因为成绩录入保存后fenshus的个数自然加1；好像没使用到！
            $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id"); //最新录入成绩后的选手编排信息表，主要是为了显示本次的成绩（必须）和弃权情况
	        
            $title='【'.$bsinfo['bs_id'].'】第'.$dijilun.'轮 显示成绩=《'.$bsinfo['bs_biaoti'].'》 共 '.$bsinfo['bs_zonglunshu'].' 轮';
	        $zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.$dijilun.'轮 成绩显示';
		
			tiaoshimoshi('dengfen',1);
		}
		if (!$title) {
		    $title='【'.$bsinfo['bs_id'].'】第'.$dijilun.'轮 录入成绩=《'.$bsinfo['bs_biaoti'].'》 共 '.$bsinfo['bs_zonglunshu'].' 轮';
      		$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.$dijilun.'轮 成绩录入';
		}
        ///下面是获取本轮的对阵的，本轮退赛的选手任然显示	
		$taicis=array();
		$qituis=array();//本次成绩前的结果
		//以taihaos为标准，不够的即是本轮编排和成绩都不用处理的选手（已包含了去除上轮退赛的选手）
		foreach ($xuanshous as $key => $value) {
			$linshi=split(',,',trim($value['xs_taihaos'],','));
			if (count($linshi)==$dijilun) {
				if (strpos(strrev($value['xs_xianhous']),'+')===0) {    //不再兼容新旧两种格式的xianshus，目前是没逗号的
					$taicis[$linshi[count($linshi)-1]-1][0]=$value;     //key是从0开始算的，且要取taihaos的最后一个
				}else{
					$taicis[$linshi[count($linshi)-1]-1][1]=$value;     //taicis保存时都>0
				}	
			}else{
				$qituis[]=$value;
			}
		}
//var_dump($taicis[1][0]);
	}else{
//		echo '请指定比赛！';
//		exit;
        $title='比赛编排管理系统-使用提示';
		$zhutibiaoti='☆☆使用提示★★';
		$zhutizuoce='<div style="height:200px;padding:50px;font-size:30px;">没有指定赛事ID！</div>';
		
		$zhutizuoce='<div style="height: 200px; padding: 50px; font-size: 30px;">请指定赛事ID！
				<br>
				<form action="" method="get">
				   <input type="text" name="bsid" value="" size="5">
				   <input type="submit" value="提交">
				</form>
			</div>';
//		exit('<script>alert("没有指定赛事ID！"); window.history.back();</script>');
	}
}else{
	
	exit('<script>location.href="/bp/index.php"</script>') ;
}

		$zhutizuoceFile='dengfen.php';   //载入显示内容


/**
* 功能：增加随机成绩录入，可按一定的发生率；只是针对成绩登录和测试用
* 参数：$jieguos 数组，取值范围：0、1、2、5
* 返回：新的$jieguos数组
*/
function sjchengji($jieguos,$xuhaos){
	$redsheng=45; //红方的胜率
	$he=16;
	$heisheng=34;
	$qita1=2;//如hong方都弃权
	$qita2=2;//如hei方都弃权
	$qita3=1;//如双方都弃权
   foreach ($jieguos as $key => $value) {
   	   $suijishu=rand(1,100);
		   if ($suijishu<=$redsheng) {
		   	   $jieguos[$key]=0;
		   }elseif ($suijishu>$redsheng&&$suijishu<=$redsheng+$he){
		   	   $jieguos[$key]=1;
		   }elseif ($suijishu>$redsheng+$he&&$suijishu<=$redsheng+$he+$heisheng){
		   	   $jieguos[$key]=2;
		   }elseif ($suijishu>$redsheng+$he+$heisheng&&$suijishu<=$redsheng+$he+$heisheng+$qita1) {
		   	 	$jieguos[$key]=3;
		   }elseif ($suijishu>$redsheng+$he+$heisheng+$qita1&&$suijishu<=$redsheng+$he+$heisheng+$qita1+$qita2) {
		   	 	$jieguos[$key]=4;
		   }elseif ($suijishu>$redsheng+$he+$heisheng+$qita1+$qita2&&$suijishu<=$redsheng+$he+$heisheng+$qita1+$qita2+$qita3) {
		   	    $jieguos[$key]=5;
		   } else {
		   	
		   }
   }		   
   if (!$xuhaos[$key*2+1]) { //经测试，xuhaos最后一个为空，估计是被转换后的换行符！！！！
   	   $jieguos[$key]=0;
   } elseif (!$xuhaos[$key*2]) {
   	   $jieguos[$key]=2;
   } else {
   	
   }
//print_r($xuhaos);
//print_r($jieguos);
//exit($xuhaos[$key*2+1].'ggg'.$xuhaos[$key*2].'ddd'.$jieguos[$key].'rr'.$key);
   return $jieguos;
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