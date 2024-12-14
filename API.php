<?php
header('Access-Control-Allow-Origin: *'); // Mengizinkan semua domain mengakses
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Mengizinkan metode HTTP tertentu
header('Access-Control-Allow-Headers: Content-Type'); // Mengizinkan header tertentu

// Set the content type to JSON
header('Content-Type: application/json');

// Database configuration
$host = 'localhost:3307'; // Ganti sesuai konfigurasi Anda
$dbname = 'monitor_kolam_lele'; // Nama database Anda
$username = 'root'; // Username database Anda
$password = ''; // Password database Anda

try {
    // Establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve data from POST request
        $suhu = $_POST['suhu']; // Suhu yang dikirim dari ESP32

        // Validate data
        if (!is_numeric($suhu)) {
            echo json_encode(['success' => false, 'message' => 'Invalid suhu value']);
            exit;
        }

        // Prepare SQL statement for inserting data
        $stmt = $pdo->prepare("INSERT INTO sensor_suhu (suhu) VALUES (:suhu)");
        $stmt->bindParam(':suhu', $suhu);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert data']);
        }
    } else {
        // If request method is not POST, return an error
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    // Handle SQL error
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
