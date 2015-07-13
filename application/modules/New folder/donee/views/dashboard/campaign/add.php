
<div class="panel panel-default multi-form">
  <div class="panel-heading">
    <h4>Campaign Details</h4>
  </div>
  <form method="post" action="" enctype="multipart/form-data" novalidate="novalidate" id="validate_form">
    <div class="panel-body">


      <div class="row">

        <div class="col-md-6">

          <h5>Content</h5>

          <div class="form-group">
            <label for="campaign_title">Campaign Title</label>
            <input required name="campaign_title" type="text" class="form-control" id="campaign_title" 
            placeholder="Campaign title here"
            value="<?php echo set_value('campaign_title') ?>">
          </div>

          <div class="form-group">
            <label for="category">Fundraiser Category</label>
            <select required name="categories" id="categories" class="form-control" >
              <?php 
              foreach (fund_categories() as $category) { ?>
              <option value="<?=$category['id']?>"><?=$category['name']?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <h5>Amount & Time</h5>

          <div class="form-group">
            <label class="control-label">Target Amount</label>
            <div class="controls">
              <input required type="number" name="target_amount" id="target_amount" data-required="1" class="form-control"
              value="<?php echo set_value('target_amount') ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Starting Date</label>
            <div class="controls">
              <input required type="text" name="starting_at" id="starting_at"  data-required="1" 
              class="form-control" 
              value="<?php echo set_value('starting_at') ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label">Ending Date</label>
            <div class="controls">
              <input required type="text" name="ending_at" id="ending_at" data-required="1" 
              class="form-control" 
              value="<?php echo set_value('ending_at') ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="description">Description</label>        
        <textarea required name="description" class="form-control wysihtml" rows="9" id="description"
        placeholder="About your Fundraiser here"><?php echo set_value('description'); ?></textarea>
      </div> 

      <div class="row">

        <div class="col-md-8">
          <h5>Links</h5>
          <div class="form-group">
            <label class="control-label" name="url_link">URL Link</label>
            <input required type="text" id="url_link" name="url_link" data-required="1" class="form-control" placeholder="url link here eg. ramesh"
            value="<?php echo set_value('url_link') ?>">
          </div>
          <div class="form-group">
            <label class="control-label">Your URL looks</label>
            <span class="form-control"><?php echo config_item('site_url')?><span id="your_url">/</span></span>
          </div>          
        </div>

        <div class="col-md-4 add_remove pull-right">
          <h5>Photos</h5>
          <div class="form-group">
            <p class="text-danger"><i>Max picture size: 2MB.</i></p>
            <br>
            <label for="photo">Photo Upload:</label>
            <a href="#" class="btn btn-success  btn-sm" id="add_more">Add more</a>
            <a href="#" class="btn btn-danger  btn-sm" id="remove_all">Remove all</a>        
          </div>
          <span id="add_remove">
            <div class="form-group">
              <input id="input-1" type="file" class="file" name="photos[]">
            </div>
          </span>          
        </div>
      </div>



    </div>  
    <div class="panel-footer">
      <input type="submit" name="add" value="Submit" class="btn btn-success">
      <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
    </div>
  </form>
</div>

