<?php
require 'functions/date_functions.php';
require 'functions/string_functions.php';
require 'functions/db_helper_functions.php';
require 'functions/language_functions.php';
require 'functions/debug_functions.php';
require 'functions/pagination_functions.php';
require 'functions/file_functions.php';
require 'functions/email_functions.php';

function getConfig() {
	global $db;
	return $db->get_row("select * from config where config_id='1'",ARRAY_A);
}
function getConfigTeklif() {
	global $db;
	return $db->get_row("select * from config_teklif where config_id='1' and config_teklif_id='1'",ARRAY_A);
}
function getConfigProforma() {
	global $db;
	return $db->get_row("select * from config_proforma where config_id='1' and config_proforma_id='1'",ARRAY_A);
}

function getCompanies() {
	global $db;
	return $db->get_results("select * from firma where firma_silindi='0' order by firma_id desc",ARRAY_A);
}

function getUsers() {
	global $db;
	return $db->get_results("select * from u1s9e2r6 where user_active='1' and group_id='2' order by user_id desc",ARRAY_A);
}

function getParameterTypes() {
	global $db;
	return $db->get_results("select * from parametre_tipleri order by tip_id",ARRAY_A);
}
function getParameterType($tip_id) {
	global $db;
	return $db->get_row("select * from parametre_tipleri where tip_id='$tip_id'",ARRAY_A);
}

function getParameters($tip_id,$onlyactiveparameters=false) {
	global $db;
	$sql = "select * from parametreler where tip_id='$tip_id' and parametre_silindi='0' ";
	if($onlyactiveparameters) {
		$sql.=" and parametre_aktif='1'";
	}
	$sql.=" order by parametre_id";
	return $db->get_results($sql,ARRAY_A);
}

function getParameter($parametre_id) {
	global $db;
	return $db->get_row("select * from parametreler where parametre_id='$parametre_id'",ARRAY_A);
}

function getMaxTeklifNo() {
	global $db;
	return $db->get_var("select COALESCE(max(teklif_id),0) from teklifler");
}



function getAcilisBanner() {
	global $db;
	return $db->get_row("select * from acilis where acilis_id='1'",ARRAY_A);
}
function getLanguages(){
	global $db;
	return $db->get_results("select * from languages where language_state='1' order by language_id",ARRAY_A);
}
function controlUserLogin($username,$password) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where user_name='$username' and user_pass='".md5($password)."' and user_active='1'",ARRAY_A); 
}

function controlUserLoginwithCookie($cookiehash) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where cookiehash='$cookiehash' and user_active='1'",ARRAY_A); 
}

function controlAllUserwithEmail($email) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where user_name='$email'",ARRAY_A); 
}

function controlActiveUserwithEmail($email) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where user_name='$email' and user_active='1'",ARRAY_A); 
}


function controlUserwithActivationCode($code) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where user_activation_code='$code' and user_active='0'",ARRAY_A); 
}

function activateUser($user) {
	global $db;
	$updateData = [
		"user_active" => 1,
		"user_activation_date" => date('Y-m-d H:i:s'),
	];
	$where = [
		"user_id" => $user["user_id"]
	];
	updateTableData('u1s9e2r6',$updateData,$where);
}

function updateLastLogin($user_id) {
	global $db;
	$db->query("update u1s9e2r6 set last_online='".date("Y-m-d H:i:s")."' where user_id='$user_id'");
}

function getUserDetails($user_id) {
	global $db;
	return $db->get_row("select * from u1s9e2r6 where user_id='$user_id' and user_active='1'",ARRAY_A);
}

function getUserPass($user_id) {
	global $db;
	return $db->get_var("select user_pass from u1s9e2r6 where user_id='$user_id' and user_active='1'");
}

function getUserGroupName($group_id) {
	global $db;
	return $db->get_var("select group_name from u1s9e2r6_group where group_id='$group_id' and group_state='1'");
}

function isUserLogged() {
	if(!isset($_SESSION['cookie']) && empty($_SESSION["user"]["auth"])) {
		CheckCookieLogin();
	}
	return $_SESSION["user"]["auth"]==sha1(md5(session_id()."vizyoner")) ? true : false;
}

function isUserRootUser() {
	return $_SESSION["user"]["group"]=="root" ? true : false;
}
function isUserAdminUser() {
	return $_SESSION["user"]["group"]=="admin" ? true : false;
}
function isUserNormalUser() {
	return $_SESSION["user"]["group"]=="user" ? true : false;
}
function canUserAccessAdminArea() {
	return (isUserLogged() && (isUserRootUser() || isUserAdminUser())) ? true : false;
}

function saveLoginData($usercontrol) {
	$last_online = $usercontrol["last_online"]!="" ? $usercontrol["last_online"] : date("Y-m-d H:i:s");
	$_SESSION["user"]["auth"]					= sha1(md5(session_id()."vizyoner"));
	$_SESSION["user"]["user_id"]				= $usercontrol["user_id"];
	$_SESSION["user"]["name"]					= $usercontrol["name"];
	$_SESSION["user"]["last_online"]			= $last_online;
	$_SESSION["user"]["group"]					= getUserGroupName($usercontrol["group_id"]);
	updateLastLogin($usercontrol["user_id"]);
}

