<!-- date from database starts  -->
<?php

include "Connection.php";


session_start();

$tol_b_amount=0;
$tol_p_amount=0;
$tol_v_amount=0;
$tol_col = 0;
$tol_r_amount=0;
$tol_n_amount=0;


// For print detail button show
$location_submit="0"; 


$ZONE = "";
$CIRCLE = "";
$LOCATION="";
// $DIVISION="";
$BANK="";
$FROM_DATE = "";
$TO_DATE = "";
$REPORT_LAVEL = "";


$sql="SELECT DISTINCT PAY_DATE FROM DA_PAYMENT_MST ORDER BY PAY_DATE DESC";

$parse = ociparse($conn, $sql);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $form_date[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);


$sql="SELECT DISTINCT PAY_DATE FROM DA_PAYMENT_MST ORDER BY PAY_DATE DESC";

$parse = ociparse($conn, $sql);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $last_date[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);





?>


<?php 



set_time_limit(3000);
 include 'Connection.php';

 $sql1="SELECT PAY_DATE FROM (SELECT DISTINCT PAY_DATE FROM DA_PAYMENT_MST ORDER BY PAY_DATE DESC) WHERE ROWNUM=1";

    $parseresults = ociparse($conn, $sql1);
    oci_execute($parseresults);

    // var_dump($sql1);

    while ($row = oci_fetch_assoc($parseresults)) {
        $output1[] = $row;
    }
     
    // var_dump($output1);
    $date = $output1[0]["PAY_DATE"];

    oci_free_statement($parseresults);

    $sql2="SELECT LAST_DAY(ADD_MONTHS('". $date ."',-1)) AS LAST_DATE FROM DUAL";

    $parseresults = ociparse($conn, $sql2);
    oci_execute($parseresults);

    // var_dump($sql2);

    while ($row = oci_fetch_assoc($parseresults)) {
        $output2[] = $row;
    }
     
    // var_dump($output2);



    $last_date = $output2[0]["LAST_DATE"];

    // echo $last_date;


   $sql3="SELECT TRUNC(LAST_DAY('".$last_date."'),'mm') AS FRIST_DATE FROM DUAL";
   

   $parseresults = ociparse($conn, $sql3);
   oci_execute($parseresults);

   
   while ($row = oci_fetch_assoc($parseresults)) {
    $output3[] = $row;
}

// var_dump($output3);

$frist_date = $output3[0]["FRIST_DATE"];

// echo $frist_date;




  $p_SDATE = $frist_date;
 $p_EDATE = $last_date;


 


 oci_close($conn);



?>

<!-- page load starts  -->

<?php 

include "Connection.php";


$p_ZONE_CODE = NULL;
$p_CIRCLE_CODE = NULL;
$p_location_code = NULL;
$p_Bank_CODE =NULL;
$p_report_level_CODE = 1;




    // package starts 
    $curs = oci_new_cursor($conn);

    $stid = oci_parse($conn, "begin PKG_SELECT_SDA.dpd_dashboard(:cur_data,:p_SDATE,:p_EDATE,:p_ZONE_CODE,:p_CIRCLE_CODE,:p_location_code,:p_Bank_CODE,:p_report_level_CODE); end;");
   
   
    oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
    oci_bind_by_name($stid, ":p_SDATE", $p_SDATE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_EDATE", $p_EDATE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_ZONE_CODE", $p_ZONE_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_CIRCLE_CODE", $p_CIRCLE_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_location_code", $p_location_code, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_Bank_CODE", $p_Bank_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_report_level_CODE", $p_report_level_CODE, -1, SQLT_CHR);
   

    // print_r($p_SDATE);
    // print_r($p_EDATE);
   oci_execute($stid);
   oci_execute($curs);
   
   
   while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
   
       
     $form_data[]=$row;
     

   }

  //  var_dump($form_data);
   

   $ZONE_TOTAL_BILL = "[";

   $ZONE_NB = "[";
   $ZONE_TAKA = "[";

   $REPORT_HEADER = $form_data[0]["REPORT_HDR"];


   for($i=0; $i<count($form_data); $i++){
       $ZONE_TAKA .= '"' . $form_data[$i]["TOT_COLL"] . '",';
       $ZONE_TOTAL_BILL .= '"' . $form_data[$i]["NO_OF_BILL"] . '",';

       $ZONE_NB .= '"' . $form_data[$i]["REPORT_X"] . '",';

   }
   
   
   $ZONE_TAKA = substr($ZONE_TAKA, 0, -1);
   $ZONE_TOTAL_BILL = substr($ZONE_TOTAL_BILL, 0, -1);

   $ZONE_NB = substr($ZONE_NB, 0, -1);
   
   $ZONE_TOTAL_BILL = $ZONE_TOTAL_BILL . ']';
   $ZONE_TAKA = $ZONE_TAKA . ']';
   $ZONE_NB= $ZONE_NB . ']';


  //  echo "N"."<br>";
  //  echo $ZONE_TOTAL_BILL ;
  //  echo $ZONE_NB ;
  //  echo $ZONE_TAKA ;
   
