<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "artesanos";

$conn = new mysqli($host, $user, $pass, $dbname, 3307);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>