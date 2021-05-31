<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>dashboard/" class="brand-link">
      
      <span class="brand-text font-weight-light">Eirev Microfinance <br/> Web Information System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block">Hi <?php echo $this->session->fullname; ?>!</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview <?php if($menu == 'maintenance'){ echo 'menu-open'; } ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Maintenance
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url()?>maintenance/user_accounts" class="nav-link <?php if($menu == 'maintenance' && $submenu == 'user_accounts'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?php echo base_url()?>maintenance/interest_rate" class="nav-link <?php if($menu == 'maintenance' && $submenu == 'interest_rate'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Interest rate</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php if($menu == 'transaction'){ echo 'menu-open'; } ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Transaction
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url()?>transaction/collection" class="nav-link <?php if($menu == 'transaction' && $submenu == 'collection'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Central Collection</p>
                </a>
              </li>
              <li class="nav-item has-treeview <?php if($menu == 'transaction' && $submenu == 'loan_management'){ echo 'menu-open'; } ?>">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Loan Management  <i class="right fas fa-angle-left"></i></p>
									
                </a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
                    <a href="<?php echo base_url()?>transaction/loans_for_release" class="nav-link <?php if($menu == 'transaction' && $submenu == 'loan_management' && $subsubmenu == 'for_release'){ echo 'active'; } ?>">
                      <i class="fas fa-file-invoice nav-icon"></i>
                      <p>For release</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo base_url()?>transaction/active_loans" class="nav-link <?php if($menu == 'transaction' && $submenu == 'loan_management' && $subsubmenu == 'active_loans'){ echo 'active'; } ?>">
                      <i class="fas fa-money-bill-alt nav-icon"></i>
                      <p>Active Loans</p>
                    </a>
                  </li>
									<li class="nav-item">
                    <a href="<?php echo base_url()?>transaction/loans_overdue" class="nav-link <?php if($menu == 'transaction' && $submenu == 'loan_management' && $subsubmenu == 'overdue'){ echo 'active'; } ?>">
                      <i class="fas fa-book nav-icon"></i>
                      <p>Loans Overdue</p>
                    </a>
                  </li>
								</ul>
              </li>
              <li class="nav-item ">
                <a href="<?php echo base_url()?>transaction/application" class="nav-link <?php if($menu == 'transaction' && $submenu == 'application'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Applications</p>
                </a>
              </li>
							<li class="nav-item ">
                <a href="<?php echo base_url()?>transaction/verify_accounts" class="nav-link <?php if($menu == 'transaction' && $submenu == 'verify_accounts'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Verify Accounts</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php if($menu == 'reports'){ echo 'menu-open'; } ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url()?>reports/report_and_sales" class="nav-link <?php if($menu == 'reports' && $submenu == 'sales_market'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales and <br/>Marketing Reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url()?>reports/loan_reports" class="nav-link <?php if($menu == 'reports' && $submenu == 'loan_reports'){ echo 'active'; } ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Loan Reports</p>
                </a>
              </li>
            </ul>
          </li>
					<li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>site/logout" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
