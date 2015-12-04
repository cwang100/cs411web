<div class="content">
<p>This page is for top.</p>

	<!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> Top
                    <small>...</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->

        <?php
        $index = 0;
        foreach ($itemlist as $rows) {
        	if($index % 3 == 0){ ?>
        <div class="row">
        	<?php } ?>

            <div class="col-md-4 portfolio-item">
                <a href="<?php echo base_url().'detail?id='.$rows->id?>">
                    <img class="img-responsive" src=<?php if($rows->img) { echo $rows->img; } else { echo "http://placehold.it/700x400"; }?> alt="">
                </a>
                <h3>
                    <a href="<?php echo base_url().'detail?id='.$rows->id?>"><?php echo $rows->name?></a>
                </h3>
            </div>
            <?php if($index % 3 == 2){ ?>
        </div>
        <!-- /.row -->
        <?php } $index++; } ?>
    </div>

</div>