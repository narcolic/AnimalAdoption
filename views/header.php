<?php ?>
<!-- navbar-fixed-top -->
<nav class="navbar navbar-inverse ">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                    class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php<?php if (isset($this->headerModel['user'])) { echo '?action=home'; }?>" class="navbar-brand">A Pet's World</a>
        </div>
        <?php if (!isset($this->headerModel['user'])): ?>
            <div class="navbar-collapse collapse" id="navbar">
                <form class="navbar-form navbar-right" action="index.php?action=login" method="post">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-success" type="submit">Sign in</button>
                    <a class="btn btn-info" href="index.php?action=register">Register</a>
                </form>
            </div><!--/.navbar-collapse -->
        <?php else: ?>
            <div class="navbar-collapse collapse" id="navbar">
                <form class="navbar-form navbar-right" action="index.php?action=logout" method="post">
                    <div class="form-group">
                        <h4>Hello, <?php echo  $this->headerModel['user']->username ?>&nbsp;</h4>
                    </div>
                    <button class="btn btn-success" type="submit">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">HakunaLePeta</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
        </div>
    </nav>

</nav>