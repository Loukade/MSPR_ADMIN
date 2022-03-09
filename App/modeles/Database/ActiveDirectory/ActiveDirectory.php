<?php

namespace mspr\Database\ActiveDirectory;

class ActiveDirectory
{

    private function setupCon(){
        $ldap_host = "ldap://192.168.43.25";  //inserer ici l'addresse du serveur LDAP
        $base_dn = "DC=MSPR,DC=LAN";

        $connect = ldap_connect($ldap_host);// connexion en anonymous
        ldap_set_option($connect,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($connect, LDAP_OPT_REFERRALS,0);
        return [$connect,$base_dn];
    }

    public function login($user,$password)
    {
        $userGlobal = $user."@MSPR.LAN";
        $connect = $this->setupCon();
        $bind = @ldap_bind($connect[0],$userGlobal , $password);
        if(!$bind){
            return false;
        }else{
            $filter = "(sAMAccountName=$user)";
            $read = ldap_search($connect[0],$connect[1],$filter);
            $query_user = ldap_get_entries($connect[0],$read);
        }
        return $query_user[0]['mail'][0];
    }

}