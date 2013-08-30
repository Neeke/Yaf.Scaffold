<?php
/**
 * @author ciogao@gmail.com
 * Date: 13-8-30 下午8:06
 */
class IndexController extends Scaffold{

    public function indexAction(){
        /**
         * 如果目前正在登录状态
         */
        if ($this->user_id) {
            $this->redirect(helper_common::site_url('scaffold/main'));
        }
    }
}