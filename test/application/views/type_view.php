<div class="content">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> <?php echo $item_type?>
                </h1>
            </div>
        </div>

        <?php
        $index = 0;
        foreach ($itemlist as $rows) {
        	if($index % 3 == 0){ ?>
        <div class="row">
        	<?php } ?>

            <div class="col-md-4 portfolio-item">
                <div style="width:280px; height:180px;">
                <a href="<?php echo base_url().'detail?id='.$rows->id?>">
                    <img class="img_list img-responsive" src=<?php if($rows->img) { echo $rows->img; } else { echo "http://placehold.it/700x400"; }?> alt="">
                </a>
            </div>
                <h3>
                    <a href="<?php echo base_url().'detail?id='.$rows->id?>"><?php echo $rows->name?></a>
                </h3>
            </div>
            <?php if($index % 3 == 2){ ?>
        </div>
        <?php } $index++; } ?>

</div>