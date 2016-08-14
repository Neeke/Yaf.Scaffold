<?php
    error_reporting(1);
    define("APPLICATION_PATH", dirname(__FILE__) . "/scaffold");
    define("VIEW_PATH", dirname(__FILE__) . "/scaffold/views");
    define("STATIC_PATH", dirname(__FILE__) . "/static");

    $application = new Yaf_Application("conf/scaffold.ini");

    $response = $application
        ->bootstrap()
        ->run();
?>
