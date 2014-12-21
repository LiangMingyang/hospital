$(document).ready(function()
{
	$("#history_tb").flexigrid(	
			{
			url:'../php/TransferStation_for_flexigrid.php',
			method:"POST",	
			dataType: 'json',
			colModel : [   
				{display: '预约号', name : 'History_Reservation_ID', width : 60, sortable : true, align: 'center'},
				{display: '预约时间', name : 'History_Reservation_Time', width : 180, sortable : false, align: 'center'},
				{display: '操作时间', name : 'History_Operation_Time', width : 100, sortable : true, align: 'center'},
				{display: '支付状态', name : 'History_Reservation_Paied', width : 100, sortable : true, align: 'center'},
				{display: '预约医生', name : 'Doctor_ID', width : 100, sortable : true, align: 'center'},
				//{display: '预约状态', name : 'State', width : 100, sortable : true, align: 'center'},
				],
			buttons : [
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

function getQueryStr(){
	var st=$('#StartDate').val();
	var et=$('#EndDate').val();
	var encrypttime=getEncryptTime();
	return st+"!"+et+"!"+encrypttime;
}

function search(){
	$("#history_tb").flexOptions(	
			{
             query:getQueryStr()
			}
		).flexReload();
}
