<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('App/modeles/Autoloader.php');
$autoload = new \mspr\Autoloader();
$autoload::register();

$islogin = false;
$isApi = false;

ob_start();
if (empty($_GET['controller'])) {
    $controller = "Login";
    $controllerLogin = new mspr\Controller\controllerLogin();
    $controllerLogin->show();
} else {
    if ($_GET['controller'] === "api"){
        $isApi = true;
    }

    $controller = $_GET['controller'];
    $classeController = 'Controller' . $_GET['controller'];
    $fichierController = $classeController . ".php";

    $objectWithNamespace = $autoload->getNamespace().'\Controller\Controller' . $_GET['controller'];

    if(file_exists(\Utils\Path::CONTROLLER . $fichierController)){
        require_once(\Utils\Path::CONTROLLER . $fichierController);

        $objetController = new $objectWithNamespace();
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            $objetController->$action();
        }
    }else{
        if (!$isApi){
            header('Location: ?controller=404');
        }
    }
}
$content = ob_get_clean();
if(!$isApi){
    require_once( \Utils\Path::TEMPLATE .'default.php');
}else{
    echo "Server up";
}