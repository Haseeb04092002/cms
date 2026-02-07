<div class="offcanvas offcanvas-start w-75" id="sideMenu">

    <!-- Header -->
    <div class="offcanvas-header border-bottom">
        <img src="<?= base_url('assets/img/schoolium-logo.png') ?>"
                alt="iTimium"
                height="42">
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body p-0">

        <!-- Main Links -->
        <div class="list-group list-group-flush">

            <a href="<?= site_url('pwa/dashboard') ?>"
                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <i class="bi bi-speedometer2 fs-5 text-secondary"></i>
                <span>Dashboard</span>
            </a>

            <a href="#"
                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <i class="bi bi-question-circle fs-5 text-secondary"></i>
                <span>How to use</span>
            </a>

            <a href="<?= site_url('pwa/website') ?>"
                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <i class="bi bi-globe fs-5 text-secondary"></i>
                <span>School Website</span>
            </a>

            <a href="<?= site_url('pwa/support') ?>"
                class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <i class="bi bi-headset fs-5 text-secondary"></i>
                <span>Contact Support</span>
            </a>

            <a href="<?= site_url('pwa/logout') ?>"
                class="text-danger list-group-item list-group-item-action d-flex align-items-center gap-3">
                <i class="bi bi-headset fs-5 text-danger"></i>
                <span>Logout</span>
            </a>

        </div>

    </div>
</div>