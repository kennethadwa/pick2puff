<?php
include("../connect.php");

// Check if ID parameter is provided
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Fetch item details from the database
    $result = mysqli_query($con, "SELECT * FROM items WHERE id = $id");
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $itemname = $row["itemname"];
        $description = $row["description"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $categoryid = $row["categoryid"];
        $img = $row["img"];
    } else {
        echo "Item not found.";
        exit();
    }
} else {
    echo "ID parameter missing.";
    exit();
}

// Handle update operation
if(isset($_POST["btnupdateitem"])) {
    $id = $_POST["item_id"];
    $itemname = $_POST["itemname"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $categoryid = $_POST["categoryid"];

    // Update item in the database
    mysqli_query($con, "UPDATE items SET itemname = '$itemname', description = '$description', price = $price, quantity = $quantity, categoryid = $categoryid WHERE id = $id");

    // Optionally, you can also update the image if changed
    if(!empty($_FILES["img"]["name"])) {
        $img = "images/" . basename($_FILES["img"]["name"]);
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $img)) {
            mysqli_query($con, "UPDATE items SET img = '$img' WHERE id = $id");
        }
    }

    header("Location: index.php?pg=items");
    exit();
}
?>

<section>
    <div class="card mt-3">
        <div class="card-header text-center">
            Edit Item
        </div>
        <div class="card-body">
            <form action="edit_item.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="itemname" class="form-label">Item Name</label>
                    <input type="text" class="form-control" id="itemname" name="itemname" value="<?php echo $itemname; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo $description; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="categoryid" class="form-label">Category ID</label>
                    <input type="number" class="form-control" id="categoryid" name="categoryid" value="<?php echo $categoryid; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Current Image</label><br>
                    <img src="<?php echo $img; ?>" style="max-width:100px; max-height:100px;" alt="Current Image"><br><br>
                    <label for="img" class="form-label">Update Image (Optional)</label>
                    <input type="file" class="form-control" id="img" name="img">
                </div>
                <button type="submit" name="btnupdateitem" class="btn btn-primary">Update Item</button>
            </form>
        </div>
    </div>
</section>
