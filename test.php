<?php
$_ENV[ 'TWO_TASK']="/usr/lib/oracle/11.2/client/network/admin/tnsnames.ora";
$_ENV[ 'ORACLE_HOME']="/usr/lib/oracle/11.2/client";
$_ENV[ 'TNS_ADMIN']="/usr/lib/oracle/11.2/client/network/admin";


// echo '<pre>';
// print_r($_ENV);

// echo '</pre>';

phpinfo();
$dbstr1 = "(DESCRIPTION=
				(ADDRESS=(PROTOCOL=TCP)(HOST=BEORATST01-SCAN.UNIANDES.EDU.CO)(PORT=1521))
				(CONNECT_DATA=(SERVER=dedicated)
				(SERVICE_NAME=APPSQA))
			)";
 
if(!@($conn = oci_connect('convenios','zL0_s65a',$dbstr1)))
{ 
	$conn = oci_connect('convenios','zL0_s65a',$dbstr) or die (ocierror()); 
} 

$stid = oci_parse($conn, 'select table_name from user_tables');
oci_execute($stid);

echo "<table>\n";
while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;")."</td>\n";
    }
    echo "</tr>\n";
}
// echo "</table>\n";
// $DB = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=BEORATST01-SCAN.UNIANDES.EDU.CO)(PORT=1521))(CONNECT_DATA=(SERVER=dedicated)(SERVICE_NAME=APPSQA)))';
// $dbh = ocilogon ('convenios', 'zL0_s65a',  $DB) or die( "Could not connect to Oracle database!");
// if ($dbh == false){
   // $msg = OCIError($dbh);
// } else {
   // $msg = 'Conexion exitosa!';
// }
// ocilogoff($dbh);
// echo $msg;
// ?> 
 <?php

// define ('BD_HOST', 'APPSQA');
// define ('BD_USUARIO'        , 'convenios');
// define ('BD_PASS'           , 'zL0_s65a');
// define ('BD_NOMBRE'         , '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=BEORATST01-SCAN.UNIANDES.EDU.CO)(PORT=1521))(CONNECT_DATA=(SERVER=dedicated)(SERVICE_NAME=APPSQA)))');

// define ('BD_TIPO'           , 'oci8');

// echo BD_HOST.'/'.BD_NOMBRE;

// $conn = oci_connect(BD_USUARIO, BD_PASS, BD_HOST.'/'.BD_NOMBRE) or die(oci_error());;

// $stid = oci_parse($conn, 'select table_name from user_tables');
// oci_execute($stid);

// echo "<table>\n";
// while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
    // echo "<tr>\n";
    // foreach ($row as $item) {
        // echo "  <td>".($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;")."</td>\n";
    // }
    // echo "</tr>\n";
// }
// echo "</table>\n";

?>

