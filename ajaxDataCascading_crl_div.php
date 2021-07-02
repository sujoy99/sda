<?PHP
include 'Connection.php';
 set_time_limit(1000);

 $CIRCLE_CODE =$_POST['crl_id'];



 $sql = "SELECT * FROM DA_DIST_DIV_MST WHERE CIRCLE_CODE =".$CIRCLE_CODE;


 $p = ociparse($conn, $sql);
 oci_execute($p);

 



echo '<option value="0">Select Division </option>';
while ($row = oci_fetch_assoc($p)) {

	echo '<option value="' . $row['DIV_CODE'] . '">' . $row['DIV_DESC'] . '</option>';
//   $output[]=$row;
}
// print($output);
// print(gettype($output));
// print json_encode($output);

oci_free_statement($p);
oci_close($conn);



?>