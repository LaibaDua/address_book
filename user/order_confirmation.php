<?php
$order_id = $_GET['order_id'];
include('includes/db.php');

// Fetch order details
$query = "SELECT * FROM orders WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include('header.php'); ?>

<div class="container my-5">
    <h2>Order Confirmation</h2>
    <p>Thank you for your order! Your order ID is: <?= $order['id'] ?></p>
    <p>Total: $<?= $order['total'] ?></p>
</div>

<?php include('footer.php'); ?>
