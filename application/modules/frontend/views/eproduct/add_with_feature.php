<form action="" method="POST" role="form">
	<legend>Add Product with feature</legend>

	


	<div class="form-group">
		<label for="feature">Name</label>
		<input type="text" class="form-control" id="" 
		name="name"
		value="<?php echo set_value('name');?>">
	</div>

	<div class="form-group">
		<label for="feature">Feature 1</label>
		<input type="text" class="form-control" id="" 
		name="features[]"
		value="<?php echo set_value('features[0]');?>">
	</div>

	<div class="form-group">
		<label for="feature">Feature 2</label>
		<input type="text" class="form-control" id="" 
		name="features[]"
		value="<?php echo set_value('features[1]');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>