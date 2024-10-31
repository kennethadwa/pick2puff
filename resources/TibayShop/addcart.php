<?php
include("connect.php");
$id = $_GET["id"];
$item = mysqli_fetch_array(mysqli_query($con, "select * from items where id=$id"));
mysqli_query($con, "insert into cart(clientid,itemid,quantity,price) values (2, $id, 1, $item[price])");
echo "<script>alert('Item has been added into your cart!!!!');window.location='cart.php';</script>";
?>