<?php
/**
* Class for the database operation.
*/
class DB_class{
private $host;      //The hostname of database.
private $user;		//The username of database.
private $pwd;		//The password of database.
private $db;		//The name of database.
private $prefix; 	//The prepart of tables name.
private $result;	//The return value.
private $sql;		//The excutive sql words. 
private $row;		//The returned row numbers.
private $conn;      //The connection of database.
private $show_error = true;
/**
*construct function
*/
public function __construct($host="engr-cpanel-mysql.engr.illinois.edu",$user="dotaarmory_admin",$pwd="dotaarmoryftw2014",$db="dotaarmory_main",$prefix ="",$conn="conn"){
	$this->host   = $host;
    $this->user   = $user;
    $this->pwd    = $pwd;
    $this->db     = $db;
	$this->prefix = $prefix;
	$this->conn   = $conn;
    $this->connect();
}
/**
*connect to database.
*/
private function connect(){
	$this->conn=mysql_connect($this->host,$this->user,$this->pwd)or die('Connect to datebase error:'.mysql_error());
	mysql_select_db($this->db);
	mysql_query("SET NAMES 'utf8'");    //设置数据库编码
}
/**
*excute sql query.
*/
public function query($sql){
	if($sql==""){
		$this->show_error("sql command error：","sql command is empty");
	}
	$this->sql=$sql;
	$result=mysql_query($this->sql);
	if(!$result){
		if($this->show_error) 
			$this->show_error("sql command error：",$this->sql); // 调试中使用，sql语句出错时会自动打印出来
	}
	else{
		$this->result=$result;
	}
    return $result;
}
/**
*excute Sql select function.
*/
public function Get($Table,$Fileds="*",$Condition=""){
	if (!$Fileds || empty($Fileds)){$Fileds="*";}
	//echo "SELECT ".$Fileds." FROM ".$this->getprefix().$Table." ".$Condition;
	return $this->query("SELECT ".$Fileds." FROM ".$this->getprefix().$Table." ".$Condition);
}
/**
*excute Sql insert function.
*/
public function Add($Table,$Fileds,$Value){
	//echo "INSERT INTO ".$this->getprefix().$Table." (".$Fileds.") VALUES (".$Value.")";
	return $this->query("INSERT INTO ".$this->getprefix().$Table." (".$Fileds.") VALUES (".$Value.")");
}
/**
*excute Sql update function.
*/
public function Set($Table,$Content,$Condition=""){
	return $this->query("UPDATE ".$this->getprefix().$Table." SET ".$Content." ".$Condition);
}
/**
*excute Sql delete function.
*/
public function Del($Table,$Condition=""){
	return $this->query("DELETE FROM ".$this->getprefix().$Table." WHERE ".$Condition);
}
/**
*return the number of query rows.
*/
public function num_fields($Table){
	$this->query("SELECT * FROM ".$Table);
	echo "<br />";
	echo "字段数：".$total=mysql_num_fields($this->result);
	echo "<pre>";
	for ($i=0; $i<$total; $i++){
		print_r(mysql_fetch_field($this->result,$i));
	}
	echo "</pre><br />";
}
/**
*get the result.
*/
public function result(){
	return mysql_result($str);
}
public function fetch_array(){
	return mysql_fetch_array($this->result);
}
public function fetch_assoc(){
	return mysql_fetch_assoc($this->result);
}
public function fetch_row(){
	return mysql_fetch_row($this->result);
}
public function fetch_obj(){
	return mysql_fetch_object($this->result);
}
public function insert_id(){
	return mysql_insert_id();
}
/**
*return the data based on id.
*/
public function data_seek($id){
	if($id>0){$id=$id-1;}
	if(!@mysql_data_seek($this->result,$id)){$this->show_error("sql语句有误：", "指定的数据为空");}
	return $this->result; 
}
/**
*return the number of query rows.
*/
public function num_rows(){ 
	if($this->result==null){
		if($this->show_error){
			$this->show_error("sql语句错误","暂时为空，没有任何内容！");
		}   
	}
	else{
		return mysql_num_rows($this->result); 
	}
}
/**
*return the number of affected rows.
*/
public function affected_rows(){
	return mysql_affected_rows();
}
public function getQuery(){
	foreach($_GET as $key => $value){
		$list[] .= $key."=".$value;
	}
	return $list?"?".implode("&amp;", $list):"";
}
/**
*show the error information.
*/
public function show_error($message="",$sql=""){
	if(!$sql){
		echo "<font color='red'>".$message."</font>";
	}else{
		echo "<fieldset>";
		echo "<legend>错误信息提示</legend>";
		echo "<div style='font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif;'>错误原因：".mysql_error()."<br /><br />";
		echo "<div style='line-height:20px; background:#F00; border:1px solid #F00; color:#FFF;'>".$message."</div>";
		echo "<font color='red'>".$sql."</font><br />";
	}
	echo "</div></fieldset><br />";
}
/**
*free the result.
*/
public function free(){
	@mysql_free_result($this->result);
}
/**
*close the database.
*/
public function close(){
	@mysql_close($this->conn);
}
/**
*destruct function of DB_class.
*/
public function __destruct(){
	$this->free();
	$this->close();
}
/**
*get the para $prefix.
*/
public function getprefix()
{
	return $this->prefix;
}
}
?>