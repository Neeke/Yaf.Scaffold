<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-22 下午4:57
 */
class ConfigController extends Scaffold
{

    public function init()
    {
        $this->table_name = 'yaf_scaffold_config';
        $this->primary    = 'cid';
        $this->columns    = array('model_name','remark','table_primary','table_name','columns');
        $this->Scaffold   = TRUE;
        parent::init();
    }
}