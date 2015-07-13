<form method="post" action="" enctype="multipart/form-data">
  <div class="panel panel-default">
    <div class="panel-heading">Add New</div>
    <div class="panel-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input name="name" type="text" class="form-control" placeholder="fund category name here"
        value="<?php echo set_value('name') ?>">
      </div>
      <div class="form-group">
        <label for="description">Content</label>
        <textarea name="description" class="form-control" id="ckeditor" 
        placeholder="fund category description here"><?php echo set_value('description'); ?></textarea>
      </div>
      <div class="form-group">
        <label for="image">Image</label>
        <input name="image" type="file" class="form-input">
      </div>
      <div class="form-group">
        <label for="glyphicon">Glyphicon class</label>
        <input name="glyphicon" type="text" class="form-control" placeholder="Glyphicon class here"
        value="<?php echo set_value('glyphicon') ?>">
      </div>
    </div>
    <div class="panel-footer">
      <input type="submit" name="add" value="Add" class="btn btn-success">
      <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
    </div>
  </div>
</form>

