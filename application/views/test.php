<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<!-- Breadcrumbs -->
<ol class="breadcrumb D-breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active">My Dashboard</li>
</ol>
</div>


<div class="container-fluid">
    <form action="<?php echo  base_url('/test/formdata'); ?>" class="form-inline export-form" method="post">
        <fieldset>
            <legend><input type="submit" name="export" value="Export_to_CSV" class="btn btn-info" /></legend>
            <div id="foo">
                <input type="text" name="startdate" id="start" class="form-control" placeholder="start date"  >
                <span>To</span>
                <input type="text" name="enddate" id="end" class="form-control" placeholder="end date"  >
            </div>
        </fieldset>
    </form>
</div>

  

<?php 
// echo '<pre>';
// print_r($record_count);
// echo '</pre>';

// [COD_count] => 2
// [Prepaid_count] => 16
 
 
 
$cod_count = $record_count[0]['COD_count'];  
 $prepaid_count = $record_count[0]['Prepaid_count'];  
?>
 <div class="chart-container" style="position: relative; height:40vh; width:80vw">
  <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');


  const data = {
  labels: [
    'COD payments',
    'Prepaid payments',
     
  ],
  datasets: [{
    label: 'COD payments VS Prepaid payments',
    data: [<?php echo $cod_count;?>, <?php echo $prepaid_count;?> ],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      
    ],
    hoverOffset: 4
  }]
};


const config = {
  type: 'doughnut',
  data: data,
};

new Chart(ctx, config);

//   new Chart(ctx, {
//     type: 'bar',
//     data: {
//       labels: ['Red', 'Orange'],
//       datasets: [{
//         label: 'COD VS Prepaid',
//         data: [100,200],
//         borderWidth: 1
//       }]
//     },
//     options: {
//       scales: {
//         y: {
//           beginAtZero: true
//         }
//       }
//     }
//   });
</script>

 
 
 
               
                <div class="card-footer small text-muted text-right">
                    <p><?php echo $links; ?></p>
                </div>
            </div>





        </div>