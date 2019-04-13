<?php
	session_start();
?>

<style>
	@font-face
	{
		font-family: 'fontBarcode';
		src: url('../css/fonts/3OF9_NEW.TTF');
	}
</style>

<table id="container" border="0" width="100%" cellspacing="2" cellpadding="0">
</table>

<script language="javascript" type="text/javascript">
	var data = sessionStorage.getItem('data').split(',');
	var company_name = sessionStorage.getItem('company_name');
	var html = "";
	var tr = 0;
	
	for (i=0;i<data.length;i++)
	{	
		if (tr == 0) html += "<tr>";
		
		if (i % 12 == 0)
		{
			tr++;
			
			if (data[i+1] != "" && data[i+1] != " ")
			{
				html += "<td width='20%' align='center' style='font-size:10px'>" + company_name + "<br>" + data[i+1] + "<br>" + data[i+2] + "<br>" + data[i+7] + " / " + data[i+8] + "</td>";
			}
			else html += "<td>&nbsp;</td>";
		}
		
		if (tr == 5)
		{
			html += "</tr>";
			tr = 0;
		}
	}
	
	document.getElementById('container').innerHTML = html;
</script>