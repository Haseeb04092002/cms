<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title) ?></title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      color: #111;
    }

    .header {
      text-align: center;
      margin-bottom: 10px;
    }

    .header h2 {
      margin: 0;
      font-size: 18px;
    }

    .header .sub {
      margin-top: 4px;
      font-size: 12px;
    }

    .meta {
      margin: 10px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #333;
      padding: 6px;
      vertical-align: top;
    }

    th {
      background: #eee;
    }

    .footer {
      position: fixed;
      bottom: -20px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 10px;
      color: #444;
    }

    .pageno:before {
      content: counter(page);
    }
  </style>
</head>

<body>

  <div class="header">
    <h2>Your School / Institute Name</h2>
    <div class="sub"><?= htmlspecialchars($title) ?></div>
  </div>

  <div class="meta">
    <strong>Filters:</strong>
    Class: <?= htmlspecialchars($filters['className'] ?: 'All') ?> |
    Section: <?= htmlspecialchars($filters['sectionName'] ?: 'All') ?>
  </div>

  <table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
      <tr>
        <th>Student Name</th>
        <th>Class</th>
        <th>Section</th>
        <th>Time Period</th>
        <th>Status / Value</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['studentName']) ?></td>
            <td><?= htmlspecialchars($r['className']) ?></td>
            <td><?= htmlspecialchars($r['sectionName']) ?></td>
            <td><?= htmlspecialchars($periodText) ?></td>
            <td><?= htmlspecialchars($r['value']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">No record found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>


  <div class="footer">
    Generated on: <?= date('d-M-Y h:i A') ?> | Page <span class="pageno"></span>
  </div>

</body>

</html>