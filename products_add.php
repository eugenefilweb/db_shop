<?php 
require_once('db_connection.php');


if(isset($_POST) &&  isset($_POST['product_name'])){

$data = [
    'product_name' => $_POST['product_name'],
    'price' =>  $_POST['price'],
    'date_created' => date('Y-m-d H:i:s'),
	'date_updated' => date('Y-m-d H:i:s'),
];
$sql = "INSERT INTO tbl_products (product_name, price, date_created, date_updated) VALUES (:product_name, :price, :date_created, :date_updated)";
$stmt= $db->prepare($sql);
$stmt->execute($data);

//echo $db->lastInsertId();

 header("Location: http://localhost/training/db_shop/index.php?page=products");
 die();
}


?>


<h1>Add Products</h1>


<form method="post"  action="">
  <label for="fname">Product Name:</label><br>
  <input type="text" id="fname" name="product_name" value=""><br>
  <label for="lname">Price</label><br>
  <input type="text" id="lname" name="price" value=""><br><br>
  <input type="submit" value="Submit">
</form>



