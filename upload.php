<?php
ini_set('max_execution_time','360');
//ini_set('memory_limit', '-1');
// 允许上传的后缀
$allowedExts = array( "xls", "xlsx");
$temp = explode(".", $_FILES["file"]["name"]);
$up = 0;




$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
|| ($_FILES["file"]["type"] == "pjpeg")
|| ($_FILES["file"]["type"] == "x-png")
|| ($_FILES["file"]["type"] == "png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2mb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        
        //echo "文件类型: " . $_FILES["file"]["type"] . "<br><br>";
        //echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br><br>";
        //echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br><br>";
        
        // 判断当期目录下的 upload 目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        
        
        //if (file_exists($_FILES["file"]["name"]))
        //if ($data->sheets[0]['cells'][1][1] == "单据编号" or $data->sheets[0]['cells'][1][1] == "卡号")
        //{
        
            $up = move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
            echo "<br><br>您上传的文件是: " . $_FILES["file"]["name"] . "<br><br>";
            //echo "文件存储在: " . "upload/" . $_FILES["file"]["name"] . "<br><br>";
        //}
        //else
        //{
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            //$up = move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
        //    echo "文件不正确，请重新选择文件上传<br><br>";
        //}
        
    }
}
else
{
    echo "<br><br>非法的文件格式，只允许上传excel文件。或您上传的文件超过2M<br><br>";
}


