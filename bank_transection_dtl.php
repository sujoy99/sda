<?php

include "Connection.php";

// $p_TR_CODE=NULL;
$p_Bank_CODE =NULL;
$p_TR_DATE=NULL;
$p_TR_NO=NULL;
$p_bank_tr_CODE=NULL;
$p_tr_CODE=NULL;

$p_DB_AMOUNT=NULL;
$p_CR_AMOUNT=NULL;

$p_trans_ID=NULL;


$flag=0;




if (isset($_GET["id"]) && $_GET["id"]!=""){
    $flag=1;

    $id=$_GET["id"];

    $sql7="SELECT TRANS_DTL_ID,BANK_CODE,TR_DATE,BANK_TRANS_NO,BANK_TR_CODE,TR_CODE,DB_AMOUNT,CR_AMOUNT,TRANS_ID FROM DA_BANK_TRANS_DTL where TRANS_DTL_ID= ". $id;


    $parse7=oci_parse($conn,$sql7);

    
    oci_execute($parse7);

    while ($row7 = oci_fetch_assoc($parse7)) {
        $p_Bank_CODE =$row7["BANK_CODE"];
        $p_TR_DATE=$row7["TR_DATE"];
        $p_TR_NO=$row7["BANK_TRANS_NO"];
        $p_bank_tr_CODE=$row7["BANK_TR_CODE"];
        $p_tr_CODE=$row7["TR_CODE"];

        
        $p_DB_AMOUNT=$row7["DB_AMOUNT"];
        $p_CR_AMOUNT=$row7["CR_AMOUNT"];
        $p_trans_ID=$row7["TRANS_ID"];

        $date=date_create($p_TR_DATE);
        $p_TR_DATE = date_format($date,"Y-m-d");

        
    
    // var_dump($form_data);
    
    }
    


    oci_free_statement($parse7);

  


}


if (isset($_POST['submit'])){

    $bank_code=$_POST['bank_code'];
    $tr_date=$_POST['tr_date'];
    $tr_no=$_POST['tr_no'];
    $b_tr_code=$_POST['b_tr_code'];

    $tr_code=$_POST['tr_code'];
    $db_amount=$_POST['db_amount'];
    $cr_amount=$_POST['cr_amount'];
    $transection_id=$_POST['transection_id'];
    
    // echo $bank_code;
    // echo $tr_date;
    // echo $tr_no;
    // echo $b_tr_code;
    // echo $tr_code;
    // echo $db_amount;
    // echo $cr_amount;
    // echo $transection_id;
    
    
    
    $sql="INSERT INTO DA_BANK_TRANS_DTL(TRANS_DTL_ID,BANK_CODE,TR_DATE,BANK_TRANS_NO,BANK_TR_CODE,TR_CODE,DB_AMOUNT,CR_AMOUNT,TRANS_ID) VALUES (SEQ_B_T_DTL.NEXTVAL, '".$bank_code."',  TO_DATE('".$tr_date."', 'YYYY-MM-DD'), '".$tr_no."','".$b_tr_code."','".$tr_code."',".$db_amount.",".$cr_amount.",".$transection_id.")";
    
    // print_r($sql);

                                                                                                    // echo $bank_code;
                                                                                                    // echo $tr_date;
                                                                                                    // echo $tr_no;
                                                                                                    // echo $b_tr_code;
                                                                                                    // echo $tr_code;
                                                                                                    // echo $db_amount;
                                                                                                    // echo $cr_amount;
                                                                                                    // echo $transection_id;

    $parse=oci_parse($conn,$sql);

    
    oci_execute($parse);
    oci_free_statement($parse);

}



