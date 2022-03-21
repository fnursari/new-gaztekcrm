<?php
include_once $cfg["SiteRoot"]."classes/ez_sql_core.php";
include_once $cfg["SiteRoot"]."classes/ez_sql_mysql.php";  
$db = new ezSQL_mysql($cfg["DatabaseUsername"],$cfg["DatabasePassword"],$cfg["DatabaseName"],$cfg["DatabaseHost"]."");
?>