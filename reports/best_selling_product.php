<?php

session_start();

require "../include/config_db.php";
require "../include/function.php";

$start = $_GET['start'];
$end = $_GET['end'];
$tipe = $_GET['tipe'];
$limit =  $_GET['limit'];

$branch_id = $_SESSION['branch_id'] ?? 0;

$branch_filter = '';
if ($branch_id != 0) {
	$branch_filter = " AND a.branch_id = $branch_id ";
}

switch ($tipe) {
    case '1':
        $tipeName = 'Frame';
        $tipeQuery = '( b.tipe = 1 OR b.tipe = 5 )';
    break;

    case '2':
        $tipeName = 'Softlens';
        $tipeQuery = 'b.tipe = 2';
    break;

    case '3':
        $tipeName = 'Lensa';
        $tipeQuery = '( b.tipe = 3 OR b.tipe = 5 )';
    break;

    case '4':
        $tipeName = 'Accessories';
        $tipeQuery = 'b.tipe = 4';
    break;
}

if ($tipe == '3')
{
    $query = "SELECT c.kode, c.barang, c.frame, c.color, c.power_add, c.ukuran, 
                d.jenis AS brand_name, 
                SUM(b.qty) AS sold, SUM(c.qty) AS stock 
            FROM keluarbarang a 
            JOIN dkeluarbarang b ON a.keluarbarang_id = b.keluarbarang_id 
            JOIN barang c ON b.lensa = c.product_id 
            JOIN jenisbarang d ON c.brand_id = d.brand_id 
            WHERE a.referensi != '' 
            AND a.tgl BETWEEN '$start' AND '$end' 
            AND $tipeQuery 
            $branch_filter 
            GROUP BY kode, barang, frame, color, power_add, ukuran, brand_name 
            ORDER BY sold DESC 
            LIMIT 0,$limit ";
}
else {
    $query = "SELECT c.kode, c.barang, c.frame, c.color, c.power_add, c.ukuran, 
                d.jenis AS brand_name, 
                SUM(b.qty) AS sold, SUM(c.qty) AS stock 
            FROM keluarbarang a 
            JOIN dkeluarbarang b ON a.keluarbarang_id = b.keluarbarang_id 
            JOIN barang c ON b.product_id = c.product_id 
            JOIN jenisbarang d ON c.brand_id = d.brand_id 
            WHERE a.referensi != '' 
            AND a.tgl BETWEEN '$start' AND '$end' 
            AND $tipeQuery 
            $branch_filter 
            GROUP BY kode, barang, frame, color, power_add, ukuran, brand_name 
            ORDER BY sold DESC 
            LIMIT 0,$limit ";
}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha512-rO2SXEKBSICa/AfyhEK5ZqWFCOok1rcgPYfGOqtX35OyiraBg6Xa4NnBJwXgpIRoXeWjcAmcQniMhp22htDc6g==" crossorigin="anonymous" />

		<title>Produk Terlaris</title>

		<style type="text/css">
			table {
				font-size: 10px;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<h4 class="text-center mt-3">
				<font color="#2B9FDC"><?=$limit?> <?=$tipeName?> Terlaris</font>
            </h4>
            <div class="text-center text-muted"><?=$start?> s/d <?=$end?></div>

			<table class="table table-hover table-sm table-responsive mt-4">
				<thead>
					<tr>
						<th scope="col" class="text-nowrap align-middle">No.</th>
						<th scope="col" class="text-nowrap align-middle">Brand</th>
						<th scope="col" class="text-nowrap align-middle">Kode</th>
                        <th scope="col" class="text-nowrap align-middle">Produk</th>
                        <?php
                            if ($tipe == '1') {
                                ?>
                                    <th scope="col" class="text-center text-nowrap align-middle">Frame</th>
                                    <th scope="col" class="text-center text-nowrap align-middle">Color</th>
                                <?php
                            }
                            else if ($tipe == '2') {
                                ?>
                                    <th scope="col" class="text-center text-nowrap align-middle">Minus</th>
                                    <th scope="col" class="text-center text-nowrap align-middle">Color</th>
                                    <th scope="col" class="text-center text-nowrap align-middle">Expiry Date</th>
                                <?php
                            }
                            else if ($tipe == '3') {
                                ?>
                                    <th scope="col" class="text-center text-nowrap align-middle">SPH</th>
                                    <th scope="col" class="text-center text-nowrap align-middle">CYL</th>
                                    <th scope="col" class="text-center text-nowrap align-middle">ADD</th>
                                <?php
                            }
                        ?>
                        <th scope="col" class="text-center text-nowrap align-middle">Penjualan (Pcs)</th>
					</tr>
				</thead>

				<tbody>
                    <?php
                        $rs = $mysqli->query($query);
                        
                        $i = 0;
                        while ($data = $rs->fetch_assoc()) {
                            $i++;
                            ?>
                                <tr>
                                    <td scope="row" class=""><?=$i?></td>
                                    <td class=""><?=$data['brand_name']?></td>
                                    <td class=""><?=$data['kode']?></td>
                                    <td class=""><?=$data['barang']?></td>
                                    <?php
                                        if ($tipe == '1') {
                                            ?>
                                                <td class="text-center"><?=$data['frame']?></td>
                                                <td class="text-center"><?=$data['color']?></td>
                                            <?php
                                        }
                                        else if ($tipe == '2') {
                                            ?>
                                                <td class="text-center"><?=$data['frame']?></td>
                                                <td class="text-center"><?=$data['color']?></td>
                                                <td class="text-center"><?=$data['ukuran']?></td>
                                            <?php
                                        }
                                        else if ($tipe == '3') {
                                            ?>
                                                <td class="text-center"><?=$data['frame']?></td>
                                                <td class="text-center"><?=$data['color']?></td>
                                                <td class="text-center"><?=$data['power_add']?></td>
                                            <?php
                                        }
                                    ?>
                                    <td class="text-center"><?=$data['sold']?></td>
                                </tr>
                            <?php
                        }
                    ?>
				</tbody>
            </table>

		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js" integrity="sha512-ubuT8Z88WxezgSqf3RLuNi5lmjstiJcyezx34yIU2gAHonIi27Na7atqzUZCOoY4CExaoFumzOsFQ2Ch+I/HCw==" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha512-I5TkutApDjnWuX+smLIPZNhw+LhTd8WrQhdCKsxCFRSvhFx2km8ZfEpNIhF9nq04msHhOkE8BMOBj5QE07yhMA==" crossorigin="anonymous"></script>

	</body>
</html>
