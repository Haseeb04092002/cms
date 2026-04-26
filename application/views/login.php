<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!doctype html>
<html lang="en">

<head>
    <?php
    $this->load->view('commons/header_meta');
    $this->load->view('commons/css_links');
    ?>
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

    <?php
    $this->load->view('commons/js_links');
    ?>

    <style>
        /* Import Google font */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        /* ================= BACKGROUND ================= */

        .login-wrapper {
            position: relative;
            min-height: 100vh;
            /* background: url('<?= base_url("assets/img/bg-wrapper-2.png") ?>') center/cover no-repeat; */
            padding: 20px;
        }

        .login-wrapper::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(3px);
        }

        /* ================= CARD ================= */

        .login-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 520px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            animation: fadeIn .5s ease;
        }

        /* ================= LOGO ================= */

        .login-logo {
            width: 160px;
            max-width: 70%;
        }

        /* ================= INPUTS ================= */

        .login-input .input-group-text {
            background: #f1f3f5;
            border-right: 0;
            color: #6c757d;
        }

        .login-input .form-control {
            border-left: 0;
            padding: 14px;
            font-size: 15px;
        }

        .login-input .form-control:focus {
            box-shadow: none;
            border-color: #3b82f6;
        }

        /* Select */

        select.form-select {
            padding: 13px;
            font-size: 15px;
        }

        /* ================= BUTTON ================= */

        .login-btn {
            padding: 14px;
            font-weight: 600;
            letter-spacing: .5px;
            border-radius: 10px;
            transition: .3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(59, 130, 246, .35);
        }

        /* ================= FOOTER ================= */

        .card-footer {
            background: #fff;
            border-top: 1px solid #eee;
        }

        /* ================= ANIMATION ================= */

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =====================================================
                MOBILE APP STYLE
===================================================== */

        @media (max-width:768px) {

            .login-wrapper {
                padding: 10px;
                align-items: center;
            }

            /* Full screen mobile feel */

            .login-card {
                max-width: 100%;
                border-radius: 20px;
            }

            /* Bigger logo */

            .login-logo {
                width: 140px;
            }

            /* App style spacing */

            .card-body {
                padding: 30px 22px;
            }

            /* Bigger inputs */

            .login-input .form-control {
                font-size: 16px;
                padding: 16px;
            }

            select.form-select {
                padding: 16px;
            }

            /* Bigger button */

            .login-btn {
                padding: 16px;
                font-size: 17px;
            }

            /* Titles */

            h3 {
                font-size: 22px;
            }

        }


        @media (max-width:480px) {

            .login-wrapper {
                padding: 6px;
            }

            .card-body {
                padding: 26px 18px;
            }

            .login-logo {
                width: 120px;
            }

            h3 {
                font-size: 20px;
            }

            .login-btn {
                font-size: 16px;
            }

        }
    </style>

    <!-- Main Content -->
    <main class="login-wrapper d-flex justify-content-center align-items-center">
        <div class="card login-card shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <?php
                    $StationId = (int)$this->session->userdata('station_id') ?? '';
                    // $imgUrl = base_url('assets/img/schoolium-logo.png');
                    $imgUrl = '';
                    if ($StationId === 1001) {
                        $imgUrl = base_url('assets/img/inklings-logo.webp');
                    }
                    if ($StationId === 1002) {
                        $imgUrl = base_url('assets/img/oes-logo-2.png');
                    }
                    ?>
                    <img src="<?= $imgUrl ?>" class="login-logo">
                    <!-- <h2 class="mt-3 fw-bold">School Management System</h2> -->
                    <h3 class="mt-3 fw-bold">School Management System</h3>
                    <p class="text-muted small">Please login to your account</p>
                </div>

                <form id="LoginForm" class="d-flex flex-column gap-3" data-parsley-validate>

                    <select class="form-select" name="userRole" id="userRole" required>
                        <option value="">-- Select User Role --</option>
                        <?php if (!empty($user_roles)): ?>
                            <?php foreach ($user_roles as $userRole): ?>
                                <option value="<?= $userRole->roleName ?>">
                                    <?= $userRole->roleName ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <div class="input-group login-input" id="username-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Username" name="email">
                    </div>

                    <div class="input-group login-input" id="password-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary login-btn">
                        Login
                    </button>

                </form>
            </div>
            <div class="card-footer">
                <h6 class="text-center p-2">Powered by <a href="https://itimium.com.pk" target="_blank">Itimium.com.pk</a> | Software Solutions</h6>
            </div>
        </div>
    </main>


    <!-- Footer -->
    <footer class="mt-auto text-center bg-light">
        <?php $this->load->view('commons/footer'); ?>
    </footer>

    <script>
        $(document).ready(function() {
            function toggleUsername() {
                var role = $('#userRole').val();

                if (role === 'Admin') {
                    $('#username-group').show(); // show username
                } else {
                    $('#username-group').hide(); // hide username
                }
            }

            // Initial check
            toggleUsername();

            // On change
            $('#userRole').change(function() {
                toggleUsername();
            });
        });

        $(document).off('submit', '#LoginForm');
        $(document).on('submit', '#LoginForm', function(e) {
            e.preventDefault();

            let form = $(this);

            if (!form.parsley().validate()) {
                return false;
            }

            // Reset previous highlights
            $("#LoginForm input").removeClass("is-invalid");
            $("#LoginForm select").removeClass("is-invalid");

            $.ajax({
                url: "<?= site_url('Login/login') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status === false) {
                        if (response.message.includes("Email")) {
                            $("input[name='email']").addClass("is-invalid");
                        }
                        if (response.message.includes("Password")) {
                            $("input[name='password']").addClass("is-invalid");
                        }
                        Swal.fire({
                            title: response.status ? 'Success' : 'Error',
                            text: response.message,
                            icon: response.status ? 'success' : 'error',
                            timer: 3000,
                            showConfirmButton: true
                        });

                    } else {
                        var url = "<?= base_url('Cms') ?>";
                        console.log(url);
                        window.location.href = url;

                    }
                }
            });
        });
    </script>

</body>

</html>