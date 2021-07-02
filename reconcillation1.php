<?php


error_reporting(0);
set_time_limit(1000);
include "Connection.php";

$ZONE = "";

$sql1 = "SELECT * FROM DA_ZONE_MST";
$parse = ociparse($conn, $sql1);
oci_execute($parse);

while ($row = oci_fetch_assoc($parse)) {
	$zone[] = $row;
}

// var_dump($division);
// echo count($division);
oci_free_statement($parse);



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Reconcillation</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
        integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="./style1.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Chosen CSS File -->

    <link rel="stylesheet" href="chosen/css/chosen.css">
    
    <!-- Chosen CSS File -->

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ"
        crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY"
        crossorigin="anonymous"></script>

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

    <div class="wrapper" style="min-height: 650px;">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <img style="border-radius: 50%;" class="sidebar-logo-image" src="./img/logo.png" alt="logo">
                <!-- <h3 class="sidebar-logo-text">ই-আলাপন</h3> -->
            </div>

            <ul class="list-unstyled" id="list-unstyled">
                <!-- <p>Dummy Heading</p> -->
                <li>
                    <a class="nav-bar-actv-btn active-nav-bar-btn" href="./dashboard.php"><i class="fa fa-tachometer-alt"></i><span
                            style="margin-left: 8px;"></span>Dashboard</a>
                </li>
                <li>
                    <a class="nav-bar-actv-btn" href="#"><i class="fa fa-tablet"></i><span
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

        <nav class="navbar-pc navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="row text-center">
                        <div class="col-3 mdl-clmn">
                            <div class="page-title">
                                <h5>
                                    Reconciliation
                                </h5>
                            </div>
                        </div>
                    </div>
                    <form action="">
                    <div class="row" style="margin: 30px 0px 10px 0px;">
                        <div class="col-4 date-select-reconclsn text-center">
                            
                                <label for="">Date : </label>
                                <select name="" id="" class="chooseDate">
                                    <option value="">22 February, 2021</option>
                                    <option value="">23 February, 2021</option>
                                    <option value="">24 February, 2021</option>
                                    <option value="">25 February, 2021</option>
                                    <option value="">26 February, 2021</option>
                                </select>
                            
                        </div>
                        <div class="col-4 zone-select-reconclsn text-center">
                            
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
                        <div class="col-4 bank-select-reconclsn text-center">
                            
                                <label for="">Bank : </label>
                                <select name="" id="" class="chooseDate">
                                    <option value="">DBBL</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            
                        </div>
                        </form>
                    </div>
                </div>
            </nav>
            <nav class="navbar-mobile navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="btn-sidebarCollapse-div">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="text-center page-title">
                        <h5>
                            Reconciliation
                        </h5>
                    </div>
                </div>
                <div class="row" style="margin: 30px 0px 10px 0px;">
                    <div class="col-12 date-select-reconclsn text-center">
                        <form action="">
                            <label for="">Date : </label>
                            <select name="" id="" class="chooseDate">
                                <option value="">22 February, 2021</option>
                                <option value="">23 February, 2021</option>
                                <option value="">24 February, 2021</option>
                                <option value="">25 February, 2021</option>
                                <option value="">26 February, 2021</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-12 zone-select-reconclsn text-center">
                        <form action="">
                            <label for="">Zone : </label>
                            <select name="zone" id="zone">
                                <option value="">Select Zone</option>
																
																<?php
																for ($i = 0; $i < count($zone); $i++) {

																	echo "<option value='" . $zone[$i]["ZONE_CODE"] . "'>" . $zone[$i]["ZONE_DESC"] . "</option>";
																}

																?>
                                </select>
                        </form>
                    </div>
                    <div class="col-12 bank-select-reconclsn text-center">
                        <form action="">
                            <label for="">Bank : </label>
                            <select name="" id="" class="chooseDate">
                                <option value="">DBBL</option>
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                            

                        </form>
                    </div>
                </div>
                

            </nav>

            <div class="row">
                <div class="col-3 mt-5 text-center">
                    <p style="font-weight: 700;">Central Zone : </p>
                </div>
                <div class="col-3 text-center">
                    <p>TK</p>
                    <div class="stylist-input-box-text">
                        <p>12191511.00</p>
                    </div>
                </div>
                <div class="col-3 text-center">
                    <p>TK</p>
                    <div class="stylist-input-box-text">
                        <p>12191511.00</p>
                    </div>
                </div>
                <div class="mt-3 col-3 text-center">
                    <button class="btn-cnfrm-reconclsn button1">
                        <a href="#" > Confirm</a>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

    <script>

        $(document).ready(function () {
            $('#custom-data-table').DataTable();
        });
    </script>

    <!-- Chosen JS File -->


<script src="chosen/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="chosen/js/chosen.jquery.js" type="text/javascript"></script>
    <script>
        $(".chooseDate").chosen();
    </script>


    <!-- Chosen JS File -->
</body>

</html>