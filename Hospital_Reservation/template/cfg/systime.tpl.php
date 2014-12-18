<?php
/**
 * systime.tpl.php-系统时间设置.
 * @author zhangxin
 *
 * @modification history
 * ---------------------
 * 2014-6-17,created by zhanxgin
 */
include header_inc();
?>
<script type="text/javascript">
function modifysystime(){
	$.ajax({
        url : 'systime.php?cmd=modify',
        type : 'POST',
        dataType : 'text',
        data:{
        	newDate:$("#nowDate").val(),
        	newTime:$("#nowTime").val()
	    },
        success : function(data) {
	        if(data == 'OK') {
        		artDialog({content:'设置成功！', style:'succeed'}, function(){
				});
        		window.location.href="systime.php";
        	} else {
        		artDialog({content:"服务器出错，设置失败，请重试！", style:'error'}, function(){
        			window.location.href="systime.php";
				});
        	}
        	
        }
		});
}
</script>


<html>
<body>
 <div>
                    	<div><h5 class="title102"><em>系统时间设置</em> <span ></span></h5></div>
                        <div class="box102 p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
                            	<tbody>
                                	<tr><th width="10%">系统时间</th>
       								    <td><input name="nowDate" id='nowDate' value='<?php echo date("Y-m-d");?>' class="Wdate" onClick="WdatePicker()" type="text">
       								    <input name="nowTime" id="nowTime" value='<?php echo date('H:i:s');?>' class="WTime" onClick="WdatePicker({dateFmt:'HH:mm:ss'})" type="text">
       								    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" class="neibu" onClick="modifysystime();">保存设置</a></td>
       								</tr>
                                </tbody>
                            </table>                           
                        </div>
                        </div> 
                        
 </body>
 </html>