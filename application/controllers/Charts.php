<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Charts extends CI_Controller {

	
public function __construct()
{
		parent::__construct();// you have missed this line.
	 
		$this->output->delete_cache();
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');


		$this->load->helper('url'); 
  
		 // load model
		 $this->load->model('Chart_model');
 
		 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
}


	public function index()
	{ 
		if ($this->Admin_model->verifyUser()) {
			$data["records"] = $this->Chart_model->getRecords();
				$this->load->view('header');
				$this->load->view('chart', $data);
				$this->load->view('footer');
		} 
	}

 
 }
 
