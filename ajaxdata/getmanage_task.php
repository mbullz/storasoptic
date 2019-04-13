<table width="100%" border="0" cellpadding="2" cellspacing="0" id="t_task" class="datatable">
  <tr>
    <th width="10%">Date</th>
    <th width="25%">Aktivitas</th>
    <th width="12%">Waktu</th>
    <th>Info</th>
    <th width="8%">Status</th>
    <th width="10%">Manage</th>
    </tr>
  <?php if($total_task > 0) { do { ?>
  <tr valign="top">
    <td align="center"><?php genDate($row_task['tgl']);?></td>
    <td><?php echo $row_task['kegiatan'];?></td>
    <td align="center"><?php echo $row_task['mulai'];?> - <?php echo $row_task['sampai'];?></td>
    <td><?php echo $row_task['info'];?>&nbsp;</td>
    <td align="center"><img src="images/<?php echo $row_task['status'];?>.png" border="0" /></td>
    <td align="center"><a href="#" title="Edit Task"><img src="images/edit-icon.png" hspace="2" border="0" />Edit</a> <a href="#" title="Delete Task"><img src="images/close-icon.png" hspace="2" border="0" />Delete</a></td>
    </tr>
  <?php }while($row_task = mysqli_fetch_assoc($task)); } ?>
</table>