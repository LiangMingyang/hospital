<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="/include/div_flash.js"></script>
<title>动画弹出层</title>
<style>
.list{
	position:relative;;
	background:#eee;
	border:1px #ccc solid;
	margin:10px;
	height:30px;
	width:100px;
	cursor :pointer ;
}
.listShow{
	position:relative;
	background:#eff;
	border:1px #ddd solid;
	margin:10px;
	height:30px;
	width:100px;
	cursor :pointer ;
}
.comment{
	position:absolute;
	left:0;
	display:none;
	position:absolute;
	border:1px #ccc solid;
	background:#fee;
	width:200px;
	height:200px;
	overflow:hidden;
	z-index:100;
}
</style>
</head>
<body>
<div class="" id="show">
0
</div>
<div class="list" id="list1">1
	<div class="comment" id="comment1">源码爱好者<br/>
</div>
<div class="list" id="list2">2
	<div class="comment" id="comment2">新浪搜狐</div>
</div>
<div class="list" id="list3">3
	<div class="comment" id="comment3">网页特效</div>
</div>
<script>
</script>
</body>
</html>
