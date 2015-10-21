<script type="text/javascript" src="<?php echo base_url()?>js/jquery.form.js"></script>

<div class="content">

  <h1>Edit Your Post</h1>
  <hr>
<div class="row">
    <div class="col-md-3">
      <div class="text-center">
        <div style="width:200px; height:200px;">
          <img id="showimg" class="img_post img-responsive" src="http://placehold.it/200" alt="avatar">
        </div>
        <h6>Upload a photo for your item...</h6>

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


    <!-- edit form column -->
  <?php echo validation_errors('<p class="error">'); ?>
    <?php echo form_open("post/postitem"); ?>
    <div class="col-md-9">

        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_name">Name:</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" id="item_name" name="name" value="<?php echo set_value('name');?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_price">Price:</label>
          <div class="col-lg-8">
            <input class="form-control" type="number" step="0.01" id="item_price" name="price" value="<?php echo set_value('price');?>"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_count">Count:</label>
          <div class="col-lg-8">
            <input class="form-control" type="number" id="item_count" name="count" value="<?php echo set_value('count');?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_gender">Gender:</label>
          <div class="col-lg-8">
            <div class="ui-select">
              <select id="gender" class="form-control" name="gender" value="<?php echo set_value('gender');?>">
                <option value="female">Women</option>
                <option value="male">Man</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_type">Category:</label>
          <div class="col-lg-8">
            <div class="ui-select">
              <select id="clothes-style" class="form-control" name="type" value="<?php echo set_value('type');?>">
                <option value="top">Top</option>
                <option value="bottom">Bottom</option>
                <option value="shoes">Shoes</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_material">Material:</label>
          <div class="col-lg-8">
      <input class="form-control" type="text" id="item_material" name="material" placeholder="optional" value="<?php echo set_value('material');?>" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_style">Style:</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" id="item_style" name="style" placeholder="optional" value="<?php echo set_value('style');?>"  />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_size">Size:</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" id="item_size" name="size" placeholder="optional" value="<?php echo set_value('size');?>"   />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label" for="item_detail">Detail:</label>
          <div class="col-lg-8">
          	<textarea class="form-control" rows="5" id="item_detail" name="detail" placeholder="optional" value="<?php echo set_value('detail');?>"></textarea>
          </div>
        </div>

    	<input style="display:none" type="text" id="item_url" name="url" value="<?php echo set_value('url');?>"  />
            

        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-8">
            <input type="submit" class="btn btn-primary" value="Post it!">
            <span></span>
            <input type="reset" class="btn btn-default" value="Reset">
          </div>
        </div>

        <?php echo form_close(); ?>
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
  $("#fileupload").wrap("<form id='myupload' action='<?php echo base_url()?>post/up_img?act='upimg' method='post' enctype='multipart/form-data'></form>");
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
    $.post("<?php echo base_url()?>post/up_img?act=delimg",{imagename:pic},function(msg){
      if(msg==1){
        files.html("Delete Success");
        showimg.attr("src", "");
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

</style>
