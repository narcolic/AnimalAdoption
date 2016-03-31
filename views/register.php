<html>
<body>
<div class="jumbotron">
    <div class="container">
        <form class="form" action="index.php?action=register" method="post">
            <caption>
                <h2 class="form title">Register Form:</h2>
            </caption>
            <div class="form-group">
                Username:
                <input name="user_name" type="text" class="form-control" placeholder="name"><br/>
                Password:
                <input name="user_password" type="text" class="form-control" placeholder="password">
                <input name="register_user" type="hidden" value="1">
            </div>
            <button class="btn btn-success" type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>
