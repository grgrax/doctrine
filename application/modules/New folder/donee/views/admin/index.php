<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        Donees
        <span class="badge badge-info"><?=$total?></span>
        <span class="pull-right">
            <?php if(permission_permit(array('add-category'))){?>
            <span class="col-lg-3">
                <a href="<?= $link ?>add" class="btn btn-primary btn-labeled fa fa-plus"/>Add New  </a>
            </span>
            <?php } ?>
        </span>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th class="center">s.no</th>
                    <th width="20%">name</th>
                    <th width="15%">status</th>
                    <th width="15%">fund category name</th>
                    <th width="10%">Amount (AUD) </th>
                    <th width="15%">Pictures</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($rows && count($rows) > 0) {
                    $c = $offset;
                    foreach ($rows as $row) {
                        $c++;
                        $alertClass="";
                        $actions=array();
                        switch($row['status']){
                            case campaign_m::PENDING:
                            {
                                $alertClass="warning";
                                if(permission_permit(array('activate-category'))) 
                                    $actions=array('publish');
                                break;
                            }
                            case campaign_m::ACTIVE:
                            {
                                $alertClass="";
                                if(permission_permit(array('block-category'))) 
                                    $actions[]='unpublish';
                                if(permission_permit(array('delete-category'))) 
                                    $actions[]='delete';
                                break;
                            }
                        }
                        $donation_amount = get_donation_amount($row['id'] );
                        $target_percent = $donation_amount/$row['target_amount']*100;
                        ?>
                        <tr class="<?php echo $alertClass?>">
                            <td class="center"><?php echo $c?></td>
                            <td>
                                <a href="<?= $link ?>edit/<?= $row['slug'] ?>"/><?= word_limiter(convert_accented_characters($row['campaign_title']), 5) ?>
                                </a>
                                <hr>
                                <?php
                                echo "Starting at: ";
                                echo "<label><b>".$row['starting_at']."</b></label>";
                                echo "<br/>Ending at</label>: ";
                                echo "<label><b>".$row['ending_at']."</b></label>";
                                echo "<hr/><label><b>".days_left($row['ending_at'])."</b></label>";                            
                                $user=get_user($row['user_id']);
                                echo "<hr/><label>Donee</label>: ";
                                echo "<b>".$user['username']."</b>";
                                ?>                         
                            </td>
                            <td class="center">
                                <?php 
                                if($row['status']==campaign_m::PENDING)
                                    echo "pending";
                                elseif($row['status']==campaign_m::ACTIVE)
                                    echo "active";
                                elseif($row['status']==campaign_m::SUCCESS)
                                    echo "success";
                                elseif($row['status']==campaign_m::FAIL)
                                    echo "failed";
                                elseif($row['status']==campaign_m::BLOCKED)
                                    echo "Blocked";
                                $percent=$target_percent<100?number_format($target_percent):'100';
                                ?>
                                <div class="progress progress-lg">
                                    <div style="width: <?=$percent?>%;" class="progress-bar progress-bar-success">
                                        <?=$percent?>%
                                    </div>
                                </div>

                            </td>
                            <td>
                                <?php
                                $fund_category=get_fund_category($row['fund_category_id']);
                                echo word_limiter(convert_accented_characters($fund_category['name']), 5);
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo "$ ".$donation_amount = get_donation_amount($row['id'] );
                                echo " of ";
                                echo "$ ".$row['target_amount'];
                                ?>
                            </td>
                            <td>
                                <div id="carousel-example-generic-<?php echo $row['id']?>" class="carousel slide col-lg-12">
                                    <?php if($row['pic']!="") {
                                        $pics=unserialize($row['pic']);
                                        if(count($pics)>0){ ?>
                                        <ol class="carousel-indicators">
                                            <?php foreach ($pics as $key=>$pic) { 
                                                if(is_picture_exists(campaign_m::file_path.$pic)){ ?>
                                                <li data-target="#carousel-example-generic-<?php echo $row['id']?>" data-slide-to="<?php echo $key?>" <?php echo ($key==1)?'class="active"':'';?>></li>
                                                <?php } 
                                            } ?>
                                        </ol>
                                        <?php } 
                                    } ?>
                                    <div class="carousel-inner">
                                        <?php if($row['pic']!="") {
                                            $pics=unserialize($row['pic']);
                                            if(count($pics)>0){ 
                                                foreach ($pics as $key=>$pic) { 
                                                    if(is_picture_exists(campaign_m::file_path.$pic)){ ?>
                                                    <div class="item <?php echo ($key==1)?"active":'';?>">
                                                        <img alt="" src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>">
                                                    </div>                                                        
                                                    <?php } 
                                                } 
                                            } 
                                        } ?>
                                    </div>
                                </div>
                            </td>  
                            <td>
                                <?php if(is_default($row['slug'])) continue; ?>
                                <?php if(permission_permit(array('edit-category'))) { ?>
                                <a class="btn btn-sm btn-default btn-icon btn-hover-success add-tooltip fa fa-pencil" 
                                data-toggle="tooltip" 
                                href="<?= $link ?>edit/<?= $row['slug'] ?>" 
                                data-original-title="Edit" 
                                ></a>
                                <?php } ?>
                                <?php foreach ($actions as $k=>$action) { 
                                    switch ($action) {
                                        case 'publish':
                                        $class='btn-success fa fa-check';
                                        break;
                                        case 'unpublish':
                                        $class='btn-warning fa fa-warning';
                                        break;
                                        case 'delete':
                                        $class='btn-danger fa fa-times delete';
                                        break;
                                    }
                                    ?>
                                    <a href="<?= $link.$action.'/'.$row['slug'] ?>" class="btn btn-sm btn-icon add-tooltip <?=$class?>" 
                                        data-toggle="tooltip" 
                                        data-original-title="<?=ucfirst($action)?>"
                                        data-container="body"/></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7" class="td_no_data">No data</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <ul class="pagination">
                    <?php if (!empty($pages)) echo $pages; ?>
                </ul>
            </div>
        </div>

