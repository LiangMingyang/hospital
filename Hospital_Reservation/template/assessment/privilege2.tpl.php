<?php
/**
 * privilege.tpl.php-.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-5-8,created by Fu Cheng
 */
 include header_inc();
 ?>
<script src="<?php echo JS_PATH?>highcharts/highcharts.js"></script>
<script src="<?php echo JS_PATH?>highcharts/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	$('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '用户分类'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.y}</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.point.y;
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '用户数',
//                data: [
//                    ['Firefox',   45.0],
//                    ['IE',       26.8],
//                    {
//                        name: 'Chrome',
//                        y: 12.8,
//                        sliced: true,
//                        selected: true
//                    },
//                    ['Safari',    8.5],
//                    ['Opera',     6.2],
//                    ['Others',   0.7]
//                ]
                data: <?php echo $data;?> //核心数据列来源于php读取的数据并解析成JSON
            }]
        });

    	$('#longTimeUsers').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '长时间未活动用户'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.y}</b>',
            	percentageDecimals: 1
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.point.y;
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '未活动天数',
//                data: [
//                    ['Firefox',   45.0],
//                    ['IE',       26.8],
//                    {
//                        name: 'Chrome',
//                        y: 12.8,
//                        sliced: true,
//                        selected: true
//                    },
//                    ['Safari',    8.5],
//                    ['Opera',     6.2],
//                    ['Others',   0.7]
//                ]
                data: <?php echo $unactiveData;?> //核心数据列来源于php读取的数据并解析成JSON
            }]
        });//end unactive user
        
    });// end document ready
    
});
</script>

 <body>
 <h5 class="title102"><em>数据库权限合理性评估</em></h5>
<div class="box102 p20">
  <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</div>
<div class="box102 p20">
<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="text-align: center;">
	<tr width="100%">
		<th width="10%">模式编号</th>
       	<th width="20%">代表用户</th>
       	<th width="15%">包含的用户数</th>
        <th width="45%">权限</th> 
        <th width="10%">操作</th> 
	</tr>
	<?php 
		foreach ($patternList as $pattern) {
			$userSetStr = $pattern['user_set'];
			$userList = explode(",", $userSetStr);
			$privilegeSetStr = $pattern['db_privilege_set'];
			$privilegeList = explode(",", $privilegeSetStr);
			?>
			<tr>
			<td><a href="privilegeInfo.php?targetId=<?php echo $pattern['id']?>"><?php echo $pattern['id']?></a></td>
			<td><?php echo $pattern['user_center']?></td>
			<td><?php echo count($userList)?></td>
			<td><?php echo $privilegeSetStr?></td>
			<td class="border_r0">
            	<a href="privilegeInfo.php?targetId=<?php echo $pattern['id']?>" class="neibu" style="color: white;">查看</a>
            </td>
			</tr>
			<?php
		}
		?>	
</table>
<!-- 
<a href="evaluation.php">权限评估</a>
 -->
</div>

<!-- 长时间未活动的用户显示 -->
<div class="box102 p20">
  <div id="longTimeUsers" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</div>
<!-- 从未活动过的用户 -->
<div class="box102 p20">
<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">从未活动过的用户</p>
  	<br/>
  	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
		<tr>
			<th width="10%">编号</th>
			<th width="20%">用户名</th>
			<th>数据库设置的权限</th>
		</tr>
		<?php 
		foreach ($unactiveUserList as $user) {
			?>
			<tr>
				<td><?php echo $user['id']?></td>
				<td><?php echo $user['username']?></td>
				<td align="left">
				<?php 
					$userPrivStr = $user['db_privilege'];
					$privList = explode(",", $userPrivStr);
					$count=1;
					$showStr = "";
					foreach ($privList as $priv) {
						if($count%10==0){
							$showStr .= "<br/>";
						} else {
							$showStr .= $priv.",";
						}
						$count++;
					}
					echo $showStr;
				?></td>
			</tr>
			<?php
		}
		?>
	</table>
</div>
 </body>
 </html>
