<?php
require_once('includes/nusoap.php');
define(URL, 'http://localhost/miurabike/nusoap/server.php');

$server = new soap_server;
$server->configurewsdl('MiuraBike2'); //nombre del web service

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
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('listClientes');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar.');
}

function listProductos() {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('listProductos');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function setCotizacion($cotizacion, $productos) {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('setCotizacion', array("cotizacion" => $cotizacion, "productos" => $productos));
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listTipoPago() {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('listTipoPago');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listVendedores() {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('listVendedores');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getIva() {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('getIva');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getCambioMoneda() {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('getCambioMoneda');
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function getUsuario($usuario, $clave) {
    if (getSeguridad ()) {
        $soapclient = new nusoap_client(URL);
        $soapclient->setCredentials("MiuraBike2011", "SwsNet2011", "basic");
        $sError = $soapclient->getError();
        if ($sError) {
            return new soap_fault('Client', '', 'No se pudo realizar la operación.');
        }
        $result = $soapclient->call('getUsuario', array("usuario" => $usuario, "clave" => $clave));
        if ($soapclient->fault) {
            return new soap_fault('Client', '', $soapclient->faultstring);
        } else {
            $sError = $soapclient->getError();
            if ($sError) {
                return new soap_fault('Client', '', 'Error:' . $sError);
            }
        }
        return $result;
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
//Registrando funcion Iva
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