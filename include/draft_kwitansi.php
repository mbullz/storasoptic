<?php
session_start();
include('config_db.php');
include('function.php');
include('config.php');

$keluarbarang_id = $_GET['keluarbarang_id'] ?? 0;
$aruskas_id = $_GET['aruskas_id'] ?? 0;

$rs = $mysqli->query("SELECT 
    a.*, b.kontak AS customer_name, c.kontak AS karyawan_name 
    FROM keluarbarang a 
    JOIN kontak b ON a.client = b.user_id 
    JOIN kontak c ON a.updated_by = c.user_id 
    WHERE keluarbarang_id = $keluarbarang_id ");

if ($data = $rs->fetch_assoc()) {
    $ref = $data['referensi'];
    $tgl = $data['tgl'];
    $c = $data['client'];
    $karyawan = $data['updated_by'];
    $tipe_pembayaran = $data['tipe_pembayaran'];
}
else {
    return;
}

// get total payment
if ($aruskas_id == 0) {
    $rs = $mysqli->query("SELECT * FROM aruskas WHERE transaction_id = $keluarbarang_id AND tipe = 'piutang' ORDER BY tgl DESC, id DESC LIMIT 0,1");
}
else {
    $rs = $mysqli->query("SELECT * FROM aruskas WHERE id = $aruskas_id");
}

$data = $rs->fetch_assoc();
$dp = $data['jumlah'];
$keterangan = $data['info'];

// get order
/* $query_gorder = "select a.referensi, a.tgl, a.total, a.info, a.sales, b.kontak, b.kperson, b.alamat, b.notlp, b.notlp2, b.hp, c.matauang from keluarbarang a, kontak b, matauang c where a.client = b.kode AND a.matauang = c.kode AND a.referensi='$ref'";
  $gorder       = $mysqli->query($query_gorder);
  $row_gorder   = mysqli_fetch_assoc($gorder); */

// get customer
$query_cust = "SELECT * FROM kontak WHERE user_id = $c";
$cust = $mysqli->query($query_cust);
$row_cust = mysqli_fetch_assoc($cust);
$total_cust = mysqli_num_rows($cust);

// list detail barang
$query_detbrg = "SELECT a.*, c.satuan, d.jenis, 
                        b.kode, b.barang, b.color
                FROM dkeluarbarang a 
                JOIN barang b ON b.product_id = a.product_id 
                JOIN satuan c ON c.satuan_id = a.satuan_id 
                JOIN jenisbarang d ON d.brand_id = b.brand_id 
                WHERE a.keluarbarang_id = $keluarbarang_id 
                ORDER BY a.id";
$detbrg = $mysqli->query($query_detbrg);
$row_detbrg = mysqli_fetch_assoc($detbrg);
$total_detbrg = mysqli_num_rows($detbrg);
// get sales / kary
    $query_gkary = "select kontak from kontak where user_id = $karyawan";
    $gkary       = $mysqli->query($query_gkary);
    $row_gkary   = mysqli_fetch_assoc($gkary);
?>
<style type="text/css" media="all">
    body {
        margin:1px;
        padding:0;
        font-family:tahoma;
        color:#000;
    }
    .divInvoice {
        /*border:solid 1px #030303;*/

    }
    .divInvoice tr td {
        font-size:10px;
    }
    .garisbawah {
        border-bottom:solid 1px #000;	
    }
    #divOrder {
        border:solid 1px #999;	
    }
    #divOrder tr th {
        font-size:11px;
        font-weight:bold;
        background:#CCC;
    }
</style>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="divInvoice">
        <tr>
            <td align="left" colspan="5">
                <h2><?=$GLOBALS['company_name']?></h2>
                <p>
                   	<?=$GLOBALS['company_address']?>
                </p>
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="divInvoice">
        <tr>
            <td align="center">
            	<font size="+3"><strong><u>Kwitansi</u></strong></font>
            </td>
        </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="5" cellpadding="10" style="font-family:'Helvetica';font-size:16px">
        <tr>
            <td align="left" width="25%">
               	<strong>Sudah terima dari</strong>
            </td>
            
            <td align="center" width="10%">
            	<strong>:</strong>
            </td>
            
            <td align="left" style="border-bottom:solid 1px #000000">
            	<em><?=$row_cust['kontak']?></em>
            </td>
        </tr>
        
        <tr>
            <td align="left">
               	<strong>Uang sebesar</strong>
            </td>
            
            <td align="center">
            	<strong>:</strong>
            </td>
            
            <td align="left" style="background-color:#CCC">
            	<em><?=terBilang($dp)?> Rupiah</em>
            </td>
        </tr>
        
        <tr>
            <td align="left">
               	<strong>Untuk pembayaran</strong>
            </td>
            
            <td align="center">
            	<strong>:</strong>
            </td>
            
            <td align="left" style="border-bottom:solid 1px #000000">
            	<em><?=$ref?></em>
            </td>
        </tr>
        
        <tr>
            <td align="left">
               	<strong>Keterangan</strong>
            </td>
            
            <td align="center">
            	<strong>:</strong>
            </td>
            
            <td align="left" style="border-bottom:solid 1px #000000">
            	<em><?=$keterangan?></em>
            </td>
        </tr>
    </table>
    
    <div style="width:100%;text-align:right;margin-top:10px;margin-bottom:10px">
    	<strong>Jakarta, <?=$tgl?></strong>&nbsp;&nbsp;&nbsp;
    </div>
    
    <table border="0" cellspacing="5" cellpadding="10" style="font-family:'Helvetica';font-size:16px;border-bottom:solid 1px #000000;border-top:solid 1px #000000;margin-left:15px">
        <tr>
            <td align="left">
               	<strong>Jumlah Rp.</strong>
            </td>
            
            <td align="left" style="background-color:#CCC;">
            	<em><?=number_format($dp,0,",",".")?></em>
            </td>
        </tr>
    </table>
</body>