//    var_dump($form_data);
//    echo"<br>";
   // print json_encode($output);

//    echo $frist_date;

// for first load start
   $FROM_DATE=$frist_date;
   $TO_DATE=$last_date;
   // for first load end



   


   
   oci_free_statement($stid);
   oci_free_statement($curs);
   
    // package ends 

    if(is_null($p_ZONE_CODE)){
        $ZONE=-1;
        // var_dump($ZONE);
    }
    
    if(is_null($p_CIRCLE_CODE)){
        $CIRCLE=-1;
        // var_dump($CIRCLE);
        
    }
    
    if(is_null($p_location_code)){
        $LOCATION=-1;
        // var_dump($CIRCLE);
        
    }

    
    if(is_null($p_Bank_CODE)){
        $p_Bank_CODE=-1;
        // var_dump($p_Bank_CODE);
    }

   






?>




<!-- page load ends  -->















<!-- submit start  -->


<?php



error_reporting(0);
set_time_limit(3000);
include "Connection.php";








if (isset($_POST['submit'])) {

    $ZONE = $_POST['zone'];
    $CIRCLE = $_POST['circle'];


    if($_POST['location']==""){

        // echo "Y";
        $LOCATION=""; 
    }
    else{

        // echo "N";
        $LOCATION = $_POST['location'];
    }
    // echo $LOCATION;
    

    // $DIVISION=$_POST['division'];

    $p_Bank_CODE=$_POST['bank'];

    $FROM_DATE = $_POST['form_date'];
    $TO_DATE = $_POST['last_date'];


    $p_SDATE=$FROM_DATE;
    $p_EDATE= $TO_DATE ;
    $p_ZONE_CODE=$ZONE;
    $p_CIRCLE_CODE=$CIRCLE;
    $p_location_code=$LOCATION;
    $p_report_level_CODE = $_POST['report'];

    
   



    // package starts 
    $curs = oci_new_cursor($conn);

    $stid = oci_parse($conn, "begin PKG_SELECT_SDA.dpd_dashboard(:cur_data,:p_SDATE,:p_EDATE,:p_ZONE_CODE,:p_CIRCLE_CODE,:p_location_code,:p_Bank_CODE,:p_report_level_CODE); end;");
   
   
    oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
    oci_bind_by_name($stid, ":p_SDATE", $p_SDATE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_EDATE", $p_EDATE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_ZONE_CODE", $p_ZONE_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_CIRCLE_CODE", $p_CIRCLE_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_location_code", $p_location_code, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_Bank_CODE", $p_Bank_CODE, -1, SQLT_CHR);
    oci_bind_by_name($stid, ":p_report_level_CODE", $p_report_level_CODE, -1, SQLT_CHR);
   

    // print_r($p_SDATE);
    // print_r($p_EDATE);
   oci_execute($stid);
   oci_execute($curs);
   
   $form_data = array();
   
   while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
   
       
     $form_data[]=$row;
     

   }

//    var_dump($form_data);
   

   $ZONE_TOTAL_BILL = "[";

   $ZONE_NB = "[";
   $ZONE_TAKA = "[";

   $REPORT_HEADER = $form_data[0]["REPORT_HDR"];


   for($i=0; $i<count($form_data); $i++){
       $ZONE_TAKA .= '"' . $form_data[$i]["TOT_COLL"] . '",';
       $ZONE_TOTAL_BILL .= '"' . $form_data[$i]["NO_OF_BILL"] . '",';

       $ZONE_NB .= '"' . $form_data[$i]["REPORT_X"] . '",';
   }
   
   
   $ZONE_TAKA = substr($ZONE_TAKA, 0, -1);
   $ZONE_TOTAL_BILL = substr($ZONE_TOTAL_BILL, 0, -1);

   $ZONE_NB = substr($ZONE_NB, 0, -1);
   
   $ZONE_TOTAL_BILL = $ZONE_TOTAL_BILL . ']';
   $ZONE_TAKA = $ZONE_TAKA . ']';
   $ZONE_NB= $ZONE_NB . ']';


  //  echo "N"."<br>";
  //  echo $ZONE_TOTAL_BILL ;
  //  echo $ZONE_NB ;
  //  echo $ZONE_TAKA ;
   
//    var_dump($form_data);
//    echo"<br>";
   // print json_encode($output);




$location_submit=1;



   
   oci_free_statement($stid);
   oci_free_statement($curs);
   
    // package ends 

    // circle ajax selected date show start

    $CIRCLE_AJX=$CIRCLE;
    $sql20="select CIRCLE_CODE, CIRCLE_DESC from DA_CIRCLE_MST where  CIRCLE_CODE=". $CIRCLE;
    $sql20_1="select CIRCLE_CODE,CIRCLE_DESC from DA_CIRCLE_MST where ZONE_CODE=".$ZONE;
    // print_r($sql20);
    
    $parseresults = ociparse($conn, $sql20);
    oci_execute($parseresults);


      
  
while ($crl = oci_fetch_assoc($parseresults)) {
    $CIRCLE_OUTPUT[] = $crl;
    
}
// var_dump($CIRCLE_OUTPUT);


$parseresults1 = ociparse($conn, $sql20_1);
oci_execute($parseresults1);


  

while ($crl_1 = oci_fetch_assoc($parseresults1)) {
$CIRCLE_OUTPUT_1[] = $crl_1;

}
// var_dump($CIRCLE_OUTPUT_1);

// echo "N <br>";

// echo count($CIRCLE_OUTPUT);



    // circle ajax selected date show end



     // location ajax selected date show start

     $LOCATION_AJX=$LOCATION;
     $sql21="select LOCATION_CODE, LOCATION_DESC from DA_LOCATION_MST where LOCATION_CODE='".$LOCATION."'";
     $sql21_1="select  LOCATION_CODE,LOCATION_DESC from DA_LOCATION_MST where CIRCLE_CODE=".$CIRCLE;
    
     
     // print_r($sql21);
     
     $parseresults = ociparse($conn, $sql21);
     oci_execute($parseresults);
 
 
       
   
 while ($loc = oci_fetch_assoc($parseresults)) {
     $LOCATION_OUTPUT[] = $loc;
     
 }
//  var_dump($LOCATION_OUTPUT);


 $parseresults2= ociparse($conn, $sql21_1);
 oci_execute($parseresults2);


   

while ($loc_1 = oci_fetch_assoc($parseresults2)) {
 $LOCATION_OUTPUT_1[] = $loc_1;
 
}
// var_dump($LOCATION_OUTPUT_1);


//  echo "N <br>";
 
//  echo count($LOCATION_OUTPUT);
//  echo ($LOCATION);
 
 
 
     // location ajax selected date show end
 
 


}


