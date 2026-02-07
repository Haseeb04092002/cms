<nav class="navbar fixed-top bg-white border-bottom">
    <div class="container-fluid px-2">

        <!-- Left: Menu -->
        <button class="btn p-1"
            data-bs-toggle="offcanvas"
            data-bs-target="#sideMenu">
            <i class="bi bi-list fs-3"></i>
        </button>

        <!-- Center: Logo (TRUE CENTER) -->
        <div class="position-absolute start-50 translate-middle-x">
            <img src="<?= base_url('assets/img/schoolium-logo.png') ?>"
                alt="iTimium"
                height="38">
        </div>

        <!-- Right: Actions -->
        <div class="d-flex align-items-center gap-1">
            <button class="btn p-1 fs-5">
                🔔
            </button>

            <a href="<?= site_url('pwa/chat') ?>" class="btn p-1 fs-4 fw-bold">
                <!-- <i class="text-success bi bi-chat-dots fs-4 fw-bold"></i> -->
                <i class="fs-3 bi bi-chat-left-text-fill" style="color: #ffa700;"></i>
            </a>
        </div>

    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div style="height:56px"></div>