<?php

namespace mspr\Controller;

use mspr\User\User;
use Utils\SiteInterface;

class Controller2faVerif
{

    public function __construct()
    {
        $this->handletwofactor();
        $this->show();
    }

    private function show(){
        require_once 'App/views/2fa_verif.php';
    }

    private function handletwofactor(){
        $user = "";
        if(isset($_GET['user'])){
            $user = User::getUser($_GET["user"]);
            if(!$user){
                header('Location: ?');
            }
        }
        $lastCon = User::getLastConnect($user['id']);
        if(isset($_POST['code'])){
            if($lastCon["2FA"] == $_POST['code']){
                User::createConn($user);
                header("Location: ?controller=User");
            }else{
                SiteInterface::alert("Ooops","Code incorrect",3);
            }
        }
    }
}