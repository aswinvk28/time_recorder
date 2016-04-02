<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'time_recorder.php';

class EventLog {
    public function write($data)
    {
        print $data;
    }
}

$eventLog = new EventLog();

// Named Timer
$timer = TimeRecorder::timer("Context 1")->start()->log($eventLog);
for($index = 0; $index < 100; $index++) {
    
}
$timer->end()->log($eventLog);

// Named Timer and List of Pages
$timer = TimeRecorder::timer("Context 2")->start()->log($eventLog);
try {
    TimeRecorder::pageTimer(fopen(TIMER_ROOT . '/links.xml', 'r'))->get()->log($eventLog);
} catch (Exception $ex) {
    print "\nException Occurred" . __FILE__ . " Line: " . __LINE__;
}
$timer->end()->log($eventLog);

print "\nSummary:";

TimeRecorder::total($eventLog);

print "\n";