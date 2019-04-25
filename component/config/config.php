<?php
	global $mysqli;

	$rs = $mysqli->query("SELECT * FROM config WHERE config = 'global_discount'");
	$data = $rs->fetch_assoc();
	$temp = $data['value'];
	$temp = explode('#', $temp);
	foreach ($temp AS $r) {
		$r = explode('_', $r);
		if (sizeof($r) <= 1) continue;
		$global_discount[$r[0]] = $r[1];
	}
?>

<script type="text/javascript" language="javascript">
	$(function() {
		$('#form_global_discount').submit(function() {
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
	});
</script>

<div id="result" style="display: none;"></div>

<h1>Toko</h1>

<form name="form_global_discount" id="form_global_discount" method="POST" action="component/config/p_config.php?p=global_discount">
	<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
		<thead>
			<tr>
				<th colspan="3" align="center">
					<h1 style="margin: 5px;">Global Discount</h1>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$rs = $mysqli->query("SELECT * FROM kontak WHERE jenis = 'B001' ORDER BY kontak ASC");
				while ($data = $rs->fetch_assoc()) {
					$id = $data['user_id'];
					?>
						<tr>
							<td><?=$data['kontak']?></td>
							<td>:</td>
							<td>
								<input type="number" name="<?=$id?>" value="<?=($global_discount[$id] ?? 0)?>" />
							</td>
						</tr>
					<?php
				}
			?>

			<tr>
				<td colspan="2">&nbsp;</td>
				<td>
					<input type="submit" value="Update" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
