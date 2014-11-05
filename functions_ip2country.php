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
// functions_ip2country

function get_visitor_country($mode){
	global $system, $DBPrefix;
	$ip = $_SERVER["REMOTE_ADDR"];
	if(filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	if(filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
		$ip = $_SERVER['HTTP_CLIENT_IP'];
		
	$iparray = explode('.', $ip);
	$ipdecimal = ($iparray[0] * 16777216) + ($iparray[1] * 65536) + ($iparray[2] * 256) + ($iparray[3]);

	$sql="SELECT code,name FROM " . $DBPrefix . "ip2country WHERE ".$ipdecimal." BETWEEN min AND max";
	$result = mysql_query($sql);
	$row = mysql_fetch_row($result);
	
	switch($mode){
		case 'name':
			return $visitor_country_name = $row[1];
		case 'code':
			return $visitor_country_code = $row[0];
		case 'all':
		default :
			$visitor_country_array['name']=$row[1];
			$visitor_country_array['code']=$row[0];
			return $visitor_country_array;
			
	}
}	
function block_countries_by_name($countries){
	//$countries should be in the form of $countries='United States,Germany,Costa Rica,Monaco';
	
	$country = get_visitor_country('name'); 
	if(in_array($country,explode(',',$countries))){
		if ($MSG['IP2COUNTRY_001']=="" || $MSG['IP2COUNTRY_002']=="")
			echo '<center><h1>Access Denied</h1><h2>Your country <b>'.$country.'</b> has been blocked.</h2></center>';
		else
			echo $MSG['IP2COUNTRY_001'].$country.$MSG['IP2COUNTRY_002'];
		exit;
	}
}
function block_countries_by_code($countries){
	//$countries should be in the form of $countries='US,DE,CR,GR';
	
	$country = get_visitor_country('code'); 
	if(in_array($country,explode(',',$countries))){
		if ($MSG['IP2COUNTRY_001']=="" || $MSG['IP2COUNTRY_002']=="")
			echo '<center><h1>Access Denied</h1><h2>Your country <b>'.$country.'</b> has been blocked.</h2></center>';
		else
			echo $MSG['IP2COUNTRY_001'].$country.$MSG['IP2COUNTRY_002'];
		exit;
	}
}

function get_user_zone($seller_id,$buyer_id){
	global $system, $DBPrefix;

$query = "SELECT * FROM " . $DBPrefix . "zones WHERE user_id = ". $seller_id;
$result = mysql_query($query);
$system->check_mysql($result, $query, __LINE__, __FILE__);
$zones = mysql_fetch_assoc($result);

$buyer_id = ($buyer_id) ? $buyer_id : 0;

  if ($buyer_id==0)	{
  	echo $country = get_visitor_country('name');
  }	
  else
  {
  	$query = "SELECT country FROM " . $DBPrefix . "users WHERE id = " . $buyer_id ;
  	$result = mysql_query($query);
  	$system->check_mysql($result, $query, __LINE__, __FILE__);
  	$row=mysql_fetch_assoc($result);
  	$country= $row['country'];
  }
  
	if(in_array($country,explode(',',$zones[zone1])))
		return 1;
	else if (in_array($country,explode(',',$zones[zone2])))
		return 2;
	else if (strpos($zones[zone4],$country)!== false)
		return 0; //banned countries
	else 
		return 3;
  
}

?>
