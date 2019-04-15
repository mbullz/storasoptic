<?php
	include('include/define.php');
	include('include/config_db.php');
	
	$tipe = $_POST['tipe'] ?? 1;
	
	$rs3 = $mysqli->query("SELECT * FROM jenisbarang WHERE tipe = $tipe AND info NOT LIKE 'DELETED' ORDER BY jenis ASC");
	$i = 0;
	$listBrand = '';
	while ($data3 = mysqli_fetch_assoc($rs3))
	{
		if ($i == 0) $listBrand = "'" . $mysqli->real_escape_string(strtoupper($data3['jenis'])) . "'";
		else $listBrand .= ",'" . $mysqli->real_escape_string(strtoupper($data3['jenis'])) . "'";
		$i++;
	}
	
	$rs3 = $mysqli->query("SELECT DISTINCT frame FROM barang WHERE tipe = 1 ORDER BY frame ASC");
	$i = 0;
	$listFrame = '';
	while ($data3 = mysqli_fetch_assoc($rs3))
	{
		if ($i == 0) $listFrame = "'" . $mysqli->real_escape_string(strtoupper($data3['frame'])) . "'";
		else $listFrame .= ",'" . $mysqli->real_escape_string(strtoupper($data3['frame'])) . "'";
		$i++;
	}
	
	$rs3 = $mysqli->query("SELECT DISTINCT color FROM barang WHERE tipe = 1 ORDER BY color ASC");
	$i = 0;
	$listColor = '';
	while ($data3 = mysqli_fetch_assoc($rs3))
	{
		if ($i == 0) $listColor = "'" . $mysqli->real_escape_string(strtoupper($data3['color'])) . "'";
		else $listColor .= ",'" . $mysqli->real_escape_string(strtoupper($data3['color'])) . "'";
		$i++;
	}
	
	$rs3 = $mysqli->query("SELECT DISTINCT color FROM barang WHERE tipe = 2 ORDER BY color ASC");
	$i = 0;
	$listColorSoftlens = '';
	while ($data3 = mysqli_fetch_assoc($rs3))
	{
		if ($i == 0) $listColorSoftlens = "'" . $mysqli->real_escape_string(strtoupper($data3['color'])) . "'";
		else $listColorSoftlens .= ",'" . $mysqli->real_escape_string(strtoupper($data3['color'])) . "'";
		$i++;
	}
	
	$rs3 = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'S001' ORDER BY kontak ASC");
	$i = 0;
	$listContact = '';
	while ($data3 = mysqli_fetch_assoc($rs3))
	{
		if ($i == 0) $listContact = "'" . $mysqli->real_escape_string(strtoupper($data3['kontak'])) . "'";
		else $listContact .= ",'" . $mysqli->real_escape_string(strtoupper($data3['kontak'])) . "'";
		$i++;
	}
?>
<script data-jsfiddle="common" src="js/jquery.handsontable.full.js"></script>
<script language="javascript" type="text/javascript">
	function printInvoice()
	{
		var data = $("#example").data('handsontable').getData();
		var company_name = "<?=$company_name?>";
		sessionStorage.setItem('data', data);
		sessionStorage.setItem('company_name', company_name);
		NewWindow('include/draft_barcode.php','name','640','550','yes');
    }
	
	function printInvoice2()
	{
		var data = $("#example").data('handsontable').getData();
		var company_name = "<?=$company_name?>";
		sessionStorage.setItem('data', data);
		sessionStorage.setItem('company_name', company_name);
		NewWindow('include/draft_barcodeb.php','name','640','550','yes');
    }
	
	function openDialogPrintInvoice()
	{
		$("#dialog3").dialog("open");
	}
	
	$(function()
	{
		$("#dialog3").dialog(
		{
			autoOpen: false,
			modal: true,
			show:
			{
				effect: "drop",
				duration: 500
			},
			hide:
			{
				effect: "drop",
				duration: 500
			},
			open: function()
			{
				jQuery('.ui-widget-overlay').bind('click',function()
				{
					jQuery('#dialog3').dialog('close');
				});
			},
			close: function()
			{
				window.location = "<?=$base_url?>index-c-masterbarang.pos";
			},
			buttons:
			{
				"No Barcode": function()
				{
					printInvoice2();
					$("#dialog3").dialog("close");
				},
				"With Barcode": function()
				{
					printInvoice();
					$("#dialog3").dialog("close");
				},
				"Close": function()
				{
					$("#dialog3").dialog("close");
				}
			}
		});
	});
</script>
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="css/jquery.handsontable.full.css">
<?php
// get jenis barang
/*$query_jbarang = "select kode, jenis from jenisbarang order by jenis";
$jbarang       = $mysqli->query($query_jbarang);
$row_jbarang   = mysqli_fetch_assoc($jbarang);
$total_jbarang = mysqli_num_rows($jbarang);*/
if($klas <>'importcsv') { 
?>

<?php }else { ?>
<?php
if(isset($_POST['import'])) {  ?>
<?php } ?>
<h1 style="margin-top:-30px;">Input Barang Baru</h1> 
<?php } ?>

<?php
	
?>

<form method="post" id="formTipe">
	Tipe : 
    <select name="tipe" id="tipe" onchange="document.forms['formTipe'].submit();">
        <option value="1" <?php echo ($tipe == 1) ? 'selected' : '' ?>>Frame</option>
        <option value="2" <?php echo ($tipe == 2) ? 'selected' : '' ?>>Softlens</option>
		<option value="3" <?php echo ($tipe == 3) ? 'selected' : '' ?>>Lensa</option>
        <option value="4" <?php echo ($tipe == 4) ? 'selected' : '' ?>>Accessories</option>
    </select>
</form>

