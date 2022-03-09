<?php
namespace mspr\Controller;
class controller404 extends controllerDefault{
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
        require_once 'App/views/404.php';
    }
}