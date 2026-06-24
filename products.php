<?php
header('Content-Type: application/json');
include 'config.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action === 'fetch') {
    // Fetch all products
    $sql = "SELECT id, product_name, price, description FROM products ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $products = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        echo json_encode(['success' => true, 'products' => $products]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching products']);
    }
} 
elseif ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new product (with basic validation)
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Validation
    if (empty($product_name) || empty($price) || empty($description)) {
        echo "All fields are required";
        exit;
    }

    if (!is_numeric($price) || $price < 0) {
        echo "Price must be a valid positive number";
        exit;
    }

    // Insert product with prepared statement
    $sql = "INSERT INTO products (product_name, price, description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        echo "Failed to add product: " . mysqli_error($conn);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "sds", $product_name, $price, $description);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Product added successfully";
    } else {
        echo "Failed to add product: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} 
else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

mysqli_close($conn);
?>