function CheckCookieLogin() {
	global $cfg,$db;
	$uname = $_COOKIE['uname']; 
	if (!empty($uname)) {   
		$usercontrol = controlUserLoginwithCookie($uname);
		if(count($usercontrol)>0) {
			setcookie("uname",$uname,time()+3600*24*365,'/',$cfg["cookieDomain"]);
			$_SESSION['cookie'] 						= $uname;
			saveLoginData($usercontrol);
		}
	}
}

function recursive_kategori_al_yukari($kategori_id) {
	global $db,$recursive_kategori_nav,$dil;
	$sql="select * from urun_kategori where kategori_id='$kategori_id'";
	$details = $db->get_row($sql,ARRAY_A);
	if($details["ana_id"]==0) {
		$recursive_kategori_nav[]='<span><a href="'.getCategoryLink($details).'">'.$details["kategori_ad_$dil"].'</a></span><span class="ttm-bread-sep ttm-textcolor-white">&nbsp;   →  &nbsp;</span>';
		return 1;
	} 
	else {
		$recursive_kategori_nav[]='<span><a href="'.getCategoryLink($details).'">'.$details["kategori_ad_$dil"].'</a></span><span class="ttm-bread-sep ttm-textcolor-white">&nbsp;   →  &nbsp;</span>';
		recursive_kategori_al_yukari($details["ana_id"]);
		return ($recursive_kategori_nav);
	}
}
function getRecursiveCategories($kategori_id) {
	global $db,$dil, $recursive_categories,$kategori_index;
	$details = $db->get_row("select ana_id,kategori_id,kategori_ad_$dil from urun_kategori where kategori_id='$kategori_id'",ARRAY_A);



	$recursive_categories[$kategori_index]["id"]=$details["kategori_id"];
	$recursive_categories[$kategori_index]["name"]=$details["kategori_ad_$dil"];
	$recursive_categories[$kategori_index]["link"]= permayap($details["kategori_ad_$dil"]).'_'.$details["kategori_id"].'_c_'.$dil.'.html';
	$kategori_index++;
	if($details["ana_id"]=="0") return 1;
	return getRecursiveCategories($details["ana_id"]);
}

function getSayfaBilgileri($sayfa_id,$only_active_records=false) {
	global $db;
	$sql = "select * from sayfa where sayfa_id='".$sayfa_id."'";
	if($only_active_records) $sql .= " and sayfa_aktif='1'";
	return $db->get_row($sql,ARRAY_A);
}

function getSayfaIdFromPerma($perma) {
	global $db,$dil;
	return $db->get_var("select sayfa_id from sayfa where sayfa_link_$dil='$perma' and sayfa_link_$dil<>''");
}
function getTags(){
	global $db,$dil;
	return $db->get_results("select * from urun where urun_aktif='1' and seo_keyword_$dil<>'' order by rand()",ARRAY_A);
}

function getIstatistik(){
	global $db;
	return $db->get_results("select * from istatistik where aktif='1' order by sira",ARRAY_A);
}

function getPageLink($sayfa_id){
	global $db,$dil;
	$sayfa=$db->get_row("select * from sayfa where sayfa_id='$sayfa_id'",ARRAY_A);
	if ($sayfa["sayfa_link_$dil"]!="") {
		$link=$sayfa["sayfa_link_$dil"].'_'.$dil.'.html';
	} else {
		$link=permayap($sayfa["sayfa_ad_$dil"])."_".($sayfa["sayfa_id"])."_p_".$dil.".html";
	}
	return $link;
}

function getProductCat(){
	global $db;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' order by kategori_id",ARRAY_A);
}
function getProductCatName($kategori_id){
	global $db,$dil;
	return $db->get_var("select kategori_ad_$dil from urun_kategori where kategori_aktif='1' and kategori_id='$kategori_id'");
}


function getPagePermaLink($sayfa_id) {
	global $db,$cfg,$dil;
	
	if($cfg["mode"]=="dev") {
		$sayfa=$db->get_row("select * from sayfa where sayfa_id='$sayfa_id'",ARRAY_A);
		if ($sayfa["sayfa_link_$dil"]!="") {
			$link=$cfg["Host"].$sayfa["sayfa_link_$dil"].'_'.$dil.'.html';
		} else {
			$link=permayap($sayfa["sayfa_ad_$dil"])."_".($sayfa["sayfa_id"])."_p_".$dil.".html";
		}
		return $link;	
	}
	else {
		if(!isset($_SESSION["permalink_$dil"])) {
			$sayfalar = $db->get_results("select sayfa_link_$dil,sayfa_ad_$dil,sayfa_id from sayfa",ARRAY_A);
			if(!is_null($sayfalar)) {
				foreach ($sayfalar as $sayfa) {
					if ($sayfa["sayfa_link_$dil"]!="") {
						$link=$cfg["Host"].$sayfa["sayfa_link_$dil"].'_'.$dil.'.html';
					} else {
						$link=permayap($sayfa["sayfa_ad_$dil"])."_".($sayfa["sayfa_id"])."_p_".$dil.".html";
					}
					$_SESSION["permalink_$dil"][$sayfa["sayfa_id"]] = $link;
				}
			}
		}
		return $_SESSION["permalink_$dil"][$sayfa_id];
	}
}

