<?php

    /**
     * 用户
     * @author ciogao@gmail.com
     *
     */
    class models_user extends Models
    {
        private static $_instance = NULL;

        /**
         * @return models_user
         */
        final public static function getInstance()
        {
            if (!isset(self::$_instance) || !self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        public function __construct()
        {
            parent::__construct();
            $this->_table = 'yaf_admin';
            $this->_primary = 'user_id';
        }

        /**
         * 检查该用户是否合法用户
         * @param string $username
         * @param string $pwd
         *
         * @return false || array
         */
        function is_user($username, $pwd)
        {
            $sql = 'select ' . $this->_primary . ' from ' . $this->_table . ' where user_name = ? and pwd = ?';
            $a = $this->db->getOne($sql, array($username, $pwd));

            return $a;
        }

        /**
         * 获取已经登录的用户信息
         */
        public function getUserInfo()
        {
            $s = Yaf_Session::getInstance();
            if ($s->has('userinfo')) {
                $userinfo = $s->get('userinfo');
                $array['user_id'] = $userinfo['user_id'];
                $array['user_name'] = $userinfo['user_name'];

                return $array;
            }

            return FALSE;
        }

        /**
         * 返回用户的完整信息
         * @param int $user_id
         * @return array|bool
         */
        public function getUserInfoAll($user_id = 0)
        {
            if ($user_id < 1) {
                $userinfo = $this->getUserInfo();
                $user_id = $userinfo['user_id'];
                if ($userinfo == FALSE) return FALSE;
            }

            $this->db->cache_on(1800);
            $this->db->cache_key('user_info_' . $user_id);

            return $this->getRow('*', $user_id);
        }

        /**
         * 登录
         * @param $user_name
         * @param $user_pwd
         *
         * @return boolean
         */
        public function login($user_name, $user_pwd)
        {
            $this->db->cache_off();
            $aResult = $this->db->getRow('select * from ' . $this->_table . ' where user_name = ? and user_pwd = ?', array($user_name, md5($user_pwd)));
            if ($aResult == FALSE) return FALSE;

            $session = Yaf_Session::getInstance();
            $session->userinfo = $aResult;

            return TRUE;
        }

        /**
         * 相册总数加１
         * @return bool
         */
        public function addalbum()
        {
            $userinfo = $this->getUserInfo();
            $this->db->query('update ' . $this->_table . ' set album_count = album_count + 1 where user_id = ?', array($userinfo['user_id']));

            return TRUE;
        }

        /**
         * 取得某用户头像
         * @param $user_id
         * @return array
         */
        public function getAvatarByUserId($user_id)
        {
            $this->db->cache_on(3600);

            return $this->getRow('face_url', (int)$user_id);
        }

        /**
         * 取得某用户姓名
         * @param $user_id
         * @return array
         */
        public function getUsernameByUserId($user_id)
        {
            $this->db->cache_on(3600);

            return $this->getRow('user_name', (int)$user_id);
        }

        /*
         * 收藏总数加１
         * @return bool
         */
        public function addcollect()
        {
            $userinfo = $this->getUserInfo();
            $this->db->update_cache('user_info_' . $userinfo['user_id']);
            $this->db->query('update ' . $this->_table . ' set collect_count = collect_count + 1 where user_id = ?', array($userinfo['user_id']));

            return TRUE;
        }

        /**
         * 更新用户email
         * @todo 邮箱变更流程 激活
         * @param $email
         * @return bool
         */
        public function updateEmail($email)
        {
            $userinfo = $this->getUserInfo();
            if (empty($email) || strlen($email) < 1) return FALSE;

            $this->db->update_cache('user_info_' . $userinfo['user_id']);

            return $this->update(array('user_email' => $email), array('user_id' => $userinfo['user_id']));
        }

        /**
         * 更新用户密码
         * @todo 不同error的返回
         * @param $pwd
         * @return bool
         */
        public function updatePwd($pwd)
        {
            if (empty($pwd) || ($pwd['new'] != $pwd['repeat'])) return FALSE;

            $userinfo = $this->getUserInfoAll();
            if (md5($pwd['old']) != $userinfo['user_pwd']) return FALSE;

            $this->db->update_cache('user_info_' . $userinfo['user_id']);

            return $this->update(array('user_pwd' => md5($pwd['new'])), array('user_id' => $userinfo['user_id']));
        }

        /**
         * 更新用户头像
         * @param $avatar
         * @return bool
         */
        public function updateAvatar($avatar)
        {
            if (empty($avatar) || strlen($avatar) < 1) return FALSE;

            $userinfo = $this->getUserInfo();
            $this->db->update_cache('user_info_' . $userinfo['user_id']);

            return $this->update(array('face_url' => $avatar), array('user_id' => $userinfo['user_id']));
        }

        /**
         * 更新用户性别
         * @param $gender
         * @return bool
         */
        public function updateGender($gender)
        {
            $userinfo = $this->getUserInfo();
            if (empty($gender) || (int)$gender < 1) return FALSE;

            $this->db->update_cache('user_info_' . $userinfo['user_id']);

            return $this->update(array('gender' => (int)$gender), array('user_id' => $userinfo['user_id']));
        }

        /**
         * 检测并确认用户姓名
         * @param $username
         * @return string
         */
        public function updateUsername($username)
        {
            if ($this->exits(array('user_name' => $username))) return '用户名重复';

            $userinfo = $this->getUserInfo();
            $result = $this->update(array('user_name' => $username), array('user_id' => $userinfo['user_id']));
            if ($result == TRUE) {
                $userinfo['user_name'] = $username;
                Yaf_Session::getInstance()->userinfo = $userinfo;

                return TRUE;
            }

            return FALSE;
        }

        public function mkdata($v)
        {
            return array(
                'user_email'     => $v['email'],
                'user_name'      => $v['user_name'],
                'user_pwd'       => md5($v['pwd']),
                'remark'         => $v['remark'],
                'follower_count' => (int)$v['follower_count'],
                'items_count'    => (int)$v['items_count'],
                'collect_count'  => (int)$v['collect_count'],
                'album_count'    => (int)$v['album_count'],
                'interest_count' => (int)$v['interest_count'],
                'created_time'   => time(),
            );
        }

    }