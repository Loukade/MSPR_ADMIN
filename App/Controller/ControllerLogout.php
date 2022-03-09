<?php
namespace mspr\Controller;
use mspr\User\User;

class ControllerLogout extends ControllerDefault{
    /**
     * controler_accueil constructor.
     */
    public function __construct()
    {
       User::logout();
    }
}