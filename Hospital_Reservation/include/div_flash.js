<script>
function $id(id){
		return document.getElementById(id);
}
function addEventHandler(oTarget, sEventType, fnHandler){ 
	  if(oTarget.addEventListener){oTarget.addEventListener(sEventType, fnHandler, false);}
	  else if(oTarget.attachEvent){oTarget.attachEvent('on' + sEventType, fnHandler);}
	  else{oTarget['on' + sEventType] = fnHandler;}
}
$(document).ready(function() {
	var zindex=0;
	
	var Bind = function(object,fun){
		var args = Array.prototype.slice.call(arguments).slice(2);
		return function(){
			return fun.apply(object,args);
		}
	}
	
	var Shower=function(){
		this.list=null;
		this.comment=null;
		this.moveLeft=80;  
		this.moveTop=20;
		this.height=150;
		this.width=250;
		this.time=800;
		this.init=function(lisObj,comObj){
			this.list=lisObj;
			this.comment=comObj;
			var _this=this;
			this._fnMove=Bind(this,this.move);
			(function(){
				var obj=_this;
				addEventHandler(obj.list,"click",obj._fnMove);
			})();
		};
		this.move=function(){
			var _this=this;
				var w=0; 
				var h=0; 
				var height=0; //弹出div的高
				var width=0;  //弹出div的宽
				var t=0;
				var startTime = new Date().getTime();//开始执行的时间
				if(!_this.comment.style.display||_this.comment.style.display=="none"){
					_this.comment.style.display="block";
					_this.comment.style.height=0+"px";
					_this.comment.style.width=0+"px";
					_this.list.style.zIndex=++zindex;
					_this.list.className="listShow";
					var comment=_this.comment.innerHTML;  
					_this.comment.innerHTML="";  //去掉显示内容
					var timer=setInterval(function(){
						var newTime = new Date().getTime();
						var timestamp = newTime - startTime;
						_this.comment.style.left=Math.ceil(w)+"px";
						_this.comment.style.top=Math.ceil(h)+"px";
						_this.comment.style.height=height+"px";
						_this.comment.style.width=width+"px";
						t++;
			var change=(Math.pow((timestamp/_this.time-1), 3) +1); //根据运行时间得到基础变化量
						w=_this.moveLeft*change;
						h=_this.moveTop*change;
						height=_this.height*change;
						width=_this.width*change;
						$id("show").innerHTML=w;
						if(w>_this.moveLeft){
								clearInterval(timer);					
								_this.comment.style.left=_this.moveLeft+"px";							
								_this.comment.style.top=_this.moveTop+"px";							
								_this.comment.style.height=_this.height+"px";							
								_this.comment.style.width=_this.width+"px";							
								_this.comment.innerHTML=comment; //回复显示内容
						}
				},1,_this.comment);
				}else{
					_this.hidden();
				}
}
this.hidden=function(){
	var _this=this;
	var flag=1;
	var hiddenTimer=setInterval(function(){
	if(flag==1){
	_this.comment.style.height=parseInt(_this.comment.style.height)-10+"px";
	}else{								_this.comment.style.width=parseInt(_this.comment.style.width)-15+"px";
	_this.comment.style.left=parseInt(_this.comment.style.left)+5+"px";
	}
	if(flag==1 && parseInt(_this.comment.style.height)<10){
		flag=-flag;
	}
	if(parseInt(_this.comment.style.width)<20){
		clearInterval(hiddenTimer);
		_this.comment.style.left="0px";
		_this.comment.style.top="0px";
		_this.comment.style.height="0px";
		_this.comment.style.width="0px";
		_this.comment.style.display="none";
		if(_this.list.style.zIndex==zindex){
				zindex--;
		};
		_this.list.style.zIndex=0;
		_this.list.className="list";
		}
			},1)
		}
	}
	
});
window.onload=function(){
                               //建立各个菜单对象
		var shower1=new ();
		shower1.init($id("list1"),$id("comment1"));
		var shower2=new Shower();
		shower2.init($id("list2"),$id("comment2"));
		var shower3=new Shower();
		shower3.init($id("list3"),$id("comment3"));

	}
    
</script>