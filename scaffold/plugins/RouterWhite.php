<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-1 上午1:14
 *
 * 登录状态外，允许的router白名单
 * Class RouterWhitePlugin
 */
class RouterWhitePlugin extends Yaf_Plugin_Abstract
{
    private $router_white = array(
        'Index_Login_index',
        'Index_Login_sign',
        'Index_Register_index',
    );

    private function check_router($request)
    {
        $router = $request->module . '_' . $request->controller . '_' . $request->action;
        return in_array($router, $this->router_white);
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $if_in_router_white = $this->check_router($request);
        if ($if_in_router_white) {
            contast_router::getInstance()->setIFrouterWhite(TRUE);
        }

        if (!Yaf_Session::getInstance()->get('userinfo') && !$if_in_router_white) {
            $request->setModuleName('Index');
            $request->setControllerName('Login');
            $request->setActionName('index');
        }
    }
}
