<?php

class DBHelper {
	private $mysqli;

	public function __construct($mysqli) {
		$this->mysqli = $mysqli;
	}

	public function getBarang($b) {
		if ($b->getProductId() != null) {
			$query = "SELECT * FROM barang WHERE product_id = " . $b->getProductId();
		}
		else {
			$query = "SELECT * FROM barang WHERE kode LIKE '".$b->getKode()."' 
				AND brand_id = ".$b->getBrandId()." 
				AND barang LIKE '".$b->getBarang()."' 
				AND frame LIKE '".$b->getFrame()."' 
				AND color LIKE '".$b->getColor()."' 
				AND power_add LIKE '".$b->getPowerAdd()."' 
				AND tipe = ".$b->getTipe()." 
				AND branch_id = ".$b->getBranchId()." ";
		}

		$rs = $this->mysqli->query($query);

		if ($data = $rs->fetch_assoc()) {
			$r = new Barang();

			$r->setProductId($data['product_id']);
			$r->setKode($data['kode']);
			$r->setBrandId($data['brand_id']);
			$r->setBarang($data['barang']);
			$r->setFrame($data['frame']);
			$r->setColor($data['color']);
			$r->setPowerAdd($data['power_add']);
			$r->setQty($data['qty']);
			$r->setPrice($data['price']);
			$r->setPrice2($data['price2']);
			$r->setKodeHarga($data['kode_harga']);
			$r->setInfo($data['info']);
			$r->setUkuran($data['ukuran']);
			$r->setTipe($data['tipe']);
			$r->setTglMasukAkhir($data['tgl_masuk_akhir']);
			$r->setTglKeluarAkhir($data['tgl_keluar_akhir']);
			$r->setBranchId($data['branch_id']);
			$r->setCreatedUserId($data['created_user_id']);
			$r->setCreatedDate($data['created_date']);
			$r->setLastUpdateUserId($data['last_update_user_id']);
			$r->setLastUpdateDate($data['last_update_date']);

			return $r;
		}
		else {
			return null;
		}
	}

	public function insertBarang($b) {
		$kode = $b->getKode();
		$brand_id = $b->getBrandId();
		$barang = $b->getBarang();
		$frame = $b->getFrame();
		$color = $b->getColor();
		$power_add = $b->getPowerAdd();
		$qty = $b->getQty();
		$price = $b->getPrice();
		$price2 = $b->getPrice2();
		$kode_harga = $b->getKodeHarga();
		$info = $b->getInfo();
		$ukuran = $b->getUkuran();
		$tipe = $b->getTipe();
		$tgl_masuk_akhir = $b->getTglMasukAkhir();
		$tgl_keluar_akhir = $b->getTglKeluarAkhir();
		$branch_id = $b->getBranchId();
		$created_user_id = $b->getCreatedUserId();
		$created_date = $b->getCreatedDate();
		$last_update_user_id = $b->getLastUpdateUserId();
		$last_update_date = $b->getLastUpdateDate();

		if ($tgl_keluar_akhir != 'NULL') $tgl_keluar_akhir = "'" . $tgl_keluar_akhir . "'";

		$query = "INSERT INTO barang(product_id, kode, brand_id, barang, frame, color, power_add, qty, price, price2, kode_harga, info, ukuran, tipe, tgl_masuk_akhir, tgl_keluar_akhir, branch_id, created_user_id, created_date, last_update_user_id, last_update_date) VALUES (0, '$kode', $brand_id, '$barang', '$frame', '$color', '$power_add', $qty, $price, $price2, '$kode_harga', '$info', '$ukuran', $tipe, '$tgl_masuk_akhir', $tgl_keluar_akhir, $branch_id, $created_user_id, $created_date, $last_update_user_id, $last_update_date)";

		$result = $this->mysqli->query($query);
		$insert_id = $this->mysqli->insert_id;

		if ($result) {
			return $this->response_success($insert_id);
		}
		else {
			return $this->response_fail();
		}
	}

