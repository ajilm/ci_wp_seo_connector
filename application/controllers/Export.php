<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {


	
public function __construct()
{
		parent::__construct();// you have missed this line.
		//$this->output->delete_cache();
//$this->output->clear_all_cache(); 
$this->output->delete_cache();
$this->output->set_header('HTTP/1.0 200 OK');
$this->output->set_header('HTTP/1.1 200 OK');
$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
$this->output->set_header('Pragma: no-cache');
 
       
		 // load model
		 $this->load->model('Main_model');
		 $this->load->model('Export_model');

		 error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
 
}

 
	public function index()
	{

		if ($this->Admin_model->verifyUser()) {
			redirect(base_url(), 'auto');
		} 

		//$data = array();
		//$data['orderData'] = $this->ExportModel->getDateRecord($startdate,$enddate);
		//$this->load->view('export_view',$data);
		//$this->load->view('welcome_message');
		
	}

	public function formdata()
    {
      //code goes here
     
      $form_data = $this->input->post();
	//   echo '<pre>';
	//   print_r($form_data);
	//   exit;
	  
if(  $form_data['startdate'] != '' &&  $form_data['enddate'] != '' )
{

	  $startdate = $form_data['startdate'];
	  $enddate = $form_data['enddate'];  
	  $export = $form_data['export'];   

	  $this->exportCSV($startdate,$enddate); 

}else{
	$this->load->view('header');
	 $this->load->view('error');
	 $this->load->view('footer');

}
	 
      // or just the username:
      //$username = $this->input->post("username");

      // then do whatever you want with it :)
	//   $this->load->view('header');
	//   $this->load->view('welcome_message');
	//   $this->load->view('footer');

    }

	// Export data in CSV format
	public function exportCSV($startdate,$enddate)
	{
		
		// echo '<pre>';
		// echo $startdate;
		// echo $enddate;
		// exit;
		//csv file name
		$filename = 'order_'.date('d-m-Y').'_'.time().'.csv';
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; "); 


		$startdate = $this->convertDateFormat($startdate);
		$enddate = $this->convertDateFormat($enddate);
		

		// get data
		$usersData = $this->Export_model->getDateRecord($startdate,$enddate);

		// echo '<pre>';
		//  print_r($usersData);
		//  exit;
		// file creation
		$file = fopen('php://output', 'w');

		$header = array('No',
		'Order No',
		'Order Date', 
		'Order Time', 
		'City',
		'State ', 
		'Postcode' ,
		'Email',
		'Phone'  ,
		'Payment Method',  
		'Order Total Amount' ,
		'Order Status',
		'PFA(Only)',
		'Additional Contribution(Only)',
		'Source Id' ,
		'Source' ,
		'Medium' ,
		'Campaign',
		'Itemcount' );
 

		fputcsv($file, $header);

		foreach ($usersData as $key=>$line){
		 fputcsv($file,$line);
		}

		 
		fclose($file);
		exit;
	}
	public function convertDateFormat($datestring)
	{

		$strng = strtotime($datestring);
		$new_date = date('Y-m-d', $strng);   
		return $new_date;

	}
}