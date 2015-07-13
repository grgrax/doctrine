<div class="row">
  <div class="">
    <!-- multistep form -->
    <form id="msform" action="" method="POST" role="form" class="signupForm" novalidate>
      <!-- progressbar -->
      <ul id="progressbar">
        <li class="active">Create Account</li>
        <li>Start you Campaign</li>
        <li>Fundraiser Personal Detais</li>
      </ul>

      <fieldset>
        <h2 class="fs-title">Create your account</h2>
        <div class="form-group">
          <div class="col-md-3"><label for="name" class="control-label">Gender:</label></div>
          <div class="col-md-9">
            <!-- <div class="col-md-2"> -->
            <select class="titleselect" name="title">
              <option value="mr">Mr</option>
              <option value="mrs">Mrs</option>
            </select>
          </div>

        </div>
        <div class="form-group">
          <div class="col-md-3"><label for="first_name">First Name:</label></div>
          <div class="col-md-9">
            <input required name="first_name" type="text" class="form-control" id="first_name" value="<?php echo set_value('first_name')?>"/>
          </div>
        </div> 
        <div class="form-group">
          <div class="col-md-3"><label for="last_name">Last Name:</label></div>
          <div class="col-md-9">
            <input required name="last_name" type="text" class="form-control" id="last_name" value="<?php echo set_value('last_name')?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3"><label for="username">Username:</label></div>
          <div class="col-md-9">
            <input required name="username" type="text" class="form-control" id="username" value="<?php echo set_value('username')?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3"><label for="email">Email address:</label></div>
          <div class="col-md-9">
            <input required name="email" type="email" class="form-control" id="email" value="<?php echo set_value('email')?>"/>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-3"><label for="confirm_email">Confirm Email:</label></div>
          <div class="col-md-9">
            <input required name="confirm_email" type="email" class="form-control" id="confirm_email" value="<?php echo set_value('confirm_email')?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3"><label for="password">Password:</label></div>
          <div class="col-md-9">
            <input required name="password" type="password" class="form-control" id="password" value="<?php echo set_value('password')?>"/>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-3"><label for="confirm_password">Confirm Password:</label></div>
          <div class="col-md-9">
            <input required name="confirm_password" type="password" class="form-control" id="confirm_password" value="<?php echo set_value('confirm_password')?>"/>
          </div>
        </div>


        <input type="submit" class="submit action-button" value="Sign Up" name="submit">
        <a href="<?php echo base_url()?>" class="btn btn-default">Cancel and goto Home</a>
      </fieldset>


    </form>


  </div> 
</div>

</div>


<script type="text/javascript">
  $().ready(function() {
    $(".signupForm").validate({
      rules: {
        username: {
          minlength: 2
        },
        password: {
          minlength: 5
        },
        confirm_password: {
          minlength: 5,
          equalTo: ".col-md-9 #password"
        },
        email: {
          email: true
        },
      },
      messages: {
        username: {
          minlength: "Your username must consist of at least 2 characters"
        },
        password: {
          minlength: "Your password must be at least 5 characters long"
        },
        confirm_password: {
          minlength: "Your password must be at least 5 characters long",
          equalTo: "Please enter the same password as above"
        },
        email: "Please enter a valid email address",
      }
    });
      // $("form").on('submit', function(e){
      //   e.preventDefault();
      //   // alert('gingo');
      //   console.log('pre');
      // });
});

</script>