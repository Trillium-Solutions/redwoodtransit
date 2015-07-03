<?php

// Include the configuration file for error management and such.
require_once ('../includes/config.inc.php'); 

// Connect to the database
require_once ('../postgres_connect.php');

date_default_timezone_set('America/Los_Angeles');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Redwood Transit System Holiday Calendar</title>
		<link href="../css/main.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
#instruction {float:left; width:200px;height:300px;margin-left:10px;margin-right:10px;}
li {margin-left:20px; padding-right:7px;}
#route_name {font-size:50px;font-weight:bold;}
table.holidays td {border-bottom:1px solid #ccc;padding:0px;padding-right:10px;margin:0px}
th {padding-right:10px;border-bottom:2px solid black;margin:0px;}

</style>





</head>

<body onload="MM_preloadImages('images/nav_bar2/symbol%20icon%20row%20v3_r1_c1_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c3_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c5_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c7_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c9_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c11_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f3.gif');">


<a href="#Content" class="hidden">Skip to Content</a>
<div id="Container">
<div id="ContentWrapper">




<div id="logo_header_left">
<a href="../"><img src="../../images/rts_logo.gif" alt="" border="0" livesrc="../../Documents/Transit%20info%20work/HTA/HTA%20../../images/RTS%20LOGO.psd" width="252" height="81" /></a>
</div>

<div id="nav_links">

<?php require_once ('../includes/nav_bar.html'); ?>


</div>

<br clear="all">

<hr size="2"  width="784" style="padding-left:10px;padding-right:10px;">

<div id="page_text_itself" style="width:670;margin-left:3px; padding-left:30px;">

<a href="../">RTS Home</a> &#xBB; <a href="index.html">Schedules</a> &#xBB;<br/>

<h1>Holiday Schedule</h1>

<?php

$last_year= date("Y")-1;

$calendar_dates_query = "


SELECT calendar_dates.description, calendar_dates.calendar_date_id, DATE_FORMAT( calendar_dates.date,  '%W, %e %b %Y' ) AS formated_date, calendar.service_label AS service_name_added
FROM calendar_date_service_exceptions
LEFT JOIN calendar ON calendar_date_service_exceptions.service_exception = calendar.calendar_id
LEFT JOIN calendar_dates ON calendar_date_service_exceptions.calendar_date_id = calendar_dates.calendar_date_id
WHERE calendar_dates.agency_id =1
AND calendar_dates.date >  '".$last_year."-12-31'
AND calendar_dates.date <  '".date("Y")."-12-31'
AND (
calendar_date_service_exceptions.exception_type =1
OR calendar_date_service_exceptions.exception_type = NULL
)
ORDER BY calendar_dates.date ASC";
$calendar_dates_result = db_query($calendar_dates_query);


// echo '<p>'.$calendar_dates_query.'</p>';

if ($calendar_dates_result) {

echo '<table class="holidays" cellspacing="0">
<tr><th style="padding-right:20px">Date</th><th style="padding-right:20px">Holiday / exception description</th><th style="padding-right:20px">Service</th>';


// begin while loop
while ($row = db_fetch_array($calendar_dates_result, MYSQL_ASSOC)) {
echo '<tr><td>';
echo $row['formated_date'];
echo ' &nbsp;&nbsp;</td><td>';
echo $row['description'];
echo '&nbsp;&nbsp;</td><td>';


$calendar_date_service_exceptions_query = "select calendar.service_label from calendar_date_service_exceptions inner join calendar on calendar_date_service_exceptions.service_exception=calendar.calendar_id where calendar_date_id=".$row['calendar_date_id']." and exception_type=1;";
$calendar_date_service_exceptions_result = db_query($calendar_date_service_exceptions_query);


if (db_num_rows($calendar_date_service_exceptions_result) > 0) 
{echo '<ul style="list-style-type: none;padding:0px;margin:0px;">';
while ($row = db_fetch_array($calendar_date_service_exceptions_result, MYSQL_ASSOC)) {
echo '<li style="padding:0px;margin:0px;">'.$row['service_label'].'</li>';
}
echo '</ul>';
}

else {echo 'No service';}

echo '</td></tr>';

// end while loop
}

echo '</table>';

}

else {echo '<p>There are no service holidays lsited.</p>';}

?>

<p>This table is provided below, which shows normal holidays without dates.  This information is provided because the transit information database does not always fully reflect these holidays.</p>

<table>
	<tr>
		<th>Holiday / exception description</th> <th>Service</th>
	</tr>
	<tr>
		<td>New Year's Day</td> <td>No service</td>
	</tr>
	<tr>
		<td>MLK Day  </td> <td>Saturday service</td>
	</tr>
	<tr>
		<td>Presidents Day  </td> <td>Saturday service</td>
	</tr>
	<tr>
		<td>Memorial Day  </td> <td>Saturday service</td>
	</tr>
	<tr>
		<td>Independence Day  </td> <td>No service</td>
	</tr>
	<tr>
		<td>Labor Day  </td> <td>Saturday service</td>
	</tr>
	<tr>
		<td>Thanksgiving Day  </td> <td>No service</td>
	</tr>
	<tr>
		<td>Day after Thanksgiving  </td> <td>Saturday service</td>
	</tr>
	<tr>
		<td>Christmas Day  </td> <td>No service</td>
	</tr>
	<tr>
		<td>Day after Christmas  </td> <td>Saturday service</td>
	</tr>
</table>


</div>

</div>
<br clear="all" />
</div>

<?php require_once ('../includes/footer.html'); ?>

</body>

</html>