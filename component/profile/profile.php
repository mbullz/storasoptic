<h1>Profile</h1>

<style type="text/css">
	.odd {
		background-color: #FFF;
	}

	.even {
		background-color: #F9F9F9;
	}
</style>

<form name="profile" method="POST" action="component/profile/p_profile.php?p=change_password">
	<table border="0" cellspacing="0" cellpadding="10" style="border: solid 1px #CCC;">
		<thead>
			<tr>
				<th colspan="3" align="center">
					<h1 style="margin: 5px;">Change Password</h1>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Current Password</td>
				<td>:</td>
				<td>
					<input type="password" name="currentPassword" />
				</td>
			</tr>

			<tr class="even">
				<td>New Password</td>
				<td>:</td>
				<td>
					<input type="password" name="newPassword" />
				</td>
			</tr>

			<tr>
				<td>Confirm Password</td>
				<td>:</td>
				<td>
					<input type="password" name="confirmPassword" />
				</td>
			</tr>

			<tr class="even">
				<td colspan="2">&nbsp;</td>
				<td>
					<input type="submit" value="Update" />
				</td>
			</tr>
		</tbody>
	</table>
</form>
