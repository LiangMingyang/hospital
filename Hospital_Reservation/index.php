<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>全国医院预约挂号统一系统</title>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/index.css" type="text/css" />
    <script type="text/javascript" src="js/sha1.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <!-- 导航栏-->
    <link href="css/topanv.v1.0.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/topanv.js"></script>

    <!-- slider-->
    <link rel="stylesheet" href="css/slider.css" type="text/css" />
    <script type="text/javascript" src="js/slider.js"></script>
    <script type="text/javascript" src="js/slider_data.js"></script>

    <!--tabblock-->
    <link rel="stylesheet" href="css/tabblock.css" type="text/css" />
    <script type="text/javascript" src="js/tabblock.js"></script>

    <!--tabblock new-->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/tabs.css" />
    <script type="text/javascript" src="js/modernizr.min.js"></script>
    <script type="text/javascript" src="js/tab_design.js"></script>

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

    //print_r($_COOKIE);
    //print_r($_SESSION);
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

<!-- slider代码Begin -->
<div id="header">
    <div class="wrap">
        <div id="slide-holder">
            <div id="slide-runner">
                <a href="#" target="_blank"><img id="slide-img-1" src="images/slider_a1.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-2" src="images/slider_a2.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-3" src="images/slider_a3.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-4" src="images/slider_a4.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-5" src="images/slider_a5.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-6" src="images/slider_a6.jpg" class="slide" alt="" /></a>
                <a href="#" target="_blank"><img id="slide-img-7" src="images/slider_a4.jpg" class="slide" alt="" /></a>
                <div id="slide-controls">
                    <p id="slide-client" class="text"><strong></strong><span></span></p>
                    <p id="slide-desc" class="text"></p>
                    <p id="slide-nav"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider代码End -->

<div id="page-wrap">
    <h1>医院预约</h1>
    <div id="tab_design">
        <a class="blind" href="#contents">跳过选项卡菜单</a>
        <nav class="tab_menu clearfix">
            <ul>
                <li class="tabli">
                    <a href="#hospthree">
                        <img src="img/icon_three.png" alt="" width="24" height="24" />三级医院
                    </a>
                </li>
                <li class="tabli">
                    <a href="#hosptwo">
                        <img src="img/icon_two.png" alt="" width="24" height="24" />二级医院
                    </a>
                </li>
            </ul>
        </nav><!-- e: .tab_menu -->
        <div class="tab_contents">
            <ul>
                <li id="hospthree" class="tabli">
                    <div class="hospital_list">
                        <div class="content">
                            <ul>

                            </ul>
                        </div>
                    </div>
                </li>
                <li id="hosptwo" class="tabli">
                    <div class="hospital_list">
                        <div class="content">
                            <ul>

                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div><!-- e: .tab_contents -->
    </div><!-- e: #tab_design -->
</div><!-- e: #page-wrap -->

<!--tab选项代码Begin-->
<div class="i_zxme">
    <div class="i_zxmel">
        <div class="i_zxmelt"><div class="title">医院简介</div></div>
        <div class="i_zxmelc">
            <div class="i_zxmelc1">
                <ul>
                    <li id="two1" onmouseover="setContentTab('two',1,2)" class="hover"><a href="javascript:void(0)">三级医院</a></li>
                    <li id="two2" onmouseover="setContentTab('two',2,2)"><div class="i_zxmelc"><a href="javascript:void(0)">二级医院</a></div></li>
                </ul>
            </div><!--i_zxmelc1-->

            <div class="i_zxmelc3">
                <div id="con_two_1" style="display: block;">
                    <div class="i_zxmelc2"><img src="images/tab_third_hosp.jpg"/></div><!--i_zxmelc2-->
                    <div class="i_zxmelc3d">
                        <div class="i_zxmelc31">
                            <p>三级医院</p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            三级医院是跨地区、省、市以及向全国范围提供医疗卫生服务的医院，是具有全面医疗、教学、科研能力的医疗预防技术中心。其主要功能是提供专科（包括特殊专科）的医疗服务，解决危重疑难病症，接受二级转诊，对下级医院进行业务技术指导和培训人才；完成培养各种高级医疗专业人才的教学和承担省以上科研项目的任务；参与和指导一、二级预防工作。
                        </div><!--i_zxmelc31-->
                    </div> <!--i_zxmelc3d-->
                </div><!--con_one5_1-->

                <div id="con_two_2" style="display: none;">
                    <div class="i_zxmelc2"><img src="images/tab_second_hosp.jpg"/></div>
                    <div class="i_zxmelc3d">
                        <div class="i_zxmelc31">
                            <p>二级医院</p>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            二级医院的基本标准是：向多个社区提供综合医疗卫生服务和承担一定教学、科研任务的地区性医院;具有五百张以下，一百张以上病床的规模的医院可以申报二级医院，又根据技术力量、设备条件、人员结构、科研水平等划分为甲、乙、丙三等。二级甲等医院应该是二级医院中实力最强的了。
                        </div><!--i_zxmelc31 -->
                    </div> <!--i_zxmelc3d-->
                </div><!--con_one5_2-->
            </div><!--i_zxmelc3-->

        </div><!--i_zxmelc-->

    </div><!--i_zxmel-->

    <div class="i_zxmer">
        <ul>
            <li><img src="images/tab_main.png"/></li>
        </ul>
    </div><!--i_zxmer-->
</div><!--i_zxme全局-->
<!--tab选项代码End-->

<div class="province_list" id="province_list">
    <div class="content">
        <ul>

        </ul>
    </div>
</div>
</body>
</html>
