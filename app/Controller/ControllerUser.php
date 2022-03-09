<?php
namespace mspr\Controller;

use mspr\Controller\controllerDefault;

/**
 * Class controler_accueil
 * @package pronostics\Controler
 */
class controllerUser extends controllerDefault
{

    /**
     * controler_accueil constructor.
     */
    public function __construct()
    {
        $this->show();
    }

    /**
     * Affiche la vue
     * @return void
     */
    public function show()
    {
        require_once 'App/views/user/profil.php';
    }

}