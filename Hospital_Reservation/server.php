<?php
$img = isset($_POST['img'])? $_POST['img'] : '';

// ��ȡͼƬ
list($type, $data) = explode(',', $img);

// �ж�����
if(strstr($type,'image/jpeg')!==''){
    $ext = '.jpg';
}elseif(strstr($type,'image/gif')!==''){
    $ext = '.gif';
}elseif(strstr($type,'image/png')!==''){
    $ext = '.png';
}

// ���ɵ��ļ���
$photo = time().$ext;

// �����ļ�
file_put_contents($photo, base64_decode($data), true);

// ����
header('content-type:application/json;charset=utf-8');
$ret = array('img'=>$photo);
echo json_encode($ret);
?>