function getBanks(){
	global $db;
	return $db->get_results("select * from banka where banka_aktif='1' order by sira",ARRAY_A);
}

function getDosyaAdi($dosya_id) {
	global $dil,$db;
	return $db->get_var("select dosya from is_basvurusu where basvuru_id='$dosya_id'");
}
function getPageContent($sayfa_id) {
	global $dil,$db;
	return $db->get_var("select icerik_$dil from sayfa where sayfa_id='$sayfa_id'");
}
function getPageEtiket($sayfa_id) {
	global $dil,$db;
	$sayfa_etiket=$db->get_var("select sayfa_etiket_$dil from sayfa where sayfa_id='$sayfa_id'");
	if ($sayfa_etiket!="") {
		$return.='<hr>';
		$return.='<p class="fontsize_11">';
		$return.=$sayfa_etiket;
		$return.='</p>';
	} else {
		$return.="";
	}
	return $return;
}
function getPageTitle($sayfa_id) {
	global $dil,$db;
	return $db->get_var("select sayfa_ad_$dil from sayfa where sayfa_id='$sayfa_id'");
}

function getMainBanner(){
	global $db,$dil;
	return $db->get_results("select * from banner where banner_aktif='1' order by sira",ARRAY_A);
}
function getContentImages($tablo,$tablo_id,$altlimit=0,$limit=NULL) {
	global $dil,$db;
	$sql = "SELECT * from resim where tablo='$tablo' and tablo_id='$tablo_id' and resim_aktif='1' order by sira";
	if(!is_null($limit)) {	
		$sql.=" limit $altlimit,$limit";
	}
	return $db->get_results($sql,ARRAY_A);
}
function getCategories(){
	global $db;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' and ana_id='0' order by sira",ARRAY_A);
}
function getFooterCategories($alt_limit,$ust_limit){
	global $db;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' and ana_id='0' order by sira limit $alt_limit,$ust_limit",ARRAY_A);
}
function getAllSubCategories(){
	global $db;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' and ana_id!='0' order by sira",ARRAY_A);
}
function getSubCategories($kategori_id){
	global $db;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' and ana_id=$kategori_id order by sira",ARRAY_A);
}
function getProduct($kategori_id,$limit=200){
	global $db;
	return $db->get_results("select * from urun where urun_aktif='1' and kategori_id='$kategori_id' order by sira limit 0,$limit",ARRAY_A);
}
function getMainPageProduct($alt_limit,$ust_limit){
	global $db;
	return $db->get_results("select * from urun where urun_aktif='1' and anasayfa_gosterim='1' order by sira limit $alt_limit,$ust_limit",ARRAY_A);
}
function getContactUsers(){
	global $db;
	return $db->get_results("select * from kisi_iletisim where aktif='1' order by sira",ARRAY_A);
}
function getDepartments(){
	global $db;
	return $db->get_results("select * from departman where departman_aktif='1' order by sira",ARRAY_A);
}
function getProducts(){
	global $db;
	return $db->get_results("select * from urun where urun_aktif='1' order by sira",ARRAY_A);
}
function getUsedProducts(){
	global $db;
	return $db->get_results("select * from ikincielurun where urun_aktif='1' order by sira",ARRAY_A);
}

function getNews($alt_limit=0,$limit=1000){
	global $db;
	return $db->get_results("select * from haber where haber_aktif='1' order by haber_tarih limit $alt_limit,$limit",ARRAY_A);
}

function getFairs(){
	global $db;
	return $db->get_results("select * from fuar where fuar_aktif='1' order by fuar_id desc",ARRAY_A);
}


function getNewsLink($haber){
	global $db,$dil;
	$link=permayap($haber["haber_baslik_$dil"])."_".$haber["haber_id"]."_h_".$dil.".html";
	return $link;
}
function getFairsLink($fuar){
	global $db,$dil;
	$link=permayap($fuar["fuar_baslik_$dil"])."_".$fuar["fuar_id"]."_f_".$dil.".html";
	return $link;
}
function getMultimedya(){
	global $db;
	return $db->get_results("select * from multimedya where multimedya_aktif='1' order by multimedya_tarih DESC",ARRAY_A);
}
function getReferences(){
	global $db;
	return $db->get_results("select * from resim where tablo_id='7' and tablo='sayfa' order by sira",ARRAY_A);
}
function getSSS(){
	global $db;
	return $db->get_results("select * from sss where sss_aktif='1' order by sira",ARRAY_A);
}
function getLangName($lang){
	
	switch ($lang) {
		case 'tr':$name='Türkçe';break;
		case 'en':$name='English';break;
		case 'ru':$name='Русский';break;
		case 'fr':$name='Français';break;
		case 'es':$name='Español';break;
		case 'ar':$name='العربية';break;
		case 'sq':$name='Shqiptar';break;
		case 'de':$name='Deutsch';break;
		default:$name='Türkçe';break;
	}
	return $name;
}

function formatTitle($seo,$title) {
	return $seo=="" ? $title : $seo;
}

function getSocialAccount(){
	global $db;
	return $db->get_results("select * from sosyal_medya where hesap_state='1' order by hesap_id",ARRAY_A);
}
function getAdresler($tip,$lang){
	global $db;
	return $db->get_results("select * from adresler where lang='$lang' and adres_name='$tip' order by adres_id",ARRAY_A);
}


