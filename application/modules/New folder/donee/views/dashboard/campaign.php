<?php
//echo $tab=$mod;
?>
<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$tab = end($link_array);
?>
<script>
    $(function(){
        var tab='<?php echo $tab ?>';
        $("#"+tab).click();
    });
</script>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-xs-12 col-sm-8 wow fadeInDown">
            <div class="tab-wrap"> 
                <div class="media">
                    <div class="parrent pull-left">
                        <ul class="nav nav-tabs nav-stacked"  id="myTab">
                            <li class="active"><a href="#tab1" data-toggle="tab" class="analistic-01" id="tab-1">Campaign Details</a></li>
                            <li class=""><a href="#tab2" data-toggle="tab" class="analistic-02" id="tab-2">Target Amount and Time</a></li>
                            <li class=""><a href="#tab3" data-toggle="tab" class="tehnical" id="tab-3">Photos and Videos</a></li>
                            <li class=""><a href="#tab4" data-toggle="tab" class="tehnical" id="tab-4">URL Links</a></li>
                            <li class=""><a href="#tab5" data-toggle="tab" class="tehnical" id="tab-5"><span class="badge badge-success pull-right">731</span> Donation</a></li>
                            <li class=""><a href="#tab6" data-toggle="tab" class="tehnical" id="tab-6">Comments</a></li>
                        </ul>
                    </div>

                    <div class="parrent media-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="tab1">
                                <div class="media">
                                    <div class="media-body">
                                        <!-- BEGIN FORM--><span class="badge badge-info pull-right">view</span> 
                                        <form method="POST" id="msform" class="form-horizontal" novalidate>
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="control-label">Campaign Title<span class="required">*</span></label>
                                                    <div class="controls">
                                                        <input type="text" name="campaign_title" value="<?php echo $campaign['campaign_title']; ?>" 
                                                        data-required="1" class="span6 m-wrap" id="campaign_title" required/>
                                                    </div>
                                                    <input type="hidden" name="set_url_link" value="<?php echo $campaign['url_link']; ?>" 
                                                    data-required="1" class="span6 m-wrap" id="<?php if(!empty($campaign['url_link']) && ($campaign['url_link'] == NULL))  echo 'set_url_link' ?>" required/>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Category<span class="required">*</span></label>

                                                    <div class="controls">
                                                        <select class="span6 m-wrap" name="category">
                                                            <?php foreach ($categories as $category) {?>
                                                            <option value="<?php echo $category['id'] ?>"
                                                                <?php if($category['id']==$campaign['fund_category_id']) { ?> selected="selected" <?php }?>?>
                                                                <?php echo $category['name']?>                                            
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="control-group">
                                                    <label class="control-label" for="textarea2">Textarea WYSIWYG</label>
                                                    <div class="controls">
                                                        <textarea class="input-xlarge textarea" name="description" placeholder="Enter text ..." style="width: 810px; height: 200px"><?php echo $campaign['description'] ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-actions" style="background:#eee">
                                                    <input type="submit" class="btn btn-primary" name="title" value="Save Changes" />
                                                    <!-- <button type="button" class="btn">Cancel</button> -->
                                                </div>  
                                            </fieldset>
                                        </form>
                                        <!-- END FORM-->   
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab2">
                                <div class="media">
<!-- <div class="pull-left">
<img class="img-responsive" src="images/tab1.png">
</div> -->
<!-- BEGIN FORM-->
<form action="<?php echo base_url('donee/dashboard/campaign/'.$campaign['id'])?>" method="POST" id="msform" class="form-horizontal">
    <fieldset>
        <div class="media-body">
            <div class="control-group">
                <label class="control-label">Target Amount<span class="required">*</span></label>
                <div class="controls">
                    <input type="number" name="target_amount" value="<?php  echo $campaign['target_amount']; ?>" data-required="1" class="span6 m-wrap"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Starting Date<span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="starting_at" value="<?php  echo $campaign['starting_at']; ?>" data-required="1" class="span6 m-wrap" id="from"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Ending Date<span class="required">*</span></label>
                <div class="controls">
                    <input type="text" name="ending_at" value="<?php  echo $campaign['ending_at']; ?>" data-required="1" class="span6 m-wrap" id="to"/>
                </div>
            </div>
            <div class="form-actions" style="background:#eee">
                <input type="submit" class="btn btn-primary" name="target-amt-time" value="Save changes"/>
                <!-- <button type="button" class="btn">Cancel</button> -->
            </div> 
        </div> 
    </fieldset>
</form>
<!-- END FORM-->    
</div>
</div>
<div class="tab-pane fade" id="tab3">
    <div class="media">
        <span id="previous">
            <div class="pull-left" style="width:62%">
                <?php if($campaign['pic']!="") { ?>
                <?php 
                $pics=unserialize($campaign['pic']);
                if(count($pics)>0){
                    foreach ($pics as $pic) { ?>              
                    <div class="pull-left">
                        <img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" 
                        class="img-responsive" width="200px" height="500px" title=<?php echo $pic?$pic:''?>>
                        <div>
                            <a href="#">view </a>
                            <a href="<?php echo base_url('donee/dashboard/remove_media/'.$campaign['id'].'/'.$pic)?>"
                                onclick="return confirm('Are you sure you want to proceed?');">remove</a>  
                            </div>
                        </div>
                        <?php 
                    }
                }
            } 
            ?>
        </span>
    </div>
    <div class="media-body">
        <form method="POST" id="msform" class="form-horizontal" 
        action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="photo">Photo Upload:</label>
            <a href="#" class="btn btn-success  btn-sm" id="add_more">Add more</a>
            <a href="#" class="btn btn-danger  btn-sm" id="remove_all">Remove all</a>        
        </div>
        <span id="add_remove">
            <div class="form-group">
                <input id="input-1" type="file" class="file" name="photos[]">
            </div>
        </span>
        <br>    
        <br>    
        <input type="submit" name="photos-videos" value="submit" class="btn btn-info">
    </form>



</div>
</div>
<!--  <div class="row">
<div style="float:left; width:62%">
<div class="">
<div >
<div class="">
<img class="img-responsive" src="<?php // echo is_picture_exists(campaign_m::file_path.'app.png');?>" alt="">

</div>
</div>   

<div >
<div class="">
<img class="img-responsive" src="<?php// echo is_picture_exists(campaign_m::file_path.'app.png');?>" alt="">

</div>
</div> 

<div >
<div class="">
<img class="img-responsive" src="<?php // echo is_picture_exists(campaign_m::file_path.'app.png');?>" alt="">

</div>
</div>   

<div >
<div class="">
<img class="img-responsive" src="<?php // echo is_picture_exists(campaign_m::file_path.'app.png');?>" alt="">

</div>
</div>   

<div >
<div class="">
<img class="img-responsive" src="<?php //echo is_picture_exists(campaign_m::file_path.'app.png');?>" alt="">

</div>
</div>   

</div>
<div style="width:35%;float:right">
<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words</p>
</div>
</div> -->
</div>

<div class="tab-pane fade" id="tab4">
    <form action="<?php echo base_url('donee/dashboard/campaign/'.$campaign['id'])?>" method="POST" id="form_sample_1" class="form-horizontal">
        <fieldset>
            <div class="media-body">
                <div class="control-group">
                    <label class="control-label" name="url_link">Edit URL Link</label>
                    <div class="controls">
                        <input type="text" id="url" name="url" value="<?php  echo $campaign['url_link']; ?>" data-required="1" class="span6 m-wrap"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Your URL looks</label>
                    <div class="controls">
                        <input type="text" id="url_link" name="url_link" value="<?php  echo $campaign['url_link']; ?>" data-required="1" class="span6 m-wrap" readonly/>
                    </div>
                </div>
                
                <div class="form-actions" style="background:#eee">
                    <input type="submit" class="btn btn-primary" name="url" value="Save changes"/>
                    
                </div> 
            </fieldset>
        </form></div>

        <div class="tab-pane fade" id="tab5">
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures,</p>
        </div>
        <div class="tab-pane fade" id="tab6">
            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures,</p>
        </div>
    </div> <!--/.tab-content-->  
</div> <!--/.media-body--> 
</div> <!--/.media-->     
</div><!--/.tab-wrap-->               
</div><!--/.col-sm-6-->
</div>
</div>



</div>
</div>
<hr>

</div>
<script>
    $(function() 
// { 
//   $('a[data-toggle="tab"]').on('shown', function () {
//     //save the latest tab; use cookies if you like 'em better:
//     localStorage.setItem('lastTab', $(this).attr('href'));
//    });

//   //go to the latest tab, if it exists:
//   var lastTab = localStorage.getItem('lastTab');
//   if (lastTab) {
//      $('a[href=' + lastTab + ']').tab('show');
//   }
//   else
//   {
//     // Set the first tab if cookie do not exist
//     $('a[data-toggle="tab"]:first').tab('show');
//   }
});
</script>

