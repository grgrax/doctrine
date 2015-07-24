<form action="" method="POST" role="form">
	<legend>Add User's Phoneno</legend>

	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name" disabled
		value="<?php echo $user->getUsername();?>">
	</div>


	<div class="form-group">
		<label for="phoneno">Phoneno</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="phoneno"
		value="<?php echo set_value('phoneno');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend/onetoonetbljoinuserpnos', 'Cancel', 'class="btn btn-warning"'); ?>

</form>