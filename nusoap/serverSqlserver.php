<?php
require_once('includes/nusoap.php');
 dirname(__FILE__) .
set_time_limit(0);

$server = new soap_server;
$server->configurewsdl('MiuraBike'); //nombre del web service

/**************LISTA DE CLIENTES *********/
/* * ********** REGISTRANDO EL ARRAY A DEVOLVER ************* */
$server->wsdl->addComplexType(
        'ArregloListaClientes', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definici�n del tipo secuencia(all|sequence|choice)
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
            'codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),/*xsd:int*/
            'compania' => array('name' => 'compania', 'type' => 'xsd:string'),
            'rif' => array('name' => 'rif', 'type' => 'xsd:string'),
			'nit' => array('name' => 'nit', 'type' => 'xsd:string'),
            'contacto' => array('name' => 'contacto', 'type' => 'xsd:string'),
            'direccion' => array('name' => 'direccion', 'type' => 'xsd:string'),
            'telefono' => array('name' => 'telefono', 'type' => 'xsd:string'),
			'email' => array('name' => 'email', 'type' => 'xsd:string')
        )
);
/***************LISTA PRODUCTOS*****************/
$server->wsdl->addComplexType(
        'ArregloListaProductos', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definici�n del tipo secuencia(all|sequence|choice)
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
			'unimed' => array('name' => 'unimed', 'type' => 'xsd:string'),
            'costo' => array('name' => 'costo', 'type' => 'xsd:float'),
            'precio1' => array('name' => 'precio1', 'type' => 'xsd:float'),
            'precio2' => array('name' => 'precio2', 'type' => 'xsd:float'),
            'precio3' => array('name' => 'precio3', 'type' => 'xsd:float'),
            'precio4' => array('name' => 'precio4', 'type' => 'xsd:float'),
			'imagen' => array('name' => 'imagen', 'type' => 'xsd:string'),
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
        '', // definici�n del tipo secuencia(all|sequence|choice)
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
            'id' => array('name' => 'id', 'type' => 'xsd:string'),
            'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
			'dias_cred' => array('name' => 'dias_cred', 'type' => 'xsd:int')
        )
);
/**************LISTA DE VENDEDORES***********/
$server->wsdl->addComplexType(
        'ArregloListaVendedores', // Nombre
        'complexType', // Tipo de Clase
        'array', // Tipo de PHP
        '', // definici�n del tipo secuencia(all|sequence|choice)
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
            'login' => array('name' => 'login', 'type' => 'xsd:string'),
			'tipo' => array('name' => 'tipo', 'type' => 'xsd:string')
        )
);
function listClientes() {
    if (getSeguridad ()) {
        include_once("../include/conn.php");
        if ($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
        }else{
            try { 
				$tsql = "SELECT cli.co_cli as cocli, cli.cli_des as clides, cli.respons as clires, cli.email as cliemail, cli.rif as clirif,  cli.nit as clinit, cli.direc1 as dir1, cli.ciudad as dir1, cli.estado as edo, pai.pais_des as pais, cli.telefonos as telef, cli.fax as clifax FROM clientes as cli inner join paises as pai on cli.co_pais = pai.co_pais ORDER BY cli.co_cli DESC"; $stmt = sqlsrv_query( $conn, $tsql);
                if ($stmt === false) { return new soap_fault('Client', '', 'Error en la consulta'); }
                $i = 0;
                while($row = sqlsrv_fetch_array($stmt)){
                    $toc[$i]['codigo'] = utf8_encode($row['cocli']);
                    $toc[$i]['compania'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['clides']))));
                    $toc[$i]['rif'] = utf8_encode(trim($row['clirif']));
					$toc[$i]['nit'] = utf8_encode(trim($row['clinit']));
                    $toc[$i]['contacto'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row['clires'])));
                    $toc[$i]['direccion'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['dir1']))));
					$toc[$i]['email'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['cliemail']))));
                    $toc[$i]['telefono'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row['telef'])));
                    $i++;
                }
                return $toc;
				sqlsrv_free_stmt( $stmt);
				sqlsrv_close( $conn);
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    }else{
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
	}
}
function listProductos() {
    if (getSeguridad ()) {
        include_once("../include/conn.php");
        if ($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
        } else {
            try {
				$tsql = "SELECT a.co_art as parte, a.art_des as descripcion, cat.cat_des as marca, a.uni_venta as unimed,
				a.prec_vta1 as costo, a.prec_vta1 as precio1, a.prec_vta2 as precio2, a.prec_vta3 as precio3, 
				a.prec_vta4 as precio4, a.imagen1 as imagen 
				FROM art as a inner join cat_art as cat ON a.co_cat = cat.co_cat 
				WHERE a.anulado = 0 and a.tipo = 'V' ORDER BY a.co_art ASC"; $stmt = sqlsrv_query( $conn, $tsql);
				if ($stmt === false) { return new soap_fault('Client', '', 'Error en la consulta');}
				$i = 0;
				while($row = sqlsrv_fetch_array($stmt)){
					$toc[$i]['parte'] = trim($row['parte']);
					$toc[$i]['descripcion'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['descripcion']))));
					$toc[$i]['marca'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['marca']))));
					$toc[$i]['unimed'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['unimed']))));
					$toc[$i]['costo'] = number_format($row['costo'], 2, ".", "");
					$toc[$i]['precio1'] = number_format($row['costo'], 2, ".", "");/*number_format($row['precio1'], 2, ".", "");*/
					/*$toc[$i]['precio1'] = number_format(((100 * $row['costo'])/(100 -$row['precio1'])), 2, ".", "");*/
					$toc[$i]['precio2'] = number_format(((100 * $row['costo'])/(100 -$row['precio2'])), 2, ".", "");
					$toc[$i]['precio3'] = number_format(((100 * $row['costo'])/(100 -$row['precio3'])), 2, ".", "");
					$toc[$i]['precio4'] = number_format(((100 * $row['costo'])/(100 -$row['precio4'])), 2, ".", "");
					$toc[$i]['imagen'] = str_replace("\n", "", str_replace("\r", "", utf8_encode(trim($row['imagen']))));
					$i++;
				}
				return $toc;
				sqlsrv_free_stmt( $stmt);
				sqlsrv_close( $conn);
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    }else{
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
	}
}
function getGUID(){
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// 
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);//
        return $uuid;
}
function setCotizacion($cotizacion, $productos) {
    if (getSeguridad ()) {
        include_once("../include/conn.php");
        if ($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
        } else {
            try {
                $tsql01 = "SELECT MAX(fact_num) + 1 as maximo FROM cotiz_c";
 				$stmt01 = sqlsrv_query( $conn, $tsql01);
				if ($stmt01 === false) { return new soap_fault('Client', '', 'Error en la consulta');}
				$row01 = sqlsrv_fetch_array($stmt01);
                $numCotizacion = $row01['maximo'];
				
                $tsql21 = "SELECT dias_cred FROM condicio WHERE co_cond = '".$cotizacion['descripcionTipoPago']."'";
 				$stmt21 = sqlsrv_query( $conn, $tsql21);
				if ($stmt21 === false) { return new soap_fault('Client', '', 'Error en la consulta tipo pago');}
				$row21 = sqlsrv_fetch_array($stmt21);
                $diasCred = $row21['dias_cred'];	
				
				$fechaVencimiento = '';		
				
				$fecha = date('Y-m-j');
				$fechaVencimiento = strtotime ( '+'.$diasCred.' day' , strtotime ( $fecha ) ) ;
				$fechaVencimiento = date ( 'Y-m-d H:i:s' , $fechaVencimiento );

                $tsql11 = "UPDATE par_emp SET ped_num=".$numCotizacion." WHERE cod_emp='MIURA_A2'";
 				$stmt11 = sqlsrv_query( $conn, $tsql11);
				if ($stmt11 === false) { return new soap_fault('Client', '', 'Error en la consulta');}
				
                $tsql02 = "INSERT INTO cotiz_c ( 
                                            fact_num,
                                            contrib,
                                            nombre,
                                            rif,
                                            nit,
                                            status,
                                            comentario,
                                            descrip,
                                            saldo,
                                            fec_emis,
                                            fec_venc,
                                            co_cli,
                                            co_ven,
                                            co_tran,
                                            dir_ent,
                                            forma_pag,
                                            tot_bruto,
                                            tot_neto,
                                            glob_desc,
                                            tot_reca,
                                            porc_gdesc,
                                            porc_reca,
                                            total_uc,
                                            total_cp,
                                            tot_flete,
                                            monto_dev,
                                            totklu,
                                            anulada,
                                            impresa,
                                            iva,
                                            iva_dev,
                                            feccom,
                                            numcom,
                                            tasa,
                                            moneda,
                                            cta_contab,
                                            seriales,
                                            tasag,
                                            tasag10,
                                            tasag20,
                                            campo1,
                                            campo2,
                                            campo3,
                                            campo4,
                                            campo5,
                                            campo6,
                                            campo7,
                                            campo8,
                                            co_us_in,
                                            fe_us_in,
                                            co_us_mo,
                                            fe_us_mo,
                                            co_us_el,
                                            fe_us_el,
                                            revisado,
                                            trasnfe,
                                            co_sucu,
                                            rowguid,
                                            mon_ilc,
                                            otros1,
                                            otros2,
                                            otros3,
                                            salestax,
                                            origen,
                                            origen_d,
                                            sta_prod,
                                            telefono
                                        )                                             
								VALUES  ( 
											 ".$numCotizacion.",
											  1, 
											 '".$cotizacion['nombreCliente']."',
											 '".$cotizacion['rifCliente']."',
											 '".$cotizacion['nitCliente']."',
											 '0',
											 '',
											 '".$cotizacion['descPedWeb']."',
											 ".$cotizacion['totalCotizacion'].",
											 '".date("Y-m-d H:i:s")."',
											 '".$fechaVencimiento."',
											 '".$cotizacion['codigoCliente']."',
											 '".$cotizacion['idVendedor']."',
											 '000001',
											 '".$cotizacion['direccionCliente']."',
											 '".$cotizacion['descripcionTipoPago']."',
											 ".$cotizacion['subTotalCotizacion'].",
											 ".$cotizacion['totalCotizacion'].",
											 0.00,
											 0.00,
											 '',
											 '',
											 0.00,
											 0.00,
											 0.00,
											 0.00,
											 0.00,
											 0,
											 0,
											 ".$cotizacion['totalImpuesto'].",
											 0.00,
											 '".date("Y-m-d H:i:s")."',
											 0,
											 1.00000,
											 'US$',
											 '',
											 0,
											 16.00000,
											 12.00000,
											 12.00000,
											 '',
											 '',
											 '',
											 '',
											 '',
											 '',
											 '',
											 '',
											 '001',
											 '".date("Y-m-d H:i:s")."',
											 '',
											 '".date("Y-m-d H:i:s")."',
											 '',
											 '".date("Y-m-d H:i:s")."',
											 '',
											 '',
											 '000001',
											 '".getGUID()."',
											 0.00000,
											 0.00000,
											 0.00000,
											 0.00000,
											 '',
											 '',
											 '',
											 '',
											 ''
                                             )";
				$stmt02 = sqlsrv_query( $conn, $tsql02);

				if ($stmt02 === false) { 
					if( ($errors = sqlsrv_errors() ) != null) {
						foreach( $errors as $error ) {
							$str = "SQLSTATE: ".$error[ 'SQLSTATE']." - "."code: ".$error[ 'code']." - "."message: ".$error[ 'message'];
						}
					}				
                    return new soap_fault('Client', '', 'Error en la consulta Cab: '.$tsql02);
                }
                $i = 0;
                foreach ($productos as $producto) {
                    $i++;
					
					$tsql14 = "SELECT ult_cos_un, cos_pro_un FROM art WHERE co_art = '".trim($producto['codigoProducto'])."'";
					/*Verificar*/
					$stmt14 = sqlsrv_query( $conn, $tsql14);
					if ($stmt14 === false) { return new soap_fault('Client', '', 'Error en la consulta art');}
					$row14 = sqlsrv_fetch_array($stmt14);
					
                    $tsql03 = " INSERT INTO reng_cac  (
                                            fact_num, 
                                            reng_num, 
                                            tipo_doc, 
                                            reng_doc, 
                                            num_doc, 
                                            co_art, 
                                            co_alma, 
                                            total_art, 
                                            stotal_art, 
                                            pendiente, 
                                            uni_venta, 
                                            prec_vta, 
                                            porc_desc, 
                                            tipo_imp, 
                                            reng_neto, 
                                            cos_pro_un, 
                                            ult_cos_un, 
                                            ult_cos_om, 
                                            cos_pro_om, 
                                            total_dev, 
                                            monto_dev, 
                                            prec_vta2, 
                                            anulado, 
                                            des_art, 
                                            seleccion, 
                                            cant_imp, 
                                            comentario, 
                                            rowguid, 
                                            total_uni, 
                                            mon_ilc, 
                                            otros, 
                                            nro_lote, 
                                            fec_lote, 
                                            pendiente2, 
                                            tipo_doc2, 
                                            reng_doc2, 
                                            num_doc2,  
                                            co_alma2, 
                                            aux01, 
                                            aux02, 
                                            cant_prod, 
                                            imp_prod)  
                                VALUES   (
                                            ".$numCotizacion.",
                                            ".$i.",
                                            '', 
                                            0, 
                                            0, 
                                            '".trim($producto['codigoProducto'])."', 
                                            '000001', 
                                            ".$producto['cantidadProducto'].", 
                                            0.00000,
                                            ".$producto['cantidadProducto'].",
                                            '".$producto['uniVenta']."', 
                                            ".$producto['montoUnitario'].",
                                            '',
                                            1,
                                            ".($producto['cantidadProducto']*$producto['montoUnitario']).",
                                            ".$row14['cos_pro_un'].",
                                            ".$row14['ult_cos_un'].",
                                            0.00000, 
                                            0.00000, 
                                            0.00000, 
                                            0.00000, 
                                            0.00000,                                                                                                                                                                                       
                                            0,
                                            '".$producto['descripcionProducto']."',
                                            0,
                                            0.00000,
                                            '',
                                            '".getGUID()."',
                                            1,
                                            0.00000,
                                            0.00000,
                                            '',
                                            '".date("Y-m-d H:i:s")."', 
                                            0.00000, 
                                            '', 
                                            0, 
                                            0, 
                                            '',
                                            0.00000, 
                                            '', 
                                            0.00000,
                                            0.00000)";
                    /* total_uni => antes ".$producto['cantidadProducto']." ahora 1 (02/06/2021)*/
					$stmt03 = sqlsrv_query( $conn, $tsql03);
					if ($stmt03 === false) { 
						if( ($errors = sqlsrv_errors() ) != null) {
							foreach( $errors as $error ) {
								$str = "SQLSTATE: ".$error[ 'SQLSTATE']." - "."code: ".$error[ 'code']." - "."message: ".$error[ 'message'];
							}
						}
                        return new soap_fault('Client', '', 'Error en la consulta reng_cac: '.$tsql03);
                    }

					/*
					$tsql15 = "UPDATE cotiz_c SET status = '0' WHERE fact_num = ".$numCotizacion."";
					$stmt15 = sqlsrv_query( $conn, $tsql15);
					if ($stmt15 === false) { return new soap_fault('Client', '', 'Error en la consulta update cotiz_c '.$tsql15);}
					*/
					/*
					$tsql16 = "UPDATE reng_cac SET pendiente = '".$producto['cantidadProducto']."', total_uni = '1', cos_pro_un = '".$row14['cos_pro_un']."', ult_cos_un =  WHERE fact_num = ".$numCotizacion; 
					$stmt16 = sqlsrv_query( $conn, $tsql16);
					if ($stmt16 === false) { return new soap_fault('Client', '', 'Error en la consulta reng_cac');}
					*/

					$tsql12 = "UPDATE st_almac SET STOCK_COM = 0.00000, sSTOCK_COM = 0.00000  WHERE co_art = '".trim($producto['codigoProducto'])."' AND co_alma = '000001'";
					$stmt12 = sqlsrv_query( $conn, $tsql12);
					if ($stmt12 === false) { return new soap_fault('Client', '', 'Error en la consulta st_almac');}
	
					$tsql13 = "UPDATE art SET STOCK_COM = 0.00000, sSTOCK_COM = 0.00000 WHERE co_art = '".trim($producto['codigoProducto'])."'";
					$stmt13 = sqlsrv_query( $conn, $tsql13);
					if ($stmt13 === false) { return new soap_fault('Client', '', 'Error en la consulta art');}

				}
				$toc['numero'] = $numCotizacion;
                return $toc;
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta Gen');
            }
        }
    } else
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
}

