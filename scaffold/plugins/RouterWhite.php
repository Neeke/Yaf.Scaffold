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

    /**
     * 白名单列表
     *
     * @var unknown
     */
    private $router_White = array(
        'Index_Login_index',
        'Index_Login_sign',
        'Index_Register_index'
    );

    /**
     * 检查当前的请求是否在白名单
     *
     * @param array $request
     * @return boolean
     */
    private function check_router($request)
    {
        $router = $request->module . '_' . $request->controller . '_' . $request->action;
        return in_array($router, $this->router_White);
    }

    /**
     * 检查当前请求，如果在白名单内，则设置确认白名单
     * 如果不在，并没有登陆，则跳转带登陆
     */
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $if_in_router_White = $this->check_router($request);
        if ($if_in_router_White) {
            contast_router::getInstance()->setIfRouterWhite(TRUE);
        } elseif (! Yaf_Session::getInstance()->get('userinfo')) {
            $request->setModuleName('Index');
            $request->setControllerName('Login');
            $request->setActionName('index');
        }
    }
}
