<?php
include("connect.php");

$id = $_GET["id"];
$clientid = $_SESSION["id"];

$ctr = mysqli_num_rows(mysqli_query($con,"SELECT * FROM cart WHERE clientid=$clientid AND itemid=$id"));
if($ctr > 0){
    mysqli_query($con,"UPDATE cart SET quantity=quantity+1 WHERE clientid=$clientid AND itemid=$id");
} else {
    $item = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM items WHERE id = $id"));
    mysqli_query($con,"INSERT INTO cart(clientid, itemid, quantity, price) VALUES($clientid, $id, 1, $item[price])");
}

echo "<script>alert('Your item has been added into your cart!'); window.location='index.php?pg=shop';</script>";
?>