<?php if(count($user)>0) { ?>
<form action="" method="POST" role="form">
	<legend>Edit user</legend>

	<div class="form-group">
		<label for="">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name',$user->getUsername());?>">
	</div>

	<div class="form-group">
		<label for="groups">Groups</label>
		<select name="groups[]" id="" class="form-control" multiple="mutiple" size="10">
			<?php foreach ($groups as $k=>$v): ?>				
				<option value="<?php echo $k?>" 
					<?php echo array_key_exists($k, $user_groups)?'selected':'';?>	>
					<?php echo $v?>
				</option>
			<?php endforeach ?>
		</select>
	</div>




	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend/manytomanyusergroups', 'Cancel', 'class="btn btn-warning"'); ?>

</form>
<?php } ?>