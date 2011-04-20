<?php
/**
* FILE_NAME : bianpai.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\bianpai.php
* 进行比赛编排
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");
require_once(INCLUDE_PATH."tiaoshimoshi.php");

if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
        	qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
		
		//由于赛制 个人2/团体3/个人团体混合1 分别决定了
		if ($bsinfo['bs_saizhi']==2) {
			$bsinfo['bs_TTbuyi']=0;  // 同队可以相遇。其他两赛制暂不限定！
		}

		$zuiduokey=$zuiduoshu=0;
		foreach ($xuanshous as $key => $value) {
			//寻找fenshus个数最多的项，保证正在进行的操作是在登分之后
			if (substr_count($value['xs_fenshus'],',')>$zuiduoshu) {
				$zuiduoshu=substr_count($value['xs_fenshus'],',');
				$zuiduokey=$key;
			}
		}
		////！！dijilun比较特别是以登分次数+1来算的
		$dijilun=substr_count($xuanshous[$zuiduokey]['xs_fenshus'],',')/2+1;        //当前进行的编排轮次，有赖于最多towhos和最多fenshus
		
		if ($_POST['tijiao']) { //保存编排结果
			
			//取出序号对应的积分，后面得到选手的上下调情况，不考虑上下调也对上下调结果进行保存
			$linshi=array();
			foreach ($xuanshous as $value) {
				$linshi[$value['xs_xuhao']]=$value['xs_zongfen'];
			}
			//保存编排结果，逐个选手进行   //$_POST['duizhen']  $data  //还要记录上下调！！！！！！！！！！！！！
			if ($dijilun==substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2+1
			&&$_POST['lunci']==$dijilun) {  //可以防止交叉提交保存
	            $data=array();
	            
				$bianpais=split(",",trim($_POST['duizhen'],','));//先手序号,后手序号,
				$linshi[0]=-1;  //如果有轮空的才用到！
				for ($i=0;$i<count($bianpais);$i++) {
					$data['xs_taihaos']=ceil(($i+1)/2);
					if ($linshi[$bianpais[$i]]>$linshi[$bianpais[$i+1-($i%2)*2]]) {
						$data['xs_shangxias']='V';
					} else {
						if ($linshi[$bianpais[$i]]<$linshi[$bianpais[$i+1-($i%2)*2]]) {
							$data['xs_shangxias']='A';
						} else {
							$data['xs_shangxias']='=';
						}
					}
					
					if ($i%2) {
						$data['xs_towhos']=$bianpais[$i-1];    //对手的序号
						$data['xs_xianhous']='-';
					}else{
						$data['xs_towhos']=$bianpais[$i+1];    //对手的序号
						$data['xs_xianhous']='+';
					}
//print_r($data);echo '<br>';
					if (!$user->baocunBP($bsid,$bianpais[$i],$data)) {
						exit('保存编排信息失败！');
					}
				}
				tiaoshimoshi('bianpai',1);
				//echo '成功！正在跳转中...'; //成功后的操作，输出编排的情况 //$message='编排结果保存成功';
				exit('<script>location.href="/bp/user/bianpai.php?bsid='.$_GET['bsid'].'"</script>');	
			} else {
				echo '<script>alert("本轮保存过编排，不能再次保存编排！");location.href="bianpai.php?bsid='.$_GET['bsid'].'";</script>';
				exit;
			}
			
		} else {   //输出已经编排的结果或进行编排并输出结果
			$zonglunshu=$bsinfo['bs_zonglunshu'];  // 设定的轮次数
	        if ($dijilun>count($xuanshous)-3||$dijilun>count($xuanshous)/2+5) {   //必须在过滤选手之前判断
	        	//exit('所进行的轮次超越了权限的范围！');
	        	
	        	exit('<script>alert("所进行的轮次超越了权限的范围！");location.href="/bp/user/sczb.php?bsid='.$_GET['bsid'].'"</script>');
	        }
	        
			//去除退赛的选手，和lianqi、qianlunfen、dilunfen（考虑时）符合条件的选手，并重新按序号排序，返回
			$linshi=XSshaixuan($xuanshous);		//根据全局变量 lianqi、qianlunfen、dilunfen来确定
			$xuanshous=$linshi[0];
			$qituis=$linshi[1];
			
	        require_once(CLASS_PATH."class_bianpai.php");
	        $bp=new BP();
	        if ($dijilun>$bsinfo['bs_zonglunshu']) {   //最后一轮的成绩都已经录入，比赛结束，应转到计算成绩打印排名等相关的操作
	        	
	        	exit('<script>alert( "不能超过设定的'.$bsinfo['bs_zonglunshu'].'轮 ！准备转到打印设置页面 " ) ;location.href="/bp/user/sczb.php?bsid='.$_GET['bsid'].'"</script>');
	        }
	        if ($dijilun!=substr_count($xuanshous[0]['xs_towhos'],',')/2+1) {	//已编排保存显示已存编排结果 或 数据错误（[0]即可了，前面进行过过滤了）
	        	   $title='【'.$bsinfo['bs_id'].'】第'.($dijilun).'轮 编排已存=《'.$bsinfo['bs_biaoti'].'》 共 '.$bsinfo['bs_zonglunshu'].' 轮';
	        	   $zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.($dijilun).'轮 编排已存';
	        	//输出上次编排的结果
	        	$taicis[0]=array();
	        	$taicis[1]=array();
	        	foreach ($xuanshous as $key => $value) {
	        		$taihao=$value['xs_taihaos'];
	        	}
				foreach ($xuanshous as $key => $value) {
					$linshi=split(',',$value['xs_taihaos']);
		            if (strpos(strrev($value['xs_xianhous']),'+')===0) {   	//不再兼容新旧两种格式的xianshus，目前是没逗号的
						$taicis[$linshi[count($linshi)-2]-1][0]=$value; 	//key是从0开始算的，且要取倒数第二项，所以减2
					}else{
						$taicis[$linshi[count($linshi)-2]-1][1]=$value; 	//taicis保存时都>0
					}
				}
	        	
	        } else {  //fenshus和towhos的相同，进行下轮编排
	        	
	        	//目前只是控制erpei中的qiongju，不能控制yipei中的！
	        	$GLOBALS['g_buqiongju']=isset($GLOBALS['bsinfo']['bs_buqiongju'])?$GLOBALS['bsinfo']['bs_buqiongju']:0;
        	    $title='【'.$bsinfo['bs_id'].'】第'.($dijilun).'轮 编排未存=《'.$bsinfo['bs_biaoti'].'》 共 '.$bsinfo['bs_zonglunshu'].' 轮';
        	    $zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.($dijilun).'轮 编排未存';
	        	//对于saizhi赛制而言，因为只涉及同队相遇的问题，其他的赞美发现，所以只在选择“个人”赛制时在前面强制TTbuyu为0！！！
		        if ($dijilun==1) {
		        	//进行第一轮的编排
		        	$taicis=$bp->diyilun($xuanshous,$bsinfo['bs_peiduimoshi'],$bsinfo['bs_xianhoumoshi']);
		        }else{
		        	//第二轮开始，先计算出选手的xianshu值和上下调的值
		        	foreach ($xuanshous as $key => $value) {
		        		$xianshu=100*(substr_count($value['xs_xianhous'],'+')-substr_count($value['xs_xianhous'],'-'));
						$xianhous=str_split(trim($value['xs_xianhous'],' '),1);	    
		        		$linshi=count($xianhous)-1;
					    for ($i=$linshi;$i>=0;$i--){
						   	if ($xianhous[$i]==$xianhous[$linshi]) {
						   		if ($xianhous[$i]=="+") {
						   		     $xianshu++;
						   	    }else{
						   	    	 $xianshu--;
						   	    }
						   	}else{
						   		break;
						   	}
					    }	
		        		$xuanshous[$key]['xs_xianshu']=$xianshu;
		        		$xuanshous[$key]['xs_shangtiao']=substr_count($value['xs_shangxias'],'A');
		        		$xuanshous[$key]['xs_xiatiao']=substr_count($value['xs_shangxias'],'V');
		        		$xuanshous[$key]['xs_shangxiacha']=$xuanshous[$key]['xs_shangtiao']-$xuanshous[$key]['xs_xiatiao'];
		        	}
		        	if ($dijilun<$zonglunshu-3) {
		        		$taicis=$bp->ersilun($xuanshous,$bsinfo['bs_saizhi']);			//进行2至倒数第4轮的比赛编排
		        	}else{
		        		if ($dijilun==$zonglunshu) {
		        			$taicis=$bp->zuihoulun($xuanshous,$bsinfo['bs_saizhi']);	//最后一轮的编排
		        		}else{
		        			$taicis=$bp->housanlun($xuanshous,$bsinfo['bs_saizhi']);	//进行最后三轮（不包括最后一轮）的编排
		        		}
		        	}
		        }	
	        }
	        tiaoshimoshi('bianpai',1);
		} 
		$zhutizuoceFile='bianpai.php';	//编排结果的显示界面载入
	}else{
		//echo '<script>alert("没有指定赛事ID！")</script>';
		$title='比赛编排管理系统-使用提示';
		$zhutibiaoti='☆☆使用提示★★';
		$zhutizuoce='<div style="height:200px;padding:50px;font-size:30px;">请指定赛事ID！
						<br>
						<form method="get" action="">
						   <input type="text" size="5" value="" name="bsid"/>
						   <input type="submit" value="提交"/>
						</form>
					</div>';
	}	   
}else{
	
	exit('<script>alert("没有登录，请重新登录！");location.href="/bp/index.php"</script>');
}



/**
 * 功能：和xiugaibp.php那个一样》//去除退赛的选手，和lianqi、qianlunfen、dilunfen（考虑时）符合条件的选手，并重新按序号排序，返回
 * 参数：该比赛的全部选手，按序号排序;
 * 返回：继续比赛的选手数组[0]和不参与、淘汰的选手数组[1]（注：一般适用于编排之前）
 */
