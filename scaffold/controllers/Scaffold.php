<?php

    /**
     * @author ciogao@gmail.com
     * Date: 13-8-20 下午11:26
     */
    class ScaffoldController extends Scaffold
    {

        public function init()
        {
            parent::init();
        }

        public function mainAction()
        {

        }

        /**
         * 来自scaffold_config配置的脚手架
         */
        public function cAction()
        {
            $model_name = $this->getRequest()->getParam('model');

            $config_info = models_scaffoldConfig::getInstance()->getConfigByModelName($model_name);

            if ($config_info == FALSE) {
                $errorMsg = '该脚手架不存在，请检查配置或数据是否正常.';
                $this->set('errorMSG', $errorMsg);
            } else {
                $this->table_name = $config_info['table_name'];
                $this->primary = $config_info['table_primary'];
                $this->columns = explode(',', $config_info['columns']);
                $this->Scaffold = TRUE;
                $this->ScaffoldRoute();
            }
        }
    }