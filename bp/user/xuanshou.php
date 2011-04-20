<?php
/**
 * 功能：选手的详细信息查询和修改，可指定一个选手（bsid+xsxuhao）或多个（bsid+xsxuhaos）
 * 
 */
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

if (1==1||$_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsinfo=$user->getInfo($_GET['bsid'],"bp_bisai","bs_id");
        qingqiuzt($_SESSION['bp_user'],'bisai',$_GET['bsid']);
        $xuanshous=$user->getInfo($_GET['bsid'],"bp_xuanshou","xs_bs_id");
        qingqiuzt($_SESSION['bp_user'],'xuanshou',$_GET['bsid']);
        zuquanxian($_SESSION['bp_user'],'user',$_GET['bsid'],'caozuo');
        	require_once(CLASS_PATH."class_user.php");
			$user=new USER();
       if ($_POST['tijiao']) {
        	//修改指定选手的信息  bsid和xsxuhao
        	$col=$data=array();
			foreach ($_POST as $key => $value) {
			     if ($key=='danwei'
			     ||$key=='zongfen'||$key=='sex'||$key=='banqu'
			     ||$key=='fangui'||$key=='tuichu') {   //其他的不允许修改
			     	 $data['xs_'.$key]=$value;
			     }
			}
			isset($_POST['tuichu'])?'':$data['xs_tuichu']=0;
			foreach ($data as $key => $value) {
				$col[] = $key . "='" . $value . "'";
			}
			$sql = "UPDATE bp_xuanshou SET " . implode(',',$col) . " WHERE xs_bs_id = '".$_GET['bsid']."' AND xs_xuhao = '".$_POST['xuhao']."' ";
			if ($user->update($sql)) {
				
				exit('<script>alert("修改选手信息成功！");  window.history.back();</script>');  
			} else {
				
				exit('<script>alert("修改选手失败！请重试");  window.history.back();</script>');  
			}
        } else {   //查询指定赛事的指定选手的信息
			$data=array();
			if ($_GET['bsid']&&is_numeric($_GET['bsid'])&&$_GET['bsid']>0) {
				$data['xs_bs_id']=$_GET['bsid'];
			} else {
				
				exit('<script>alert("必须指定比赛ID且为正整数！返回原页面");  window.history.back();</script>');  
			}
			$_GET['xsxuhao']?$data['xs_xuhao']=$_GET['xsxuhao']:'';
			$_GET['name']?$data['xs_name']=$_GET['name']:'';
			$xss=$user->chaxunxs($_SESSION['bp_user'],$data,'');   //这个选手数组一般是不全的
//print_r($xss);
			///只一个则显示详细信息；如果多于一个则显示列表和第一个的详细信息
			if ($xss) {
				$xs=$xss[0];	
			} else {
				
				exit('<script>alert("没有任何符合查询条件的选手！返回原页面"); window.history.back();</script>');  
			}
        }
		if (!$xs) {
			exit('<script>alert("所指定选手不存在！返回原页面"); window.history.back();</script>');  
		}
        $xuanshous=xsKEYxuhao($xuanshous);		//转换选手数组成以各自序号为键值
			///////V比较原始的数据数组/
		$fenShuLun=count(explode(',,',trim($xs['xs_fenshus'],',')));	//已经登分的轮次（到目前的，而非处理后的！）
		if (isset($_GET['lunci'])) {
			if ($_GET['lunci']<1||$_GET['lunci']>$fenShuLun) {
				
				exit('<script>alert("指定的轮次不再常规范围内！返回原页面"); window.history.back();</script>');  
			}
			$lunci=$_GET['lunci'];	
		} else { //没有传递lunci来，默认最后fenshulun的结果（不包含已编排没登分的）
			$lunci=$fenShuLun;
		}
		$shuJus=array($xs['xs_fenshus'],$xs['xs_taihaos'],$xs['xs_towhos'],$xs['xs_xianhous'],$xs['xs_shangxias'],$xs['xs_lianqis']);
		foreach ($shuJus as $key => $value) {
			if ($key<3) {	 	//前三个是数字加逗号的！shuJus变动也随之变动！
				$shuChus[$key][0]=explode(',,',trim($value,','));
			} else {			//三个之后的是单符号的
				$shuChus[$key][0]=str_split(trim($value));
			}
			$shuChus[$key][0]=array_slice($shuChus[$key][0],0,$lunci);  //截取设定轮次的结果 lunci
			$shuChus[$key][1]=BuChangJuLie($shuChus[$key][0],4,'&nbsp;','&nbsp;',1);
		}
		$fenShus=$shuChus[0][0];			//选手各轮 得分 数组（非各轮的积分）
			$fenShuLie=$shuChus[0][1];
		$taiHaos=$shuChus[1][0];			//选手各轮台号数组
			$taiHaoLie=$shuChus[1][1];
		$toWhos=$shuChus[2][0];				//对手序号数组
			$toWhoLie=$shuChus[2][1];
		$xianHous=$shuChus[3][0];			//选手各轮先后手数组
			$xianHouLie=$shuChus[3][1];
		$shangXias=$shuChus[4][0];			//选手上下调数组
			$shangXiaLie=$shuChus[4][1];
		$lianQis=$shuChus[5][0];			//选手弃权的情况数组
			$lianQiLie=$shuChus[5][1];
			//////A比较原始的数据数组///////
		$toWhoLun=count($towhos);								//已经保存编排结果的轮数
		$juFenMoShi=explode(':',$bsinfo['bs_jufenmoshi']);  	//这里没有兼容多种分隔符
		
		//各轮对手姓名数组，各轮对手的当轮积分，胜负序列，
		$duiShouNames=$duiShouDanWeis=$duiShouFens=$shengFus
			=$geLunFens=$duiShouZongFens=$shangLunFens=array();
		$lunshu=1;
		$duiShouFen=0;
		$shengShu=$heShu=$fuShu= $houShengShu=$houShouShu=0;
		$GLOBALS['bsinfo']['bs_konghaofen']?$zuidifen=zuidifen($xuanshous):'';  //选手中的最低分（指定轮次的）
		foreach ($fenShus as $key => $value) {
			if ($toWhos[$key]) {
				$duiShouNames[]=$xuanshous[$toWhos[$key]]['xs_name'];						//lunci轮次的对手姓名
				$duiShouDanWeis[]=$xuanshous[$toWhos[$key]]['xs_danwei'];					//lunci轮次的对手的单位
					$duiShouFenShus=explode(',,',trim($xuanshous[$toWhos[$key]]['xs_fenshus'],','));//对手的得分序列数组，截止指定轮次的
				$duiShouFens[]=array_sum(array_slice($duiShouFenShus,0,$lunshu-1));			//对手在相遇那轮的前一轮积分
				$duiShouZongFens[$key]=array_sum(array_slice($duiShouFenShus,0,$lunci));	//对手到指定轮次时的积分
				
				$duiShouFen+=$duiShouZongFens[$key];   			//对手分总和！注意：到指定轮次lunci的所有对手积分之和
			} else {  ///对手为0，即轮空的情况！  //选手最低分或0分！
				$duiShouNames[]='空号';				//lunci轮次的对手姓名
				$duiShouDanWeis[]='';				//对手的单位
				$duiShouFens[]=0;					//对手在相遇那轮的前一轮积分 就是0分
				if ($GLOBALS['bsinfo']['bs_konghaofen']) {
					//取所有选手的最低分
					$duiShouZongFens[$key]=$zuidifen;			//对手到指定轮次时的积分
				} else {
					$duiShouZongFens[$key]=0;					//对手到指定轮次时的积分
				}
				$duiShouFen+=$duiShouZongFens[$key];   			//对手分总和！注意：到指定轮次lunci的所有对手积分之和
			}
			$shangLunFens[]=array_sum(array_slice($fenShus,0,$lunshu-1));//自身上一轮的积分
			
			$lunshu++;
			
			//获取胜负情况序列
			$linshi=$xianHous[$key]=='+'?0:3;  //区分先后手的得分的不同来判断实际的胜负结果
			$xianHous[$key]=='-'?$houShouShu++:'';        //后手次数
			if ($fenShus[$key]==$juFenMoShi[0+$linshi]) {			//胜
				$shengFus[]='胜';
				$shengShu++;
				$linshi?$houShengShu++:'';
			} elseif ($fenShus[$key]==$juFenMoShi[1+$linshi]) {		//和
				$shengFus[]='和';
				$heShu++;
			} else {												//负
				$shengFus[]='负';
				$fuShu++;
			}
			if ($key) {
				$geLunFens[$key]=$geLunFens[$key-1]+$fenShus[$key];   	//各轮积分数组
			} else {
				$geLunFens[0]=$fenShus[$key];
			}
		}
		$leiJinFen=array_sum($geLunFens);    	//累进分
		
		$zongFen=array_sum($fenShus);			//兼容lunci指定时可能会与$xs['xs_zongfen']不同！
		//$duiShouNames							//各轮对手的姓名数组
		//$duiShouFens							//！各轮的对手当时的积分！
		//$shengFus								//各轮胜负结果
		//$duiShouFen							//对手分总和
		
//print_r($xs); 
        
        $zhutizuoceFile='xuanshou.php';
	} else {
		
		exit('<script>alert("没有指定比赛的ID或不是数字！返回原页面");window.history.back();</script>');  
	}
}


