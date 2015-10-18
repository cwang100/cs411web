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
			<label for="item_detail">detail:</label>
			<input type="text" id="item_detail" name="detail"  />
		</p>        
		<p>
			<input type="submit" class="greenButton" value="Submit" />
		</p>
	<?php echo form_close(); ?>
</div>

</div>