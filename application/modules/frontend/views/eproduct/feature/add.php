<form action="" method="POST" role="form">
	<legend>Add Product's Feature</legend>

	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name" disabled
		value="<?php echo $eproduct->getName();?>">
	</div>


	<div class="form-group">
		<label for="feature">Feature</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="feature"
		value="<?php echo set_value('feature');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend/onetomanyfromeproduct', 'Cancel', 'class="btn btn-warning"'); ?>

</form>