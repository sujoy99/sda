<?PHP
include 'Connection.php';
 set_time_limit(1000);

 $CIRCLE_CODE =$_POST['crl_id'];



 $sql = "SELECT * FROM DA_LOCATION_MST WHERE CIRCLE_CODE =".$CIRCLE_CODE;
 print_r($sql);

 $p = ociparse($conn, $sql);
 oci_execute($p);

 



echo '<option value="">Select Location </option>';
while ($row = oci_fetch_assoc($p)) {

	echo '<option value="' . $row['LOCATION_CODE'] . '">' . $row['LOCATION_DESC'] . '</option>';
//   $output[]=$row;
}
// print($output);
// print(gettype($output));
// print json_encode($output);

oci_free_statement($p);
oci_close($conn);



?>