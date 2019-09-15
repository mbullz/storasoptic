<?php

class Branch {
	private $user_id;
	private $kode;
	private $klasifikasi;
	private $kontak;
	private $alamat;

	public function __construct() {

	}

	public function setUserId($user_id) { $this->user_id = $user_id; }
	public function setKode($kode) { $this->kode = $kode; }
	public function setKlasifikasi($klasifikasi) { $this->klasifikasi = $klasifikasi; }
	public function setKontak($kontak) { $this->kontak = $kontak; }
	public function setAlamat($alamat) { $this->alamat = $alamat; }

	public function getUserId() { return $this->user_id; }
	public function getKode() { return $this->kode; }
	public function getKlasifikasi() { return $this->klasifikasi; }
	public function getKontak() { return $this->kontak; }
	public function getAlamat() { return $this->alamat; }
}

?>
