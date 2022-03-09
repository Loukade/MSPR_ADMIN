<?php
namespace mspr\User;

use mspr\Database\Database;
use mspr\Services\SmsService\SmsService;

class User{
    private string $email;
    private string $pseudo;

    public function __construct($email,$pseudo)
    {
        $this->pseudo = $pseudo;
        $this->email = $email;
    }

    public function Authenticate(){
        $isExist = Database::count("select * from Users where id = :id",array(":id" => $this->email));
        $user = Database::prepare("select * from Users where id = :id",array(":id" => $this->email),true,true);
        if($isExist > 0){
            $userAgentId = $this->addUserAgent($_SERVER["HTTP_USER_AGENT"]);
            $ipId = $this->addIp($_SERVER["HTTP_USER_AGENT"]);
            $twoFACode = $this->create2faCode($user,$userAgentId,$ipId);
            SmsService::sendSms($user["telephone"],$twoFACode);
           return true;
        }else{
            $this->createUser();
        }
        return false;
    }

    public function create2faCode($user,$useragent,$ip){
        $random = rand(1000,10000);
        Database::prepare("insert into Se_Connecter(idMachine,idNavigateur,idUser,2FA,last_login) values (:idMachine,:idNav,:idUser,:2FA,Now())", array(":idMachine" => $ip[0], ':idNav' => $useragent[0],':idUser' => $user["id"], '2FA' => $random), false);
        //Database::prepare("insert into Se_Connecter()");
        return $random;
    }

    private function addUserAgent($userAgent){
        Database::prepare("insert into Navigateur(name) value (:name)",array(':name' => $userAgent),false);
        return Database::prepare("select MAX(id) id from Navigateur",array(),true,true);
    }

    private function addIp(){
        $ip = $_SERVER['REMOTE_ADDR'];
        Database::prepare("insert into Machine(IP) value(:ip)", array(":ip" => $ip), false);
        return Database::prepare("select MAX(codeMachine) id from Machine",array(),true,true);
    }

    private function createUser(){
        Database::prepare("insert into Users(id,name,telephone) values(:id,:name,:tel)",array(":id" => $this->email, ":name" => $this->pseudo,":tel" => "00"));
        $this->Authenticate();
    }

}