<?php

class Kontak {
	private $user_id;
	private $gender;
	private $akses;
	private $kode;
	private $klasifikasi;
	private $kontak;
	private $alamat;
	private $kperson;
	private $pinbb;
	private $mulai;
	private $aktif;
	private $jabatan;
	private $notlp;
	private $notlp2;
	private $hp;
	private $fax;
	private $email;
	private $info;
	private $branch_id;

	public function __construct() {

	}

	public function setUserId($user_id) { $this->user_id = $user_id; }
	public function setGender($gender) { $this->gender = $gender; }
	public function setAkses($akses) { $this->akses = $akses; }
	public function setKode($kode) { $this->kode = $kode; }
	public function setKlasifikasi($klasifikasi) { $this->klasifikasi = $klasifikasi; }
	public function setKontak($kontak) { $this->kontak = $kontak; }
	public function setAlamat($alamat) { $this->alamat = $alamat; }
	public function setKPerson($kperson) { $this->kperson = $kperson; }
	public function setPinBb($pinbb) { $this->pinbb = $pinbb; }
	public function setMulai($mulai) { $this->mulai = $mulai; }
	public function setAktif($aktif) { $this->aktif = $aktif; }
	public function setJabatan($jabatan) { $this->jabatan = $jabatan; }
	public function setNoTlp($notlp) { $this->notlp = $notlp; }
	public function setNoTlp2($notlp2) { $this->notlp2 = $notlp2; }
	public function setHp($hp) { $this->hp = $hp; }
	public function setFax($fax) { $this->fax = $fax; }
	public function setEmail($email) { $this->email = $email; }
	public function setInfo($info) { $this->info = $info; }
	public function setBranchId($branch_id) { $this->branch_id = $branch_id; }

	public function getUserId() { return $this->user_id; }
	public function getGender() { return $this->gender; }
	public function getAkses() { return $this->akses; }
	public function getKode() { return $this->kode; }
	public function getKlasifikasi() { return $this->klasifikasi; }
	public function getKontak() { return $this->kontak; }
	public function getAlamat() { return $this->alamat; }
	public function getKPerson() { return $this->kperson; }
	public function getPinBb() { return $this->pinbb; }
	public function getMulai() { return $this->mulai; }
	public function isAktif() { return $this->aktif; }
	public function getJabatan() { return $this->jabatan; }
	public function getNoTlp() { return $this->notlp; }
	public function getNoTlp2() { return $this->notlp2; }
	public function getHp() { return $this->hp; }
	public function getFax() { return $this->fax; }
	public function getEmail() { return $this->email; }
	public function getInfo() { return $this->info; }
	public function getBranchId() { return $this->branch_id; }
}

?>
