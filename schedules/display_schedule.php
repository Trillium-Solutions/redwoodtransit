<?php

// Start output buffering.
ob_start();
// Initialize a session.
session_start();

// Include the configuration file for error management and such.
require_once ('../includes/config.inc.php'); 

// Connect to the database
require_once ('../postgres_connect.php');



if (isset($_GET['urlvar'])) {
require_once ('config_schedules.inc.php'); 
}


// if (isset($_GET['route_id'])) {$route_id=$_GET['route_id'];}
// if (isset($_GET['common_stop'])) {$route_id=$_GET['common_stop'];}
// if (isset($_GET['service'])) {$service=$_GET['service'];}
// if (isset($_GET['order'])) {$order=$_GET['order'];}
// if (isset($_GET['direction_id'])) {$direction_id=$_GET['direction_id'];}


if (isset($route_id)) {

if (isset($direction_id)) {if ($direction_id==5) {$order='asc';} elseif ($direction_id==6) {$order='desc';} elseif ($direction_id==7) {$order ='ASC';} elseif ($direction_id==8) {$order ='DESC';}
} else $order='desc';



$route_query = "select route_short_name,route_long_name from routes where route_id=$route_id";
$route_result = db_query($route_query);

while ($row=db_fetch_array($route_result, MYSQL_ASSOC))
{$route_long_name=$row['route_long_name'];
$route_short_name=$row['route_short_name'];}

$direction_query = "select direction_label from directions where direction_id=$direction_id";
$direction_result = db_query($direction_query);

while ($row=db_fetch_array($direction_result, MYSQL_ASSOC))
{$direction_label=$row['direction_label'];}


// Set the page title and include the HTML header.
$page_title = $route_long_name." (".$direction_label.") ".$service_label;

$css="th, td {font-size:10px;
	border-bottom: black;
	border-width: 0 0 1px 0;
	border-style: none none solid none;
	padding:0px;}

th {font-size:10px;
	border-bottom: black;
	border-width: 0 0 1px 0;
	border-style: none none solid none;
	padding:0px;}
	
