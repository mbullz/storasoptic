<?php
session_start();

include('../../../include/config_db.php');
require '../../../models/KeluarBarang.php';
require '../../../models/DBHelper.php';

$db = new DBHelper($mysqli);

$mode = $_GET['mode'];
$keyword = $_GET['q'] ?? '';
$keyword = $mysqli->real_escape_string($keyword);
$query = '';
$arr = array();

switch($mode) {
    case 'get_supplier':    
        $query = "select a.*,b.jenis from kontak a join jeniskontak b on a.jenis=b.kode where b.klasifikasi='supplier'";
        if (!empty($keyword) && isset($keyword)) {
            $query = $query . " and kontak like '%$keyword%'";
        }
        $query = $query . " order by b.jenis, a.kontak";
        $res = $mysqli->query($query);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, array('user_id' => $row['user_id'], 'jenis' => $row['jenis'], 'kontak' => $row['kontak'], 'gender' => $row['gender']));
        }
        echo json_encode($arr);
        break;
    case 'get_customer':
        $query = "SELECT a.user_id, a.jenis, a.kontak, a.gender 
            FROM kontak a 
            JOIN jeniskontak b ON a.jenis = b.kode 
            WHERE b.klasifikasi = 'customer' 
            AND kontak LIKE '%$keyword%' 
            AND a.branch_id = $_SESSION[branch_id] 
            ORDER BY b.jenis, a.kontak ";

        $res = $mysqli->query($query);
        while ($row = mysqli_fetch_assoc($res)) {
            array_push($arr, array(
                'user_id'   => $row['user_id'], 
                'jenis'     => $row['jenis'], 
                'kontak'    => $row['kontak'], 
                'gender'    => $row['gender'],
            ));
        }

        echo json_encode($arr);
        break;

    case 'get_info_customer':
        $user_id = $_GET['user_id'] ?? 0;

        $arr = array(
            'keluarbarang'  => $db->getKeluarBarangByCustomer($user_id, 'array'),
        );

        echo json_encode($arr);
    break;
}
