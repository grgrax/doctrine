<form action="" method="POST" role="form">
	<legend>Add Client</legend>



	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name');?>">
	</div>


	<div class="form-group">
		<label for="country">country</label>
		<select name="country" id="" class="form-control">
			<option value="null"> Select 
			</option>
			<?php foreach ($countries as $c): ?>
				<option value="<?php echo $c->getId()?>">
					<?php echo $c->getName();?>
				</option>
			<?php endforeach ?>
		</select>
	</div>

	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend', 'Cancel', 'class="btn btn-warning"'); ?>

</form>