if($up){
	  //echo "文件上传成功！<br><br>";
	  require_once 'reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('gbk');
		$data->read($_FILES["file"]["name"]);
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
			die("数据库连接失败: " . $connent->connect_error) . '<br/><br/>';
		}
		 
		mysql_select_db('yaZVGYaXcSIadItswcZm'); //选择数据库 

		//插入数据
		//$insertdata="insert into guoxin03(卡号,密码,卡类型) values('zhanghao','avc','142123123112@110.com')";
		//if($connent->query($insertdata)==true){
		//	echo "插入数据成功";
		//}else{
		//	echo "Error insert data: " . $connent->error;
		//}
		$flag = 0;

		if($data->sheets[0]['cells'][1][1] == "卡号"){
			$dbname = "guoxin02";
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 
				$sql = "INSERT INTO " . $dbname ."(卡号,卡类型,卡级别,账户名称,会员名称,发生机构,发生方向,发生金额,jcje,折扣金额,消费金额,业务类型,备注,业务日期) select '". 
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
				$data->sheets[0]['cells'][$i][14]."' from dual where not exists(select * from guoxin02 where ".
				"卡号='" . $data->sheets[0]['cells'][$i][1] . 
				"' and 卡类型='" . $data->sheets[0]['cells'][$i][2] . 
				"' and 卡级别='" . $data->sheets[0]['cells'][$i][3] . 
				"' and 账户名称='" . $data->sheets[0]['cells'][$i][4] . 
				"' and 会员名称='" . $data->sheets[0]['cells'][$i][5] . 
				"' and 发生机构='" . $data->sheets[0]['cells'][$i][6] . 
				"' and 发生方向='" . $data->sheets[0]['cells'][$i][7] . 
				"' and 发生金额='" . $data->sheets[0]['cells'][$i][8] . 
				"' and jcje='" . $data->sheets[0]['cells'][$i][9] . 
				"' and 折扣金额='" . $data->sheets[0]['cells'][$i][10] . 
				"' and 消费金额='" . $data->sheets[0]['cells'][$i][11] . 
				"' and 业务类型='" . $data->sheets[0]['cells'][$i][12] . 
				"' and 备注='" . $data->sheets[0]['cells'][$i][13] . 
				"' and 业务日期='" . $data->sheets[0]['cells'][$i][14] . 
				"')";
				
				$sqluser = "INSERT INTO guoxin03(卡号,密码) VALUES('". $data->sheets[0]['cells'][$i][1]."','". md5($data->sheets[0]['cells'][$i][1]) . "')  ON duplicate KEY UPDATE 卡号 = '" . $data->sheets[0]['cells'][$i][1] . "'" ;
				//echo $sql.'<br/>'; 
				//if($connent->query($sql)==true){
				//	echo "插入数据成功".'<br/>';
				//	}
				//else{
				//	$flag = 1;
				//	echo "插入数据失败: " . $connent->error;
				//	}
				
				if($connent->query($sql)==false){
					$flag = $flag + 1;
					echo "插入数据失败: " . $connent->error;
				}
				if($connent->query($sqluser)==false){
					$flag = $flag + 1;
					echo "插入数据失败: " . $connent->error;
				}	
			} 
			if($flag > 0){
					echo $flag . "条数据插入数据库失败，请重新上传文件<br/>" ;
			}
			else{
					echo "文件中的数据已成功插入到数据库，数据上传完成。".'<br/><br/>';
			}
		}
		else{
			if($data->sheets[0]['cells'][1][1] == "单据编号"){
				$dbname = "guoxin01";
				$k = 0;
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 
					
					if($data->sheets[0]['cells'][$i][1]!=''){
					$k = $i;
				//$sql = "INSERT INTO " . $dbname ."(单据编号,单据日期,单据类型,收银员,POS机,总金额,折扣金额,实收金额,会员卡,备注,离线销售流水号,销售开始时间,销售结束时间,退货销售单号,退货操作人,打折操作人,变价操作人,赠送操作人,会员姓名,收款性质,客户名称,退货原因,辅助单位,辅助数量,仓库,商品编码,商品条码,商品名称,销售单位,数量,原价,实价,应付金额,实付金额,商品打折率,打折类型,打折原因,促销流水号,积分,退货数量,赠品标志,营业员,是否上传过,辅助属性) select '". 
				$sql = "INSERT INTO " . $dbname ."(djbh,djrq,单据类型,收银员,POS机,总金额,折扣金额,实收金额,会员卡,备注,离线销售流水号,销售开始时间,销售结束时间,退货销售单号,退货操作人,打折操作人,变价操作人,赠送操作人,会员姓名,收款性质,客户名称,退货原因,辅助单位,辅助数量,仓库,商品编码,商品条码,spmc,销售单位,sl,yj,sj,应付金额,sfje,商品打折率,打折类型,打折原因,促销流水号,积分,退货数量,赠品标志,营业员,是否上传过,辅助属性) select '". 
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
				$data->sheets[0]['cells'][$i][14]."','".
				$data->sheets[0]['cells'][$i][15]."','".
				$data->sheets[0]['cells'][$i][16]."','".
				$data->sheets[0]['cells'][$i][17]."','".
				$data->sheets[0]['cells'][$i][18]."','".
				$data->sheets[0]['cells'][$i][19]."','".
				$data->sheets[0]['cells'][$i][20]."','".
				$data->sheets[0]['cells'][$i][21]."','".
				$data->sheets[0]['cells'][$i][22]."','".
				$data->sheets[0]['cells'][$i][23]."','".
				$data->sheets[0]['cells'][$i][24]."','".
				$data->sheets[0]['cells'][$i][25]."','".
				$data->sheets[0]['cells'][$i][26]."','".
				$data->sheets[0]['cells'][$i][27]."','".
				$data->sheets[0]['cells'][$i][28]."','".
				$data->sheets[0]['cells'][$i][29]."','".
				$data->sheets[0]['cells'][$i][30]."','".
				$data->sheets[0]['cells'][$i][31]."','".
				$data->sheets[0]['cells'][$i][32]."','".
				$data->sheets[0]['cells'][$i][33]."','".
				$data->sheets[0]['cells'][$i][34]."','".
				$data->sheets[0]['cells'][$i][35]."','".
				$data->sheets[0]['cells'][$i][36]."','".
				$data->sheets[0]['cells'][$i][37]."','".
				$data->sheets[0]['cells'][$i][38]."','".
				$data->sheets[0]['cells'][$i][39]."','".
				$data->sheets[0]['cells'][$i][40]."','".
				$data->sheets[0]['cells'][$i][41]."','".
				$data->sheets[0]['cells'][$i][42]."','".
				$data->sheets[0]['cells'][$i][43]."','".
				$data->sheets[0]['cells'][$i][44]."' from dual where not exists(select * from guoxin01 where ".
				"djbh='" . $data->sheets[0]['cells'][$i][1] . 
				"' and djrq='" . $data->sheets[0]['cells'][$i][2] . 
				"' and 单据类型='" . $data->sheets[0]['cells'][$i][3] . 
				"' and 收银员='" . $data->sheets[0]['cells'][$i][4] . 
				"' and POS机='" . $data->sheets[0]['cells'][$i][5] . 
				"' and 总金额='" . $data->sheets[0]['cells'][$i][6] . 
				"' and 折扣金额='" . $data->sheets[0]['cells'][$i][7] . 
				"' and 实收金额='" . $data->sheets[0]['cells'][$i][8] . 
				"' and 会员卡='" . $data->sheets[0]['cells'][$i][9] . 
				"' and 备注='" . $data->sheets[0]['cells'][$i][10] . 
				"' and 离线销售流水号='" . $data->sheets[0]['cells'][$i][11] . 
				"' and 销售开始时间='" . $data->sheets[0]['cells'][$i][12] . 
				"' and 销售结束时间='" . $data->sheets[0]['cells'][$i][13] . 
				"' and 退货销售单号='" . $data->sheets[0]['cells'][$i][14] . 
				"' and 退货操作人='" . $data->sheets[0]['cells'][$i][15] . 
				"' and 打折操作人='" . $data->sheets[0]['cells'][$i][16] . 
				"' and 变价操作人='" . $data->sheets[0]['cells'][$i][17] . 
				"' and 赠送操作人='" . $data->sheets[0]['cells'][$i][18] . 
				"' and 会员姓名='" . $data->sheets[0]['cells'][$i][19] . 
				"' and 收款性质='" . $data->sheets[0]['cells'][$i][20] . 
				"' and 客户名称='" . $data->sheets[0]['cells'][$i][21] . 
				"' and 退货原因='" . $data->sheets[0]['cells'][$i][22] . 
				"' and 辅助单位='" . $data->sheets[0]['cells'][$i][23] . 
				"' and 辅助数量='" . $data->sheets[0]['cells'][$i][24] . 
				"' and 仓库='" . $data->sheets[0]['cells'][$i][25] . 
				"' and 商品编码='" . $data->sheets[0]['cells'][$i][26] . 
				"' and 商品条码='" . $data->sheets[0]['cells'][$i][27] . 
				"' and spmc='" . $data->sheets[0]['cells'][$i][28] . 
				"' and 销售单位='" . $data->sheets[0]['cells'][$i][29] . 
				"' and sl='" . $data->sheets[0]['cells'][$i][30] . 
				"' and yj='" . $data->sheets[0]['cells'][$i][31] . 
				"' and sj='" . $data->sheets[0]['cells'][$i][32] . 
				"' and 应付金额='" . $data->sheets[0]['cells'][$i][33] . 
				"' and sfje='" . $data->sheets[0]['cells'][$i][34] . 
				"' and 商品打折率='" . $data->sheets[0]['cells'][$i][35] . 
				"' and 打折类型='" . $data->sheets[0]['cells'][$i][36] . 
				"' and 打折原因='" . $data->sheets[0]['cells'][$i][37] . 
				"' and 促销流水号='" . $data->sheets[0]['cells'][$i][38] . 
				"' and 积分='" . $data->sheets[0]['cells'][$i][39] . 
				"' and 退货数量='" . $data->sheets[0]['cells'][$i][40] . 
				"' and 赠品标志='" . $data->sheets[0]['cells'][$i][41] . 
				"' and 营业员='" . $data->sheets[0]['cells'][$i][42] . 
				"' and 是否上传过='" . $data->sheets[0]['cells'][$i][43] . 
				"' and 辅助属性='" . $data->sheets[0]['cells'][$i][44] . 
				"')";
				}else{
				
				
				$sql = "INSERT INTO " . $dbname ."(djbh,djrq,单据类型,收银员,POS机,总金额,折扣金额,实收金额,会员卡,备注,离线销售流水号,销售开始时间,销售结束时间,退货销售单号,退货操作人,打折操作人,变价操作人,赠送操作人,会员姓名,收款性质,客户名称,退货原因,辅助单位,辅助数量,仓库,商品编码,商品条码,spmc,销售单位,sl,yj,sj,应付金额,sfje,商品打折率,打折类型,打折原因,促销流水号,积分,退货数量,赠品标志,营业员,是否上传过,辅助属性) select '". 
				$data->sheets[0]['cells'][$k][1]."','".
				$data->sheets[0]['cells'][$k][2]."','". 
				$data->sheets[0]['cells'][$k][3]."','".
				$data->sheets[0]['cells'][$k][4]."','".
				$data->sheets[0]['cells'][$k][5]."','".
				$data->sheets[0]['cells'][$k][6]."','".
				$data->sheets[0]['cells'][$k][7]."','".
				$data->sheets[0]['cells'][$k][8]."','".
				$data->sheets[0]['cells'][$k][9]."','".
				$data->sheets[0]['cells'][$k][10]."','".
				$data->sheets[0]['cells'][$k][11]."','".
				$data->sheets[0]['cells'][$k][12]."','".
				$data->sheets[0]['cells'][$k][13]."','". 
				$data->sheets[0]['cells'][$k][14]."','".
				$data->sheets[0]['cells'][$k][15]."','".
				$data->sheets[0]['cells'][$k][16]."','".
				$data->sheets[0]['cells'][$k][17]."','".
				$data->sheets[0]['cells'][$k][18]."','".
				$data->sheets[0]['cells'][$k][19]."','".
				$data->sheets[0]['cells'][$k][20]."','".
				$data->sheets[0]['cells'][$k][21]."','".
				$data->sheets[0]['cells'][$k][22]."','".
				$data->sheets[0]['cells'][$k][23]."','".
				$data->sheets[0]['cells'][$i][24]."','".
				$data->sheets[0]['cells'][$i][25]."','".
				$data->sheets[0]['cells'][$i][26]."','".
				$data->sheets[0]['cells'][$i][27]."','".
				$data->sheets[0]['cells'][$i][28]."','".
				$data->sheets[0]['cells'][$i][29]."','".
				$data->sheets[0]['cells'][$i][30]."','".
				$data->sheets[0]['cells'][$i][31]."','".
				$data->sheets[0]['cells'][$i][32]."','".
				$data->sheets[0]['cells'][$i][33]."','".
				$data->sheets[0]['cells'][$i][34]."','".
				$data->sheets[0]['cells'][$i][35]."','".
				$data->sheets[0]['cells'][$i][36]."','".
				$data->sheets[0]['cells'][$i][37]."','".
				$data->sheets[0]['cells'][$i][38]."','".
				$data->sheets[0]['cells'][$i][39]."','".
				$data->sheets[0]['cells'][$i][40]."','".
				$data->sheets[0]['cells'][$i][41]."','".
				$data->sheets[0]['cells'][$i][42]."','".
				$data->sheets[0]['cells'][$i][43]."','".
				$data->sheets[0]['cells'][$i][44]."' from dual where not exists(select * from guoxin01 where ".
				"djbh='" . $data->sheets[0]['cells'][$k][1] . 
				"' and djrq='" . $data->sheets[0]['cells'][$k][2] . 
				"' and 单据类型='" . $data->sheets[0]['cells'][$k][3] . 
				"' and 收银员='" . $data->sheets[0]['cells'][$k][4] . 
				"' and POS机='" . $data->sheets[0]['cells'][$k][5] . 
				"' and 总金额='" . $data->sheets[0]['cells'][$k][6] . 
				"' and 折扣金额='" . $data->sheets[0]['cells'][$k][7] . 
				"' and 实收金额='" . $data->sheets[0]['cells'][$k][8] . 
				"' and 会员卡='" . $data->sheets[0]['cells'][$k][9] . 
				"' and 备注='" . $data->sheets[0]['cells'][$k][10] . 
				"' and 离线销售流水号='" . $data->sheets[0]['cells'][$k][11] . 
				"' and 销售开始时间='" . $data->sheets[0]['cells'][$k][12] . 
				"' and 销售结束时间='" . $data->sheets[0]['cells'][$k][13] . 
				"' and 退货销售单号='" . $data->sheets[0]['cells'][$k][14] . 
				"' and 退货操作人='" . $data->sheets[0]['cells'][$k][15] . 
				"' and 打折操作人='" . $data->sheets[0]['cells'][$k][16] . 
				"' and 变价操作人='" . $data->sheets[0]['cells'][$k][17] . 
				"' and 赠送操作人='" . $data->sheets[0]['cells'][$k][18] . 
				"' and 会员姓名='" . $data->sheets[0]['cells'][$k][19] . 
				"' and 收款性质='" . $data->sheets[0]['cells'][$k][20] . 
				"' and 客户名称='" . $data->sheets[0]['cells'][$k][21] . 
				"' and 退货原因='" . $data->sheets[0]['cells'][$k][22] . 
				"' and 辅助单位='" . $data->sheets[0]['cells'][$k][23] . 
				"' and 辅助数量='" . $data->sheets[0]['cells'][$i][24] . 
				"' and 仓库='" . $data->sheets[0]['cells'][$i][25] . 
				"' and 商品编码='" . $data->sheets[0]['cells'][$i][26] . 
				"' and 商品条码='" . $data->sheets[0]['cells'][$i][27] . 
				"' and spmc='" . $data->sheets[0]['cells'][$i][28] . 
				"' and 销售单位='" . $data->sheets[0]['cells'][$i][29] . 
				"' and sl='" . $data->sheets[0]['cells'][$i][30] . 
				"' and yj='" . $data->sheets[0]['cells'][$i][31] . 
				"' and sj='" . $data->sheets[0]['cells'][$i][32] . 
				"' and 应付金额='" . $data->sheets[0]['cells'][$i][33] . 
				"' and sfje='" . $data->sheets[0]['cells'][$i][34] . 
				"' and 商品打折率='" . $data->sheets[0]['cells'][$i][35] . 
				"' and 打折类型='" . $data->sheets[0]['cells'][$i][36] . 
				"' and 打折原因='" . $data->sheets[0]['cells'][$i][37] . 
				"' and 促销流水号='" . $data->sheets[0]['cells'][$i][38] . 
				"' and 积分='" . $data->sheets[0]['cells'][$i][39] . 
				"' and 退货数量='" . $data->sheets[0]['cells'][$i][40] . 
				"' and 赠品标志='" . $data->sheets[0]['cells'][$i][41] . 
				"' and 营业员='" . $data->sheets[0]['cells'][$i][42] . 
				"' and 是否上传过='" . $data->sheets[0]['cells'][$i][43] . 
				"' and 辅助属性='" . $data->sheets[0]['cells'][$i][44] . 
				"')";
				}
				
				//echo $sql.'<br/>'; 
				//if($connent->query($sql)==true){
				//	echo "插入数据成功".'<br/>';
				//	}
				//else{
				//	$flag = 1;
				//	echo "插入数据失败: " . $connent->error;
				//	}
				
					if($connent->query($sql)==false){
						$flag = $flag + 1;
						echo "插入数据失败: " . $connent->error;
					}	
				} 
				if($flag > 0){
						echo $flag . "条数据插入数据库失败，请重新上传文件<br/><br/>" ;
				}
				else
				{
					echo "文件中的数据已成功插入到数据库，数据上传完成。".'<br/><br/>';
				}
			}
			else{
				echo "上传的文件不复合格式要求，请重新选择文件上传".'<br/><br/>';		
			}
			
			
			
			
		}

		
		echo "<a href='upload.html'>单击这里，继续上传新文件<a><br><br>";
		mysqli_close($connent); 
	 
	}
else{
	  echo "<a href='upload.html'>文件上传失败，单击这里重新上传<a><br><br>";
	}


?>