<?php
/**
 * Scaffold Controller base
 * @author ciogao@gmail.com
 *
 */
class Scaffold extends Yaf_Controller_Abstract
{
    protected $table_name = '';
    protected $primary = '';
    protected $columns = array();
    protected $Scaffold = FALSE;

    /**
     * @var Models
     */
    public $model;
    /**
     * @var db_Mysql
     */
    public $db;
    public $meta;

    protected $appconfig = array();
    protected $userinfo = array();
    protected $user_id = 0;

    /**
     * @var rest_Server
     */
    protected $rest;

    /**
     * @var rest_Check
     */
    protected $check;

    /**
     * @var rest_Quantity
     */
    protected $quantity;

    /**
     * @var rest_Modified
     */
    protected $modified;

    /**
     * @var Yaf_Session
     */
    protected $session;

    /**
     * @var rest_Mkdata
     */
    protected $mkData;

    /**
     * @var
     */
    protected $allParams = array();

    protected $start = 0;
    protected $limit = 0;

    function init()
    {
        $this->userinfo = models_user::getInstance()->getUserInfo();
        $this->user_id  = (is_array($this->userinfo) && array_key_exists('user_id', $this->userinfo)) ? $this->userinfo['user_id'] : 0;

        self::check_login();

        $this->db       = db_contect::db();
        $this->check    = rest_Check::instance();
        $this->quantity = rest_Quantity::instance();
        $this->rest     = rest_Server::instance();
        $this->modified = rest_Modified::instance();
        $this->session  = Yaf_Session::getInstance();
        $this->mkData   = rest_Mkdata::instance();

        $this->setConfig();

        $this->ScaffoldRoute();
    }

    /**
     *Scaffold action识配
     */
    protected function ScaffoldRoute()
    {
        if (!$this->Scaffold) return;

        Yaf_Dispatcher::getInstance()->disableView();

        $action = $this->getRequest()->getActionName();
        switch ($action) {
            case 'scaffold':
                $this->ScaffoldIndex();
                break;
            case 'getrow':
                $this->ScaffoldGetrow();
                break;
            case 'modify':
                $this->ScaffoldModify();
                break;
            case 'remove':
                $this->ScaffoldRemove();
                break;
            default:
                $this->ScaffoldIndex();
        }
    }

    /**
     * Scaffold 默认list
     */
    protected function ScaffoldIndex()
    {
        $columns = models_datadic::getInstance()->getColumnsByTable($this->table_name);

        if (!is_array($this->columns) || count($this->columns) < 1){
            $columnsShow = $columns;
        }else{
            $columnsShow[$this->primary] = $columns[$this->primary];
            foreach ($this->columns as $value) {
                if (array_key_exists($value, $columns)) {
                    $columnsShow[$value] = $columns[$value];
                }
            }
        }
        $select = implode(',',array_keys($columnsShow));

        $data = $this->db->getAll("select {$select} from {$this->table_name}");

        $this->set('tableName', $this->table_name);
        $this->set('primary',$this->primary);
        $this->set('columns', $columnsShow);
        $this->set('data', $data);

        $this->getView()->display(VIEW_PATH . '/scaffoldView/scaffold.phtml');
    }

    /**
     * Scaffold 取得单条信息
     */
    protected function ScaffoldGetrow()
    {
        $this->rest->method('GET');
        $parms = $this->allParams();

        $this->rest->paramsMustMap = array('primary');
        $this->rest->paramsMustValid($parms);

        $result = $this->db->getRow("select * from {$this->table_name} where {$this->primary} = ?", array($parms['primary']));
        if ($result) $this->rest->success($result);
        $this->rest->error();
    }

    /**
     * Scaffold insert||modify
     */
    protected function ScaffoldModify()
    {
        $this->rest->method('POST');
        $parms = $this->allParams();

        $this->rest->paramsMustMap = array($this->primary);
        $this->rest->paramsMustValid($parms);

        $primary_value = $parms[$this->primary];
        unset($parms[$this->primary]);

        if ((int)$primary_value > 0) {
            $where = array(
                $this->primary => $primary_value,
            );

            $result = $this->db->update($this->table_name, $parms, $where);
        } else {
            $result = $this->db->insert($this->table_name, $parms);
        }

        if ($result) $this->rest->success($result);
        $this->rest->error();
    }

    /**
     * Scaffold delete
     */
    protected function ScaffoldRemove()
    {
        $this->rest->method('POST');
        $parms = $this->getRequest()->getPost();

        $this->rest->paramsMustMap = array('primary');
        $this->rest->paramsMustValid($parms);

        $result = $this->db->delete($this->table_name, array($this->primary => $parms['primary']));
        if ($result) $this->rest->success();
        $this->rest->error();
    }

    /**
     * 取得所有参数
     * @return mixed
     */
    protected function allParams()
    {
        $params = $this->getRequest()->getParams();
        $params += $_GET;
        $params += $_POST;
        $this->allParams = $params;
        return $params;
    }

    /**
     * 取得start limit值
     */
    protected function getStartLimit()
    {
        if (count($this->allParams) < 1) {
            $this->allParams();
        }

        $this->start = array_key_exists('start', $this->allParams) ? (int)$this->allParams['start'] : 0;
        $this->limit = array_key_exists('limit', $this->allParams) ? (int)$this->allParams['limit'] : 10;
    }

    /**
     * 检测状态
     */
    private function check_login()
    {
        $this->set('userinfo', $this->userinfo);
        $this->set('user_id', $this->user_id);

        if ($this->userinfo == FALSE && !contast_router::getInstance()->getIfrouterWright()) {
            $this->redirect(helper_common::site_url('login'));
        }
    }

    /**
     * 设置menu的active状态
     * @param string $action
     */
    protected function setMenu($action = '/')
    {
        $this->set('this_menu', $action);
    }

    /**
     * 设置变量到模板
     * @param $key
     * @param string $val
     */
    protected function set($key, $val = '')
    {
        $this->getView()->assign($key, $val);
    }

    /**
     * 设置页面config值
     * @param $config
     */
    protected function setConfig($config = array())
    {
        $config_ = array_merge($config, $this->userinfo);
        $this->set('config', $config_);
    }

    function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}