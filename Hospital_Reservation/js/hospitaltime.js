/**
 * Created by Yip on 2014/12/3.
 */

//加密信息需要
var encrypttime=getEncryptTime();
var token=getToken(encrypttime);
//全局变量保存
var doctor=new Array();
$(document).ready(function(){
    Init_User_info();
    Get_HospitalInfo_detail(hospital_id);
    gen_calendar(new Date().getFullYear(),new Date().getMonth()+1);
});


//将初始用户信息保存到Cookies
function Init_User_info()
{
    //setCookie("province_ID",1,30);
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
        // complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            var data = msg.content;
            //var data = eval("("+msg+")");
            if (msg.msg==0)
            {
                $.each(data,function(idx,item){
                    var newelement='<p>'+item.Hospital_Name+'——'+department_name+'</p>';
                    newelement+='<label><strong>等级：</strong>';
                    switch (item.Hospital_Level)
                    {
                        case 31:newelement+='三级甲等';break;
                        case 32:newelement+='三级乙等';break;
                        case 33:newelement+='三级丙等';break;
                        case 21:newelement+='二级甲等';break;
                        case 22: newelement+='二级乙等';break;
                        case 23: newelement+='二级丙等';break;
                        case 11: newelement+='一级甲等';break;
                        case 12: newelement+='一级乙等';break;
                        case 13: newelement+='一级丙等';break;
                        default :break;
                    }
                    newelement+='</label>';
                    $(".listbox .hospital").append(newelement);

                    newelement="<strong>开诊时间："+item.Reservation_Start_Time+"</strong><br/>"+"<strong>结诊时间："+item.Reservation_End_Time+"</strong>";
                    $(".listbox .notes_gh .notes_ghn").append(newelement);
                });
            }
        }
    });
}

function Find_Doctor_By_Condition_Free(Hospital_ID,Depart_ID,Duty_Time,Reservation_Time,divid)
{
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Get_DepartInfo",//要访问的后台地址
        data: {
            url:'Find_Doctor_By_Condition_Free',
            encrypttime:encrypttime,
            Hospital_ID:Hospital_ID,
            Depart_ID:Depart_ID,
            Duty_Time:Duty_Time,
            Reservation_Time:Reservation_Time
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            //var data = eval("("+msg+")").content;
            if (msg.msg!=0)return;
            var data = msg.content;
            doctor[Hospital_ID.toString()+Depart_ID.toString()+Reservation_Time.toString()]=msg.content;
            if (data.length>0)
            {
                $(divid).attr("class","greenbg");
                $(divid+" a").attr("onclick",'showdoctor('+hospital_id+','+department_id+',\''+Reservation_Time+'\')');
                $(divid+" span").empty().append("预约");
            }
        }
    });
}

/**
 * 获取上一个月
 *
 * @date 格式为yyyy-mm-dd的日期，如：2014-01
 */
function getPreMonth(date) {
    var arr = date.split('-');
    var year = arr[0]; //获取当前日期的年份
    var month = arr[1]; //获取当前日期的月份
    var year2 = year;
    var month2 = parseInt(month) - 1;
    if (month2 == 0) {
        year2 = parseInt(year2) - 1;
        month2 = 12;
    }
    return  year2 + ',' + month2;
}

/**
 * 获取下一个月
 *
 * @date 格式为yyyy-mm-dd的日期，如：2014-01
 */
