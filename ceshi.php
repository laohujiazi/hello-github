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

/**
 * 将字符串参数变为数组
 * @param $query
 * @return array array (size=10)
          'm' => string 'content' (length=7)
          'c' => string 'index' (length=5)
          'a' => string 'lists' (length=5)
          'catid' => string '6' (length=1)
          'area' => string '0' (length=1)
          'author' => string '0' (length=1)
          'h' => string '0' (length=1)
          'region' => string '0' (length=1)
          's' => string '1' (length=1)
          'page' => string '1' (length=1)
 */
function convertUrlQuery($query)
{
  $queryParts = explode('&', $query);
  $params = array();
  foreach ($queryParts as $param) {
    $item = explode('=', $param);
    $params[$item[0]] = $item[1];
  }
  return $params;
}
/**
 * 将参数变为字符串
 * @param $array_query
 * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1'(length=73)
 */
function getUrlQuery($array_query)
{
  $tmp = array();
  foreach($array_query as $k=>$param)
  {
    $tmp[] = $k.'='.$param;
  }
  $params = implode('&',$tmp);
  return $params;
}

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$arr = parse_url($url);

$arr_query = convertUrlQuery($arr['query']);

if(!$arr_query['p']){
    $arr_query['p'] = 1;
}
$arr_query['p'] = (int)$arr_query['p'];


$categorys = array(
    1 => '',
    2 => '',
    3 => '',
    4 => '',
    5 => '',
    6 => ''
);
$where = '';

//if($arr_query['type']){
//  $where = 'where category="'.$categorys[$arr_query['type']].'"';/
//}


//$where = 'where url="'.$arr_query['cardid'].'" and image="'.$arr_query['password'].'"';
//$where = 'where guoxin03.卡号="'.$arr_query['cardid'].'"';
//$where = "where guoxin03.卡号='".$arr_query['cardid']."' and guoxin01.会员卡='".$arr_query['cardid']."' and guoxin03.密码='".md5($arr_query['password'])."'";
//$where = "WHERE guoxin03.卡号 =  '".$arr_query['cardid']."' AND guoxin02.卡号 =  '".$arr_query['cardid']."' AND guoxin02.id = (  SELECT MAX( guoxin02.id )  FROM guoxin02 WHERE guoxin02.卡号 =  '".$arr_query['cardid']."' AND guoxin02.jcje >0 )  AND guoxin01.会员卡 =  '".$arr_query['cardid']."' and guoxin03.密码='".md5($arr_query['password'])."'"



$where = "where guoxin03.卡号='".$arr_query['cardid']."' and guoxin02.卡号='".$arr_query['cardid']."' and guoxin02.id=(select max(guoxin02.id) from guoxin02 where guoxin02.卡号='".$arr_query['cardid']."' and guoxin02.jcje >0 ) and guoxin01.会员卡='".$arr_query['cardid']."' and guoxin03.密码='".md5($arr_query['password'])."'"  ;


$sql = "SELECT guoxin01.djbh,guoxin01.djrq,guoxin01.spmc,guoxin01.sl,guoxin01.yj,guoxin01.sj,guoxin01.sfje,guoxin02.jcje FROM guoxin01,guoxin02,guoxin03 ".$where." ORDER BY guoxin01.id ASC LIMIT ".(($arr_query['p'] -1)*10).",10";


try {
    $db = getConnection();
    $db->query('set names utf8;');
    $stmt = $db->prepare($sql);
	  $stmt->execute();
	  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    echo '{"girls": ' . json_encode($results) . '}';
} catch (PDOException $e) {
    echo '{"error":{"text":' . $e->getMessage() . '}}';
}

?>