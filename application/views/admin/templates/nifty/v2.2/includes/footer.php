</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->
<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
  <div id="mainnav">


    <!--Menu-->
    <!--================================-->
    <div id="mainnav-menu-wrap">
      <div class="nano">
        <div class="nano-content">
          <ul id="mainnav-menu" class="list-group">

            <li class="list-header">Navigation</li>

            <li class="active-link">
              <a href="<?=base_url('dashboard')?>">
                <i class="fa fa-dashboard"></i>
                <span class="menu-title">
                  <strong>Dashboard</strong>
                </span>
              </a>
            </li>

            

            <?php if(permission_permit(['administrator-donation'])) {?>            
            <li>
              <a href="<?=base_url('donation/admin')?>">
                <i class="fa fa-flask"></i>
                <span class="menu-title">
                  <strong>Donation</strong>
                  <span class="pull-right badge badge-success">
                    <?php 
                    $param['module']='donation'; 
                    echo show_total($param);
                    ?>
                  </span>
                </span>
              </a>
            </li>
            <?php } ?>

            <li class="list-divider"></li>

            <!--Category name-->
            <li class="list-header">Manage</li>


            <?php if(permission_permit(['administrator-fund-category'])) {?>
            <!-- fund-category -->
            <li>

              <a href="#">
                <i class="fa fa-table"></i>
                <span class="menu-title">Fund Categories
                  <span class="pull-right badge badge-info">
                    <?php 
                    $param['module']='fund_category'; 
                    echo show_total($param);
                    ?>
                  </span>
                </span>
                <i class="arrow"></i>
              </a>

              <ul class="collapse">
                <li><a href="<?=base_url('fund_category')?>">List</a></li>
                <?php if(permission_permit(['add-fund-category'])) {?>
                <li> <a href="<?=base_url()?>fund_category/add">Add</a></li>
                <?php } ?>                
              </ul>

            </li>
            <!-- fund-category -->
            <?php } ?>

            <?php if(permission_permit(['administrator-campaign'])) {?>
            <!-- campaigns -->
            <li>
              <a href="#">
                <i class="fa fa-table"></i>
                <span class="menu-title">Campaigns
                  <span class="pull-right badge badge-info">
                    <?php 
                    $param['module']='campaign'; 
                    echo show_total($param);
                    ?>
                  </span>
                </span>
                <i class="arrow"></i>
              </a>
              <ul class="collapse">
                <li><a href="<?=base_url('campaign/admin')?>">List</a></li>
                <?php if(permission_permit(['add-campaign'])) {?>
                <li> <a href="<?=base_url('campaign/admin/add')?>">Add</a></li>
                <?php } ?>
                <!-- <li> <a href="<?=base_url('report/fund_category/most_campaigns')?>">Most</a></li>                       -->
              </ul>
            </li>
            <!-- campaigns -->
            <?php } ?>

            <?php if(permission_permit(['administrator-donee'])) {?>
            <!-- fund-donee -->
            <li>
              <a href="javascritp:;">
                <i class="fa fa-table"></i>
                <span class="menu-title">Donee
                  <span class="pull-right badge badge-info">
                    <?php 
                    $param['module']='donee'; 
                    echo show_total($param);
                    ?>
                  </span>
                </span>
                <i class="arrow"></i>
              </a>
              <ul class="collapse">
                <li><a href="<?=base_url('user/donee')?>">List</a></li>
                <?php if(permission_permit(['add-donee'])) {?>
                <li> <a href="<?=base_url('user/donee/add')?>"/>Add</a></li>
                <?php } ?>
              </ul>
            </li>
            <!-- fund-donee -->
            <?php } ?>

            <?php             
            $user=permission_permit(['administrator-user']);
            $group=permission_permit(['administrator-group']);
            $permission=permission_permit(['administrator-permission']);

            if($user or $group or $permission) 
            {
              ?>
              <!-- users, groups and permission -->
              <li>
                <a href="<?php echo base_url('user')?>">
                  <i class="fa fa-briefcase"></i>
                  <span class="menu-title">
                    <?php
                    if($user and $group)
                      echo 'Users & Groups';
                    elseif ($user)
                      echo 'Users';
                    elseif ($group)
                      echo 'Groups';
                    ?>
                  </span>
                  <i class="arrow"></i>
                </a>
                <ul class="collapse">
                  <?php if(permission_permit(['administrator-group'])) {?>
                  <li>
                    <a href="<?=base_url('group')?>">Groups
                      <span class="pull-right badge badge-info">
                       <?php 
                       $param['module']='group'; 
                       echo show_total($param);
                       ?>
                     </span>
                   </a>
                 </li>
                 <?php } ?>
                 <?php if(permission_permit(['administrator-user'])){?>            
                 <li>
                  <a href="<?=base_url('user')?>">Users
                    <span class="pull-right badge badge-info">
                      <?php 
                      $param['module']='user'; 
                      echo show_total($param);
                      ?>
                    </span>
                  </a>
                </li>
                <?php } ?>
                <?php if(permission_permit(['administrator-permission'])){?>            
                <li>
                  <a href="<?=base_url('group/permission')?>">Permissions
                    <span class="pull-right badge badge-info">
                      <?php 
                      $param['module']='permission'; 
                      echo show_total($param);
                      ?>
                    </span></a>
                  </li>
                  <?php } ?>
                </ul>
              </li>
              <!-- users, groups and permission -->
              <?php 
            } 
            ?>

            
            <?php if(permission_permit(['administrator-setting'])){?>            
            <!-- setting -->           
            <li>
              <a href="<?=base_url('setting')?>">
                <i class="fa fa-flask"></i>
                <span class="menu-title">
                  <strong>Setting</strong>
                  <span class="pull-right badge badge-info">
                    <?php 
                    $param['module']='setting'; 
                    echo show_total($param);
                    ?>
                  </span>
                </span>
              </a>
            </li>
            <!-- setting -->
            <?php } ?>


            <li>
            <a href="<?=base_url('student')?>">
                <i class="fa fa-flask"></i>
                <span class="menu-title">
                  <strong>Student</strong>
                </span>
              </a>
            </li>

          </ul>


        </div>
      </div>
    </div>
    <!--================================-->
    <!--End menu-->

  </div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->


