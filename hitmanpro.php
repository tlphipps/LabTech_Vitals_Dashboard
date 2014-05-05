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
if(isset($_GET['CMD'])){$CMD = $_GET['CMD'];}
if(isset($_GET['ClientID'])){$ClientID = $_GET['ClientID'];}
if(isset($_GET['ID'])){$ComputerID = $_GET['ID'];}
if(isset($_GET['THREAT'])){$THREAT = $_GET['THREAT'];}
if(isset($_GET['Name'])){$Name = $_GET['Name'];}
echo "<div id=banner><h1>HitMan Pro Dashboard</h1></div>";


if($CMD == "LIST" and is_numeric($ComputerID)){
	$MyThreats = getHitmanProAlarms($ltserver,$ltuser,$ltpass,$ltdb,$ComputerID,$THREAT);
			echo "<br><fieldset><legend>Current Hitman PRO Alarms for $Name</legend><br><table width=\"98%\" cellpadding=12 cellspacing=12 align=center >";
			$cnt = 1;
			foreach($MyThreats AS $Threats => $Threat){
				$MyMessage = $Threat['Message'];
				$MyMessage = str_replace("[Scanners]", "<br><br><font color=red><b>[Scanners]", "$MyMessage");
				$MyMessage = str_replace("[/Scanners]", "[/Scanners]</b></font><br><br>", "$MyMessage");
				$MyMessage = str_replace("[Item type=", "<br><br>[Item type=", "$MyMessage");
				$MyMessage = str_replace("[File path=", "<font color=orange>[File path=", "$MyMessage");
								$MyMessage = str_replace("[/Item", "[/Item]</font>", "$MyMessage");
				echo "<tr valign=top><td align=left><b>[Alarm:$cnt]</b></td><td><b>".$Threat['Source']."</b></td></tr>";
				echo "<tr valign=top><td width=120>".$Threat['AlertDate']."</td><td>$MyMessage</td></tr>";
				echo "<tr><td colspan=2 align=center><hr></td></tr>";
				$cnt++;
			}
			echo "</table><br></fieldset>";

}else{


	echo "<br><table width=\"100%\" cellpadding=2 cellspacing=2><tr valign=top><td width=50%>";

		echo "<br><table width=\"90%\" cellpadding=2 cellspacing=2><tr><td><h2>Current Hitman PRO Alarms</h2></td></tr><tr><td align=left>";
		$HMPThreats = getHitmanProThreats($ltserver,$ltuser,$ltpass,$ltdb);
		$Company = "";
		foreach($HMPThreats AS $Threats => $Threat){
			if($Company != $Threat['Company']){ $Company = $Threat['Company'];
#        	$myThreats = $Threat['CurrentThreats'];
				echo "<br><img src=\"virus-alarm.png\" width=\"16\">&nbsp;".$Threat['Company']."<br><br>";
				}
			if($Company == $Threat['Company']){ 
				echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"hitmanpro.php?ClientID=".$Threat['ClientID']."&CMD=LIST&ID=".$Threat['ComputerID']."&THREAT=".$Threat['CurrentThreats']."&Name=".$Threat['Name']."\">".$Threat['Name']."</a><br>";
				}
		}
		echo  "</td></tr></table>";
	echo  "</td><td width=50%>";
		echo "<br><table width=\"90%\" cellpadding=2 cellspacing=2><tr><td><h2>Systems Scanned in last 24 hours</h2></td></tr><tr><td align=left>";
		$HMPScans = getHitmanDailyScan($ltserver,$ltuser,$ltpass,$ltdb);
		$Company = "";
		foreach($HMPScans AS $Scans => $Scan){
			if($Company != $Scan['Company']){ $Company = $Scan['Company'];
#       	 $myThreats = $Threat['CurrentThreats'];
				echo "<br><img src=\"virus-alarm.png\" width=\"16\">&nbsp;<a href=\"hitmanpro.php?ClientID=".$Scan['ClientID']."&CMD=LIST\">".$Scan['Company']."</a><br><br>";
				}
			if($Company == $Scan['Company']){ 
				echo "&nbsp;&nbsp;&nbsp;&nbsp;System = ".$Scan['Name']."&nbsp;&nbsp;&nbsp;Last Scan:&nbsp;&nbsp;".$Scan['LastScan']."<br>";
				}
		}
		echo  "</td></tr></table>";
	echo  "</td></tr></table>";
}

?>


   
<?php
include("footer.php");
?>  
