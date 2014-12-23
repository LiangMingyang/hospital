/**
 * Created by Yip on 2014/11/30.
 */

//加密信息需要
var encrypttime=getEncryptTime();
var token=getToken(encrypttime);
//全局变量保存
var hospital_number;
var Province_ID,Area_ID='',Hospital_Level='',start=0,size=10;

var bjqPagination=false;//判断分页按钮是否初始化
$(document).ready(function(){
    Init_User_info();

    if (Province_ID==undefined||Province_ID=='undefined')Province_ID=0;
    Get_Area_Info_By_Province_ID(Province_ID);
    Find_Hospital(Province_ID,Area_ID,Hospital_Level,start,size);
    //jqPaginationInit(hospital_number);
});

//分页按钮初始化
function jqPaginationInit(number)
{
    $('.pagination').jqPagination({
        //link_string : '/?page={page_number}',
        current_page: 1, //设置当前页 默认为1
        max_page : Math.ceil(number/size), //设置最大页 默认为1
        page_string : '当前第{current_page}页,共{max_page}页',
        paged : function(page) {
            //回发事件。。。
            if (bjqPagination)Find_Hospital(Province_ID,Area_ID,Hospital_Level,size*(page-1),size);
            //bjqPagination=true;
        }
    });
}


//将初始用户信息保存到Cookies
function Init_User_info()
{
    //setCookie("province_ID",1,30);
    Get_Province_Info();
}

//跳转到医院详细信息页面
function HospitalDetail(hpid)
{
    window.location.href="hospitaldetail.php?hpid="+hpid;
}

function Find_Hospital(province_ID,Area_ID,Hospital_Level,start,size)
{
    encrypttime=getEncryptTime();
    //获取医院列表
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
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
        // complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定

            $(".hospital_list .content ul").empty();//清空上次保存的医院列表

            var data = msg.content;
            hospital_number=msg.total;
            $.each(data,function(idx,item){
                var newhosp='<li'+'>';
                newhosp+='<img src="'+ item.Hospital_Picture_Url +'" height="96" width="128">';
                newhosp+='<strong><a href="#" onclick="HospitalDetail('+item.Hospital_ID+')">'+ item.Hospital_Name +'</a></strong>';
                newhosp+='</li'+'>';
                $(".hospital_list .content ul").append(newhosp);
                //输出
                //alert(item.id+"哈哈"+item.name);
            });
            if (!bjqPagination){jqPaginationInit(hospital_number);bjqPagination=true;}
        }
    });
}

//获取地区信息
function Get_Area_Info_By_Province_ID(province_ID)
{
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Get_Area_Info_By_Province_ID",//要访问的后台地址
        data: {
            url: 'Get_Area_Info_By_Province_ID',
            encrypttime: encrypttime,
            Province_ID: province_ID
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            var data = msg.content;
            $.each(data,function(idx,item){
                var newelement='<li><a href=\"javascript:void(0)\" onclick=\"areafilter(\'';
                newelement+=item.Area_ID+'\')';
                newelement+='\" id=\"area'+ item.Area_ID +'\">';
                newelement+=item.Area_Name+'</a></li>';
                $(".listbox .arealist .hospital_area ul").append(newelement);
                //输出
                //alert(item.id+"哈哈"+item.name);
            });
        }
    });
}

//过滤函数
function levelfilter(Hospital_Level)
{
    bjqPagination=false;
    Find_Hospital(Province_ID,Area_ID,Hospital_Level,start,size);
    //jqPaginationInit(hospital_number);
    $(".hospital_level ul li a").attr("class","");
    $("#level"+Hospital_Level).attr("class","selected");
    //$(".hospital_level ul li a").removeClass();
}

function areafilter(Area_ID)
{
    bjqPagination=false;
    Find_Hospital(Province_ID,Area_ID,Hospital_Level,start,size);
    //jqPaginationInit(hospital_number);
    $(".hospital_area ul li a").attr("class","");
    $("#area"+Area_ID).attr("class","selected");
}