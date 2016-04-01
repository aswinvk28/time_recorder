<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once TIMER_ROOT . '/page_time_execution.php';

class TimeRecorder {
    
    /**
     * Named Timer
     * @var string
     */
    private $name;
    
    /**
     * State of the Timer
     * @var string
     */
    private $state;
    
    private $recordStore = array();
    
    public function __construct($name = '')
    {
        $this->name = $name;
    }
    
    public static function timer($name = '')
    {
        return new static($name);
    }
    
    public static function pageTimer($file = '')
    {
        return new PageExecutionTime($file);
    }
    
    public function log(EventLog $log)
    {
        if($this->state == "Ended") {
            $log->write("\n" . $this->name . " Ended: " . 
                    ($this->recordStore[$this->name]['end'] - $this->recordStore[$this->name]['start']) . " microseconds");
        } elseif($this->state == "Started") {
            $log->write("\n" . $this->name . " Started");
        }
    }
    
    public function start()
    {
        $this->state = "Started";
        $this->recordStore[$this->name] = array('start' => microtime());
    }
    
    public function end()
    {
        $this->state = "Ended";
        $this->recordStore[$this->name]['end'] = microtime();
    }
    
    public function total()
    {
        foreach($this->recordStore as $name => $info) {
            $log->write("\n" . $name . " Ended: " . ($info['end'] - $info['start']) . " microseconds");
        }
    }
}