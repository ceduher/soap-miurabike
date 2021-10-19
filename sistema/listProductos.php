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
    $soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");
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
    <head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
        
        <title>Lista de Productos - Miura Bike</title>
        <style type="text/css" title="currentStyle">
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_page.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/demo_table_jui.css";
            @import "assets/javascripts/DataTables-1.7.6/media/css/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
		<script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.js"></script> 
        <script type="text/javascript" src="assets/javascripts/DataTables-1.7.6/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="assets/javascripts/jquery.ui.core.js"></script>
        <script type="text/javascript" src="assets/javascripts/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="assets/javascripts/jquery.ui.dialog.js"></script>
		<script type="text/javascript" src="assets/javascripts/jquery.ui.position.js"></script>
        <script type="text/javascript" charset="utf-8">
			
				var img = "";
				function imageZoom(img){
					console.log("ya pasamos por aqui "+img+" !!");
					$(document).ready(function() {
						$("#dialog").dialog({
							height: 550,
							width: 810,
							modal: true,
							open: function() {
								$("#dialog").html('<img src="'+img+'" style=\"width: auto;max-height: 400px;\" />');
							}
						});
					});
				}

            var aDataSet = [
                <?php 
				function is_url_exist($url){
					$ch = curl_init($url);    
					curl_setopt($ch, CURLOPT_NOBODY, true);
					curl_exec($ch);
					$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if($code == 200){
					   $status = true;
					}else{
					  $status = false;
					}
					curl_close($ch);
				   return $status;
				}				
				
				if (isset($listProductos) && is_array($listProductos)): ?>
                    <?php foreach ($listProductos as $row): ?>
                        <?php 
						  $urlImg = "http://bicicletasmiura11.dyndns.org:8080/imagenes/".strtolower(rtrim($row['parte'])).".jpg";//"http://bicicletasmiura11.dyndns.org:8080/imagenes/ii-0089-ro-az-sl.jpg";
						  $string = $row['parte'];
						  $lnkImg = "<table id=\"imagenes\" width=\"100\" height=\"67\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td height=\"67\"><img onmouseover=\"imageZoom(\'".addslashes($urlImg)."\');\"  src=\"".addslashes($urlImg)."\" style=\"width: auto;max-height: 67px;\" /></td></tr></table>";
					echo "['".addslashes($row['parte']). "',
					       '".addslashes($row['marca'])."',
					       '".addslashes(utf8_decode($row['descripcion']))."',
					       '".addslashes(utf8_decode($row['precio1']))."',
					       '".$lnkImg."',
					       '".addslashes($row['costo'])."',
					       '".addslashes($row['unimed'])."'
], \n"; ?>
                    <?php endforeach ?>
                <?php endif ?>
                ];

                $(document).ready(function() {					
                    var searchTable =
                    $('#list').dataTable( {
                        "aaData": aDataSet,
                        "aoColumns": [
                            { "sTitle": "Codigo", "sWidth": "20%" },
                            { "sTitle": "Marca", "sWidth": "20%" },
                            { "sTitle": "Descripcion", "sWidth": "30%" },
                            { "sTitle": "Precio", "sWidth": "10%" },
			    { "sTitle": "Imagen", "sWidth": "10%" },
			    { "sTitle": "Costo", "sWidth": "10%" },
			    { "sTitle": "Unimed", "sWidth": "10%" }
                        ],
                        "aoColumnDefs": [
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 5 ] },
                            { "bSearchable": false, "bVisible": false, "aTargets": [ 6 ] }
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
                        message += "Codigo: " + searchTable.fnGetData(position)[0] + "\n";
                        message += "Marca: " + searchTable.fnGetData(position)[1] + "\n";
                        message += "Precio: " + searchTable.fnGetData(position)[3] + "\n";
                        if(confirm(message)) {
                            codigo = $('#PCodigo_<?php echo $l ?>', window.opener.document);
                            marca = $('#PMarca_<?php echo $l ?>', window.opener.document);
                            descripcion = $('#PDescripcion_<?php echo $l ?>', window.opener.document);
                            precio = $('#PPrecio_<?php echo $l ?>', window.opener.document);
                            cantidad = $('#PCantidad_<?php echo $l ?>', window.opener.document);
                            costo = $('#PCosto_<?php echo $l ?>', window.opener.document);
                            unimed = $('#PUnimed_<?php echo $l ?>', window.opener.document);
                            if(codigo != null && marca != null && descripcion != null && precio != null && costo != null) {
                                codigo.val(searchTable.fnGetData(position)[0]);
                                marca.val(searchTable.fnGetData(position)[1]);
                                descripcion.val(searchTable.fnGetData(position)[2]);
                                precio.val(searchTable.fnGetData(position)[3]);
                                costo.val(searchTable.fnGetData(position)[5]);
                                unimed.val(searchTable.fnGetData(position)[6]);
                                cantidad.val(1);
                                cantidad.focus();
                                window.close();
                            } else {
                                window.close();
                            }
                        }
                    } );
                });
          </script>
    </head>
    <body id="dt_example" class="ex_highlight_row">
        <div class="prueba"><img src="assets/images/top.jpg" width="1420" height="244"></div>
        <div id="dialog" title="Vista Ampliada Producto" style="display:none; text-align:justify"></div>
        <div id="container">
            <h1>Lista de Productos</h1>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="list"></table>
        </div>
    </body>
</html>