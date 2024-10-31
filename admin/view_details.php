<?php
include("../connect.php");

// Check if an ID is set in the URL
if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];

    // Fetch transaction details
    $query = "
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
            transactions.id = $transaction_id
    ";
    $result = mysqli_query($con, $query);
    $transaction = mysqli_fetch_assoc($result);

    if (!$transaction) {
        echo "Transaction not found.";
        exit();
    }

    // Fetch transaction items
    $items_query = "
        SELECT 
            * 
        FROM 
            items
        
    ";
    $items_result = mysqli_query($con, $items_query);
} else {
    echo "No transaction ID provided.";
    exit();
}
?>
<section class="container mt-5">
    <div class="container">
        <div class="card mb-3 mt-3">
            <h5 class="card-header text-center">Transaction Details</h5>
            <div class="card-body">
                <p><strong>Client Name:</strong> <?php echo $transaction['fullname']; ?></p>
                <p><strong>Delivery Address:</strong> <?php echo $transaction['address']; ?></p>
                <p><strong>Contact Detail:</strong> <?php echo $transaction['contact']; ?></p>
                <p><strong>Sub Total:</strong> <?php echo $transaction['subtotal']; ?></p>
                <p><strong>Fee:</strong> <?php echo $transaction['fee']; ?></p>
                <p><strong>Total Amount:</strong> <?php echo $transaction['totalamount']; ?></p>
                <p><strong>Status:</strong> <?php echo $transaction['status']; ?></p>
                <p><strong>Order Date:</strong> <?php echo $transaction['orderdate']; ?></p>

                <h5 class="card-header text-center">Items</h5>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>
                            <tr>
                                <td><?php echo $item['itemname']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['price']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <a href="index.php?pg=transaction" class="btn btn-secondary btn-sm">Back to Transactions</a>

                <!-- Buttons based on transaction status -->
                  <?php if ($transaction['status'] == 'Pending') { ?>
                      <a href="index.php?pg=transaction&action=approve&id=<?php echo $transaction['id']; ?>" 
                         class="btn btn-success btn-sm" 
                         onclick="alert('Transaction marked as Out For Delivery');">Out For Delivery</a>
                      <a href="index.php?pg=transaction&action=cancel&id=<?php echo $transaction['id']; ?>" 
                         class="btn btn-danger btn-sm" 
                         onclick="alert('Transaction canceled');">Cancel Transaction</a>
                  <?php } elseif ($transaction['status'] == 'Out For Delivery') { ?>
                      <a href="index.php?pg=transaction&action=complete&id=<?php echo $transaction['id']; ?>" 
                         class="btn btn-success btn-sm" 
                         onclick="alert('Transaction marked as Complete');">Complete Transaction</a>
                  <?php } ?>
            </div>
        </div>
    </div>
</section>
