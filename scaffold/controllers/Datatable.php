<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-21 上午12:49
 */
class DatatableController extends Controller {

    public function init()
    {
        parent::init();
    }

    /**
     * 数据库字典
     */
    public function dicAction()
    {
        $dataDics = models_datadic::getInstance()->getDataDics();
        $this->set('dataDics',$dataDics);
    }
}