<?php
namespace mspr\User;

use mspr\Services\SmsService\SmsService;

class User{
    private string $pseudo;
    private string $phoneNumber;

    public function __construct($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function login(string $password, $mockup): bool{
        // Ci dessous est un mockup, sera changé lors de l'obtention de la base de donnée
        foreach ($mockup as $k => $value){
            foreach ($value as $key => $item){
                if (trim($key) == "user"){
                    if ($this->pseudo === $item){
                        $mockupPassword = $mockup[$k]['password'];
                        if ($mockupPassword === $password){
                            var_dump('success');
                            SmsService::sendSms($mockup[$k]['phoneNumber']);
                            return true;
                        }else{
                            var_dump('badPassword');
                        }
                    }
                }
            }
        }
        return false;
    }

    public function loadMockup(){
        $mockup = file_get_contents(__DIR__."/../../../mockup/user.json");
        $mockup_json = json_decode($mockup, true);
        return $mockup_json;
    }

    private function Authenticate(){

    }

}