/**
 * Created by Yip on 2014/12/3.
 */

//加密信息需要
var encrypttime;
//var encrypttime=getEncryptTime();
//var token=getToken(encrypttime);
//全局变量保存

$(document).ready(function(){
    Init_User_info();
    Get_HospitalInfo_detail(hospital_id);
    Get_DepartInfo(hospital_id);
});


//将初始用户信息保存到Cookies
function Init_User_info()
{
    //setCookie("province_ID",1,30);
}

//跳转到科室时间页面
function HospitalTime(hpid,dpmid,dpmname)
{
    window.location.href="hospitaltime.php?hpid="+hpid+"&dpmid="+dpmid+"&dpmname="+dpmname;
}


//读取医院详细信息
function Get_HospitalInfo_detail(hospital_id)
{
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Get_HospitalInfo_detail",//要访问的后台地址
        data: {
            url:'Get_HospitalInfo_detail',
            encrypttime:encrypttime,
            Hospital_ID:hospital_id
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            var data = msg.content;
            //var data = eval("("+msg+")");
            $.each(data,function(idx,item){
                var newelement='<p>'+item.Hospital_Name+'</p>';
                newelement+='<label><strong>等级：</strong>';
                switch (item.Hospital_Level)
                {
                    case 31: newelement+='三级甲等';break;
                    case 32:newelement+='三级乙等';break;
                    case 33:newelement+='三级丙等';break;
                    case 21:newelement+='二级甲等';break;
                    case 22: newelement+='二级乙等';break;
                    case 23: newelement+='二级丙等';break;
                    case 11: newelement+='一级甲等';break;
                    case 12: newelement+='一级乙等';break;
                    case 13: newelement+='一级丙等';break;
                    default:break;
                }
                newelement+='</label>';
                $(".listbox .hospital").append(newelement);

                $(".listbox .notes img").attr("src",item.Hospital_Picture_Url);
                newelement="<li>联系地址："+item.Hospital_Location+"</li>"+"<li>医院简介："+item.Hospital_Introduction+"</li>"+"<li>开诊时间："+item.Reservation_Start_Time+"</li>"+"<li>结诊时间："+item.Reservation_End_Time+"</li>";
                $(".listbox .notes span").append(newelement);
            });
        }
    });
}

//获取科室信息
function Get_DepartInfo(hospital_id){
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Get_DepartInfo",//要访问的后台地址
        data: {
            url:'Get_DepartInfo',
            encrypttime:encrypttime,
            Hospital_ID:hospital_id
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            var data = msg.content;
            //var data = eval("("+msg+")").content;
            $.each(data,function(idx,item){
                var newhosp='<li>';
                newhosp+='<a href=\"javascript:void(0)\" onclick=\"HospitalTime('+hospital_id+','+item.Depart_ID+',\''+item.Depart_Name+'\')\">'+ item.Depart_Name +'</a>';
                newhosp+='</li>';
                $(".yyksbox .yyksxl .ks_content ul").append(newhosp);
                //输出
                //alert(item.id+"哈哈"+item.name);
            });
        }
    });
}
