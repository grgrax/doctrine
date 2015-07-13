<br>
<br>
<br>
<br>

<form method="POST" id="form_sample_1" class="form-horizontal" 
action="<?php echo base_url('donee/campaign/media/'.$campaign['id']);?>"
enctype="multipart/form-data">
  <div class="col-md-6">
    <div class="form-group">
      <label for="photo">Photo Upload:</label>
      <a href="#" class="btn btn-info" id="add_more">Add more</a>
      <a href="#" class="btn btn-info" id="remove_all">Remove all</a>        
    </div>
    <span id="previous">
      <div class="span3">
        <?php if($campaign['pic']!="") { ?>
        <?php 
        $pics=unserialize($campaign['pic']);
        foreach ($pics as $pic) { ?>
        <li>
          <img src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>" 
          class="img-responsive" width="70" height="30" title=<?php echo $pic?$pic:''?>>
          <a href="#">view</a>
          <a href="<?php echo base_url('donee/campaign/remove_media/'.$campaign['id'].'/'.$pic)?>"
          onclick="return confirm('Are you sure you want to proceed?');">remove</a>          
        </li>
        <?php } ?>
        <?php } ?>
      </div>
    </span>
    <span id="add_remove">
      <div class="form-group">
        <input id="input-1" type="file" class="file" name="photos[]">
      </div>
    </span>
  </div>
  <input type="submit" name="submit" value="submit" class="btn btn-info">
</form>

<script>
  $("form").validate();

  $(function(){
    $('#add_more').click(function(e){
      e.preventDefault();
      var section='<div class="form-group">';
      section+='<input type="file" class="photos" name="photos[]">';
      section+='<a href="#" class="remove">remove</a>';
      section+='</div>';
      $('#add_remove .form-group:last').after(section);
      $('#remove_all').toggle(true);
      console.log(this);
    });

    $('#remove_all').click(function(e){
      e.preventDefault();
      $("#add_remove div.form-group:not(:first)").remove();
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
  });
</script>