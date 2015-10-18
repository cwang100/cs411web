<div class="content">

<div class="post_form">
<div class="form_title">Post Item</div>
<?php echo validation_errors('<p class="error">'); ?>
	<?php echo form_open("post/postitem"); ?>
		<p>
			<label for="item_name">name:</label>
			<input type="text" id="item_name" name="name" />
		</p>
		<p>
			<label for="item_type">type:</label>
			<select name="type">
				<option value="top">top</option>
				<option value="bottom">bottom</option>
				<option value="shoes">shoes</option>
			</select>
		</p> 
		<p>
			<label for="item_material">material:</label>
			<input type="text" id="item_material" name="material" />
		</p>
		<p>
			<label for="gender">gender:</label>
			<input type="text" id="item_gender" name="gender"  />
		</p>
		<p>
			<label for="item_count">count:</label>
			<input type="text" id="item_count" name="count"  />
		</p>
		<p>
			<label for="item_style">style:</label>
			<input type="text" id="item_style" name="style"  />
		</p>
		<p>
			<label for="item_size">size:</label>
			<input type="text" id="item_size" name="size"  />
		</p>
		<p style="display:none">
			<input type="text" id="item_url" name="url"  />
		</p>
		<p>
			<input type="submit" class="greenButton" value="Submit" />
		</p>
	<?php echo form_close(); ?>
</div>




<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery.form.js"></script>

<div id="main">
   <div class="demo">
   		<div class="btn">
            <span>Choose Image</span>
            <input id="fileupload" type="file" name="mypic">
        </div>
        <div class="progress">
    		<span class="bar"></span><span class="percent">0%</span >
		</div>
        <div class="files"></div>
        <div id="showimg"></div>
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
        		showimg.empty();
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
				showimg.html("<img src='"+img+"'>");
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
	
	$(".delimg").live('click',function(){
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
});
</script>



</div>