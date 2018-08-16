<?php 
require_once 'reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('gbk');
$data->read('001.xls');
error_reporting(E_ALL ^ E_NOTICE);

//for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
//	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
//		echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
//	}
//	echo "\n";
//}

$db = mysql_connect('sqld-gz.bcehost.com:3306', 'ba2c4dd5dbe44d658fe1e6761de1c524', '1d3856b06df04fb59a2b5f8dea6f73ab') or die("Could not connect to database.");

$servername="sqld-gz.bcehost.com:3306";
$username="ba2c4dd5dbe44d658fe1e6761de1c524";
$userpassword="1d3856b06df04fb59a2b5f8dea6f73ab";
 
$connent=new mysqli($servername,$username,$userpassword);
if($connent->connect_error){
	die("连接失败: " . $connent->connect_error);
}else{
	echo "连接成功".'<br/>';
}
 
mysql_select_db('yaZVGYaXcSIadItswcZm'); //选择数据库 

//插入数据
//$insertdata="insert into guoxin03(卡号,密码,卡类型) values('zhanghao','avc','142123123112@110.com')";
//if($connent->query($insertdata)==true){
//	echo "插入数据成功";
//}else{
//	echo "Error insert data: " . $connent->error;
//}

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 
	$sql = "INSERT INTO guoxin02(卡号,卡类型,卡级别,账户名称,会员名称,发生机构,发生方向,发生金额,结存金额,折扣金额,消费金额,业务类型,备注,业务日期) VALUES('". 
	$data->sheets[0]['cells'][$i][1]."','". 
	$data->sheets[0]['cells'][$i][2]."','". 
	$data->sheets[0]['cells'][$i][3]."','".
	$data->sheets[0]['cells'][$i][4]."','".
	$data->sheets[0]['cells'][$i][5]."','".
	$data->sheets[0]['cells'][$i][6]."','".
	$data->sheets[0]['cells'][$i][7]."','".
	$data->sheets[0]['cells'][$i][8]."','".
	$data->sheets[0]['cells'][$i][9]."','".
	$data->sheets[0]['cells'][$i][10]."','".
	$data->sheets[0]['cells'][$i][11]."','".
	$data->sheets[0]['cells'][$i][12]."','".
	$data->sheets[0]['cells'][$i][13]."','".
	$data->sheets[0]['cells'][$i][14]."')"; 
	
	echo $sql.'<br/>'; 
	
	if($connent->query($sql)==true){
		echo "插入数据成功".'<br/>';
	}else{
		echo "Error insert data: " . $connent->error;
	}
	
} 

mysqli_close($connent);

?> 