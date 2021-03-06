<?php
require_once('includes/nusoap.php');
$server = new soap_server;
$server->configurewsdl('MiuraBike'); //nombre del web service

/**************LISTA DE CLIENTES *********/
/* * ********** REGISTRANDO EL ARRAY A DEVOLVER ************* */
$server->wsdl->addComplexType(
        'ArregloListaClientes', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definición del tipo secuencia(all|sequence|choice)
        'SOAP-ENC:Array', // Restricted Base
        array(),
        array(
            array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:ListaClientes[]') // Atributos
        ),
        'tns:ListaClientes'
);
/* * ********** REGISTRANDO LA ESTRUCTURA DEL ARREGLO A DEVOLVER************* */
$server->wsdl->addComplexType(
        'ListaClientes', 
        'complexType',    
        'struct',
        'all',
        '',
        array(
            'codigo' => array('name' => 'codigo', 'type' => 'xsd:int'),
            'compania' => array('name' => 'compania', 'type' => 'xsd:string'),
            'rif' => array('name' => 'rif', 'type' => 'xsd:string'),
            'contacto' => array('name' => 'contacto', 'type' => 'xsd:string'),
            'direccion' => array('name' => 'direccion', 'type' => 'xsd:string'),
            'telefono' => array('name' => 'telefono', 'type' => 'xsd:string')
        )
);

/***************LISTA PRODUCTOS*****************/
$server->wsdl->addComplexType(
        'ArregloListaProductos', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definición del tipo secuencia(all|sequence|choice)
        'SOAP-ENC:Array', // Restricted Base
        array(),
        array(
            array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:ListaProductos[]') // Atributos
        ),
        'tns:ListaProductos'
);
$server->wsdl->addComplexType(
        'ListaProductos',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'parte' => array('name' => 'parte', 'type' => 'xsd:string'),
            'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
            'marca' => array('name' => 'marca', 'type' => 'xsd:string'),
            'costo' => array('name' => 'costo', 'type' => 'xsd:float'),
            'precio1' => array('name' => 'precio1', 'type' => 'xsd:float'),
            'precio2' => array('name' => 'precio2', 'type' => 'xsd:float'),
            'precio3' => array('name' => 'precio3', 'type' => 'xsd:float'),
            'precio4' => array('name' => 'precio4', 'type' => 'xsd:float')
        )
);
/************** COTIZACION ***********/
$server->wsdl->addComplexType(
        'ArrCotizacion',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'numero' => array('name' => 'numero', 'type' => 'xsd:int')
        )
);
/**************LISTA DE TIPOS DE PAGO ***********/
$server->wsdl->addComplexType(
        'ArregloListaTipoPago', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definición del tipo secuencia(all|sequence|choice)
        'SOAP-ENC:Array', // Restricted Base
        array(),
        array(
            array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:ListaTipoPago[]') // Atributos
        ),
        'tns:ListaTipoPago'
);
$server->wsdl->addComplexType(
        'ListaTipoPago',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string')
        )
);
/**************LISTA DE VENDEDORES***********/
$server->wsdl->addComplexType(
        'ArregloListaVendedores', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definición del tipo secuencia(all|sequence|choice)
        'SOAP-ENC:Array', // Restricted Base
        array(),
        array(
            array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:ListaVendedores[]') // Atributos
        ),
        'tns:ListaVendedores'
);
$server->wsdl->addComplexType(
        'ListaVendedores',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'nombre' => array('name' => 'nombre', 'type' => 'xsd:string')
        )
);
/**************IVA***********/
$server->wsdl->addComplexType(
        'Iva',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
            'porcentaje' => array('name' => 'porcentaje', 'type' => 'xsd:float')
        )
);
/**************CAMBIO MONEDA***********/
$server->wsdl->addComplexType(
        'CambioMoneda',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'cambio' => array('name' => 'cambio', 'type' => 'xsd:float')
        )
);
/**************USUARIO***********/
$server->wsdl->addComplexType(
        'Usuario',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
            'login' => array('name' => 'login', 'type' => 'xsd:string')
        )
);

