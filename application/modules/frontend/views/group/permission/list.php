<?php if(count($permissions)>0) { ?>
<ul class="container">
	<?php foreach ($permissions as $permission) { ?>
	<li>
		<?php echo $permission->getName()?>--- 
		<?php 
		// foreach ($permission->getGroup() as $group) {
		// 	echo $group->getName()?:'N/A';
		// }
		?>
		(Group)
	</li>
	<?php } ?>
</ul>
<hr>
<?php } else {?>
<p>no data</p>
<?php } ?>
<?php echo anchor('frontend/add_permission/', 'Add permission', 'class="btn btn-success"'); ?>
