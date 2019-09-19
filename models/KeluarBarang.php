<?php

class KeluarBarang {
	private $keluarbarang_id;
	private $referensi;
	private $tgl;
	private $jtempo;
	private $client;
	private $client_name;
	private $sales;
	private $sales_name;
	private $matauang_id;
	private $matauang_kode;
	private $matauang;
	private $tdiskon;
	private $diskon;
	private $ppn;
	private $total;
	private $total_before;
	private $info;
	private $lunas;
	private $tipe_pembayaran;
	private $branch_id;
	private $branch_name;
	private $created_by;
	private $created_at;
	private $updated_by;
	private $updated_at;

	public function __construct() {}

	public function setKeluarbarangId($keluarbarang_id) { $this->keluarbarang_id = $keluarbarang_id; }
	public function setReferensi($referensi) { $this->referensi = $referensi; }
	public function setTgl($tgl) { $this->tgl = $tgl; }
	public function setJtempo($jtempo) { $this->jtempo = $jtempo; }
	public function setClient($client) { $this->client = $client; }
	public function setClientName($client_name) { $this->client_name = $client_name; }
	public function setSales($sales) { $this->sales = $sales; }
	public function setSalesName($sales_name) { $this->sales_name = $sales_name; }
	public function setMatauangId($matauang_id) { $this->matauang_id = $matauang_id; }
	public function setMatauangKode($matauang_kode) { $this->matauang_kode = $matauang_kode; }
	public function setMatauang($matauang) { $this->matauang = $matauang; }
	public function setTdiskon($tdiskon) { $this->tdiskon = $tdiskon; }
	public function setDiskon($diskon) { $this->diskon = $diskon; }
	public function setPpn($ppn) { $this->ppn = $ppn; }
	public function setTotal($total) { $this->total = $total; }
	public function setTotalBefore($total_before) { $this->total_before = $total_before; }
	public function setInfo($info) { $this->info = $info; }
	public function setLunas($lunas) { $this->lunas = $lunas; }
	public function setTipePembayaran($tipe_pembayaran) { $this->tipe_pembayaran = $tipe_pembayaran; }
	public function setBranchId($branch_id) { $this->branch_id = $branch_id; }
	public function setBranchName($branch_name) { $this->branch_name = $branch_name; }
	public function setCreatedBy($created_by) { $this->created_by = $created_by; }
	public function setCreatedAt($created_at) { $this->created_at = $created_at; }
	public function setUpdatedBy($updated_by) { $this->updated_by = $updated_by; }
	public function setUpdatedAt($updated_at) { $this->updated_at = $updated_at; }

	public function getKeluarbarangId() { return $this->keluarbarang_id; }
	public function getReferensi() { return $this->referensi; }
	public function getTgl() { return $this->tgl; }
	public function getJtempo() { return $this->jtempo; }
	public function getClient() { return $this->client; }
	public function getClientName() { return $this->client_name; }
	public function getSales() { return $this->sales; }
	public function getSalesName() { return $this->sales_name; }
	public function getMatauangId() { return $this->matauang_id; }
	public function getMatauangKode() { return $this->matauang_kode; }
	public function getMatauang() { return $this->matauang; }
	public function getTdiskon() { return $this->tdiskon; }
	public function getDiskon() { return $this->diskon; }
	public function getPpn() { return $this->ppn; }
	public function getTotal() { return $this->total; }
	public function getTotalBefore() { return $this->total_before; }
	public function getInfo() { return $this->info; }
	public function getLunas() { return $this->lunas; }
	public function getTipePembayaran() { return $this->tipe_pembayaran; }
	public function getBranchId() { return $branch_id; }
	public function getBranchName() { return $branch_name; }
	public function getCreatedBy() { return $created_by; }
	public function getCreatedAt() { return $created_at; }
	public function getUpdatedBy() { return $updated_by; }
	public function getUpdatedAt() { return $updated_at; }
}

?>
