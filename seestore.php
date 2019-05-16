<?php
//connect to database
include 'ch21_include.php';
doDB();

$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";

$get_cats_res = mysqli_query($mysqli, $get_cats_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
	$display_block = "<p><em>Sorry, no categories to browse.</em></p>";
} else {
	while ($cats = mysqli_fetch_array($get_cats_res)) {
		$cat_id = $cats['id'];
		$cat_title = strtoupper(stripslashes($cats['cat_title']));
		$cat_desc = stripslashes($cats['cat_desc']);

		$display_block .= "<p><strong><a href=\"".$_SERVER['PHP_SELF'].
			"?cat_id=".$cat_id."\">".$cat_title."</a></strong><br/>"
			.$cat_desc."</p>";

		if (isset($_GET['cat_id']) && ($_GET['cat_id'] == $cat_id)) {
			//create safe value for use
			$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']);

			//get items
			$get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE
				cat_id = '".$cat_id."' ORDER BY item_title";
			$get_items_res = mysqli_query($mysqli, $get_items_sql)
			or die(mysqli_error($mysqli));

			if (mysqli_num_rows($get_items_res) < 1) {
				$display_block = "<p><em>Sorry, no items in this category.</em></p>";
		} else {
			$display_block .= "<ul>";
			while ($items = mysqli_fetch_array($get_items_res)) {
				$item_id = $items['id'];
				$item_title = stripslashes($items['item_title']);
				$item_price = $items['item_price'];

				$display_block .= "<li><a
				href=\"showitem.php?item_id=".
				$item_id."\">".$item_title."</a>
				(\$".$item_price.")</li>";
			}

			$display_block .= "</ul>";
		}
		//free results
		mysqli_free_result($get_items_res);
		}
	}
}
//free results
mysqli_free_result($get_cats_res);
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Categories</title>
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