<form method="post" action="" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-heading">Edit Details</div>
        <div class="panel-body">
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="input" class="form-control capitalize">
                    <option value="">Select</option>
                    <?php foreach ($categories as $r) {?>
                    <option value="<?php echo $r['id'] ?>" <?php echo $r['id'] == $row['category_id']?"selected":'';?>><?php echo $r['name']?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input name="name" type="text" class="form-control" placeholder="article name here"
                value="<?php echo set_value('name',$row['name']) ?>" <?php echo is_default($row['slug'])?'readonly':''?>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" id="ckeditor" 
                placeholder="article content here"><?php echo set_value('content',$row['content']); ?></textarea>
            </div>
            <span>        
                <div class="form-group">

                    <div class="tab-head">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#image" data-toggle="tab">Image</a></li>
                            <li><a href="#video" data-toggle="tab">Video</a></li>
                            <li><a href="#meta" data-toggle="tab">Meta</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="image" class="tab-pane fade in active">
                            <p>
                                <div class="form-group">
                                    <label for="image">Image</label> (Max upload size: 5M)
                                    <input name="image" type="file" class="form-input">
                                    <div class="thumbnail">
                                      <img src="<?php echo is_picture_exists($article_m::file_path.$row['image']);?>" 
                                      class="img-responsive" width="70" height="30" title=<?php echo $row['image_title']?$row['image_title']:''?>>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="image_title">Image title</label>
                                <input name="image_title" type="text" class="form-control" placeholder="Image title here"
                                value="<?php echo set_value('image_title',$row['image_title']) ?>">
                            </div> 
                        </p>
                    </div>
                    <div id="video" class="tab-pane fade">
                        <p>
                            <div class="form-group">
                                <label for="video">Video</label> (Max upload size: 25M)
                                <input name="video" type="file" class="form-input">
                                <div class="thumbnail">
                                    <video width="320" height="240" class="img-responsive" controls>
                                      <source src="<?php echo is_video_exists($article_m::file_path.$row['video']);?>" type="video/mp4">
                                     <!--  <source src="movie.ogg" type="video/ogg">
                                 -->     
                                 Your browser does not support the video tag.
                             </video>
                         </div>

                     </div>
                     <div class="form-group">
                        <label for="video_title">Video title</label>
                        <input name="video_title" type="text" class="form-control" placeholder="video title here"
                        value="<?php echo set_value('video_title',$row['video_title']) ?>">
                    </div> 
                    <div class="form-group">
                        <label for="video_url">Video url</label>
                        <input name="video_url" type="text" class="form-control" placeholder="url here"
                        value="<?php echo set_value('video_url',$row['video_url']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="embed_code">Embed Video code</label>
                        <textarea name="embed_code" class="form-control" id="" 
                        placeholder="article content here"><?php echo html_entity_decode(set_value('embed_code',$row['embed_code'])); ?></textarea>
                        <br/>
                        <?php echo html_entity_decode($row['embed_code']);?>
                    </div>
                </p>          
            </div>
            <div id="meta" class="tab-pane fade">
                <p>
                    <div class="form-group">
                        <label for="meta_description">Meta description</label>
                        <input name="meta_description" type="text" class="form-control" placeholder="meta description here"
                        value="<?php echo set_value('meta_description',$row['meta_desc']) ?>">
                    </div> 
                    <div class="form-group">
                        <label for="meta_keywords">Meta keywords</label>
                        <input name="meta_keywords" type="text" class="form-control" placeholder="meta keywords here"
                        value="<?php echo set_value('meta_keywords',$row['meta_key']) ?>">
                    </div> 
                    <div class="form-group">
                        <label for="meta_robots">Meta robots</label>
                        <input name="meta_robots" type="text" class="form-control" placeholder="meta robots here"
                        value="<?php echo set_value('meta_robots',$row['meta_robots']) ?>">
                    </div> 
                </p>          
            </div>
        </div> 
    </div>
</span>
</div>
<div class="panel-footer">
    <input type="submit" name="edit" value="Edit" class="btn btn-primary"/>
    <a href="<? echo $link ?>" class="btn btn-default"/>Cancel</a>
</div>
</div>
</form>


