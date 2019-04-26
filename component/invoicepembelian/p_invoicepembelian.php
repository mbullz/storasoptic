<?php
session_start();
include('../../include/config_db.php');
//Define variable
$stat = '';
$url = "index-c-invoicepembelian.pos";
$p = $_GET['p'];
$inv = $_POST['invoice'] ?? '';
$inv = $mysqli->real_escape_string($inv);
$tgl = $_POST['tgl'] ?? date('Y-m-d');
$tgl = $mysqli->real_escape_string($tgl);
$jte = $_POST['jtempo'] ?? null;
$jte = $mysqli->real_escape_string($jte);
$mat = $_POST['matauang'] ?? 1;
$mat = $mysqli->real_escape_string($mat);
$tot = $_POST['total'] ?? 0;
$tot = intval($tot);
$gud = $_POST['gudang'] ?? 1;
$gud = $mysqli->real_escape_string($gud);
$sup = $_POST['supplier'] ?? 0;
$sup = $mysqli->real_escape_string($sup);
$inf = $_POST['info'] ?? '';
$inf = $mysqli->real_escape_string($inf);
$lun = $_POST['lunas'] ?? 0;
$lun = intval($lun);
$tipe = $_POST['tipePembayaran'] ?? 1;
$tipe = intval($tipe);

