<?php
include "../user/connection.php";
include "header.php" ;
?>
<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
            Stock Master</a></div>
    </div>
    <!--End-breadcrumbs-->

    <!--Action boxes-->
    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
        <div class="widget-box">
       
        
          
      <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th><ID></th>
                  <th>Product Company</th>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Product Selling Price</th>
                  <th>Edit</th>
                  
                </tr>
              </thead>
              <tbody>

              <?php
                    $count=0;
                    $res=mysqli_query($link,"select * from stock_master");
                    while($row=mysqli_fetch_array($res))
                    {
                        $count=$count+1;
                        ?>
                        <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $row['product_company']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_qty']; ?></td>
                        <td><?php echo $row['product_selling_price']; ?></td>
                        <td><center><a href="edit_stock_master.php?id=<?php echo $row['id'];?>">Edit</a></center></td>
                        
                        </tr>
                        <?php
                       
                    }
                   
              ?>
                
                
              </tbody>
            </table>
          </div>
        </div>

    </div>
</div>



<!--end-main-container-part-->



<?php
include 'footer.php'

?>