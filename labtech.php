<?php
/*
Labtech Vitals Dashboard
Description: A dashboard to be used during Control Centre loading as a splash page quick view of the state of the customer base.

By:Squidworks Inc  (http://www.squidworks.net)
Dev: Shannon Anderson
Date: 9/29/2013
Email: sanderson@squidworks.net
*/


function getLTComputerCount($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE ClientID = '$companyID'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}

function getLTComputerCountNoMacs($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE OS NOT LIKE '%Mac OS%' and OS NOT LIKE '%linux%' and LastContact > timestampadd(minute, -10, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}
function getLTLinuxCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE OS LIKE '%linux%' and LastContact > timestampadd(minute, -10, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}

function getLTComputerCountNoMacsByClient($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE ClientID = '$companyID' and OS NOT LIKE '%Mac OS%'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}

function getOfflineCoreCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select DISTINCT Computers.ComputerID, Clients.Name as `Client Name`, Computers.Name as ComputerName, Computers.Domain, Computers.UserName, Software.`Name` as `Software_Name`, Computers.LastContact 
			from Computers, Clients, Software Where Computers.ClientID = Clients.ClientID and Software.ComputerID = Computers.ComputerID 
			and Software.`Name` = 'AppAssure Core'
			AND Computers.LastContact < timestampadd(minute, -15, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows = mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLTESXCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	
		    $SQL = "SELECT ID,Name FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' 
				or extrafield.Name = 'This system monitors a ESX host' 
				or extrafield.Name = 'ESX host being monitored' 
				or extrafield.Name = 'Last time ESX host was scanned' 
				or extrafield.Name = 'Prevent  ESX alarms' 
				or extrafield.Name = 'Remove ESX monitor on next scan'";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
		if($Rows['Name'] == "ESX Hardware Health Status"){$ID578 = $Rows['ID'];}
		if($Rows['Name'] == "This system monitors a ESX host"){$ID579 = $Rows['ID'];}
		if($Rows['Name'] == "ESX host being monitored"){$ID580 = $Rows['ID'];}
		if($Rows['Name'] == "Last time ESX host was scanned"){$ID581 = $Rows['ID'];}
		if($Rows['Name'] == "Prevent  ESX alarms"){$ID582 = $Rows['ID'];}
		if($Rows['Name'] == "Remove ESX monitor on next scan"){$ID583 = $Rows['ID'];}		
		$i++;
		}
	
	
    $SQL = "SELECT count(*) AS Hosts FROM extrafielddata WHERE ExtraFieldID = '$ID580' and extrafielddata.Value != ''";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['Hosts'];
		}
    mysql_close($con);
    return($sys);
}

function getLTESXHardwareFailureCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) AS Hosts FROM extrafielddata WHERE ExtraFieldID = '578' and Value NOT LIKE 'OK - Server:%'  and extrafielddata.Value != '' ";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['Hosts'];
		}
    mysql_close($con);
    return($sys);
}

function getLTESXHardwareMissingCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$MYM = date("m");
	$MYD = date("d");
	$MYY = date("Y");
	$MYDATE = $MYM."/".$MYD."/".$MYY;
	
		    $SQL = "SELECT ID,Name FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' 
				or extrafield.Name = 'This system monitors a ESX host' 
				or extrafield.Name = 'ESX host being monitored' 
				or extrafield.Name = 'Last time ESX host was scanned' 
				or extrafield.Name = 'Prevent  ESX alarms' 
				or extrafield.Name = 'Remove ESX monitor on next scan'";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
		if($Rows['Name'] == "ESX Hardware Health Status"){$ID578 = $Rows['ID'];}
		if($Rows['Name'] == "This system monitors a ESX host"){$ID579 = $Rows['ID'];}
		if($Rows['Name'] == "ESX host being monitored"){$ID580 = $Rows['ID'];}
		if($Rows['Name'] == "Last time ESX host was scanned"){$ID581 = $Rows['ID'];}
		if($Rows['Name'] == "Prevent  ESX alarms"){$ID582 = $Rows['ID'];}
		if($Rows['Name'] == "Remove ESX monitor on next scan"){$ID583 = $Rows['ID'];}		
		$i++;
		}
    $SQL = "SELECT count(*) AS Hosts FROM extrafielddata WHERE ExtraFieldID = '$ID581' and Value NOT LIKE '%$MYDATE%'  and extrafielddata.Value != ''";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['Hosts'];
		}
    mysql_close($con);
    return($sys);
}

function getLTESXDetail($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
		    $SQL = "SELECT ID,Name FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' 
				or extrafield.Name = 'This system monitors a ESX host' 
				or extrafield.Name = 'ESX host being monitored' 
				or extrafield.Name = 'Last time ESX host was scanned' 
				or extrafield.Name = 'Prevent  ESX alarms' 
				or extrafield.Name = 'Remove ESX monitor on next scan'";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
		if($Rows['Name'] == "ESX Hardware Health Status"){$ID578 = $Rows['ID'];}
		if($Rows['Name'] == "This system monitors a ESX host"){$ID579 = $Rows['ID'];}
		if($Rows['Name'] == "ESX host being monitored"){$ID580 = $Rows['ID'];}
		if($Rows['Name'] == "Last time ESX host was scanned"){$ID581 = $Rows['ID'];}
		if($Rows['Name'] == "Prevent  ESX alarms"){$ID582 = $Rows['ID'];}
		if($Rows['Name'] == "Remove ESX monitor on next scan"){$ID583 = $Rows['ID'];}		
		$i++;
		}
	
	
    $SQL = "SELECT extrafielddata.ID, extrafielddata.ExtraFieldID, extrafielddata.Value, computers.Name AS Monitor 
			FROM extrafielddata
			LEFT JOIN computers ON computers.ComputerID = extrafielddata.ID 
			WHERE ExtraFieldID IN (SELECT ID FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' or extrafield.Name = 'This system monitors a ESX host' or extrafield.Name = 'ESX host being monitored' or extrafield.Name = 'Last time ESX host was scanned' or extrafield.Name = 'Prevent  ESX alarms' or extrafield.Name = 'Remove ESX monitor on next scan')  ORDER BY ID";
#    echo $SQL;
    $i = 0;
	$result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
				if($MYID != $Rows['ID']){$i++;
					$MYID = $Rows['ID'];
					$sys[$i]['Monitor'] = $Rows['Monitor'];
					$sys[$i]['ID'] = $Rows['ID'];					
					}
				if($Rows['ExtraFieldID'] == "$ID580"){$sys[$i]['ESXHOST'] = $Rows['Value'];}
                elseif($Rows['ExtraFieldID'] == "$ID578"){$sys[$i]['ESXHOSTSTATUS'] = $Rows['Value'];}				
                elseif($Rows['ExtraFieldID'] == "$ID581"){$sys[$i]['ESXHOSTSCAN'] = $Rows['Value'];}
		}
    mysql_close($con);
    return($sys);
}

