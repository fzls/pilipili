<?php $navbar_style = 'navbar-default'; ?>
<nav class="navbar <?php echo $navbar_style; ?>" role="navigation" id="global_nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#"><img src="../img/logo<?php if ($navbar_style === 'navbar-inverse') echo '_white'; ?>.png"
                             alt="pilipili" height="50px"/></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="../home/index.php">Home</a></li>
                <li><a href="../image/upload.php">Submit</a></li>
                <li><a href="#">Manage</a></li>
                <li><a href="#">Bookmark</a></li>
                <li><a href="#">Feed</a></li>
            </ul>
            <!--            TODO: add search -->
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../common/help.php"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"><span class="glyphicon glyphicon-cog"></span>Settings</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">User settings</a></li>
                        <li><a href="#">Profile settings</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="../account/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>