<?php
global $mysqli;
global $c, $t;
global $branch_id;
// clear dkeluarbarang
//$query_cleanup = "call sp_cleanup_trans";
//$mysqli->query($query_cleanup);

	if (isset($_GET['id']))
	{
		$t = 'edit';
		$keluarbarang_id = $_GET['id'];

		$rs = $mysqli->query("SELECT a.*, b.kontak AS customer_name 
                                FROM keluarbarang a 
                                JOIN kontak b ON a.client = b.user_id 
                                WHERE keluarbarang_id = $keluarbarang_id");
		if ($data = $rs->fetch_assoc())
		{
			$referensi = $data['referensi'];
			
			$tgl = $data['tgl'];
			$client = $data['client'];
			$sales = $data['sales'];

            $matauang_id = 1;
            $tdiskon = $data['tdiskon'];
            $diskon = $data['diskon'];
            $ppn = $data['ppn'];
            $info = $data['info'];

            $customer_name = $data['customer_name'];

            $disabled = 'disabled';
		}
	}
	else
	{
		$mysqli->query("INSERT INTO keluarbarang(referensi, tgl, created_by, created_at) VALUES('', NOW(), $_SESSION[user_id], NOW())");
		$keluarbarang_id = $mysqli->insert_id;

		$referensi = "INV-";
		$rs = $mysqli->query("SELECT referensi FROM keluarbarang WHERE referensi LIKE '$referensi%' AND branch_id = $branch_id ORDER BY referensi DESC LIMIT 0,1");
		$data = $rs->fetch_assoc();

		if ($data == null) $referensi .= '000001';
		else {
			$lastreferensi = substr('00000' . (substr($data['referensi'], -6) + 1), -6);
			$referensi .= $lastreferensi;
		}

		$tgl = date("Y-m-d");
		$client = 0;
		$sales = 0;
		
		$matauang_id = 1;
		$tdiskon = '1';
		$diskon = 0;
		$ppn = 0;
		$info = '';

        $disabled = '';
	}

// get matauang
$jkontak_query = "select kode, matauang from matauang order by matauang";
$jkontak = $mysqli->query($jkontak_query);
$row_jkontak   = mysqli_fetch_assoc($jkontak);
$total_jkontak = mysqli_num_rows($jkontak);

// getsatuan
$query_satuan = "SELECT * FROM satuan ORDER BY satuan ASC";
$satuan       = $mysqli->query($query_satuan);
$row_satuan   = mysqli_fetch_assoc($satuan);
$total_satuan = mysqli_num_rows($satuan);

?>

<script type="text/javascript" src="js/jquery.number.min.js"></script>
<script type="text/javascript" language="javascript" src="js/apps/add_invoicepenjualan.js"></script>

<style type="text/css">
#result{ 
	background-color: #F0FFED;
	border: 1px solid #215800;
	padding: 10px;
	width: 400px;
	margin-bottom: 20px;
	position:absolute;
	z-index:4;
	margin-left:30%;
}
a.close {
	float:right;
}
table, input, textarea, button {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
}
table ul {
	padding:0;
	margin:0;
}
table ul li {
	padding-left:20px;
	list-style:none;	
}
</style>
<link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />

<h1> <?=$t=='edit'?'Edit':''?> Penjualan Baru</h1>

<input type="hidden" id="global_discount" value="<?=($_SESSION['global_discount'] ?? 0)?>" />
<input type="hidden" id="global_discount_lensa" value="<?=($_SESSION['global_discount_lensa'] ?? 0)?>" />
<input type="hidden" id="global_discount_softlens" value="<?=($_SESSION['global_discount_softlens'] ?? 0)?>" />
<input type="hidden" id="global_discount_accessories" value="<?=($_SESSION['global_discount_accessories'] ?? 0)?>" />
<input type="hidden" id="editable_price" value="<?=($_SESSION['editable_price'] ?? 0)?>" />
<input type="hidden" id="bpjs_promo_enabled" value="<?=($_SESSION['bpjs_promo_enabled'] ?? 0)?>" />
<input type="hidden" id="bpjs_promo_discount_1" value="<?=($_SESSION['bpjs_promo_discount_1'] ?? 0)?>" />
<input type="hidden" id="bpjs_promo_discount_2" value="<?=($_SESSION['bpjs_promo_discount_2'] ?? 0)?>" />
<input type="hidden" id="bpjs_promo_discount_3" value="<?=($_SESSION['bpjs_promo_discount_3'] ?? 0)?>" />

