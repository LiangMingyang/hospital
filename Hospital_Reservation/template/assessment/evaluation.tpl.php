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
    	
    	// Build the chart
    	/*
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '数据库权限评估'
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
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: '用户数',
                data: <?php echo $data;?> //核心数据列来源于php读取的数据并解析成JSON
            }]
        });
		*/
        
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

        $('#bigPrivUsers').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '权限设置过大的用户'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: 
//                    [
//                    'Jan',
//                    'Feb',
//                    'Mar',
//                    'Apr',
//                    'May',
//                    'Jun',
//                    'Jul',
//                    'Aug',
//                    'Sep',
//                    'Oct',
//                    'Nov',
//                    'Dec'
//                ]
                	<?php echo $xBigPrivUsers?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: 
//            [{
//                name: 'Tokyo',
//                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
//    
//            }, {
//                name: 'New York',
//                data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
//    
//            }, {
//                name: 'London',
//                data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]
//    
//            }, {
//                name: 'Berlin',
//                data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]
//    
//            }]
            <?php echo $returnValue?>
        });
        
    }); //end document ready
    
});
</script>

 <body>
 <h5 class="title102"><em>数据库权限合理性评估</em></h5>
<!-- 
<div class="box102 p20">
  <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</div>
 -->
<!-- 长时间未活动的用户显示 -->
<div class="box102 p20">
  <div id="longTimeUsers" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
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
<!-- 权限设置过大的用户显示 -->
<div class="box102 p20">
  <div id="bigPrivUsers" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
</div>

<!-- 同类用户中权限设置差别太大的用户 -->
<!-- 
<div class="box102 p20">
<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">同类权限设置差别大的用户</p>
  	<br/>
  	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4">
		<tr>
			<th width="10%">编号</th>
			<th width="20%">用户名</th>
			<th>数据库设置的权限</th>
		</tr>
	</table>
</div>
 -->
 </body>
 </html>
