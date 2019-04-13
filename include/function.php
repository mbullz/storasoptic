<?php
function getBody($a,$b,$c,$d) {
if(isset($c)) {
	if(isset($a) AND $a<>'') {		
		if(isset($b) AND $b<>'') {
			$cfile = $b."_".$a;
			if(strstr($d,$cfile) OR $a =='bantuan') {
				if(file_exists("component/".$a."/task/".$b."_".$a.".php")) {
					include("component/".$a."/task/".$b."_".$a.".php");
				}else{
					include('include/notfound.php');
				}
			}else{
				include('include/denied.php');	
			}
		}else{
			$cfile = $a;
			if(strstr($d,$cfile) OR $a == 'copyright') {
				if(file_exists("component/".$a."/".$a.".php")) { 
					include("component/".$a."/".$a.".php");
				}else{
					include('include/notfound.php');
				}
			}else{
				include('include/denied.php');
			}
		}
	}else{
		include('include/the_content.php');
	}
}else{
	if(file_exists("include/login.php")) { 
		include('include/login.php');
	}else{
		include('include/notfound.php');
	}
}
}

function genDate($date) {
	$exp = explode("-",$date);
	$tgl = $exp[2];
	$bulan = $exp[1];
	$tahun = $exp[0];
	//Gen Month
	switch($bulan) {
		case("01"):
		$bulan = "Jan";
		break;
		case("02"):
		$bulan = "Feb";
		break;
		case("03"):
		$bulan = "Mar";
		break;
		case("04"):
		$bulan = "Apr";
		break;
		case("05"):
		$bulan = "May";
		break;
		case("06"):
		$bulan = "Jun";
		break;
		case("07"):
		$bulan = "Jul";
		break;
		case("08"):
		$bulan = "Aug";
		break;
		case("09"):
		$bulan = "Sep";
		break;
		case("10"):
		$bulan = "Okt";
		break;
		case("11"):
		$bulan = "Nov";
		break;
		default:
		$bulan = "Des";
		break;
	}
	echo $tgl." ".$bulan." ".$tahun;
}

function genPeriod($date) {
	$exp = explode("-",$date);
	$tgl = $exp[2] ?? '';
	$bulan = $exp[1];
	$tahun = $exp[0];
	//Gen Month
	switch($bulan) {
		case("01"):
		$bulan = "Jan";
		break;
		case("02"):
		$bulan = "Feb";
		break;
		case("03"):
		$bulan = "Mar";
		break;
		case("04"):
		$bulan = "Apr";
		break;
		case("05"):
		$bulan = "May";
		break;
		case("06"):
		$bulan = "Jun";
		break;
		case("07"):
		$bulan = "Jul";
		break;
		case("08"):
		$bulan = "Aug";
		break;
		case("09"):
		$bulan = "Sep";
		break;
		case("10"):
		$bulan = "Okt";
		break;
		case("11"):
		$bulan = "Nov";
		break;
		default:
		$bulan = "Des";
		break;
	}
	echo $bulan." ".$tahun;
}

function terBilang($x) {
$x = abs($x);
$angka = array("", "Satu", "Dua", "Tiga", "Empat", "Lima","Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas", "Dua Belas", "Tiga Belas");
$temp = "";
    if ($x <14) {
        $temp = " ". $angka[$x];
    }else if ($x <20) {
        $temp = terBilang($x - 10). " Belas";
    }else if ($x <100) {
        $temp = terBilang($x/10)." Puluh". terBilang($x % 10);
    }else if ($x <200) {
        $temp = " Seratus" . terBilang($x - 100);
    }else if ($x <1000) {
        $temp = terBilang($x/100) . " Ratus" . terBilang($x % 100);
    }else if ($x <2000) {
        $temp = " Seribu" . terBilang($x - 1000);
    }else if ($x <1000000) {
        $temp = terBilang($x/1000) . " Ribu" . terBilang($x % 1000);
    }else if ($x <1000000000) {
        $temp = terBilang($x/1000000) . " Juta" . terBilang($x % 1000000);
    }else if ($x <1000000000000) {
        $temp = terBilang($x/1000000000) . " Miliyar" . terBilang(fmod($x,1000000000));
    }else if ($x <1000000000000000) {
        $temp = terBilang($x/1000000000000) . " Trilyun" . terBilang(fmod($x,1000000000000));
    }      
        /*$rep_1 = str_replace("Twoty","Twenty",$temp);
		$rep_2 = str_replace("Threety","Thirty",$rep_1);
		$temp = $rep_2;*/
		return $temp;
}

function jumlah_hari($bulan = 0, $tahun = '')
{
    if ($bulan < 1 OR $bulan > 12)
    {
        return 0;
    }
    if ( ! is_numeric($tahun) OR strlen($tahun) != 4)
    {
        $tahun = date('Y');
    }
    if ($bulan == 2)
    {
        if ($tahun % 400 == 0 OR ($tahun % 4 == 0 AND $tahun % 100 != 0))
        {
            return 29;
        }
    }
    $jumlah_hari    = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    return $jumlah_hari[$bulan - 1];
}
//
function encrypt_text($value)
{
   if(!$value) return false;
 
   $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, 'SECURE_STRING_1', $value, MCRYPT_MODE_ECB, 'SECURE_STRING_2');
   return trim(base64_encode($crypttext));
}
 
function decrypt_text($value)
{
   if(!$value) return false;
 
   $crypttext = base64_decode($value);
   $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, 'SECURE_STRING_1', $crypttext, MCRYPT_MODE_ECB, 'SECURE_STRING_2');
   return trim($decrypttext);
}
?>