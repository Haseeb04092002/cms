<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Challan - <?= $challan->challanNo ?></title>

    <style>
        @page {
            size: A4 landscape;
            margin: 7mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .main-wrapper {
            width: 100%;
        }

        .copy-wrapper {
            width: 32.5%;
            float: left;
            border: 1px solid #000;
            margin-right: 1%;
        }

        .copy-wrapper:last-child {
            margin-right: 0;
        }

        .header {
            text-align: center;
            padding: 5px;
            border-bottom: 1px solid #000;
        }

        .logo {
            font-size: 18px;
            font-weight: bold;
        }

        .school-address {
            font-size: 14px;
        }

        .bank-info {
            font-size: 12px;
            border-bottom: 1px solid #000;
            padding: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
        }

        .info-table td {
            border: none;
            padding: 2px 4px;
        }

        .fee-table th {
            background: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            font-size: 12px;
            padding: 4px;
            border-top: 1px solid #000;
        }

        .copy-title {
            text-align: right;
            font-weight: bold;
            margin-top: 5px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .logo-img {
            width: 110px;
            height: auto;
            display: block;
            margin: 0 auto 5px auto;
        }
    </style>
</head>

<body>

    <div class="main-wrapper clearfix">

        <?php
        $copies = ['STUDENT COPY', 'BANK COPY', 'SCHOOL COPY'];

        foreach ($copies as $copy):
        ?>

            <div class="copy-wrapper">

                <!-- HEADER -->
                <div class="header">

                    <?php
                    $imgUrl = base_url('assets/img/schoolium-logo.png');
                    $stationId = (int)$this->session->userdata('station_id') ?? '';
                    if ($stationId === 1001) {
                        $imgUrl = base_url('assets/img/inklings-logo.png');
                    }
                    if ($stationId === 1002) {
                        $imgUrl = base_url('assets/img/oes-logo-2.png');
                    }
                    ?>

                    <?php
                    if ($stationId === 1001):
                    ?>
                        <img class="logo-img" src="<?= $imgUrl ?>" />
                        <div class="logo">INKLINGS JUNIOR SCHOOL</div>
                        <div class="school-address">DHA - II, GATE NO. 02, ISLAMABAD.</div>
                    <?php endif; ?>

                    <?php
                    if ($stationId === 1002):
                    ?>
                        <img class="logo-img" src="<?= $imgUrl ?>" />
                        <div class="logo">OXBRIDGE SCHOOL</div>
                        <div class="school-address">BALKASAR, CHAKWAL.</div>
                    <?php endif; ?>


                </div>

                <!-- BANK INFO -->
                <div class="bank-info">
                    <strong>BANK:</strong> <?= $station->bankName ?? 'Bank of Punjab' ?>,
                    <?= $station->bankBranch ?? 'Near Giga Mall, DHA-2' ?><br>
                    <strong>Collection A/C#</strong>
                    <?= $station->bankAccountNumber ?? '_____________' ?>
                </div>

                <!-- STUDENT INFO -->
                <table class="info-table">
                    <tr>
                        <td width="35%">Issue Date:</td>
                        <td><strong><?= date('d/m/Y', strtotime($challan->issueDate)) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Due Date:</td>
                        <td><strong><?= date('d/m/Y', strtotime($challan->dueDate)) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Billing Month:</td>
                        <td><strong><?= date('F', mktime(0, 0, 0, $challan->challanMonth, 1)) ?></strong></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><strong><?= $student->firstName . ' ' . $student->lastName ?></strong></td>
                    </tr>
                    <tr>
                        <td>Class:</td>
                        <td><strong><?= $student->className ?></strong></td>
                    </tr>
                    <tr>
                        <td>Admission No:</td>
                        <td><strong><?= $student->admissionNo ?></strong></td>
                    </tr>
                </table>

                <!-- TITLE -->
                <div class="text-center" style="font-weight:bold;border-top:1px solid #000;border-bottom:1px solid #000;padding:3px;">
                    FEE CHALLAN
                </div>

                <!-- FEE TABLE -->
                <table class="fee-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th width="30%" class="text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $item->description ?></td>
                                <td class="text-right"><?= number_format($item->amount) ?>/-</td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td><strong>Payable within Due Date</strong></td>
                            <td class="text-right">
                                <strong><?= number_format($challan->netAmount) ?>/-</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Payable after Due Date</td>
                            <td class="text-right">
                                <?= number_format($challan->netAmount + ($station->lateFeePerDay ?? 50)) ?>/-
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- FOOTER -->
                <div class="footer">
                    <div>Pay via Mobile Banking, JazzCash, EasyPaisa, HBL Connect.</div>
                    <div style="margin-top:4px;">
                        Late Fee: Rs. <?= number_format($station->lateFeePerDay ?? 50) ?>/- per day after due date.
                    </div>

                    <div class="copy-title"><?= $copy ?></div>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</body>

</html>