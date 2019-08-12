<?php
    
    global $mysqli;
    global $base_url;

    include('include/define.php');

$id = $_GET['id'];
// query edit
$query_edit = "SELECT * FROM barang WHERE product_id = $id";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);

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
				if (result[i].brand_id == '<?php echo $row_edit['brand_id']; ?>') {
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
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
	<input type="hidden" name="product_id" id="product_id" value="<?=$id?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
        <td width="12%" align="right" valign="top">Tipe</td>
        <td width="1%" align="center" valign="top">:</td>
        <td width="82%" valign="top">
            <input type="hidden" name="tipe" id="tipe" value="<?=$row_edit['tipe']?>" />
            <select disabled="disabled">
                <option value="1" <?php echo ($row_edit['tipe'] == 1) ? 'selected' : '' ?>>Frame</option>
                <option value="2" <?php echo ($row_edit['tipe'] == 2) ? 'selected' : '' ?>>Softlens</option>
                <option value="3" <?php echo ($row_edit['tipe'] == 3) ? 'selected' : '' ?>>Lensa</option>
                <option value="4" <?php echo ($row_edit['tipe'] == 4) ? 'selected' : '' ?>>Accessories</option>
            </select>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Kode</td>
      <td align="center" valign="top">:</td>
      <td valign="top">
        <label>
            <input name="kode" type="text" id="kode" value="<?=$row_edit['kode']?>" size="10" />
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
        <input name="barang" type="text" id="barang" value="<?php echo $row_edit['barang'];?>" size="30" maxlength="100" />
      </label></td>
    </tr>

    <?php if ($row_edit['tipe'] < 4): ?>

    <tr>
        <td align="right">
            <?php
                $frame = $row_edit['frame'];

                switch ($row_edit['tipe']) {
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
                $color = $row_edit['color'];

                switch ($row_edit['tipe']) {
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

    <tr>
        <td align="right">Expiry Date</td>
        <td align="center">:</td>
        <td>
            <input type="date" name="size" id="size" value="<?=$row_edit['ukuran']?>" <?=($row_edit['tipe'] != 2) ? 'disabled="disabled"' : ''?> />
        </td>
    </tr>

    <tr valign="top">
        <td align="right">Qty</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="qty" id="qty" size="10" maxlength="5" value="<?php echo $row_edit['qty']; ?>" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga Beli</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price" id="price" value="<?php echo $row_edit['price']; ?>" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga Jual</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price2" id="price2" value="<?php echo $row_edit['price2']; ?>" />
        </td>
    </tr>
    <tr valign="top">
        <td align="right">Kode Harga</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="kode_harga" id="kode_harga" value="<?php echo $row_edit['kode_harga']; ?>" />
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
									if ($row_edit['info'] == $data2['kontak']) echo "selected='selected'";
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
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:window.location='<?=$base_url?>index-c-masterbarang.pos';" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>

<script>
    refreshBrand();
</script>