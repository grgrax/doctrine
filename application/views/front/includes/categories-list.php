<div class="col-lg-3 sidebar-categories">
      <div class=""><h3 class="content-title">Categories</h3></div>
      <div class="list-group">
        <?php  foreach ($fund_categories as $category) {

          ?>

          <a class="list-group-item" href="<?php  echo base_url('campaign_acc_cat/'.$category['slug'])?>">
            <?php //echo isset($category['glyphicon']) ? 'glyph' : 'pic' ?>
            <?php if(!empty($category['glyphicon'])){ ?>
            <i class="fa <?php echo $category['glyphicon'] ?> fa-fw"></i>
            <?php }elseif($category['image']!="") { 
              $icon=($category['image']); 
              ?>
              <img src="<?php echo is_picture_exists(fund_category_m::file_path.$icon);?>" 
              width="25" height="25" title=''>
              <?php } ?>


              &nbsp; <?php echo ucfirst($category['name']) ?> 
              </a>
              <?php } ?>
            </div>
          </div><!--end of category-->