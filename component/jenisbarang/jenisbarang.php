<?php

global $mysqli;
include('include/define.php');

$tipe = $_POST['tipe'] ?? 1;
$font_color = "#660099";

$query_data  = "SELECT * FROM jenisbarang WHERE tipe = $tipe AND info NOT LIKE 'DELETED' ORDER BY jenis ASC ";

$data = $mysqli->query($query_data);

?>

<script type="text/javascript">
$(document).ready(function()
{
	$("#example").dataTable(
	{
		dom: 'B<"clear">lfrtip',
		tableTools:
		{
			"sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
		}
	});

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#formdata').submit(function() {
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
</script>

    <h1>Master Brand</h1>
    
	<?php if(strstr($_SESSION['akses'],"add_".$c)) { ?><a href="index-c-<?php echo $c;?>-t-add.pos"><img src="images/add.png" border="0"/>&nbsp;Tambah Data</a>
    <!--<a href="index-c-jenisbarang-t-add-k-importcsv.pos" title="Import CSV"><img src="images/_xls.png" width="20" height="20" border="0" align="right" /></a>-->
	<?php } ?>

    <div style="clear:both;margin-top:10px;">
        <form method="post" id="formTipe">
           	Tipe : 
            <select name="tipe" id="tipe" onchange="document.forms['formTipe'].submit();">
                <option value="1" <?php echo ($tipe == 1) ? 'selected' : '' ?>>Frame</option>
                <option value="2" <?php echo ($tipe == 2) ? 'selected' : '' ?>>Softlens</option>
                <option value="3" <?php echo ($tipe == 3) ? 'selected' : '' ?>>Lensa</option>
                <option value="4" <?php echo ($tipe == 4) ? 'selected' : '' ?>>Accessories</option>
            </select>
        </form>
    </div>

    <br />

	<table id="example" class="display" cellspacing="0" cellpadding="0" width="100%">
		<thead> 
      <tr>
        <th width="20%" align="center" style="color: <?=$font_color?>;">BRAND</th>
        <th align="center" style="color: <?=$font_color?>;">SUPPLIER</th>
        <th align="center" style="color: <?=$font_color?>;">TIPE</th>
        <th width="8%" align="center" style="color: <?=$font_color?>;"></th>
      </tr>
		</thead>
        
        <tbody>
      <?php $no=0; 
	  while ($row_data = mysqli_fetch_assoc($data)) { ?>
      <tr valign="top">
        <td align="left"><?php echo $row_data['jenis'];?></td>
        <td align="left"><?php echo $row_data['info'];?></td>
        <td align="center">
			<?php
				switch ($row_data['tipe'])
				{
					case '1':
						echo "Frame";
					break;
					
					case '2':
						echo "Softlens";
					break;
					
					case '3':
						echo "Lensa";
					break;
					
					case '4':
						echo "Accessories";
					break;
				}
			?>
		</td>
        <td align="center">
        	<?php if(strstr($_SESSION['akses'],"edit_".$c)) : ?>
        		<a href="index-c-<?=$c?>-t-add-<?=$row_data['brand_id']?>.pos" title="Edit Data"><img src="images/edit_icon.png" border="0" width="16px" height="16px" /></a>
        	<?php endif; ?>
        	&nbsp;
        	<?php if(strstr($_SESSION['akses'],"delete_".$c)) : ?>
          		<img src="images/delete_icon.png" title="Delete Data" border="0" width="16px" height="16px" style="cursor: pointer;" />
      		<?php endif; ?>
        </td>
        </tr>
      <?php } ?>
		</tbody>
	</table>