// echo $ZONE;
// echo "<br>";
// echo $CIRCLE;
// echo "<br>";

// echo $LOCATION;
// echo "<br>";


// echo $p_report_level_CODE;
// echo "<br>";
// echo $p_Bank_CODE;
// echo "<br>";
// echo $FROM_DATE;
// echo "<br>";
// echo $TO_DATE;




?>

<!-- submit end  -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dashboard</title>

    <link rel="icon" href="./img/SDA.png" type="image/ico">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="./stylenew.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">



    <!-- Chosen CSS File -->

    <link rel="stylesheet" href="chosen/css/chosen.css">

    <!-- Chosen CSS File -->

    <!-- data table print start css  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">

    <!-- data table print  css end  -->


    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

    <style>
    ::-webkit-scrollbar {
        width: 5px !important;
    }

    ::-webkit-scrollbar-thumb {
        background: #e1e1e1 !important;
        border-radius: 10px !important;
    }


  
    </style>

</head>

<body style="overflow-x: hidden; width: 100%;">

    <div class="wrapper" style="height:150vh">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img style="border-radius: 50%;" class="sidebar-logo-image" src="./img/logo.png" alt="logo">
                <!-- <h3 class="sidebar-logo-text">ই-আলাপন</h3> -->
            </div>

            <ul class="list-unstyled" id="list-unstyled">
                <!-- <p>Dummy Heading</p> -->
                <li>
                    <a class="nav-bar-actv-btn active-nav-bar-btn" href="#"><i class="fa fa-tachometer-alt"></i><span
                            style="margin-left: 8px;"></span>Dashboard</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="./reconcillation.php"><i class="fa fa-tablet"></i><span
                            style="margin-left: 8px;"></span>Reconciliation</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="./report.php"><i class="fa fa-building"></i><span
                            style="margin-left: 8px;"></span>Report</a>
                </li>
                <!-- <li>
                    <a class="nav-bar-actv-btn" th:href="@{/eBaarta}"><i class="fa fa-home"></i><span
                            style="margin-left: 8px;"></span>E-Barta</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" th:href="@{/notice}"><i class="fa fa-exclamation-triangle"></i><span
                            style="margin-left: 8px;"></span>Notice</a>
                </li> -->
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="bi bi-gear-wide"></i><span style="margin-left: 8px;"></span>Settings</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#"><i class="fa fa-random"></i><span style="margin-left: 8px;"></span>Communication
                                Type</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-comment"></i><span style="margin-left: 8px;"></span>Post</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-comments"></i><span style="margin-left: 8px;"></span>Post
                                Category</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users"></i><span style="margin-left: 8px;"></span>User</a>
                        </li>
                    </ul>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="bi bi-person-fill"></i><span style="margin-left: 8px;"></span>Admin</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#"><i class="fa fa-users"></i><span style="margin-left: 8px;"></span>User Type</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-universal-access"></i><span
                                    style="margin-left: 8px;"></span>User Grant</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="#"><i class="fa fa-sign-out-alt"></i><span
                            style="margin-left: 8px;"></span>Logout</a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <p style="margin: 5px auto;">Powered by</p>
                <h3 class="mb-4" style="margin: 5px auto;">It Bangla Ltd.</h3>
            </div>
        </nav>


        <!-- Page Content Holder -->
        <div id="content">
            <!-- PC navbar Start -->
            <nav class="navbar-pc navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <form action="" method="post">
                        <div class="row" style="margin: 20px 0px 10px 0px;">
                            <div class="col-lg-3 col-md-3 col-sm-12 date-select-reconclsn text-center">

                                <label for="">From : </label>
                                <select name="form_date" id="form_date" class="chooseDate">

                                    <option value="">Select Date</option>




                                    <?php
																for ($i = 0; $i < count($form_date); $i++) {

                                                                    echo '<option value=' . $form_date[$i]["PAY_DATE"] . ' ';
                                                                    if ($form_date[$i]["PAY_DATE"] == $FROM_DATE) {
                                                                        echo 'selected';
                                                                    }
                                                                    echo '>';
                                                                    echo '' . $form_date[$i]["PAY_DATE"]  . '</option>';

                                                                   
                                                                    
																	// echo "<option value='" . $form_date[$i]["PAY_DATE"] . "'>" . $form_date[$i]["PAY_DATE"] . " </option>";
                                                                    
}
                                                                
																?>

                                </select>

                            </div>



                            <!-- to starts  -->
                            <div class="col-lg-5 col-md-5 col-sm-12 zone-select-reconclsn text-center">

                                <label for="">To : </label>
                                <select name="last_date" id="l_date" class="chooseDate">

                                    <option value="">Select Date</option>

                                    <?php
                                                           for ($i = 0; $i < count($form_date); $i++) {
                                                            
                                                               echo "<option value='" . $form_date[$i]["PAY_DATE"] . "'>" . $form_date[$i]["PAY_DATE"] . "</option>";
                                                             
                                                               
}                                                      
                                                           
                                                           ?>


                                    <?php
																for ($i = 0; $i < count($form_date); $i++) {

                                                                    echo '<option value=' . $form_date[$i]["PAY_DATE"] . ' ';
                                                                    if ($form_date[$i]["PAY_DATE"] == $TO_DATE) {
                                                                        echo 'selected';
                                                                    }
                                                                    echo '>';
                                                                    echo '' . $form_date[$i]["PAY_DATE"]  . '</option>';

                                                                   
                                                                    
																	// echo "<option value='" . $form_date[$i]["PAY_DATE"] . "'>" . $form_date[$i]["PAY_DATE"] . " </option>";
                                                                    
}
                                                                
																?>




                                </select>

                            </div>

                            <!-- to ends  -->









                            <div class="col-lg-4 col-md-4 col-sm-12 bank-select-reconclsn text-center">

                                <label for="">Bank : </label>
                                <select name="bank" id="bank" class="chooseDate">

                                    <option value="">Select Bank</option>
                                    <?php 
                                
                                include "Connection.php";

                                $sql = "select BANK_CODE, BANK_NAME from DA_BANKS";
                                $parse = ociparse($conn, $sql);

                                oci_execute($parse);

                                while($row = oci_fetch_assoc($parse)){

                                    ?>
                                    <option value="<?php  echo $row['BANK_CODE']?>"
                                        <?php if($row['BANK_CODE'] == $p_Bank_CODE){ echo 'selected'; }  ?>>
                                        <?php echo $row['BANK_NAME'] ?></option>



                                    <?php
                                }

                                oci_free_statement($parse);

                                oci_close($conn);



                            
                            
                            ?>
                                </select>

                            </div>
                        </div>
                        <div class="row" style="margin: 20px 0px 10px 0px;">

                            <div class="col-lg-3 col-md-3 col-sm-12 date-select-reconclsn text-center">

                                <label for="">Zone : </label>
                                <select name="zone" id="zone">
                                    <option value="">Select Zone</option>


                                    <?php 

                                 include "Connection.php";
                                 $sql="select ZONE_CODE,ZONE_DESC from DA_ZONE_MST";
                                 $parseres = ociparse($conn, $sql);
                                 oci_execute($parseres);
                                 

                                 while($row= oci_fetch_assoc($parseres)){

                                ?>
                                    <option value="<?php  echo $row['ZONE_CODE']?>"
                                        <?php if($row['ZONE_CODE'] == $ZONE){ echo 'selected'; }  ?>>
                                        <?php echo $row['ZONE_DESC'] ?></option>

                                    <?php
                                 }

                                 oci_free_statement($parseres);

                                 oci_close($conn);
                                
                                ?>

                                </select>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 zone-select-reconclsn text-center">

                                <label for="">Circle : </label>

                                <select name="circle" id="circle">
                                <option value="">Select Circle</option>
                                    <?php 
                                
                                if(count($CIRCLE_OUTPUT)==1){

                                    for($i=0;$i<count($CIRCLE_OUTPUT_1);$i++){


                                   
                                    ?>
                                    <option  <?php if($CIRCLE_OUTPUT_1[$i]["CIRCLE_CODE"]==$CIRCLE_OUTPUT[0]["CIRCLE_CODE"]){echo "selected" ;}?> value="<?php echo $CIRCLE_OUTPUT_1[$i]["CIRCLE_CODE"]?>"><?php echo $CIRCLE_OUTPUT_1[$i]["CIRCLE_DESC"];?></option>
                                    <?php
                                     }
                                }
                                
                                
                                
                                
                                
                                ?>




                                 

                                </select>

                            </div>

                             


                            <div class="col-lg-4 col-md-4 col-sm-12 zone-select-reconclsn text-center">

                                        <label for="">Location : </label>
                                        <select name="location" id="location">
                                        <option value="">Select Location</option>
                                            <?php 

                                        if(count($LOCATION_OUTPUT)==1  || $LOCATION==""){

                                            for($i=0;$i<count($LOCATION_OUTPUT_1);$i++){
                                            ?>
                                           <option  <?php if($LOCATION_OUTPUT_1[$i]["LOCATION_CODE"]==$LOCATION_OUTPUT[0]["LOCATION_CODE"]){echo "selected" ;}?> value="<?php echo $LOCATION_OUTPUT_1[$i]["LOCATION_CODE"]?>"><?php echo $LOCATION_OUTPUT_1[$i]["LOCATION_DESC"];?></option>
                                            <?php
                                            }
                                        }
                                       




                                        ?>

                             




                                           

                                        </select>

                                        </div>


                            

                           
                        </div>
                        <div class="row text-left" style="margin: 20px 0px 10px 0px;">


                        <div class="col-lg-4 col-md-4 col-sm-12 bank-select-reconclsn cstm-txt-cntr-mbl">

