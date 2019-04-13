function getSubdepertemen(dep) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divSubdepartemen');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divSubdepartemen');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var dep_ = dep;
	//var kod = document.getElementById('nama').value;
	var queryString = "?departemen=" + dep_;
	ajaxRequest.open("GET", "ajaxdata/get_subdepartemen.php" + queryString, true);
	ajaxRequest.send(null);
}
// ---
function getKaryawan(val) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('nik');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('nik');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var val_ = val;
	//var kod = document.getElementById('nama').value;
	var queryString = "?val_=" + val_;
	ajaxRequest.open("GET", "ajaxdata/get_karyawan.php" + queryString, true);
	ajaxRequest.send(null);
}
// ---
function getRequester(val) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('requester');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('requester');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var val_ = val;
	//var kod = document.getElementById('nama').value;
	var queryString = "?val_=" + val_;
	ajaxRequest.open("GET", "ajaxdata/get_requester.php" + queryString, true);
	ajaxRequest.send(null);
}
// ---
function getLeaderReq(val) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('leader');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('leader');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var val_ = val;
	//var kod = document.getElementById('nama').value;
	var queryString = "?val_=" + val_;
	ajaxRequest.open("GET", "ajaxdata/get_leader_req.php" + queryString, true);
	ajaxRequest.send(null);
}
//---
function manageTask(act,refid) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divTableTask');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divTableTask');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var etask    = act;
	var erefid   = refid;
	var etgl     = document.getElementById('tgl').value;
	var ekeg     = document.getElementById('kegiatan').value;
	var emul     = document.getElementById('mulai').value;
	var esam     = document.getElementById('sampai').value;
	var einf     = document.getElementById('info_').value;
	var esta     = document.getElementById('status').value;
	var queryString = "?task=" + etask + "&refid=" + erefid + "&tgl=" + etgl + "&kegiatan=" + ekeg + "&mulai=" + emul + "&sampai=" + esam + "&info=" + einf + "&status=" + esta;
	ajaxRequest.open("GET", "ajaxdata/getmanage_task.php" + queryString, true);
	ajaxRequest.send(null);
}
//--
function browseKaryawan(val) {
var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('browseKaryawan');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('browseKaryawan');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var val_ = val;
	//var kod = document.getElementById('nama').value;
	var queryString = "?val_=" + val_;
	ajaxRequest.open("GET", "ajaxdata/browse_karyawan.php" + queryString, true);
	ajaxRequest.send(null);
}
//---
function getAlokasiMedis() {
var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divAlokasimedis');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divAlokasimedis');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var nik_ = document.getElementById('nik').value;
	var tgl_ = document.getElementById('tgl').value;
	var queryString = "?nik=" + nik_ + "&tgl=" + tgl_;
	ajaxRequest.open("GET", "ajaxdata/get_alokasimedis.php" + queryString, true);
	ajaxRequest.send(null);
}
// --- 
function getSisaKlaim(idx) {
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divKlaim');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divKlaim');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var id_ = idx;
	var queryString = "?id=" + id_;
	ajaxRequest.open("GET", "ajaxdata/get_sisaklaim.php" + queryString, true);
	ajaxRequest.send(null);
}
// ----
function getDefaultBayar() {
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divBayar');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divBayar');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var id_ = document.getElementById('jenismedis').value;
	var no_ = document.getElementById('klaim').value;
	var queryString = "?id=" + id_ + "&nominal=" + no_;
	ajaxRequest.open("GET", "ajaxdata/get_defaultbayar.php" + queryString, true);
	ajaxRequest.send(null);
}
//---
function getSubdepertemenKgaji(dep) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divSubdepartemen');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divSubdepartemen');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var dep_ = dep;
	//var kod = document.getElementById('nama').value;
	var queryString = "?departemen=" + dep_;
	ajaxRequest.open("GET", "ajaxdata/get_subdepartemenkgaji.php" + queryString, true);
	ajaxRequest.send(null);
}
//--
function getKaryawanGaji() {
var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('browseKaryawan');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('browseKaryawan');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var dep = document.getElementById('q_departemen').value;
	var jab = document.getElementById('q_jabatan').value;
	var qtx = document.getElementById('q_text').value;
	var qbln= document.getElementById('per_bln').value;
	var qthn= document.getElementById('per_thn').value;
	var queryString = "?departemen=" + dep + "&jabatan=" + jab + "&q=" + qtx + "&bulan=" + qbln + "&tahun=" + qthn;
	ajaxRequest.open("GET", "ajaxdata/get_karyawangaji.php" + queryString, true);
	ajaxRequest.send(null);
}
//--
function getEndPeriod() {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divAkhir');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divAkhir');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var ten = document.getElementById('tenor').value;
	var awl = document.getElementById('awal').value;
	var queryString = "?tenor=" + ten + "&awal=" + awl;
	ajaxRequest.open("GET", "ajaxdata/get_endperiod.php" + queryString, true);
	ajaxRequest.send(null);	
}
//---
function getCicilan() {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divCicilan');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divCicilan');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var ten = document.getElementById('tenor').value;
	var jum = document.getElementById('jumlah').value;
	var bun = document.getElementById('bunga').value;
	var queryString = "?tenor=" + ten + "&jumlah=" + jum + "&bunga=" + bun;
	ajaxRequest.open("GET", "ajaxdata/get_cicilan.php" + queryString, true);
	ajaxRequest.send(null);	
}
//--
function getMasterBarang(val, tipe) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divMBarang');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divMBarang');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var val_ = val;
	var tipe_ = tipe;
	if (tipe_ == '5') tipe_ = '1';
	var queryString = "?q=" + val_ + '&t=' + tipe_;
	ajaxRequest.open("GET", "ajaxdata/get_mbarang.php" + queryString, true);
	ajaxRequest.send(null);
}
//---
function manageInvoiceBeli(t,v) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			onLoad();
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var checkBarangBaru = document.getElementById("checkBarangBaru").checked;
	var tsk = t;
	var xid = v;
	var ref = document.getElementById('invoice').value;
	var bar = document.getElementById('barang').value;
	var qty = document.getElementById('qty').value;
	var sat = document.getElementById('satuan').value;
	var hsa = document.getElementById('hsatuan').value;
	var tdi = document.getElementById('tdiskon').value;
	var dis = document.getElementById('diskon').value;
	var xsu = document.getElementById('subtotal').value;
	
	if (checkBarangBaru == true)
	{
		tsk = "add2";
		bar = document.getElementById("barang2").value;
		var type = document.getElementById("tipe2").value;
		var brand = document.getElementById("brand2").value;
		var warna = document.getElementById("warna2").value;
		var frame = document.getElementById("frame2").value;
		var kode_harga = document.getElementById("kode_harga2").value;
		var supplier = document.getElementById("supplier").options[document.getElementById('supplier').selectedIndex].text;
		supplier = supplier=="-- Choose Supplier --"?"":supplier;
	}
	
	var queryString = "?task=" + tsk + "&rid=" + xid + "&ref=" + ref + "&barang=" + bar + "&qty=" + qty + "&satuan=" + sat + "&hsatuan=" + hsa + "&subtotal=" + xsu + "&tdiskon=" + tdi + "&diskon=" + dis;
	
	if (checkBarangBaru == true)
	{
		queryString = queryString + "&type=" + type + "&brand=" + brand + "&warna=" + warna + "&frame=" + frame + "&kode_harga=" + kode_harga + "&supplier=" + supplier;
	}
	
	ajaxRequest.open("GET", "ajaxdata/manage_invoicebeli.php" + queryString, true);
	ajaxRequest.send(null);
}
//---
/*
function manageInvoiceJual(t,v) {
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var tsk = t;
	var xid = v;
	var ref = document.getElementById('invoice').value;
	var bar = document.getElementById('barang').value;
	var qty = document.getElementById('qty').value;
	var sat = document.getElementById('satuan').value;
	var hsa = document.getElementById('hsatuan').value;
	var tdi = document.getElementById('tdiskon').value;
	var dis = document.getElementById('diskon').value;
	var xsu = document.getElementById('subtotal').value;
    var fra = document.getElementById('frame').value;
    
	var rSph = document.getElementById('rSph').value;
    var rCyl = document.getElementById('rCyl').value;
    var rAxis = document.getElementById('rAxis').value;
    var rAdd = document.getElementById('rAdd').value;
    var rPd = document.getElementById('rPd').value;
    
	var lSph = document.getElementById('lSph').value;
    var lCyl = document.getElementById('lCyl').value;
    var lAxis = document.getElementById('lAxis').value;
    var lAdd = document.getElementById('lAdd').value;
    var lPd = document.getElementById('lPd').value;
	
	var lens = document.getElementById('lensa').value;
	var harga_lensa = document.getElementById('').value;
        
	var queryString = "?task=" + tsk + 
                "&rid=" + xid + 
                "&ref=" + ref + 
                "&brg=" + bar + 
                "&qty=" + qty + 
                "&sat=" + sat + 
                "&hsat=" + hsa + 
                "&subtot=" + xsu + 
                "&tdisc=" + tdi + 
                "&disc=" + dis + 
                "&fra=" + fra + 
                "&lens=" + lens +
                "&rSph=" + (rSph*100) +
                "&rCyl=" + (rCyl*100) +
                "&rAxis=" + (rAxis*100) +
                "&rAdd=" + (rAdd*100) +
                "&rPd=" + rPd +
                "&lSph=" + (lSph*100) +
                "&lCyl=" + (lCyl*100) +
                "&lAxis=" + (lAxis*100) +
                "&lAdd=" + (lAdd*100) +
                "&lPd=" + lPd;

	ajaxRequest.open("GET", "ajaxdata/manage_invoicejual.php" + queryString, true);
	ajaxRequest.send(null);
}
*/

