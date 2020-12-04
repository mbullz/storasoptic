<?php
session_start();
include('config_db.php');
include('function.php');
include('config.php');

$aruskas_id = $_GET['aruskas_id'] ?? 0;

$query = "SELECT a.*, b.kontak AS customer_name, c.kontak AS karyawan_name, 
            d.jumlah, d.info 
        FROM aruskas d 
        JOIN keluarbarang a ON d.transaction_id = a.keluarbarang_id 
        JOIN kontak b ON a.client = b.user_id 
        JOIN kontak c ON a.updated_by = c.user_id 
        WHERE d.id = $aruskas_id ";

$rs = $mysqli->query($query);

if ($data = $rs->fetch_assoc()) {
    $ref = $data['referensi'];
    $tgl = $data['tgl'];
    $customer_name = $data['customer_name'];
    $karyawan = $data['karyawan_name'];
    $tipe_pembayaran = $data['tipe_pembayaran'];

    $dp = $data['jumlah'];
    $keterangan = $data['info'];
}
else {
    return;
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

<style type="text/css" media="all">
    body {
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

    .button-print {
        margin: 10px;
        text-align: center;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }

</style>

<body class="container">
    <div class="button-print no-print">
        <input type="button" value="Print" onclick="javascript:window.print()" />
    </div>
    
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
    
    <table class="table table-borderless mt-3">
        <tr>
            <td align="left" width="25%">
               	<strong>Telah terima dari</strong>
            </td>
            
            <td align="center" width="10%">
            	<strong>:</strong>
            </td>
            
            <td align="left" style="border-bottom:solid 1px #000000">
            	<em><?=$customer_name?></em>
            </td>
        </tr>
        
        <tr>
            <td align="left">
               	<strong>Uang sejumlah</strong>
            </td>
            
            <td align="center">
            	<strong>:</strong>
            </td>
            
            <td align="left" class="table-secondary border-bottom border-dark">
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
            
            <td align="left" class="table-secondary">
            	<em><?=number_format($dp,0,",",".")?></em>
            </td>
        </tr>
    </table>
</body>