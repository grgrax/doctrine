<div class="row">
  <div class="col-md-8">
    <form method="post">

      <div class="form-group">

        <label for="title">Title:</label>
        <select class="form-control" name="title">
          <option value="mr">Mr</option>
          <option value="mrs">Mrs</option>

        </select>
      </div>

      <div class="form-group">

        <label for="first_name">First Name:</label>
        <input name="first_name" type="text" class="form-control" id="first_name" value="<?php echo set_value('first_name') ?>">
      </div>

      <div class="form-group">

        <label for="last_name">Last Name:</label>
        <input name="last_name" type="text" class="form-control" id="lname" value="<?php echo set_value('last_name')?>"/>
      </div>
      <div class="form-group">

        <label for="email">Username:</label>
        <input name="username" type="text" class="form-control" id="email" value="<?php echo set_value('username')?>"/>
      </div>
      <div class="form-group">

        <label for="email">Email address:</label>
        <input name="email" type="text" class="form-control" id="email" value="<?php echo set_value('email')?>"/>
      </div>
      
      <div class="form-group">

        <label for="confirm_email">Confirm Email address:</label>
        <input name="confirm_email" type="text" class="form-control" id="email" value="<?php echo set_value('confirm_email')?>"/>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input name="password" type="password" class="form-control" id="pwd" value="<?php echo set_value('password')?>"/>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input name="confirm_password" type="password" class="form-control" id="pwd" value="<?php echo set_value('confirm_password')?>"/>
      </div>

      
      <input type="submit" class="btn btn-primary" value="Submit" name="submit">
    </form>


  </div> 
</div>