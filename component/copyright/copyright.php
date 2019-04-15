<h1>Point of Sales</h1>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
      	<td>
        	<div style="width:200px">
                <font style="font-size:16px"><center>Sales Representatives</center></font>
                <hr size="1" style="" color="#FF0000" />
           	</div>
            <br />
            <font style="font-size:12px" color="#666666">
                Robert
                <br />
                <img src="images/phone.png" height="32px" align="center" style="margin-top:5px" /> : 0818434216
                <br />
                <img src="images/email.png" height="32px" align="center" style="margin-top:5px" /> : m_bull_z@yahoo.com
            </font>
		</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="3%"></td>
      <td width="95%" align="right"><br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo $GLOBALS['company_name']; ?></td>
      <td width="2%">&nbsp;</td>
    </tr>
</table>

<br /><br /><br />
<br /><br /><br />
<br /><br /><br />

<?php
	if (isset($_POST['company_name']) && $_POST['company_name'] != '')
	{
		$mysqli->query("UPDATE config SET value = '$_POST[company_name]' WHERE config LIKE 'company_name'");
	}
	
	if (isset($_POST['company_address']) && $_POST['company_address'] != '')
	{
		$mysqli->query("UPDATE config SET value = '$_POST[company_address]' WHERE config LIKE 'company_address'");
	}
	
	if (isset($_POST['company_telephone']) && $_POST['company_telephone'] != '')
	{
		$mysqli->query("UPDATE config SET value = '$_POST[company_telephone]' WHERE config LIKE 'company_telephone'");
	}
	
	$rs = $mysqli->query("SELECT * FROM config");
	while ($data = mysqli_fetch_assoc($rs))
	{
		if ($data['config'] == 'company_name')
			$config_company_name = $data['value'];
		else if ($data['config'] == 'company_address')
			$config_company_address = $data['value'];
		else if ($data['config'] == 'company_telephone')
			$config_company_telephone = $data['value'];
	}
?>

<form name="form1" action="index.php?component=copyright" method="post">
<table border="1" cellspacing="0" cellpadding="5" bordercolor="#DDDDDD">
	<tr>
    	<td>
        	Company Name
        </td>
        
        <td>
        	:
        </td>
        
        <td>
        	<input type="text" name="company_name" size="50" value="<?=$config_company_name?>" />
        </td>
    </tr>
    
    <tr>
    	<td>
        	Company Address
        </td>
        
        <td>
        	:
        </td>
        
        <td>
        	<input type="text" name="company_address" size="50" value="<?=$config_company_address?>" />
        </td>
    </tr>
    
    <tr>
    	<td>
        	Company Telephone
        </td>
        
        <td>
        	:
        </td>
        
        <td>
        	<input type="text" name="company_telephone" size="50" value="<?=$config_company_telephone?>" />
        </td>
    </tr>
    
    <tr>
    	<td>
        	&nbsp;
        </td>
        
        <td>
        	&nbsp;
        </td>
        
        <td>
        	<input type="submit" value="Change" />
        </td>
    </tr>
</table>
</form>