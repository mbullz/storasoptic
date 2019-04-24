<script>
var menu1=new Array()
/*menu1[0]='<a href="index-c-jenisbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Barang</a>'
menu1[1]='<a href="index-c-masterbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Master Barang</a>'*/
<?php if(strstr($_SESSION['akses'],'jeniskontak')) { ?>
//menu1[2]='<a href="index-c-jeniskontak.pos" style="border-bottom:solid 2px #FFF;"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Kontak</a>'
<?php } ?>

<?php if(strstr($_SESSION['akses'],'masterkontak')) { ?>
menu1[3]='<a href="index-c-masterkontak-k-customer-q-.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Customer</a>'
<?php } ?>

<?php if(strstr($_SESSION['akses'],'masterkontak')) { ?>
menu1[4]='<a href="index-c-masterkontak-k-supplier-q-.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Supplier</a>'
<?php } ?>

<?php if(strstr($_SESSION['akses'],'masterkontak')) { ?>
menu1[5]='<a href="index-c-masterkontak-k-sales-q-.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Sales</a>'
<?php } ?>

<?php if($_SESSION['is_admin'] && strstr($_SESSION['akses'],'masterkontak')) { ?>
menu1[6] = '<a href="index-c-masterkontak-k-karyawan-q-.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Karyawan</a>';
menu1[7] = '<a href="index-c-masterkontak-k-cabang-q-.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Cabang</a>';
<?php } ?>

var menu2=new Array()
<?php if(strstr($_SESSION['akses'],'user')) { ?>
menu2[1]='<a href="index-c-user.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> User Internal</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'lokasigudang')) { ?>
//menu2[2]='<a href="index-c-lokasigudang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Lokasi Gudang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'matauang')) { ?>
menu2[3]='<a href="index-c-matauang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Mata Uang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'cbayar')) { ?>
menu2[4]='<a href="index-c-cbayar.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Cara Pembayaran</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'satuan')) { ?>
menu2[5]='<a href="index-c-satuan.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Satuan</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'jenisbarang')) { ?>
//menu2[6]='<a href="index-c-jenisbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Brand</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'masterbarang')) { ?>
//menu2[7]='<a href="index-c-masterbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Master Barang</a>'
//menu2[8]='<a href="index-c-report_masterbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Laporan Master Barang</a>'
//menu2[9]='<a href="index-c-report_kartustock.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Kartu Stock</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'targetpenjualan')) { ?>
//menu2[8]='<a href="index-c-targetpenjualan.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Target Penjualan</a>'
<?php } ?>
/*menu2[7]='<a href="index.php?component=tindakan_medis"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Tindakan Medis</a>'
menu2[7]='<a href="index.php?component=groupshift"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Grup Shift</a>'
menu2[8]='<a href="index.php?component=bank"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Bank</a>'
menu2[9]='<a href="index.php?component=agama"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Agama</a>'
menu2[10]='<a href="index.php?component=status"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Status</a>'
menu2[11]='<a href="index.php?component=skontrak"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Status Kontrak</a>'
menu2[12]='<a href="index.php?component=jcuti"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Cuti</a>'
menu2[13]='<a href="index.php?component=jatahcuti"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pengaturan Cuti</a>'
menu2[14]='<a href="index.php?component=jenismedis"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Medis</a>'
menu2[15]='<a href="index.php?component=alokasimedis"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Alokasi Medis</a>'
menu2[16]='<a href="index.php?component=komponengaji"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Komponen Gaji</a>'
menu2[17]='<a href="index.php?component=alokasikgaji"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Alokasi Komponen Gaji</a>'*/
/*var menu10=new Array()
menu10[0]='<a href="index.php?component=main_service">Main Service List</a>'
menu10[1]='<a href="index.php?component=additional_service">Additional Service List</a>'
menu10[2]='<a href="index.php?component=request_changeservice">Request Change Service</a>'
menu10[3]='<a href="index.php?component=request_changeservice&task=add">Add Request Change Service</a>'*/

