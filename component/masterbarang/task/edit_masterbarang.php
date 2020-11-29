<?php
    
    global $mysqli;
    global $base_url;

    include('include/define.php');
    require "models/Barang.php";
    require "models/DBHelper.php";

$db = new DBHelper($mysqli);

$id = $_GET['id'];
//$old_search = urlencode($_GET['old_search'] ?? '');
$old_search = $_GET['old_search'];

$b = new Barang();
$b->setProductId($id);
$b = $db->getBarang($b);

?>

<script type="text/javascript">

function refreshBrand() {
    var tipe = $("#tipe").val();
    
    $.ajax({
        url: 'component/masterbarang/task/ajax_masterbarang.php',
        type: 'GET',
        dataType: 'json',
        data: 'mode=get_jenis&tipe=' + tipe,
        success: function(result) {
            var html = '<option value="">-- Choose Brand --</option>';
            for (i=0; i<result.length; i++) {
				if (result[i].brand_id == '<?=$b->getBrandId()?>') {
				    html += '<option value="' + result[i].brand_id + '" selected="selected">' + result[i].jenis + '</option>';
				}
                else {
					html += '<option value="' + result[i].brand_id + '">' + result[i].jenis + '</option>';
				}
            }
            $("#jenis").html(html);
        }
    });
}

$(document).ready(function() {

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#edit').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
			}
		})
		return false;
	});
  $('#result').click(function(){
  $(this).hide();
  });
})
$(function()
  {
  });
</script>
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

<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1>Edit Master Barang</h1> 
<form action="component/<?=$c?>/p_<?=$c?>.php?p=<?=$t?>" method="post" name="edit" id="edit">
	<input type="hidden" name="product_id" id="product_id" value="<?=$id?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
        <td width="12%" align="right" valign="top">Tipe</td>
        <td width="1%" align="center" valign="top">:</td>
        <td width="82%" valign="top">
            <input type="hidden" name="tipe" id="tipe" value="<?=$b->getTipe()?>" />
            <select disabled="disabled">
                <option value="1" <?= ($b->getTipe() == 1) ? 'selected' : '' ?>>Frame</option>
                <option value="2" <?= ($b->getTipe() == 2) ? 'selected' : '' ?>>Softlens</option>
                <option value="3" <?= ($b->getTipe() == 3) ? 'selected' : '' ?>>Lensa</option>
                <option value="4" <?= ($b->getTipe() == 4) ? 'selected' : '' ?>>Accessories</option>
            </select>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Kode</td>
      <td align="center" valign="top">:</td>
      <td valign="top">
        <label>
            <input name="kode" type="text" id="kode" value="<?=$b->getKode()?>" size="10" />
        </label>
        </td>
    </tr>
    
    <tr>
      <td align="right" valign="top">Brand</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="jenis" id="jenis">
        </select>
      </label></td>
    </tr>

    <tr>
      <td align="right" valign="top">Nama Product</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="barang" type="text" id="barang" value="<?=$b->getBarang()?>" size="30" maxlength="100" />
      </label></td>
    </tr>

    <?php if ($b->getTipe() < 4): ?>

    <tr>
        <td align="right">
            <?php
                $frame = $b->getFrame();

                switch ($b->getTipe()) {
                    case 1:
                        echo 'Frame';
                    break;

                    case 2:
                        echo 'Minus';
                    break;

                    case 3:
                        echo 'Minus';
                    break;
                }
            ?>
        </td>
        <td align="center">:</td>
        <td>
            <input type="text" name="frame" id="frame" value="<?=$frame?>" />
        </td>
    </tr>

    <tr>
        <td align="right">
            <?php
                $color = $b->getColor();

                switch ($b->getTipe()) {
                    case 1:
                        echo 'Color';
                    break;

                    case 2:
                        echo 'Color';
                    break;

                    case 3:
                        echo 'Silinder';
                    break;
                }
            ?>
        </td>
        <td align="center">:</td>
        <td>
            <input type="text" name="color" id="color" value="<?=$color?>" />
        </td>
    </tr>

    <?php endif; ?>

    <?php if ($b->getTipe() == 3): ?>

        <tr>
            <td align="right">Add</td>
            <td align="center">:</td>
            <td>
                <input type="text" name="power_add" id="power_add" value="<?=$b->getPowerAdd()?>" />
            </td>
        </tr>

    <?php endif; ?>

    <tr>
        <td align="right">Expiry Date</td>
        <td align="center">:</td>
        <td>
            <input type="date" name="size" id="size" value="<?=$b->getUkuran()?>" <?=($b->getTipe() != 2) ? 'disabled="disabled"' : ''?> />
        </td>
    </tr>

    <tr valign="top">
        <td align="right">Qty</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="qty" id="qty" size="10" maxlength="5" value="<?=$b->getQty()?>" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga Beli</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price" id="price" value="<?=$b->getPrice()?>" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga Jual</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price2" id="price2" value="<?=$b->getPrice2()?>" />
        </td>
    </tr>
    <tr valign="top">
        <td align="right">Kode Harga</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="kode_harga" id="kode_harga" value="<?=$b->getKodeHarga()?>" />
        </td>
    </tr>
    <tr valign="top">
      <td align="right">Nama Supplier</td>
      <td align="center">:</td>
      <td><label>
			<select id="info" name="info">
    			<option value="">-- Choose Supplier --</option>
    				<?php
						$rs2 = $mysqli->query("SELECT a.user_id,kontak FROM kontak a JOIN jeniskontak b ON a.jenis = b.kode WHERE b.klasifikasi like 'supplier'");
						while ($data2 = mysqli_fetch_assoc($rs2))
						{
							?>
								<option value="<?=$data2['kontak']?>" 
                                <?php
									if (strtoupper($b->getInfo()) == strtoupper($data2['kontak'])) echo "selected='selected'";
                                ?>><?=$data2['kontak']?></option>
							<?php
						}
					?>
			</select>
		</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:window.location='<?=$base_url?>index-c-masterbarang-q-<?=$old_search?>.pos';" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>

<script>
    refreshBrand();
</script>