function getMultimedyaLink($multimedya_id){
	global $db,$dil;
	$multimedya=$db->get_row("select * from multimedya where multimedya_aktif='1' and multimedya_id='$multimedya_id'",ARRAY_A);
	$link="m_".permayap($multimedya["multimedya_baslik_$dil"])."_".$multimedya["multimedya_id"]."_".$dil.".html";
	return $link;
}
function getCategoryLink($kategori){
	global $db,$dil;
	if ($kategori["seo_baslik_$dil"]!="") {
		$link=permayap($kategori["seo_baslik_$dil"])."_".$kategori["kategori_id"]."_c_".$dil.".html";
	} else {
		$link=permayap($kategori["kategori_ad_$dil"])."_".$kategori["kategori_id"]."_c_".$dil.".html";
	}
	return $link;
}
function getCategoryLink2($kategori_id){
	global $db,$dil;
	$kategori=$db->get_row("select * from urun_kategori where kategori_aktif='1' and kategori_id='$kategori_id'",ARRAY_A);
	if ($kategori["seo_baslik_$dil"]!="") {
		$link=permayap($kategori["seo_baslik_$dil"])."_".$kategori["kategori_id"]."_c_".$dil.".html";
	} else {
		$link=permayap($kategori["kategori_ad_$dil"])."_".$kategori["kategori_id"]."_c_".$dil.".html";
	}
	return $link;
}

function getDepartmentsLink($departman){
	global $db,$dil;
	
	if ($departman["seo_baslik_$dil"]!="") {
		$link=permayap($departman["seo_baslik_$dil"])."_".$departman["departman_id"]."_d_".$dil.".html";
	} else {
		$link=permayap($departman["departman_ad_$dil"])."_".$departman["departman_id"]."_d_".$dil.".html";
	}
	return $link;
}

function getProductLink($urun){
	global $db,$dil;
	
	if ($urun["seo_baslik_$dil"]!="") {
		$link=permayap($urun["seo_baslik_$dil"])."_".$urun["urun_id"]."_u_".$dil.".html";
	} else {
		$link=permayap($urun["urun_ad_$dil"])."_".$urun["urun_id"]."_u_".$dil.".html";
	}
	return $link;
}

function getTagLink($tag){
	global $db,$dil;
	
	$link=permayap2($tag)."_tag_".$dil.".html";
	
	return $link;
}



/*function getPageLink($sayfa_id,$sayfa_ad){
	global $db,$dil;
	$perma=$db->get_var("select sayfa_link_$dil from sayfa where sayfa_id='$sayfa_id'");
	return $perma.'_'.$dil.'.html';
}*/

function getProductName(){
	global $db,$dil;
	$urunler=$db->get_results("select * from urun where urun_aktif='1' order by rand() limit 0,6",ARRAY_A);
	if ($db->num_rows > 0) {
		foreach ($urunler as $urun) {
			$urun_ad=$urun["urun_ad_$dil"]." ,".$urun_ad;
		}
	}
	return $urun_ad;
}

function getSearch($grm_no,$oem_no,$cross_no,$brand,$model,$year,$sayfanum,$category,$group,$q){
	global $db,$dil;
	$sql="select * from urun where urun_aktif=1";
	$maxsql="select count(urun_id) from urun where urun_aktif=1";

	if ($grm_no!="") {
		$sql.=" and grm_no like '%$grm_no%'";
		$maxsql.=" and grm_no like '%$grm_no%'";
	}

	if ($oem_no!="") {
		$sql.=" and oem_no like '%$oem_no%'";
		$maxsql.=" and oem_no like '%$oem_no%'";
	}
	if ($cross_no!="") {
		$sql.=" and cross_no like '%$cross_no%'";
		$maxsql.=" and cross_no like '%$cross_no%'";
	}
	if ($brand!="") {
		$sql.=" and rtrim(marka)='$brand'";
		$maxsql.=" and marka='$brand'";
	}
	if ($group!="") {
		$sql.=" and urun_ad_$dil='$group'";
		$maxsql.=" and urun_ad_$dil='$group'";
	}
	if ($model!="") {
		$sql.=" and model='$model'";
		$maxsql.=" and model='$model'";
	}
	if ($category!="") {
		$sql.=" and kategori_id='$category'";
		$maxsql.=" and kategori_id='$category'";
	}
	if ($year!="") {
		$sql.=" and year like '%$year%'";
		$maxsql.=" and year like '%$year%'";
	}

	if ($q!="") {
		$sql.=" and (grm_no like '%$q%' or oem_no like '%$q%' or urun_ad_$dil like '%$q%')";
		$maxsql.=" and (grm_no like '%$q%' or oem_no like '%$q%' or urun_ad_$dil like '%$q%')";
	}
	$maxsql.=" group by sira";
	$maxresult=$db->get_results($maxsql,ARRAY_A);
	$num=$db->num_rows;

	if(is_null($urlformat)) $urlformat="index.php?pg=search&dil=$dil&grm_no=$grm_no&oem_no=$oem_no&cross_no=$cross_no&marka=$brand&model=$model&year=$year&kategori=$category&group=$group&q=$q";

	if($sayfanum=="") $sayfanum=0;
	$per_page=20;
	$start=$sayfanum*$per_page;
	if(empty($start))$start=0;

	$pagination=pagination($urlformat,$num,$sayfanum,$per_page);

	$showeachside = 8;
	$max_pages = ceil($num / $per_page);
	$cur = ceil($start / $per_page)+1;


	$sql.=" order by sira";
	$sql.=" limit $start,$per_page";

   /* echo $maxsql;
    echo '<br>';
    echo $sql;*/


    /*return $db->get_results($sql,"ARRAY_A");*/
    $result=$db->get_results($sql,ARRAY_A);
    $return=array(
    	"result"        =>  $result,
    	"num"           =>  $num,
    	"pagination"    =>  $pagination
    );
    return $return;
}

