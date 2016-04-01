<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageExecutionTime {
    
    /**
     *
     * @var array
     */
    private $total = array();
    
    /**
     * Array of cURL Handles
     * @var array
     */
    private $curlHandles;
    
    private $file;
    
    public function __construct($file)
    {
        if(is_resource($file)) {
            $this->file = $file;
        }
    }
    
    /**
     * Logs the output using an EventLog object
     */
    public function log(EventLog $log)
    {
        
    }
    
    /**
     * Finds the total time taken in execution of the HTTP GET Pages
     * @return array
     */
    public function total()
    {
        
    }
    
    /**
     * 
     * @param type $ch
     * @param type $url
     * @return array Array of handle, contents and cURL GET Info
     */
    protected function curlGet($ch, $url = '')
    {
        if(!empty($url)) {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000);
        
        return curl_exec($ch);
    }
    
    protected function isSuccessFul($ch)
    {
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return ($status >= 200 && $status < 300) || $status == 304;
    }
    
    public function get($url = '')
    {
        if(empty($url) && !is_resource($this->file)) {
            throw new Exception("Not a valid file or URL to execute HTTP GET", __FILE__ . ': ' . __LINE__);
        }
        if(is_resource($this->file)) {
            $time = array();
            $attributes = $this->parse();
            if(!empty($attributes)) {
                foreach($attributes as $link) {
                    $curlHandle = curl_init($link);
                    array_push($this->curlHandles, $curlHandle);
                    $this->curlGet($curlHandle);
                    $this->total[$link] = curl_getinfo($curlHandle, CURLINFO_TOTAL_TIME);
                }
            }
        } elseif(!empty($url)) {
            $curlHandle = curl_init($url);
            $this->curlGet($curlHandle);
            $this->total[$link] = curl_getinfo($curlHandle, CURLINFO_TOTAL_TIME);
        }
        return $this;
    }
    
    public function close()
    {
        if(!empty($this->curlHandles)) {
            for($index = 0; $index < count($this->curlHandles); $index++) {
                curl_close($this->curlHandles[$index]);
            }
            return true;
        }
        return false;
    }
    
    public function parse()
    {
        $xmlElement = simplexml_load_string(stream_get_contents($this->file));
        $attributes = array();
        if(!empty($xmlElement->pages->page)) {
            foreach($xmlElement->pages->page as $page) {
                $pageAttributes = $page->attributes();
                array_push($attributes, $pageAttributes['href']);
            }
        }
        return $attributes;
    }
}