<?php
$besok = date("Y-m-d", time()+86400);
// cek generated absensi
$query_cekabsen = "select id from absensi where tgl='$besok'";
$cekabsen       = $mysqli->query($query_cekabsen);
$total_cekabsen = mysqli_num_rows($cekabsen);
if($total_cekabsen == 0) { 
	// --- get karyawan aktif
	$query_karyawan_aktif = "select nik from karyawan where aktif='1'";
	$karyawan_aktif       = $mysqli->query($query_karyawan_aktif);
	$row_karyawan_aktif   = mysqli_fetch_assoc($karyawan_aktif);
	$total_karyawan_aktif = mysqli_num_rows($karyawan_aktif);
	if($total_karyawan_aktif > 0) {
		$no = 1;
		$query_insert = "insert into absensi (nik,tgl,datang,pulang,sinfo,telat) values ";
		do {
			$query_insert .= "('$row_karyawan_aktif[nik]','$besok','00:00','00:00','alpha','0')";
			if($no < $total_karyawan_aktif) {
				$query_insert .=",";	
			}else{
				$query_insert .=";";	
			}
			$no++;
		}while($row_karyawan_aktif = mysqli_fetch_assoc($karyawan_aktif));
		$insert_absen = $mysqli->query($query_insert);
	}
}
?>