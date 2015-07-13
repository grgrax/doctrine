<!-- <div class="row">
  <div class="col-lg-8">
  </div>
  <div class="col-lg-4">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search Keywords">
      <div class="input-group-btn">
        <div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Filter
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Dropdown link</a></li>
            <li><a href="#">Dropdown link</a></li>
          </ul>
        </div>
        <button type="button" class="btn btn-default">Search</button>
      </div>
    </div>
  </div>
</div>
-->

<hr class="clean">

<span class="pull-right">
  <a href='<?php echo base_url("donee/dashboard/add_campaign")?>' 
    class="btn btn-block btn-success tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create Campaign"><i class="fa fa-plus"></i></a>
  </span>

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
      <a href="#all" role="tab" data-toggle="tab"> <?php echo $total?>  Campaigns <span class="badge bg-success"></span></a>    
    </li>
  </ul>

<?php /*
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#all" role="tab" data-toggle="tab"> All <span class="badge bg-success">8</span></a></li>
  <li role="presentation"><a href="#active" role="tab" data-toggle="tab">Active <span class="badge bg-purple">5</span></a></li>
  <li role="presentation"><a href="#finished" role="tab" data-toggle="tab">Finished <span class="badge">8</span></a></li>
  <li role="presentation"><a href="#blocked" role="tab" data-toggle="tab">Blocked <span class="badge">10</span></a></li>
  <li role="presentation"><a href="#pending" role="tab" data-toggle="tab">Pending <span class="badge">8</span></a></li>
</ul>
<!-- Nav tabs -->
*/ ?>


<!-- Tab panes -->
<div class="tab-content">


  <div role="tabpanel" class="panel panel-default tab-pane tabs-up active" id="active">
    <div class="panel-body">
      <?php 
      $c=0;
      foreach ($campaigns as $campaign) { 
        $c++;
        $donation_amount = get_donation_amount($campaign['id'] );
        $target_percent = $donation_amount/$campaign['target_amount']*100;                
        ?>
        <div class="<?php echo $campaign['status']==campaign_m::BLOCKED?'blocked':''?>">          
          <span class="pull-right">
            <a href='<?php echo base_url("donee/dashboard/campaign/{$campaign['slug']}")?>' class="btn btn-info tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i></a>
            <!-- <a href='<?php echo base_url("donee/campaign/delete/{$campaign['slug']}")?>' class="delete btn btn-danger tooltip-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i></a> -->

          </span>
          <h4 class="text-blue"><?php echo $campaign['campaign_title'];?></h4>
          <div class="row">
            <div class="col-md-3">
              <?php //carousel()?>
              <?php if($campaign['pic']!="") {  ?>              
              <!-- carousel -->
              <div id="carousel-example-generic-<?php echo $campaign['id'];?>" class="carousel slide" data-ride="carousel">
                <?php $pics=unserialize($campaign['pic']); $c=0; ?>                
                <!-- indicators -->
                <ol class="carousel-indicators">
                  <?php
                  foreach ($pics as $pic) { 
                    if(is_picture_exists(campaign_m::file_path.$pic)){ 
                      ?>
                      <li data-target="#carousel-example-generic-<?php echo $campaign['id'];?>" data-slide-to="<?php echo $c?>" class="<?php echo $c==0?'active':''?>"></li>
                      <?php 
                      $c++; 
                    } 
                  }
                  ?>
                </ol>
                <!-- indicators -->
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php
                  $c=0;
                  foreach ($pics as $pic) { 
                    if(is_picture_exists(campaign_m::file_path.$pic)){ 
                      ?>
                      <div class="item <?php echo $c==0?'active':''?>">
                        <img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" 
                        class="img-responsive" width="260" height="140" title=<?php echo $pic?$pic:''?>>
                      </div>
                      <?php 
                      $c++; 
                    } 
                  }
                  ?>
                </div>
                <!-- Wrapper for slides -->

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic-<?php echo $campaign['id'];?>" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic-<?php echo $campaign['id'];?>" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
                <!-- Controls -->                
              </div>
              <!-- carousel -->
              <?php 
            }
            ?>
          </div>

          <div class="col-md-9">
            <?php echo my_word_limiter($campaign['description'],100);?>
            <?php $percent=$target_percent<100?number_format($target_percent):'100';?><br>
            <br>
            <div class="col-md-6"><ul>
              <li><label for="starting_at">Starting at:</label> <?php echo $campaign['starting_at']?></li>
              <li><label for="ending_at">Ending at:</label> <?php echo $campaign['ending_at']?></li>
              <li><label for="created_at">Created at:</label> <?php echo format($campaign['created_at'])?></li>
            </ul></div>
            <div class="col-md-6">
              <ul>
                <li><label for="starting_at">Percent: </label> <?php echo $percent?> %</li>
                <li><label for="ending_at">Amount: $</label> <?php echo $campaign['target_amount']?>                                
                </li>
                <li><label for="created_at">Raised: $</label> 
                  <?php 
                  $donation_amount = get_donation_amount($campaign['id']);
                  echo $donation_amount ? $donation_amount :' 0';
                  ?>
                </li>
                <?php if($campaign['status']==campaign_m::BLOCKED) { ?>
                <li><label class="col-md-5 bg-warning padd-sm text-white text-center">BLOCKED</label></li>
                <?php } ?>
              </ul>
            </div>

          </div>
        </div>
        <br>
        <hr>
      </div>

      <?php } ?>
    </div>
  </div>

</div>
<!-- Tab panes -->

<nav>
  <ul class="pagination">
   <?php if (!empty($pages)) echo $pages; ?>
 </ul>
</nav>

<style>
  .item img{
    width: 300px !important;
    height: 180px !important;
  }
  .blocked, .blocked h4{
    color: red !important;
  }
</style>