</div>



<!-- FOOTER -->
<!--===================================================-->
<footer id="footer">

  <!-- Visible when footer positions are fixed -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <div class="pull-right">
    <ul class="footer-list list-inline">
      <!-- <li>
        <p class="text-sm">SEO Proggres</p>
        <div class="progress progress-sm progress-light-base">
          <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
        </div>
      </li>

      <li>
        <p class="text-sm">Online Tutorial</p>
        <div class="progress progress-sm progress-light-base">
          <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
        </div>
      </li>
      <li>
        <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
      </li> -->
    </ul>
  </div>



  <!-- Visible when footer positions are static -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <div class="hide-fixed pull-right pad-rgt">&#0169; 2015 <?=config_item('developer')?></div>



  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
  <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
  <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

  <!-- <p class="pad-lft">&#0169; 2015 <?=config_item('developer')?></p> -->



</footer>
<!--===================================================-->
<!-- END FOOTER -->


<!-- SCROLL TOP BUTTON -->
<!--===================================================-->
<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
<!--===================================================-->



</div>
<!--===================================================-->
<!-- END OF CONTAINER -->


<!--JAVASCRIPT-->
<!--=================================================-->



<!--BootstrapJS [ RECOMMENDED ]-->
<!-- <script src="<?=admin_template_asset_path()?>/js/bootstrap.min.js"></script> -->


<!--Fast Click [ OPTIONAL ]-->
<script src="<?=admin_template_asset_path()?>/plugins/fast-click/fastclick.min.js"></script>


<!--Nifty Admin [ RECOMMENDED ]-->
<script src="<?=admin_template_asset_path()?>/js/nifty.min.js"></script>


<!--Morris.js [ OPTIONAL ]-->
<!-- <script src="<?=admin_template_asset_path()?>/plugins/morris-js/morris.min.js"></script> -->
<script src="<?=admin_template_asset_path()?>/plugins/morris-js/raphael-js/raphael.min.js"></script>


<!--Sparkline [ OPTIONAL ]-->
<script src="<?=admin_template_asset_path()?>/plugins/sparkline/jquery.sparkline.min.js"></script>


<!--Skycons [ OPTIONAL ]-->
<script src="<?=admin_template_asset_path()?>/plugins/skycons/skycons.min.js"></script>


<!--Switchery [ OPTIONAL ]-->
<script src="<?=admin_template_asset_path()?>/plugins/switchery/switchery.min.js"></script>


<!--Bootstrap Select [ OPTIONAL ]-->
<script src="<?=admin_template_asset_path()?>/plugins/bootstrap-select/bootstrap-select.min.js"></script>

