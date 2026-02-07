<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $this->load->view('pwa/commons/header_meta');
    $this->load->view('pwa/commons/css_links');
    ?>
</head>

<body>

    <?php
    $this->load->view('pwa/commons/js_links');
    $this->load->view('pwa/commons/topbar');
    $this->load->view('pwa/commons/offcanvas');
    ?>

    <!-- MAIN APP FRAME -->
    <main class="container-fluid px-0"
        style="
        padding-top:10px;
        padding-bottom:10px;
        height:100vh;
        overflow:hidden;
      ">

        <!-- SCROLLABLE CONTENT -->
        <div id="pageContent"
            class="h-100 overflow-auto p-3">

            <!-- AJAX / VIEW CONTENT LOADS HERE -->

        </div>
    </main>

    <?php $this->load->view('pwa/commons/bottombar'); ?>

    <script>
        var historyStack = [];
        var forwardStack = [];
        var currUrl = "";

        // Load Dashboard by default
        currUrl = <?= json_encode(site_url('Pwa/dashboard/') . $this->session->userdata('user_role')) ?>;

        console.log("currUrl == " + currUrl);

        $("#pageContent").load(currUrl);
        historyStack.push(currUrl);

        // Navigation click
        $(document).on("click", ".navigator", function(e) {
            e.preventDefault();

            var url = $(this).attr("href");

            if ($(this).hasClass("bottom-menu")) {
                $(".pwa-nav-item").removeClass("active"); // remove from all
                $(".pwa-nav-item").removeClass("active-menu"); // remove from all
                $(this).addClass("active-menu"); // add to clicked one
            }

            if (currUrl !== url) {
                historyStack.push(currUrl); // save current to back history
                forwardStack = []; // clear forward history
            }

            currUrl = url;
            console.log("currUrl == " + currUrl);
            $("#pageContent").load(currUrl);
        });
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/service-worker.js", {
                        scope: "/pwa/"
                    })
                    .then(reg => console.log("SW registered", reg.scope))
                    .catch(err => console.error("SW failed", err));
            });
        }
    </script>

</body>

</html>