function getNextMonth(date) {
    var arr = date.split('-');
    var year = arr[0]; //获取当前日期的年份
    var month = arr[1]; //获取当前日期的月份
    var year2 = year;
    var month2 = parseInt(month) + 1;
    if (month2 == 13) {
        year2 = parseInt(year2) + 1;
        month2 = 1;
    }
    return year2 + ',' + month2;
}
function gen_calendar(year,month)//month已经+1
{
    var genstart=false,gen_num=0;
    var myDate = new Date();
    if (year<myDate.getFullYear()||(year==myDate.getFullYear()&&month-1<myDate.getMonth()))return;
    $(".nyr_up a").attr("onclick","gen_calendar("+getPreMonth(year+"-"+(month))+")");
    $(".nyr_down a").attr("onclick","gen_calendar("+getNextMonth(year+"-"+(month))+")");
    $(".nyr_center").empty().append(year+"-"+month);
    var weekday=(new Date(year,month-1,1)).getDay();
    var daynum=(new Date(year,month,0)).getDate();//生成月天数
    $("#calendar").empty();
    $("#calendar").append("<tr>");
    /*if (year==myDate.getFullYear()&&month==myDate.getMonth())
    {
        while (gen_num<myDate.getDate())
        {
            $("#calendar").append('<td class="detailtext"><b></b><span></span></td>');
            gen_num++;
        }
    }
    else {
        while (gen_num<weekday)
        {
            $("#calendar").append('<td class="detailtext"><b></b><span></span></td>');
            gen_num++;
        }
    }*/
    while (gen_num<weekday)
    {
        $("#calendar").append('<td class="detailtext"><b></b><span></span></td>');
        gen_num++;
    }
    for (var i= 1;i<=daynum;i++)
    {//<tr><td class="detailtext"><b></b><span></span></td>
        //<td class="detailtext"><div class="orgbg"><a class="iframe cboxElement" href="ghao.php?hpid=142&amp;keid=1220114&amp;date1=2014-12-15" title="北京市预约挂号统一平台"><p>15</p><span>约满</span></a></div></td>
        //<td class="detailtext"><div class="greenbg"><a class="iframe cboxElement" href="ghao.php?hpid=142&amp;keid=1220114&amp;date1=2014-12-16" title="北京市预约挂号统一平台"><p>16</p><span>预约</span></a></div></td>
        gen_num++;
        if ((i>=myDate.getDate()&&month-1==myDate.getMonth()&&year==myDate.getFullYear())||(month-1>myDate.getMonth()&&year>=myDate.getFullYear())||(year>myDate.getFullYear()))
        {
            genstart=true;
            var newelement='<td class="detailtext">';
            //$("#calendar").append('<td class="detailtext">');

            var Reservation_Time=myDate.getFullYear()+'-'+(month)+'-'+i;
            var Duty_Time=new Date(Date.parse((year+'-'+(month)+'-'+i).replace(/\-/g,"/"))).getDay();
            if (Duty_Time==0)Duty_Time=7;
            Find_Doctor_By_Condition_Free(hospital_id,department_id,Duty_Time+'1',Reservation_Time,'#day'+i);
            Find_Doctor_By_Condition_Free(hospital_id,department_id,Duty_Time+'2',Reservation_Time,'#day'+i);
            newelement+='<div class="orgbg" id=\"day'+i+'\"><a class="iframe cboxElement" href="javascript:void(0)" onclick=""';
            newelement+='><p>'+i+'</p><span>约满</span></a></div></td>';
            /*if (Find_Doctor_By_Condition_Free(hospital_id,department_id,Duty_Time+'1',Reservation_Time)||Find_Doctor_By_Condition_Free(hospital_id,department_id,Duty_Time+'2',Reservation_Time))
            {
                newelement+='<div class="greenbg" id=\"day'+i+'\"><a class="iframe cboxElement" href="javascript:void(0)" onclick="';
                newelement+='showdoctor('+hospital_id+','+department_id+',\"'+Reservation_Time+'\")';
                newelement+='"><p>'+i+'</p><span>预约</span></a></div></td>';
                //$("#calendar").append('<div class="greenbg"><a class="iframe cboxElement" href="javascript:void(0)" onclick="');
                //$("#calendar").append('showdoctor('+hospital_id+','+department_id+',\"'+Reservation_Time+'\")');
                //$("#calendar").append('"><p>'+i+'</p><span>预约</span></a></div></td>');
            }else
            {
                //newelement+='<div class="orgbg">';
                newelement+='<div class="orgbg" id=\"day'+i+'\"><a class="iframe cboxElement" href="javascript:void(0)" onclick=""';
                newelement+='><p>'+i+'</p><span>约满</span></a></div></td>';
                //$("#calendar").append('<div class="orgbg">');
                //$("#calendar").append('<div class="greenbg"><a class="iframe cboxElement" href="javascript:void(0)"');
                //$("#calendar").append('><p>'+i+'</p><span>约满</span></a></div></td>');
            }*/
            newelement+='</td>';
            $("#calendar").append(newelement);
        }
        else {
            $("#calendar").append('<td class="detailtext"><b>'+i+'</b><span></span></td>');
        }
        if (gen_num%7==0&&i!=daynum)
        {
            $("#calendar").append("</tr><tr>");
        }
    }

    while (gen_num%7!=0)
    {
        gen_num++;
        $("#calendar").append('<td class="detailtext"><b></b><span></span></td>');
    }
}

