<?php
function tarih_formatla($tarih) {
    $t=explode("-",$tarih);
    return $t["2"].".".$t["1"].".".$t[0];
}

function makeUnixTime($datetime) {
    $val = explode(" ",$datetime);
    $date = explode("-",$val[0]);
    $time = explode(":",$val[1]);
    return mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
} 

function turkce_tarih($pul) {
    $gunler = array('Pazar', 'Pazartesi', 'Sali', 'Carsamba', 'Persembe', 
        'Cuma', 'Cumartesi');
    $aylar  = array('', 'Ocak', 'Subat', 'Mart', 'Nisan', 'Mayis', 'Haziran', 
        'Temmuz', 'Agustos', 'Eylul', 'Ekim', 'Kasim', 'Aralik');
    return date("d ", $pul).$aylar[date("n", $pul)].date(" Y ", $pul).
    $gunler[date("w", $pul)].date(" H",$pul).":".date("i",$pul).":".date("s",$pul);
}

function turkce_tarih1($pul) {
    $gunler = array('', '', '', '', '', 
        '', '');
    $aylar  = array('', '01', '02', '03', '04', '05', '06', 
        '07', '08', '09', '10', '11', '12');
    return date("d", $pul).".".$aylar[date("n", $pul)].".".date("Y", $pul).
    $gunler[date("w", $pul)].date(" H",$pul).":".date("i",$pul).":".date("s",$pul);
}

function tarih_formatla_saatli($dt) {
    return turkce_tarih1(makeUnixTime($dt));
}



function aybul($tarih) {
    $exp=explode("-",$tarih);
    if($exp[1]=="01") return "Ocak ".$exp[0];
    else if($exp[1]=="02") return "Şubat ".$exp[0];
    else if($exp[1]=="03") return "Mart ".$exp[0];
    else if($exp[1]=="04") return "Nisan ".$exp[0];
    else if($exp[1]=="05") return "Mayıs ".$exp[0];
    else if($exp[1]=="06") return "Haziran ".$exp[0];
    else if($exp[1]=="07") return "Temmuz ".$exp[0];
    else if($exp[1]=="08") return "Ağustos ".$exp[0];
    else if($exp[1]=="09") return "Eylül ".$exp[0];
    else if($exp[1]=="10") return "Ekim ".$exp[0];
    else if($exp[1]=="11") return "Kasım ".$exp[0];
    else if($exp[1]=="12") return "Aralık ".$exp[0];
}

function tarih_ay($pul) {
    global $dil;
    $exp=explode("-",$pul);
    $aylar = array(1 => "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
    $month_en = array(1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $ay=intval($exp[1]);
    if ($dil=="tr") {
        $month=$aylar[$ay];
    }
    else{
        $month=$month_en[$ay];
    }   
    return $month;
}

function tarih_gun($pul) {
    $exp=explode("-",$pul);
    return $exp[2];
}
function tarih_yil($pul) {
    $exp=explode("-",$pul);
    return $exp[0];
}
function turkish_date($pul) 
{
    $exp=explode("-",$pul);
    return $exp[2];
    $aylar[$ay]; 
}

function turkishDate($pul) 
{
    global $dil;
    $exp=explode("-",$pul);
    $aylar = array(1 => "Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara");
    $month_en = array(1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $ay=intval($exp[1]);
    if ($dil=="tr") {
        $month=$aylar[$ay];
    }
    else{
        $month=$month_en[$ay];
    }

    
    return $month;
}


function haberTarih($pul) 
{
    global $dil;
    $exp=explode("-",$pul);
    $aylar = array(1 => "Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara");
    $month_en = array(1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $ay=intval($exp[1]);
    if ($dil=="tr") {
        $month=$aylar[$ay];
    }
    else{
        $month=$month_en[$ay];
    }

    return $exp["2"]." ".$month." ".$exp[0];
}


function pdfTarih($pul,$dil) 
{
   /* global $dil;*/
    $exp=explode("-",$pul);
    $aylar = array(1 => "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
    $month_en = array(1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $ay=intval($exp[1]);
    if ($dil=="tr") {
        $month=$aylar[$ay];
    }
    else{
        $month=$month_en[$ay];
    }

    return $exp["2"]." ".$month." ".$exp[0];
}



function teslimTarih($tarih,$teslim_gun,$dil) 
{
    /*global $dil;*/


    $t=explode("-",$tarih);
	$day=$t[2]+$teslim_gun;
	if($day>30){
        $day= $day-30;
		$t[1]+=1;
		if($t[1]>12){
			$t[1]=1;
			$t[0]+=1;
		}
	}

    $aylar = array(1 => "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
    $month_en = array(1 => "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    $ay=intval($t[1]);
    if ($dil=="tr") {
        $month=$aylar[$ay];
    }
    else{
        $month=$month_en[$ay];
    }

    return $day." ".$month." ".$t[0];
}