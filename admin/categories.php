<?php
include("../connect.php");

// Handle Category CRUD operations
if(isset($_POST["btnaddcategory"])){
    $category = $_POST["category"];
    mysqli_query($con, "INSERT INTO categories (category) VALUES ('$category')");
    header("Location: index.php?pg=categories");
    exit();
}

if(isset($_POST["btnupdatecategory"])){
    $id = $_POST["category_id"];
    $category = $_POST["category"];
    mysqli_query($con, "UPDATE categories SET category = '$category' WHERE id = $id");
    header("Location: index.php?pg=categories");
    exit();
}

if(isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // Delete item from database
    $stmt = mysqli_prepare($con, "DELETE FROM categories WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?pg=categories");
    exit();
}
?>

<section>

    <div class="card">
        <div class="card-header text-center">
            Categories
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result_categories = mysqli_query($con, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_assoc($result_categories)) {
                    ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["category"]; ?></td>
                            <td>
                                <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Update</a>
                                <a href="index.php?pg=categories&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<section>
<div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="category" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="btnaddcategory">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</section>

