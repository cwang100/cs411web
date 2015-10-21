<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php if($item_detail->name) {echo $item_detail->name;} else { echo "Item Detail";} ?>
            </h1>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8">
            <img class="img_detail img-responsive" src=<?php if($item_detail->img) { echo $item_detail->img; } else { echo "http://placehold.it/750x500";} ?> alt="">
        </div>

        <div class="col-md-4">
            <h4>Status: <span style="color:red;font-size:24px;"><?php if(!$item_detail->count) echo "Sold"; else echo "Still Available!"; ?></span></h4>
            <h4>Price: <span style="color:red;font-size:24px;"><?php echo $item_detail->price." USD"; ?></span></h4>
            <ul>
                <li>Gender: <?php echo $item_detail->gender?></li>
                <li>Material: <?php echo $item_detail->material?></li>
                <li>Seller: <?php echo $item_detail->ownername?></li>
                <li>Remaining: <?php echo $item_detail->count?></li>
            </ul>
            <h4>Owner's comment:</h4>
            <p><?php echo $item_detail->detail; ?></p>
            <br></br>
            <br></br>
            <br></br>
            <button id="buy_btn" type="button" class="btn btn-lg btn-success btn-block">Buy Now</button>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Seller's other items</h3>
        </div>

    <?php if(count($itemlist) == 0){ ?>
        <p> There is no other item posted by the seller </p>
    <?php } else { foreach ($itemlist as $rows) { ?>

        <div class="col-md-4 portfolio-item">
            <div style="width:280px; height:180px;">
            <a href="<?php echo base_url().'detail?id='.$rows->id?>">
                <img class="img_list img-responsive" src=<?php if($rows->img) { echo $rows->img; } else { echo "http://placehold.it/700x400"; }?> alt="">
            </a>
            </div>
            <h4>
                <a href="<?php echo base_url().'detail?id='.$rows->id?>"><?php echo $rows->name?></a>
            </h4>
        </div>
    <?php }} ?>
    </div>
 
</div>

<script type="text/javascript">
$("#buy_btn").click(function(){
    var msg = 'Send message to the owner about availibility:';
    msg += '<textarea rows="4" cols="50" name="comment" form="usrform">Enter Your message here ...</textarea>';
    BootstrapDialog.show({
        title: 'Willing to buy?',
        message: msg,
        buttons: [{
            label: 'Send message first'
        },{
            label: 'Confirm buy item!',
            action: function(dialog){
                // $.ajax({
                    // url: './detail/buy?id='+<?php echo $item_detail->id; ?>,
                    // success: function(response) {
                        location.href = './detail/buy?id='+<?php echo $item_detail->id; ?>;
                    // }
                // })
            }
        }]
    });
});
</script>