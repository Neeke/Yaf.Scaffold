<?php

/**
 * 当有未捕获的异常, 则控制流会流到这里
 */
class ErrorController extends Yaf_Controller_Abstract
{
    public $actions = array(
        "action" => "actions/index.php"
    );

    public function init()
    {
//        Yaf_Dispatcher::getInstance()->disableView();
    }

    public function errorAction($exception)
    {
        /* error occurs */
//        switch ($exception->getCode()) {
//            case YAF_ERR_NOTFOUND_MODULE:
//            case YAF_ERR_NOTFOUND_CONTROLLER:
//            case YAF_ERR_NOTFOUND_ACTION:
//            case YAF_ERR_NOTFOUND_VIEW:
//                self::halt('404', $exception->getMessage());
//                break;
//            default :
//                self::halt('0', $exception->getMessage());
//                break;
//        }

        switch ($exception->getCode()) {
            case YAF_ERR_NOTFOUND_MODULE:
            case YAF_ERR_NOTFOUND_CONTROLLER:
            case YAF_ERR_NOTFOUND_ACTION:
            case YAF_ERR_NOTFOUND_VIEW:
                $this->getView()->assign('code',$exception->getCode());
                $this->getView()->assign('msg', $exception->getMessage());
                break;
            default :
                $this->getView()->assign('code',$exception->getCode());
                $this->getView()->assign('msg', $exception->getMessage());
                break;
        }
    }

    /**
     * 返回错误
     * @param int|string $stats
     * @param string $msg
     */
    function halt($stats = 200, $msg = '')
    {
        $s = '<html>
					<head>
					<title>ERROR</title>
					<style type="text/css">
					body {background-color:	#fff;margin:40px;font-family:	Lucida Grande, Verdana, Sans-serif;font-size:12px;color:#000;}
					#content  {border:	#999 1px solid;background-color:	#fff;padding:	20px 20px 12px 20px;}
					h1 {font-weight:normal;font-size:14px;color:#990000;margin:0 0 4px 0;}
					</style>
					</head>
					<body>
						<div id="content">
							<h1>' . $stats . '</h1>
							' . $msg . '
						</div>
					</body>
				</html>';
        exit($s);
    }
}
