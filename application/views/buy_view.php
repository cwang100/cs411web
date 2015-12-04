<div class="content">

<?php if($buy_success == 1) { ?>

<p>Thank you for buying the item <?php echo $item_detail->name; ?></p>

<?php } elseif($buy_success == 2) { ?>

<p>You cannot buy the item you posted! </p>

<?php } elseif($buy_success == -1) { ?>

<p>You need to log in fitst!</p>

<?php } else { ?>

<p>Sorry, the item <?php echo $item_detail->name; ?> is sold out! </p>

<?php } ?>

</div>