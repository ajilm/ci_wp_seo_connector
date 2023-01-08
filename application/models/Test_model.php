<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_model extends CI_Model 
{ 
 
	 public function __construct()
     {
             parent::__construct();
            
     }

    
      public function getRecords($rowno,$rowperpage)  
      {	
                     
               $this->legacy_db = $this->load->database('default', true);
         
                   $sql = "SELECT * FROM Order_data AS od LEFT JOIN Order_products as op ON od.Order_No = op.Order_No  LIMIT $rowperpage, $rowno";

                   $query = $this->legacy_db->query($sql);
 
                   
                     if ($query->num_rows() > 0) {

                        $result = $query->result_array();

                     }else{

                        $result = array(); 

                     } 
 
                      
                  return $result; 
      }


      public function getRecordCount() {
     
         $this->legacy_db = $this->load->database('default', true);
       
     
         $sql = "SELECT * FROM Order_data AS od LEFT JOIN Order_products as op ON od.Order_No = op.Order_No ";
                  
          $query = $this->legacy_db->query($sql);
          $this->legacy_db->close();  
     
          $result = $query->result_array();
          
          return   $result[0]['allcount'];
     }


     public function get_record_count() {

        $this->legacy_db = $this->load->database('default', true);

        $sql = "SELECT  count(case when Payment_Method='cod' then 1 else null end) as COD_count, count(case when Payment_Method !='cod' then 1 else null end) as Prepaid_count  FROM Order_data ";

        $query = $this->legacy_db->query($sql);

            if ($query->num_rows() > 0) {

            $result = $query->result_array();

            }else{

            $result = array(); 

            } 
   
 

    return $result; 

     } 
    
 public function getDateRecord($startdate,$enddate) {	
             
   $this->legacy_db = $this->load->database('default', true);

 
  $sql = "SELECT 
  od.Order_No  as Order_No,
  od.Order_Date  as Order_Date,
  od.Order_Time as Order_Time,
  od.City as City,
  od.State as State,
  od.Postcode as Postcode,
  od.Gender as Gender,
  od.Email as Email,
  od.Phone as Phone,
  od.Payment_Method as Payment_Method,
  od.Order_Total_Amount as Order_Total_Amount,
  od.Order_Status as Order_Status,
  od.PFA as PFA,
  od.Additional_Contribution as Additional_Contribution,
  od.Source_Id as Source_Id,
  od.Source as Source,
  od.Medium as Medium,
  od.Campaign as Campaign,
  od.cookie_visitor_medium as Visitor_Source,
  od.cookie_visitor_ad as Visitor_Ad,
  op.product_title as product_title,
  op.Product_sku as product_sku,
  op.Product_category  as product_category


 FROM Order_data AS od LEFT JOIN Order_products as op ON od.Order_No = op.Order_No WHERE
  DATE(od.Order_date)  BETWEEN CAST('$startdate' AS DATE) AND CAST('$enddate' AS DATE) ORDER BY od.Order_No DESC";
 
  //echo $sql ;
 
 /*
  
SELECT 
  
  od.Order_No  as Order_No,
  od.Order_Date  as Order_Date,
  od.Order_Time as Order_Time,
  od.City as City,
  od.State as State,
  od.Postcode as Postcode,
  od.Gender as Gender,
  od.Email as Email,
  od.Phone as Phone,
  od.Payment_Method as Payment_Method,
  od.Order_Total_Amount as Order_Total_Amount,
  od.Order_Status as Order_Status,
  od.PFA as PFA,
  od.Additional_Contribution as Additional_Contribution,
  od.Source_Id as Source_Id,
  od.Source as Source,
  od.Medium as Medium,
  od.Campaign as Campaign,
  op.product_title as product_title,
  op.Product_sku as product_sku,
  op.Product_category  as product_category


 FROM Order_data AS od LEFT JOIN Order_products as op ON od.Order_No = op.Order_No WHERE
  DATE(od.Order_date)  BETWEEN CAST('2022-12-09' AS DATE) AND CAST('2022-12-09' AS DATE) ORDER BY od.Order_date DESC
*/

   $query = $this->legacy_db->query($sql);

   $this->legacy_db->close();  

   if ($query->num_rows() > 0) {

      $result = $query->result_array();

   }else{

      $result = array(); 

   } 
   
 $refdata = $this->refinedata($result);

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

        $pfa = '';
        $adcon = '';

        if($data['product_sku'] === 'ADD-CONTR')
        {
            $adcon = 'TRUE'; 
        }
        else if($data['Order_Status'] === 'paid')
        { 
            $pfa = 'TRUE'; 
        }

           $refdata[] = array( 
                       
                   'No'=>$rw_count,
                   'Order_No'=>$data['Order_No'],  
                   'Orderdate'=>$data['Order_Date'],  
                   'Order_time'=>$data['Order_Time'],    
   
                   'City'=> $data['City'],  
                   'State_Name'=>$data['State'],  
                   'Postcode'=>$data['Postcode'],  
                   'Email'=> $data['Email'],  
                   'Phone'=>$data['Phone'],  
                   'Payment_Method_Title'=>$data['Payment_Method'],  
                    
                   'Order_Total_Amount'=> $data['Order_Total_Amount'],  
                   'Order_status' => $data['Order_Status'],  
                   'PFA' =>$pfa,  
                   'Additional Contribution' => $adcon,  
   
                   'Source_Id'=>$data['Source_Id'],  
                   'Source'=>$data['Source'],  
                   'Medium'=>$data['Medium'],  
                   'Campaign'=>$data['Campaign'],
                   'Visitor_Source' => $data['Visitor_Source'],
                   'Visitor_Ad' => $data['Visitor_Ad'],
                   'Product_title' => $data['product_title'],
                   'Product_sku' => $data['product_sku'],
                   'Product_category' => $data['product_category'],
  
    
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
           'Campaign'=>'NA'
      
   
       );
   
   }
   
   
   
   
   return $refdata;
   
   
    }
         

}
 

 