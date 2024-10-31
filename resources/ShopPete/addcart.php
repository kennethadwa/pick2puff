<?php
	include("connect.php");
	$id = $_GET["id"];
	$ctr = mysqli_num_rows(mysqli_query($con,"select * from cart where clientid=1 and itemid=$id"));
	if($ctr > 0){
		mysqli_query($con,"update cart set quantity=quantity+1 where clientid=1 and itemid=$id");
	}
	else{
		$item = mysqli_fetch_array(mysqli_query($con, "select * from items where id = $id"));
		mysqli_query($con,"insert into cart(clientid,itemid,quantity,price) values(1,$id,1,$item[price])");
	}
	echo "<script>alert('Your item has been added into your cart!'); window.location='cart.php';</script>";
?>