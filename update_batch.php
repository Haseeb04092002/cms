<?php
mysqli_report(MYSQLI_REPORT_OFF);

$connections = [
    ['127.0.0.1', 'root', '', 'haseeb_cms', 3306],
    ['127.0.0.1', 'root', '', 'yrapnvhc_cms', 3306],
    ['127.0.0.1', 'root', '', 'haseeb_cms', 3307],
    ['127.0.0.1', 'yrapnvhc', 'Ziaulhassan@456', 'yrapnvhc_cms', 3306],
    ['localhost', 'root', '', 'haseeb_cms', 3306]
];

$conn = null;
foreach ($connections as $c) {
    $conn = new mysqli($c[0], $c[1], $c[2], $c[3], $c[4]);
    if (!$conn->connect_error) {
        break;
    }
}

if ($conn->connect_error) {
    die("Could not connect to database.");
}

$years = [];
for ($i = 2010; $i <= 2030; $i++) {
    $next_year = substr((string)($i + 1), -2);
    $years[] = "'" . $i . "-" . $next_year . "'";
}
$enum_str = implode(',', $years);

$db_name = $conn->query("SELECT DATABASE()")->fetch_row()[0];
echo "Connected to DB: $db_name\n";

$res = $conn->query("SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$db_name' AND COLUMN_NAME = 'batchYear'");
while ($row = $res->fetch_assoc()) {
    $table = $row['TABLE_NAME'];
    $sql = "ALTER TABLE $table MODIFY COLUMN batchYear ENUM($enum_str) DEFAULT NULL";
    if ($conn->query($sql) === TRUE) {
        echo "$table altered successfully.\n";
    } else {
        echo "Error altering $table: " . $conn->error . "\n";
    }
}
echo "Done";
