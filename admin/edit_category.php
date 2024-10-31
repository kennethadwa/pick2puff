<?php
include("../connect.php");

// Check if ID parameter is provided
if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Fetch category details from the database
    $result = mysqli_query($con, "SELECT * FROM categories WHERE id = $id");
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $category = $row["category"];
    } else {
        echo "Category not found.";
        exit();
    }
} else {
    echo "ID parameter missing.";
    exit();
}

// Handle update operation
if(isset($_POST["btnupdatecategory"])) {
    $id = $_POST["category_id"];
    $category = $_POST["category"];

    // Update category in the database
    mysqli_query($con, "UPDATE categories SET category = '$category' WHERE id = $id");

    header("Location: index.php?pg=categories");
    exit();
}
?>

<section>
    <div class="card mt-3">
        <div class="card-header text-center">
            Edit Category
        </div>
        <div class="card-body">
            <form action="edit_category.php?id=<?php echo $id; ?>" method="POST">
                <input type="hidden" name="category_id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="category" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category" name="category" value="<?php echo $category; ?>" required>
                </div>
                <button type="submit" name="btnupdatecategory" class="btn btn-primary">Update Category</button>
            </form>
        </div>
    </div>
</section>
