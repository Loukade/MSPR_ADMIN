<?php
namespace Utils;

class GeolocationUtils extends ApiUtils {
    private $apiKey = "8e74d0ab320eed483e4f369aab1541d2";
    private $ip;


    public function __construct($ip)
    {
        $this->ip = $ip;
    }

    public function getGeolocation(){
        return $this->sendRequest("http://api.ipstack.com/".$this->ip."?access_key=".$this->apiKey."&format=1&language=fr");
    }
}