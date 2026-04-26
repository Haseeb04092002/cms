<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Task</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header .sub {
            margin-top: 4px;
            font-size: 13px;
        }

        .section {
            margin-bottom: 12px;
        }

        .label {
            font-weight: bold;
            width: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
        }

        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        .pageno:before {
            content: counter(page);
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Your School / Institute Name</h2>
        <div class="sub">Student Task</div>
    </div>

    <?php if (!empty($task)): ?>
        <?php $t = $task; ?>

        <!-- Basic Info -->
        <table>
            <tr>
                <td class="label">Task Title</td>
                <td><?= htmlspecialchars($t->taskTitle ?? '-') ?></td>
            </tr>

            <tr>
                <td class="label">Subject</td>
                <td><?= htmlspecialchars($t->subjectName ?? '-') ?></td>
            </tr>

            <tr>
                <td class="label">Student Name</td>
                <td>
                    <?= htmlspecialchars(($t->firstName ?? '') . ' ' . ($t->lastName ?? '')) ?>
                </td>
            </tr>

            <tr>
                <td class="label">Class</td>
                <td>
                    <?= htmlspecialchars($t->className ?? '-') ?>
                    (<?= htmlspecialchars($t->sectionName ?? '-') ?>)
                </td>
            </tr>

            <tr>
                <td class="label">Education Type</td>
                <td><?= htmlspecialchars($t->student_education_type ?? '-') ?></td>
            </tr>

            <tr>
                <td class="label">Assigned Date</td>
                <td>
                    <?= !empty($t->startDate) ? date('d-M-Y', strtotime($t->startDate)) : '-' ?>
                </td>
            </tr>

            <tr>
                <td class="label">Due Date</td>
                <td>
                    <?= !empty($t->endDate) ? date('d-M-Y', strtotime($t->endDate)) : '-' ?>
                </td>
            </tr>
        </table>

        <!-- Task Description -->
        <div class="section">
            <h4>Task Description</h4>
            <div style="border:1px solid #333; padding:10px; min-height:80px;">
                <?= nl2br(htmlspecialchars($t->description ?? '-')) ?>
            </div>
        </div>

        <!-- Attachment -->
        <?php if (!empty($t->documentPath)): ?>
            <div class="section">
                <h4>Attachment</h4>
                <p>
                    <?= htmlspecialchars($t->documentPath) ?>
                </p>
            </div>
        <?php endif; ?>

    <?php else: ?>

        <p>No task record found.</p>

    <?php endif; ?>

    <div class="footer">
        Generated on: <?= date('d-M-Y h:i A') ?> |
        Page <span class="pageno"></span>
    </div>

</body>

</html>