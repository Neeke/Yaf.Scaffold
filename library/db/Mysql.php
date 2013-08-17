<?php
/**
 * mysql操作类
 *
 * @author ciogao@gmail.com
 *
 */
//class db_Mysql implements db_DbInterface {
class db_Mysql
{

    public static $_instances;
    private $_debug = FALSE;
    private $_update_cache = FALSE;
    private $_dbh;
    private $_sth;
    private $_sql;
    private $_cache;
    private $_cache_on = FALSE;
    private $_cache_off = FALSE;
    private $_cache_time = 60;
    private $_cache_if_have = FALSE;
    private $_cache_key = FALSE;

    private function __construct($dbhost, $dbport, $username, $password, $dbname, $dbcharset, $cachesys, $cachetype, $cachehost, $cacheport)
    {

        try {
            if ($cachesys == 'sae') {
                $dbhost_port = $dbhost . ':' . $dbport;
            } else {
                $dbhost_port = $dbhost;
            }
            $this->_dbh = new PDO('mysql:dbname=' . $dbname . ';host=' . $dbhost_port, $username, $password, array(PDO::ATTR_PERSISTENT => TRUE));
            $this->_dbh->query('SET NAMES ' . $dbcharset);
        } catch (PDOException $e) {
            echo '<pre><b>Connection failed:</b> ' . $e->getMessage();
            die();
        }

        $this->_cache = db_Cache::instance($cachehost, $cacheport, $cachetype, $cachesys);
        if (!$this->_cache) {

        }
    }

    /**
     * 单例连接数据库
     * @param \OB|string $db_config
     * @param \OB|string $cache_config
     * @return db_Mysql
     */
    static public function getInstance($db_config = '', $cache_config = '')
    {

        $_db_host    = $db_config->host;
        $_db_port    = $db_config->port;
        $_db_name    = $db_config->dbname;
        $_db_charset = $db_config->charset;
        $_db_usr     = $db_config->usr;
        $_db_pwd     = $db_config->pwd;

        $_cache_system = $cache_config->system;
        $_cache_type   = $cache_config->type;
        $_cache_host   = $cache_config->host;
        $_cache_port   = $cache_config->port;

        $idx = md5($_db_host . $_db_name . $_cache_host . $_cache_port);

        if (!isset(self::$_instances[$idx])) {
            self::$_instances[$idx] = new self($_db_host, $_db_port, $_db_usr, $_db_pwd, $_db_name, $_db_charset, $_cache_system, $_cache_type, $_cache_host, $_cache_port);
        }
        return self::$_instances[$idx];
    }

    /**
     * 返回错误
     * @param string $msg
     * @param string $sql
     */
    function halt($msg = '', $sql = '')
    {
        $error_info = $this->_sth->errorInfo();
        $s          = '<html>
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
							<h1>' . $error_info[2] . '</h1>
							' . $error_info[1] . '<br>
							' . $this->_sql . '
						</div>
					</body>
				</html>';
        exit($s);
    }

    /**
     * 起用debug
     */
    function debug()
    {
        $this->_debug        = TRUE;
        $this->_cache->debug = TRUE;
    }

    /**
     * 起用强制更新cache
     */
    function update_cache($key = FALSE)
    {
        $this->_update_cache = TRUE;
        if ($key) $this->cache_key($key);
    }

    /**
     * 是否使用缓存
     * @access 只对selete操作有效 对insert\delete\update无效
     */
    function cache_on($time = '')
    {
        $this->_cache_on   = TRUE;
        $this->_cache_time = !empty($time) ? (int)$time : $this->_cache_time;
    }

    function cache_off()
    {
        $this->_cache_on      = FALSE;
        $this->_cache_if_have = FALSE;
//     	$this->_cache->close();
    }

    /**
     * set the cache_key
     * @param $key
     */
    function cache_key($key)
    {
        $this->_cache_key = $key;
    }

    /**
     * 生成cache key
     * @param string $a
     * @param array|string $b
     * @return string
     */
    function cache_made_key($a, $b)
    {
        return md5(json_encode(array($a, $b)));
    }

    /**
     * @todo join库
     * @param $sql
     * @param array $values
     */
    function joinQuery($sql, $values = array())
    {

    }

    /**
     * 执行语句  先查询memcache，memcache中未过期，取cache || 取值写cache
     * @see db_DbInterface::query()
     */
    function query($sql, $values = array(), $type = '')
    {
        if ($this->_cache_on && $this->_update_cache == FALSE) {
            if (!$this->_cache_key) {
                $this->_cache_key = $this->cache_made_key($sql, $values) . $type;
            }

            $if_have_cache = $this->_cache->get($this->_cache_key);

            if ($if_have_cache) {
                $this->_cache_if_have = TRUE;
                return $if_have_cache;
            } else {
                $this->_cache_if_have = FALSE;
            }
        }

        if ($this->_update_cache && $this->_cache_key) {
            $this->_cache->set($this->_cache_key, 0, -1);
        }

        $this->_sql = $sql;
        $this->_sth = $this->_dbh->prepare($sql);
        $bool       = $this->_sth->execute($values);
        if ('00000' !== $this->_sth->errorCode()) {
            $this->halt();
        }

        if ($this->_debug == TRUE) {
            echo '<pre>sql: ';
            print_r($sql);
            echo '<br /><br />$values: ';
            var_dump($values);
            echo '<br /><br />$this->_cache_time: ';
            print_r($this->_cache_time);
            echo '<br /><br />$this->_cache_key: ';
            print_r($this->_cache_key);
            echo '<br />';
        }

        return $bool;
    }

