<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moja_strona";

$login = "admin";
$pass = "kopytko";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
?>
