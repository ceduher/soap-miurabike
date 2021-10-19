<?php
include dirname(__FILE__) ."/ruta.php";

$mdbFilename = $ruta . "/clieprov.mdb";
$user = "";
$password = "";
$linkCliente = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", $user, $password);
?>
