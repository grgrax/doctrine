<?php if(count($features)>0) { ?>
<ul>
	<?php foreach ($features as $feature) { ?>
	<li>
		<a href="<?php echo base_url('frontend/feature/').'/'.$feature->getId()?>">
			<?php echo $feature->getName();?>
		</a>
		<b><?php echo $feature->getEproduct()?$feature->getEproduct()->getName():''?></b> (Product)
	</li>
	<?php } ?>
</ul>
<hr>
<?php } else {?>
<p>no data</p>
<?php } ?>
<?php echo anchor('frontend/onetomanyfromfeature/', 'Cancel', 'class="btn btn-warning"'); ?>
