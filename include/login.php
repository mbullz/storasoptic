<style type="text/css">
<!--
body, td, th {
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333;
}
body {
	background-color: #FFF;
	margin: 0;
}
a, a:visited {
	color: #000066;
	text-decoration: underline;
}
a:hover {
	text-decoration: none;
}
form {
	margin: 0;
	padding: 0;
}
input, select, textarea {
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	font-size: 11px;
	padding: 3px;
}
#login_container {
	color: #333;
	background-color: #FFF;
	text-align: left;
	width: 330px;
	padding: 1px;
	margin: 20px auto 10px auto;
	border: 1px solid #CCCCCC;
}
#logo {
	text-align: center;
	margin: 0;
	padding: 50px 0 0 0;
}
#login_container #login {
	background-color: #EFEFEF;
	text-align: left;
	margin: 0;
	padding: 10px;
}
#login_container #login_failed {
    background-color: #FCF9D2;
    text-align: center;
    padding: 10px;
    margin: 0 0 1px 0;
}
#login_container #extra_info {
	background-color: #CCC;
	text-align: left;
	padding: 10px;
	margin: 1px 0 0 0;
}
-->
</style>
<script language="javascript">
function sf(){ document.frmlogin.username.focus(); }
</script>
<script type="text/javascript">
	function checkTime(i)
		{
			if (i<10)
		  	{
		  		i="0" + i;
		  	}
			return i;
		}
		
	function startTime() {
		var today=new Date();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		// add a zero in front of numbers<10
		m=checkTime(m);
		s=checkTime(s);
		if(h < 10) {
			gh = "0" + h;	
		}else{
			gh = h;	
		}
		if(m < 10) {
			if(m > 0) {
			gm = "0" + m;
			}else{
				gm = m;
			}
		}else{
			gm = m;	
		}
		document.getElementById('jam').value = gh+":"+m+":"+s;
		t=setTimeout('startTime()',500);
		}
	
$(document).ready(function() {
	
	startTime();

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
	});

	$('#frmlogin').submit(function() {
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
<div id="loading" style="display:none;"><img src="images/loading.gif" alt="loading..." /></div>
<div id="result" style="display:none;"></div>
<div id="login_container">
  <div id="login">
    <form action="include/p_login.php" method="post" name="frmlogin" id="frmlogin">
      <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tbody>
          <tr>
            <td valign="middle" align="right"><strong>Waktu</strong></td>
            <td valign="middle" align="left"><label>
              <input name="jam" type="text" id="jam" size="8" maxlength="5" value="" style="border:none;background:#EFEFEF;text-align:center;">
            </label></td>
          </tr>
          <tr>
          <td valign="middle" width="30%" align="right"><strong>Username</strong></td>
          <td valign="middle" align="left"><input name="username" size="30" type="text" value=""></td>
        </tr>
        <tr>
          <td valign="middle" width="30%" align="right"><strong>Password</strong></td>
          <td valign="middle" align="left"><input name="password" size="30" type="password" value=""></td>
        </tr>
        <!--<tr>
          <td valign="middle" align="right">&nbsp;</td>
          <td valign="middle" align="left"><label>
            <input type="radio" name="abslog" value="1" id="abslog_0" onclick="if(this.checked) { this.form.submit.value='Absen'; }else{ this.form.submit.value='Login'; }" checked="checked"/>
            Absensi</label>
            <label>
              <input type="radio" name="abslog" value="2" id="abslog_1" onclick="if(this.checked) { this.form.submit.value='Login'; }else{ this.form.submit.value='Absen'; }"/>
            Login</label></td>
        </tr>-->
        <tr>
          <td valign="middle" width="30%" align="right">&nbsp;</td>
          <td valign="middle" align="left"><input value="Login" class="button" type="submit" name="submit">
            <input name="component" type="hidden" id="component" value="<?php echo $_GET['component'];?>" />
            <input name="task" type="hidden" id="task" value="<?php echo $_GET['task'];?>" /></td>
        </tr>
      </tbody></table>
    </form>
  </div>
  <div id="extra_info">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tbody><tr>
        <td valign="middle" align="left">IP Logged: <strong><?php echo $_SERVER['REMOTE_ADDR'];?></strong></td>
        <td valign="middle" align="right">Powered by <a href="index.php?component=copyright"><?php echo $GLOBALS['company_name']; ?></a></td>
      </tr>
    </tbody></table>
  </div>
</div>
<!--<div align="center"><a href="http://demo.whmcs.com/admin/login.php?action=remind">Forgot your password?</a></div>-->