/**
* 功能：转换选手数组成以各自序号为键值
* 参数：$xuanshous 要转换的选手数组
* 返回：以自身序号为键值的选手数组
*/
function xsKEYxuhao($xuanshous) {
	$linshi=array();
	foreach ($xuanshous as $value) {
		$linshi[$value['xs_xuhao']]=$value;
	}
	return $linshi;
}

/**
* 功能：把数组元素补足长度后（多不截取）用分隔符聚合成字符串；（补号不能是X）
* 参数：
* 返回：聚合后的字符串
*/
function BuChangJuLie($shuzu,$chang=4,$buhao='&nbsp;',$gehao='|',$qianjia=1) {
	$lie='';
	foreach ($shuzu as $key => $str) {
		if (strlen($value)<$chang) {
			if ($qianjia) {
				if ($qianjia==2) {	//两头加
					$weizhi='STR_PAD_BOTH';
				} else {			//前加
					$weizhi='STR_PAD_LEFT';
				}
			} else {				//后加
				$weizhi='STR_PAD_RIGHT';
			}
			$shuzu[$i]=str_pad($str,$chang,'X',$weizhi);			
		}
		if ($key>0) {
			$lie.=$gehao.$shuzu[$i];
		} else {
			$lie.=$shuzu[$i];		
		}		
	}
	$lie=str_replace('X',$buhao,$lie);
	return $lie;
}

