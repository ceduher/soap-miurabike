<?php
session_start();
if(isset($_SESSION['session']) && $_SESSION['session'] == true && isset($_SESSION['usuario']) && $_SESSION['usuario'] != ""){
    header("Location: cot.php");
}
?>

<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
        <title>Sistema de Cotizaciones - Miurabike</title>
        
        <link href="assets/stylesheets/login-box.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="assets/javascripts/jquery-1.3.2.min.js"></script>
		<style>
        .acc1{
            font-family:Arial, Helvetica, sans-serif;
            color:#ffc000;
            font-size:14pt;
            }
        .acc2{
            font-family:Arial, Helvetica, sans-serif;
            color:#ffc000;
            font-size:11pt;
        }
        </style>
        <script language="javascript" type="text/javascript">
            $(document).ready(function(){
                $("#form_signin").submit(function(){
                    if( $("#usuario").val()=="" || $("#password").val()=="") {
                        $("#mens_signin").html("No dejar campos en blanco.....");
                        $("#mens_signin").fadeIn();
                        return false;
                    }else{
                        $("#mens_signin").html("");
                        $.post("autenticacion.php", { user:$("#usuario").val(),pass:$("#password").val() },
                        function(data){
                            if(data==true){
                                document.location.href="cot.php";
                            }else{
				if(data == 'acceso'){
				     $('#mens_signin').html('<font class=\"acc1\">Sistema temporalmente desactivado,</font><br/><font class=\"acc2\">favor ponerse en contacto con el administrador.</font>');
				}else{
				     $('#mens_signin').html(data);
				}
                            }
                        });
                        return false;
                    }
                });
            });
        </script>
    </head>
    <body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table id="Table_01" width="1420" height="896" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <img src="assets/images/pedido_01.jpg" alt="" width="1420" height="244" border="0" usemap="#Map"></td>
          </tr>
            <tr>
                <td>
                    <form name="form_signin" id="form_signin" method="post" action="">
                    <table width="1420" height="427" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="173">
                                <div style="padding: 20px 0 0 250px;">
                                    <div id="login-box">
                                        <H2>Acceso</H2>
                                        <br />                                        
                                        <div id="login-box-name" style="margin-top:20px;">Usuario:</div>
                                        <div id="login-box-field" style="margin-top:20px;">
                                            <input id="usuario" name="usuario" class="form-login" title="Usuario" value="" size="30" maxlength="2048" />
                                        </div>
                                        <div id="login-box-name">Clave:</div>
                                        <div id="login-box-field">
                                            <input id="password" name="password" type="password" class="form-login" title="Contraseña" value="" size="30" maxlength="2048" />
                                        </div>
                                        <br /><br />
                                        <a href="#"><input type="image" src="assets/images/login-btn.png" width="103" height="42" style="margin-left:90px;" value="submit" /></a>
                                        <br /><br />
                                        <div id="mens_signin" align="center"></div>
                                    </div>                                    
                                </div>
                            </td>
                        </tr>
                    </table>
                    </form>
                </td>
            </tr>
            <tr>
                <td><img src="assets/images/pedido_03.jpg" width="1420" height="225" alt=""></td>
            </tr>
        </table>
<map name="Map"><area shape="rect" coords="667,32,924,56" href="http://miurabike.com/site" target="_self">
</map></body>
</html>