function showdoctor(Hospital_ID,Depart_ID,Reservation_Time)
{
    var data=doctor[Hospital_ID.toString()+Depart_ID.toString()+Reservation_Time.toString()];
    var Duty_Time=new Date(Date.parse((Reservation_Time).replace(/\-/g,"/"))).getDay();
    if (Duty_Time==0)Duty_Time=7;
    //$("doctorcontent").append('<tbody><tr><td class="tdtitle">医生</td><td class="tdtitle">操作</td></tr><tr>');
    $.each(data,function(idx,item){
        var newelement='<tr><td>' +item.Doctor_Name+'</td><td>上午</td><td><a class=\"doctororder\" href="javascript:void(0)" ';
        newelement+='onclick=\"initHbox('+item.Doctor_ID+','+User_ID+',\''+Reservation_Time+'\','+(Duty_Time+'1')+')\">';
        newelement+='预约挂号</a></td></tr>';
        $("#doctortbody").append(newelement);
        var newelement='<tr><td>' +item.Doctor_Name+'</td><td>上午</td><td><a class=\"doctororder\" href="javascript:void(0)" ';
        newelement+='onclick=\"initHbox('+item.Doctor_ID+','+User_ID+',\''+Reservation_Time+'\','+(Duty_Time+'2')+')\">';
        newelement+='预约挂号</a></td></tr>';
        $("#doctortbody").append(newelement);
    });

    $(".doctororder").hDialog({width: 500,height: 350});
    $("#cboxOverlay").css({"display":"block","opacity":"0.9"});
    $("#colorbox").css({"display":"block"});
}

function boxclose()
{
    $("#cboxOverlay").css({"display":"none","opacity":"1"});
    $("#colorbox").css({"display":"none"});
    $("#doctorcontent tbody").empty();
}

function Reservation(Doctor_ID,User_ID,Reservation_Time,DutyTime,Reseration_Symptom)
{
    encrypttime=getEncryptTime();
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Reservation",//要访问的后台地址
        data: {
            url:'Reservation',
            encrypttime:encrypttime,
            Doctor_ID:Doctor_ID,
            User_ID:User_ID,
            Reservation_Time:Reservation_Time,
            Duty_Time:DutyTime,
            Reseration_Symptom:Reseration_Symptom
        },//要发送的数据
        //complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            if (msg.msg==0)
            {
                alert("预约成功！");
                $(".doctororder").hDialog('close',{box:'#HBox'});
            }else {
                alert("预约失败！");
            }
        }
    });
}

function initHbox(Doctor_ID,User_ID,Reservation_Time,DutyTime)
{
    $('.submitBtn').click(function() {
        var Reseration_Symptom=$(".Reseration_Symptom").val();
        Reservation(Doctor_ID,User_ID,Reservation_Time,DutyTime,Reseration_Symptom);
    });
}