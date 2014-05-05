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

if($CMD == "LISTPATCHES"){
	$CriticalPatchesMissing = getLTComputerHotfixFailures($ltserver,$ltuser,$ltpass,$ltdb,$ID);
?>

	<div id=banner><h1>Missing Hotfixes Dashboard</h1></div>
	<div id=onlinevitals>
	<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
	<tr valign=top>
	<td ><fieldset><legend>Missing Critical Patches</legend>
	<h1></h1>
	<table width="100%" cellpadding=0 cellspacing=5 border=0 align=left>
<?php
	foreach($CriticalPatchesMissing AS $hotfix => $computer){
		echo "<tr><td align=left><b>".$computer['Title']."</b></td></tr><tr><td align=left>".$computer['Description']."</td></tr><tr><td>&nbsp;</td></tr>";
	}
?>
	</table>

	</fieldset></td>
	</tr></table>
	</div>

<?php
}else{
$CriticalPatchesMissing = getLTCriticalHotfixFail($ltserver,$ltuser,$ltpass,$ltdb);
?>

<div id=banner><h1>Missing Hotfixes Dashboard</h1></div>
<div id=onlinevitals>
<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td ><fieldset><legend>Systems Missing Critical Patches</legend>
<h1></h1>
	<table width="100%" cellpadding=0 cellspacing=5 border=0>
	<tr><th>Name</th><th>Domain</th><th>Last Check In</th><th>Missing Patches</th></tr>
<?php
foreach($CriticalPatchesMissing AS $hotfix => $computer){
	echo "<tr><td width=20%><a href=missinghotfix.php?CMD=LISTPATCHES&ID=".$computer['ComputerID'].">".$computer['Name']."</a></td><td width=30%>".$computer['Domain']."</td><td>".$computer['LastContact']."</td><td>".$computer['Failed']."</td></tr>";
}
?>
</table>

</fieldset></td>
</tr></table>
</div>




<?php
}
include("footer.php");
?>