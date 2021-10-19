<?php
session_start();
if(!isset($_SESSION['session']) || $_SESSION['session'] != true || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == "") {
    header("Location: index.php");
}
include "include/url.php";
if(isset($_SESSION['listProductos']) && is_array($_SESSION['listProductos'])) {
    $listProductos = $_SESSION['listProductos'];
} else {
    require_once('nusoap/includes/nusoap.php');
    $soapclient = new nusoap_client($url);
    $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
    $sError = $soapclient->getError();
    $listProductos = $soapclient->call('listProductos');
    $_SESSION['listProductos'] = $listProductos;
    $mensaje = "";
    if ($soapclient->fault) {
        $mensaje = $soapclient->faultstring;
        unset($listProductos);
        unset($_SESSION['listProductos']);
    } else {
        $sError = $soapclient->getError();
        if ($sError) {
            $mensaje = 'Error:' . $sError;
            unset($listProductos);
            unset($_SESSION['listProductos']);
        }
    }
}
$l = $_REQUEST["l"]
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Lista de Productos - Miura Bike</title>
        <style type="text/css" title="currentStyle">
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_page.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_table_jui.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        <script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.js"></script>
        <script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            var aDataSet = [
                <?php if (isset($listProductos) && is_array($listProductos)): ?>
                    <?php foreach ($listProductos as $row): ?>
                        <?php echo "['" . addslashes($row['parte']) . "', '" . addslashes($row['marca']) . "', '" . addslashes($row['descripcion']) . "', '" . $row['precio1'] . "', '" . $row['costo'] . "'], \n"; ?>
                    <?php endforeach ?>
                <?php endif ?>
                ];

                $(document).ready(function() {
                    var searchTable =
                    $('#list').dataTable( {
                        "aaData": aDataSet,
                        "aoColumns": [
                            { "sTitle": "Código", "sWidth": "20%" },
                            { "sTitle": "Marca", "sWidth": "30%" },
                            { "sTitle": "Descripción", "sWidth": "40%" },
                            { "sTitle": "Precio", "sWidth": "10%" }
                        ],
                        "aoColumnDefs": [
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 4 ] }
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
                        message += "Código: " + searchTable.fnGetData(position)[0] + "\n";
                        message += "Marca: " + searchTable.fnGetData(position)[1] + "\n";
                        message += "Precio: " + searchTable.fnGetData(position)[2];
                        if(confirm(message)) {
                            codigo = $('#PCodigo_<?php echo $l ?>', window.opener.document);
                            marca = $('#PMarca_<?php echo $l ?>', window.opener.document);
                            descripcion = $('#PDescripcion_<?php echo $l ?>', window.opener.document);
                            precio = $('#PPrecio_<?php echo $l ?>', window.opener.document);
                            cantidad = $('#PCantidad_<?php echo $l ?>', window.opener.document);
                            costo = $('#PCosto_<?php echo $l ?>', window.opener.document);
                            if(codigo != null && marca != null && descripcion != null && precio != null && costo != null) {
                                codigo.val(searchTable.fnGetData(position)[0]);
                                marca.val(searchTable.fnGetData(position)[1]);
                                descripcion.val(searchTable.fnGetData(position)[2]);
                                precio.val(searchTable.fnGetData(position)[3]);
                                costo.val(searchTable.fnGetData(position)[4]);
                                cantidad.val(1);
                                cantidad.focus();
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
            <h1>Lista de Productos</h1>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="list"></table>
        </div>
    </body>
</html>