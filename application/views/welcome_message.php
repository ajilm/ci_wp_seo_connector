<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 

            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">My Dashboard</li>
            </ol>


<div class="container">

<div class="row">


  
  <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Data Table Example
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                            <thead>
                                <tr>
                                <th>#</th>
      <th>Order Date</th> 
      <th>Order Number</th>

      <th>Salutation</th>
      <th>Full Name (Billing)</th>   
        
      <th>Address 1</th>  
      <th>Address 2</th>  
      <th>City (Billing)</th>  
      <th>State Name (Billing)</th>  
      <th>Postcode (Billing)</th>
      
      <th>Email (Billing) </th> 
      <th>Phone (Billing)</th>   
       <th>Payment Method </th>
      <th>Payment Method Title</th>
     
        

      <th>Category </th>
      <th>Coupon Code </th>
      <th>Cart Discount Amount</th>
       
      <th>COD fee</th>
      <th>Order Total Amount</th>

 
      
      <th>Source Id</th>
      <th>Source</th>
      <th>Medium</th>
      <th>Campaign</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>#</th>
      <th>Order Date</th> 
      <th>Order Number</th>

      <th>Salutation</th>
      <th>Full Name (Billing)</th>   
        
      <th>Address 1</th>  
      <th>Address 2</th>  
      <th>City (Billing)</th>  
      <th>State Name (Billing)</th>  
      <th>Postcode (Billing)</th>
      
      <th>Email (Billing) </th> 
      <th>Phone (Billing)</th>   
       <th>Payment Method </th>
      <th>Payment Method Title</th>
     
        

      <th>Category </th>
      <th>Coupon Code </th>
      <th>Cart Discount Amount</th>
       
      <th>COD fee</th>
      <th>Order Total Amount</th>

 
      
      <th>Source Id</th>
      <th>Source</th>
      <th>Medium</th>
      <th>Campaign</th>
                                </tr>
                            </tfoot>
                            <tbody>


                 

<?php


$cnt = 1;
foreach($results as $data) {

    
//echo $data['ID']. " - " . $data['utmsrc'] . "<br>";



echo '<pre>';
print_r($data);
echo '</pre>';
exit; 

// foreach ( $sourcedata_init as $data_init ) {
//     $unserialized_init = unserialize($data_init->utmsrc);



// foreach($unserialized_init as $key_i=>$val_i)
// {

//  if(count($unserialized_init) > 1){
//          $insider_key_i[]  = array(
//        'order_id' => $data_init->ID,
//        'unserialized' => $unserialized_init[$key_i]);

//   }

// }

// }  
 


echo '<tr>
<td>'.$cnt.'</td>
<td>Order Date</td> 
<td>'.$data->ID.'</td>

<td>Salutation</td>
<td>Full Name (Billing)</td>   

<td>Address 1</td>  
<td>Address 2</td>  
<td>City (Billing)</td>  
<td>State Name (Billing)</td>  
<td>Postcode (Billing)</td>

<td>Email (Billing) </td> 
<td>Phone (Billing)</td>   
<td>Payment Method </td>
<td>Payment Method Title</td>



<td>Category </td>
<td>Coupon Code </td>
<td>Cart Discount Amount</td>

<td>COD fee</td>
<td>Order Total Amount</td>



<td>Source Id</td>
<td>Source</td>
<td>Medium</td>
<td>Campaign</td>
</tr>
 
 ';

 
 
  
$cnt++;
}
?>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>


            <p><?php echo $links; ?></p>


</div>
 
        