function getSearchCategory($q){
	global $db,$dil;
	return $db->get_results("select * from urun_kategori where kategori_aktif='1' and ( (kategori_ad_$dil like '%$q%')  or (seo_keyword_$dil like '%$q%') or (seo_baslik_$dil like '%$q%') or (seo_description_$dil like '%$q%')) order by sira",ARRAY_A);
}

function getBenzerUrunler($urun_id,$kategori_id){
	global $db;
	return $db->get_results("select * from urun where urun_aktif='1' and kategori_id='$kategori_id' and urun_id<>'$urun_id' order by sira",ARRAY_A);
}

function getKategoriAdi($kategori_id){
	global $db,$dil;
	return $db->get_var("select kategori_ad_$dil from urun_kategori where kategori_aktif='1' and kategori_id='$kategori_id'");
}
function getBrands(){
	global $db;
	return $db->get_results("select Distinct(marka) from urun where urun_aktif='1' order by marka",ARRAY_A);
}
function getGroup(){
	global $db,$dil;
	return $db->get_results("select Distinct(urun_ad_$dil) from urun where urun_aktif='1' order by urun_ad_$dil",ARRAY_A);
}
function getYear(){
	global $db;
	return $db->get_results("select Distinct(year) from urun where urun_aktif='1' order by year",ARRAY_A);
}

function PhoneTrim($phone){
	global $db,$dil;
	/*$phn=str_replace('+','', $phone);*/
	$phn=str_replace('(','', $phone);
	$phn=str_replace(')','', $phn);
	$phn=str_replace(' ','', $phn);
	return $phn;
}

function getAllNews() {
	global $dil,$db;
	return $db->get_results("select * from haber where haber_aktif='1' order by haber_tarih ASC",ARRAY_A);
}
function getAllFairs() {
	global $dil,$db;
	return $db->get_results("select * from fuar where fuar_aktif='1' order by fuar_tarih ASC",ARRAY_A);
}

function searchProduct($keyword){
	global $db,$dil;
	return $db->get_results("select * from urun where urun_aktif='1' and urun_ad_$dil like '%$keyword%' order by sira ",ARRAY_A);
}



function getImages($images,$url,$img='noimg') {
	$img=(($images!="") && (file_exists($url.$images))) ? $url.$images : 'images/'.$img.'.jpg';
	return $img;
}
function getCategoryIcon($images,$url,$img='noicon') {
	$img=(($images!="") && (file_exists($url.$images))) ? $url.$images : 'assets/images/icons/passenger-vehicle.svg';
	return $img;
}
function getIcon($icon) {
	$icn=(($icon!="")) ? $icon : 'bagcicon-other';
	return $icn;
}
function getDocuments($file) {
	$fl=(($file!="") && (file_exists('upload/'.$file))) ? 'upload/'.$file : '#';
	return $fl;
}
function getDocumentsPdfs($file,$file_path) {
	$fl=(($file!="") && (file_exists($file_path.$file))) ? $file_path.$file : '#';
	return $fl;
}

function getOzellikler($tablo,$tablo_id){
	global $dil, $db;
	return $db->get_results("select * from ozellik where tablo='$tablo' and tablo_id='$tablo_id' and ozellik_aktif='1' order by sira",ARRAY_A);

}

function getResimler($tablo,$tablo_id){
	global $dil, $db;
	return $db->get_results("select * from resim where tablo='$tablo' and tablo_id='$tablo_id' and resim_aktif='1' order by sira",ARRAY_A);

}
function getDosyalar($tablo,$tablo_id){
	global $dil, $db;
	return $db->get_results("select * from dosya where tablo='$tablo' and tablo_id='$tablo_id' and dosya_aktif='1' order by sira",ARRAY_A);

}

function getFiles(){
	global $dil,$db,$cfg;
	$dosyalar=$db->get_results("select * from dosya where tablo='urun' and dosya_aktif='1' order by sira",ARRAY_A);
	if (!is_null($dosyalar)) {
		$x=4;
		foreach ($dosyalar as $dosya) {
			if (($dosya["dosya"]!="") && file_exists("upload/".$dosya["dosya"])) {
				$return.='<div class="col-md-3 col-lg-3 col-23 download">';
				$return.='<div class="sbox-2 pt-20 pb-20 wow fadeInDown" data-wow-delay="0.'.$x.'s" style="visibility: visible; animation-delay: 0.'.$x.'s;">';
				$return.='<a href="upload/'.$dosya["dosya"].'" target="_blank">';
				$return.='<div class="sbox-2-icon icon-xs">';
				$return.='<span class="fa fa-file-pdf"></span>';
				$return.='</div>';
				$return.='<h5 class="h5-sm sbox-2-title steelblue-color">'.$dosya["ad_$dil"].'</h5>';
				$return.='</a>';
				$return.='</div>';
				$return.='</div>';

			}
			$x+=2;
		}
	}
	return $return;
}

