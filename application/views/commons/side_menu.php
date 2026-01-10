<!-- Sidebar -->
<nav id="sidebar" class="d-flex flex-column bg-primary text-white p-3 overflow-auto" style="width: 260px; min-height: 100vh; max-height: 100vh;">

    <!-- Brand -->
    <a href="dashboard.html" class="mb-3 d-flex align-items-center text-white text-decoration-none">
        <i class="bi bi-bootstrap fs-3 me-2"></i>
        <span class="fs-5 fw-bold">School-CMS</span>
    </a>
    <hr class="text-white-50">

    <!-- Menu Items -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item"><a href="<?= site_url('Cms/dashboard') ?>" class="nav-link navigator text-white"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li><a href="<?= site_url('Cms/admission') ?>" class="nav-link navigator text-white"><i class="bi bi-journal-plus me-2"></i> Online Admission</a></li>
        <li><a href="users.html" class="nav-link navigator text-white"><i class="bi bi-people me-2"></i> Users</a></li>
        <li><a href="portals.html" class="nav-link navigator text-white"><i class="bi bi-person-badge me-2"></i> Portals</a></li>
        <li><a href="attendance.html" class="nav-link navigator text-white"><i class="bi bi-calendar-check me-2"></i> Attendance</a></li>
        <li><a href="hr.html" class="nav-link navigator text-white"><i class="bi bi-briefcase me-2"></i> HR & Staff</a></li>
        <li><a href="reports.html" class="nav-link navigator text-white"><i class="bi bi-graph-up me-2"></i> Reports</a></li>
        <li><a href="notifications.html" class="nav-link navigator text-white"><i class="bi bi-bell me-2"></i> Notifications</a></li>
        <li><a href="timetable.html" class="nav-link navigator text-white"><i class="bi bi-table me-2"></i> Time Table</a></li>
        <li><a href="lms.html" class="nav-link navigator text-white"><i class="bi bi-book me-2"></i> LMS</a></li>
        <li><a href="fees.html" class="nav-link navigator text-white"><i class="bi bi-cash-stack me-2"></i> Fees</a></li>
        <li><a href="expenses.html" class="nav-link navigator text-white"><i class="bi bi-receipt me-2"></i> Expenses</a></li>
        <li><a href="grading.html" class="nav-link navigator text-white"><i class="bi bi-award me-2"></i> Grading</a></li>
        <li><a href="website_home.html" class="nav-link navigator text-white"><i class="bi bi-window me-2"></i> School Website</a></li>
        <li><a href="social_media.html" class="nav-link navigator text-white"><i class="bi bi-share me-2"></i> Social Media</a></li>
        <li><a href="hosting.html" class="nav-link navigator text-white"><i class="bi bi-cloud-upload me-2"></i> Hosting & Domain</a></li>
    </ul>

    <hr class="text-white-50 mt-auto">

    <!-- Admin Info -->
    <div class="d-flex align-items-center mt-2 py-2 px-1 bg-opacity-10 rounded sidebar-admin">
        <div class="avatar bg-white text-primary me-2">A</div>
        <div>
            <div class="fw-bold">Admin</div>
            <small class="text-white-50">Super Admin</small>
        </div>
    </div>
</nav>

<style>
/* Sidebar Gradient & Shadow */
.sidebar.bg-gradient {
    background: linear-gradient(180deg, #6a11cb, #2575fc);
    box-shadow: 4px 0 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

/* Brand */
#sidebar a {
    transition: transform 0.2s;
}
#sidebar a:hover {
    transform: scale(1.05);
}

/* Menu Links */
.sidebar .nav-link {
    border-radius: 0.5rem;
    margin-bottom: 0.3rem;
    padding: 0.55rem 0.75rem;
    transition: all 0.25s ease-in-out;
    position: relative;
}

/* Hover Effect with Color & Shadow */
.sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.2);
    transform: translateX(6px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    color: #fff;
}

/* Active Link Indicator */
.sidebar .nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background-color: #ffeb3b;
    border-radius: 0 3px 3px 0;
}

/* Icons */
.sidebar .nav-link i {
    font-size: 1.2rem;
}

/* Scrollbar Styling */
.sidebar::-webkit-scrollbar {
    width: 8px;
}
.sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.35);
    border-radius: 4px;
}
.sidebar::-webkit-scrollbar-track {
    background-color: rgba(255,255,255,0.05);
}

/* Avatar */
.avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
    font-size: 1rem;
}

/* Admin Info Hover */
.sidebar-admin:hover {
    background-color: rgba(255,255,255,0.15);
    cursor: pointer;
}

/* Responsive for small screens */
@media(max-width: 991.98px) {
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        z-index: 1050;
    }
}
</style>
