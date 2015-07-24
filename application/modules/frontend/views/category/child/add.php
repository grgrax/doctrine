<form action="" method="POST" role="form">
	<legend>Add Product's Feature</legend>

	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name" disabled
		value="<?php echo $category->getName();?>">
	</div>


	<div class="form-group">
		<label for="child">child</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="child"
		value="<?php echo set_value('child');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>