function XSshaixuan($xuanshous){
		if (!$xuanshous) {
			exit('<script>alert("$xuanshou为空，可能是由于过关淘汰的相关设置太严格了，把所有人都排除掉了！")</script>');
		}
		if ($GLOBALS['bsinfo']) {
			$bsinfo=&$GLOBALS['bsinfo'];
		} else {
			$user?'':$user=new USER();  //如果没有再原页面载入相关文件将提示错误
			$bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
		}
		$qituis=array();//准备记录退赛的选手，或考虑连弃权时符合条件的选手，混在一个数组中
		//private $qianlunfen;		//前【$[0]】轮得【$[1]】分不排；默认0或空或0x0，模式[3x6]
		if ($bsinfo['bs_qianlunfen']&&substr($bsinfo['bs_qianlunfen'],0,1)) {
			$linshi=explode('x',$bsinfo['bs_qianlunfen']);
			$qian=$linshi[0];
			$de=$linshi[1];		
			    foreach ($xuanshous as $key => $value) {
					//if (substr_count($value['xs_fenshus'],',')/2<=$qian) {	
				    	  $linshi=explode(',,',trim($value['xs_fenshus'],','));
						  substr_count($value['xs_fenshus'],',')/2>=$qian?$linshi=array_slice($linshi,0,$qian):$linshi=array_slice($linshi,0,substr_count($value['xs_fenshus'],',')/2);
						  $qianzongfen=array_sum($linshi);
				          if ($qianzongfen>=$de) {   //取大于等于得分的不进行编排；应该属于过关的
					             $qituis[]=$xuanshous[$key];
							   //echo "剔除了一个qianlunfen选手：[",$xuanshous[$key]['xs_xuhao'],']<br>';
								 unset($xuanshous[$key]);
			  			  }
					//}
		       }
		}
		
		//private $dilunfen;			//在第【$[0]】轮未得【$[1]】分淘汰；默认0或空或0x0， 模式[3x6]
		if ($bsinfo['bs_dilunfen']&&substr($bsinfo['bs_dilunfen'],0,1)) {
			$linshi=explode('x',$bsinfo['bs_dilunfen']);
			$zai=$linshi[0];
			$weide=$linshi[1];	
			    foreach ($xuanshous as $key => $value) {
					if (substr_count($value['xs_fenshus'],',')/2>=$zai) {	
				    	  $linshi=explode(',,',trim($value['xs_fenshus'],','));
						  $linshi=array_slice($linshi,0,$zai);
						  $dizongfen=array_sum($linshi);
				          if ($dizongfen<$weide) {
					             $qituis[]=$xuanshous[$key];
							  //echo "剔除了一个dilunfen选手：[",$xuanshous[$key]['xs_xuhao'],']<br>';
								 unset($xuanshous[$key]);
			  			  }
					}
		       }
		}
		
	   //判断是否考虑连续弃权的处理，如处理是连x轮的？
		$lianqistr='';
		if ($bsinfo['bs_lianqi']) {//考虑连弃的，而且连弃是根据给定的值来相应处理的
		    for ($i=0;$i<$bsinfo['bs_lianqi'];$i++){
		    	$lianqistr.='-';
		    }
		    foreach ($xuanshous as $key => $value) {
				if ($value['xs_tuichu']||strpos($value['xs_lianqis'],$lianqistr)!==false) {
						$qituis[]=$xuanshous[$key];
					//echo "剔除了一个选手：[",$xuanshous[$key]['xs_xuhao'],']<br>';
						unset($xuanshous[$key]);					 
				}
		    }
		}else{//不考虑连弃的
			foreach ($xuanshous as $key => $value) {
				if ($value['bs_tuichu']) {
					$qituis[]=$xuanshous[$key];
					unset($xuanshous[$key]);
				}
		    }	
		}
		if ($xuanshous) {
			foreach ($xuanshous as $value) {
				$xuhaos[]=$value['xs_xuhao'];	
			}
			array_multisort($xuhaos,$xuanshous);  //去除退出比赛的选手后，按序号从小到大排序	
		}
			$fanhui[0]=$xuanshous;
			$fanhui[1]=$qituis;
			return $fanhui;			
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
