<?php
namespace mspr\Controller;
use mspr\User\User;

class ControllerLogout extends controllerDefault{
    /**
     * controler_accueil constructor.
     */
    public function __construct()
    {
       User::logout();
    }
}