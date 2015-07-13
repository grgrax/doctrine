
<?php // print_r($campaign); //echo 'mod-'.($mod); 
echo $campaign[0]['id'] ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3" id="sidebar">
            <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                <li class="active">
                    <a href="index.html"><i class="icon-chevron-right"></i> View / Edit</a>
                </li>
                <li>
                    <a href="<?php echo base_url('donee/dashboard/single/'.$campaign[0]['id'])?>"><i class="icon-chevron-right"></i> Title, Goal, Time frame</a>
                </li>
                <li>
                    <a href="<?php echo base_url('donee/dashboard/single/'.$campaign[0]['id']).'/desc'?>"><i class="icon-chevron-right"></i> Description</a>
                </li>
                <li>
                    <a href="<?php echo base_url('donee/dashboard/single/'.$campaign[0]['id']).'/photos-videos'?>"><i class="icon-chevron-right"></i> Photos and Videos</a>
                </li>
                <li>
                    <a href="tables.html"><i class="icon-chevron-right"></i> Set Link</a>
                </li>
                <li>
                    <a href="buttons.html"><span class="badge badge-success pull-right">731</span> Donations</a>
                </li>
                <li>
                    <a href="editors.html"><span class="badge badge-info pull-right">2,221</span> Comments</a>
                </li>
            </ul>
        </div>
        
        <!--/span-->
        <div class="span9" id="content">
            <?php  foreach ($campaign as $camp) {?>
            <div class="row-fluid">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left"><?php echo $camp['campaign_title']; ?></div>
                        <div class="pull-right"><span class="badge badge-info">View</span>
                        </div>
                    </div>
                    <div class="block-content collapse in">
                        <!-- BEGIN FORM-->
            <form method="POST" id="form_sample_1" class="form-horizontal">
                <fieldset>
                    <?php if($mod==NULL) {?>
                    <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success hide">
                        <button class="close" data-dismiss="alert"></button>
                        Your form validation is successful!
                    </div>
                    <div class="control-group">
                        <label class="control-label">Campaign Title<span class="required">*</span></label>
                        <div class="controls">
                            <input type="text" name="campaign_title" value="<?php echo $camp['campaign_title']; ?>" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Target Amount<span class="required">*</span></label>
                        <div class="controls">
                            <input type="number" name="target_amount" value="<?php echo $camp['target_amount']; ?>" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Category<span class="required">*</span></label>
                        <div class="controls">
                            <select class="span6 m-wrap" name="category">
                             <?php foreach ($categories as $category) {?>
                             <option value="<?php echo $category['id'] ?>" 
                                    <?php if($category['id']==$camp['fund_category_id']) { ?> selected="selected" <?php }?>?>
                                <?php echo $category['name']?>
                            </option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php }else if($mod=='desc') { ?>
                    <div class="control-group">
                        <label class="control-label" for="textarea2">Textarea WYSIWYG</label>
                        <div class="controls">
                            <textarea class="input-xlarge textarea" name="description" placeholder="Enter text ..." style="width: 810px; height: 200px">
                                <?php echo $camp['description'] ?>
                            </textarea>
                        </div>
                    </div>
                    <?php  }elseif($mod=='photos_videos') { ?>
                    <div class="control-group">
                        <label class="control-label" for="fileInput">Photos upload</label>
                        <div class="controls">
                            <input class="input-file uniform_on" name="pic" id="fileInput" type="file">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Video Link</label>
                        <div class="controls">
                            <input type="text" name="video" value="<?php echo $camp['video']; ?>" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>
                    <?php  }elseif($mod=='set-link') { ?>
                    <div class="control-group">
                        <label class="control-label">Url Link</label>
                        <div class="controls">
                            <input type="text" name="url_link" value="<?php echo $camp['url_link']; ?>" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>
                    <?php  }?>    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn">Cancel</button>
                    </div>
                </fieldset>
            </form>
            <!-- END FORM-->

                    </div>
                </div>
                <!-- /block -->
            </div>
           <?php } ?>
        </div>
    </div>
    <hr>
  
</div>