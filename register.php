<?php
function getConnection()
{
    $dbhost = 'sqld-gz.bcehost.com:3306';
    $dbuser = 'ba2c4dd5dbe44d658fe1e6761de1c524';
    $dbpass = '1d3856b06df04fb59a2b5f8dea6f73ab';
    $dbname = 'yaZVGYaXcSIadItswcZm';
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    return $dbh;
}


$sql = "UPDATE guoxin03 SET 密码 = '" . md5($_POST["password1"]) ."' WHERE 卡号 ='" .  $_POST['cardid'] . "' and 密码 = '" . md5($_POST['password0']) ."'";

try {
    $db = getConnection();
    $db->query('set names utf8;');
    $stmt = $db->prepare($sql);
	  $stmt->execute();
		$results = array
       (
          'flag'=>$stmt->rowCount()
       );
    $db = null;  
    echo '{"girls": ' . json_encode($results) . '}';
} catch (PDOException $e) {
    echo '{"error":{"text":' . $e->getMessage() . '}}';
}

?>