<!-- template validation -->
<!--Bootstrap Validator [ OPTIONAL ]-->
<!-- <script src="<?=admin_template_asset_path()?>/plugins/bootstrap-validator/bootstrapValidator.min.js"></script> -->
<!--Masked Input [ OPTIONAL ]-->
<!-- <script src="<?=admin_template_asset_path()?>/plugins/masked-input/jquery.maskedinput.min.js"></script> -->
<!-- template validation -->

<!--Demo script [ DEMONSTRATION ]-->
<!-- <script src="<?=admin_template_asset_path()?>/js/demo/nifty-demo.min.js"></script> -->


<!--Specify page [ SAMPLE ]-->
<!-- <script src="<?=admin_template_asset_path()?>/js/demo/dashboard.js"></script> -->
<!--Specify page [ SAMPLE ]-->
<script src="<?=admin_template_asset_path()?>/js/custom.js"></script>



<!-- footables -->
<!-- <link href="<?=admin_template_asset_path()?>/plugins/fooTable/css/footable.core.css" rel="stylesheet">
<script src="<?=admin_template_asset_path()?>/plugins/fooTable/dist/footable.all.min.js"></script>
<script src="<?=admin_template_asset_path()?>/js/demo/tables-footable.js"></script>
--><!-- footables -->




<!-- core jquery -->
<link rel="stylesheet" href="<?=base_url()?>/templates/assets/jquery-v1.11.4/jquery-ui.css">
<script src="<?=base_url()?>/templates/assets/jquery-v1.11.4/jquery-ui.js"></script>
<!-- core jquery -->


<!-- bootstrap tinymice v 3 -->
<script src="<?=base_url()?>/templates/assets/bootstrap/v3/components/wysiwyg/wysihtml5x-toolbar.min.js"></script>
<script src="<?=base_url()?>/templates/assets/bootstrap/v3/core/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>/templates/assets/bootstrap/v3/components/wysiwyg/handlebars.runtime.min.js"></script>
<script src="<?=base_url()?>/templates/assets/bootstrap/v3/components/wysiwyg/bootstrap3-wysihtml5.min.js"></script>
<!-- bootstrap tinymice v 3 -->

<!-- bootsrtap components -->
<script src="<?=base_url()?>/templates/assets/bootstrap/components/bootbox-v4.4.0/bootbox.min.js"></script>
<!-- bootsrtap components -->

<!--Form validation [ SAMPLE ]-->
<!-- <script src="<?=admin_template_asset_path()?>/js/demo/form-validation.js"></script> -->
<script src="<?php echo template_path('assets/js/campaign.js')?>" type="text/javascript"></script>

<script>

  $(function(){
    try{

      $('.textarea').wysihtml5();

      var validate='<?php echo $this->config->item("enabe_jq_validation_backend")?>';
      console.log(validate);
      if(validate==1){
        $("#validate_form").validate();
        // $("#validate_form").validate({
        //   rules: {description: "required"},
        //   errorPlacement: function(label, element) {
        //     console.log(element);
        //     if (element.is("textarea")) {
        //       label.insertAfter(element.next());
        //     }
        //   }
        // });
}


$( "#starting_at" ).datepicker({
  dateFormat: 'dd-mm-yy',
  minDate: new Date(),
  stepMonths: 0,
  onClose: function( selectedDate ) {
    $( "#ending_at" ).datepicker( "option", "minDate", selectedDate );
  }
});
$( "#ending_at" ).datepicker({
  dateFormat: 'dd-mm-yy',
  numberOfMonths: 2,
  stepMonths: 0,
  onClose: function( selectedDate ) {
    $( "#ending_at" ).datepicker( "option", "maxDate", selectedDate );
  }
});
$("#starting_at").datepicker('setDate', new Date());



    //hide success Message
    // $(".alert-success").fadeOut("96000");
    // $( ".alert-success" ).hide( "drop", { direction: "down" }, "10000" );

    //remove pic
    $('a.delete').on("click", function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      // console.log(url);
      bootbox.confirm("Are you sure?", function(result) {
        if(result){
          window.location=url;
        }
      });
    });

  }
  catch(e){
    console.log(e.message)
  }

  //hack pagination for repsonsive
  $('<br class="clear">').insertAfter('ul.pagination');

  //delete click
  $('.btn-danger').click(function(){

  });

});
</script>
<style>
  .clear{
    clear: both;
  }
</style>

<?php //show_pre(get_session('logged_in_user')); ?>

</body>

</html>