function getPhotoGallery() {
	global $dil,$db,$cfg;;
	$sql="select * from fotogaleri where  fotogaleri_aktif='1' order by sira";
	$fotogalerilar=$db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {
		$return.='<div class="row">';
		$return.='<div class="col-md-12">';
		$return.='<div class="isotope popup-gallery column-4">';
		foreach ($fotogalerilar as $fotogaleri) {
			if (($fotogaleri["image"]!="") && file_exists("upload/photogallery/".$fotogaleri["image"])) {
				$return.='<div class="grid-item">';
				$return.='<div class="car-item-3">';
				$return.='<img class="img-fluid center-block" src="upload/photogallery/'.$fotogaleri["thumb"].'"  alt="'.$fotogaleri["ad_$dil"].'">';

				$return.='<div class="car-popup">';
				$return.='<a class="popup-img" href="upload/photogallery/'.$fotogaleri["image"].'"><i class="fa fa-plus"></i></a>';
				$return.='</div>';
				$return.='<div class="car-overlay text-center">';
				$return.='<a class="link" >'.$fotogaleri["fotogaleri_ad_$dil"].'</a>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';
			}
		}

		$return.='</div>';
		$return.='</div>';
		$return.='</div>';
	} else {
		$return.='<div class="alert alert-info text-center" role="alert"><strong>'.$cfg["uyari_$dil"].'</strong></div>';
	}
	return $return;
}
function getVideoGallery() {
	global $dil,$db,$cfg;
	$sql="select * from video where  video_aktif='1' order by sira";
	$videolar=$db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {
		$return.='<div class="row">';
		foreach ($videolar as $video) {
			if (($video["resim"]!="") && file_exists("upload/videogallery/".$video["resim"])) {

				$return.='<div class="col-md-3">';
				$return.='<div class="item">';
				$return.='<div class="car-item  gray-bg text-center">';
				$return.='<div class="car-image">';
				$return.='<img class="img-fluid" src="upload/videogallery/'.$video["resim"].'"  alt="'.$video["video_ad_$dil"].'">';
				$return.='<div class="car-overlay-banner">';
				$return.='<ul>';
				$return.='<li><a class="popup-youtube" href="'.$video["embed"].'"><i class="fa fa-play"></i></a></li>';
				$return.='</ul>';
				$return.='</div>';
				$return.='</div>';
				$return.='<div class="car-content">';
				$return.='<a class="popup-youtube" href="'.$video["embed"].'">'.$video["video_ad_$dil"].'</a>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';

			}
		}

		$return.='</div>';
	} else {
		$return.='<div class="alert alert-info text-center" role="alert"><strong>'.$cfg["uyari_$dil"].'</strong></div>';
	}
	return $return;
}

/*function getPageVideoGallery($table,$table_id) {
	global $dil,$db,$cfg;
	$sql="SELECT * from videolar where tablo='$table' and tablo_id='$table_id' and video_aktif='1' order by sira";
	$videolar=$db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {

		$return.='<div class="row multi-columns-row cmt-boxes-spacing-15px">';
		foreach ($videolar as $video) {
			if (($video["thumb"]!="") && file_exists("upload/".$video["thumb"])) {

				$return.='<div class="cmt-box-col-wrapper col-lg-4 col-md-6 col-sm-6">';
					$return.='<div class="featured-imagebox featured-imagebox-portfolio cmt-portfolio-box-view1">';
					$return.='<div class="cmt-box-view-overlay cmt-portfolio-box-view-overlay">';
					$return.='<div class="featured-thumbnail">';
					$return.='<a title="'.$video["ad_$dil"].'"  data-fancybox="video" data-caption="'.$video["ad_$dil"].'" href="'.$video["video_link"].'"> ';
					$return.='<img class="img-fluid" src="upload/'.$video["thumb"].'" alt="'.$video["ad_$dil"].'">';
					$return.='</a>';
					$return.='</div>';
					$return.='<div class="featured-iconbox cmt-media-link">';
					$return.='<a class="link" data-fancybox="video" data-caption="'.$video["ad_$dil"].'" href="'.$video["video_link"].'" >';
					$return.='<i class="fa fa-play"></i>';
					$return.='</a>';
					$return.='</div>';
					$return.='<div class="cmt-box-view-content-inner">';
					$return.='<div class="featured-content featured-content-portfolio">';
					$return.='<div class="featured-title">';
					$return.='<h5>'.$video["ad_$dil"].'</h5>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
			}
		}
		$return.='</div>';
	}
	return $return;
}*/



