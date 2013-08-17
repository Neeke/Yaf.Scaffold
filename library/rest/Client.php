<?php 
/**
 * RestClient
 * @author ciogao@gmail.com
 *
 * demo
 * 		$data = array(
 * 			'param1' => 'test',
 * 			'param2' => 'test',
 * 			);
 *	
 *		$this->c = rest_Client::instance();
 *		$this->c->method = 'POST';
 *		$this->c->data($data);
 *		$this->c->api = 'http://tbbundlesina.weiboyi.com/tbapp/apilist/demand';
 *		$this->c->go();
 *		$body = $this->c->getBody();
 *		var_dump($body);
 */
class rest_Client{

	private $header = null;
	function getHeader(){
		return $this->header;
	}
	
	private $body = null;
	function getBody(){
		return $this->body;
	}
	
	/**
	 * @var rest_Client
	 */
	private static $self=null;
	
	/**
	 * @static
	 * @return rest_Client
	 */
	public static function instance(){
		if (self::$self == null){
			self::$self = new self;
		}
		return self::$self;
	}
	
	/**
	 * method方法
	 * @var (string)GET|POST|PUT|DELETE
	 */
	public $method = 'GET';
	/**
	 * api url
	 * @var (string)url
	 */
	public $api = null;
	
	/**
	 * GET或POST的请求参数
	 * @var (array)请求参数
	 */
	private $data = array();
	private $ifData = FALSE;
	public function data($data){
		$this->ifData = TRUE;
		$this->data = $data;
	}
	
	/**
	 * 设置referer来源
	 * @var (string)referer
	 */
	private $referer = null;
	private $ifReferer = FALSE;
	public function referer($referer){
		$this->ifReferer = TRUE;
		$this->referer = $referer;
	}
	
	/**
	 * 走起
	 */
	public function go(){
		self::valid();
		self::myCurl();
	}
	
	private function valid(){
		if ($this->api == null) {
			throw new Exception('$this->api can not be null');
		}
		
		if ($this->ifData && (!is_array($this->data) || count($this->data) < 1)) {
			throw new Exception('$this->data is empty');
		}
		
		if ($this->ifReferer && (strlen($this->referer) < 1)) {
			throw new Exception('$this->referer is empty');
		}
		
		if ($this->method != 'GET' && !in_array($this->method, array('POST','PUT','DELETE'))) {
			throw new Exception('$this->method is error');
		}
	}
	
	private function myCurl(){
			$ch = curl_init();
			$timeout = 300;
			$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
			$header = array('Accept-Language: zh-cn','Connection: Keep-Alive','Cache-Control: no-cache');
			curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			//curl_setopt($ch, CURLOPT_USERPWD , "$name:$pwd");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			switch ($this->method){
				case 'GET':
					$api = $this->api.'?';
					foreach ($this->data as $k => $v){
						$api .= $k.'='.$v.'&';
					}
					curl_setopt($ch, CURLOPT_URL, $api);
					break;
				case 'POST':
					curl_setopt($ch, CURLOPT_URL, $this->api);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
					break;
				case 'PUT':
					curl_setopt($ch, CURLOPT_PUT, true);
					break;
				case 'DELETE':
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'DELETE');
					break;
			}
			
			if ($this->ifReferer) {
				curl_setopt($ch,CURLOPT_REFERER,$this->referer);
			}	
			 
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			
			if (curl_errno($ch)) {
				throw new Exception('CURL was error');
			}else{
				$this->body = curl_exec($ch);
				$this->header = curl_getinfo($ch);				
			}

			curl_close($ch);
	}
	
}