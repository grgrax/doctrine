<?php if(config_item('admin_template')=='charisma') { ?>
<div class="panel panel-default">
    <div class="panel-heading"><h3>File Manager</h3></div>
    <div class="panel-body">
        <table class="table">
            <tbody>
                <tr>
                    <td>
                        <div class="row-fluid sortable">
                            <div class="box span12">
                                <div class="box-header well" data-original-title>
                                    <h2><i class="icon-picture"></i> File Manager</h2>
                                    <div class="box-icon">
                                        <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                                        <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                                        <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                                    </div>
                                </div>
                                <div class="box-content">
<!--                                     <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="icon-info-sign"></i> As its a demo, you currently have read-only permission, in your server you may do everything like, upload or delete. It will work on a server only.
                                    </div>
                                -->                                    
                                <div class="file-manager"></div>
                            </div>
                        </div><!--/span-->            
                    </div><!--/row-->
                </td>

            </tr>
        </tbody>
    </table>
</div>
<div class="panel-footer">
</div>
</div>
<?php } ?>



<?php if(config_item('admin_template')=='metis') { ?>

<div class="box">
  <header>
    <div class="icons">
      <i class="icon-folder-open-alt"></i>
  </div>
  <h5>File Manager</h5>
</header>
<div class="row">
    <div class="col-lg-12">
      <div id="elfinder"></div>
  </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
</div>
<?php } ?>
