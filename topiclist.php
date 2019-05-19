<?php
include 'ch21_include.php';
doDB();

$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];

$get_topics_count_sql = "SELECT COUNT(topic_id) FROM forum_topics
WHERE forum_id = '". $forum_id."' ORDER BY topic_create_time DESC";

$get_topics_count_res = mysqli_query($mysqli, $get_topics_count_sql)
or die(mysqli_error($mysqli));

//------------Set Pagination-----------
$limit = 3;
if (isset($_GET["page"])){
    $page  = $_GET["page"]; 
}else { $page=1; };
$start_from = ($page-1) * $limit; 

$row = mysqli_fetch_row($get_topics_count_res);
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

//gather the topics by form id
$get_topics_sql = "SELECT topic_id, topic_title,
DATE_FORMAT(topic_create_time, '%b %e %Y at %r') AS
fmt_topic_create_time, topic_owner FROM forum_topics
WHERE forum_id = '". $forum_id."' ORDER BY topic_create_time DESC LIMIT $start_from, $limit";

$get_topics_res = mysqli_query($mysqli, $get_topics_sql)
or die(mysqli_error($mysqli));



if (mysqli_num_rows($get_topics_res) < 1) {
    //there are no topics, so say so
$display_block = "<p><em>No topics exist.</em></p>";
} else {

    //create the display string
$display_block = <<<END_OF_TEXT
<table class="table">
    <thead class="bg-info text-white">
    <tr>
      <th scope="col">Posts</th>
      <th scope="col">Topics</th>
      <th scope="col">Owner</th>
      <th scope="col">Last post</th>
    </tr>
    </thead>
<tr>
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
<td>$num_posts</td>

<th scope="row">
<a href="showtopic.php?topic_id=$topic_id&forum_id=$forum_id&forum_name=$forum_name">$topic_title</a>
</th>
<td>
<span class='text-primary'>$topic_owner</span>
<p>$topic_create_time</p>
</td>

<td>
<span class='text-primary'>$last_post_owner</span>
<p>$last_post_time</p>
</td>
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
<title><?php echo $forum_name?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
  
    <link rel="stylesheet" href="css/app.css">
    <link type="text/css" rel="stylesheet" href="css/simplePagination.css"/>
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


<?php echo $display_block; ?>
<?php
    $pagLink = "<nav><ul class='pagination'>";
    for ($i=1; $i<=$total_pages; $i++) {  
            $pagLink .= "<li><a href=\"topiclist.php?forum_id=$forum_id&forum_name=$forum_name&page=".$i."\">".$i."</a></li>";  
        };  
    echo $pagLink . "</ul></nav>";
?>
<a class="btn btn-info" href="addtopic.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>">    
&#10133; Add a topic</a>
</div>

<script>
    $(document).ready(function(){
    $('.pagination').pagination({
            items: <?php echo $total_records;?>,
            itemsOnPage: <?php echo $limit;?>,
            cssStyle: 'light-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : "topiclist.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>&page="
        });
        });
</script>
</body>
</html>