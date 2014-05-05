<?php
/*
Labtech Vitals Dashboard
Description: A dashboard to be used during Control Center loading as a splash page quick view of the state of the customer base.

By:Squidworks Inc  (http://www.squidworks.net)
Dev: Shannon Anderson
Date: 9/29/2013
Email: sanderson@squidworks.net
*/

include("header.php");
$LastMissingSP = getLastMissingSPCount($ltserver,$ltuser,$ltpass,$ltdb);
$LastOutOfDate = getWindowsUpdateCount($ltserver,$ltuser,$ltpass,$ltdb);
$LastDriveSpace = getLastDriveSpaceCount($ltserver,$ltuser,$ltpass,$ltdb);
$LastReoccuring = getLastReoccuringCriticalCount($ltserver,$ltuser,$ltpass,$ltdb);
$HMPThreatCount = getHMPCurrentThreatCount($ltserver,$ltuser,$ltpass,$ltdb);
$HMPScanCount = getHitmanDailyScanCount($ltserver,$ltuser,$ltpass,$ltdb);
$OfflineServers = getOfflineServers($ltserver,$ltuser,$ltpass,$ltdb);
$OfflineCoreCount = getOfflineCoreCount($ltserver,$ltuser,$ltpass,$ltdb);
$CriticalPatchesMissing = getLTCriticalHotfixFail($ltserver,$ltuser,$ltpass,$ltdb);
$CriticalPatchesMissingCount = count($CriticalPatchesMissing);
$MacCount = getLTMacSystemCount($ltserver,$ltuser,$ltpass,$ltdb);
$AVCount = getLTAVScannerCount($ltserver,$ltuser,$ltpass,$ltdb);
$MacAVCount = getLTMacAVScannerCount($ltserver,$ltuser,$ltpass,$ltdb);
$WindowsCount = getLTComputerCountNoMacs($ltserver,$ltuser,$ltpass,$ltdb);
$LinuxCount = getLTLinuxCount($ltserver,$ltuser,$ltpass,$ltdb);

# If you have installed the ESX Health Monitor V2+ and or Appassure Probe then uncomment the next 5 lines
# removing the (#) from in front of function call.

#$Appassure = getBackupStatus($ltserver,$ltuser,$ltpass,$ltdb);
#$AppassureFailed = getAppassureFailStatusCount($ltserver,$ltuser,$ltpass,$ltdb);
#$ESXHOSTS = getLTESXCount($ltserver,$ltuser,$ltpass,$ltdb);
#$ESXHOSTFAILURE = getLTESXHardwareFailureCount($ltserver,$ltuser,$ltpass,$ltdb);
#$ESXHSOTMISSING = getLTESXHardwareMissingCount($ltserver,$ltuser,$ltpass,$ltdb);


if($LinuxCount == ""){$LinuxCount = 0;}
if($WindowsCount == ""){$WindowsCount = 0;}
if($AVCount == ""){$AVCount = 0;}
if($MacCount == ""){$MacCount = 0;}
?>
<div id=banner><h1>Vitals Dashboard</h1></div>
<div id=onlinevitals>
<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td width=20% ><fieldset><legend>Windows Agents Online</legend>
<h1><?php echo $WindowsCount; ?></h1>
</fieldset></td>
<td width=20% ><fieldset><legend>Macs Agents Online</legend>
<h1><?php echo $MacCount; ?></h1>
</fieldset></td>
<td width=20% ><fieldset><legend>Linux Agents Online</legend>
<h1><?php echo $LinuxCount; ?></h1>
</fieldset></td>
<td width=20% ><fieldset><legend>Windows Missing AV</legend>
<a href="AV.php"><h1><?php echo $AVCount;  ?></h1></a>
</fieldset></td>
<td width=20% ><fieldset><legend>Macs Missing AV</legend>
<h1><?php echo $MacAVCount;  ?></h1>
</fieldset></td>
</tr></table>
<br>
<table width="90%" align=center cellpadding=0 cellspacing=15 border=0>
<tr valign=top>
<td width=20% ><fieldset><legend>Offline Backup Cores</legend>
<h1><?php echo $OfflineCoreCount; ?></h1>
</fieldset></td>
<td width=20% ><fieldset><legend>Agents Missing Patches</legend>
<a href="missinghotfix.php"><h1><?php echo $CriticalPatchesMissingCount ?></h1></a>
</fieldset></td>
<td width=20% ><fieldset><legend>3+ Critical Patches</legend>
<?php
	$CriticalPatchCountOver3 = 0;
	foreach($CriticalPatchesMissing AS $hotfix => $computer){
		if($computer['Failed'] >= 3){$CriticalPatchCountOver3++;}
	}

