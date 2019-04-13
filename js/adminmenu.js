var menu1=new Array()
menu1[0]='<a href="index.php?component=karyawan&aktif=1"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Karyawan</a>'
menu1[1]='<a href="index.php?component=karyawan&aktif=0"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Karyawan Inaktif</a>'
menu1[2]='<a href="index.php?component=keluarga"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Keluarga</a>'
menu1[3]='<a href="index.php?component=pendidikan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Pendidikan</a>'
/*menu1[1]='<a href="index.php?component=to_do" title="View task job order" style="border-bottom:solid 1px #fff;"><img src="images/task.png" align="left" hspace="1" vspace="4"/> Task Job Order</a>'
menu1[2]='<a href="index.php?component=req_job_order&task=add" title="Create new request job order"><img src="images/edit-icon.png" align="left" hspace="1" vspace="4"/> New Request Job Order</a>'
menu1[3]='<a href="index.php?component=to_do&task=add" title="Create new task job order"><img src="images/edit-icon.png" align="left" hspace="1" vspace="4"/> New Task Job Order</a>'
menu1[4]='<a href="index.php?component=currency">Data Currency</a>'
menu1[5]='<a href="index.php?component=p_method">Data Payment Method</a>'*/

var menu2=new Array()
menu2[1]='<a href="index.php?component=user"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Setting User</a>'
menu2[2]='<a href="index.php?component=departemen"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Departemen</a>'
menu2[3]='<a href="index.php?component=subdepartemen"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Sub Departemen</a>'
menu2[4]='<a href="index.php?component=jabatan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Jabatan</a>'
menu2[5]='<a href="index.php?component=shift"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Shift</a>'
menu2[6]='<a href="index.php?component=groupshift"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Group Shift</a>'
menu2[7]='<a href="index.php?component=bank"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Bank</a>'
menu2[8]='<a href="index.php?component=agama"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Agama</a>'
menu2[9]='<a href="index.php?component=status"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Status</a>'
menu2[10]='<a href="index.php?component=skontrak"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Status Kontrak</a>'
/*menu2[5]='<a href="index.php?component=list_company">List Company</a>'
menu2[6]='<a href="index.php?component=list_client">Data Customer</a>'

menu2[0]='<a href="index.php?component=employee">Data Employee</a>'
menu2[4]='<a href="clientshostinglist.php?type=hostingaccount">List Hosting Accounts</a>'
menu2[5]='<a href="clientshostinglist.php?type=reselleraccount">List Reseller Accounts</a>'
menu2[6]='<a href="clientshostinglist.php?type=server">List Server Accounts</a>'
menu2[7]='<a href="clientshostinglist.php?type=other">List Other Services</a>'
menu2[8]='<a href="clientsaddonslist.php">List Account Addons</a>'
menu2[9]='<a href="clientsdomainlist.php">List Domains</a>'
menu2[10]='<a href="cancelrequests.php">Cancellation Requests</a>'
menu2[11]='<a href="affiliates.php">Manage Affiliates</a>'*/

var menu10=new Array()
menu10[0]='<a href="index.php?component=main_service">Main Service List</a>'
menu10[1]='<a href="index.php?component=additional_service">Additional Service List</a>'
menu10[2]='<a href="index.php?component=request_changeservice">Request Change Service</a>'
menu10[3]='<a href="index.php?component=request_changeservice&task=add">Add Request Change Service</a>'

