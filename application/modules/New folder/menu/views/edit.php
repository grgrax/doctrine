<form method="post" action="" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">Edit Details</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="parent_menu">Parent menu</label>
                <select name="parent_menu" id="input" class="form-control capitalize">
                    <option value="0">Select</option>
                    <?php foreach ($rows as $menu) {?>
                    <option value="<?php echo $menu['id'] ?>"
                        <?php echo $menu['id']==$row['parent_id']?'selected':'';?>>
                        <?php echo $menu['name']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="page_type">Type</label>
                    <select name="page_type" id="input" class="form-control capitalize">
                        <option value="">Select</option>
                        <?php foreach ($page_types as $page_type) {?>
                        <option value="<?php echo $page_type['id'] ?>"                     
                            <?php echo $page_type['id']==$row['page_type_id']?'selected':'';?>>
                            <?php echo $page_type['name']?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="input" class="form-control capitalize">
                        <option value="0">Select</option>
                        <?php foreach ($categories as $category) {?>
                        <option value="<?php echo $category['id'] ?>"
                            <?php echo $category['id']==$row['category_id']?'selected':'';?>>
                            <?php echo $category['name']?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="article">Article</label>
                    <select name="article" id="input" class="form-control capitalize">
                        <option value="">Select</option>
                        <?php foreach ($articles as $article) {?>
                        <option value="<?php echo $article['id'] ?>"                     
                        <?php if(isset($row['article_id'])) { ?>
                            <?php echo $article['id']==$row['article_id']?'selected':'';?>
                        <?php } ?>  
                            >                              
                            <?php echo $article['name']?>
                        </option>
                        <?php } ?>
                    </select>
                </div>                <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="input" class="form-control">
                    <option value="">Select</option>
                    <?php foreach ($actions as $k => $v) {if($row['status']!=$menu_m::PENDING && $k==$menu_m::PENDING) continue?>
                        <option value="<?php echo $k ?>" <?php echo $k==$row['status']?'selected':'';?>><?php echo $v ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" class="form-control"
                    placeholder="menu name here" value="<?php echo set_value('name', $row['name']); ?>"/>
                </div>
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea name="desc" class="form-control tinymice"
                    placeholder="menu Description here"><?php echo set_value('desc', $row['desc']); ?></textarea>
                </div>
            </div>
            <div class="panel-footer">
                <input type="submit" name="update" value="Edit" class="btn btn-primary"/>
                <a href="<?= $link ?>" class="btn btn-default"/>Cancel</a>
            </div>
        </div>
    </form>


