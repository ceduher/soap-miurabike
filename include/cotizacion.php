<?php
include dirname(__FILE__) ."/ruta.php";

$mdbFilename = $ruta . "/cotizar.mdb";
$user = "";
$password = "";
$linkCotizacion = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", $user, $password);
?>
