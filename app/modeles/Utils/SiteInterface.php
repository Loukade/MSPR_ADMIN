<?php
namespace Utils;

class SiteInterface{
    /**
     * @param $titre
     * @param $message
     * @param $type
     * @return void
     */
    public static function alert($titre,$message,$type):void{
        $possibleType = "";
        switch ($type){
            case 1:{
                $possibleType = "success";
                break;
            }
            case 2:{
                $possibleType = "info";
                break;
            }
            case 3:{
                $possibleType = "error";
                break;
            }
        }
        echo "<script> swal('$titre','$message','$possibleType') </script>";
    }
}