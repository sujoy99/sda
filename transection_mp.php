<?php

include "Connection.php";


$p_TR_CODE=NULL;
$p_TR_DESC=NULL;

$p_Bank_CODE =NULL;
$p_tr_CODE=NULL;

$flag=0;

$flag1=0;




if (isset($_GET["b_id"]) && $_GET["b_id"]!="" && ($_GET["t_id"]) && $_GET["t_id"]!=""){
    $flag=1;
    $flag1=1;

    $id=$_GET["b_id"];
    $t_id=$_GET["t_id"];


    
    $sql7="SELECT BANK_CODE,BANK_TR_CODE,BANK_TR_DESC,TR_CODE FROM DA_TR_CODE_MAP  where BANK_CODE= '". $id."' AND TR_CODE='".$t_id."' ";

//    print_r($sql7);
    $parse7=oci_parse($conn,$sql7);

    
    oci_execute($parse7);


    while ($row7 = oci_fetch_assoc($parse7)) {
        $p_Bank_CODE=$row7["BANK_CODE"];
        $p_TR_CODE=$row7["BANK_TR_CODE"];
        $p_TR_DESC=$row7["BANK_TR_DESC"];
        $p_tr_CODE=$row7["TR_CODE"];
        
        
    
    // var_dump($form_data);
    
    }


        // echo $p_Bank_CODE;
        // echo $p_TR_CODE;
        // echo $p_TR_DESC;
        // echo $p_tr_CODE;
    
   
  
  


}


if (isset($_POST['submit'])){

    $transection_code=$_POST['transection_code'];
    $transection_desc=$_POST['transection_desc'];
    $bank_code=$_POST['bank_code'];
    $tr_code=$_POST['tr_code'];
    
    // echo $transection_code;
    // echo $transection_desc;
    // echo $bank_code;
    // echo $tr_code;
    
    
    
    $sql="INSERT INTO DA_TR_CODE_MAP(BANK_CODE,BANK_TR_CODE,BANK_TR_DESC,TR_CODE) VALUES ('".$bank_code."','".$transection_code."','".$transection_desc."','".$tr_code."')";
    
    $parse=oci_parse($conn,$sql);
    
    oci_execute($parse);
    oci_free_statement($parse);

}



if (isset($_POST['edit'])){


    $transection_code=$_POST['transection_code'];
    $transection_desc=$_POST['transection_desc'];
    $bank_code=$_GET['b_id'];
    $tr_code=$_GET['t_id'];

    $sql2="UPDATE  DA_TR_CODE_MAP SET BANK_TR_DESC='".$transection_desc."',BANK_TR_CODE='".$transection_code."' WHERE BANK_CODE='".$bank_code."' AND TR_CODE='".$tr_code."'";

    // print_r($sql2);

    // echo $transection_code;
    // echo $transection_desc;
    // echo $bank_code;
    // echo $tr_code;

    $parse2=oci_parse($conn,$sql2);

oci_execute($parse2);
oci_free_statement($parse2);

header("location:transection_mp.php");

}



if (isset($_POST['delete'])){

    $bank_code=$_GET['b_id'];
    $tr_code=$_GET['t_id'];
    
    $sql3="DELETE  FROM DA_TR_CODE_MAP WHERE BANK_CODE='".$bank_code."' AND TR_CODE='".$tr_code."' ";

    $parse3=oci_parse($conn,$sql3);

oci_execute($parse3);
oci_free_statement($parse3);

header("location:transection_mp.php");

}


    
$sql4="SELECT DA_TR_CODE_MAP.BANK_CODE,DA_BANKS.BANK_NAME,BANK_TR_CODE, BANK_TR_DESC,DA_TR_CODE_MST.TR_DESC,DA_TR_CODE_MST.TR_CODE FROM DA_TR_CODE_MAP,DA_TR_CODE_MST,DA_BANKS WHERE DA_TR_CODE_MAP.BANK_CODE = DA_BANKS.BANK_CODE and DA_TR_CODE_MST.TR_CODE=DA_TR_CODE_MAP.TR_CODE";
$parse4=oci_parse($conn,$sql4);

