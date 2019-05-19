<?php
include 'ch21_include.php';
doDB();

//check for required fields from the form
if ((!$_POST['forum_id']) ||(!$_POST['topic_owner']) || (!$_POST['topic_title']) || (!$_POST['post_text'])) {
    header('Location: addtopic.php');
    exit;
}

$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];

//create safe values for input into the database
$clean_forum_id = mysqli_real_escape_string($mysqli, $_POST['forum_id']);
$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['topic_owner']);
$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['topic_title']);
$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

//create and issue the first query
$add_topic_sql = "INSERT INTO forum_topics(topic_title, topic_create_time, topic_owner,forum_id)
VALUES ('".$clean_topic_title ."', now(), '".$clean_topic_owner."', '".$clean_forum_id."')";

$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

//get the id of the last query
$topic_id = mysqli_insert_id($mysqli);

//create and issue the second query
$add_post_sql = "INSERT INTO forum_posts(topic_id, post_text, post_create_time, post_owner, forum_id) 
VALUES ('".$topic_id."', '".$clean_post_text."',now(), '".$clean_topic_owner."', '".$clean_forum_id."')";

$add_post_res = mysqli_query($mysqli, $add_post_sql)
or die(mysqli_error($mysqli));
//close connection to MySQL
mysqli_close($mysqli);

//create nice message for user
$display_block = "<p>The <strong>".$_POST["topic_title"]."</strong>
topic has been created.</p>";
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Topic Added</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<h1>New Topic Added</h1>
<?php
include 'layouts/navbar.php';
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="topiclist.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>"><?php echo $forum_name?></a></li>
    </ol>
</nav>
<?php echo $display_block; ?>

</div>
</body>
</html>