function getPageVideoGallery($table,$table_id) {
	global $dil,$db,$cfg;
	$sql="SELECT * from videolar where tablo='$table' and tablo_id='$table_id' and video_aktif='1' order by sira";
	$videolar=$db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {

		$return.='<div class="row multi-columns-row cmt-boxes-spacing-10px">';
		foreach ($videolar as $video) {
			if (($video["thumb"]!="") && file_exists("upload/".$video["thumb"])) {




				$return.='<div class="cmt-box-col-wrapper col-lg-4 col-md-4 col-sm-6">';
				$return.='<a class="popup-gallery"  data-fancybox="gallery" title="'.$video["ad_$dil"].'" data-caption="'.$video["ad_$dil"].'"  href="'.$video["video_link"].'">';
				$return.='<div class="featured-imagebox featured-imagebox-team style1">';
				$return.='<div class="cmt-box-view-overlay cmt-team-box-view-overlay">';
				$return.='<div class="featured-thumbnail">';
				$return.='<img class="img-fluid" src="upload/'.$video["thumb"].'" alt="'.$video["ad_$dil"].'">';
				$return.='</div>';
				$return.='</div>';
				$return.='<div class="featured-content imagebox-title featured-content-team">';
				$return.='<div class="team-sep-icon cmt-textcolor-darkgrey"><i class="flaticon flaticon-play"></i></div>';
				$return.='<div class="featured-title">';
				$return.='<h5>'.$video["ad_$dil"].'</h5>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';
				$return.='</a>';
				$return.='</div>';


			}
		}
		$return.='</div>';

	}
	return $return;
}


function getImageGallery($table,$table_id) {
	global $dil,$db;
	$sql="SELECT * from resim where tablo='$table' and tablo_id='$table_id' and resim_aktif='1' order by sira";
	$resimler = $db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {
		$return.='<div class="row">';

		foreach ($resimler as $resim)   {
			if (($resim["thumb"]!="") && file_exists("upload/".$resim["thumb"])) {

				$return.='<div class="col-lg-3 col-md-3 col-xs-6">';
				$return.='<div class="b-personal__worker wow zoomInUp" data-wow-delay="0.5s">';
				$return.='<a data-fancybox="images" class="fancybox" title="'.$resim["ad_$dil"].'"  href="upload/'.$resim["image"].'">';
				$return.='<div class="b-personal__worker-img">';
				$return.='<img src="upload/'.$resim["thumb"].'" class="img-responsive" alt="'.$resim["ad_$dil"].'">';
				$return.='<div class="b-personal__worker-img-social">';
				$return.='<div class="b-personal__worker-img-social-main">';
				$return.='<span class="fa fa-search"></span>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';
				$return.='</a>';
				$return.='</div>';
				$return.='</div>';
			}
		}
		$return.='</div>';
	}
	return $return;
}
function getPageReferencesImages($sayfa_id) {
	global $dil,$db;
	$sql="SELECT * from resim where tablo='sayfa' and tablo_id='$sayfa_id' and resim_aktif='1' order by sira";
	$resimler = $db->get_results($sql,ARRAY_A);
	if ($db->num_rows > 0) {
		$return.='<div class="row">';

		foreach ($resimler as $resim)   {
			if (($resim["thumb"]!="") && file_exists("upload/".$resim["thumb"])) {


				$return.='<div class="col-md-2 col-sm-3 page-references">';
				$return.='<div class="featured-imagebox featured-imagebox-team mb-30">';
				$return.='<div class="featured-thumbnail">';
				$return.='<img class="img-fluid" src="upload/'.$resim["thumb"].'"  alt="'.$resim["ad_$dil"].'">';
				$return.='</a>';
				$return.='</div>';
				$return.='</div>';
				$return.='</div>';

			}
		}
		$return.='</div>';
	}
	return $return;
}

