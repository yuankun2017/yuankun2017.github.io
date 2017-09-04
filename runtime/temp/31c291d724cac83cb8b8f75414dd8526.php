<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:47:"./application/admin/view2/mobile_app/index.html";i:1503541883;s:44:"./application/admin/view2/public/layout.html";i:1503541889;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link href="__PUBLIC__/static/css/main.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/css/page.css" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/static/font/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="__PUBLIC__/static/font/css/font-awesome-ie7.min.css">
<![endif]-->
<link href="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<link href="__PUBLIC__/static/js/perfect-scrollbar.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">html, body { overflow: visible;}</style>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/layer/layer.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
<script type="text/javascript" src="__PUBLIC__/static/js/admin.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/js/jquery.mousewheel.js"></script>
<script src="__PUBLIC__/js/myFormValidate.js"></script>
<script src="__PUBLIC__/js/myAjax2.js"></script>
<script src="__PUBLIC__/js/global.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
						layer.closeAll();
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }   
    
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['70%', '80%'],
            content: $(obj).attr('data-url'), 
        });
    }
    
    function delAll(obj,name){
    	var a = [];
    	$('input[name*='+name+']').each(function(i,o){
    		if($(o).is(':checked')){
    			a.push($(o).val());
    		}
    	})
    	if(a.length == 0){
    		layer.alert('请选择删除项', {icon: 2});
    		return;
    	}
    	layer.confirm('确认删除？', {btn: ['确定','取消'] }, function(){
    			$.ajax({
    				type : 'get',
    				url : $(obj).attr('data-url'),
    				data : {act:'del',del_id:a},
    				dataType : 'json',
    				success : function(data){
						layer.closeAll();
    					if(data == 1){
    						layer.msg('操作成功', {icon: 1});
    						$('input[name*='+name+']').each(function(i,o){
    							if($(o).is(':checked')){
    								$(o).parent().parent().remove();
    							}
    						})
    					}else{
    						layer.msg(data, {icon: 2,time: 2000});
    					}
    				}
    			})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);	
    }
</script>  

</head>
<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3>移动App管理</h3>
                <h5>移动App系统升级配置</h5>
            </div>
        </div>
    </div>
    <!-- 操作说明 -->
    <div id="explanation" class="explanation" style="color: rgb(44, 188, 163); background-color: rgb(237, 251, 248); width: 99%; height: 100%;">
        <div id="checkZoom" class="title"><i class="fa fa-lightbulb-o"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span title="收起提示" id="explanationZoom" style="display: block;"></span>
        </div>
        <ul>
            <li>填写系统升级的信息。</li>
        </ul>
    </div>
    <form method="post" id="handlepost" action="<?php echo U('MobileApp/handle'); ?>" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="form_submit" value="ok" />
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label for="android_app_version">安卓App版本号</label>
                </dt>
                <dd class="opt">
                    <input id="android_app_version" name="android_app_version" value="<?php echo $config['android_app_version']; ?>" class="input-txt" type="text" />
                    <p class="notic">请填写安卓App版本号</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="android_app_log">安卓App更新日志</label>
                </dt>
                <dd class="opt">
                    <textarea id="android_app_log" name="android_app_log" class="input-txt"><?php echo $config['android_app_log']; ?></textarea>
                    <p class="notic">请填写安卓App更新日志</p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="android_app_path">安卓App</label>
                </dt>
                <dd class="opt">
                <!--<div class="input-file-show">
                        <span class="type-file-box">
                            <input type="text" id="android_app_path" name="android_app_path" value="<?php echo $config['android_app_path']; ?>" class="type-file-text">
                            <input type="button" name="button" id="button1" value="选择上传..." class="type-file-button">
                            <input class="type-file-file" onClick="appUploadify(1,'','','img_call_back','Admin','MobileApp', 'upload')" size="30" hidefocus="true">
                        </span>
                    </div>-->
                    <input id="android_app_version"  value="<?php echo $config['android_app_path']; ?>" class="input-txt" type="text" disabled/>
                    <input type="file" name="android_app">
                    <span class="err"></span>
                    <p class="notic">上传安卓App文件</p>
                </dd>
            </dl>
            <div class="bot">
                <input type="hidden" name="inc_type" value="<?php echo $inc_type; ?>">
                <a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="check_form();">确认提交</a>
            </div>
        </div>
    </form>
</div>
<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
<script>
    function check_form()
    {
        if(!$('#android_app_version').val()){
            layer.alert('版本号非空',{icon:2});
            return false;
        }
        document.form1.submit()
    }
//    function img_call_back(fileurl_tmp)
//    {
//        $("#android_app_path").val(fileurl_tmp);
//        $("#img_a").attr('href', fileurl_tmp);
//        $("#img_i").attr('onmouseover', "layer.tips('<img src="+fileurl_tmp+">',this,{tips: [1, '#fff']});");
//    }
//    
//    function appUploadify(num,elementid,path,callback , module, cls, fun) {
//        var upurl ='/index.php?m='+module+'&c='+cls+'&a='+fun+'&num='+num+'&input='+elementid+'&path='+path+'&func='+callback;
//        var iframe_str='<iframe frameborder="0" ';
//        iframe_str=iframe_str+'id=uploadify ';   		
//        iframe_str=iframe_str+' src='+upurl;
//        iframe_str=iframe_str+' allowtransparency="true" class="uploadframe" scrolling="no"> ';
//        iframe_str=iframe_str+'</iframe>';    	    		
//        $("body").append(iframe_str);	
//        $("iframe.uploadframe").css("height",$(document).height()).css("width","100%").css("position","absolute").css("left","0px").css("top","0px").css("z-index","999999").show();
//        $(window).resize(function(){
//            $("iframe.uploadframe").css("height",$(document).height()).show();
//        });
//    }
</script>
</body>
</html>