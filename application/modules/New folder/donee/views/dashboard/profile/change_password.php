<?php $group=get_group(array('id'=>$user['group_id']));?>
<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        <h4>Change Password : <b><?php echo $user['username']?></b></h4>        
    </div>   
    <form action="" method="POST" role="form">
        <div class="panel-body">
            <p class="bg bg-danger">                        
                <?=$group['name']==group_m::FACEBOOK_USER?'To change your details at our library, Please login to your facebook account':''?>
            </p>
            <?if($group['name']!=group_m::FACEBOOK_USER){?>
            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="old password">
            </div> 
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="new password">
            </div> 
            <div class="form-group">
                <label for="confirm_password">Confirm new Password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="confirm new password">
            </div>
            <?php } ?>
        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Submit"
            <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>

        </form>
    </div>
</div>    

