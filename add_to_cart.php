<?php 
require_once('db_connection.php');


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


<h1>Add to Cart</h1>


<form method="post"  action="index.php?page=cart">
  <label for="fname">Product Name:</label><?php echo $row['product_name']; ?>
   <br/>
  <label for="lname">Price</label>
   Price : <?php echo $row['price']; ?>
   <br/>
 
  QTY:<br>
  <input type="text" id="lname" name="qty" value=""><br><br>
  <input type="hidden" id="fname" name="product_id" value="<?php echo $data['id']; ?>">
  <input type="submit" value="add to cart">
</form>