th#stop {font-size:10px;
	border-bottom: none;
	border-width: 0 0 0px 0;
	border-style: none none none none;
	padding:0px;
}
.colorback {background-color:#ffe7a5;}
.supplemental {background-color:#a4cbe7;}";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $page_title; ?></title>
	<link href="http://www.redwoodtransit.org/css/main.css" rel="stylesheet" type="text/css" media="all" />


<?php
echo '<style type="text/css" media="all">';

echo 'body {margin:8px}';

echo '#green_bar_header {background-color: #030; border-top: 2px solid black; color:#ffcc40; padding:2px; text-align: center; margin:0px; width:100%;}';


if (isset($css)) {echo $css;}

echo '</style>';

?>

</head>
<body>

<a href="http://www.redwoodtransit.org/"><img src="http://www.redwoodtransit.org/images/rts_logo.gif" alt="" border="0" width="151" height="49" style="margin-bottom:10px"/></a>

<br/>
<a href="http://www.redwoodtransit.org/schedules/">Schedules</a> &#xBB;

<?php

echo '<h2 id="green_bar_header">'.$page_title.'</h2>';

if ($route_id==1) {

$supplemental_service_shown = 0;

foreach ($supplemental_service_id as &$value) {
     if (in_array($value, $service_ids)) { $supplemental_service_shown = 1;}
}

if ($supplemental_service_shown == 1) {

echo '<div class="supplemental"><strong><em><sup>*</sup>Note:</em></strong> Columns marked in blue (and with an asterisk in their headings show service that is only offered during <a href="http://www.humboldt.edu">Humboldt State University</a> spring and fall semesters.</div>';

}

}

?>

<div id="Content">

<?php

$time_of_day_conditional='';

if (!isset($_GET['trip_id']) && $route_id != 8 && $route_id != 822 && $route_id != 303) {

if (isset($_GET['time_of_day'])) {$time_of_day=$_GET['time_of_day'];} else {$time_of_day="all";}

echo '<form method="get" style="margin-top:5px;"><em>For easier viewing, select a particular time of day for which to view the schedule:</em><br/>';
echo '<select name="time_of_day">
<option value="all"';
if ($time_of_day=='all') {echo ' selected="selected"';}
echo '>All day</option>
<option value="morning"';
if ($time_of_day=='morning') {echo ' selected="selected"'; $time_of_day_conditional=' AND arrival_time BETWEEN \'05:00:00\' AND \'11:20:00\'';}
echo '>Morning (approx 5:45am to 11:20am)</option>
<option value="midday"';
if ($time_of_day=='midday') {echo ' selected="selected"';$time_of_day_conditional=' AND arrival_time BETWEEN \'08:26:00\' AND \'13:48:00\'';}
echo '>Midday (approx 8:30am to 1:50pm)</option>
<option value="afternoon"';
if ($time_of_day=='afternoon') {echo ' selected="selected"';$time_of_day_conditional=' AND arrival_time BETWEEN \'12:06:00\' AND \'16:49:00\'';}
echo '>Afternoon (approx 12:05pm to 4:50pm)</option>
<option value="night"';
if ($time_of_day=='night') {echo ' selected="selected"';$time_of_day_conditional=' AND arrival_time BETWEEN \'15:58:00\' AND \'23:59:00\'';}
echo '>Evening/night (approx 3:55pm to 11pm)</option></select><input type="submit" value="View schedule"/>
</form>';

}



if (isset($_GET['trip_id'])) {$trip_conditional='AND trips.trip_id='.$_GET['trip_id']; echo '<h4>Single trip view</h4>';} else {$trip_conditional='';}

$trips_query = "select DISTINCT stop_times.arrival_time, trips.trip_short_name, trips.trip_id, headsigns.headsign, calendar.service_label, calendar.calendar_id, trips.service_id from trips left join stop_times on trips.trip_id=stop_times.trip_id inner join calendar on trips.service_id=calendar.calendar_id
left join headsigns on trips.headsign_id = headsigns.headsign_id
where trips.route_id =$route_id AND trips.direction_id=$direction_id AND service_id IN (".implode(",",$service_ids).") $trip_conditional $time_of_day_conditional and stop_times.stop_id=$common_stop ORDER BY arrival_time";

// echo $trips_query;

$trips_result = db_query($trips_query);

$trips_array = array();
while ($row=db_fetch_array($trips_result)) {array_push($trips_array, $row['trip_id']);}
$trips_list = implode (",",$trips_array);


$stops_query = "select DISTINCT stops.stop_id,stops.stop_name,stops.zone_id,stops.stop_list_order,stops.stop_list_order_sortqual,stops.stop_lat,stops.stop_lon from stop_times inner join stops on stop_times.stop_id=stops.stop_id where stop_times.trip_id in ($trips_list) order by stops.stop_list_order $order,stops.stop_list_order_sortqual $order";


$stops_result = db_query($stops_query);

echo '<table cellspacing="0">
<tr><th id="stop">Stops (READ DOWN)</th></tr>
<tr><td><i>click name for map</i></td>';

$colorbackrotate=' class="colorback"';

db_data_seek ($trips_result, 0);

while ($row = db_fetch_array($trips_result, MYSQL_ASSOC)) {
echo '
	<th';

if (in_array($row['service_id'], $supplemental_service_id ) ) {echo ' class="supplemental"';}
else {echo $colorbackrotate;}

if ($colorbackrotate=="") {$colorbackrotate=' class="colorback"';}
else {$colorbackrotate="";}

echo ' style="text-align:center;" align="center"><i>'.$row['trip_short_name'].'</i></th>';
}

while ($row = db_fetch_array($stops_result, MYSQL_ASSOC)) {

echo '<tr><th><nobr><a href="http://maps.google.com/maps?f=q&hl=en&q='.$row['stop_lat'].'+,'.$row['stop_lon'].'&z=17">'.$row['stop_name'].'</a>&nbsp;&nbsp;&nbsp;</nobr></th>';

$stop_id=$row['stop_id'];

// reset row pointer for trips_result
db_data_seek ($trips_result, 0);

//reset $colorbackrotate
$colorbackrotate=' class="colorback"';

// loop over trips

while ($row = db_fetch_array($trips_result, MYSQL_ASSOC)) {

$trip_id=$row['trip_id'];

$stop_time_query = "select to_char(arrival_time, 'HH12:MI am') AS stop_time from stop_times where stop_id=$stop_id and trip_id=$trip_id LIMIT 1";
$stop_time_result = db_query($stop_time_query);

echo '
	<td';

if (in_array($row['service_id'], $supplemental_service_id ) ) {echo ' class="supplemental"';}
else {echo $colorbackrotate;}

echo $colorbackrotate;

if ($colorbackrotate=="") {$colorbackrotate=' class="colorback"';}
else {$colorbackrotate="";}


echo '>';

if ($stop_time_result) {

if (db_num_rows($stop_time_result) > 0) { 

while ($row = db_fetch_array($stop_time_result, MYSQL_ASSOC)) {

echo '&nbsp;&nbsp;<nobr>'.$row['stop_time'].'</nobr>&nbsp;&nbsp;';

}

}

else {echo '&nbsp;&nbsp;--&nbsp;&nbsp;';}


} 


echo '</td>';

}

echo '</tr>
';

}

echo '</table>';


if ($route_id == 8) {

echo '<p>Connection to RTS Mainline with service to Fortuna, Eureka, McKinleyville, Trinidad, and other destinations is available at the Arcata Transit Center.  <a href="../">See schedules</a>.
</p>
<p>Connection to <a href="http://www.trinitytransit.org">Trinity Transit</a> with service to Weaverville and Redding is availanble in Willow Creek: See <a href="http://www.trinitytransit.org/timetables/willow-creek/">Weaverville/Willow Creek timetable</a>.</p>';

}


}

?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2025592-1";
urchinTracker();
</script>

</body>

</html>