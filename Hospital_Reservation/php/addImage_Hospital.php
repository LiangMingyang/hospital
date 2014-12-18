<?php
$res["error"] = "";//错误信息
$res["msg"] = "";//提示信息
$fileElementName='fileToUpload';
$error_code='0';
$error="";
$filetype=$_POST['filetype'];
$oldfile=$_POST['oldfile'];
$filename="hospital_pic_".date('YmdHis').".".$filetype;
$storage_url="http://localhost/Hospital_Reservation//hospital_image//";
$storage_path="../hospital_image//";
if(trim($oldfile)!=''){
	$storage_path.=$oldfile;
	$storage_url.=$oldfile;
	@unlink($storage_path);
}else{
	$storage_path.=$filename;
	$storage_url.=$filename;
}
if(!empty($_FILES[$fileElementName]['error']))
{
	$error_code=$_FILES[$fileElementName]['error'];
	switch($_FILES[$fileElementName]['error'])
	{

		case '1':
			$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
		case '2':
			$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
		case '3':
			$error = 'The uploaded file was only partially uploaded';
			break;
		case '4':
			$error = 'No file was uploaded.';
			break;

		case '6':
			$error = 'Missing a temporary folder';
			break;
		case '7':
			$error = 'Failed to write file to disk';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'No error code avaiable';
	}
}else if(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
{
	$error = 'No file was uploaded..';
}
if($error_code!='0'){
	 $res["msg"] = $error_code;
	$res['error']=$error;
	$res['filename']="";
}
else if(move_uploaded_file($_FILES['PicturetoUpload']['tmp_name'],$storage_path)){
    $res["msg"] = 0;
	$res['error']="";
	$res['filename']=$storage_path;
	$res['Hospital_Picture_url']=$storage_url;
}else{
	$res["msg"] = -1;
    $res["error"] = "Upload Fail";
	$res['filename']="";
	$res['Hospital_Picture_url']="";
}


echo json_encode($res);
?>