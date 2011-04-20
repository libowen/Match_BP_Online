<?php
/**
 * FILE_NAME : yanzheng.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\include\yanzheng.php
 * 集中过滤传递到服务器的数据，
 *
 * @copyright Copyright (c) 2010
 */
 
header("Content-type: text/html; charset=utf-8");//统一编码！

if ($_GET) {//如果GET传递的值不为空，则进行数据过滤
	foreach ($_GET as $key => $value) {
		if (is_array($value)) {
			foreach ($value as $ke => $val) {
				if (is_array($val)) {
					exit('不能有三维数组');
				}else{
					guolv($val);
					$_GET[$key][$ke]=htmlspecialchars($val);	
				}
			}
		}else{
			guolv($value);
			$_GET[$key]=htmlspecialchars($value);
			if ($key=="pas") {
				$_GET[$key]=md5($_GET[$key]);
			}
		}
	}
}
if ($_POST) {//如果POST传递的值不为空，则进行数据过滤
	foreach ($_POST as $key => $value) {
		if (is_array($value)) {
			foreach ($value as $ke => $val) {
				if (is_array($val)) {
					exit('不能有三维数组');
				}else{
					guolv($val);
					$_POST[$key][$ke]=htmlspecialchars($val);
				}
			}
		}else{
			guolv($value);
			$_POST[$key]=htmlspecialchars($value);
			if ($key=="pas"||$key=="pass"||$key=="passwork"||$key=="mima") {
				$_POST[$key]=md5($_POST[$key]);
			}	
		}
	}
}
/**
 * 功能：过滤掉恶意符号，
 * 参数：each $_GET 的值，
 * 返回：TRUE OR FALSE+exit
 */
function guolv($shuju){
   $jiankong="/[\>\/\'\"\<\&]/";           //不能含有的字符段，有待增添（true，false作用户名？！）
   if (preg_match($jiankong,$shuju,$huairen)) {
//  echo '不可以包含以下字符：'.$huairen[0];
   	//print_r($huairen);
   	exit('传入值包含非法符号，请认真检查所输入的数据！');
   }
}

/**
 * 功能：查看等级（创建者设置）和写入的权限控制，/指定比赛才判断；没有指定哪个比赛，则默认通过而不做任何处理	
 * 参数：用户的账号名（可以为空），用户所在的组别（游客、会员、将来会员还要分级、社团管理员、分站管理员、站点管理员）一般不使用； 指定的bsid比赛ID； 所请求的操作（编排、保存编排、保存成绩、修改***、新建比赛、删除**、查看、查询、恢复）；
 * 返回：无返回，不通过则终止程序和跳出错误提示
 */
function zuquanxian($username,$yonghuzu,$bsid='',$caozuo='caozuo') {		//查看等级（创建者设置）和写入的权限控制
	if ($bsid) {  //指定比赛才判断；没有指定哪个比赛，则默认通过而不做任何处理	
			if ($GLOBALS['bsinfo']) {
				$bsinfo=&$GLOBALS['bsinfo'];
			} else {
				$user?'':$user=new USER();		//！需要保证classUser.php文件已经载入了
				$bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
			}
			
			if (!$bsinfo) {
				
				exit('<script>alert("你指定的比赛不存在！返回原页面"); window.history.back();</script>');  
			}
			////下面相当于查看权限的判断
			if ($_POST['tijiao']||$_GET['tijiao']||$_POAT['action']||$_GET['action']) {///注意！这个不能完美解决！
				if ($username) {  //登录了的账户  //也就是读取操作可以，写入不可以
					if ($bsinfo['bs_luruyuan']!=$username) {
						
						exit('<script>alert("你不是本赛事的管理员！不能进行任何写入的操作！返回原页面"); window.history.back();</script>');
					}			
				} else {	//没有登录账号，即游客
					
					exit('<script>alert("你不是本赛事的管理员！不能进行任何写入的操作！返回原页面"); window.history.back();</script>');
				}
			}
			
			///下面相当于写入操作权限的判断
			if (!$bsinfo['bs_quanxian']||$bsinfo['bs_quanxian']<1) {
				//暂时默认
			} elseif ($bsinfo['bs_quanxian']>=1&&$bsinfo['bs_quanxian']<100) {   ///允许会员读取
				if (!$username) {
					
					exit('<script>alert("本赛只允许会员查看！不能进行下面的操作，即将返回原页面"); window.history.back();</script>');
				}
			} else {		//暂时只有自己可以读取
				if ($bsinfo['bs_luruyuan']!=$username) {
					
					exit('<script>alert("本赛私有，请联系本赛事的管理员！不能进行下面的操作，将返回原页面"); window.history.back();</script>');
				}
			}
	}
}

/**
* 功能：公共的请求状态判断
* 参数：$username,$duixiang='bisai' or 'xuanshou' or 'danwei'；$bsid 指定的比赛的ID
* 返回：无返回，不通过则终止程序和跳出错误提示
*/
function qingqiuzt($username,$duixiang,$bsid) {
	switch ($duixiang) {
		case 'bisai':
		if ($bsinfo) {
			$bsinfo=&$GLOBALS['bsinfo'];
		} else {
			$user?'':$user=new USER();
			$bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
		}
		if (!$bsinfo) {
			exit('<script>alert("所指定赛事不存在！返回原页面"); window.history.back();</script>');
		}
			break;
			
		case 'xuanshou':
		if ($GLOBALS['xuanshous']) {
			$xuanshous=&$GLOBALS['xuanshous'];
//print_r($xuanshous);exit();
		} else {
			$user?'':$user=new USER();
			$xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
		}
		if (!$xuanshous||$xuanshous['xs_id']||count($xuanshous)<6) {	//也排除只一个选手的情况
			
			exit('<script>alert("还没有录入选手或选手不够6人！"); location.href="/bp/user/xsgl.php?bsid='.$bsid.'&&rukou=luru"</script>');
		}
			break;
			
		case 'danwei':
		if ($danwei&&!$GLOBALS['danweis']) {
			$user?'':$user=new USER();
//		$danweis='';
		} else {
			$danweis=$GLOBALS['danweis'];
		}
		
			break;
			
		default:
			
			exit('<script>alert("暂时没有对应的判断！返回原页面"); window.history.back();</script>');  
			break;
	}
}
?>
