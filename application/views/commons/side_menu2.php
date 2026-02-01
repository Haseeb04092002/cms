<?php

$UserRole = $this->session->userdata('user_role') ?? '';

?>


<nav class="sidebar">
    <div class="menu_content">

        <ul class="menu_items">

            <!-- ================================ -->
            <!-- ADMIN MENUS -->
            <!-- ================================ -->

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/dashboard') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-speedometer2"></i></span>
                    <span class="navlink">Admin Dashboard</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Student/admission') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-person-plus"></i></span>
                    <span class="navlink">Admission</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Student/all_students') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-people"></i></span>
                    <span class="navlink">Students</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Classes/all_classes') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-building"></i></span>
                    <span class="navlink">Class & Section</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Fee/fees') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-cash-coin"></i></span>
                    <span class="navlink">Fee Management</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Tasks/task_assingment') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-list-check"></i></span>
                    <span class="navlink">Task Assignment</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Timetable/all_time_tables') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-clock-history"></i></span>
                    <span class="navlink">Time Table</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Subject/all_subjects') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-book"></i></span>
                    <span class="navlink">Subjects</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/all_teachers') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-person-video3"></i></span>
                    <span class="navlink">Teachers</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Exams/exam_dashboard') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-mortarboard"></i></span>
                    <span class="navlink">Exams & Results</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Attendance') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-calendar-check"></i></span>
                    <span class="navlink">Attendance</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Reports/reports') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-bar-chart"></i></span>
                    <span class="navlink">Reports</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/all_expenses') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-wallet2"></i></span>
                    <span class="navlink">Expenses</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Chatting') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="navlink">Chatting</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Admin') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/user_access_control') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-person-gear"></i></span>
                    <span class="navlink">Users</span>
                </a>
            </li>



            <!-- ================================ -->
            <!-- TEACHER MENUS -->
            <!-- ================================ -->

            <!-- Teacher Dashboard -->
            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/dashboard') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-speedometer2"></i></span>
                    <span class="navlink">My Dashboard</span>
                </a>
            </li>

            <!-- Attendance -->
            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/all_classes') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-clipboard-check"></i></span>
                    <span class="navlink">Attendance</span>
                </a>
            </li>

            <!-- My Tasks -->
            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/tasks') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-list-check"></i></span>
                    <span class="navlink">Task Assignment</span>
                </a>
            </li>

            <!-- My Timetable -->
            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/timetable') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-calendar-week"></i></span>
                    <span class="navlink">My Timetable</span>
                </a>
            </li>

            <!-- Notifications -->
            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Teacher/notifications') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-bell"></i></span>
                    <span class="navlink">Notifications</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Teacher') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Chatting/chats') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="navlink">Chatting</span>
                </a>
            </li>



            <!-- ================================ -->
            <!-- STUDENT MENUS -->
            <!-- ================================ -->

            <!-- Student Menus -->
            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/dashboard/Student') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-speedometer2"></i></span>
                    <span class="navlink">Student Dashboard</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/tasks_assignments') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-journal-text"></i></span>
                    <span class="navlink">Tasks & Assignments</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/my_progress') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-bar-chart-line"></i></span>
                    <span class="navlink">My Progress</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/my_fees') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-wallet2"></i></span>
                    <span class="navlink">My Fees</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/my_time_table') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-calendar3"></i></span>
                    <span class="navlink">My Time Table</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Cms/exams') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-pencil-square"></i></span>
                    <span class="navlink">Exams</span>
                </a>
            </li>

            <li class="<?= ($UserRole == 'Student') ? 'd-block' : 'd-none' ?> item">
                <a href="<?= site_url('Chatting/chats') ?>" class="nav_link navigator side-menu-links">
                    <span class="navlink_icon"><i class="bi bi-chat-square-text"></i></span>
                    <span class="navlink">Chatting</span>
                </a>
            </li>


            <li class="item">
                <a href="#" class="nav_link">
                    <span class="navlink_icon"><i class="bi bi-globe"></i></span>
                    <span class="navlink">School Website</span>
                </a>
            </li>

            <li class="item">
                <a href="https://itimium.com.pk" target="_blank" class="nav_link">
                    <span class="navlink_icon"><i class="bi bi-headset"></i></span>
                    <span class="navlink">Contact Support</span>
                </a>
            </li>

        </ul>

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