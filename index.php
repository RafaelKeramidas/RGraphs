<?php
	/***
	 * RGraph - SA-MP Server Graphs
	 * 
	 * @Author		Rafael 'R@f' Keramidas <rafael@keramid.as>
	 * @Version		1.0
	 * @Date		13th September 2012
	 * @Licence		GPLv3
	 * @Comment		Just an example page to add servers. No verification done, don't use this in production !
	 ***/
 
	require('includes/config.inc.php');
	
	try {
		$db = new PDO('mysql:host=' . $config['mysql_host'] . ';dbname=' . $config['mysql_db'], $config['mysql_user'], $config['mysql_passwd']);
	}
	catch (Exception $e) {
			die('Error: ' . $e->getMessage());
	}
	
	if(isset($_POST['name']) && isset($_POST['ip'])) {
		if(!empty($_POST['name']) && !empty($_POST['ip'])) {
			$serverinfos = explode(':', $_POST['ip']);
			if(!isset($serverinfos[1]))
				$serverinfos[1] = 7777;
			
			$ip = $serverinfos[0];
			$port = intval($serverinfos[1]);
			$name = $_POST['name'];
			
			$query = $db->prepare("INSERT INTO rgraph_servers VALUES(null, :name, :ip, :port)");
			$query->execute(array(
				'name' => $name,
				'ip' => $ip,
				'port' => $port
			));
			
			echo '<b>Server added ! Please wait 24 hours to get the full stats.</b>';
		}
		else {
			echo '<b>Please fill all boxes !</b>';
		}
	}
	
	echo '<h1>Server list</h1>
	<ul>';
	$result = $db->query("SELECT serverid, name FROM rgraph_servers");
	while($dbdata = $result->fetch()) {
		echo '<li>' . $dbdata['name'] . ' - <a href="graph.php?srvid=' . $dbdata['serverid'] . '&size=small">Small graph</a> - <a href="graph.php?srvid=' . $dbdata['serverid'] . '&size=big">Big graph</a>';
	}
	echo '</ul>
	<h1>Add Server</h1>
	<form action="index.php" method="POST">
		Server name: <input type="text" name="name" />
		IP:Port: <input type="text" name="ip" />
		<input type="submit" value="Add" />
	</form>';
?>