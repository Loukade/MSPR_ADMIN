<?php


namespace mspr\Controller;


use mspr\Database\ActiveDirectory\ActiveDirectory;
use mspr\Database\Database;
use mspr\User\User;
use Utils\SiteInterface;

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
            $pseudo = $_POST['pseudo'];
            //var_dump(Database::prepare("Select * from Machine where CODE = :id", array(":id" => 1)));
            $ldap = new ActiveDirectory();
            $bind = $ldap->login($pseudo,$_POST['password']);
            if(!$bind){
                SiteInterface::alert("Oops","Pseudo ou mot de passe incorrect",3);
            }else{
                $user = new User($bind,$pseudo);
                $isGood = $user->Authenticate();
                if(!$isGood){
                    SiteInterface::alert("Ouiiiii","Votre profil viens d'être crée, veuillez rentrer de nouveau vos identifiants",1);
                }else{
                    header('Location: ?controller=2faVerif&user='.$pseudo);
                }
            }
        }
    }

}