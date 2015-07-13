<br>

<!--Tiles - Bright version-->
<!--===================================================-->
<div class="row">


  <a href="<?php echo base_url('user/donee'); ?>" style="display:block">

    <div class="col-md-6 col-lg-3">

      <!--Registered User-->
      <div class="panel media pad-all">
        <div class="media-left">
          <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
            <i class="fa fa-user fa-2x"></i>
          </span>
        </div>

        <div class="media-body">
          <p class="text-2x mar-no text-thin">

            <?php 
            $param['module']='donee'; 
            echo show_total($param);
            ?>
            

          </p>
          <p class="text-muted mar-no">Donee</p>
        </div>

      </div>

    </div>
  </a>
  <a href="<?php echo base_url('campaign/admin'); ?>" style="display:block">
    <div class="col-md-6 col-lg-3">

      <!--New Order-->
      <div class="panel media pad-all">
        <div class="media-left">
          <span class="icon-wrap icon-wrap-sm icon-circle bg-info">
            <i class="fa fa-shopping-cart fa-2x"></i>
          </span>
        </div>

        <div class="media-body">

          <p class="text-2x mar-no text-thin"><?php 
            $param['module']='campaign'; 
            echo show_total($param);
            ?></p>
            <p class="text-muted mar-no">Campaign</p>
          </div>
        </div>

      </div>
    </a>
    <a href="<?php echo base_url('campaign/admin'); ?>" style="display:block">
      <div class="col-md-6 col-lg-3">

        <!--Comments-->
        <div class="panel media pad-all">
          <div class="media-left">
            <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
              <i class="fa fa-comment fa-2x"></i>
            </span>
          </div>

          <div class="media-body">
            <p class="text-2x mar-no text-thin"><?php 
              $param['module']='fund_category'; 
              echo show_total($param);
              ?>
            </p>
            <p class="text-muted mar-no">Categories</p>

          </div>
        </div>

      </div>
    </a>
    <a href="<?php echo base_url('campaign/admin'); ?>" style="display:block">
      <div class="col-md-6 col-lg-3">

        <!--Sales-->
        <div class="panel media pad-all">
          <div class="media-left">
            <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
              <i class="fa fa-dollar fa-2x"></i>
            </span>
          </div>

          <div class="media-body">

            <p class="text-2x mar-no text-thin"><?php 
              $param['module']='donation'; 
              echo show_total($param);
              ?></p>
              <p class="text-muted mar-no">Donation</p>

            </div>
          </div>

        </div>
      </div>
    </a>
    <!--===================================================-->
    <!--End Tiles - Bright version-->

    <br>
    <br>
    <div class="row">
      <div class="col-md-12">
        <?php $data['rows'] = $campaigns; 
        $this->load->view('campaigns', $data)?>
      </div> 
    </div> 
    <!--===================================================-->
    <!--End Large Tile - (Earning)-->









