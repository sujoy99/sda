<?PHP

set_time_limit(300);
 include 'Connection.php';

 
 $curs = oci_new_cursor($conn);

$stid = oci_parse($conn, "begin API_SETTING_DATA_PKG.DA_BANK_TRANS_MST_LIST(:cur_data); end;");


oci_bind_by_name($stid, ":cur_data", $curs, -1, OCI_B_CURSOR);

oci_execute($stid);
oci_execute($curs);


while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {

	
  $output[]=$row;
}
print json_encode($output);

oci_free_statement($stid);
oci_free_statement($curs);
oci_close($conn);



?>