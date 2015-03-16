<?php
session_start();
//session variable: username, usertype

$db = new DB();

$js[] = 'jquery-1.11.0.min';
$js[] = 'bootstrap.min';
$js[] = 'jquery.tablesorter.min';
$js[] = 'jquery.tablesorter.pager.min';
$js[] = 'jquery.tablesorter.widgets.min';
$css[] = 'font-awesome.min';
$css[] = 'bootstrap.min';
$css[] = 'tablesortertheme.bootstrap_2';

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

function isSignedIn(){
	if(isset($_SESSION['username']) && isset($_SESSION['usertype']))
		return true;
	return false;
}

function checkPost($param){
	if(isset($_POST[$param]) && !empty($_POST[$param]))
		return true;
	//echo 'Post not found';
	return false;
}

function requireUsertype($type){
	if(!isSignedIn() || !$_SESSION['usertype'] === $type)
	{
		header("Location: noaccess.php");
		exit();
	}
}

function getbusinessdetails($id, $db){
	$qry = "SELECT d.*, p1.status as p1, p2.status as p2, p3.status as p3, p4.status as p4, p5.status as p5 FROM `dashboard` d LEFT JOIN page1 p1 ON p1.user_id = d.user_ID LEFT JOIN page2 p2 ON p2.user_id = d.user_ID LEFT JOIN page3 p3 ON p3.user_id = d.user_ID LEFT JOIN page4 p4 ON p4.user_id = d.user_ID LEFT JOIN page5 p5 ON p5.user_id = d.user_ID WHERE d.user_id = $id";
	$result = $db->query($qry);
	$r = $result->fetch_assoc();
	if($result->num_rows > 0)
		return $r;
	else
		return '';
}

function printr($a){
	echo '<pre>';
	print_r($a);
	echo '</pre>';
}



class DB{
	private $db = null;

    public function __construct() {
    
      $dbhost = '127.0.0.1';
      $dbuser = 'root';
      $dbpass = '';
      $dbname = 'pokchai';
      $this->db = new Mysqli($dbhost, $dbuser, $dbpass, $dbname);
	}
	
	//return an associate array of first row from the given query
	public function get_first_row($qry)
	{
		$row = array();
		if($result = $this->query($qry))
		{
			$row = $result->fetch_assoc();
			$result->free();
		}
		return $row;
	}
	//return an associate array of all rows from the given query
	public function select($qry)
	{
		$rows = array();
		if($result = $this->query($qry))
		{
			while ($row = $result->fetch_assoc())
				$rows[] = $row;
			$result->free();
		}
		return $rows;
	}
	
	//insert a new row with provided values, into a given table
	public function insert_row($values, $table)
	{
		return $this->query("INSERT INTO `$table` VALUES($values)");
	}
	
	//count the number of rows of result of a given query
	public function row_count($qry)
	{
		return $this->query($qry)->num_rows;
	}
	
	public function query($qry){
		Log::q($qry);
		return $this->db->query($qry);
	}	
	

}

class Log{
	public function d($msg)
	{
		$lines[] = ''.date('Y-m-d g:i:sa', strtotime("now")).": $msg\r\n\n";
		$i = 0;
		foreach(file('log/debug_log.txt') as $l){
			$lines[] = $l; 
			if($i++ == 200)
				break;
		}
		$fp = fopen('log/debug_log.txt', 'w'); 
		fwrite($fp, implode('', $lines)); 
		fclose($fp);
	}
	public function q($msg)
	{
		$lines[] = ''.date('Y-m-d g:i:sa', strtotime("now"))."\r\n$msg\r\n\n";
		$i = 0;
		foreach(file('log/query_log.sql') as $l){
			$lines[] = $l;
			if($i++ == 400)
				break;
		}
		$fp = fopen('log/query_log.sql', 'w'); 
		fwrite($fp, implode('', $lines)); 
		fclose($fp);
	}
}
