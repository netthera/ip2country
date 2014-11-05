<?php
/***************************************************************************
 *   copyright				: (C) 2008 - 2014 WeBid
 *   site					: http://www.webidsupport.com/
 ***************************************************************************/

/***************************************************************************
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version. Although none of the code may be
 *   sold. If you have been sold this script, get a refund.
 ***************************************************************************/
include '../common.php';

	
//create database table
	$query = "CREATE TABLE IF NOT EXISTS " . $DBPrefix . "ip2country (min bigint(12) NOT NULL DEFAULT 0, max bigint(12) NOT NULL, code varchar(2) NOT NULL, name varchar(100) NOT NULL, PRIMARY KEY (min))";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__);
	echo '<br>Table ip2country was created';

// import ip/country data in the database

	$file = "ip2country_csv.txt";
	$query = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE " . $DBPrefix . "ip2country
  FIELDS TERMINATED BY ','
  ENCLOSED BY '\"'
  LINES TERMINATED BY '\\n'";
	$system->check_mysql(mysql_query($query), $query, __LINE__, __FILE__); 
	echo '<br>IP and Country data loaded to table ip2country';



//move functions_ip2country.php in the includes directory
$file = 'functions_ip2country.php';
if (!copy($file, $include_path.$file)) {
    echo "<br>failed to move $file...\n";
    exit;
}
echo '<br>'.$file.' has been copied to the '.$include_path.' directory';


header('location:index.php');


?>
