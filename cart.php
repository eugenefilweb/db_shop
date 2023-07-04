<?php 
session_start();

require_once('db_connection.php');


//unset($_SESSION['cart']);



$data = [
    'id' => $_POST['product_id'],
];
$statement = $db->prepare("select * from  tbl_products where id=:id ");
$statement->execute($data);
$row = $statement->fetch();



if($_GET['action']=='delete'){
	unset($_SESSION['cart'][$_GET['id']]);
}

if($_GET['action']=='update'){
	//$_SESSION['cart'][$_GET['id']]['qty'] =10;
}


if($_GET['action']=='update' ){
	$_SESSION['cart'][$_POST['id']]['qty'] =$_POST['qty'];
}


if($row['id']){
$_SESSION['cart'][]=[
'id'=>$row['id'],
'product_name'=>$row['product_name'],
'price'=>$row['price'],
'qty'=>$_POST['qty']
];
}


//print_r($_SESSION['cart']);


//print_r($row);

//print_r($_POST);

$cart_data = $_SESSION['cart'];


?>



<h1>Cart</h1>


<a href="index.php"   >Back to product</a>
<br/> <br/>





<table class="table">
 <tr>
   <td>Product Name</td>
   <td>Price</td>
   <td>Qty</td>
    <td>Total</td>
   <td>Action</td>
 </tr>
 <?php if ($cart_data){
	 
	 foreach($cart_data as $key=>$data){ 
	   
	   $subtotal= $data['qty']*$data['price'];
	   $total +=$subtotal;
	 ?>
  <tr>
   <td><?php echo $data['product_name']; ?></td>
   <td><?php echo $data['price']; ?></td>
   <td><?php echo $data['qty']; ?></td>
    <td><?php echo $subtotal; ?></td>
   <td><a href="index.php?page=cart&action=delete&id=<?php echo $key; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete?')" >Remove</a> 
  
	 
	 <form method="post"  action="index.php?page=cart&action=update">
 
  <input type="hidden" id="fname" name="id" value="<?php echo $key; ?>"><br>
   <label for="fname">QTY:</label><br>
  <input type="text" id="lname" name="qty" value="">
  
  <input type="submit" value="Update">
  </form>
	 
   </td>
  </tr>
 <?php } ?>
 
  <tr>
   <td></td>
   <td></td>
   <td>Total</td>
    <td><?php echo $total ?></td>
   <td></td>
 </tr>

 <?php } ?>
 
</table>

<a href="index.php?page=checkout">Proceed to checkout</a>