<script>

    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    var id='<?php echo $id?>';
    id='tab3';
    $('#'+id).click();


    store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
// alert(hash);
$('#myTab a[href="' + hash + '"]').tab('show');

//$('#myTab a')

// $('#myTab > li.active').removeClass('active');
// $('#myTab "' + hash + '"').parent().addClass('active');//active the profile tab
// $('.tab-content .active').removeClass('active in');//hide home content
// $('.tab-content "' + hash + '"').addClass('active in');//show profile content
</script>
<script>
    $(function(){
        $('#add_more').click(function(e){
            e.preventDefault();
            var section='<div class="form-group">';
            section+='<input type="file" class="photos" name="photos[]"  style="float:left">';
            section+='<a href="#" class="remove btn btn-danger  btn-xs" style="margin:2px 4px; padding:2px ">Remove</a>';
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
<script>
    $(function(){
        $( "#msfrom" ).validate();

        $( "#from" ).datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: new Date(),
            stepMonths: 0,
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            dateFormat: 'dd-mm-yy',
            numberOfMonths: 2,
            stepMonths: 0,
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        $("#from").datepicker('setDate', new Date());
// var from_date=$( "#from" ).datepicker("getDate");
// from_date.ssetMonth(1);
// $("#to").datepicker('setDate',from_date);

});
</script>
<script type="text/javascript">
    $(function() {
        $('#campaign_title').keyup(function() {
            var val = $(this).val();
        //$('#page_title,#h1_title').val(val);
        
        val = val.toLowerCase();
        val = val.replace(/[^a-z0-9 ]+/g, '');
        val = val.replace('  ', ' ');
        
        //var url = '/' + val.replace(/\s/g, '-') + '.html';
        var url = '/' + val.replace(/\s/g, '-') ;
        // $('#url').val(url);
        $('#set_url_link').val(url);
    });

        $('#url').keyup(function() {
            var val = $(this).val();
        //$('#page_title,#h1_title').val(val);
        
        val = val.toLowerCase();
        val = val.replace(/[^a-z0-9 ]+/g, '');
        val = val.replace('  ', ' ');
        
        //var url = '/' + val.replace(/\s/g, '-') + '.html';
        var url = '/' + val.replace(/\s/g, '-') ;
        $('#url_link').val(url);
    });
    });
</script>