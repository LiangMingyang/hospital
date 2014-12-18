function getSysInfo(){
	getCPUInfo();
	getMemory();
	setTimeout(getDisk,500);
}
function findSWF(movieName) {
	  if (navigator.appName.indexOf("Microsoft")!= -1) {
	    return window[movieName];
	  } else {
	    return document[movieName];
	  }
	}
function getCPUInfo(){
	$.get(WEB_ROOT+'monitor/computer.php?cmd=cpu',{dt:new Date().getTime()},function(data){
		try{
		tmp = findSWF("cpu");
	    x = tmp.load(data);
		
	}catch(ex){}
    setTimeout(getCPUInfo,1000);
	});
}
function getMemory(){
	$.get(WEB_ROOT+'monitor/computer.php?cmd=memory',{dt:new Date().getTime()},function(data){
		try{
		tmp = findSWF("memory");
	    x = tmp.load(data);
	}catch(ex){}
	setTimeout(getMemory,1000);
	});
}
function getDisk(){
	$.get(WEB_ROOT+'monitor/computer.php?cmd=disk',{dt:new Date().getTime()},function(data){
		try{
		arr = $.evalJSON(data);
		for(var i = 0; i < arr.length; ++i){
		tmp = findSWF("disk"+i);
	    x = tmp.load(arr[i]);
		}
	}catch(ex){}
    setTimeout(getDisk,5000);
	});
}