function listClientes() {
    if (getSeguridad ()) {
        include("../include/cliente.php");
        if ($linkCliente === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = " SELECT ID, Codigo, Compania, Contacto, Rif, Direccion, Ciudad, Estado, Pais, Telefono, Fax
                         FROM   PhoneList
                         WHERE  Codigo < 100000
                         ORDER BY ID DESC";
                $rs_access = odbc_exec($linkCliente, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $num_rows = odbc_num_rows($rs_access);
                $i = 0;
                while ($row = odbc_fetch_object($rs_access)) {
                    $toc[$i]['codigo'] = number_format($row->Codigo,0);
                    $toc[$i]['compania'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Compania)));
                    $toc[$i]['rif'] = $row->Rif;
                    $toc[$i]['contacto'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Contacto)));
                    $toc[$i]['direccion'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Direccion)));
                    $toc[$i]['telefono'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Telefono)));
                    $i++;
                }
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listProductos() {
    if (getSeguridad ()) {
        include_once("../include/producto.php");
        if ($linkProducto === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT  P.Parte, P.Descripción as Descripcion,
                                P.Marca, I.UltimoCostoBS as Costo,
                                P.Metodo1, P.Metodo2, P.Metodo3, P.Metodo4
                        FROM    Productos as P, Inventario as I
                        WHERE   P.Parte = I.Codigo
                        ORDER   BY P.Marca, P.Descripción";
                $rs_access = odbc_exec($linkProducto, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $num_rows = odbc_num_rows($rs_access);
                $i = 0;
                while ($fila = odbc_fetch_object($rs_access)) {
                    $toc[$i]['parte'] = $fila->Parte;
                    $toc[$i]['descripcion'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($fila->Descripcion)));
                    $toc[$i]['marca'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($fila->Marca)));
                    $toc[$i]['costo'] = number_format($fila->Costo, 2, ".", "");
                    $toc[$i]['precio1'] = number_format(((100 * $fila->Costo)/(100 -$fila->Metodo1)), 2, ".", "");
                    $toc[$i]['precio2'] = number_format(((100 * $fila->Costo)/(100 -$fila->Metodo2)), 2, ".", "");
                    $toc[$i]['precio3'] = number_format(((100 * $fila->Costo)/(100 -$fila->Metodo3)), 2, ".", "");
                    $toc[$i]['precio4'] = number_format(((100 * $fila->Costo)/(100 -$fila->Metodo4)), 2, ".", "");
                    $i++;
                }
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function setCotizacion($cotizacion, $productos) {
    if (getSeguridad ()) {
        include_once("../include/cotizacion.php");
        include_once("../include/tabla.php");
        if($linkCotizacion === false || $linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT MAX(Numero) + 1 as maximo FROM Facturas";
                $rs_access = odbc_exec($linkCotizacion, $sql);
                $res = odbc_fetch_object($rs_access);
                $numCotizacion = number_format($res->maximo, 0, ".", "");
                
                $sql = "SELECT TOP 1 CambioBSUS as cambio FROM CambioMoneda ORDER BY ID DESC";
                $rs_access = odbc_exec($linkTabla, $sql);
                $res = odbc_fetch_object($rs_access);
                $cambioMoneda = number_format($res->cambio, 2, ".", "");
                
                $sql = "INSERT INTO Facturas   (Numero,
                                                NumeroRevision,
                                                FechaFactura,           
                                                FechaVence,             
                                                CodigoFacturar,         
                                                NombreFacturar,         
                                                ContactoFacturar,       
                                                DireccionFacturar,      
                                                TelefonoFacturar,       
                                                Vendedor,               
                                                DocumentoOrigenTipo,    
                                                FormaPagoDescripcion,  
                                                Observaciones1,         
                                                Renglones,              
                                                SubTotal,               
                                                Impuesto,               
                                                ImpuestoDescripcion,    
                                                ImpuestoOtro,           
                                                Total,                  
                                                Status,                 
                                                Periodo,                
                                                Cambio,                 
                                                FechaRequerida,         
                                                FechaDespacho,          
                                                UltimaFecha,            
                                                MontoEScritoBS,
                                                OrdenDeCompraFecha)                                             
                                    VALUES    ( " . $numCotizacion . ",
                                                " . $numCotizacion . ",
                                                '" . date("d/m/Y") . "',
                                                '" . date("d/m/Y") . "',
                                                " . $cotizacion['codigoCliente'] . ",
                                                '" . $cotizacion['nombreCliente'] . "',
                                                '" . $cotizacion['contactoCliente'] . "',
                                                '" . $cotizacion['direccionCliente'] . "',
                                                '" . $cotizacion['telefonoCliente'] . "',
                                                " . $cotizacion['idVendedor'] . ",
                                                13,
                                                '" . $cotizacion['descripcionTipoPago']. "',
                                                'COTIZACION CREADA DESDE LA WEB',
                                                " . $cotizacion['cantidadRenglones'] . ",
                                                " . $cotizacion['subTotalCotizacion'] . ",
                                                " . $cotizacion['totalImpuesto'] .",
                                                '" . $cotizacion['descripcionImpuesto'] . "',
                                                " . $cotizacion['porcentajeImpuesto'] . ",
                                                " . $cotizacion['totalCotizacion'] . ",
                                                0,
                                                10,
                                                " . $cambioMoneda . ",
                                                '" . date("d/m/Y") . "',
                                                '" . date("d/m/Y") . "',
                                                '" . date("d/m/Y H:i:s") . "',
                                                '',
                                                '" . date("d/m/Y") . "' )";
                $rs_access = odbc_exec($linkCotizacion, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $i = 0;
                foreach ($productos as $producto) {
                    $i ++;
                    $sql = " INSERT INTO Detalle    (Numero,
                                                     NumeroRevision,
                                                     Renglon,
                                                     Codigo,
                                                     Cantidad,
                                                     MontoUnitario,
                                                     Costo,
                                                     SujetoAImpuesto,
                                                     DescripcionProducto,
                                                     Codigo2,
                                                     Moneda,
                                                     Cambio,
                                                     Vendedor)
                                           VALUES   (" . $numCotizacion . ",
                                                     " . $numCotizacion . ",
                                                     " . $i . ",
                                                     '" . $producto['codigoProducto'] . "',
                                                     " . $producto['cantidadProducto'] . ",
                                                     " . $producto['montoUnitario'] . ",
                                                     " . $producto['costoUnitario'] . ",
                                                     -1,
                                                     '" . $producto['descripcionProducto'] . "',
                                                     " . $cotizacion['porcentajeImpuesto'] . ",
                                                     0,
                                                     " . $cambioMoneda . ",
                                                     " . $cotizacion['idVendedor'] .")";
                    $rs_producto = odbc_exec($linkCotizacion, utf8_decode($sql));
                }
                $toc['numero'] = $numCotizacion;
                $toc['sql'] = $sql2;
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listTipoPago() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT ID, Descripcion FROM FormasPago 
                        WHERE Descripcion like '%Contado%' or Descripcion like '%Crédito%15%' or Descripcion like '%Crédito%30%'
                        ORDER BY ID";
                $rs_access = odbc_exec($linkTabla, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $i = 0;
                while ($fila = odbc_fetch_object($rs_access)) {
                    $toc[$i]['id'] = number_format($fila->ID, 0);
                    $toc[$i]['descripcion'] = utf8_encode($fila->Descripcion);
                    $i++;
                }
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listVendedores() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT ID, Nombre FROM vendedores WHERE ID > 0 ORDER BY ID";
                $rs_access = odbc_exec($linkTabla, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $i = 0;
                while ($fila = odbc_fetch_object($rs_access)) {
                    $toc[$i]['id'] = number_format($fila->ID, 0);
                    $toc[$i]['nombre'] = utf8_encode($fila->Nombre);
                    $i++;
                }
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getIva() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT TOP 1 Impuesto, Descripcion, Porcentaje FROM Impuestos ORDER BY Impuesto DESC";
                $rs_access = odbc_exec($linkTabla, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }                
                $fila = odbc_fetch_object($rs_access);
                $toc['id'] = number_format($fila->Impuesto, 0);
                $toc['descripcion'] = utf8_encode($fila->Descripcion);
                $toc['porcentaje'] = number_format($fila->Porcentaje, 2, ".", "");
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getCambioMoneda() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT ID, CambioBSUS FROM CambioMoneda";
                $rs_access = odbc_exec($linkTabla, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $fila = odbc_fetch_object($rs_access);
                $toc['id'] = number_format($fila->ID, 0);
                $toc['cambio'] = number_format($fila->CambioBSUS, 2, ".", "");
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getUsuario($usuario, $clave) {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = "SELECT  top 1 ID, Nombre, Login, Clave
                        FROM    Vendedores
                        WHERE   ID > 0 AND Tipo = 2
                                AND Login = '".$usuario."' AND Clave = '".$clave."'";
                $rs_access = odbc_exec($linkTabla, utf8_decode($sql));
                if ($rs_access === false) {
                    return new soap_fault('Client', '', 'Error en la consulta');
                }
                $toc['id'] = 0;
                $toc['nombre'] = "";
                $toc['login'] = "";
                while ($fila = odbc_fetch_object($rs_access)) {
                    $toc['id'] = number_format($fila->ID, 0);
                    $toc['nombre'] = utf8_encode($fila->Nombre);
                    $toc['login'] = utf8_encode($fila->Login);
                }
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getSeguridad() {
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_USER'] == "MiuraBike2011" && $_SERVER['PHP_AUTH_PW'] == "SwsNet2011") {
        return true;
    } else return false;
}

$rawPost = strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0 ? (isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input")) : NULL;
//Registrando funcion listClientes
$server->register(
        'listClientes', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:ArregloListaClientes')   //Datos de Salida
);
//Registrando funcion listProductos
$server->register(
        'listProductos', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:ArregloListaProductos')   //Datos de Salida
);
//Registrando funcion setCotizacion
$server->register(
        'setCotizacion', // Nombre del Metodo
        array('cotizacion' => 'xsd:array', 'productos' => 'xsd:array'), // Parametros de Entrada
        array('return' => 'tns:ArrCotizacion')   //Datos de Salida
);
//Registrando funcion listTipoPago
$server->register(
        'listTipoPago', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:ArregloListaTipoPago')   //Datos de Salida
);
//Registrando funcion listVendedores
$server->register(
        'listVendedores', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:ArregloListaVendedores')   //Datos de Salida
);
//Registrando funcion getIva
$server->register(
        'getIva', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:Iva')   //Datos de Salida
);
//Registrando funcion getCambioMoneda
$server->register(
        'getCambioMoneda', // Nombre del Metodo
        array(), // Parametros de Entrada
        array('return' => 'tns:CambioMoneda')   //Datos de Salida
);
//Registrando funcion getUsuario
$server->register(
        'getUsuario', // Nombre del Metodo
        array('usuario' => 'xsd:string', 'clave' => 'xsd:string'), // Parametros de Entrada
        array('return' => 'tns:Usuario')   //Datos de Salida
);
$server->service($rawPost);
?>