<?php if(count($group)>0) { ?>
<form action="" method="POST" role="form">
	<legend>Edit group</legend>

	<div class="form-group">
		<label for="">Name</label>
		<input type="text" class="form-control" id="" placeholder="Input field"
		name="name"
		value="<?php echo set_value('name',$group->getName());?>">
	</div>

	<div class="form-group">
		<label for="permissions">Permissions</label>
		<select name="permissions[]" id="" class="form-control" multiple="mutiple" size="10">
			<?php foreach ($permissions as $k=>$v): ?>				
				<option value="<?php echo $k?>" 
					<?php echo array_key_exists($k, $group_permissions)?'selected':'';?>	>
					<?php echo $v?>
				</option>
			<?php endforeach ?>
		</select>
	</div>

	<button type="submit" class="btn btn-success" name="submit">Submit</button>
	<?php echo anchor('frontend/manytomanygroupspermissions', 'Cancel', 'class="btn btn-warning"'); ?>

</form>
<?php } ?>