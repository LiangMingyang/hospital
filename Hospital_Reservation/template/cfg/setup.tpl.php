<?php
/**
 * server.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script>
 function check(obj){
var value = obj.value;
var name = obj.name;
$('#'+name).html("<img src='"+WEB_ROOT+"template/images/load.gif'/>");
$.get(WEB_ROOT+'cfg/setup.php?cmd=set&item='+name+'&value='+value,'',function(data){
	if(data == "OK")
		$('#'+name).html("<img src='"+WEB_ROOT+"template/images/ok.gif'/>");
	else
		$('#'+name).html("<img src='"+WEB_ROOT+"template/images/err.gif'/>");
});
	 }
 function checkStatus(){
	 $.get(WEB_ROOT+'cfg/backend.php?cmd=check&ps=auditor','',function(data){
		 if(data == 'RUNNING'){
			$('#status').html('<font color="green">运行中...</font>');
			$('.GONE').hide();
			$('.RUNNING').show();
			 }else{
				 $('#status').html('已停止');
				 $('.RUNNING').hide();
				 $('.GONE').show();
			}
		setTimeout('checkStatus()',10000);
		});
	 }
 function stop(){
$.get(WEB_ROOT+'cfg/backend.php?cmd=stop');
$('#status').html('正在关闭...');
	 }
 function restart(){
	 $.get(WEB_ROOT+'cfg/backend.php?cmd=stop');
	 <?php sleep(2); ?>
	 $.get(WEB_ROOT+'cfg/backend.php?cmd=start');
	 $('#status').html('正在重启...');
	 }
 function start(){
	 $.get(WEB_ROOT+'cfg/backend.php?cmd=start');
	 $('#status').html('正在启动...');
	 }
 $(function(){
	 setTimeout('checkStatus()',100);
	 });
 </script>
 <body>
 <div>
                    	<div><h5 class="title102"><em>基本配置</em> <span ></span></h5></div>
                        <div class="box102 p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
                            	<tbody>
                                	<tr><th>部署方式</th>
                                		<td>
                                			<input type="radio" name="<?php echo setup::DEPLOYMENT?>" value="1" <?php if($deployment) echo "checked";?> onclick="check(this)"> 旁路监听&nbsp;&nbsp;&nbsp;&nbsp;
       										<!-- 
       										<input type="radio" name="<?php echo setup::DEPLOYMENT?>" value="0"<?php if(!$deployment) echo "checked";?> onclick="check(this)"> 网关拦截&nbsp;&nbsp;&nbsp;&nbsp;
       										 --><span id="<?php echo setup::DEPLOYMENT?>"></span>				
       									</td>
       								</tr>
       								<!-- 
       								<tr><th>审计事件</th><td><input type="radio" name="<?php echo setup::LOG?>" value="0" <?php if(!$log) echo "checked";?> onclick="check(this)"> 全部记录&nbsp;&nbsp;&nbsp;&nbsp;
       														<input type="radio" name="<?php echo setup::LOG?>" value="1" <?php if($log) echo "checked";?> onclick="check(this)"> 只记录匹配规则的事件&nbsp;&nbsp;&nbsp;&nbsp;<span id="<?php echo setup::LOG?>"></span></td>
       								</tr>
       								 -->
       								<tr><th>报警方式</th><td><input type="radio" name="<?php echo setup::WARN?>" value="1" <?php if($warn) echo "checked";?> onclick="check(this)"> 开启&nbsp;&nbsp;&nbsp;&nbsp;
       														<input type="radio" name="<?php echo setup::WARN?>" value="0" <?php if(!$warn) echo "checked";?> onclick="check(this)"> 关闭&nbsp;&nbsp;&nbsp;&nbsp;<span id="<?php echo setup::WARN?>"></span></td>
       								</tr>
       								<tr>
       									<th>入侵检测</th><td><input type="radio" name="<?php echo setup::DETECT?>" value="1" <?php if($detect) echo "checked";?> onclick="check(this)"> 开启&nbsp;&nbsp;&nbsp;&nbsp;
       														<input type="radio" name="<?php echo setup::DETECT?>" value="0" <?php if(!$detect) echo "checked";?> onclick="check(this)"> 关闭&nbsp;&nbsp;&nbsp;&nbsp;<span id="<?php echo setup::DETECT?>"></span></td>
       								</tr>
       								<tr><th>后台程序</th><td><span id='status'></span>&nbsp;
       										<a href="javascript:void(0)" onclick="restart()" class="RUNNING neibu">重启</a>
       										<a href="javascript:void(0)" onclick="start()" class="GONE neibu">启动</a>
       										<a href="javascript:void(0)" onclick="stop()" class="RUNNING neibu">关闭</a></td>
       								</tr>
                                </tbody>
                            </table>                            
                        </div> 
                        </div> 
 </body>
 </html>
