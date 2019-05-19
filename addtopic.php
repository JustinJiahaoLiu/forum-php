<?php
$forum_id = $_GET['forum_id'];
$forum_name = $_GET['forum_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add a Topic to <?php echo $forum_name?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
<?php
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
    <h3>Add a Topic</h3>
    <h5>to <span class= "text-info"><?php echo $forum_name?></span></h5>
    <form method="post" action="do_addtopic.php?forum_id=<?php echo $forum_id?>&forum_name=<?php echo $forum_name ?>">
        <div class="form-group">
        <input type="text" name="forum_id" value="<?php echo $forum_id ?>" hidden>
        </div>

        <div class="form-group">
        <label for="topic_owner">Email Address:</label>
        <input class="form-control" type="email" id="topic_owner" name="topic_owner" placeholder="Enter email" maxlength="150" required="required" />
        </div>

        <div class="form-group">
        <label for="topic_title">Topic Title:</label><br/>
        <input class="form-control" type="text" id="topic_title" name="topic_title" placeholder="Enter title" maxlength="150" required="required" />
        </div>

        <div class="form-group">
        <label for="post_text">Post Text:</label><br/>
        <textarea class="form-control" id="post_text" name="post_text" rows="8"cols="40" ></textarea>
        </div>

        <button type="submit" class="btn btn-info" name="submit" value="submit">Add Topic</button>
    </form>
</div>
</body>

</html>