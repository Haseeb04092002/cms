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

    <!-- Main Content -->
    <main class="flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg rounded-4 overflow-hidden" style="max-width: 600px; width: 100%;">
            <div class="row g-0">
                <div class="col-md-12 p-4">
                    <h3 class="mb-4 text-center fw-bold">Login</h3>
                    <form id="LoginForm" class="d-flex flex-column gap-3">

                        <!-- <div class="input-group">
                            <select name="WarehouseId" id="WarehouseId" class="selectpicker form-control" data-live-search="true" title="Select shop">
                                <?php foreach ($all_warehouses as $record):
                                ?>
                                    <option value="<?= $record->WarehouseId ?>"><?= $record->Name ?> (<?= $record->Location ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope text-secondary"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Username" name="email" required>
                        </div>

                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock text-secondary"></i>
                            </span>
                            <input type="password" class="form-control border-start-0" placeholder="Password" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            Submit
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto text-center bg-light">
        <?php $this->load->view('commons/footer'); ?>
    </footer>

    <script>
        $(document).on('submit', '#LoginForm', function(e) {
            e.preventDefault();

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