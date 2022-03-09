<?php
namespace mspr\Database\ActiveDirectory;

class ActiveDirectory {
    private $host;

    public function __construct($host)
    {
        $this->host= $host;
    }

    private function getLDAP($port = 389){
        $conn = ldap_connect($this->host,$port);
        ldap_set_option($conn,LDAP_OPT_PROTOCOL_VERSION, 3);
        return $conn;
    }

    public function startConnection($ldap_dn,$ldap_password,$port = 389){
        if(ldap_bind($this->getLDAP(),$ldap_dn,$ldap_password)){
            echo "Connexion réussi";
        }else{
            echo "Connexion pas réussi";
        }
    }


    public function searchByName(){

    }
    public function closeConnection(){
        ldap_close($this->host);
    }

}