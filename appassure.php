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
$AppassureSnaps = getBackupStatusDetail($ltserver,$ltuser,$ltpass,$ltdb);
$AppassureFails = getAppassureFailStatus($ltserver,$ltuser,$ltpass,$ltdb);
?>

<div id=banner><h1>Replay Completed Backup Snapshots Dashboard</h1></div>
<div id=onlinevitals>
<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td ><fieldset><legend>Snapshot Failure Today</legend>
<h1></h1>
	<table width="100%" cellpadding=0 cellspacing=5 border=0>
	<tr><th>Server Name</th><th>Core</th><th>Date Failed</th><th>Failure</th></tr>
<?php
foreach($AppassureFails AS $Systems => $computer){
	echo "<tr><td width=100 align=left><a href=appassure.php?CMD=GRAPHFAIL&ID=".$computer['serverName'].">".$computer['serverName']."</a></td><td width=100 align=left>".$computer['coreName']."</td><td>".$computer['dateFailed']."</td><td align=left>".$computer['lastFailure']."</td></tr>";
}
?>
</table>

</fieldset></td>
</tr>


<tr valign=top>
<td ><fieldset><legend>Systems Snapshots Taken</legend>
<h1></h1>
	<table width="100%" cellpadding=0 cellspacing=5 border=0>
	<tr><th>Server Name</th><th>Core</th><th>Last Snapshot</th></tr>
<?php
foreach($AppassureSnaps AS $Systems => $computer){
	echo "<tr><td width=20%><a href=appassure.php?CMD=ALLSNAPS&ID=".$computer['serverName'].">".$computer['serverName']."</a></td><td width=30%>".$computer['coreName']."</td><td>".$computer['lastSnapshot']."</td></tr>";
}
?>
</table>

</fieldset></td>
</tr></table>
</div>




<?php

include("footer.php");
?>