<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Export Data -->
<a href='<?php echo  base_url('/ExportController/exportCSV'); ?>'>Export</a><br><br>

<!-- User Records -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($usersData as $key=>$val)
        {
            echo "<tr>";
            echo "<td>".$val['name']."</td>";
            echo "<td>".$val['email']."</td>";
            echo "<td>".$val['phone']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</body>
</html>