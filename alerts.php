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
if(isset($_GET['ClientID'])){$ClientID = $_GET['ClientID'];}
if(isset($_GET['ID'])){$ComputerID = $_GET['ID'];}
if(isset($_GET['THREAT'])){$THREAT = $_GET['THREAT'];}
if(isset($_GET['Name'])){$Name = $_GET['Name'];}



if($CMD == "REOCCURINGLOGS"){
	include("header.php");
	echo "<div id=banner><h1>Alarm Dashboard</h1></div>";
	$MyThreats = getLastReoccuringCritical($ltserver,$ltuser,$ltpass,$ltdb);
			echo "<br><fieldset><legend>Agents With High Reoccurring Logs Events</legend><br><table width=\"98%\" cellpadding=12 cellspacing=12 align=center >";
			echo "<tr><td colspan=2></td></tr>";
			$cnt = 1;
			foreach($MyThreats AS $Threats => $Threat){
				$MyMessage = $Threat['Message'];
				$MyMessage = str_replace(",", ",<br>", "$MyMessage");
				echo "<tr valign=top><td colspan=2><b>Name: ".$Threat['Name']."&nbsp;&nbsp;&nbsp;Domain: ".$Threat['Domain']."</b><br>OS Type: ".$Threat['OS']."<br><hr></td></tr>";
				echo "<tr valign=top><td width=120>".$Threat['AlertDate']."</td><td>Reporting Log: <font color=navy>".$Threat['Fieldname']."</font></td></tr>";
				echo "<tr valign=top><td width=120></td><td>$MyMessage</td></tr>";
				echo "<tr><td colspan=2 align=center><hr></td></tr>";
				$cnt++;
			}
			echo "</table><br></fieldset>";
	include("footer.php");
}elseif($CMD == "DISKSPACE"){
	include("header.php");
	echo "<div id=banner><h1>Alarm Dashboard</h1></div>";
	$MyThreats = getLastDriveSpace($ltserver,$ltuser,$ltpass,$ltdb);
			echo "<br><fieldset><legend>Agents Reporting Low Disk Space</legend><br><table width=\"98%\" cellpadding=12 cellspacing=12 align=center >";
			echo "<tr><td colspan=2></td></tr>";
			$cnt = 1;
			foreach($MyThreats AS $Threats => $Threat){
				$MyMessage = $Threat['Message'];
				$MyMessage = str_replace(",", ",<br>", "$MyMessage");
				echo "<tr valign=top><td colspan=2><b>Name: ".$Threat['Name']."&nbsp;&nbsp;&nbsp;Domain: ".$Threat['Domain']."</b><br>OS Type: ".$Threat['OS']."<br><hr></td></tr>";
				echo "<tr valign=top><td width=120>".$Threat['AlertDate']."</td><td>Drive or Volume Reported: <font color=maroon>".$Threat['Fieldname']."</font></td></tr>";
				echo "<tr valign=top><td width=120></td><td>$MyMessage</td></tr>";
				echo "<tr><td colspan=2 align=center><hr></td></tr>";
				$cnt++;
			}
			echo "</table><br></fieldset>";
	include("footer.php");
}elseif($CMD == "NOPATCH"){
	include("header.php");
	echo "<div id=banner><h1>Alarm Dashboard</h1></div>";
	$MyThreats = getWindowsUpdate($ltserver,$ltuser,$ltpass,$ltdb);
			echo "Systems that have not been patched this month yet. If we are at the very first of the month then this list will be larger than expected. Check back each week to see count go down.<br><br><fieldset><legend>Agents not patched this month</legend><br><table width=\"98%\" cellpadding=12 cellspacing=12 align=center >";
			$cnt = 1;
			foreach($MyThreats AS $Threats => $Threat){
				$MyMessage = $Threat['Message'];
				echo "<tr valign=top><td><b>Name:</b> ".$Threat['Name']."&nbsp;&nbsp;&nbsp;<b>Domain:</b> ".$Threat['Domain']."<br>OS Type: ".$Threat['OS']."</td>";
				echo "<td>Last Contact: ".$Threat['LastContact']."</td><td>Last Patch Date: <font color=maroon>".$Threat['WindowsUpdate']."</font></td></tr>";
				$cnt++;
			}
			echo "</table><br></fieldset>";
	include("footer.php");
}elseif($CMD == "MISSINGSP"){
	include("header.php");
	echo "<div id=banner><h1>Alarm Dashboard</h1></div>";
	$MyThreats = getLastMissingSP($ltserver,$ltuser,$ltpass,$ltdb);
			echo "<br><fieldset><legend>Agents Missing Service Packs</legend><br><table width=\"98%\" cellpadding=12 cellspacing=12 align=center >";
			echo "<tr><td colspan=2></td></tr>";
			$cnt = 1;
			foreach($MyThreats AS $Threats => $Threat){
				$MyMessage = $Threat['Message'];
				$MyMessage = str_replace(",", ",<br>", "$MyMessage");
				echo "<tr valign=top><td colspan=2><b>Name: ".$Threat['Name']."&nbsp;&nbsp;&nbsp;Domain: ".$Threat['Domain']."</b><br>OS Type: ".$Threat['OS']."<br><hr></td></tr>";
				echo "<tr valign=top><td width=120>".$Threat['AlertDate']."</td><td>Service Pack for: <font color=maroon>".$Threat['Fieldname']."</font></td></tr>";
				echo "<tr valign=top><td width=120></td><td>$MyMessage</td></tr>";
				echo "<tr><td colspan=2 align=center><hr></td></tr>";
				$cnt++;
			}
			echo "</table><br></fieldset>";
	include("footer.php");
}else{
header("Location: index.php");

}

?>