var menu3=new Array()

<?php if(strstr($_SESSION['akses'],'stokbarang')) { ?>
//menu3[5]='<a href="index-c-stokbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Stok Barang</a>'
<?php } ?>
/*menu3[4]='<a href="index.php?component=tindakan_medispasien"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Tindakan Medis Pasien</a>'
menu3[5]='<a href="index.php?component=rekam_medis&task=add" style="border-top:solid 2px #ffffff;"><img src="images/add.png" align="left" hspace="1" vspace="4"> Rekam Medis Baru</a>'
menu3[5]='<a href="index.php?component=cutikaryawan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Cuti Karyawan</a>'
menu3[6]='<a href="index.php?component=tugas"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Surat Tugas</a>'
menu3[8]='<a href="index.php?component=kmedis"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Klaim Medis</a>'
menu3[10]='<a href="index.php?component=lembur"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Surat Ijin Lembur</a>'
menu3[14]='<a href="index.php?component=penghargaan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Penghargaan Karyawan</a>'
menu3[16]='<a href="index.php?component=peringatan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Peringatan Karyawan</a>'
menu3[18]='<a href="index.php?component=resign"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Berhenti Kerja</a>'*/

var menu4=new Array()
<?php if(strstr($_SESSION['akses'],'invoicepembelian')) { ?>
menu4[0]='<a href="index-c-invoicepembelian.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Pembelian</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'hutangjtempo')) { ?>
menu4[1]='<a href="index-c-hutangjtempo.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pembayaran Hutang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'pembayaranhutang')) { ?>
menu4[2]='<a href="index-c-pembayaranhutang.pos" style="border-bottom:solid 2px #FFF;"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Hutang Lunas</a>'
<?php } ?>
<?php /* if(strstr($_SESSION['akses'],'barangmasuk')) { ?>
menu4[3]='<a href="index-c-barangmasuk.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Penerimaan Barang</a>'
<?php } */ ?>
<?php if(strstr($_SESSION['akses'],'barangreturmasuk')) { ?>
menu4[4]='<a href="index-c-barangreturmasuk.pos" style="border-bottom:solid 2px #FFF;"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Retur Penerimaan Barang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'add_invoicepembelian')) { ?>
//menu4[5]='<a href="index-c-invoicepembelian-t-add.pos"><img src="images/add.png" align="left" hspace="1" vspace="4"> Pembelian Baru</a>'
<?php } ?>
/*menu4[4]='<a href="index.php?component=prorate_downtime">Prorate Downtime</a>'
menu4[5]='<a href="index.php?component=prorate">Prorate Upgrade / Downgrade</a>'
menu4[8]='<a href="billableitems.php?status=Uninvoiced"> - Uninvoiced Items</a>'
menu4[9]='<a href="billableitems.php?status=Recurring"> - Recurring Items</a>'
menu4[10]='<a href="billableitems.php?action=manage"> - Add New</a>'
menu4[11]='<a href="quotes.php">List All Quotes</a>'
menu4[12]='<a href="quotes.php?validity=Valid"> - Valid Quotes</a>'
menu4[13]='<a href="quotes.php?validity=Expired"> - Expired Quotes</a>'
menu4[14]='<a href="quotes.php?action=manage"> - Create New</a>'
*/
var menu5=new Array()
<?php if(strstr($_SESSION['akses'],'invoicepenjualan')) { ?>
menu5[0]='<a href="index-c-invoicepenjualan.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Penjualan</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'piutangjtempo')) { ?>
menu5[1]='<a href="index-c-piutangjtempo.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Data Piutang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'pembayaranpiutang')) { ?>
menu5[2]='<a href="index-c-pembayaranpiutang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pembayaran Lunas</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'pembayaranpiutang')) { ?>
//menu5[3]='<a href="index-c-specialorder.pos" style="border-bottom:solid 2px #FFF;"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Special Order</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'barangkeluar')) { ?>
//menu5[4]='<a href="index-c-barangkeluar.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pengiriman Barang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'barangreturkeluar')) { ?>
//menu5[5]='<a href="index-c-barangreturkeluar.pos" style="border-bottom:solid 2px #FFF;"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Retur Pengiriman Barang</a>'
<?php } ?>
/*menu5[3]='<a href="index.php?component=absensi&task=add" style="border-top:solid 2px #ffffff;"><img src="images/add.png" align="left" hspace="1" vspace="4"> Absensi</a>'
menu5[4]='<a href="index.php?component=gajikaryawan&task=add"><img src="images/add.png" align="left" hspace="1" vspace="4"> Gaji Karyawan</a>'*/
<?php if(strstr($_SESSION['akses'],'add_invoicepenjualan')) { ?>
menu5[6]='<a href="index-c-invoicepenjualan-t-add.pos"><img src="images/add.png" align="left" hspace="1" vspace="4"> Penjualan Baru</a>'
<?php } ?>

