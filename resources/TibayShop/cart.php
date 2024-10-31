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
        <title>Tibay Shop</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Tibay Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="cart.php">Cart</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
			<table class="table table-striped table-hover table-bordered">
				<tr>
					<th>Client Name</th>
					<th>Item Name</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Subtotal</th>
					<th>Action</th>
				</tr>
				<?php
				$total = 0;
				$subtotal = 0;
				$q = mysqli_query($con,
					"select 
						cart.*, 
						items.itemname,
						clients.fullname
					from 
						cart 
						left join items on cart.itemid = items.id 
						left join clients on cart.clientid=clients.id
					where 
						cart.clientid=2 
					order by 
						items.itemname
					"
				);
				while($r = mysqli_fetch_array($q)){
					$subtotal = $subtotal + ($r["price"] * $r["quantity"]);
				?>
					<tr>
						<td><?php echo $r["fullname"]; ?></td>
						<td><?php echo $r["itemname"]; ?></td>
						<td><?php echo $r["quantity"]; ?></td>
						<td><?php echo number_format($r["price"],2); ?></td>
						<td><?php echo number_format($r["price"] * $r["quantity"],2); ?></td>
						<td>X</td>
					</tr>
				<?php
				}
				?>
			</table>
			<?php
				$total = $subtotal+100;
				echo "<h4>SUBTOTAL: $subtotal</h4>";
				echo "<h5>SHIPPING FEE: 100</h5>";
				echo "<h2>TOTAL AMOUNT: $total</h2>";
			?>
			
			<form method="POST">
				
				<input type="submit" value="Checkout" name="btncheckout" class="btn btn-success"></input>
				<?php
				if(isset($_POST["btncheckout"])){
					mysqli_query($con, "insert into transactions(clientid,subtotal,fee,total,status,orderdate) values(2,$subtotal,100,$total,'Pending',NOW())");
					$q = mysqli_query($con,"select * from cart where clientid=2");
					while($r = mysqli_fetch_array($q)){
						mysqli_query($con, "update items set quantity=quantity-$r[quantity] where id=$r[itemid]");
					}
					mysqli_query($con, "delete from cart where clientid=2");
					echo "<script>alert('Thank you for ordering our not so durable items from Tibay Shop');window.location='index.php';</script>";
				}
				?>
			</form>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
