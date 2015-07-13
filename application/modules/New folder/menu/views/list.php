<?php 
$CI =& get_instance();
?>
<div class="panel panel-default">
    <div class="panel-heading">Menus</div>
    <div class="panel-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th width="10%">type</th>
                    <th width="20%">name</th>
                    <th>content</th>
                    <th width="5%">status</th>
                    <th>actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($rows && count($rows) > 0) {
                    $str='';
                    echo GenerateTableRowHTML($rows,$link);
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
        <?php if(permission_permit(array('add-menu'))){?>
        <a href="<?= $link ?>add" class="btn btn-primary"/>Add New  </a>
        <?php } ?>
        <?php if(permission_permit(array('add-menu'))){?>
        <a href="<?= $link ?>order" class="btn btn-primary"/>Order menus</a>
        <?php } ?>
        <ul class="pagination">
            <?php  if (!empty($menus)) echo $menus; ?>
        </ul>
    </div>
</div>


<?php 
function GenerateTableRowHTML($rows,$link=null,$child=FALSE,$dashes=0)
{
    global $CI;
    if(count($rows)){
        foreach ($rows as $row) {
            global $inc,$str;
            $str .="<tr>";
            foreach ($row as $column_key => $column_value) {
                # code...
                switch ($column_key) {
                    case 'id':{
                        $str .="<td>";
                        $str .="</td>". PHP_EOL;
                        break;
                    }                    
                    case 'name':{
                        $px=$row['level']*3;
                        $px .=$px."px";
                        $style="padding-left:$px";
                        $str .="<td><p style='".$style."'>";
                        $str .=$row['name'];
                        $str .="</p></td>". PHP_EOL;
                        break;
                    }                    
                    case 'page_type_id':{
                        $str .="<td>";
                        $str .=$CI->page_types_m->read_row($row['page_type_id'])['name'];
                        $str .="</td>";
                        break;
                    }                    
                    case 'category_id':{
                        $str .="<td>";
                        if($row['category_id']){
                            $category=$CI->category_m->read_row($row['category_id']);
                            $str .="Category: ".anchor(base_url('category/edit/'.$category['slug']), $category['name']);
                        }
                    }                    
                    case 'article_id':{
                        if($row['article_id']){
                            $article=$CI->article_m->read_row($row['article_id']);
                            $str .=" Article: ".anchor(base_url('article/edit/'.$article['slug']), $article['name']);
                        }
                        $str .="</td>";
                        break;
                    }                    
                    case 'status':{
                        $str .="<td>";
                        $str .=menu_m::status($row['status']);
                        $str .="</td>". PHP_EOL;
                        $str .="<td>";
                        $alertClass="";
                        $actions=array();
                        switch($row['status']){
                            case menu_m::PENDING:
                            {
                                $alertClass="";
                                if(permission_permit(array('activate-menu'))) 
                                    $actions=array('activate');
                                break;
                            }
                            case menu_m::ACTIVE:
                            {
                                $alertClass="";
                                if(permission_permit(array('block-menu'))) 
                                    $actions[]='block';
                                if(permission_permit(array('delete-menu'))) 
                                    $actions[]='delete';
                                break;
                            }
                            case menu_m::BLOCKED:
                            {
                                $alertClass="warning";
                                if(permission_permit(array('activate-menu'))) 
                                    $actions[]='activate';
                                if(permission_permit(array('delete-menu'))) 
                                    $actions[]='delete';
                                break;
                            }
                            case menu_m::DELETED:
                            {
                                $alertClass="danger";
                                if(permission_permit(array('activate-menu'))) 
                                    $actions=array('activate');
                                break;
                            }
                        }

                        if(permission_permit(array('edit-menu'))) { 
                            $str .=anchor("$link/edit/".$row['slug'], 'Edit', 'attributes');
                        }
                        foreach ($actions as $k=>$action) { 
                            $str .=anchor("$link/$action/".$row['slug'], " / ".$action, 'attributes');
                        }
                        $str .="</td>". PHP_EOL;
                        break;
                    }                    
                }
            }
            $str .="</tr>". PHP_EOL;
            if(isset($row['children']) && count($row['children'])){
                $p=10+5+$dashes;
                $dashes=count($row['children']);
                $str_child ="<tr>";
                $str_child .=GenerateTableRowHTML($row['children'],$link,TRUE,$dashes);               
                $str_child .="</tr>". PHP_EOL;
            }
        }
        return $str;
    }
}
?>