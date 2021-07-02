<?php 

include "Connection.php";
set_time_limit(100000);


$sql200 = "select pay_date n from (select distinct pay_date from da_payment_mst order by pay_date desc)   where rownum=1";


$parseresults = ociparse($conn, $sql200);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $current_date = $row["N"];
}

oci_free_statement($parseresults);

echo $current_date. "<br>";


$sql201 = "SELECT LAST_DAY(ADD_MONTHS(TO_DATE('". $current_date. "'),-1)) N from dual";



$parseresults = ociparse($conn, $sql201);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $last_date = $row["N"];
}

oci_free_statement($parseresults);

echo $last_date. "<br>";


$sql202 = "  select dt 
from
(select  (TRUNC (last_day(TO_DATE('". $last_date ."')) - ROWNUM) + 1) dt from dual connect by rownum<32) order by dt asc";


// print_r($sql2);
// $sql2 = ""


$parseresults = ociparse($conn, $sql202);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $month_date[] = $row;
}

oci_free_statement($parseresults);

// var_dump($month_date);
echo "<br>";



$sql203 = "select trunc(to_date('". $last_date ."'), 'MM') N from dual";

// print_r($sql3);


$parseresults = ociparse($conn, $sql203);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $first_date = $row["N"];
}

oci_free_statement($parseresults);
echo $first_date. "<br>";


$next = $first_date;

$sql204= "SELECT COUNT( BILL_NUMBER )  as M FROM DA_PAYMENT_DTL WHERE BATCH_NO IN (select BATCH_NO  FROM DA_PAYMENT_MST WHERE PAY_DATE='". $first_date."')" ;

// print_r($sql204);




$parseresults = ociparse($conn, $sql204);
oci_execute($parseresults);


while($row = oci_fetch_assoc($parseresults)){

    $NO_OF_BILL[] = $row;
}

oci_free_statement($parseresults);

// var_dump($NO_OF_BILL);



do {

    $sql205 = "SELECT TO_DATE('". $next. "' ) + 1 tomorrow FROM DUAL";

    $parseresults = ociparse($conn, $sql205);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NEXT_date = $row["TOMORROW"];
}

// echo "<br>";
// var_dump($NEXT_date);
oci_free_statement($parseresults);


$next = $NEXT_date;


$sql206="SELECT COUNT( BILL_NUMBER ) as M FROM  DA_PAYMENT_DTL WHERE BATCH_NO IN (select BATCH_NO  FROM DA_PAYMENT_MST WHERE PAY_DATE='". $next."')";

// print_r($sql206);


$parseresults = ociparse($conn, $sql206);
oci_execute($parseresults);

while($row = oci_fetch_assoc($parseresults)){

    $NO_OF_BILL[] = $row;
}

// echo "<br>";
// var_dump($NO_OF_BILL);
oci_free_statement($parseresults);






// echo "Next Date :". $next. "<br>";

        if($next == $last_date){
        break;
        }
    
  } while ($next <= $last_date);



  $NO_OF_BILL1 = "[";
    $month_date1 = "[";

    for($i=0; $i<count($month_date); $i++){
        $NO_OF_BILL1 .= '"' . $NO_OF_BILL[$i]['M'] . '",';
        // echo $ZONE_TOTAL."<br>";
        $month_date1 .= '"' . $month_date[$i]['DT'] . '",';
        // echo $ZONE_N."<br>";
    }

    $NO_OF_BILL1 = substr($NO_OF_BILL1, 0, -1);
  $month_date1 = substr($month_date1, 0, -1);

  $NO_OF_BILL1 = $NO_OF_BILL1 . ']';
  $month_date1 = $month_date1 . ']';

  echo ($NO_OF_BILL1);
  echo ($month_date1);














?>