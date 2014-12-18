<?php
/**
 * whitelistInfo.tpl.php-.
 * @author chenhuan
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2013-05 chenhuan
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
function addWhiteList() {
	var serviceId=$("#ServiceId").val();
	var iprange = $("#ipRangeSelector").val();
	var username=$("#userName").val();
	/*added by gengjinun*/
	
	if(check_danger(username)){
               artDialog({content:'输入含有危险字符或长度大于64，请不要包含|&;$%@,\'"<>()+', style:'alert'}, function(){});
					   return;
		}
	
	if(($.trim(serviceId).length==0)){
		artDialog({content:'服务器不能为空！请到[系统]-[数据库服务器配置]中进行配置！', style:'alert'}, function(){
			
		});
	}else if(($.trim(iprange).length==0)){
		artDialog({content:'IP范围不能为空！请到[审计策略配置]-[IP范围管理]中进行配置！', style:'alert'}, function(){
			
		});
	}else if(checkUserName()) {
		var enabled = $("input[name='white[Enabled]']:checked").val();
		$.ajax({
			url:"whitelistInfo.php?cmd=save",
			type:"POST",
			dataType:"text",
			data:{
				ServiceId:$("#ServiceId").val(),
				IPRange:$("#ipRangeSelector").val(),
				userName:$("#userName").val(),
				enabled:enabled,
				whitelistId:$("#whitelistIdHidden").val()
			},
			success:function(data) {
				if(data=="UPDATE_OK"){
					artDialog({content:'修改成功！', style:'succeed'}, function(){
						window.location.href="whitelist.php";
					});
				} else if(data=="SAVE_OK"){
					artDialog({content:'添加成功！', style:'succeed'}, function(){
						window.location.href="whitelist.php";
					});
				} else {
					artDialog({content:'服务器出错，保存失败，请重试！', style:'error'}, function(){
						
					});
				}
			}		
		});
	}
}


//验证host为localhost或者ip格式
function checkUserName() {
  	var userName = $("#userName").val();
  	if($.trim(userName).length>20){
  		$('#userName').removeClass();
  		$('#userName').addClass('inputError');
  		$('#userNameTip').html('登录名不能超过20个字符！');
  		$('#userName').focus();
  		return false;
  	}
  	$('#userName').addClass('inputRight');
  	$('#userNameTip').html('');
  	return true;
}

function cancel() {
	window.location.href="whitelist.php";
}

</script>

 <h5 class="title102"><em>入侵检测白名单</em></h5>
          <div class="box102 p20">
          <form action="" >
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                	<td width="10%" class="td1">
                        	数据库：</td>
                    <td>
                        <select name='white[ServiceId]' id='ServiceId' style="width: 250px;">
                        <?php 
                        if(strlen(trim($targetWhite['ServiceId']))>0){
                        foreach($Services as $service){
	                        if($targetWhite['ServiceId']==$service['ServiceId']) {
	                        	?>
	                        	<option value='<?php echo $service['ServiceId']?>' selected="selected"><?php echo $service['ServerName'].':'.$service['Name'].':'.$service['ServiceName'];?> </option>
	                        	<?php 
	                        }else {
	                        	?>
	                        	<option value='<?php echo $service['ServiceId']?>'><?php echo $service['ServerName'].':'.$service['Name'].':'.$service['ServiceName'];?> </option>
	                        	<?php 
	                        }
                        }
                        }else{
                        	foreach($Services as $service){
                        		?>
	                        	<option value='<?php echo $service['ServiceId']?>'><?php echo $service['ServerName'].':'.$service['Name'].':'.$service['ServiceName'];?> </option>
	                        	<?php 
                        	}
                        }
                        ?>
                        </select>
                    </td>
                	</tr>
                	<tr>
					<td class="td1">选择IP范围：</td>
					<td>
						<select id="ipRangeSelector" name="white[IPRange]" style="width: 250px;">
							<?php 
							if($targetWhite!=null){
							foreach ($ipRangeList as $ipRange) {
								if($targetWhite['IPRange']==$ipRange['IPRange']){
									?>
								<option value="<?php echo $ipRange['RangeID']?>" selected="selected"><?php echo $ipRange['RangeName']?></option>
								<?php
								}else{
								?>
								<option value="<?php echo $ipRange['RangeID']?>"><?php echo $ipRange['RangeName']?></option>
								<?php
								}
							}
							}else{
								foreach ($ipRangeList as $ipRange) {
									?>
								<option value="<?php echo $ipRange['RangeID']?>"><?php echo $ipRange['RangeName']?></option>
								<?php
								}
							}
							
							?>
						</select>
					</td>
				</tr>
                	<tr>
                    	<td class="td1">
                        	登录名：
                        </td>
                        <td>
                        	<input type="text" id="userName" value="<?php echo $targetWhite['UserName']?>" name="white[UserName]" style="width: 250px;" onblur="checkUserName();"/><span class="errorTip" id='userNameTip'></span>
                        </td>
                    </tr>
                    <tr>
                    	<td class="td1">
                        	是否开启：
                        </td>
                        <td>
                        	<?php 
                        	if($targetWhite!=null){
                        	if($targetWhite['Enabled']==1) {
                        	?>
                        	<input type="radio" name="white[Enabled]" value="1" checked="checked"/>是
                        	<input type="radio" name="white[Enabled]" value="0"/>否
                        	<?php
                        	} else {
                        	?>
                        	<input type="radio" name="white[Enabled]" value="1"/>是
                        	<input type="radio" name="white[Enabled]" value="0" checked="checked"/>否
                        	<?php
                        	}
                        	} else {
                        		?>
                        	<input type="radio" name="white[Enabled]" value="1" checked="checked"/>是
                        	<input type="radio" name="white[Enabled]" value="0"/>否
                        	<?php
                        	}
                        	?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="button" class="neibu" name="sbtServer" value="保存" onclick="addWhiteList();"/>
                        <input type="button" class="neibu" name="rstServer" value="取消" onclick="cancel();"/></td>
                    </tr>
                </tbody>
             </table>
             <input type="hidden" name="white[WhitelistId]" id="whitelistIdHidden" value="<?php echo $targetWhite['WhitelistId']?>"/> 
             </form>
          </div>