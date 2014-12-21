
$(function(){
	//鼠标越过效果
	$('.conleft li,.hr li').hover(function(){
		$(this).addClass('hover').siblings().removeClass('hover')	
			},function(){$(this).removeClass('hover')})
			
	$('.conleft li a').click(function(){
		$('.conleft li a').removeClass('currstate');
		$(this).addClass('currstate');
	})
			
//左侧莱单显示隐藏切换
	$('.conleft div p').click(function(){
		var i =$('.conleft div p').index(this);
		if($('.conleft div ul').eq(i).css('display')=='none')
			{
			$('.conleft div ul').each(function(){$(this).hide();});
			$('.conleft div p').each(function(){$(this).removeClass('hover');});
			$('.conleft div ul').eq(i).show();				
			$(this).addClass('hover');
			}
		else{
			$('.conleft div ul').eq(i).hide();				
			$(this).removeClass('hover');
			}
	})
	function reposi(){
		var winW=$(window).width();
		var winH=$(window).height();
		var docH=$(document).height();
		//alert($('.conright').height())
		if(winW<1000){$('.conright').width(1000-250);}else{$('.conright').width(winW-250);}
		$('.conleft').height($('.conright').height());
		c_Height =  document.body.clientHeight || document.documentElement.clientHeight; //可见 高度
		$('.conleft').css('min-height',c_Height-163);
		//$('iframe').css('min-height',c_Height-185);
	}

//	var nbw=document.documentElement.clientWidth||document.body.clientWidth;
//	var leftW=nbw-263	
//	var a=Math.floor((leftW-28)/3)-1
//	var b=Math.floor((leftW-14)/2);
		
	$(window).load(function(){
		reposi();
	})
	$(window).resize(function(){
		reposi();
	})
	
//	if(nbw>1200)
//	{
//		$('.top li').css('width',a+'px')
//		$('.foot div').css('width',b+'px')
//	}
//	else
//	{
//		$('.top li').css('width','301px')
//		$('.foot div').css('width','460px')
//		$('#header,#content,.title1').css('width','1000px')
//	}
})
function logout()
{
//	if(confirm('确定要退出吗?'))
//	{
//		location.href=WEB_ROOT+'system/logout.php';
//	}
	
	artDialog({content:'确定要退出吗？', style:'confirm'}, function(){
		location.href=WEB_ROOT+'system/logout.php';
	}, function(){});
}
function command(module,url,para,text)
{
	if(para != undefined && para != '')
		para = '?'+para;
	else
		para = '';
	$('#rightFrame').attr('src',WEB_ROOT+module+'/'+url+para);
	$('#secondNav').html(" \\ "+text);
}
function updatePass() {
	$('#rightFrame').attr('src',WEB_ROOT+'system/update_password.php');
	$('#secondNav').html(" \\ 修改密码");
}
function goTop(){
	if(window != window.top){
		 window.top.location=location;
		}
}