<?php
session_start();

//connect to database
include 'ch21_include.php';
doDB();

$clean_order_name = mysqli_real_escape_string($mysqli, $_POST['order_name']);
$clean_order_address = mysqli_real_escape_string($mysqli, $_POST['order_address']);
$clean_order_city = mysqli_real_escape_string($mysqli, $_POST['order_city']);
$clean_order_state = mysqli_real_escape_string($mysqli, $_POST['order_state']);
$clean_order_zip = mysqli_real_escape_string($mysqli, $_POST['order_zip']);
$clean_order_tel = mysqli_real_escape_string($mysqli, $_POST['order_tel']);
$clean_order_email = mysqli_real_escape_string($mysqli, $_POST['order_email']);
$clean_item_total = mysqli_real_escape_string($mysqli, $_POST['item_total']);

$store_orders_sql = "INSERT INTO `store_orders`(`order_date`, `order_name`, `order_address`, `order_city`, `order_state`, `order_zip`, `order_tel`, `order_email`, `item_total`) VALUES (now(),'".$clean_order_name."','".$clean_order_address."','".$clean_order_city."','".$clean_order_state."','".$clean_order_zip."','".$clean_order_tel."','".$clean_order_email."','".$clean_item_total."')";

$store_orders_res = mysqli_query($mysqli, $store_orders_sql) or die(mysqli_error($mysqli));

if($store_orders_res){
	$last_id = mysqli_insert_id($mysqli);
}

//check for cart items based on user session id
$get_cart_sql = "SELECT st.sel_item_id, si.item_title, si.item_price,
st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM
store_shoppertrack AS st LEFT JOIN store_items AS si ON
si.id = st.sel_item_id WHERE session_id =
'".$_COOKIE['PHPSESSID']."'";

$get_cart_res = mysqli_query($mysqli, $get_cart_sql)
or die(mysqli_error($mysqli));


/*----------------------Store Orders Items---------------------*/
while ($cart_info = mysqli_fetch_array($get_cart_res)) {
	$id = mysqli_real_escape_string($mysqli, $cart_info['sel_item_id']);
	
	$item_price = mysqli_real_escape_string($mysqli, $cart_info['item_price']);
	$item_qty = mysqli_real_escape_string($mysqli, $cart_info['sel_item_qty']);
	$item_color = mysqli_real_escape_string($mysqli, $cart_info['sel_item_color']);
	$item_size = mysqli_real_escape_string($mysqli, $cart_info['sel_item_size']);

	$store_orders_items_sql = "INSERT INTO `store_orders_items`(`order_id`, `sel_item_id`, `sel_item_qty`, `sel_item_size`, `sel_item_color`, `sel_item_price`) VALUES ('".$last_id."','".$id."','".$item_qty."','".$item_size."','".$item_color."','".$item_price."')";

	$store_orders_items_res = mysqli_query($mysqli, $store_orders_items_sql)
or die(mysqli_error($mysqli));
	
//---------Update Stock-------------
	$stock_update_sql = " UPDATE `store_items` 
		SET `store_items`.item_stock = `store_items`.item_stock - $item_qty
		WHERE `store_items`.id = $id";
	$stock_update_res = mysqli_query($mysqli, $stock_update_sql)
or die(mysqli_error($mysqli));
}

//Remove shoppertrack log
$delete_shoppertrack_sql = "DELETE FROM `store_shoppertrack` WHERE `store_shoppertrack`.session_id = '".$_COOKIE['PHPSESSID']."'";
$delete_shoppertrack_res = mysqli_query($mysqli, $delete_shoppertrack_sql)
or die(mysqli_error($mysqli));

//clear cookie
if (isset($_COOKIE['PHPSESSID'])) {
    setcookie('PHPSESSID', null, -1, '/');
}

//free result
mysqli_free_result($get_cart_res);

//close connection to MySQL
mysqli_close($mysqli);

?>


<!DOCTYPE html>
<html>
<head>
<title>My Order</title>
<style type="text/css">
</style>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<?php
	include 'layouts/navbar.php';
?>
<div class="container">
	<h1>Thank you for shopping with us!</h1>
	<a href="seestore.php"><button class="btn btn-success">Go Back to Shop</button></a>
</div>
</body>
</html>