if (isset($_POST['edit'])){


    $bank_code=$_POST['bank_code'];
    $tr_date=$_POST['tr_date'];
    $tr_no=$_POST['tr_no'];
    $b_tr_code=$_POST['b_tr_code'];

    $tr_code=$_POST['tr_code'];
    $db_amount=$_POST['db_amount'];
    $cr_amount=$_POST['cr_amount'];
    $transection_id=$_POST['transection_id'];

    $sql2="UPDATE  DA_BANK_TRANS_DTL SET BANK_CODE='".$bank_code."',TR_DATE=TO_DATE('".$tr_date."', 'YYYY-MM-DD'),BANK_TRANS_NO='".$tr_no."',BANK_TR_CODE='".$b_tr_code."',DB_AMOUNT=".$db_amount.",CR_AMOUNT=".$cr_amount.",TRANS_ID=".$transection_id." WHERE TRANS_DTL_ID='".$id."'";

    $parse2=oci_parse($conn,$sql2);

oci_execute($parse2);
oci_free_statement($parse2);

header("location:bank_transection_dtl.php");

}



if (isset($_POST['delete'])){

    $bank_code=$_POST['bank_code'];
    $tr_date=$_POST['tr_date'];
    $tr_no=$_POST['tr_no'];
    $b_tr_code=$_POST['b_tr_code'];

    $tr_code=$_POST['tr_code'];
    $db_amount=$_POST['db_amount'];
    $cr_amount=$_POST['cr_amount'];
    $transection_id=$_POST['transection_id'];

    $sql3="DELETE  FROM DA_BANK_TRANS_DTL WHERE TRANS_DTL_ID='".$id."' ";

    $parse3=oci_parse($conn,$sql3);

oci_execute($parse3);
oci_free_statement($parse3);

header("location:bank_transection_dtl.php");

}





$sql4="SELECT TRANS_DTL_ID,DA_BANKS.BANK_NAME,TR_DATE, BANK_TRANS_NO,DA_TR_CODE_MAP.BANK_TR_DESC,DA_TR_CODE_MST.TR_DESC,DB_AMOUNT,CR_AMOUNT,DA_BANK_TRANS_MST.TRANS_ID FROM DA_BANK_TRANS_DTL,DA_BANK_TRANS_MST, DA_BANKS,DA_TR_CODE_MAP,DA_TR_CODE_MST
WHERE DA_BANK_TRANS_DTL.BANK_CODE = DA_BANKS.BANK_CODE and DA_BANK_TRANS_DTL.BANK_TR_CODE=DA_TR_CODE_MAP.BANK_TR_CODE and DA_BANK_TRANS_DTL.TR_CODE=DA_TR_CODE_MST.TR_CODE 
and DA_BANK_TRANS_DTL.TRANS_ID=DA_BANK_TRANS_MST.TRANS_ID";


$parse4=oci_parse($conn,$sql4);

oci_execute($parse4);
while ($row = oci_fetch_assoc($parse4)) {
 
    $form_data[] = $row;

// var_dump($form_data);

}

oci_free_statement($parse4);






    // package starts 
//     $curs = oci_new_cursor($conn);

//     $stid = oci_parse($conn, "begin SETTING_DATA_PKG.SDA_TR_MAP_LIST(:cur_data); end;");
   
   
//     oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);
 
   

//     // print_r($p_SDATE);
//     // print_r($p_EDATE);
//    oci_execute($stid);
//    oci_execute($curs);
   
   
//    while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
   
       
//      $form_data[]=$row;

// var_dump($form_data);



// }










