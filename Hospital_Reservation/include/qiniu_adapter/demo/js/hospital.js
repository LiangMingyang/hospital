$(function() {
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',    //上传模式,依次退化
        browse_button: 'pickfiles',       //上传选择的点选按钮，**必需**
        uptoken_url: 'http://hospital.wannakissyou.com/data/getToken',
        //uptoken_url: 'http://127.0.0.1:12321/tok',
            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        domain: 'http://hospital.qiniudn.com/',
            //bucket 域名，下载资源时用到，**必需**
        container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '100mb',           //最大文件体积限制
        flash_swf_url: './Moxie.swf',  //引入flash,相对路径
        max_retries: 3,                   //上传失败最大重试次数
        dragdrop: true,                   //开启可拖曳上传
        drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        init: {
            'FilesAdded': function(up, files) {
                plupload.each(files, function(file) {
                    // 文件添加进队列后,处理相关的事情
                });
            },
            'BeforeUpload': function(up, file) {
                   // 每个文件上传前,处理相关的事情
            },
            'UploadProgress': function(up, file) {
                   // 每个文件上传时,处理相关的事情
            },
            'FileUploaded': function(up, file, info) {
                   // 每个文件上传成功后,处理相关的事情
                   // 其中 info 是文件上传成功后，服务端返回的json，形式如
                   // {
                   //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                   //    "key": "gogopher.jpg"
                   //  }
                   // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                   // var domain = up.getOption('domain');
                   // var res = parseJSON(info);
                   // var sourceLink = domain + res.key; 获取上传成功后的文件的Url
               
                    art.dialog({
                    	title:'系统提示',
                    	icon:'succeed',
                    	content:'上传成功！',
                    	ok:true,
                    	okVal:'确定'
                    });
                    var id=$('#pickfiles img').attr('id');
                    var url=$('#picture_url').val();
                    $('#'+id).attr('src',url);
            },
            'Error': function(up, err, errTip) {
            	    $('#picture_url').val(pic_url);
                    $('#picture_name').val(key);
                    art.dialog({
                    	title:'系统提示',
                    	icon:'error',
                    	content:'上传失败！',
                    	ok:true,
                    	okVal:'确定'
                    });
                   //上传出错时,处理相关的事情
            },
            'UploadComplete': function() {
                   //队列文件处理完毕后,处理相关的事情
            },
            'Key': function(up, file) {
                // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                // 该配置必须要在 unique_names: false , save_key: false 时才生效
                var myDate=new Date();
                var key = "pic_"+myDate.getTime();
                //var key="picture_upload_logo.jpg";
                var pic_url="http://hospital.qiniudn.com/"+key;
                $('#picture_url').val(pic_url);
                // do something with key here
                return key;
            }
        }
    });
    // domain 为七牛空间（bucket)对应的域名，选择某个空间后，可通过"空间设置->基本设置->域名设置"查看获取
    // uploader 为一个plupload对象，继承了所有plupload的方法，参考http://plupload.com/docs
    uploader.bind('FileUploaded', function() {
      console.log('file uploaded successfully');
    });

    $('#container').on('dragenter', function(e) {
      e.preventDefault();
      $('#container').addClass('draging');
      e.stopPropagation();
    }).on('drop', function(e) {
      e.preventDefault();
      $('#container').removeClass('draging');
      e.stopPropagation();
    }).on('dragleave', function(e) {
      e.preventDefault();
      $('#container').removeClass('draging');
      e.stopPropagation();
    }).on('dragover', function(e) {
      e.preventDefault();
      $('#container').addClass('draging');
      e.stopPropagation();
    });
});
