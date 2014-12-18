<?php
/**
 * riskthreshold.tpl.php-.
 * @author zhangxin
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2014-6-19,created by zhangxin
 */
include header_inc();
 ?>
<script>
function saveThresinfo(){
		$.ajax({
	        url : 'riskthreshold.php?cmd=save',
	        type : 'POST',
	        dataType : 'text',
	        data:{
	        	highriskthres:$("#highriskthres").val(),
	        	midriskthres:$("#midriskthres").val(),
	        	lowriskthres:$("#lowriskthres").val()
		    },
	        success : function(data) {
	        		artDialog({content:'保存成功！', style:'succeed'}, function(){
					});	        	
	        }
   		});
	}
	/*added by gengjinkun
	 2014-08-05
	 */
function Check_Num(){
	
	    var num_source1=document.getElementById("lowriskthres");
		var num1 = num_source1.value;
		var num_source2=document.getElementById("midriskthres");
		var num2 = num_source2.value;
		var num_source3=document.getElementById("highriskthres");
		var num3 = num_source3.value;
		
		
		if(isNaN(num1)){
			alert("低风险阈值不是数字");
			return  false;
		}
		
		if(isNaN(num2)){
			alert("中风险阈值不是数字");
			return  false;
		}
		if(isNaN(num3)){
			alert("高风险阈值不是数字");
			return  false;
		}
        saveThresinfo();
		return true;
		
}
</script>
<body>
	<div>
		<div><h5 class="title102"><em>风险阈值配置</em> <span ></span></h5></div>
		<div class="box102 p20">
		    <p style="color: red;font-size:14px;">当风险事件的累计发生次数或发生频率超过此设定阈值时，表明信息系统出现了可能的潜在危害。</p>
        	<table id="val" border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
            		<tr>
            			<th width="10%">低风险阈值</th>
            			<td><input type="text" id="lowriskthres" name="lowriskthres" style="width:100px;" value="<?php echo $riskthreshold[0];?>" /></td>
            		</tr>
            		<tr>
            			<th width="10%">中风险阈值</th>
            			<td><input type="text" id="midriskthres" name="midriskthres" style="width:100px;" value="<?php echo $riskthreshold[1];?>" /></td>
            		</tr>
            		<tr>
            			<th width="10%">高风险阈值</th>
            			<td><input type="text" id="highriskthres" name="highriskthres" style="width:100px;" value="<?php echo $riskthreshold[2];?>" /></td>
            		</tr>
            		<tr>
                        <td colspan="2">
                        	<input type="button" class="neibu" name="threshold" value="保存" onClick="Check_Num();"/>
                        </td>
                    </tr>    		
                </tbody>
            </table>                            
		</div> 
	</div> 
</body>
</html>