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
        /* Background */
        .login-wrapper {
            min-height: 100vh;
            /* background: linear-gradient(135deg, #4f46e5, #3b82f6); */
            background: linear-gradient(135deg, #e54646, #3b82f6);
            padding: 20px;
        }

        /* Card */
        .login-card {
            max-width: 420px;
            width: 100%;
            border: none;
            animation: fadeIn 0.6s ease-in-out;
        }

        /* Logo */
        .login-logo {
            width: 90px;
            height: auto;
        }

        /* Inputs */
        .login-input .input-group-text {
            background: #f8f9fa;
            border-right: 0;
            color: #6c757d;
        }

        .login-input .form-control {
            border-left: 0;
            padding: 12px;
        }

        .login-input .form-control:focus {
            box-shadow: none;
            border-color: #3b82f6;
        }

        /* Button */
        .login-btn {
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        /* Animation */
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
    </style>

    <!-- Main Content -->
    <main class="login-wrapper d-flex justify-content-center align-items-center">
        <div class="card login-card shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-4">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Company Logo" class="login-logo">
                    <h3 class="mt-3 fw-bold">Welcome Back</h3>
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
                        var url = "<?= base_url('Pwa') ?>";
                        console.log(url);
                        window.location.href = url;
                    }
                }
            });
        });
    </script>

</body>

</html>