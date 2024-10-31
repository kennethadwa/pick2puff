<!DOCTYPE html>
<?php
	include("connect.php");
?>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shoppete</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Shoppete</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="cart.php">Cart</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="row pt-4">
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
				$fee = 100;
				$q = mysqli_query($con, 
					"
					select 
						cart.*,
						items.itemname,
						clients.fullname
					from 
						cart 
						left join items on cart.itemid=items.id
						left join clients on cart.clientid=clients.id
					"
				
				);
				while($r = mysqli_fetch_array($q)){
					$subtotal = $subtotal + ($r["price"]*$r["quantity"]);
				?>
					<tr>
						<td><?php echo $r["fullname"]; ?></td>
						<td><?php echo $r["itemname"]; ?></td>
						<td><?php echo $r["quantity"]; ?></td>
						<td><?php echo number_format($r["price"],2); ?></td>
						<td><?php echo number_format($r["price"]*$r["quantity"],2); ?></td>
						<td>X</td>
					</tr>
				<?php
				}
				?>
				</table>
				<h4>Subtotal: <?php echo number_format($subtotal,2); ?></h4>
				<h3>Fee: <?php echo number_format($fee,2); ?></h3>
				<h2>Total Amount: <?php echo number_format($subtotal+ $fee,2); ?></h2>
				
				<form method="POST">
					<input type="submit" class="btn btn-success" name="btncheckout" value="Checkout"></input>
					<?php
					if(isset($_POST["btncheckout"])){
						mysqli_query($con, "insert into transactions(clientid,subtotal,fee,totalamount,status,orderdate) values(1,$subtotal,$fee,$subtotal+$fee,'Pending',NOW())");
						$q = mysqli_query($con, "select * from cart where clientid=1");
						while($r = mysqli_fetch_array($q)){
							mysqli_query($con, "update items set quantity=quantity-$r[quantity] where id=$r[itemid]");
						}
						mysqli_query($con, "delete from cart where clientid=1");
						echo "<script>alert('Thank your for Shopeteing!'); window.location='index.php';</script>";
					}
					?>
				</form>
			</div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
