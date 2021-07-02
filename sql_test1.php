








<?php



error_reporting(0);
set_time_limit(1000);
include "Connection.php";

$ZONE = "";
$CIRCLE = "";

$FROM_DATE = "";
$TO_DATE = "";
// $DIVISION = "";

$sql1 = "SELECT * FROM DA_ZONE_MST";
$parse = ociparse($conn, $sql1);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $zone[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);


$sql2 = "SELECT * FROM DA_CIRCLE_MST";
$parse = ociparse($conn, $sql2);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $circle[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);


$sql2 = "SELECT * FROM DA_CIRCLE_MST";
$parse = ociparse($conn, $sql2);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
    $circle[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);




if (isset($_POST['submit'])) {

    $ZONE = $_POST['zone'];
    $CIRCLE = $_POST['circle'];
}





?>


<!-- date from database starts  -->
<?php

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
<!-- date from database end  -->










<?php 

error_reporting(0);
include "Connection.php";


///////////////////////////////////////////////////////////////////////
$sql = "select pay_date n from (select distinct pay_date from da_payment_mst order by pay_date desc)   where rownum=1";


$parseresults = ociparse($conn, $sql);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $current_date = $row["N"];
}

oci_free_statement($parseresults);


// echo "Last Date in database :";
// echo $current_date;
// echo "<br>";
/////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
$sql1 = "SELECT LAST_DAY(ADD_MONTHS(TO_DATE('". $current_date. "'),-1)) N from dual";



$parseresults = ociparse($conn, $sql1);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $last_date = $row["N"];
}

oci_free_statement($parseresults);


// echo "Last date of previous month from last database date :";
// echo $last_date;
// echo "<br>";



////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////

$sql2 = "  select dt 
from
(select  (TRUNC (last_day(TO_DATE('". $last_date ."')) - ROWNUM) + 1) dt from dual connect by rownum<32) order by dt asc";


// print_r($sql2);
// $sql2 = ""


$parseresults = ociparse($conn, $sql2);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $month_date[] = $row;
}

oci_free_statement($parseresults);


// echo "Previous Month Days :"."<br>";
// var_dump($month_date);

// echo count($month_date);

// for($i=0; $i<count($month_date); $i++){
//     echo $month_date[$i]["DT"]."<br>";
// }

///////////////////////////////////////////////////

$sql3 = "select trunc(to_date('". $last_date ."'), 'MM') N from dual";

// print_r($sql3);


$parseresults = ociparse($conn, $sql3);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $first_date = $row["N"];
}

oci_free_statement($parseresults);

// echo "First Date of previous Month :".$first_date."<br>";


$next = $first_date;


// $sql4 = "SELECT TO_DATE('". $next. "' ) + 1 tomorrow FROM DUAL";

// // print_r($sql4);

// $parseresults = ociparse($conn, $sql4);
// oci_execute($parseresults);

// while($row = oci_fetch_assoc($parseresults)){

//     $NEXT_date = $row["TOMORROW"];
// }


// oci_free_statement($parseresults);
// $next = $NEXT_date;

// echo "Next Date :". $NEXT_date;

// if($first_date == $first_date){
//     echo "OK";
// }



$next = $first_date;

$sql5= "select  sum ( TOTAL_PDB_AMOUNT ) as n from DA_PAYMENT_MST where PAY_DATE='".$next."'" ;

// print_r($sql3);


$parseresults = ociparse($conn, $sql5);
oci_execute($parseresults);

$DATE_AXES = '["'. $first_date. '"'.', ';

// echo $DATE_AXES;

while($row = oci_fetch_assoc($parseresults)){

    $bill[] = $row;
}

oci_free_statement($parseresults);



do {

    $sql4 = "SELECT TO_DATE('". $next. "' ) + 1 tomorrow FROM DUAL";

    $parseresults = ociparse($conn, $sql4);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NEXT_date = $row["TOMORROW"];
}

oci_free_statement($parseresults);




$next = $NEXT_date;

$BILL_AXES .= '"' . $bill[$i]["N"] . '",';

$DATE_AXES.='"'.$next.'",'; 



