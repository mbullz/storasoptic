<?php

class Barang {
	private $product_id;
	private $kode;
	private $brand_id;
	private $brand_name;
	private $barang;
	private $frame;
	private $color;
	private $power_add;
	private $qty;
	private $price;
	private $price2;
	private $kode_harga;
	private $info;
	private $ukuran;
	private $tipe;
	private $tgl_masuk_akhir;
	private $tgl_keluar_akhir;
	private $branch_id;
	private $created_user_id;
	private $created_date;
	private $last_update_user_id;
	private $last_update_date;

	function __construct() {
		
	}

	/*
	function __construct($product_id, $kode, $brand_id, $barang, $frame, $color, $power_add, $qty, $price, $price2, $kode_harga, $info, $ukuran, $tipe, $tgl_masuk_akhir, $tgl_keluar_akhir, $branch_id, $created_user_id, $created_date, $last_update_user_id, $last_update_date) {
		$this->product_id = $product_id;
		$this->kode = $kode;
		$this->brand_id = $brand_id;
		$this->barang = $barang;
		$this->frame = $frame;
		$this->color = $color;
		$this->power_add = $power_add;
		$this->qty = $qty;
		$this->price = $price;
		$this->price2 = $price2;
		$this->kode_harga = $kode_harga;
		$this->info = $info;
		$this->ukuran = $ukuran;
		$this->tipe = $tipe;
		$this->tgl_masuk_akhir = $tgl_masuk_akhir;
		$this->tgl_keluar_akhir = $tgl_keluar_akhir;
		$this->branch_id = $branch_id;
		$this->created_user_id = $created_user_id;
		$this->created_date = $created_date;
		$this->last_update_user_id = $last_update_user_id;
		$this->last_update_date = $last_update_date;
	}
	*/

	public function setProductId($product_id) { $this->product_id = $product_id; }
	public function setKode($kode) { $this->kode = $kode; }
	public function setBrandId($brand_id) { $this->brand_id = $brand_id; }
	public function setBrandName($brand_name) { $this->brand_name = $brand_name; }
	public function setBarang($barang) { $this->barang = $barang; }
	public function setFrame($frame) { $this->frame = $frame; }
	public function setColor($color) { $this->color = $color; }
	public function setPowerAdd($power_add) { $this->power_add = $power_add; }
	public function setQty($qty) { $this->qty = $qty; }
	public function setPrice($price) { $this->price = $price; }
	public function setPrice2($price2) { $this->price2 = $price2; }
	public function setKodeHarga($kode_harga) { $this->kode_harga = $kode_harga; }
	public function setInfo($info) { $this->info = $info; }
	public function setUkuran($ukuran) { $this->ukuran = $ukuran; }
	public function setTipe($tipe) { $this->tipe = $tipe; }
	public function setTglMasukAkhir($tgl_masuk_akhir) { $this->tgl_masuk_akhir = $tgl_masuk_akhir; }
	public function setTglKeluarAkhir($tgl_keluar_akhir) { $this->tgl_keluar_akhir = $tgl_keluar_akhir; }
	public function setBranchId($branch_id) { $this->branch_id = $branch_id; }
	public function setCreatedUserId($created_user_id) { $this->created_user_id = $created_user_id; }
	public function setCreatedDate($created_date) { $this->created_date = $created_date; }
	public function setLastUpdateUserId($last_update_user_id) { $this->last_update_user_id = $last_update_user_id; }
	public function setLastUpdateDate($last_update_date) { $this->last_update_date = $last_update_date; }

	public function getProductId() { return $this->product_id; }
	public function getKode() { return $this->kode; }
	public function getBrandId() { return $this->brand_id; }
	public function getBrandName() { return $this->brand_name; }
	public function getBarang() { return $this->barang; }
	public function getFrame() { return $this->frame; }
	public function getColor() { return $this->color; }
	public function getPowerAdd() { return $this->power_add; }
	public function getQty() { return $this->qty; }
	public function getPrice() { return $this->price; }
	public function getPrice2() { return $this->price2; }
	public function getKodeHarga() { return $this->kode_harga; }
	public function getInfo() { return $this->info; }
	public function getUkuran() { return $this->ukuran; }
	public function getTipe() { return $this->tipe; }
	public function getTglMasukAkhir() { return $this->tgl_masuk_akhir; }
	public function getTglKeluarAkhir() { return $this->tgl_keluar_akhir; }
	public function getBranchId() { return $this->branch_id; }
	public function getCreatedUserId() { return $this->created_user_id; }
	public function getCreatedDate() { return $this->created_date; }
	public function getLastUpdateUserId() { return $this->last_update_user_id; }
	public function getLastUpdateDate() { return $this->last_update_date; }
}

?>
