var c_Width, //可见 宽度
s_Width, //滚动 宽度
s_Left, //据左边距 宽度
c_Height, //可见 高度
s_Height, //滚动 高度
s_Top, //距上边距 高度
js_Top, //弹出框距 上边框 距离
js_Left, //弹出框距 左边框 距离
js_Title; //标题行
function show_Win(content,title,type,w_width,w_height){
	var html = "";
	title = arguments[1]?arguments[1]:'&nbsp;';
	type = arguments[2]?arguments[2]:'text';
	if(type == "url"){
		w_width = arguments[3]?arguments[3]:600;
		w_height = arguments[4]?arguments[4]:350;
		if(w_height > 350) w_height = 350;
		html ="<div><iframe src='"+content+"'width='"+w_width+"' height='"+w_height+"' frameborder='no' border='0' scrolling='yes' /></div>";;
	}else if(type == "text"){
		w_width = arguments[3]?arguments[3]:'400px';
		html = '<div class="cont">'+content+'</div>';
	}
	$body = $('<div id="win_div" class="s_tip"><h4><span onclick="close_Win()"></span>'+title+'</h4>'+html+'</div>');
	var d = document;
	 var render = $('body');
	    if(window == window.top || window.parent == window.top)
	    	render = $('body');
	    else{
	    	d = window.parent.document;
	    	render = $(window.parent.document).find('body');
	    }
	c_Width = d.body.clientWidth || d.documentElement.clientWidth; //可见 宽度
    s_Width = d.documentElement.scrollWidth; //滚动 宽度
    s_Left = d.documentElement.scrollLeft || d.body.scrollLeft; //据左边距 宽度(document.body的加入是为了兼容safari浏览器)
    c_Height =  d.body.clientHeight || d.documentElement.clientHeight; //可见 高度
    s_Height = d.documentElement.scrollHeight; //滚动 高度
    s_Top = d.documentElement.scrollTop || d.body.scrollTop; //距上边距 高度(document.body的加入是为了兼容safari浏览器)
	//创建遮罩层
    ll = $("body").offset().left;
    tt = $("body").offset().top;
    ww = s_Width - ll;
    hh = s_Height - tt;
   
	$("<div id=\"div_Bg\"></div>").css({ "position": "absolute", "left": ll+"px", "top": tt+"px", "width": ww+"px", "height": hh+"px", "background-color": "#ffffff", "opacity": "0.6", "z-index": "19698" }).appendTo(render);
	
    js_X = c_Width/2; //被点击按钮距 上边距 距离
    js_Y = c_Height/2; //被点击按钮距 左边距 距离
    $body.appendTo(render);
    $body.css({"position":"absolute","display":"block"}).animate({width:w_width},0); //必须先弹出此行，否则msgObj[0].offsetHeight为0，因为"display":"none"时，offsetHeight无法取到数据
    //y轴位置
    js_Top = (c_Height - parseInt($body.height())) / 2 + s_Top + "px";
    //x轴位置
    js_Left = (c_Width - parseInt($body.width())) / 2 + s_Left + "px";
    $body.css("display", "none");//为了运行animate效果，再隐藏
    $body.css({ "position": "absolute", "top": js_Y, "left": js_X, "background-color": "#ffffff", "z-index": "19699" }).animate({ top: js_Top, left: js_Left, width: 'toggle', height: 'toggle' });
    
}
function show_Win2(div_Win, tr_Title, render) {
    c_Width = document.body.clientWidth || document.documentElement.clientWidth; //可见 宽度
    s_Width = document.documentElement.scrollWidth; //滚动 宽度
    s_Left = document.documentElement.scrollLeft || document.body.scrollLeft; //据左边距 宽度(document.body的加入是为了兼容safari浏览器)
    c_Height =  document.body.clientHeight || document.documentElement.clientHeight; //可见 高度
    s_Height = document.documentElement.scrollHeight; //滚动 高度
    s_Top = document.documentElement.scrollTop || document.body.scrollTop; //距上边距 高度(document.body的加入是为了兼容safari浏览器)
    js_Title = $("#" + tr_Title); //标题
    js_Title.css("cursor","move");
    //创建遮罩层
    ll = $(render).offset().left;
    tt = $(render).offset().top;
    ww = s_Width - ll;
    hh = s_Height - tt;
    $("<div id=\"div_Bg\"></div>").css({ "position": "absolute", "left": ll+"px", "right": tt+"px", "width": ww+"px", "height": hh+"px", "background-color": "#ffffff", "opacity": "0.6", "z-index": "19698" }).prependTo($(render));
    //获取弹出层
    var msgObj = $("#" + div_Win);

    
    //从鼠标点击控件的位置 到 屏幕居中位置渐变
    
    js_X = c_Width/2; //被点击按钮距 上边距 距离
    js_Y = c_Height/2; //被点击按钮距 左边距 距离
    msgObj.css("display","block"); //必须先弹出此行，否则msgObj[0].offsetHeight为0，因为"display":"none"时，offsetHeight无法取到数据
    //y轴位置
    js_Top = (c_Height - parseInt(msgObj[0].offsetHeight)) / 2 + s_Top + "px";
    //x轴位置
    js_Left = (c_Width - parseInt(msgObj[0].offsetWidth)) / 2 + s_Left + "px";
    msgObj.css("display", "none");//为了运行animate效果，再隐藏
    msgObj.css({ "position": "absolute", "top": js_Y, "left": js_X, "background-color": "#ffffff", "z-index": "19699" }).animate({ top: js_Top, left: js_Left, width: 'toggle', height: 'toggle' });

    //处理移动事件
    element = document.getElementById(div_Win);
    drag_element = document.getElementById(tr_Title);
    drag_element['target'] = div_Win;
    drag_element.onmousedown = pop_mousedown;
}

