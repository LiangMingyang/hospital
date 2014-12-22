/**
 * Created by Yip on 2014/12/22.
 */
$(document).ready(function(){
    Get_Province_Info();
});
function Get_Province_Info()
{
    var encrypttime=getEncryptTime();
    //获取所有省份信息
    $.ajax({
        type: "post",//使用post方法访问后台
        dataType: "json",//返回json格式的数据
        url:'php/TransferStation.php',
        //url: "http://hospital.wannakissyou.com/Find_Hospital_By_Condition",//要访问的后台地址
        data:{
            url:'Get_Province_Info',
            encrypttime:encrypttime
        },//要发送的数据
        // complete :function(){$("#load").hide();},//AJAX请求完成时隐藏loading提示
        success: function(msg) {//msg为返回的数据，在这里做数据绑定
            if (msg.msg!=0)return;
            var data = msg.content;
            $.each(data,function(idx,item){
                var newelement='<li>';
                newelement+='<strong><a href="javascript:void(0)" onclick="SelectProvince('+item.Province_ID+',\''+item.Province_Name+'\''+')">'+ item.Province_Name +'</a></strong>';
                newelement+='</li>';
                $(" .province_list .content ul").append(newelement);
            });
            $("#provincebtn").hDialog({box:"#province_list",width: 500,height: 350});
        }
    });
}

function SelectProvince(Province_ID,Province_Name)
{
    $("#provincebtn").hDialog('close',{box:'#province_list'});
    /*document.cookie="Province_ID="+Province_ID;
    document.cookie="Province_Name="+Province_Name;*/
    setCookie("Province_ID",Province_ID.toString(),365);
    setCookie("Province_Name",Province_Name,365);
    location.reload(true);
}

function setCookie(c_name,value,expiredays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}