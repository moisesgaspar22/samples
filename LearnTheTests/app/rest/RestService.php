<?php

namespace someApp\rest;

/**
 * Testing external calls to APIS
 */
class RestService
{
    /**
     * holds the response result
     *
     * @var array or object
     */
    protected $result;
    
    /**
     * test endpoint
     * hardcoded just for testing purposes
     * http://www.mocky.io/v2/5d85026f3000006ceb22dcc2
     * 
     * @var string
     */
    protected $url = 'http://www.mocky.io/v2/5185415ba171ea3a00704eed';
    
    /**
     * Testing external calls to APIS
     * make a request to the mock url
     */
    public function request($url = '', $arr = false)
    {
        if (empty($url)) {
            $url = $this->url;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $this->result = json_decode($result, $arr);
        //return $this->result = json_decode(file_get_contents($url), $arr);
    }
    
    /**
     * get result from call
     * @return string|array
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * set the url for a new call/result
     * @return void
     */
    public function setUrl($newUrl)
    {
        $this->url = $newUrl;
    }
}
