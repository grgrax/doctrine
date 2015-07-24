<?php if(count($cats)>0) { ?>
<ul class="container">
	<?php foreach ($cats as $cat) { ?>
	<li>
		<a href="<?php echo base_url('frontend/cat/').'/'.$cat->getId()?>">
			<?php echo $cat->getName();?>
		</a>
		---
		<?php echo $cat->getParent()?$cat->getParent()->getName()."(parent)":'';?>
		---
		<?php 
		echo anchor('frontend/add_category_child/'.$cat->getId(), 'Add child', 'class="btn btn-xs-2 btn-success"');
		if(count($cat->getChilds())>0) { ?>
		<ul style="margin-left:50px;">
			Childs
			<?php
			foreach ($cat->getChilds() as $c) {
				?>			
				<li><a href=""><?php echo $c->getName()?></a></li>
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
<?php echo anchor('frontend/add_category/', 'Add', 'class="btn btn-success"'); ?>

<?php echo anchor('frontend/add_category_with_childs/', 'Add wih childs ', 'class="btn btn-success"'); ?>
