<?php include header_inc() ?>
<script type="text/javascript">
<!--
var divindex;
$(function(){
//鼠标越过效果
$('.conleft li,.hr li').hover(function(){
	$(this).addClass('hover').siblings().removeClass('hover')	
		},function(){$(this).removeClass('hover')})
		
$('.conleft li a').click(function(){
	$('.conleft li a').removeClass('currstate');
	$(this).addClass('currstate');
	$('.conleft div').removeClass('on');
	$('.conleft div').eq(divindex).addClass('on');
})
		
//左侧莱单显示隐藏切换
$('.conleft div').hover(function(){
	var i =$('.conleft div').index(this);
	divindex = i;
	if($('.conleft div ul').eq(i).css('display')=='none')
		{
			$('.conleft div ul').eq(i).show();				
			$(this).addClass('hover')
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
	if(winW<1000){$('.conright').width(1000);}else{$('.conright').width(winW);}
	var a=Math.floor(winW/<?php echo count($main_menus);?>)-5;
	$('.conleft p').css('width',a);
}

//var nbw=document.documentElement.clientWidth||document.body.clientWidth;
//var leftW=nbw-263	
//var a=Math.floor((leftW-28)/3)-1
//var b=Math.floor((leftW-14)/2);
	
$(window).load(function(){
	reposi();
})
$(window).resize(function(){
	reposi();
})
	if(window != window.top){
		 window.top.location=location;
		}
})
function logout()
{
	if(confirm('确定要退出吗?'))
	{
		location.href=WEB_ROOT+'system/logout.php';
	}
}
function command(module,url)
{
	$('#rightFrame').attr('src',WEB_ROOT+module+'/'+url);
}
//-->
</script>
<body >
<style>
body{background:#e3e3e3 url(<?php echo IMAGE_PATH?>bg2.jpg) repeat-x; height:100%;}
</style>
<!--头部-->
<div id="header" class="clearfix">
	<div class="hl">
    	<div class="logo fl"><img src="<?php echo IMAGE_PATH?>logo.png"/></div> 
       <!--导航-->
    <div class="title2 fr mr-32">
        <em><?php
if (isset($_SESSION['fullName']) && $_SESSION['fullName'] != '')
    echo $_SESSION['fullName'];
else
    echo $_SESSION['username'];
?>，欢迎您回来。</em>
        <em class="ml-20 mr-32">您上次登录系统是在<?php echo $_SESSION['lastLoginTime'];?></em>
        <a href="#">修改密码</a>

        <a href="javascript:void(0);" onclick="logout()" class=" ml-20">退出登录</a>
    </div>
    </div>
    <div class="clear"></div>    

</div>

<div class="title1 conleft">
        	<?php
        	foreach($main_menus as $menu){ 
        	?>
        	<div>
            <p><span class="licon<?php echo ($menu['MenuID']);?>"><?php echo $menu['MenuText']?></span></p>
            <ul style="display:none">
            	<?php
            	    for($i = 0; $i < count($submenu[$menu['MenuID']]); $i++)
            	    {
            	        $item = $submenu[$menu['MenuID']][$i];
            	?>
                <li class="<?php if($i == 0) echo 'first';?> <?php if($i ==count($submenu[$menu['MenuID']])-1) echo 'last'?>">
                <a href="javascript:void(0);" onclick="command('<?php echo $item['Module']?>','<?php echo $item['Command']?>')"><?php echo $item['MenuText']?></a></li>
				<?php }?>
            </ul>
            </div>
            <?php }?>
        </div>    

<!--内容-->
<div id="content">
    	<!--左侧-->
           
        <!--右侧-->
        <div class="conright">
        	<div style="padding:20px;">
        	<div style="width:100%">
            <!--列表模块-->     
        	<iframe src="<?php echo WEB_ROOT?>shortcut.php" id='rightFrame' width="100%" height="100%" frameborder="no" border="0" scrolling="no" ></iframe>
             </div>
  			</div>
        <div class="clear"></div>
		</div>
</div>
</body>
</html>
