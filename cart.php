<?php
include("connect.php");

require_once 'vendor/autoload.php';

$clientid = $_SESSION["id"];

define('PAYPAL_SANDBOX', TRUE);
define('PAYPAL_SANDBOX_CLIENT_ID', 'ARsvm_38-yeIedzC88hRFVV9Jwt1QDaAUx59s1IPinhjuJtaRSkshQ_b9gEQ2Weqi_nCThTpC8reg2d0');
define('PAYPAL_SANDBOX_CLIENT_SECRET', 'EHaV8ihP5kKf_ak0ySDoXZvjv0sKhQ5CIYuJIORWHQoCU37LYdMFxmk78bWwbfEQTkivFudw0x5ETfgm');
define('PAYPAL_PROD_CLIENT_ID', 'Insert_Live_Paypal_Client_ID_Here');
define('PAYPAL_PROD_CLIENT_SECRET', 'Insert_Live_Paypal_Secret_Key_Here');


?>

<script src="https://www.paypal.com/sdk/js?client-id=ARsvm_38-yeIedzC88hRFVV9Jwt1QDaAUx59s1IPinhjuJtaRSkshQ_b9gEQ2Weqi_nCThTpC8reg2d0&currency=PHP"></script>

<section>
    <div class="card col-lg-12">
        <div class="container">
            <div class="card mb-3 mt-3">
                <h5 class="card-header text-center">Items in your Cart</h5>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3 mb-2 justify-content-center">
                            <div class="col-lg-12 text-center">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                    $subtotal = 0;
                                    $fee = 100; // Shipping fee
                                    $q = mysqli_query($con, 
                                        "
                                        SELECT 
                                        cart.*, 
                                        items.itemname, 
                                        items.price, 
                                        accounts.fullname 
                                        FROM cart 
                                        LEFT JOIN items ON cart.itemid=items.id 
                                        LEFT JOIN accounts ON cart.clientid=accounts.id 
                                        WHERE cart.clientid='$clientid'
                                        "
                                    );

                                    while($r1 = mysqli_fetch_array($q)){
                                        $item_subtotal = $r1["price"] * $r1["quantity"];
                                        $subtotal += $item_subtotal;
                                        ?>
                                        <tr> 
                                            <td><?php echo $r1["fullname"]; ?></td>
                                            <td><?php echo $r1["itemname"]; ?></td>
                                            <td><?php echo $r1["quantity"]; ?></td>
                                            <td><?php echo number_format($r1["price"],2); ?></td>
                                            <td><?php echo number_format($item_subtotal,2); ?></td>
                                            <td>
                                                <form method="POST" style="display:inline;">
                                                    <input type="hidden" name="cart_id" value="<?php echo $r1['id']; ?>">
                                                    <input type="submit" class="btn btn-dark" name="btnremove" value="Remove">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }

                                    if (isset($_POST["btnremove"])) { 
                                        $cart_id = $_POST["cart_id"];
                                        mysqli_query($con, "DELETE FROM cart WHERE id='$cart_id'");
                                        echo "<script>window.location = 'index.php?pg=cart';</script>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="card col-sm-4 text-center">
                                <div class="card-header text-center">Cart Summary</div>
                                <div class="card-body mb-0">
                                    <p class="mb-0"><b>Subtotal:</b> ₱<?php echo number_format($subtotal,2); ?></p>
                                    <p class="mb-0"><b>Shipping Fee:</b> ₱<?php echo number_format($fee,2); ?></p>
                                    <p class="mb-0" style="font-size: 25px;"><b>Total Amount:</b> ₱<?php echo number_format($subtotal + $fee,2); ?></p>         
                                </div>
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?php echo round($subtotal + $fee, 2); ?>'
                }
            }]
        });
    },

    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "save_transaction.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText.includes("success")) {
                    alert('Purchased Successfully!');
                    window.location.href = 'index.php?pg=cart';
                } else {
                    alert("Transaction processing failed. Please try again.");
                }
            };

            xhr.send("clientid=<?php echo $clientid; ?>&subtotal=<?php echo $subtotal; ?>&fee=<?php echo $fee; ?>&totalamount=<?php echo $subtotal + $fee; ?>&status=Pending");
        });
    }
}).render('#paypal-button-container');
</script>
