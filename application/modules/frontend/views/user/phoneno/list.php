<?php if(count($eproducts)>0) { ?>
<ul class="container">
	<?php foreach ($eproducts as $eproduct) { ?>
	<li>
		<a href="<?php echo base_url('frontend/eproduct/').'/'.$eproduct->getId()?>">
			<?php echo $eproduct->getName();?>
		</a>--

		<?php 
		echo anchor('frontend/add_feature/'.$eproduct->getId(), 'Add feature', 'class="btn btn-xs-2 btn-success"');
		if(count($eproduct->getFeatures())>0) { ?>
		<ul style="margin-left:50px;">
			Features
			<?php
			foreach ($eproduct->getFeatures() as $feature) {
				?>			
				<li><a href=""><?php echo $feature->getName()?></a></li>
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
<?php echo anchor('frontend/add_eproduct/', 'Add', 'class="btn btn-success"'); ?>

<?php echo anchor('frontend/add_eproduct_add_feature/', 'Add features also ', 'class="btn btn-success"'); ?>
