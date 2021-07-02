<?PHP
include 'Connection.php';
 set_time_limit(1000);

 $ZONE_CODE =$_POST['zon_id'];



 $sql = "SELECT * FROM DA_CIRCLE_MST WHERE ZONE_CODE =".$ZONE_CODE;
 print_r($sql);

 $p = ociparse($conn, $sql);
 oci_execute($p);

 



echo '<option value="">Select Circle </option>';
while ($row = oci_fetch_assoc($p)) {

	echo '<option value="' . $row['CIRCLE_CODE'] . '">' . $row['CIRCLE_DESC'] . '</option>';
//   $output[]=$row;
}
// print($output);
// print(gettype($output));
// print json_encode($output);

oci_free_statement($p);
oci_close($conn);



?>