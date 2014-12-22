$(function(){
	var $anvlfteb=$('#anvlfteb'),
		$posbox=$anvlfteb.find('div.posbox'),
		$seledbox=$("#seledbox"),
		anvjson={
            order:'<a href="hospital.php"><img src="img/icon_hosp.png">按医院预约</a>'
                //+'<a href="#"><img src="img/ico_office.gif">按科室预约</a>'
                //+'<a href="#"><img src="img/ico_ill.gif">按疾病预约</a>'
                ,
            orderhelp:'<a href="#"><img src="img/icon_help.png">预约指南</a>',
            notice:'<a href="#"><img src="img/icon_annouce.png">最新公告</a>',
            suggest:'<a href="#"><img src="img/ico_suggest.gif">提交意见</a>'
		};
		 

		$posbox.mouseover(function(){
			var i=$(this).index();
			$(this).addClass("anvh").siblings().removeClass("anvh");
			var selec=$(this).attr("selec");
			if($seledbox.is(":hidden")){
				$seledbox.show().css("left",64*i+1).html("<div>"+anvjson[selec]+"</div>")
			}else{
				$seledbox.stop().animate({left:64*i+1},200,function(){
                        $("#seledbox").html("<div>"+anvjson[selec]+"</div>")
				})
			}
		});
		$anvlfteb.mouseleave(function(){
			$seledbox.hide();
			$posbox.removeClass("anvh");
		})
})
