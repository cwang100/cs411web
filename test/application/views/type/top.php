<div class="content">
<p>This page is for top.</p>

	<!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> type
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
                <a href="#">
                    <img class="img-responsive" src="http://placehold.it/700x400" alt="">
                </a>
                <h3>
                    <a href="#"><?php echo $rows->name?></a>
                </h3>
            </div>
            <?php if($index % 3 == 2){ ?>
        </div>
        <!-- /.row -->
        <?php } $index++; } ?>
    </div>

</div>