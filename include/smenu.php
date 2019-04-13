<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/jquery.js"></script>-->
<script>
$(document).ready(function(){
  $("#cmd-<?php echo str_replace(".","",$row_data['nik']);?>").click(function(){
	$("#m-shortcut<?php echo str_replace(".","",$row_data['nik']);?>").toggle(1000);
  });
});
</script>
<div id="box-shortcut">
	<a href="javascript:void(0);" id="cmd-<?php echo str_replace(".","",$row_data['nik']);?>"><img src="images/invoices.png" hspace="6" border="0" align="left" />[ S ] Menu</a>
    <div id="m-shortcut<?php echo str_replace(".","",$row_data['nik']);?>" style="display:none;">
    <?php if($ak=='1') { ?>
   	<?php if(strstr($_SESSION['akses'],'add_keluarga')) { ?>
    <a href="index.php?component=keluarga&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Keluarga</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_pendidikan')) { ?>
    <a href="index.php?component=pendidikan&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Pendidikan</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_absensi')) { ?>
    <a href="index.php?component=absensi&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Absensi</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_kontrak')) { ?>
    <a href="index.php?component=kontrak&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Karir</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_cutikaryawan')) { ?>
    <a href="index.php?component=cutikaryawan&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Cuti</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_tugas')) { ?>
    <a href="index.php?component=tugas&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Tugas</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_kmedis')) { ?>
    <a href="index.php?component=kmedis&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />K-Medis</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_lembur')) { ?>
    <a href="index.php?component=lembur&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Lembur</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_penghargaan')) { ?>
    <a href="index.php?component=penghargaan&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Penghargaan</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_peringatan')) { ?>
    <a href="index.php?component=peringatan&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Peringatan</a><br />
    <?php } ?>
    <?php if(strstr($_SESSION['akses'],'add_resign')) { ?>
    <a href="index.php?component=resign&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Berhenti</a>
    <?php } ?>
    <?php }else{ ?>
    <?php if(strstr($_SESSION['akses'],'add_kontrak')) { ?>
    <a href="index.php?component=kontrak&task=add&nik=<?php echo $row_data['nik'];?>"><img src="images/add.png" hspace="6" border="0" />Re Hired</a><br />
    <?php } ?>
    <?php } ?>
</div>
</div>