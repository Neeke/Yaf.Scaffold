<?php

    /**
     * set \ get 是否在白名单路由
     * 该hook于Bootstrap中init
     * @see RouterWhitePlugin
     * @author ciogao@gmail.com
     * Date: 13-8-1 上午1:14
     */
    class contast_router
    {
        private static $_instance = NULL;

        /**
         * @return contast_router
         */
        final public static function getInstance()
        {
            if (!isset(self::$_instance) || !self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        private $if_router_white = FALSE;

        /**
         * 当前router是否在白名单外
         * @return bool
         */
        public function getIfrouterWhite()
        {
            return $this->if_router_white;
        }

        /**
         * 设置touter是否在白名单外
         * @param bool $bool
         */
        public function setIFrouterWhite($bool = TRUE)
        {
            $this->if_router_white = $bool;
        }
    }