if (empty($tipe) || !isset($tipe)) {$tipe = 1;}
$tipe_pembayaran = $tipe == 1 ? "Cash" : "Jatuh Tempo";
//------
$data = $_POST['data'];
$jdata = count($data);
//Validasi
if ($p <> 'mdelete' AND $p <> 'delete') {
    if ($p == 'add') {
        // cek username
        $query_cek = "select referensi from masukbarang where referensi='$inv'";
        $cek = $mysqli->query($query_cek);
        $row_cek = mysqli_fetch_assoc($cek);
        $total_cek = mysqli_num_rows($cek);
        if ($total_cek > 0) {
            $error[] = '- No. PO <b>' . $row_cek[referensi] . '</b> sudah digunakan !!!';
        }
    }
    if (trim($tgl) == '') {
        $error[] = '- Tanggal harus diisi !!!';
    }
    if ($p == 'barangmasuk' OR $p == 'barangreturmasuk') {
        if (trim($gud) == '') {
            $error[] = '- Lokasi Gudang harus diisi !!!';
        }
    }
    if ($p <> 'barangmasuk' AND $p <> 'barangreturmasuk') {
        if (trim($mat) == '') {
            $error[] = '- Mata Uang harus diisi !!!';
        }
        if ($tipe == 2 && trim($jte) == '') {
            $error[] = '- Jatuh Tempo harus diisi !!!';
        }
        if (trim($sup) == '') {
            $error[] = '- Supplier harus diisi !!!';
        }
    }
    if (trim($tot) == 0) {
        $error[] = '- Detail Transaksi harus diisi !!!';
    }
} else if ($p == 'mdelete') {
    if ($jdata <= 0) {
        $error[] = "- Proses gagal, Pilih min 1 data yang ingin dihapus !!!";
    }
}
// End Validasi
if (isset($error)) {
//		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Kesalahan : </b><br />".implode("<br />", $error);
    $stat = 'Kesalahan: ' . implode('\n', $error);
} else {
    switch ($p) {
        case("mdelete"):
            $where = " WHERE ";
            for ($i = 0; $i < $jdata; $i++) {
                $where .=" masukbarang_id = $data[$i] ";
                if ($i < $jdata - 1) {
                    $where .=" OR ";
                }
            }
            $query_exe = "DELETE FROM masukbarang " . $where;
            $exe = $mysqli->query($query_exe);
            if ($exe) {
                // delete dmasukbarang
                $query_delx = " delete from dmasukbarang " . $where;
                $delx = $mysqli->query($query_delx);
                $stat = 'Data telah dihapus ...';
            } else {
                $stat = 'Data gagal dihapus, coba lagi !!!';
            }
            break;
        case("edit"):
            $query_exe = "update masukbarang set tgl='$tgl', jtempo='$jte', total='$tot', info='$inf', matauang='$mat', supplier='$sup', lunas='$lun' where referensi='$inv'";
            $exe = $mysqli->query($query_exe) or die(mysql_error());
            if ($exe) {
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
            } else {
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
                $stat = 'Data gagal disimpan, coba lagi !!!';
            }
            break;
        case("barangmasuk"):
            $brg = $mysqli->real_escape_string($_POST[barang]);
            $query_exe = "insert into terimabarang (tgl,noreferensi,barang,satuan,qty,gudang,info) values ('$tgl','$inv','$brg','$_POST[satuan]','$tot','$gud','$inf')";
            $exe = $mysqli->query($query_exe) or die(mysql_error());
            if ($exe) {
                //update qty in barang
                $query_barang = "update barang set qty=qty+$tot, tgl_masuk_akhir=current_date where kode='$brg'";
                $mysqli->query($query_barang);
                // cek stok
                $query_cstok = "select * from stokbarang where barang='$_POST[barang]' AND satuan='$_POST[satuan]' AND gudang='$gud'";
                $cstok = $mysqli->query($query_cstok);
                $row_cstok = mysqli_fetch_assoc($cstok);
                $total_cstok = mysqli_num_rows($cstok);
                if ($total_cstok > 0) {
                    $qtynow = $row_cstok[qty] + $tot;
                    $query_upstok = "update stokbarang set qty='$qtynow' where id='$row_cstok[id]'";
                } else {
                    $query_upstok = "insert into stokbarang (gudang,barang,satuan,qty) values ('$gud','$_POST[barang]','$_POST[satuan]','$tot')";
                }
                $upstok = $mysqli->query($query_upstok);
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
            } else {
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">ata gagal disimpan, coba lagi !!!</b></center>";
                $stat = 'Data gagal disimpan, coba lagi !!!';
            }
            break;
        case("barangreturmasuk"):
            $brg = $mysqli->real_escape_string($_POST[barang]);
            $query_exe = "insert into terimabarang_r (tgl,noreferensi,barang,satuan,qty,gudang,info) values ('$tgl','$inv','$_POST[barang]','$_POST[satuan]','$tot','$gud','$inf')";
            $exe = $mysqli->query($query_exe) or die(mysql_error());
            if ($exe) {
                //update qty in barang
                $query_barang = "update barang set qty=qty-$tot where kode='$brg'";
                $mysqli->query($query_barang);
                // cek stok
                $query_cstok = "select * from stokbarang where barang='$brg' AND satuan='$_POST[satuan]' AND gudang='$gud'";
                $cstok = $mysqli->query($query_cstok);
                $row_cstok = mysqli_fetch_assoc($cstok);
                $total_cstok = mysqli_num_rows($cstok);
                if ($total_cstok > 0) {
                    $qtynow = $row_cstok[qty] - $tot;
                    $query_upstok = "update stokbarang set qty='$qtynow' where id='$row_cstok[id]'";
                }
                $upstok = $mysqli->query($query_upstok);
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
            } else {
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">ata gagal disimpan, coba lagi !!!</b></center>";
                $stat = 'Data gagal disimpan, coba lagi !!!';
            }
            break;
        default:
            if ($tipe == 1) {
                $query_exe = "insert into masukbarang values ('$inv','$tgl','$jte','$_SESSION[i_sesadmin]','$sup','$mat','$tot','$inf', '1', '$tipe_pembayaran')";
                $exe = $mysqli->query($query_exe);

                $mysqli->query("insert into aruskas(carabayar,tipe,tgl,opr,referensi,jumlah,matauang,info) values('CASH', 'hutang', '$tgl', ".($tipe-1).", '$inv', $tot, 'IDR', '')") or die(mysql_error());
            } else if ($tipe == 2) {
                $query_exe = "insert into masukbarang values ('$inv','$tgl','$jte','$_SESSION[i_sesadmin]','$sup','$mat','$tot','$inf', '0', '$tipe_pembayaran')";
                $exe = $mysqli->query($query_exe);
				
				$mysqli->query("insert into aruskas(carabayar,tipe,tgl,opr,referensi,jumlah,matauang,info) values('CASH', 'hutang', '$tgl', ".($tipe-1).", '$inv', $tot, 'IDR', 'Uang Muka')") or die(mysql_error());
            }
			
			$rs = $mysqli->query("SELECT product_id,satuan_id,qty FROM dmasukbarang WHERE noreferensi LIKE '$inv'");
			while ($data = mysqli_fetch_assoc($rs))
			{
				$brg = $data['product_id'];
				$satuan = $data['satuan_id'];
				$qty = $data['qty'];
				
				$mysqli->query("INSERT INTO terimabarang (tgl,noreferensi,barang,satuan,qty,gudang,info) VALUES ('$tgl','$inv',$brg,$satuan,'$qty','GDG_A','Sukses')");
				
				//update qty in barang
                $mysqli->query("UPDATE BARANG set qty=qty+$qty, tgl_masuk_akhir=current_date where product_id=$brg");
				
				// cek stok
                $query_cstok = "select * from stokbarang where product_id=$brg AND satuan_id=$satuan AND gudang='GDG_A'";
                $cstok = $mysqli->query($query_cstok);
                $row_cstok = mysqli_fetch_assoc($cstok);
                $total_cstok = mysqli_num_rows($cstok);
                if ($total_cstok > 0)
				{
                    $qtynow = $row_cstok[qty] + $qty;
                    $query_upstok = "update stokbarang set qty='$qtynow' where id='$row_cstok[id]'";
                }
				else
				{
                    $query_upstok = "insert into stokbarang (gudang,barang,satuan,qty) values ('GDG_A',$brg,$satuan,'$qty')";
                }
                $upstok = $mysqli->query($query_upstok);
			}
            
            //echo $query_exe;
            if ($exe) {
//                $query_exe = "select barang, qty from dmasukbarang where noreferensi='$inv'";
//                $exe = $mysqli->query($query_exe);
//                while ($row = mysqli_fetch_assoc($exe)) {
//                    $query_brg = "update barang set qty=qty+$row[qty] where kode='$row[barang]'";
//                    $mysqli->query($query_brg);
//                }
//					echo "<center><img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Data telah disimpan ...</b></center>";
                $stat = 'Data telah disimpan ...';
            } else {
//					echo "<center><img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Data gagal disimpan, coba lagi !!!</b></center>";
                $stat = 'Data gagal disimpan, coba lagi !!!';
            }
            break;
    }
}

?>
<script type="text/javascript">
    alert('<?php echo $stat; ?>');
    location.href = '<?=$base_url?><?php echo $url; ?>';
</script>