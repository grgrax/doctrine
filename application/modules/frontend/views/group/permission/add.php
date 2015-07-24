<form action="" method="POST" role="form">
	<legend>Add Group's permission</legend>

	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name" disabled
		value="<?php echo $group->getName();?>">
	</div>


	<div class="form-group">
		<label for="permission">permission</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="permission"
		value="<?php echo set_value('permission');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend/manytomanygroupspermissions', 'Cancel', 'class="btn btn-warning"'); ?>

</form>