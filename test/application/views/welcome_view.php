<div class="content">

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title margin-title">IlliniBeauty</h1>

              <div class="col-md-12 input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Search</button>
                </span>
              </div><!-- /input-group -->

        
        <p class="lead blog-description">UIUC second hand clothes exchange website</p>
      </div>
    </div>

    <?php if(!$islogin) { if(isset($user_exist)) { echo '<p class="error">Username already exsist</p>'; } echo $register; } ?>

</div><!--<div class="content">-->