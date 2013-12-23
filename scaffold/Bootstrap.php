<?php
/**
 * @author ciogao@gmail.com
 * Class Bootstrap
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{
	public function _initSession($dispatcher) {
		/*
		 * start a session 
		 */
		Yaf_Session::getInstance()->start();
	}

	public function _initConfig() {
		$config = Yaf_Application::app()->getConfig();
		Yaf_Registry::set("config", $config);
	}
	
	public function _initXhprof(Yaf_Dispatcher $dispatcher){
		$if_xhprof = Yaf_Registry::get("config")->get('xhprof')->get('open');
		$if_xhprof = isset($if_xhprof) && (int)$if_xhprof > 0 ? 'open' : 'close';

		if ($if_xhprof == 'open') {
			$xhprof = new xhprofPlugin();
			$dispatcher->registerPlugin($xhprof);
		}
	}

	public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
		/**
		 * actully this is unecessary, since all the parameters here is the default value of Yaf
		 */
		$dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
	}
	
	public function _initDb(){
          db_contect::db();
	}

    /**
     * 路由白名单hook
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initRouterWhite(Yaf_Dispatcher $dispatcher) {
        $dispatcher->registerPlugin(new RouterWhitePlugin());
    }
}
