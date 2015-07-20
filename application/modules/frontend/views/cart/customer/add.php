<form action="" method="POST" role="form">
	<legend>Add Customer</legend>



	<div class="form-group">
		<label for="">Customer</label>
		<input type="text" class="form-control" id="" 
		name="customer"
		value="<?php echo set_value('no');?>">
	</div>

	<div class="form-group">
		<label for="">Cart No.</label>
		<input type="text" class="form-control" id="" 
		name="no"
		value="<?php echo set_value('no');?>">
	</div>



	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>