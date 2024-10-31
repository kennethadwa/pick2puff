<?php
// Start output buffering to prevent headers already sent error
ob_start();
include("../connect.php");

// Get the current page number from the query string or set it to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

// Get the total count of items
$total_items_query = mysqli_query($con, "SELECT COUNT(*) as total FROM items");
$total_items_result = mysqli_fetch_assoc($total_items_query);
$total_items = $total_items_result['total'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch items for the current page
// Fetch items for the current page in descending order by id
$result_items = mysqli_query($con, "SELECT * FROM items ORDER BY id DESC LIMIT $offset, $items_per_page");


// Handle Item CRUD operations (same as before)
if (isset($_POST["btnadditem"])) {
    $itemname = $_POST["itemname"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $categoryid = $_POST["categoryid"];
    $target = "images/";
    $img = $target . basename($_FILES["img"]["name"]);

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $img)) {
        mysqli_query($con, "INSERT INTO items (itemname, description, price, quantity, categoryid, img) VALUES ('$itemname', '$description', $price, $quantity, $categoryid, '$img')");
        header("Location: index.php?pg=items");
        exit(); // Exit to prevent further execution
    }
}

// Other item operations remain unchanged...

// End output buffering and send output
ob_end_flush();
?>

<section>
    <div class="card mt-3">
        <div class="card-header text-center">
            Items
            <button class="btn btn-outline-dark btn-sm float-end" data-bs-toggle="collapse" data-bs-target="#addItemForm">Add Item</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category ID</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_items)) { ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["itemname"]; ?></td>
                            <td><?php echo $row["description"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td><?php echo $row["categoryid"]; ?></td>
                            <td style="max-width: 100px; max-height: 100px;">
                                <img src="<?php echo $row["img"]; ?>" style="max-width:100%; max-height:100%;" alt="Item Image">
                            </td>
                            <td>
                                <a href="index.php?pg=edit_item&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Update</a>
                                <br>
                                <a href="index.php?pg=items&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?pg=items&page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?pg=items&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?pg=items&page=<?php echo $page + 1; ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <!-- Add Item Form -->
            <div class="collapse" id="addItemForm">
                <form action="index.php?pg=items" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="itemname" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="itemname" name="itemname" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryid" class="form-label">Category ID</label>
                        <input type="number" class="form-control" id="categoryid" name="categoryid" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Image</label>
                        <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                    <button type="submit" name="btnadditem" class="btn btn-success">Add Item</button>
                </form>
            </div>
        </div>
    </div>
</section>
