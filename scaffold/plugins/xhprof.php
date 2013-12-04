<?php

class xhprofPlugin extends Yaf_Plugin_Abstract
{

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        xhprof_enable();
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        // stop profiler
        $xhprof_data = xhprof_disable();

        $XHPROF_ROOT = realpath(dirname(__FILE__) . '/../../');
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

        // save raw data for this profiler run using default
        // implementation of iXHProfRuns.
        $xhprof_runs = new XHProfRuns_Default();

        // save the run under a namespace "xhprof_foo"
        $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

        echo "<p><a href='http://x/index.php?run=$run_id&source=xhprof_foo' target='_blank'>Xhprof</a></p>";
    }
}