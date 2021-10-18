<?php

        include("../include/cliente.php");
        if ($linkCliente === false) {
            return new soap_fault('Client', '', 'Error en la conexión con la DB.');
        } else {
            try {
                $sql = " SELECT ID, Codigo, Compania, Contacto, Rif, Direccion, Ciudad, Estado, Pais, Telefono, Fax FROM   PhoneList WHERE  Codigo < 100000 ORDER BY ID DESC";//ORDER BY ID DESC ID, Codigo, Compania, Contacto, Rif, Direccion, Ciudad, Estado, Pais, Telefono, Fax WHERE  Codigo < 100000
				
                //$rs_access = odbc_exec($linkCliente, utf8_decode($sql));
                //if ($rs_access === false) {
                    //return new soap_fault('Client', '', 'Error en la consulta');
					//echo 'Error en la consulta';
                //}
                //$num_rows = odbc_num_rows($rs_access);
				
				if( $rs_access = odbc_exec($linkCliente, utf8_decode($sql))){
				   //echo "La sentencia se ejecutó correctamente";
				   $i = 0;
				   while ($row = odbc_fetch_object($rs_access)){
								$toc[$i]['codigo'] = number_format($row->Codigo,0);
								$toc[$i]['compania'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Compania)));
								$toc[$i]['rif'] = $row->Rif;
								$toc[$i]['contacto'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Contacto)));
								$toc[$i]['direccion'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Direccion)));
								$toc[$i]['telefono'] = str_replace("\n", "", str_replace("\r", "", utf8_encode($row->Telefono)));
								$i++;
				   }
					var_dump($toc);
				}else{
				   //echo "Error al ejecutar la sentencia SQL";
				}
            } catch (Exception $e) {
                return new soap_fault('Client', '', 'Error en la consulta');
            }
        }
				
?>