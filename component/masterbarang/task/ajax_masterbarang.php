<?php
session_start();
include('../../../include/config_db.php');
$mode = $_GET['mode'];
$query = '';
$arr = array();

switch($mode) {
    case 'get_jenis':
        $tipe = $mysqli->real_escape_string($_GET['tipe']);
        $query = "SELECT * FROM jenisbarang WHERE tipe = $tipe AND info != 'DELETED' ORDER BY jenis ASC";
        $res = $mysqli->query($query);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, array(
                'brand_id'  => $row['brand_id'], 
                'jenis'     => $row['jenis'],
            ));
        }
        echo json_encode($arr);
        break;
    case 'get_jenis_frame':
        $tipe = $mysqli->real_escape_string($_GET['tipe']);
        $query = "SELECT * FROM frame_type ORDER BY frame ASC";
        $res = $mysqli->query($query);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, array('frame' => $row['frame']));
        }
        echo json_encode($arr);
        break;
    case 'get_barang':
        $tipe = $mysqli->real_escape_string($_GET['tipe']);
        $query = "select a.*, b.jenis as type_brand, b.info as supplier from barang a join jenisbarang b on a.brand_id=b.brand_id where qty > 0 and b.tipe=$tipe";
        $res = $mysqli->query($query);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, 
                array(
					'product_id' => $row['product_id'],
                    'kode' => $row['kode'], 
                    'jenis' => $row['jenis'],
                    'barang' => $row['barang'],
                    'frame' => $row['frame'],
                    'color' => $row['color'],
                    'info' => $row['info'],
                    'ukuran' => $row['ukuran'],
                    'type_brand' => $row['type_brand'],
                    'supplier' => $row['supplier']
                )
            );
        }
        echo json_encode($arr);
        break;
    case 'get_detail':
        $product_id = $_GET['product_id'];
        $query = "select * from barang where qty > 0 and product_id=$product_id";
        $res = $mysqli->query($query);
        $row = mysqli_fetch_assoc($res);
        array_push($arr, array(
			'product_id' 	=> $row['product_id'],
            'kode'      	=> $row['kode'],
            'brand_id'		=> $row['brand_id'],
            'barang'    	=> $row['barang'],
            'frame'     	=> $row['frame'],
            'color'     	=> $row['color'],
            'info'      	=> $row['info'],
            'ukuran'    	=> $row['ukuran'],
            'tipe'      	=> $row['tipe'],
			'price'			=> $row['price'],
			'price2'		=> $row['price2']
        ));
        echo json_encode($arr);
        break;

    case 'get_detail_lensa':
        $kode = $_GET['kode'];
        $jenis = $_GET['jenis'];
        $barang = $_GET['barang'];
        $rSph = $_GET['rSph'];
        $rCyl = $_GET['rCyl'];
        $lSph = $_GET['lSph'];
        $lCyl = $_GET['lCyl'];
        
        $query = "SELECT * 
            FROM barang a 
            JOIN jenisbarang b ON a.brand_id = b.brand_id 
            WHERE a.kode = '$kode' 
            AND b.jenis = '$jenis' 
            AND a.barang = '$barang' 
            AND a.frame = '$rSph' 
            AND a.color = '$rCyl' 
            AND a.tipe = 3 
            AND a.branch_id = $_SESSION[branch_id] ";
        $res = $mysqli->query($query);
        if ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, array(
                'product_id'    => $row['product_id'],
                'kode'          => $row['kode'],
                'brand_id'      => $row['brand_id'],
                'barang'        => $row['barang'],
                'frame'         => $row['frame'],
                'color'         => $row['color'],
                'qty'           => $row['qty'],
                'tipe'          => $row['tipe'],
                'price'         => $row['price'],
                'price2'        => $row['price2'],
            ));
        }
        
        echo json_encode($arr);
        break;
}

//echo json_encode($result);