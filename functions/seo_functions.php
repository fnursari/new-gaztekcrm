<?php 

function permayap($str) {
	global $dil;
	if ($dil=="tr" || $dil=="en") {
		$turkce=array("ş","Ş","ı","İ","ü","Ü","ö","Ö","ç","Ç","ğ","Ğ");
		$duzgun=array("s","S","i","I","u","U","o","O","c","C","g","G");
	} elseif($dil=="ru") {
		$turkce = array(
			'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
			'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'ы', 'Ь', 'Э', 'Ю', 'Я' );
		$duzgun = array(
			'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya',
			'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e', 'yu', 'ya');

	}  elseif($dil=="ar") {
		$turkce = array(
			"ا","أ", "إ", "آ", 
			"ب", "ت", "ث", "ج", 
			"ح", "خ", "د", "ذ", 
			"ر", "ز", "س", "ش", 
			"ص", "ض", "ط", "ظ", 
			"ع", "غ", "ف", "ق",
"ك","ل","م","ن",
			"ه", "و", "ي", "اي", 
			"ة", "ئ", "ى", "ء", 
			"ؤ", "َ", "ُ", "ِ", 
			" ٌ", "ٍ", "ً", "تش"
		);
		$duzgun = array(
			"a", "a","ie","aa",
			"b","t","th","j",
			"h","kh", "d", "thz",
			 "r", "z", "s","sh",
			 "ss", "dt", "td", "thz",
			 "a", "gh", "f", "q",
			 "k", "l", "m", "n",
			 "h", "w", "e", "i",
			 "tt", "ae", "a", "aa",
			 "uo","a", "u", "e",
			 "on","en", "an", "tsch"
		);


	}

	$str=str_replace($turkce,$duzgun,$str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", '-', $clean);
	return mb_substr($clean,0,200,'UTF-8');

}
function permayap2($str) {
	global $dil;
	$clean = preg_replace("/[\/_|+ -]+/", '-', $str);
	return mb_substr($clean,0,200,'UTF-8');

}
$perma=$_GET["perma"];
if ($perma!="") {
	$sayfa_id=$db->get_var("Select sayfa_id from sayfa where sayfa_link_$dil='$perma'");
	if ($sayfa_id > 0) {
		if ($sayfa_id==8) {
			$pg="iletisim";
		} 
		else if ($sayfa_id==3) {
			$pg="haberler";
		} 
		else {
			$pg="page";
		}
		
	} else {
		switch ($perma) {
			case 'search':$pg="search";break;
			case 'iletisim':$pg="iletisim";break;
			case 'uruntakvimi':$pg="uruntakvimi";break;
			case 'uretim':$pg="uretim";break;
			case 'faq':$pg="faq";break;
			case 'haberler':$pg="haberler";break;
			case 'urunler':$pg="urunler";break;
			case 'videogallery':$pg="videogallery";break;
			case 'teklifal':$pg="teklifal";break;
			case 'referanslar':$pg="referanslar";break;
			case 'search':$pg="search";break;
			case 'fuarlar':$pg="fuarlar";break;
			
			default:$pg="main";break;
		}
	}

}


function keywordyap($deger) {
	global $dil,$config;
	$kwp=explode(" ",$deger);
	$deger="";
	for($i=0;$i<count($kwp);$i++)
	{
		if($kwp[$i]!="") $deger.=$kwp[$i].", ";
	}
	$deger.=$config["seo_keyword_$dil"];
	return $deger;
}
function descriptionyap($deger) {
	global $dil,$config;
	$stripped=strip_tags($deger);
	$deger=substr($stripped,0,200); 
	if($deger!="") $deger.=". ";
	$deger.=$config["seo_description_$dil"];
	return $deger;
}
function titleyap($deger) {
	global $dil,$config;
	if($deger=="") $deger=$config["seo_baslik_$dil"];
	else $deger.=" - ".$config["seo_baslik_$dil"];
	return $deger;
}

function purifyTag($tag) {
	return strip_tags(str_replace('&nbsp;',' ',$tag));
}

$request_uri=$_SERVER['REQUEST_URI'];
if($request_uri!="/")
{
	if($dil=="tr")
	{
		$tr_url=$request_uri;
		$en_url=str_replace('_tr.html','_en.html',$request_uri);
		$ru_url=str_replace('_tr.html','_ru.html',$request_uri);
		$de_url=str_replace('_tr.html','_de.html',$request_uri);
		$ar_url=str_replace('_tr.html','_ar.html',$request_uri);
		$fr_url=str_replace('_tr.html','_fr.html',$request_uri);
		$es_url=str_replace('_tr.html','_es.html',$request_uri);
		$sq_url=str_replace('_tr.html','_sq.html',$request_uri);
	}
	else if($dil=="en")
	{
		$en_url=$request_uri;
		$tr_url=str_replace('_en.html','_tr.html',$request_uri);
		$ru_url=str_replace('_en.html','_ru.html',$request_uri);
		$de_url=str_replace('_en.html','_de.html',$request_uri);
		$ar_url=str_replace('_en.html','_ar.html',$request_uri);
		$fr_url=str_replace('_en.html','_fr.html',$request_uri);
		$es_url=str_replace('_en.html','_es.html',$request_uri);
		$sq_url=str_replace('_en.html','_sq.html',$request_uri);
	}
	else if($dil=="ru")
	{
		$ru_url=$request_uri;
		$tr_url=str_replace('_ru.html','_tr.html',$request_uri);
		$en_url=str_replace('_ru.html','_en.html',$request_uri);
		$de_url=str_replace('_ru.html','_de.html',$request_uri);
		$ar_url=str_replace('_ru.html','_ar.html',$request_uri);
		$fr_url=str_replace('_ru.html','_fr.html',$request_uri);
		$es_url=str_replace('_ru.html','_es.html',$request_uri);
		$sq_url=str_replace('_ru.html','_sq.html',$request_uri);
	}
	else if($dil=="ar")
	{
		$ar_url=$request_uri;
		$tr_url=str_replace('_ar.html','_tr.html',$request_uri);
		$en_url=str_replace('_ar.html','_en.html',$request_uri);
		$ru_url=str_replace('_ar.html','_ru.html',$request_uri);
		$de_url=str_replace('_ar.html','_de.html',$request_uri);
		$fr_url=str_replace('_ar.html','_fr.html',$request_uri);
		$es_url=str_replace('_ar.html','_es.html',$request_uri);
		$sq_url=str_replace('_ar.html','_sq.html',$request_uri);
	}
	else if($dil=="fr")
	{
		$fr_url=$request_uri;
		$tr_url=str_replace('_fr.html','_tr.html',$request_uri);
		$en_url=str_replace('_fr.html','_en.html',$request_uri);
		$ru_url=str_replace('_fr.html','_ru.html',$request_uri);
		$de_url=str_replace('_fr.html','_de.html',$request_uri);
		$ar_url=str_replace('_fr.html','_ar.html',$request_uri);
		$es_url=str_replace('_fr.html','_es.html',$request_uri);
		$sq_url=str_replace('_fr.html','_sq.html',$request_uri);
	}
	else if($dil=="es")
	{
		$es_url=$request_uri;
		$tr_url=str_replace('_es.html','_tr.html',$request_uri);
		$en_url=str_replace('_es.html','_en.html',$request_uri);
		$ru_url=str_replace('_es.html','_ru.html',$request_uri);
		$de_url=str_replace('_es.html','_de.html',$request_uri);
		$ar_url=str_replace('_es.html','_ar.html',$request_uri);
		$fr_url=str_replace('_es.html','_fr.html',$request_uri);
		$sq_url=str_replace('_es.html','_sq.html',$request_uri);
	}
	else if($dil=="sq")
	{
		$sq_url=$request_uri;
		$tr_url=str_replace('_sq.html','_tr.html',$request_uri);
		$en_url=str_replace('_sq.html','_en.html',$request_uri);
		$ru_url=str_replace('_sq.html','_ru.html',$request_uri);
		$de_url=str_replace('_sq.html','_de.html',$request_uri);
		$ar_url=str_replace('_sq.html','_ar.html',$request_uri);
		$fr_url=str_replace('_sq.html','_fr.html',$request_uri);
		$es_url=str_replace('_sq.html','_es.html',$request_uri);
	}
	else if($dil=="de")
	{
		$de_url=$request_uri;
		$tr_url=str_replace('_de.html','_tr.html',$request_uri);
		$en_url=str_replace('_de.html','_en.html',$request_uri);
		$ru_url=str_replace('_de.html','_ru.html',$request_uri);
		$de_url=str_replace('_de.html','_de.html',$request_uri);
		$ar_url=str_replace('_de.html','_ar.html',$request_uri);
		$fr_url=str_replace('_de.html','_fr.html',$request_uri);
		$es_url=str_replace('_de.html','_es.html',$request_uri);
	}
		
}
else
{
	$tr_url="index_tr.html";
	$en_url="index_en.html";
	$ru_url="index_ru.html";
	$ar_url="index_ar.html";
	$de_url="index_de.html";
	$fr_url="index_fr.html";
	$es_url="index_es.html";
	$sq_url="index_sq.html";
}


switch($pg) {
	case "main" :  {
		$title=$config["seo_baslik_$dil"];
		$keyword=$config["seo_keyword_$dil"];
		$description=$config["seo_description_$dil"];
		$canonical_link=$cfg["SiteUrl"]."";
		$content_url=$cfg["SiteUrl"];
		$content_title=$config["seo_baslik_$dil"];
		$content_image=$cfg["SiteUrl"]."images/logo-social.png";
		$content_desc=$config["seo_description_$dil"];

		break;
	}
	case "page" : {
		if ($sayfa_id!="") {
			$page_id=$sayfa_id;
		} else {
			$page_id=makeSafe($_REQUEST["page_id"]);
		}
		$page_ad=makeSafe($_REQUEST["page_ad"]);

		if($page_id==strval(intval($page_id))) {
			
			$sql="SELECT * FROM sayfa WHERE sayfa_aktif = '1' AND sayfa_id = '$page_id'";
			$page_details = $db->get_row($sql,ARRAY_A); 
			if ($page_details["sayfa_etiket_$dil"]!="") {
			 	$pagetitle=$page_details["sayfa_ad_$dil"]." - ".$page_details["sayfa_etiket_$dil"];
			 	$pagekeyword=$page_details["sayfa_ad_$dil"];
			} else {
				$pagetitle=$page_details["sayfa_ad_$dil"];
				$pagekeyword=$page_details["sayfa_ad_$dil"];
			}
			
			$title=titleyap($pagetitle,$dil);
			$keyword=keywordyap($pagekeyword,$dil);
			$description=descriptionyap($pagetitle,$dil);	
			$canonical_link=$cfg["SiteUrl"].$perma."_".$dil.".html";		
		}
		
		break;
	}

	
	case "search" : 
	{
		$s=makeSafe($_REQUEST["s"]);
		$title=titleyap($lang["Products"],$dil);
		$keyword=keywordyap($lang["Products"],$dil);
		$description=descriptionyap($lang["Products"],$dil);
		break;
	}

	case "news" : {
		$title=titleyap($lang["News"]);
		$keyword=keywordyap($lang["News"]);
		$description=descriptionyap($lang["News"]);
		break;
	}
	case "fairs" : {
		$title=titleyap($lang["Fairs"]);
		$keyword=keywordyap($lang["Fairs"]);
		$description=descriptionyap($lang["Fairs"]);
		break;
	}
	case "blog" : {
		$title=titleyap($lang["Blog"]);
		$keyword=keywordyap($lang["Blog"]);
		$description=descriptionyap($lang["Blog"]);
		break;
	}
	case "teklifal" : {
		$title=titleyap($lang["TeklifAl"]);
		$keyword=keywordyap($lang["TeklifAl"]);
		$description=descriptionyap($lang["TeklifAl"]);
		break;
	}
	case "teklif" : {
		$title=titleyap($lang["TeklifAl"]);
		$keyword=keywordyap($lang["TeklifAl"]);
		$description=descriptionyap($lang["TeklifAl"]);
		break;
	}
	/*case "urunler" : {
		$title=titleyap($lang["Products"]);
		$keyword=keywordyap($lang["Products"]);
		$description=descriptionyap($lang["Products"]);
		break;
	}*/
	case "kategoriler" : {
		$title=titleyap($lang["OurProducts"]);
		$keyword=keywordyap($lang["OurProducts"]);
		$description=descriptionyap($lang["OurProducts"]);
		break;
	}

	case "photogallery" : {
		$title=titleyap($lang["PhotoGallery"]);
		$keyword=keywordyap($lang["PhotoGallery"]);
		$description=descriptionyap($lang["PhotoGallery"]);
		break;
	}
	case "videogallery" : {
		$title=titleyap($lang["VideoGallery"]);
		$keyword=keywordyap($lang["VideoGallery"]);
		$description=descriptionyap($lang["VideoGallery"]);
		break;
	}
	case "fuarlar" : {
		$title=titleyap($lang["Fuarlar"]);
		$keyword=keywordyap($lang["Fuarlar"]);
		$description=descriptionyap($lang["Fuarlar"]);
		break;
	}

	case "uruntakvimi" : {
		$title=titleyap($lang["UrunTakvimi"]);
		$keyword=keywordyap($lang["UrunTakvimi"]);
		$description=descriptionyap($lang["UrunTakvimi"]);
		break;
	}
	case "uretim" : {
		$title=titleyap($lang["Production"]);
		$keyword=keywordyap($lang["Production"]);
		$description=descriptionyap($lang["Production"]);
		break;
	}
	case "iletisim" : {
		$title=titleyap($lang["ContactUs"]);
		$keyword=keywordyap($lang["ContactUs"]);
		$description=descriptionyap($lang["ContactUs"]);
		break;
	}
	case "humanresources" : {
		$title=titleyap($lang["HumanResources"]);
		$keyword=keywordyap($lang["HumanResources"]);
		$description=descriptionyap($lang["HumanResources"]);
		break;
	}
	case "faq" : {
		$title=titleyap($lang["FAQ"]);
		$keyword=keywordyap($lang["FAQ"]);
		$description=descriptionyap($lang["FAQ"]);
		break;
	}
	case "referanslar" : {
		$title=titleyap($lang["References"]);
		$keyword=keywordyap($lang["References"]);
		$description=descriptionyap($lang["References"]);
		break;
	}
	case "downloads" : {
		$title=titleyap($lang["Downloads"]);
		$keyword=keywordyap($lang["Downloads"]);
		$description=descriptionyap($lang["Downloads"]);
		break;
	}

	
	case "ikincielurunler" : {
		$title=titleyap($lang["IkinciElUrunler"]);
		$keyword=keywordyap($lang["IkinciElUrunler"]);
		$description=descriptionyap($lang["IkinciElUrunler"]);
		break;
	}
	/*case "search" : 
	{
		
		$q=makeSafe($_REQUEST["q"]);

		$brand=makeSafe($_REQUEST["marka"]);
		$category=makeSafe($_REQUEST["kategori_id"]);
		$model=makeSafe($_REQUEST["model"]);
		$group=makeSafe($_REQUEST["group"]);
		$oem_no=makeSafe($_REQUEST["oem_no"]);
		$grm_no=makeSafe($_REQUEST["grm_no"]);
		$cross_no=makeSafe($_REQUEST["cross_no"]);
		$year=makeSafe($_REQUEST["year"]);
		$sayfanum=intval($_GET["sayfanum"]);

		$title=titleyap($lang["Products"]);
		$keyword=keywordyap($lang["Products"]);
		$description=descriptionyap($lang["Products"]);
		break;
	}*/
	case "urunler" : {
		$kategori_ad=makeSafe($_REQUEST["kategori_ad"]);
		$kategori_id=makeSafe($_REQUEST["kategori_id"]);

		if($kategori_id==strval(intval($kategori_id))) {
			$sql = "select * from urun where urun_aktif='1' and kategori_id='$kategori_id' order by sira"; 
			$urun_details = $db->get_results($sql,ARRAY_A);
			$urun_say=$db->num_rows;
			$kategori_details = $db->get_row("select * from urun_kategori where kategori_aktif='1' and kategori_id='$kategori_id'",ARRAY_A); 
			$ana_id=$kategori_details["ana_id"];
			$anakategori_details = $db->get_row("select * from urun_kategori where kategori_aktif='1' and kategori_id='$ana_id'",ARRAY_A); 
			if($kategori_details["seo_baslik_$dil"]!="") $title=$kategori_details["seo_baslik_$dil"];
			 else   $title=titleyap($kategori_details["kategori_ad_$dil"]);
			 
			 
			if($kategori_details["seo_keyword_$dil"]!="") $keyword=$kategori_details["seo_keyword_$dil"];
			 else   $keyword=keywordyap($kategori_details["kategori_ad_$dil"]);

			if($kategori_details["seo_description_$dil"]!="") $description=$kategori_details["seo_description_$dil"];
			 else   $description=descriptionyap($kategori_details["kategori_ad_$dil"]);
			 
			 
			 if($kategori_details["seo_baslik_$dil"]!="") $canonical_link=$cfg["SiteUrl"].permayap($kategori_details["seo_baslik_$dil"])."_".$kategori_details["kategori_id"]."_c_".$dil.".html";
			else $canonical_link=$cfg["SiteUrl"].permayap($kategori_details["kategori_ad_$dil"])."_".$kategori_details["kategori_id"]."_c_".$dil.".html";
			if($kategori_details["ana_id"]!="0") {

				$sql = "select * from urun_kategori where kategori_aktif='1' and kategori_id='".$kategori_details["ana_id"]."'"; 
				$anakategori_details = $db->get_row($sql,ARRAY_A); 
				$alt_ana_id=$anakategori_details["ana_id"];
				$title=$anakategori_details["kategori_ad_$dil"].' | '.$title;
			}
			
		}
		break;
	}

	case "kategori" : {
		$kategori_ad=makeSafe($_REQUEST["kategori_ad"]);
		$kategori_id=makeSafe($_REQUEST["kategori_id"]);

		if($kategori_id==strval(intval($kategori_id))) {
			$sql = "select * from urun where urun_aktif='1' and kategori_id='$kategori_id' order by sira"; 
			$urun_details = $db->get_results($sql,ARRAY_A);
			$urun_say=$db->num_rows;
			$kategori_details = $db->get_row("select * from urun_kategori where kategori_aktif='1' and kategori_id='$kategori_id'",ARRAY_A); 
			$ana_id=$kategori_details["ana_id"];
			if($kategori_details["seo_baslik_$dil"]!="") $title=$kategori_details["seo_baslik_$dil"];
			 else   $title=titleyap($kategori_details["kategori_ad_$dil"]);
			 
			 
			if($kategori_details["seo_keyword_$dil"]!="") $keyword=$kategori_details["seo_keyword_$dil"];
			 else   $keyword=keywordyap($kategori_details["kategori_ad_$dil"]);

			if($kategori_details["seo_description_$dil"]!="") $description=$kategori_details["seo_description_$dil"];
			 else   $description=descriptionyap($kategori_details["kategori_ad_$dil"]);
			 
			 
			 if($kategori_details["seo_baslik_$dil"]!="") $canonical_link=$cfg["SiteUrl"].permayap($kategori_details["seo_baslik_$dil"])."_".$kategori_details["kategori_id"]."_c_".$dil.".html";
			else $canonical_link=$cfg["SiteUrl"].permayap($kategori_details["kategori_ad_$dil"])."_".$kategori_details["kategori_id"]."_c_".$dil.".html";

			if($kategori_details["ana_id"]!="0") {

				$sql = "select * from urun_kategori where kategori_aktif='1' and kategori_id='".$kategori_details["ana_id"]."'"; 
				$anakategori_details = $db->get_row($sql,ARRAY_A); 
				$alt_ana_id=$anakategori_details["ana_id"];
				$title=$anakategori_details["kategori_ad_$dil"].' | '.$title;
			}
			
		}
		break;
	}
	case "ikincielurun" : {
		$urun_id=makeSafe($_REQUEST["urun_id"]);
		$urun_ad=makeSafe($_REQUEST["urun_ad"]);

		if($urun_id==strval(intval($urun_id))) {

			$sql="SELECT * FROM ikincielurun WHERE urun_aktif = '1' AND urun_id = '$urun_id'";
			$urun_details = $db->get_row($sql,ARRAY_A); 

			$title=titleyap($urun_details["urun_ad_$dil"]);
			$keyword=keywordyap($urun_details["urun_ad_$dil"]);
			$description=descriptionyap($urun_details["urun_ad_$dil"]);
			
				
				$content_url=$cfg["SiteUrl"].permayap($urun_details["urun_ad_$dil"])."_".$urun_details["urun_id"]."_up_".$dil.".html";
				$content_title=$urun_details["urun_ad_$dil"];
				$canonical_link=$cfg["SiteUrl"].permayap($urun_details["urun_ad_$dil"])."_".$urun_details["urun_id"]."_up_".$dil.".html";
			
			
			$content_image=$cfg["SiteUrl"]."upload/usedproduct/".$urun_details["resim_buyuk"];
			$content_desc=strip_tags($urun_details["urun_icerik_$dil"]);

			
		}
		break;
	}
	case "urun" : {
		$urun_id=makeSafe($_REQUEST["urun_id"]);
		$urun_ad=makeSafe($_REQUEST["urun_ad"]);

		if($urun_id==strval(intval($urun_id))) {

			$sql="SELECT * FROM urun WHERE urun_aktif = '1' AND urun_id = '$urun_id'";
			$urun_details = $db->get_row($sql,ARRAY_A); 
			$kategori_id=$urun_details["kategori_id"];
			$seo_title = formatTitle($urun_details["seo_baslik_$dil"],$urun_details["urun_ad_$dil"]);
			$seo_desc = formatTitle($urun_details["seo_description_$dil"],$urun_details["urun_ad_$dil"]);
			$sql = "select * from urun_kategori where kategori_aktif='1' and kategori_id='$urun_details[kategori_id]'";
			$kategori_details = $db->get_row($sql,ARRAY_A);
			$ana_id=$kategori_details["ana_id"];

			if($kategori_details["seo_baslik_$dil"]!="") $kategori_seo_baslik=$kategori_details["seo_baslik_$dil"];
			else $kategori_seo_baslik=$kategori_details["kategori_ad_$dil"];

			if($urun_details["seo_baslik_$dil"]!="") $title=$urun_details["seo_baslik_$dil"];
			else $title=titleyap($urun_details["urun_ad_$dil"].' '.$urun_details["grm_no"].' '.$urun_details["oem_no"]);
			if($urun_details["seo_keyword_$dil"]!="") $keyword=$urun_details["seo_keyword_$dil"];
			else $keyword=keywordyap($urun_details["urun_ad_$dil"].' '.$urun_details["grm_no"].' '.$urun_details["oem_no"]);
			if($urun_details["seo_description_$dil"]!="") $description=$urun_details["seo_description_$dil"];
			else $description=descriptionyap($urun_details["urun_ad_$dil"].' '.$urun_details["grm_no"].' '.$urun_details["oem_no"]);
			if ($urun_details["seo_baslik_$dil"]!="") {
				$content_url=$cfg["SiteUrl"].permayap($urun_details["seo_baslik_$dil"])."_".$urun_details["urun_id"]."_u_".$dil.".html";
				$content_title=$urun_details["urun_ad_$dil"];
				$canonical_link=$cfg["SiteUrl"].permayap($urun_details["seo_baslik_$dil"])."_".$urun_details["urun_id"]."_u_".$dil.".html";
			}
			else {
				
				$content_url=$cfg["SiteUrl"].permayap($urun_details["urun_ad_$dil"])."_".$urun_details["urun_id"]."_u_".$dil.".html";
				$content_title=$urun_details["urun_ad_$dil"];
				$canonical_link=$cfg["SiteUrl"].permayap($urun_details["urun_ad_$dil"])."_".$urun_details["urun_id"]."_u_".$dil.".html";
			}
			if($kategori_details["ana_id"]!="0") {

				$sql = "select * from urun_kategori where kategori_aktif='1' and kategori_id='".$kategori_details["ana_id"]."'"; 
				$anakategori_details = $db->get_row($sql,ARRAY_A); 
				$alt_ana_id=$anakategori_details["ana_id"];
			}
			$content_image=$cfg["SiteUrl"]."upload/product/".$urun_details["resim_buyuk"];
			$content_desc=formatTitle($urun_details["seo_description_$dil"],$urun_details["urun_icerik_$dil"]);

			
		}
		break;
	}
	case "departments" : {
		$departman_id=makeSafe($_REQUEST["departman_id"]);
		$departman_ad=makeSafe($_REQUEST["departman_ad"]);

		if($departman_id==strval(intval($departman_id))) {

			$sql="SELECT * FROM departman WHERE departman_aktif = '1' AND departman_id = '$departman_id'";
			$departman_details = $db->get_row($sql,ARRAY_A); 
			$kategori_id=$departman_details["kategori_id"];
			$seo_title = formatTitle($departman_details["seo_baslik_$dil"],$departman_details["departman_ad_$dil"]);
			$seo_desc = formatTitle($departman_details["seo_description_$dil"],$departman_details["departman_ad_$dil"]);
			

			if($departman_details["seo_baslik_$dil"]!="") $title=$departman_details["seo_baslik_$dil"];
			else $title=titleyap($departman_details["departman_ad_$dil"]);
			if($departman_details["seo_keyword_$dil"]!="") $keyword=$departman_details["seo_keyword_$dil"];
			else $keyword=keywordyap($departman_details["departman_ad_$dil"]);
			if($departman_details["seo_description_$dil"]!="") $description=$departman_details["seo_description_$dil"];
			else $description=descriptionyap($departman_details["departman_ad_$dil"]);
			
			
	

			
		} else {
			$title=titleyap($lang["Departments"]);
			$keyword=keywordyap($lang["Departments"]);
			$description=descriptionyap($lang["Departments"]);
		}
		break;
	}

	case "haberler" : {
		$title=titleyap($lang["HaberlerDesc"]);
		$keyword=keywordyap($lang["HaberlerDesc"]);
		$description=descriptionyap($lang["HaberlerDesc"]);
		break;
	}
		
	case "newsdetails" : {
		$haber_id=$_GET["haber_id"];
		$haber_baslik=$_GET["haber_baslik"];
		if($haber_id==strval(intval($haber_id))) {
			$sql = "select * from haber where haber_aktif='1' and haber_id='$haber_id'"; 
			$haber_details = $db->get_row($sql,ARRAY_A); 
			$pagetitle=$haber_details["haber_baslik_$dil"];
			$canonical_link=$cfg["SiteUrl"].permayap($haber_details["haber_baslik_$dil"])."_".$haber_details["haber_id"]."_h_".$dil.".html";
			
		}
		$title=titleyap($pagetitle,$dil);
		$keyword=keywordyap($pagetitle,$dil);
		$description=descriptionyap($pagetitle,$dil);
		break;
	}
	case "fairsdetails" : {
		$fuar_id=$_GET["fuar_id"];
		$fuar_baslik=$_GET["fuar_baslik"];
		if($fuar_id==strval(intval($fuar_id))) {
			$sql = "select * from fuar where fuar_aktif='1' and fuar_id='$fuar_id'"; 
			$fuar_details = $db->get_row($sql,ARRAY_A); 
			$pagetitle=$fuar_details["fuar_baslik_$dil"];
			$canonical_link=$cfg["SiteUrl"].permayap($fuar_details["fuar_baslik_$dil"])."_".$fuar_details["fuar_id"]."_f_".$dil.".html";
			
		}
		$title=titleyap($pagetitle,$dil);
		$keyword=keywordyap($pagetitle,$dil);
		$description=descriptionyap($pagetitle,$dil);
		break;
	}


	
}
?>