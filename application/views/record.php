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
    <form action="<?php echo  base_url('/Start/formdata'); ?>" class="form-inline export-form" method="post">
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

  
  
               
                <div class="card-footer small text-muted text-right">
                    <p><?php echo $links; ?></p>
                </div>
            </div>





        </div>