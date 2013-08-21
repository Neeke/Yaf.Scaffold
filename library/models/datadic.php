<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-21 上午11:15
 */

class models_datadic extends Models
{
    private static $_instance = NULL;

    /**
     * @return models_datadic
     */
    final public static function getInstance()
    {
        if (!isset(self::$_instance) || !self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private $database;
    private $tableList = array();

    function __construct()
    {
        parent::__construct();
        $config = Yaf_Registry::get("config")->get('yaf')->get('db')->get('master');
        $this->database   = $config->get('dbname');
    }

    /**
     * 获取表名lists
     */
    private function getTablesLists()
    {
        $result = $this->db->getTablesLists();
        foreach($result as $info){
            $this->tableList[$info['TABLE_NAME']] = $info;
        }
    }

    /**
     * 获取某表结构
     * @param $table
     * @return array|bool|string
     */
    private function getColumnsByTable($table)
    {
        $result = array();

        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$table}' AND table_schema = '{$this->database}'";

        $this->db->cache_on(1800);
        $result_tem = $this->db->getAll($sql);
        foreach($result_tem as $info){
            $result[$info['COLUMN_NAME']] = $info;
        }
        unset($sql,$result_tem);

        return $result;
    }

    /**
     * 获取数据库字典
     */
    function getDataDics()
    {
        $this->getTablesLists();

        foreach($this->tableList as $table_name => $info){
            $this->tableList[$table_name]['columns'] = $this->getColumnsByTable($table_name);
        }

        return $this->tableList;
    }
}