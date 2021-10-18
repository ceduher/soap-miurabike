<?php
include dirname(__FILE__) ."/ruta.php";

$mdbFilename = $ruta . "/TABLAS.MDB";
$user = "";
$password = "2481692085354";
$linkTabla = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", $user, $password);

?>