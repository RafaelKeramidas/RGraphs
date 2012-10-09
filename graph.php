<?php
	/***
	 * RGraph - SA-MP Server Graphs
	 * 
	 * @Author		Rafael 'R@f' Keramidas <rafael@keramid.as>
	 * @Version		1.0
	 * @Date		13th September 2012
	 * @Licence		GPLv3 
	 ***/
	 
	require('includes/config.inc.php');
	require('pchart/pData.class.php');  
	require('pchart/pChart.class.php');  
	require('pchart/pCache.class.php');  
  
	/* Connect to the MySQL Database */
	try {
		$db = new PDO('mysql:host=' . $config['mysql_host'] . ';dbname=' . $config['mysql_db'], $config['mysql_user'], $config['mysql_passwd']);
	}
	catch (Exception $e) {
			die('Error: ' . $e->getMessage());
	}
	
	if(isset($_GET['srvid']) && isset($_GET['size'])) {
		$serverid = $_GET['srvid'];
		$size = $_GET['size'];
		
		$result = $db->prepare("SELECT srv.name AS name, srv.ip AS ip, srv.port AS port, COUNT(st.statid) AS statscount FROM rgraph_servers srv INNER JOIN rgraph_stats st ON st.fk_server = srv.serverid WHERE serverid = :srvid");
		$result->execute(array(
			'srvid' => $serverid
		));
		$dbdata = $result->fetch();
		
		/* Check if the server exists */
		if(count($dbdata) != 0) {
			$name = $dbdata['name'];
			$ip = $dbdata['ip'];
			$port = $dbdata['port'];
			$scount = $dbdata['statscount'];
			
			if($scount != 0) {
				if($size == 'small') {
					$result = $db->prepare("SELECT players, DATE_FORMAT(stattime, '%H:%i') AS stime FROM rgraph_stats WHERE fk_server = :srvid AND stattime > DATE_SUB(NOW(), INTERVAL 6 HOUR)");
					$result->execute(array(
						'srvid' => $serverid
					));
					
					$dataSet = new pData;  
					
					while($dbdata = $result->fetch()) {
						$dataSet->AddPoint($dbdata['players'],"Serie1");  
						$dataSet->AddPoint($dbdata['stime'],"Serie2");  
					}
					
					$dataSet->AddAllSeries();  
					$dataSet->SetAbsciseLabelSerie("Serie2");  
					$dataSet->SetYAxisName("Amout of players");  
					  
					$cache = new pCache();  
					$cache->GetFromCache("Small$serverid",$dataSet->GetData());  
					  
					$chart = new pChart(600,230);  
					$chart->setFontProperties("fonts/tahoma.ttf",8);  
					$chart->setGraphArea(60,30,550,200);  
					$chart->drawFilledRoundedRectangle(7,7,593,223,5,240,240,240);  
					$chart->drawRoundedRectangle(5,5,595,225,5,230,230,230);  
					$chart->drawGraphArea(255,255,255,TRUE);  
					$chart->drawScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,0);     
					$chart->drawGrid(4,TRUE,230,230,230,50);   
					$chart->drawFilledLineGraph($dataSet->GetData(),$dataSet->GetDataDescription(), 50, TRUE);  
					$chart->setFontProperties("fonts/tahoma.ttf",10);  
					$chart->drawTitle(40,22,"Stats on 6 hours for $name ($ip:$port)",50,50,50,585);  
						
					$cache->WriteToCache("Small$serverid",$dataSet->GetData(),$chart);  
					$chart->Stroke();  
				}
				else if($size = 'big') {
					$result = $db->prepare("SELECT players, DATE_FORMAT(stattime, '%H:%i') AS stime FROM rgraph_stats WHERE fk_server = :srvid AND stattime > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
					$result->execute(array(
						'srvid' => $serverid
					));
					
					$dataSet = new pData;  
					
					while($dbdata = $result->fetch()) {
						$dataSet->AddPoint($dbdata['players'],"Serie1");  
						$dataSet->AddPoint($dbdata['stime'],"Serie2");  
					}
					$dataSet->AddAllSeries();  
					$dataSet->SetAbsciseLabelSerie("Serie2");  
					$dataSet->SetYAxisName("Amout of players");  
					  
					$cache = new pCache();  
					$cache->GetFromCache("Big$serverid",$dataSet->GetData());  
					  
					$chart = new pChart(1800,230);  
					$chart->setFontProperties("fonts/tahoma.ttf",8);  
					$chart->setGraphArea(60,30,1750,200);  
					$chart->drawFilledRoundedRectangle(7,7,1793,223,5,240,240,240);  
					$chart->drawRoundedRectangle(5,5,1795,225,5,230,230,230);  
					$chart->drawGraphArea(255,255,255,TRUE);  
					$chart->drawScale($dataSet->GetData(),$dataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,0);     
					$chart->drawGrid(4,TRUE,230,230,230,50);   
					$chart->drawFilledLineGraph($dataSet->GetData(),$dataSet->GetDataDescription(), 50, TRUE);  
					$chart->setFontProperties("fonts/tahoma.ttf",10);  
					$chart->drawTitle(1100,22,"Stats on 24 hours for $name ($ip:$port)",50,50,50,585);  
						
					$cache->WriteToCache("Big$serverid",$dataSet->GetData(),$chart);  
					$chart->Stroke();  
				}
			}
			else {
				echo 'No data fetched for the moment...';
			}
		}
		
		$result->closeCursor();
	}
	
?>