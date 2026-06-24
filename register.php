<?php
header('Content-Type: application/json');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters";
        exit;
    }

    // Check if email already exists
    $check_sql = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered";
        exit;
    }

    // Hash password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user with prepared statement
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')";
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        echo "Registration failed: " . mysqli_error($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Registration successful";
    } else {
        echo "Registration failed: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request method";
}
?>
