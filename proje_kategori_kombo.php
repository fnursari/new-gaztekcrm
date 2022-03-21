<?php

$sql="SELECT * FROM proje_kategori ORDER BY sira";

$nav_rows = $db->get_results($sql,ARRAY_A);  

$tree = "";					

$depth = 1;					

$top_level_on = 1;			

$exclude = array();			

array_push($exclude, 0);	



if(!isset($categoryrequired)) ;

else $cls="";





echo '<select name="ana_id" id="ana_id" required class="form-control '.$cls.'">';

echo '<option value="">Kategori Seçiniz</option>';

if($ana_id=="0") $slc="selected";

else $slc="";

if(!isset($anakategorioptiongoster)) echo '<option value="0" '.$slc.'>Ana Kategori</option>';

if($db->num_rows > 0)

{

foreach ($nav_rows as $nav_row)  

{

	$goOn = 1;			

	for($x = 0; $x < count($exclude); $x++ )		

	{

		if ( $exclude[$x] == $nav_row['kategori_id'] )

		{

			$goOn = 0;

			break;				

		}

	}

	if ( $goOn == 1 )

	{

		$selected = $ana_id==$nav_row['kategori_id'] ? 'selected="selected"' : '';

		$tree .="<option  $selected value=$nav_row[kategori_id]>$nav_row[kategori_ad_tr]</option>";			

		array_push($exclude, $nav_row['kategori_id']);

		if ( $nav_row['kategori_id'] < 6 )

		{ $top_level_on = $nav_row['kategori_id']; }

		

		$tree .= build_child($nav_row['kategori_id'],$ana_id);

	}

}

}

function build_child($oldID,$ana_id)			

{

	global $exclude, $depth,$db;			

	$sql="SELECT * FROM proje_kategori WHERE ana_id=" . $oldID;

	$childs = $db->get_results($sql,ARRAY_A);  

	if($db->num_rows > 0)

	{

	foreach ($childs as $child)  

	{

		if ( $child['kategori_id'] != $child['ana_id'] )

		{

			

			if($depth==1) $clr="#E5E5E5";

			if($depth==2) $clr="#FDF2D9";

			$selected = $ana_id==$child['kategori_id'] ? 'selected="selected"' : '';

			$tempTree .= "<option  $selected value=$child[kategori_id]>";

			for ( $c=0;$c<$depth;$c++ )			

			{ $tempTree .= "___| "; }

			$tempTree .=$child[kategori_ad_tr];

			$tempTree.="</option>";

			$depth++;		

			$tempTree .= build_child($child['kategori_id'],$ana_id);		

			$depth--;		

			array_push($exclude, $child['kategori_id']);			

		}

	}

	}

	return $tempTree;		

}

echo $tree;

echo "</select>";

?>