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
			<div class="row">
			 <?php
				$q = mysqli_query($con, "select * from items order by itemname");
				while($r = mysqli_fetch_array($q)){
				?>
					<div class="col-3">
						<div class="card mb-3">
							<img src="<?php echo $r["img"]; ?>" class="card-img-top" alt="..." style="max-height:300px !important;">
							<div class="card-body">
							<h5 class="card-title"><?php echo $r["itemname"]; ?></h5>
							<p class="card-text">
								Qty: 
								<?php 
									if($r["quantity"]==0){
										echo "Sold Out";
									}
									else{
										echo $r["quantity"];
									}
								?>
							</p>
							<a href="addcart.php?id=<?php echo $r["id"]; ?>" class="btn btn-primary">Add To Cart</a>
							</div>
						</div>
					</div>
				<?php
				}
			?>
			</div>
          
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
