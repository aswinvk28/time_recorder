<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('TIMER_ROOT', dirname(__FILE__));

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
    
    private static $recordStore = array();
    
    public function __construct($name = '')
    {
        $this->name = $name;
    }
    
    public static function timer($name = '')
    {
        return new self($name);
    }
    
    public static function pageTimer($file = '')
    {
        return new PageExecutionTime($file);
    }
    
    public function log(EventLog $log)
    {
        if($this->state == "Ended") {
            $log->write("\n" . $this->name . " Ended: " . 
                    (self::$recordStore[$this->name]['end'] - self::$recordStore[$this->name]['start']) . " seconds");
        } elseif($this->state == "Started") {
            $log->write("\n" . $this->name . " Started");
        }
        return $this;
    }
    
    public function start()
    {
        $this->state = "Started";
        self::$recordStore[$this->name] = array('start' => microtime(true));
        return $this;
    }
    
    public function end()
    {
        $this->state = "Ended";
        self::$recordStore[$this->name]['end'] = microtime(true);
        return $this;
    }
    
    public static function total(EventLog $log)
    {
        foreach(self::$recordStore as $name => $info) {
            $log->write("\n" . $name . " Ended: " . ($info['end'] - $info['start']) . " seconds");
        }
    }
}