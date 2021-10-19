<?php
session_start();
if(!isset($_SESSION['session']) || $_SESSION['session'] != true || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == "") {
    header("Location: index.php");
}
if(isset($_SESSION['numeroCotizacion']) && $_SESSION['numeroCotizacion'] != "") {

    echo "<script>alert('Se ha creado la cotización con el número: ".$_SESSION['numeroCotizacion']."')</script>";
    $_SESSION['numeroCotizacion'] = "";

}

include "include/url.php";
//Inicio del Webservice
require_once('nusoap/includes/nusoap.php');
$soapclient = new nusoap_client($url);
$soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");
$sError = $soapclient->getError();

$listTipoPago = $soapclient->call('listTipoPago');
$_SESSION['listTipoPago'] = $listTipoPago;

$listVendedores = $soapclient->call('listVendedores');
$_SESSION['listVendedores'] = $listVendedores;

$getIva = /*$soapclient->call('getIva')*/16;
$_SESSION['getIva'] = $getIva;

if ($soapclient->fault) {
    $mensaje = $soapclient->faultstring;
} else {
    $sError = $soapclient->getError();
    if ($sError) {
        $mensaje = 'Error:' . $sError;
    }
}

?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Cotizaciones en Línea - Miura Bike</title>
        <link rel="stylesheet" href="assets/stylesheets/master.css" />
        <script language="javascript" type="text/javascript" src="assets/javascripts/jquery-1.3.2.min.js"></script>
        <script type="text/javascript">
            function popUp(pagina) {
                window.open(pagina, '_blank', 'scrollbars=yes, resizable=yes, width=950, height=750');
            }
            function redondeo(numero) {
                original = parseFloat(numero);
                result = Math.round(original*100)/100 ;
                return result;
            }
            function calculaRow(row) {
                PCantidad = document.getElementById("PCantidad_" + row);
                PCantidad.value = PCantidad.value.replace(/^\s*|\s*$/g,"");
                if(PCantidad.value == "") {
                    PCantidad.value = 1;
                }
                PTotalRow = document.getElementById("PTotal_" + row);
                PPrecio = document.getElementById("PPrecio_" + row);
                if (PTotalRow != null && PCantidad != null && PPrecio != null) {
                    if(PCantidad.value != "" && PPrecio.value != "") {
                        PTotalRow.value = redondeo(parseInt(PCantidad.value) * parseFloat(PPrecio.value));
                    }
                }
                calculaTotal();                
            }
            function calculaTotal() {
                PSubTotal = document.getElementById("PSubTotal");
                PIva = document.getElementById("PIva");
                PImpuesto = document.getElementById("PImpuesto");
                PTotal = document.getElementById("PTotal");
                PRows = document.getElementById("PRows");
                SubTotal = 0;                
                for (i = 1; i <= parseInt(PRows.value); i++) {
                    PRow = document.getElementById("PTotal_" + i);
                    if(PRow != null) {
                        SubTotal += (PRow.value != "" && PRow.value != "NaN") ? redondeo(parseFloat(PRow.value)) : 0;
                    }
                }
                PSubTotal.value = redondeo(SubTotal);
                PImpuesto.value = redondeo(parseFloat(PSubTotal.value) * (parseFloat(PIva.value)/100));
                PTotal.value = redondeo(parseFloat(PSubTotal.value) + parseFloat(PImpuesto.value));
            }
            function fn_agregar() {
                cant = $("#PRows").val();
                codigo = $("#PCodigo_" + cant);
                total = $("#PTotal_" + cant);
                if(codigo != null && total != null && codigo.val() != "" && total.val() != "") {
                    $("#PRows").val(parseInt($("#PRows").val()) + 1);
                    cant = $("#PRows").val();
                    cadena = "<tr id='fila_"+ cant +"'>";
                    cadena = cadena + "<td width='40px'><img src='assets/images/filter.png' onclick='javascript: popUp(\"listProductos.php?l=" + cant + "\")' /></td>";
                    cadena = cadena + "<td>"+ cant +"</td>";
                    cadena = cadena + "<td><input type='text' size='12' id='PCodigo_" + cant + "' name='PCodigo[" + (parseInt(cant) -1) + "]' readonly/></td>";
                    cadena = cadena + "<td><input type='text' size='30' id='PDescripcion_" + cant +"' name='PDescripcion[" + (parseInt(cant) -1) + "]' readonly/></td>";
                    cadena = cadena + "<td><input type='text' size='10' id='PCantidad_" + cant + "' name='PCantidad[" + (parseInt(cant) -1) + "]' onblur='javascript: calculaRow(\""+cant+"\")' /></td>";
                    cadena = cadena + "<td><input type='text' size='10' id='PPrecio_" + cant + "' name='PPrecio[" + (parseInt(cant) -1) + "]' readonly/></td>";
                    cadena = cadena + "<td><input type='text' size='10' id='PTotal_" + cant + "' name='PTotal[" + (parseInt(cant) -1) + "]' readonly/><input type='hidden' id='PCosto_" + cant + "' name='PCosto[" + (parseInt(cant) -1) + "]' /><input type='hidden' id='PUnimed_" + cant + "' name='PUnimed[" + (parseInt(cant) -1) + "]' /></td>";
                    cadena = cadena + "</tr>";
                    $("#grilla tbody").append(cadena);
                } else {
                    alert("Debe completar los datos del producto");
                }
            };
            function fn_dar_eliminar(){
                cant = $("#PRows").val();
                fila = $("#fila_" + cant);
                if (confirm("¿Desea eliminar el último producto?")){
                    fila.fadeOut("normal", function(){fila.remove();});
                    $("#PRows").val(parseInt($("#PRows").val()) - 1);
                    calculaTotal();
                }
            };
            function validaCot() {
                id = $("#CId");
                cant = $("#PRows").val();
                codigo = $("#PCodigo_" + cant);
                total = $("#PTotal_" + cant);
                tipoPago = $("#tipoPago");
                vendedor = $("#vendedor");
                if(id!= null && id.val() != "") {
                    if(codigo != null && codigo.val() != "" && total != null && total.val() != "" && parseInt(cant) > 0) {
                        if (tipoPago != null && tipoPago.val() != "" && vendedor != null && vendedor.val() != "") {
/*                             document.getElementById("btnSendCot").disabled = true; */
                            return true;
                        } else { alert("Debe completar los datos Tipo Pago y Vendedor"); return false; }
                    } else { alert("Debe completar los datos del Producto"); return false; }
                } else { alert("Debe completar los datos del Cliente"); return false; }
                return false;
            }
            $(document).ready(function(){
                //Obtiene respuesta del lado del script que el proceso concluyo satisfactoriamente
                var changeBtnCot = '';
                <?php 
                    $statusCot = '';
                    if(isset($_GET['statusCot'])){
                        $statusCot = $_GET['statusCot'];
                    }
                ?>
                //Setea el valor que trae de respuesta para pasar por el condicional
                changeBtnCot = $("#keyNewCot").val();

/*                 if(changeBtnCot === 'true' || changeBtnCot != ''){
                    //Habilita el boton
                    document.getElementById("btnSendCot").disabled = false;
                }else{
                    //Deshabilita el boton
                    document.getElementById("btnSendCot").disabled = true;
                } */

                $("#vendedor").change(function(){
                    $("#nomVen").val($(this).find("option[value=" + $(this).val() + "]").text());
                });
                $("#tipoPago").change(function(){
                    $("#tipPag").val($(this).find("option[value=" + $(this).val() + "]").text());
                });
                $(".signout").click(function(){
                    if(confirm("¿Está seguro que desea salir?")) {
                        $.post("logoff.php", {logoff: true },
						function(data){
							if(data==true){
								document.location.href="index.php";
							}else{
								$('#mens_signin').html(data);
							}
						});
                    }
                })
            });
        </script>
        <script src="https://code.jquery.com/jquery-1.8.0.min.js"integrity="sha256-jFdOCgY5bfpwZLi0YODkqNXQdIxKpm6y5O/fy0baSzE=" crossorigin="anonymous"></script>
	    <script type="text/javascript">
            var newjq = jQuery.noConflict();
            newjq(document).ready(function() {
                newjq("#habilitador").click(function () {
                    var myData = 'llaveSistema='+ newjq("#opcion").val(); //build a post data structure
                    jQuery.ajax({
                        type: "POST",
                        url: "response.php",
                        dataType:"text",
                        data:myData,
                        success:function(response){
                            location.reload();
                        },
                        error:function (xhr, ajaxOptions, thrownError){}
                    });
                });
            });
        </script>
    </head>
    <body>
        <input type="hidden" id="keyNewCot" value="<?php echo $statusCot; ?>">
        <div class="prueba"><img src="assets/images/pedido_01.jpg" width="1420" height="244"></div>
        Bienvenido <?php echo $_SESSION['usuario'] ?> &nbsp; <a href="#" class="signout"><strong>Cerrar sesión</strong></a>
        <div align="center">
            <table width="800px" align="center"><?php if( $_SESSION['tipo'] == 'A'){ ?>
                <tr>
                  <td height="30" valign="middle"><table width="327" height="30" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="134" height="30">Habilitar Sistema:</td>
                      <td width="193">
                      <?php
						include_once("config.php");//include db configuration file
						
						$link = mysql_connect($hostname, $username, $password) or die('No se pudo conectar: ' . mysql_error());
						mysql_select_db($databasename) or die('No se pudo seleccionar la base de datos');
						
						// Realizar una consulta MySQL
						$query = 'SELECT acceso FROM acceso;';
						$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
						while($fila=mysql_fetch_array($result)){
							if($fila[0] == 1){ //Habilitado ?>
							  <input type="hidden" name="opcion" id="opcion" value="<?php echo 0;?>">
							  <input type="button" name="habilitador" id="habilitador" value="<?php echo "Deshabilitar";?>">
					  <?php }elseif($fila[0] == 0){ //Deshabilitado ?>
							  <input type="hidden" name="opcion" id="opcion" value="<?php echo 1;?>">
							  <input type="button" name="habilitador" id="habilitador" value="<?php echo "Habilitar";?>">
					  <?php }else{
								echo "Un mutante!!";
							}
						}
						// Liberar resultados
						mysql_free_result($result);
						mysql_close($link);	
					  ?></td>
                    </tr>
                  </table></td>
                </tr><?php }?>
                <tr>
                    <td>
                        <h1>Información del Cliente</h1>
                        <form id="cotizacion" name="cotizacion" action="newCot.php" method="post" onSubmit="return validaCot()">
                            <img src="assets/images/filter.png" onClick="javascript: popUp('listClient.php')" />Buscar Cliente
                            <input type="hidden" id="CId" name="CId" />
                            <input type="hidden" id="CEmail" name="CEmail" />
                            <table width="800px">
                                <tbody>
                                    <tr>
                                        <td width="20%" style="text-align: right">Nombre</td>
                                        <td><input type="text" id="CNombre" name="CNombre" size="40" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">Contacto</td>
                                        <td><input type="text" id="CContacto" name="CContacto" size="40" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">Dirección</td>
                                        <td><textarea cols="45" rows="3" id="CDireccion" name="CDireccion" readonly ></textarea></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">Teléfono</td>
                                        <td><input type="text" id="CTelefono" name="CTelefono" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">Rif</td>
                                        <td><input type="text" id="CRif" name="CRif" readonly/></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h1>Información del Producto</h1>
                            <input type="hidden" id="PRows" name="PRows" value="1" />
                            <input type="hidden" id="PIva" name="PIva" value="16" /><!--<?php /*echo $getIva['porcentaje']*/ ?>-->
                            <input type="hidden" id="PDescImpuesto" name="PDescImpuesto" value="<?php echo $getIva['descripcion'] ?>" />
                            <table width="800px" id="grilla" class="lista">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th style="text-align: center">No</th>
                                        <th style="text-align: center">Código</th>
                                        <th style="text-align: center">Descripción</th>
                                        <th style="text-align: center">Cantidad</th>
                                        <th style="text-align: center">Precio Unitario</th>
                                        <th style="text-align: center">Precio Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="fila_1">
                                        <td width="40px"><img src="assets/images/filter.png" onClick="javascript: popUp('listProductos.php?l=1')" /></td>
                                        <td>1</td>
                                        <td><input type="text" size="12" id="PCodigo_1" name="PCodigo[0]" readonly/></td>
                                        <td><input type="text" size="30" id="PDescripcion_1" name="PDescripcion[0]" readonly/></td>
                                        <td><input type="text" size="10" id="PCantidad_1" name="PCantidad[0]" onBlur="javascript: calculaRow('1')" /></td>
                                        <td><input type="text" size="10" id="PPrecio_1" name="PPrecio[0]" readonly/></td>
                                        <td>
                                            <input type="text" size="10" id="PTotal_1" name="PTotal[0]" readonly/>
                                            <input type="hidden" id="PCosto_1" name="PCosto[0]" />
                                            <input type="hidden" id="PUnimed_1" name="PUnimed[0]" />
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7"><br /></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3" colspan="3" valign="top">
                                            <img src="assets/images/add.png" onClick="javascript: fn_agregar()" /> Agregar Producto <br />
                                            <img src="assets/images/delete.png" onClick="javascript: fn_dar_eliminar()" /> Eliminar Producto
                                            <br /> <br />
                                            Fecha: <?php echo date("d-m-Y") ?>
                                        </td>
                                        <td rowspan="3" valign="top">
                                            <div align="right">
                                                <input type="hidden" id="nomVen" name="CNomVen" />
                                                <select id="vendedor" name="vendedor" style="width: 200px">
                                                    <option value="">Vendedor</option>
                                                    <?php foreach ($listVendedores as $row): ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['id'] . " - " .$row['nombre'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div> <br />
                                            <div align="right">
                                                <input type="hidden" id="tipPag" name="CTipPag" />
                                                <select id="tipoPago" name="tipoPago" style="width: 200px">
                                                    <option value="">Forma de Pago</option>
                                                    <?php foreach ($listTipoPago as $row): ?>
                                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['descripcion'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td rowspan="3">&nbsp;</td>
                                        <td>Sub Total</td>
                                        <td><input type="text" size="10" id="PSubTotal" name="PSubTotal" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>Impuestos</td>
                                        <td><input type="text" size="10" id="PImpuesto" name="PImpuesto" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL</td>
                                        <td><input type="text" size="10" id="PTotal" name="PTotal" readonly/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"><br/>
                                            <div align="center"><input id="btnSendCot" type="submit" value="Crear Cotización" /></div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>