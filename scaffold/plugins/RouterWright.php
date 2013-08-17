<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-1 上午1:14
 *
 * 登录状态外，允许的router白名单
 * Class RouterWrightPlugin
 */
class RouterWrightPlugin extends Yaf_Plugin_Abstract
{
    private $router_wright = array(
        'Index_Login_index',
        'Index_Register_index',
        'Api_User_login',
        'Api_User_reg'
    );

    private function check_router($request)
    {
        $router = $request->module . '_' . $request->controller . '_' . $request->action;
        return in_array($router, $this->router_wright);
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $if_in_router_wright = $this->check_router($request);
        if ($if_in_router_wright) {
            contast_router::getInstance()->setIFrouterWright(TRUE);
        }

        if (!Yaf_Session::getInstance()->get('userinfo') && !$if_in_router_wright) {
            $request->setModuleName('Index');
            $request->setControllerName('Login');
            $request->setActionName('index');
        }
    }
}
