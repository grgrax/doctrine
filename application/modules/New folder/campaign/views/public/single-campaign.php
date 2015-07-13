single campaign
<?php show_pre($campaign) ;
echo $campaign['campaign_title']?$campaign['campaign_title']:'not set'; echo "<br>";
echo $campaign['target_amount']?$campaign['target_amount']:'not set';echo "<br>";
echo $campaign['description']?$campaign['description']:'not set';echo "<br>";
echo $campaign['campaign_title']?$campaign['campaign_title']:'not set';echo "<br>";

$category=get_fund_category($campaign['fund_category_id']);
echo $category['name']?$category['name']:'not set';echo "<br>";


?>
<?php if($campaign['pic']!="") { //echo 'k ho yo' ;?>

<?php 
$pics=unserialize($campaign['pic']); 
//foreach ($pics as $pic) { ?>
<img src="<?php echo is_picture_exists(campaign_m::file_path.$pics[0]);?>" 
width="70" height="186" title=''>
<?php }else { ?>
<img src="<?php echo front_template_path()?>/assets/images/propic.jpg" class="img-responsive" alt="" >
<?php } ?>

<?php 
$donation_amount = get_donation_amount($campaign['id'] );
echo "Total donations = ".count($donations);
//show_pre($donation_amount);
show_pre($donations);
	//$target_percent = $donation_amount/$campaign['target_amount']*100;
?>



<div class="camp-img">


				

				<?php if($campaign['pic']!="") { 
					$pics=unserialize($campaign['pic']); 
				//foreach ($pics as $pic) { ?>
				<img src="<?php echo is_picture_exists(campaign_m::file_path.$pics[0]);?>" title=''>
				<?php }else { ?>
				<img src="<?php echo front_template_path()?>/assets/images/propic.jpg" class="img-responsive" alt="" >
				<?php } ?>
			</div>



			<div id="myCarousel" class="carousel slide carousel-fade">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>
				<!-- 'http://placehold.it/1900x1080&text=Slide One' -->

				<!-- Wrapper for Slides -->
				<div class="carousel-inner">
					<div class="item active">
						<img src="<?php echo front_template_path()?>/assets/images/w1.jpg" alt="OurLibrary"  class="center-block" />
					</div>
					<div class="item">
						<img src="<?php echo front_template_path()?>/assets/images/w2.jpg" alt="OurLibrary"  class="center-block" />
					</div>
					<div class="item">
						<img src="<?php echo front_template_path()?>/assets/images/w3.jpg" alt="OurLibrary"  class="center-block" />
					</div>
				</div>

				<!-- Controls -->
		      <!--   <a class="left carousel-control" href="#myCarousel" data-slide="prev">
		            <span class="icon-prev"></span>
		        </a>
		        <a class="right carousel-control" href="#myCarousel" data-slide="next">
		            <span class="icon-next"></span>
		        </a> -->
	   		</div> <!-- carousel -->