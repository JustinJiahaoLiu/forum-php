<?php
include 'ch21_include.php';
doDB();

$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];

//gather the topics by form id
$get_topics_sql = "SELECT topic_id, topic_title,
DATE_FORMAT(topic_create_time, '%b %e %Y at %r') AS
fmt_topic_create_time, topic_owner FROM forum_topics
WHERE forum_id = '". $forum_id."' 
ORDER BY topic_create_time DESC";

$get_topics_res = mysqli_query($mysqli, $get_topics_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_topics_res) < 1) {
    //there are no topics, so say so
$display_block = "<p><em>No topics exist.</em></p>";
} else {
    //create the display string
$display_block = <<<END_OF_TEXT
<table>
<tr>
<th>TOPIC TITLE</th>
<th># of POSTS</th>
</tr>
END_OF_TEXT;

while ($topic_info = mysqli_fetch_array($get_topics_res)) {
$topic_id = $topic_info['topic_id'];
$topic_title = stripslashes($topic_info['topic_title']);
$topic_create_time = $topic_info['fmt_topic_create_time'];
$topic_owner = stripslashes($topic_info['topic_owner']);

//get number of posts
$get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
    forum_posts WHERE topic_id = '".$topic_id."'";

$get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql)
or die(mysqli_error($mysqli));

while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
        $num_posts = $posts_info['post_count'];
}

//add to display
$display_block .= <<<END_OF_TEXT
<tr>
<td><a href="showtopic.php?topic_id=$topic_id&forum_id=$forum_id&forum_name=$forum_name">
<strong>$topic_title</strong></a><br/>
Created on $topic_create_time by $topic_owner</td>
<td class="num_posts_col">$num_posts</td>
</tr>
END_OF_TEXT;
}
//free results
mysqli_free_result($get_topics_res);
mysqli_free_result($get_num_posts_res);

//close connection to MySQL
mysqli_close($mysqli);

//close up the table
$display_block .= "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Topics in My Forum</title>
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
    </ol>
</nav>


<h1>Topics in My Forum</h1>
<?php echo $display_block; ?>
<p>Would you like to <a href="addtopic.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>">add a topic</a>?</p>
</div>
</body>
</html>