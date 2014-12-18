<?php
/**
 * 全局公用方法
 * @author chunyuan.ye
 * @since 2010-03-05
 */

function template ($name)
{
    return ROOT . 'template/' . $name . '.tpl.php';
}
function header_inc ()
{
    return ROOT . 'template/header.inc.php';
}

// 验证用户是否已经登录
/**
 * 验证用户是否已登录，如果未登录，跳转到登录页面
 * 验证用户是否有权限，如果没有权限，阻止访问
 */
 /*
function authorize ($module = '', $menuName = '', $para = '')
{
    session_start();
    if (! $_SESSION['userid'] || ! $_SESSION['username']) {
        header('Location:' . WEB_ROOT . 'system/login.php');
    } else {
        $m = new menu();
        $menu = $m->get_by_name($module, $menuName, $para);
        if ($menu) {
            session_start();
            $roleId = $_SESSION['userrole'];
            $rm = new role_menu();
            if (! $rm->check($roleId, $menu['MenuID'])) {
                echo "<script>alert('对不起，您没有使用此功能的权限');window.location='" . WEB_ROOT . "index.php';</script>";
            }
        }
    }
}
*/
function display_filetype ($file)
{
    $path = IMAGE_PATH;
    //检查文件格式并显示相应的图表和属性
    //图片文件
    if (preg_match("^.*(\.bmp|\.jpg|\.jpeg)^", $file)) {
        $icon = "<IMG SRC='".$path."icon/IMG.ico' alt=\"图片\" border=\"0\">";
    }
    //PDF文件
    elseif (preg_match("^.*\.pdf^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/_PDFFile.ico\" alt=\"PDF文件\" border=\"0\">";
    } //Excel文件
    elseif (preg_match("^.*(\.xls|\.xlsx)^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/EXCEl.ico\" alt=\"PDF文件\" border=\"0\">";
    }  //Word文件
    elseif (preg_match("^.*(\.doc|\.docx)^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/WORD.ico\" alt=\"PDF文件\" border=\"0\">";
    } //文本文件  
    elseif (preg_match("^.*\.txt^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/TEXT.ico\" alt=\" 文本文件\" border=\"0\">";
    } //压缩文件   
    elseif (preg_match("^.*(\.rar|\.tar\.gz|\.7z)^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/ZIP.gif\" alt=\"RAR\" border=\"0\">";
    } ///Web页面文件   
    elseif (preg_match("^.*(\.html|\.htm)^", $file)) {
        $icon = "<IMG SRC=\"".$path."icon/HTML.ico\" alt=\" 网页文件\" border=\"0\">";
    } //不确定格式文件   
    else {
        $icon = "<IMG SRC=\"".$path."icon/UNKNOWN.ico\" alt=\" 未知文件类型\" border=\"0\">";
    }
    return $icon;
}
function translate($eng){
    switch ($eng) {
        case "Sunday":
        case "Sun":
            return "星期日";
        break;
        case "Monday":
        case "Mon":
            return "星期一";
        case "Tuesday":
        case "Tue":
            return "星期二";
        case "Wednesday":
        case "Wed":
            return "星期三";
        case "Thursday":
        case "Thu":
            return "星期四";
        case "Friday":
        case "Fri":
            return "星期五";
        case "Saturday":
        case "Sat":
            return "星期六";
        case "Morning":
            return "上午";
        case "Afternoon":
            return "下午";
        case "Evening":
        case "Night":
            return "晚上";
        default:
            return $eng;
        break;
    }
}
?>