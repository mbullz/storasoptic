<?php
//--
include('../include/config_db.php');
$a_dep = $_GET['departemen'];
$a_jab = $_GET['jabatan'];
$a_q   = $_GET['q'];
$a_bln = ceil($_GET['bulan']);
$a_thn = $_GET['tahun'];
if($a_bln == 1) {
	$a_bln = 12;	
	$a_thn = $a_thn - 1;
}else{
	$a_bln = $a_bln - 1;	
}
if($a_bln < 10) {
	$a_bln = "0".$a_bln;	
}
$p_bln   = $a_thn."-".$a_bln;
$p_bln_2 = $_GET['tahun']."-".$_GET['bulan'];
//---
$per_mulai = $p_bln."-26";
$per_sampai= $p_bln_2."-25";
//echo $per_mulai." s/d ".$per_sampai;
//---
$where = "";
if($a_dep <>'all' OR $a_jab <>'all' OR $a_q <>'') {
	if($a_dep <>'all') {
		$where .= " AND departemen='".$a_dep."'";	
	}
	if($a_jab <>'all') {
		$where .= " AND jabatn='".$a_jab."'";	
	}
	if($a_q <>'') {
		$where .= " AND (a.nik LIKE '%".$a_q."%' OR a.nama LIKE '%".$a_q."%' OR a.posisi LIKE '%".$a_q."')";
	}
}
// gen karyawan
$query_browse = "select distinct a.nik, a.nama from karyawan a, setkomponengaji b where a.nik=b.nik AND a.aktif='1'".$where." order by a.nik";
$browse       = $mysqli->query($query_browse);
$row_browse   = mysqli_fetch_assoc($browse);
$total_browse = mysqli_num_rows($browse);
?>
<?php if($total_browse > 0) { ?>
<table width="100%" border="0" cellspacing="4" cellpadding="2">
  <tr>
  <?php $ki = 0; $i = 1; do { ?>
  <?php 
  // get komponen gaji
  $query_komgaji = "select b.kode, b.komponen, b.tunjpot, a.nilai, a.ref_komponen, a.formula, a.absensi, a.tugas, a.lembur, a.klaim, a.pinjaman from setkomponengaji a, komponengaji b where a.nik='$row_browse[nik]' AND a.komponengaji = b.kode order by tunjpot, b.kode";
  $komgaji       = $mysqli->query($query_komgaji);
  $row_komgaji   = mysqli_fetch_assoc($komgaji);
  $total_komgaji = mysqli_num_rows($komgaji);
  ?>
    <td width="33%" style="border:solid 1px #b9dbe6;" valign="top">
    <label><input name="nik[]" type="checkbox" id="<?php echo $row_browse['nik'];?>" value="<?php echo $row_browse['nik'];?>" checked></label>
	<?php echo $row_browse['nik'];?> - <?php echo $row_browse['nama'];?>
    <!-- list komponen gaji!-->
    <?php if($total_komgaji > 0) { ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <?php $ttunj = 0; $tpot =0; do { ?>
    <?php
		if($row_komgaji['ref_komponen']<>'') {
			// get ref komponen
			$query_gref = "select a.formula, a.nilai, b.kode, b.komponen from setkomponengaji a, komponengaji b 
						   where a.komponengaji='$row_komgaji[ref_komponen]' AND a.nik='$row_browse[nik]'";
			$gref       = $mysqli->query($query_gref);
			$row_gref   = mysqli_fetch_assoc($gref);
			if($row_komgaji['formula']==1) {
				$nilai_ = $row_komgaji['nilai'];	
			}else{
				$nilai_ = ($row_komgaji['nilai'] * $row_gref['nilai']) / 100;
			}
		}else{
			if($row_komgaji['absensi']=='1') {
				// get absen
				$query_gabsn = "select id from absensi where nik='$row_browse[nik]' AND tgl >='$per_mulai' AND tgl <='$per_sampai'
								AND sinfo='hadir'";
				$gabsn       = $mysqli->query($query_gabsn);
				$total_gabsn = mysqli_num_rows($gabsn);
				// ---
				if($row_komgaji['formula']=='1') {
					$nilai_ = $total_gabsn * $row_komgaji['nilai'];	
				}else{
					$nilai_ = "0";
				}
			}else{
				if($row_komgaji['tugas']=='1' OR $row_komgaji['lembur']=='1' OR $row_komgaji['klaim']=='1' OR $row_komgaji['pinjaman']=='1') {
					$nilai_ = $row_komgaji['nilai'];
					if($row_komgaji['tugas']=='1') {
						// get tugas 
						$query_stugas = "select sum(kompensasi) as t_ktugas from tugas where nik='$row_browse[nik]' 
										 AND tgl >='$per_mulai' AND tgl <='$per_sampai'";
						$stugas       = $mysqli->query($query_stugas);
						$row_stugas   = mysqli_fetch_assoc($stugas);
						if($row_stugas['t_ktugas'] > 0) {
							$nilai_ += $row_stugas['t_ktugas'];
						}
					}
					if($row_komgaji['lembur']=='1') {
						// get lembur
						$query_slembur = "select sum(nominal) as t_klembur from lembur where nik='$row_browse[nik]' AND tgl >='$per_mulai'
										  AND tgl <='$per_sampai' AND status ='1'";
						$slembur       = $mysqli->query($query_slembur);
						$row_slembur   = mysqli_fetch_assoc($slembur);
						if($row_slembur['t_klembur'] > 0) {
							$nilai_ += $row_slembur['t_klembur'];
						}
					}
					if($row_komgaji['klaim']=='1') {
						// get klaim
						$query_sklaim = "select sum(bayar) as t_kklaim from kmedis where nik='$row_browse[nik]' AND tgl >='$per_mulai'
										 AND tgl <='$per_sampai'";
						$sklaim       = $mysqli->query($query_sklaim);
						$row_sklaim   = mysqli_fetch_assoc($sklaim);
						if($row_sklaim['t_kklaim'] > 0) {
							$nilai_ += $row_sklaim['t_kklaim'];
						}
					}
					if($row_komgaji['pinjaman']=='1') {
						// get klaim
						$query_spinjam = "select sum(cicilan) as totalcicil from pinjaman where awalcicil <='$p_bln_2' AND akhircicil >='$p_bln_2' AND nik='$row_browse[nik]'";
						$spinjam       = $mysqli->query($query_spinjam);
						$row_spinjam   = mysqli_fetch_assoc($spinjam);
						if($row_spinjam['totalcicil'] > 0) {
							$nilai_ += $row_spinjam['totalcicil'];
						}
					}
				}else{
					$nilai_ = $row_komgaji['nilai'];
				}
			}
		}
		if($row_komgaji['tunjpot']=='tunjangan') {
			$ttunj += $nilai_;	
		}else{
			$tpot += $nilai_;	
		}
	?>
      <tr>
        <td align="left" valign="top"><strong><?php echo ucfirst($row_komgaji['tunjpot']);?></strong></td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td width="48%" align="left" valign="top">- <?php echo $row_komgaji['komponen'];?></td>
        <td valign="top"><input type="hidden" name="komponen[]" id="komponen[]" value="<?php echo $row_komgaji['kode'];?>">
          <label>
            <input name="nilai[]" type="text" id="nilai[]" value="<?php echo round($nilai_);?>" size="7" maxlength="10">
          </label> <?php if($row_komgaji['formula']==2) { echo "<small>".$row_komgaji['nilai']." % </span>"; } if($row_komgaji['ref_komponen']<>'') { echo " ".$row_gref['komponen']; } if($row_komgaji['absensi']=='1') { echo "<small>".$total_gabsn." * ".$row_komgaji['nilai']."</span>"; } ?>
          <input name="tunjpot[]" type="hidden" id="tunjpot[]" value="<?php echo $row_komgaji['tunjpot'];?>"></td>
      </tr>
    <?php $ki++; }while($row_komgaji = mysqli_fetch_assoc($komgaji)); ?>
    </table>
    <br />
    <strong>Rekapitulasi Gaji</strong> :<br /><strong>Tunjangan</strong> - <?php echo number_format($ttunj,2,',','.');?>
    <input name="tunjangan[]" type="hidden" id="tunjangan[]" value="<?php echo $ttunj; ?>">
    <br>
    <strong>Potongan</strong>&nbsp;&nbsp; - <?php echo number_format($tpot,2,',','.');?>
    <input name="potongan[]" type="hidden" id="potongan[]" value="<?php echo $tpot; ?>">
    <br>
    <strong>Gaji</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <?php echo number_format($ttunj-$tpot,2,',','.');?>
    <input name="gaji[]" type="hidden" id="gaji[]" value="<?php echo $ttunj-$tpot;?>"><?php $ttunj = 0; $tpot = 0; } ?>
    <input name="jumkom[]" type="hidden" id="jumkom[]" value="<?php echo $ki;?>"></td>
  <?php if($i % 3 == 0) { ?></tr><tr><?php } $i++; ?>
  <?php }while($row_browse = mysqli_fetch_assoc($browse)); ?>
  </tr>
</table>
<?php }else{ ?> Karyawan tidak ada!!!<?php } ?>
