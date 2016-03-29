<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/bootstrap.js"></script>
</head>
<body>
<div>
    <?php
    include_once("controllers/Controller.php");
    $controller = new Controller();
    $controller->invoke();

    ?>
</div>
</body>
</html>
