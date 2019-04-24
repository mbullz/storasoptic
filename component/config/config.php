<?php
	global $mysqli;
?>

<h1>Toko</h1>

<form name="global_discount" method="POST" action="component/config/p_config.php?p=global_discount">
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
					?>
						<tr>
							<td><?=$data['kontak']?></td>
							<td>:</td>
							<td>
								<input type="number" name="<?=$data['user_id']?>" />
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
