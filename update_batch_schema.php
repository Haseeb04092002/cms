<?php
define('BASEPATH', true);
define('ENVIRONMENT', 'development');

require 'application/config/database.php';

$host = $db['default']['hostname'];
$user = $db['default']['username'];
$pass = $db['default']['password'];
$db_name = $db['default']['database'];

$conn = new mysqli($host, $user, $pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$years = [];
for ($i = 2010; $i <= 2030; $i++) {
    $next_year = substr((string)($i + 1), -2);
    $years[] = "'" . $i . "-" . $next_year . "'";
}
$enum_str = implode(',', $years);

$res = $conn->query("SELECT TABLE_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$db_name' AND COLUMN_NAME = 'batchYear'");
while ($row = $res->fetch_assoc()) {
    $table = $row['TABLE_NAME'];
    $sql = "ALTER TABLE $table MODIFY COLUMN batchYear ENUM($enum_str) DEFAULT NULL";
    if ($conn->query($sql) === TRUE) {
        echo "Table '$table' altered successfully to new batchYear format.<br>";
    } else {
        echo "Error altering table '$table': " . $conn->error . "<br>";
    }
}
echo "<br><strong>All done! You can now delete this file.</strong>";
