<div class="row">
  <!-- multistep form -->
  <form id="msform" method="post" novalidate>
    <!-- progressbar -->
    <ul id="progressbar">
      <li>Create Account</li>
      <li class="active">Start you Campaign</li>
      <li>Fundraiser Personal Detais</li>
    </ul>

    <fieldset>
      <h2 class="fs-title">Start your Campaign</h2>

      <div class="form-group">
        <label for="title">Fundraiser Title:</label>
        <input required type="text" class="form-control" id="campaign_title" name="campaign_title" placeholder="e.g. Climbing Mount Everest" 
        value="<?php echo set_value('campaign_title')?>">
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="amount">Amount of money you hope to raise:</label>
          <div class="inner-addon left-addon">
            <i class="glyphicon glyphicon-user"></i>
            <input required type="number" class="form-control" id="target_amount" name="target_amount" placeholder="e.g. 100.00"
            value="<?php echo set_value('target_amount')?>">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">

          <label for="categories">Fundraiser Category:</label>
          <select name="categories" class="form-control capitalize" required>
            <option value="">Select</option>
            <?php foreach ($categories as $category) {?>
            <option value="<?php echo $category['id'] ?>"><?php echo $category['name']?></option>
            <?php } ?>

          </select>
        </div>
      </div>


      <div class="col-md-6">
       <div class="form-group">
        <label for="starting_at">Starting Date:</label>
        <input type="text" name="starting_at" value="<?php  echo set_value('starting_at'); ?>" 
        class="form-control" id="starting_at" required/>
      </div>
    </div>
    <div class="col-md-6">

      <div class="form-group">
        <label for="ending_at">Ending Date:</label>
        <input type="text" name="ending_at" value="<?php  echo set_value('ending_at');?>" 
        class="form-control" id="ending_at" required/>
      </div>
    </div>

    <div class="form-group">

      <label for="description">About your Fundraiser:</label>
      <textarea required name="description" class="form-control wysihtml" placeholder="Tell everyone about your fundraiser, why your cause is so important and what you will do with the money you raise. Make it as personal and compelling as possible in case someone actually reads it. "><?php echo set_value('description')?></textarea>
    </div>

    <h2 class="fs-title">Fundraiser Location</h2>
    <div class="form-group">

      <label for="apartment">Unit/Apartment:</label>
      <input required type="text" class="form-control" id="address_unit" name="address_unit"
      value="<?php echo set_value('address_unit')?>">
    </div>
    <div class="form-group">

      <label for="street">Street:</label>
      <input required type="text" class="form-control" id="address_street" name="address_street"
      value="<?php echo set_value('address_street')?>">
    </div>
    <div class="form-group">

      <label for="suburb">Suburb:</label>
      <input required type="text" class="form-control" id="address_suburb" name="address_suburb"
      value="<?php echo set_value('address_suburb')?>">
    </div>
    <div class="form-group">
      <div class="col-md-6">

        <label for="state">State:</label>
        <select  class="form-control" required>
          <option value="1" name="">NSW</option>
          <option value="2" name="">ACT</option>
          <option value="3" name="">NT</option>
          <option value="4" name="">QLD</option>
          <option value="5" name="">SA</option>
          <option value="6" name="">TAS</option>
          <option value="7" name="">VIC</option>
          <option value="8" name="">WA</option>
        </select>
      </div>
      <div class="col-md-6">


        <label for="postcode">Postcode:</label>
        <input required type="text" class="form-control" id="postcode" name="postcode"
        value="<?php echo set_value('postcode')?>">
      </div>
    </div>
    <input type="submit" class="submit action-button" value="Save and Proceed" name="submit">
    <a href="<?php echo base_url()?>" class="btn btn-default">Cancel and goto Home</a>
  </fieldset>
</form>
</div> 
<script>
  $("form").validate();
  $(function(){
    $( "#starting_at" ).datepicker({
      dateFormat: 'dd-mm-yy',
      minDate: new Date(),
      stepMonths: 0,
      onClose: function( selectedDate ) {
        $( "#ending_at" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#ending_at" ).datepicker({
      dateFormat: 'dd-mm-yy',
      numberOfMonths: 2,
      stepMonths: 0,
      onClose: function( selectedDate ) {
        $( "#starting_at" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    $("#starting_at").datepicker('setDate', new Date());
  });
</script>