/**
* 功能：所有选手的最低分
* 参数：一定范围内的选手数组
* 返回：所有选手的最低分
*/
function zuidifen($xuanshous) {
	$fens=array();
	foreach ($xuanshous as $value) {
		$fens[]=$value['xs_zongfen'];
	}
	array_multisort($fens,$xuanshous);
	$zuidifen=$xuanshous[0]['xs_zongfen'];
	return $zuidifen;
}

if (isset($_GET['lunci'])) {
	$luncixinxi='第'.$_GET['lunci'].'轮';
}
$title='【'.$bsinfo['bs_id'].'】（第'.$xs['xs_xuhao'].'选手）'.$xs['xs_name'].' '.$luncixinxi.' 的信息《'.$bsinfo['bs_biaoti'].'》';
$zhutibiaoti='【'.$bsinfo['bs_id'].'】（第'.$xs['xs_xuhao'].'选手）'.$xs['xs_name'].' '.$luncixinxi.' 的信息';

//////////////////可以改变的内容////////////////////
//$title;          //页面的标题
//$zhutibiaoti;    //主体左侧窗口内容的标题
//$css;			   //样式文件的文件名，默认default
//$js;             //js代码文件的文件名，默认default
//$zhutizuoce;     //主体左侧的内容，即zhutibiaoti下面
/////////////////////////////////////////////////

include(INCLUDE_PATH."moban/user.php");    //载入user专用模板
?>