function getLTESXHardwareFailureDetail($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
		    $SQL = "SELECT ID,Name FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' 
				or extrafield.Name = 'This system monitors a ESX host' 
				or extrafield.Name = 'ESX host being monitored' 
				or extrafield.Name = 'Last time ESX host was scanned' 
				or extrafield.Name = 'Prevent  ESX alarms' 
				or extrafield.Name = 'Remove ESX monitor on next scan'";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
		if($Rows['Name'] == "ESX Hardware Health Status"){$ID578 = $Rows['ID'];}
		if($Rows['Name'] == "This system monitors a ESX host"){$ID579 = $Rows['ID'];}
		if($Rows['Name'] == "ESX host being monitored"){$ID580 = $Rows['ID'];}
		if($Rows['Name'] == "Last time ESX host was scanned"){$ID581 = $Rows['ID'];}
		if($Rows['Name'] == "Prevent  ESX alarms"){$ID582 = $Rows['ID'];}
		if($Rows['Name'] == "Remove ESX monitor on next scan"){$ID583 = $Rows['ID'];}		
		$i++;
		}
	
	
    $SQL = "SELECT extrafielddata.ID, extrafielddata.ExtraFieldID, extrafielddata.Value, computers.Name AS Monitor FROM extrafielddata
		LEFT JOIN computers ON computers.ComputerID = extrafielddata.ID 
		WHERE ID IN (SELECT ID FROM extrafielddata WHERE ExtraFieldID = '$ID578' and Value NOT LIKE 'OK - Server:%')
		and ExtraFieldID IN (SELECT ID FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' or extrafield.Name = 'This system monitors a ESX host' or extrafield.Name = 'ESX host being monitored' or extrafield.Name = 'Last time ESX host was scanned' or extrafield.Name = 'Prevent  ESX alarms' or extrafield.Name = 'Remove ESX monitor on next scan') 
		ORDER BY ID";
#    echo $SQL;
    $i = 0;
	$result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
				if($MYID != $Rows['ID']){$i++;
					$MYID = $Rows['ID'];
					$sys[$i]['Monitor'] = $Rows['Monitor'];
					$sys[$i]['ID'] = $Rows['ID'];					
					}
				if($Rows['ExtraFieldID'] == "$ID580"){$sys[$i]['ESXHOST'] = $Rows['Value'];}
                elseif($Rows['ExtraFieldID'] == "$ID578"){$sys[$i]['ESXHOSTSTATUS'] = $Rows['Value'];}				
                elseif($Rows['ExtraFieldID'] == "$ID581"){$sys[$i]['ESXHOSTSCAN'] = $Rows['Value'];}
		}
		
    mysql_close($con);
    return($sys);
}

function getLTESXHardwareMissingDetail($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$MYM = date("m");
	$MYD = date("d");
	$MYY = date("Y");
	$MYDATE = $MYM."/".$MYD."/".$MYY;
	    $SQL = "SELECT ID,Name FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' 
				or extrafield.Name = 'This system monitors a ESX host' 
				or extrafield.Name = 'ESX host being monitored' 
				or extrafield.Name = 'Last time ESX host was scanned' 
				or extrafield.Name = 'Prevent  ESX alarms' 
				or extrafield.Name = 'Remove ESX monitor on next scan'";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
		if($Rows['Name'] == "ESX Hardware Health Status"){$ID578 = $Rows['ID'];}
		if($Rows['Name'] == "This system monitors a ESX host"){$ID579 = $Rows['ID'];}
		if($Rows['Name'] == "ESX host being monitored"){$ID580 = $Rows['ID'];}
		if($Rows['Name'] == "Last time ESX host was scanned"){$ID581 = $Rows['ID'];}
		if($Rows['Name'] == "Prevent  ESX alarms"){$ID582 = $Rows['ID'];}
		if($Rows['Name'] == "Remove ESX monitor on next scan"){$ID583 = $Rows['ID'];}		
		$i++;
		}
	
	
    $SQL = "SELECT extrafielddata.ID, extrafielddata.ExtraFieldID, extrafielddata.Value, computers.Name AS Monitor FROM extrafielddata
		LEFT JOIN computers ON computers.ComputerID = extrafielddata.ID 
		WHERE ID IN (SELECT ID FROM extrafielddata WHERE extrafielddata.ExtraFieldID = '$ID581' and extrafielddata.Value NOT LIKE '%$MYDATE%')
		and extrafielddata.ExtraFieldID IN (SELECT ID FROM extrafield Where extrafield.Name = 'ESX Hardware Health Status' or extrafield.Name = 'This system monitors a ESX host' or extrafield.Name = 'ESX host being monitored' or extrafield.Name = 'Last time ESX host was scanned' or extrafield.Name = 'Prevent  ESX alarms' or extrafield.Name = 'Remove ESX monitor on next scan') 
		ORDER BY ID";
