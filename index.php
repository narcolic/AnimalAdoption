<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">-->
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php
    include_once ("controllers/Controller.php");
    $controller = new Controller();
    $controller->invoke();

?>
</body>
</html>
