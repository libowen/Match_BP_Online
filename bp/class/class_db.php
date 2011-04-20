<?php
/**
功能：数据库的基础操作类
**/
//include("../config.inc.php");//本系统在每个页面前都调用了此文件，这里不用再次调用
class DB{
	private $CONN = "";									//定义数据库连接变量
	/**
	 * 功能：初始化构造函数，连接数据库
	 * 参数：
	 * 返回：数据库连接$conn
	 */
	public function __construct(){
		try {											//捕获连接错误并显示错误文件
			$conn = mysql_connect(ServerName,UserName,PassWord);
		}catch (Exception $e)
		{
			$msg = $e;
			include(ERRFILE);
		}
		try {											//捕获数据库选择错误并显示错误文件
			mysql_select_db(DBName,$conn);
			mysql_query("set names utf8");            //另外限定编码类型！
		}catch (Exception $e)
		{
			$msg = $e;
			include(ERRFILE);
		}
		$this->CONN = $conn;
	}
	/**
	 * 功能：数据库查询函数
	 * 参数：$sql SQL语句
	 * 返回：键值为字段名的数组或false
	 */
	public function select($sql = ""){	
		if (empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if (empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$results = mysql_query($sql,$this->CONN);
		}catch (Exception $e){
			$msg = $e;
			include(ERRFILE);
		}		
		if ((!$results) or (empty($results))) {			//如果查询结果为空则释放结果并返回FALSE
			@mysql_free_result($results);
			return false;
		}
		
		$count = 0;
		$data = array();
		
		while ($row = @mysql_fetch_assoc($results)) {	//把查询结果重组成一个键值为字段名的一维数组
			$data[$count] = $row;
			$count++;
		}		
		@mysql_free_result($results);		
		return $data;
	}
	/**
	 * 功能：数据插入函数
	 * 参数：$sql SQL语句
	 * 返回：0或新插入数据的id
	 */
	public function insert($sql = ""){
		if (empty($sql)) return 0;						//如果SQL语句为空则返回FALSE
		if (empty($this->CONN)) return 0;				//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$results = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);
		}
		if (!$results) 									//如果插入失败返回0，否则返回当前插入数据id
			return 0;
		else
			return @mysql_insert_id($this->CONN);
	}
	
	/**
	 * 功能：数据更新函数
	 * 参数：$sql SQL语句
	 * 返回：TRUE OR FALSE
	 */
	public function update($sql = ""){
		if(empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if(empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{											//捕获数据库选择错误并显示错误文件
			$result = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);
		}
		return $result;
	}
	/**
	 * 功能：数据删除函数
	 * 参数：$sql SQL语句
	 * 返回：TRUE OR FALSE
	 */
	public function delete($sql = ""){
		if(empty($sql)) return false;					//如果SQL语句为空则返回FALSE
		if(empty($this->CONN)) return false;			//如果连接为空则返回FALSE
		try{
			$result = mysql_query($sql,$this->CONN);
		}catch(Exception $e){
			$msg = $e;
			include(ERRFILE);
		}
		return $result;
	}
	
	/**
	 * 功能：定义事务
	 */
	public function begintransaction()
	{
		mysql_query("SET  AUTOCOMMIT=0");				//设置为不自动提交，因为MYSQL默认立即执行
		mysql_query("BEGIN");							//开始事务定义
	}
	/**
	 * 功能：回滚
	 */
	public function rollback()
	{
		mysql_query("ROOLBACK");
	}
	/**
	 * 功能：提交执行
	 */
	public function commit()
	{
		mysql_query("COMMIT");
	}
	
	/**
	 * 功能：提取指定表的指定id的记录，默认是比赛表的
	 * 参数：$id 表id,$dbname 表名称,$where id所对应的字段
	 * 返回：表中符合条件所有行，只一行则返回一维数组，2行以上返回2维数组{符合条件所有行}
	 */
	public function getInfo($id,$dbname,$where="bs_id")
	{
		$sql = "SELECT * FROM " . $dbname . " WHERE $where = '".$id."'";
		$r = $this->select($sql);
		
		if (isset($r[1])) {
			return $r;
		}else{
			return $r[0];
		}
		//return $r[0];
	}
	
	/**
	 * 功能：向指定表中插入数据
	 * 参数：$dbname 表名称,$data 数组(格式：$data['字段名'] = 值)
	 * 返回：插入记录id
	 */
	public function insertData($dbname,$data)
	{
		$field = implode(',',array_keys($data));			//定义sql语句的字段部分
		$i = 0;
		foreach($data as $key => $val)						//组合sql语句的值部分
		{
			$value.= "'" . $val . "'";
			if($i < count($data) - 1)						//判断是否到数组的最后一个值
				$value.= ",";
			$i++;
		}
		$sql = "INSERT INTO " . $dbname . " (" . $field . ") VALUES(" . $value . ")";
		return $this->insert($sql);
	}
	/**
	* 功能：更新指定表指定id的调查表记录（默认是操作比赛表的，但选手表不适用此函数）
	* 参数：$dbname 表名称,$id 表id,$data 数组(格式：$data['字段名'] = 值)
	* 返回：TRUE OR FALSE
	*/
	public function updateData($dbname,$id,$data,$where="bs_id"){	 
		$col = array();
		foreach ($data as $key => $value)
		{
			$col[] = $key . "='" . $value . "'";
		}
		$sql = "UPDATE " . $dbname . " SET " . implode(',',$col) . " WHERE $where = $id";
		return $this->update($sql);
	}
	
	/**
	 * 功能：删除指定id的表记录（默认是操作比赛表的，选手表不适用此函数）
	 * 参数：$id表id,$dbname 表名称
	 * 返回：TRUE OR FALSE
	 */
	public function delData($id,$dbname,$where="bs_id")
	{
		$sql = "DELETE FROM " . $dbname . " WHERE $where = '".$id."'";
		return $this->delete($sql);
	}
}

?>
