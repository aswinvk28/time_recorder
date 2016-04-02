# Time Recorder

Define Named Timers as well as HTTP Page Execution Times    

    Initiate Time recorder
    -----------------------
    require_once 'time_recorder.php';

    Named Timer
    -------------
    $timer = \TimeRecorder::timer("NAMED TIMER")->start();
    /**
    * Block of Code
    **/
    $timer->end();
    
    Page Execution Times
    ----------------------
    $pTimer = \TimeRecorder::timer("PAGE TIMER")->start();
    $execTimes = \TimeRecorder::pageTimer(fopen(TIMER_ROOT . '/links.xml'))->get();
    print_r($execTimes->total());
    $pTimer->end();

    \TimeRecorder::total(new EventLog); // EventLog is a defined class having a write method

    Compatibility
    --------------
    This class can be included within any framework and is compatible with PHP version 5.*
    The XML format for the page links are to be specified as defined in links.xml file and there are no dependencies for this plugin.

*By,*     
*Aswin Vijayakumar*
    