#    echo $SQL;
    $i = 0;
	$result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
				if($MYID != $Rows['ID']){$i++;
					$MYID = $Rows['ID'];
					$sys[$i]['Monitor'] = $Rows['Monitor'];
					$sys[$i]['ID'] = $Rows['ID'];					
					}
				if($Rows['ExtraFieldID'] == "$ID580"){$sys[$i]['ESXHOST'] = $Rows['Value'];}
                elseif($Rows['ExtraFieldID'] == "$ID578"){$sys[$i]['ESXHOSTSTATUS'] = $Rows['Value'];}				
                elseif($Rows['ExtraFieldID'] == "$ID581"){$sys[$i]['ESXHOSTSCAN'] = $Rows['Value'];}
		}
		
    mysql_close($con);
    return($sys);

}




function getLTAVScannerCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select DISTINCT Computers.ComputerID, Clients.Name as `Client Name`, Computers.Name as ComputerName, Computers.Domain, Computers.UserName, Computers.OS, Computers.VirusScanner from Computers, Clients Where Computers.ClientID = Clients.ClientID and ((Computers.OS like '%Window%') AND (Computers.VirusScanner = 0) AND (Clients.Name not in ('AUCC', 'BPCI', 'CAI', 'CDACOUNCIL', 'Dance', 'JHUPress', 'LNESC', 'SCM', 'StrouseCorporation', 'Trevigen')))";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows = mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLTAVScannerInfo($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select DISTINCT Computers.ComputerID, Clients.Name as `ClientName`, Computers.Name as ComputerName, Computers.Domain AS Domain, Computers.UserName, Computers.OS, Computers.VirusScanner from Computers, Clients Where Computers.ClientID = Clients.ClientID and ((Computers.OS like '%Window%') AND (Computers.VirusScanner = 0)) ORDER BY ClientName";
#    echo $SQL;
	   $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerName'] = $Rows['ComputerName'];
                $sys[$i]['ClientName'] = $Rows['ClientName'];
                $sys[$i]['Domain'] = $Rows['Domain'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLTMacAVScannerCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select DISTINCT Computers.ComputerID, Clients.Name as `Client Name`, Computers.Name as ComputerName, Computers.Domain, Computers.UserName, Computers.OS, Computers.VirusScanner from Computers, Clients Where Computers.ClientID = Clients.ClientID and ((Computers.OS like '%OS X%') AND (Computers.VirusScanner = 0) AND (Clients.Name not in ('AUCC', 'BPCI', 'CAI', 'CDACOUNCIL', 'Dance', 'JHUPress', 'LNESC', 'SCM', 'StrouseCorporation', 'Trevigen', 'DR')))";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows = mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLTAVScannerCountByClient($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE ClientID = '$companyID' and VirusAP = '1'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}


function getLTAVScannerByClient($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT computers.Name as system, computers.OS, computers.VirusScanner, computers.VirusDefs, virusscanners.Name as AVType FROM computers 
LEFT JOIN virusscanners ON computers.virusscanner = virusscanners.VScanID WHERE ClientID = '$companyID'";
#    echo $SQL;
    $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['system'] = $Rows['system'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['VirusScanner'] = $Rows['VirusScanner'];
                $sys[$i]['VirusDefs'] = $Rows['VirusDefs'];
                $sys[$i]['AVType'] = $Rows['AVType'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}


function getOfflineServers($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT Name, Domain, LastUsername, LastContact, LocalAddress, UpTime  FROM computers
	    WHERE LastContact < timestampadd(minute, -10, now())
	    and OS LIKE '%server%' ORDER BY LastContact DESC";
#    echo $SQL;
    $i = 0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['LastUsername'] = $Rows['LastUsername'];
                $sys[$i]['LastContact'] = $Rows['LastContact'];
                $sys[$i]['LocalAddress'] = $Rows['LocalAddress'];
                $sys[$i]['UpTime'] = $Rows['UpTime'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}
function getAppassureFailStatusCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$year = date("Y");
	$month = date("m");
	$day = date("d");
    $SQL = "SELECT count(*) AS FAILURES FROM cns_appassurecore_failedjobs WHERE dateFailed LIKE '$month/$day/$year%'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occured: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['FAILURES'];
                }
    mysql_close($con);
    return($sys);
}

function getAppassureFailStatus($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$year = date("Y");
	$month = date("m");
	$day = date("d");
    $SQL = "SELECT * FROM cns_appassurecore_failedjobs WHERE dateFailed LIKE '$month/$day/$year%' ORDER BY serverName";
 #   echo $SQL;
    $i = 0;
    $result = mysql_query($SQL) or die('A error occured: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['id'] = $Rows['id'];
                $sys[$i]['clientID'] = $Rows['clientID'];
                $sys[$i]['locationID'] = $Rows['locationID'];
                $sys[$i]['coreName'] = $Rows['coreName'];
                $sys[$i]['serverName'] = $Rows['serverName'];
                $sys[$i]['lastFailure'] = $Rows['lastFailure'];
                $sys[$i]['dateFailed'] = $Rows['dateFailed'];
                $sys[$i]['dateEntered'] = $Rows['dateEntered'];
                $i++;
                }
    mysql_close($con);
    return($sys);
}

function getBackupStatus($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$year = date("Y");
	$month = date("m");
	$day = date("d");
    $SQL = "SELECT DISTINCT serverName, coreName FROM cns_appassurecore_snapshots WHERE dateEntered LIKE '$year-$month-$day%' ORDER BY serverName";
 #   echo $SQL;
    $i = 0;
    $result = mysql_query($SQL) or die('A error occured: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['id'] = $Rows['id'];
                $sys[$i]['clientID'] = $Rows['clientID'];
                $sys[$i]['locationID'] = $Rows['locationID'];
                $sys[$i]['coreName'] = $Rows['coreName'];
                $sys[$i]['serverName'] = $Rows['serverName'];
                $sys[$i]['lastSnapshot'] = $Rows['lastSnapshot'];
                $sys[$i]['dateEntered'] = $Rows['dateEntered'];
                $i++;
                }
    mysql_close($con);
    return($sys);
}
function getBackupStatusDetail($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	$year = date("Y");
	$month = date("m");
	$day = date("d");
    $SQL = "SELECT * FROM cns_appassurecore_snapshots WHERE dateEntered LIKE '$year-$month-$day%' ORDER BY serverName";
#    echo $SQL;
    $i = 0;
    $result = mysql_query($SQL) or die('A error occured: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['id'] = $Rows['id'];
                $sys[$i]['clientID'] = $Rows['clientID'];
                $sys[$i]['locationID'] = $Rows['locationID'];
                $sys[$i]['coreName'] = $Rows['coreName'];
                $sys[$i]['serverName'] = $Rows['serverName'];
                $sys[$i]['lastSnapshot'] = $Rows['lastSnapshot'];
                $sys[$i]['dateEntered'] = $Rows['dateEntered'];
                $i++;
                }
    mysql_close($con);
    return($sys);
}

function getLTMacSystemCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE OS LIKE '%Mac OS%' and LastContact > timestampadd(minute, -10, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}

function getLTMacSystemCountByClient($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as systems FROM computers WHERE ClientID = '$companyID' and OS LIKE '%Mac OS%'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['systems'];
		}
    mysql_close($con);
    return($sys);
}

function getHMPCurrentThreatCount($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) as Threats FROM alerts WHERE Source LIKE 'HitmanPro%' and AlertDate > timestampadd(day, -1, now());";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['Threats'];
		}
    mysql_close($con);
    return($sys);
}





