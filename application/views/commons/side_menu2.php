<nav class="sidebar">
    <div class="menu_content">
        <ul class="menu_items">

            <li class="item">
                <a href="<?= site_url('Cms/dashboard') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-grid-alt"></i></span>
                    <span class="navlink">Dashboard</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Student/admission') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-user-plus"></i></span>
                    <span class="navlink">Admission</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Student/all_students') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-user"></i></span>
                    <span class="navlink">Students</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Classes/all_classes') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-building-house"></i></span>
                    <span class="navlink">Class & Section</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Fee/fees') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-money"></i></span>
                    <span class="navlink">Fee Management</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Tasks/task_assingment') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-money"></i></span>
                    <span class="navlink">Task Assignment</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/all_teachers') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-time-five"></i></span>
                    <span class="navlink">Time Table</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/all_teachers') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-chalkboard"></i></span>
                    <span class="navlink">Staff</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/student_attendance') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-book-open"></i></span>
                    <span class="navlink">Exams & Results</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/student_attendance') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-calendar-check"></i></span>
                    <span class="navlink">Attendance</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/reports') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-bar-chart-alt-2"></i></span>
                    <span class="navlink">Reports</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/all_expenses') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-wallet"></i></span>
                    <span class="navlink">Expenses</span>
                </a>
            </li>

            <li class="item">
                <a href="<?= site_url('Cms/all_expenses') ?>" class="nav_link navigator">
                    <span class="navlink_icon"><i class="bx bx-support"></i></span>
                    <span class="navlink">Tickets</span>
                </a>
            </li>

            <li class="item">
                <a href="https://inklings.com.pk" target="_blank" class="nav_link">
                    <span class="navlink_icon"><i class="bx bx-globe"></i></span>
                    <span class="navlink">School Website</span>
                </a>
            </li>

        </ul>

        <div class="bottom_content">
            <div class="bottom collapse_sidebar">
                <span>Developed by <a>Itimium</a></span>
            </div>
        </div>
    </div>
</nav>
<script>
    const submenuItems = document.querySelectorAll(".submenu_item");
    submenuItems.forEach((item, index) => {
        item.addEventListener("click", () => {
            item.classList.toggle("show_submenu");
            submenuItems.forEach((item2, index2) => {
                if (index !== index2) {
                    item2.classList.remove("show_submenu");
                }
            });
        });
    });
</script>