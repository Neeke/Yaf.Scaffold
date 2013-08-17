<?php
/**
 * Controller base
 * @author ciogao@gmail.com
 *
 */
class Controller extends Yaf_Controller_Abstract
{
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
    protected $modules = array();

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
        $this->modules  = explode(',', Yaf_Registry::get("config")->get('yaf')->get('modules'));

        self::check_login();

        $this->db = db_contect::db();
//        $this->setmeta();
        $this->check    = rest_Check::instance();
        $this->quantity = rest_Quantity::instance();
        $this->rest     = rest_Server::instance();
        $this->modified = rest_Modified::instance();
        $this->session  = Yaf_Session::getInstance();
        $this->mkData   = rest_Mkdata::instance();

        $this->setConfig();
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

    /**
     * 取得meta值
     */
    private function getmeta()
    {
        $this->db->cache_on(5000);
        $query = 'select * from yaf_config';
        $a     = $this->db->getRow($query);
        $this->db->cache_off();
        $this->meta = $a;
    }

    /**
     * 设置meta值
     */
    private function setmeta()
    {
        self::getmeta();
        $this->set('title', $this->meta['title']);
        $this->set('proname', $this->meta['proname']);
        $this->set('webroot', $this->meta['webroot']);
    }

    function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}