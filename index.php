<?php
session_start();

if (!isset($_SESSION['akses'])) $_SESSION['akses'] = '';

$_SESSION['is_logged_in'] = $_SESSION['is_logged_in'] ?? false;
$_SESSION['is_admin'] = $_SESSION['is_admin'] ?? false;

require('include/config_db.php');

require('include/define.php');
include('include/function.php');

  $branch_id = $_SESSION['branch_id'] ?? 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $GLOBALS['company_name']; ?></title>
	
<link rel="shortcut icon" href="images/favicon.png" />

<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css" />
<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />

<?php include('include/menu_js.php');?>

<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />

<link href="css/style.css" rel="stylesheet" type="text/css" />

<style type="text/css" media="print">
  
  .hide,#topnav,#logo_container,#navigation,#footer, .notesetting {
	display:none;	
  }

  body {
	background:none;	
  }

</style>

  <!--
	
	<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
	<script type="text/javascript" src="js/greybox.js"></script>
	<script type="text/javascript" src="js/jquery.cluetip.js"></script>
	<script type="text/javascript" src="js/demo.js"></script>
	<script type="text/javascript" src="js/ajax_data.js"></script>
	<script type="text/javascript" src="js/jquery.calculator.js"></script>
  -->

  <script type="text/javascript" language="javascript" src="js/jquery-3.4.0.min.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery-ui.min.js"></script>

  <script type="text/javascript" language="javascript" src="assets/DataTables/datatables.min.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.tooltipster.min.js"></script>

  <script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>

  <script type="text/javascript" language="javascript">

  //Jquery Mask Input IP Address
   jQuery(function($){
	  /*$("#ip").mask("999.99.999.999 / 999.99.999.999");
	$(".jam").mask("99:99");
	$(".thn").mask("9999");
	$(".tgl").mask("9999-99-99");*/
   });
   //Jquery Calendar Input
   $(function(){
		$('.calendar').datepicker({
			appendText : "",
			dateFormat : 'yy-mm-dd'
		});
		$('.monthcalendar').datepicker({
			appendText : "",
			dateFormat : 'yy-mm'
		});
		//$('#basicCalculator').calculator({
		//showOn: 'both', buttonImageOnly: true, buttonImage: 'images/calculator.png'});
		// striped table
		$(".datatable tr:nth-child(even)").addClass("rowhighlight");
		$("form table tr:nth-child(even)").addClass("rowhighlight");
		//$('#alamat').wysiwyg();
		//$('#info').wysiwyg();
   });
   //Javascript Open Center Window
   var win = null;
   function NewWindow(mypage,myname,w,h,scroll){
   LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
   TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
   settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',menubar=yes';
   win = window.open(mypage,myname,settings)
  }
  //-------- Hide tooltips
  /*$(document).ready(function(){
	$("a.title").click(function(){
	$(".cluetip-default").hide(2000);
  });
  });*/
  //Hide Notification
  $(document).ready(function(){
  $(".close").click(function(){
	$("#notifyInbox").fadeTo("slow",0.00);
	});
  });
  //Check & Uncheck all
  function checkAll(field) {
	for (i = 0; i < field.length; i++)
	field[i].checked = true ;
  }

  function uncheckAll(field) {
	for (i = 0; i < field.length; i++)
	field[i].checked = false ;
  }

  function changeBranch(branch_id) {
    $.ajax({
      url: 'include/global_ajax.php',
      type: 'POST',
      dataType: 'json',
      data: 'mode=change_branch&branch_id=' + branch_id,
      success: function(result) {
      },
      complete: function() {
        location.reload();
      },
  });
  }
</script>

</head>

<body>

  <input type="hidden" id="base_url" value="<?=$base_url?>" />
  <input type="hidden" id="company_name" value="<?=$company_name?>" />

<div id="mynotes"><textarea id="mynotesbox" rows="15" cols="80">B-POS :: point of sales asli indonesia</textarea><br /><input type="button" value="Save" id="savenotes" /></div>
<div id="topnav">
  <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) { ?>
  <div id="welcome" style="margin-left: 50px;">
    Selamat Datang ,  <strong><a href="index-c-profile.pos"><?php echo $_SESSION['nama'];?></a></strong>
    [ <a href="logout.php" title="Logout">Logout</a> ]
    <?php if ($_SESSION['is_admin']): ?>
    <select id="branch_id" style="margin-left: 16px;" onchange="changeBranch(this.value)">
      <option value="0">ALL</option>
      <?php
        $rs = $mysqli->query("SELECT * FROM kontak WHERE jenis LIKE 'B001' ORDER BY kontak ASC");
        while ($data = $rs->fetch_assoc()) {
          ?>
            <option value="<?=$data['user_id']?>" 
            <?=($data['user_id'] == $_SESSION['branch_id'] ? 'selected="selected"' : '')?> >
              <?=$data['kontak']?>
            </option>
          <?php
        }
      ?>
    </select>
    <?php endif; ?>
  </div>
  <?php } ?>
  <div id="date">&nbsp;<?php //echo date("l, d M Y"); ?></div>
