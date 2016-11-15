<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function ambil_ip() {
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED') as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
      foreach (explode(',', $_SERVER[$key]) as $ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
          return $ip;
        }
      }
    }
  }
}
function getURLFriendly($str) {
		$string = preg_replace("/[-]+/", "-", preg_replace("/[^a-z0-9-]/", "",
		strtolower( str_replace(" ", "-", $str) ) ) );
		return $string;
}
function getData($ip){
	if ($ip != "127.0.0.1") {
		$json = file_get_contents('http://ipinfo.io/'.$ip.'/json');
		$links = json_decode($json,true);
		return $links;
	} else {
		return false;
	}
}
function gambarSmall($up_data, $folder,$file_name) {
	$CI =& get_instance();
	/* PATH */
	$source             = "./assets/media/".$folder."/".$file_name.$up_data['file_ext'];
	$destination_thumb	= "./assets/media/".$folder."/small" ;
	// Permission Configuration
	chmod($source, 0777) ;
	/* Resizing Processing */
	// Configuration Of Image Manipulation :: Static
	$CI->load->library('image_lib') ;
	$img['image_library'] = 'GD2';
	$img['create_thumb']  = TRUE;
	$img['maintain_ratio']= TRUE;
	/// Limit Width Resize
	$limit_medium   = 300 ;
	$limit_thumb    = 150;
	// Size Image Limit was using (LIMIT TOP)
	$limit_use  = $up_data['image_width'] > $up_data['image_height'] ? $up_data['image_width'] : $up_data['image_height'] ;
	// Percentase Resize
	if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
		$percent_medium = $limit_medium/$limit_use ;
		$percent_thumb  = $limit_thumb/$limit_use ;
	}
	//// Making THUMBNAIL ///////
	$img['width']  = $limit_use > $limit_thumb ?  $up_data['image_width'] * $percent_thumb : $up_data['image_width'] ;

	$img['height'] = $limit_use > $limit_thumb ?  $up_data['image_height'] * $percent_thumb : $up_data['image_height'] ;
	// Configuration Of Image Manipulation :: Dynamic
	$img['thumb_marker'] = '_S' ;
	$img['quality']      = '100%' ;
	$img['source_image'] = $source ;
	$img['new_image']    = $destination_thumb ;
	// Do Resizing
	$CI->image_lib->initialize($img);
	$CI->image_lib->resize();
	$CI->image_lib->clear() ;
}
function gambarFb($up_data, $folder,$file_name) {
	$CI =& get_instance();
	/* PATH */
	$source             = "./assets/media/".$folder."/".$file_name.$up_data['file_ext'];
	$destination_thumb	= "./assets/media/".$folder."/social" ;
	// Permission Configuration
	chmod($source, 0777) ;
	/* Resizing Processing */
	// Configuration Of Image Manipulation :: Static
	$CI->load->library('image_lib') ;
	$img['image_library'] = 'GD2';
	$img['create_thumb']  = TRUE;
	$img['maintain_ratio']= TRUE;
    $img['width']     = 250;
    $img['height']   = 250;
	// Configuration Of Image Manipulation :: Dynamic
	$img['thumb_marker'] = '_fb' ;
	$img['quality']      = '100%' ;
	$img['source_image'] = $source ;
	$img['new_image']    = $destination_thumb ;
	// Do Resizing
	$CI->image_lib->initialize($img);
	$CI->image_lib->resize();
	$CI->image_lib->clear() ;
}
function gambarTwtr($up_data, $folder,$file_name) {
	$CI =& get_instance();
	/* PATH */
	$source             = "./assets/media/".$folder."/".$file_name.$up_data['file_ext'];
	$destination_thumb	= "./assets/media/".$folder."/social" ;
	// Permission Configuration
	chmod($source, 0777) ;
	/* Resizing Processing */
	// Configuration Of Image Manipulation :: Static
	$CI->load->library('image_lib') ;
	$img['image_library'] = 'GD2';
	$img['create_thumb']  = TRUE;
	$img['maintain_ratio']= TRUE;
    $img['width']     = 280;
    $img['height']   = 150;
	// Configuration Of Image Manipulation :: Dynamic
	$img['thumb_marker'] = '_twtr' ;
	$img['quality']      = '100%' ;
	$img['source_image'] = $source ;
	$img['new_image']    = $destination_thumb ;
	// Do Resizing
	$CI->image_lib->initialize($img);
	$CI->image_lib->resize();
	$CI->image_lib->clear() ;
}
function tgl_panjang($tgl, $tipe) {
	$tgl_pc 		= explode(" ", $tgl);
	$tgl_depan		= $tgl_pc[0];
	$jam_depan		= $tgl_pc[1];

	$tgl_depan_pc	= explode("-", $tgl_depan);
	$tgl			= $tgl_depan_pc[2];
	$bln			= $tgl_depan_pc[1];
	$thn			= $tgl_depan_pc[0];

	if ($tipe == "lm") {
		if ($bln == "01") { $bln_txt = "Januari"; }
		else if ($bln == "02") { $bln_txt = "Februari"; }
		else if ($bln == "03") { $bln_txt = "Maret"; }
		else if ($bln == "04") { $bln_txt = "April"; }
		else if ($bln == "05") { $bln_txt = "Mei"; }
		else if ($bln == "06") { $bln_txt = "Juni"; }
		else if ($bln == "07") { $bln_txt = "Juli"; }
		else if ($bln == "08") { $bln_txt = "Agustus"; }
		else if ($bln == "09") { $bln_txt = "September"; }
		else if ($bln == "10") { $bln_txt = "Oktober"; }
		else if ($bln == "11") { $bln_txt = "November"; }
		else if ($bln == "12") { $bln_txt = "Desember"; }
	} else if ($tipe == "sm") {
		if ($bln == "01") { $bln_txt = "Jan"; }
		else if ($bln == "02") { $bln_txt = "Feb"; }
		else if ($bln == "03") { $bln_txt = "Mar"; }
		else if ($bln == "04") { $bln_txt = "Apr"; }
		else if ($bln == "05") { $bln_txt = "Mei"; }
		else if ($bln == "06") { $bln_txt = "Jun"; }
		else if ($bln == "07") { $bln_txt = "Jul"; }
		else if ($bln == "08") { $bln_txt = "Ags"; }
		else if ($bln == "09") { $bln_txt = "Sep"; }
		else if ($bln == "10") { $bln_txt = "Okt"; }
		else if ($bln == "11") { $bln_txt = "Nov"; }
		else if ($bln == "12") { $bln_txt = "Des"; }
	}
	$baseurl = base_URL();
	return $tgl." ".$bln_txt." ".$thn."<img src='".$baseurl."/aset/ico/clock.png' style='margin-left:10px;margin-right:5px;margin-bottom:5px;'> Pukul ".$jam_depan." ";
}
// use this function above 5.4 > PHP
// Find how much time has elapsed since now()
// from: http://stackoverflow.com/a/18602474/235633
// made by Glavić
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// use this function nether 5.3 < PHP
// Find how much time has elapsed since now()
// from: http://stackoverflow.com/a/18602474/235633
// made by Glavić
function timeElapsedSinceNow( $datetime, $full = false ){
    $now = new DateTime;
    $then = new DateTime( $datetime );
    $diff = (array) $now->diff( $then );

    $diff['w']  = floor( $diff['d'] / 7 );
    $diff['d'] -= $diff['w'] * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    foreach( $string as $k => & $v )
    {
        if ( $diff[$k] )
        {
            $v = $diff[$k] . ' ' . $v .( $diff[$k] > 1 ? 's' : '' );
        }
        else
        {
            unset( $string[$k] );
        }
    }

    if ( ! $full ) $string = array_slice( $string, 0, 1 );
    return $string ? implode( ', ', $string ) . ' ago' : 'just now';
}

function replaceWordChars($text) {
    // smart single quotes and apostrophe
    $text = preg_replace('/’/', "'", $text);
    $text = preg_replace('/”/', "\"", $text);
    $text = preg_replace('/`/', "`", $text);
    return $text;
}

function replaceWordCharsControllerName($text2) {
    // smart single quotes and apostrophe
    $text2 = preg_replace('/\s/', "_", $text2);
    return $text2;
}

function cekLevelUser($id_session){

}
