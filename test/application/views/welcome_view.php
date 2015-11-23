<div class="content">

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title margin-title">IlliniBeauty</h1>

              <div class="col-md-12 input-group">
                <input type="text" class="form-control" placeholder="Search for..." id="search_complete">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="button">Search</button>
                </span>
              </div><!-- /input-group -->

        
        <p class="lead blog-description">UIUC second hand clothes exchange website</p>

        <div id="search_result">

        </div>
      </div>
    </div>

    <?php if(!$islogin) { if(isset($user_exist)) { echo '<p class="error">Username already exsist</p>'; } echo $register; } ?>

</div><!--<div class="content">-->

<script type="text/javascript">
$("#search_complete").keyup(function(){
  var keyword = $("#search_complete").val();
  if(keyword !== ''){
        $.ajax({
            type: "POST",
            url: "./type/get_items",
            data: { query: keyword },
            cache: false,
            success: function(data){
              $("#search_result").html("");
              var json = JSON.parse(data);
              handle_data(json.baseurl, json.qresult);
            }
        });
    }
    if(keyword == ''){
      $("#search_result").html("");
    }
    return false;
});



function handle_data(base_url, data){
  var index;
  var item = "";
  for(index = 0; index < data.length; index++){
    if(index % 3 == 0){
      item += "<div class='row'>";
    }
    item += "<div class='col-md-4 portfolio-item'>" + 
    "<div style='width:280px; height:180px;'>" + 
    "<a href='" + base_url + "detail?id=" + data[index].id + "'>" +
    "<img class='img_list img-responsive' src='";
    if(data[index].img){
      item += data[index].img;
    }
    else{
      item += "http://placehold.it/700x400";
    }
    item += "' alt=''>" +
    "</a>" +
    "</div>" +
    "<h3>" +
    "<a href='" + base_url + "detail?id=" + data[index].id + "'>" + data[index].name + "</a>" +
    "</h3>" +
    "</div>";
    if(index % 3 == 2){
      item += "</div>";
    }
  }
  // alert(item);
  $("#search_result").html(item);
}
</script>