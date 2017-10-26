<?php

namespace TRTApi;

class TRTApi {
    protected $apiKey;
    protected $apiSecret;
    protected $apiDomain = "https://api.therocktrading.com/v1";

    public function __construct($apiKey, $apiSecret) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    protected function createHeaders($url) {
        $nonce=microtime(true)*10000;
        $signature=hash_hmac("sha512",$nonce.$url, $this->apiSecret);

        $headers=array(
          "Content-Type: application/json",
          "X-TRT-KEY: ".$this->apiKey,
          "X-TRT-SIGN: ".$signature,
          "X-TRT-NONCE: ".$nonce
        );

        return $headers;
    }

    public function getTrades($fund_id) {
        $url= $this->apiDomain."/funds/".$fund_id."/trades";
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $this->createHeaders($url, $this->apiKey, $this->apiSecret));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $callResult=curl_exec($ch);
        curl_close($ch);

        $result=json_decode($callResult,true);
        return $result;
    }

    public function getTicker($fund_id)
    {
        $url= $this->apiDomain."/funds/".$fund_id."/ticker";

        $headers=array(
            "Content-Type: application/json"
        );

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $this->createHeaders($url, $this->apiKey, $this->apiSecret));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $callResult=curl_exec($ch);
        curl_close($ch);

        $result=json_decode($callResult,true);

        return $result;
    }


}