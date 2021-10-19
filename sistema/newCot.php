<?php
session_start();
include "include/url.php";
//Inicio del Webservice
require_once('nusoap/includes/nusoap.php');
$soapclient = new nusoap_client($url);
$soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");
$sError = $soapclient->getError();
$statusCot = false;
if(isset($_POST)) {
    $cotizacion['codigoCliente'] = $_POST['CId'];
    $cotizacion['nombreCliente'] = substr(str_replace("'","",$_POST['CNombre']), 0, 60);
    $cotizacion['contactoCliente'] = str_replace("'","",$_POST['CContacto']);
    $cotizacion['direccionCliente'] = str_replace("'","",$_POST['CDireccion']);
    $cotizacion['rifCliente'] = $_POST['CRif'];
    $cotizacion['emailCliente'] = $_POST['CEmail'];
    $cotizacion['telefonoCliente'] = $_POST['CTelefono'];
    $cotizacion['idVendedor'] = $_POST['vendedor'];
    $c1 = date("d-m-Y");
    $c2 = substr(str_replace("'","",$_POST['CNombre']), 0, 22);
    if(strlen($c2) > 22){ $c2 = $c2." ..."; }
    $c3 = substr($_POST['CNomVen'], 0, 14);
    $cadena = $c1." - ".$c2." - ".$c3." ...";
    $cotizacion['descPedWeb'] = $cadena;
    $cotizacion['descripcionTipoPago'] = $_POST['tipoPago'];
    $cotizacion['cantidadRenglones'] = $_POST['PRows'];

    for ($i = 0; $i < $_POST['PRows']; $i++) {
        $producto[$i]['codigoProducto'] = $_POST['PCodigo'][$i];
        $producto[$i]['cantidadProducto'] = $_POST['PCantidad'][$i];
        $producto[$i]['montoUnitario'] = $_POST['PPrecio'][$i];
        $producto[$i]['uniVenta'] = $_POST['PUnimed'][$i];
        $producto[$i]['costoUnitario'] = $_POST['PCosto'][$i];
        $producto[$i]['descripcionProducto'] = $_POST['PDescripcion'][$i];
    }
	
    $cotizacion['subTotalCotizacion'] = $_POST['PSubTotal'];
    $cotizacion['totalImpuesto'] = $_POST['PImpuesto'];
    $cotizacion['descripcionImpuesto'] = $_POST['PDescImpuesto'];
    $cotizacion['porcentajeImpuesto'] = $_POST['PIva'];
    $cotizacion['totalCotizacion'] = $_POST['PTotal'];	

    $resServ = $soapclient->call('setCotizacion', array("cotizacion" => $cotizacion, "productos" => $producto));
    $_SESSION['numeroCotizacion'] = $resServ['numero'];
    if ($soapclient->fault) {
        $mensaje = $soapclient->faultstring;
        $_SESSION['numeroCotizacion'] = "";
    } else {
        $sError = $soapclient->getError();
        if ($sError) {
            $mensaje = 'Error:' . $sError;
            $_SESSION['numeroCotizacion'] = "";
        }
    }

$titulo = "Nueva Cotizacion #".$_SESSION['numeroCotizacion'];

$mensaje = "
<table width='800px' align='center'>
    <th>El vendedor: ".$_SESSION["usuario"]." ha creado una nueva cotizaci&oacute;n con el n&uacute;mero: ".$_SESSION['numeroCotizacion']."</th>
    <tr>
        <td>
          <h1>Informaci&oacute;n del Cliente</h1>
           <table width='800px'>
                <tbody>
                    <tr>
                        <td width='20%' style='text-align: right'>Nombre</td>
                        <td>".$cotizacion['nombreCliente']."</td>
                    </tr>
                    <tr>
                        <td style='text-align: right'>Contacto</td>
                        <td>".$cotizacion['contactoCliente']."</td>
                    </tr>
                    <tr>
                        <td style='text-align: right'>Direcci&oacute;n</td>
                        <td>".$cotizacion['direccionCliente']."</td>
                    </tr>
                    <tr>
                        <td style='text-align: right'>Tel&eacute;fono</td>
                        <td>".$cotizacion['telefonoCliente']."</td>
                    </tr>
                    <tr>
                        <td style='text-align: right'>Rif</td>
                        <td>".$cotizacion['rifCliente']."</td>
                    </tr>
                </tbody>
            </table>
            <h1>Informaci&oacute;n del Producto</h1>
            <table width='800px' style='border-collapse: collapse;border-spacing: 0;margin-bottom: 20px;'>
              <thead>
                  <tr>
                      <th>No</th>
                      <th style='text-align: center'>C&oacute;digo</th>
                      <th style='text-align: center'>Descripci&oacute;n</th>
                      <th style='text-align: center'>Cantidad</th>
                      <th style='text-align: center'>Precio Unitario</th>
                      <th style='text-align: center'>Precio Total</th>
                  </tr>
              </thead>
              <tbody>";
                    $j = 1;
		    for ($i = 0; $i < $_POST['PRows']; $i++) { 
      $mensaje .= "<tr id='fila_".$j."'>
                      <td>".$j."</td>
                      <td>".$producto[$i]['codigoProducto']."</td>
                      <td>".$producto[$i]['descripcionProducto']."</td>
                      <td>".$producto[$i]['cantidadProducto']."</td>
                      <td>".$producto[$i]['montoUnitario']."</td>
                      <td>".($producto[$i]['montoUnitario']*$producto[$i]['cantidadProducto'])."</td>        
        	   </tr>";
    		        $j++;
		    }
              $mensaje .= "</tbody>
              <tfoot>
                  <tr>
                      <td colspan='6'><br /></td>
                  </tr>
                  <tr>
                      <td rowspan='3' colspan='2' valign='top'>
                          Fecha: ".date('d-m-Y')."
                      </td>
                      <td rowspan='3' valign='top'>
                          <div align='right'><span>".$_SESSION["usuario"]."</span></div><br />
                          <div align='right'><span>Contado</span></div>
                      </td>
                      <td rowspan='3'>&nbsp;</td>
                      <td>Sub Total</td>
                      <td>".$cotizacion['subTotalCotizacion']."</td>
                  </tr>
                  <tr>
                      <td>Impuestos 16%</td>
                      <td>".$cotizacion['totalImpuesto']."</td>
                  </tr>
                  <tr>
                      <td>TOTAL</td>
                      <td>".$cotizacion['totalCotizacion']."</td>
                  </tr>
              </tfoot>
          </table>
        </td>
    </tr>
</table>";

    require_once('swift/lib/swift_required.php');
    //Datos del usaurio de correo electronico				
    $smtp = "mail.miurabike.com";
    $port = 25;
    $usr = "info@miurabike.com";
    $pass = "FILFDos"; 

    //Datos del envio a una sola persona
    
    //$mail_to = array("ceduher@hotmail.com");
    //Datos de envio a varias personas
//if($cotizacion['emailCliente'] != ''){
  //  $mail_to = array("bikemiura33@yahoo.com", "giulianozamora2001@hotmail.com", "miura1998@yahoo.es", "bicicletasmiura1959@gmail.com", $cotizacion['emailCliente']);
//}else{
    $mail_to = array("bikemiura33@yahoo.com", "giulianozamora2001@hotmail.com", "miura1998@yahoo.es", "bicicletasmiura1959@gmail.com");
//}
    $cc_to = array("vsilva@swsnet.com.ve", "soporte@sws.com.ve");

    $connection = Swift_SmtpTransport::newInstance($smtp, $port);
    $connection->setUsername($usr);
    $connection->setPassword($pass);

    $mailer = Swift_Mailer::newInstance($connection);
    $message = Swift_Message::newInstance($titulo);               
    $message->setBody($mensaje, 'text/html');
    $message->setFrom(array($usr => "miurabike.com"));
    $message->setTo($mail_to);
    $message->setCc($cc_to);
    $mailer->send($message, $failures);
    $statusCot = true;
}
header("Location: cot.php?statusCot=$statusCot");
?>