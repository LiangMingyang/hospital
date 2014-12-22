<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全国医院预约挂号统一系统</title>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/index.css" type="text/css" />
    <link href="css/hospitaltime.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/sha1.js"></script>

    <script type="text/javascript" src="js/hospitaltime.js"></script>

    <!-- 导航栏-->
    <link href="css/topanv.v1.0.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/topanv.js"></script>

    <!--弹窗-->
    <script type="text/javascript"  src="js/jquery.hDialog.js"></script>
    <link rel="stylesheet" href="css/common.css"/><!-- 基本样式 -->
    <link rel="stylesheet" href="css/animate.min.css"/> <!-- 动画效果 -->
    <script type="text/javascript"  src="js/selectprovince.js"></script>

    <?php
    @header('Content-type: text/html;charset=UTF-8');
    //http://localhost:63342/SystemAnalysisProject/hospitaltime.php?hpid=3&dpmid=5&dpmname=%E7%9C%BC%E7%A7%91
    //输出医院id和科室id
        echo '<script type="text/javascript">var hospital_id='.$_REQUEST['hpid'].';'.'var department_id='.$_REQUEST['dpmid'].';var department_name=\''.$_REQUEST['dpmname'].'\';</script>';
    ?>

    <script type="text/javascript" src="js/logout.js"></script>
    <?php
    session_start();
    echo "<script type='text/javascript'>var User_ID=-1;</script>";

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
            {
                echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" href=\"php/IndividualCenter.php\">".$_SESSION['UserName']."点击进入个人中心</a> </div>";
                echo "<script type='text/javascript'>var User_ID=".$_SESSION['User_ID'].";</script>";
            }
                else echo "<div id=\"btn\"> <a style=\"color:#FFF\" target=\"_self\" href=\"php/IndividualCenter.php\">".$_SESSION['Admin_Name']."点击进入个人中心</a> </div>";
        }
        echo '<div id="btn"> <a style="color:#FFF" target="_self" href="javascript:void(0)" id="provincebtn">您的所在地：['.$_SESSION["Province_Name"].']，点击可更换</a> </div>';
        ?>
    </div>
</div>
<!-- 导航栏代码end -->

<!--医院信息，时间列表-->
<div class="listbox">
    <div class="hospital">
        <!--<p>北京大学第三医院——泌尿外科门诊</p>
        <label><strong>等级：</strong>三级甲等<strong>区域：</strong>海淀区<strong>分类：</strong>北京大学附属医院</label>-->
    </div>
    <div class="notes_gh"><div class="notes_ght">重要提示:</div>
        <div class="notes_ghn">
        </div>
    </div>
    <div class="detail">
        <table style="width:962px;border:1px #B4E0FC solid;border-bottom:0px;background:#E9F6FD;" border="0" cellpadding="0" cellspacing="1" width="100%">
            <tbody><tr>
                <td bgcolor="#E9F6FD"><div class="tabletitle"><strong>预约月历表</strong><p>（点击日历上日期进行预约挂号）</p><span><a href="hospitaldetail.php?hpid=<?php echo $_REQUEST['hpid']?>"><img alt='' src="img/fhksy.gif" align="absmiddle" height="27" width="115"></a></span></div></td>
            </tr>
            </tbody></table>
        <table style="width:962px;background:#B4E0FC;" border="0" cellpadding="0" cellspacing="1" width="100%">
            <tbody><tr>
                <td class="detailbt">&nbsp;</td>
                <td class="datatext red1">日</td>
                <td class="datatextb">一</td>
                <td class="datatext">二</td>
                <td class="datatext">三</td>
                <td class="datatextb">四</td>
                <td class="datatextb">五</td>
                <td class="datatextb green1">六</td>
            </tr>
            </tbody></table>

        <table style="width:962px;border-left:1px #B4E0FC solid;" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <!-- 月份选择框 -->
                <td style="border-bottom:1px #B4E0FC solid;" bgcolor="#E9F6FD" valign="top" width="131">
                    <table style="margin:0px;" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr>
                        <td style="height:30px;_height:0px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><p class="nyr_up"><a href="javascript:void(0)" onclick=""></a></p></td>
                    </tr>
                    <tr>
                        <td height="50">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><p class="nyr_center"><?php  echo date("Y-m",time());//获取当前时间?></p></td>
                    </tr>
                    <tr>
                        <td height="50">&nbsp;</td>
                    </tr>
                    <tr>
                        <td><p class="nyr_down"><a href="javascript:void(0)" onclick=""></a></p></td>
                    </tr>
                    <tr>
                        <td style="_height:80px;">&nbsp;</td>
                    </tr></tbody></table>
                </td>

                <!--日期选择栏-->
                <td valign="top">
                    <table style="background:#B4E0FC;" border="0" cellpadding="0" cellspacing="1" width="100%">
                        <tbody id="calendar">
                        </tbody>
                    </table>
                </td>
                </tr></tbody>
        </table>
    </div>
