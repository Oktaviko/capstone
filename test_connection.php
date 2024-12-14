<?php
$host = 'localhost';
$dbname = 'monitor_kolam_lele';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Koneksi ke database berhasil!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
