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

$store_orders = "INSERT INTO `store_orders`(`order_date`, `order_name`, `order_address`, `order_city`, `order_state`, `order_zip`, `order_tel`, `order_email`, `item_total`) VALUES ('".$clean_order_name."','".$clean_order_address."','".$clean_order_city."','".$clean_order_state."','".$clean_order_zip."','".$clean_order_tel."','".$clean_order_email."')";





//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price,
st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM
store_shoppertrack AS st LEFT JOIN store_items AS si ON
si.id = st.sel_item_id WHERE session_id =
'".$_COOKIE['PHPSESSID']."'";

$get_cart_res = mysqli_query($mysqli, $get_cart_sql)
or die(mysqli_error($mysqli));


/*----------------------Store Orders Items---------------------*/
$total_price_order = 0;


$store_orders_items = ""

while ($cart_info = mysqli_fetch_array($get_cart_res)) {
	$id = $cart_info['id'];
	$item_title = stripslashes($cart_info['item_title']);
	$item_price = $cart_info['item_price'];
	$item_qty = $cart_info['sel_item_qty'];
	$item_color = $cart_info['sel_item_color'];
	$item_size = $cart_info['sel_item_size'];
	$total_price = sprintf("%.02f", $item_price * $item_qty);
	//Add up to order price
	$total_price_order += $total_price;



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
</div>
</body>
</html>