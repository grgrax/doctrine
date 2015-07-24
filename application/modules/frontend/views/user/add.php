<form action="" method="POST" role="form">
	<legend>Add Student</legend>

	<div class="form-group">
		<label for="mentor">Mentor</label>
		<select name="mentor" id="" class="form-control">
			<option value="null"> Select </option>
			<?php foreach ($students as $student): ?>
				<option value="<?php echo $student->getId()?>">
					<?php echo $student->getName();?>
				</option>
			<?php endforeach ?>
		</select>
	</div>


	<div class="form-group">
		<label for="">label</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name');?>">
	</div>


	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>