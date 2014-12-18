

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ajaxfileupload图片上传控件</title>
</head>
<script type="text/javascript" src="include/AjaxFileUploaderV2.1/jquery.js"></script>
<script type="text/javascript" src="include/AjaxFileUploaderV2.1/ajaxfileupload.js"></script>
<script language="javascript">
  jQuery(function(){   
      $("#buttonUpload").click(function(){     
         //加载图标   
         /* $("#loading").ajaxStart(function(){
            $(this).show();
         }).ajaxComplete(function(){
            $(this).hide();
         });*/
          //上传文件
        $.ajaxFileUpload({
            url:'test.php',//处理图片脚本
            secureuri :false,
            fileElementId :'fileToUpload11',//file控件id
            dataType : 'json',
            success : function (data, status){
                if(typeof(data.error) != 'undefined'){
                    if(data.error != ''){
                        alert("error:  "+data.error);
                    }else{
                        alert(data.msg);
                    }
                }
            },
            error: function(data, status, e){
                alert(e);
            }
    })
    return false;
      }) 
  })

</script>


<body>
<input id="fileToUpload11" type="file" size="20" name="fileToUpload" class="input">
<button id="buttonUpload">上传</button>
<!--<img id="loading" src="loading.jpg" style="display:none;">-->
</body>
</html>

