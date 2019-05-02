<?php
include 'ch21_include.php';
doDB();

//gather the forums
$get_forums_sql = "SELECT forum_id, forum_name, forum_Description, forum_image
FROM forums";

$get_forums_res = mysqli_query($mysqli, $get_forums_sql)
or die(mysqli_error($mysqli));


if (mysqli_num_rows($get_forums_res) < 1) {
    //there are no topics, so say so
    $display_block = "<p><em>No topics exist.</em></p>";
} else {
    //create the display string
    $display_block = <<<END_OF_TEXT
    <table class="table">
    <thead class="bg-primary text-white">
    <tr>
      <th scope="col">MMORPG</th>
      <th scope="col">Topics</th>
      <th scope="col">Posts</th>
      <th scope="col">Last post</th>
    </tr>
    </thead>
END_OF_TEXT;

while ($forum_info = mysqli_fetch_array($get_forums_res)) {
        $forum_id = $forum_info['forum_id'];
        $forum_name = stripslashes($forum_info['forum_name']);
        $forum_des = $forum_info['forum_Description'];
        $forum_img = $forum_info['forum_image'];

        //get number of topics
        $get_num_topics_sql = "SELECT COUNT(topic_id) AS topic_count FROM
            forum_topics WHERE forum_id = '".$forum_id."'";

        $get_num_topics_res = mysqli_query($mysqli, $get_num_topics_sql)
        or die(mysqli_error($mysqli));

        while ($topics_info = mysqli_fetch_array($get_num_topics_res)) {
                $num_topics = $topics_info['topic_count'];
        }

        //get number of posts
        $get_num_posts_sql = "SELECT COUNT(post_id) AS post_count FROM
            forum_posts WHERE forum_id = '".$forum_id."'";

        $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql)
        or die(mysqli_error($mysqli));

        while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
                $num_posts = $posts_info['post_count'];
        }

        //get the last post
        $get_last_post_sql = "SELECT * FROM forum_posts WHERE forum_id = '".$forum_id."'
        ORDER BY post_create_time DESC LIMIT 1";

        $get_last_post_res = mysqli_query($mysqli, $get_last_post_sql)
        or die(mysqli_error($mysqli));
        while ($post_info = mysqli_fetch_array($get_last_post_res)) {
                $last_post_owner = $post_info['post_owner'];
                $last_post_time = $post_info['post_create_time'];
        }

//add to display
        $display_block .= <<<END_OF_TEXT
<tbody>
<tr>
<th scope="row">
<div class="d-flex">
<a href="topiclist.php?forum_id=$forum_id&forum_name=$forum_name"><img src="$forum_img"></a>
<div>
<a href="topiclist.php?forum_id=$forum_id&forum_name=$forum_name"><strong>$forum_name</strong></a><br/>
<p>$forum_des</p>
</div>
</div>
</th>
<td>$num_topics</td>
<td>$num_posts</td>
<td>
<span class='text-primary'>$last_post_owner</span>
<p>$last_post_time</p>
</td>
</tr>
END_OF_TEXT;
    }
//free results
    mysqli_free_result($get_forums_res);

//close connection to MySQL
    mysqli_close($mysqli);

//close up the table
    $display_block .= "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forums List</title>
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
    </ol>
</nav>

<?php echo $display_block; ?>
</div>
</body>
</html>