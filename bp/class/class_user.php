<?php
/**
* FILE_NAME : class_user.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\class_user.php
* 实现会员基本操作功能的类class USER: fun??zhuce注册，denglu登陆，zigai修改个人信息，xinjianbs新建比赛，xiugaibs修改比赛的基本信息，chaxunbs查询，shanchubs删除比
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Thu Jan 28 14:57:54 CST 2010
*/
require_once(CLASS_PATH."class_db.php");
/**
* 功能：会员的zhuce注册，denglu登陆，zigai修改个人信息，xinjianbs新建比赛，xiugaibs修改比赛的基本信息，chaxunbs查询，shanchubs删除比
*/
class USER extends DB{
	/**
	* 功能：检查指定查询是否已有记录，用于检查注册用户是否可用 等
	* 参数：$name 要检测的会员名，$dbname 表名称
	* 返回：TRUE OR FALSE
	*/
	function checkname($name,$dbname,$where="u_name"){
	   $sql = "SELECT * FROM " . $dbname . " WHERE $where = '".$name."'";
	   $r=$this->select($sql);
	   if ($r) {
	   	 return TRUE;
	   }else{
	   	 return FALSE;
	   }
	}
	
	/**
	* 功能：指定会员的详细信息，在此一般只能查询到自己的=等效getInfo($_SESSION['bp_userid'],"bp_user","u_id")
	* 参数：$username 或 $userid
	* 返回：会员的详细信息
	*/
	function userinfo($userid='',$username='') {
		$sql = "SELECT * FROM bp_user WHERE ";
		if ($userid&&is_numeric($userid)) {
			$sql.="u_id = '".$userid."'";
		} elseif ($username) {
			$sql.="u_name = '".$username."'";
		} else {
			
			exit('<script>alert("没有指定账户或输入数据格式错误！返回原页面");window.history.back();</script>');  
		}
		$r=$this->select($sql);
		return $r[0];
	}
	
	/**
	* 功能：注册会员
	* 参数：$data数组(格式：$data['字段名'] = 值)包括u_name 要注册的名字，u_pas 设置的密码，等
	* 返回：会员表单中对应的id值 OR FALSE
	*/
	function zhuce($data){
	   if(!$this->checkname($data["u_name"],"bp_user","u_name")){
	   	   return $this->insertData("bp_user",$data);
	   }else{
	   	   return FALSE;
	   }
	}
	/**
	* 功能：会员验证登陆
	* 参数：$username 要登录的账号名，$passwork 提交的验证密码
	* 返回：会员表单中对应的数组 OR FALSE
	*/
	function denglu($username,$passwork){
	   $sql="SELECT * FROM bp_user WHERE u_name = '".$username."'";
	   $r=$this->select($sql);
	   if ($r[0]['u_pas']==$passwork) {
	   	   return $r[0];
	   }else{
	   	   return false;
	   }
	}
	/**
	* 功能：修改个人信息（之前应该过滤掉一些重要字段，否则可以注入攻击）
	* 参数：$id 对应会员表的u_id字段，$data数组($data[字段名]=值)
	* 返回：TRUE OR FALSE
	*/
	function zigai($id,$data){
	   return $this->updateData("bp_user",$id,$data,"u_id");
	}
	/**
	* 功能：新建比赛，并同时录入比赛的基本信息和具体的编排模式（权限方面以后再增添）
	* 参数：$data数组($data[字段名]=值)
	* 返回：插入行的id值即bs_id字段的 OR FALSE
	*/
	function xinjianbs($data){
	   return $this->insertData("bp_bisai",$data);
	}
	/**
	* 功能：修改比赛的基本信息和具体的编排模式（权限方面以后再增添）
	* 参数：$bs_id 对应比赛表的bs_id字段，$data数组($data[字段名]=值)
	* 返回：TRUE OR FALSE?
	*/
	function xiugaibs($bs_id,$data){
	   return $this->updateData("bp_bisai",$bs_id,$data,"bs_id");
	}
	/**
	* 功能：条件综合查询比赛，如某会员建立的所有比赛列表（权限方面以后再增添，除别人的私密比赛外）
	* 参数：$u_name 查询比赛的会员name，$data数组($data[查询字段名]=值)[是否模糊查询？时间字段呢？]，$limit=''分页设置【0,30】数字逗号
	* 返回：$r 数组比赛列表
	*/
	function chaxunbs($u_name,$data,$limit=''){
	   $i=1;
	   $sql="SELECT * FROM bp_bisai WHERE ";
	   foreach ($data as $key => $value) {
	   	  if ($key=="bs_biaoti"
	   	      ||$key=="bs_zubie"
	   	      ||$key=="bs_didian"
	   	      ||$key=="bs_shijian"
	   	      ||$key=="bs_xingzhi"
	   	      ||$key=="bs_caipanzhang"
	   	      ||$key=="bs_bianpaiyuan") {
	   	  	 $sql.="$key LIKE '%".$value."%' ";//上面所列字段为模糊匹配
	   	  }else{
		   	  	if ($key=="bs_jianliriqi1"||$key=="bs_jianliriqi2") {//建立比赛的日期区间
		   	  		if ($key=="bs_jianliriqi1") {
		   	  			$sql.="bs_jianliriqi > '".$data['bs_jianliriqi1']."' ";
		   	  		}
		   	  		if ($key=="bs_jianliriqi2") {
		   	  			$sql.="bs_jianliriqi < '".$data['bs_jianliriqi2']."' ";
		   	  		}
		   	  	}else{
		   	  		$sql.=$key." = '".$value."' ";		//其他泪如||$key=="bs_luruyuan"
		   	  	}
	   	  }
	   	  if ($i<count($data)) {
	   	  	 $sql.=" AND ";
	   	  }
	   	  $i++;
	   }
	   if ($limit) {
	   	  $sql.=' LIMIT '.$limit;
	   }
	   $r=$this->select($sql);
	   return $r;
	}
	
