<?php
/**
 * netCard.tpl.php-.
 * @author Liu Moyao
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2014-1-3,created by Liu Moyao
 */
include header_inc();
 ?>
<script>
function ipaddr_check(addr)
	{
	 var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])(\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])){3}$/;
	 if(addr.match(reg)){
	     return true;
	 }
	 else{
	     return false;
	 }
	}
function getNetcards(){
	var i;
	var arrayNetcard =  {};
	var table =document.getElementById("netcfg");
	var rows = table.rows.length;
	for(i=0;i<rows;i++){
		var key = "#netCardFunc".concat(i);
		arrayNetcard[i] = $(key).val();
	}
	return arrayNetcard;
}
function saveNetcards_admin(){
	var address=$('#address').val();
	var netmask=$('#netmask').val();
    var gateway=$('#gateway').val();
    var broadcast=$('#broadcast').val();
    var network=$('#network').val();
    //alert(address);
	if(!(ipaddr_check(address)&&ipaddr_check(netmask)&&ipaddr_check(gateway)&&ipaddr_check(broadcast)&&ipaddr_check(network))){
		artDialog({content:"输入内容不符合IP格式！", style:'error'}, function(){
					});
		return;
	}
    $.ajax({
    	url: 'netCard.php?cmd=set',
		//url: 'setnetinfo.php',
    	type: 'POST',
    	datatype: 'text',
    	data:{
    		address:address,
			netmask:netmask,
    		gateway:gateway,
   			broadcast:broadcast,
    		network:network
    	},
    	success:function(data){
				//alert(data);
    		if(data=='OK'){
    			artDialog({content:"配置成功！", style:'succeed'}, function(){
					});
    		}
			else if(data=='CONFLICT'){
                artDialog({content:"接口IP冲突，请重新选择接口IP！", style:'error'}, function(){
					});
			}
    		else{
    			artDialog({content:"配置失败！失败信息:"+data, style:'error'}, function(){
					});
    		}
    	},
    	error:function(data){
    		artDialog({content:"与服务器交互出现错误，错误信息:"+data, style:'error'}, function(){
					});
    	}
    	
    });
	
	
}
function saveNetcards(){
	var netcardList = getNetcards();
	if(netcardList){
		$.ajax({
	        url : 'netCard.php?cmd=save',
	        type : 'POST',
	        dataType : 'text',
	        data:{
				netcardList:netcardList
		    },
	        success : function(data) {
			    if(data=='OK'){
	        		artDialog({content:"保存成功！", style:'succeed'}, function(){
					});

	        	}
		        else if(data == 'ERROR') {
	        		artDialog({content:"服务器出错，保存失败，请重试！", style:'error'}, function(){
					});

	        	}
				else{
	        		artDialog({content:'失败！失败信息：'+data, style:'error'}, function(){
					});
		        }
	        	
	        },
	        error:function(data){
	        	artDialog({content:'与服务器交互出现错误，错误信息：'+data, style:'error'}, function(){
					});
	        }
	        
   		});
	}
}
</script>
<body>
	<div>
		<div><h5 class="title102"><em>监控口配置</em> <span ></span></h5></div>
		<div class="box102 p20">
        	<table id="netcfg" border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
            		<?php if($ethAll == NULL) {
            		for($i=1;$i<$netCardCount;$i++){?>
            			<tr>
            				<th><?php echo "eth".$i?></th>
            				<td>
            					<select name=<?php echo "netCardFunc".$i ?> id=<?php echo "netCardFunc".$i ?> style="width: 200px;">
                				<option value="1">数据库审计</option>
								<option value="2">http数据包抓取</option>
                			</select>
            				</td>
            			</tr>
            		<?php }
            		}else{
            			for($i=1;$i<$netCardCount;$i++){
            			$row = $ethAll[$i-1]?>
            			<tr>
            				<th><?php echo "eth".$i?></th>
            				    <td>
            				        <select name=<?php echo "netCardFunc".$i ?> id=<?php echo "netCardFunc".$i ?> style="width: 200px;">
            				        <?php if($row['function']=="1"){?>
            				             <option value="1" selected="selected">数据库审计</option>
            				             <option value="2">http数据包抓取</option>
            				        <?php }else{?>
            				        	 <option value="1">数据库审计</option>
            				        	 <option value="2" selected="selected">http数据包抓取</option>
									<?php }?>            				        	 
            				         </select>
            				    </td>
            			</tr>
            		<?php }   				
            		}?>	
            		<tr>
                        <td colspan="2">
                        	<input type="button" class="neibu" name="sbtNetcards" value="保存" onClick="saveNetcards();"/>
                        </td>
                    </tr>    		
                </tbody>
            </table>                            
		</div> 
		<div><h5 class="title102"><em>管理口配置</em> <span ></span></h5></div>
		<div class="box102 p20">
        	<table id="netcfg_admin" border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
            		<tr>
						<th>接口IP</th>
						<td>
							<input type="text" id="address" name="address" value="<?php echo $netcard_info['address'];?>" style="width:900px"/>
						<td>	
					</tr>
					<tr>
						<th>子网掩码</th>
						<td>
							<input type="text" id="netmask" name="netmask" value="<?php echo $netcard_info['netmask'];?>" style="width:900px"/>
						<td>	
					</tr>
					<tr>
						<th>默认网关</th>
						<td>
							<input type="text" id="gateway" name="gateway" value="<?php echo $netcard_info['gateway'];?>" style="width:900px"/>
						<td>	
					</tr>
					<tr>
						<th>广播地址</th>
						<td>
							<input type="text" id="broadcast" name="broadcast" value="<?php echo $netcard_info['broadcast'];?>" style="width:900px"/>
						<td>	
					</tr>
					<tr>
						<th>网络号</th>
						<td>
							<input type="text" id="network" name="network" value="<?php echo $netcard_info['network'];?>" style="width:500px"/>
						<td>	
					</tr>
					<tr>
                        <td colspan="2">
                        	<input type="button" class="neibu" name="sbtNetcards_admin" value="保存" onClick="saveNetcards_admin();"/>
                        </td>
                    </tr>
                </tbody>
            </table>                            
		</div> 
	</div> 

</body>
</html>
