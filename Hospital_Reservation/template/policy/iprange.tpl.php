<?php
/**
 * iprange列表管理
 * whiteList.tpl.php-.
 * @author Chenhuan
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-14,created by Chenhuan
 */
include header_inc();
//include policy_inc();
//function ip2int($ip){
//    list($ip1,$ip2,$ip3,$ip4)=explode(".",$ip);
//    return ($ip1<<24)|($ip2<<16)|($ip3<<8)|($ip4);
//}
function int2ip($int){
	return (($int/16777216)%256).".".(($int/65536)%256).".".(($int/256)%256).".".($int%256);
}
 ?>
 <script type="text/javascript" src="<?php echo JS_PATH?>policy/iprange.js?"></script>
 <script type="text/javascript">
 function page(pageNo)
 {
 
	 if(pageNo == -1) {
		 pageNo = $('#pageNum').val();
	 }
	 var re = /^[1-9]\d*$/;
	 pageCount = $("#pageCountHidden").val();
	 if ((!re.test(pageNo)) || (parseInt(pageNo) > parseInt(pageCount)))
	 {
	   	 alert("必须为正整数，且不能大于"+pageCount);
	 } else {
		 var currentPageNo = parseInt($(".numon").html());
		 if(parseInt(pageNo)==currentPageNo){
			alert("当前为"+pageNo+"页");
		 } else{
			 var service = $("#serviceSelectHidden").val();
			 window.location.href="iprange.php?page=page&pageNo="+pageNo;
		 } 
	 }
 }
</script>
 <body id="body">
 <h5 class="title102" style="position:relative; zoom:1;"><em>IP范围管理</em> <span></span></h5>
    <div class="itabContent"> 
    <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
             		<tr>
                        <th align="right">
                        	<div class="btn" style="width: 100px;">
                       	 		<a href="#" class="neibu" onclick="addIPRange();">添加</a>
							</div>
						</th>
                    </tr>                 
    </table>
         <div class="tabContent">
     	 	<?php 
     	 	$len=count($ipRangeList);
     	 	if ($len <= 0) {
     	 		echo '<font color="red" style="font-size:14px;">无IP范围记录显示，请重试！</font>';
     	 	} else {
     	 	?>
     	 	
     	 	 <table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
             	<tbody>
                	<tr>
                        <th width="8%">编号</th>
                        <th width="25%">IP范围名称</th>
                        <th width="20%">起始IP</th>
                        <th width="20%">终止IP</th>
                        <th class="border_r0">操作</th>                        
                    </tr>  
                    <?php 
                    	foreach ($ipRangeList as $iprange){
                    ?>          
                    <tr>
                    	<td><?php echo $iprange['RangeID']?></td>
                    	<td><?php echo $iprange['RangeName']?></td>
                    	<td><?php echo ($iprange['StartIP'])?></td>
                    	<td><?php echo ($iprange['EndIP'])?></td>
						<td><a href="#" class="neibu" style="color: white;" onclick="deleteIPRange(<?php echo $iprange['RangeID']?>);">删除</a></td>
                    </tr>       
                    <?php }?>   
                </tbody>
             </table> 
             <?php
     	 	}
     	 	?>    
         </div>
         <?php echo $page->toString()?>         
     </div>
    
     <!-- 添加IPRange -->
     <div id="addNewIPRangeDiv" title="添加IP范围" style="display: none;">
		<form action="addIpRange" method="post" name="addNewIPRangeForm">
			<table id="addNewObjectGroup" style="color: orange; left: 1px;" class="tab3">
				<tr>
					<td>范围名称：</td>
					<td><input type="text" style="width: 150px;" id="newRangeNameText"/><font color="red">*</font></td>
				</tr>
				<tr>
					<td>起始IP：</td>
					<td><input type="text" style="width: 150px;" id="newStartIPText"/><font color="red">*</font></td>
				</tr>
				<tr>
					<td>结束IP：</td>
					<td><input type="text" style="width: 150px;" id="newEndIPText"/><font color="red">*</font></td>
				</tr>
			</table>
			<span id="warningInfo"></span>
		</form>
	 </div>   
     
 </body>
 </html>