<?php
include header_inc();
?>

<html>
<body>
 <div>
                    	<div><h5 class="title102"><em>授权信息</em> <span ></span></h5></div>
                        <div class="box102 p20">
                        	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
                            	<tbody>
                                	<tr><th width="10%">是否授权</th>
                                		<td>已授权</td>
       								</tr>
       								<tr><th>授权单位</th>
       								    <td><?php echo $info[2];?></td>
       								</tr>
       								<tr><th>有效期限</th>
       								    <td><?php echo $info[1];?></td>
       								</tr>
                                </tbody>
                            </table>                            
                        </div> 
                        </div> 
 </body>
 </html>