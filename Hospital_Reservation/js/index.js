/**
 * Created by Yip on 2014/11/27.
 */

var Province_ID;
//加密信息需要
var encrypttime;
//var token=getToken(encrypttime);

$(document).ready(function(){
    Init_User_info();
    if (Province_ID==undefined||Province_ID=='undefined')Province_ID=0;
    Find_Hospital("#hospthree",Province_ID,'',31,0,10);
    Find_Hospital("#hosptwo",Province_ID,'',21,0,10);
});

//将初始用户信息保存到Cookies
function Init_User_info()
{
    //setCookie("province_ID",1,30);

}

//读取医院信息
//http://www.cnblogs.com/xinsheng/p/3908631.html
//http://www.php100.com/html/program/jquery/2013/0905/5912.html
//http://www.cnblogs.com/fredlau/archive/2008/08/12/1266089.html
//获取医院列表
function Find_Hospital(divname,province_ID,Area_ID,Hospital_Level,start,size)
{
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:"php/TransferStation.php",
        //url: "http://hospital.wannakissyou.com/Find_Hospital_By_Condition",//要访问的后台地址
        data:{
            url:'Find_Hospital_By_Condition',
            encrypttime:encrypttime,
            Province_ID:province_ID,
            Area_ID:Area_ID,
            Hospital_Level:Hospital_Level,
            start:start,
            size:size
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            var data = msg.content;
            hospital_number=msg.total;
            $.each(data,function(idx,item){
                var newhosp='<li>';
                //newhosp+='<img src=\"'+ item.Hospital_Picture_url +'\" height=\"96\" width=\"128\">';
                newhosp+='<strong><a href="javascript:void(0)" onclick="HospitalDetail('+item.Hospital_ID+')">'+ item.Hospital_Name +'</a></strong>';
                newhosp+='</li>';
                $(divname+" .hospital_list .content ul").append(newhosp);
                //输出
                //alert(item.id+"哈哈"+item.name);
            });
            var newhosp='<li>';
            newhosp+='<strong><a href="hospital.php">点击查看更多医院</a></strong>';
            newhosp+='</li>';
            $(divname+" .hospital_list .content ul").append(newhosp);
        }
    });
}

function HospitalDetail(hpid)
{
    window.location.href="hospitaldetail.php?hpid="+hpid;
}

//cookies相关函数
function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end))
        }
    }
    return ""
}
function setCookie(c_name,value,expiredays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+
        ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}