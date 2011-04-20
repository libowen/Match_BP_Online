<?php
/**
 * 功能：对当轮已保存的编排结果进行修改
 * 
 */

session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

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

		//还要找出本轮是第几轮的，但是不一定是[0]，所以还要遍寻
		require_once(INCLUDE_PATH."function.php");
		$linshi=bianpailun($xuanshous);        
		$dijilun=$linshi[0];			//当前已经编排和保存编排结果的轮数
		$linshi=fenshulun($xuanshous);     
		$fenshulun=$linshi[0];			//当前已经录入成绩的轮数
		$zuiduokey=$linshi[1];
//echo $dijilun,$fenshulun,'<br>',$_POST['duizhen'];

		if ($_POST['action']=='xiugaibp'&&$_POST['tijiao']) {  //提交保存修改后的编排结果
			if ($_POST['lunci']==$dijilun) {  //可以防止交叉提交保存
				//分两种情况，已经保存了当轮编排结果的和未保存的
				if ($dijilun==$fenshulun) {  				//编排未保存
						//直接在后面进行即可
				} else if ($dijilun==$fenshulun+1) {  		// 编排结果已经保存
					    //首先撤销当前轮次的编排结果，注意前面轮次成绩的保留
					    $lun=$dijilun-1;	//保留前 多少轮的编排结果，
						$cjliu=1;			//保留前面轮次的成绩 1 
						require_once(INCLUDE_PATH.'function.php');
						$xuanshous=anlunhuoqu($xuanshous,$lun,$cjliu);
						
						//使用UPDATE
						$data=array();
						foreach ($xuanshous as $key => $value) {
							$id=$value['xs_id'];
							foreach ($value as $ke => $val) {
								if ($ke=='xs_fenshus'||$ke=='xs_taihaos'||$ke=='xs_towhos'
								||$ke=='xs_xianhous'||$ke=='xs_zongfen'||$ke=='xs_shangxias'
								||$ke=='xs_lianqis') {
									$data[$ke]=$val; 
								}
							}
							if (!$user->updateData("bp_xuanshou",$id,$data,"xs_id")) {
								print_r($data);
								//print_r($value);
								echo $id,':';
								exit('恢复错误！');
							}
						}
//						echo '<script>alert("恢复成功！")</script>';
				} else {  	//应该有某些位置错误
					exit('已登分轮次和已保存的编排轮次无法匹配，可能发生了某些未知错误！可重试或备份后使用 查询恢复');
				}
				/////因为无论是否需要先恢复，最后还是要保存新的数据的！
				
					//取出序号对应的积分，后面得到选手的上下调情况，不考虑上下调也对上下调结果进行保存
					$linshi=array();
					foreach ($xuanshous as $value) {
						$linshi[$value['xs_xuhao']]=$value['xs_zongfen'];
					}
					//保存编排结果，逐个选手进行   //$_POST['duizhen']  $data  //还要记录上下调
		            $data=array();
					$bianpais=split(",",trim($_POST['duizhen'],','));//先手序号,后手序号,
					$bianpais = arrayTrim($bianpais);
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
					//echo '成功！正在跳转中...'; //成功后的操作，输出编排的情况 //$message='编排结果保存成功';
					exit('<script>location.href=""</script>');	//相当于重新载入页面，而非刷新页面（会再次提交数据的）
				/////保存数据	
			} else {   //交叉重复提交数据，将重新载入页面
				exit('<script>
				if(confirm("重复提交数据了，继续载入请求页面，或取消返回原页面。")) {
					location.href="";
				} else {
					window.history.back();
				}</script>');  //相当于重新载入页面，而非刷新页面（会再次提交数据的）
			}
			
		} else { //显示当前轮次的编排结果，如果当轮没有保存编排，则显示传递过来的duizhen（如果也没有传递来的呢，提示跳转到bianpai.php进行编排）；或已保存的编排结果
			
			if ($_GET['lunci']) {
				if (!is_numeric($_GET['lunci'])||$_GET['lunci']>$dijilun) {
					exit('<script>alert("指定轮次lunci非数字或大于已进行过的轮次！返回原页面");window.history.back();</script>');  
				}
					$title='【'.$bsinfo['bs_id'].'】第'.$_GET['lunci'].'轮查看编排结果《'.$bsinfo['bs_biaoti'].'》_已进行 '.$dijilun.' 轮_共 '.$bsinfo['bs_zonglunshu'].' 轮_第'.$_GET['lunci'].'轮编排结果查看';
					$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.$_GET['lunci'].'轮编排结果查看';
					
					$taicis=array();
					$qituis=array();  //包括本轮的弃权退赛的选手数组
					//以taihaos为标准，不够的即是本轮编排前被过滤掉的选手
					foreach ($xuanshous as $key => $value) {
					//$xuxuhaohao=$value['xs_name'].'---'.$value['xs_taihaos'];
						if ($value['xs_taihaos']&&$value['xs_taihaos']!=',,'&&$value['xs_towhos']!=',,') {   /// 预防没有任何台次的选手，即第一轮前就被退赛的
							$linshi=split(',,',trim($value['xs_taihaos'],','));
							if (count($linshi)>=$_GET['lunci']) {
								if (strpos(strrev(substr($value['xs_xianhous'],0,$_GET['lunci'])),'+')===0) { 
									$taicis[$linshi[$_GET['lunci']-1]-1][0]=$value;     //key是从0开始算的，且要取taihaos的最后一个
								} else {
									$taicis[$linshi[$_GET['lunci']-1]-1][1]=$value;     //taicis保存时都>0
								}
							} else {
								$qituis[]=$value;
							}
						} else {
							$qituis[]=$value;
						}
					}				
			} else {
				if ($dijilun==$fenshulun) {   //本轮没有保存编排，必须duizhen，无则提示跳转到bianpai.php?bsid=。。。
					$title='【'.$bsinfo['bs_id'].'】第'.($fenshulun+1).'轮《'.$bsinfo['bs_biaoti'].'》修改未保存编排结果 比赛共 '.$bsinfo['bs_zonglunshu'].' 轮';
					$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.($fenshulun+1).'轮 修改未存编排';
					if ($_POST['duizhen']) {  //根据duizhen显示对阵表
						$xuhaolies=split(',',trim($_POST['duizhen'],','));
						$xuhaolies = arrayTrim($xuhaolies);
						if (count($xuhaolies)%2) {  //奇数个直接调试错误了（必须偶数个数据才正确）
							exit('传入的数据有误！应为偶数个选手！！');
						}
						
						$xuhaos=array();  //以序号为键值的选手数组
						foreach ($xuanshous as $value) {
							$xuhaos[$value['xs_xuhao']]=$value;
						}
						unset($xuanshous);  //释放大变量
						$taicis=array();
						$i=0;
						foreach ($xuhaolies as $key => $value) {
							if ($key%2) {   //因为使用的传递过来的duizhen，所以先后手如此确定
								$taicis[$i][1]=$xuhaos[$value];
								$xuhaos[$value]['did']=1;
								$i++;
							} else {  //第一个，肯定是红方 先手 0
								$taicis[$i][0]=$xuhaos[$value];
								$xuhaos[$value]['did']=1;
							}
						}
						foreach ($xuhaos as $value) {
							if (!$value['did']) {
								$qituis[]=$value;    //弃权退赛的选手数组
							}
						}
					} else {  //提示错误，跳转到编排页面
						exit('<script>alert("请先查看本系统的编排是否如意，即将跳转到编排页面");location.href="bianpai.php?bsid='.$_GET['bsid'].'";</script>');
					}
					
				} elseif ($dijilun==$fenshulun+1) {    //本轮已经保存，无需duizhen，从数据库中获取对阵并显示
					
				$title='【'.$bsinfo['bs_id'].'】第'.($fenshulun+1).'轮《'.$bsinfo['bs_biaoti'].'》修改已保存编排结果 共 '.$bsinfo['bs_zonglunshu'].' 轮';
				$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》第'.($fenshulun+1).'轮 修改已存编排';
	
					$taicis=array();
					$qituis=array();  //包括本轮的弃权退赛的选手数组
					//以taihaos为标准，不够的即是本轮编排前被过滤掉的选手
					foreach ($xuanshous as $key => $value) {
	//$xuxuhaohao=$value['xs_name'].'---'.$value['xs_taihaos'];
						if ($value['xs_taihaos']&&$value['xs_taihaos']!=',,'&&$value['xs_towhos']!=',,') {   /// 预防没有任何台次的选手，即第一轮前就被退赛的
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
						} else {
							$qituis[]=$value;
						}
					}
					
				} else {		//应该有某些位置错误
					exit('已登分轮次和已保存的编排轮次无法匹配，可能发生了某些未知错误！可重试或备份后使用 查询恢复');
				}
			}
			if ($_GET['lunci']) {
				$message='<div class="xiugaibp_message" style="color:red;width:100%;height:auto" title="多次相遇的选手对阵列表，请注意修正！">查看历轮比赛编排结果中，不能保存修改结果！</div>';
			} else {
			    /////检测对阵是否规范，包括已相遇过的和考虑TTbuyu时同队不能相遇，好像保存编排后的taicis肯定都相遇的哦！！！！！
			    //另外还需考虑有空号、轮空的情况，因为以上的taicis没有复制空号
				if ($dijilun==$fenshulun+1) {  //编排已保存
					$linshi='已';
					$cishu=1;
				} else {//编排未保存，显示的将是本轮的对阵，但towhos是至上轮的数据，！！如果显示，说明程序有严重错误！！！
					$linshi='未';
					$cishu=0;	
				}
					///检测同台次两选手是否相遇过河单位相同
					foreach ($taicis as $key => $value) {
						$value[1]?'':$value[1]=array('xs_name'=>'空号','xs_xuhao'=>'0');  //兼容空号情况
						$towholie=$value[0]['xs_towhos'];
						$towho=','.$value[1]['xs_xuhao'].',';
	//echo '【'.$value[0]['xs_towhos'].'】V【'.$value[1]['xs_xuhao'].'】；<br>',strpos($value[0]['xs_towhos'],','.$value[1]['xs_xuhao'].',');		
						if (!$value[0]) {
							$value[0]=array('xs_name'=>'空号','xs_xuhao'=>'0');
							$towholie=$value[1]['xs_towhos'];
							$towho=','.$value[0]['xs_xuhao'].',';
						}
						if (substr_count($towholie,$towho)>$cishu) { 	//在前者里有后者2个，说明他们相遇过了
							$yuguo.='【'.$value[0]['xs_xuhao'].'】V【'.$value[1]['xs_xuhao'].'】，';
						}
						if ($bsinfo['bs_TTbuyu']) { //TTbuyu为1才考虑；且目前与是否保存编排无关
							if ($value[0]['xs_danwei']==$value[1]['xs_danwei']) {	//单位相等
								$TTyu.='【'.$value[0]['xs_xuhao'].'】V【'.$value[1]['xs_xuhao'].'】，';
							}
						}
					}
				$message=$yuguo? '<div class="xiugaibp_message" style="color:red;width:100%;height:auto" title="多次相遇的选手对阵列表，请注意修正！">多次相遇('.$linshi.'保存)：'.$yuguo.'</div>':'';
				$message.=$TTyu? '<div class="xiugaibp_message" style="color:red;width:100%;height:auto" title="考虑同队不遇时，同队相遇的选手对阵列表，请注意修正！">同队相遇('.$linshi.'保存)：'.$TTyu.'</div>':'';   //得到对阵不规范的信息
	//		exit($message.$yanduizhens[$value][0].','.trim($bianpais[$bianpais[$key-1]]).',');
			}
			$zhutizuoceFile='xiugaibp.php';	//编排结果的显示界面载入
		}
	}else{
		$title='比赛编排管理系统-使用提示';
		$zhutibiaoti='☆☆使用提示★★';
		$zhutizuoce='<div style="height:200px;padding:50px;font-size:30px;">没有指定赛事ID！</div>';
		$zhutizuoceFile='';
		exit('<script>alert("没有指定赛事ID！");window.history.back();</script>');
	}	   
}else{
	exit('<script>alert("没有登录，请重新登录！");location.href="/bp/index.php"</script>');
}


/**
 * 功能：在bianpai.php中那个一样》//去除退赛的选手，和lianqi、qianlunfen、dilunfen（考虑时）符合条件的选手，并重新按序号排序，返回
 * 参数：该比赛的全部选手，按序号排序;
 * 返回：继续比赛的选手数组[0]和不参与、淘汰的选手数组[1]（注：一般适用于编排之前）
 */
function XSshaixuan($xuanshous){
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
		foreach ($xuanshous as $value) {
			$xuhaos[]=$value['xs_xuhao'];	
		}
			array_multisort($xuhaos,$xuanshous);  //去除退出比赛的选手后，按序号从小到大排序
			$fanhui[0]=$xuanshous;
			$fanhui[1]=$qituis;
			return $fanhui;			
}

//返回的每个元素都是两端无空格的
function arrayTrim($arr) {
	if ($arr) {//不为空时
		foreach ($arr as $key => $value) {
			$arr[$key] = trim($value);
		}
	}
	return $arr;
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