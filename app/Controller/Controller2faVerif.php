<?php

namespace mspr\Controller;

use mspr\User\User;

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
        if(isset($_GET['user'])){
            $user = User::getUser($_GET["user"]);
            if($user){
                $test = User::getLastConnect($user['id']);
                if(isset($_POST['login'])){
                    if($test["2FA"] == $_POST['code']){
                        var_dump("ouiiii");
                    }else{
                        var_dump("nonnnn");
                    }
                }
            }
        }
    }
}