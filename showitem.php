<?php
session_start();

//connect to database
include 'ch21_include.php';
doDB();

$display_block = "<h1>My Store - Item Detail</h1>";

//create safe values for use
$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title,
si.item_price, si.item_desc, si.item_image, si.item_stock FROM store_items
AS si LEFT JOIN store_categories AS c on c.id = si.cat_id
WHERE si.id = '".$safe_item_id."'";

$get_item_res = mysqli_query($mysqli, $get_item_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_item_res) < 1) {
	//invalid item
	$display_block .= "<p><em>Invalid item selection.</em></p>";
} else {
	//valid item, get info
	while ($item_info = mysqli_fetch_array($get_item_res)) {
	$cat_id = $item_info['cat_id'];
	$cat_title = strtoupper(stripslashes($item_info['cat_title']));
	$item_title = stripslashes($item_info['item_title']);
	$item_price = $item_info['item_price'];
	$item_desc = stripslashes($item_info['item_desc']);
	$item_image = $item_info['item_image'];
	$item_stock = $item_info['item_stock'];
}

//make breadcrumb trail & display of item
$display_block .= <<<END_OF_TEXT
<p><em>You are viewing:</em><br/>
<strong><a href="seestore.php?cat_id=$cat_id">$cat_title</a> &gt;
$item_title</strong></p>
<div style="float: left;"><img src="$item_image" alt="$item_title"
/></div>
<div style="float: left; padding-left: 12px">
<p><strong>Description:</strong><br/>$item_desc</p>
<p><strong>Price:</strong> \$$item_price</p>
<p><strong>Stock:</strong> $item_stock</p>
<form method="post" action="addtocart.php">
END_OF_TEXT;

//free result
mysqli_free_result($get_item_res);

//get colors
$get_colors_sql = "SELECT item_color FROM store_item_color WHERE
item_id = '".$safe_item_id."' ORDER BY item_color";

$get_colors_res = mysqli_query($mysqli, $get_colors_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_colors_res) > 0) {
	$display_block .= "<p><label for=\"sel_item_color\">
		Available Colors:</label><br/>
		<select id=\"sel_item_color\" name=\"sel_item_color\">";

	while ($colors = mysqli_fetch_array($get_colors_res)) {
		$item_color = $colors['item_color'];
		$display_block .= "<option value=\"".$item_color."\">".
			$item_color."</option>";
	}
	$display_block .= "</select></p>";
}
//free result
mysqli_free_result($get_colors_res);

//get sizes
$get_sizes_sql = "SELECT item_size FROM store_item_size WHERE
item_id = ".$safe_item_id." ORDER BY item_size";

$get_sizes_res = mysqli_query($mysqli, $get_sizes_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_sizes_res) > 0) {
	$display_block .= "<p><label for=\"sel_item_size\">
		Available Sizes:</label><br/>
		<select id=\"sel_item_size\" name=\"sel_item_size\">";
	while ($sizes = mysqli_fetch_array($get_sizes_res)) {
		$item_size = $sizes['item_size'];
		$display_block .= "<option value=\"".$item_size."\">".
			$item_size."</option>";
	}
}
$display_block .= "</select></p>";
//free result
mysqli_free_result($get_sizes_res);

$display_block .= "<p><label for=\"sel_item_qty\">Select Quantity:</label>
	<select id=\"sel_item_qty\" name=\"sel_item_qty\">";
}

for($i=1; $i<11; $i++) {
	$display_block .= "<option value=\"".$i."\">".$i."</option>";
}

$display_block .= <<<END_OF_TEXT
</select></p>
<input type="hidden" name="sel_item_id"
value="$_GET[item_id]" />
<button type="submit" name="submit" value="submit">
Add to Cart</button>
</form>
</div>
END_OF_TEXT;

//close connection to MySQL
mysqli_close($mysqli);

?>
<!DOCTYPE html>
<html>
<head>
<title>My Store</title>
<style type="text/css">
label {font-weight: bold;}
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
<?php echo $display_block; ?>
</body>
</html>

