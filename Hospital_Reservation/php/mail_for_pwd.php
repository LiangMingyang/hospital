<?php
    echo "ok";
		print_r($_POST);
  require('../include/phpmailer/class.phpmailer.php');
  echo "1";
  date_default_timezone_set('PRC');
  function create_password($pw_length) 
    {  
    	$randpwd = '';  
    	for ($i = 0; $i < $pw_length; $i++)  
    	{  
    	$randpwd .= chr(mt_rand(97, 122));  
    	}  
    	return $randpwd;  
    }  
    echo "3";
	$conn=mysqli_connect("localhost","root","root");
	echo "33";
	if(!$conn){
		echo "Fail to Connect ".mysql_error();
	} else {
	    echo "normal";
	}
	echo "4";
	mysql_select_db("password_reset");
  	    $Mail=$_POST['Mail'];
		$User_ID=$_POST['User_ID'];
  		$date_now=date('Y-m-d H:i:s');
		$randstr=create_password(160);
  		$insert="Insert into Reset_Pwd(User_ID,Time,rand_str) values('$User_ID','$date_now','$randstr')";
		$reset_id="";
		echo "5";
		if(mysql_query($insert)){
			$reset_id=mysql_insert_id();
		}else {
			echo $insert;
		}
		echo "6";
  		$url="http://hospital.szm.me/php/reset_pwd.php?Reset_ID=$reset_id&randstr=$randstr";
  		echo "7";
		$content="您好！请将以下链接复制到浏览器地址栏完成密码重置，链接将在30分钟后失效<br/>".$url;
		echo "the begin";
		echo $Mail;
		echo "the end";
		$mail = new PHPMailer();
      	$mail->IsSMTP();
     	$mail->SMTPDebug = 2;
      	$mail->Host = "smtp.163.com";
		$mail->Port = "25";
      	$mail->CharSet = "utf-8"; // 这里指定字符集！
      	$mail->SMTPAuth = true;
      	$mail->Username ="gengjinkun1994@163.com";
      	$mail->Password ="gengjin1234kun";
		$from_addr="gengjinkun1994@163.com";
		$sender_name="医院预约挂号系统";
		$mail->AddReplyTo($from_addr, $sender_name);
      	$mail->AddAddress($Mail);//收件人地址
      	$mail->SetFrom($from_addr,$sender_name);
      	$mail->IsHTML(false);
      	$mail->Subject = "医院预约挂号系统密码重置";
      	$mail->MsgHTML($content); //邮件内容
      if(!$mail->Send())
      {
        echo "Fail";
      }
      else
      {
        echo "OK";
      }
  	

?>