<label for="">Report Level : </label>
<select name="report" id="report">
    <option value="">Select Report</option>


    <?php 

    include "Connection.php";

    $sql = " select REPORT_LEVEL_CODE,REPORT_LEVEL_DESC from DA_REPORT_LEVEL_MST";
    $parseres = ociparse($conn, $sql);

    oci_execute($parseres);

    while($row = oci_fetch_assoc($parseres)){

        ?>
    <option value="<?php  echo $row['REPORT_LEVEL_CODE']?>"
        <?php if($row['REPORT_LEVEL_CODE'] == $p_report_level_CODE){ echo 'selected'; }  ?>>
        <?php echo $row['REPORT_LEVEL_DESC'] ?></option>



    <?php
    }

    oci_free_statement($parseres);

    oci_close($conn);





?>


</select>

</div>

                        <div class="col-lg-5 col-md-5 col-sm-0"></div>


                            <div class="col-lg-3 col-md-3 col-sm-12 text-center cstm-mrgn-col-mbl" >
                                <input class="btn-submit-navbar button1" type="submit" name="submit" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </nav>

            <!-- PC navbar End -->



            <!-- Mobile Nav Bar Starts -->

            







            <!-- chart starts  -->

            <div class="container-fluid">


                <div class="row">
                    <!-- Bar1 -->
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?php echo $REPORT_HEADER; ?> Wise Tk
                                </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="overflow-x:auto; height: 300px">
                                    <canvas id="myBarChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- second graph start -->

                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?php echo $REPORT_HEADER; ?> Wise Bill
                                </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="overflow-x:auto; height: 300px">
                                    <canvas id="myBarChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- second graph end-->



                    <!-- Pie Chart 2 -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"> <?php echo $REPORT_HEADER; ?>  Wise
                                    Bill</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="overflow-x:auto; height: 300px">
                                    <!-- table starts  -->
                                    <a href="./dashboard_next.php?z=<?php echo $ZONE?>&c=<?php echo $CIRCLE?>&l=<?php echo $LOCATION?>&r=<?php echo $p_report_level_CODE?>&b=<?php echo $p_Bank_CODE?>&f=<?php echo $FROM_DATE?>&t=<?php echo $TO_DATE?>" class=" btn btn-warning" <?php if($location_submit==1 && $LOCATION!=""){ echo "style='pointer-events:auto;display:block;margin-bottom:5px'"; }else{echo "style='pointer-events:none;display:none;'";}?> >Print Detail</a>
                                    
                                    <table id="table_id" class="table display table-bordered margin-top:10px"
                                        style="margin: 0 auto; width:100%;border: 1px solid black;width: 100%;border-collapse: collapse;!important">
                                      
                                        <thead>
                                            <tr>
                                                <th><?php echo $REPORT_HEADER ;?></th>
                                                <th>No Of Transection</th>
                                                <th>Principle Amount</th>
                                                <th>Vat Amount</th>
                                                <th>Total Coll Amount</th>
                                                <th>Rev Stamp Amount</th>
                                                <th>Net Amount</th>
                                                


                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php 
				for($i=0;$i<count($form_data);$i++){
            
                // for($i=0; $i<count($output); $i++){

               ?>

                                            <tr>
                                                <td><?php echo $form_data[$i]['REPORT_X']; ?></td>
                                                <td><?php echo $form_data[$i]['NO_OF_BILL']; ?></td>
                                                <?php $tol_b_amount += $form_data[$i]['NO_OF_BILL'];   ?>
                                                
                                                <td><?php echo $form_data[$i]['PRINCIPAL_AMOUNT']; ?></td>
                                                <?php $tol_p_amount += $form_data[$i]['PRINCIPAL_AMOUNT'];   ?>
                                                
                                                <td><?php echo $form_data[$i]['VAT_AMOUNT']; ?></td>
                                                <?php $tol_v_amount += $form_data[$i]['VAT_AMOUNT'];   ?>
                                                <td><?php echo $form_data[$i]['TOT_COLL']; ?></td>
                                                <?php $tol_col += $form_data[$i]['TOT_COLL'];   ?>

                                                <td><?php echo $form_data[$i]['REVENUE_STAMP_AMOUNT']; ?></td>
                                                <?php $tol_r_amount += $form_data[$i]['REVENUE_STAMP_AMOUNT'];   ?>
                                                <td><?php echo $form_data[$i]['NET_PDB_AMOUNT']; ?></td>
                                                <?php $tol_n_amount += $form_data[$i]['NET_PDB_AMOUNT'];   ?>
                                               



                                            </tr>

                                            <?php
                }
            ?>

            <tr>
                <td class="font-weight-bold">Total</td>
                <td class="font-weight-bold"><?php echo $tol_b_amount; ?></td>
                <td class="font-weight-bold"><?php echo $tol_p_amount; ?></td>
                <td class="font-weight-bold"><?php echo $tol_v_amount; ?></td>
                <td class="font-weight-bold"><?php echo $tol_col; ?></td>
                <td class="font-weight-bold"><?php echo $tol_r_amount; ?></td>
                <td class="font-weight-bold"><?php echo $tol_n_amount; ?></td>
              
            </tr>


                                        </tbody>
                                    </table>
                                    <!-- table end  -->

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
               


                <!-- End of Main Content -->
            </div>





                    </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });
    });
    </script>




    <!-- Chosen JS File -->


    <script src="chosen/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="chosen/js/chosen.jquery.js" type="text/javascript"></script>
    <script>
    $(".chooseDate").chosen();
    </script>


    <!-- Chosen JS File -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js">
    </script>

    <!-- datatable script  start -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <!-- <script>
        $(document).ready( function () {
    $('#table_id').DataTable(
		{
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
 					columns: [ 0, 1, 2 ]
				}
            }
        ]
    } );
	
} );
    </script> -->

    <!-- 