	/**
	* 功能：使用ID来查询，允许多个ID一起
	* 参数：$idsdata 记录ID的数组,$dbname 请求的表名；对应的字段名 $ziduan='u_id',限制数 $limit=''
	* 返回：指定ID存在的所有数据
	*/
	function idschaxun($idsdata,$dbname='bp_bisai',$ziduan='bs_id',$limit='') {
		$sql="SELECT * FROM ".$dbname." WHERE ";
		foreach ($idsdata as $key => $value) {
			$sql.=$ziduan." = '".$value."' ";
			if ($key<count($idsdata)-1) {
				$sql.=" OR ";
			}
		}
		if ($limit) {
			$sql.=" LIMIT ".$limit;
		}
		return $this->select($sql);
	}
	
	/**
	* 功能：查看某个比赛的情况，包括基本信息、编排模式和详细编排信息
	* 参数：$bs_id 对应查看的比赛表的bs_id和选手表的bs_id字段
	* 返回：$r数组($r[字段名]=值)，包括比赛的基本信息、编排模式和当前轮次的成绩详细表 OR FALSE
	*/
	function chakanbs($u_name,$bs_id){
	   $r=$this->getInfo($bs_id,"bp_bisai","bs_id");
	   if ($r['bs_luruyuan']==$u_name&&$r['bs_quanxian']<100) {//应该使用账号等级制的
	   	  $r=array_merge($r,$this->getInfo($bs_id,"bp_xuanshou","bs_id"));
	   	  return $r;
	   }else{
	   	  return FALSE;
	   }
	}
	/**
	* 功能：删除某个比赛，包括比赛表和选手表中相关的(权限设置很重要！只能删除自己建立的)
	* 参数：$bs_id 对应查看的比赛表的bs_id和选手表的bs_id字段，$u_name 进行删除操作的账号名
	* 返回：TRUE OR FALSE
	*/
	function shanchubs($u_name,$bs_id=""){
	   if ($bs_id) {
	   		   $r=$this->getInfo($bs_id,"bp_bisai","bs_id");
	   		   if ($r['bs_luruyuan']==$u_name) {            //检测此比赛是否自己建立的
	   		      if (!$this->delData($bs_id,"bp_xuanshou","xs_bs_id")) {
	   		      	return false;
	   		      }
	   		      if ($this->delData($bs_id,"bp_bisai","bs_id")) {
                  	return true;
	   		      }else{
	   		      	return false;
	   		      }
	   		   }else{
	   		   	 return false;
	   		   }
	   }else{
	   	  return FALSE;
	   }
	}

	/**
	* 功能：对指定比赛的加入选手
	* 参数：$dbname 数据表名；$XSluru 为$_POST['xuanshouluru']的值(序号,姓名,单位,性别,半区,备注,犯规,退赛,..)可按顺序从后可省略;$db_id 指定比赛的编号
	* 返回：TRUE OR FALSE
	*/
	function luruXS($dbname,$bs_id,$XSluru){
	    //提交了表单,提交后显示本次比赛的选手列表，并可修改提交
		//提交的数据$_POST['xuanshouluru'](序号,姓名,单位,性别,...;序号,姓名,单位,性别,半区,备注,犯规,退赛,...;...)空的组不算在内
		//和xs_bs_id的值
		if (strstr($XSluru,',')) {
			$fuhaos=array(',',';');
		}else{
			if (strstr($XSluru,'，')) {
				$fuhaos=array('，','；');
			}else{
				echo '至少一次输入1组以上，或数据格式错误！';
			}
		}
		$keys=array('xuhao','name','danwei','sex','banqu','beizhu','fangui','tuichu');
		$xuanshous=split($fuhaos[1],$XSluru);
		//去除两端的空格、换行等"\0" - NULL 、"\t" - tab 、"\n" - new line 、"\x0B" - 纵向列表符 、"\r" - 回车 、" " - 普通空白字符 
		foreach ($xuanshous as $key => $value){ $xuanshous[$key]=trim($value); }
		foreach ($xuanshous as $value) {
			if ($value) {
				$data=array();
				$data['xs_bs_id']=$bs_id;
				$linshi=split($fuhaos[0],$value);
				foreach ($linshi as $ke => $val){ $linshi[$ke]=trim($val); }
			    /////怎么编制序号，当没有传入序号值时！！！所以目前必须传入序号
				foreach ($linshi as $key => $val) {
					if ($val&&$keys[$key]) { //要预防逗号过多
					   $data['xs_'.$keys[$key]]=$val;
					}
				}
				//插入数据，如果是同一比赛2个以上序号相同呢
				if (!$this->insertData("bp_xuanshou",$data)) {
					echo '插入错误';
					return FALSE;
					//exit;
				}
			}
		}
		return TRUE;
	}
	/**
	* 功能：修改指定比赛中指定选手的信息修改，只能单个修改，
	* 参数：$id 指定xuanshou表的主键
	* 返回：修改指定行的基本信息 OR FALSE
	*/
	function xiugaiXS($id,$data){
	   return $this->updateData("bp_xuanshou",$id,$data,"xs_id");
	}
	
