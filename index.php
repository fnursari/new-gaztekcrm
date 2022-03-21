<?php
session_start();
$session_kullanici=$_SESSION["session_kullanici"];
if($session_kullanici[0]!="") // kullanici_id var ise : login olmuş ise
{
    header("location:admin.php");
}
else                          // login olmamış ise
{
    header("location:loginform.php");
}
?>