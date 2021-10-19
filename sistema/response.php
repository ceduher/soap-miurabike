<?php
include_once("config.php");//include db configuration file
$link = mysql_connect($hostname, $username, $password) or die('No se pudo conectar: ' . mysql_error());
mysql_select_db($databasename) or die('No se pudo seleccionar la base de datos');

if(isset($_POST["llaveSistema"])){
	if($_POST["llaveSistema"] == 0){// Realizar una consulta MySQL
		$query = 'UPDATE acceso SET acceso = 0 WHERE id = 0;';
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		if($result){
			echo 0; 
			// Liberar resultados
			mysql_close($link);	
		}else{
			header('HTTP/1.1 500 Looks like mysql error, could not update record!');
			exit();
		}
	}elseif($_POST["llaveSistema"] == 1){// Realizar una consulta MySQL
		$query = 'UPDATE acceso SET acceso = 1 WHERE id = 0;';
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		if($result){
			echo 1; 
			// Liberar resultados
			mysql_close($link);	
		}else{
			header('HTTP/1.1 500 Looks like mysql error, could not update record!');
			exit();
		}
	}else{}
}
?>