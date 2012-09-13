<?php
	/***
	 * RGraph - SA-MP Server Graphs
	 * 
	 * @Author		Rafael 'R@f' Keramidas <rafael@keramid.as>
	 * @Version		1.0
	 * @Date		13th September 2012
	 * @Licence		GPLv3 
	 * @Comment		Run this script in a Cron (GNU/Linux) or Scheduled Task (Windows)
	 ***/
	 
	 
	require('../includes/config.inc.php');
	require('../classes/sampquery.class.php');
	
	/* Connect to the MySQL Database */
	try {
		$db = new PDO('mysql:host=' . $config['mysql_host'] . ';dbname=' . $config['mysql_db'], $config['mysql_user'], $config['mysql_passwd']);
	}
	catch (Exception $e) {
			die('Error: ' . $e->getMessage());
	}
	
	/* Fetch and insert the data for all servers */
	$result = $db->query("SELECT serverid, ip, port FROM rgraph_servers");
	while($dbdata = $result->fetch()) {
		$serverid = $dbdata['serverid'];
		$players = 0;
		$sampQuery = new SampQuery($dbdata['ip'], $dbdata['port']);
		if($sampQuery->isOnline()) {
			$sinfo = $sampQuery->getInfo();
			$players = $sinfo['players'];
			echo "Players: $players\n";
		}
		else {
			$players = 0;
			echo "Server offline\n";
		}
		
		$db->query("INSERT INTO rgraph_stats VALUES(null, $players, NOW(), $serverid)");
	}
	$result->closeCursor();
	
	/* Delete the old data (older than 48 hours) */
	$db->query("DELETE FROM rgraph_stats WHERE stattime < DATE_SUB(NOW(), INTERVAL 48 HOUR)");
	
?>