?>










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
                            <a href="#"><i class="fa fa-random"></i><span style="margin-left: 8px;"></span>Bill Cycle
                            </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-comment"></i><span style="margin-left: 8px;"></span>Transection</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-comments"></i><span style="margin-left: 8px;"></span>Bank
                                </a>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-users"></i><span style="margin-left: 8px;"></span>User</a>
                        </li> -->
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
            <nav class="navbar-pc navbar-expand-lg navbar-light"style="height:220px">
                <div class="container-fluid ">
                  

                <form  action="" method="post">



                
                <div class="row">

                <div class="col-lg-3 col-md-3 col-sm-12 ">
               


    <label for="text" class="text-center " >Bank Code:</label>
    <!-- <input type="text" class="form-control" name="transection_code" id="transection_code" value="<?php echo $p_TR_CODE ?>"> -->

                            <select name="bank_code" id="bank_code" >

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


                <div class="col-lg-3 col-md-3 col-sm-12">

                <label for="text"> Transection Date:</label>
    <input type="date" class="form-control" name="tr_date" id="tr_date" value="<?php echo $p_TR_DATE ?>">
      


                </div>


                <div class="col-lg-3 col-md-3 col-sm-12">
                <label for="text">Bank Transection No:</label>
    <input type="text" class="form-control" name="tr_no" id="tr_no" value="<?php echo $p_TR_NO ?>">
      
                
                </div>


                <div class="col-lg-3 col-md-3 col-sm-12">
                
                
                <label for="text">Bank Transection Code:</label>
    <!-- <input type="text" class="form-control" name="total_db_amount" id="total_db_amount" value="<?php echo $p_DB_AMOUNT ?>"> -->


                            <select name="b_tr_code" id="b_tr_code" >

                        <option value="">Select Bank Transection Code</option>
                        <?php 

                        include "Connection.php";

                        $sql = "select BANK_TR_CODE, BANK_TR_DESC from DA_TR_CODE_MAP";
                        $parse = ociparse($conn, $sql);

                        oci_execute($parse);

                        while($row = oci_fetch_assoc($parse)){

                        ?>
                        <option value="<?php  echo $row['BANK_TR_CODE']?>"
                            <?php if($row['BANK_TR_CODE'] == $p_bank_tr_CODE){ echo 'selected'; }  ?>>
                            <?php echo $row['BANK_TR_DESC'] ?></option>



                        <?php
                        }

                        oci_free_statement($parse);

                        oci_close($conn);





                        ?>
                        </select>





                
                </div>
                
                
                </div> 




                <div class="row">

<div class="col-lg-3 col-md-3 col-sm-12" style="margin-top:8px">
<label for="text">Transection Code:<label>
    <!-- <input type="text" class="form-control" name="total_cr_amount" id="total_cr_amount" value="<?php echo $p_CR_AMOUNT ?>"> -->

                            <select name="tr_code" id="tr_code" >

                        <option value="">Select Transection Code</option>
                        <?php 

                        include "Connection.php";

                        $sql = "select TR_CODE, TR_DESC from DA_TR_CODE_MST";
                        $parse = ociparse($conn, $sql);

                        oci_execute($parse);

                        while($row = oci_fetch_assoc($parse)){

                        ?>
                        <option value="<?php  echo $row['TR_CODE']?>"
                            <?php if($row['TR_CODE'] == $p_tr_CODE){ echo 'selected'; }  ?>>
                            <?php echo $row['TR_DESC'] ?></option>



                        <?php
                        }

                        oci_free_statement($parse);

                        oci_close($conn);





                        ?>
                        </select>





</div>


<div class="col-lg-3 col-md-3 col-sm-12">


    <label for="text">DB Amount:</label>
    <input type="text" class="form-control" name="db_amount" id="opening_balance" value="<?php echo $p_DB_AMOUNT ?>">
  
           

</div>

<div class="col-lg-3 col-md-3 col-sm-12">


    <label for="text">CR Amount:</label>
    <input type="text" class="form-control" name="cr_amount" id="closing_balance" value="<?php echo $p_CR_AMOUNT ?>">
  
           

</div>


<div class="col-lg-3 col-md-3 col-sm-12">


    <label for="text" class="text-center">Transection Identification:</label>
    <!-- <input type="text" class="form-control" name="closing_balance" id="closing_balance" value="<?php echo $p_C_BALANCE ?>"> -->


    
                                <select name="transection_id" id="transection_id" >

                            <option value="">Select Transection ID</option>
                            <?php 

                            include "Connection.php";

                            $sql = "select TRANS_ID from DA_BANK_TRANS_MST";
                            $parse = ociparse($conn, $sql);

                            oci_execute($parse);

                            while($row = oci_fetch_assoc($parse)){

                            ?>
                            <option value="<?php  echo $row['TRANS_ID']?>"
                                <?php if($row['TRANS_ID'] == $p_trans_ID){ echo 'selected'; }  ?>>
                                <?php echo $row['TRANS_ID'] ?></option>



                            <?php
                            }

                            oci_free_statement($parse);

                            oci_close($conn);





                            ?>
                            </select>
                            
           

