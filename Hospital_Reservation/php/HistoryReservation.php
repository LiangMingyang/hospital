<!DOCTYPE html >
<html>
<?php
date_default_timezone_set('PRC');
?>
<head>

    <script src="../include/jquery-2.1.1.js"></script>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script src="../include/My97DatePicker/WdatePicker.js"></script>
    <link rel="stylesheet" type="text/css" href="../include/flexigrid/css/flexigrid.css" />
    <script type="text/javascript" src="../include/flexigrid/jquery-1.2.3.pack.js"></script> 
    <script type="text/javascript" src="../include/flexigrid/flexigrid.js"></script>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js" type="text/javascript"></script>
    <script language="JavaScript" src="../include/sha1.js"></script>
    <script src="../js/HistoryReservation.js"></script>
    <link href="../css/HistoryReservation.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="search_area">
	<p>预约起始时间</p> 
	<input name="StartDate" id="StartDate" 
		   class="Wdate" value="<?php echo date('Y-m-d') ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
    <p>预约截止时间</p> 
    <input name="EndDate" id="EndDate" 
			class="Wdate" value="<?php echo date('Y-m-d') ?>"onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">  
	<input type="button" readonly="readonly" id="search" onclick="search()" value="搜索"/>
    
</div>
<br /><br /><br />
<div id="presentation_area">
	<table id="history_tb"></table>
</div>   

</body>
</html>