	/**
	* 功能：删除指定选手，在xuanshou表中
	* 参数：$dbname,$bsid,$xuhao,$xsid=''
	* 返回：成功TRUE OR FALSE
	*/
	function shanchuXS($dbname,$bsid,$xuhao,$xsid=''){
	   if ($xsid) {
	   	  $sql="DELETE FROM ".$dbname." WHERE xs_id='".$xsid."'";
	   	  if ($this->delete($sql)) {
	   	  	  return TRUE;
	   	  }else{
	   	  	  return FALSE;
	   	  }
	   }else{
	   	   $sql="DELETE FROM ".$dbname." WHERE xs_bs_id='".$bsid."' AND xs_xuhao='".$xuhao."'";
	   	   if ($this->delete($sql)) {
	   	   	   return TRUE;
	   	   }else{
	   	   	   return FALSE;
	   	   }
	   }
	}
	
	/**
	* 功能：根据条件data数组，查询选手
	* 参数：
	* 返回：符合条件的选手数组
	*/
	function chaxunxs($u_name,$data,$limit=''){
		$i=1;
	   	$sql="SELECT * FROM bp_xuanshou WHERE ";
	   	foreach ($data as $key => $value) {
	   	  if ($key=="xs_name") {
	   	  	 $sql.="$key LIKE '%".$value."%' ";//上面所列字段为模糊匹配
	   	  }else{
		   	 $sql.=$key." = '".$value."' ";		//其他泪如||$key=="bs_luruyuan"
	   	  }
	   	  if ($i<count($data)) {
	   	  	 $sql.=" AND ";
	   	  }
	   	  $i++;
	   	}
	   	if ($limit) {
	   	  $sql.=' LIMIT '.$limit;
	   	}
	   $r=$this->select($sql);
	   return $r;
	}
	
	
	/**
	* 功能：保存xuanshou表中的编排信息，保存成绩 或 对阵
	* 参数：$bs_id 指定比赛； $xs_xuhao 选手的序号； $data($data[字段名]=值) $key=defen或taihaos towhos xianhous xianshu
	* 返回：TRUE OR FALSE
	*/
	function baocunBP($bs_id,$xs_xuhao,$data){
		$sql="UPDATE  bp_xuanshou  SET  ";
		if (isset($data['xs_defen'])) {
			//保存成绩的操作
			$sql.=" xs_zongfen=xs_zongfen+'".$data['xs_defen']."' ,
			        xs_fenshus=CONCAT(xs_fenshus,',".$data['xs_defen'].",'),
			        xs_lianqis=CONCAT(xs_lianqis,'".$data['xs_lianqis']."') ";
		}else{
			//fenshus为空，则为保存编排对阵的操作。taihaos有引号保卫 towhos有引号保卫 xianhous
			$sql.="xs_taihaos=CONCAT(xs_taihaos,',".$data['xs_taihaos'].",'), 
			       xs_towhos=CONCAT(xs_towhos,',".$data['xs_towhos'].",'), 
			       xs_xianhous=CONCAT(xs_xianhous,'".$data['xs_xianhous']."'),
			       xs_shangxias=CONCAT(xs_shangxias,'".$data['xs_shangxias']."')  ";
		}
		$sql.=" WHERE  xs_bs_id ='".$bs_id."' AND xs_xuhao='".$xs_xuhao."'";
		return $this->update($sql);
	}

    //根据会员等级或积分或金币，创建的数量有所限制？已经加入到xinjian.php
    //是数字的为数值也可以是字符串代表对应字段
	function xinjianquanxian($userid,$dengji='',$jifen='',$jinbi='') {
		
	}
	
	//新建成功则可以减去相关的积分或金币，或增加经验等
	 //是数字的为数值也可以是字符串代表对应字段
	function xinjiandaijia ($userid,$dengji='',$jifen='',$jinbi='') {
		
	}
}
?>