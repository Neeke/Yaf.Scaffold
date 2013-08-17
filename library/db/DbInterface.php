<?php
/*
 * Db接口定义
 *
 * @author ciogao@gmail.com
 *
 */

interface db_DbInterface {

    static public function getInstance(); //要求所有数据连接皆为单例
    
    function cache_on();
    function cache_off();

    function debug();   //开启debug
    function query($query); //执行sql语句
    
    /**
     * 处理事务
     * @param string $query
     */
    function transaction($query); //事务

    function getOne($query); //执行sql语句，只得到一条记录

    /**
     * @param string $query
     * @param array $values
     * @param $a
     * @return mixed
     */
    function getRow($query,$values,$a); //从结果集中取得一行作为关联数组

    function getCol($query); //从结果集中取得一列作为关联数组

    function getAll($query); //返回一个N行N列的结果集
    /**
     * 转义插入
     * @param string $table
     * @param array $data
     * @internal param array $where
     * @return boolean || int
     */
    function insert($table, $data); //返回上一次插入记录的ID;
    
    /**
     * 更新
     * @param string $table
     * @param array $data
     * @param array $where
     * @return boolean
     */
    function update($table, $data, $where); 

    /**
     * 删除
     * @param string $table
     * @param array $where
     * @return boolean
     */
    function delete($table,$where);
    
    function close(); //关闭数据库连接
}