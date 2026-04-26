<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view('commons/header_meta');
    $this->load->view('commons/css_links');
    ?>
</head>

<body>

    <?php
    $this->load->view('commons/js_links');
    $this->load->view('commons/header');
    ?>

    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --white-color: #fff;
            --blue-color: #4070f4;
            --grey-color: #707070;
            --grey-color-light: #aaa;
        }

        body {
            background-color: #e7f2fd;
            transition: all 0.5s ease;
        }

        body.dark {
            background-color: #333;
        }

        body.dark {
            --white-color: #333;
            --blue-color: #fff;
            --grey-color: #f2f2f2;
            --grey-color-light: #aaa;
        }

        /* navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            left: 0;
            background-color: var(--white-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
            z-index: 1000;
            box-shadow: 0 0 2px var(--grey-color-light);
        }

        .logo_item {
            display: flex;
            align-items: center;
            column-gap: 10px;
            font-size: 22px;
            font-weight: 500;
            color: var(--blue-color);
        }

        /* .navbar img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        } */

        .search_bar {
            height: 47px;
            max-width: 430px;
            width: 100%;
        }

        .search_bar input {
            height: 100%;
            width: 100%;
            border-radius: 25px;
            font-size: 18px;
            outline: none;
            background-color: var(--white-color);
            color: var(--grey-color);
            border: 1px solid var(--grey-color-light);
            padding: 0 20px;
        }

        .navbar_content {
            display: flex;
            align-items: center;
            column-gap: 25px;
        }

        .navbar_content i {
            cursor: pointer;
            font-size: 20px;
            color: var(--grey-color);
        }

        /* sidebar */
        .sidebar {
            background-color: var(--white-color);
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            padding-top: 90px;
            padding-bottom: 70px;
            padding-left: 0px;
            padding-right: 10px;
            z-index: 100;
            overflow-y: scroll;
            box-shadow: 0 0 1px var(--grey-color-light);
            transition: all 0.5s ease;
        }

        .sidebar.close {
            padding: 60px 0;
            width: 80px;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .menu_content {
            position: relative;
        }

        .menu_title {
            margin: 15px 0;
            padding: 0 20px;
            font-size: 18px;
        }

        .sidebar.close .menu_title {
            padding: 6px 30px;
        }

        .menu_title::before {
            color: var(--grey-color);
            white-space: nowrap;
        }

        .menu_dahsboard::before {
            content: "Dashboard";
        }

        .menu_editor::before {
            content: "Editor";
        }

        .menu_setting::before {
            content: "Setting";
        }

        .sidebar.close .menu_title::before {
            content: "";
            position: absolute;
            height: 2px;
            width: 18px;
            border-radius: 12px;
            background: var(--grey-color-light);
        }

        .menu_items {
            padding: 0;
            list-style: none;
        }

        .navlink_icon {
            position: relative;
            font-size: 22px;
            min-width: 50px;
            line-height: 40px;
            display: inline-block;
            text-align: center;
            border-radius: 6px;
        }

        .navlink_icon::before {
            content: "";
            position: absolute;
            height: 100%;
            width: calc(100% + 100px);
            left: -20px;
        }

        .navlink_icon:hover {
            background: var(--blue-color);
        }

        .active-menu {
            background: var(--blue-color);
            color: white !important;
        }

        .sidebar .nav_link {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 4px 15px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--grey-color);
            white-space: nowrap;
        }

        .sidebar.close .navlink {
            display: none;
        }

        .nav_link:hover {
            color: var(--white-color);
            background: var(--blue-color);
        }

        .sidebar.close .nav_link:hover {
            background: var(--white-color);
        }

        .submenu_item {
            cursor: pointer;
        }

        .submenu {
            display: none;
        }

        .submenu_item .arrow-left {
            position: absolute;
            right: 10px;
            display: inline-block;
            margin-right: auto;
        }

        .sidebar.close .submenu {
            display: none;
        }

        .show_submenu~.submenu {
            display: block;
        }

        .show_submenu .arrow-left {
            transform: rotate(90deg);
        }

        .submenu .sublink {
            padding: 7px 10px 7px 55px;
        }

        .bottom_content {
            position: fixed;
            bottom: 60px;
            left: 0;
            width: 260px;
            cursor: pointer;
            transition: all 0.5s ease;
        }

        .bottom {
            position: absolute;
            display: flex;
            align-items: center;
            left: 0;
            justify-content: space-around;
            padding: 18px 0;
            text-align: center;
            width: 100%;
            color: var(--grey-color);
            border-top: 1px solid var(--grey-color-light);
            background-color: var(--white-color);
        }

        .bottom i {
            font-size: 20px;
        }

        .bottom span {
            font-size: 12px;
        }

        .sidebar.close .bottom_content {
            width: 50px;
            left: 15px;
        }

        .sidebar.close .bottom span {
            display: none;
        }

        .sidebar.hoverable .collapse_sidebar {
            display: none;
        }

        #sidebarOpen {
            display: none;
        }

        @media screen and (max-width: 768px) {
            #sidebarOpen {
                font-size: 25px;
                display: block;
                margin-right: 10px;
                cursor: pointer;
                color: var(--grey-color);
            }

            .sidebar.close {
                left: -100%;
            }

            .search_bar {
                display: none;
            }

            .sidebar.close .bottom_content {
                left: -100%;
            }
        }

        #loaderOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        #loaderOverlay.active {
            display: flex;
        }

        .loader {
            width: 50px;
            height: 165px;
            position: relative;
        }

        .loader::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            transform: translate(-50%, 0);
            width: 16px;
            height: 16px;
            background: #FF3D00;
            border-radius: 50%;
            animation: bounce 2s linear infinite;
        }

        .loader::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            height: 48px;
            width: 48px;
            background: #ffffff;
            border-radius: 4px;
            animation: rotate 2s linear infinite;
        }

        @keyframes bounce {

            0%,
            50%,
            100% {
                transform: translate(-50%, 0px);
                height: 20px;
            }

            20% {
                transform: translate(-25%, 85px);
                height: 28px;
            }

            25% {
                transform: translate(-25%, 110px);
                height: 12px;
            }

            70% {
                transform: translate(-75%, 85px);
                height: 28px;
            }

            75% {
                transform: translate(-75%, 108px);
                height: 12px;
            }
        }

        @keyframes rotate {

            0%,
            50%,
            100% {
                transform: rotate(0deg)
            }

            25% {
                transform: rotate(90deg)
            }

            75% {
                transform: rotate(-90deg)
            }
        }
    </style>

    <!-- ================= GLOBAL LOADER ================= -->
    <div id="loaderOverlay">
        <span class="loader"></span>
    </div>


    <div class="row g-0">

        <!-- Sidebar -->
        <div class="col-md-2">
            <?php $this->load->view('commons/side_menu2'); ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <main class="mt-5 pt-3" style="max-height: 90%;">

                <!-- <div class="content" id="main-content"> -->

                <div id="pageContent">
                    <!-- Ajax contents load here -->
                </div>
            </main>

        </div>

    </div>

    <script>
        var historyStack = [];
        var forwardStack = [];
        var currUrl = "";

        function showLoader() {
            $("#loaderOverlay").addClass("active");
        }

        function hideLoader() {
            $("#loaderOverlay").removeClass("active");
        }

        let activeAjaxRequests = 0;

        $(document).ajaxSend(function(event, jqxhr, settings) {

            if (settings.noLoader === true) return;

            activeAjaxRequests++;
            showLoader();
        });

        $(document).ajaxComplete(function(event, jqxhr, settings) {

            if (settings.noLoader === true) return;

            activeAjaxRequests--;

            if (activeAjaxRequests <= 0) {
                hideLoader();
                activeAjaxRequests = 0;
            }
        });


        $(document).on("submit", "form", function() {
            showLoader();
        });

        function loadPage(url) {
            showLoader();

            $.ajax({
                url: url,
                type: "GET",
                success: function(response, status, xhr) {

                    // 🔥 Load page content
                    $("#pageContent").html(response);

                    // 🔥 Read custom header
                    let pageTitle = xhr.getResponseHeader("X-Page-Title");

                    if (pageTitle) {
                        $("#navbarPageTitle").text(pageTitle);
                    } else {
                        $("#navbarPageTitle").text("Dashboard");
                    }

                    hideLoader();
                }
            });
        }


        currUrl = <?= json_encode(site_url('Cms/dashboard/') . $this->session->userdata('user_role')) ?>;
        loadPage(currUrl);
        historyStack.push(currUrl);

        // $(document).on("click", ".navigator", function(e) {
        //     e.preventDefault();

        //     var url = $(this).attr("href");

        //     if ($(this).hasClass("side-menu-links")) {
        //         $(".nav_link").removeClass("active active-menu");
        //         $(this).addClass("active-menu");
        //     }

        //     if (currUrl !== url) {
        //         historyStack.push(currUrl);
        //         forwardStack = [];
        //     }

        //     currUrl = url;
        //     loadPage(currUrl);
        // });

        $(document).on("click", ".navigator", function(e) {

            e.preventDefault();

            var url = $(this).attr("href");

            /* ================= CLOSE OFFCANVAS ================= */

            var offcanvasEl = document.getElementById('mainSidebar');
            if (offcanvasEl) {
                var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (offcanvas) {
                    offcanvas.hide();
                }
            }

            /* ================= MENU ACTIVE STATE ================= */

            if ($(this).hasClass("side-menu-links")) {
                $(".nav_link").removeClass("active active-menu");
                $(this).addClass("active-menu");
            }

            /* ================= PAGE HISTORY ================= */

            if (currUrl !== url) {
                historyStack.push(currUrl);
                forwardStack = [];
            }

            currUrl = url;

            /* ================= LOAD PAGE ================= */

            loadPage(currUrl);

        });

        $(document).on("click", "#frame-refresh", function(e) {
            e.preventDefault();
            if (currUrl) {
                loadPage(currUrl);
            }
        });

        $(document).on("click", "#backFrame", function(e) {
            e.preventDefault();

            if (historyStack.length > 0) {
                forwardStack.push(currUrl);
                currUrl = historyStack.pop();
                loadPage(currUrl);
            }
        });

        $(document).on("click", "#forwardFrame", function(e) {
            e.preventDefault();

            if (forwardStack.length > 0) {
                historyStack.push(currUrl);
                currUrl = forwardStack.pop();
                loadPage(currUrl);
            }
        });
    </script>

</body>

</html>