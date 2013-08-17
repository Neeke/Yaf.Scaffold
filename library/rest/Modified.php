<?php
/**
 * 利用浏览器modified缓存
 * 
 * 根据uri与$_GET\$_POST参数计算cache_key
 * 确保用户对每个uri请求参数相同的情况下,采用此类
 * @author ciogao@gmail.com
 * @access 注意,只在GET请求时生效
 * 			jquery已经对GET默认启用了modified方法,没过期的缓存不再请求
 * 			jquery的POST方法已经不再发送HTTP_IF_MODIFIED_SINCE头
 * 			参看:http://api.jquery.com/jQuery.ajax/
 * 						jQuery.ajax( url [, settings] )
 * 						cache
 * 						headers
 *
 *
 * demo
 * 可用于集中的RESTapi接口,采用客户端缓存,可有效降低服务器资源消费
 * 注: 处于init\paramCheck\quantityCheck之后,正式逻辑之前
 * 
 * 		$this->modified = rest_Modified::instance();
 * 		$this->modified->ckModified();
 */
class rest_Modified {
	
	const DEFAULT_MODIFIED_TIME = 600; //默认设置浏览器缓存10分钟
	
	/**
	 * 默认缓存时间
	 * @var int
	 */
	private $modified_time = 0;
	
	/**
	 * @var db_Cache
	 */
	private $cache = NULL;
	
	/**
	 * @var rest_Modified
	 */
	private static $self=NULL;

    /**
     * @static
     * @param string $time
     * @return rest_Modified
     */
	public static function instance($time = ''){
		if (self::$self == NULL){
			self::$self = new self;
		}
		
		return self::$self;
	}
	
	protected function __construct(){
 		$this->cache = db_Cache::instance();
	}
	
	/**
	 * modified时间配置
	 */
	public function config($time = self::DEFAULT_MODIFIED_TIME){
		$this->ifConfig = TRUE;
		$this->modified_time = (int)$time;
	}
	
	/**
	 * 根据uri与$_GET\$_POST参数计算cache_key
	 * @param string $uri
	 * @param array $params
     * @return string
     */
	private static function setModifiedKey($uri,$params){
		return md5(json_encode(array($uri,$params)));
	}
	
	/**
	 * 返回modified缓存header
	 * @param int $last_modified
	 */
	private function mkHeader($last_modified){
		header("Pragma: private");
		header("Last-Modified: " . gmdate ('r', $last_modified));
		header("Expires: " . gmdate ("r", ($last_modified + $this->modified_time)));
		header("Cache-control: max-age=$this->modified_time");
	}
	
	/**
	 * 主要检测过程
	 * @param int $time
	 */
	public function ckModified($time = self::DEFAULT_MODIFIED_TIME){
		if (!$this->ifConfig) {
			self::config($time);
		}
		
		$method = $_SERVER['REQUEST_METHOD'];
		
		switch ($method){
			case 'GET':
				$uri = $_SERVER['REQUEST_URI'];
				$params = 0;
				break;
			case 'POST':
				$uri = $_SERVER['REQUEST_URI'];
				$params = $_POST;
				break;
		}
		
		$key = self::setModifiedKey($uri, $params);
		$cache_time = $this->cache->get($key);
		
		if ($cache_time){
			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				
				$modified_time = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
				if ($cache_time <= $modified_time) {
					self::mkHeader($cache_time);
					header("HTTP/1.0 304 Not Modified");
					die;
				}
				
			}
		}else{
			$now = time();
			$this->cache->set($key, $now, $this->modified_time);
		}
		
		self::mkHeader($now);
	}
	
}