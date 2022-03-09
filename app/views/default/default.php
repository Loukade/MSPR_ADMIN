<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MSPR Reseau</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

<nav>
    <div class="nav-wrapper">
        <a href="?" class="brand-logo">MSPR Reseau</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
                <?php
                    if(isset($_SESSION['user'])){
                ?>
                    <a href="?controller=logout">Deconnexion</a>
                <?php
                    }else{
                ?>
                    <a href="?controller=login">Login</a>
                <?php
                    }
                ?>
            </li>
        </ul>
    </div>
</nav>

<?=
/** @var $content */
$content
?>


</body>
</html>
