<?php
session_start();

// Enable error reporting for debugging (remove or disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Use output buffering to prevent accidental output before our JSON response
ob_start();

// Set header for JSON response
header('Content-Type: application/json');

// Database connection settings
$servername   = "webhost1.eeecs.qub.ac.uk";
$db_username  = "root";
$db_password  = "";
$dbname       = "bmsaq";

// Process only POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password_input = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    // Create the database connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "error" => "Database connection failed: " . $conn->connect_error]);
        exit();
    }

    // Prepare the SQL statement to avoid SQL injection.
    $stmt = $conn->prepare("SELECT id, password FROM teachers WHERE email1_value = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "error" => "SQL prepare failed: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a record was found
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($teacher_id, $hashed_password);
        $stmt->fetch();

        // Verify the password (ensure your passwords in the database are hashed)
        if (password_verify($password_input, $hashed_password)) {
            $_SESSION['teacher_id'] = $teacher_id;
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Invalid email or password."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid email or password."]);
    }

    $stmt->close();
    $conn->close();
    ob_end_flush();
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
?>