?>
<h1><?php echo $CriticalPatchCountOver3; ?></h1>
</fieldset></td>
<td width=20% ><fieldset><legend>Servers / Failures Today</legend>
<a href="appassure.php"><h1><?php
$snaps = count($Appassure);
echo $snaps."/".$AppassureFailed;
   ?></h1></a>
</fieldset></td>
<td width=20% ><fieldset><legend>ESX Hosts/Failed/Missing</legend>
<a href="ESXDetail.php">
<h1><?php echo $ESXHOSTS."/".$ESXHOSTFAILURE."/".$ESXHSOTMISSING; ?></h1>
</a>
</fieldset></td>
</tr></table>
<br>


<table width="90%" cellpadding=2 cellspacing=2 border=0><tr valign=top><td width=50%>

    <table width="400" cellpadding=2 cellspacing=15 align=center>
	<tr><td ><fieldset><legend>HitmanPRO Threats Last 24 hours</legend><a href="hitmanpro.php"><h1><?php echo $HMPThreatCount; ?></h1></a></fieldset>
	</td>
	<td ><fieldset><legend>HitmanPro Scans last 24 hours</legend><a href="hitmanpro.php"><h1><?php echo $HMPScanCount; ?></h1></a></fieldset>
	</td></tr></table>
    <table width="400" cellpadding=2 cellspacing=15 align=center>
	<tr><td ><fieldset><legend>Agents With High Reoccurring Logs</legend><a href="alerts.php?CMD=REOCCURINGLOGS"><h1><?php echo $LastReoccuring; ?></h1></a></fieldset>
	</td>
	<td ><fieldset><legend>Agents With Low Disk Space</legend><a href="alerts.php?CMD=DISKSPACE"><h1><?php echo $LastDriveSpace; ?></h1></a></fieldset>
	</td></tr></table>
	    <table width="400" cellpadding=2 cellspacing=15 align=center>
	<tr><td ><fieldset><legend>Agents Not Patched for 30+ Days</legend><a href="alerts.php?CMD=NOPATCH"><h1><?php echo $LastOutOfDate; ?></h1></a></fieldset>
	</td>
	<td ><fieldset><legend>Agents Missing Service Packs</legend><a href="alerts.php?CMD=MISSINGSP"><h1><?php echo $LastMissingSP; ?></h1></a></fieldset>
	</td></tr></table>
</td><td width=50%>

    <table width="400" cellpadding=2 cellspacing=12>
	<tr><td align=left><fieldset><legend>Offline Server Alarms</legend><br>&nbsp;Either the server or LT agent is has not checked in in the last 10 minutes.
	<table cellpadding=5 cellspacing=2><tr><th>Name</th><th>Domain</th><th>Last Check In</th></tr>
<?php

foreach($OfflineServers AS $Offline => $Server){
        echo "<tr><td><img src=\"red-arrow.gif\">&nbsp;".$Server['Name'] ."</td><td>".$Server['Domain']."</td><td>";
        echo $Server['LastContact']."</td></tr>";

}

?>

	</table><br></fieldset>
	</td></tr></table>



</td></tr></table>
</div>   
   
<?php
include("footer.php");
?>  
 