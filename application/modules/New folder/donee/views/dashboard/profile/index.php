<?php $group=get_group(array('id'=>$user['group_id']));?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>User's Profile : <b><?php echo $user['username']?></b></h4>
    </div>  
    <form action="" method="POST" role="form">
        <div class="panel-body">
            <p class="bg bg-danger">                        
                <?=$group['name']==group_m::FACEBOOK_USER?'To change your details at our library, Please login to your facebook account':''?>
            </p>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="tamangastha@gmail.com"
                value=<?php echo set_value('email',$user['email']);?>
                <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Astha"
                value=<?php echo set_value('first_name',$user['first_name']);?>
                <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Tamnag"
                value=<?php echo set_value('last_name',$user['last_name']);?>
                <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Submit"
            <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
        </form>
    </div>
</div>    

