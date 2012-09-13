/* *                                                   	* *
 * RGraph - SQL Code            	       				  *
 * *                                                    * *
 * @Author  Rafael 'R@f' Keramidas <rafael@keramid.as>    *
 * @Date    13th September 2012                           *
 * @Version 1.0                                           *
 * @Licence GPLv3                                         *
 * *													* */

CREATE TABLE rgraph_servers (
	serverid SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(60) NOT NULL,
	ip VARCHAR(40) NOT NULL,
	port SMALLINT(5) UNSIGNED NOT NULL,
	PRIMARY KEY(serverid)
) ENGINE=InnoDB;

CREATE TABLE rgraph_stats (
	statid MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
	players SMALLINT(5) UNSIGNED NOT NULL,
	stattime DATETIME NOT NULL,
	fk_server SMALLINT(5) UNSIGNED NOT NULL,
	PRIMARY KEY(statid),
	INDEX(fk_server),
	FOREIGN KEY(fk_server) REFERENCES rgraph_servers(serverid) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;