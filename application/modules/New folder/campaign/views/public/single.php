<section class="top">
	<h1 class="title"><?php echo isset($campaign[0]['campaign_title'])?ucfirst($campaign[0]['campaign_title']):'';?></h1>
	<div class="container" id="" style="">
		<!-- Example row of columns -->
		<div class="">
			<div class="col-md-8">
				<div class="camp-banner">
					

					<!-- myCarousel -->
					<div id="myCarousel" class="carousel slide carousel-fade">
						<?php if($campaign['0']['pic']!="") { 
							$pics=unserialize($campaign['0']['pic']); $c = '0'; ?>
							<ol class="carousel-indicators">
								<?php if($pics){
									foreach ($pics as $pic) { ?>
									<li data-target="#myCarousel" data-slide-to="<?php echo $c ?>" <?php echo $c=='0'?'class="active"':''?>></li>
									<?php $c++; 
								}}?>
							</ol>
							<div class="carousel-inner">
								<?php $c='0'; if($pics){ foreach ($pics as $pic) { ?>
								<div class="item <?php if($c=='0') echo "active"?>">
									<img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" title=''  class="center-block" >
								</div>
								<?php $c++; }} else { ?>
								<img src="<?php echo front_template_path()?>/assets/images/propic.jpg" 
								class="img-responsive camp-img" alt="">									
								<?php } ?>
							</div>
							<?php 
						} else {?>
						<img src="<?php echo front_template_path()?>/assets/images/propic.jpg" 
						class="img-responsive camp-img" alt="">														
						<?php } ?>
					</div> 
					<!-- myCarousel -->

				</div> <!-- camp-img -->
			</div> <!-- col-md-8 -->
			<div class="col-md-4" >
				<div class="campaign-sidebox">
					<h1><span class="h1">$<?php echo number_format(get_donation_amount($campaign['0']['id'] ));?></span> <small>of $<?php echo number_format($campaign['0']['target_amount'])?></small></h1>
					<?php $donation_amount = get_donation_amount($campaign['0']['id'] );
					$target_percent = $donation_amount/$campaign['0']['target_amount']*100;
					?>
					<div class="progress">
						<div style="width: <?php echo $target_percent?>%" class="progress-bar progress-bar"><?php //echo $target_percent; ?></div>
					</div>
					<div class="row">
						<?php
						// $date1 =  date_create($campaign['starting_at']);
						// $date2 =  date_create($campaign['ending_at']);
						// $daysleft=date_diff($date1,$date2); 

						$date = $campaign['0']['starting_at'];
						$dt = new DateTime($date);
						$ptime = strtotime($dt->format('Y-m-d'));
						$daysago = time_elapsed_string($ptime );

						$date = $campaign['0']['ending_at'];
						$dt = new DateTime($date);
						$ptime = strtotime($dt->format('Y-m-d'));
						$daysleft = time_left_string($ptime );
						?>
						<div class="pull-left">Raised <?php echo$daysago?></div>
						<div class="pull-right"><?php echo$daysleft?></div>
					</div> <!-- row -->

					<div class="col-centered" style="max-width:600px; margin:40px 0">
						<a class="btn btn-success btn-social btn-large col-5" href="" style="width:100%" >
							<i class="fa fa-check" ></i> Donate Now
						</a>
					</div>
				</div><!-- end of campaign-sidebox -->
			</div> <!-- end of col-md-4 -->


		</div> <!-- background div -->
	</div> <!-- container -->

	<div class="container" style="margin-top:10px">
		<div class="col-md-8">

			<div>
				<div class="camp-cat">
					<div class="row">
						<div class="pull-left">
							<?php $category=get_fund_category($campaign['0']['fund_category_id']); ?>
							<a href="">
								<?php //echo isset($category['glyphicon']) ? 'glyph' : 'pic' ?>
								<?php if(!empty($category['glyphicon'])){ ?>
								<i class="fa <?php echo $category['glyphicon'] ?> fa-fw"></i>
								<?php }elseif($category['image']!="") { 
									$icon=($category['image']); 
									?>
									<img src="<?php echo is_picture_exists(fund_category_m::file_path.$icon);?>" 
									width="14" height="15" title='' >
									<?php } ?>


									&nbsp; <?php echo ucfirst($category['name']) ?>
								</a>
							</div>
							<div class="pull-right">
								<span class="camp-btm-timeStarted">Campaign started at 
									<?php 
									$date = $campaign['0']['starting_at'];
									$dt = new DateTime($date);
									echo $dt->format('Y-m-d');
							//$interval = $dt->diff(new DateTime());
									?>
								</span>
							</div>
						</div>
					</div> <!-- camp-cat -->

					<div style="border-top: 2px solid #129bfe;border-bottom: 2px solid #129bfe; ">
						<h3 style="margin:0.3em">Story</h3>
					</div>
					<div style="background:#fefefe;text-align:justify; font-size:1.1em"><?php echo $campaign['0']['description']?$campaign['0']['description']:'not set'; ?></div>
				</div>
			</div> <!-- col-md-8 -->

			<!-- donations -->
			<div class="col-md-4">
				<div class="campaign-donation-box">
				</div>
			</div> 
			<!-- col-md-4 -->
			<!-- donations -->

		</div> <!-- container -->
	</section>

	<script>
		$(function(){

			var campaign="<?php echo $campaign['0']['id']?>";
			var url="<?php echo base_url('donation/front/index')?>"+'/'+campaign;

			load_doantions(url);

			function load_doantions(url){
				$('.campaign-donation-box').html("Loading ...");
				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'html',
					success: function(data) {
						$('.campaign-donation-box').html(data);
					},
					error: function(xhr,status,error){
						console.log("Error: " + xhr.status + ": " + xhr.statusText);
					}
				});
			}

		});
	</script>


	<style>
		#myCarousel{
			height: 350px;
		}
		.camp-img{
			margin: 0 auto;
			height: 345px;
		}
	</style>


