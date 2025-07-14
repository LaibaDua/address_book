<?php
// Include the database connection file
include('../includes/db.php');

// Fetch all products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch all products as an associative array
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include('header.php'); ?>

<div class="container my-5">
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/images/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text"><?= $product['description'] ?></p>
                        <p class="price">$<?= $product['price'] ?></p>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                            <button type="submit" class="btn btn-pink">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('user_footer.php'); ?>
