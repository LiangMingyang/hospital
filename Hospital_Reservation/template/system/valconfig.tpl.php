<?php
/**
 * valconfig.tpl.php-.
 * @author zhangxin
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2014-1-3,created by zhangxin
 */
include header_inc();
 ?>
<script>
function saveValinfo(){
		$.ajax({
	        url : 'valconfig.php?cmd=save',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	valOrNot:$("#valvalue").val()
		    },
	        success : function(data) {
	        		artDialog({content:'保存成功！', style:'succeed'}, function(){
					});	        	
	        }
   		});
	}
</script>
<body>
	<div>
		<div><h5 class="title102"><em>验证码配置</em> <span ></span></h5></div>
		<div class="box102 p20">
        	<table id="val" border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
            		<tr>
            			<th><?php echo "是否显示验证码"?></th>
            			<td>
            			<?php 
            			   $CfgBaseInfo=new baseinfo();
            			   $statuses=$CfgBaseInfo->get_status_by_id(1);
            			   $status=$statuses[0]['Status'];
            			?>
            				<select name=valvalue id=valvalue style="width: 200px;">
                			   <option value="1" <?php if($status==1) echo selected?>>是</option>
							   <option value="0" <?php if($status==0) echo selected?>>否</option>
                		    </select>
            			</td>
            		</tr>
            		<tr>
                        <td colspan="2">
                        	<input type="button" class="neibu" name="val" value="保存" onClick="saveValinfo();"/>
                        </td>
                    </tr>    		
                </tbody>
            </table>                            
		</div> 
	</div> 
</body>
</html>
