<?php  
/**
* FILE_NAME : xsgl.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\xsgl.php
* 选手管理：录入选手，修改选手信息（包括退赛指定），删除选手，
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {  //指定比赛
		$bsid=$_GET['bsid'];
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
        	
		if ($_GET['rukou']=='luru') {    //为比赛录入选手或导入或增加
			if ($_POST['tijiao']) {
				//一般是批量录入的，或大量导入；也可以一个个录入？（序号怎么排？）
				$xsluru=$_POST['xuanshouluru'];
				if ($user->luruXS("bp_xuanshou",$bsid,$xsluru)) {
					$message='成功录入';
					echo '<script>location.href="xsgl.php?bsid='.$bsid.'&&rukou=luru"</script>';  //刷新本页，另外设置按钮跳转到xsgl.php?bsid=，可修改是定bsid的比赛里的选手
				}
			}else{  //显示录入框和导入入口
				$message='录入选手';
	   			$xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
				$title='选手录入【'.$_GET['bsid'].'】《'.$bsinfo['bs_biaoti'].'》';  
				$zhutibiaoti='【'.$_GET['bsid'].'】《'.$bsinfo['bs_biaoti'].'》 '.$message; 
				$xuhaoliebiao='本比赛还没有录入参赛选手';
				if ($xuanshous) {
					if (isset($xuanshous['xs_xuhao'])) {
						$xuhaoliebiao='已存选手序号列表（共1人）：<a href="javascript:gotoxs('.$xuanshous['xs_bs_id'].','.$xuanshous['xs_xuhao'].')" title="单位：'.$xuanshous['xs_danwei'].'">【'.$xuanshous['xs_xuhao'].'】'.$xuanshous['xs_name'].'</a>';
					}else{
						$linshi=array();
						foreach ($xuanshous as $value) {
							$linshi[]=$value['xs_xuhao'];
						}
						array_multisort($linshi,$xuanshous);
						$xuhaoliebiao='已存选手序号列表（共'.count($xuanshous).'人）：<br>';
						foreach ($xuanshous as $key => $value) {
							$xuhaoliebiao.='<a href="javascript:gotoxs('.$value['xs_bs_id'].','.$value['xs_xuhao'].')" title="单位：'.$value['xs_danwei'].'">【'.$value['xs_xuhao'].'】'.$value['xs_name'].'</a>   ';
						}
					}
				}
				$zhutizuoceFile='xsluru.php';
			}
		}else if ($_GET['action']=='chongpai'){ //打乱原有序号排序，重新排列序号
			$xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
			///目前总共有4中模式 和 另一种默认的以实际修改为准的——这里不用考虑的
			$_GET['moshi']?'':exit('<script>alert("请选择一种序号安排模式！即将返回原页面");window.history.back();</script>');
			switch ($_GET['moshi']) {
				case 'suiji':
				$xuanshous=suijimoshi($xuanshous);
					break;
				case 'luru':
				$xuanshous=lurumoshi($xuanshous,1);
					break;
				case 'luruni':
				$xuanshous=lurumoshi($xuanshous,0);
					break;
				case 'chouqian':
				$xuanshous=chouqianmoshi($xuanshous);
					break;
				case 'danwei':
				$xuanshous=danweimoshi($xuanshous);
					break;
				case 'banqu':
				$xuanshous=banqumoshi($xuanshous);
					break;
				default:
				exit('<script>alert("没有这种序号安排模式！即将返回原页面");window.history.back();</script>');
			}
			
			$data=array();
			foreach ($xuanshous as $key => $value) {
				$data['xs_xuhao']=$key+1;
				if (!$user->xiugaiXS($value['xs_id'],$data)) {
					////此处可导致非法注入和越权修改或意外修改！！！！！ 
					exit('<script>alert("重新排序失败！");location.href="xsgl.php?bsid='.$bsid.'"</script>');
				}
			}
			exit('<script>location.href="xsgl.php?bsid='.$bsid.'"</script>');
			
		} elseif ($_GET['action']=='qingkong'){  //一次删除已存所有选手
			
			   $r=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
	   		   if ($r['bs_luruyuan']==$_SESSION['bp_user']) {            //检测此比赛是否自己建立的
	   		      if ($user->delData($_GET['bsid'],"bp_xuanshou","xs_bs_id")) {
	   		      	  exit('<script>alert("清空选手成功。即将返回原页面");location.href="xsgl.php?bsid='.$_GET['bsid'].'&rukou=luru"</script>');  
	   		      } else {
	   		      	//清空失败！
	   		      	exit('<script>alert("清空失败！即将返回原页面");window.history.back();</script>');  
	   		      }
	   		   } else {
	   		   	  exit('<script>alert("你不是本比赛的管理员，无足够权限！返回原页面");window.history.back();</script>');  
	   		   }
	   		   
		}else{
			
			if ($_GET['action']=='shanchu'&&is_numeric($_GET['xuhao'])) {  //删除指定选手
				//权限，是否需要现在验证权限是否允许，或是在后面函数会自动处理？
				$linshi=$user->getInfo($_GET['xsid'],"bp_xuanshou","xs_id");
				if ($linshi['xs_bs_id']==$_GET['bsid']&&$bsinfo['bs_luruyuan']==$_SESSION['bp_user']) { //删除操作的是管理员本人
					//if ($user->shanchuXS("bp_xuanshou",$bsid,$_GET['xuhao'])) {
					if ($user->shanchuXS("bp_xuanshou",$bsid,$_GET['xuhao'],$_GET['xsid'])) {//以xsid为准；权限要另外处理
						echo '删除成功，正在跳转中...';
						echo '<script>location.href="xsgl.php?bsid='.$bsid.'"</script>';
						exit;
					}else{
						echo '<script>alert("删除失败！请重试");location.href="xsgl.php?bsid='.$bsid.'"</script>';
						exit;
					}	
				}else{
					echo '<script>alert("只有本赛事的管理员才能删除此选手！");location.href="xsgl.php?bsid='.$bsid.'"</script>';
					exit;
				}
			}else{
		   		$xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
	   			if ($xuanshous) {
					//没有指定操作动作，默认是修改本比赛的选手信息，包括退赛指定；包括增减？！
					if ($_POST['tijiao']) {
						
						//只能修改选手的个人信息，非比赛编排信息。
						$XSxiugai=$_POST['XSxiugai'];
						//提交的XSxiugai（XSxiugai=(id,序号,姓名,单位,性别,半区,备注,  犯规次数,退赛,...;...)）
						$xuanshous=split(";",$XSxiugai);//数据至少应有一个’;
						$keys=array('id','xuhao','name','danwei','sex','banqu','beizhu','fangui','tuichu');
						foreach ($xuanshous as $key => $value) {
							if ($value) {
								$data=array();
								$value=split(',',$value);
								foreach ($value as $ke => $val) {
									$val=trim($val);              //取出两端的空格换行等
									if ($val!=NULL&&$ke) {//排除id字段
										$data['xs_'.$keys[$ke]]=$val;
									}
								}
								if (!$user->xiugaiXS($value[0],$data)) {
									////此处可导致非法注入和越权修改或意外修改！！！！！
									echo '修改失败！';
								}
							}
						}
						exit('<script>alert("更新成功");location.href="xsgl.php?bsid='.$bsid.'"</script>');
					}else{  //显示本次比赛的选手列表（$xuanshous有可能是一维数组）
						$title=$zhutibiaoti='选手管理【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》';
						$zhutizuoceFile='xiugaixs.php';
					}
				}else{
					echo '<script>location.href="xsgl.php?bsid='.$bsid.'&&rukou=luru"</script>';
					exit;
				}
			}
		}
		
	} else {
		$zhutizuoce='<div style="height: 200px; padding: 50px; font-size: 30px;">请指定赛事ID！
				<br>
				<form action="" method="get">
				   <input type="text" name="bsid" value="" size="5">
				   <input type="submit" value="提交">
				</form>
			</div>';
//		exit('<script>alert("请指定比赛id！即将返回原页面");window.history.back();</script>');

		
	}
}else{
	exit( '<script>alert("请先登录！"); location.href="/bp/index.php";</script>' );  
}

/**
* 功能：“随机重排序号”根据需要打乱原排序再电脑随机排序
* 参数：
* 返回： 按要求重新排序后的选手数组
*/
function suijimoshi($xuanshous) {
	$linshi=array();
	foreach ($xuanshous as $key => $value) {
		$linshi[$key]['xs_id']=$value['xs_id'];
		$linshi[$key]['xs_danwei']=$value['xs_danwei'];
		$linshi[$key]['xs_xuhao']=$value['xs_xuhao'];
		$linshi[$key]['xs_banqu']=$value['xs_banqu'];
	}
	$xuanshous=$linshi;   //注意：为了简化数据，返回时需要特别注意
	unset($linshi);
	
			if ($_GET['TTbuyu']) {  //同队不能相遇
				require_once(CLASS_PATH."class_bianpai.php");
		        $bp=new BP();
		        $cishu=0;  //防止死循环；设定1000次
				do{
					shuffle($xuanshous);
					foreach ($xuanshous as $key => $value) {
						$xuanshous[$key]['xs_xuhao']=$key+1;
					}
					//下面的排序时根据序号的，而不是键值！！
			        $taicis=$bp->diyilun($xuanshous,$GLOBALS['bsinfo']['bs_peiduimoshi'],$GLOBALS['bsinfo']['bs_xianhoumoshi']);
					$chenggong=1;
			        foreach ($taicis as $key => $value) {
//echo $value[0]['xs_danwei'],'==',$value[1]['xs_danwei'],'<br>';
						if ($value[0]['xs_danwei']==$value[1]['xs_danwei']) {
							$chenggong=2;
							break;
						}
					}
					$cishu++;
				}while ($chenggong==2&&$cishu<1000);	
//echo '<br>',$cishu,'<br>ggggggggggggg'; exit;
			    if (!$chenggong) {
			    	exit('<script>alert("随机了1000次都没符合条件的，请重试或检查数据的规范性！即将返回原页面");window.history.back();</script>');
			    }
			    
			} else {  //同队可以相对，不考虑这个
				shuffle($xuanshous);
			}
			return $xuanshous;
}