<script>
        $(document).ready( function () {
    $('#table_id1').DataTable(
		{
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                exportOptions: {
 					columns: [ 0, 1, 2 ]
				}
            }
        ]
    } );
	
} );
    </script> -->


    <!-- datatable script  end -->



    <script>
    $(document).ready(function() {
        $('#custom-data-table').DataTable();
    });
    </script>

    <script>
    // Zone code cascading starts 
    $('#zone').on('change', function() {
        var zoneID = $(this).val();

        console.log(zoneID);
        if (zoneID) {
            $.ajax({
                type: 'POST',
                url: 'ajaxDataCascading_zon_crl.php',
                data: 'zon_id=' + zoneID,
                success: function(html) {
                    $('#circle').html(html);
                }
            });
        } else {
            $('#circle').html('<option value="">Select Zone first</option>');
        }
    });
    // Zone code cascading ends
    </script>

    <script>
    // Circle code cascading starts 
    $('#circle').on('change', function() {
        var circleID = $(this).val();

        // console.log(circle);
        if (circleID) {
            $.ajax({
                type: 'POST',
                url: 'ajaxDataCascading_crl_div.php',
                data: 'crl_id=' + circleID,
                success: function(html) {
                    $('#division').html(html);
                }
            });
        } else {
            $('#division').html('<option value="">Select division first</option>');
        }
    });
    // Circle code cascading ends
    </script>


      <!-- LOCATION SELETION WILL START  -->

        
    <script>
    // Circle code cascading starts 
    $('#circle').on('change', function() {
        var circleID = $(this).val();

        // console.log(circle);
        if (circleID) {
            $.ajax({
                type: 'POST',
                url: 'ajaxDataCascading_crl_loc.php',
                data: 'crl_id=' + circleID,
                success: function(html) {
                    $('#location').html(html);
                }
            });
        } else {
            $('#location').html('<option value="">Select Circle first</option>');
        }
    });
    // Circle code cascading ends
    </script>



      <!-- LOCATION SELETION WILL END  -->






    <!-- chart pluging starts  -->
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>





    <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    //var a = <?php echo "$ZONE_NB" ?>;
    //console.log(a);

    //var b = <?php echo "$ZONE_TOTAL_BILL" ?>;
    //console.log(b);



    headr = '<?php echo $REPORT_HEADER ;?>';

    console.log(headr);

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart4").getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo "$ZONE_NB" ?>,
            datasets: [{
                label: 'WARD Wise Bill',
                data: <?php echo "$ZONE_TOTAL_BILL" ?>,
                backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72',
                    '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00',
                    '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345',
                    '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360',
                    '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212',
                    '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251',
                    '#0B5345', '#186A3B', '#0000CC',
                ],
                borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Bill'
                    },

                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: headr
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>


    <!-- SELECT_PDB_AMOUNT_WISE start  -->






    <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';






    // Bar Chart Example
    var ctx = document.getElementById("myBarChart2").getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $ZONE_NB ?>,
            datasets: [{
                label: 'WARD Wise Bill',
                data: <?php echo $ZONE_TAKA ?>,
                backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72',
                    '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00',
                    '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345',
                    '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360',
                    '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212',
                    '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251',
                    '#0B5345', '#186A3B', '#0000CC',
                ],
                borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'TK'
                    },

                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: headr
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>



    <!-- SELECT_PDB_AMOUNT_WISE End  -->



    <!-- SELECT_BILL_NUMBER_DATE start  -->




    <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';






    // Bar Chart Example
    var ctx = document.getElementById("myBarChart3").getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo "$PAY_DATE" ?>,
            datasets: [{
                label: 'Date Wise Bill',
                data: <?php echo "$BILL_NUMBER" ?>,
                backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72',
                    '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00',
                    '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345',
                    '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360',
                    '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212',
                    '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251',
                    '#0B5345', '#186A3B', '#0000CC',
                ],
                borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Bill'
                    },

                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: headr
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        },

        
    });
    </script>







    <!-- SELECT_BILL_NUMBER_DATE start  -->





    <!-- SELECT_PDB_AMOUNT_DATE start  -->




    <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';





    // Bar Chart Example
    var ctx = document.getElementById("myPieChart1").getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo "$PAY_DATE" ?>,
            datasets: [{
                label: 'Date Wise Bill',
                data: <?php echo "$PDB_AMOUNT" ?>,
                backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72',
                    '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00',
                    '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345',
                    '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360',
                    '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212',
                    '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251',
                    '#0B5345', '#186A3B', '#0000CC',
                ],
                borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9',
                    '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673',
                    '#2e59d9', '#17a673'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: 'Tk'
                    },

                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: headr
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>



    <!-- SELECT_PDB_AMOUNT_DATE end  -->

    <!-- data table print start  -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
   <script>

