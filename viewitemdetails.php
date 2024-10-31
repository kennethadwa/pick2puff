<?php
include("connect.php");


$item_id = $_GET['id'];
$q = mysqli_query($con, "SELECT items.*, categories.category FROM items LEFT JOIN categories ON items.categoryid = categories.id WHERE items.id = $item_id");
$item = mysqli_fetch_array($q);

if (isset($_POST['add_to_cart'])) {
    $quantity = intval($_POST['quantity']);
    $clientid = $_SESSION["id"];
    
    $checkCart = mysqli_query($con, "SELECT * FROM cart WHERE clientid = '$clientid' AND itemid = '$item_id'");
    
    if (mysqli_num_rows($checkCart) > 0) {
        $updateCart = mysqli_query($con, "UPDATE cart SET quantity = quantity + $quantity WHERE clientid = '$clientid' AND itemid = '$item_id'");
    } else {
        $insertCart = mysqli_query($con, "INSERT INTO cart (clientid, itemid, quantity) VALUES ('$clientid', '$item_id', '$quantity')");
    }
    echo "<script>alert('Item added to cart!'); window.location = 'index.php?pg=shop';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Details</title>
    <link rel="stylesheet" href="path/to/your/bootstrap.css">
</head>
<body>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-5">
                    <div class="card h-100 shadow-lg border-0 rounded-lg overflow-hidden">
                        <div class="d-flex justify-content-center align-items-center bg-dark">
                            <img class="card-img-top p-3" src="admin/<?php echo $item["img"]; ?>" alt="Product Image" style="width: 250px; height: 250px; object-fit: cover;">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="fw-bold"><?php echo $item["itemname"]; ?></h5>
                            <p class="text-muted"><?php echo $item["description"]; ?></p>
                            <div class="mb-2"><span class="badge bg-secondary"><?php echo $item["category"]; ?></span></div>
                            <h6 class="text-primary fw-bolder mb-3">₱<?php echo number_format($item["price"], 2); ?></h6>

                            <form method="POST" class="d-flex flex-column align-items-center">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <button type="button" onclick="decreaseQuantity()" class="btn btn-sm btn-outline-secondary">-</button>
                                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $item["quantity"]; ?>" value="1" class="form-control mx-2 text-center" style="width: 60px;">
                                    <button type="button" onclick="increaseQuantity()" class="btn btn-sm btn-outline-secondary">+</button>
                                </div>
                                <p><strong>Available:</strong> <?php echo $item["quantity"]; ?></p>
                                <button type="submit" name="add_to_cart" class="btn btn-dark mt-3 px-4">Add to Cart</button>
                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 text-center">
                            <a href="index.php?pg=shop" class="btn btn-outline-dark px-3">Back to Shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    function increaseQuantity() {
        var qtyInput = document.getElementById("quantity");
        if (qtyInput.value < <?php echo $item["quantity"]; ?>) {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        }
    }

    function decreaseQuantity() {
        var qtyInput = document.getElementById("quantity");
        if (qtyInput.value > 1) {
            qtyInput.value = parseInt(qtyInput.value) - 1;
        }
    }
    </script>
</body>
</html>
