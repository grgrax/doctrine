<?php 
$group=get_group(array('id'=>$user['group_id']));
$bank_details['id']=isset($bank_details['id'])?$bank_details['id']:'';
$bank_details['bsb']=isset($bank_details['bsb'])?$bank_details['bsb']:'';
$bank_details['bank_name']=isset($bank_details['bank_name'])?$bank_details['bank_name']:'';
$bank_details['acc_no']=isset($bank_details['acc_no'])?$bank_details['acc_no']:'';
$bank_details['acc_holder_name']=isset($bank_details['acc_holder_name'])?$bank_details['acc_holder_name']:'';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4>User's Bank Details</h4>
    </div>  
    <form action="" method="POST" role="form">
        <div class="panel-body">
            <div class="form-group">
                <label for="text">Bank Information</label>
                <span class="form-control disabled"># 
                    <?php echo $bank_details['id']?$bank_details['id']:'N/A'; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="hidden" name="bank_id" value="<?php echo set_value('bank_id',$bank_details['id']) ?>">
                <label for="text">BSB</label>
                <input name="bsb" type="text" class="form-control" placeholder="BSB here"
                value="<?php echo set_value('bsb',$bank_details['bsb']) ?>">
            </div>
            <div class="form-group">
                <label for="text">Bank</label>
                <input name="bank" type="text" class="form-control" placeholder="Bank here"
                value="<?php echo set_value('bank',$bank_details['bank_name']) ?>">
            </div>
            <div class="form-group">
                <label for="text">Account Number</label>
                <input name="account_number" type="text" class="form-control" placeholder="Account Number here"
                value="<?php echo set_value('account_number',$bank_details['acc_no']) ?>">
            </div>
            <div class="form-group">
                <label for="text">Account Holder Name</label>
                <input name="account_holder_name" type="text" class="form-control" placeholder="Account holder name here"
                value="<?php echo set_value('account_holder_name',$bank_details['acc_holder_name']) ?>">
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" name="submit" class="btn btn-success" value="Submit"
            <?=$group['name']==group_m::FACEBOOK_USER?'disabled':''?>>
            <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
        </form>
    </div>
</div>    