function getHitmanProThreats($ltserver,$ltuser,$ltpass,$ltdb){

    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $labtech = mysql_select_db($ltdb, $con);
	$SQLID = "SELECT ID FROM extrafield WHERE Section = 'HitmanPro' and Name = 'Current Threats'";
	$GETSQLID = mysql_query($SQLID) or die('A error occurred: ' . $SQLID);
	$MyID = mysql_fetch_array($GETSQLID);
 
$SQL = "SELECT  alerts.ClientID, alerts.ComputerID, alerts.AlertDate, alerts.Message, alerts.Fieldname, computers.Name, computers.Domain, computers.OS, clients.Company, computers.LastUsername 
FROM alerts 
left join computers on computers.ComputerID = alerts.ComputerID
Left JOIN clients ON clients.ClientID = computers.ClientID
WHERE Source LIKE 'HitmanPro%' and AlertDate > timestampadd(day, -1, now())";

# $SQL = "SELECT computers.ComputerID, clients.Company, computers.ClientID, computers.Name, computers.LastUsername, computers.OS, extrafielddata.Value AS CurrentThreats
#	FROM computers 
#	Left JOIN clients ON clients.ClientID = computers.ClientID
#	Left JOIN extrafielddata ON extrafielddata.id = computers.ComputerID 
#	WHERE extrafielddata.ExtraFieldID = '$MyID[0]' 
#	and extrafielddata.value != '0'  and AlertDate > timestampadd(day, -1, now())
#	ORDER BY Company";
#    echo $SQL;

    $i =0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Company'] = $Rows['Company'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];
                $sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['LastUsername'] = $Rows['LastUsername'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['Message'] = $Rows['Message'];
				$sys[$i]['AlertDate'] = $Rows['AlertDate'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getHitmanProAlarms($ltserver,$ltuser,$ltpass,$ltdb,$ID){

    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $labtech = mysql_select_db($ltdb, $con);
    $SQL = "SELECT * FROM alerts WHERE Source LIKE '%hitman%' and ComputerID = '$ID' AND AlertDate  > timestampadd(day,-1,now()) ORDER BY AlertDate DESC";
    #echo $SQL;
    $i =0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['AlertDate'] = $Rows['AlertDate'];
                $sys[$i]['Message'] = $Rows['Message'];
                $sys[$i]['Source'] = $Rows['Source'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}


function getHitmanDailyScan($ltserver,$ltuser,$ltpass,$ltdb){

    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $labtech = mysql_select_db($ltdb, $con);
	$SQLID = "SELECT ID FROM extrafield WHERE Section = 'HitmanPro' and Name = 'Last Scan Date'";
	$GETSQLID = mysql_query($SQLID) or die('A error occurred: ' . $SQLID);
	$MyID = mysql_fetch_array($GETSQLID);
    $SQL = "SELECT computers.ComputerID, clients.Company, computers.ClientID, computers.Name, computers.LastUsername, computers.OS, extrafielddata.Value AS LastScan
	FROM computers 
	Left JOIN clients ON clients.ClientID = computers.ClientID
	Left JOIN extrafielddata ON extrafielddata.id = computers.ComputerID 
	WHERE extrafielddata.ExtraFieldID = '$MyID[0]' 
	and extrafielddata.value > timestampadd(day,-1,now())
	ORDER BY Company";
#    echo $SQL;
    $i =0;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Company'] = $Rows['Company'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];
                $sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['LastUsername'] = $Rows['LastUsername'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['LastScan'] = $Rows['LastScan'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getHitmanDailyScanCount($ltserver,$ltuser,$ltpass,$ltdb){

    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $labtech = mysql_select_db($ltdb, $con);
	$SQLID = "SELECT ID FROM extrafield WHERE Section = 'HitmanPro' and Name = 'Last Scan Date'";
	$GETSQLID = mysql_query($SQLID) or die('A error occurred: ' . $SQLID);
	$MyID = mysql_fetch_array($GETSQLID);
    $SQL = "SELECT count(*) AS Scans
	FROM computers 
	Left JOIN clients ON clients.ClientID = computers.ClientID
	Left JOIN extrafielddata ON extrafielddata.id = computers.ComputerID 
	WHERE extrafielddata.ExtraFieldID = '$MyID[0]' 
	and extrafielddata.value > timestampadd(day,-1,now())"; 
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['Scans'];
		}
    mysql_close($con);
    return($sys);
}







function getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT ComputerID  FROM computers WHERE ClientID = '$companyID'";
#    echo $SQL;
    $i = 1;
    $sys = "";
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $numrows = mysql_num_rows($result);
        while($Rows = mysql_fetch_array($result)){
                if($numrows == 0){
            	    $sys = 0;
                }elseif($i < $numrows){
            	    $sys .= $Rows['ComputerID'].",";
		}else{
            	    $sys .= $Rows['ComputerID'];
		}
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLTSystemInfo($ltserver,$ltuser,$ltpass,$ltdb,$ComputerID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT *  FROM computers WHERE ComputerID = '$ComputerID'";
#    echo $SQL;
    $i = 1;
    $sys = "";
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $numrows = mysql_num_rows($result);
        while($Rows = mysql_fetch_array($result)){
            	    $sys['ClientID'] = $Rows['ClientID'];
            	    $sys['LocationID'] = $Rows['LocationID'];
            	    $sys['Name'] = $Rows['Name'];
            	    $sys['Domain'] = $Rows['Domain'];
            	    $sys['Username'] = $Rows['Username'];
            	    $sys['PCDate'] = $Rows['PCDate'];
            	    $sys['TimeZone'] = $Rows['TimeZone'];
            	    $sys['OS'] = $Rows['OS'];
            	    $sys['WinDir'] = $Rows['WinDir'];
            	    $sys['Version'] = $Rows['Version'];
            	    $sys['BiosName'] = $Rows['BiosName'];
            	    $sys['BiosVer'] = $Rows['BiosVer'];
            	    $sys['BiosMFG'] = $Rows['BiosMFG'];
            	    $sys['BiosFlash'] = $Rows['BiosFlash'];
            	    $sys['Serial'] = $Rows['Serial'];
            	    $sys['Parallel'] = $Rows['Parallel'];
            	    $sys['LastContact'] = $Rows['LastContact'];
            	    $sys['DNSInfo'] = $Rows['DNSInfo'];
            	    $sys['LastInventory'] = $Rows['LastInventory'];
            	    $sys['CPUUsage'] = $Rows['CPUUSage'];
            	    $sys['TotalMemory'] = $Rows['TotalMemory'];
            	    $sys['MemoryAvail'] = $Rows['MemoryAvail'];
            	    $sys['LocalAddress'] = $Rows['LocalAddress'];
            	    $sys['RouterAddress'] = $Rows['RouterAddress'];
            	    $sys['Shares'] = $Rows['Shares'];
            	    $sys['VirusScanner'] = $Rows['VirusScanner'];
            	    $sys['VirusDefs'] = $Rows['VirusDefs'];
            	    $sys['VirusAP'] = $Rows['VirusAP'];
            	    $sys['WindowsUpdate'] = $Rows['WindowsUpdate'];
            	    $sys['UserAccounts'] = $Rows['UserAccounts'];
            	    $sys['UpTime'] = $Rows['UpTime'];
            	    $sys['DataIn'] = $Rows['DataIn'];
            	    $sys['DataOut'] = $Rows['DataOut'];
            	    $sys['MAC'] = $Rows['MAC'];
            	    $sys['DateAdded'] = $Rows['DateAdded'];
            	    $sys['bandwidth'] = $Rows['bandwidth'];
            	    $sys['LastUsername'] = $Rows['LastUsername'];
            	    $sys['ScoreCPU'] = $Rows['ScoreCPU'];
            	    $sys['ScoreD3D'] = $Rows['ScoreD3D'];
            	    $sys['ScoreDisk'] = $Rows['ScoreDisk'];
            	    $sys['ScoreGraphics'] = $Rows['ScoreGraphics'];
            	    $sys['ScoreMemory'] = $Rows['ScoreMemory'];
            	    $sys['SNMPCommunity'] = $Rows['SNMPCommunity'];
            	    $sys['IdleTime'] = $Rows['IdleTime'];
		}
    mysql_close($con);
    return($sys);
}

function getLTAllSystemsInfo($ltserver,$ltuser,$ltpass,$ltdb,$ClientID){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$ClientID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT *  FROM computers WHERE ComputerID IN ($ltSystemIDs) ORDER BY Name";
#    echo $SQL;
    $i = 1;
    $sys = "";
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $numrows = mysql_num_rows($result);
        while($Rows = mysql_fetch_array($result)){
            	    $sys[$i]['ClientID'] = $Rows['ClientID'];
            	    $sys[$i]['LocationID'] = $Rows['LocationID'];
            	    $sys[$i]['Name'] = $Rows['Name'];
            	    $sys[$i]['Domain'] = $Rows['Domain'];
            	    $sys[$i]['Username'] = $Rows['Username'];
            	    $sys[$i]['PCDate'] = $Rows['PCDate'];
            	    $sys[$i]['TimeZone'] = $Rows['TimeZone'];
            	    $sys[$i]['OS'] = $Rows['OS'];
            	    $sys[$i]['WinDir'] = $Rows['WinDir'];
            	    $sys[$i]['Version'] = $Rows['Version'];
            	    $sys[$i]['BiosName'] = $Rows['BiosName'];
            	    $sys[$i]['BiosVer'] = $Rows['BiosVer'];
            	    $sys[$i]['BiosMFG'] = $Rows['BiosMFG'];
            	    $sys[$i]['BiosFlash'] = $Rows['BiosFlash'];
            	    $sys[$i]['Serial'] = $Rows['Serial'];
            	    $sys[$i]['Parallel'] = $Rows['Parallel'];
            	    $sys[$i]['LastContact'] = $Rows['LastContact'];
            	    $sys[$i]['DNSInfo'] = $Rows['DNSInfo'];
            	    $sys[$i]['LastInventory'] = $Rows['LastInventory'];
            	    $sys[$i]['CPUUsage'] = $Rows['CPUUSage'];
            	    $sys[$i]['TotalMemory'] = $Rows['TotalMemory'];
            	    $sys[$i]['MemoryAvail'] = $Rows['MemoryAvail'];
            	    $sys[$i]['LocalAddress'] = $Rows['LocalAddress'];
            	    $sys[$i]['RouterAddress'] = $Rows['RouterAddress'];
            	    $sys[$i]['Shares'] = $Rows['Shares'];
            	    $sys[$i]['VirusScanner'] = $Rows['VirusScanner'];
            	    $sys[$i]['VirusDefs'] = $Rows['VirusDefs'];
            	    $sys[$i]['VirusAP'] = $Rows['VirusAP'];
            	    $sys[$i]['WindowsUpdate'] = $Rows['WindowsUpdate'];
            	    $sys[$i]['UserAccounts'] = $Rows['UserAccounts'];
            	    $sys[$i]['UpTime'] = $Rows['UpTime'];
            	    $sys[$i]['DataIn'] = $Rows['DataIn'];
            	    $sys[$i]['DataOut'] = $Rows['DataOut'];
            	    $sys[$i]['MAC'] = $Rows['MAC'];
            	    $sys[$i]['DateAdded'] = $Rows['DateAdded'];
            	    $sys[$i]['bandwidth'] = $Rows['bandwidth'];
            	    $sys[$i]['LastUsername'] = $Rows['LastUsername'];
            	    $sys[$i]['ScoreCPU'] = $Rows['ScoreCPU'];
            	    $sys[$i]['ScoreD3D'] = $Rows['ScoreD3D'];
            	    $sys[$i]['ScoreDisk'] = $Rows['ScoreDisk'];
            	    $sys[$i]['ScoreGraphics'] = $Rows['ScoreGraphics'];
            	    $sys[$i]['ScoreMemory'] = $Rows['ScoreMemory'];
            	    $sys[$i]['SNMPCommunity'] = $Rows['SNMPCommunity'];
            	    $sys[$i]['IdleTime'] = $Rows['IdleTime'];
		    $i++;
		}
    mysql_close($con);
    return($sys);
}



function getLTSmartFailCount($ltserver,$ltuser,$ltpass,$ltdb,$ltSystemIDs){
    if($ltSystemIDs == ""){$ltSystemIDs = 0;}
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select count(*) AS SmartFailures
	    FROM ((v_smartattributes LEFT 
	    JOIN Computers ON Computers.ComputerID=v_smartattributes.ComputerID) 
	    LEFT JOIN Locations ON Locations.LocationID=Computers.Locationid) 
	    LEFT JOIN Clients ON Clients.ClientID=Computers.clientid 
	    JOIN AgentComputerData on Computers.ComputerID=AgentComputerData.ComputerID     
	    WHERE v_smartattributes.`Worst` < v_smartattributes.Threshold 
	    AND  (v_smartattributes.Threshold>0 and  ((((Computers.Flags & 2048) <> 2048)) ) 
	    and (computers.os not like 'Mac OS X%' and computers.os not like 'Linux%') 
	    and v_smartattributes.attributeid<>190 
	    AND Computers.LastContact > DATE_ADD(NOW(),INTERVAL -15 MINUTE))  
	    AND Computers.ComputerID IN ($ltSystemIDs); ";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['SmartFailures'];
		}
    mysql_close($con);
    return($sys);
}


function getLTDefragCount($ltserver,$ltuser,$ltpass,$ltdb,$ltSystemIDs){
    if($ltSystemIDs == ""){$ltSystemIDs = 0;}
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select count(*) NeedsDefrag
	    FROM ((v_defragmentation 
	    LEFT JOIN Computers ON Computers.ComputerID=v_defragmentation.ComputerID) 
	    LEFT JOIN Locations ON Locations.LocationID=Computers.Locationid) 
	    LEFT JOIN Clients ON Clients.ClientID=Computers.clientid 
	    JOIN AgentComputerData on Computers.ComputerID=AgentComputerData.ComputerID 
	    WHERE v_defragmentation.`TotalFrag` > 30
	    and ((Select SmartStatus from Drives Where Drives.DriveID=v_defragmentation.DriveID and Missing != 1 Limit 1) not Like 'USB%' and (Select Model from Drives Where Drives.DriveID=v_defragmentation.DriveID and Missing != 1 Limit 1) not like '%IEEE%'  and DriveID in (SELECT drives.driveid FROM drives WHERE drives.ssd=0 AND drives.computerid=computers.computerid) and Computers.LastContact > DATE_ADD(NOW(),INTERVAL -1400 MINUTE))  
	    AND Computers.ComputerID IN ($ltSystemIDs)";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['NeedsDefrag'];
		}
    mysql_close($con);
    return($sys);
}

function getLTDefragDetail($ltserver,$ltuser,$ltpass,$ltdb,$ClientID){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$ClientID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "Select DISTINCT 'C',computers.computerid,computers.Name as ComputerName,Convert(CONCAT(clients.name,' ',locations.name) Using utf8) As Location, v_defragmentation.`TotalFrag` as TestValue,v_defragmentation.letter 

	    FROM ((v_defragmentation 
	    LEFT JOIN Computers ON Computers.ComputerID=v_defragmentation.ComputerID) 
	    LEFT JOIN Locations ON Locations.LocationID=Computers.Locationid) 
	    LEFT JOIN Clients ON Clients.ClientID=Computers.clientid 
	    JOIN AgentComputerData on Computers.ComputerID=AgentComputerData.ComputerID 
	    WHERE ((Select SmartStatus from Drives Where Drives.DriveID=v_defragmentation.DriveID and Missing != 1 Limit 1) not Like 'USB%' and (Select Model from Drives Where Drives.DriveID=v_defragmentation.DriveID and Missing != 1 Limit 1) not like '%IEEE%'  and DriveID in (SELECT drives.driveid FROM drives WHERE drives.ssd=0 AND drives.computerid=computers.computerid) and Computers.LastContact > DATE_ADD(NOW(),INTERVAL -1400 MINUTE))  
	    AND Computers.ComputerID IN ($ltSystemIDs) ORDER BY v_defragmentation.`TotalFrag` DESC";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['computerid'];
                $sys[$i]['ComputerName'] = $Rows['ComputerName'];
                $sys[$i]['Location'] = $Rows['Location'];
                $sys[$i]['TestValue'] = $Rows['TestValue'];
                $sys[$i]['letter'] = $Rows['letter'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}




function getLTHotfixFailCount($ltserver,$ltuser,$ltpass,$ltdb,$ltSystemIDs){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT count(*) AS PatchFailures FROM v_hotfixes WHERE ComputerID IN ($ltSystemIDs) and Installed = '0' and Pushed = '1'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
        while($Rows = mysql_fetch_array($result)){
                $sys = $Rows['PatchFailures'];
		}
    mysql_close($con);
    return($sys);
}

function getLTCriticalHotfixFail($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT v_hotfixes.ComputerID, computers.Name, computers.Domain, computers.LastContact, count(*) AS Failed 
			FROM v_hotfixes 
			LEFT JOIN computers ON computers.ComputerID = v_hotfixes.ComputerID
			WHERE Installed = '0' 
			and Pushed = '1'
			and Severity = 'Critical' 
			GROUP BY ComputerID ORDER BY computers.Domain";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
			if($Rows['Name'] == ""){
			}else{
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['LastContact'] = $Rows['LastContact'];
                $sys[$i]['Failed'] = $Rows['Failed'];
		$i++;
			}
		}
    mysql_close($con);
    return($sys);
}

function getLTComputerHotfixFailures($ltserver,$ltuser,$ltpass,$ltdb,$ID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT * FROM v_hotfixes WHERE ComputerID IN ($ID) and Installed = '0' and Pushed = '1' and Severity = 'Critical'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Installed'] = $Rows['Installed'];
                $sys[$i]['Approved'] = $Rows['Approved'];
                $sys[$i]['Pushed'] = $Rows['Pushed'];
                $sys[$i]['kbID'] = $Rows['kbID'];
                $sys[$i]['Title'] = $Rows['Title'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['Category'] = $Rows['Category'];
                $sys[$i]['Description'] = $Rows['Description'];
                $sys[$i]['SupportURL'] = $Rows['SupportURL'];
                $sys[$i]['Severity'] = $Rows['Severity'];
                $sys[$i]['CategoryName'] = $Rows['CategoryName'];
                $sys[$i]['PatchType'] = $Rows['PatchType'];
                $sys[$i]['UNINSTALL'] = $Rows['UNINSTALL'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLTHotfixFailures($ltserver,$ltuser,$ltpass,$ltdb,$companyID){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT * FROM v_hotfixes WHERE ComputerID IN ($ltSystemIDs) and Installed = '0' and Pushed = '1' ORDER by ComputerID";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Installed'] = $Rows['Installed'];
                $sys[$i]['Approved'] = $Rows['Approved'];
                $sys[$i]['Pushed'] = $Rows['Pushed'];
                $sys[$i]['kbID'] = $Rows['kbID'];
                $sys[$i]['Title'] = $Rows['Title'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['Category'] = $Rows['Category'];
                $sys[$i]['Description'] = $Rows['Description'];
                $sys[$i]['SupportURL'] = $Rows['SupportURL'];
                $sys[$i]['Severity'] = $Rows['Severity'];
                $sys[$i]['CategoryName'] = $Rows['CategoryName'];
                $sys[$i]['PatchType'] = $Rows['PatchType'];
                $sys[$i]['UNINSTALL'] = $Rows['UNINSTALL'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getWindowsUpdateCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	if(date("d") < 1){
		$myDate = (date("m") -1)."/%/".date("Y");
	}else{
		$myDate = date("m")."/%/".date("Y");
		}
#	echo $myDate;	
    $SQL = "SELECT `Name`, `Domain`, `LastContact`, `WindowsUpdate`  FROM labtech.computers
			WHERE WindowsUpdate NOT LIKE '$myDate%'
			AND OS LIKE '%Windows%'";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows= mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getWindowsUpdate($ltserver,$ltuser,$ltpass,$ltdb){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
if(date("d") < 1){
		$myDate = (date("m") -1)."/%/".date("Y");
	}else{
		$myDate = date("m")."/%/".date("Y");
		}
#	echo $myDate;	
    $SQL = "SELECT `Name`, `Domain`, `OS`, `LastContact`, `WindowsUpdate`  FROM labtech.computers
			WHERE WindowsUpdate NOT LIKE '$myDate%'
			AND OS LIKE '%Windows%'";
    #    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
				$sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['LastContact'] = $Rows['LastContact'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['WindowsUpdate'] = $Rows['WindowsUpdate'];

		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLastDriveSpaceCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT Distinct ComputerID FROM alerts WHERE Source LIKE '%DRV - Free Space Remaining%' and AlertDate  > timestampadd(day, -7, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows= mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLastDriveSpace($ltserver,$ltuser,$ltpass,$ltdb){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
	    $SQL = "SELECT alerts.ClientID, alerts.ComputerID, alerts.AlertDate, alerts.Message, alerts.Fieldname, computers.Name, computers.Domain, computers.OS  
			FROM alerts  
			left join computers on computers.ComputerID = alerts.ComputerID
			WHERE Source LIKE '%DRV - Free Space Remaining%' and AlertDate > timestampadd(day, -7, now()) ORDER BY computers.Domain";
    #    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Message'] = $Rows['Message'];
				$sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['AlertDate'] = $Rows['AlertDate'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['Fieldname'] = $Rows['Fieldname'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];	

		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLastMissingSPCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT Distinct ComputerID FROM alerts WHERE Source LIKE '%Missing Service Pack%' and AlertDate  > timestampadd(day, -7, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows= mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLastMissingSP($ltserver,$ltuser,$ltpass,$ltdb){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT  alerts.ComputerID, alerts.ClientID, alerts.AlertDate, alerts.Message, alerts.Fieldname, computers.Name, computers.Domain, computers.OS  
			FROM alerts  
			left join computers on computers.ComputerID = alerts.ComputerID
			WHERE Source LIKE '%Missing Service Pack%' and AlertDate > timestampadd(day, -7, now())  ORDER BY computers.Domain";
 #    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Message'] = $Rows['Message'];
				$sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['AlertDate'] = $Rows['AlertDate'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['Fieldname'] = $Rows['Fieldname'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];	

		$i++;
		}
    mysql_close($con);
    return($sys);
}


function getLastOutOfDateCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT Distinct ComputerID FROM alerts WHERE Source LIKE '%Out of Date -%' and AlertDate > timestampadd(day, -15, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows= mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLastOutOfDate($ltserver,$ltuser,$ltpass,$ltdb){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT alerts.ClientID, alerts.ComputerID, alerts.AlertDate, alerts.Message, alerts.Fieldname, computers.Name, computers.Domain, computers.OS  
			FROM alerts  
			left join computers on computers.ComputerID = alerts.ComputerID
			WHERE Source LIKE '%Out of Date -%' and AlertDate > timestampadd(day, -15, now()) ORDER BY computers.Domain"; 
 
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Message'] = $Rows['Message'];
				$sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['AlertDate'] = $Rows['AlertDate'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['Fieldname'] = $Rows['Fieldname'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];	

		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLastReoccuringCriticalCount($ltserver,$ltuser,$ltpass,$ltdb){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT Distinct ComputerID FROM alerts WHERE Source LIKE '%EV - Reoccuring Critical%' and AlertDate > timestampadd(hour, -24, now())";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
	$numrows= mysql_num_rows($result);
    mysql_close($con);
    return($numrows);
}

function getLastReoccuringCritical($ltserver,$ltuser,$ltpass,$ltdb){
    $ltSystemIDs = getLTSystemIDs($ltserver,$ltuser,$ltpass,$ltdb,$companyID);
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT alerts.ClientID, alerts.ComputerID, alerts.AlertDate, alerts.Message, alerts.Fieldname, computers.Name, computers.Domain, computers.OS  
			FROM alerts  
			left join computers on computers.ComputerID = alerts.ComputerID
			WHERE Source LIKE '%EV - Reoccuring Critical%' and AlertDate > timestampadd(day, -1, now()) ORDER BY computers.Domain";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occurred: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Message'] = $Rows['Message'];
				$sys[$i]['Name'] = $Rows['Name'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['AlertDate'] = $Rows['AlertDate'];
                $sys[$i]['Domain'] = $Rows['Domain'];
                $sys[$i]['Fieldname'] = $Rows['Fieldname'];
                $sys[$i]['ClientID'] = $Rows['ClientID'];				
		$i++;
		}
    mysql_close($con);
    return($sys);
}

function getLTHotfixDetails($ltserver,$ltuser,$ltpass,$ltdb,$ComputerID){
    $con = mysql_connect($ltserver,$ltuser,$ltpass);
    $vipre = mysql_select_db($ltdb, $con);
    $SQL = "SELECT * FROM v_hotfixes WHERE ComputerID = '$ComputerID'  ORDER by Installed";
#    echo $SQL;
    $result = mysql_query($SQL) or die('A error occured: ' . $SQL);
    $i = 0;
        while($Rows = mysql_fetch_array($result)){
                $sys[$i]['ComputerID'] = $Rows['ComputerID'];
                $sys[$i]['Installed'] = $Rows['Installed'];
                $sys[$i]['Approved'] = $Rows['Approved'];
                $sys[$i]['Pushed'] = $Rows['Pushed'];
                $sys[$i]['kbID'] = $Rows['kbID'];
                $sys[$i]['Title'] = $Rows['Title'];
                $sys[$i]['OS'] = $Rows['OS'];
                $sys[$i]['Category'] = $Rows['Category'];
                $sys[$i]['Description'] = $Rows['Description'];
                $sys[$i]['SupportURL'] = $Rows['SupportURL'];
                $sys[$i]['Severity'] = $Rows['Severity'];
                $sys[$i]['CategoryName'] = $Rows['CategoryName'];
                $sys[$i]['PatchType'] = $Rows['PatchType'];
                $sys[$i]['UNINSTALL'] = $Rows['UNINSTALL'];
		$i++;
		}
    mysql_close($con);
    return($sys);
}





?>
