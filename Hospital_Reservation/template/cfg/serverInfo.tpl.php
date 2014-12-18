<?php
/**
 * serverInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Xu Guozhi
 */
require header_inc();
 ?>
 
  <script type="text/javascript">
  /*added by gengjinkun 2014-08-19*/
 function check_danger(str){
	var reg = /[|&;$%@,\'"<>()+]/;
	var res=reg.test(str);
	if(res){
			return true;
		  }
	else if(str.length>64){
			return true;
		}
	else{
			return false;
		}
	
}
  function checkAll2(){
		flag = $("#checkAll").attr("checked");
		if(flag == 'checked')
			$("input[name='rptType']").attr("checked",flag);
		else
			$("input[name='rptType']").removeAttr("checked");
	}
	
	function uncheckAll(obj){
		flag = obj.checked;
		if(flag){
			types = document.getElementsByName("rptType");
			for(var i = 0; i < types.length; ++i){
				if(!types[i].checked)
					return;
			}
			document.getElementById("checkAll").checked = true;
		}else
			document.getElementById("checkAll").checked = false;

	}

function checkOne(c,p)
{
	var checkId="rptType";
	var portId="port";
	checkId=checkId+c;
	portId=portId+c;
	document.getElementById(checkId).checked = true;
	document.getElementsByName(portId)[0].value=p; //赋值赋不了

	return;
}

function iponly(address)
{
	var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g 
	if(re.test(address)) 
	{ 
		if( RegExp.$1 <256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) return true; 
	} 
	alert("IP地址输入不正确");
	return false; 
}

function checkNumber(portNumber)
{
	var s=portNumber
	if(/^(\+|-)?\d+$/.test(s))
	{
		return true;
	}
	else
	{
		return false;
	}
		
}
function checkPort(portNumber)
{
	if(!checkNumber(portNumber))
	{
		return false; 
	}
	if(portNumber<65536 && portNumber>0)
	{
		
		return true;
	}
		
	return false;
}

function checkNameLength()
{
	var ServerName=$('#ServerName').val();
	if(ServerName.length > 20){
		alert('服务器名不能超过20个字符！');
		$('#ServerName').val('');
		$('#ServerName').focus();
		return false;
	}
	return true;
}

function checkRemarkLength()
{
	var ServerName=$('#Remarks').val();
	if(ServerName.length > 20){
		alert('备注不能超过20个字符！');
		$('#Remarks').val('');
		$('#Remarks').focus();
		return false;
	}
	return true;
}

function checkPortExisted()
{
	
}

//$('.myPort').click(function(){
//	var i =$(this).index();
//	var port = $(this).text();
//	var flag = true;
//	$("myPort").each(function(){
//	    var j = $(this).index();
//	    var tmpPort = $(this).text();
//	    if((i != j) && (port==tmpPort)) {
//			flag = false;
//		}
//	});
//	if(flag) {
//		alert("OK");
//	} else {
//		alert("已存在相同的端口号！");
//	}
//});

function checkPortLength(obj,i)
{
//	var i = obj.index;
	var port = obj.value;
	var flag = true;
	$(".myPort").each(function(index,elem){
//	    var j = $(this).index();
//	    var tmpPort = $(this).val();
		var j = index;
	    var tmpPort = elem.value;
//	    if(i!=j) {
//			if(port==tmpPort){
//				flag=false;
//			}
//		}
	});
	if(flag) {
		var portStr=obj.value;
		if(parseInt(portStr) < 0 || parseInt(portStr) > 65535) {
			alert('请输入正确的端口号！');
			obj.value = "";
			obj.focus();
			return false;
		}
		return true;
	} else {
		alert("已存在相同的端口号！");
		obj.value = "";
		obj.focus();
		return false;
	}
	return true;
}

function serverSave()
{
	var ServerName=$('#ServerName').val();
	if(ServerName== null || ServerName==''){
		alert('服务器名不能为空');
		$('#ServerName').focus();
		return false;
	}
	var ServerIp = $('#ServerIp').val();
	if(!iponly(ServerIp)){
		$('#ServerIp').focus();
		return false;
	}
	/*
	var checked;
	var port="port";
	var flag=true;
	$('input:checkbox:checked').each(function(){
		checked+=","+$(this).val();
		var temp=$(this).val();
		if(temp!="on"){
		var portId=port+temp;
		var portNumber=document.getElementsByName(portId)[0].value;
		if(!checkPort(portNumber))
		{
			flag=false;
			document.getElementsByName(portId)[0].select();
		}
		}
				
	}
	);

	$('#checksId').val(checked);
	
	if(checked== null || checked==","){
		alert('协议类型不能为空');
		return false;
	}

	if(!flag)
	{
		alert("端口号输入不正确");
	}
	*/
	var servicesNum=$('.service').length;
	if(servicesNum==null || servicesNum=="")
	{
		alert("服务名不能为空");
		$('#ServerIp').focus();
		return false;
	}

	var services={};
	for(var i = 0; i < $('.service').length;++i){
		var service = {};
		var ServiceId = $('.service input[type=hidden]').eq(i).val();
		var ServiceName = $('.service input[type=text]').eq(i*2).val();
		var Protocol = $('.service select').eq(i).val();
		var ServerPort = $('.service input[type=text]').eq(i*2+1).val();
		service['ServiceId']=ServiceId;
		service['ServiceName']=ServiceName;
		service['Protocol']=Protocol;
		service['ServerPort']=ServerPort;
		services[i]=service;


		if(Protocol==null || ServerPort=="")
		{
			alert("请选择协议");
			return false;
		}
		
		if(ServiceName==null || ServiceName=="")
		{
			alert("服务名不能为空");
			return false;
		} else if(ServiceName.length > 20) {
			alert("服务名不能超过20个字符！");
			return false;
		}
		if(ServerPort==null || ServerPort=="")
		{
			alert("端口号不能为空");
			return false;
		}
		
//		var j=i;
//		for(j=0; j<i; j++)
//		{
//			if(services[j].ServiceName==services[i].ServiceName && 
//					services[j].Protocol==services[i].Protocol)
//			{
//				alert("同一服务器和同一协议类型中不能有重复的服务名");
//				return false;
//			}
//			if(services[j].ServerPort==services[i].ServerPort){
//				alert("不能有相同的端口号！");
//				return false;
//			}
//		}
		}
	$.toJSON(services);
	$('#servicesInfoId').val($.toJSON(services));
	return true;
		
}
//点击保存按钮
function saveServer() {
	if(serverSave()) {
	    var check1=$("#ServerName").val();
	    var check2=$("#Remarks").val();
		/*added by gengjinun*/
		if(check_danger(check1)||check_danger(check2)){
              artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
			  return;
		}
	    servicesInfo:$("#servicesInfoId").val()
		$.ajax({
	        url : 'serverInfo.php?cmd=save',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	ServerID:$("#ServerID").val(),
	        	ServerName:$("#ServerName").val(),
	        	ServerIP:$("#ServerIp").val(),
	        	Remarks:$("#Remarks").val(),
	        	servicesInfo:$("#servicesInfoId").val()
		    },
	        success : function(data) {
		        if(data == 'IP_EXIST') {
	        		artDialog({content:'IP为'+$("#ServerIp").val()+'的服务器已存在！', style:'error'}, function(){
					});

	        	} else if(data == 'SAVE_OK') {
	        		artDialog({content:'保存成功！', style:'succeed'}, function(){
	        			window.location.href="servers.php";
					});

	        	} else if(data == 'OK') {
	        		artDialog({content:'保存成功！', style:'succeed'}, function(){
	        			window.location.href="servers.php";
					});

	        	}/*Add By Yip Date:2014.8.5*/
	        	 else if (data=='ServerName_ILLEGAL'){
	        		artDialog({content:'服务器名称含有非法字符，请重新输入！', style:'error'}, function(){
					});

	        	}
	        	/*****************************/
	        	 else {
	        		artDialog({content:"服务器出错，保存失败，请重试！", style:'error'}, function(){
	        			window.location.href="servers.php";
					});
	        	}
	        	
	        }
   		});
	}
}
function addRow(){
	var html ="<tr class='service'><td><input type='text' value='数据库名'></td><td><select onchange='idx=$(\".service select\").index(this);setPort(idx)'>";
	html+='<option value="">选择协议</option>';
	<?php if($protocols){foreach($protocols as $protocol){?>
	html+="<option value='<?php echo $protocol['Protocol']?>' <?php if($protocol['Protocol']==$service['Protocol'])echo "selected"?>><?php echo $protocol['Description']?></option>";
		<?php }}?>
	html+="</select></td>";
	html+="<td><input type='text' class='myPort' onchange=\"idx=$('.myPort').index(this);checkPortLength(this,idx);\"></td><td><a href='javascript:void(0)' onclick='idx=$(\".service a\").index(this);deleteRow(idx)' class='neibu'>删除</a><input type='hidden' name='serviceIdHidden' class='serviceIdHidden' value='#'/></td></tr>";
	$('#last').before(html);
}
function deleteRow(idx){
	var targetId = $('.serviceIdHidden').eq(idx).val();
	if(targetId=='#') {
		$('.service').eq(idx).remove();
	} else {
		//delete service in database
		$.ajax({
	        url : 'serverInfo.php?cmd=delete',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	serviceId:targetId
		    },
	        success : function(data) {
	        	if(data == 'ERROR') {
	        		artDialog({content:'服务器删除失败，请重试！', style:'error'}, function(){
					});
	        	} else {
	        		$('.service').eq(idx).remove();
		        }
	        }
   		});	
	}
}
var portMap={};
portMap['其它']=0;
portMap['Oracle']=1521;
portMap['IBM DB2']=50000;
portMap['Microsoft SQL Server']=1433;
portMap['Sybase']=5000;
//portMap['Informix']=1;
portMap['MySQL']=3306;
//portMap['FTP']=21;
//portMap['TELNET']=23;
//portMap['SSH']=22;
//portMap['RSH']=514;
//portMap['远程登录(RLOGIN)']=513;