<?php
    $tipes = array(
        '0' => 'SEMUA TIPE',
        '1' => 'FRAME',
        '2' => 'SOFTLENS',
        '3' => 'LENSA',
        '4' => 'ACCESSORIES',
    );

    $promo = array(
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
    );

    $promo_persen = array(
        '1' => '0',
        '2' => '0',
        '3' => '0',
        '4' => '0',
    );

    $rs = $mysqli->query("SELECT * FROM promo WHERE branch_id IN (0, $branch_id) AND NOW() BETWEEN start_date AND end_date");
    while ($data = $rs->fetch_assoc()) {
        $category = $data['category'];
        
        if ($category == 0) {
            if ($data['discount_type'] == '0') {
                $promo[1] += $data['discount'];
                $promo[2] += $data['discount'];
                $promo[3] += $data['discount'];
                $promo[4] += $data['discount'];
            }
            else if ($data['discount_type'] == '1') {
                $promo_persen[1] .= ',' . $data['discount'];
                $promo_persen[2] .= ',' . $data['discount'];
                $promo_persen[3] .= ',' . $data['discount'];
                $promo_persen[4] .= ',' . $data['discount'];
            }
        }
        else {
            if ($data['discount_type'] == '0')
                $promo[$category] += $data['discount'];
            else if ($data['discount_type'] == '1')
                $promo_persen[$category] .= ',' . $data['discount'];
        }

        ?>
            <div class="alert alert-info" role="alert">
                <strong><?=$data['name']?></strong> - Potongan <strong><?=number_format($data['discount'], 0)?><?=$data['discount_type']=='1'?'%':''?></strong> untuk pembelian <strong><?=$tipes[$category]?></strong>
            </div>
        <?php
    }
?>

<input type="hidden" id="promo_frame" value="<?=$promo['1']?>" />
<input type="hidden" id="promo_softlens" value="<?=$promo['2']?>" />
<input type="hidden" id="promo_lensa" value="<?=$promo['3']?>" />
<input type="hidden" id="promo_accessories" value="<?=$promo['4']?>" />

<input type="hidden" id="promo_persen_frame" value="<?=$promo_persen['1']?>" />
<input type="hidden" id="promo_persen_softlens" value="<?=$promo_persen['2']?>" />
<input type="hidden" id="promo_persen_lensa" value="<?=$promo_persen['3']?>" />
<input type="hidden" id="promo_persen_accessories" value="<?=$promo_persen['4']?>" />