</div>




</div>




<div class="row">



<div class="col-lg-8 col-md-8 col sm-12">



</div>



<div class="col-lg-4 col-md-4 col-sm-12 mt-auto text-center">

<?php 
    if($flag == "0"){
        ?>
<button  type="submit" class="btn btn-default" name="submit" id="submit" style="margin-right:80px" >Save</button>

    <?php
    }
?>

<?php 
    if($flag == "1"){
        ?>
<button  type="submit" class="btn btn-default" name="edit" id="edit" style="margin-right:80px;margin-top:10px;" >Edit</button>

<button  type="submit" class="btn btn-default" name="delete" id="delete" style="margin-right:80px;margin-top:10px;" >Delete</button>

    <?php
    }
?>



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
                






                    <!-- Pie Chart 2 -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <!-- <h6 class="m-0 font-weight-bold text-primary"> <?php echo $REPORT_HEADER; ?>  Wise -->
                                    <!-- Bill</h6> -->
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2" style="overflow-x:auto; height: 300px">
                                    <!-- table starts  -->
                                    <!-- <a href="./dashboard_next.php?z=<?php echo $ZONE?>&c=<?php echo $CIRCLE?>&l=<?php echo $LOCATION?>&r=<?php echo $p_report_level_CODE?>&b=<?php echo $p_Bank_CODE?>&f=<?php echo $FROM_DATE?>&t=<?php echo $TO_DATE?>" class=" btn btn-warning" <?php if($location_submit==1 && $LOCATION!=""){ echo "style='pointer-events:auto;display:block;margin-bottom:5px'"; }else{echo "style='pointer-events:none;display:none;'";}?> >Print Detail</a> -->
                                    
                                    <table id="table_id" class="table display table-bordered margin-top:10px"
                                        style="margin: 0 auto; width:100%;border: 1px solid black;width: 100%;border-collapse: collapse;!important">
                                      
                                        <thead>
                                            <tr>
                                                <th>Transection Detail ID</th>
                                                <th>Bank Name</th>
                                                <th>TR Date</th>
                                                <th>Bank Trans No</th>
                                                <th>Bank Trans Code</th>
                                                <th>TR Code</th>
                                                <th>DB Amount</th>
                                                <th>CR Amount</th>
                                                <th>Trans ID</th>
                                                <th>Action</th>
                                               
                                              
                                                


                                            </tr>
                                        </thead>
                                        <tbody>



                                        

                                


                                            <?php 
				for($i=0;$i<count($form_data);$i++){
            
                // for($i=0; $i<count($output); $i++){

               ?>

                                            <tr>
                                                
                                                <td><?php echo $form_data[$i]['TRANS_DTL_ID']; ?></td>
                                                <td><?php echo $form_data[$i]['BANK_NAME']; ?></td>
                                                <td><?php echo $form_data[$i]['TR_DATE']; ?></td>
                                                <td><?php echo $form_data[$i]['BANK_TRANS_NO']; ?></td>
                                                <td><?php echo $form_data[$i]['BANK_TR_DESC']; ?></td>
                                                <td><?php echo $form_data[$i]['TR_DESC']; ?></td>
                                                <td><?php echo $form_data[$i]['DB_AMOUNT']; ?></td>
                                                <td><?php echo $form_data[$i]['CR_AMOUNT']; ?></td>
                                                <td><?php echo $form_data[$i]['TRANS_ID']; ?></td>
                                                
                                                
                                                <td><a href="bank_transection_dtl.php?id=<?php echo  $form_data[$i]['TRANS_DTL_ID'];?>" class="btn btn-primary">Edit</a></td>
                                                
                                                



                                            </tr>

                                            <?php
                }
            ?>

           


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