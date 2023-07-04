<?php
session_start();
require_once('db_connection.php');
if($_GET['action']=='logout'){
	unset($_SESSION['user']);
	header("Location: http://localhost/project/train/index.php");
}

if(!$_SESSION['user']){
	header("Location: http://localhost/project/train/index.php");
}



//print_r($_SESSION['user']);

$statement = $db->prepare("select * from tbl_user where id=".$_SESSION['user']['id']." ");
$statement->execute();
$row = $statement->fetch();

//print_r($row);






?>
<h1>Dashboard</h1>

Welcome <?php echo $row['nick_name']; ?>








  
  
  
   <a href="index.php"  >Go to Shopping cart</a> |  <a href="index.php?page=dashboard&action=logout"  >Logout</a>
  
  <div class="container text-center">
  <div class="row">
    <div class="col-sm-5">
	
	<h2>Your Order</h2>

<table class="table">
 <tr>
   <td>Order_no</td>
   <td>Customer</td>
   <td>status</td>
   <td>date</td>
   <td> </td>
 </tr>
 <?php 
 
$statement = $db->prepare("select o.*, concat(c.first_name,' ',c.last_name) as customer_name from tbl_orders o, tbl_customer c where o.customer_id=".$row['customer_id']."  and c.id=o.customer_id ");
$statement->execute();
$rows = $statement->fetchAll();
 
 
 if ($rows){
	 
	 foreach($rows as $key=>$data){ 
	 
	 ?>
  <tr>
   <td><?php echo $data['order_no']; ?></td>
   <td><?php echo $data['customer_name']; ?></td>
   <td><?php echo $data['status']?'Paid':'Pending'; ?></td>
   <td><?php echo  $data['date_created']; ?></td>
   <td> 
   <a href="index.php?page=dashboard&id=<?php echo $data['id']; ?>" class="btn btn-primary" >View Details</a>
   </td>
  </tr>
 <?php } ?>
 


 <?php } ?>
 
</table>
	
	</div>
    <div class=" col-sm-7">
	
	<h2>Order Details</h2>
	
	  <?php 


	  ?>
	
	
	
	  Review Your Oder

<table class="table">
 <tr>
   <td>Product Name</td>
   <td>Price</td>
   <td>Qty</td>
    <td>Total</td>
   
 </tr>
 <?php 
 
 if($_GET['id']){
	 
 $statement = $db->prepare("select o.*, p.product_name from tbl_order_details o,  tbl_products p  where o.order_id=".$_GET['id']." and p.id=o.product_id  ");
$statement->execute();
$rows = $statement->fetchAll();
 
 
 if ($rows){
	 
	 foreach($rows as $key=>$data){ 
	   
	   $subtotal= $data['qty']*$data['price'];
	   $total +=$subtotal;
	 ?>
  <tr>
   <td><?php echo $data['product_name']; ?></td>
   <td><?php echo $data['price']; ?></td>
   <td><?php echo $data['qty']; ?></td>
    <td><?php echo $subtotal; ?></td>
 
  </tr>
 <?php } ?>
 
  <tr>
   <td></td>
   <td></td>
   <td>Total</td>
    <td><?php echo $total ?></td>
   <td></td>
 </tr>

 <?php }

 } ?>
 
</table>
  
	
	
	
	</div>

    
  </div>
</div>
  
  
  









