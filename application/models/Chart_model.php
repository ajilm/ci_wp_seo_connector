<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_model extends CI_Model 
{ 
 
	 public function __construct()
     {
             parent::__construct();
            
     }

    
      public function getRecords() {	
                     
               $this->legacy_db = $this->load->database('second', true);
         
                     $sql = " 
                     select DISTINCT(o.ID) as ID, pm2.meta_value as utmsrc FROM wp_posts o 
                     JOIN wp_postmeta om ON o.ID = om.post_id 
                     LEFT JOIN wp_postmeta  pm2 ON o.ID = pm2.post_id 
                     WHERE
                     o.post_type = 'shop_order' AND o.post_status NOT IN('wc-pending', 'codrto', 'wc-cancelled', 'wc-failed') 
                     AND pm2.meta_key = 'after_order_cookie_xlutm_params_utm' AND  pm2.meta_key != ''  ORDER BY o.post_date DESC";

            
                     $query = $this->legacy_db->query($sql);

                     $this->legacy_db->close();  

                     if ($query->num_rows() > 0) {

                        $result = $query->result_array();

                     }else{

                        $result = array(); 

                     } 
                     
                     $count_noutmsrc = 0;
                     $count_withutmsrc = 0;

                     foreach ($result as $src ) { 
                        
                        if($src['utmsrc'] != '')
                        {

                          $count_noutmsrc =  $count_noutmsrc +1;
                         
                        }else{

                          $count_withutmsrc =  $count_withutmsrc +1;
                            
                        }
 
                        
                     }  
                  
                     
                     $count_data = array(

                     'withutmsrc' => $count_withutmsrc,
                     'noutmsrc' => $count_noutmsrc

                     );
 
         
                  return $count_data; 
      }
         

}
 

 