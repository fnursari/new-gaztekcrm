<?php
function pagination ($urlformat,$num,$sayfanum,$per_page,$showeachside=8) {
    $start=$sayfanum*$per_page;
    $max_pages = ceil($num / $per_page);
    $cur = ceil($start / $per_page)+1;

    $return.='<ul class="styled-pagination">';
    /*$return.='Toplam '.$num.' kayıt. Sayfa '.$cur.'/'.$max_pages." &nbsp;";*/
    if(($start-$per_page) >= 0) {
        $next = ($start-$per_page);
        $return.='<li><a href="'.$urlformat.'&sayfanum='.($next>0?("").($next/$per_page):"").'"> <span class="fa fa-angle-left"></span> </a></li> ';
    }
    $eitherside = ($showeachside * $per_page);
    if($start+1 > $eitherside) $return.=' .... ';
    $pg=1;
    for($y=0;$y<$num;$y+=$per_page) {
        $class=($y==$start)?"active":"";
        if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside))) {
            $return.='<li><a class="'.$class.'" href="'.$urlformat.'&sayfanum='.($y>=0?("").($y/$per_page):"").'">'.$pg.'</a></li> ';
        }
        $pg++;
    }
    if(($start+$eitherside)<$num) $return.=' ... ';
    if($start+$per_page<$num) {
        $return.='<li><a href="'.$urlformat.'&sayfanum='.(max(0,$start+$per_page)/$per_page).'"> <span class="fa fa-angle-right"></span> </a></li> ';
    }
    $return.='</ul>';
    return $return;
}