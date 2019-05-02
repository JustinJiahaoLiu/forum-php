<!DOCTYPE html>
<html>
<head>
    <title>Add a Topic</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
<?php
$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];

include 'layouts/navbar.php';
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="topiclist.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name?>"><?php echo $forum_name?></a></li>
        <li class="breadcrumb-item"><a href="#">Add a topic</a></li>
    </ol>
</nav>

<div class="container">
    <h1>Add a Topic</h1>
    <form method="post" action="do_addtopic.php">
        <h5>to <?php echo $forum_name?></h5>
        <input type="text" name="forum_id" value="<?php echo $forum_id ?>" hidden>
        <p><label for="topic_owner">Your Email Address:</label><br/>
        <input type="email" id="topic_owner" name="topic_owner" size="40"
                   maxlength="150" required="required" /></p>

        <p><label for="topic_title">Topic Title:</label><br/>
        <input type="text" id="topic_title" name="topic_title" size="40"
                   maxlength="150" required="required" /></p>
        <p><label for="post_text">Post Text:</label><br/>
        <textarea id="post_text" name="post_text" rows="8"
                    cols="40" ></textarea></p>

        <button type="submit" name="submit" value="submit">Add Topic</button>
    </form>
</div>
</body>

</html>