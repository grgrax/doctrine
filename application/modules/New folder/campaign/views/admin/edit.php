

<div class="panel panel-default">
  <div class="panel-heading">Edit Details</div>
</div>

<div class="tab-base">
  <form method="post" action="" enctype="multipart/form-data" novalidate="novalidate" id="validate_form">
    <!--Nav Tabs-->
    <ul class="nav nav-tabs">
      <li class="active">
        <a data-toggle="tab" href="#demo-lft-tab-1" aria-expanded="false">Content</a>
      </li>
      <li class="">
        <a data-toggle="tab" href="#demo-lft-tab-2" aria-expanded="false">Amount & Time</a>
      </li>
      <li>
        <a data-toggle="tab" href="#demo-lft-tab-3" aria-expanded="true">Photos & Videos</a>
      </li>
      <li class="">
        <a data-toggle="tab" href="#demo-lft-tab-4" aria-expanded="false">Links</a>
      </li>
      <li class="">
        <a data-toggle="tab" href="#demo-lft-tab-5" aria-expanded="false">Donations</a>
      </li>
    </ul>
    <!--Tabs Content-->
    <div class="tab-content">
      <div id="demo-lft-tab-1" class="tab-pane fade active in">
        <div class="form-group">
          <label for="campaign_title">Campaign Title</label>
          <input required name="campaign_title" type="text" class="form-control" id="campaign_title" 
          placeholder="Campaign title here"
          value="<?php echo set_value('campaign_title',$row['campaign_title']) ?>">
        </div>
        <div class="form-group">
          <label for="category">Fundraiser Category</label>
          <select required name="categories" id="categories" class="form-control" >
            <?php foreach (fund_categories() as $category) { ?>
            <option <?php echo $category['id']==$row['fund_category_id']?'selected':'';?> value="<?=$category['id']?>"><?=$category['name']?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="donee"><b>Donee</b></label>
          <select required name="donee" id="donee" class="form-control">
            <?php foreach (get_donees(1) as $donee) { ?>
            <option <?php echo $donee['id']==$row['user_id']?'selected':'';?> value="<?=$donee['id']?>"><?=$donee['first_name']." ".$donee['last_name']?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
          <label for="description">About your Fundraiser</label>
          <textarea required name="description" class="form-control textarea" id="description"
          placeholder="About your Fundraiser here"><?php echo set_value('description',$row['description']); ?></textarea>
        </div>

        <div class="panel panel-default">
          <div class="panel-footer">
            <input type="submit" name="add_content" value="Update" class="btn btn-success">
            <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
          </div>
        </div>
      </div>
      <div id="demo-lft-tab-2" class="tab-pane fade">
        <div class="form-group">
          <label class="control-label">Target Amount</label>
          <div class="controls">
            <input required type="number" name="target_amount" id="target_amount" data-required="1" class="form-control"
            value="<?php echo set_value('target_amount',$row['target_amount']) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Starting Date</label>
          <div class="controls">
            <input required type="text" name="starting_at" id="starting_at"  data-required="1" 
            class="form-control" 
            id="from"
            value="<?php echo set_value('starting_at',format($row['starting_at'],'d-m-Y')) ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label">Ending Date</label>
          <div class="controls">
            <input required type="text" name="ending_at" id="ending_at" data-required="1" 
            class="form-control" id="to"
            value="<?php echo set_value('ending_at',format($row['ending_at'],'d-m-Y')) ?>">
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-footer">
            <input type="submit" name="add_amount" value="Update" class="btn btn-success">
            <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
          </div>
        </div>
      </div>
      <div id="demo-lft-tab-3" class="tab-pane fade">
        <div class="container">
          <div class="col-lg-4 add_remove">
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

          <div class="col-lg-8" style="border-left:1px green dotted;padding-left: 79px;padding:0px 0px 20px 35px;"
          >
          <h5>Pictures</h5>
          <?php 
          if($row['pic']!="") { 
            $pics=unserialize($row['pic']);
            if(count($pics)>0) { 
              $chunked_pics=array_chunk($pics,4);
              ?>
              <div class="table-responsive">                
                <table border="0">
                  <tbody>
                    <?php
                    foreach ($chunked_pics as $chunked_pic) { 
                      echo "<tr>";
                      foreach ($chunked_pic as $pic) { 
                        ?>
                        <td>
                          <img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" class="img-gallery thumbnail">
                          <a href="<?=base_url('campaign/admin/remove_picture/').'/'.$row['slug'].'/'.$pic?>" 
                            class="btn btn-xs btn-icon add-tooltip btn-danger fa fa-times delete">
                          </a>
                        </td>
                        <?php 
                      }
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php
          }
          ?>

        </div> 
      </div>
      <hr>
      <div class="panel panel-default">
        <div class="panel-footer">
          <input type="submit" name="add_photos" value="Update" class="btn btn-success">
          <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
        </div>
      </div>
    </div>

    <div id="demo-lft-tab-4" class="tab-pane fade">
      <div class="form-group">
        <label class="control-label" name="url_link">URL Link</label>
        <input required type="text" id="url_link" name="url_link" data-required="1" class="form-control" placeholder="url link here eg. ramesh"
        value="<?php echo set_value('url_link',str_replace('/', '', $row['url_link'])) ?>">
      </div>
      <div class="form-group">
        <label class="control-label">Your URL looks</label>
        <span class="form-control"><?php echo config_item('site_url')?><span id="your_url"><?php echo $row['url_link']?$row['url_link']:'/'?></span></span>

      </b>
    </div>
    <div class="panel panel-default">
      <div class="panel-footer">
        <input type="submit" name="add_links" value="Update" class="btn btn-success">
        <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
      </div>
    </div>
  </div>
  <div id="demo-lft-tab-5" class="tab-pane fade table-responsive">
    <?php 
    $this->load->helper('donation/donation');
    $my_data['donations']=get_donations(array('campaign_id'=>$row['id']));
    $this->load->view("donation/admin/campaign_wise.php",$my_data);
    ?>
  </div>
</div>
</form>
</div>

<script>
  $(function(){

    $('#add_more').click(function(e){
      e.preventDefault();
      var section='<div class="form-group">';
      section+='<input type="file" class="photos" name="photos[]"  style="float:left">';
      section+='<a href="#" class="remove btn btn-danger  btn-xs">Remove</a>';
      section+='</div>';
      $('#add_remove .form-group:last').after(section);
      $('#remove_all').toggle(true);
      console.log(this);
    });

    $('#remove_all').click(function(e){
      e.preventDefault();
      $("#add_remove div.form-group:not(:first)").remove();
      $('#remove_all').toggle(false);
    });

    $( "body" ).on( "click", "a.remove", function(e) {
      e.preventDefault();
      $(this).parent().remove();
      $('#remove_all').toggle($(".photos").length==0?false:true);
    });

    $('#remove_all').toggle($(".photos").length==0?false:true);

    //change tab after submit 
    var tab='<?php echo get_session("tab")?>';
    tab=tab?tab:'tab-1';
    $('.nav-tabs a[href="#demo-lft-' + tab + '"]').tab('show');

    //url 
    $('#url_link').keyup(function() {
      var val = $(this).val();
      val = val.toLowerCase();
      val = val.replace(/[^a-z0-9 ]+/g, '');
      val = val.replace('  ', ' ');
      var url = val.replace(/\s/g, '-') ;
      $('#your_url').html("/"+url);
    });

  });
</script>

<style>
  .thumbnail{
    margin-top: 30px;
    width: 120px !important;
    height: 80px !important;
  }
  table td{
    padding-left:15px;
    padding-right:15px;
  }
  .add_remove input{
    border:none !important;
  }
</style>