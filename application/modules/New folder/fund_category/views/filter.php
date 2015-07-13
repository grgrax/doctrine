<div class="panel panel-default">
    <div class="panel-heading">
        Fund Categories
        <?php if(permission_permit(array('add-category'))){?>
        <a href="<?= $link ?>add" class="btn btn-primary"/>Add New  </a>
        <?php } ?>     
        <?php is_picture_exists(fund_category_m::file_path.'public.png')?>       
    </div>
    <div class="panel-body">
        <h4>Filter by</h4>
        <hr>            
        <form action="" method="GET" role="form">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" id="" placeholder="Fund category name"
                        value="<?php echo isset($filters['name'])? $filters['name'] : '';?>">                                            
                    </div>
                </div>   
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" class="form-control capitalize">
                            <option value="">Select</option>
                            <?php foreach (fund_category_m::status() as $key=>$value) {?>
                                <option value="<?php echo $key?>" 
                                    <?php echo isset($filters['status'])? ($filters['status']==$key?'selected':''): '';?>>
                                    <?php echo $value?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>              
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Filter</button>                
                    </div>
                    <hr>
                </form>


                <table class="table">
                    <thead>
                        <tr>
                            <th class="center">s.no</th>
                            <th>name</th>
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
                                        if(permission_permit(array('activate-category'))) 
                                            $actions=array('publish');
                                        break;
                                    }
                                    case $fund_category_m::PUBLISHED:
                                    {
                                        $alertClass="";
                                        if(permission_permit(array('block-category'))) 
                                            $actions[]='unpublish';
                                        if(permission_permit(array('delete-category'))) 
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
                                        if($row['status']==fund_category_m::UNPUBLISHED)
                                            echo "Unpublished";
                                        elseif($row['status']==fund_category_m::PUBLISHED)
                                            echo "Published";
                                        elseif($row['status']==fund_category_m::DELETED)
                                            echo "Deleted";
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($row['image']!="") { ?>
                                        <img src="<?php echo is_picture_exists(fund_category_m::file_path.$row['image']);?>" 
                                        class="img-responsive" width="70" height="30" title=<?php echo $row['image']?$row['image']:''?>>
                                        <?php } ?>
                                    </td>                            
                                    <td>
                                        <?php if(is_default($row['slug'])) continue; ?>
                                        <?php if(permission_permit(array('edit-category'))) { ?>
                                        <a href="<?= $link ?>edit/<?= $row['slug'] ?>"/>Edit </a>
                                        <?php if(count($actions)>0) echo "/" ?>
                                        <?php } ?>
                                        <?php foreach ($actions as $k=>$action) { ?>
                                        <a href="<?= $link ?><?= $action ?>/<?= $row['slug'] ?>"/> <?php if($k>0) echo "/"; ?> <?php echo $action?> </a>
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



