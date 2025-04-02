<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>
  <h2>Welcome to the Dashboard</h2>
  <p>You are logged in as teacher ID: <?php echo $_SESSION['teacher_id']; ?></p>
</body>
</html>
