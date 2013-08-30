<?php
/**
 * 脚手架 config
 * @author ciogao@gmail.com
 */
class models_scaffoldConfig extends Models
{
    private static $_instance = NULL;

    /**
     * @return models_scaffoldConfig
     */
    final public static function getInstance()
    {
        if (!isset(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    function __construct()
    {
        parent::__construct();
        $this->_table   = 'yaf_scaffold_config';
        $this->_primary = 'cid';
    }

    /**
     * 根据模块名返回配置信息
     * @param string $model_name
     * @internal param int $user_id
     * @return array|bool
     */
    public function getConfigByModelName($model_name = '')
    {
        $this->db->cache_on(100);
        $this->db->cache_key('scaffold_config_' . md5($model_name));
        return $this->getRow('*', array('model_name' => $model_name));
    }

    /**
     * 获取所有配置信息
     * @return array|bool
     */
    public function getAllConfig()
    {
        $this->db->cache_on(1800);
        return $this->getAll('*',array());
    }
}