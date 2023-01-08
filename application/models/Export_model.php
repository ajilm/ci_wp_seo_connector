<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export_model extends CI_Model 
{ 
 
	 public function __construct()
     {
             parent::__construct();
             // Your own constructor code
             $this->load->helper('curl_helper'); 
     }

    
 public function getDateRecord($startdate,$enddate) {	
             
             $this->legacy_db = $this->load->database('second', true);
  
            $sql = " select DISTINCT(o.ID) as ID, pm2.meta_value as utmsrc FROM wp_posts o 
            JOIN wp_postmeta om ON o.ID = om.post_id 
            LEFT JOIN wp_postmeta  pm2 ON o.ID = pm2.post_id 
            WHERE
            o.post_type = 'shop_order' AND o.post_status NOT IN('wc-pending', 'codrto', 'wc-cancelled', 'wc-failed') 
            AND pm2.meta_key = 'after_order_cookie_xlutm_params_utm' AND  pm2.meta_key != '' AND
            DATE(o.post_date) BETWEEN CAST('$startdate' AS DATE) AND CAST('$enddate' AS DATE) ORDER BY o.post_date DESC";

   
             $query = $this->legacy_db->query($sql);

             $this->legacy_db->close();  

             if ($query->num_rows() > 0) {

                $result = $query->result_array();

             }else{

                $result = array(); 

             } 
            
             foreach ($result as $src ) { 
               
                $data[] =    array(
                'id' => $src['ID'],
                'utm' => $src['utmsrc']
                );

               
             } 

 

           $refdata = $this->refinedata($data);
  
           return $refdata;// $query->result_array();
 }


 public function refinedata($results) { 

if($results)
{
$rw_count = 1;
$orderdate='';
$ordertime='';
$total_product_per_order='';
 
    foreach($results as $data)
    {
     
       
 

        $product_utm = unserialize($data['utm']);

        if($product_utm)
        {

        

            foreach($product_utm as $key_i=>$val_i)
            {
        
                $arysrc =  
                    
                    array(
                        'order_id' => $data['id'], 
                        'utm_source_id' =>  $key_i,

                        'utm_source' => $product_utm[$key_i]['utm_source'], 
                        'utm_medium' => $product_utm[$key_i]['utm_medium'],
                        'utm_campaign' => $product_utm[$key_i]['utm_campaign'],
                        'utm_content' =>  $product_utm[$key_i]['utm_content'],          
                    
                        );

                    $data_camp_src[$data['id']]  =  $arysrc ;     
            }
        
            

        }
 
        
 
        $showcoupondata = '0';
        
        $showpercent='';
        $codfee = '';
        $dt_src_data = '';

            

            if($data_camp_src)
            {


            $dt = $data_camp_src[$data['id']];

                $dt_src_data = array(
                    'utm_source_id' => $dt['utm_source_id'],
                    'utm_source' =>$dt['utm_source'],
                    'utm_medium' => $dt['utm_medium'],
                    'utm_campaign'=>$dt['utm_campaign']
 
                );

            

            }
        
            $itemscount = 0;
            //Fetch order data from Woo Rest API
            $odata = get_orderdata_by_id($data['id']);
            $itemscount = count($odata->order->line_items);
            $order_status = $odata->order->status;

            $email = $odata->order->billing_address->email; 
            $city = $odata->order->billing_address->city;
            $total = $odata->order->total;
            $postcode = $odata->order->billing_address->postcode;
            $phone = $odata->order->billing_address->phone;
            $method_title = $odata->order->payment_details->method_title;
            $state = $odata->order->billing_address->state;
            $orderdate = $odata->order->created_at;


            $datetime = new DateTime($orderdate);
            $orderdate = $datetime->format('Y-m-d');
            $ordertime = $datetime->format('H:i:s');


            
            $pfa = '';
            $addcon = '';
            $restrictids = array(206036,243077);//PFA & Additional Contribution
	 
	  if(count($odata->order->line_items)  == 1 )
	  { 
		
		

		foreach ($odata->order->line_items as $line_items)
         {
           if('206036' == $line_items->product_id)
            { 
            $pfa = 'TRUE';
            } 

            if('243077' ==  $line_items->product_id)
            {
                $addcon = 'TRUE';
            }
        } 
	  } 
    
	
      if(count($odata->order->line_items)  == 2)
	  {  

        $pfa = '';
        $addcon = '';
		 
		foreach ($odata->order->line_items as $line_items)
         {
		  $givenids[] = $line_items->product_id;
		 }


      

       $result = array_diff($givenids, $restrictids);
	   if(!$result)
       { 

	    $pfa = 'TRUE';
        $addcon = 'TRUE';

	   }

    }
       
  
       $refdata[] = array( 
                    
                'No'=>$rw_count,
                'Order_No'=>$data['id'],  
                'Orderdate'=>$orderdate,  
                'Order_time'=>$ordertime,  

                'City'=> $city  ,
                'State_Name'=>$state ,
                'Postcode'=>$postcode,
                'Email'=> $email,
                'Phone'=>$phone, 
                'Payment_Method_Title'=>$method_title,
                 
                'Order_Total_Amount'=> $total,
                'Order_status' => $order_status,
                'PFA' => $pfa,
                'Additional Contribution' =>$addcon,

                'Source_Id'=>$dt_src_data['utm_source_id'],
                'Source'=>$dt_src_data['utm_source'],
                'Medium'=>$dt_src_data['utm_medium'],
                'Campaign'=>$dt_src_data['utm_campaign'],

                'itemcount' => $itemscount 
 
            );

            
    
    $rw_count++;
    }//Foreach end

}else{        //-----End result


    
    $refdata[] = array(
            
        'No'=>'NA',
        'Order_No'=>'NA',
        'Orderdate'=>'NA',
        'Order_time'=>'NA',

        'City'=>'NA',
        'State_Name'=>'NA',
        'Postcode'=>'NA',
        'Email'=>'NA',
        'Phone'=>'NA',
        'Payment_Method_Title'=>'NA',
         
        'Order_Total_Amount'=>'NA',
        'Order_status' =>'NA',
        'PFA'=>'NA',
        'Additional Contribution' =>'NA',

        'Source_Id'=>'NA',
        'Source'=>'NA',
        'Medium'=>'NA',
        'Campaign'=>'NA',
        'itemcount' =>'NA',

    );

}


// echo '<pre>';
// print_r($refdata);
// exit;

return $refdata;


 }
 

}
 

 