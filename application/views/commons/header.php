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

<style>
  .nav-divider {
    width: 2px;
    height: 38px;
    background-color: #949494;
    margin: 0 18px;
  }

  .nav-divider-sm {
    width: 2px;
    height: 38px;
    background-color: #949494;
    margin: 0 12px;
  }


  #navbarPageTitle {
    text-transform: capitalize;
  }
</style>

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
    <!--  -->
    <div class="d-none d-lg-flex w-100 align-items-center justify-content-between">

      <div class="d-flex align-items-center">

        <?php
        $StationId = (int)$this->session->userdata('station_id') ?? '';
        $imgUrl = base_url('assets/img/schoolium-logo.png');
        if ($StationId === 1001) {
          $imgUrl = base_url('assets/img/inklings-logo.webp');
        }
        if ($StationId === 1002) {
          $imgUrl = base_url('assets/img/oes-logo-2.png');
        }
        ?>
        <img src="<?= $imgUrl ?>" class="img-fluid" style="max-height:50px;">

        <div class="nav-divider d-none d-lg-block"></div>

        <div class="d-none d-lg-block">
          <div id="navbarPageTitle"
            class="fw-semibold text-dark"
            style="font-size:18px; letter-spacing:0.4px;">
            Dashboard
          </div>
        </div>

      </div>

      <div class="d-flex align-items-center gap-2">

        <button id="frame-refresh" class="btn btn-success btn-sm">
          Refresh
        </button>

        <div class="btn-group btn-group-sm">
          <button id="backFrame" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i>
            Prev
          </button>
          <button id="forwardFrame" class="btn btn-primary">
            <i class="bi bi-arrow-right"></i>
            Next
          </button>
        </div>

        <div class="nav-divider-sm"></div>

        <a href="https://inklings.com.pk/" target="_blank"
          target="_blank"
          class="btn btn-secondary btn-sm">
          School Website
        </a>

        <a href="https://itimium.com.pk/" target="_blank"
          class="btn btn-secondary btn-sm">
          Help
        </a>

        <!-- Chatting -->
        <!-- <a href="<?= site_url('Chatting') ?>"
          class="navigator btn btn-secondary btn-sm">
          <i class="bi bi-chat-dots me-1"></i>
          Chat
        </a> -->

        <!-- Divider -->
        <div class="nav-divider-sm"></div>

        <?php if (!empty($UserId)): ?>
          <a href="<?= site_url('Login/logout') ?>" class="btn btn-dark btn-sm">
            <!-- <i class="bi bi-box-arrow-right me-1"></i> -->
            Logout <span class="text-uppercase badge bg-white text-dark p-1 mx-1"><?= $this->session->userdata('user_role') ?></span>
          </a>
        <?php endif; ?>

        <?php if (empty($UserId)): ?>
          <a href="<?= site_url('Login') ?>" class="btn btn-dark btn-sm">
            <!-- <i class="bi bi-box-arrow-in-right me-1"></i> -->
            Login
          </a>
        <?php endif; ?>

      </div>

    </div>

    <!-- <div class="container-fluid">
      <div class="d-flex align-items-center gap-2">
        <a class="nav-link navigator" href="<?= site_url('fee/heads') ?>">Heads</a>
        <a class="nav-link navigator" href="<?= site_url('fee/structure') ?>">Structure</a>
        <a class="nav-link navigator" href="<?= site_url('fee/services') ?>">Services</a>
        <a class="nav-link navigator" href="<?= site_url('fee/student_services') ?>">Student Services</a>
        <a class="nav-link navigator" href="<?= site_url('fee/discounts') ?>">Discounts</a>
        <a class="nav-link navigator" href="<?= site_url('fee/student_discounts') ?>">Student Discounts</a>
        <a class="nav-link navigator" href="<?= site_url('fee/generate') ?>">Generate</a>
        <a class="nav-link navigator" href="<?= site_url('fee/challans') ?>">Challans</a>
        <a class="nav-link navigator" href="<?= site_url('fee/cash_counter') ?>">Cash Counter</a>
        <a class="nav-link navigator" href="<?= site_url('fee/bank_pending') ?>">Bank Pending</a>
        <a class="nav-link navigator" href="<?= site_url('fee/ledger') ?>">Ledger</a>
      </div>
    </div> -->

  </div>

</nav>


<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav> -->




<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->

<!-- </nav> -->
<!-- <div class="container py-3">
  <h4 class="mb-3"><?= htmlspecialchars($title ?? '') ?></h4>
</div> -->




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