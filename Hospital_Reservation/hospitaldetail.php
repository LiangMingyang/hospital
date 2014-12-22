<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全国医院预约挂号统一系统</title>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/sha1.js"></script>
    <link rel="stylesheet" href="css/index.css" type="text/css" />

    <script type="text/javascript" src="js/hospitaldetail.js"></script>
    <link href="css/hospitaldetail.css" rel="stylesheet" type="text/css" />

    <?php
        echo "<script type=\"text/javascript\">var hospital_id=".$_REQUEST["hpid"].";</script>";
    ?>

    <!-- 导航栏-->
    <link href="css/topanv.v1.0.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/topanv.js"></script>

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

<div class="listbox">
    <!--医院详细信息显示-标题-->
    <div class="hospital">

    </div>

    <!--医院详细信息显示-内容-->
    <div class="notes">
    <img src="" height="135" width="180"/>
    <span>
    </span>
    </div>

    <!--医院科室-->
    <div class="yytitle"><p>开放预约科室</p></div>
    <div class="yyksbox">
        <div class="yyksxl">
            <div class="ks_content">
                <ul></ul>
            </div>
        </div>
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