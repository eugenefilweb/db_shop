<?php 
require_once('db_connection.php');

// if(isset($_POST) && $_POST['product_name']){
if(isset($_POST) && isset($_POST['product_name'])){

$data = [
    'id' => $_GET['id'],
    'product_name' => $_POST['product_name'],
    'price' =>  $_POST['price'],
	'date_updated' => date('Y-m-d H:i:s'),
	
];
$sql = "UPDATE tbl_products SET product_name=:product_name, price=:price, date_updated=:date_updated WHERE id=:id";
$stmt= $db->prepare($sql);
$stmt->execute($data);
 
 header("Location: http://localhost/project/train/index.php?page=products");
 die();
}





//$statement = $db->prepare("select * from  tbl_products where id=".$_GET['id']." ");
//$statement->execute();

$data = [
    'id' => $_GET['id'],
];
$statement = $db->prepare("select * from  tbl_products where id=:id ");
$statement->execute($data);
$row = $statement->fetch();


//echo $row['product_name']
//print_r($row);

?>


<h1>Update Product <?php echo $row['product_name']; ?></h1>


<form method="post"  action="">
  <label for="fname">Product Name:</label><br>
  <input type="text" id="fname" name="product_name" value="<?php echo $row['product_name']; ?>"><br>
  <label for="lname">Price</label><br>
  <input type="text" id="lname" name="price" value="<?php echo $row['price']; ?>"><br><br>
  <input type="submit" value="Submit">
</form>



