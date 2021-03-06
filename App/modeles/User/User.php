<?php
namespace mspr\User;

use mspr\Database\Database;
use mspr\Services\SmsService\SmsService;
use Utils\ApiUtils;
use Utils\GeolocationUtils;
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
        if (User::checkCountry()){
            if ($this->checkBlacklist()) {
                SiteInterface::alert(":(", "Vous êtes actuellement banni de nos services veuillez contacter un admin", 2);
            } else {
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
    }

    public static function checkCountry(){
        $ip = SiteInterface::getIp();
        $authorized = false;
        /**
         * Code postaux autorisé : France
         */
        $authorizedCountry = [
            "FR",
            null
        ];
        $localisation = (new GeolocationUtils($ip))->getGeolocation();
        for ($i = 0; $i < count($authorizedCountry);$i++){
            if ($authorizedCountry[$i] == $localisation->country_code){
                $authorized = true;
                break;
            }
        }

        return $authorized;
    }

    private function checkBlacklist(){
        $ip = SiteInterface::getIp();
        $list = Database::count("Select * from blacklist where ip = :ip",array(":ip" => $ip),true,false);
        if($list > 0){
            return true;
        }
        return false;
    }

    public static function brutForce(){
        if(User::checkCountry()) {
            if(isset($_SESSION['error'])){
                if ($_SESSION["error"] == 4){
                    $ip = SiteInterface::getIp();
                    Database::prepare("insert into blacklist(ip) value(:ip)", array(":ip" => $ip),false);
                }else{
                    $_SESSION['error']++;
                }
            }else{
                $_SESSION['error'] = 1;
            }
        }else{
            SiteInterface::alert("Désolé","Votre pays ne peux pas acceder à nos services",2);
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
        $ip = SiteInterface::getIp();
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