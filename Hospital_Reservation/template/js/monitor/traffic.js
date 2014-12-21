
function getSysInfo(){
	getTraffic();
}
function findSWF(movieName) {
	  if (navigator.appName.indexOf("Microsoft")!= -1) {
	    return window[movieName];
	  } else {
	    return document[movieName];
	  }
	}
function getTraffic(){
	$.get(WEB_ROOT+'monitor/traffic.php?cmd=cpu',{dt:new Date().getTime()},function(data){
		try{
		tmp = findSWF("cpu");
	    x = tmp.load(data);
		
	}catch(ex){}
    setTimeout(getTraffic,1000);
	});
}

function loadResult(){
	getServerStatus();
}

//获取数据库服务器运行状态
function getServerStatus() {
	var serverIp = $("#serverIpHidden").val();
	var protocol = $("#protocolHidden").val();
	var timeRadio = $("#timeRadioHidden").val();
	$.get(WEB_ROOT+"monitor/dbServerStatus.php",{
		searchServer:serverIp,
		searchProtocol:protocol,
		timeRadio:timeRadio
	},function(data){
		try {
//			alert(data);
			$('body').html(data);
		} catch(ex) {}
		setTimeout(getServerStatus,1000*60*5);
	},"text");
//	window.location.href="dbServerStatus.php?searchServer="+serverIp+"&searchProtocol="+protocol+"&timeRadio="+timeRadio;
//	setTimeout(getServerStatus,1000*60*5);
}