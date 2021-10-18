<?php
include dirname(__FILE__) ."/ruta.php";

$mdbFilename = $ruta . "/inventar.mdb";
$user = "";
$password = "";
$linkProducto = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", $user, $password);
?>
