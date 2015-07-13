<div class="panel panel-default table-responsive">
    <div class="panel-heading">
        Campaigns
        <span class="badge badge-info"><?=$total?></span>
        <span class="pull-right">
            <?php if(permission_permit(array('add-campaign'))){?>
            <span class="col-lg-3">
                <a href="<?= $link ?>add" class="btn btn-primary btn-labeled fa fa-plus"/>Add New  </a>
            </span>
            <?php } ?>
        </span>
    </div>
    <div class="panel-body">



        <form action="" method="GET" role="form">
            <div class="text-center"><b>--- Filter data by ---</b></div>
            <table class="table filter">            
                <tbody>
                    <tr>
                        <td class="col-lg-3">
                            <div class="form-group">
                                <!-- <label>Fund Category</label> -->
                                <select id="fund_category_id" class="form-control" name="fund_category_id">
                                    <option value=""> -- Fund Category --</option>
                                    <?php foreach (get_fund_categories(array('status !='=>fund_category_m::DELETED)) as $fund_category) { ?>
                                        <option value="<?=$fund_category['id']?>"
                                            <?php echo $this->input->get('fund_category_id')==$fund_category['id']?'selected':'';?>
                                            >
                                            <?=my_word_limiter($fund_category['name'])?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label>Donee</label> -->
                                    <select id="user_id" class="form-control" name="user_id">
                                        <option value="">-- Donee --</option>                                        
                                        <?php foreach (get_donees(1) as $donee) { ?>
                                        <option value="<?=$donee['id']?>"
                                            <?php echo $this->input->get('user_id')==$donee['id']?'selected':'';?>
                                            >
                                            <?=$donee['first_name']." ".$donee['last_name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label>Fund Category</label> -->
                                    <input type="text" class="form-control" placeholder="Campaign Title" name="campaign_title"                                    
                                    value="<?=$this->input->get('campaign_title')?$this->input->get('campaign_title'):''?>"
                                    >
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <!-- <label>Status</label> -->
                                    <select id="status" class="form-control" name="status">
                                        <option value="">-- Status --</option>
                                        <?php foreach ($status as $k=>$v) { if($k==campaign_m::SUCCESS OR $k==campaign_m::FAIL OR $k==campaign_m::DELETED) continue;?>
                                            <option value="<?=$k?>"
                                                <?php 
                                                if($this->input->get('status')!=''){
                                                    echo $this->input->get('status')==$k?'selected':'';
                                                }
                                                ?>
                                                >
                                                <?=$v;?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td  class="col-lg-3">
                                    <div class="form-group">
                                        <!-- <label>From Date</label> -->
                                        <input type="text" name="starting_at" id="filter_starting_at"  data-required="1" 
                                        class="form-control" placeholder="Starting at"
                                        value="<?=$this->input->get('starting_at')?$this->input->get('starting_at'):''?>">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <!-- <label>To Date</label> -->
                                        <input type="text" name="ending_at" id="ending_at" data-required="1" 
                                        class="form-control" placeholder="Ending at"
                                        value="<?=$this->input->get('ending_at')?$this->input->get('ending_at'):''?>">
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $amount_option=array(
                                        '1'=>'Equal to',
                                        '2'=>'Above',
                                        '3'=>'Below',
                                        '4'=>'Between',
                                        // '5'=>'Lowest',
                                        // '6'=>'Highest',
                                        );
                                        ?>
                                        <div class="form-group">
                                            <select id="amount_option" class="form-control" name="amount_option">
                                                <option value="">-- Amount --</option>
                                                <?php foreach ($amount_option as $k=>$v) { ?>
                                                <option value="<?=$k?>"
                                                    <?php echo $this->input->get('amount_option')==$k?'selected':'';?>
                                                    >
                                                    <?=$v;?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <span class="amount_1">
                                                <!-- <label>Equal to</label> -->
                                                <input type="text" class="form-control" name="amount_equal_to" placeholder="equal to" 
                                                value="<?=$this->input->get('amount_equal_to')?$this->input->get('amount_equal_to'):''?>">
                                            </span>
                                            <span class="amount_2">
                                                <!-- <label>Above </label> -->
                                                <input type="text" class="form-control" name="amount_above" placeholder="Above" 
                                                value="<?=$this->input->get('amount_above')?$this->input->get('amount_above'):''?>">
                                            </span>
                                            <span class="amount_3">
                                                <!-- <label>Below </label>                                        -->
                                                <input type="text" class="form-control" name="amount_below" placeholder="Below" 
                                                value="<?=$this->input->get('amount_below')?$this->input->get('amount_below'):''?>">
                                            </span>
                                            <span class="amount_4">
                                                <!-- <label>Start from </label> -->
                                                <input type="text" class="form-control" name="amount_start_from" placeholder="Start from" 
                                                value="<?=$this->input->get('amount_start_from')?$this->input->get('amount_start_from'):''?>">
                                                <!-- <label>End at </label>                                       -->
                                                <input type="text" class="form-control" name="amount_end_at" placeholder="End at" 
                                                value="<?=$this->input->get('amount_end_at')?$this->input->get('amount_end_at'):''?>">
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group pull-right">
                            <input type="submit" class="btn btn-info" name="filter" value="Filter">
                            <a href="<?=$link?>" class="btn btn-info">Reset</a>
                        </div>
                    </form>

                    <table class="table">
                        <thead>
                            <tr>
                                <th class="center">s.no</th>
                                <th width="20%">name</th>
                                <th width="15%">status</th>
                                <th width="15%">fund category name</th>
                                <th width="10%">Amount (AUD) </th>
                                <th width="15%">Pictures</th>
                                <th width="15%">Date</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($rows && count($rows) > 0) {
                                $c = $offset;
                                foreach ($rows as $row) {
                                    $c++;
                                    $alertClass="";
                                    $actions=array();
                                    switch($row['status']){
                                        case campaign_m::PENDING:
                                        {
                                            $alertClass="warning";
                                            if(permission_permit(array('activate-campaign'))) 
                                                $actions=array('publish');
                                            break;
                                        }
                                        case campaign_m::ACTIVE:
                                        {
                                            $alertClass="";
                                            if(permission_permit(array('block-campaign'))) 
                                                $actions[]='unpublish';
                                            if(permission_permit(array('delete-campaign'))) 
                                                $actions[]='delete';
                                            break;
                                        }
                                        case campaign_m::BLOCKED:
                                        {
                                            $alertClass="warning";
                                            if(permission_permit(array('activate-campaign'))) 
                                                $actions=array('publish');
                                            if(permission_permit(array('delete-campaign'))) 
                                                $actions[]='delete';
                                            break;
                                        }
                                    }
                                    $donation_amount = get_donation_amount($row['id'] );
                                    $target_percent = $donation_amount/$row['target_amount']*100;
                                    ?>
                                    <tr class="<?php echo $alertClass?>">
                                        <td class="center"><?php echo $c?></td>
                                        <td>
                                            <a href="<?= $link ?>edit/<?= $row['slug'] ?>"/><?= word_limiter(convert_accented_characters($row['campaign_title']), 5) ?>
                                            </a>
                                            <hr>
                                            <?php
                                            echo "Starting at: ";
                                            echo "<label><b>".$row['starting_at']."</b></label>";
                                            echo "<br/>Ending at</label>: ";
                                            echo "<label><b>".$row['ending_at']."</b></label>";
                                            echo "<hr/><label><b>".days_left($row['ending_at'])."</b></label>";                            
                                            echo "<hr/><label>Donee</label>: ";
                                            echo "<b>".$row['username']."</b>";
                                            ?>                         
                                        </td>
                                        <td class="center">
                                            <?php 
                                            if($row['status']==campaign_m::PENDING)
                                                echo "Pending";
                                            elseif($row['status']==campaign_m::ACTIVE)
                                                echo "Active";
                                            elseif($row['status']==campaign_m::SUCCESS)
                                                echo "Success";
                                            elseif($row['status']==campaign_m::FAIL)
                                                echo "Failed";
                                            elseif($row['status']==campaign_m::BLOCKED)
                                                echo "Blocked";
                                            $percent=$target_percent<100?number_format($target_percent):'100';
                                            ?>
                                            <div class="progress progress-lg">
                                                <div style="width: <?=$percent?>%;" class="progress-bar progress-bar-success">
                                                    <?=$percent?>%
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <?php
                                            // $fund_category=get_fund_category($row['name']);
                                            echo word_limiter(convert_accented_characters($row['name']), 5);
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            echo "$ ".$donation_amount = get_donation_amount($row['id'] );
                                            echo " of ";
                                            echo "$ ".$row['target_amount'];
                                            ?>
                                        </td>
                                        <td>
                                            <div id="carousel-example-generic-<?php echo $row['id']?>" class="carousel slide col-lg-12">
                                                <?php if($row['pic']!="") {
                                                    $pics=unserialize($row['pic']);
                                                    if(count($pics)>0){ ?>
                                                    <ol class="carousel-indicators">
                                                        <?php foreach ($pics as $key=>$pic) { 
                                                            if(is_picture_exists(campaign_m::file_path.$pic)){ ?>
                                                            <li data-target="#carousel-example-generic-<?php echo $row['id']?>" data-slide-to="<?php echo $key?>" <?php echo ($key==1)?'class="active"':'';?>></li>
                                                            <?php } 
                                                        } ?>
                                                    </ol>
                                                    <?php } 
                                                } ?>
                                                <div class="carousel-inner">
                                                    <?php if($row['pic']!="") {
                                                        $pics=unserialize($row['pic']);
                                                        if(count($pics)>0){ 
                                                            foreach ($pics as $key=>$pic) { 
                                                                if(is_picture_exists(campaign_m::file_path.$pic)){ ?>
                                                                <div class="item <?php echo ($key==1)?"active":'';?>">
                                                                    <img alt="" src="<?php echo is_picture_exists(campaign_m::file_path.$pic);?>">
                                                                </div>                                                        
                                                                <?php } 
                                                            } 
                                                        } 
                                                    } ?>
                                                </div>
                                            </div>
                                        </td>  
                                        <td><?php echo format($row['created_at'])?></td>
                                        <td>
                                            <?php if(is_default($row['slug'])) continue; ?>
                                            <?php if(permission_permit(array('edit-campaign'))) { ?>
                                            <a class="btn btn-sm btn-default btn-icon btn-hover-success add-tooltip fa fa-pencil" 
                                            data-toggle="tooltip" 
                                            href="<?= $link ?>edit/<?= $row['slug'] ?>" 
                                            data-original-title="Edit" 
                                            ></a>
                                            <?php } ?>
                                            <?php                                                                                        
                                            foreach ($actions as $k=>$action) { 
                                                switch ($action) {
                                                    case 'publish':
                                                    $class='btn-success fa fa-check';
                                                    break;
                                                    case 'unpublish':
                                                    $class='btn-warning fa fa-warning';
                                                    break;
                                                    case 'delete':
                                                    $class='btn-danger fa fa-times delete';
                                                    break;
                                                }
                                                ?>
                                                <a href="<?= $link.$action.'/'.$row['slug'] ?>" class="btn btn-sm btn-icon add-tooltip <?=$class?>" 
                                                    data-toggle="tooltip" 
                                                    data-original-title="<?=ucfirst($action)?>"
                                                    data-container="body"/></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="td_no_data">No data</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <ul class="pagination">
                                <?php if (!empty($pages)) echo $pages; ?>
                            </ul>
                        </div>
                    </div>

                    <?php //show_pre($rows) ?>

                    <script>
                        $(function(){

                            $("#filter_starting_at").datepicker({
                                dateFormat: 'dd-mm-yy',
                                changeMonth: true,
                                changeYear: true,
                                onClose: function( selectedDate ) {
                                    $( "#ending_at" ).datepicker( "option", "minDate", selectedDate );
                                    $( "#ending_at" ).focus();                                    
                                }
                            });
                            $("#ending_at").datepicker({
                                dateFormat: 'dd-mm-yy',
                                changeMonth: true,
                                changeYear: true,
                                minDate: $('#filter_starting_at').val()
                            });


                            var amount_option=$("select[name=amount_option]").val();
                            show_amount_section(amount_option);

                            $("select[name=amount_option]").change(function(){
                                show_amount_section($(this).val());
                            });

                            function show_amount_section(option){
                                hide_amount_secton();
                                var amount_option="amount_"+option;
                                $("."+amount_option).show();
                            }

                            function hide_amount_secton(){
                                $(".amount_1").hide();
                                $(".amount_2").hide();
                                $(".amount_3").hide();
                                $(".amount_4").hide();
                            }

                        })
                    </script>

                    <style>
                        .filter{
                            margin-bottom: 10px;
                            border-top: none !important;
                            /*border-bottom: 1px dotted rgba(182, 184, 184, 0.99);*/
                        }
                    </style>



