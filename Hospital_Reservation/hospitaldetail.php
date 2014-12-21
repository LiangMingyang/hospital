<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全国医院预约挂号统一系统</title>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/sha1.js"></script>

    <script type="text/javascript" src="js/hospitaldetail.js"></script>
    <link href="css/hospitaldetail.css" rel="stylesheet" type="text/css" />

    <?php
        echo "<script type=\"text/javascript\">var hospital_id=".$_REQUEST["hpid"].";</script>";
    ?>

    <!-- 导航栏-->
    <link href="css/topanv.v1.0.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/topanv.js"></script>

    <?php
    //登陆之后跳转回来的时候将登陆信息保存
    if (isset($_SESSION['tiaozhuan']))//判断是否跳转到本页面
        if($_SESSION['isUser']==""){
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
                unset($_SESSION['rd_token']);
                $_SESSION['rd_token']="";
            }
            else if($_SESSION['isUser']=='0'){
                $_SESSION['Admin_ID']=$_POST['Admin_ID'];
                $_SESSION['Admin_Name']=$_POST['Admin_Name'];
                $_SESSION['isSuper']=$_POST['isSuper'];
                $_SESSION['LastLogInTime']=$_POST['LastLogInTime'];
                unset($_SESSION['rd_token']);
                $_SESSION['rd_token']="";
            }
        }
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

</body>
</html>