/**
* 功能：“录入顺序排序”按原来选手录入的前后顺序来排列序号；
* 参数： $xuanshous 选手数组； $shunxu 录入先后的顺序1 或 逆序0
* 返回： 按要求重新排序后的选手数组
*/
function lurumoshi($xuanshous,$shunxu=1) {
	$ids=array();
	foreach ($xuanshous as $value) {
		$ids[]=$value['xs_id'];
	}
	if ($shunxu) {
		array_multisort($ids,$xuanshous);
	} else {
		array_multisort($ids,SORT_DESC,$xuanshous);
	}
	return $xuanshous;
}

/**
* 功能：“根据抽签排序”根据目前的序号从小到大重新排列并重置序号；
* 参数：
* 返回： 按要求重新排序后的选手数组
*/
function chouqianmoshi($xuanshous) {
	$xuhaos=array();
	$ids=array();
	foreach ($xuanshous as $value) {
		$xuhaos[]=$value['xs_xuhao'];
		$ids[]=$value['xs_id'];
	}
	array_multisort($xuhaos,$ids,$xuanshous);
	return $xuanshous;
}

/**
* 功能：“根据单位排序”同队成员连续，单位整体随机重新排列并重置序号（一般首轮使用栏腰配对）
* 参数：
* 返回： 按要求重新排序后的选手数组
*/
function danweimoshi($xuanshous) {//也会分为几种的：从最多人数的单位开始，到成员少的单位；不论成员数的单位整体随机；先单位后个人
	$linshi=array();
	foreach ($xuanshous as $key => $value) {
		$linshi[$key]['xs_id']=$value['xs_id'];
		$linshi[$key]['xs_danwei']=$value['xs_danwei'];
		$linshi[$key]['xs_xuhao']=$value['xs_xuhao'];
	}
	$xuanshous=$linshi;   //注意：为了简化数据，返回时需要特别注意
	unset($linshi);
	
	//这里只选择：有2人及以上的单位在前面随机排序，个人单位在后面随机排序
	$danweis=array();
	$xuhaos=array();
	foreach ($xuanshous as $value) {
		$danweis[]=$value['xs_danwei'];
		$xuhaos[]=$value['xs_xuhao'];
	}
	array_multisort($danweis,$xuhaos,$xuanshous);
//print_r($xuanshous);exit;	
	$danweis=array();
	$danweihao = 0;	
	$qiandanwei ="";
	foreach ($xuanshous as $key => $value) {
		if ($key) {
//echo $qiandanwei,$value['xs_danwei'];
			if ($qiandanwei==$value['xs_danwei']) {
				$danweis[$danweihao][]=$value;
			} else {
				$danweihao++;
//echo $qiandanwei,$value['xs_danwei'];print_r($xuanshous);exit;
				$danweis[$danweihao][0]=$value;
				$qiandanwei=$value['xs_danwei'];
			}
		} else {
			$danweis[0][0]=$value;
			$qiandanwei=$value['xs_danwei'];
			$danweihao=0;
		}
	}
	$yirens=$duorens=array();
	foreach ($danweis as $value) {
		if (count($value)<2) {  //个人单位
			$yirens[]=$value;
		} else { //多人单位
			$duorens[]=$value;
		}
	}
	$xuanshous=array();
	count($duorens)>1?shuffle($duorens):'';
	count($yirens)>1?shuffle($yirens):'';
	if ($duorens) {
		foreach ($duorens as $value) {
			$xuanshous=array_merge($xuanshous,$value);
		}
	}
	if ($yirens) {
		foreach ($yirens as $value) {
			$xuanshous=array_merge($xuanshous,$value);
		}
	}
//print_r($yirens);exit;
	return $xuanshous;
}


/**
* 功能：半区分别随机，区分上下半区的随机，上半区在前
* 参数：
* 返回：
*/
function banqumoshi($xuanshous) {
	$linshi=array();
	foreach ($xuanshous as $key => $value) {
		$linshi[$key]['xs_id']=$value['xs_id'];
		$linshi[$key]['xs_banqu']=$value['xs_banqu'];
		$linshi[$key]['xs_xuhao']=$value['xs_xuhao'];
	}
	$xuanshous=$linshi;   //注意：为了简化数据，返回时需要特别注意
	unset($linshi);
	
	$shangbanqus=$buqufens=$xiabanqus=array();
	foreach ($xuanshous as $value) {
		if ($value['xs_banqu']) {
			if ($value['xs_banqu']==1) {
				$shangbanqus[]=$value;
			} else {
				$xiabanqus[]=$value;
			}
		} else {
			$buqufens[]=$value;
		}
	}
	
	shuffle($shangbanqus);
	shuffle($buqufens);
	shuffle($xiabanqus);
	$xuanshous=array_merge($shangbanqus,$buqufens);
	$xuanshous=array_merge($xuanshous,$xiabanqus);
//print_r($xuanshous);exit;
	return $xuanshous;
}
/////半区分别随机 的排序模式？？


//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>