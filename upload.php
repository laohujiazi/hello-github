<?php
ini_set('max_execution_time','360');
//ini_set('memory_limit', '-1');
// �����ϴ��ĺ�׺
$allowedExts = array( "xls", "xlsx");
$temp = explode(".", $_FILES["file"]["name"]);
$up = 0;




$extension = end($temp);     // ��ȡ�ļ���׺��
if ((($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
|| ($_FILES["file"]["type"] == "pjpeg")
|| ($_FILES["file"]["type"] == "x-png")
|| ($_FILES["file"]["type"] == "png"))
&& ($_FILES["file"]["size"] < 2048000)   // С�� 2mb
&& in_array($extension, $allowedExts))
{
    if ($_FILES["file"]["error"] > 0)
    {
        echo "����: " . $_FILES["file"]["error"] . "<br>";
    }
    else
    {
        
        //echo "�ļ�����: " . $_FILES["file"]["type"] . "<br><br>";
        //echo "�ļ���С: " . ($_FILES["file"]["size"] / 1024) . " kB<br><br>";
        //echo "�ļ���ʱ�洢��λ��: " . $_FILES["file"]["tmp_name"] . "<br><br>";
        
        // �жϵ���Ŀ¼�µ� upload Ŀ¼�Ƿ���ڸ��ļ�
        // ���û�� upload Ŀ¼������Ҫ��������upload Ŀ¼Ȩ��Ϊ 777
        
        
        //if (file_exists($_FILES["file"]["name"]))
        //if ($data->sheets[0]['cells'][1][1] == "���ݱ��" or $data->sheets[0]['cells'][1][1] == "����")
        //{
        
            $up = move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
            echo "<br><br>���ϴ����ļ���: " . $_FILES["file"]["name"] . "<br><br>";
            //echo "�ļ��洢��: " . "upload/" . $_FILES["file"]["name"] . "<br><br>";
        //}
        //else
        //{
            // ��� upload Ŀ¼�����ڸ��ļ����ļ��ϴ��� upload Ŀ¼��
            //$up = move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
        //    echo "�ļ�����ȷ��������ѡ���ļ��ϴ�<br><br>";
        //}
        
    }
}
else
{
    echo "<br><br>�Ƿ����ļ���ʽ��ֻ�����ϴ�excel�ļ��������ϴ����ļ�����2M<br><br>";
}


if($up){
	  //echo "�ļ��ϴ��ɹ���<br><br>";
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
			die("���ݿ�����ʧ��: " . $connent->connect_error) . '<br/><br/>';
		}
		 
		mysql_select_db('yaZVGYaXcSIadItswcZm'); //ѡ�����ݿ� 

		//��������
		//$insertdata="insert into guoxin03(����,����,������) values('zhanghao','avc','142123123112@110.com')";
		//if($connent->query($insertdata)==true){
		//	echo "�������ݳɹ�";
		//}else{
		//	echo "Error insert data: " . $connent->error;
		//}
		$flag = 0;

		if($data->sheets[0]['cells'][1][1] == "����"){
			$dbname = "guoxin02";
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 
				$sql = "INSERT INTO " . $dbname ."(����,������,������,�˻�����,��Ա����,��������,��������,�������,jcje,�ۿ۽��,���ѽ��,ҵ������,��ע,ҵ������) select '". 
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
				"����='" . $data->sheets[0]['cells'][$i][1] . 
				"' and ������='" . $data->sheets[0]['cells'][$i][2] . 
				"' and ������='" . $data->sheets[0]['cells'][$i][3] . 
				"' and �˻�����='" . $data->sheets[0]['cells'][$i][4] . 
				"' and ��Ա����='" . $data->sheets[0]['cells'][$i][5] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][6] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][7] . 
				"' and �������='" . $data->sheets[0]['cells'][$i][8] . 
				"' and jcje='" . $data->sheets[0]['cells'][$i][9] . 
				"' and �ۿ۽��='" . $data->sheets[0]['cells'][$i][10] . 
				"' and ���ѽ��='" . $data->sheets[0]['cells'][$i][11] . 
				"' and ҵ������='" . $data->sheets[0]['cells'][$i][12] . 
				"' and ��ע='" . $data->sheets[0]['cells'][$i][13] . 
				"' and ҵ������='" . $data->sheets[0]['cells'][$i][14] . 
				"')";
				
				$sqluser = "INSERT INTO guoxin03(����,����) VALUES('". $data->sheets[0]['cells'][$i][1]."','". md5($data->sheets[0]['cells'][$i][1]) . "')  ON duplicate KEY UPDATE ���� = '" . $data->sheets[0]['cells'][$i][1] . "'" ;
				//echo $sql.'<br/>'; 
				//if($connent->query($sql)==true){
				//	echo "�������ݳɹ�".'<br/>';
				//	}
				//else{
				//	$flag = 1;
				//	echo "��������ʧ��: " . $connent->error;
				//	}
				
				if($connent->query($sql)==false){
					$flag = $flag + 1;
					echo "��������ʧ��: " . $connent->error;
				}
				if($connent->query($sqluser)==false){
					$flag = $flag + 1;
					echo "��������ʧ��: " . $connent->error;
				}	
			} 
			if($flag > 0){
					echo $flag . "�����ݲ������ݿ�ʧ�ܣ��������ϴ��ļ�<br/>" ;
			}
			else{
					echo "�ļ��е������ѳɹ����뵽���ݿ⣬�����ϴ���ɡ�".'<br/><br/>';
			}
		}
		else{
			if($data->sheets[0]['cells'][1][1] == "���ݱ��"){
				$dbname = "guoxin01";
				$k = 0;
				for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { 
					
					if($data->sheets[0]['cells'][$i][1]!=''){
					$k = $i;
				//$sql = "INSERT INTO " . $dbname ."(���ݱ��,��������,��������,����Ա,POS��,�ܽ��,�ۿ۽��,ʵ�ս��,��Ա��,��ע,����������ˮ��,���ۿ�ʼʱ��,���۽���ʱ��,�˻����۵���,�˻�������,���۲�����,��۲�����,���Ͳ�����,��Ա����,�տ�����,�ͻ�����,�˻�ԭ��,������λ,��������,�ֿ�,��Ʒ����,��Ʒ����,��Ʒ����,���۵�λ,����,ԭ��,ʵ��,Ӧ�����,ʵ�����,��Ʒ������,��������,����ԭ��,������ˮ��,����,�˻�����,��Ʒ��־,ӪҵԱ,�Ƿ��ϴ���,��������) select '". 
				$sql = "INSERT INTO " . $dbname ."(djbh,djrq,��������,����Ա,POS��,�ܽ��,�ۿ۽��,ʵ�ս��,��Ա��,��ע,����������ˮ��,���ۿ�ʼʱ��,���۽���ʱ��,�˻����۵���,�˻�������,���۲�����,��۲�����,���Ͳ�����,��Ա����,�տ�����,�ͻ�����,�˻�ԭ��,������λ,��������,�ֿ�,��Ʒ����,��Ʒ����,spmc,���۵�λ,sl,yj,sj,Ӧ�����,sfje,��Ʒ������,��������,����ԭ��,������ˮ��,����,�˻�����,��Ʒ��־,ӪҵԱ,�Ƿ��ϴ���,��������) select '". 
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
				"' and ��������='" . $data->sheets[0]['cells'][$i][3] . 
				"' and ����Ա='" . $data->sheets[0]['cells'][$i][4] . 
				"' and POS��='" . $data->sheets[0]['cells'][$i][5] . 
				"' and �ܽ��='" . $data->sheets[0]['cells'][$i][6] . 
				"' and �ۿ۽��='" . $data->sheets[0]['cells'][$i][7] . 
				"' and ʵ�ս��='" . $data->sheets[0]['cells'][$i][8] . 
				"' and ��Ա��='" . $data->sheets[0]['cells'][$i][9] . 
				"' and ��ע='" . $data->sheets[0]['cells'][$i][10] . 
				"' and ����������ˮ��='" . $data->sheets[0]['cells'][$i][11] . 
				"' and ���ۿ�ʼʱ��='" . $data->sheets[0]['cells'][$i][12] . 
				"' and ���۽���ʱ��='" . $data->sheets[0]['cells'][$i][13] . 
				"' and �˻����۵���='" . $data->sheets[0]['cells'][$i][14] . 
				"' and �˻�������='" . $data->sheets[0]['cells'][$i][15] . 
				"' and ���۲�����='" . $data->sheets[0]['cells'][$i][16] . 
				"' and ��۲�����='" . $data->sheets[0]['cells'][$i][17] . 
				"' and ���Ͳ�����='" . $data->sheets[0]['cells'][$i][18] . 
				"' and ��Ա����='" . $data->sheets[0]['cells'][$i][19] . 
				"' and �տ�����='" . $data->sheets[0]['cells'][$i][20] . 
				"' and �ͻ�����='" . $data->sheets[0]['cells'][$i][21] . 
				"' and �˻�ԭ��='" . $data->sheets[0]['cells'][$i][22] . 
				"' and ������λ='" . $data->sheets[0]['cells'][$i][23] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][24] . 
				"' and �ֿ�='" . $data->sheets[0]['cells'][$i][25] . 
				"' and ��Ʒ����='" . $data->sheets[0]['cells'][$i][26] . 
				"' and ��Ʒ����='" . $data->sheets[0]['cells'][$i][27] . 
				"' and spmc='" . $data->sheets[0]['cells'][$i][28] . 
				"' and ���۵�λ='" . $data->sheets[0]['cells'][$i][29] . 
				"' and sl='" . $data->sheets[0]['cells'][$i][30] . 
				"' and yj='" . $data->sheets[0]['cells'][$i][31] . 
				"' and sj='" . $data->sheets[0]['cells'][$i][32] . 
				"' and Ӧ�����='" . $data->sheets[0]['cells'][$i][33] . 
				"' and sfje='" . $data->sheets[0]['cells'][$i][34] . 
				"' and ��Ʒ������='" . $data->sheets[0]['cells'][$i][35] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][36] . 
				"' and ����ԭ��='" . $data->sheets[0]['cells'][$i][37] . 
				"' and ������ˮ��='" . $data->sheets[0]['cells'][$i][38] . 
				"' and ����='" . $data->sheets[0]['cells'][$i][39] . 
				"' and �˻�����='" . $data->sheets[0]['cells'][$i][40] . 
				"' and ��Ʒ��־='" . $data->sheets[0]['cells'][$i][41] . 
				"' and ӪҵԱ='" . $data->sheets[0]['cells'][$i][42] . 
				"' and �Ƿ��ϴ���='" . $data->sheets[0]['cells'][$i][43] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][44] . 
				"')";
				}else{
				
				
				$sql = "INSERT INTO " . $dbname ."(djbh,djrq,��������,����Ա,POS��,�ܽ��,�ۿ۽��,ʵ�ս��,��Ա��,��ע,����������ˮ��,���ۿ�ʼʱ��,���۽���ʱ��,�˻����۵���,�˻�������,���۲�����,��۲�����,���Ͳ�����,��Ա����,�տ�����,�ͻ�����,�˻�ԭ��,������λ,��������,�ֿ�,��Ʒ����,��Ʒ����,spmc,���۵�λ,sl,yj,sj,Ӧ�����,sfje,��Ʒ������,��������,����ԭ��,������ˮ��,����,�˻�����,��Ʒ��־,ӪҵԱ,�Ƿ��ϴ���,��������) select '". 
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
				"' and ��������='" . $data->sheets[0]['cells'][$k][3] . 
				"' and ����Ա='" . $data->sheets[0]['cells'][$k][4] . 
				"' and POS��='" . $data->sheets[0]['cells'][$k][5] . 
				"' and �ܽ��='" . $data->sheets[0]['cells'][$k][6] . 
				"' and �ۿ۽��='" . $data->sheets[0]['cells'][$k][7] . 
				"' and ʵ�ս��='" . $data->sheets[0]['cells'][$k][8] . 
				"' and ��Ա��='" . $data->sheets[0]['cells'][$k][9] . 
				"' and ��ע='" . $data->sheets[0]['cells'][$k][10] . 
				"' and ����������ˮ��='" . $data->sheets[0]['cells'][$k][11] . 
				"' and ���ۿ�ʼʱ��='" . $data->sheets[0]['cells'][$k][12] . 
				"' and ���۽���ʱ��='" . $data->sheets[0]['cells'][$k][13] . 
				"' and �˻����۵���='" . $data->sheets[0]['cells'][$k][14] . 
				"' and �˻�������='" . $data->sheets[0]['cells'][$k][15] . 
				"' and ���۲�����='" . $data->sheets[0]['cells'][$k][16] . 
				"' and ��۲�����='" . $data->sheets[0]['cells'][$k][17] . 
				"' and ���Ͳ�����='" . $data->sheets[0]['cells'][$k][18] . 
				"' and ��Ա����='" . $data->sheets[0]['cells'][$k][19] . 
				"' and �տ�����='" . $data->sheets[0]['cells'][$k][20] . 
				"' and �ͻ�����='" . $data->sheets[0]['cells'][$k][21] . 
				"' and �˻�ԭ��='" . $data->sheets[0]['cells'][$k][22] . 
				"' and ������λ='" . $data->sheets[0]['cells'][$k][23] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][24] . 
				"' and �ֿ�='" . $data->sheets[0]['cells'][$i][25] . 
				"' and ��Ʒ����='" . $data->sheets[0]['cells'][$i][26] . 
				"' and ��Ʒ����='" . $data->sheets[0]['cells'][$i][27] . 
				"' and spmc='" . $data->sheets[0]['cells'][$i][28] . 
				"' and ���۵�λ='" . $data->sheets[0]['cells'][$i][29] . 
				"' and sl='" . $data->sheets[0]['cells'][$i][30] . 
				"' and yj='" . $data->sheets[0]['cells'][$i][31] . 
				"' and sj='" . $data->sheets[0]['cells'][$i][32] . 
				"' and Ӧ�����='" . $data->sheets[0]['cells'][$i][33] . 
				"' and sfje='" . $data->sheets[0]['cells'][$i][34] . 
				"' and ��Ʒ������='" . $data->sheets[0]['cells'][$i][35] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][36] . 
				"' and ����ԭ��='" . $data->sheets[0]['cells'][$i][37] . 
				"' and ������ˮ��='" . $data->sheets[0]['cells'][$i][38] . 
				"' and ����='" . $data->sheets[0]['cells'][$i][39] . 
				"' and �˻�����='" . $data->sheets[0]['cells'][$i][40] . 
				"' and ��Ʒ��־='" . $data->sheets[0]['cells'][$i][41] . 
				"' and ӪҵԱ='" . $data->sheets[0]['cells'][$i][42] . 
				"' and �Ƿ��ϴ���='" . $data->sheets[0]['cells'][$i][43] . 
				"' and ��������='" . $data->sheets[0]['cells'][$i][44] . 
				"')";
				}
				
				//echo $sql.'<br/>'; 
				//if($connent->query($sql)==true){
				//	echo "�������ݳɹ�".'<br/>';
				//	}
				//else{
				//	$flag = 1;
				//	echo "��������ʧ��: " . $connent->error;
				//	}
				
					if($connent->query($sql)==false){
						$flag = $flag + 1;
						echo "��������ʧ��: " . $connent->error;
					}	
				} 
				if($flag > 0){
						echo $flag . "�����ݲ������ݿ�ʧ�ܣ��������ϴ��ļ�<br/><br/>" ;
				}
				else
				{
					echo "�ļ��е������ѳɹ����뵽���ݿ⣬�����ϴ���ɡ�".'<br/><br/>';
				}
			}
			else{
				echo "�ϴ����ļ������ϸ�ʽҪ��������ѡ���ļ��ϴ�".'<br/><br/>';		
			}
			
			
			
			
		}

		
		echo "<a href='upload.html'>������������ϴ����ļ�<a><br><br>";
		mysqli_close($connent); 
	 
	}
else{
	  echo "<a href='upload.html'>�ļ��ϴ�ʧ�ܣ��������������ϴ�<a><br><br>";
	}


?>