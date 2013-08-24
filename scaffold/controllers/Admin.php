<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-22 下午4:57
 */
class AdminController extends Scaffold
{

    public function init()
    {
        $this->table_name = 'yaf_admin';
        $this->primary    = 'user_id';
        $this->Scaffold   = TRUE;
        parent::init();
    }
}