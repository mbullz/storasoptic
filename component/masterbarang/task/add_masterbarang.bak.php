<?php include('include/define.php');?>
<?php
// get jenis barang
/*$query_jbarang = "select kode, jenis from jenisbarang order by jenis";
$jbarang       = $mysqli->query($query_jbarang);
$row_jbarang   = mysqli_fetch_assoc($jbarang);
$total_jbarang = mysqli_num_rows($jbarang);*/
if($klas <>'importcsv') { 
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
            var html = '<option value="">Pilih Jenis</option>';
            for (i=0; i<result.length; i++) {
                html += '<option value="' + result[i].frame + '">' + result[i].frame + '</option>';
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
            var html = '<option value="">Pilih Nama Brand</option>';
            for (i=0; i<result.length; i++) {
                html += '<option value="' + result[i].kode + '">' + result[i].jenis + '</option>';
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

	$('#add').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
			}
		});
		return false;
	});
  $('#result').click(function(){
  $(this).hide();
  });
});
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
<h1>Master Barang Baru</h1> 
<form action="component/<?php echo $c;?>/p_<?php echo $c;?>.php?p=<?php echo $t;?>" method="post" name="add" id="add">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right" valign="top">Kode *</td>
      <td width="1%" align="center" valign="top">:</td>
      <td width="82%" valign="top"><label>
        <input name="kode" type="text" id="kode" size="8" maxlength="10">
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Tipe</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select name="tipe" id="tipe" onchange="changeTipe();">
                <option value="1">Frame</option>
                <option value="2">Softlens</option>
				<option value="3">Lensa</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top"><label id="jenisFrame">Frame</label> *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <select name="frame" id="frame">
                <option value="">Pilih Jenis</option>
            </select>
            atau
            <input type="text" name="frame1" id="frame1" placeholder="Buat jenis baru" size="15" />
        </td>
    </tr>
    <tr>
      <td align="right" valign="top">Nama Brand *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <select name="jenis" id="jenis">
          <option value="">Pilih Nama Brand</option>
          <?php /*if($total_jbarang > 0) { do { ?>
          <option value="<?php echo $row_jbarang['kode'];?>"><?php echo $row_jbarang['jenis'];?></option>
          <?php }while($row_jbarang = mysqli_fetch_assoc($jbarang)); }*/ ?>
        </select>
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top"><label id="tipeFrame">Tipe Frame</label> *</td>
      <td align="center" valign="top">:</td>
      <td valign="top"><label>
        <input name="barang" type="text" id="barang" size="30" maxlength="100">
      </label></td>
    </tr>
    <tr>
        <td align="right" valign="top">Warna *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <input name="color" type="text" id="color" size="30" maxlength="30" />
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">Ukuran *</td>
        <td align="center" valign="top">:</td>
        <td valign="top">
            <input name="size" type="text" id="size" size="30" maxlength="30" />
            <?php /*
            Kiri:
            <select id="sizeL" name="sizeL">
                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                <?php } ?>
            </select>
            Kanan:
            <select id="sizeR" name="sizeR">
                <?php for ($r = 15; $r >= -20; $r = $r - 0.25) { ?>
                <option value="<?php echo $r; ?>" <?php echo ($r == 0 ? 'selected' : ''); ?>><?php echo $r; ?></option>
                <?php } ?>
            </select> */ ?>
        </td>
    </tr>
    <tr valign="top">
        <td align="right">Qty</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="qty" id="qty" size="10" maxlength="5" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price" id="price" />
        </td>
    </tr>
	<tr valign="top">
        <td align="right">Harga 2</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="price2" id="price2" />
        </td>
    </tr>
    <tr valign="top">
        <td align="right">Kode Harga</td>
        <td align="center">:</td>
        <td>
            <input type="text" name="kode_harga" id="kode_harga" />
        </td>
    </tr>
    <tr valign="top">
      <td align="right">Nama Supplier</td>
      <td align="center">:</td>
      <td><label>
        <textarea name="info" id="info" cols="30" rows="3"></textarea>
      </label></td>
    </tr>
	<tr valign="top">
		<td align="right">Tanggal Masuk</td>
		<td align="center">:</td>
		<td>
			<input type="text" class="calendar" id="tgl_masuk" name="tgl_masuk" />
		</td>
	</tr>
	<tr valign="top">
		<td align="right">Tanggal Keluar</td>
		<td align="center">:</td>
		<td>
			<input type="text" class="calendar" id="tgl_masuk" name="tgl_keluar" />
		</td>
	</tr>
    <tr>
      <td><em>*diisi</em></td>
      <td align="center" valign="top">&nbsp;</td>
      <td width="82%"><label>
        <input name="Save" type="submit" id="Save" value="Simpan">
      </label>
        <label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>
<?php }else { ?>
<?php
if(isset($_POST['import'])) {  ?>
<div id="result">
<?php
  $file = $_FILES['fcsv']['name'];
  $ext_f= explode(".",$file);
  $ext  = $ext_f[count($ext_f) - 1];
  if($ext <>'csv') {
	  echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">File bukan CSV, coba lagi !!!</b>";
  }else{
	  if (($handle = fopen($_FILES['fcsv']['tmp_name'], "r")) !== FALSE) { 
		$import = "insert into barang (kode,jenis,barang,frame,color,qty,price,price2,kode_harga,info,ukuran,tipe,tgl_masuk_akhir,tgl_keluar_akhir) values ";
		$str = fread($handle, 50);
		
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($data[0] <>'kode') {
				$import .= "('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','$data[13]'),";
			}
		}
		$import .=",";
	  }
	  $query_import = str_replace(",,",";",$import);
	  $result = $mysqli->query($query_import) or die(mysql_error());
	  if(!$result) {
		echo "<img src=\"images/alert.gif\" hspace=\"5\"/><b style=\"color:#FA5121;\">Import CSV gagal, coba lagi !!!</b>";  
	  }else{
		echo "<img src=\"images/_info.png\" hspace=\"5\"/><b style=\"color:#1A4D80;\">Import CSV berhasil ...</b>";
		echo "<script type=\"text/javascript\">setTimeout(\"location.href='index-c-masterbarang-t-add-k-importcsv.pos'\", 2000);</script>";
	  }
  }
?>
</div>
<?php } ?>
<h1><small><a href="index-c-<?php echo $c; ?>.pos">&lt;kembali</a></small> Import Master Barang (CSV)</h1> 
<form action="" method="post" enctype="multipart/form-data" name="import" id="import" onsubmit="return confirm('Lanjutkan Import CSV Master Produk ?');">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
	<tr>
	  <td>Contoh format data</td>
	  <td>:</td>
	  <td>
		[ <a href="formatcsv/importbarang.csv">lihat contoh format</a> ]
	  </td>
	</tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
      <td width="12%">Pilih CSV</td>
      <td width="1%" align="center">:</td>
	  <td width="82%">
		<em>
			*) Browse adalah pengambilan data dari file yang telah disediakan dan disimpan melalui bentuk file csv.
		</em>
	  </td>
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="file" name="fcsv" id="fcsv" />
      </label>
	  </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>
		<em>
			*) Jika pengambilan data selesai, klik "Save Import CSV" sebagai data yang akan ditarik.<br>
			*) Jika salah mengambil data, klik batal untuk kembali ke master barang
		</em>
	  </td>
	</tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="import" id="import" value="Save import CSV" />
      </label><label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>
<?php } ?>

<script>
    $("#size").parent().parent().hide();
    changeTipe();
</script>