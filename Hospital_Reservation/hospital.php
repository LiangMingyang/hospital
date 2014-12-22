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

    <!--弹窗-->
    <script type="text/javascript"  src="js/jquery.hDialog.js"></script>
    <link rel="stylesheet" href="css/common.css"/><!-- 基本样式 -->
    <link rel="stylesheet" href="css/animate.min.css"/> <!-- 动画效果 -->
    <script type="text/javascript"  src="js/selectprovince.js"></script>

    <script type="text/javascript" src="js/logout.js"></script>
    <?php
    session_start();
    if (!isset($_SESSION['rd_token']))
        $_SESSION['rd_token']="#";//#未登录 空已登录
    //登陆之后跳转回来的时候将登陆信息保存
    if (isset($_SESSION['tiaozhuan']))
    {//判断是否跳转到本页面
        unset($_SESSION['tiaozhuan']);
        if(!isset($_SESSION['isUser'])or $_SESSION['isUser']==""){
            $_SESSION['isUser']=$_POST['isUser'];
            if($_SESSION['isUser']=='1'){
                $_SESSION["Province_ID"]=$_POST["Province_ID"];
                $_SESSION["Province_Name"]=$_POST['Province_Name'];
                $_SESSION["Credit_Rank"]=$_POST['Credit_Rank'];
                $_SESSION["UserName"]=$_POST['UserName'];
                $_SESSION["User_ID"]=$_POST['User_ID'];
                $_SESSION["Credit_Rank"]=$_POST["Credit_Rank"];
                $_SESSION["Area_ID"]=$_POST['Area_ID'];
                $_SESSION["Area_Name"]=$_POST['Area_Name'];
                $_SESSION["Appointment_Limit"]=$_POST['Appointment_Limit'];
                $_SESSION["Identity_ID"]=$_POST['Identity_ID'];
                $_SESSION["Sex"]=$_POST["Sex"];
                $_SESSION["Birthday"]=$_POST['Birthday'];
                $_SESSION["Location"]=$_POST['Location'];
                $_SESSION["Phone"]=$_POST['Phone'];
                $_SESSION["Mail"]=$_POST['Mail'];
                $_SESSION['LastLogInTime']=$_POST['LastLogInTime'];
                //unset($_SESSION['rd_token']);
                $_SESSION['rd_token']="";
            }
            else if($_SESSION['isUser']=='0'){
                $_SESSION['Admin_ID']=$_POST['Admin_ID'];
                $_SESSION['Admin_Name']=$_POST['Admin_Name'];
                $_SESSION['isSuper']=$_POST['isSuper'];
                $_SESSION['LastLogInTime']=$_POST['LastLogInTime'];
                //unset($_SESSION['rd_token']);
                $_SESSION['rd_token']="";
            }
        }
    }
    $a;
    if (isset($_COOKIE['Province_ID']))
    {
		$a=$_COOKIE['Province_ID'];
        $_SESSION['Province_ID']=$a;
        $_SESSION['Province_Name']=$_COOKIE['Province_Name'];
    }
    if (!isset($_SESSION['Province_ID'])||$_SESSION['Province_ID']="")
    {
        $_SESSION['Province_ID']="0";
        $_SESSION['Province_Name']="北京市";
    }
    echo "<script type='text/javascript'>var Province_ID="  .$a.   ";var Province_Name=\""  .  $_SESSION["Province_Name"] ."\";</script>";
    ?>
</head>
<body>

<!-- 导航栏代码begin -->
<div id="topnavbar" style="display: block;">
    <div id="topnanv" style="width: 980px;">
        <div class="defu"> <a href="index.php" target="_self">首页</a> </div>
        <div id="anvlfteb">
            <div selec="order" class="posbox"> <a href="javascript:void(0)">预约</a> <i></i></div>
            <div selec="notice" class="posbox"><a href="javascript:void(0)">公告</a><i></i></div>
            <div selec="orderhelp" class="posbox"><a href="javascript:void(0)">帮助</a> <i></i></div>
            <div selec="suggest" class="posbox"><a href="javascript:void(0)">反馈</a><i></i></div>
            <div id="seledbox" class="posiabox" style="display: none; left: 1px;">
                <div> </div>
            </div>
        </div>
        <?php
        if ($_SESSION['rd_token']=="#")
        {
            echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_blank\" href=\"php/register.php\">注册</a> </div>";
            echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" href=\"php/login.php?lastweb=../index.php\">登录</a> </div>";
        }
        else {
            echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" onclick='logout(\"".'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\")' href=\"javascript:void(0)\">登出</a> </div>";
            if($_SESSION['isUser']=='1')
                echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" href=\"php/IndividualCenter.php\">".$_SESSION['UserName']."点击进入个人中心</a> </div>";
            else echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" href=\"php/IndividualCenter.php\">".$_SESSION['Admin_Name']."点击进入个人中心</a> </div>";
        }
        echo '<div id="btn"> <a style="color:#FFF" target="_self" href="javascript:void(0)" id="provincebtn">您的所在地：['.$_SESSION["Province_Name"].']，点击可更换</a> </div>';
        ?>
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

<div class="province_list" id="province_list">
    <div class="content">
        <ul>

        </ul>
    </div>
</div>

<div class="province_list" id="province_list">
    <div class="content">
        <ul>

        </ul>
    </div>
</div>
</body>
</html>