$sql6="select sum ( TOTAL_PDB_AMOUNT ) as n from DA_PAYMENT_MST where PAY_DATE='". $next."'";

// print_r($sql3);


$parseresults = ociparse($conn, $sql6);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $bill[] = $row;
}

oci_free_statement($parseresults);



// echo $first_date;

$sql7="SELECT COUNT( BILL_NUMBER ) FROM DA_PAYMENT_DTL WHERE BATCH_NO IN (select BATCH_NO  FROM DA_PAYMENT_MST WHERE PAY_DATE='". $first_date."')";
$parseresults = ociparse($conn, $sql7);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NO_OF_BILL[] = $row;
}

oci_free_statement($parseresults);


do {

    $sql4 = "SELECT TO_DATE('". $next. "' ) + 1 tomorrow FROM DUAL";

    $parseresults = ociparse($conn, $sql4);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NEXT_date = $row["TOMORROW"];
}

var_dump($NO_OF_BILL);
oci_free_statement($parseresults);


$next = $NEXT_date;


$sql8="SELECT COUNT( BILL_NUMBER ) as M FROM  DA_PAYMENT_DTL WHERE BATCH_NO IN (select BATCH_NO  FROM DA_PAYMENT_MST WHERE PAY_DATE='". $next."')";

print_r($sql8);


$parseresults = ociparse($conn, $sql8);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NO_OF_BILL[] = $row;
}
var_dump($NO_OF_BILL);
oci_free_statement($parseresults);






// echo "Next Date :". $next. "<br>";

if($next == $last_date){
break;
}
    
  } while ($next <= $last_date);

 
//   var_dump($bill);



  
  
  oci_close($conn);

  $BILL_AXES = "[";


  for($i=0; $i<count($bill); $i++){
      $BILL_AXES .= '"' . $bill[$i]["N"] . '",';
      // echo $ZONE_TOTAL."<br>";
    //   $DATE_AXES .= '"' . $next[$i]["N"] . '",';
      // echo $ZONE_N."<br>";
  }

  


  




  $BILL_AXES = substr($BILL_AXES, 0, -1);
$DATE_AXES = substr($DATE_AXES, 0, -1);

$BILL_AXES = $BILL_AXES . ']';
$DATE_AXES = $DATE_AXES . ']';

//   echo ($BILL_AXES);
//   echo ($DATE_AXES);




echo $NO_OF_BILL;
echo "<br>";
echo count($NO_OF_BILL);

// $NO_OF_BILL_AXES = "[";


// for($i=0; $i<count($NO_OF_BILL); $i++){
//     echo $i."->". $NO_OF_BILL_AXES. "<br>";
//     $NO_OF_BILL_AXES .= '"' . $NO_OF_BILL[$i]['M'] . '",';
    
// }




  


// echo "N";
// echo $NO_OF_BILL_AXES;

// $NO_OF_BILL_AXES = substr($NO_OF_BILL_AXES, 0, -1);
// $DATE_AXES = substr($DATE_AXES, 0, -1);

// $NO_OF_BILL_AXES = $NO_OF_BILL_AXES . ']';
// $DATE_AXES = $DATE_AXES . ']';

//   echo ($NO_OF_BILL_AXES);
//   echo ($DATE_AXES);








?> 

















<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dashboard1</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="./style1.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Chosen CSS File -->

    <link rel="stylesheet" href="chosen/css/chosen.css">
    
    <!-- Chosen CSS File -->

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

</head>

