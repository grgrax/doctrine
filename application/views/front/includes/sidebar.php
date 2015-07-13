<div id="left">
  <div class="media user-media">
    <div class="user-media-toggleHover">
      <span class="fa fa-user"></span> 
    </div>
  </div>

  <!-- #menu -->
  <ul id="menu" class="">
    <li class="">
      <a href="javascript:;"><i class="fa fa-tasks"></i>
        <span class="link-title">Components</span> 
        <span class="fa arrow"></span> 
      </a> 
      <ul style="height: inherit;">
        <li class="">
          <a href="icon.html">
            <i class="fa fa-angle-right"></i>
            &nbsp;Icon
          </a> 
        </li>
        <li class="">
          <a href="button.html">
            <i class="fa fa-angle-right"></i>
            &nbsp;Button
          </a> 
        </li>
        <li class="">
          <a href="progress.html">
            <i class="fa fa-angle-right"></i>&nbsp;Progress
          </a> 
        </li>
        <li class="">
          <a href="pricing.html">
            <i class="fa fa-credit-card"></i>&nbsp;Pricing Table
          </a> 
        </li>
        <li class="">
          <a href="bgimage.html">
            <i class="fa fa-angle-right"></i>&nbsp;Bg Image
          </a> 
        </li>
        <li class="">
          <a href="bgcolor.html">
            <i class="fa fa-angle-right"></i>&nbsp;Bg Color
          </a> 
        </li>
      </ul>
    </li>
    <li class="">
      <a href="javascript:;">
        <i class="fa fa-pencil"></i>
        <span class="link-title">
          Forms
        </span> 
        <span class="fa arrow"></span> 
      </a> 
      <ul style="height: inherit;">
        <li class="">
          <a href="form-general.html">
            <i class="fa fa-angle-right"></i>&nbsp;General
          </a> 
        </li>
        <li class="">
          <a href="form-validation.html">
            <i class="fa fa-angle-right"></i>&nbsp;Validation
          </a> 
        </li>
        <li class="">
          <a href="form-wysiwyg.html">
            <i class="fa fa-angle-right"></i>&nbsp;WYSIWYG
          </a> 
        </li>
        <li class="">
          <a href="form-wizard.html">
            <i class="fa fa-angle-right"></i>&nbsp;Wizard &amp; File Upload
          </a> 
        </li>
      </ul>
    </li>

    <?php if(permission_permit(['administrator-menu'])){?>
    <li>
      <a href="<?=base_url()?>menu">Menus</a>
    </li>
    <?php } ?>

    <?php if(permission_permit(['administrator-category'])){?>
    <li>
      <a href="<?=base_url()?>category">Categories</a>
    </li>
    <?php } ?>
    <?php if(permission_permit(['administrator-article'])){?>
    <li>
      <a href="<?=base_url()?>article">Articles</a>
    </li>
    <?php } ?>
    <?php if(permission_permit(['administrator-testimonial'])){?>
    <li>
      <a href="<?=base_url()?>testimonial">Testinomials</a>
    </li>
    <?php } ?>
    <li>
      <a href="<?=base_url()?>page">Pages</a>
    </li>
    <?php if(permission_permit(['administrator-user'])){?>            
    <li>
      <a href="<?=base_url()?>user">User</a>
    </li>
    <?php } ?>
    <li>
      <a href="<?=base_url()?>group">Group</a>
    </li>
    <li>
      <a href="<?=base_url()?>group/permission">Permission</a>
    </li>
    <li>
      <a href="<?=base_url()?>sample">sample module</a>
    </li>



    <li>
      <a href="typography.html">
        <i class="fa fa-font"></i>
        <span class="link-title">
          Typography
        </span>  
      </a> 
    </li>
    <li>
      <a href="maps.html">
        <i class="fa fa-map-marker"></i><span class="link-title">
        Maps
      </span> 
    </a> 
  </li>
  <li>
    <a href="chart.html">
      <i class="fa fa fa-bar-chart-o"></i>
      <span class="link-title">
        Charts
      </span> 
    </a> 
  </li>
  <li>
    <a href="calendar.html">
      <i class="fa fa-calendar"></i>
      <span class="link-title">
        Calendar
      </span> 
    </a> 
  </li>
  <li>
    <a href="javascript:;">
      <i class="fa fa-exclamation-triangle"></i>
      <span class="link-title">
        Error Pages
      </span> 
      <span class="fa arrow"></span> 
    </a> 
    <ul style="height: inherit;">
      <li>
        <a href="403.html">
          <i class="fa fa-angle-right"></i>&nbsp;403
        </a> 
      </li>

      <li>
        <a href="404.html">
          <i class="fa fa-angle-right"></i>&nbsp;404
        </a> 
      </li>
      <li>
        <a href="405.html">
          <i class="fa fa-angle-right"></i>&nbsp;405
        </a> 
      </li>
      <li>
        <a href="500.html">
          <i class="fa fa-angle-right"></i>&nbsp;500
        </a> 
      </li>
      <li>
        <a href="503.html">
          <i class="fa fa-angle-right"></i>&nbsp;503
        </a> 
      </li>
      <li>
        <a href="offline.html">
          <i class="fa fa-angle-right"></i>&nbsp;offline
        </a> 
      </li>
      <li>
        <a href="countdown.html">
          <i class="fa fa-angle-right"></i>&nbsp;Under Construction
        </a> 
      </li>
    </ul>
  </li>
  <li>
    <a href="grid.html">
      <i class="fa fa-columns"></i>
      <span class="link-title">
        Grid
      </span> 
    </a> 
  </li>
  <li>
    <a href="blank.html">
      <i class="fa fa-square-o"></i>
      <span class="link-title">
        Blank Page
      </span> 
    </a> 
  </li>
  <li class="nav-divider"></li>
  <li>
    <a href="login.html">
      <i class="fa fa-sign-in"></i>
      <span class="link-title">
        Login Page
      </span> 
    </a> 
  </li>
  <li>
    <a href="javascript:;">
      <i class="fa fa-code"></i>
      <span class="link-title">
        Unlimited Level Menu 
      </span> 
      <span class="fa arrow"></span> 
    </a> 
    <ul style="height: inherit;">
      <li>
        <a href="javascript:;">Level 1  <span class="fa arrow"></span>  </a> 
        <ul style="height: inherit;">
          <li> <a href="javascript:;">Level 2</a>  </li>
          <li> <a href="javascript:;">Level 2</a>  </li>
          <li>
            <a href="javascript:;">Level 2  <span class="fa arrow"></span>  </a> 
            <ul style="height: inherit;">
              <li> <a href="javascript:;">Level 3</a>  </li>
              <li> <a href="javascript:;">Level 3</a>  </li>
              <li> <a href="javascript:;">Level 3  <span class="fa arrow"></span>  </a> 
                <ul style="height: inherit;">
                  <li> <a href="javascript:;">Level 4</a>  </li>
                  <li> <a href="javascript:;">Level 4</a>  </li>
                  <li> <a href="javascript:;">Level 4  <span class="fa arrow"></span>  </a> 
                    <ul style="height: inherit;">
                      <li> <a href="javascript:;">Level 5</a>  </li>
                      <li> <a href="javascript:;">Level 5</a>  </li>
                      <li> <a href="javascript:;">Level 5</a>  </li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li> <a href="javascript:;">Level 4</a>  </li>
            </ul>
          </li>
          <li> <a href="javascript:;">Level 2</a>  </li>
        </ul>
      </li>
      <li> <a href="javascript:;">Level 1</a>  </li>
      <li>
        <a href="javascript:;">Level 1  <span class="fa arrow"></span>  </a> 
        <ul style="height: inherit;">
          <li> <a href="javascript:;">Level 2</a>  </li>
          <li> <a href="javascript:;">Level 2</a>  </li>
          <li> <a href="javascript:;">Level 2</a>  </li>
        </ul>
      </li>
    </ul>
  </li>
</ul><!-- /#menu -->
</div>