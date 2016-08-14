<?php

    /**
     * 基础模型
     * Class Models
     */
    class Models
    {

        public $_table;
        public $_primary;

        function __construct()
        {
            $this->db = db_contect::db();
        }

        function getDB()
        {
            return $this->db;
        }

        /**
         * 格式化数据
         * @param $data
         * @return array
         */
        public function mkdata($data)
        {
            return array();
        }

        /**
         * 依条件检测某条数据是否存在
         * @param string|array $where
         *
         * @return array|bool
         */
        public function exits($where)
        {
            $this->db->cache_off();
            $_where = self::where($where);
            $back = $this->db->getRow('select ' . $this->_primary . ' from ' . $this->_table . $_where['where_key'], $_where['where_value']);
            if (is_array($back) && count($back) > 0) {
                return $back;
            }

            return FALSE;
        }

        /**
         * 获得符合条件的数据数量
         * @param $where
         * @return array
         */
        public function count($where = array())
        {
            $this->db->cache_on(10);
            $_where = self::where($where);
            $back = $this->db->getRow('select count(1) as count from ' . $this->_table . $_where['where_key'], $_where['where_value']);
            $this->db->cache_off();
            if (is_array($back) && count($back) > 0) {
                return $back['count'];
            }
        }

        /**
         * 依条件获取所有数据
         * @param              $colume
         * @param string|array $where
         * @param string $orderby
         * @param              $start
         * @param              $limit
         *
         * @return array|bool
         */
        public function getAll($colume, $where, $orderby = 'primary', $start = 0, $limit = 10)
        {
            $this->db->cache_on();
            $_where = self::where($where);
            $_orderby = self::orderby($orderby);
            $_colume = self::colume($colume);
            $back = $this->db->getAll('select ' . $_colume . ' from ' . $this->_table . $_where['where_key'] . $_orderby . " limit {$start},{$limit}", $_where['where_value']);
            $this->db->cache_off();
            if (is_array($back) && count($back) > 0) {
                return $back;
            }

            return FALSE;
        }

        /**
         * @param        $colume
         * @param        $where
         * @param string $orderby
         *
         * @return array|bool
         */
        public function getRow($colume, $where, $orderby = 'primary')
        {
            $this->db->cache_on();
            $_where = self::where($where);
            $_orderby = self::orderby($orderby);
            $_colume = self::colume($colume);
            $back = $this->db->getRow('select ' . $_colume . ' from ' . $this->_table . $_where['where_key'] . $_orderby . " limit 1", $_where['where_value']);
            $this->db->cache_off();
            if (is_array($back) && count($back) > 0) {
                return $back;
            }

            return FALSE;
        }

        /**
         * 插入数据
         * @param array $data
         *
         * @return boolean
         */
        public function insert($data)
        {
            return $this->db->insert($this->_table, $data);
        }

        /**
         * 更新数据
         * @param array $data
         * @param array $where
         *
         * @return boolean
         */
        public function update($data, $where)
        {
            return $this->db->update($this->_table, $data, $where);
        }

        /**
         * 删除数据
         * @param array $where
         *
         * @return boolean
         */
        public function delete($where)
        {
            return $this->db->delete($this->_table, $where);
        }

        /**
         * 查询字段
         *
         * @param $colume
         * @return string
         */
        protected function colume($colume)
        {
            if (is_array($colume) && count($colume) > 0) return implode(',', $colume);

            return $colume;
        }

        /**
         * 生成条件语句
         * 如果where是单一string ,判断成主鍵条件
         *
         * @param string|array $where
         *
         * @return array
         */
        protected function where($where)
        {
            $_where_key = ' where 1 = 1 ';
            $_where_value = array();
            if (!is_array($where)) {
                $_where_key .= 'and ' . $this->_primary . ' = ?';
                $_where_value[] = $where;
            } else {
                foreach ($where as $k => $v) {
                    if (is_array($v) && count($v) > 1) {
                        $_where_key .= "and " . $k . " in (?)";
                        $_where_value[] = implode(',', $v);
                    } else {
                        $_where_key .= 'and ' . $k . ' = ? ';
                        if (is_array($v)) {
                            $_where_value[] = $v[0];
                        } else {
                            $_where_value[] = is_numeric($v) ? intval($v) : $v;
                        }
                    }
                }
            }

            return array('where_key' => $_where_key, 'where_value' => $_where_value);
        }

        /**
         * 生成order by 语句
         * 如果orderby是单一string ,判断成主鍵desc
         *
         * @param $orderby
         *
         * @internal param array|string $where
         * @return array
         */
        protected function orderby($orderby = 'primary')
        {
            $_order_by = ' order by ';
            if (!is_array($orderby)) {
                $_order_by .= $this->_primary . ' desc';
            } else {
                foreach ($orderby as $k => $v) {
                    $_order_by .= "{$k} {$v},";
                }
                $_order_by = substr($_order_by, 0, -1);
            }

            return $_order_by;
        }
    }