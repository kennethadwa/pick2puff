<?php
include("connect.php");
$cat = (isset($_GET["categoryid"])) ? " WHERE items.categoryid = $_GET[categoryid]" : "";

// Set the number of items per page
$items_per_page = 8;

// Get the current page number from the query string or set it to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Get the total count of items
$total_items_query = mysqli_query($con, "SELECT COUNT(*) as total FROM items $cat");
$total_items_result = mysqli_fetch_assoc($total_items_query);
$total_items = $total_items_result['total'];
$total_pages = ceil($total_items / $items_per_page);

// Fetch items for the current page
$q2 = mysqli_query($con, "SELECT items.*, categories.category FROM items LEFT JOIN categories ON items.categoryid = categories.id $cat ORDER BY itemname LIMIT $offset, $items_per_page");
?>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-4 justify-content-center">
            <?php while ($item = mysqli_fetch_array($q2)) { ?>
                <div class="col mb-5">
                    <div class="card product-card h-100 shadow-lg text-center">
                        <div class="badge badge-custom position-absolute">
                            <?php 
                                if ($item["quantity"] > 0) {
                                    echo 'In Stock: ' . $item["quantity"];
                                } else {
                                    echo 'Sold Out';
                                }
                            ?>
                        </div>
                        <div class="product-img-container">
                            <img class="card-img-top product-img" src="admin/<?php echo $item["img"]; ?>" alt="Product Image" style="height: 200px; object-fit: contain;">
                        </div>
                        <div class="card-body p-4">
                            <h4 class="fw-bolder text-primary" style="font-size: 1.25rem; margin: 0;"><?php echo $item["itemname"]; ?></h4>
                            <strong style="color: orangered; display: block; margin: 5px 0;"><?php echo $item["category"]; ?></strong>
                            <h5 class="text-success" style="font-size: 1.2rem; margin: 0;"><b>₱</b><?php echo number_format($item["price"], 2); ?></h5>
                        </div>
                        <?php if ($item["quantity"] > 0) { ?>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-dark w-100" href="index.php?pg=viewitemdetails&id=<?php echo $item["id"]; ?>">View Details</a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</section>
