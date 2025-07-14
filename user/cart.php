<?php
session_start();  // Start the session

// Include the database connection file
include('../includes/db.php');

// Fetch cart items if POST request is made (i.e., adding to the cart)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Initialize the cart if not already initialized
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // If product is not found in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = ['product_id' => $product_id, 'quantity' => $quantity];
    }
}

// Fetch the product details from the cart
$cart_items = [];
$total = 0;

// Ensure that the cart is not empty before processing
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Loop through the cart items
    foreach ($_SESSION['cart'] as $item) {
        // SQL query to fetch product details by product ID
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query); // Prepare statement (procedural)
        mysqli_stmt_bind_param($stmt, 'i', $item['product_id']); // Bind the product_id parameter
        mysqli_stmt_execute($stmt); // Execute query
        $result = mysqli_stmt_get_result($stmt); // Get result from the query

        // Fetch product details
        $product = mysqli_fetch_assoc($result);

        // If the product exists, add to the cart items
        if ($product) {
            $cart_items[] = $product;
            $total += $product['price'] * $item['quantity']; // Calculate total price
        }
    }
}
?>

<?php include('header.php'); ?>

<div class="container my-5">
    <h2>Your Cart</h2>

    <!-- Check if there are items in the cart -->
    <?php if (!empty($cart_items)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= $item['price'] ?></td>
                        <td>$<?= $item['price'] * $item['quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: $<?= $total ?></h3>
        <a href="checkout.php" class="btn btn-pink">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include('user_footer.php'); ?>
