<?php
/**
 * system.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-15,created by Xu Guozhi
 */
include header_inc();
 ?>
 <body>
 <h5 class="title102" style="position:relative; zoom:1;"><em>系统监控</em> <span><a href="#" class="on">运行状况</a> <a href="#">流量监控</a></span></h5>
    <div class="tabContent">
              <div class="itabContent">
              <iframe src="<?php echo WEB_ROOT?>monitor/computer.php" width="100%" height="100%" frameborder="no" border="0" scrolling="no" ></iframe>
              </div>
         <div class="itabContent" style="display:none">            
         	 
         </div>
     </div>
             <script type="text/javascript">
	function tab(nav,content,on,type)
{
	$(nav).children().bind(type,(function(){
		var $tab=$(this);
		var tab_index=$tab.prevAll().length;
		var $content = $(content).children();
		$(nav).children().removeClass(on);
		$tab.addClass(on);
		$content.hide();
		$content.eq(tab_index).show();
	}));
}
   tab(".title102 span",".tabContent","on","mouseover");
</script>
 </body>
 </html>