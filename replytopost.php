<?php
include 'ch21_include.php';
doDB();

$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];

//check to see if we're showing the form or adding the post
if (!$_POST) {
    // showing the form; check for required item in query string
if (!isset($_GET['post_id'])) {
        header("Location: topiclist.php?forum_id=$forum_id&forum_name=$forum_name");
exit;
}



//create safe values for use
$safe_post_id = mysqli_real_escape_string($mysqli, $_GET['post_id']);

//still have to verify topic and post
$verify_sql = "SELECT ft.topic_id, ft.topic_title FROM forum_posts
AS fp LEFT JOIN forum_topics AS ft ON fp.topic_id =
        ft.topic_id WHERE fp.post_id = '".$safe_post_id."'";

$verify_res = mysqli_query($mysqli, $verify_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_res) < 1) {
//this post or topic does not exist
header("Location: topiclist.php");
exit;
} else {
//get the topic id and title
while($topic_info = mysqli_fetch_array($verify_res)) {
$topic_id = $topic_info['topic_id'];
$topic_title = stripslashes($topic_info['topic_title']);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Post Your Reply in <?php echo $topic_title; ?></title>
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
<nav aria-label="breadcrumb">
    <ol class="breadcrumb arr-right">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="topiclist.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>"><?php echo $forum_name?></a></li>
        <li class="breadcrumb-item"><a href="#">Reply to post</a></li>
    </ol>
</nav>

<h1>Post Your Reply in <?php echo $topic_title; ?></h1>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div class="form-group">
        <input type="text" name="forum_id" value="<?php echo $forum_id ?>" hidden>
        <input type="text" name="forum_name" value="<?php echo $forum_name ?>" hidden>
    </div>
<p><label for="post_owner">Your Email Address:</label><br/>
<input type="email" id="post_owner" name="post_owner" size="40"
maxlength="150" required="required"></p>
<p><label for="post_text">Post Text:</label><br/>
<textarea id="post_text" name="post_text" rows="8" cols="40"
required="required"></textarea></p>
<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
<button type="submit" name="submit" value="submit">Add Post</button>
</form>
</div>
</body>
</html>
<?php
}
//free result
mysqli_free_result($verify_res);

//close connection to MySQL
mysqli_close($mysqli);

} else if ($_POST) {
//check for required items from form
if ((!$_POST['topic_id']) || (!$_POST['post_text']) ||
(!$_POST['post_owner']) || (!$_POST['forum_id']) || (!$_POST['forum_name'])) {
header("Location: topiclist.php");
exit;
}

//create safe values for use
$safe_forum_id = mysqli_real_escape_string($mysqli, $_POST['forum_id']);
$safe_forum_name = mysqli_real_escape_string($mysqli, $_POST['forum_name']);
$safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['topic_id']);
$safe_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);
$safe_post_owner = mysqli_real_escape_string($mysqli, $_POST['post_owner']);

//add the post
$add_post_sql = "INSERT INTO forum_posts (topic_id,post_text,
post_create_time,post_owner, forum_id) VALUES
('".$safe_topic_id."', '".$safe_post_text."',
now(),'".$safe_post_owner."','".$safe_forum_id."')";
$add_post_res = mysqli_query($mysqli, $add_post_sql)
or die(mysqli_error($mysqli));

//close connection to MySQL
mysqli_close($mysqli);

//redirect user to topic
header("Location: showtopic.php?topic_id=$safe_topic_id&forum_id=$safe_forum_id&forum_name=$safe_forum_name");
exit;
}
?>