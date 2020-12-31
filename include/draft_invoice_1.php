<?php
session_start();
include('config_db.php');
include('function.php');
include('config.php');

$keluarbarang_id = $_GET['keluarbarang_id'] ?? 0;

$rs = $mysqli->query("SELECT 
        a.*, 
        b.kontak AS customer_name, b.notlp AS customer_phone_1, b.notlp2 AS customer_phone_2, 
        c.kontak AS karyawan_name, 
    d.kontak AS branch_name, d.alamat AS branch_address, d.notlp AS branch_phone1, d.notlp2 AS branch_phone2 
    FROM keluarbarang a 
    JOIN kontak b ON a.client = b.user_id 
    JOIN kontak c ON a.updated_by = c.user_id 
    JOIN kontak d ON a.branch_id = d.user_id 
    WHERE keluarbarang_id = $keluarbarang_id ");

if ($data = $rs->fetch_assoc()) {
    $ref = $data['referensi'];
    $tgl = $data['tgl'];
    $c = $data['client'];

    $customer_name = $data['customer_name'];
    $customer_phone_1 = $data['customer_phone_1'];
    $customer_phone_2 = $data['customer_phone_2'];

    $karyawan = $data['updated_by'];
    $karyawan_name = $data['karyawan_name'];
    $tipe_pembayaran = $data['tipe_pembayaran'];
    $ppn = $data['ppn'];

    $branch_name = $data['branch_name'];
    $branch_address = $data['branch_address'];
    $branch_phone1 = $data['branch_phone1'];
    $branch_phone2 = $data['branch_phone2'];

    if ($branch_name == 'PRASIDA OPTIK')
        $branch_name = 'PRASIDA OPTIK BY ITC OPTIK';
}
else {
    return;
}

// get total payment
$rs = $mysqli->query("SELECT SUM(jumlah) AS total_payment FROM aruskas WHERE transaction_id = $keluarbarang_id AND tipe = 'piutang'");
$data = $rs->fetch_assoc();
$dp = $data['total_payment'];

// list detail barang
$query_detbrg = "SELECT a.*, c.satuan, d.jenis, 
                        b.kode, b.barang, b.frame, b.color 
                FROM dkeluarbarang a 
                LEFT JOIN barang b ON b.product_id = a.product_id 
                LEFT JOIN satuan c ON c.satuan_id = a.satuan_id 
                LEFT JOIN jenisbarang d ON d.brand_id = b.brand_id 
                WHERE a.keluarbarang_id = $keluarbarang_id 
                ORDER BY a.id";
$detbrg = $mysqli->query($query_detbrg);
$total_detbrg = mysqli_num_rows($detbrg);

$dkeluarbarang_info = '';

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />
<style type="text/css" media="all">
    body {
        color: #000;
    }

    .font-8 {
        font-size: 8px;
    }

    .font-10 {
        font-size: 10px;
    }

    .font-12 {
        font-size: 13px;
    }

    .divInvoice tr td {
        font-size: 13px;
        color: #000;
    }

    .divOrder tr th {
        font-size: 13px;
        color: #000;
        -webkit-print-color-adjust: exact;
    }

    .garisbawah {
        border-bottom:solid 2px #000;	
    }

    .button-print {
        margin: 10px;
        text-align: center;
    }

    .section-to-print {
        display: none;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .section-to-print {
            display: block;
        }

        .table th {
            /*background-color: #eee !important;*/
        }
    }
    
</style>

<body class="container">
    <div class="button-print no-print">
        <input type="button" class="btn btn-primary btn-sm" value="Print" onclick="javascript:window.print()" />
    </div>

    <ul class="nav nav-tabs no-print mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="invoice-besar-tab" data-toggle="tab" href="#invoice-besar" role="tab" aria-controls="invoice-besar" aria-selected="true">Invoice Besar</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="invoice-kecil-tab" data-toggle="tab" href="#invoice-kecil" role="tab" aria-controls="invoice-kecil" aria-selected="false">Invoice Kecil</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="invoice-besar" role="tabpanel" aria-labelledby="invoice-besar-tab">
    

    <table class="divInvoice table table-borderless table-sm">
        <tr>
            <td width="1%" class="text-center align-middle pr-2">
                <img src="../images/itc-optik.png" height="52px" />
            </td>

            <td>
                <h6 class="font-weight-bold"><?=$branch_name?></h6>
                <p class="m-0 p-0">
                    <?=$branch_address?>
                </p>
                <p class="m-0 p-0 mt-1">
                    PHONE: <?=$branch_phone1?>
                </p>
            </td>
            
            <td class="text-center align-bottom border-bottom border-dark" width="30%">
            	<p class="font-weight-bold m-0 p-0">No. Invoice / Tanggal</p>
                <p class="m-0 p-0 mt-1 mb-1">
                    <?=$ref?> / <?=$tgl?>
                </p>
            </td>
        </tr>
    </table>

    <table class="divInvoice table table-borderless table-sm mt-4">
        <tbody>
            <tr>
                <td width="1%" class="font-weight-bold text-nowrap pr-2">Customer</td>
                <td width="1%" class="font-weight-bold pr-2">:</td>
                <td>
                    <?=$customer_name?>
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold text-nowrap pr-2">No. Tlp / Handphone</td>
                <td class="font-weight-bold pr-2">:</td>
                <td>
                    <?php echo $customer_phone_1 . ' / ' . $customer_phone_2; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="divOrder divInvoice table table-bordered mt-4 mb-4">
        <tr class="table-secondary">
            <th width="5%" class="text-center">No</th>
            <th class="text-center">Deskripsi Barang</th>
            <th width="10%" class="text-center">Qty</th>
            <th width="12.5%" class="text-center">Harga</th>
            <th width="12.5%" class="text-center">Diskon</th>
            <th width="20%" class="text-center">Subtotal</th>
        </tr>
        <?php 
            $gTot = 0;
            $no = 1;
            $i = 0;
            while ($row_detbrg = mysqli_fetch_assoc($detbrg))
            {
                $gTot += $row_detbrg['subtotal'];

                if ($row_detbrg['info'] != '') $dkeluarbarang_info = $row_detbrg['info'];

                if ($row_detbrg['tipe'] != '3')
                {
                    if ($i == 0) {
                        $ik_barang = $row_detbrg['jenis'] . ' - ' . $row_detbrg['barang'];
                    }

                    ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $no++; ?>
                            </td>
                            <td>
                                <?php
                                    if ($row_detbrg['kode'] != '') echo $row_detbrg['kode'] . " # ";
                                ?>
                                <?=$row_detbrg['jenis']?> # <?=$row_detbrg['barang']?> # <?=$row_detbrg['frame']?>
                            </td>
                            <td class="text-center">
                                <?php echo $row_detbrg['qty']; ?> PCS
                            </td>
                            <td class="text-right">
                                <div class="no-print">
                                    <?php //echo number_format($row_detbrg['harga'], 0, ',', '.'); ?>
                                    1
                                </div>
                                <div class="section-to-print">1</div>
                            </td>
                            <td class="text-right">
                                <?php if ($row_detbrg['tdiskon'] == 0) {
                                        echo number_format($row_detbrg['diskon'], 0, ',', '.');
                                    } else {
                                        echo number_format($row_detbrg['diskon'], 2, ',', '.') . " %";
                                    } 
                                ?>
                            </td>
                            <td class="text-right">
                                <?php
                                    $price = $row_detbrg['harga'] * $row_detbrg['qty'];

                                    if ($row_detbrg['tdiskon'] == 0) {
                                        $price -= $row_detbrg['diskon'];
                                    }
                                    else {
                                        $price -= (($row_detbrg['diskon']/100) * $price);
                                    } 
                                ?>
                                <div class="no-print">
                                    <?php //echo number_format($price, 0, ',', '.'); ?>1 Rupiah
                                </div>
                                <div class="section-to-print">1 Rupiah</div>
                            </td>
                        </tr>
                    <?php
                }
                
                if ($row_detbrg['tipe'] == '3' || $row_detbrg['tipe'] == '5')
                {
                    if ($i == 0) {
                        $ik_rsph = $row_detbrg['rSph'];
                        $ik_rcyl = $row_detbrg['rCyl'];
                        $ik_raxis = $row_detbrg['rAxis'] / 100;
                        $ik_radd = $row_detbrg['rAdd'];
                        $ik_rpd = $row_detbrg['rPd'];

                        $ik_lsph = $row_detbrg['lSph'];
                        $ik_lcyl = $row_detbrg['lCyl'];
                        $ik_laxis = $row_detbrg['lAxis'] / 100;
                        $ik_ladd = $row_detbrg['lAdd'];
                        $ik_lpd = $row_detbrg['lPd'];
                    }

                    ?>
                        <tr>
                            <td class="text-center">
                                <?=$no++?>
                            </td>
                            <td>
                                <?php
                                    if ($row_detbrg['special_order'] == '1') {
                                        echo 'LENSA SO';

                                        if ($i == 0) $ik_lensa = 'LENSA SO';
                                    }
                                    else 
                                    {
                                        $rs2 = $mysqli->query("SELECT * FROM barang a JOIN jenisbarang b ON a.brand_id = b.brand_id WHERE product_id = $row_detbrg[lensa]");
                                        $data2 = mysqli_fetch_assoc($rs2);
                                        echo 'LENSA : ' . $data2['kode'] . ' # ' . $data2['jenis'] . ' # ' . $data2['barang'];

                                        if ($i == 0) $ik_lensa = $data2['jenis'] . ' - ' . $data2['barang'];
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                2 PCS
                            </td>
                            <td class="text-right">
                                <div class="no-print">
                                    <?php //echo number_format($row_detbrg['harga_lensa'], 0, ',', '.'); ?>
                                    1
                                </div>
                                <div class="section-to-print">1</div>
                            </td>
                            <td class="text-right">
                                <?php 
                                    echo number_format($row_detbrg['diskon_lensa'], 2, ',', '.') . " %";
                                ?>
                            </td>
                            <td class="text-right">
                                <?php
                                    $price = $row_detbrg['harga_lensa'] * 2;

                                    $price -= (($row_detbrg['diskon_lensa']/100) * $price);
                                ?>
                                <div class="no-print">
                                    <?php //echo number_format($price, 0, ',', '.'); ?>1 Rupiah
                                </div>
                                <div class="section-to-print">1 Rupiah</div>
                            </td>
                        </tr>
                    <?php
                }

                $i++;
            }
        ?>
        
        <tr>
            <th colspan="5" class="text-right table-active">Total : </th>
            <td class="text-right"><?php echo number_format($gTot, 0, ',', '.'); ?> Rupiah</td>
        </tr>

        <?php if ($ppn != 0): ?>
            <?php
                $ppn_value = (($ppn/100) * $gTot);
                $gTot += $ppn_value;
            ?>
            <tr>
                <th colspan="5" class="text-right table-active">PPN <?=$ppn?>% : </th>
                <td class="text-right">
                    <?php echo number_format($ppn_value, 0, ',', '.'); ?> Rupiah
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <th colspan="5" class="text-right table-active">Total Pembayaran : </th>
            <td class="text-right"><?php echo number_format($dp, 0, ',', '.'); ?> Rupiah</td>
        </tr>
        
        <tr>
            <th colspan="5" class="text-right table-active">Sisa : </th>
            <td class="text-right"><?php echo number_format($gTot - $dp, 0, ',', '.'); ?> Rupiah</td>
        </tr>
    </table>

    <div class="row m-1 font-12">
        <div class="col-4 text-right font-weight-bold">Terbilang : </div>
        <div class="col-5 border-bottom font-italic">
            <?php
                if ($gTot-$dp == 0) echo "Lunas";
                else echo terBilang($gTot - $dp) . " Rupiah";
            ?>
        </div>
        <div class="col-3">&nbsp;</div>
    </div>

    <div class="row m-1 mt-4 font-12">
        <div class="col-7">
            <p class="font-weight-bold m-0">Keterangan : </p>
            <p class="m-0 p-1"><?=nl2br($dkeluarbarang_info)?></p>
        </div>

        <div class="col-5">
            <ul>
                <li>Pesanan sesudah 1 bulan tidak diambil, perusahaan tidak bertanggung jawab.</li>
                <li>Pesanan yang dibatalkan, uang muka dianggap hilang.</li>
                <li>Barang yang sudah dibeli tidak dapat dikembalikan/ditukar.</li>
            </ul>

            <p class="text-right"><strong>Karyawan</strong> : <?=$karyawan_name?></p>
        </div>
    </div>


    </div>

    <div class="tab-pane fade mt-3" id="invoice-kecil" role="tabpanel" aria-labelledby="invoice-kecil-tab">
    
        <div class="row border m-0 font-10" style="width: 10cm; height: 4cm;">
            <div class="col-4 p-0 border-right">
                <p class="text-center p-1 mb-2 border-bottom"><?=$ref?></p>
                <p class="pl-1 mb-2">Pengirim : <br /><?=$branch_name?></p>
                <p class="pl-1 m-0">Penerima : <br /><?=$customer_name?><br /><?=$customer_phone_1?></p>
            </div>

            <div class="col-8 p-0 mt-1">
                <p class="pl-1 mb-1">Tanggal : <?=$tgl?></p>
                <p class="pl-1 mb-1">Frame : <?=$ik_barang ?? '-'?></p>
                <p class="pl-1 mb-1">Keterangan : <?=$ik_lensa ?? '-'?></p>
                <p class="p-1 m-0">
                    <table class="table table-bordered table-sm font-8">
                        <thead>
                            <tr>
                                <td>&nbsp;</td>
                                <td class="text-center">SPH</td>
                                <td class="text-center">CYL</td>
                                <td class="text-center">AXIS</td>
                                <td class="text-center">ADD</td>
                                <td class="text-center">PD</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="text-center">R</td>
                                <td class="text-center"><?=$ik_rsph ?? '-'?></td>
                                <td class="text-center"><?=$ik_rcyl ?? '-'?></td>
                                <td class="text-center"><?=$ik_raxis ?? '-'?></td>
                                <td class="text-center"><?=$ik_radd ?? '-'?></td>
                                <td class="text-center"><?=$ik_rpd ?? '-'?></td>
                            </tr>

                            <tr>
                                <td class="text-center">L</td>
                                <td class="text-center"><?=$ik_lsph ?? '-'?></td>
                                <td class="text-center"><?=$ik_lcyl ?? '-'?></td>
                                <td class="text-center"><?=$ik_laxis ?? '-'?></td>
                                <td class="text-center"><?=$ik_ladd ?? '-'?></td>
                                <td class="text-center"><?=$ik_lpd ?? '-'?></td>
                            </tr>
                        </tbody>
                    </table>
                </p>
            </div>
        </div>
    
    </div>
    </div>

    <div id="iframe" style="visibility: hidden;width: 0px;height: 0px;"></div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>
<script type="text/javascript">
    window.onafterprint = (event) => {
        $('#iframe').html('<iframe src="rp58:open"></iframe>');
    };
</script>
