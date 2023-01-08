<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once( 'Woocommerce/woocommerce-api.php' );

class Woocommerce
{
	protected $options;
	function __construct()
	{
		// parent::__construct();
		$this->options = array(
			'debug'           => true,
			'return_as_array' => false,
			'validate_url'    => false,
			'timeout'         => 30,
			'ssl_verify'      => false,
		);
	}
	public function request()
	{

		$consumer_key = 'ck_cc24f3c224eae46ff7f57080bc6006453e0097dd';
		$consumer_secret = 'cs_e0b01ec1ecb7e518587aedd8ee7aaf98130e5933';
		$storeurl = 'https://imfpa.org/';


	 	$client = new WC_API_Client( $storeurl, $consumer_key, $consumer_secret, $this->options );
	 	return $client;
	}
}
