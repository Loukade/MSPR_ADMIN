<?php
namespace mspr\User;

use mspr\Database\Database;
use mspr\Services\SmsService\SmsService;
use Utils\SiteInterface;

class User{
    private string $email;
    private string $pseudo;

    public function __construct($email,$pseudo)
    {
        $this->pseudo = $pseudo;
        $this->email = $email;
    }


    public function Authenticate(){
        if($this->checkBlacklist()){
            SiteInterface::alert(":(","Vous êtes actuellement banni de nos services veuillez contacter un admin",2);
        }else {
            $_SESSION['error'] = 0;
            $isExist = Database::count("select * from Users where id = :id", array(":id" => $this->email));
            $user = Database::prepare("select * from Users where id = :id", array(":id" => $this->email), true, true);
            if ($isExist > 0) {
                $userAgentId = $this->addUserAgent($_SERVER["HTTP_USER_AGENT"]);
                $ipId = $this->addIp($_SERVER["HTTP_USER_AGENT"]);
                $twoFACode = $this->create2faCode($user, $userAgentId, $ipId);
                try {
                    SmsService::sendSms($user["telephone"], $twoFACode);
                } catch (\Exception $exception) {
                    SiteInterface::alert("Ooopps", "Votre numéro de téléphone n'est pas valide", 3);
                }
                return true;
            } else {
                $this->createUser();
            }
            return false;
        }
    }

    private function checkBlacklist(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $list = Database::count("Select * from blacklist where ip = :ip",array(":ip" => $ip),true,false);
        if($list > 0){
            return true;
        }
        return false;
    }

    public static function brutForce(){
        if(isset($_SESSION['error'])){
            if ($_SESSION["error"] == 4){
                $ip = $_SERVER['REMOTE_ADDR'];
                Database::prepare("insert into blacklist(ip) value(:ip)", array(":ip" => $ip),false);
            }else{
                $_SESSION['error']++;
            }
        }else{
            $_SESSION['error'] = 1;
        }
    }

    public function create2faCode($user,$useragent,$ip){
        $random = rand(1000,10000);
        Database::prepare("insert into Se_Connecter(idMachine,idNavigateur,idUser,2FA,last_login) values (:idMachine,:idNav,:idUser,:2FA,Now())", array(":idMachine" => $ip[0], ':idNav' => $useragent[0],':idUser' => $user["id"], '2FA' => $random), false);
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

    public static function getUser($user){
        return Database::prepare("select * from Users where name = :name", array(":name" => $user),true,true);
    }

    public static function getLastConnect($user){
        return Database::prepare("select * from Se_Connecter where idUser = :idUser order by last_login desc",array(":idUser" => $user),true,true);
    }

    public static function createConn($user){
        $_SESSION['user'] = $user;
    }

    public static function logout(){
        session_destroy();
        header("Location: ?");
    }

}