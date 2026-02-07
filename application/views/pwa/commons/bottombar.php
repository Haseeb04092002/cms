<?php
$active = $active ?? '';
?>
<style>
    /* ===============================
   ACTIVE (PHP + JS)
   =============================== */

    .pwa-nav-item.active,
    .pwa-nav-item.active-menu {
        color: var(--brand-orange) !important;
        font-weight: 600;
    }

    /* Active icon */
    .pwa-nav-item.active i,
    .pwa-nav-item.active-menu i {
        color: var(--brand-orange);
        transform: translateY(-1px);
    }

    /* Active underline indicator */
    .pwa-nav-item.active::after,
    .pwa-nav-item.active-menu::after {
        content: '';
        width: 18px;
        height: 3px;
        background: var(--brand-orange);
        border-radius: 3px;
        margin-top: 4px;
    }

    /* Touch feedback */
    .pwa-nav-item:active {
        transform: scale(.95);
    }
</style>
<nav class="navbar fixed-bottom pwa-bottom-nav bg-white bg-gradient border-top">
    <div class="container-fluid px-2">
        <div class="row w-100 text-center g-0">

            <div class="col">
                <a href="<?= site_url('pwa/dashboard/Student') ?>"
                    class="pwa-nav-item navigator bottom-menu fw-bold text-dark <?= ($active == 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="col">
                <a href="<?= site_url('pwa/tasks') ?>"
                    class="pwa-nav-item navigator bottom-menu fw-bold text-dark <?= ($active == 'tasks') ? 'active' : '' ?>">
                    <i class="bi bi-list-task"></i>
                    <span>Tasks</span>
                </a>
            </div>

            <div class="col">
                <a href="<?= site_url('pwa/progress') ?>"
                    class="pwa-nav-item navigator bottom-menu fw-bold text-dark <?= ($active == 'progress') ? 'active' : '' ?>">
                    <i class="bi bi-bar-chart"></i>
                    <span>Progress</span>
                </a>
            </div>

            <div class="col">
                <a href="<?= site_url('pwa/fees') ?>"
                    class="pwa-nav-item navigator bottom-menu fw-bold text-dark <?= ($active == 'fees') ? 'active' : '' ?>">
                    <i class="bi bi-cash"></i>
                    <span>Fees</span>
                </a>
            </div>

            <div class="col">
                <a href="<?= site_url('pwa/calendar') ?>"
                    class="pwa-nav-item navigator bottom-menu fw-bold text-dark <?= ($active == 'calendar') ? 'active' : '' ?>">
                    <i class="bi bi-calendar"></i>
                    <span>Calendar</span>
                </a>
            </div>

        </div>
    </div>
</nav>

<div style="height:72px"></div>