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
            <a href="index.php" class="navbar-brand">A Pet's World</a>
        </div>
        <?php if (!isset($_SESSION['user'])): ?>
            <div class="navbar-collapse collapse" id="navbar">
                <form class="navbar-form navbar-right" action="index.php" method="post">
                    <input type="hidden" name="action" value="0">
                    <div class="form-group">
                        <input name="username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-success" type="submit">Sign in</button>
                    <a class="btn btn-info">Register</a>
                </form>
            </div><!--/.navbar-collapse -->
        <?php else: ?>
            <div class="navbar-collapse collapse" id="navbar">
                <form class="navbar-form navbar-right" action="index.php" method="post">
                    <div class="form-group">
                    <h4>Hello, <?php echo $_SESSION['user']->username ?>&nbsp;</h4>
                    </div>
                    <input type="hidden" name="action" value="1">
                    <button class="btn btn-success" type="submit">Logout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</nav>