
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Demo Forum</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link <?php echo isset($_GET['forum_id'])?"":"active"; ?>" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($_GET['forum_id'])?($_GET['forum_id']=="1"?"active":""):""; ?>" href="topiclist.php?forum_id=1&forum_name=Final Fantacy XIV">FF14</a>
            </li>
            <li class="nav-item <?php echo isset($_GET['forum_id'])?($_GET['forum_id']=="2"?"active":""):""; ?>">
                <a class="nav-link" href="topiclist.php?forum_id=2&forum_name=Guild Wars 2">GW2</a>
            </li>
            <li class="nav-item <?php echo isset($_GET['forum_id'])?($_GET['forum_id']=="3"?"active":""):""; ?>">
                <a class="nav-link" href="topiclist.php?forum_id=3&forum_name=World of Warcraft">WoW</a>
            </li>
            <li class="nav-item <?php echo $_SERVER['REQUEST_URI'] == "/forum-php/seestore.php"?"active":"" ?>">
                <a class="nav-link" href="seestore.php">Shop</a>
            </li>
            <li class="nav-item <?php echo $_SERVER['REQUEST_URI'] == "/forum-php/showcart.php"?"active":"" ?>">
                <a class="nav-link" href="showcart.php"><h3>&#128722;</h3></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>
        
    </div>
</nav>