oci_execute($parse4);
while ($row = oci_fetch_assoc($parse4)) {
 
    $form_data[] = $row;

// var_dump($form_data);

}














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
            <nav class="navbar-pc navbar-expand-lg navbar-light">
                <div class="container-fluid ">
                  

                <form  action="" method="post">



                
                <div class="row">

                <div class="col-lg-2 col-md-2 col-sm-12">
                
      
                </div>


                <div class="col-lg-3 col-md-3 col-sm-12">
                
                <label for="text" class="text-center" >Bank Code:</label>
    <!-- <input type="text" class="form-control" name="transection_code" id="transection_code" value="<?php echo $p_TR_CODE ?>"> -->

                            <select name="bank_code" id="bank_code"<?php if($flag1==1){echo "disabled style='color:black!important;font-weight:bold!important'" ;} ?>>

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
                
                
    <label for="text" class="text-center" >Transection Code:</label>
    <!-- <input type="text" class="form-control" name="transection_code" id="transection_code" value="<?php echo $p_TR_CODE ?>"> -->
                                <select name="tr_code" id="tr_code" <?php if($flag1==1){echo "disabled style='color:black!important;font-weight:bold!important'" ;} ?>>

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


                <div class="col-lg-4 col-md-4 col-sm-12">
                
                
  
                
                </div>
                
                
                </div> 




                <div class="row">

<div class="col-lg-2 col-md-2 col-sm-12">



</div>


<div class="col-lg-3 col-md-3 col-sm-12">


    <label for="text">Bank Transection Code:</label>
    <input type="text" class="form-control" name="transection_code" id="transection_code" value="<?php echo $p_TR_CODE ?>">
  
           

</div>

<div class="col-lg-3 col-md-3 col-sm-12">


    <label for="text">Bank Transection Desc:</label>
    <input type="text" class="form-control" name="transection_desc" id="transection_desc" value="<?php echo $p_TR_DESC ?>">
  
           

</div>


<div class="col-lg-4 col-md-4 col-sm-12">

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
<button  type="submit" class="btn btn-default" name="edit" id="edit" style="margin-right:80px" >Edit</button>

<button  type="submit" class="btn btn-default" name="delete" id="delete" style="margin-right:80px" >Delete</button>

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
                                <div class="chart-pie pt-4 pb-2" style="overflow-x:auto; height:600px">
                                    <!-- table starts  -->
                                    <!-- <a href="./dashboard_next.php?z=<?php echo $ZONE?>&c=<?php echo $CIRCLE?>&l=<?php echo $LOCATION?>&r=<?php echo $p_report_level_CODE?>&b=<?php echo $p_Bank_CODE?>&f=<?php echo $FROM_DATE?>&t=<?php echo $TO_DATE?>" class=" btn btn-warning" <?php if($location_submit==1 && $LOCATION!=""){ echo "style='pointer-events:auto;display:block;margin-bottom:5px'"; }else{echo "style='pointer-events:none;display:none;'";}?> >Print Detail</a> -->
                                    
                                    <table id="table_id" class="table display table-bordered margin-top:10px"
                                        style="margin: 0 auto; width:100%;border: 1px solid black;width: 100%;border-collapse: collapse;!important">
                                      
                                        <thead>
                                            <tr>
                                                <th>Bank Code</th>
                                                <th>Bank Transection Code</th>
                                                <th>Bank Transection</th>
                                                <th> Transection Code</th>
                                                <th>Action</th>
                                              
                                                


                                            </tr>
                                        </thead>
                                        <tbody>



                                        

                                


                                            <?php 
				for($i=0;$i<count($form_data);$i++){
            
                // for($i=0; $i<count($output); $i++){

               ?>

                                            <tr>
                                                
                                                <td><?php echo $form_data[$i]['BANK_NAME']; ?></td>
                                                <td><?php echo $form_data[$i]['BANK_TR_CODE']; ?></td>
                                                <td><?php echo $form_data[$i]['BANK_TR_DESC']; ?></td>
                                                <td><?php echo $form_data[$i]['TR_DESC']; ?></td>
                                                
                                                
                                                <td><a href="transection_mp.php?b_id=<?php echo  $form_data[$i]['BANK_CODE']?>&t_id=<?php echo $form_data [$i]['TR_CODE'];?>" class="btn btn-primary">Edit</a></td>
                                                
                                                



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

// document.write(today);



    $('#table_id').DataTable( { 
        dom: 'Bfrtip',
        "searching": true,
        "paging": true,
        "bInfo" : true,
        "ordering": true,
        buttons: [
      'colvis'
    ]
       
        
    } );
    </script>


    <!-- data table print start  -->



</body>

</html>