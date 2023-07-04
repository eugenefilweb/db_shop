<?php 
session_start();

require_once('db_connection.php');

$cart_data = $_SESSION['cart'];

 //print_r($_POST);
 //exit;
 
if(isset($_POST) &&  $_POST['submit'] ){



if (!$_SESSION['user'] && $_POST['first_name']){
	
	
$data = [
    'first_name' => $_POST['first_name'],
    'last_name' =>  $_POST['last_name'],
	'email' =>  $_POST['email'],
    'date_created' => date('Y-m-d H:i:s'),
	'date_updated' => date('Y-m-d H:i:s'),
];

//insert customer
$sql = "INSERT INTO  tbl_customer (first_name, last_name, email, date_updated, date_created) VALUES (:first_name, :last_name, :email, :date_created, :date_updated)";
$stmt= $db->prepare($sql);
$stmt->execute($data);
 
 
$last_id = $db->lastInsertId();
 

$data = [
    'id' => $last_id,
];
$statement = $db->prepare("select * from tbl_customer where id=:id ");
$statement->execute($data);
$row = $statement->fetch();
 
 
 
 
 
 //insert user
 
 
 $data = [
    'customer_id'=>$row['id'],
    'user_name' => $row['email'],
    'user_email' =>  $row['email'],
	'password' =>  $_POST['password'],
	'nick_name' => $row['first_name'],
    'date_created' => date('Y-m-d H:i:s'),
	'date_updated' => date('Y-m-d H:i:s'),
];
 
$sql = "INSERT INTO  tbl_user (customer_id, user_name, user_email, password, nick_name, date_updated, date_created) VALUES (:customer_id, :user_name, :user_email, :password, :nick_name, :date_created, :date_updated)";
$stmt= $db->prepare($sql);
$stmt->execute($data);
$last_user_id = $db->lastInsertId();

$statement = $db->prepare("select * from tbl_user where id=".$last_user_id." ");
$statement->execute();
$row = $statement->fetch();
$_SESSION['user']=$row;

}else{
	
$statement = $db->prepare("select * from tbl_user where id=".$_SESSION['user']['id']." ");
$statement->execute();
$row = $statement->fetch();	
	
}






 //insert order
 
 
 $data = [
    'order_no'=>time(),
	'customer_id'=>$row['id'],
    'status' => 0,
    'date_created' => date('Y-m-d H:i:s'),
	'date_updated' => date('Y-m-d H:i:s'),
];
 
$sql = "INSERT INTO  tbl_orders (order_no,	customer_id, status, date_updated, date_created) VALUES (:order_no, :customer_id, :status, :date_created, :date_updated)";
$stmt= $db->prepare($sql);
$stmt->execute($data);
$last_order_id = $db->lastInsertId();



 if ($cart_data){
 	 foreach($cart_data as $key=>$data){ 
	 
	 $data = [
    'order_id'=>$last_order_id,
    'product_id' => $data['id'],
	'price'=>$data['price'],
	'qty'=>$data['qty'],
    'date_created' => date('Y-m-d H:i:s'),
	'date_updated' => date('Y-m-d H:i:s'),
       ];
	    $sql = "INSERT INTO  tbl_order_details (order_id, product_id, price, qty, date_updated, date_created) VALUES (:order_id, :product_id,:price,:qty, :date_created, :date_updated)";
        $stmt= $db->prepare($sql);
         $stmt->execute($data);
	 
	 }
 }
 
 

 //print_r($row);



  unset($_SESSION['cart']);
  
  
  header("Location: http://localhost/project/train/index.php?page=dashboard");
  die();
 
 

}

 //print_r($cart_data);







?>
Welcome <?php echo $_SESSION['user']['nick_name']; ?> | <a href="index.php?page=dashboard">My Account</a>


<h1>Checkout</h1>





<div style="max-width: 1000px;width: 100%; margin: auto;">
<a href="index.php?page=cart">Back to Cart</a> <a href="index.php">Back to Product</a>
<br/> <br/>





<form method="post"  action="">

<?php if (!$_SESSION['user']){?>


  <label for="fname">First Name</label><br>
  <input class="form-control" type="text" id="fname" name="first_name" value=""><br>
  <label for="lname">Last Name</label><br>
  <input class="form-control" type="text" id="lname" name="last_name" value=""><br><br>
  <label for="lname">Email</label><br>
  <input class="form-control" type="text" id="lname" name="email" value=""><br><br>
  <label for="lname">Password</label><br>
  <input class="form-control" type="text" id="lname" name="password" value=""><br><br>
<?php } ?>
  
  
  
  
     Review Your Oder

<table class="table">
 <tr>
   <td>Product Name</td>
   <td>Price</td>
   <td>Qty</td>
    <td>Total</td>
   
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
  
  
  
  
  
  
  
  
  
  
  
  <input type="submit" name="submit" value="Confirm">
</form>

</div>