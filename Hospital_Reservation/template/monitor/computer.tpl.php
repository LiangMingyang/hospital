<?php
/**
 * computer.tpl.php-系统运行状态监控.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-13,created by Xu Guozhi
 */
include header_inc();
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>monitor.js"></script>
 <body onload="getSysInfo()">
 
<div>
<div class="box102">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
		<tr>
           <td><div id='cpu'></div></td>
       	</tr>
	</table>
</div>
</div>
<div class="bottom">
	<h5 class="title101"><em>内存使用</em></h5>
	<div class="box102 p20">
	<table>
		<tr><td><div id="memory"></div></td></tr>
	</table>
    </div>
</div>
<div class="bottom">
	<h5 class="title101"><em>磁盘空间</em></h5>
	<div class="box102 p20">
		<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tab2">
       		<tr>
           <?php for($i = 0; $i < $diskCount; ++$i){
               echo "<td><div id='disk$i'></div></td>";
               if(($i+1)%2 == 0){
                   echo "</tr><tr>";
               }
           }?>
       		</tr>
       	</table>
	</div>
</div>
<script type="text/javascript">
swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "cpu", "450", "200", "9.0.0", "expressInstall.swf",{"data-file":"<?php echo WEB_ROOT?>line.json"}, {"wmode":"opaque"} );

swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "memory", "450", "200", "9.0.0", "expressInstall.swf", {"data-file":"<?php echo WEB_ROOT?>line.json"},{"wmode":"opaque"} );
<?php for($i = 0; $i < $diskCount; ++$i){?>
swfobject.embedSWF("<?php echo WEB_ROOT?>open-flash-chart.swf", "<?php echo "disk$i"?>", "450", "200", "9.0.0", "expressInstall.swf",{"data-file":"<?php echo WEB_ROOT?>pie.json"}, {"wmode":"transparent"} );
<?php }?>
</script>
          
 </body>
 </html>