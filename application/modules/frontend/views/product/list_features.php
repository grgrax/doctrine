<?php if(count($products)>0) { ?>
<ul class="container">
	<?php foreach ($products as $product) { ?>
	<li>
		<a href="<?php echo base_url('frontend/product/').'/'.$product->getId()?>">
			<?php echo $product->getName();?>
		</a>--

		<?php 
		echo anchor('frontend/add_feature', 'Add feature', 'class="btn btn-xs-2 btn-success"');
		if(count($product->getFeatures())>0) { ?>
		<ul style="margin-left:50px;">
			Features
			<?php
			foreach ($product->getFeatures() as $feature) {
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
<?php echo anchor('frontend/product_add_n_feature/', 'Add', 'class="btn btn-success"'); ?>
