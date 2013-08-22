<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-22 下午4:57
 */
class AdminController extends Scaffold {

    public function init()
    {
        parent::init();
    }

    public function scaffoldAction()
    {
        $table = 'yaf_admin';
        $columns = models_datadic::getInstance()->getColumnsByTable($table);

        $data = $this->db->getAll("select * from {$table}");

        $this->set('tableName',$table);
        $this->set('columns',$columns);
        $this->set('data',$data);
    }
}