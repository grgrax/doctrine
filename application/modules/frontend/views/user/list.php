<?php if(count($users)>0) { ?>
<ul class="container">
	<?php foreach ($users as $user) { ?>
	<li>
		<a href="<?php echo base_url('frontend/user/').'/'.$user->getId()?>">
			<?php echo $user->getUsername();?>
		</a>
	
		<?php 
		echo anchor('frontend/add_phone', 'Add Phone No', 'class="btn btn-xs-2 btn-success"');
		if(count($user->getPhonenos())>0) { ?>
		<ul style="margin-left:50px;">
			phones
			<?php
			foreach ($user->getPhonenos() as $phone) {
				?>			
				<li><a href=""><?php echo $phone->getNumber()?></a></li>
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
<?php echo anchor('frontend/user_add_n_phone/', 'Add', 'class="btn btn-success"'); ?>
