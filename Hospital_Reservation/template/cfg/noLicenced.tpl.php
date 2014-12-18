<?php
include header_inc();
?>

<html>
<body>
 <div>
                    	<div><h5 class="title102"><em>授权信息</em> <span ></span></h5></div>
                        <div class="box102 p20">
                            <p style="color: red;font-size:16px;">系统还未被授权。认证码如下，请发给供应商进行授权。</p>
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
                            	<tbody>
                                	<tr><th width="10%">认证码</th>
                                		<td><?php echo $licenceinfo;?></td>
       								</tr>
                                </tbody>
                            </table>
                        <br />
                        <form action="licenceinfo.php" method="post" enctype="multipart/form-data" target="hidden_frame">
						<input name="src" type="file" />
						<input class="neibu" type="submit" name="submit" value="上传授权文件"> <input class="neibu" type="reset" value="重新选择">
					    </form>                            
                        </div>
                        </div> 
                        
 </body>
 </html>