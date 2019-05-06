<?php

function image_upload($lokasi, $nama, $tipe, $ukuran, $dir_ori, $dir_small){

	$boolean = true;
	$nama_foto_baru = date("Ymd_His")."-".rand(1000,9999).preg_replace("/\s+/","_",$nama);
	$direktori_simpan = $dir_ori.$nama_foto_baru;

	$format_foto = array("image/jpg","image/jpeg","image/png");
	if(!in_array($tipe,$format_foto) OR $ukuran > 20000000){
		$boolean = false;
		exit();
	}

	move_uploaded_file($lokasi,$direktori_simpan);
	if($tipe == "image/jpeg" || $tipe == "image/jpg"){
		$im_src = imagecreatefromjpeg($direktori_simpan);
	}
	else if ($tipe == "image/png"){
		$im_src = imagecreatefrompng($direktori_simpan);
	}

	$src_width = imageSX($im_src);
    $src_height = imageSY($im_src);

	$dst_width = 110;
	$dst_height = ($dst_width/$src_width)*$src_height;

	$im = imagecreatetruecolor($dst_width,$dst_height);
	imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

	if($tipe == "image/jpeg" || $tipe == "image/jpg"){\
		imagejpeg($im, $dir_small . "small_" . $nama_foto_baru);
	}
	else if ($tipe == "image/png"){
		imagepng($im,  $dir_small . "small_" . $nama_foto_baru);
	}

	if($boolean == true){
		return $nama_foto_baru;
	} else {
		return 0;
	}
}


function file_uploads($lokasi, $nama, $tipe, $ukuran, $dir_ori) {
	$boolean = true;
	$nama_foto_baru = date("Ymd_His")."-".rand(1000,9999).preg_replace("/\s+/","_",$nama);
	$direktori_simpan = $dir_ori.$nama_foto_baru;

	$format_foto = array("pdf","xlsx","docx","doc","jpeg","jpg","png","PNG","JPEG","JPG","PDF","XLSX","DOCX","DOC");
	$ext = pathinfo($nama, PATHINFO_EXTENSION);
	if(!in_array($ext,$format_foto) OR $ukuran > 20000000){
		$boolean = false;
		// exit();
	}

	if($boolean == true){
		move_uploaded_file($lokasi,$direktori_simpan);
		return $nama_foto_baru;
	} else {
		return "-";
	}

}


function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
} 
 ?>
