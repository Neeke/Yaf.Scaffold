<?php
/**
 * 连接数据库
 * @author ciogao@gmail.com
 *
 */
class db_contect{
    /**
     * @param string $which
     * @return db_Mysql
     */
    static public function db($which = 'master'){
		$db_config = Yaf_Registry::get('config')->get('yaf')->get('db')->$which;
		$cache_config = Yaf_Registry::get('config')->get('yaf')->get('cache');

		$db = db_Mysql::getInstance($db_config, $cache_config);
        return $db;
//		return ($db instanceof db_DbInterface) ? $db : false;

		}

}
