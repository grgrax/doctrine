<form action="" method="POST" role="form">
	<legend>Add Category with child</legend>

	


	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" 
		name="name"
		value="<?php echo set_value('name');?>">
	</div>

	<div class="form-group">
		<label for="child">child 1</label>
		<input type="text" class="form-control" id="" 
		name="childs[]"
		value="<?php echo set_value('childs[0]');?>">
	</div>

	<div class="form-group">
		<label for="child">child 2</label>
		<input type="text" class="form-control" id="" 
		name="childs[]"
		value="<?php echo set_value('childs[1]');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>