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

        $data = array();

        $data['product_id'] = 0;
        $data['kode'] = '';
        $data['brand_id'] = 0;
        $data['barang'] = '';
        $data['qtyL'] = 0;
        $data['qtyR'] = 0;
        $data['tipe'] = 3;
        $data['price'] = 0;
        $data['price2'] = 0;

        $query = "SELECT a.*, b.jenis 
            FROM barang a 
            JOIN jenisbarang b ON a.brand_id = b.brand_id 
            WHERE a.kode = '$kode' 
            AND b.jenis = '$jenis' 
            AND a.barang = '$barang' 
            AND a.tipe = 3 
            AND a.branch_id = $_SESSION[branch_id] ";
        $res = $mysqli->query($query);
        if ($row = mysqli_fetch_assoc($res)) {
            $data['product_id'] = $row['product_id'];
            $data['kode'] = $row['kode'];
            $data['brand_id'] = $row['brand_id'];
            $data['barang'] = $row['barang'];
            $data['tipe'] = 3;
            $data['price'] = $row['price'];
            $data['price2'] = $row['price2'];
        }
        
        $query = "SELECT a.*, b.jenis 
            FROM barang a 
            JOIN jenisbarang b ON a.brand_id = b.brand_id 
            WHERE a.kode = '$kode' 
            AND b.jenis = '$jenis' 
            AND a.barang = '$barang' 
            AND a.frame = '$lSph' 
            AND a.color = '$lCyl' 
            AND a.tipe = 3 
            AND a.branch_id = $_SESSION[branch_id] ";
        $res = $mysqli->query($query);
        if ($row = mysqli_fetch_assoc($res)) {
            $data['qtyL'] = $row['qty'];
        }

        $query = "SELECT a.*, b.jenis 
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
            $data['qtyR'] = $row['qty'];
        }

        array_push($arr, $data);
        
        echo json_encode($arr);
        break;

    case 'get_detail_softlens':
        $kode = $_GET['kode'];
        $jenis = $_GET['jenis'];
        $barang = $_GET['barang'];
        $color = $_GET['color'];
        $minus = $_GET['minus'];

        $data = array();

        $data['product_id'] = 0;
        $data['kode'] = '';
        $data['brand_id'] = 0;
        $data['barang'] = '';
        $data['qty'] = 0;
        $data['tipe'] = 2;
        $data['price'] = 0;
        $data['price2'] = 0;

        $query = "SELECT a.*, b.jenis 
            FROM barang a 
            JOIN jenisbarang b ON a.brand_id = b.brand_id 
            WHERE a.kode = '$kode' 
            AND b.jenis = '$jenis' 
            AND a.barang = '$barang' 
            AND a.frame = '$minus' 
            AND a.color = '$color' 
            AND a.tipe = 2 
            AND a.branch_id = $_SESSION[branch_id] ";
        $res = $mysqli->query($query);
        if ($row = mysqli_fetch_assoc($res)) {
            $data['product_id'] = $row['product_id'];
            $data['kode'] = $row['kode'];
            $data['brand_id'] = $row['brand_id'];
            $data['barang'] = $row['barang'];
            $data['tipe'] = 2;
            $data['qty'] = $row['qty'];
            $data['price'] = $row['price'];
            $data['price2'] = $row['price2'];
        }

        array_push($arr, $data);
        
        echo json_encode($arr);
        break;
}

//echo json_encode($result);