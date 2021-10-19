<?php
session_start();
if(isset($_POST["logoff"]) && $_POST["logoff"] == true) {
   $_SESSION["session"] = false;
   $_SESSION["correo"] = "";
   $_SESSION["usuario"] = "";
   session_destroy();
   echo true;
}
?>
