# Time Recorder

Time Recorder is a PHP Component that can be included within a library or your framework. It records the execution times for a block of code, intended for observing the performance of a block of code.

The execution times are recorded by a developer using Named Timers so that the named timer reveals the time in (microseconds). The execution times for a set of HTTP Idenitfiers can also be calculated in (milliseconds). The definitions for the HTTP identifiers are written using REST URIs in a structured XML format which are available at [https://github.com/aswinvk28/time_recorder/blob/master/links.xml][1]

#Implementation
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
    
  [1]: https://github.com/aswinvk28/time_recorder/blob/master/links.xml