<div class="clear"></div>
</div>
<div id="logo_container"><a href="index.php" style="position:relative;top:22px;"><span style="font-size:36px; font-family:'Segoe UI'; font-weight:bold"><?php echo $GLOBALS['company_name']; ?></span></a></div>
<?php if(isset($_SESSION['i_sesadmin'])) { ?>
<div id="navigation">
  <ul>
  <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index.php">Home</a></li>
  <?php if(strstr($_SESSION['akses'],'user') OR strstr($_SESSION['akses'],'lokasigudang') OR strstr($_SESSION['akses'],'matauang') OR strstr($_SESSION['akses'],'cbayar') OR strstr($_SESSION['akses'],'satuan') OR strstr($_SESSION['akses'],'jenisbarang') OR strstr($_SESSION['akses'],'masterbarang') OR strstr($_SESSION['akses'],'targetpenjualan')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu11, '');" onmouseout="this.className='navbutton';delayhidemenu();">Gudang</li>
  <?php } ?>
   <?php if(strstr($_SESSION['akses'],'jeniskontak') OR strstr($_SESSION['akses'],'masterkontak')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu1, '');" onmouseout="this.className='navbutton';delayhidemenu();">Data Kontak</li>
  <?php } ?>
  <!--<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu4, '');" onmouseout="this.className='navbutton';delayhidemenu();">Hari ini</li>-->
  <?php if(strstr($_SESSION['akses'],'barangmasuk') OR strstr($_SESSION['akses'],'barangreturmasuk') OR strstr($_SESSION['akses'],'barangkeluar') OR strstr($_SESSION['akses'],'barangreturkeluar')) { ?>
  <!--<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu3, '');" onmouseout="this.className='navbutton';delayhidemenu();">Inventory</li>-->
  <?php } ?>
  <?php if(strstr($_SESSION['akses'],'invoicepembelian') OR strstr($_SESSION['akses'],'hutangjtempo') OR strstr($_SESSION['akses'],'pembayaranhutang') OR strstr($_SESSION['akses'],'add_invoicepembelian')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu4, '');" onmouseout="this.className='navbutton';delayhidemenu();">Pembelian</li>
  <?php } ?>
  <?php if(strstr($_SESSION['akses'],'invoicepenjualan') OR strstr($_SESSION['akses'],'piutangjtempo') OR strstr($_SESSION['akses'],'pembayaranpiutang') OR strstr($_SESSION['akses'],'add_invoicepenjualan')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu5, '');" onmouseout="this.className='navbutton';delayhidemenu();">Penjualan</li>
  <?php } ?>
  
  <?php if(strstr($_SESSION['akses'],'pembayaranhutang') OR strstr($_SESSION['akses'],'pembayaranpiutang') OR strstr($_SESSION['akses'],'biayaops')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Arus Kas</li>
  <?php } ?>
  <?php if(strstr($_SESSION['akses'],'user') OR strstr($_SESSION['akses'],'lokasigudang') OR strstr($_SESSION['akses'],'matauang') OR strstr($_SESSION['akses'],'cbayar') OR strstr($_SESSION['akses'],'satuan') OR strstr($_SESSION['akses'],'jenisbarang') OR strstr($_SESSION['akses'],'masterbarang') OR strstr($_SESSION['akses'],'targetpenjualan')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu2, '');" onmouseout="this.className='navbutton';delayhidemenu();">Pengaturan</li>
  <?php } ?>
  <?php /* if(strstr($_SESSION['akses'],'reportjualper_pm') OR strstr($_SESSION['akses'],'reportjualper_customer') OR strstr($_SESSION['akses'],'reportjualper_barang') OR strstr($_SESSION['akses'],'reportrugilaba')) { ?>
  <li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu6, '');" onmouseout="this.className='navbutton';delayhidemenu();">Laporan</li>
  <?php } */ ?>
   <!--<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Bantuan</li>-->
   <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index.php?component=copyright">Copyright</a></li>
  </ul>
</div>
<?php } ?>
<div id="content_container">
  <div id="content">
	<?php include 'include/breadcrumb.php'; ?>
	
	<?php 
		if($_SESSION['is_logged_in']) {
			if ($c == 'profile') {
				include('component/profile/profile.php');
			}
      else if ($c == 'config' && $_SESSION['is_admin']) {
        include('component/config/config.php');
      }
			else {
				getBody($_GET['component'] ?? '', $_GET['task'] ?? '', $_SESSION['i_sesadmin'] ?? '', $_SESSION['akses'] ?? '');
			}
		}
		else {
			if ($c == 'copyright') {
				include('component/copyright/copyright.php');
			}
			else {
				include('include/login.php');
			}	
		}
	?>

  </div>
  <div class="clear">&nbsp;</div>
</div>
<?php 
/*if(isset($_SESSION['i_sesadmin']) AND $_SESSION['i_sesadmin']<>'') { 
	include('include/notification_user.php');
}*/ ?>
<div id="footer">
  Copyright &copy; <a href="index.php?component=copyright">Imperium Technology</a>.  All Rights Reserved.
</div>
</body>

</html>