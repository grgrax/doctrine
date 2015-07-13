<form method="post" action="" enctype="multipart/form-data">
  <div class="panel panel-default">
    <div class="panel-heading">Edit details</div>
    <div class="panel-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input name="name" type="text" class="form-control" placeholder="fund category name here"
        value="<?php echo set_value('name',$row['name']) ?>">
      </div>
      <div class="form-group">
        <label for="description">Content</label>
        <textarea name="description" class="form-control" id="ckeditor" 
        placeholder="fund category description here"><?php echo set_value('description',$row['description']); ?></textarea>
      </div>
      <div class="form-group">
      <label for="image">Image</label>
        <?php if($row['image']) { ?>
        <div class="thumbnail">
          <img src="<?php echo is_picture_exists(fund_category_m::file_path.$row['image']);?>" 
          class="img-responsive" width="70" height="30" title=<?php echo $row['image']?$row['image']:''?>>
        </div>
        <?php } ?>
        <input name="image" type="file" class="form-input"><br/>

      </div>
      <div class="form-group">
        <label for="glyphicon">Glyphicon class</label>
        <input name="glyphicon" type="text" class="form-control" placeholder="Glyphicon class here"
        value="<?php echo set_value('glyphicon',$row['glyphicon']) ?>">
      </div>
    </div>
    <div class="panel-footer">
      <input type="submit" name="add" value="Update" class="btn btn-success">
      <a href="<? echo $link ?>" class="btn btn-warning"/>Cancel</a>
    </div>
  </div>
</form>

