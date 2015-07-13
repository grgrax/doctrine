
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Content</a></li>
  <li><a href="#tab-2" role="tab" data-toggle="tab">Target Amount & Time</a></li>
  <li><a href="#tab-3" role="tab" data-toggle="tab">Photos</a></li>
  <li><a href="#tab-4" role="tab" data-toggle="tab">Url Links</a></li>
  <li><a href="#tab-5" role="tab" data-toggle="tab">Donations</a></li>
</ul>

<form method="post" action="" enctype="multipart/form-data" novalidate="novalidate" id="validate_form">

  <div class="tab-content">    


    <div class="panel panel-default tab-pane tabs-up active" id="tab-1">
      <div class="panel-body">
        <div class="form-group">
          <label for="campaign_title">Campaign Title</label>
          <input required name="campaign_title" type="text" class="form-control" id="campaign_title" 
          placeholder="Campaign title here"
          value="<?php echo set_value('campaign_title',$campaign['campaign_title']) ?>"/>
        </div>
        <div class="form-group">
          <label for="category">Fundraiser Category</label>
          <select required name="categories" id="categories" class="form-control" >
            <?php foreach (fund_categories() as $category) { ?>
            <option <?php echo $category['id']==$campaign['fund_category_id']?'selected':'';?> value="<?=$category['id']?>"><?=$category['name']?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea cols="100" id="description" name="description" class="wysihtml form-control" rows="7"><?php echo set_value('description',$campaign['description']); ?></textarea>

        </div>
        <hr>
        <div class="form-group">
          <input type="submit" name="add_content" value="Update" class="btn btn-success">
          <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
        </div>
      </div>
    </div>

    <div class="panel panel-default tab-pane tabs-up" id="tab-2">
      <div class="panel-body">
        <div class="form-group">
          <label class="control-label">Target Amount</label>
          <div class="controls">
            <input required type="number" name="target_amount" id="target_amount" data-required="1" class="form-control"
            value="<?php echo set_value('target_amount',$campaign['target_amount']) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Starting Date</label>
          <div class="controls">
            <input required type="text" name="starting_at" id="starting_at"  data-required="1" 
            class="form-control" 
            id="from"
            value="<?php echo set_value('starting_at',format($campaign['starting_at'],'d-m-Y')) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Ending Date</label>
          <div class="controls">
            <input required type="text" name="ending_at" id="ending_at" data-required="1" 
            class="form-control" id="to"
            value="<?php echo set_value('ending_at',format($campaign['ending_at'],'d-m-Y')) ?>">
          </div>
        </div>
        <hr>
        <div class="form-group">
          <input type="submit" name="add_amount" value="Update" class="btn btn-success">
          <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
        </div>

      </div>
    </div>

    <div class="panel panel-default tab-pane tabs-up" id="tab-3">
      <div class="panel-body">
        <div class="col-md-4 add_remove">
          <div class="form-group">          
            <p class="text-danger"><i>Max picture size: 2MB.</i></p>
            <br>
            <label for="photo">Photo Upload:</label>
            <a href="#" class="btn btn-success  btn-sm" id="add_more">Add more</a>
            <a href="#" class="btn btn-danger  btn-sm" id="remove_all">Remove all</a>        
          </div>
          <span id="add_remove">
            <div class="form-group"><input id="input-1" type="file" class="file" name="photos[]"></div>
          </span> 
        </div>
        <div class="col-md-8">
          <h5>Pictures</h5>
          <?php 
          if($campaign['pic']!="") { 
            $pics=unserialize($campaign['pic']);
            if(count($pics)>0) { 
              $chunked_pics=array_chunk($pics,4);
              ?>
              <div class="table-responsive">                
                <table border="0">
                  <tbody>
                    <?php
                    foreach ($chunked_pics as $chunked_pic) { ?>
                    <tr>
                      <?php
                      foreach ($chunked_pic as $pic) { ?>
                      <td>
                        <img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" class="img-gallery thumbnail">
                        <a href="<?=base_url("donee/dashboard/remove_picture/{$campaign['slug']}/$pic").'/'.$campaign['slug'].'/'.$pic?>" 
                          class="btn btn-xs btn-icon add-tooltip btn-danger fa fa-times delete">
                        </a>
                      </td>
                      <?php } ?></tr>
                      <?php
                    }
                  }
                  ?></tbody></table>
                </div>
                <?php } ?></div>
              </div>
              <hr>
              <div class="col-md-1"></div>
              <div class="form-group">
                <input type="submit" name="add_photos" value="Update" class="btn btn-success">
                <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
              </div>
            </div>

            <div class="panel panel-default tab-pane tabs-up" id="tab-4">
              <div class="panel-body">
                <div class="form-group">
                  <label class="control-label" name="url_link">URL Link</label>
                  <input required type="text" id="url_link" name="url_link" data-required="1" class="form-control" placeholder="url link here eg. ramesh"
                  value="<?php echo set_value('url_link',str_replace('/', '', $campaign['url_link'])) ?>">
                </div>
                <div class="form-group">
                  <label class="control-label">Your URL looks</label>
                  <span class="form-control"><?php echo config_item('site_url')?><span id="your_url"><?php echo $campaign['url_link']?$campaign['url_link']:'/'?></span></span>
                </div>
                <hr>
                <div class="form-group">
                  <input type="submit" name="add_links" value="Update" class="btn btn-success">
                  <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
                </div>
              </div>
            </div>

            <div class="panel panel-default tab-pane tabs-up" id="tab-5">
              <div class="panel-body">
                <?php
                $this->load->helper('donation/donation');
                $my_data['donations']=get_donations(array('campaign_id'=>$campaign['id']));
                $this->load->view("donation/admin/campaign_wise.php",$my_data);        
                ?>
              </div>
            </div>

          </div>

        </form>    





