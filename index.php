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
echo '<head><title>IP to Country Mod</title></head><body>';

//check to see if already installed
$filename = 'functions_ip2country.php';
if (file_exists($include_path.$filename)) {

    echo "<h2>IP to Country Mod</h2><h3>Congratulations IP to Country Mod is installed on your server</h3>";
    include $include_path.$filename;

} else {
    echo "
      <h2>IP to Country Mod</h2>
      <h3>Before you install</h3>
    	<ul>
    		<li>chown and chgrp the ip2country directory to match the user and the group of your WeBid instalation</li>
    		<li>Make sure your /includes/ directory is writable by the group of your WeBid instalation</li>
    		<li>If you want to change or translate the default messages. At the bottom of your /language/EN/messages.inc.php before the ?&gt; put<br>";
    		echo'<code><div style="background:lightgray;width:680px;">
    		<br>
    		$MSG[\'IP2COUNTRY_001\'] = "&lt;center>&lt;h1>Access Denied&lt;/h1>&lt;h2>Your country &lt;b>";<br>
    		$MSG[\'IP2COUNTRY_002\'] = "&lt;/b> has been blocked.&lt;/h2>&lt;/center>";
    		<br>
    		<br>
    		</div></code>';
    		echo "</li>
    	</ul>
    	<h3>Installation</h3>
    	Click <a href=install.php>Install</a>
		";
		exit;
}	


?>

<h2>IP to Country Mod functions</h2>
<ul>
	<li>get_visitor_country($mode)</li>
	<li>block_countries_by_code($countries)</li>
	<li>block_countries_by_name($countries)</li>
	<li>get_user_zone($seller_id,$buyer_id)</li>
</ul>
<h2>Usage</h2>

<h3>1. get_visitor_country($mode)</h3>
<b>Argument:</b> $mode <b>Values:</b> 'code', 'name', 'all' <br>
<ul>
	<li>'code' returns a string with the country code of the incoming visitor </li>
	<li>'name' returns a string with the country name of the incoming visitor </li>
	<li>'all' returns an array with the country code and name of the incoming visitor</li>
</ul>
<ol>
	<li><b>get_visitor_country('name')</b> for you will return: <b><?php echo get_visitor_country('name'); ?></b></li>
	<li><b>get_visitor_country('code')</b> for you will return: <b><?php echo get_visitor_country('code'); ?></b></li>
	<li><b>get_visitor_country('all')</b> for you will return: <pre><?php print_r(get_visitor_country('')); ?></pre></li>
</ol>
<b>Examples:</b><br>
If you want to show the country name of your visitor in any of your WeBid pages in the php file of that page 
put somewhere
<pre><div style='background:lightgray;width:580px;'>
	include $include_path . 'functions_ip2country.php';
	$visitror_country = get_visitor_country('name');
	
</div></pre>
and then assign $visitror_country to the corresponding template.
<br><br>If you want to show the country code of your visitor in any of your WeBid pages in the php file of that page 
put somewhere
<pre><div style='background:lightgray;width:580px;'>
	include $include_path . 'functions_ip2country.php';
	$visitror_country = get_visitor_country('code');
	
</div></pre>
and then assign $visitror_country to the corresponding template.
<br><br>
<h3>2. block_countries_by_code($countries)</h3>
<b>Argument:</b> $countries <b>Value:</b> a comma delimited string of country codes <br>
<b>Example:</b><br>If you want to block certain countries by country code <br> 
at the top of your header.php after the line
<pre><div style='background:lightgray;width:580px;'>
	if (!defined('InWeBid')) exit();
		</div></pre>
put
<pre><div style='background:lightgray;width:580px;'>
	include $include_path . 'functions_ip2country.php';
	$block_countries='US,DE,CR,GR';
	block_countries_by_code($block_countries);
	
</div></pre>
If the visitor's country code is US, DE, CR or GR it will show 
<table border=1 width=50%><tr><td><center><h1>Access Denied</h1><h2>Your country <b><?php echo get_visitor_country('code'); ?></b> has been blocked.</h2></center>
</td></tr></table>
and exit.
<br><br>
<h3>3. block_countries_by_name($countries)</h3>
<b>Argument:</b> $countries <b>Value:</b> a comma delimited string of country codes <br>
<b>Example</b><br>If you want to block certain countries by country name <br> 
at the top of your header.php after the line
<pre><div style='background:lightgray;width:580px;'>
	if (!defined('InWeBid')) exit();
		</div></pre>
put
<pre><div style='background:lightgray;width:580px;'>
	$block_countries='Denmark,Germany,Italy,Spain';
	block_countries_by_code($block_countries);
	
</div></pre>
If the visitor is from Denmark, Germany, Italy or Spain it will show 
<table border=1 width=50%><tr><td><center><h1>Access Denied</h1><h2>Your country <b><?php echo get_visitor_country('name'); ?></b> has been blocked.</h2></center></td></tr></table>

and exit.
<br><br>
If you want to change or translate the default message. At the bottom of your /language/EN/messages.inc.php before the ?> put<br>
    		<pre><div style="background:lightgray;width:680px;">
  $MSG['IP2COUNTRY_001'] = "&lt;center>&lt;h1>Access Denied&lt;/h1>&lt;h2>Your country &lt;b>";
  $MSG['IP2COUNTRY_002'] = "&lt;/b> has been blocked.&lt;/h2>&lt;/center>";
    		</div></pre>

<h3>4. get_user_zone($seller_id,$buyer_id)</h3>
This function is used by the Shipping Zones Mod.
<br><br><br>
</body>
