<div class="panel panel-default">
    <div class="panel-heading">Most campaigns</div>
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="center">s.no</th>
                    <th>fund category name</th>
                    <th>total campaings</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rows && count($rows) > 0) {
                    $c = $offset;
                    foreach ($rows as $row) {
                        $c++; ?>
                        <tr>
                            <td class="center"><?php echo $c?></td>
                            <td>
                                <?php
                                $fund_category=get_fund_category($row['fund_category_id']);
                                echo word_limiter(convert_accented_characters($fund_category['name']), 5);
                                ?>
                            </td>
                            <td><?php echo $row['count'] ?></td>
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
        <?php if(permission_permit(array('add-article'))){?>
        <?php if(isset($category)){?>
        <a href="<?php echo $link."add/category/".$category['slug'];?>" class="btn btn-primary"/>Add New  </a>
        <?php } else{?>
        <a href="<?= $link ?>add" class="btn btn-primary"/>Add New  </a>
        <?php }?>
        <?php } ?>
        <ul class="pagination">
            <?php if (!empty($pages)) echo $pages; ?>
        </ul>
    </div>
</div>



