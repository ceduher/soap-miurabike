<?php
 error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
if(!isset($_SESSION['session']) || $_SESSION['session'] != true || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == "") {
    header("Location: index.php");
}
include "include/url.php";
if(isset($_SESSION['listClientes']) && is_array($_SESSION['listClientes'])) {
    $listClientes = $_SESSION['listClientes'];
} else {
    require_once('nusoap/includes/nusoap.php');
    $soapclient = new nusoap_client($url);
    $soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");
    $sError = $soapclient->getError();
    $listClientes = $soapclient->call('listClientes');
    $_SESSION['listClientes'] = $listClientes;
    $mensaje = "";
    if ($soapclient->fault) {
        $mensaje = $soapclient->faultstring;
        unset($listClientes);
        unset($_SESSION['listClientes']);
    } else {
        $sError = $soapclient->getError();
        if ($sError) {
            $mensaje = 'Error:' . $sError;
            unset($listClientes);
            unset($_SESSION['listClientes']);
        }
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <title>Lista de Clientes - Miura Bike</title>
        <style type="text/css" title="currentStyle">
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_page.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_table_jui.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        <script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.js"></script>
        <script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            var aDataSet = [
                <?php 
if (isset($listClientes) && is_array($listClientes)): ?>
                    <?php foreach ($listClientes as $row): ?>
                        <?php 
$codigoCli = '';
/*
if(strlen(utf8_decode($row['codigo'])) == 1){ 
    $codigoCli = '000'.utf8_decode($row['codigo']);
}else if(strlen(utf8_decode($row['codigo'])) == 2){ 
    $codigoCli = '00'.utf8_decode($row['codigo']);
}else if(strlen(utf8_decode($row['codigo'])) == 3){ 
    $codigoCli = '0'.utf8_decode($row['codigo']);
}else if(strlen(utf8_decode($row['codigo'])) == 4){ 
    $codigoCli = '00'.utf8_decode($row['codigo']);
}*/

$codigoCli = utf8_decode(trim($row['codigo']));

         echo "['".$codigoCli."',
'".addslashes(utf8_decode($row['compania']))."',
'".addslashes(utf8_decode($row['rif']))."',
'".addslashes(utf8_decode($row['nit']))."',
'".addslashes(utf8_decode($row['contacto']))."',
'".addslashes($row['direccion'])."',
'".addslashes($row['telefono'])."',
'".addslashes($row['email'])."'],"; ?>
                    <?php endforeach ?>
                <?php endif ?>
                ];

                $(document).ready(function() {
                    var searchTable =
                    $('#list').dataTable( {
                        "aaData": aDataSet,
                        "aoColumns": [
                            { "sTitle": "Codigo", "sWidth": "10%" },
                            { "sTitle": "Compania", "sWidth": "40%" },
                            { "sTitle": "Rif", "sWidth": "20%" },
                            { "sTitle": "Nit" },
                            { "sTitle": "Contacto", "sWidth": "30%" },
                            { "sTitle": "Direccion" },
                            { "sTitle": "Telefono" },
                            { "sTitle": "Email" }
                        ],
                        "aoColumnDefs": [
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 3 ] },
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 4 ] },
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 5 ] },
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 7 ] },
			],
                        "aaSorting": [[ 0, "desc" ]],
                        "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
                        "oLanguage": {
                            "sUrl": "assets/javascripts/DataTables-1.7.6/es_ES.txt"
                        }
                    } );
                    $('#list tbody tr').live( 'click', function() {
                        position = searchTable.fnGetPosition(this); //se trae la fila a la que corresponde el registro
                        message = "Confirme los siguientes datos: \n";
                        message += "Nombre: " + searchTable.fnGetData(position)[1] + "\n";
                        message += "Rif: " + searchTable.fnGetData(position)[2];
                        if(confirm(message)) {
                            id = $('#CId', window.opener.document);
                            nombre = $('#CNombre', window.opener.document);
                            rif = $('#CRif', window.opener.document);
                            nit = $('#CNit', window.opener.document);
                            contacto = $('#CContacto', window.opener.document);
                            direccion = $('#CDireccion', window.opener.document);
                            telefono = $('#CTelefono', window.opener.document);
                            email = $('#CEmail', window.opener.document);
                            if(id != null && nombre != null && contacto != null && telefono != null && rif != null) {
                                id.val(searchTable.fnGetData(position)[0]);
                                nombre.val(searchTable.fnGetData(position)[1]);
                                rif.val(searchTable.fnGetData(position)[2]);
                                nit.val(searchTable.fnGetData(position)[3]);
                                contacto.val(searchTable.fnGetData(position)[4]);
                                direccion.val(searchTable.fnGetData(position)[5]);
                                telefono.val(searchTable.fnGetData(position)[6]);
                                email.val(searchTable.fnGetData(position)[7]);
                                window.close();
                            } else {
                                window.close();
                            }
                        }
                    } );
                } );
        </script>
    </head>
    <body id="dt_example" class="ex_highlight_row">
        <div class="prueba"><img src="assets/images/top.jpg" width="1420" height="244"></div>
        <div id="container">
            <h1>Lista de Clientes</h1>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="list"></table>
        </div>
    </body>
</html>