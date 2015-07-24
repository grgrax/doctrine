<?php if(count($groups)>0) { ?>
<ul class="container">
	<?php foreach ($groups as $group) { ?>
	<li>
		<a href="<?php echo base_url('frontend/group/').'/'.$group->getId()?>"><?php echo $group->getName();?></a>
		<?php 
		echo anchor('frontend/add_permission/'.$group->getId(), 'Add new Permission', 'class="btn btn-xs-2 btn-success"');
		echo "&nbsp";	
		echo anchor('frontend/assign_permisisons_to_group/'.$group->getId(), 'Assign Permission', 'class="btn btn-xs-2 btn-success"');
		if(count($group->getPermissions())>0) { ?>
		<ul style="margin-left:50px;">
			Permissoins
			<?php
			foreach ($group->getPermissions() as $p) {
				?>			
				<li><a href=""><?php echo $p->getName()?></a></li>
				<?php
			} 
			?>
		</ul>
		<?php }
		?>
	</li>
	<?php } ?>
</ul>
<hr>
<?php } else {?>
<p>no data</p>
<?php } ?>
<?php echo anchor('frontend/add_group/', 'Add Group', 'class="btn btn-success"'); ?>
