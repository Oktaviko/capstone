<?php
header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain mengakses
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Mengizinkan metode HTTP tertentu
header('Access-Control-Allow-Headers: Content-Type'); // Mengizinkan header tertentu

// Set the content type to JSON
header('Content-Type: application/json');

// Database configuration
$host = 'localhost:3307'; // Sesuaikan dengan konfigurasi database Anda
$dbname = 'monitor_kolam_lele'; // Nama database Anda
$username = 'root'; // Username database Anda
$password = ''; // Password database Anda

try {
    // Establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement for selecting the latest data
    $stmt = $pdo->prepare("SELECT suhu, timestamp FROM sensor_suhu ORDER BY timestamp DESC LIMIT 1");
    $stmt->execute();

    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if there are results
    if ($result) {
        // Output the data as JSON
        echo json_encode(['success' => true, 'data' => $result]);
    } else {
        // Output no data found
        echo json_encode(['success' => false, 'message' => 'No data found']);
    }
} catch (PDOException $e) {
    // Handle SQL error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
