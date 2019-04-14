<?php
    $current = 'home';
    if (!empty($t) && isset($t)) { $current = $t; }
    else if (!empty($c) && isset($c)) { $current = $c; }
    else { $current = 'home'; }
?>
<div>
    <?php if ($current == 'home') { ?>
    <?php echo $menu['home'][0]; ?>
    <?php } else { ?>
    <a href="<?=$base_url?>index.php"><?php echo $menu['home'][0]; ?></a>
    <?php } ?>
    
    <?php if (!empty($c) && isset($c)) { ?>
        <?php if ($current == $c) { ?>
        &gt; <?php echo $menu[$c][0]; ?>
        <?php } else { ?>
        &gt; <a href="<?=$base_url?>index-c-<?php echo $c; ?>-k-<?php echo $klas; ?>-q-.pos"><?php echo $menu[$c][0]; ?></a>
        <?php } ?>
    <?php } ?>
    
    <?php if (!empty($t) && isset($t)) { ?>
        &gt; <?php echo $menu[$c][$t]; ?>
    <?php } else if (!empty($_GET['task']) && isset($_GET['task'])) { ?>
		&gt; <?php echo $menu[$c][$_GET['task']]; ?>
	<?php } ?>
</div>