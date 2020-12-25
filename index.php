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

<!doctype html>
<html lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $GLOBALS['company_name']; ?></title>
	
	<link rel="shortcut icon" href="images/favicon.png" />

	<!--
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.structure.min.css" integrity="sha512-oM24YOsgj1yCDHwW895ZtK7zoDQgscnwkCLXcPUNsTRwoW1T1nDIuwkZq/O6oLYjpuz4DfEDr02Pguu68r4/3w==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.theme.min.css" integrity="sha512-9h7XRlUeUwcHUf9bNiWSTO9ovOWFELxTlViP801e5BbwNJ5ir9ua6L20tEroWZdm+HFBAWBLx2qH4l4QHHlRyg==" crossorigin="anonymous" />
	<!--
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css" integrity="sha512-1k7mWiTNoyx2XtmI96o+hdjP8nn0f3Z2N4oF/9ZZRgijyV4omsKOXEnqL1gKQNPy2MTSP9rIEWGcH/CInulptA==" crossorigin="anonymous" />
	-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/css/tooltipster.min.css" integrity="sha512-awOgwBW6XldbPsuzBfoPhbi48OkYKn+TmMVwqD75MPrWnLvA6LN98sWdE4Jl17G4FHIyp8k/jFM9tfiGE8qFyw==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

	<link href="css/style.css" rel="stylesheet" type="text/css" />

	<?php include('include/menu_js.php');?>

<?php if (!$_SESSION['is_logged_in'] || $c != 'presence'): ?>
<style>
	body {
		background: url("images/body_top_bg.gif") repeat-x;
	}
</style>
<?php endif; ?>

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

	<!--
	<script type="text/javascript" language="javascript" src="js/jquery-3.4.0.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" language="javascript" src="assets/DataTables/datatables.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.tooltipster.min.js"></script>
	<script type="text/javascript" language="javascript" src="js/bootstrap.min.js"></script>
	-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
	<!--
	<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>
	-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/js/jquery.tooltipster.min.js" integrity="sha512-vgY1+uleaxFEkXfUFLiXB5udry+v5uCvFeuqUn4CUkWbAtUl5TqAyDu4XhdATzdJ7CbXxbonHS8UWsEc0D8TDw==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

	<!-- datatables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-html5-1.6.3/b-print-1.6.3/datatables.min.css"/>
 
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.21/b-1.6.3/b-html5-1.6.3/b-print-1.6.3/datatables.min.js"></script>

	<script type="text/javascript" language="javascript">

		function nl2br(str, is_xhtml) {
			var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
			return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
		}

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

<!--
<div id="mynotes">
	<textarea id="mynotesbox" rows="15" cols="80">B-POS :: point of sales asli indonesia</textarea><br />
	<input type="button" value="Save" id="savenotes" />
</div>
-->

<?php if (!$_SESSION['is_logged_in'] || $c != 'presence'): ?>
	<div id="topnav">
		<?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) { ?>
			<div id="welcome" style="margin-left: 50px;">
				Selamat Datang ,  <strong><a href="index-c-profile.pos"><?php echo $_SESSION['nama'];?></a></strong>
				[ <a href="logout.php" title="Logout">Logout</a> ]
				<?php if ($_SESSION['is_admin'] || $_SESSION['role'] == 'Co-Administrator'): ?>
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

	<div id="logo_container">
		<a href="index.php" style="position:relative;top:22px;">
			<span style="font-size:36px; font-family:'Segoe UI'; font-weight:bold">
				<img src="images/itc-optik.png" height="64px" />
				<?php echo $GLOBALS['company_name']; ?>
			</span>
		</a>
	</div>
<?php endif; ?>

<?php if(isset($_SESSION['i_sesadmin']) && $c != 'presence') { ?>
	<div id="navigation">
		<ul>
		<li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index.php">Home</a></li>
		
		<?php if( strstr($_SESSION['akses'],'lokasigudang') OR strstr($_SESSION['akses'],'jenisbarang') OR strstr($_SESSION['akses'],'masterbarang') ) { ?>
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

		<?php if(strstr($_SESSION['akses'],',invoicepenjualan,') OR strstr($_SESSION['akses'],'piutangjtempo') OR strstr($_SESSION['akses'],'pembayaranpiutang') OR strstr($_SESSION['akses'],'specialorder') OR strstr($_SESSION['akses'],'penjualanorder') OR strstr($_SESSION['akses'],'add_invoicepenjualan')) { ?>
		<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu5, '');" onmouseout="this.className='navbutton';delayhidemenu();">Penjualan</li>
		<?php } ?>
		
		<?php if( strstr($_SESSION['akses'],'biayaops') ) { ?>
		<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Arus Kas</li>
		<?php } ?>

	<?php if (strstr($_SESSION['akses'], 'report_all')): ?>
		<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu13, '');" onmouseout="this.className='navbutton';delayhidemenu();">Laporan</li>
	<?php endif; ?>

		<?php /* if(strstr($_SESSION['akses'],'reportjualper_pm') OR strstr($_SESSION['akses'],'reportjualper_customer') OR strstr($_SESSION['akses'],'reportjualper_barang') OR strstr($_SESSION['akses'],'reportrugilaba')) { ?>
		<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu6, '');" onmouseout="this.className='navbutton';delayhidemenu();">Laporan</li>
		<?php } */ ?>
		 <!--<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu7, '');" onmouseout="this.className='navbutton';delayhidemenu();">Bantuan</li>-->

		 <?php if (strstr($_SESSION['akses'], 'kwitansi')): ?>
			<li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index-c-kwitansi.pos">Kwitansi</a></li>
		<?php endif; ?>

		 <?php if (strstr($_SESSION['akses'], 'presence')): ?>
			<li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index-c-presence.pos" target="_blank">Absensi</a></li>
		<?php endif; ?>

		<?php if(strstr($_SESSION['akses'],'user') OR strstr($_SESSION['akses'],'lokasigudang') OR strstr($_SESSION['akses'],'matauang') OR strstr($_SESSION['akses'],'cbayar') OR strstr($_SESSION['akses'],'satuan') OR strstr($_SESSION['akses'],'targetpenjualan')) { ?>
		<li class="navbutton" onmouseover="this.className='navbuttonover';dropdownmenu(this, event, menu2, '');" onmouseout="this.className='navbutton';delayhidemenu();">Pengaturan</li>
		<?php } ?>

		 <li class="navbutton" onmouseover="this.className='navbuttonover';" onmouseout="this.className='navbutton';"><a href="index.php?component=copyright">Copyright</a></li>
		</ul>
	</div>
<?php } ?>

<div id="content_container">
	<div id="content">
		<?php
			if ($_SESSION['is_logged_in'] && $c != 'presence')
				include 'include/breadcrumb.php';
		?>
		
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