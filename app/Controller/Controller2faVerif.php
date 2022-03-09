<?php

namespace mspr\Controller;

class Controller2faVerif
{

    public function __construct()
    {
        $this->show();
    }

    private function show(){
        require_once 'App/views/2fa_verif.php';
    }
}