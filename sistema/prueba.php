<?php

    //$titulo = "Nueva Cotización # 0000";
    //$mensaje = "El vendedor: yomismo ha creado una nueva cotización con el número: 0000";

    //require_once('swift/lib/swift_required.php');

    //Datos del usaurio de correo electróo				
    //$smtp = "mail.miurabike.com";
    //$port = 25;
    //$usr = "info@miurabike.com";
    //$pass = "FILFDos"; 

    //Datos del envíuna sópersona
    //$mail_to = array("bikemiura33@yahoo.com", "giulianozamora2001@hotmail.com", "miura1998@yahoo.es");
    //Datos de envívarias personas:
    //$mail_to = "fchaconu@gmail.com, vsilva@swsnet.com.ve";
    //$mail_to = 'ceduher@hotmail.com';
    //$cc_to = array("vsilva@swsnet.com.ve", "soporte@sws.com.ve");

    //$connection = Swift_SmtpTransport::newInstance($smtp, $port);
    //$connection->setUsername($usr);
    //$connection->setPassword($pass);

    //$mailer = Swift_Mailer::newInstance($connection);
    //$message = Swift_Message::newInstance($titulo);               
    //$message->setBody($mensaje);
    //$message->setFrom(array($usr => "miurabike.com"));
    //$message->setTo($mail_to);
    //$message->setCc($cc_to);
    //$mailer->send($message, $failures);

/*
    session_start();
    
    include "include/url.php";
    //Inicio del Webservice
    require_once('nusoap/includes/nusoap.php');
    $soapclient = new nusoap_client($url);
    $soapclient->setCredentials("MiuraBike2017", "SwsNet2017", "basic");
    $sError = $soapclient->getError();
    
    $listClientes = $soapclient->call('listClientes');
    
    $mensaje = '';
    if ($soapclient->fault) {
        $mensaje = $soapclient->faultstring;
    } else {
        $sError = $soapclient->getError();
        if ($sError) {
            $mensaje = 'Error:' . $sError;
        }
    }
    
    var_dump($listClientes);
    */
?>