<?php
session_start();

//connect to database
include 'ch21_include.php';
doDB();

$display_block = "<h1>Your order</h1>";

//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price,
st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM
store_shoppertrack AS st LEFT JOIN store_items AS si ON
si.id = st.sel_item_id WHERE session_id =
'".$_COOKIE['PHPSESSID']."'";

$get_cart_res = mysqli_query($mysqli, $get_cart_sql)
or die(mysqli_error($mysqli));

$display_block .= <<<END_OF_TEXT
<table>
<tr>
<th>Title</th>
<th>Size</th>
<th>Color</th>
<th>Price</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
END_OF_TEXT;


$total_price_order = 0;

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

$display_block .= <<<END_OF_TEXT
<tr>
<td>$item_title <br></td>
<td>$item_size <br></td>
<td>$item_color <br></td>
<td>\$ $item_price <br></td>
<td>$item_qty <br></td>
<td>\$ $total_price</td>
</tr>
END_OF_TEXT;
}

//Display total price for order
$display_block .= <<<END_OF_TEXT
<td colspan='6'>Toal: \$ $total_price_order</td>;

<form action="" method="POST">
<label for=

</form>

END_OF_TEXT;

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
table {
border: 1px solid black;
border-collapse: collapse;
}
th {
border: 1px solid black;
padding: 6px;
font-weight: bold;
background: #ccc;
text-align: center;
}
td {
border: 1px solid black;
padding: 6px;
vertical-align: top;
text-align: center;
}
</style>
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>