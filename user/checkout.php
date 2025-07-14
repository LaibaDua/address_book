<?php
session_start();

// Correct the path to db.php
include('../includes/db.php');

// Process checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $total = 0;

    // Calculate the total price of the cart
    foreach ($_SESSION['cart'] as $item) {
        // Fetch product details from the database
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query); // Using MySQLi in procedural style
        mysqli_stmt_bind_param($stmt, 'i', $item['product_id']); // Bind the product_id
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        $total += $product['price'] * $item['quantity']; // Calculate total price
    }

    // Insert order into the orders table
    $query = "INSERT INTO orders (user_id, total) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query); // Prepare the query
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $total);
    mysqli_stmt_execute($stmt);

    // Get the last inserted order ID
    $order_id = mysqli_insert_id($conn);

    // Insert order details into the order_details table
    foreach ($_SESSION['cart'] as $item) {
        $query = "SELECT price FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $item['product_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        // Insert the order details
        $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iiid', $order_id, $item['product_id'], $item['quantity'], $product['price']);
        mysqli_stmt_execute($stmt);
    }

    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    // Redirect to the order confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit(); // Ensure no further code is executed
}
?>

<?php include('header.php'); ?> <!-- Corrected path for header -->

<div class="container my-5">
    <h2>Checkout</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="user_id" class="form-label">Your ID</label>
            <input type="text" class="form-control" id="user_id" name="user_id" required>
        </div>
        <button type="submit" class="btn btn-pink">Place Order</button>
    </form>
</div>

<?php include('user_footer.php'); ?> <!-- Corrected path for footer -->