<ul style="color:red">
    <li><em>Isilah data sesuai dengan kolom yang disediakan</em></li>
    <li><em>Pastikan setelah pengisian di cek terlebih dahulu baru kemudian menekan tombol save</em></li>
	<li><em>Apabila sudah terlanjur mengisi brand/supplier kemudian ingin melakukan pembatalan maka dapat dilakukan dengan cara : <br />menekan tombol mouse sebelah kanan pada baris yang ingin dihapus kemudian pilih 'remove row'</em></li>
</ul>

<div id="example"></div>

<br />
<input type="password" id="textPasswordSave" placeholder="Password Save" size="15" />
<input type="button" id="save" value="Save" />
<!--
<input type="button" onclick="printInvoice();" value="Print Barcode" />
<input type="button" onclick="printInvoice2();" value="Print No Barcode" />
-->

<div id="dialog3">
	<h2>Apakah ingin melakukan Print Label ?</h2>
</div>

<script data-jsfiddle="example">
	var data = [
		[" ", "", "", "", "", , , , "", "", "", "", ""]
  		];
	
	var row_header = [
		["Kode", "Brand Frame", "Nama Product", "Frame", "Color", "Qty", "Harga Beli", "Harga Jual", "Kode Harga", "Supplier", "Tanggal Masuk"],
		["Kode", "Brand Softlens", "Nama Product", "Expiry Date", "Minus", "Color", "Qty", "Harga Beli", "Harga Jual", "Kode Harga", "Supplier", "Tanggal Masuk"],
		["Kode", "Brand Lensa", "Nama Product", "Minus", "Silinder", "Qty", "Harga Beli", "Harga Jual", "Kode Harga", "Supplier", "Tanggal Masuk"],
		["Kode", "Brand Acc", "Nama Product", "Qty", "Harga Beli", "Harga Jual", "Kode Harga", "Supplier", "Tanggal Masuk"]
		];

	$('#example').handsontable(
	{
		data: data,
		minSpareRows: 15,
		rowHeaders: true,
		colHeaders: row_header[<?=$tipe-1?>],
		contextMenu: true,
		columns:
		[
			<?php
				switch ($tipe)
				{
					case '1':
						?>
							{},
							{
								//brand
								type: 'autocomplete',
								source: [<?=$listBrand?>],
								strict: true,
								allowInvalid: false,
								colWidths: 150
							},
							{},
							{
								//frame
								type: 'autocomplete',
								source: [<?=$listFrame?>],
								strict: false,
								colWidths: 130
							},
							{
								//color
								type: 'autocomplete',
								source: [<?=$listColor?>],
								strict: false,
								colWidths: 100
							},
							
						<?php
					break;
					
					case '2':
						?>
							{},
							{
								//brand
								type: 'autocomplete',
								source: [<?=$listBrand?>],
								strict: true,
								allowInvalid: false,
								colWidths: 150
							},
							{
								//tipe softlens
							},
							{
								//expiry date
								type: 'date',
								dateFormat: 'yy-mm-dd'
							},
							{
								//minus
							},
							{
								//color
								type: 'autocomplete',
								source: [<?=$listColorSoftlens?>],
								strict: false,
								colWidths: 100
							},
						<?php
					break;
					
					case '3':
						?>
							{},
							{
								//brand
								type: 'autocomplete',
								source: [<?=$listBrand?>],
								strict: true,
								allowInvalid: false,
								colWidths: 150
							},
							{
								//tipe lensa
							},
							{
								//minus
							},
							{
								//silinder
							},
						<?php
					break;
					
					case '4':
						?>
							{},
							{
								//brand
								type: 'autocomplete',
								source: [<?=$listBrand?>],
								strict: true,
								allowInvalid: false,
								colWidths: 150
							},
							{
								//tipe acc
							},
						<?php
					break;
				}
			?>
			
			{
				//qty
			},
			{
				type: 'numeric',
				format: '0,0'
			},
			{
				type: 'numeric',
				format: '0,0'
			},
			{},
			{
				//supplier
				type: 'autocomplete',
				source: [<?=$listContact?>],
				strict: true,
				allowInvalid: false,
				colWidths: 150
			},
			{
				type: 'date',
      			dateFormat: 'yy-mm-dd'
			}
		],
		afterChange: function(change, source)
		{
			if (source === 'loadData')
			{
				return; //don't save this change
			}
			
			var hot = $('#example').data('handsontable');
			
			if (change[0][1] == 1)
			{
				$.ajax(
				{
					url: 'component/masterbarang/task/ajax_handsontable.php',
					data: {"data": hot.getDataAtCell(change[0][0], change[0][1]), "method":"get_supplier"},
					type: 'POST',
					error: function(e)
					{
					},
					beforeSend: function()
					{
					},
					success: function(response)
					{
						var col = 
						<?php
							if ($tipe == 1) echo "9";
							else if ($tipe == 2) echo "10";
							else if ($tipe == 3) echo "9";
							else if ($tipe == 4) echo "7";
						?>;
						hot.setDataAtCell(change[0][0], col, response);
					},
					complete: function()
					{
					}
				});
			}
			
		}
  	});
	
	$("#save").click(function()
	{
		if ($("#textPasswordSave").val() == "")
		{
			alert("Password Save harus diisi");
		}
		else if ($("#textPasswordSave").val() != "123456")
		{
			alert("Password Save Salah");
		}
		else
		{
			$.ajax(
			{
				url: "component/masterbarang/task/save_handsontable.php",
				data: {"data": $("#example").data('handsontable').getData(), "tipe":<?=$tipe?>},
				dataType: 'json',
				type: 'POST',
				success: function (res)
				{
					alert(res);
					openDialogPrintInvoice();
					//window.location = "<?=$base_url?>index-c-masterbarang.pos";
				}
			});
		}	
	});
</script>