<body style="overflow-x: hidden; width: 100%;">

    <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img style="border-radius: 50%;" class="sidebar-logo-image" src="./img/logo.png" alt="logo">
                <!-- <h3 class="sidebar-logo-text">ই-আলাপন</h3> -->
            </div>

            <ul class="list-unstyled" id="list-unstyled">
                <!-- <p>Dummy Heading</p> -->
                <li>
                    <a class="nav-bar-actv-btn active-nav-bar-btn" href="#"><i class="fa fa-tachometer-alt"></i><span style="margin-left: 8px;"></span>Dashboard</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="./reconcillation.php"><i class="fa fa-tablet"></i><span style="margin-left: 8px;"></span>Reconciliation</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="./report.php"><i class="fa fa-building"></i><span style="margin-left: 8px;"></span>Report</a>
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
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="bi bi-gear-wide"></i><span style="margin-left: 8px;"></span>Settings</a>
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
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="bi bi-person-fill"></i><span style="margin-left: 8px;"></span>Admin</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#"><i class="fa fa-users"></i><span style="margin-left: 8px;"></span>User Type</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-universal-access"></i><span style="margin-left: 8px;"></span>User Grant</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="#"><i class="fa fa-sign-out-alt"></i><span style="margin-left: 8px;"></span>Logout</a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <p style="margin: 5px auto;">Powered by</p>
                <h3 style="margin: 5px auto;">It Bangla Ltd.</h3>
            </div>
        </nav>

        <!-- Page Content Holder -->
        <div id="content">
         <!-- PC navbar Start -->
        <nav class="navbar-pc navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <form action="">
                    <div class="row" style="margin: 20px 0px 10px 0px;">
                        <div class="col-3 date-select-reconclsn text-center">
                           
                                <label for="">From : </label>
                                <select name="form_date" id="form_date" class="chooseDate">

																<option value="">Select Date</option>
																
																<?php
																for ($i = 0; $i < count($form_date); $i++) {
                                                                    
																	echo "<option value='" . $form_date[$i]["PAY_DATE"] . "'>" . $form_date[$i]["PAY_DATE"] . "</option>";
}
                                                                
																?>
                                    
                                </select>
                            
                        </div>
                        <div class="col-5 zone-select-reconclsn text-center">
                            
                                <label for="">To : </label>
																<select name="last_date" id="last_date" class="chooseDate">

																<option value="">Select Date</option>
																
																<?php
																for ($i = 0; $i < count($last_date); $i++) {
                                                                    
																	echo "<option value='" . $last_date[$i]["PAY_DATE"] . "'>" . $last_date[$i]["PAY_DATE"] . "</option>";
}
                                                                
																?>
                                    
                                </select>
																
                        </div>
                        <div class="col-4 bank-select-reconclsn text-center">
                           
                                <label for="">Bank : </label>
                                <select name="bank" id="bank" class="chooseDate">
                                    <option value="">DBBL</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            
                        </div>
                    </div>
                    <div class="row" style="margin: 20px 0px 10px 0px;">
                        <div class="col-3 date-select-reconclsn text-center">
                            
                                <label for="">Zone : </label>
                                <select name="zone" id="zone">
                                <option value="">Select Zone</option>
																
																<?php
																for ($i = 0; $i < count($zone); $i++) {
                                                                    
													echo "<option value='" . $zone[$i]["ZONE_CODE"] . "'>" . $zone[$i]["ZONE_DESC"] . "</option>";
															}
																															
															?>
                                </select>
                            
                        </div>
                        <div class="col-5 zone-select-reconclsn text-center">
                            
                                <label for="">Circle : </label>
                                <select name="circle" id="circle">
                                <option value="">Select Circle</option>

                                </select>
                            
                        </div>
                        <div class="col-4 bank-select-reconclsn text-center">
                            
                                <label for="">Division : </label>
                                <select name="division" id="division">
                                <option value="">Select Division</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            
                        </div>
                    </div>
                    <div class="row text-right" style="margin: 20px 0px 10px 0px;">
                        <div class="col-11">
                            <input class="btn-submit-navbar button1" type="submit" value="Submit">
                        </div>
                    </div>
                    </form>
                </div>
            </nav>

             <!-- PC navbar End -->





            <!-- Mobile Nav Bar Starts -->

            <nav class="navbar-mobile navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="btn-sidebarCollapse-div">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
                <form action="">
                <div class="row" style="margin: 30px 0px 10px 0px;">
                    <div class="col-12 date-select-reconclsn text-center">
                        
                            <label for="">From : </label>
                            <select name="form_date" id="form_date1">

																<option value="">Select Date</option>
																
																<?php
																for ($i = 0; $i < count($form_date); $i++) {
                                                                    
																	echo "<option value='" . $form_date[$i]["PAY_DATE"] . "'>" . $form_date[$i]["PAY_DATE"] . "</option>";
}
                                                                
																?>
                                    
                                </select>
                        
                    </div>
                    <div class="col-12 zone-select-reconclsn text-center">
                        
                            <label for="">To : </label>
																		<select name="last_date" id="last_date1">

																		<option value="">Select Date</option>

																		<?php
																		for ($i = 0; $i < count($last_date); $i++) {
																																				
																			echo "<option value='" . $last_date[$i]["PAY_DATE"] . "'>" . $last_date[$i]["PAY_DATE"] . "</option>";
																		}
																																		
																		?>
																				
																		</select>
                        
                    </div>
                    <div class="col-12 bank-select-reconclsn text-center">
                        
                            <label for="">Bank : </label>
                            <select name="bank1" id="bank1">
                                <option value="">DBBL</option>
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        
                    </div>
                </div>
                <div class="row" style="margin: 30px 0px 10px 0px;">
                    <div class="col-12 date-select-reconclsn text-center">
                        
                    <label for="">Zone : </label>
                                <select name="zone" id="zone1">
                                <option value="">Select Zone</option>
																
																<?php
																for ($i = 0; $i < count($zone); $i++) {
                                                                    
																echo "<option value='" . $zone[$i]["ZONE_CODE"] . "'>" . $zone[$i]["ZONE_DESC"] . "</option>";
																}
                                                                
																?>
                                </select>
                        
                    </div>
                    <div class="col-12 zone-select-reconclsn text-center">
                        
                    <label for="">Circle : </label>
                                <select name="circle" id="circle1">
                                <option value="">Select Circle</option>

                            
                                <!-- <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option> -->
                            </select>
                        
                    </div>
                    <div class="col-12 bank-select-reconclsn text-center">
                    <label for="">Division : </label>
                                <select name="division1" id="division1">
                                <option value="">Select Division</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                        
                    </div>
                </div>
                <div class="row text-center" style="margin: 30px 0px 10px 0px;">
                    <div class="col-11">
                        <input class="btn-submit-navbar" type="submit" name="submit" value="Submit">
                    </div>
                </div>
                </form>
            </nav>

            <!-- Mobile Nav Bar End -->








            <!-- chart starts  -->

            <div class="container-fluid">


                <div class="row">
                    <!-- Bar1 -->
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Tk Wise</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myBarChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Pie Chart 2 -->
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Bill Wise</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Bar Chart  -->
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Date Wise Tk</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myBarChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bar2 -->
                    <div class="col-xl-6 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"> Date Wise Bill </h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myBarChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Bar2 -->
                </div>


                <!-- End of Main Content -->
            </div>
            <!-- chart ends  -->


        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

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
        // mobile Zone code cascading starts 
        $('#zone1').on('change', function() {
            var zoneID = $(this).val();

            console.log(zoneID);
            if (zoneID) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxDataCascading_zon_crl.php',
                    data: 'zon_id=' + zoneID,
                    success: function(html) {
                        $('#circle1').html(html);
                    }
                });
            } else {
                $('#circle1').html('<option value="">Select Zone first</option>');
            }
        });
        // mobile Zone code cascading ends
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


    
<script>
        // mobile Circle code cascading starts 
        $('#circle1').on('change', function() {
            var circleID = $(this).val();

            // console.log(circle);
            if (circleID) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxDataCascading_crl_div.php',
                    data: 'crl_id=' + circleID,
                    success: function(html) {
                        $('#division1').html(html);
                    }
                });
            } else {
                $('#division1').html('<option value="">Select division first</option>');
            }
        });
        // mobile Circle code cascading ends
    </script>







    <!-- chart pluging starts  -->



    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>



    <?php

    include "Connection.php";

    $sql = "SELECT ZONE_DESC, ZONE_CODE FROM DA_ZONE_MST";

    $parseresults = ociparse($conn, $sql);
    oci_execute($parseresults);

    while ($row = oci_fetch_assoc($parseresults)) {
        $ZONE[] = $row;
        $ZONE_NAME[] = $row["ZONE_DESC"];
    }

    // ZONE NAME VALUE 
    // var_dump($ZONE_NAME);
    oci_free_statement($parseresults);

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

   $sql3="SELECT TRUNC(LAST_DAY('".$last_date."'),'mm') AS FRIST_DATE FROM DUAL";
   

   $parseresults = ociparse($conn, $sql3);
   oci_execute($parseresults);

   
   while ($row = oci_fetch_assoc($parseresults)) {
    $output3[] = $row;
}

