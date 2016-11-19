<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->userdata('name');?></p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">  
      <!-- Optionally, you can add icons to the links -->
      <li>
        <a href="index.php">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </span>
        </a>
        </li><li class="treeview">
        <a href="#">
          <i class="fa fa-laptop"></i> <span>Service Platform</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <!--BN MENU-->
          <li>
            <a href="#"><i class="fa fa-cogs"></i> Broadcast Application
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
               <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i> Service Parameter
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> Channel LineUp</a></li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Bouquet LineUp</a></li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Services / Packages</a></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i> XTI
                </a>
              </li>
			  <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i>Traffic System
                </a>
              </li>
			  <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i>Projects
                </a>
              </li> 
              <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i>Work Log
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                 <ul class="treeview-menu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> SSR Logs</a></li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Gen21 Logs</a></li>
                </ul>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-file-pdf-o"></i> SOP
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> SSR SOP</a></li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Gen21 SOP</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <!--CA MENU-->
          <li>
            <a href="#">
              <i class="fa  fa-lock"></i> Conditional Acces
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="#">
                  <i class="fa fa-bar-chart"></i> Traffic Bmail+OSD
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-circle-o"></i> Bmail+OSD Daily
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-circle-o"></i> Bmail+OSD Monthly
                    </a>
                  </li>
                </ul>
              </li>
               <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i>Projects
                </a>
              </li> 
              <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i>Work Log
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-file-pdf-o"></i> SOP
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li>
                    <a href="<?= base_url('sop/c_sop');?>">
                      <i class="fa fa-circle-o"></i> Level Three
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-circle-o"></i> Level Three
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li>
        <a href="pages/calendar.html">
          <i class="fa fa-line-chart"></i>
          <span>Projects</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-red">2</small>
          </span>
        </a>
      </li>
       <li>
        <a href="pages/calendar.html">
          <i class="fa fa-calendar"></i>
          <span>Agenda</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-red">3</small>
            <small class="label pull-right bg-blue">17</small>
          </span>
        </a>
      </li>
      <li>
        <a href="pages/widgets.html">
          <i class="fa fa-sitemap"></i>
          <span>Structure Organitation</span>
            <span class="pull-right-container">
            </span>
        </a>
      </li>
      <li>
        <a href="pages/widgets.html">
          <i class="fa fa-picture-o"></i>
          <span>Album</span>
          <span class="pull-right-container">
            <small class="label pull-right bg-green">new</small>
          </span>
        </a>
      </li>
      <li class="active">
        <a href="#">
          <i class="fa fa-link"></i>
          <span>Link</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-link"></i>
          <span>Another Link</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-link"></i>
          <span>Multilevel</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="#">Link in level 2</a>
          </li>
          <li>
            <a href="#">Link in level 2</a>
          </li>
        </ul>
      </li>
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>