<?php
/**
* FILE_NAME : saishi.php   FILE_PATH : F:\PHPnow\htdocs\bp\user\saishi.php
* 我的赛事，个人创建的比赛：显示列表，有编辑跳转按钮（跳转）和删除按钮（需再次确定）；是否分完成和未完成？
*
* @copyright Copyright (c) 2010
* 备注：权限??1、只能修改自己的比赛；2、查看比赛也需要涉及到权限；3、删除比赛必须是自己的（完成）;$bsinfo和$bisais有所不同；以后可以考虑按各种条件排序
*/
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

//$_GET['bsid']=49;
//$_GET['action']='shanchu';
if (1==1||$_SESSION['bp_userid']) {
        require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
        $bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");		//获取指定比赛的基本信息
        qingqiuzt($_SESSION['bp_userid'],'bisai',$_GET['bsid']);				//所指定的比赛是否存在
        zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');		//权限验证：
		////兼容了三种形式的局分模式
		if(	isset($_POST['jufenmoshi']) ) {
			if (!preg_match("/[\,\;\:]/", $_POST['jufenmoshi'], $fengefu)) {
				exit('<script>alert("局分模式分割的符号不正确！！返回原页面");window.history.back();</script>');  
			}
			$fenzhis=split($fengefu[0], $_POST['jufenmoshi']);  //分制： 红方- 胜 和 负；黑方- 胜和负
			$linshi = count($fenzhis);
			if ($linshi == 4 || $linshi == 3 || $linshi == 6) {
				if ($linshi == 4) {
					//如果为四位模式，则统一转化成6位模式（下面的顺序不能变动）
					$fenzhis[4] = $fenzhis[2];
					$fenzhis[5] = $fenzhis[3];
					$fenzhis[2] = $fenzhis[3];
					$fenzhis[3] = $fenzhis[0];	
					$_POST['jufenmoshi'] = 	join(':', $fenzhis);
				} elseif ($linshi == 3) {
					//如果为四位模式，则统一转化成6位模式（下面的顺序不能变动）
					$fenzhis[3] = $fenzhis[0];	
					$fenzhis[4] = $fenzhis[1];
					$fenzhis[5] = $fenzhis[2];
					$_POST['jufenmoshi'] = 	join(':', $fenzhis);
				}
			} else {
				echo '<script>alert("你设置的局分模式不符合规范，请立即修改！必须如1:0.5:0:1:0.5:0 或 1:0.5:0.5:0 或1:0.5:0模式")</script>';  
			}
		}
		///		
        	if ($_GET['action']=='shanchu') {  //删除指定比赛（bsid）
        		//echo 'shanchu';
                $username=$_SESSION['bp_user'];
				if ($user->shanchubs($username,$_GET['bsid'])) {
					exit('<script>alert("删除成功！");location.href="saishi.php"</script>');
				}else{
					exit('<script>alert("删除失败！？");location.href="saishi.php"</script>');
				}
        	} else { //修改比赛（bsid）
				//echo '修改比赛';
				$message='可编辑';
        		if ($_POST['tijiao']&&$_POST['action']=='bianji') {		//提交比赛信息编辑修改
        			$data=array();
					foreach ($_POST as $key => $value) {
						if ($key!='submit'&&$key!='tijiao'&&$key!='reset'&&$key!='action'
						  //&&!empty($value)
						   &&$key!='biaoti'
						   &&$key!='luruyuan'
						   &&$key!='jianliriqi') {
							//只捕获允许修改的字段
							$data['bs_'.$key]=$value;
						}
					}
					isset($_POST['TTbuyu'])?'':$data['bs_TTbuyu']=0;
					isset($_POST['SXtiao'])?'':$data['bs_SXtiao']=0;
					isset($_POST['Jliansan'])?'':$data['bs_Jliansan']=0;
					isset($_POST['kongbufen'])?'':$data['bs_kongbufen']=0;
					isset($_POST['guobufen'])?'':$data['bs_guobufen']=0;
					//var_dump($data);
        			if ($user->updateData("bp_bisai",$_GET['bsid'],$data,"bs_id")) {
        				$message='编辑成功';
        				$bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id"); //更新后的
        			}else{
        				$message='编辑失败！';
        			}        			
        		}
        		//权限，会员只是不能查看其他会员私密的比赛（朋友的呢？！）
        		//显示编排页面内容，未提交修改
        		$title='编辑指定比赛的基本信息';                           				//页面的标题
				$zhutibiaoti='【'.$bsinfo['bs_id'].'】《'.$bsinfo['bs_biaoti'].'》 '.$message;     //主体左侧窗口内容的标题
    		    $zhutizuoceFile='xiugaibs.php';
        	}
        	
		}else{  //没有进行编排或删除操作，正常显示或查询中
			$data=array();
			if ($_POST['tijiao']) {  //条件查询（只有条件查询才提交此字段）
				$title='我的赛事=查询';             //页面的标题
				$zhutibiaoti='我创建的赛事=查询：【条件】';    //主体左侧窗口内容的标题
				
				$_POST['biaoti']?$data['bs_biaoti']=$_POST['biaoti']:'';
				$_POST['BSxiangmu']?$data['bs_BSxiangmu']=$_POST['BSxiangmu']:'';
				$_POST['didian']?$data['bs_didian']=$_POST['didian']:'';
				$_POST['shijian']?$data['bs_shijian']=$_POST['shijian']:'';
				//是否要先检查日期的正确性呢？！
				$_POST['jianliriqi1']?$data['bs_jianliriqi1']=$_POST['jianliriqi1']:'';
				$_POST['jianliriqi2']?$data['bs_jianliriqi2']=$_POST['jianliriqi2']:'';
				
				$data['bs_luruyuan']=$_SESSION['bp_user'];  //指定在自己创建的比赛中查询
			}else{   //一般显示，我的赛事列表
				$title='我的赛事';             //页面的标题
				$zhutibiaoti='我创建的赛事';    //主体左侧窗口内容的标题
				$data['bs_luruyuan']=$_SESSION['bp_user'];
			}
			$limit='0,30';                //限制每页显示的数量，好像难于获取总数量！
			$fenye='注意：每页最多30条，可能未完全显示！';
			$bisais=$user->chaxunbs($_SESSION['bp_user'],$data,$limit);
			if ($bisais['bs_id']) {
				$linshi=$bisais;
				$bisais=array();
				$bisais[0]=$linshi;
			}else{
				$bsids=array();
				foreach ($bisais as $value){
					$bsids[]=$value['bs_id'];
				}
				array_multisort($bsids,$bisais);
			}
		    //主体左侧的内容，即zhutibiaoti下面
			$zhutizuoceFile='saishi.php';
	   }
}else{//没有登录的，跳转到频道首页，来登录
	exit('<script>if (confirm("账户登录后才能拥有和查看自己的赛事仓库！确定则转到登录页（频道首页），或取消则返回原页面")) {location.href="/bp/index.php"} else {window.history.back();}</script>');  
}


include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>