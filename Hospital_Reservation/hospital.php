<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全国医院预约挂号统一系统-医院列表</title>
    <script type="text/javascript"  src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>

    <link rel="stylesheet" href="css/index.css" type="text/css" />
    <script type="text/javascript" src="js/sha1.js"></script>
    <script type="text/javascript"  src="js/hospital.js"></script>

    <!-- 导航栏-->
    <link href="css/topanv.v1.0.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript"  src="js/topanv.js"></script>

    <!--分页-->
    <link rel="stylesheet" href="css/jqpagination.css" type="text/css" />
    <script type="text/javascript" src="js/jquery.jqpagination.min.js"></script>

    <!--筛选、列表-->
    <link rel="stylesheet" href="css/hospitallist.css" type="text/css" />

    <?php
    session_start();
    if (isset($_SESSION['UserName']))
    {echo "<script type='text/javascript'>var username=".$_SESSION['UserName'].";</script>";}
    $_SESSION['rd_token']="#";
    //$_SESSION['User_ID']=="#"
    if (isset($_SESSION['Province_ID']))
    {echo "<script type='text/javascript'>var Province_ID="  .$_SESSION["Province_ID"].   ";var Province_Name="  .  $_SESSION["Province_Name"] .";</script>";}
    ?>
</head>
<body>

<!-- 导航栏代码begin -->
<div id="topnavbar" style="display: block;">
    <div id="topnanv" style="width: 980px;">
        <div class="defu"> <a href="#" target="_self">首页</a> </div>
        <div id="anvlfteb">
            <div selec="order" class="posbox"> <a href="#">预约</a> <i></i></div>
            <div selec="notice" class="posbox"><a href="#">公告</a><i></i></div>
            <div selec="orderhelp" class="posbox"><a href="#">帮助</a> <i></i></div>
            <div selec="suggest" class="posbox"><a href="#">反馈</a><i></i></div>
            <div id="seledbox" class="posiabox" style="display: none; left: 1px;">
                <div> </div>
            </div>
        </div>
        <div id="btn"> <a style="color:#FFF" target="_blank" href="#">注册</a> </div>
        <div id="btn"> <a style="color:#FFF" target="_blank" href="#">登陆</a> </div>
        <div id="btn"> <a style="color:#FFF" target="_blank" href="#">您所在的城市为：[]，点击可更换</a> </div>
    </div>
</div>
<!-- 导航栏代码end -->

<!--筛选功能-->
<div class="listbox">
    <div class="arealist">
        <div class="title">医院等级：</div>
        <div class="hospital_level">
            <ul>
                <li><a class="selected" onclick="levelfilter('')" id="level">不限</a></li>
                <li><a  onclick="levelfilter(31)" id="level31" href="javascript:void(0)">三级甲等</a></li>
                <li><a  onclick="levelfilter(32)" id="level32" href="javascript:void(0)">三级乙等</a></li>
                <li><a  onclick="levelfilter(33)" id="level33" href="javascript:void(0)">三级丙等</a></li>
                <li><a  onclick="levelfilter(21)" id="level21" href="javascript:void(0)">二级甲等</a></li>
                <li><a  onclick="levelfilter(22)" id="level22" href="javascript:void(0)">二级乙等</a></li>
                <li><a  onclick="levelfilter(23)" id="level23" href="javascript:void(0)">二级丙等</a></li>
                <li><a  onclick="levelfilter(11)" id="level11" href="javascript:void(0)">一级甲等</a></li>
                <li><a  onclick="levelfilter(12)" id="level12" href="javascript:void(0)">一级乙等</a></li>
                <li><a  onclick="levelfilter(13)" id="level13" href="javascript:void(0)">一级丙等</a></li>
            </ul>
        </div>
        <div class="listboxline"></div>
        <div class="title">所属区县：</div>
        <div class="hospital_area">
            <ul>
                <li><a class="selected"  href="javascript:void(0)" onclick="areafilter('')" id="area">不限</a></li>
            </ul>
        </div>
    </div>
</div>

<!--医院列表-->
<div class="hospital_list">
    <div class="content">
        <ul>

        </ul>
    </div>
</div>

<!-- 分页代码begin -->
<div class="pagination">
    <a href="#" class="first" data-action="first">&laquo;</a>
    <a href="#" class="previous" data-action="previous">&lsaquo;</a>
    <input type="text" readonly="readonly" data-max-page="40" />
    <a href="#" class="next" data-action="next">&rsaquo;</a>
    <a href="#" class="last" data-action="last">&raquo;</a>
</div>
<!-- 分页代码end -->

</body>
</html>