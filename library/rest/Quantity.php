<?php
/**
 * 访问频次限制
 * @author ciogao@gmail.com 
 * demo
 * 		$this->quantity = rest_Quantity::instance();
 *		
 *		以ip统计,60秒内10次
 *		$this->quantity->config(10,60,rest_Quantity::CONFIG_IP);
 *		$this->quantity->check();
 *
 *		以ip&appkey统计,30秒内10次
 *		$this->quantity->config(10,30,rest_Quantity::CONFIG_KEY_AND_IP);
 *		$this->quantity->check('appkey');
 *
 *		以appkey统计,30秒内30次
 *		$this->quantity->config(30,30);
 *		$this->quantity->check('appkey');
 */
class rest_Quantity {
	
	const CONFIG_KEY = 'key';
	const CONFIG_IP = 'ip';
	const CONFIG_KEY_AND_IP = 'key_ip';
	
	const DEFAULT_KEY_OR_IP = 'key';
	const DEFAULT_MAX_COUNT = 60;
	const DEFAULT_TIME = 60;
	
	private $key_or_ip = self::DEFAULT_KEY_OR_IP;	//key或者ip
	private $max_count = self::DEFAULT_MAX_COUNT;	//单位时间内最大次数
	private $time = self::DEFAULT_TIME;				//单位时间/秒 默认1分钟
	private $key = null;	
	
	/**
	 * @var db_Cache
	 */
	private $cache = null;
	
	/**
	 * @var rest_Server
	 */
	private $rest = null;
	
	/**
	 * @var rest_Quantity
	 */
	private static $self=null;
	
	/**
	 * @static
	 * @return rest_Quantity
	 */
	public static function instance(){
		if (self::$self == null){
			self::$self = new self;
		}
		return self::$self;
	}
	
	protected function __construct(){
 		$this->cache = db_Cache::instance();
		$this->rest = rest_Server::instance();
	}
	
	/**
	 * 设置配置项
	 * @param int $max_count 单位时间内允许的最大次数
	 * @param int $time 单位时间 秒 默认为1分钟,建议不超过5分钟
	 * @param string $key_or_ip
	 */
	public function config($max_count = NULL, $time = NULL, $key_or_ip = NULL){
		$this->max_count = $max_count == NULL ? self::DEFAULT_MAX_COUNT : (int)$max_count;
		$this->time = $time == NULL ? self::DEFAULT_TIME : (int)$time;
		$this->key_or_ip = $key_or_ip == NULL ? self::DEFAULT_KEY_OR_IP : $key_or_ip;
	}
	
	/**
	 * 主要check流程
	 * @param string $key
	 */
	public function check($key = NULL){
		self::getkey($key);
		$ready = $this->cache->get($this->key);

		if ($ready == FALSE) {
			$this->cache->set($this->key, array(time()));
			return ;
		}
		
		$ready_ = $ready;
		if (self::checkCountAndTime($ready_)) {
			$this->rest->error(rest_Code::STATUS_ERROR_API_QUENCY_M);
		}
		unset($ready_);
		
		array_push($ready, time());
		$this->cache->set($this->key, $ready);
	}
	
	/**
	 * check单位时间内的频次
	 * @param array $ready_
	 * @return boolean
	 */
	private function checkCountAndTime(array $ready_){
		return (count($ready_) >= $this->max_count || array_pop($ready_) > time() + $this->time);
	}
	
	/**
	 * 计算将用于使用的cache_key
	 * @param string $key
	 */
	private function getkey($key = NULL){
		switch ($this->key_or_ip){
			case self::CONFIG_KEY:
				$this->key = md5((string)$key);
				break;
			case self::CONFIG_IP:
				$this->key = md5(helper_clientinfo::getIP());
				break;
			case self::CONFIG_KEY_AND_IP:
				$this->key = md5((string)$key.'&'.helper_clientinfo::getIP());
				break;
			default:
				$this->key = md5((string)$key);
		}
		
	}
	
}