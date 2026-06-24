<?php
// Database Setup Script for FanTrade 2026
// Run this once to create the required tables

$conn = mysqli_connect("localhost", "root", "", "");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$create_db = "CREATE DATABASE IF NOT EXISTS fantrade2026";
if (mysqli_query($conn, $create_db)) {
    echo "✓ Database created successfully<br>";
} else {
    echo "✗ Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select database
mysqli_select_db($conn, "fantrade2026");

// Create users table
$create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $create_users)) {
    echo "✓ Users table created successfully<br>";
} else {
    echo "✗ Error creating users table: " . mysqli_error($conn) . "<br>";
}

// Create products table
$create_products = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $create_products)) {
    echo "✓ Products table created successfully<br>";
} else {
    echo "✗ Error creating products table: " . mysqli_error($conn) . "<br>";
}

// Create orders table (for future use)
$create_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
)";

if (mysqli_query($conn, $create_orders)) {
    echo "✓ Orders table created successfully<br>";
} else {
    echo "✗ Error creating orders table: " . mysqli_error($conn) . "<br>";
}

echo "<br><strong>Database setup completed!</strong>";
echo "<br>You can now delete this file or move it to a secure location.";

mysqli_close($conn);
?>
