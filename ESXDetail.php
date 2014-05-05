<?php
/*
Labtech Vitals Dashboard
Description: A dashboard to be used during Control Center loading as a splash page quick view of the state of the customer base.

By:Squidworks Inc  (http://www.squidworks.net)
Dev: Shannon Anderson
Date: 9/29/2013
Email: sanderson@squidworks.net
*/
if(isset($_GET['CMD'])){$CMD = $_GET['CMD'];}
if(isset($_GET['ID'])){$ID = $_GET['ID'];}
include("header.php");
$ESXHOSTS = getLTESXDetail($ltserver,$ltuser,$ltpass,$ltdb);
$ESXHOSTFAILURE = getLTESXHardwareFailureDetail($ltserver,$ltuser,$ltpass,$ltdb);
$ESXHOSTMISSING = getLTESXHardwareMissingDetail($ltserver,$ltuser,$ltpass,$ltdb);
#print_r($ESXHOSTFAILURE);
?>

<div id=banner><h1>VMWare ESX Status Dashboard</h1></div>
<div id=onlinevitals>
<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td ><fieldset><legend>System Hardware Health Failures</legend>
<h1></h1>
	<table width="100%" cellpadding=5 cellspacing=5 border=0>

<?php
if(count($ESXHOSTFAILURE) != 0){	
	echo "<tr><th>ESX HOST</th><th>Monitor</th><th>Status</th><th>Last Enquiry</th></tr>";
	foreach($ESXHOSTFAILURE AS $Systems => $computer){
		echo "<tr><td width=110 align=left><a href=ESXDetail.php?CMD=ESXFAILURE&ID=".$computer['ESXHOST'].">".$computer['ESXHOST']."</a></td><td width=100 align=left>".$computer['Monitor']."</td><td align=left>".$computer['ESXHOSTSTATUS']."</td><td>".$computer['ESXHOSTSCAN']."</td></tr>";
	}
}else{
echo "<tr><td><h3>No Host Failures Reported</h3></td></tr>";
}
?>
</table>

</fieldset></td>
</tr></table>

<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td ><fieldset><legend>Missing ESX Status Reports</legend>
<h1></h1>
	<table width="100%" cellpadding=5 cellspacing=5 border=0>

<?php
if(count($ESXHOSTMISSING) != 0){	
	echo "<tr><th>ESX HOST</th><th>Monitor</th><th>Status</th><th>Last Enquiry</th></tr>";
	foreach($ESXHOSTMISSING AS $Systems => $computer){
		echo "<tr><td width=110 align=left><a href=ESXDetail.php?CMD=ESXFAILURE&ID=".$computer['ESXHOST'].">".$computer['ESXHOST']."</a></td><td width=100 align=left>".$computer['Monitor']."</td><td align=left>".$computer['ESXHOSTSTATUS']."</td><td>".$computer['ESXHOSTSCAN']."</td></tr>";
	}
}else{
echo "<tr><td><h3>No Missing Host Reported</h3></td></tr>";
}
?>
</table>

</fieldset></td>
</tr></table>

<table width="90%" align=center cellpadding=5 cellspacing=15 border=0>
<tr valign=top>
<td ><fieldset><legend>System Hardware Health Current Status</legend>
<h1></h1>
	<table width="100%" cellpadding=0 cellspacing=5 border=0>

<?php
if(count($ESXHOSTS) != 0){	
	echo "<tr><th>ESX HOST</th><th>Monitor</th><th>Status</th><th>Last Enquiry</th></tr>";
	foreach($ESXHOSTS AS $Systems => $computer){
		echo "<tr><td width=110 align=left><a href=ESXDetail.php?CMD=ESXFAILURE&ID=".$computer['ESXHOST'].">".$computer['ESXHOST']."</a></td><td width=100 align=left>".$computer['Monitor']."</td><td align=left>".$computer['ESXHOSTSTATUS']."</td><td>".$computer['ESXHOSTSCAN']."</td></tr>";
	}
}else{
echo "<tr><td><h3>No Host Reported</h3></td></tr>";
}
?>
</table>

</fieldset></td>
</tr></table>

</div>




<?php

include("footer.php");
?>