</div>

<!--<div style="display: none; opacity: 1; cursor: auto;" id="cboxOverlay"></div>
<div style="display: none; padding-bottom: 42px; padding-right: 42px; top: 318px; left: 219px; position: absolute; width: 818px; height: 761px; opacity: 1; cursor: auto;"
     class="" id="colorbox">
    <div style="height: 803px; width: 860px;" id="cboxWrapper">
        <div>
            <div style="float: left;" id="cboxTopLeft"></div>
            <div style="float: left; width: 818px;" id="cboxTopCenter"></div>
            <div style="float: left;" id="cboxTopRight"></div>
        </div>
        <div style="clear: left;">
            <div style="float: left; height: 761px;" id="cboxMiddleLeft"></div>
            <div style="float: left; width: 818px; height: 761px;" id="cboxContent">

                <div style="display: block; width: 818px; overflow: auto; height: 733px;" id="cboxLoadedContent">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
                        <tbody><tr>
                            <td class="riqidh" align="left">开始预约</td>
                        </tr>
                        </tbody>
                    </table>

                    <table align="center" border="0" cellpadding="1" cellspacing="1" width="800" id="doctorcontent">
                        <tbody id="doctortbody"><tr>
                            <td class="tdtitle">医生</td>
                            <td class="tdtitle">时间段</td>
                            <td class="tdtitle">操作</td></tr>
                        </tbody></table>
                </div>
            </div>
            <div style="float: left; height: 761px;" id="cboxMiddleRight"></div>
        </div>
        <div style="clear: left;"><div style="float: left;" id="cboxBottomLeft"></div>
                    <div style="float: left; width: 818px;" id="cboxBottomCenter"></div>
                    <div style="float: left;" id="cboxBottomRight"></div>
        </div>
    </div>
    <div style="position: absolute; width: 9999px; visibility: hidden; display: none;"></div>
</div>-->

<div id="doctorcontent" class="doctorcontent">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="500">
        <tbody><tr>
            <td class="riqidh" align="left">开始预约</td>
        </tr></tbody>
    </table>
    <table align="center" border="0" cellpadding="1" cellspacing="1" width="500">
        <tbody id="doctortbody">
            <tr>
                <td class="tdtitle">医生</td>
                <td class="tdtitle">时间段</td>
                <td class="tdtitle">操作</td>
            </tr>
        </tbody>
    </table>
</div>
<!--病症填写弹窗-->
<div id="HBox">
    <form action="" method="post" onsubmit="return false;">
        <ul class="list">
            <li>
                <strong>请简要描述一下您的病状：<font color="#ff0000">*</font></strong>
                <div class="fl"><textarea name="Reseration_Symptom"  class="ipt Reseration_Symptom"></textarea></div>
            </li>
            <li><input type="submit" value="确认提交" class="submitBtn" /></li>
        </ul>
    </form>
</div><!-- HBox end -->

<div class="province_list" id="province_list">
    <div class="content">
        <ul>

        </ul>
    </div>
</div>
</body>
</html>