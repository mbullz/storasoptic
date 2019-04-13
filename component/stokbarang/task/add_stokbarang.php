<?php include('include/define.php');?>
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
		$import = "insert into stokbarang (id,gudang,barang,satuan,qty) values ";
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($data[0] <>'kode') {
				$import .= "('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]'),";
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
		echo "<script type=\"text/javascript\">setTimeout(\"location.href='index-c-stokbarang-t-add-k-importcsv.pos'\", 2000);</script>";
	  }
  }
?>
</div>
<?php } ?>
<h1>Import Stok Barang (CSV)</h1> 
<form action="" method="post" enctype="multipart/form-data" name="import" id="import" onsubmit="return confirm('Lanjutkan Import CSV ?');">
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
    <tr>
      <td width="12%" align="right">Pilih CSV </td>
      <td width="1%" align="center">:</td>
      <td width="82%"><label>
        <input type="file" name="fcsv" id="fcsv" />
      </label> 
        [ <a href="formatcsv/stokbarang.csv">Format data</a> ]</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="import" id="import" value="Import CSV" />
      </label><label>
        <input name="Cancel" type="reset" id="Cancel" onclick="javascript:history.go(-1);" value="Batal"/>
      </label></td>
    </tr>
  </table>
</form>