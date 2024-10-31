<?php
include("connect.php");

// Initialize the query variable
$query = ""; // Ensure $query is initialized

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
        // Set an error message in a session variable instead of echoing it
        $_SESSION['message'] = "Invalid action.";
        header("Location: index.php?pg=transaction");
        exit();
    }

    // Check if $query is set before executing
    if (!empty($query)) {
        $result = mysqli_query($con, $query);
        // Set a message in the session variable for success or error
        if ($result) {
            $_SESSION['message'] = "Transaction updated successfully.";
            $alertMessage = "Order canceled successfully."; // Prepare the alert message
        } else {
            $_SESSION['message'] = "Error updating transaction: " . mysqli_error($con);
            $alertMessage = "Error canceling order."; // Prepare the alert message
        }
    } else {
        $_SESSION['message'] = "Query was not set.";
        $alertMessage = "Error: Query was not set."; // Prepare the alert message
    }
}

// Ensure the user is logged in and get their ID
if (!isset($_SESSION['id'])) {
    echo "User not logged in.";
    exit();
}

$user_id = $_SESSION['id'];

// Updated SQL query to include transactions_items and filter by user_id
$q = mysqli_query($con, "
    SELECT 
        transactions.*,
        accounts.fullname,
        accounts.address,
        accounts.contact,
        items.itemname
    FROM 
        transactions 
    LEFT JOIN 
        accounts ON transactions.clientid = accounts.id
    LEFT JOIN 
        transactions_items ON transactions.id = transactions_items.transactionid
    LEFT JOIN 
        items ON transactions_items.itemid = items.id
    WHERE 
        transactions.clientid = '$user_id'
    ORDER BY 
        transactions.orderdate DESC
");

// Check for query errors
if (!$q) {
    echo "Error: " . mysqli_error($con);
    exit();
}

// Add the alert message to be used in JavaScript
$alertMessage = isset($alertMessage) ? $alertMessage : '';
ob_end_flush();
?>

<section>
    <div class="container">
        <div class="card mb-3 mt-3">
            <h5 class="card-header text-center">Transactions</h5>
            <div class="card-body">
                <?php 
                // Display success or error message if available
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>".$_SESSION['message']."</div>";
                    unset($_SESSION['message']); // Clear the message after displaying
                }
                ?>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Client Name</th>
                            <th>Delivery Address</th>
                            <th>Contact</th>
                            <th>Item Name</th>
                            <th>Subtotal</th>
                            <th>Fee</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        while ($row = mysqli_fetch_array($q)) { 
                        ?>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["fullname"]; ?></td>
                                <td><?php echo $row["address"]; ?></td>
                                <td><?php echo $row["contact"]; ?></td>
                                <td><?php echo isset($row["itemname"]) ? $row["itemname"] : 'N/A'; ?></td>
                                <td>₱<?php echo number_format($row["subtotal"], 2); ?></td>
                                <td>₱<?php echo number_format($row["fee"], 2); ?></td>
                                <td>₱<?php echo number_format($row["totalamount"], 2); ?></td>       
                                <td><?php echo $row["status"]; ?></td>
                                <td><?php echo $row["orderdate"]; ?></td>
                                <td>
                                    <?php if (strtolower($row['status']) == 'pending') { ?>
                                        <a href="index.php?pg=viewtransactiondetails&action=cancel&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    // Display an alert if there is a message to show
    <?php if ($alertMessage) { ?>
        alert('<?php echo addslashes($alertMessage); ?>'); // Use addslashes to escape quotes
    <?php } ?>
</script>