function listTipoPago() {
    if (getSeguridad ()) {
        include_once("../include/conn.php");
        if($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
        } else {
            try {
				$tsql = "SELECT co_cond as ID, cond_des as descripcion, dias_cred FROM condicio"; 
				$stmt = sqlsrv_query( $conn, $tsql);
                if($stmt === false){ return new soap_fault('Client', '', 'Error en la consulta tipopago');}
                $i = 0;
                while ($row = sqlsrv_fetch_array($stmt)) {
                    $toc[$i]['id'] = utf8_encode($row['ID']);
                    $toc[$i]['descripcion'] = utf8_encode(trim($row['descripcion']));
					$toc[$i]['dias_cred'] = $row['dias_cred'];
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
        include_once("../include/conn.php");
        if($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
        } else {
            try {
				$tsql = "SELECT co_ven, ven_des FROM vendedor WHERE co_ven != 'NA' ORDER BY co_ven ASC"; $stmt = sqlsrv_query( $conn, $tsql);
                if ($stmt === false) { return new soap_fault('Client', '', 'Error en la consulta');}
                $i = 0;
                while($row = sqlsrv_fetch_array($stmt)){
                    $toc[$i]['id'] = $row['co_ven'];
                    $toc[$i]['nombre'] = utf8_encode($row['ven_des']);
                    $i++;
                }
                return $toc;
				sqlsrv_free_stmt( $stmt);
				sqlsrv_close( $conn);
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    }else{
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
	}
}
/*
function getIva() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
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
*/
/*
function getCambioMoneda() {
    if (getSeguridad ()) {
        include_once("../include/tabla.php");
        if($linkTabla === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.');
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
*/
$str = '';
function getUsuario($usuario, $clave) {
    if(getSeguridad ()) {
	    include_once("../include/conn.php");
        if($conn === false) {
            return new soap_fault('Client', '', 'Error en la conexi�n con la DB.'); /*die( print_r( sqlsrv_errors(), true));*/
        } else {
            try {
				$tsql = "SELECT top 1 co_ven, ven_des, login, password, tipo FROM vendedor WHERE co_ven != 'NA' AND login = '".$usuario."' AND password = '".$clave."';";
				$stmt = sqlsrv_query( $conn, $tsql);
				if($stmt === false ){
				    if( ($errors = sqlsrv_errors() ) != null) {
						foreach( $errors as $error ) {
							$str = "SQLSTATE: ".$error[ 'SQLSTATE']." - "."code: ".$error[ 'code']." - "."message: ".$error[ 'message'];
						}
					}
				
				return new soap_fault('Client', '', 'Error en la consulta '.$str); /*die( print_r( sqlsrv_errors(), true));*/}
                $toc['id'] = '';
                $toc['nombre'] = '';
                $toc['login'] = '';
				$toc['tipo'] = '';
				while($row = sqlsrv_fetch_array($stmt)){
                    $toc['id'] = utf8_encode($row['co_ven']);
                    $toc['nombre'] = utf8_encode($row['ven_des']);
                    $toc['login'] = utf8_encode($row['login']);
					$toc['tipo'] = utf8_encode($row['tipo']);
				}
                return $toc;
				sqlsrv_free_stmt( $stmt);
				sqlsrv_close( $conn);
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
    }else{
        return new soap_fault('Client', '', 'No esta autorizado para ingresar');
	}
}

function getSeguridad() {
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_USER'] == "MiuraBike2017" && $_SERVER['PHP_AUTH_PW'] == "SwsNet2017") {
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