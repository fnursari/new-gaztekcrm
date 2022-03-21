<?php
session_start();
header("Content-Type: text/html; charset=utf-8"); 
include_once "config.php";
include_once $cfg["SiteRoot"]."db_connection.php";
include_once $cfg["SiteRoot"]."functions.php"; 

$marka_id = $_POST["marka_id"];

	$sql = "SELECT Distinct(model) FROM urun WHERE marka = '$marka_id' order by model";
	$sonuc='<option value="">'.$lang["Model"].'</option>';

	$modeller = $db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {
		foreach ($modeller as $model_item) {
			if (!is_null($model_item["model"])) {
				
				$sonuc.='<option value="'.$model_item["model"].'">'.$model_item["model"].'</option>';
			}
		};
	}

	echo $sonuc;


?>