// var_dump($output3);

$frist_date = $output3[0]["FRIST_DATE"];


    for ($i = 0; $i < count($ZONE); $i++) {

        $sql2 = "SELECT SUM(N) AS N FROM (SELECT LOCATION_CODE, SUM(TOTAL_PDB_AMOUNT) AS N FROM DA_PAYMENT_MST WHERE LOCATION_CODE IN (SELECT LOCATION_CODE FROM DA_LOCATION_MST WHERE ZONE_CODE = '" . $ZONE[$i]["ZONE_CODE"] . "') AND PAY_DATE >='".$frist_date ."' AND  PAY_DATE <= '".$last_date ."' GROUP BY LOCATION_CODE ORDER BY LOCATION_CODE)";


				$sql3 = "
				SELECT COUNT(A)  AS M FROM (SELECT  COUNT(BILL_NUMBER) AS A FROM DA_PAYMENT_DTL WHERE BATCH_NO IN ( 
				SELECT DA_PAYMENT_MST.BATCH_NO FROM DA_PAYMENT_MST,DA_LOCATION_MST
				 WHERE DA_PAYMENT_MST.LOCATION_CODE=DA_LOCATION_MST.LOCATION_CODE AND DA_LOCATION_MST.ZONE_CODE='" . $ZONE[$i]["ZONE_CODE"] . "' AND
				 DA_PAYMENT_MST.PAY_DATE  >= '". $frist_date."' AND DA_PAYMENT_MST.PAY_DATE <= '". $last_date ."') GROUP BY BATCH_NO ORDER BY
				BATCH_NO DESC)
				";

					// print_r($sql3);
					echo "<br>";

        $parseresults = ociparse($conn, $sql2);
        oci_execute($parseresults);
        $parseresult = ociparse($conn, $sql3);
        oci_execute($parseresult);

				// total amount starts 
        while ($row = oci_fetch_assoc($parseresults)) {
            $output[] = $row;


        }
				// var_dump($output);
				// total amount ends 

				// total bill starts 
        while ($row = oci_fetch_assoc($parseresult)) {
					$out[] = $row;
			}
			// var_dump($out);
			// total bill ends 


        
        if ($output[$i]["N"] == NULL) {

            // echo "Ok";
            $SUM[$i] = 0;
        } else {
            // echo "test";
            $SUM[$i] = $output[$i]["N"];
        }




        // TOTAL_SUM VALUE 

        // total bill number starts
        
        if($out[$i]["M"] == NULL){
            $TOTAL[$i] = 0;
        }else{
            $TOTAL[$i] = $out[$i]["M"];
        }
        
        // total bill number ends
        // var_dump($SUM);
        // var_dump($TOTAL);

        // break;

        oci_free_statement($parseresults);
    }
    echo "<br>"; 



    // echo $SUM;
    // for($i=0;$i<count($SUM); $i++){
    //     // echo $SUM[$i]."<br>";
    // }
    oci_close($conn);

    $ZONE_TOTAL = "[";
    $ZONE_N = "[";

    for($i=0; $i<count($SUM); $i++){
        $ZONE_TOTAL .= '"' . $SUM[$i] . '",';
        // echo $ZONE_TOTAL."<br>";
        $ZONE_N .= '"' . $ZONE_NAME[$i] . '",';
        // echo $ZONE_N."<br>";
    }

    $ZONE_TOTAL = substr($ZONE_TOTAL, 0, -1);
  $ZONE_N = substr($ZONE_N, 0, -1);

  $ZONE_TOTAL = $ZONE_TOTAL . ']';
  $ZONE_N = $ZONE_N . ']';

