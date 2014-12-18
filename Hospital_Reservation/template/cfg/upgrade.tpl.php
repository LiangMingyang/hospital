<?php
/**
 * upgrade.tpl.php-系统升级界面.
 * @author zhangxin
 *
 * @modification history
 * ---------------------
 * 2014-6-17,created by zhanxgin
 */
include header_inc();
?>

<html>
<body>
 <div>
        <div><h5 class="title102"><em>系统升级</em> <span ></span></h5></div>
        <div class="box102 p20">
		<div class="s_top"><a href="#"><img src="<?php echo IMAGE_PATH ?>logo.png" alt="" /></a></div>

		<div>
		    <p style="color: green;font-size:14px;">本系统当前版本信息如下。</p>
        	<table id="val" border="0" cellspacing="0" cellpadding="0" width="50%" class="tab6">
            	<tbody>
            	    <tr align="center">
            	        <th>类型</th>
            	        <th>版本</th>
            	        <th>升级日期</th>
            	    </tr>
            		<tr align="center">
            			<td>WEB控制台</td>
            			<td><?php echo $web[0];?></td>
            			<td><?php echo $web[1];?></td>
            		</tr>
            		<tr align="center">
            			<td>审计引擎</td>
            			<td><?php echo $eng[0];?></td>
            			<td><?php echo $eng[1];?></td>
            		</tr>
            		<tr align="center">
            			<td>内置规则库</td>
            			<td><?php echo $inrule[0];?></td>
            			<td><?php echo $inrule[1];?></td>
            		</tr>
            		<tr align="center">
            			<td>知识库</td>
            			<td><?php echo $kb[0];?></td>
            			<td><?php echo $kb[1];?></td>
            		</tr>   		
                </tbody>
            </table>                            
		</div> 
  		<div class="s_tip"style="margin-top:10px">
  		
					<form action="upgrade.php" method="post" enctype="multipart/form-data" target="_self">
						<p style="color: blue">请选择您的升级包：</p>
						<input name="src" type="file" />
						<br />
						<br />
						<div>
						<input class="tijiao" type="submit" name="submit" value="升级"><input class="repire" type="reset" value="重新选择">
					    </div>
					</form>
		  </div>                   
        </div>
     </div> 
                        
 </body>
 </html>