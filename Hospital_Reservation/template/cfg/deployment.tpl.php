<?php
/**
 * deployment.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Xu Guozhi
 */
include header_inc()
 ?>
 <body>
 <h5 class="title102"><em>部署方式</em></h5>
  <div class="box102 p20">
       		 <table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab3">
             	<tbody>
                	<tr>
                    	<td width="10%" class="td1">选择部署方式:</td>
       				<td><input type="radio" name="status" value="1">旁路监听&nbsp;&nbsp;
       				<input type="radio" name="status" value="2">网关拦截
       				</td>
       			</tr>
       			<tr>
       				<td colspan="2"><input type="submit" class="tijiao" value="保存"/>
       				</td>
       			</tr>
       		</tbody>
       		</table>
         </div>
</body>
</html>