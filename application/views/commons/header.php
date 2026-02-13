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

<nav class="navbar bg-white border-bottom sticky-top py-2">
  <div class="container-fluid">

    <!-- MOBILE LAYOUT -->
    <div class="d-flex d-lg-none w-100 align-items-center justify-content-between">

      <!-- Left: Offcanvas -->
      <button class="btn btn-outline-dark btn-sm"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#mainSidebar">
        <i class="bi bi-list"></i>
      </button>

      <!-- Center: Logo -->
      <img src="<?= base_url('assets/img/schoolium-logo.png') ?>"
        class="img-fluid"
        style="max-height:32px;">

      <!-- Right: Buttons -->
      <div class="d-flex align-items-center gap-1">

        <button id="frame-refresh" class="btn btn-success btn-sm px-2">
          <i class="bi bi-arrow-clockwise"></i>
        </button>

        <div class="btn-group btn-group-sm">
          <button id="backFrame" class="btn btn-primary px-2">
            <i class="bi bi-box-arrow-left"></i>
          </button>
          <button id="forwardFrame" class="btn btn-primary px-2">
            <i class="bi bi-box-arrow-right"></i>
          </button>
        </div>

        <?php if (!empty($UserId)): ?>
          <a href="<?= site_url('Login/logout') ?>" class="btn btn-outline-secondary btn-sm px-2">
            Logout
          </a>
        <?php endif; ?>

      </div>
    </div>


    <!-- DESKTOP LAYOUT -->
    <div class="d-none d-lg-flex w-100 align-items-center justify-content-between">

      <!-- Left: Logo -->
      <img src="<?= base_url('assets/img/schoolium-logo.png') ?>"
        class="img-fluid"
        style="max-height:55px;">

      <!-- Center: Search -->
      <!-- <div style="width:300px;">
        <input type="text"
          class="form-control form-control-sm"
          placeholder="Search">
      </div> -->

      <!-- Right: Buttons -->
      <div class="d-flex align-items-center gap-2">

        <a href="" class="btn btn-success btn-sm">
          <i class="bi bi-arrow-clockwise"></i>
        </a>

        <div class="btn-group btn-group-sm">
          <a id="backFrame" class="btn btn-primary">
            <i class="bi bi-box-arrow-left"></i>
          </a>
          <a id="forwardFrame" class="btn btn-primary">
            <i class="bi bi-box-arrow-right"></i>
          </a>
        </div>

        <?php if (!empty($UserId)): ?>
          <a href="<?= site_url('Login/logout') ?>" class="btn btn-outline-secondary btn-sm">
            Logout
          </a>
        <?php endif; ?>

        <?php if (empty($UserId)): ?>
          <a href="" class="btn btn-outline-secondary btn-sm">
            Login
          </a>
        <?php endif; ?>

      </div>
    </div>

  </div>
</nav>




<audio id="NotificationSound" src="<?= base_url('assets/sounds/notify.mp3') ?>" preload="auto"></audio>

<script>
  function NotificationSound() {
    console.log('Playing notification sound');
    const a = document.getElementById('NotificationSound');
    if (a) {
      a.currentTime = 0;
      a.play().catch(() => {});
    }
  }
</script>