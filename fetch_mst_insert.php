<?PHP

set_time_limit(300);
 include 'Connection.php';
$p_BANK_CODE =$_POST['p_BANK_CODE'];
$p_FROM_TR_DATE =$_POST['p_FROM_TR_DATE'];
$p_TO_TR_DATE =$_POST['p_TO_TR_DATE'];

$p_TOTAL_DB_AMOUNT =$_POST['p_TOTAL_DB_AMOUNT'];
$p_TOTAL_CR_AMOUNT =$_POST['p_TOTAL_CR_AMOUNT'];
$p_OPENING_BAL =$_POST['p_OPENING_BAL'];
$p_CLOSING_BAL =$_POST['p_CLOSING_BAL'];


                                                  
$returnval=0;
$stid = oci_parse($conn, "begin API_SETTING_DATA_PKG.DA_BANK_TRANS_MST_INSERT(:OUTPUT, :p_BANK_CODE , :p_FROM_TR_DATE ,:p_TO_TR_DATE ,:p_TOTAL_DB_AMOUNT,:p_TOTAL_CR_AMOUNT,:p_OPENING_BAL,:p_CLOSING_BAL); end;");


oci_bind_by_name($stid, ":OUTPUT", $returnval, -1, SQLT_INT);
oci_bind_by_name($stid, ":p_BANK_CODE", $p_BANK_CODE, -1, SQLT_CHR);
oci_bind_by_name($stid, ":p_FROM_TR_DATE", $p_FROM_TR_DATE, -1, SQLT_CHR);
oci_bind_by_name($stid, ":p_TO_TR_DATE", $p_TO_TR_DATE, -1, SQLT_CHR);

oci_bind_by_name($stid, ":p_TOTAL_DB_AMOUNT", $p_TOTAL_DB_AMOUNT, -1, SQLT_INT);
oci_bind_by_name($stid, ":p_TOTAL_CR_AMOUNT", $p_TOTAL_CR_AMOUNT, -1, SQLT_INT);
oci_bind_by_name($stid, ":p_OPENING_BAL", $p_OPENING_BAL, -1, SQLT_INT);
oci_bind_by_name($stid, ":p_CLOSING_BAL", $p_CLOSING_BAL, -1, SQLT_INT);

oci_execute($stid);

print $returnval;

oci_free_statement($stid);
oci_close($conn);



?>