var menu6=new Array()
<?php if(strstr($_SESSION['akses'],'reportjualper_pm')) { ?>
menu6[0]='<a href="index-c-reportjualper_pm.pos"><img src="images/data_tables.png" align="left" hspace="1" vspace="4"/> Rekap Penjualan per Sales</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'reportjualper_customer')) { ?>
menu6[1]='<a href="index-c-reportjualper_customer.pos"><img src="images/data_tables.png" align="left" hspace="1" vspace="4"/> Rekap Penjualan per Customer</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'reportjualper_barang')) { ?>
menu6[2]='<a href="index-c-reportjualper_barang.pos"><img src="images/data_tables.png" align="left" hspace="1" vspace="4"/> Rekap Penjualan per Barang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'reportrugilaba')) { ?>
menu6[3]='<a href="index-c-reportrugilaba.pos"><img src="images/data_tables.png" align="left" hspace="1" vspace="4"/> Rekap Rugilaba per Bulan</a>'
<?php } ?>
/**/

/*var menu11=new Array()
menu11[0]='<a href="index.php?component=server">Server List</a>'
menu11[1]='<a href="index.php?component=rack">Rack Server Allocation</a>'
//Reporting Menu 
var menu12=new Array()
menu12[0]='<a href="index.php?component=annual_summary">Annual Report ( Summary )</a>'
menu12[1]='<a href="index.php?component=monthly_summary">Monthly Report ( Summary )</a>'*/

