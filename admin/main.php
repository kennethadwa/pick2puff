<?php
include("../connect.php");

// Define the number of records per page
$records_per_page = 15;

// Get the current page number from the URL, default to 1 if not set
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $records_per_page;

// Query to fetch the total number of transactions
$total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM transactions");
$total_result = mysqli_fetch_array($total_query);
$total_records = $total_result['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch transactions with pagination and join with accounts
$q = mysqli_query($con, "
    SELECT 
        transactions.*,
        accounts.fullname,
        accounts.address,
        accounts.contact
    FROM 
        transactions 
    LEFT JOIN 
        accounts 
    ON 
        transactions.clientid = accounts.id
    ORDER BY 
        transactions.orderdate DESC
    LIMIT $offset, $records_per_page
");

// Queries to count pending, out-for-delivery, and completed transactions
$pending_query = mysqli_query($con, "SELECT COUNT(*) as pending_count FROM transactions WHERE status = 'Pending'");
$pending_count = mysqli_fetch_array($pending_query)['pending_count'];

$afd_query = mysqli_query($con, "SELECT COUNT(*) as afd_count FROM transactions WHERE status = 'Out For Delivery'");
$afd_count = mysqli_fetch_array($afd_query)['afd_count'];

$completed_query = mysqli_query($con, "SELECT COUNT(*) as completed_count FROM transactions WHERE status = 'Completed'");
$completed_count = mysqli_fetch_array($completed_query)['completed_count'];
?>

<section>
    <div class="container">
        <div class="card mb-3 mt-3">
            <h1 class="card-header text-center">Transactions</h1>
            <div class="card-body">
                <p class="text-center">Pending Transactions: <?php echo $pending_count; ?></p>
                <p class="text-center">Out For Delivery Transactions: <?php echo $afd_count; ?></p>
                <p class="text-center">Completed Transactions: <?php echo $completed_count; ?></p>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Delivery Address</th>
                            <th>Contact Detail</th>
                            <th>Sub Total</th>
                            <th>Fee</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($q)) { ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["fullname"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["contact"]; ?></td>
                                <td><?php echo $row["subtotal"]; ?></td>
                                <td><?php echo $row["fee"]; ?></td>
                                <td><?php echo $row["totalamount"]; ?></td>
                                <td><?php echo $row["status"]; ?></td>
                                <td><?php echo $row["orderdate"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                <!-- Pagination Links -->
                <div class="pagination d-flex justify-content-center">
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>" class="btn btn-secondary btn-sm mx-1">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="btn btn-<?php echo $i == $current_page ? 'primary' : 'secondary'; ?> btn-sm mx-1"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>" class="btn btn-secondary btn-sm mx-1">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$con->close();
?>
