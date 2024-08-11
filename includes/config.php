<?php
if (!defined('DB_HOST')) {
    define('DB_HOST', 'lrgs.ftsm.ukm.my');
}

if (!defined('DB_USER')) {
    define('DB_USER', 'a188250');
}

if (!defined('DB_PASS')) {
    define('DB_PASS', 'tinyblackgoat');
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'a188250');
}

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error($conn));

try {
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>
