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

    	$('#neverActiveUsers').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '从未活动过的用户'
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
                            return '<b>'+ this.point.name +'</b>: '+ parseFloat(parseInt(this.point.percentage*100)/100.0) + ' %';
//                        		return '<b>'+ this.point.name +'</b>: '+ this.point.y + ' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '用户数:',
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
                data: <?php echo $neverData;?> //核心数据列来源于php读取的数据并解析成JSON
            }]
        });//end unactive user
        
    });// end document ready
    
});

function checkNum(obj)
{
	var re = /^[1-9]\d*$/;
     if (!re.test(obj.value))
    {
        alert("请输入正整数!");
   		obj.value=$("#unactiveDayHidden").val();
        obj.focus();
        return false;
     }
} 

function checkRightMining(serviceId) {
	$.ajax({
		url:"checkRightMining.php?serviceId="+serviceId,
		type:"post",
		dataType:"json",
		success:function(data){
			alert(data);
		}
	});
}
</script>

 <body>
 <h5 class="title102"><em>用户活动情况</em></h5>
<div class="box102 p20" style="width: 100%">
	<form action="?cmd=query" name="searchActiveForm" id="searchActiveForm" method="post">
	<table align="center">
	<tr>
	<td>请选择数据库：
		<select name='service' style='width:250px'><option value=''>全部数据库</option>
		<?php foreach ($services as $serviceObj){
			if($serviceId==$serviceObj['ServiceId']){
				?>
				<option value="<?php echo $serviceObj['ServiceId']?>" selected="selected" onchange="checkRightMining(<?php echo $serviceObj['ServiceId']?>);"><?php echo $serviceObj['ServerName'].":",$serviceObj['Protocol'].":".$serviceObj['ServiceName']?></option>
				<?php
			} else {
				?>
				<option value="<?php echo $serviceObj['ServiceId']?>" onchange="checkRightMining(<?php echo $serviceObj['ServiceId']?>);"><?php echo $serviceObj['ServerName'].":",$serviceObj['Protocol'].":".$serviceObj['ServiceName']?></option>
				<?php
			}
		}
			?>
		</select>
		&nbsp;&nbsp;
	</td>
	<td>
		输入未活动天数：
		<input type="text" value="<?php echo $days?>" id="unactiveDayText" name="unactiveDayText" style="width: 50px;" onchange="checkNum(this);"/>&nbsp;&nbsp;
	</td>
	<td>
		<a href="javascript:void(0)" onclick="searchActiveForm.submit();" class="neibu">查询</a>
	</td>
	</tr>
	</table>
	<input type="hidden" value="<?php echo $days?>" name="unactiveDayHidden" id="unactiveDayHidden"/>
	</form>
</div>
<!-- 长时间未活动的用户显示 -->
<div class="box102 p20">
  <div id="longTimeUsers" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
  <div style="width: 100%;text-align: right;"><a href="activeUserDetails.php?cmd=longTime&targetServiceId=<?php echo $serviceId?>&days=<?php echo $days?>"><img src="<?php echo IMAGE_PATH?>clickShow.jpg"/></a></div>
</div>
<!-- 从未活动过的用户 -->
<div class="box102 p20">
  	<div id="neverActiveUsers" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
  	<div style="width: 100%;text-align: right;"><a href="activeUserDetails.php?cmd=unactive&targetServiceId=<?php echo $serviceId?>"><img src="<?php echo IMAGE_PATH?>clickShow.jpg"/></a></div>
</div>
 </body>
 </html>