//   echo ($ZONE_TOTAL);
//   echo ($ZONE_N);


// total bill set in variable starts
$ZONE_TOTAL_BILL = "[";
// $ZONE_M = "[";

for($i=0; $i<count($TOTAL); $i++){
    $ZONE_TOTAL_BILL .= '"' . $TOTAL[$i] . '",';
    // echo $ZONE_TOTAL."<br>";
    // $ZONE_N .= '"' . $ZONE_NAME[$i] . '",';
    // echo $ZONE_N."<br>";
}

$ZONE_TOTAL_BILL = substr($ZONE_TOTAL_BILL, 0, -1);
// $ZONE_N = substr($ZONE_N, 0, -1);

$ZONE_TOTAL_BILL = $ZONE_TOTAL_BILL . ']';
// $ZONE_N = $ZONE_N . ']'; 
// total bill set in variable ends



    ?>


<script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';



    

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart2").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$ZONE_N" ?>,
        datasets: [{
          label: 'WARD Wise Bill',
          data: <?php echo "$ZONE_TOTAL" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
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
            labelString: 'zone'
          },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
 
  </script>

  <!-- GRAPH OF ZONE TOTAL AMOUNT ENDS -->


  <!-- GRAPH OF ZONE TOTAL BILL STARTS -->


  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';



    

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$ZONE_N" ?>,
        datasets: [{
          label: 'WARD Wise Bill',
          data: <?php echo "$ZONE_TOTAL_BILL" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
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
            labelString: 'No. of bills'
          },
            ticks: {
              beginAtZero: true
            }
          }],

          xAxes: [{
        scaleLabel: {
            display: true,
            labelString: 'zone'
          },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
 
  </script>


  <!-- GRAPH OF ZONE TOTAL BILL ENDS -->



  
  <!-- GRAPH OF Date TOTAL BILL STARTS -->


  <script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';



    

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart3").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$DATE_AXES" ?>,
        datasets: [{
          label: 'Date Wise TK',
          data: <?php echo "$BILL_AXES" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
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
            labelString: 'Date'
          },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
 
  </script>


  <!-- GRAPH OF Date TOTAL BILL ENDS -->



  <!-- GRAPH OF Date TOTAL No Of BILL STARTS -->


  <script type="text/javascript"> 
    // Set new default font family and font color to mimic Bootstrap's default styling
    // Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    // Chart.defaults.global.defaultFontColor = '#858796';



    

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart3").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$DATE_AXES" ?>,
        datasets: [{
          label: 'Date Wise TK',
          data: <?php echo "$NO_OF_BILL_AXES" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
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
            labelString: 'No Of Bill'
          },
            ticks: {
              beginAtZero: true
            }
          }],

          xAxes: [{
        scaleLabel: {
            display: true,
            labelString: 'Date'
          },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
 
   </script>


  <!-- GRAPH OF Date  No Of BILL ENDS -->









<script type="text/javascript">
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';



    

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo "$ZONE_N" ?>,
        datasets: [{
          label: 'WARD Wise Bill',
          data: <?php echo "$ZONE_TOTAL_BILL" ?>,
          backgroundColor: ['#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', '#641E16', '#78281F', '#512E5F', '#4A235A', '#154360', '#1B4F72', '#0E6251', '#0B5345', '#145A32', '#186A3B', '#7D6608', '#784212', '#6E2C00', '#B71C1C', '#880E4F', '#4A148C', '#0D47A1', '#01579B', '#0E6251', '#0B5345', '#186A3B', '#0000CC', ],
          borderColor: ['#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673', '#2e59d9', '#17a673'],
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
            labelString: 'No. of bills'
          },
            ticks: {
              beginAtZero: true
            }
          }],

          xAxes: [{
        scaleLabel: {
            display: true,
            labelString: 'zone'
          },
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
 
  </script>


  <!-- GRAPH OF ZONE TOTAL BILL ENDS -->





<!-- Chosen JS File -->


<script src="chosen/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="chosen/js/chosen.jquery.js" type="text/javascript"></script>
    <script>
        $(".chooseDate").chosen();
    </script>


    <!-- Chosen JS File -->






</body>

</html>