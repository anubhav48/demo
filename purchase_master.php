<?php
include "../user/connection.php";
include "header.php" ;
?>
<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>
            Home</a></div>
    </div>
    <!--End-breadcrumbs-->

    <!--Action boxes-->
    <div class="container-fluid">

        <div class="row-fluid" style="background-color: white; min-height: 1000px; padding:10px;">
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Add new purchase</h5>
        </div>
        <div class="widget-content nopadding">
          <form name="form1" action="" method="post" class="form-horizontal" >
            <div class="control-group">
              <label class="control-label">Select Company </label>
              <div class="controls">
                <select class="span11" name="company_name" id="company_name" onchange="select_company(this.value)">
                    <option value="">Select</option>
                    <?php
                      $res = mysqli_query($link,"select * from company_name");
                      while($row = mysqli_fetch_array($res))
                      {
                          echo "<option>";
                          echo $row['company_name'];
                          echo "</option>";
                      }
                    ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Select Product Name</label>
              <div class="controls" id="product_name_div">
              <select class="span11">
                    <option>Select</option>
                </select>
            </div>
            </div>
            
           
           
            <div class="control-group">
              <label class="control-label">Enter packing size</label>
              <div class="controls" id="packing_size_div">
              <select class="span11">
                    <option>Select</option>
                </select>
            </div>
            </div>


            <div class="control-group">
              <label class="control-label">Enter quantity</label>
              <div class="controls" >
              <input type="number" name="qty" value="0" class="span11">
                   
            </div>
            </div>

            <div class="control-group">
              <label class="control-label">Enter Price</label>
              <div class="controls" >
              <input type="number" name="price" value="0" class="span11">
                   
            </div>
            </div>

            <div class="control-group">
              <label class="control-label">Enter Party Name</label>
              <div class="controls" >
              <select class="span11" name="party_name">
                    <?php
                    $res=mysqli_query($link,"select * from party_info");
                    while($row=mysqli_fetch_array($res))
                    {
                      echo "<option>";
                      echo $row["businessname"];
                      echo "</option>";
                    } 

                    ?>
                </select>
             
                   
            </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">Select Purchase type:</label>
              <div class="controls">
              <select class="span11" name="purchase_type">
                    
                    <option >Cash</option>
                    <option >Debit</option>
                </select> </div>
            </div>
            


          

            <div class="alert alert-danger" style="display:none" id="error"> 
                <strong>This username already exists. Try another.</strong>    
            </div>


            <div class="form-actions">
              <button type="submit" name="submit1" class="btn btn-success">Save</button>
            </div>

            <div class="alert alert-success" style="display:none" id="success"> 
                <strong>Purchase Inserted Successfully. </strong>
            </div>

          </form>


        </div>
        
      </div>
     

    </div>
</div>



<!--end-main-container-part-->
<script type="text/javascript">
     function select_company(company_name)
     {
      // alert(document.getElementById("company_name").value);
      // alert(company_name); 
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange =function(){

      if (xmlhttp.readyState ==4 &&  xmlhttp.status == 200) {

       document.getElementById("product_name_div"). innerHTML=xmlhttp.responseText;
}
};

     xmlhttp.open("GET", "forajax/load_product_using_company.php?company name="+company_name,true);
     xmlhttp.send();
}
function select_product(product_name,company_name)
{
  
  var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange =function(){

      if (xmlhttp.readyState ==4 &&  xmlhttp.status == 200) {

       document.getElementById("packing_size_div"). innerHTML=xmlhttp.responseText;
}
};

     xmlhttp.open("GET", "forajax/load_packing_size_using_unit.php?product_name="+product_name+"&company_name="+company_name,true);
     xmlhttp.send();
  alert(company_name+" =="+ product_name); 
}
/*function select_unit(unit,product_name,company_name)
{
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange =function(){

      if (xmlhttp.readyState ==4 &&  xmlhttp.status == 200) {

       document.getElementById("unit_div"). innerHTML=xmlhttp.responseText;
}
};

     xmlhttp.open("GET", "forajax/load_packing_size_using_unit.php?unit="+unit+" &product_name="+product_name+"&company_name="+company_name,true);
     xmlhttp.send();
}*/

</script>

<?php
/*if(isset($_POST['submit1']))
{
    
        $query="insert into products 
        values(NULL, '$_POST[company_name]','$_POST[product_name]','$_POST[quantity]')";
        $res=mysqli_query($link,$query);
        ?>
        <script type="text/javascript">
        document.getElementById("success").style.display="block";
        document.getElementById("error").style.display="none";
        setTimeout(function () {
            window.location.href = window.location.href;
        }, 3000);
        </script>
        <?php	
        

}*/
?> 
<?php
if(isset($_POST['submit1']))
{
  $res=mysqli_query($link,"INSERT into purchase_master values (NULL,'$_POST[company_name]','$_POST[product_name]','$_POST[packing_size]','$_POST[qty]','$_POST[price]','$_POST[party_name]','$_POST[purchase_type]') ") or die(mysqli_error($link));
  
 if($res)
  {
  $count=0;
  $res=mysqli_query($link,"select * from stock_master where product_company='$_POST[company_name]' && product_name='$_POST[product_name]' ");
  $count=mysqli_num_rows($res);
  
  if($count==0)
  {
    mysqli_query($link,"INSERT into stock_master values(NULL,'$_POST[company_name]','$_POST[product_name]','$_POST[qty]','0')") or die(mysqli_error($link));
  }
  else{
    mysqli_query($link,"UPDATE stock_master set product_qty=product_qty + $_POST[qty] where product_company='$_POST[company_name]' && product_name='$_POST[product_name]'") or die(mysqli_error($link));
  }
  ?>
  <script type="text/javascript">
        document.getElementById("success").style.display="block";
        document.getElementById("error").style.display="none";
        setTimeout(function () {
            window.location.href = window.location.href;
        }, 3000);
        </script>
  <?php
    }
    else{
      ?>
      <script type="text/javascript">
        document.getElementById("success").style.display="none";
        document.getElementById("error").style.display="block";
        setTimeout(function () {
            window.location.href = window.location.href;
        }, 3000);
        </script> 
        <?php
    }
}
?>

<?php
include 'footer.php'

?>