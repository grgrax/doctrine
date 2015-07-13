
<div class="panel panel-default">
    <div class="panel-heading">Order Pages</div>
    <div class="panel-body" id="orderResult">
    </div>
    <div class="panel-footer">
        <input type="button" name="sortable" value="Update" class="btn btn-primary" id="save"/>
        <?php if(permission_permit(array('add-page'))){?>
        <a href="<?= $link ?>add" class="btn btn-primary"/>Add New  </a>
        <?php } ?>
        <a href="<?= $link ?>" class="btn btn-default" />Cancel</a>
    </div>
</div>
</div>
<script>
    $(function(){

        $.ajax({
            type : 'GET',
            url : '<?php echo site_url('page/ajax/order_ajax'); ?>',
            success : function(data){
                console.log("1st time");
                $('#orderResult').html(data);
            }
        });



        $('#save').click(function(){
            oSortable = $('.sortable').nestedSortable('toArray');
            $('#orderResult').slideUp(function(){
                $.post('<?php echo site_url('page/ajax/order_ajax'); ?>', { sortable: oSortable }, function(data){
                    $('#orderResult').html(data);
                    $('#orderResult').slideDown();
                });
            });
        });

    });
</script>
