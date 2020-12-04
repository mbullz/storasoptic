<?php

session_start();
include('../../include/config_db.php');

$url = $base_url . "index-c-presence.pos";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$note = $_POST['note'] ?? '';

$username = $mysqli->real_escape_string($username);
$password = $mysqli->real_escape_string($password);
$password = md5($password);
$note = $mysqli->real_escape_string($note);

$rs = $mysqli->query("SELECT * FROM kontak WHERE kontak = '$username' AND pass = '$password' AND jenis = 'T001' AND aktif = '1'");

if ($data = $rs->fetch_assoc()) {
	$user_id = $data['user_id'];

	$mysqli->query("INSERT INTO presence(user_id, presence_date, note, created_by, created_at) VALUES($user_id, NOW(), '$note', $_SESSION[user_id], NOW())");

	$_SESSION['flash_status'] = 'success';
	$_SESSION['flash'] = 'Absensi berhasil';
}
else {
	$_SESSION['flash_status'] = 'failed';
	$_SESSION['flash'] = 'Data tidak valid';
}

header('location:' . $url);

?>
