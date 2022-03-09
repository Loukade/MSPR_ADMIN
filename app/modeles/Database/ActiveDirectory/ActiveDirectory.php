<?php

namespace mspr\Database\ActiveDirectory;

class ActiveDirectory
{

    public function __construct()
    {

    }

    public function lol()
    {
        $ldap_host = "ldap://192.168.43.25";  //inserer ici l'addresse du serveur LDAP
        $base_dn = "DC=MSPR,DC=LAN";
        $filter = "(sAMAccountName=Lucas.Jenvrain)";
        /*$user = "cn=" . $_POST['user'];  //  on traite les information recoltées
        $password = $_POST['pass'];*/

        $admin = "admin";  // indiquez ici le groupe auquels appartient les admin et les membres. dans mon exemple, j'ai un o=admin et un o=membres.
        $membres = "membres";

        $connect = ldap_connect($ldap_host);// connexion en anonymous
        ldap_set_option($connect,LDAP_OPT_PROTOCOL_VERSION,3);
        ldap_set_option($connect, LDAP_OPT_REFERRALS,0);
        $bind = ldap_bind($connect,"Mathys.Theolade@MSPR.LAN" , "User2@Serv");
        if(!$bind){
            echo 'user_error';
        }
        else
        {
            $read = ldap_search($connect,$base_dn,$filter);
            $query_user = ldap_get_entries($connect,$read);
            print_r($query_user);
        }


        var_dump($read);
        //or exit(">>Connexion au serveur LDAP echoué<<");

/*

        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);  // on passe le LDAP en version 3, necessaire pour travailler avec le AD
        ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);


        $read = ldap_search($connect, $base_dn, $user)
        or exit(">>erreur lors de la recherche<<");
        $info = ldap_get_entries($connect, $read);

        if (preg_match("!" . $admin . "!", $info[0]["dn"])) // si le user trouvé est admin :
        {
            $bind = ldap_bind($connect, $info[0]["dn"], $password);
            if ($bind == FALSE)    // si le BIND est FALSE, le mot de passe est erronée
                // echo( " il est admin mais faux mdp");
                header("location: auth_ldap.php?result='0'");
            elseif ($bind == TRUE)   // on peut ajouter d'autre traitement si l'identification est ok ( ex : $_SESSION['user'] = ... )
            {
                header("location: index.php");
            }
        } elseif (preg_match("!" . $membres . "!", $info[0]["dn"])) // si le user trouvé est membres :
        {
            $bind = ldap_bind($connect, $info[0]["dn"], $password);
            if ($bind == FALSE)  // si le BIND est FALSE, le mot de passe est erronée
                // echo( " il est membre mais faux mdp");
                header("location: auth_ldap.php?result='0'");

            elseif ($bind == TRUE)  // on peut ajouter d'autre traitement si l'identification est ok ( ex : $_SESSION['user'] = ... )
            {
                header("location: index.php");
            }
        } else // le user n'a pas pu être trouvé
        {
// echo  "nom de user invalide";
            header("location: auth_ldap.php?result='1'");
        }

        ldap_close($connect);

    */
    }

}