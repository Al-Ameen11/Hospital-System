<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'hospital_db';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
function esc($str){
    global $conn;
    return htmlspecialchars($conn->real_escape_string(trim($str)));
}
?>
