<?PHP
//header('Content-Type: text/html; charset=utf-8'); 
$PDBMIS=
"(DESCRIPTION =
(ADDRESS = (PROTOCOL = TCP)(HOST = 103.123.11.179)(PORT = 1521))
(CONNECT_DATA =(SERVER = DEDICATED)(SERVICE_NAME = mbillmw)
)
)";



$db_charset = 'AL32UTF8'; 


$conn = ocilogon( "SDA", "sda",$PDBMIS,"WE8ISO8859P15");

?>