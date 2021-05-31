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
          <a href="<?php echo base_url()?>client/profile" class="d-block">Hi <?php echo $this->session->fullname; ?>! <img alt="Verified Badge icon" src="<?php echo base_url(); ?>assets/images/verified-badge.png" style="height:28px;width:28px;"></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>client/loan_application" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Loan Application
              </p>
            </a>
          
          </li>
					<li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>client/billing_payment" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                Billing/Payment
              </p>
            </a>
            
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>client/loan_and_payment_history" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Loan and Payment History
              </p>
            </a>
            
          </li>
          
		<li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>client/logout" class="nav-link">
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
