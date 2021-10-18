<?php
//Conexion
$serverName = "SERVER\SQLEXPRESS";$uid = "profit";$pwd = "profit";$dtb="MIURA_A2";
$connectionInfo = array("UID"=>$uid,"PWD"=>$pwd,"Database"=>$dtb);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
//if( $conn === false ){echo "No es posible conectarse al servidor.</br>";die( print_r( sqlsrv_errors(), true));}
?>