	public function updateBarang($b) {
		if ($b->getTglKeluarAkhir() != NULL) $b->setTglKeluarAkhir("'" . $b->getTglKeluarAkhir() . "'");
		else $b->setTglKeluarAkhir('NULL');

		$query = "UPDATE barang SET 
				kode = '".$b->getKode()."', 
				brand_id = ".$b->getBrandId().", 
				barang = '".$b->getBarang()."', 
				frame = '".$b->getFrame()."', 
				color = '".$b->getColor()."', 
				power_add = '".$b->getPowerAdd()."', 
				qty = ".$b->getQty().", 
				price = ".$b->getPrice().", 
				price2 = ".$b->getPrice2().", 
				kode_harga = '".$b->getKodeHarga()."', 
				info = '".$b->getInfo()."', 
				ukuran = '".$b->getUkuran()."', 
				tipe = ".$b->getTipe().", 
				tgl_masuk_akhir = '".$b->getTglMasukAkhir()."', 
				tgl_keluar_akhir = ".$b->getTglKeluarAkhir().", 
				branch_id = ".$b->getBranchId().", 
				last_update_user_id = ".$_SESSION['user_id'].", 
				last_update_date = NOW() 
			WHERE product_id = " . $b->getProductId();

		$result = $this->mysqli->query($query);

		if ($result) {
			return $this->response_success($b->getProductId());
		}
		else {
			return $this->response_fail();
		}
	}

	public function getJenisBarang($r) {
		$query = "SELECT * FROM jenisbarang WHERE 
			jenis = '".$r->getJenis()."' AND 
			tipe = " . $r->getTipe();

		$rs = $this->mysqli->query($query);

		if ($data = $rs->fetch_assoc()) {
			$r = new JenisBarang();

			$r->setBrandId($data['brand_id']);
			$r->setKode($data['kode']);
			$r->setJenis($data['jenis']);
			$r->setInfo($data['info']);
			$r->setTipe($data['tipe']);

			return $r;
		}
		else {
			return null;
		}
	}

	public function getStockBarang($b) {
		$query = "SELECT a.kontak, b.qty FROM kontak a 
			LEFT JOIN barang b ON a.user_id = b.branch_id 
			WHERE a.jenis = 'B001' 
			AND b.kode = '".$b->getKode()."' 
			AND b.brand_id = ".$b->getBrandId()." 
			AND b.barang = '".$b->getBarang()."' 
			AND b.frame = '".$b->getFrame()."' 
			AND b.color = '".$b->getColor()."' 
			AND b.power_add = '".$b->getPowerAdd()."' 
			AND b.tipe = ".$b->getTipe()." 
			ORDER BY a.kontak ASC ";

		$rs = $this->mysqli->query($query);

		$rows = array();
		while ($data = $rs->fetch_assoc()) {
			$row = array(
				'kontak'	=> $data['kontak'],
				'qty'		=> $data['qty'],
			);

			array_push($rows, $row);
		}

		return $rows;
	}