var menu3=new Array()
menu3[0]='<a href="index.php?component=kontrak"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Karir Karyawan</a>'
menu3[1]='<a href="index.php?component=penghargaan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Penghargaan Karyawan</a>'
menu3[2]='<a href="index.php?component=peringatan"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Peringatan Karyawan</a>'
menu3[3]='<a href="index.php?component=resign"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Berhenti Kerja</a>'
/*menu3[1]='<a href="index.php?component=list_order&task=loffice"> -- List Order by Office</a>'
menu3[2]='<a href="index.php?component=list_order&task=lvendor"> -- List Order by Vendor</a>'
menu3[3]='<a href="index.php?component=list_order&task=lagen"> -- List Order by Agen</a>'
menu3[4]='<a href="index.php?component=list_order&task=lcompany"> -- List Order by Company</a>'
menu3[5]='<a href="index.php?component=list_order&task=lclient"> -- List Order by Client</a>'
menu3[6]='<a href="index.php?component=list_order&task=lcurrency"> -- List Order by Currency</a>'
menu3[7]='<a href="index.php?component=list_order&task=lpmethod"> -- List Order by Payment Method</a>'
menu3[4]='<a href="index.php?component=list_refund">Refund Order</a>'*/
/*menu3[5]='<a href="index.php?component=list_order&task=add">Create New Invoice</a>'
menu3[2]='<a href="index.php?component=cutting_stock">Stock Cutting</a>'

menu3[3]='<a href="orders.php?status=Fraud">List Fraud Orders</a>'
menu3[4]='<a href="orders.php?status=Cancelled">List Cancelled Orders</a>'
menu3[5]='<a href="ordersadd.php">Place New Order</a>'*/

var menu4=new Array()
menu4[0]='<a href="index.php?component=requestjob&aktif=new"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Request Job New</a>'
menu4[1]='<a href="index.php?component=requestjob&aktif=process"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Request Job Process</a>'
menu4[2]='<a href="index.php?component=requestjob&aktif=done"><img src="images/invoices.png" align="left" hspace="1" vspace="4"/> Request Job Done</a>'
menu4[3]='<a href="index.php?component=requestjob&task=add" style="border-top:solid 1px #ffffff;"><img src="images/add.png" align="left" hspace="1" vspace="4"> Create New Request</a>'
/*menu4[4]='<a href="index.php?component=prorate_downtime">Prorate Downtime</a>'
menu4[5]='<a href="index.php?component=prorate">Prorate Upgrade / Downgrade</a>'
menu4[8]='<a href="billableitems.php?status=Uninvoiced"> - Uninvoiced Items</a>'
menu4[9]='<a href="billableitems.php?status=Recurring"> - Recurring Items</a>'
menu4[10]='<a href="billableitems.php?action=manage"> - Add New</a>'
menu4[11]='<a href="quotes.php">List All Quotes</a>'
menu4[12]='<a href="quotes.php?validity=Valid"> - Valid Quotes</a>'
menu4[13]='<a href="quotes.php?validity=Expired"> - Expired Quotes</a>'
menu4[14]='<a href="quotes.php?action=manage"> - Create New</a>'*/

var menu5=new Array()
menu5[0]='<a href="index.php?component=invoice">All Invoice</a>'
menu5[1]='<a href="index.php?component=comming_invoice">Comming Sooon Invoice</a>'
menu5[2]='<a href="index.php?component=active_invoice">Active Invoice</a>'
menu5[3]='<a href="index.php?component=passed_invoice">Passed Invoice</a>'
/*menu5[3]='<a href="index.php?component=biaya">Biaya Pengobatan Karyawan</a>'
menu5[4]='<a href="index.php?component=hutang">Hutang Karyawan</a>'
menu5[5]='<a href="index.php?component=sp">Surat Peringatan Karyawan</a>'
menu5[6]='<a href="index.php?component=resign">Surat Resign Karyawan</a>'
menu5[0]='<a href="supportannouncements.php">Announcements</a>'
menu5[1]='<a href="supportdownloads.php">Downloads</a>'
menu5[2]='<a href="supportkb.php">Knowledgebase</a>'
menu5[3]='<a href="supporttickets.php">Support Tickets</a>'
menu5[4]='<a href="supporttickets.php?action=open">Open New Ticket</a>'
menu5[5]='<a href="supportticketpredefinedreplies.php">Predefined Replies</a>'
menu5[6]='<a href="supporttickets.php?view=flagged"> - My Flagged Tickets</a>'
menu5[7]='<a href="supporttickets.php?view=active"> - All Active Tickets</a>'
menu5[8]='<a href="supporttickets.php?view=Open"> - Open</a>'
menu5[9]='<a href="supporttickets.php?view=Answered"> - Answered</a>'
menu5[10]='<a href="supporttickets.php?view=Customer-Reply"> - Customer-Reply</a>'
menu5[11]='<a href="supporttickets.php?view=On Hold"> - On Hold</a>'
menu5[12]='<a href="supporttickets.php?view=In Progress"> - In Progress</a>'
menu5[13]='<a href="supporttickets.php?view=Closed"> - Closed</a>'
menu5[14]='<a href="networkissues.php">Network Issues</a>'
menu5[15]='<a href="networkissues.php"> - Open</a>'
menu5[16]='<a href="networkissues.php?view=scheduled"> - Scheduled</a>'
menu5[17]='<a href="networkissues.php?view=resolved"> - Resolved</a>'
menu5[18]='<a href="networkissues.php?action=manage"> - Add New</a>'*/