function manageInvoiceJual2(t,v)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divManageInvoice');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var tsk = t;
	var xid = v;
	var ref = document.getElementById('invoice').value;
	var bar = document.getElementById('barang2').value;
	var qty = document.getElementById('qty2').value;
	var frame2 = document.getElementById('frame2').value;
	var brand2 = document.getElementById('brand2').value;
	var warna2 = document.getElementById('warna2').value;
	var sat = 1;
	var hsa = document.getElementById('hsatuan2').value;
	var tipe = document.getElementById('tipe').value;
	var tdi = document.getElementById('tdiskon2').value;
	var dis = document.getElementById('diskon2').value;
	var xsu = document.getElementById('subtotal2').value;
		var fra = document.getElementById('frame').value;
        var lens = document.getElementById('lensa').value;
        var rSph = document.getElementById('rSph').value;
        var rCyl = document.getElementById('rCyl').value;
        var rAxis = document.getElementById('rAxis').value;
        var rAdd = document.getElementById('rAdd').value;
        var rPd = document.getElementById('rPd').value;
        var lSph = document.getElementById('lSph').value;
        var lCyl = document.getElementById('lCyl').value;
        var lAxis = document.getElementById('lAxis').value;
        var lAdd = document.getElementById('lAdd').value;
        var lPd = document.getElementById('lPd').value;
        
	var queryString = "?task=" + tsk + 
                "&rid=" + xid + 
                "&ref=" + ref + 
                "&brg=" + bar + 
                "&qty=" + qty + 
                "&sat=" + sat + 
                "&hsat=" + hsa + 
                "&subtot=" + xsu + 
                "&tdisc=" + tdi + 
                "&disc=" + dis + 
                "&fra=" + fra + 
                "&lens=" + lens +
                "&rSph=" + (rSph*100) +
                "&rCyl=" + (rCyl*100) +
                "&rAxis=" + (rAxis*100) +
                "&rAdd=" + (rAdd*100) +
                "&rPd=" + rPd +
                "&lSph=" + (lSph*100) +
                "&lCyl=" + (lCyl*100) +
                "&lAxis=" + (lAxis*100) +
                "&lAdd=" + (lAdd*100) +
                "&lPd=" + lPd + 
				"&frame2=" + frame2 + 
				"&brand2=" + brand2 + 
				"&warna2=" + warna2 + 
				"&tipe=" + tipe;
	ajaxRequest.open("GET", "ajaxdata/manage_invoicejual.php" + queryString, true);
	ajaxRequest.send(null);
}
// ---
function manageTargetJual(t,v) {
var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('divManageTarget');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
		if (ajaxRequest.readyState == 3) {
			var ajaxDisplay = document.getElementById('divManageTarget');
			ajaxDisplay.innerHTML = "<img src='images/ajax-loader.gif' />";
		}
	}
	var tsk = t;
	var xid = v;
	var kon = document.getElementById('sales').value;
	var bar = document.getElementById('barang').value;
	var qty = document.getElementById('qty').value;
	var sat = document.getElementById('satuan').value;
	var hsa = document.getElementById('hsatuan').value;
	var per = document.getElementById('periode').value;
	var xsu = document.getElementById('subtotal').value;
	var queryString = "?task=" + tsk + "&rid=" + xid + "&kontak=" + kon + "&barang=" + bar + "&qty=" + qty + "&satuan=" + sat + "&hsatuan=" + hsa + "&subtotal=" + xsu + "&periode=" + per;
	ajaxRequest.open("GET", "ajaxdata/manage_targetjual.php" + queryString, true);
	ajaxRequest.send(null);	
}