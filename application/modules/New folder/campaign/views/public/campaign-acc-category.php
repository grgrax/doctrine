<div class="container" id="">
  <!-- Example row of columns -->
  <div class="row">

   <?php require_once("./application/views/front/includes/categories-list.php"); ?>



   <div class="col-lg-9" >
     <div class="main-sec-cat">
      <div class=""><h3 class="content-title"><?php echo ucfirst($category_name) ?></h3></div>
      <div class="recent-box">
       <?php $c=0;  foreach ($campaigns as $campaign) { $c++ ?>  
       <div class="col-md-4" style="<?php if($c!=3) echo "padding-right: 1em"; ?>"> 
        <div class="box_inner">

         <!-- load first or default pic -->
            <?php 
            if($campaign['pic']!="") { 
              $pics=unserialize($campaign['pic']); 
              if($pics){ 
                ?>            
                <img src="<?php echo is_picture_exists(campaign_m::file_path.$pics[0]);?>" 
                title='' class="img-responsive camp-img">
                <?php 
              }
              else 
              { 
                ?>
                <img src="<?php echo front_template_path()?>/assets/images/propic.jpg" class="img-responsive camp-img" alt="" >
                <?php 
              } 
            } else{ 
              ?>
              <img src="<?php echo front_template_path()?>/assets/images/propic.jpg" class="img-responsive camp-img" alt="" >
              <? 
            } 
            ?>
            <!-- load first or default pic -->




                              <div class="desc">
                               <?php $donation_amount = get_donation_amount($campaign['id'] );
                               $target_percent = $donation_amount/$campaign['target_amount']*100;
                               ?>
                               <div class="progress">
                                <div style="width: <?php echo $target_percent?>%;" class="progress-bar progress-bar"></div>
                              </div>
                              <div class="camp-title">
                                <?php $url = (empty($campaign['url_link']) || $campaign['url_link'] == '/') ? $campaign['slug'] : $campaign['url_link']; ?>
                                <a href="<?php  echo base_url($url)?>"><?php echo ucfirst(substr($campaign['campaign_title'], 0, 52));
                                  echo strlen($campaign['campaign_title']) > 52 ? '...': '';
                                  ?></a>
                                </div>
                                <?php $category=get_fund_category($campaign['fund_category_id']); ?>
                                <div class="camp-cat">
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

                                  <div class="clearfix"></div>
                                  <div class="camp-btm">
                                    <span class="col-sm-6"><span>$<?php echo $campaign['target_amount'] ?></span><br>pledged</span>
                                    <?php
                                    $date1 =  date_create($campaign['starting_at']);
                                    $date2 =  date_create($campaign['ending_at']);
                                    // echo 'd1:'.$date1;
                                    // echo 'd2:'.$date2;
                                    // echo 'diff:'.
                                    $diff=date_diff($date1,$date2); 
                                    ?>
                                    <span class="col-sm-6" style="text-align:right"><span><?php echo $diff->format("%a"); ?></span><br> days left</span>
                                    <!-- <span class="camp-btm-balance">
                                      <span class="currency currency-small"><span>$<?php //echo $campaign['target_amount'] ?></span> 
                                      <em>AUD</em>
                                    </span> -->
                                  </div>
                                  <div class="clearfix"></div>
                                  
                                  <span class="camp-btm-timeLeft"></span>
                                </span>

                           <!--  <div style="background:#ccc">
                              <div class="float:left">asdfas<span class="">$</span></div>
                              <div class="float:right">asdf</div>
                            </div> -->
                          </div> <!-- camp-cat -->
                        </div> <!-- desc -->
                      </div> <!-- box-inner -->
                      <?php  if($c==3) $c=0;} ?>

                    </div><!--end of recent-box-->
                  </div><!-- end of main-sec-cat-->
                </div><!--end of col-->

              </div><!--end of row-->


      </div><!--end of container-->