var menu6=new Array()
menu6[0]='<a href="index.php?component=list_company">List Company</a>'
menu6[1]='<a href="index.php?component=list_client">List Client</a>'
/*menu6[2]='<a href="index.php?component=storage_consigment">Consigment Data Storage</a>'
menu6[3]='<a href="index.php?component=storage_stock">Stock Material</a>'
menu6[3]='<a href="index.php?component=l_sp">Surat Peringatan Karyawan</a>'
menu6[4]='<a href="index.php?component=l_resign">Surat Resign Karyawan</a>'
menu6[3]='<a href="index.php?component=server">Server List</a>'
menu6[3]='<a href="index.php?component=server">Server List</a>'
menu6[4]='<a href="reports.php?report=supporttickets">Support Tickets Sum.</a>'
menu6[5]='<a href="reports.php?report=promotionssummary">Promotions Summary</a>'
menu6[6]='<a href="reports.php?report=usagesummary">Disk Space & BW Usage</a>'
menu6[7]='<a href="reports.php?report=dailyperformance">Daily Performance</a>'
menu6[8]='<a href="reports.php?report=top10clientsinvoices">Top 10 Clients by Income</a>'*/

var menu11=new Array()
menu11[0]='<a href="index.php?component=server">Server List</a>'
menu11[1]='<a href="index.php?component=rack">Rack Server Allocation</a>'
//Reporting Menu 
var menu12=new Array()
menu12[0]='<a href="index.php?component=annual_summary">Annual Report ( Summary )</a>'
menu12[1]='<a href="index.php?component=monthly_summary">Monthly Report ( Summary )</a>'

//Switch, Port, n IP Menu
var menu7=new Array()
menu7[0]='<a href="index.php?component=report_order">Invoice Pending & Due Date</a>'
menu7[1]='<a href="index.php?component=report_payment">Invoice Paid</a>'
menu7[2]='<a href="index.php?component=report_outstanding">Customer Outstanding</a>'
/*menu7[3]='<a href="systemintegrationcode.php">Integration Code</a>'
menu7[8]='<a href="whmimport.php">cPanel/WHM Import</a>'
menu7[9]='<a href="systemdatabase.php">Database Status</a>'
menu7[10]='<a href="systemcleanup.php">System Cleanup</a>'
menu7[11]='<a href="systemphpinfo.php">PHP Info</a>'
menu7[12]='<a href="systemactivitylog.php">Activity Log</a>'
menu7[13]='<a href="systemadminlog.php">Admin Log</a>'
menu7[14]='<a href="systememaillog.php">Email Message Log</a>'
menu7[15]='<a href="systemmailimportlog.php">Ticket Mail Import Log</a>'
menu7[16]='<a href="systemwhoislog.php">WHOIS Lookup Log</a>'*/

var menu8=new Array()
menu8[0]='<a href="index.php?component=client_payment">Client Payment</a>'
menu8[1]='<a href="index.php?component=client_outstanding">Client Outstanding</a>'
menu8[2]='<a href="index.php?component=client_payment&task=add">Create New Payment</a>'
/*menu8[3]='<a href="index.php?component=comming_project">Comming Soon Project</a>'
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
menu8[25]='<a href="configbackups.php">Database Backups</a>'*/

var menu9=new Array()
menu9[0]='<a href="index.php?component=request_suspend">Request Suspend Server</a>'
menu9[1]='<a href="index.php?component=request_suspend&task=add">Add Request Suspend Server</a>'
menu9[2]='<a href="index.php?component=re_active">Request Re-Activation</a>'
menu9[3]='<a href="index.php?component=re_active&task=add">Add Request Re-Activation</a>'


var menuwidth='170px' //default menu width
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