$(document).ready(function()
{
	
	/*
	 * Reservation_ID
      		Reservation_Time
      		Operation_Time
      		Doctor_Name

	 */
	$("#history_tb").flexigrid(	
			{
			url:  "../test_history_reservation.php",
			method:"POST",	
			dataType: 'json',
			colModel : [   
				{display: '预约号', name : 'Reservation_ID', width : 60, sortable : true, align: 'center'},
				{display: '预约时间', name : 'Reservation_Time', width : 180, sortable : false, align: 'center'},
				{display: '操作时间', name : 'Operation_Time', width : 100, sortable : true, align: 'center'},
				{display: '预约医生', name : 'Doctor_Name', width : 100, sortable : true, align: 'center'},
				//{display: '预约状态', name : 'State', width : 100, sortable : true, align: 'center'},
				],
			buttons : [
				{name: '查看详情', bclass:'scan', onpress : scan()},
				{separator: true},		
				],
			searchitems : [
				{display: '预约号', name : 'Reservation_ID', isdefault: true},	
				],
			sortname: "Reservation_ID",
			sortorder: "asc",
			//autoload: true, 
			query:getQueryStr(),
			usepager: true,
			pagestat: '{from}~{to}，总数 {total} 条',
			nomsg: '无数据',
			title: '历史预约记录',
			showToggleBtn: false,
			procmsg: '正在获取数据，请稍候 ...',
			useRp: true,
			resizable: true, 
			rp: 10,
			rpOptions: [10, 15, 20, 25],
			showTableToggleBtn: true,
			width: 510,
			height: 250
			}
		);   
});

function scan(){
	
}
function getQueryStr(){
	var st=$('#StartDate').val();
	var et=$('#EndDate').val();
	return st+"!"+et;
}

/*
 * {"total":1,"from":1,"to":1,"rows":[{"id":1,"cell":["1","2014-11-29 07:44:27",
 * "2014-11-29 07:44:27","\u803f\u91d1\u5764","\u6210\u529f"]}]}
 */
