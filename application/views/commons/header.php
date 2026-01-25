<?php
$UserId = '';
$UserName = '';
$UserEmail = '';
$UserRole = '';
$StationId = '';
$UserId = $this->session->userdata('user_id') ?? '';
$UserName = $this->session->userdata('user_name') ?? '';
$UserEmail = $this->session->userdata('user_email') ?? '';
$UserRole = $this->session->userdata('user_role') ?? '';
$StationId = $this->session->userdata('station_id') ?? '';
?>

<!-- navbar -->
<nav class="navbar">
  <div class="logo_item">
    <i class="bx bx-menu" id="sidebarOpen"></i>
    <!-- <img src="<?= base_url('assets/img/oes-logo.png') ?>" alt=""></i> Campus Management System -->
    </i> Campus Management System
  </div>

  <div class="search_bar">
    <input type="text" placeholder="Search" />
  </div>

  <div class="navbar_content">
    <!-- <i class="bi bi-grid"></i> -->
    <?php if (!empty($UserId)): ?>
      <a href="<?= site_url('Login/logout') ?>" class="btn btn-sm btn-outline-secondary">Logout</a>
    <?php endif; ?>
    <?php if (empty($UserId)): ?>
      <a href="" class="btn btn-sm btn-outline-secondary">Login</a>
    <?php endif; ?>
    <!-- <a href="" class="btn btn-sm btn-outline-secondary">Change Campus</a> -->
    <!-- <i class='bx bx-sun' id="darkLight"></i> -->
    <!-- <a href="" id="frame-refresh"><i class="bi bi-arrow-clockwise">refresh</i></a> -->
    <a href="" title="Refresh" id="frame-refresh" class="btn btn-sm btn-success py-0"><i class="bi bi-arrow-clockwise text-light py-0"></i></a>
    <div class="btn-group" role="group" aria-label="Basic example">
      <a id="backFrame" title="Go Back" class="py-0 border btn-sm px-3 btn btn-primary"><i class="text-light bi bi-box-arrow-left"></i></a>
      <a id="forwardFrame" title="Go Forward" class="py-0 border btn-sm px-3 btn btn-primary"><i class="text-light bi bi-box-arrow-right"></i></a>
    </div>
    <i class='bx bx-bell'></i>
    <!-- <img src="<?= base_url('assets/img/profile.jpg') ?>" alt="" class="profile" /> -->
  </div>
</nav>