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
     *
     * @var Models
     */
    public $model;

    /**
     *
     * @var db_Mysql
     */
    public $db;

    public $meta;

    protected $appconfig = array();

    protected $userinfo = array();

    protected $user_id = 0;

    /**
     *
     * @var rest_Server
     */
    protected $rest;

    /**
     *
     * @var rest_Check
     */
    protected $check;

    /**
     *
     * @var rest_Quantity
     */
    protected $quantity;

    /**
     *
     * @var rest_Modified
     */
    protected $modified;

    /**
     *
     * @var Yaf_Session
     */
    protected $session;

    /**
     *
     * @var rest_Mkdata
     */
    protected $mkData;

    /**
     *
     * @var
     *
     */
    protected $allParams = array();

    protected $start = 0;

    protected $limit = 0;

    protected $scaffoldC = FALSE;

    function init()
    {
        $this->userinfo = models_user::getInstance()->getUserInfo();
        $this->user_id = (is_array($this->userinfo) && array_key_exists('user_id', $this->userinfo)) ? $this->userinfo['user_id'] : 0;

        self::check_login();

        $this->db = db_contect::db();
        $this->check = rest_Check::instance();
        $this->quantity = rest_Quantity::instance();
        $this->rest = rest_Server::instance();
        $this->modified = rest_Modified::instance();
        $this->session = Yaf_Session::getInstance();
        $this->mkData = rest_Mkdata::instance();

        $this->setScaffoldConfig();
        $this->ScaffoldRoute();

        $this->setConfig();
    }

    /**
     * Scaffold action识配
     */
    protected function ScaffoldRoute()
    {
        if (! $this->Scaffold)
            return;
        $this->set('controller', $this->getRequest()
            ->getControllerName());

        $this->allParams();

        Yaf_Dispatcher::getInstance()->disableView();
        $action = $this->getRequest()->getActionName();
        if ($action == 'c') {
            $this->scaffoldC = TRUE;
            $action = $this->getRequest()->getParam('action');
        }

        switch ($action) {
            case 'scaffoldajax':
                $this->ScaffoldAjax();
                break;
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

        if (! is_array($this->columns) || count($this->columns) < 1) {
            $columnsShow = $columns;
        } else {
            $columnsShow[$this->primary] = $columns[$this->primary];
            foreach ($this->columns as $value) {
                if (array_key_exists($value, $columns)) {
                    $columnsShow[$value] = $columns[$value];
                }
            }
        }

        $this->set('tableName', $this->table_name);

        $this->set('columns', $columnsShow);

        foreach ($columnsShow as $key => $val) {
            $column = array(
                'title' => $key,
                'comment' => $val['COLUMN_COMMENT'],
                'type' => $val['COLUMN_TYPE'],
                'sortable' => true,
                'field' => $key,
                'filter' => $key == $this->primary ? true : false
            );
            $scaffold['scaffold']['columns'][$key] = $column;
        }

        $scaffold['scaffold']['primary'] = $this->primary;

        if ($this->scaffoldC) {
            $model_name = $this->getRequest()->getParam('model');
            $scaffold['scaffold']['api'] = array(
                'scaffoldajax' => helper_common::site_url('Scaffold/c/model/' . $model_name . '/action/scaffoldajax'),
                'getrow' => helper_common::site_url('Scaffold/c/model/' . $model_name . '/action/getrow'),
                'modify' => helper_common::site_url('Scaffold/c/model/' . $model_name . '/action/modify'),
                'remove' => helper_common::site_url('Scaffold/c/model/' . $model_name . '/action/remove')
            );
        } else {
            $model_name = $this->getRequest()->getControllerName();
            $scaffold['scaffold']['api'] = array(
                'scaffoldajax' => helper_common::site_url($model_name . '/scaffoldajax'),
                'getrow' => helper_common::site_url($model_name . '/getrow'),
                'modify' => helper_common::site_url($model_name . '/modify'),
                'remove' => helper_common::site_url($model_name . '/remove')
            );
        }

        $this->setConfig($scaffold);
        $config = $this->get('config');
        $this->getView()->display(VIEW_PATH . '/scaffoldView/scaffold.phtml', $config);
    }

    /**
     * Scaffold ajaxData
     */
    protected function ScaffoldAjax()
    {
        $columns = models_datadic::getInstance()->getColumnsByTable($this->table_name);

        if (! is_array($this->columns) || count($this->columns) < 1) {
            $columnsShow = $columns;
        } else {
            $columnsShow[$this->primary] = $columns[$this->primary];
            foreach ($this->columns as $value) {
                if (array_key_exists($value, $columns)) {
                    $columnsShow[$value] = $columns[$value];
                }
            }
        }

        $scaffoldModel = models_scaffold::getInstance($this->table_name, $this->primary);

        $total_rows = $scaffoldModel->count();
        $per_page = $this->allParams['perPage'] ?  : contast_scaffold::PAGE_PER_DEFAULT;
        $current_page = $this->allParams['currentPage'] ?  : contast_scaffold::PAGE_CURRENT_DEFAULT;

        $sort = $this->allParams["sort"] ?  : array(
            array(
                $this->primary,
                "desc"
            )
        );
        $filter = $this->allParams["filter"] ?  : array(
            ''
        );

        $result = array(
            "totalRows" => $total_rows,
            "perPage" => $per_page,
            "sort" => $sort,
            "filter" => $filter,
            "currentPage" => $current_page,
            "data" => array(),
            "posted" => $this->allParams
        );

        $start = ($current_page - 1) * $per_page;
        $limit = $per_page;

        $select = implode(',', array_keys($columnsShow));
        foreach ($sort as $val) {
            $order[$val[0]] = $val[1];
        }
        $data = $scaffoldModel->getAll($select, $filter, $order, $start, $limit);

        foreach ($data as $value) {
            foreach ($columnsShow as $key => $v) {
                $data_[$key] = $value[$key];
            }

            $result["data"][] = $data_;
        }

        $this->rest->success($result);
    }

    /**
     * Scaffold 取得单条信息
     */
    protected function ScaffoldGetrow()
    {
        $this->rest->method('GET');
        $parms = $this->allParams();

        $this->rest->paramsMustMap = array(
            'primary'
        );
        $this->rest->paramsMustValid($parms);

        $result = $this->db->getRow("select * from {$this->table_name} where {$this->primary} = ?", array(
            $parms['primary']
        ));
        if ($result)
            $this->rest->success($result);
        $this->rest->error();
    }

    /**
     * Scaffold insert||modify
     */
    protected function ScaffoldModify()
    {
        $this->rest->method('POST');
        $parms = $this->allParams();

        $this->rest->paramsMustMap = $this->columns;
        $this->rest->paramsMustValid($parms);

        $primary_value = $parms[$this->primary];
        unset($parms[$this->primary], $parms['model'], $parms['action']);

        if ((int) $primary_value > 0) {
            $where = array(
                $this->primary => $primary_value
            );

            $result = $this->db->update($this->table_name, $parms, $where);
        } else {
            $result = $this->db->insert($this->table_name, $parms);
        }

        if ($result)
            $this->rest->success($result);
        $this->rest->error();
    }

    /**
     * Scaffold delete
     */
    protected function ScaffoldRemove()
    {
        $this->rest->method('POST');
        $parms = $this->getRequest()->getPost();

        $this->rest->paramsMustMap = array(
            'primary'
        );
        $this->rest->paramsMustValid($parms);

        $result = $this->db->delete($this->table_name, array(
            $this->primary => $parms['primary']
        ));
        if ($result)
            $this->rest->success();
        $this->rest->error();
    }

    /**
     * 获取并设置所有scaffold config
     * leftMenu
     */
    protected function setScaffoldConfig()
    {
        $this->set('scaffold_configs', models_scaffoldConfig::getInstance()->getAllConfig());
    }

    /**
     * 取得所有参数
     *
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

        $this->start = array_key_exists('start', $this->allParams) ? (int) $this->allParams['start'] : 0;
        $this->limit = array_key_exists('limit', $this->allParams) ? (int) $this->allParams['limit'] : 10;
    }

    /**
     * 检测状态
     */
    private function check_login()
    {
        $this->set('userinfo', $this->userinfo);
        $this->set('user_id', $this->user_id);

        if ($this->userinfo == FALSE && ! contast_router::getInstance()->getIfRouterWhite()) {
            $this->redirect(helper_common::site_url('login'));
        }
    }

    /**
     * 设置menu的active状态
     *
     * @param string $action
     */
    protected function setMenu($action = '/')
    {
        $this->set('this_menu', $action);
    }

    /**
     * 设置变量到模板
     *
     * @param
     *            $key
     * @param string $val
     */
    protected function set($key, $val = '')
    {
        $this->getView()->assign($key, $val);
    }

    /**
     * 获取模板变量
     *
     * @param
     *            $key
     * @return mixed
     */
    protected function get($key)
    {
        return $this->getView()->get($key);
    }

    /**
     * 设置页面config值
     *
     * @param
     *            $config
     */
    protected function setConfig($config = array())
    {
        $config_ = array_merge($config, $this->userinfo);
        $config_get = $this->get('config');
        if ($config_get) {
            $config_set = array_merge($config_get, $config_);
        } else {
            $config_set = $config_;
        }

        $this->set('config', $config_set);
    }

    function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}