<?php

require_once('includes/nusoap.php');
$soapclient = new nusoap_client('http://127.0.0.1:85/miurabike/nusoap/server2.php');
$soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
$sError = $soapclient->getError();
if ($sError) {
    echo "No se pudo realizar la operación.";
    die();
}
$result = $soapclient->call('listClientes');
if ($soapclient->fault) {
    echo $soapclient->faultstring;
    die();
} else {
    $sError = $soapclient->getError();
    if ($sError) {
        echo 'Error:' . $sError;
        die();
    }
}

print_r($result)
?>