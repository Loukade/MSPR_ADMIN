<?php
namespace Utils;

class GeolocationUtils extends ApiUtils {
    private $apiKey = "bfbcafa716a8191ba7708e62e74fc306";
    private $ip;


    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function getGeolocation(){
        return $this->sendRequest("http://api.ipstack.com/".$this->ip."?access_key=".$this->apiKey."&format=1&language=fr");
    }
}