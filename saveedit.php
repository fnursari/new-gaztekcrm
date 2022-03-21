<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
DEFINE("_ADMIN_GIRDI","1");
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php";  
if(canUserAccessAdminArea()) {

$result = $db->query("UPDATE " . $_POST["table"] . " set " . $_POST["column"] . " = '".$_POST["editval"]."' WHERE  " . $_POST["table_id_name"] . "=".$_POST["id"]);
}
?>