<?php
session_start();
include("../config.inc.php");
@require_once(INCLUDE_PATH."yanzheng.php");

if ($_SESSION['bp_userid']) {
	if ($_GET['bsid']&&is_numeric($_GET['bsid'])) {
		require_once(CLASS_PATH."class_user.php");
		$user=new USER();
		$bsid=$_GET['bsid'];
//$bsid=$_GET['bsid']=71;
        //权限，不是管理员不能操作
        $bsinfo=$user->getInfo($bsid,"bp_bisai","bs_id");
        if (!$bsinfo) {
        	exit('<script>alert("所指定赛事不存在！");location.href="saishi.php"</script>');
        }
        if ($bsinfo['bs_luruyuan']!=$_SESSION['bp_user']) {
        	exit('<script>alert("你不是本赛事的管理员！不能进行下面操作");location.href="saishi.php"</script>');
        }
        $xuanshous=$user->getInfo($bsid,"bp_xuanshou","xs_bs_id");
		if (!$xuanshous||$xuanshous['xs_id']) {//也排除只一个选手的情况
			exit('<script>alert("还没有录入选手！");location.href="xsgl.php?bsid='.$bsid.'&&rukou=luru"</script>');
		}
		
		
		
		
	}
}



error_reporting(E_ALL ^ E_NOTICE);
if($_POST) {
$Import_TmpFile = $_FILES['file']['tmp_name'];
require_once CLASS_PATH.'excelreader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8');  
	//		$Import_TmpFile ='D:\linshi.xls';
	//		$Import_TmpFile ='D:\ceshi.xls';
	//		$Import_TmpFile ='D:\daoru.xls';
	//		$Import_TmpFile ='D:\duizhen.xls';
	//		$Import_TmpFile ='D:\mytest.xls';
	//		$Import_TmpFile ='D:\ce.xls';
$data->read($Import_TmpFile);
$array =array();
    
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        $array[$i][$j] = $data->sheets[0]['cells'][$i][$j];
    }
}
var_dump($array);


}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>导入测试</title>
	<script type="text/javascript">
	function import_check(){
	    var f_content = form1.file.value;
	    var fileext=f_content.substring(f_content.lastIndexOf("."),f_content.length)
	        fileext=fileext.toLowerCase()
	     if (fileext!='.xls')
	        {
	         alert("对不起，导入数据格式必须是xls格式文件哦，请您调整格式后重新上传，谢谢 ！");            
	         return false;
	        }
	}
	</script>

</head>
	<body>

	
	<form enctype="multipart/form-data" method="post" action="">
	    <table width="98%" border="0" align="center" style="margin-top:20px; border:1px solid #9abcde;">
	        <tr >
	            <td height="28" colspan="2" background="../skins/top_bg.gif"><label>  <strong><a href="#">小学数学题目数据导入</a></strong></label></td>
	        </tr>
	        <tr>
	            <td width="18%" height="50"> 选择你要导入的数据表</td>
	            <td width="82%"><label>
	            <input name="file" type="file" id="file" size="50" />
	            </label>
	                <label>
	                <input name="button" type="submit" class="nnt_submit" id="button" value="导入数据"    onclick="import_check();"/>
	                </label>
	 		</td>
	        </tr>
	        <tr>
	            <td colspan="2" bgcolor="#DDF0FF">  [<span class="STYLE1">注</span>]数据导入格式说明:</td>
	        </tr>
	        <tr>
	            <td colspan="2">    1、其它.导入数据表文件必须是<strong>execel</strong>文件格式{.<span class="STYLE2">xls</span>}为扩展名．</td>
	        </tr>
	        <tr>
	            <td colspan="2">  2、execel文件导入数据顺序必须如：序号    | 题目    </td>
	        </tr>
	        <tr>
	            <td colspan="2"> </td>
	        </tr>
	    </table>
	</form>
	</body>
</html>