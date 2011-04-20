<?php
/**
* FILE_NAME : cxhf.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\cxhf.php
* 查询恢复：恢复前x轮的编排结果，主要是解决当编排结果不满意又意外保存了编排结果时，回复到前面轮次的编排结果。可选择是否保留那轮的成绩
*
* @copyright Copyright (c) 2010
*/
session_start();
include("../config.inc.php");
require_once(INCLUDE_PATH."yanzheng.php");

require_once(CLASS_PATH."class_user.php");
        //$_POST['tijiao']=3;   $_POST['zonglunshu']=0;   $_GET['bsid']=50;
if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
			$user=new USER();
			$bsid=$_GET['bsid'];
	        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
	        	qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
	        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
//	        	qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
	        	zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
			
	        if ($_POST['action']=='chaxun') { //查询时使用
	        	
	        	
	        	
	        } else {
				// 如果是只传递有GET[zonglunshu]和[action]；也可以恢复，但有限post
				if ( !isset($_POST['zonglunshu']) ) {
					if (isset($_GET['zonglunshu'])&&$_GET['zonglunshu']!==''&&$_GET['action']=='huifudao') {
						$_POST['tijiao']='yes';
						$_POST['zonglunshu']=$_GET['zonglunshu'];
						isset($_GET['chengji'])?$_POST['chengji']=$_GET['chengji']:$_POST['chengji']=1;
					}
				}
				
				if ($_POST['tijiao']&&$_POST['zonglunshu']!==''&&$_GET['bsid']!=='') {
						$lun=$_POST['zonglunshu'];//保留前 多少轮的编排结果，
						$_POST['chengji']?$cjliu=1:$cjliu=0;//是否保留那轮次的成绩 1 OR 0
						//检查如果恢复是否符合规范
						//涉及的字段：xs_zongfen;xs_fenshus;xs_taihaos;xs_towhos;xs_xianhous;
						//总分：fenshus处理后的各项之和
						//fenshus：截取前$lun-abs($cjliu-1)轮次的成绩
						//taihaos；towhos；xianhous：截取前$lun轮次的
						require_once(INCLUDE_PATH."function.php");
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
								exit('<script>alert("恢复中断，请重试！返回原页面"); window.history.back();</script>');  
							}
						}
						$liufou = ($_POST['chengji']||$_GET['chengji']) ? '' : '不';
						$linshi = isset($_GET['zonglunshu']) ? $_GET['zonglunshu'] : $_POST['zonglunshu'];
						$linshibackurl =  (isset($_GET['chengji'] )) ? ('/bp/user/dengfen.php?bsid='.$_GET['bsid']): ('/bp/user/bianpai.php?bsid='.$_GET['bsid']);
						echo '<script>alert("成功恢复到第'.$linshi.'轮！此轮成绩'.$liufou.'保留"); if(!document.referrer || document.referrer.search("cxhf.php")==-1){location.href="'.$linshibackurl .'"; } </script>';  //应该提示目前的轮次，和此轮次成绩是否登入
				}
				//指定赛事后，显示恢复填写窗口
				$title=$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》查询恢复';
				$zhutizuoceFile='cxhf.php';
	        }
	}else{
		//bsid不正确或无
		$title=$zhutibiaoti='查询恢复-未指定比赛';
		$zhutizuoce='<div style="height: 200px; padding: 50px; font-size: 30px;">请指定赛事ID！
						<br>
						<form action="" method="get">
						   <input type="text" name="bsid" value="" size="5">
						   <input type="submit" value="提交">
						</form>
					</div>';
	}
}else{
	//没登录的不能进入此页
	exit('<script>alert("你还没登陆，请先登录！");location.href="/bp/index.php"</script>');
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