<?php
include 'ch21_include.php';
doDB();

//check for required info from the query string
if (!isset($_GET['topic_id'])) {
    header("Location: topiclist.php");
exit;
}

$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];
//create safe values for use
$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);

$get_posts_count_sql = "SELECT COUNT(post_id) FROM forum_posts
WHERE topic_id = '".$safe_topic_id."'
ORDER BY post_create_time ASC";

$get_posts_count_res = mysqli_query($mysqli, $get_posts_count_sql)
or die(mysqli_error($mysqli));

//------------Set Pagination-----------
$limit = 3;
if (isset($_GET["page"])){
    $page  = $_GET["page"]; 
}else { $page=1; };
$start_from = ($page-1) * $limit; 

$row = mysqli_fetch_row($get_posts_count_res);
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);


//verify the topic exists
$verify_topic_sql = "SELECT topic_title FROM forum_topics
WHERE topic_id = '".$safe_topic_id."'";
$verify_topic_res = mysqli_query($mysqli, $verify_topic_sql)
or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_topic_res) < 1) {
    //this topic does not exist
$display_block = "<p><em>You have selected an invalid topic.<br/>
Please <a href=\"topiclist.php\">try again</a>.</em></p>";
} else {
    //get the topic title
while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
        $topic_title = stripslashes($topic_info['topic_title']);
}

//gather the posts
$get_posts_sql = "SELECT post_id, post_text,
DATE_FORMAT(post_create_time,
    '%b %e %Y<br/>%r') AS fmt_post_create_time, post_owner
FROM forum_posts
WHERE topic_id = '".$safe_topic_id."'
ORDER BY post_create_time ASC LIMIT $start_from, $limit";
$get_posts_res = mysqli_query($mysqli, $get_posts_sql)
or die(mysqli_error($mysqli));

//create the display string
$display_block = <<<END_OF_TEXT
<p>Showing posts for the <strong>$topic_title</strong> topic:</p>
<table class="table table-striped">
<thead class="bg-info text-white">
<tr>
<th style="width:300px;">AUTHOR</th>
<th style="width:810px;">POST</th>
</tr>
</thead>
END_OF_TEXT;

while ($posts_info = mysqli_fetch_array($get_posts_res)) {
$post_id = $posts_info['post_id'];
$post_text = nl2br(stripslashes($posts_info['post_text']));
$post_create_time = $posts_info['fmt_post_create_time'];
$post_owner = stripslashes($posts_info['post_owner']);

//add to display
$display_block .= <<<END_OF_TEXT
<tr>
<td><strong>$post_owner</strong><br/><br/>
created on:<br/>$post_create_time</td>
<td style="word-break: break-all;">$post_text<br/><br/>
<a href="replytopost.php?forum_id=$forum_id&forum_name=$forum_name&post_id=$post_id">
<strong>REPLY TO POST</strong></a></td>
</tr>
END_OF_TEXT;
}

//free results
mysqli_free_result($get_posts_res);
mysqli_free_result($verify_topic_res);

//close connection to MySQL
mysqli_close($mysqli);

//close up the table
$display_block .= "</table>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $topic_title?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.simplePagination.js"></script>
    <link type="text/css" rel="stylesheet" href="css/simplePagination.css"/>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<?php include 'layouts/navbar.php' ?>
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
            $pagLink .= "<li><a href=\"showtopic.php?topic_id=$safe_topic_id&forum_id=$forum_id&forum_name=$forum_name&page=".$i."\">".$i."</a></li>";  
        };  
    echo $pagLink . "</ul></nav>";
?>

<script>
    $(document).ready(function(){
    $('.pagination').pagination({
            items: <?php echo $total_records;?>,
            itemsOnPage: <?php echo $limit;?>,
            cssStyle: 'compact-theme',
            currentPage : <?php echo $page;?>,
            hrefTextPrefix : "showtopic.php?topic_id=<?php echo $safe_topic_id ?>&forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>&page="
        });
        });
</script>
</div>
</body>
</html>