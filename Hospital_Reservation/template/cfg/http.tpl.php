<?php
/**
 * http.tpl.php-.
 * @author Liu Moyao
 *
 * @copyright Copyright (c) 2013, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2013-12-18,created by Liu Moyao
 */
require header_inc();
 ?>
 
<script type="text/javascript">

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

function checkPorts()
{
	var ports=$('#Ports').val();
	ports=ports.trim();
	var portArray=ports.split(' ');
	for(var port in portArray){
		if(!checkPort(portArray[port]+"")){
			alert ('请以正确的格式输入');
			return false;
		}
	}
	return true;
}
function checkNull(){
	var ports = $('#Ports').val();
	if(ports == null || ports ==''){
		alert('服务端口不能为空');
		$('#Ports').focus();
		return false;
	}
	return true

}
//点击保存按钮
function savePorts() {
	if(checkNull()){
		$.ajax({
	        url : 'http.php?cmd=save',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	Ports:$("#Ports").val()
		    },
	        success : function(data) {
				if(data.search(/OK/)!=-1) {
	        		artDialog({content:'保存成功！', style:'succeed'}, function(){
	        			window.location.href="http.php";
					});

	        	} else {
	        		artDialog({content:"服务器出错，保存失败，请重试！", style:'error'}, function(){
	        			window.location.href="http.php";
					});
	        	}
	        	
	        }
   		});
	}


}

function resetPorts(){
	document.getElementById('Ports').value="";
	document.getElementById('Ports').focus();
}
</script>

 <h5 class="title102"><em>三层关联配置</em></h5>
          <div class="box102 p20">
          <form action="<?php echo WEB_ROOT?>cfg/http.php?cmd=save" method="post">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
             	<tbody>
                	<tr>
                    	<th width="15%">
                        	<font color="red">*</font> Web服务器端口：
                        </th>
                        <td>  
                        	<input type="text" id="Ports" value="<?php echo $portNum?>" name="Ports" onchange="checkPorts();" style="width: 300px;"/>
                        	<span style="color:red;">请输入Web服务器服务端口，以空格分隔</span>
                        </td>
                    </tr>  
                    <tr>
                        <td colspan="2"><input type="button" class="neibu" name="sbtPorts" value="保存" onClick="savePorts();"/>
                        <input class="neibu" type="button" name="rstPorts" value="重新填写" onClick="resetPorts();" /></td>
                    </tr>            
             </table>
             </form>
          </div>
         
