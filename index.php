<?php
require_once('db_connection.php');

?>
<!DOCTYPE html>
<html>
<head>
<title><?php ucwords($_GET['page']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</head>
<body>
<?php

$i=$_GET['page'];

switch ($i) {
    case 'products':
        include('products.php');
        break;
		
    case 'products-add':
        include('products_add.php');
        break;
	case 'products-edit':
        include('products_edit.php');
        break;
		
	 case 'add-cart':
        include('add_to_cart.php');
        break;	
		
    case 'cart':
        include('cart.php');
        break;
    case 'checkout':
        include('checkout.php');
        break;
	case 'dashboard':
        include('dashboard.php');
        break;
    default:
        include('products.php');
}

 ?>
 
</body>
</html>
