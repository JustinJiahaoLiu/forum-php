<?php
session_start();

//connect to database
include 'ch21_include.php';
doDB();

//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price,
st.sel_item_qty, st.sel_item_size, st.sel_item_color FROM
store_shoppertrack AS st LEFT JOIN store_items AS si ON
si.id = st.sel_item_id WHERE session_id =
'".$_COOKIE['PHPSESSID']."'";

$get_cart_res = mysqli_query($mysqli, $get_cart_sql)
or die(mysqli_error($mysqli));

$display_block = "<h1>Your Order</h1>";

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
<td colspan='6'>Toal: \$ $total_price_order</td>
</table>
<br/>
<form id="form" action="generateorder.php" method="POST">
	  <div class="form-row">
	    <div class="col-md-4 mb-3">
	      <label for="name">Name</label>
	      <input type="text" class="form-control" id="name" name="order_name" placeholder="Full name" value="" required>
	  	</div>
	  </div>

	  <div class="form-row">
	    <div class="col-md-8 mb-3">
	      <label for="address">Address</label>
	      <input type="text" class="form-control" id="address" name="order_address" placeholder="Street" value="" required>
	  	</div>
	  </div>

	  <div class="form-row">
	    <div class="col-md-6 mb-3">
	      <label for="city">City</label>
	      <input type="text" class="form-control" id="city" name="order_city" placeholder="City" required>
	    </div>
	    <div class="col-md-3 mb-3">
	      <label for="state">State</label>
	      <input type="text" class="form-control" id="state" name="order_state" placeholder="State" required>
	    </div>
	    <div class="col-md-3 mb-3">
	      <label for="zip">Zip</label>
	      <input type="text" class="form-control" id="zip" name="order_zip" placeholder="Zip" required>
	    </div>
	  </div>
	   <div class="form-row">
	    <div class="col-md-4 mb-3">
	      <label for="tel">Tel</label>
	      <input type="tel" class="form-control" id="tel" name="order_tel" placeholder="Tel" value="" required>
	  	</div>

	  	<div class="col-md-4 mb-3">
	      <label for="email">Email</label>
	      <input type="email" class="form-control " id="email" name="order_email" placeholder="JaneDoe@email.com" value="" required>
	  	</div>
	  </div>
	  <button class="btn btn-primary" type="submit">Submit form</button>
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
	<?php echo $display_block; ?>
</div>
</body>
</html>