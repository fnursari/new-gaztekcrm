<?php
function ucwordstr($str){
	$str = lowercasetr($str);
	if(substr($str,0,1) == "i") $str = "İ".substr($str,1);
	if(substr($str,0,1) == "ı") $str = "I".substr($str,1);
	return mb_convert_case( trim($str) , MB_CASE_TITLE, "UTF-8");
}

function uppercasetr($str){
	$str = strtr($str , [
		"i" => "İ",
		"ı" => "I",
		]);
	return mb_convert_case( trim($str) , MB_CASE_UPPER, "UTF-8");
}

function lowercasetr($str){
	$str = strtr($str , [
		"İ" => "i",
		"I" => "ı",
		]);
	return mb_convert_case( trim($str) , MB_CASE_LOWER, "UTF-8");
}

function makeSafe($str) {
	global $cfg,$db;
	if($cfg["makeSafe"]=="1") return  trim($db->escape($str));
	else return trim($str);
}



function beautifyName($name)
{
	$name      = preg_replace('/(?<!\.)\.(?!(\s|$|\,|\w\.))/', '. ', $name);
	$nameArray = [];
	foreach (explode(" ", trim($name)) as $inside_name) {
		$nameArray[] = uppercasetr(trim($inside_name));
	}
	$nameArray = array_filter($nameArray, function ($item) {
		return trim($item) != "";
	});
	$concatName = implode(" ", $nameArray);
	$name       = strtr($concatName, [
		". "    => ".",
		" Ve "  => " ve ",
		" And " => " and ",
		"A.ş"   => "A.Ş",
		"a.Ş"   => "A.Ş",
		".a.Ş"  => "A.Ş",
		".Ve "  => " ve ",
		]);

	return $name;
}
function beautifyPhone($phone)
{
	$phone      = str_replace('(',' ',$phone);
	$phone      = str_replace(')',' ',$phone);
	$phone      = str_replace('-',' ',$phone);
	return $phone;
}

function zerofill ($num, $zerofill = 6){
	return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

function tags($str) {
	
	$str=str_replace(" ","+",$str);
	return $str;
}


function uniqidReal($lenght = 5) {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}
