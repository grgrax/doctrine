<form method="post" action="" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">Add New</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="parent_menu">Parent menu</label>
                <select name="parent_menu" id="input" class="form-control capitalize">
                    <option value="">Select</option>
                    <?php foreach ($rows as $row) {?>
                    <option value="<?php echo $row['id'] ?>"><?php echo $row['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="page_type">Type</label>
                <select name="page_type" id="input" class="form-control capitalize">
                    <?php foreach ($page_types as $page_type) {?>
                    <option value="<?php echo $page_type['id'] ?>"><?php echo $page_type['name']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" placeholder="menu name here"
                value="<?php echo set_value('name') ?>">
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <textarea name="desc" class="form-control tinymce" 
                placeholder="menu desc here"><?php echo set_value('desc'); ?></textarea>
            </div>
        </div>
        <div class="panel-footer">
            <input type="submit" name="add" value="Add" class="btn btn-primary"/>
            <a href="<? echo $link ?>" class="btn btn-default"/>Cancel</a>
        </div>
    </div>
</form>


