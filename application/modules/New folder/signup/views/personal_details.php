<div class="row">
  <form method="post" action="" enctype="multipart/form-data" id="msform" novalidate>
    <!-- progressbar -->
    <ul id="progressbar">
      <li>Create Account</li>
      <li>Start you Campaign</li>
      <li class="active">Fundraiser Personal Details</li>
    </ul>

    <fieldset>
      <h2 class="fs-title">Fundraiser Personal Details</h2>

      <h5 style="color:#129bfe;">Hi ! <?php echo $donee['first_name'].' '.$donee['last_name'] ?></h5><hr>
      
      <div class="col-md-6" >
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
      </div>

      <div class="col-md-6">
        <div class="form-group">

          <label for="description">or youtube/video link :</label>
          <input type="text" class="form-control" id="video_link" name="video"
          value="<?php echo set_value('postcode')?>">        
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="doc">Proof of ID:</label>
          <input id="input-2" type="file" class="file" name="document"
          value="<?php echo set_value('postcode')?>">        

        </div>
      </div>
     <!--  <div class="col-md-6">
        <div class="form-group">

          <label for="description">Time Frame :</label>
          <input type="text" class="form-control" id="" name=""
          value="<?php echo set_value('postcode')?>">        
        </div>
      </div> -->
      <h2 class="fs-title">Bank Details  (Not required)</h2>
      <div class="col-md-6">
        <div class="form-group">
          <label for="bsb">BSB:</label>
          <input type="text" class="form-control" id="bsb" name="bsb" value="<?php echo set_value('postcode')?>">        
          

        </div>
        <div class="form-group">
          <label for="photo">BANK:</label>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">

          <label for="acc_no">Account no :</label>
          <input type="text" class="form-control" id="acc_no" name="acc_no">
        </div>
        <div class="form-group">

          <label for="acc_holder_name">Account holdername :</label>
          <input type="text" class="form-control" id="acc_holder_name" name="acc_holder_name">
        </div>
      </div>
      <div class="form-group">

        <label for="description">Term and Condition:</label>
        <input type="text" class="form-control" id="fundraiser_description" value="Contain will be provided">
      </div>


      <div class="checkbox">
        <label><input required type="checkbox" name="checkagree" value="1">I Agree</label>
      </div>

      <input type="submit" class="submit action-button" value="Finish" name="submit">

    </form>
  </div>
  <script>
    $("form").validate();

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

