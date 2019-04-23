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

		$rs = $mysqli->query("SELECT * FROM keluarbarang WHERE keluarbarang_id = $keluarbarang_id");
		if ($data = $rs->fetch_assoc())
		{
			$po = $data['po'];
			if (substr($po, 0, 1) == '8') $po_type = 'alat';
			else if (substr($po, 0, 1) == '9') $po_type = 'intern';
			else $po_type = 'purchasing';
			$date = $data['date'];
			$project_id = $data['project_id'];
			$vendor_id = $data['vendor_id'];
			$shipment_id = $data['shipment_id'];
			$logistics_id = $data['logistics_id'];
			$shipment_detail = $data['shipment_detail'];
			$currency_id = $data['currency_id'];
			$rates = $data['rates'];
			$tdiskon = $data['tdiskon'];
			$diskon = $data['diskon'];
			$ppn = $data['ppn'];
			$pph = $data['pph'];
			$expense = $data['expense'];
			$expense_info = $data['expense_info'];
			$round = $data['round'];
			$note = $data['note'];
			$condition = $data['condition'];
			$revisi = $data['revisi'];
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

<h1> Penjualan Baru</h1> 

<form name="add" id="add" action="component/<?=$c?>/p_<?=$c?>.php?p=<?=$t?>" method="POST">
	<input type="hidden" name="keluarbarang_id" id="keluarbarang_id" value="<?=$keluarbarang_id?>">
    <input type="hidden" id="tipePembayaran" name="tipePembayaran" value="1" />

  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="14%" align="right" valign="top">No. Invoice *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="85%" valign="top">
        <label>
            <input name="invoice" type="text" id="invoice" value="<?=$referensi?>" size="15" maxlength="15">
        </label>
        <?php if ($total_jkontak == 1) { ?>
            <input type="hidden" name="matauang" id="matauang" value="<?php echo $row_jkontak['kode']; ?>" />
        <?php } else { ?>
        <label>
            <select name="matauang" id="matauang">
                <?php if($total_jkontak > 0) { do { ?>
                <option value="<?php echo $row_jkontak['kode'];?>" <?php if($row_jkontak['kode']=='IDR') { ?>selected="selected"<?php } ?>><?php echo $row_jkontak['matauang'];?></option>
                <?php }while($row_jkontak = mysqli_fetch_assoc($jkontak)); } ?>
            </select>
        </label>
        <?php } ?>
      </td>
    </tr>
    <tr valign="top">
      <td align="right" valign="top">Tanggal *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="tgl" type="text" class="calendar" id="tgl" value="<?=$tgl?>" size="10" maxlength="10"/>
      </label></td>
    </tr>

    <tr valign="top">
      <td align="right">Customer *</td>
      <td align="center">:</td>
		<td>
          	<input type="text" placeholder="Cari Customer" maxlength="15" size="15" onkeyup="refreshCustomer(this.value);" />
        	<select name="customer" id="customer"></select>
		</td>
    </tr>
	<tr valign="top">
		<td align="right">Sales</td>
		<td align="center">:</td>
		<td>
			<label>
				<select name="sales" id="sales">
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
			</label>
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
                        <label>
							<input type="text" name="qbrg" id="qbrg" onkeyup="refreshBarang()" autocomplete="off" placeholder="Cari Kode / Brand / Nama" size="50" />
                        </label>
                        <br />
                        <label id="divMBarang">
                            <select name="barang" id="barang" onchange="getDetailBarang(this.value);" style="margin-top: 5px;margin-bottom: 5px;">
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
        
                    <td align="left">
                        <label id="frame"></label>
                    </td>
                </tr>
                <tr id="divDetailSoftlens">
                    <td align="right">&nbsp;
                       	
                    </td>
        
                    <td>
                    </td>
        
                    <td align="left">
                       	<input type="checkbox" id="checkSOSoftlens" onclick="specialOrderSoftlens()" value="1" />Special Order
                        <br />
                        <textarea cols="30" id="textSOSoftlens"></textarea>
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
				<tr class="divSpecialOrderSoftlens">
                    <td align="right">
						Jenis
                    </td>
                    
                    <td>
                    	:
                    </td>
                    
                    <td align="left">
                    	<input type="text" size="15" id="jenisSoftlens" />
                    </td>
                </tr>
                <tr class="divSpecialOrderSoftlens">
                    <td align="right">
						Price List
                    </td>
                    
                    <td>
                    	:
                    </td>
                    
                    <td align="left">
                    	<input type="text" size="15" id="hargaModalSoftlens" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" />
                    </td>
                </tr>
                <tr class="divSpecialOrderSoftlens">
                    <td align="right">
						Supplier
                    </td>
                    
                    <td>
                    	:
                    </td>
                    
                    <td align="left">
                    	<select id="supplierSoftlens">
                            <option value="">-- Choose Supplier --</option>
                            <?php
                                $rs2 = $mysqli->query("SELECT a.user_id,a.kontak FROM kontak a , jeniskontak b WHERE a.jenis = b.kode AND b.klasifikasi LIKE 'supplier' ORDER BY kontak ASC");
                                while ($data2 = mysqli_fetch_assoc($rs2))
                                {
                                    ?>
                                        <option value="<?=$data2['kontak']?>"><?=$data2['kontak']?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="tableDetail1">
                    <td align="right">Qty</td>
                    <td>:</td>
                    <td>
                        <input name="qty" type="text" id="qty" size="4" maxlength="8" value="0" onkeyup="calculate_subtotal2()" onfocus="if(this.value=='0')this.value=''" onblur="if(this.value=='')this.value='0'" autocomplete="off" />
                        <label>
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
                        </label>
                    </td>
                </tr>
                <tr class="tableDetail1">
                    <td align="right">Harga Satuan</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="hsatuan" id="hsatuan" value="0" disabled="disabled" />
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
                    <td align="right">Left : </td>
                    <td>
                        <select name="lSph" id="lSph" onchange="getDetailLensa()">
                            <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lCyl" id="lCyl" onchange="getDetailLensa()">
                            <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lAxis" id="lAxis">
                            <?php for ($r = 0; $r <= 180; $r = $r + 5) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lAdd" id="lAdd">
                            <?php for ($r = 15; $r >= 0; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="lPd" id="lPd">
                            <?php for ($r = 40; $r <= 80; $r = $r + 2) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td id="labelStockLensaLeft">
                        Stock : 
                    </td>
                </tr>
                <tr>
                    <td align="right">Right : </td>
                    <td>
                        <select name="rSph" id="rSph" onchange="getDetailLensa()">
                            <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rCyl" id="rCyl" onchange="getDetailLensa()">
                            <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rAxis" id="rAxis">
                            <?php for ($r = 0; $r <= 180; $r = $r + 5) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rAdd" id="rAdd">
                            <?php for ($r = 15; $r >= 0; $r = $r - 0.25) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select name="rPd" id="rPd">
                            <?php for ($r = 40; $r <= 80; $r = $r + 2) { ?>
                            <option value="<?php echo $r; ?>" <?php echo ($r == 56 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td id="labelStockLensaRight">
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
                        <input type="text" id="hargaLensa" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" disabled="disabled" />
                        <input type="checkbox" id="checkSOLensa" value="1" onclick="specialOrderLensa()" />Special Order

                        <input type="hidden" id="lensa_product_id" value="0" />
                    </td>
                </tr>
                <tr class="divSpecialOrderLensa">
                    <td colspan="6">
                        <label>
                            Price List : 
                            <input type="text" size="15" id="hargaModalLensa" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" />
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        
        <div style="clear:both;padding-left:10px">
            <br />
            <table border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td align="right">Diskon</td>
                    <td>:</td>
                    <td>
                        <label>
                            <input name="diskon" type="text" id="diskon" size="8" maxlength="8" value="30" onkeyup="calculate_subtotal2()" onfocus="if(this.value=='0')this.value=''" onblur="if(this.value=='')this.value='0'" autocomplete="off" disabled="disabled" />
                        </label>
                        <label>
                            <select name="tdiskon" id="tdiskon" style="font-size:9px;" onchange="calculate_subtotal2()" disabled="disabled">
                                <option value="1">%</option>
                                <option value="0">Normal</option>
                            </select>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td align="right">Subtotal</td>
                    <td>:</td>
                    <td>
                        <label>
                            <input name="subtotal" type="text" id="subtotal" value="0" disabled="disabled" />
                        </label>
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
			<a href="javascript:void(0);" onclick="manageInvoiceJual('add','');">
				<img src="images/shopping_cart.png" border="0" height="24px" /> Add to Cart
			</a>
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
            <select name="carabayar_id">
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
            <input type="text" name="uangMuka" id="uangMuka" size="20" maxlength="20" value="0" onfocus="javascript:if(this.value=='0')this.value='';" onblur="javascript:if(this.value=='')this.value='0';" autocomplete="off" />
        </td>
    </tr>
    <tr>
        <td align="right">Keterangan</td>
        <td align="center">:</td>
        <td>
            <textarea rows="3" cols="50" name="textInfoPembayaran" id="textInfoPembayaran"></textarea>
        </td>
    </tr>
    <tr>
        <td><em>*diisi</em></td>
        <td align="center" valign="top">&nbsp;</td>
        <td width="82%">
        	<label>
                <input type="button" onclick="printKwitansi();" value="Cetak Kwitansi" />
            </label>
            <label>
                <input type="button" onclick="printInvoice();" value="Cetak Invoice" />
            </label>
            <label style="margin-left: 10px;">
                <input type="button" name="Save" id="Save" value="Simpan" onclick="formSubmit()">
            </label>
            <label style="margin-left: 10px;">
                <input name="Cancel" type="reset" id="Cancel" onclick="javascript:location.reload();" value="Transaksi Baru"/>
            </label>
        </td>
    </tr>
  </table>
</form>

<div id="dialog">
</div>

<script>
    refreshTipe();
    refreshBarang();
    refreshLensa();
    refreshCustomer('');
	
	setTipePembayaran(1);
	onLoad();
</script>