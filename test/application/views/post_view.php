<script type="text/javascript" src="<?php echo base_url()?>js/jquery.form.js"></script>

<div class="content">

    <div class="row">

        <div class="col-md-4">
            
        	<div class="post_form">
			<div class="form_title">Post Item</div>
			<?php echo validation_errors('<p class="error">'); ?>
				<?php echo form_open("post/postitem"); ?>
					<p>
						<label for="item_name">name:</label>
						<input type="text" id="item_name" name="name" value="<?php echo set_value('name');?>" />
					</p>
					<p>
						<label for="item_type">type:</label>
						<select name="type" id="item_type">
							<option value="----" selected="selected">----</option>
							<option value="top">top</option>
							<option value="bottom">bottom</option>
							<option value="shoes">shoes</option>
						</select>
					</p> 
					<p>
						<label for="item_material">material:</label>
						<input type="text" id="item_material" name="material" value="<?php echo set_value('material');?>" />
					</p>
					<p>
						<label for="gender">gender:</label>
						<input type="text" id="item_gender" name="gender" value="<?php echo set_value('gender');?>" />
					</p>
					<p>
						<label for="item_count">count:</label>
						<input type="number" id="item_count" name="count" value="<?php echo set_value('count');?>" />
					</p>
					<p>
						<label for="item_style">style:</label>
						<input type="text" id="item_style" name="style" value="<?php echo set_value('style');?>"  />
					</p>
					<p>
						<label for="item_size">size:</label>
						<input type="text" id="item_size" name="size" value="<?php echo set_value('size');?>"   />
					</p>
					<p>
						<label for="item_price">price:</label>
						<input type="number" step="0.01" id="item_price" name="price" value="<?php echo set_value('price');?>"  />
					</p>
					<p style="display:none">
						<input type="text" id="item_url" name="url" value="<?php echo set_value('url');?>"  />
					</p>
					<p>
						<input type="submit" class="greenButton" value="Submit" />
					</p>
				<?php echo form_close(); ?>
			</div>

        </div>

        <div class="col-md-8">
        	<img id="showimg" class="img-responsive" src="http://placehold.it/750x500" alt="">

	   		<div class="btn">
	            <span>Choose Image</span>
	            <input id="fileupload" type="file" name="mypic">
	        </div>
	        <div class="progress">
	    		<span class="bar"></span><span class="percent">0%</span >
			</div>
	        <div class="files"></div>
        </div>

    </div>
</div>

<script type="text/javascript">
$(function () {
	var bar = $('.bar');
	var percent = $('.percent');
	var showimg = $('#showimg');
	var progress = $(".progress");
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='post/up_img?act='upimg' method='post' enctype='multipart/form-data'></form>");
    $("#fileupload").change(function(){
		$("#myupload").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {
        		showimg.attr("src","");
				progress.show();
        		var percentVal = '0%';
        		bar.width(percentVal);
        		percent.html(percentVal);
				btn.html("Uploading...");
    		},
    		uploadProgress: function(event, position, total, percentComplete) {
        		var percentVal = percentComplete + '%';
        		bar.width(percentVal);
        		percent.html(percentVal);
    		},
			success: function(data) {
				files.html("<b>"+data.name+"("+data.size+"k)</b> <span class='delimg' rel='"+data.pic+"'>Delete</span>");
				var img = "<?php echo base_url()?>upload/"+data.pic;
				showimg.attr("src", img);
				btn.html("Choose Image");
				$("#item_url").val(img);
			},
			error:function(xhr){
				btn.html("Upload Failed");
				bar.width('0')
				files.html(xhr.responseText);
			}
		});
	});
	
	$(".files").on('click', ".delimg", function(){
		var pic = $(this).attr("rel");
		$.post("post/up_img?act=delimg",{imagename:pic},function(msg){
			if(msg==1){
				files.html("Delete Success");
				showimg.empty();
				progress.hide();
			}else{
				alert(msg);
			}
		});
	});

	$("#item_type").change(function(){
		// alert($("#item_type").val());
	});

});
</script>

<style type="text/css">
.btn{position: relative;overflow: hidden;margin-right: 4px;display:inline-block; 
*display:inline;padding:4px 10px 4px;font-size:14px;line-height:18px; 
*line-height:20px;color:#fff; 
text-align:center;vertical-align:middle;cursor:pointer;background:#5bb75b; 
border:1px solid #cccccc;border-color:#e6e6e6 #e6e6e6 #bfbfbf; 
border-bottom-color:#b3b3b3;-webkit-border-radius:4px; 
-moz-border-radius:4px;border-radius:4px;} 
.btn input{position: absolute;top: 0; right: 0;margin: 0;border:solid transparent; 
opacity: 0;filter:alpha(opacity=0); cursor: pointer;} 
.progress{position:relative; margin-left:200px; margin-top:-24px;  
width:200px;padding: 1px; border-radius:3px; display:none} 
.bar {background-color: green; display:block; width:0%; height:20px;  
border-radius:3px; } 
.percent{position:absolute; height:20px; display:inline-block;  
top:3px; left:2%; color:#fff } 
.files{height:22px; line-height:22px; margin:10px 0} 
.delimg{margin-left:20px; color:#090; cursor:pointer} 
</style>