//Switch, Port, n IP Menu
var menu7=new Array()
<?php if(strstr($_SESSION['akses'],'pembayaranhutang')) { ?>
//menu7[0]='<a href="index-c-pembayaranhutang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pembayaran Hutang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'pembayaranpiutang')) { ?>
//menu7[1]='<a href="index-c-pembayaranpiutang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pembayaran Piutang</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'biayaops')) { ?>
menu7[2]='<a href="index-c-biayaops.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Biaya Operasional</a>'
<?php } ?>
/*menu7[3]='<a href="index.php?component=bantuan&task=personalia"><img src="images/notice.png" align="left" hspace="1" vspace="4"/> Bantuan Personalia</a>'
menu7[4]='<a href="index.php?component=bantuan&task=penggajian"><img src="images/notice.png" align="left" hspace="1" vspace="4"/> Bantuan Penggajian</a>'
menu7[5]='<a href="index.php?component=bantuan&task=personalia"><img src="images/notice.png" align="left" hspace="1" vspace="4"/> Bantuan Laporan</a>'

var menu8=new Array()
menu8[0]='<a href="index.php?component=client_payment">Client Payment</a>'
menu8[1]='<a href="index.php?component=client_outstanding">Client Outstanding</a>'
menu8[2]='<a href="index.php?component=client_payment&task=add">Create New Payment</a>'
menu8[3]='<a href="index.php?component=comming_project">Comming Soon Project</a>'
menu8[4]='<a href="index.php?component=l_tunjpotji">Tunjangan, Potongan, & Gaji</a>'
menu8[4]='<a href="index.php?component=payment_method">Payment Method</a>'
menu8[5]='<a href="index.php?component=shipping_agent">Shipping Agent</a>'
menu8[6]='<a href="index.php?component=user_admin">User Admin</a>'
menu8[7]='<a href="index.php?component=karyawan">Employee</a>'
menu8[2]='<a href="configemailtemplates.php">Email Templates</a>'
menu8[3]='<a href="configfraud.php">Fraud Protection</a>'
menu8[4]='<a href="configclientgroups.php">Client Groups</a>'
menu8[5]='<a href="configcustomfields.php">Custom Client Fields</a>'
menu8[6]='<a href="configadmins.php">Administrators</a>'
menu8[7]='<a href="configadminroles.php">Administrator Roles</a>'
menu8[8]='<a href="configcurrencies.php">Currencies</a>'
menu8[9]='<a href="configgateways.php">Payment Gateways</a>'
menu8[10]='<a href="configtax.php">Tax Rules</a>'
menu8[11]='<a href="configpromotions.php">Promotions</a>'
menu8[12]='<a href="configproducts.php">Products/Services</a>'
menu8[13]='<a href="configproductoptions.php">Configurable Options</a>'
menu8[14]='<a href="configaddons.php">Product Addons</a>'
menu8[15]='<a href="configdomains.php">Domain Pricing</a>'
menu8[16]='<a href="configregistrars.php">Domain Registrars</a>'
menu8[17]='<a href="configservers.php">Servers</a>'
menu8[18]='<a href="configticketdepartments.php">Support Departments</a>'
menu8[19]='<a href="configticketstatuses.php">Ticket Statuses</a>'
menu8[20]='<a href="configticketescalations.php">Escalation Rules</a>'
menu8[21]='<a href="configticketspamcontrol.php">Spam Control</a>'
menu8[22]='<a href="configsecurityqs.php">Security Questions</a>'
menu8[23]='<a href="configbannedips.php">Banned IPs</a>'
menu8[24]='<a href="configbannedemails.php">Banned Emails</a>'
menu8[25]='<a href="configbackups.php">Database Backups</a>'

var menu9=new Array()
menu9[0]='<a href="index.php?component=request_suspend">Request Suspend Server</a>'
menu9[1]='<a href="index.php?component=request_suspend&task=add">Add Request Suspend Server</a>'
menu9[2]='<a href="index.php?component=re_active">Request Re-Activation</a>'
menu9[3]='<a href="index.php?component=re_active&task=add">Add Request Re-Activation</a>'
*/

var menu11 = new Array()
<?php if(strstr($_SESSION['akses'],'jenisbarang')) { ?>
menu11[0]='<a href="index-c-jenisbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jenis Brand</a>'
<?php } ?>
<?php if(strstr($_SESSION['akses'],'masterbarang')) { ?>
menu11[1]='<a href="index-c-masterbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Master Barang</a>'
menu11[2]='<a href="index-c-report_masterbarang.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Laporan Master Barang</a>'
//menu2[3]='<a href="index-c-report_kartustock.pos"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Kartu Stock</a>'
<?php } ?>

var menu12 = new Array();

var menuwidth='200px' //default menu width
var menubgcolor='#E7EDF4'  //menu bgcolor
var disappeardelay=250  //menu disappear speed onMouseout (in miliseconds)
var hidemenu_onclick="yes" //hide menu when user clicks within menu?

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6)
document.write('<div id="dropmenudiv" style="visibility:hidden;width:'+menuwidth+';background-color:'+menubgcolor+'" onMouseover="clearhidemenu()" onMouseout="dynamichide(event)"></div>')

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}


function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top="-500px"
if (menuwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
}
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)

dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function hidemenu(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.visibility="hidden"
}
}

function delayhidemenu(){
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
document.onclick=hidemenu
</script>