    /**
     * 执行查询
     * @see db_DbInterface::getAll()
     */
    function getAll($sql, $values = array(), $fetch_style = PDO::FETCH_ASSOC)
    {
        $cache = $this->query($sql, $values, '_all');
        if ($this->_cache_if_have) {
            $this->_cache_key = FALSE;
            return $cache;
        }

        $result = $this->_sth->fetchAll($fetch_style);

        if ($this->_cache_on || $this->_update_cache) {
            if (!$this->_cache_key) {
                $this->_cache_key = $this->cache_made_key($sql, $values) . '_all';
            }

            $this->_cache->set($this->_cache_key, $result, $this->_cache_time);
        }

        $this->_cache_key = FALSE;
        return $result;
    }

    function getCol($sql, $values = array(), $column_number = 0)
    {
        $columns = array();
        $results = array();
        $this->query($sql, $values);
        $results = $this->_sth->fetchAll(PDO::FETCH_NUM);
        foreach ($results as $result) {
            $columns[] = $result[$column_number];
        }
        return $columns;
    }

    /**
     * 询取得多行的第一行
     * @see db_DbInterface::getRow()
     */
    function getRow($sql, $values = array(), $fetch_style = PDO::FETCH_ASSOC)
    {
        $cache = $this->query($sql, $values, '_row');
        if ($this->_cache_if_have) {
            $this->_cache_key = FALSE;
            return $cache;
        }

        $result = $this->_sth->fetch($fetch_style);

        if ($this->_cache_on || $this->_update_cache) {
            if (!$this->_cache_key) {
                $this->_cache_key = $this->cache_made_key($sql, $values) . '_row';
            }

            $a = $this->_cache->set($this->_cache_key, $result, $this->_cache_time);
        }

        $this->_cache_key = FALSE;
        return $result;
    }

    /**
     * 只查看一行
     * @see db_DbInterface::getOne()
     */
    function getOne($sql, $values = array(), $column_number = 0)
    {
        $this->query($sql, $values);
        return $this->_sth->fetchColumn($column_number);
    }

    /**
     * 转义插入
     * @param string $table
     * @param array $data
     * @param bool $returnStr
     * @return boolean
     */
    function insert($table = NULL, $data = NULL, $returnStr = FALSE)
    {

        $fields = array_keys($data);
        $marks  = array_fill(0, count($fields), '?');

        $sql = "INSERT INTO $table (`" . implode('`,`', $fields) . "`) VALUES (" . implode(", ", $marks) . " )";
        if ($returnStr) {
            $fields = array_keys($data);
            $marks  = array_values($data);

            foreach ($marks as $k => $v) {
                if (!is_numeric($v))
                    $marks[$k] = '\'' . $v . '\'';
            }
            $sql = "INSERT INTO $table (`" . implode('`,`', $fields) . "`) VALUES (" . implode(", ", $marks) . " )";
            return $sql;
        }
        $this->query($sql, array_values($data));
        $last_insert_id = $this->_dbh->lastInsertId();
        if ($last_insert_id) {
            return $last_insert_id;
        } else {
            return TRUE;
        }
    }

    /**
     * 处理事务
     */
    function transaction($sql)
    {
        try {
            $this->_dbh->beginTransaction();
            $this->_dbh->exec($sql);
            $this->_dbh->commit();
        } catch (PDOException $ex) {
            $this->_dbh->rollBack();
        }
    }

    /**
     * 更新
     * @param string $table
     * @param array $data
     * @param array $where
     * @return boolean
     */
    function update($table, $data, $where)
    {
        $values = $bits = $wheres = array();
        foreach ($data as $k => $v) {
            $bits[]   = "`$k` = ?";
            $values[] = $v;
        }

        foreach ($where as $c => $v) {
            $wheres[] = "$c = ?";
            $values[] = $v;
        }

        $sql = "UPDATE $table SET " . implode(', ', $bits) . ' WHERE ' . implode(' AND ', $wheres);
        return $this->query($sql, $values);
    }

    /**
     * 删除
     * @param string $table
     * @param array $where
     * @return boolean
     */
    function delete($table, $where)
    {
        $values = $wheres = array();
        foreach ($where as $key => $val) {
            $wheres[] = "$key = ?";
            $values[] = $val;
        }

        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $wheres);
        return $this->query($sql, $values);
    }

    /**
     * 关闭链接，释放资源
     */
    function close()
    {
        unset($this->_dbh);
        $this->_cache->close();
    }

}