var f = document.getElementById("form_date");
var f_date = f.options[f.selectedIndex].text;
console.log(f_date);
if(f_date === "Select Date"){
	f_date = "  ";
}
    var f1 = document.getElementById("l_date");
var l_date = f1.options[f1.selectedIndex].text;
console.log(l_date);
if(l_date === "Select Date"){
	l_date = "  ";
}

var f2 = document.getElementById("report");
var report = f2.options[f2.selectedIndex].text;
console.log(report);
if(report === "Select Report"){
	report = "  ";
}


var f3 = document.getElementById("zone");
var Zn = f3.options[f3.selectedIndex].text;
console.log(Zn);
if(Zn === "Select Zone"){
	Zn = "  ";
}

var f4 = document.getElementById("circle");
var Crl = f4.options[f4.selectedIndex].text;
console.log(Crl);
if(Crl === "Select Circle"){
	Crl = "  ";
}


var f6 = document.getElementById("location");
var loc = f6.options[f6.selectedIndex].text;
console.log(loc);
if(loc === "Select Location"){
	loc = "  ";
}

var f5 = document.getElementById("bank");
var Bnk = f5.options[f5.selectedIndex].text;
console.log(Bnk);
if(Bnk === "Select Bank"){
	Bnk = "  ";
}

var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today =  dd  + '/' +mm + '/' + yyyy;
// document.write(today);



    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        "searching": true,
        "paging": true,
        "bInfo" : false,
        "ordering": false,
        buttons: [{
                        extend: "excel",
                        className: 'btn btn-default'
                    },
                    
                    
        //             {
        //             extend: "print",
        //     text: 'Print Detail',
        //     action: function ( e, dt, node, config ) {
        //         window.location.href = 'http://localhost/sda/dashboard_next.php?z=<?php echo $ZONE?>&c=<?php echo $CIRCLE?>&r=<?php echo $p_report_level_CODE?>&b=<?php echo $p_Bank_CODE?>&f=<?php echo $FROM_DATE?>&t=<?php echo $TO_DATE?>'

        //     }
        // },
              
        

                    
                    {
                        extend: 'print',
                        text: 'Print summary',
                        orientation: 'landscape',
						pageSize: 'A4',
                        className: 'btn btn-default',
                        autoPrint: true,
                        title: '',

                        exportOptions: {
                            columns: ':visible',
                            stripHtml: false 
                        },
             
                        

                  
                       

                        messageTop:" <div class='row' style='margin-left:85%'><label style='margin-below:200px!important'>Date:</label><label style='margin-below:200px!important'>"+today+"</label></div><div class='row'><div class='col-12 '><h1 class='mt-5 text-center'>Bangladesh Power Distribution Board(BPDB)</h1></div></div><div class='row'><div class='col-2'><img style='margin-left:40px!important' src='./img/Logo.png' alt='' height='80px' width='80px'></div><div class='col-8 text-center'><h1>"+report+" wise Summary Report</h1><label style='font-weight:bold;'>Payment From: </label><label style='margin-right:10px'>"+ f_date +"</label><label style='font-weight:bold'>To:</label><label>"+ l_date +"</label></div><div class='col-2'><img style='margin-right:40px!important' src='./img/SDA.png' alt='' height='100px' width='100px'></div></div><div class='row'style='margin-top:20px;margin-bottom:5px;margin-left:1px;border: 1px solid black;width: 100%;border-collapse: collapse;'><div class='col-2 text-center'><label>Zone:</label><label>"+Zn+"</label></div><div class='col-4'><label>Circle:</label><label>"+Crl+"</label></div><div class='col-3 text-center'><label>Location:</label><label>"+loc+"</label></div><div class='col-3'><label>Bank:</label><label>"+Bnk+"</label></div></div></div>"
                    }

            
            
        ]
        
    } );
    </script>


    <!-- data table print start  -->



</body>

</html>