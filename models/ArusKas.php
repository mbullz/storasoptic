<?php

class ArusKas {
	private $id;
	private $carabayar_id;
	private $pembayaran;
	private $transaction_id;
	private $tipe;
	private $account;
	private $tgl;
	private $opr;
	private $referensi;
	private $jumlah;
	private $matauang_id;
	private $matauang_kode;
	private $matauang;
	private $info;
	private $branch_id;
	private $branch_name;

	public function __construct() {}

	public function setId($id) { $this->id = $id; }
	public function setCarabayarId($carabayar_id) { $this->carabayar_id = $carabayar_id; }
	public function setPembayaran($pembayaran) { $this->pembayaran = $pembayaran; }
	public function setTransactionId($transaction_id) { $this->transaction_id = $transaction_id; }
	public function setTipe($tipe) { $this->tipe = $tipe; }
	public function setAccount($account) { $this->account = $account; }
	public function setTgl($tgl) { $this->tgl = $tgl; }
	public function setOpr($opr) { $this->opr = $opr; }
	public function setReferensi($referensi) { $this->referensi = $referensi; }
	public function setJumlah($jumlah) { $this->jumlah = $jumlah; }
	public function setMatauangId($matauang_id) { $this->matauang_id = $matauang_id; }
	public function setMatauangKode($matauang_kode) { $this->matauang_kode = $matauang_kode; }
	public function setMatauang($matauang) { $this->matauang = $matauang; }
	public function setInfo($info) { $this->info = $info; }
	public function setBranchId($branch_id) { $this->branch_id = $branch_id; }
	public function setBranchName($branch_name) { $this->branch_name = $branch_name; }

	public function getId() { return $this->id; }
	public function getCarabayarId() { return $this->carabayar_id; }
	public function getPembayaran() { return $this->pembayaran; }
	public function getTransactionId() { return $this->transaction_id; }
	public function getTipe() { return $this->tipe; }
	public function getAccount() { return $this->account; }
	public function getTgl() { return $this->tgl; }
	public function getOpr() { return $this->opr; }
	public function getReferensi() { return $this->referensi; }
	public function getJumlah() { return $this->jumlah; }
	public function getMatauangId() { return $this->matauang_id; }
	public function getMatauangKode() { return $this->matauang_kode; }
	public function getMatauang() { return $this->matauang; }
	public function getInfo() { return $this->info; }
	public function getBranchId() { return $this->branch_id; }
	public function getBranchName() { return $this->branch_name; }

}

?>
