<?php include('include/define.php');?>
<?php
$id = $_GET['id'];
// query edit
$query_edit = "select * from barang where product_id=$id";
$edit = $mysqli->query($query_edit);
$row_edit = mysqli_fetch_assoc($edit);
$total_edit = mysqli_num_rows($edit);
// get jenis barang
$query_jbarang = "select product_id, kode, jenis from jenisbarang order by jenis";
$jbarang       = $mysqli->query($query_jbarang);
$row_jbarang   = mysqli_fetch_assoc($jbarang);
$total_jbarang = mysqli_num_rows($jbarang);
// get jenis frame
$query_jenis    = "SELECT * FROM frame_type ORDER BY frame ASC";
$jenis          = $mysqli->query($query_jenis);
$row_jenis      = mysqli_fetch_assoc($jenis);
?>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript">
function changeTipe() {
    var tipe = $("#tipe").val();
    if (tipe == 1) {
        $("#tipeFrame").html('Tipe Frame');
		$("#jenisFrame").html('Frame');
        $("#size").parent().parent().hide();
    } else if (tipe == 2) {
        $("#tipeFrame").html('Tipe Softlens');
		$("#jenisFrame").html('Softlens');
        $("#size").parent().parent().show();
    } else if (tipe == 3) {
		$("#tipeFrame").html('Tipe Lensa');
		$("#jenisFrame").html('Lensa');
        $("#size").parent().parent().show();
	}
    reloadFrame();
}

function reloadFrame() {
    var tipe = $("#tipe").val();
    $.ajax({
        url: 'component/masterbarang/task/ajax_masterbarang.php',
        type: 'GET',
        dataType: 'json',
        data: 'mode=get_jenis_frame&tipe=' + tipe,
        success: function(result) {
            var html = '<option value="">-- Choose Frame --</option>';
            var frame0 = $("#frame0").val();
            for (i=0; i<result.length; i++) {
                if (result[i].frame == frame0) {
                    html += '<option value="' + result[i].frame + '" selected>' + result[i].frame + '</option>';
                } else {
                    html += '<option value="' + result[i].frame + '">' + result[i].frame + '</option>';
                }
            }
            $("#frame").html(html);
        }
    });
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
				} else {
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
      $('#keterangan').wysiwyg();
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
<link type="text/css" rel="stylesheet" href="css/jquery.wysiwyg.css" />
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<h1>Edit Master Barang</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="edit" id="edit">
	<input type="hidden" name="product_id" id="product_id" value="<?=$id?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Kode</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="kode" type="text" id="kode" value="<?php echo $row_edit['kode'];?>" size="10" />
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Tipe</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select name="tipe" id="tipe" onchange="changeTipe();">
                <option value="1" <?php echo ($row_edit['tipe'] == 1) ? 'selected' : '' ?>>Frame</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top"><label id="jenisFrame">Frame</label> *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <input type="hidden" value="<?php echo $row_edit['frame']; ?>" id="frame0" />
            <select name="frame" id="frame">
            </select>
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Nama Brand *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="jenis" id="jenis">
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right" valign="top"><label id="tipeFrame">Tipe Frame *</label></td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="barang" type="text" id="barang" value="<?php echo $row_edit['barang'];?>" size="30" maxlength="100" />
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Warna *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select name="color" id="color">
            	<option value="">-- Choose Color --</option>
                <?php
					$rs2 = $mysqli->query("SELECT * FROM color_type ORDER BY color ASC");
					while ($data2 = mysqli_fetch_assoc($rs2))
					{
						?>
                        	<option value="<?=$data2['color']?>" 
                            <?php
								if ($row_edit['color'] == $data2['color']) echo "selected='selected'";
                            ?>><?=$data2['color']?></option>
                        <?php
					}
				?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">Ukuran *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <input name="size" type="text" id="size" size="30" maxlength="30" value="<?php echo $row_edit['ukuran']; ?>" />
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
        <td align="right">Harga</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price" id="price" value="<?php echo $row_edit['price']; ?>" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga 2</td>
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
	<tr valign="top">
		<td align="right">Tanggal Masuk</td>
		<td align="center">:</td>
		<td>
			<input type="text" class="calendar" id="tgl_masuk" name="tgl_masuk" value="<?php echo $row_edit['tgl_masuk_akhir']; ?>" />
		</td>
	</tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan" />
      </label>
        <label>
          <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
        </label></td>
    </tr>
  </table>
</form>

<script>
    $("#size").parent().parent().hide();
    changeTipe();
</script>