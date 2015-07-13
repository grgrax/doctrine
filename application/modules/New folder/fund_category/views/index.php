<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        Fund Categories
        <span class="badge badge-info"><?=$total?></span>
        <span class="pull-right">
            <?php if(permission_permit(array('add-fund-category'))){?>
            <span class="col-lg-3">
                <a href="<?= $link ?>add" class="btn btn-primary btn-labeled fa fa-plus"/>Add New  </a>
            </span>
            <?php } ?>
        </span>
    </div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="center">s.no</th>
                    <th>name</th>
                    <th>campaigns</th>
                    <th>total</th>
                    <th>status</th>
                    <th>image/glyphicon</th>
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
                            case $fund_category_m::UNPUBLISHED:
                            {
                                $alertClass="warning";
                                if(permission_permit(array('activate-fund-category'))) 
                                    $actions=array('publish');
                                break;
                            }
                            case $fund_category_m::PUBLISHED:
                            {
                                $alertClass="";
                                if(permission_permit(array('block-fund-category'))) 
                                    $actions[]='unpublish';
                                if(permission_permit(array('delete-fund-category'))) 
                                    $actions[]='delete';
                                break;
                            }
                        }
                        ?>
                        <tr class="<?php echo $alertClass?>">
                            <td class="center"><?php echo $c?></td>
                            <td>
                                <a href="<?= $link ?>edit/<?= $row['slug'] ?>"/><?= word_limiter(convert_accented_characters($row['name']), 5) ?></a>
                            </td>
                            <td>
                                <?php
                                $total=0;
                                $title="Pending";
                                $badge="";
                                $attributes=array(
                                    'class'=>"badge $badge add-tooltip", 
                                    'data-toggle'=>"tooltip",
                                    'href'=>"#",
                                    'data-original-title'=>$title
                                    );                            
                                $pendings=count_fund_category_campaigns_as_per_status($row['id'],campaign_m::PENDING);
                                if($pendings['total']>0){
                                    $total+=$pendings['total'];
                                    echo anchor('#',$pendings['total'],$attributes);                                    
                                }
                                $active=count_fund_category_campaigns_as_per_status($row['id'],campaign_m::ACTIVE);
                                if($active['total']>0){
                                    $total+=$active['total'];
                                    $title="Active";
                                    $badge="badge-info";
                                    $attributes=array(
                                        'class'=>"badge $badge add-tooltip", 
                                        'data-toggle'=>"tooltip",
                                        'href'=>"#",
                                        'data-original-title'=>$title
                                        );                            
                                    echo anchor('#',$active['total'],$attributes);                                    
                                }
                                $blocked=count_fund_category_campaigns_as_per_status($row['id'],campaign_m::BLOCKED);
                                if($blocked['total']>0){
                                    $total+=$blocked['total'];
                                    $title="Blocked";
                                    $badge="badge-danger";
                                    $attributes=array(
                                        'class'=>"badge $badge add-tooltip", 
                                        'data-toggle'=>"tooltip",
                                        'href'=>"#",
                                        'data-original-title'=>$title
                                        );                            
                                    echo anchor('#',$blocked['total'],$attributes);                                    
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if($total>0) {
                                    $title="Total";
                                    $badge="badge-primary";
                                    $attributes=array(
                                        'class'=>"badge $badge add-tooltip", 
                                        'data-toggle'=>"tooltip",
                                        'href'=>"#",
                                        'data-original-title'=>$title
                                        );                            
                                    echo anchor('#',$total, $attributes); 
                                }
                                ?>
                            </td>
                            <td>
                                <?php 
                                if($row['status']==fund_category_m::PUBLISHED){
                                    $class='success'; 
                                    $status='Active';                                  
                                }
                                else{                                
                                    $class='danger';
                                    $status='Blocked';                                  
                                }
                                ?>
                                <span class="label label-table label-<?=$class?>"><?=$status?></span>
                            </td>
                            <td>
                                <?php if($row['image']!="") { ?>
                                <img src="<?php echo is_picture_exists(fund_category_m::file_path.$row['image']);?>" 
                                class="img-responsive" width="70" height="30" title=<?php echo $row['image']?$row['image']:''?>>
                                <?php } ?>
                            </td>                            
                            <td>
                                <?php if(is_default($row['slug'])) continue; ?>
                                <?php if(permission_permit(array('edit-fund-category'))) { ?>
                                <a class="btn btn-sm btn-default btn-icon btn-hover-success add-tooltip fa fa-pencil" 
                                data-toggle="tooltip" 
                                href="<?= $link ?>edit/<?= $row['slug'] ?>" 
                                data-original-title="Edit" ></a>
                                <?php } ?>
                                <?php 
                                foreach ($actions as $k=>$action) 
                                { 
                                    switch ($action) 
                                    {
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
                                    <a href="<?=$link.$action.'/'.$row['slug'] ?>" class="btn btn-sm btn-icon add-tooltip <?=$class?>" 
                                        data-toggle="tooltip" 
                                        data-original-title="<?=ucfirst($action)?>"
                                        data-container="body"/>
                                    </a>
                                    <?php 
                                } 
                                ?>
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

<style>
    .badge{
        margin: 0 5px; 
    }
</style>



