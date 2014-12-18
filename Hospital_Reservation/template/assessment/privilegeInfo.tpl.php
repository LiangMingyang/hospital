<?php
/**
 * privilegeInfo.tpl.php-.
 * @author Fu Cheng
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-5-10,created by Fu Cheng
 */
 include header_inc();
 ?>
<script src="<?php echo JS_PATH?>highcharts/highcharts.js"></script>
<script src="<?php echo JS_PATH?>highcharts/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
	//----
	/*弹出对话框-审计策略查看页面中弹出添加审计策略白名单的对话框*/
	$( "#privilegeDiv" ).dialog({
		autoOpen: false,
		resizable: true,
		height:400,
		width:400,
		modal: false,
		position:"center",
		title:"查看操作权限",
		buttons: {
			"确定": function() {		
				$( this ).dialog( "close" );
			}
		}
	});

	//--end 弹出框----
	
    var chart;
    
    $(document).ready(function () {
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
        });//bigPrivUsers end

    	$('#bigDiffUsers').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '同类中差异大的用户'
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
                data: <?php echo $diffData;?> //核心数据列来源于php读取的数据并解析成JSON
            }]
        });//end bigDiffUsers
        
    });// end document ready
    
});

function showPrivilege(userId) {
	$.ajax({
        url : 'privilegeInfo.php?cmd=showPrivilege&userId='+userId,
        type : 'POST',
        dataType : 'JSON',
        contentType: "application/json; charset=utf-8",
        success : function(data) {
			$("#targetUserInfo").html(data.targetUser);
            var dataList = data.privList;
			count = dataList.length;
			var tr = "";
			for(var i = 0; i < count; i ++) {
				tr += "<tr><td>"+dataList[i].table+"</td>"
				   +"<td>"+dataList[i].sqltype+"</td></tr>";
			}
			var viewTbody = $("#privilegeTbody");
			viewTbody.append(tr);
        }
	});
	$("#privilegeDiv").dialog("open");
}
</script>
 <body>
 <h5 class="title102"><em>查看同类用户权限</em></h5>
<div class="box102 p20">
  <form action="" method="post">
	
	<!-- 同类差异大的用户显示 -->
	<div class="box102">
	</div>
	<div class="box102 p20">
	  <div id="bigDiffUsers" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
	</div>
	<!-- 权限设置过大的用户显示 -->
	<div class="box102 p20">
	  <div id="bigPrivUsers" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
	</div>
	
	<br/>
	<br/>
	
	<!-- 同类用户详细信息 -->
	<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:16px;color:#274b6d;fill:#274b6d;" align="center">该类用户的详细信息</p>
	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="margin-top:10px;">
		<tr>
			<th>编号</th>
			<th>代表用户</th>
			<th>包含用户数</th>
			<th>包含的权限</th>
		</tr>
		<tr>
			<td><?php echo $targetPattern['id']?></td>
			<td><?php echo $targetPattern['user_center']?></td>
			<td><?php echo $userCount?></td>
			<td><?php echo $targetPattern['db_privilege_set']?></td>
		</tr>
	</table>
	<br/>
	<p style="font-family:'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, Helvetica, sans-serif;font-size:14px;color:#274b6d;fill:#274b6d;" align="center">同类用户列表</p>
	<table  border="0" cellspacing="0" cellpadding="0" width="100%" class="tab4" style="margin-top:10px;">
		<tr>
			<th width="10%">编号</th>
			<th width="15%">用户名</th>
			<th width="30%">使用的权限</th>
			<th>数据库设置的权限</th>
			<th>是否差别过大</th>
		</tr>
		<?php 
		foreach ($targetUserList as $user) {
			?>
			<tr>
				<td><?php echo $user['id']?></td>
				<td><?php 
				if($user['username']==$targetPattern['user_center']) {
					echo "<font color='red'>".$user['username']."</font>";
				} else {
					echo $user['username'];
				}
				?></td>
				<!-- 
				<td><?php echo $user['db_privilege_set']?></td>
				<td><?php echo $user['db_real_privilege']?></td>
				 -->
				<td align="left"><a href="#" onClick="showPrivilege(<?php echo $user['id']?>)">
				<?php 
					$userPrivStr = $user['db_privilege_set'];
					$privList = explode(",", $userPrivStr);
					$count=1;
					$showStr = "";
					foreach ($privList as $priv) {
						if($count%5==0){
							$showStr .= "<br/>";
						} else {
							$showStr .= $priv.",";
						}
						$count++;
					}
					echo $showStr;
				?></a></td>
				<td align="left">
				<?php 
					$userPrivStr = $user['db_real_privilege'];
					$privList = explode(",", $userPrivStr);
					$count=1;
					$showStr = "";
					foreach ($privList as $priv) {
						if($count%5==0){
							$showStr .= "<br/>";
						} else {
							$showStr .= $priv.",";
						}
						$count++;
					}
					echo $showStr;
				?></td>
				<td>
				<?php if($user['diff_status']==0){
					echo "否";
				} else {
					echo "<font color='red'>是</font>";
				}
				?>
				</td>
			</tr>
			<?php
		}
		?>
	</table>
  </form>
</div>

<div class="box102 p20" style="text-align: center;width: 100%;">
<center><div class="btn" style="width: 100px;">
    <a href="privilege.php" class="neibu">返回</a>
</div></center>
</div>


<!-- 弹出框 -->
     <div id="privilegeDiv" title="执行过的操作权限" style="display: none;">
		<form action="">
			<p style="font-size:16px;"><span id="targetUserInfo"></span>执行过的权限如下：</p>
			<br/>
			<table id="privilegeTable" style="color: orange; left: 1px;" class="tab4">
				<tr>
					<th width="200px">表名</th>
					<th width="200px">操作</th>
				</tr>
				<tbody id="privilegeTbody"></tbody>
			</table>
		</form>
	 </div>
 </body>
 </html>