function setPort(idx){
	var protocol = $('.service select').eq(idx).find("option:selected").text();
	$('.service input[type=text]').eq(idx*2+1).val(portMap[protocol]);
}
</script>

 <h5 class="title102"><em>服务器配置</em></h5>
          <div class="box102 p20">
          <form action="<?php echo WEB_ROOT?>cfg/serverInfo.php?cmd=save" method="post" onsubmit="return serverSave()">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
             	<tbody>
                	<tr>
                    	<th width="10%">
                        	<font color="red">*</font> 服务器名：
                        </th>
                        <td>
                        	<input type="text" id="ServerName" value="<?php echo $server['ServerName']?>" name="Server[ServerName]" onchange="checkNameLength();" style="width: 300px;"/>
                        	<span style="color:red;">限定20字符以内</span>
                        </td>
                    </tr>
                    <tr>
                   	 	<th width="10%">
                        	<font color="red">*</font> 服务器IP：
                        </th>
                        <td>
                        	<input type="text" id="ServerIp" value="<?php echo isset($server['ServerIP'])?($server['ServerIP']): ""?>" name="Server[ServerIP]" style="width: 300px;"/>
                        </td>
                    </tr>
                    <tr>
                    	<th width="10%">
                        	备注：
                        </th>
                        <td>
                        	<input type="text" id="Remarks" value="<?php echo $server['Remarks']?>" name="Server[Remarks]" onchange="checkRemarkLength();" style="width: 300px;"/>
                        	<span style="color:red;">限定20字符以内</span>
                        </td>
                    </tr>
                    
                    <tr>
                    	<th colspan="4">
                        	<font color="red">*</font> 数据库：
                        </th>
                    </tr>
                    <tr>
                    	<td colspan="4"><table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab9">
                    	<tbody>
                    	<tr><th>服务名</th><th>协议类型</th><th>端口号</th><th></th></tr>
                    <?php if($services){
                        foreach($services as $service){
                    ?>
                    <tr class="service"><td><input type="text" value="<?php echo $service['ServiceName']?>"></td>
                    <td><select name="proto">
                    	<?php if($protocols){foreach($protocols as $protocol){?>
                    		<option value="<?php echo $protocol['Protocol']?>" <?php if($protocol['Protocol']==$service['Protocol'])echo "selected"?>><?php echo $protocol['Description']?></option>
                    		<?php }}?>
                    </select>
                    <td><input type="text" value="<?php echo $service['ServerPort']?>" class="myPort" onchange="idx=$('.myPort').index(this);checkPortLength(this,idx);"></td>
                    <td><a href='javascript:void(0)' onclick='idx=$(".service a").index(this);deleteRow(idx)' class='neibu'>删除</a>
                    <input type="hidden" name="serviceIdHidden" class="serviceIdHidden" value="<?php echo $service['ServiceId']?>"/>
                    </td>
                    </tr>
                    <?php }}?>
					<tr id="last"><td colspan="4" align="right"><a href="javascript:void(0)" onclick="addRow()" class="neibu">添加</a></td></tr> 
                   </tbody></table></td></tr>
                    <tr>
                        <td colspan="2"><input type="button" class="neibu" name="sbtServer" value="保存" onClick="saveServer();"/>
                        <input type="reset" class="neibu" name="rstServer" value="重新填写"/></td>
                    </tr>
                </tbody>
             </table>
             <input type="hidden" name='servicesInfo' id='servicesInfoId'/>
             <input type="hidden" id="ServerID" name="Server[ServerID]" value="<?php echo $server['ServerID']?>"/>
             </form>
          </div>
         