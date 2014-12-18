<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=7" />
<title>医院预约挂号系统</title>
<link href="<?php echo CSS_PATH?>main<?php echo $css?>.css?<?php echo mktime();?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>flexigrid.css?<?php echo mktime();?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_PATH?>jquery/jquery.ui.all.css?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo JS_PATH?>jquery-1.7.2.min.js"></script>

<link id="artDialogSkin" href="<?php echo CSS_PATH?>artDialog/skin/aero/aero.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CSS_PATH?>artDialog/artDialog.js"></script>


<!-- 
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-1.3.js"></script>
 -->


<script type="text/javascript" src="<?php echo JS_PATH?>jquery.json-2.3.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>swfobject.js"></script>
<script src='<?php echo JS_PATH?>My97DatePicker/WdatePicker.js' language='javascript'></script>
<script type="text/javascript" src="<?php echo JS_PATH?>dia.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH?>web.js"></script>
<script language="javascript" type="text/javascript">
	var WEB_ROOT = '<?php echo WEB_ROOT?>';
</script>
<script type="text/javascript">
    <!--
    function iframeAutoFit()
    {
        var ex;
        try
        {
            if(window!=parent)
            {
                var a = parent.document.getElementsByTagName("iframe");
                for(var i=0; i<a.length; i++) //author:meizz
                {
                    if(a[i].contentWindow==window)
                    {
                        var h1=0, h2=0;
                        if(document.documentElement&&document.documentElement.scrollHeight)
                        {
                            h1=document.documentElement.scrollHeight;
                        }
                        if(document.body) h2=document.body.scrollHeight;

                        var h=Math.max(h1, h2);
                        if(document.all) {h += 4;}
                        if(window.opera) {h += 1;}
                        a[i].style.height = h +"px";
                    }
                }
            }
        }
        catch (ex){alert(ex);}
    }
    if(document.attachEvent)
    {
        window.attachEvent("onload",  iframeAutoFit);
        window.attachEvent("onresize",  iframeAutoFit);
    }
    else
    {
        window.addEventListener('load',  iframeAutoFit,  false);
        window.addEventListener('resize',  iframeAutoFit,  false);
    }
    //-->
    </script>  

</head>
