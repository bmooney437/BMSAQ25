<?php
session_start();

// Database connection settings
$servername = "webhost1.eeecs.qub.ac.uk";
$db_username = "root";
$db_password = "";
$dbname = "bmsaq";

// Set header to output JSON
header('Content-Type: application/json');

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password_input = trim($_POST["password"]);

    // Create the database connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "error" => "Database connection failed."]);
        exit();
    }

    // Use a prepared statement to prevent SQL injection.
    // Note: We're assuming the teacher’s primary email is stored in the column `email1_value`
    $stmt = $conn->prepare("SELECT id, password FROM teachers WHERE email1_value = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($teacher_id, $hashed_password);
        $stmt->fetch();

        // Check if the provided password matches the stored hashed password.
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
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method."]);
}
?>
