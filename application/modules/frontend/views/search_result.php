<br>
<div class="container" style="margin-top:20px">
<h2>
<?php  echo (!empty($search_campaigns) ? 'Search Result found' : 'No such result found'); ?>
</h2><br>
<?php foreach ($search_campaigns as $campaign) { 
	?>
<?php $url = (empty($campaign['url_link']) || $campaign['url_link'] == '/') ? $campaign['slug'] : $campaign['url_link']; ?>
<h4><a href="<?php  echo base_url($url)?>"><?php echo $campaign['campaign_title'];?></a></h4>
<?php } ?>
</div>