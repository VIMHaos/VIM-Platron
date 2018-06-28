<?php class VIMPlatron{
	private $login;
	private $token;
	private $sign;
	private $url;
	
	protected $Request;
	protected $ResponseStr;
	protected $Response;
	
	public function __construct($login,$token){
        $this->login = $login;
        $this->token = $token;
	}
	public function sign($url, $data = array()){
		$this->url = $url;
		
		$data = array('request'=>$data);
		
		$data['request']['Login'] = $this->login;

		$this->sign = base64_encode(hash('sha256', $this->url. json_encode($data, JSON_UNESCAPED_UNICODE).$this->token , true));
		
		$data['request']['Signature'] = $this->sign;
		
		$this->Request = (object) $data;
		
		return $this;
	}
	public function send(){
		$bodySent = json_encode($this->Request, JSON_UNESCAPED_UNICODE);
		$headers = array( 
			"Content-Type: application/json; charset=\"utf-8\"", 
			"Accept: application/json",
			"Cache-Control: no-cache",
			'Connection: Keep-Alive', 
			'User-Agent: VIM-Platron-Client/0.1.1', 
			'Content-Length: '.strlen($bodySent), 
		); 
	
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, 'https://api.platron.pro/v1.0'.$this->url); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $bodySent); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch); 
		
		$headerSent = curl_getinfo($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headerResponse = substr($response, 0, $header_size);
		
		$this->ResponseStr = substr($response, $header_size);
		$this->Response = json_decode($this->ResponseStr);
		
		/*
		file_put_contents(dirname(__FILE__).'/platron/SentHeader.xml',print_r($headerSent,1));
		file_put_contents(dirname(__FILE__).'/platron/SentBody.xml',print_r($this->request,1));
		file_put_contents(dirname(__FILE__).'/platron/ResponseHeader.xml',$headerResponse);
		file_put_contents(dirname(__FILE__).'/platron/ResponseBody.xml',$this->Response);*/
		
		return $this;
	}
	public function Request(){return $this->Request;}
	public function Response(){return $this->Response;}
}