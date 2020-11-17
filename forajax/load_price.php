
<?php

include "../../user/connection.php";

$company_name=$_GET["company_name"];
$product_name=$_GET["product_name"];
$packing_size = $_GET["packing_size"];

$res=mysqli_query($link,"select  * from stock_master where product_company='$company_name' && product_name='$product_name'");
?>

<?php
if($res)
{
    while($row=mysqli_fetch_array($res))
    {   
    echo $row["product_selling_price"];   
    }
}


?>