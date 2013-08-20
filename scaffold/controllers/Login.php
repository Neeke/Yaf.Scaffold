<?php
/**
 * 首页
 */
class LoginController extends Controller {

	public function indexAction() {

        /**
         * 如果目前正在登录状态
         */
        if ($this->user_id) {
            $this->redirect(helper_common::site_url('scaffold/main'));
        }

        $this->setMenu('login');
	}

    public function signAction()
    {
        if ($this->_request->isPost()){
            $params = $this->allParams();
            $reult = models_user::getInstance()->login($params['username'],$params['password']);
            if ($reult){
                $this->redirect(helper_common::site_url('scaffold/main'));
            }
        }

    }

    /**
     * 登出
     */
    public function outAction(){
        $this->rest->method('GET');
        $this->session->del('userinfo');
        setcookie('userinfo', '', time()-1, '/');
        $this->redirect(helper_common::site_url('login'));
    }
}
