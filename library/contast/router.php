<?php

/**
 * set \ get 是否在白名单路由
 * 该hook于Bootstrap中init
 * @see RouterwhitePlugin
 * @author ciogao@gmail.com
 * Date: 13-8-1 上午1:14
 */
class contast_router
{

    private static $_instance = NULL;

    /**
     *
     * @return contast_router
     */
    final public static function getInstance()
    {
        if (! isset(self::$_instance) || ! self::$_instance instanceof self) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private $if_router_white = FALSE;

    /**
     * 当前router是否在白名单外
     *
     * @return bool
     */
    public function getIfRouterWhite()
    {
        return $this->if_router_white;
    }

    /**
     * 设置router是否在白名单外
     *
     * @param bool $bool
     */
    public function setIfRouterWhite($bool = TRUE)
    {
        $this->if_router_white = $bool;
    }
}