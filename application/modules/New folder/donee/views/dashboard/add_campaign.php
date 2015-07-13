<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3" id="sidebar">
            <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                <li class="active">
                    <a href="index.html"><i class="icon-chevron-right"></i> View / Edit</a>
                </li>
                <li>
                    <a href="<?php //echo  base_url('donee/dashboard/single/'.$campaign[0]['id'])?>"><i class="icon-chevron-right"></i> Title, Goal, Time frame</a>
                </li>
                <li>
                    <a href="<?php //echo base_url('donee/dashboard/single/'.$campaign[0]['id']).'/desc'?>"><i class="icon-chevron-right"></i> Description</a>
                </li>
                <li>
                    <a href="<?php //echo base_url('donee/dashboard/single/'.$campaign[0]['id']).'/photos-videos'?>"><i class="icon-chevron-right"></i> Photos and Videos</a>
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

            <div class="row-fluid">
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Add new Campaign</div>
                        <div class="pull-right"><!-- <span class="badge badge-info">View</span> -->
                        </div>
                    </div>
                    <div class="block-content collapse in">
                        <!-- BEGIN FORM-->
                        <form method="POST" id="form_sample_1" class="form-horizontal" enctype="multipart/form-data">
                            <fieldset>                                
                                <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                </div>
                                <div class="alert alert-success hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    Your form validation is successful!
                                </div>
                                <?php // if($mod == 'step-1') {?>
                                <div class="control-group">
                                    <label class="control-label">Campaign Title<span class="required">*</span></label>
                                    <div class="controls">
                                        <input type="text" name="campaign_title" value="" data-required="1" class="span6 m-wrap"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Target Amount<span class="required">*</span></label>
                                    <div class="controls">
                                        <input type="number" name="target_amount" value="" data-required="1" class="span6 m-wrap"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Category<span class="required">*</span></label>
                                    <div class="controls">
                                        <select class="span6 m-wrap" name="categories">
                                           <?php foreach ($categories as $category) {?>
                                           <option value="<?php echo $category['id'] ?>" >
                                            <?php echo $category['name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="textarea2">Textarea WYSIWYG</label>
                                <div class="controls">
                                    <textarea class="input-xlarge textarea" name="description" placeholder="Enter text ..." style="width: 810px; height: 200px">

                                    </textarea>
                                </div>
                            </div>


                            <?php //}elseif($mod=='step-2') { ?>
                     <!-- <div class="control-group">
                        <label class="control-label" for="fileInput">Photos upload</label>
                        <div class="controls">
                            <input class="input-file uniform_on" name="pic" id="fileInput" type="file">
                        </div>
                    </div> -->
                    <div class="control-group">
                        <div class="form-group">
                            <label for="photo" class="control-label">Photo Upload:</label>
                            <div class="controls">            
                                <a href="#" class="btn btn-success  btn-sm" id="add_more">Add more</a>
                                <a href="#" class="btn btn-danger  btn-sm" id="remove_all">Remove all</a>  
                            </div>      
                        </div>
                        <span id="add_remove">
                            <div class="form-group">
                                <div class="controls">            
                                    <input id="input-1" type="file" class="file" name="photos[]">
                                </div>
                            </div>
                        </span>
                    </div>


                    <div class="control-group">
                        <label class="control-label">Video Link</label>
                        <div class="controls">
                            <input type="text" name="video" value="" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Url Link</label>
                        <div class="controls">
                            <input type="text" name="url_link" value="" data-required="1" class="span6 m-wrap"/>
                        </div>
                    </div>
                    <?php //} ?>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Proceed</button>
                        <button type="button" class="btn">Cancel</button>
                    </div>
                </fieldset>
            </form>
            <!-- END FORM-->

        </div>
    </div>
    <!-- /block -->
</div>

</div>
</div>
<hr>

</div>

<script>
    $(function(){
        $('#add_more').click(function(e){
            e.preventDefault();
            var section='<div class="form-group">';
            section+='<div class="controls">';
            section+='<input type="file" class="photos" name="photos[]"  style="float:left">';
            section+='<a href="#" class="remove btn btn-danger  btn-xs" style="margin:2px 4px; padding:2px ">Remove</a>';
            section+='</div>';
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
    });
</script>
