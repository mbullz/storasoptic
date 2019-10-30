<?php

class CaraBayar {
	private $carabayar_id;
	private $pembayaran;
	private $info;

	public function __construct() {

	}

	public function setCarabayarId($carabayar_id) { $this->carabayar_id = $carabayar_id; }
	public function setPembayaran($pembayaran) { $this->pembayaran = $pembayaran; }
	public function setInfo($info) { $this->info = $info; }

	public function getCarabayarId() { return $this->carabayar_id; }
	public function getPembayaran() { return $this->pembayaran; }
	public function getInfo() { return $this->info; }
}

?>
