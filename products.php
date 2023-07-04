<?php
require_once('db_connection.php');

if(isset($_GET['action']) &&  $_GET['action']=='delete' ){
	
$data = [
    'id' => $_GET['id'],
];
$sql = "DELETE FROM tbl_products WHERE id=:id";
$stmt= $db->prepare($sql);
$stmt->execute($data);

header("Location: http://localhost/project/train/index.php?page=products");
	
}


$statement = $db->prepare("select * from  tbl_products ");
$statement->execute();
$rows = $statement->fetchAll();

//print_r($rows);
//exit;

?>


<h1>Products</h1>

<a href="index.php?page=products-add">Add Product</a>


<table class="table">
 <tr>
   <td>Product Name</td>
   <td>Price</td>
   <td>Action</td>
 </tr>
 <?php foreach($rows as $key=>$data){ ?>
  <tr>
   <td><?php echo $data['product_name']; ?></td>
   <td><?php echo $data['price']; ?></td>
   <td><a href="index.php?page=products-edit&id=<?php echo $data['id']; ?>" class="btn btn-info">Edit</a> | <a href="index.php?page=products&action=delete&id=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >Delete</a>  | 
   
   
   <a href="index.php?page=add-cart&id=<?php echo $data['id']; ?>" class="btn btn-primary" >Add to Cart</a>
   
   
   <form method="post"  action="index.php?page=cart">
 
  <input type="hidden" id="fname" name="product_id" value="<?php echo $data['id']; ?>"><br>
   <label for="fname">QTY:</label><br>
  <input type="text" id="lname" name="qty" value=""><br><br>
  
  <input type="submit" value="Add to Cart">
  </form>
   
   </td>
  </tr>
 <?php }  ?>
 
</table>




