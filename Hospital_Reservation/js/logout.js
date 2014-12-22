/**
 * Created by Yip on 2014/12/22.
 */
function logout(web)
{
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/logout.php',
        async:false
    });
    window.location.href=web;
}