var pop_dragging = false; //是否允许拖拽
var pop_target; //目标
var pop_mouseX;
var pop_mouseY;
var pop_mouseposX;
var pop_mouseposY;
var pop_oldfunction;
//mousedown
function pop_mousedown(e) {
    var ie = navigator.appName == "Microsoft Internet Explorer";
    if (ie && window.event.button != 1) return;
    if (!ie && e.button != 0) return;
    pop_dragging = false;
    pop_target = this['target'];
    pop_mouseX = ie ? window.event.clientX : e.clientX;
    pop_mouseY = ie ? window.event.clientY : e.clientY;
    if (ie) pop_oldfunction = document.onselectstart;
    else pop_oldfunction = document.onmousedown;
    if (ie) document.onselectstart = new Function("return false;");
    else document.onmousedown = new Function("return false;");
}
//mousemove
function pop_mousemove(e) {
    if (!pop_dragging) return;
    var ie = navigator.appName == "Microsoft Internet Explorer";
    var element = document.getElementById(pop_target); //移动的dom
    var mouseX = ie ? window.event.clientX : e.clientX;
    var mouseY = ie ? window.event.clientY : e.clientY;
    element.style.left = (element.offsetLeft + mouseX - pop_mouseX) + "px";
    element.style.top = (element.offsetTop + mouseY - pop_mouseY) + "px";
    pop_mouseX = ie ? window.event.clientX : e.clientX;
    pop_mouseY = ie ? window.event.clientY : e.clientY;
}
//mouseup
function pop_mouseup(e) {
    if (!pop_dragging) return;
    pop_dragging = false;
    var ie = navigator.appName == "Microsoft Internet Explorer";
    var element = document.getElementById(pop_target);
    if (ie) document.onselectstart = pop_oldfunction;
    else document.onmousedown = pop_oldfunction;
}
//mouseposition
function pop_mousepo(e) {
    var ie = navigator.appName == "Microsoft Internet Explorer";
    pop_mouseposX = ie ? window.event.clientX : e.clientX;
    pop_mouseposY = ie ? window.event.clientY : e.clientY;
}

if (navigator.appName == "Microsoft Internet Explorer") {
    document.attachEvent('onmousedown', pop_mousepo);
} else document.addEventListener('mousedown', pop_mousepo, false);
if (navigator.appName == "Microsoft Internet Explorer") {
    document.attachEvent('onmousemove', pop_mousemove);
} else document.addEventListener('mousemove', pop_mousemove, false);
if (navigator.appName == "Microsoft Internet Explorer") {
    document.attachEvent('onmouseup', pop_mouseup);
} else document.addEventListener('mouseup', pop_mouseup, false);


function removeDiv(){
	 $("#win_div").remove();
}
function close_Win() {
    $("#win_div").fadeOut('normal',removeDiv);
    var div_Bg = $("#div_Bg");
    div_Bg.remove();
   
}
 