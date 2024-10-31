<?php
include("connect.php");

// Check if a transaction ID is set for different actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $transaction_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $new_status = 'Approved';
        $current_status = 'Pending';
        $query = "UPDATE transactions SET status = '$new_status' WHERE id = $transaction_id AND status = '$current_status'";
    } elseif ($action === 'cancel') {
        $new_status = 'Canceled';
        $current_status1 = 'Pending';
        $current_status2 = 'Approved';
        $query = "UPDATE transactions SET status = '$new_status' WHERE id = $transaction_id AND (status = '$current_status1' OR status = '$current_status2')";
    } elseif ($action === 'complete') {
        $new_status = 'Completed';
        $current_status = 'Approved';
        $query = "UPDATE transactions SET status = '$new_status' WHERE id = $transaction_id AND status = '$current_status'";
    } else {
        echo "Invalid action.";
        exit();
    }

    $result = mysqli_query($con, $query);

    if ($result) {
        echo "Transaction updated successfully.";
    } else {
        echo "Error updating transaction: " . mysqli_error($con);
    }

    mysqli_close($con);
    header("Location: index.php?pg=transaction"); // Redirect to the transactions page
    exit();
}

// Get the currently logged-in user's ID from the session
$user_id = $_SESSION['id']; // Adjust this according to how you store the user ID in the session

// Join on accounts table and filter by the logged-in user ID
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
    WHERE 
        transactions.clientid = '$user_id'  -- Filter by the logged-in user's ID
    ORDER BY 
        transactions.orderdate DESC
");

?>

<section>
    <div class="container">
        <div class="card mb-3 mt-3">
            <h5 class="card-header text-center">Transactions</h5>
            <div class="card-body">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Client Name</th>
                            <th>Delivery Address</th>
                            <th>Contact Detail</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($q)) { ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["fullname"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["contact"]; ?></td>
                                <td>₱<?php echo number_format($row["totalamount"], 2); ?></td>       
                                <td><?php echo $row["status"]; ?></td>
                                <td><?php echo $row["orderdate"]; ?></td>
                                <td>
                                    <a href="index.php?pg=viewtransactiondetails&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
