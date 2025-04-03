<?php
session_start();
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit();
}

// Read and decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing email or password.']);
    exit();
}

$email = trim($data['email']);
$password = trim($data['password']);

// Include the database connection
include('dpconnector.php');

// Prepare statement to avoid SQL injection
$stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM teachers WHERE email1_value = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $first_name, $last_name, $db_password);
    $stmt->fetch();
    
    // Compare plaintext passwords (for demo only)
    if ($password === $db_password) {
        $_SESSION['teacher_id'] = $id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid email or password.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid email or password.']);
}

$stmt->close();
$conn->close();
?>
