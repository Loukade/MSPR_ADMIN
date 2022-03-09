<?php


namespace mspr\Controller;


use mspr\Database\ActiveDirectory\ActiveDirectory;
use mspr\Database\Database;
use mspr\User\User;

/**
 * Class controler_accueil
 * @package pronostics\Controler
 */
class controllerLogin extends controllerDefault
{

    /**
     * controler_accueil constructor.
     */
    public function __construct()
    {
        //var_dump(Database::prepare("Select * from Machine where CODE = :id", array(":id" => 1)));
        $test = new ActiveDirectory("MSPR.LAN");
        var_dump($test->startConnection("MSPR",""));
        $this->handleForm();
        $this->show();
    }

    /**
     * Affiche la vue
     * @return void
     */
    public function show()
    {
        require_once 'App/views/login.php';
    }

    public function handleForm(){
        if (isset($_POST['pseudo'])){
            $test = new User($_POST['pseudo']);
            $state = $test->login($_POST['password'],$test->loadMockup());
            if($state){
                header("Location: ?controller=2faVerif");
            }
        }
    }

}