<form name="add" id="add" action="component/<?=$c?>/p_<?=$c?>.php?p=<?=$t?>" method="POST">
	<input type="hidden" name="keluarbarang_id" id="keluarbarang_id" value="<?=$keluarbarang_id?>">
    <input type="hidden" id="tipePembayaran" name="tipePembayaran" value="1" />

  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="14%" align="right">No. Invoice *</td>
      <td width="1%" align="center">:</td>
      <td width="85%">
            <input name="invoice" type="text" id="invoice" value="<?=$referensi?>" size="15" maxlength="15" <?=$disabled?> />

        <?php if ($total_jkontak == 1) { ?>
            <input type="hidden" name="matauang" id="matauang" value="<?php echo $row_jkontak['kode']; ?>" />
        <?php } else { ?>
            <select name="matauang" id="matauang">
                <?php if($total_jkontak > 0) { do { ?>
                <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_jkontak['kode']=='IDR') { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['matauang'];?></option>
                <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
            </select>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <td align="right">Tanggal *</td>
      <td align="center">:</td>
      <td>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?=$tgl?>" size="10" maxlength="10" <?=$disabled?> />
      </td>
    </tr>

    <tr>
      <td align="right">Customer *</td>
      <td align="center">:</td>
		<td>
          	<input type="text" placeholder="Cari Customer" size="15" onkeyup="refreshCustomer(this.value);" <?=$disabled?> />
        	<select name="customer" id="customer" onchange="onChangeCustomer()" <?=$disabled?> ></select>
		</td>
    </tr>
	<tr>
		<td align="right">Sales</td>
		<td align="center">:</td>
		<td>
				<select name="sales" id="sales" <?=$disabled?> >
                	<option value="0">-</option>
					<?php
						$rs3 = $mysqli->query("SELECT a.user_id,a.kontak 
                            FROM kontak a 
                            JOIN jeniskontak b ON a.jenis = b.kode 
                            WHERE b.klasifikasi LIKE 'sales' 
                            AND a.branch_id = $branch_id 
                            ORDER BY kontak ASC ");
						while ($data3 = mysqli_fetch_assoc($rs3))
						{
							?>
                            	<option value="<?=$data3['user_id']?>"><?=$data3['kontak']?></option>
                            <?php
						}
                    ?>
				</select>
		</td>
	</tr>
  </table>

    <br />
	Tipe : 
	<select id="tipe" onchange="refreshTipe();">
		<option value="5">FRAME + LENSA</option>
        <option value="1">FRAME</option>
        <option value="2">SOFTLENS</option>
        <option value="3">LENSA</option>
        <option value="4">ACCESSORIES</option>
	</select>
    <br />

    <fieldset style="border:solid 1px #999999;margin-top:5px">
    <div>
        <div id="divDetail1" style="width:49%;float:left">
        	<table width="100%" border="0" cellspacing="0" class="datatable">
                <tr class="tableDetail1">
                    <td align="right" width="20%">Barang</td>
                    <td>:</td>
                    <td align="left">
							<input type="text" name="qbrg" id="qbrg" onkeyup="refreshBarang()" autocomplete="off" placeholder="Cari Kode / Brand / Nama" size="50" style="margin-top: 5px;" />
                        <br />
                        <label id="divMBarang">
                            <select name="barang" id="barang" onchange="getDetailBarang(this.value);" style="margin-top: 5px;">
                            </select>
                        </label>
                    </td>
                </tr>
                <tr id="divDetailFrame">
                    <td align="right">
                       	Frame
                    </td>
        
                    <td>
                        :
                    </td>
        
                    <td align="left" id="frame">
                    </td>
                </tr>
                
                <tr id="divDetailSoftlens">
                    <td align="right">
                        Minus
                    </td>
        
                    <td>
                    </td>
                    
                    <td align="left">
                        <input type="hidden" id="softlens_product_id" value="0" />

                        <select name="softlensMinus" id="softlensMinus" onchange="getDetailSoftlens()">
                            <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                                <option value="<?=$r?>" <?=($r == 0 ? 'selected' : '')?> >
                                    <?=$r?>
                                </option>
                            <?php } ?>
                        </select>

                        <label id="labelStockSoftlens">
                            Stock : 
                        </label>
                        <!--
                       	<input type="checkbox" id="checkSOSoftlens" onclick="specialOrderSoftlens()" value="1" />Special Order
                        <br />
                        <textarea cols="30" id="textSOSoftlens"></textarea>
                        -->
                    </td>
                </tr>

                <!--
                <tr class="divSpecialOrderSoftlens">
                    <td align="right">
						Tipe
                    </td>
                    
					<td>
                    	:
                    </td>
                    
                    <td align="left">
						<input type="text" size="15" id="tipeSoftlens" />
                    </td>
				</tr>
                -->
				
                <tr class="tableDetail1">
                    <td align="right">Qty</td>
                    <td>:</td>
                    <td>
                        <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onkeyup="calculate_subtotal2()" onfocus="if(this.value=='0')this.value=''" onblur="if(this.value=='')this.value='0'" autocomplete="off" />

                            <?php if ($total_satuan == 1) { ?>
                            <input type="hidden" name="satuan" id="satuan" value="<?=$row_satuan['satuan_id']?>" />
                            <?php echo $row_satuan['satuan']; ?>
                            <?php } else { ?>
                            <select name="satuan" id="satuan">
                                <option value="">-- Satuan --</option>
                                <?php if($total_satuan > 0) { do { ?>
                                <option value="<?php echo $row_satuan['satuan_id'];?>"><?php echo $row_satuan['satuan'];?></option>
                                <?php }while($row_satuan = mysqli_fetch_assoc($satuan)); } ?>
                            </select>
                            <?php } ?>
                    </td>
                </tr>
                <tr class="tableDetail1">
                    <td align="right">Harga Satuan</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="hsatuan" id="hsatuan" value="0" onkeyup="calculate_subtotal2()" <?=($_SESSION['editable_price'] != 1 ? 'disabled="disabled"' : '')?> />
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="divLensa" style="width:49%;float:left;vertical-align:top;margin-left: 10px">
            <table border="0" cellspacing="0" cellpadding="2" class="datatable">
                <tr>
                    <td>&nbsp;</td>
                    <td>SpH</td>
                    <td>Cyl</td>
                    <td>Axis</td>
                    <td>Add</td>
                    <td>PD</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">Right : </td>
                    <td>
                        <select name="rSph" id="rSph" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= -2000; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rCyl" id="rCyl" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= -2000; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rAxis" id="rAxis">
                            <?php for ($r = 0; $r <= 180; $r = $r + 1) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rAdd" id="rAdd" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= 0; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?=$r?>" <?=($r == 0 ? 'selected' : '')?> ><?=$r?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rPd" id="rPd">
                            <?php for ($r = 40; $r <= 80; $r = $r + 1) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td id="labelStockLensaRight">
                        Stock : 
                    </td>
                </tr>
                <tr>
                    <td align="right">Left : </td>
                    <td>
                        <select name="lSph" id="lSph" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= -2000; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                                <?php
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lCyl" id="lCyl" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= -2000; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lAxis" id="lAxis">
                            <?php for ($r = 0; $r <= 180; $r = $r + 1) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lAdd" id="lAdd" onchange="getDetailLensa()">
                            <?php for ($r = 1500; $r >= 0; $r = $r - 25) {
                                if ($r == 0) $r = '000';
                                else if ($r < 100 && $r > 0) $r = '0' . $r;
                                else if ($r < 0 && $r > -100) $r = '-0' . $r*-1;
                                ?>
                                    <option value="<?=$r?>" <?=($r == 0 ? 'selected' : '')?> ><?=$r?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lPd" id="lPd">
                            <?php for ($r = 40; $r <= 80; $r = $r + 1) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td id="labelStockLensaLeft">
                        Stock : 
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Lensa :
                    </td>
                    <td colspan="6">
                        <input type="text" size="30" id="searchLensa" placeholder="Cari Kode / Brand / Nama" autocomplete="false" onkeyup="refreshLensa()" />
                        <br />
                        <select id="lensa" style="margin-top: 5px;" onchange="getDetailLensa()">
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Harga : 
                    </td>
                    <td colspan="6">
                        <input type="text" id="hargaLensa" value="0" onkeyup="calculate_subtotal2()" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" <?=($_SESSION['editable_price'] != 1 ? 'disabled="disabled"' : '')?> />

                        <input type="hidden" id="lensa_product_id" value="0" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        Diskon : 
                    </td>
                    <td colspan="6">
                        <input type="text" name="diskonlensa" id="diskonlensa" size="8" maxlength="8" value="<?=($_SESSION['global_discount_lensa'] ?? 0)?>" onkeyup="calculate_subtotal2()" onfocus="if(this.value=='0')this.value=''" onblur="if(this.value=='')this.value='0'" autocomplete="off" disabled="disabled" />

                        <select name="tdiskonlensa" id="tdiskonlensa" style="font-size:9px;" onchange="calculate_subtotal2()" disabled="disabled">
                            <option value="1">%</option>
                            <option value="0">Normal</option>
                        </select>

                        <br />
                        <input type="checkbox" id="checkSOLensa" class="form-check-input" value="1" onclick="specialOrderLensa()" />Special Order
                    </td>
                </tr>
                <tr class="divSpecialOrderLensa">
                    <td align="right">
                        Harga SO :
                    </td>
                    <td colspan="6">
                        <input type="text" size="15" id="hargaLensaSO" value="0" onkeyup="calculate_subtotal2()" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" />
                    </td>
                </tr>
                <tr class="divSpecialOrderLensa">
                    <td align="right">
                        Keterangan SO :
                    </td>
                    <td colspan="6">
                        <textarea id="infoSOLensa" name="infoSOLensa" rows="3" cols="30"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="clear:both;padding-left:10px">
            <br />
            <table border="0" cellspacing="0" cellpadding="2">
                <tr id="trDiskon">
                    <td align="right">Diskon</td>
                    <td>:</td>
                    <td>
                        <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="<?=($_SESSION['global_discount'] ?? 0)?>" onkeyup="calculate_subtotal2()" onfocus="if(this.value=='0')this.value=''" onblur="if(this.value=='')this.value='0'" autocomplete="off" disabled="disabled" />

                        <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="calculate_subtotal2()" disabled="disabled">
                            <option value="1">%</option>
                            <option value="0">Normal</option>
                        </select>
                    </td>
                </tr>

                <?php
                    if ($_SESSION['bpjs_promo_enabled'] == 1) {
                        ?>
                            <tr>
                                <td align="right">BPJS</td>
                                <td>:</td>
                                <td>
                                    <select id="bpjs_promo" onchange="calculate_subtotal2()">
                                        <option value="0">-</option>
                                        <option value="<?=($_SESSION['bpjs_promo_discount_1'] ?? 0)?>">Kelas 1</option>
                                        <option value="<?=($_SESSION['bpjs_promo_discount_2'] ?? 0)?>">Kelas 2</option>
                                        <option value="<?=($_SESSION['bpjs_promo_discount_3'] ?? 0)?>">Kelas 3</option>
                                    </select>
                                </td>
                            </tr>
                        <?php
                    }
                ?>

                <tr>
                    <td align="right">Subtotal</td>
                    <td>:</td>
                    <td>
                        <input type="hidden" name="promo" id="promo" value="0" />
                        <input name="subtotal" type="text" id="subtotal" value="0" disabled="disabled" />
                    </td>
                </tr>
                <tr>
                    <td align="right">Keterangan</td>
                    <td>:</td>
                    <td>
                        <textarea id="detailInfo" name="detailInfo" rows="3" cols="50"></textarea>
                    </td>
                </tr>
            </table>
            <br />

            <div id="div-button-add">
                <a href="javascript:void(0);" onclick="manageInvoiceJual('add','');">
                    <img src="images/shopping_cart.png" border="0" height="24px" /> Add to Cart
                </a>
            </div>

            <div id="div-button-edit">
                <input type="hidden" id="edit_detail_id" value="0" />
                <input type="button" class="btn btn-primary btn-sm" onclick="submitEdit()" value="Edit" />
                <input type="button" class="btn btn-danger btn-sm" onclick="cancelEdit()" value="Cancel" />
            </div>
			
            <br /><br />
        </div>
    </div>
    </fieldset>
    
    <br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr valign="top">
      <td align="right">Detail Transaksi</td>
      <td align="center">:</td>
      <td>
			<div id="divManageInvoice"></div>
      </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>
            <ul>
                <li style="display: table-row;">
                    <div style="display: table-cell; vertical-align: middle;">
                        <input type="checkbox" name="checkOrder" <?=$disabled?> />
                    </div>
                    <div style="display: table-cell; vertical-align: middle;padding-top: 2px;">&nbsp;Penjualan Order</div>
                </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td align="right">PPN</td>
        <td align="center">:</td>
        <td>
            <input type="text" id="ppn" name="ppn" size="3" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" onkeyup="calculate_grandtotal()" /> %
        </td>
    </tr>
    <tr>
        <td align="right">Grand Total</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="grand_total" id="grand_total" value="0" readonly="readonly" />
        </td>
    </tr>
    <tr>
        <td align="right">Pembayaran</td>
        <td align="center">:</td>
        <td>
            <select name="carabayar_id" <?=$disabled?> >
				<?php
                    $rs = $mysqli->query("SELECT * FROM carabayar ORDER BY carabayar_id ASC");
                    while ($data = mysqli_fetch_assoc($rs))
                    {
                        ?>
                            <option value="<?=$data['carabayar_id']?>"><?=$data['pembayaran']?></option>
                        <?php
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right">Jumlah</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="uangMuka" id="uangMuka" size="20" maxlength="20" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" autocomplete="off" <?=$disabled?> />
        </td>
    </tr>
    <tr>
        <td align="right">Keterangan Pembayaran</td>
        <td align="center">:</td>
        <td>
            <textarea rows="3" cols="50" name="textInfoPembayaran" id="textInfoPembayaran" <?=$disabled?> ></textarea>
        </td>
    </tr>
    <tr>
        <td><em>*diisi</em></td>
        <td align="center" valign="top">&nbsp;</td>
        <td width="82%">
            <!--
        	<label>
                <input type="button" onclick="printKwitansi();" value="Cetak Kwitansi" />
            </label>
            -->
            <label>
                <input type="button" onclick="printInvoice();" value="Cetak Invoice" />
            </label>
            <label style="margin-left: 10px;">
                <input type="button" name="Save" id="Save" value="Simpan" onclick="formSubmit()">
            </label>
            <label style="margin-left: 10px;">
                <input name="Cancel" type="reset" id="Cancel" onclick="javascript:window.location='index-c-invoicepenjualan-t-add.pos';" value="Transaksi Baru"/>
            </label>
        </td>
    </tr>
  </table>
</form>

<script>
    <?php
        if ($t == 'add') {
            ?>
                refreshCustomer('');
            <?php
        }
    ?>

    refreshTipe();
    refreshBarang();
    refreshLensa();
	
	setTipePembayaran(1);
	onLoad();

    <?php
        if ($t == 'edit') {
            ?>
                manageInvoiceJual('refresh','');
                refreshCustomer('<?=$customer_name?>');
                $('#sales').val(<?=$sales?>);
                $('#ppn').val(<?=$ppn?>);
            <?php
        }
    ?>
</script>