	public function getAllKontak($klasifikasi) {
		$branch_id = $_SESSION['branch_id'] ?? 0;

		$branch_filter = '';
		if ($branch_id != 0 && ($klasifikasi == 'karyawan' || $klasifikasi == 'customer' || $klasifikasi == 'sales')) {
			$branch_filter = " AND a.branch_id = $branch_id ";
		}

		$query = "SELECT a.user_id, a.gender, a.akses, a.kontak, a.alamat, a.kperson, a.pinbb, a.mulai, a.aktif, a.jabatan, a.notlp, a.notlp2, a.hp, a.fax, a.email, a.info, a.branch_id, b.kode, b.klasifikasi 
				FROM kontak a 
				JOIN jeniskontak b ON a.jenis = b.kode 
				WHERE b.klasifikasi = '$klasifikasi' 
				$branch_filter 
				ORDER BY a.user_id ASC ";

		$rs = $this->mysqli->query($query);

		$rows = array();

		while ($data = $rs->fetch_assoc()) {
			$r = new Kontak();

			$r->setUserId($data['user_id']);
			$r->setGender($data['gender']);
			$r->setAkses($data['akses']);
			$r->setKode($data['kode']);
			$r->setKlasifikasi($data['klasifikasi']);
			$r->setKontak($data['kontak']);
			$r->setAlamat($data['alamat']);
			$r->setKPerson($data['kperson']);
			$r->setPinBb($data['pinbb']);
			$r->setMulai($data['mulai']);
			$r->setAktif($data['aktif']);
			$r->setJabatan($data['jabatan']);
			$r->setNoTlp($data['notlp']);
			$r->setNoTlp2($data['notlp2']);
			$r->setHp($data['hp']);
			$r->setFax($data['fax']);
			$r->setEmail($data['email']);
			$r->setInfo($data['info']);
			$r->setBranchId($data['branch_id']);

			array_push($rows, $r);
		}
		
		return $rows;
	}

	public function getAllArusKas($start, $end, $account = '%', $tipe = '%') {
		$branch_id = $_SESSION['branch_id'] ?? 0;

		$branch_filter = '';
		if ($branch_id != 0) {
			$branch_filter = " AND a.branch_id = $branch_id ";
		}

		$query = "SELECT a.id, a.carabayar_id, b.pembayaran, a.transaction_id, a.tipe, a.account, a.tgl, a.opr, a.referensi, a.jumlah, a.matauang_id, c.kode AS matauang_kode, c.matauang, a.info, a.branch_id, d.kontak AS branch_name 
				FROM aruskas a 
				JOIN carabayar b ON a.carabayar_id = b.carabayar_id 
				JOIN matauang c ON a.matauang_id = c.matauang_id 
				JOIN kontak d ON a.branch_id = d.user_id 
				WHERE a.tgl >= '$start' 
				AND a.tgl <= '$end' 
				AND a.tipe LIKE '$tipe' 
				AND a.account LIKE '$account' 
				$branch_filter 
				ORDER BY a.tgl ASC ";

		$rs = $this->mysqli->query($query);

		$rows = array();

		while ($data = $rs->fetch_assoc()) {
			$r = new ArusKas();

			$r->setId($data['id']);
			$r->setCarabayarId($data['carabayar_id']);
			$r->setPembayaran($data['pembayaran']);
			$r->setTransactionId($data['transaction_id']);
			$r->setTipe($data['tipe']);
			$r->setAccount($data['account']);
			$r->setTgl($data['tgl']);
			$r->setOpr($data['opr']);
			$r->setReferensi($data['referensi']);
			$r->setJumlah($data['jumlah']);
			$r->setMatauangId($data['matauang_id']);
			$r->setMatauangKode($data['matauang_kode']);
			$r->setMatauang($data['matauang']);
			$r->setInfo($data['info']);
			$r->setBranchId($data['branch_id']);
			$r->setBranchName($data['branch_name']);

			array_push($rows, $r);
		}
		
		return $rows;
	}

	private function response_success($id = 0, $data = [], $parameter = []) {
		return (object) array(
			'parameter'	=> $parameter,
			'status'	=> 'success',
			'message'	=> 'Success',
			'id'		=> $id,
			'data'		=> $data,
		);
	}

	private function response_fail($parameter = []) {
		return (object) array(
			'parameter'	=> $parameter,
			'status'	=> 'fail',
			'message'	=> 'Fail. Data not valid.',
		);
	}

	private function generateInsertQuery($table_name, $content_values) {
		$columns = '(';
		$values = '(';

		foreach ($content_values AS $key => $value) {
			$columns .= $key . ', ';
			$values .= $value . ', ';
		}

		$columns .= ')';
		$values .= ')';

		$query = 'INSERT INTO ' . $table_name;
	}
}

?>
