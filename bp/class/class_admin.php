<?php
/**
* FILE_NAME : class_admin.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\class_admin.php
* 管理员的操作
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Mon Feb 15 14:39:39 CST 2010
*/
include("../class/class_db.php");

/**
* 功能：管理员的操作
*/
class ADMIN extends DB{

	/**
	* 功能：管理员登陆
	* 参数：$name,$pass
	* 返回：会员表单中对应的数组 OR FALSE
	*/
	function denglu($name,$pass){
	   $sql="SELECT * FROM bp_admin WHERE a_name = '".$name."' AND a_pas = '".$pass."'";
	   $r=$this->select($sql);
	   return $r[0];
	}
	
	/**
	* 功能：会员列表
	* 参数：$count=20 每页的显示数,$page=1 页码
	* 返回：会员的信息列表 OR FALSE
	*/
	function userList($count=20,$page=1){
	   $sql="SELECT * FROM bp_user LIMIT ".$count*($page-1).",".$count;
	   return $this->select($sql);
	}
	
	/**
	* 功能：获取所有的比赛基本信息列表
	* 参数：$count=20 每页的显示数,$page=1 页码
	* 返回：比赛的基本信息列表 OR FALSE
	*/
	function bsList($count=20,$page=1){
	   $sql="SELECT * FROM bp_bisai LIMIT ".$count*($page-1).",".$count;
	   return $this->select($sql);
	}
	
	/**
	* 功能：获取某会员的详细信息
	* 参数：$u_id
	* 返回：表中符合条件所有行，只一行则返回一维数组，
	*/
	function getUserInfo($u_id=''){
	   return $this->getInfo($u_id,"bp_user","u_id");
	}
	
	/**
	* 功能：获取指定比赛的基本信息
	* 参数：$bs_id
	* 返回：表中符合条件所有行，只一行则返回一维数组  OR FALSE
	*/
	function bsInfo($bs_id=''){
	   return $this->getInfo($bs_id,"bp_bisai","bs_id");
	}
	
	/**
	* 功能：修改会员的信息
	* 参数：$u_id 对象会员,$data 修改的信息
	* 返回：TRUE OR FALSE
	*/
	function editUser($u_id,$data){
	    return $this->updateData("bp_user",$u_id,$data,"u_id");
	}
	
	/**
	* 功能：删除指定会员
	* 参数：$u_id 对象会员；
	* 返回：TRUE OR FALSE 
	*/
	function delUser($u_id){
	   return $this->delData($u_id,"bp_user","u_id");
	}
	
	/**
	* 功能：删除指定比赛（基本信息和其选手的编排信息）
	* 参数：$bs_id 对象比赛，对应bp_bisai表的bs_id xuanshou表的xs_bs_id
	* 返回：TRUE OR FALSE
	*/
	function delBisai($bs_id){
	   if ($this->delData($bs_id,"bp_xuanshou","xs_bs_id")
	   ||$this->delData($bs_id,"bp_bisai","bs_id")) {
	   	return TRUE;
	   }else {
	   	return FALSE;
	   }
	}
	
	
	
	
}




?>