<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clientid = (int)$_POST['clientid']; // Cast to integer
    $subtotal = (float)$_POST['subtotal']; // Cast to float
    $fee = (float)$_POST['fee']; // Cast to float
    $totalamount = (float)$_POST['totalamount']; // Cast to float
    $status = $_POST['status'] ?? 'Pending'; 

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Insert into transactions table
        $sql = "INSERT INTO transactions (clientid, subtotal, fee, totalamount, status, orderdate) 
                VALUES ('$clientid', '$subtotal', '$fee', '$totalamount', '$status', NOW())";

        if (!mysqli_query($con, $sql)) {
            throw new Exception("Transaction insert failed: " . mysqli_error($con));
        }

        // Get the last inserted transaction ID
        $transaction_id = mysqli_insert_id($con);

        // Fetch all items from the cart for this client
        $cart_query = "SELECT itemid, quantity, price FROM cart WHERE clientid = '$clientid'";
        $cart_result = mysqli_query($con, $cart_query);

        while ($row = mysqli_fetch_assoc($cart_result)) {
            $item_id = (int)$row['itemid']; // Cast to integer
            $quantity = (int)$row['quantity']; // Cast to integer
            $price = (float)$row['price']; // Cast to float

            // Insert into transaction_items table
            $item_sql = "INSERT INTO transactions_items (transactionid, itemid, price, quantity) 
                         VALUES ('$transaction_id', '$item_id', '$price', '$quantity')";
            if (!mysqli_query($con, $item_sql)) {
                throw new Exception("Transaction items insert failed: " . mysqli_error($con));
            }
        }

        // If all inserts were successful, delete from the cart
        mysqli_query($con, "DELETE FROM cart WHERE clientid = '$clientid'");

        // Commit the transaction
        mysqli_commit($con);
        echo "success";

    } catch (Exception $e) {
        // Rollback if there was an error
        mysqli_rollback($con);
        error_log("Transaction failed: " . $e->getMessage());
        echo "failure";
    }
}
?>
