<?php
session_start();

//$_POST["user"] = 'orimar';
//$_POST["pass"] = '989878';

if (isset($_POST["user"]) && $_POST["user"] != "" && isset($_POST["pass"]) && $_POST["pass"] != "") {
	
	$acceso = 0;
	
	require_once("config.php");//include db configuration file
	
	$link = mysql_connect($hostname, $username, $password) or die('No se pudo conectar: ' . mysql_error());
	mysql_select_db($databasename) or die('No se pudo seleccionar la base de datos');
	
	// Realizar una consulta MySQL
	$query = 'SELECT acceso FROM acceso;';
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
	while($fila=mysql_fetch_array($result)){
		$acceso = $fila[0];
	}
	// Liberar resultados
	mysql_free_result($result);
	mysql_close($link);	

    include "include/url.php";
    //Inicio del Webservice
    require_once('nusoap/includes/nusoap.php');
    $soapclient = new nusoap_client($url);
    $soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");

    $user = $soapclient->call('getUsuario', array("usuario" => $_POST["user"], "clave" => $_POST["pass"]));
    $sError = $soapclient->getError();
    if ($soapclient->fault) {
        $mensaje = $soapclient->faultstring;
        die("Error en la conexion 1".$mensaje);
    } else {
        $sError = $soapclient->getError();
        if ($sError) {
            $mensaje = 'Error:' . $sError;
            die("Error en la conexion 2".$sError);
        }
    }
    if($user['id'] != '') {
		if($user['tipo'] == 'A'){
			$_SESSION["session"] = true;
			$_SESSION["usuario"] = $user['login'];
			$_SESSION["tipo"] = $user['tipo'];
			echo true;
		}elseif($user['tipo'] == 'B' && $acceso == 1){ //Habilitado
			$_SESSION["session"] = true;
			$_SESSION["usuario"] = $user['login'];
			$_SESSION["tipo"] = $user['tipo'];
			echo true;
		}elseif($user['tipo'] == 'B' && $acceso == 0){ //Deshabilitado
			$_SESSION["session"] = false;
			$_SESSION["usuario"] = $user['login'];
			echo "acceso";		
		}
    } else {
        $_SESSION["session"] = false;
        $_SESSION["usuario"] = "";
        session_destroy();
        echo "Datos incorrectos";
    }
}
?>
