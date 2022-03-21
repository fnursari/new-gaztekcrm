<?php
function getFileExtension($filename) {
	return strtolower(substr($filename, strrpos($filename, '.')));
}

function getFileNameWithoutExtension($filename) {
	return strtolower(substr($filename, 0, strrpos($filename, '.')));
}

function uploadFile($uploaddata) {
	global $cfg,$db;
	$data = array_replace_recursive($cfg["FileUpload"],$uploaddata);
	$filename = $data["file"]["name"];
	if($filename != "") {
		$fileextension=getFileExtension($filename);
		if( in_array($fileextension,$data["allowed_filetypes"])) {
			if($data["preservefilename"]) {
				$uploadfilename = permayap(getFileNameWithoutExtension($filename)).'-'.uniqidReal().$fileextension;
			}
			else {
				$uploadfilename = permayap(strip_tags($data["filename"])).'-'.uniqidReal().$fileextension;
			}
			move_uploaded_file($data['file']['tmp_name'], $data["uploadfolder"].$uploadfilename);
		}
	}
	return $uploadfilename;
}


function uploadImage($uploaddata) {
	global $cfg,$db;
	$data = (array_replace_recursive($cfg["ImageUpload"],$uploaddata));
	$imagename = $data["image"]["name"];
	if($imagename != "") {
		$imageextension=getFileExtension($imagename);
		
		if( in_array($imageextension,$data["allowed_imagetypes"])) {

			if($data["preserveimagename"]) {
				$uploadimagename = permayap(getFileNameWithoutExtension($imagename)).'-'.uniqidReal().$imageextension;
			}
			else {
				$uploadimagename = permayap(strip_tags($data["imagename"])).'-'.uniqidReal().$imageextension;
			}
			if($data["resize"]) {
				include_once $cfg["SiteRoot"]."classes/simpleimage.php"; 
				$image = new SimpleImage();
				$image->load($data['image']['tmp_name']);
				if($data["resizedata"]["type"]=="fit") {
					$image->resizeToFit($data["resizedata"]["width"],$data["resizedata"]["height"]);
				}
				else {
					$image->resizeToWidth($data["resizedata"]["width"]);
				}
				if($data["overlay"]) {
					$image->overlay($data["overlayimg"], 'center', .3, -10, -10);
				}
				$image->save($data["uploadfolder"].$uploadimagename);
			}
			else {
				move_uploaded_file($data['image']['tmp_name'], $data["uploadfolder"].$uploadimagename);    
			}
		}
	}
	return $uploadimagename;
}


function displayImage($imagedata) {
	global $cfg;

	if ( ($imagedata["image"]!="") && file_exists($cfg["SiteRoot"].$imagedata["folder"].'/'.$imagedata["image"]) )  {
		return '<img src="'.$cfg["SiteUrl"].'/'.$imagedata["folder"].'/'.$imagedata["image"].'" class="'.$imagedata["class"].'" alt="'.$imagedata["alt"].'">';
	}
}

function displayFile($filedata) {
	global $cfg,$dil;
	if ( ($filedata["file"]!="") && file_exists($cfg["SiteRoot"].$filedata["folder"].'/'.$filedata["file"]) )  {
		return '<a target="_blank" href="'.$cfg["SiteUrl"].'/'.$filedata["folder"].'/'.$filedata["file"].'" class="'.$filedata["class"].'">'.$filedata["file"].'</a>';
	}
}

function deleteFile($file,$folder) {
	global $cfg,$dil;
	if ( ($file!="") && file_exists($cfg["SiteRoot"].$folder.'/'.$file) )  {
		unlink($cfg["SiteRoot"].$folder.'/'.$file);
	}
}