function tofloat($num) {
	$dotPos = strrpos($num, '.');
	$commaPos = strrpos($num, ',');
	$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
	((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

	if (!$sep) {
		return floatval(preg_replace("/[^0-9]/", "", $num));
	}

	return floatval(
		preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
		preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
	);
}
function priceTrim($price){
	$prc      = str_replace(',','',$price);
	$prc      = str_replace(' TL','',$prc);
	return $prc;
}


/*	function getPageImages($sayfa_id) {
		global $dil,$db;
		$sql="SELECT * from resim where tablo='sayfa' and tablo_id='$sayfa_id' and resim_aktif='1' order by sira";
		$resimler = $db->get_results($sql,ARRAY_A);
		if ($db->num_rows > 0) {
			$return.='<div class="sortable-masonry2">';
			$return.='<div class="items-container row">';

			foreach ($resimler as $resim)   {
				if (($resim["thumb"]!="") && file_exists("upload/".$resim["thumb"])) {

					$return.='<div class="gallery-block masonry-item col-lg-3 col-md-6">';
					$return.='<a class="lightbox-image" data-fancybox="gallery" title="'.$resim["ad_$dil"].'"  href="upload/'.$resim["image"].'">';
					$return.='<div class="inner-box">';
					$return.='<div class="image">';
					$return.='<img src="upload/'.$resim["thumb"].'" class="img-responsive" alt="'.$resim["ad_$dil"].'">';
					$return.='</div>';
					$return.='<div class="overlay">';
					$return.='<div class="zoom-btn">';
					$return.='<img src="assets\images\icons\icon-11.png" alt="'.$resim["ad_$dil"].'">';
					$return.='</div>';
					$return.='<h4><span>'.$resim["ad_$dil"].'</span></h4>';
					$return.='</div>';
					$return.='</div>';
					$return.='</a>';
					$return.='</div>';
				}
			}
			$return.='</div>';
			$return.='</div>';
		}
		return $return;
	}	*/
	/*function getPageImages($sayfa_id) {
		global $dil,$db;
		$sql="SELECT * from resim where tablo='sayfa' and tablo_id='$sayfa_id' and resim_aktif='1' order by sira";
		$resimler = $db->get_results($sql,ARRAY_A);
		if ($db->num_rows > 0) {

			$return.='<div class="row multi-columns-row cmt-boxes-spacing-15px">';

			foreach ($resimler as $resim)   {
				if (($resim["thumb"]!="") && file_exists("upload/".$resim["thumb"])) {


					$return.='<div class="cmt-box-col-wrapper col-lg-4 col-md-6 col-sm-6">';
					$return.='<div class="featured-imagebox featured-imagebox-portfolio cmt-portfolio-box-view1">';
					$return.='<div class="cmt-box-view-overlay cmt-portfolio-box-view-overlay">';
					$return.='<div class="featured-thumbnail">';
					
					$return.='<a href="#">';
					$return.='<img class="img-fluid" src="upload/'.$resim["thumb"].'" alt="'.$resim["ad_$dil"].'">';
					$return.='</a>';
					$return.='</div>';
					$return.='<div class="featured-iconbox cmt-media-link">';
					$return.='<a  data-fancybox="gallery" data-caption="'.$resim["ad_$dil"].'" title="'.$resim["ad_$dil"].'"  href="upload/'.$resim["image"].'">';
					$return.='<i class="fa fa-expand"></i>';
					$return.='</a>';
					$return.='</div>';
					$return.='<div class="cmt-box-view-content-inner">';
					$return.='<div class="featured-content featured-content-portfolio">';
					$return.='<div class="featured-title">';
					$return.='<h5>'.$resim["ad_$dil"].'</h5>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
				}
			}
			$return.='</div>';

		}
		return $return;
	}
*/

	function getPageImages($sayfa_id) {
		global $dil,$db;
		$sql="SELECT * from resim where tablo='sayfa' and tablo_id='$sayfa_id' and resim_aktif='1' order by sira";
		$resimler = $db->get_results($sql,ARRAY_A);
		if ($db->num_rows > 0) {
			$return.='<div class="row multi-columns-row cmt-boxes-spacing-10px">';
			foreach ($resimler as $resim)   {
				if (($resim["thumb"]!="") && file_exists("upload/".$resim["thumb"])) {

					$return.='<div class="cmt-box-col-wrapper col-lg-4 col-md-4 col-sm-6">';
					$return.='<a class="popup-gallery" title="'.$resim["ad_$dil"].'" data-fancybox="gallery" data-caption="'.$resim["ad_$dil"].'" title="'.$resim["ad_$dil"].'"  href="upload/'.$resim["image"].'">';
					$return.='<div class="featured-imagebox featured-imagebox-team style1">';
					$return.='<div class="cmt-box-view-overlay cmt-team-box-view-overlay">';
					$return.='<div class="featured-thumbnail">';
					$return.='<img class="img-fluid" src="upload/'.$resim["thumb"].'" alt="'.$resim["ad_$dil"].'">';
					$return.='</div>';
					$return.='</div>';
					$return.='<div class="featured-content imagebox-title featured-content-team">';
					$return.='<div class="team-sep-icon cmt-textcolor-darkgrey"><i class="fa fa-expand"></i></div>';
					$return.='<div class="featured-title">';
					$return.='<h5>'.$resim["ad_$dil"].'</h5>';
					$return.='</div>';
					$return.='</div>';
					$return.='</div>';
					$return.='</a>';
					$return.='</div>';
				}
			}
			$return.='</div>';
		}
		return $return;
	}


	function resolvePerma($perma) {
		global $db,$dil;
		$sayfa_id = getSayfaIdFromPerma($perma);

		if ($sayfa_id > 0) {
			$pg="page";
		} else {
			switch ($perma) {
				case 'iletisim':$pg="iletisim";break;
				case 'proje':$pg="proje";break;
				case 'fuar':$pg="fuar";break;
				case 'haberler':$pg="haberler";break;

				default:$pg="page";break;
			}
		}
		return ["id" => $sayfa_id, "pg" => $pg ];

	}

	function GetMetodu($url) { 
		$ch = curl_init(); 
		curl_setopt($ch,CURLOPT_URL,$url); 
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 

		$output=curl_exec($ch); 
		curl_close($ch); 
		return $output; 
	} 




	$config=getConfig();

	$dil="tr";
	if ($dil=='') $dil=$config["default_lang"];
	if(!file_exists('languages/'.$dil.'.php')) { $dil=$config["default_lang"];}
	include_once "languages/".$dil.".php";




	$pg=$_GET["pg"];
	if($pg=="") $pg="main";

	if(!file_exists($pg.".php")) $pg="main";
	require 'functions/seo_functions.php';
	if ($dil=="tr") {
		if ( $_COOKIE['introgosterildi']!=1 ) { setcookie("introgosterildi","1",0); $displayintro=true; }
		else $displayintro=false; 
	} if ($dil=="en") {
		if ( $_COOKIE['introgosterildien']!=1 ) { setcookie("introgosterildien","1",0); $displayintro=true; }
		else $displayintro=false; 
	}

	$acilis_banner=getAcilisBanner();

