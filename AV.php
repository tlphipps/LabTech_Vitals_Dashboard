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
echo "<div id=banner><h1>AntiVirus Dashboard</h1></div>";



	echo "<br><table width=\"100%\" cellpadding=2 cellspacing=2><tr valign=top><td>";

		
		echo "<br><table width=\"90%\" cellpadding=2 cellspacing=2><tr><td><h2>Systems missing AV software</h2></td></tr>";
		$AVScaner = getLTAVScannerInfo($ltserver,$ltuser,$ltpass,$ltdb);
		$Company = "";
		foreach($AVScaner AS $Scans => $Scan){
				echo "<tr><td align=left>System = ".$Scan['ComputerName']."</td><td>Client:&nbsp;&nbsp;".$Scan['ClientName']."</TD></tr>";
				
		}
		echo  "</table>";
	echo  "</td></tr></table>";


?>


   
<?php
include("footer.php");
?>  
