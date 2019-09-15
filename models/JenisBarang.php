<?php

class JenisBarang {
	private $brand_id;
	private $kode;
	private $jenis;
	private $info;
	private $tipe;

	public function __construct() {

	}

	public function setBrandId($brand_id) { $this->brand_id = $brand_id; }
	public function setKode($kode) { $this->kode = $kode; }
	public function setJenis($jenis) { $this->jenis = $jenis; }
	public function setInfo($info) { $this->info = $info; }
	public function setTipe($tipe) { $this->tipe = $tipe; }

	public function getBrandId() { return $this->brand_id; }
	public function getKode() { return $this->kode; }
	public function getJenis() { return $this->jenis; }
	public function getInfo() { return $this->info; }
	public function getTipe() { return $this->tipe; }
}

?>
