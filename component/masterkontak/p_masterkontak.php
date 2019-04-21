<?php
	include('../../include/config_db.php');
	//Define variable
    $stat = '';
	$klas = $_POST['klas'];
	$url = "index-c-masterkontak-k-$klas-q-.pos";
	$p   = $_GET['p'];
	$id  = $_POST['id'] ?? 0;
	$kod = intval($_POST['kode']);
	$jen = $_POST['jenis'];
    $gen = intval($_POST['gender']);
    $kon = $_POST['kontak'] ?? '';
	$kon = $mysqli->real_escape_string($kon);
	$pass = md5('123456');
	$ala = $_POST['alamat'] ?? '';
	$ala = $mysqli->real_escape_string($ala);
	$kpe = '';
	$pbb = '';
	$jab = '';
	$tlp = $_POST['notlp'] ?? '';
	$tlp = $mysqli->real_escape_string($tlp);
	$tlp2 = $_POST['notlp2'] ?? '';
	$tlp2= $mysqli->real_escape_string($tlp2);
	$hp = $_POST['hp'] ?? '';
	$hp  = $mysqli->real_escape_string($hp);
	$fax = '';
	$ema = $_POST['email'] ?? '';
	$ema = $mysqli->real_escape_string($ema);
	$inf = $_POST['info'] ?? '';
	$inf = $mysqli->real_escape_string($inf);
	$sta = $_POST['status'];
	$mul = $_POST['mulai'];
	//------
	$data = $_POST['data'];
	$jdata = count($data);
	//Validasi
	if($p <>'mdelete' AND $p <>'delete') {
		if (trim($jen) == '') {
			$error[] = '- Jenis Kontak harus diisi';
		}
		if (trim($kon) == '') {
			$error[] = '- Nama '.ucfirst($_GET['klas']).' harus diisi';
		}
		if ($klas != 'customer' && trim($ala) == '')
		{
			$error[] = '- Alamat harus diisi';
		}
		if ($klas == 'customer' && trim($tlp) == '')
		{
			$error[] = '- Telephone harus diisi';
		}
	}else if($p =='mdelete'){
		if($jdata <= 0) {
			$error[] ="- Proses gagal, Pilih min 1 data yang ingin dihapus !!!";	
		}
	}
	// End Validasi
	if (isset($error)) {
//		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b><br />".implode("<br />", $error);
        $stat = 'Kesalahan:\n' . implode('\n', $error);
	} else {
		switch($p) {
			case("edit"):
				$query_exe = "UPDATE kontak SET 
						kontak = '$kon', 
						gender = '$gen', 
						jenis = '$jen', 
						alamat = '$ala', 
						kperson = '$kpe', 
						pinbb = '$pbb', 
						jabatan = '$jab', 
						notlp = '$tlp', 
						notlp2 = '$tlp2', 
						hp = '$hp', 
						fax = '$fax', 
						email = '$ema', 
						mulai = '$mul', 
						aktif = '$sta', 
						info = '$inf' 
					WHERE user_id = $kod";

				$exe = $mysqli->query($query_exe);
				
			if($exe) {
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
				}else{
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
                    $stat = 'Data gagal disimpan, coba lagi !!!';
				}
			break;
			case("delete"):
				$query_exe = "DELETE FROM kontak WHERE user_id = $id";
				$exe = $mysqli->query($query_exe);

				if ($exe) {
                	$stat = 'Delete data berhasil';
				}
				else {
                    $stat = 'Delete data gagal';
				}
			break;
			case 'add':
				if ($klas == "karyawan")
				{
					$query_exe = "INSERT INTO kontak(pass, gender, akses, jenis, kontak, alamat, kperson, pinbb, mulai, aktif, jabatan, notlp, notlp2, hp, fax, email, info) values ('$pass', '$gen','','$jen','$kon','$ala','$kpe','$pbb','$mul','$sta','$jab','$tlp','$tlp2','$hp','$fax','$ema','$inf')";
				}
				else
				{
					$query_exe = "insert into kontak(pass,gender,akses,jenis,kontak,alamat,kperson,pinbb,mulai,aktif,jabatan,notlp,notlp2,hp,fax,email,info) values ('', '$gen','','$jen','$kon','$ala','$kpe','$pbb','$mul','$sta','$jab','$tlp','$tlp2','$hp','$fax','$ema','$inf')";
				}
				$exe = $mysqli->query($query_exe);

				if ($exe) {
                    $stat = "Tambah data berhasil";
				}
				else{
                    $stat = 'Tambah data gagal';
				}
			break;
		}
	}
?>
<script type="text/javascript">
	alert('<?php echo $stat; ?>');
   	location.href = '<?=$base_url?><?=$url?>';
</script>