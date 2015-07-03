<?php

// Start output buffering.
ob_start();
// Initialize a session.
session_start();

require_once ('../mysql_connect.php');

if (isset ($_GET['printable'])) {$printable=1;} else {$printable=0;}
$service_id=1;
$stop_id_2=0;
if (isset ($_GET['stop_id_2'])) {$stop_id_2=$_GET['stop_id_2'];}

if (isset($_GET['service_id'])) {$service_id=$_GET['service_id'];}
if ($service_id==1 || $service_id==336) {$service_id='336,11'; $singular_service_id=336;} else {$singular_service_id=191;}

// run query for service information
$service_query = "select * from service_schedule_groups where service_schedule_group_id in ($singular_service_id)";
$service_result = mysql_query($service_query);

while ($row=mysql_fetch_array($service_result, MYSQL_ASSOC))
{$service_label=$row['service_label'];}

if (isset($_GET['stop_id'])) {$stop_id=$_GET['stop_id'];}

// run query for stop information
$stop_query = "select * from stops where stop_id=$stop_id or couplet=$stop_id";
$stop_result = mysql_query($stop_query);

$lat=array();
$lon=array();
$stop_i=0;
// sset stop_name variable, set $map_iframe to be used later
while ($row=mysql_fetch_array($stop_result, MYSQL_ASSOC))
{
$direction=$row['direction'];
if (isset($stop_name)) {if ($stop_name!=$row['stop_name']) {$stop_name=$stop_name.'/<br/>'.$row['stop_name'];}} else {$stop_name=$row['stop_name'];}
if ($row['couplet'] =! 0) {$stop_id=$row['stop_id'];}
$lat[$stop_i]=$row['stop_lat'];
$lon[$stop_i]=$row['stop_lon'];
if ($stop_i==0) {$stop_select_list=$stop_id;}
else {$stop_select_list=$stop_select_list.",".$stop_id;}
if ($row['direction'] == 'Northbound' || $row['direction'] == 'Southbound') {$stop_name=$stop_name.' ('.$direction.')';}
++$stop_i;
}

// show stop name as title, set $map_iframe to be used later
while ($row=mysql_fetch_array($stop_result, MYSQL_ASSOC))
{$stop_name=$row['stop_name'];
}

// query for trips not based on others
$trips_query="SELECT trip_id from trips WHERE route_id = 1 and service_id in ($service_id) and based_on is null;";
$trips_result=mysql_query($trips_query);

// create list of trips
$trips_array = array();
while ($row=mysql_fetch_array($trips_result, MYSQL_ASSOC)) {array_push($trips_array, $row['trip_id']);}
$trips = implode (",",$trips_array);


// select stop times based on conditionals of trips and stop_id, put into temporary table
$clear_temp_stop_times_query="DELETE FROM temp_stop_times;";
$clear_temp_stop_times_result = mysql_query($clear_temp_stop_times_query);

$create_temp_stop_times_query= "INSERT INTO temp_stop_times (agency_id, stop_time_id, trip_id, arrival_time, departure_time, stop_id, stop_sequence, pickup_type, drop_off_type, shape_dist_traveled, route_id, service_id, direction_id )  SELECT stop_times.agency_id, stop_times.stop_time_id, stop_times.trip_id, stop_times.arrival_time, stop_times.departure_time, stop_times.stop_id, stop_times.stop_sequence, stop_times.pickup_type, stop_times.drop_off_type, stop_times.shape_dist_traveled,trips.route_id,trips.service_id,trips.direction_id FROM stop_times left join trips on stop_times.trip_id=trips.trip_id inner join stops on stop_times.stop_id=stops.stop_id WHERE stop_times.agency_id=1 and trips.route_id =1 and stops.stop_id in ($stop_select_list) and service_id in ($service_id);";

// echo $create_temp_stop_times_query;

$create_temp_stop_times_result = mysql_query($create_temp_stop_times_query);

// query for trips based on others
$trips_based_on_query="SELECT * from trips WHERE route_id in (1,2) and service_id in ($service_id) and based_on is not null;";
$trips_based_on_result=mysql_query($trips_based_on_query);

// query for southbound trips
$trips_south_query="SELECT trip_id from trips WHERE route_id=1 and direction_id=6 and service_id in ($service_id)";
$trips_south_result=mysql_query($trips_south_query);

// create list of southbound trips
$south_trips_array = array();
while ($row=mysql_fetch_array($trips_south_result, MYSQL_ASSOC)) {array_push($south_trips_array, $row['trip_id']);}
$south_trips = implode (",",$south_trips_array);

// query for northbound trips
$trips_north_query="SELECT trip_id from trips WHERE route_id=1 and direction_id=5 and service_id in ($service_id)";
$trips_north_result=mysql_query($trips_north_query);

// create list of northbound trips
$north_trips_array = array();
while ($row=mysql_fetch_array($trips_north_result, MYSQL_ASSOC)) {array_push($north_trips_array, $row['trip_id']);}
$north_trips = implode (",",$north_trips_array);


// loop trips based on others to get stop times
while ($row = mysql_fetch_array($trips_based_on_result, MYSQL_ASSOC)) {
$stop_times_query = "select * from stop_times where trip_id=".$row['based_on']." and agency_id =1 order by stop_sequence asc;";
$stop_times_result = mysql_query($stop_times_query);
$loop_count_index=1;

// now, find out what the difference between the based_on trip's start time is, and the reset start time for this specific trip
$first_stop_time_original=mysql_result($stop_times_result,0,"arrival_time");
$time_difference = strtotime($row['trip_start_time']) - strtotime($first_stop_time_original);

while ($row = mysql_fetch_array($stop_times_result, MYSQL_ASSOC)) {

$adjusted_arrival_time=$time_difference+strtotime($row['arrival_time']);
$adjusted_departure_time=$time_difference+strtotime($row['departure_time']);

$insert_temp_stop_times_query="INSERT INTO temp_stop_times (stop_id, arrival_time, departure_time, stop_sequence, pickup_type, drop_off_type, agency_id, trip_id,direction_id) VALUES ($stop_id, '$adjusted_arrival_time', '$adjusted_departure_time',".$row['stop_sequence'].", ".$row['pickup_type'].", ".$row['drop_off_type'].", ".$row['agency_id'].", ".$row['trip_id'].','.$row['direction_id'].")";
$insert_temp_stop_times_result=mysql_query($insert_temp_stop_times_query);


$loop_count_index=$loop_count_index+1;

// emd while loop for $stop_times_result
}

// end while loop for trips
}

// find out what the earliest and latest stop times are
$minmaxtimes_query="SELECT time_format(max(arrival_time), '%k') as last_time, time_format(min(arrival_time), '%k') as first_time FROM temp_stop_times;";
$minmaxtimes_result=mysql_query($minmaxtimes_query);
while ($row = mysql_fetch_array($minmaxtimes_result, MYSQL_ASSOC)) {
$last_time=$row['last_time'];
$first_time=$row['first_time'];}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Adobe GoLive" />
		<title>Redwood Transit System Stop times at <?php echo $stop_name; ?></title>
<?php if ($printable==0) {echo '<link href="../css/main.css" rel="stylesheet" type="text/css" media="all" />';}  ?>

<style type="text/css">
#instruction {float:left; width:200px;height:300px;margin-left:10px;margin-right:10px;}
li {margin-left:20px; padding-right:7px;}
#route_name {font-size:50px;font-weight:bold;}
body {font-family:  "Lucida Grande," Lucida Sans Unicode, verdana, arial, sans-serif;
font-size: small;}
a {
	color:#060;
	text-decoration:none;
	font-weight:900;
	font-family:verdana, arial, helvetica, sans-serif;
	}
	
a:link { color: #060; 
	font-weight:900;
}

a:visited { color: #363; }

a:hover {text-decoration:underline;}
</style>





<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAtMnWGmIz_Lxo5I8zLfj34BSb1UsQ7Upmy2wp-mJLS2fPW_ztmBTsozDOmGM_OU_M_N3uCO30s0mamQ"
      type="text/javascript"></script>

<?php
echo '<script type="text/javascript">

    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng('.$lat[0].', '.$lon[0].'),16);
        var myGeographicCoordinates1 = new GLatLng('.$lat[0].', '.$lon[0].')';
        if (isset($lat[1])) {echo '
        var myGeographicCoordinates2 = new GLatLng('.$lat[1].', '.$lon[1].')
        ';}

echo '
var polyline = new GPolyline([';
        
$shape_query="select * from shape_points where shape_id=6 order by shape_pt_sequence ASC;";
$shape_result = mysql_query($shape_query);

// then loop over the result
while ($row = mysql_fetch_array($shape_result, MYSQL_ASSOC)) {
echo 'new GLatLng('.$row['shape_pt_lat'].', '.$row['shape_pt_lon'].'),
';
}
        
echo'		], "#ff0000", 10);
		map.addOverlay(polyline);
		';
echo '
map.addOverlay(new GMarker(myGeographicCoordinates1));';
if (isset($lat[1])) {echo '
map.addOverlay(new GMarker(myGeographicCoordinates2));';}
echo'
        map.addControl(new GMapTypeControl());
      	map.addControl(new GSmallZoomControl());
      }
    }

    //]]>
    </script>';
?>

</head>

<body onload="load();MM_preloadImages('images/nav_bar2/symbol%20icon%20row%20v3_r1_c1_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c3_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c5_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c7_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c9_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c11_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f3.gif');" onunload="GUnload()" >

<?php

if ($printable==0) {echo '<a href="#Content" class="hidden">Skip to Content</a>
<div id="Container">
<div id="ContentWrapper">';}


?>

<div id="logo_header_left">
<a href="../"><img src="../images/rts_logo.gif" alt="" border="0" width="252" height="81" /></a>
</div>

<?php

if ($printable==1) {echo '<a href="http://www.redwoodtransit.org/schedules/stop_times.php?'.str_replace ( '&printable=1' , '', $_SERVER['QUERY_STRING']).'"><br/>&laquo; Back to normal display version</a>';}

if ($printable==0) {echo '

<div id="nav_links">';

require_once ('../includes/nav_bar.html');

echo '

</div>

<br clear="all">

<hr size="2"  width="784" style="padding-left:10px;padding-right:10px;">

<div id="page_text_itself" style="width:670;margin-left:3px; padding-left:30px;">

<strong><a href="../">RTS Home</a> &#xBB; <a href="index.php">Schedules</a> &#xBB; Timetables by stop &#xBB; </strong>

<br clear="all"/>
';}



if ($printable==0) {


$stops_query = "SELECT DISTINCT s1.stop_list_order,s1.stop_id, IFNULL( if( s1.stop_name = s2.stop_name, NULL , CONCAT( s1.stop_name, '/', s2.stop_name ) ) , s1.stop_name ) AS stop_name
FROM stops s1
INNER JOIN stop_times ON s1.stop_id = stop_times.stop_id
INNER JOIN stops s2 ON s1.couplet = s2.stop_id
WHERE stop_times.departure_time IS NOT NULL and stop_times.arrival_time IS NOT NULL AND s1.agency_id =1
and (
s2.direction_id =6
OR s2.direction_id =0
OR s2.direction_id IS NULL
)
AND stop_times.trip_id
IN ( $trips )

union distinct

SELECT min(stops.stop_list_order) as stop_list_order, Min(stops.stop_id) as stop_id,stops.stop_name
FROM stops
INNER JOIN stop_times ON stops.stop_id = stop_times.stop_id

left outer join stops s2 ON stops.couplet = s2.stop_id
where
 s2.stop_id is null and stops.agency_id =1

AND stop_times.trip_id
IN ( $trips )
AND stop_times.departure_time IS NOT NULL and stop_times.arrival_time IS NOT NULL

GROUP BY stop_name


ORDER BY stop_list_order";



$stops_result = mysql_query($stops_query);

echo '<form method="get" action="stop_times.php" style="margin-top:10px;">

<fieldset><legend style="font-weight:bold;">Change or add a stop</legend>
<table cellpadding="0" cellspacing="5" border="0"><tr><td align="right">
Choose a different primary stop<sup>*</sup></td><td><select name="stop_id" size="1">';
while ($row = mysql_fetch_array($stops_result, MYSQL_ASSOC)) {
echo "<option value='".$row['stop_id']."'";
if ($row['stop_id']==$stop_id) {echo " selected";}
echo ">" , $row['stop_name'], "</option>";
}

echo '</select></td></tr>';

echo '<tr><td align="right">Choose a second stop to display alongside</td>';


mysql_data_seek ($stops_result, 0);

echo "<td><select name='stop_id_2' size='1'>";
echo '<option value="0"';
if ($stop_id_2==0) {echo ' selected="selected"';}
echo '>No stop selected</option>';
while ($row = mysql_fetch_array($stops_result, MYSQL_ASSOC)) {
echo "<option value='".$row['stop_id']."'";
if ($row['stop_id']==$stop_id_2) {echo " selected";}
echo ">" , $row['stop_name'], "</option>";
}

echo '</select></td></tr>

<tr><td align="right">Service schedule:</td><td><select name="service_id" size="1">';
echo '<option value="190" ';
if ($service_id==336) {echo'selected="selected"';}
echo ">Weekday service</option>";
echo '<option value="191" ';
if ($service_id==191) {echo'selected="selected"';}
echo ">Saturday service</option></select></td></tr>
<tr><td></td><td><input type=\"submit\" value=\"Go!\"/></td></tr>
</table>
</fieldset>";

echo '</form>';

echo '<a href="http://www.redwoodtransit.org/schedules/stop_times.php?'.$_SERVER['QUERY_STRING'].'&printable=1"><img src="printable_icon.gif" alt="image" width="18" height="16" border="0" style="border:0px;"/>Printable version of this page</a><br/>Click any time below to see a complete itinerary of stop locations for that trip';
}

?>

<br clear="all"/>

<?php

echo '<div style="float:left"><table cellpadding="3" cellspacing="0" border="0" style="margin-top:15px;margin-bottom:15px;">
<tr><th style="color:white;background-color:black;border-top-style: solid; border-top-width: 1px;font-weight:bold;text-align:center;" colspan="3" >'.$stop_name.'</td></tr>
<tr><th colspan="3" style="font-weight:bold;text-align:center;border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">'.$service_label.'</td></tr>
<tr style="font-size:90%; "><th align="right" style="border-bottom-style: solid; border-bottom-width: 1px;font-style:italic;text-align:right;"><strong>Southbound</strong></th><th style="border-bottom-style: solid; border-bottom-width: 1px; padding-left:10px;padding-right:10px;text-align:center;">Hour</th><th style="border-bottom-style: solid; border-bottom-width: 1px;font-style:italic"><strong>Northbound</strong></th></tr>';

$i = $first_time;

while ($i <= $last_time) {


echo '<tr><td align="right" style="align:right; border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

// query for the stop times here
$south_stop_times_hour_query="select route_id,trip_id,service_id,time_format(arrival_time, ':%i') as arrival_time,direction_id from temp_stop_times where route_id=1 and direction_id=6 and arrival_time BETWEEN '$i:00:00' and '$i:59:59' order by arrival_time desc";
$south_stop_times_hour_result = mysql_query($south_stop_times_hour_query);

// then loop over the result
while ($row = mysql_fetch_array($south_stop_times_hour_result, MYSQL_ASSOC)) {
echo '&#160;&#160;&#160;';
if ($row['service_id']==11) {echo '<span style="background-color:#a4cbe7;padding:5px;">';}
echo '<a style="font-weight:normal;color:black;" href="http://www.redwoodtransit.org/schedules/display_schedule.php?route_id='.$row['route_id'].'&service='.$row['service_id'].'&trip_id='.$row['trip_id'].'&direction_id='.$row['direction_id'].'">'.$row['arrival_time'].'</a>';
if ($row['service_id']==11) {echo '<sup>*</sup></span>';$supplemental=true;}
}

echo '</td><th align="center" style="padding-left:15px;padding-right:15px;text-align:center;font-weight:bold; border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

if ($i > 12) { $pm_time=$i-12;echo $pm_time.' pm';}
else {echo $i.' am';}

echo '</th><td style="border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

// query for the north stop times here
/* $north_stop_times_hour_query="select service_id,time_format(arrival_time, ':%i') as arrival_time from temp_stop_times where trip_id in ($north_trips) and arrival_time between '$i:00:00' and '$i:59:59'"; */

$north_stop_times_hour_query="select route_id,trip_id,service_id,time_format(arrival_time, ':%i') as arrival_time,direction_id from temp_stop_times where route_id=1 and direction_id=5 and arrival_time BETWEEN '$i:00:00' and '$i:59:59' order by arrival_time asc";
$north_stop_times_hour_result = mysql_query($north_stop_times_hour_query);

// then loop over the result
while ($row = mysql_fetch_array($north_stop_times_hour_result, MYSQL_ASSOC)) {
if ($row['service_id']==11) {echo '<span style="background-color:#a4cbe7;padding:6px;">';}
echo '<a style="font-weight:normal;color:black;" href="http://www.redwoodtransit.org/schedules/display_schedule.php?route_id='.$row['route_id'].'&service='.$row['service_id'].'&trip_id='.$row['trip_id'].'&direction_id='.$row['direction_id'].'">'.$row['arrival_time'].'</a>';
if ($row['service_id']==11) {echo '<sup>*</sup></span>';$supplemental=true;}
echo '&#160;&#160;&#160;';}

echo '</td></tr>
';

++$i;

}

if ($supplemental==true) {echo '<tr><td colspan="3" style="text-align:center;background-color:#a4cbe7;"><sup>*</sup>Blue highlighted times <br/>indicate the supplemental<br/>(Mon-Thurs) schedule.</td></tr>';}

echo '</table></div>';

if ($stop_id_2 == 0) {

echo '<div style="float:left; margin-left:30px;margin-top:15px;">
<div id="map" style="width: 375px; height: 375px;"></div><br>
<a href="http://maps.google.com/maps?f=q&hl=en&q='.$lat[0].'+,'.$lon[0].'&z=17">See larger map</a></div>';

}


// show the second stop alongside
else {










// run query for stop information
$stop_query = "select * from stops where stop_id=$stop_id_2 or couplet=$stop_id_2";
$stop_result = mysql_query($stop_query);

$lat=array();
$lon=array();
$stop_i=0;
unset($stop_name);
unset($supplemental);

// sset stop_name variable, set $map_iframe to be used later
while ($row=mysql_fetch_array($stop_result, MYSQL_ASSOC))
{
$direction=$row['direction'];
if (isset($stop_name)) {if ($stop_name!=$row['stop_name']) {$stop_name=$stop_name.'/<br/>'.$row['stop_name'];}} else {$stop_name=$row['stop_name'];}
if ($row['couplet'] =! 0) {$stop_id_2=$row['stop_id'];}
$lat[$stop_i]=$row['stop_lat'];
$lon[$stop_i]=$row['stop_lon'];
if ($stop_i==0) {$stop_select_list=$stop_id_2;}
else {$stop_select_list=$stop_select_list.",".$stop_id_2;}
if ($row['direction'] == 'Northbound' || $row['direction'] == 'Southbound') {$stop_name=$stop_name.' ('.$direction.')';}
++$stop_i;
}

// show stop name as title, set $map_iframe to be used later
while ($row=mysql_fetch_array($route_result, MYSQL_ASSOC))
{$stop_name=$row['stop_name'];
}

// query for trips not based on others
$trips_query="SELECT trip_id from trips WHERE route_id =1 and service_id in ($service_id) and based_on is null;";
$trips_result=mysql_query($trips_query);

// create list of trips
$trips_array = array();
while ($row=mysql_fetch_array($trips_result, MYSQL_ASSOC)) {array_push($trips_array, $row['trip_id']);}
$trips = implode (",",$trips_array);


// select stop times based on conditionals of trips and stop_id, put into temporary table
$clear_temp_stop_times_query="DELETE FROM temp_stop_times;";
$clear_temp_stop_times_result = mysql_query($clear_temp_stop_times_query);

$create_temp_stop_times_query= "INSERT INTO temp_stop_times (agency_id, stop_time_id, trip_id, arrival_time, departure_time, stop_id, stop_sequence, pickup_type, drop_off_type, shape_dist_traveled, route_id, service_id, direction_id) SELECT stop_times.agency_id, stop_times.stop_time_id, stop_times.trip_id, stop_times.arrival_time, stop_times.departure_time, stop_times.stop_id, stop_times.stop_sequence, stop_times.pickup_type, stop_times.drop_off_type, stop_times.shape_dist_traveled,trips.route_id,trips.service_id,trips.direction_id FROM stop_times left join trips on stop_times.trip_id=trips.trip_id inner join stops on stop_times.stop_id=stops.stop_id WHERE stop_times.agency_id=1 and trips.route_id =1 and stops.stop_id in ($stop_select_list) and service_id in ($service_id);";

$create_temp_stop_times_result = mysql_query($create_temp_stop_times_query);

// query for trips based on others
$trips_based_on_query="SELECT * from trips WHERE route_id in (1,2) and service_id in ($service_id) and based_on is not null;";
$trips_based_on_result=mysql_query($trips_based_on_query);

// query for southbound trips
$trips_south_query="SELECT trip_id from trips WHERE route_id=1 and direction_id=6 and service_id in ($service_id)";
$trips_south_result=mysql_query($trips_south_query);

// create list of southbound trips
$south_trips_array = array();
while ($row=mysql_fetch_array($trips_south_result, MYSQL_ASSOC)) {array_push($south_trips_array, $row['trip_id']);}
$south_trips = implode (",",$south_trips_array);

// query for northbound trips
$trips_north_query="SELECT trip_id from trips WHERE route_id=1 and direction_id=5 and service_id in ($service_id)";
$trips_north_result=mysql_query($trips_north_query);

// create list of northbound trips
$north_trips_array = array();
while ($row=mysql_fetch_array($trips_north_result, MYSQL_ASSOC)) {array_push($north_trips_array, $row['trip_id']);}
$north_trips = implode (",",$north_trips_array);


// loop trips based on others to get stop times
while ($row = mysql_fetch_array($trips_based_on_result, MYSQL_ASSOC)) {
$stop_times_query = "select * from stop_times where trip_id=".$row['based_on']." and agency_id =1 order by stop_sequence asc;";
$stop_times_result = mysql_query($stop_times_query);
$loop_count_index=1;

// now, find out what the difference between the based_on trip's start time is, and the reset start time for this specific trip
$first_stop_time_original=mysql_result($stop_times_result,0,"arrival_time");
$time_difference = strtotime($row['trip_start_time']) - strtotime($first_stop_time_original);

while ($row = mysql_fetch_array($stop_times_result, MYSQL_ASSOC)) {

$adjusted_arrival_time=$time_difference+strtotime($row['arrival_time']);
$adjusted_departure_time=$time_difference+strtotime($row['departure_time']);

$insert_temp_stop_times_query="INSERT INTO temp_stop_times (stop_id, arrival_time, departure_time, stop_sequence, pickup_type, drop_off_type, agency_id, trip_id,direction_id) VALUES ($stop_id_2, '$adjusted_arrival_time', '$adjusted_departure_time',".$row['stop_sequence'].", ".$row['pickup_type'].", ".$row['drop_off_type'].", ".$row['agency_id'].", ".$row['trip_id'].','.$row['direction_id'].")";
$insert_temp_stop_times_result=mysql_query($insert_temp_stop_times_query);


$loop_count_index=$loop_count_index+1;

// emd while loop for $stop_times_result
}

// end while loop for trips
}

// find out what the earliest and latest stop times are
$minmaxtimes_result=mysql_query("SELECT time_format(max(arrival_time), '%k') as last_time, time_format(min(arrival_time), '%k') as first_time FROM temp_stop_times;");
while ($row = mysql_fetch_array($minmaxtimes_result, MYSQL_ASSOC)) {
$last_time=$row['last_time'];
$first_time=$row['first_time'];}









echo '<div style="float:left"><table cellpadding="3" cellspacing="0" border="0" style="margin-top:15px;margin-left:40px;margin-bottom:15px;">
<tr><th style="color:white;background-color:black;border-top-style: solid; border-top-width: 1px;font-weight:bold;text-align:center;" colspan="3" >'.$stop_name.'</td></tr>
<tr><th colspan="3" style="font-weight:bold;text-align:center;border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">'.$service_label.'</td></tr>
<tr style="font-size:90%; "><th align="right" style="border-bottom-style: solid; border-bottom-width: 1px;font-style:italic;text-align:right;"><strong>Southbound</strong></th><th style="border-bottom-style: solid; border-bottom-width: 1px; padding-left:10px;padding-right:10px;text-align:center;">Hour</th><th style="border-bottom-style: solid; border-bottom-width: 1px;font-style:italic"><strong>Northbound</strong></th></tr>';

$i = $first_time;

while ($i <= $last_time) {


echo '<tr><td align="right" style="align:right; border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

// query for the stop times here
$south_stop_times_hour_query="select route_id,trip_id,service_id,time_format(arrival_time, ':%i') as arrival_time,direction_id from temp_stop_times where route_id=1 and direction_id=6 and arrival_time BETWEEN '$i:00:00' and '$i:59:59' order by arrival_time desc";
$south_stop_times_hour_result = mysql_query($south_stop_times_hour_query);

// then loop over the result
while ($row = mysql_fetch_array($south_stop_times_hour_result, MYSQL_ASSOC)) {
echo '&#160;&#160;&#160;';
if ($row['service_id']==11) {echo '<span style="background-color:#a4cbe7;padding:5px;">';}
echo '<a style="font-weight:normal;color:black;" href="http://www.redwoodtransit.org/schedules/display_schedule.php?route_id='.$row['route_id'].'&service='.$row['service_id'].'&trip_id='.$row['trip_id'].'&direction_id='.$row['direction_id'].'">'.$row['arrival_time'].'</a>';
if ($row['service_id']==11) {echo '<sup>*</sup></span>';$supplemental=true;}
}

echo '</td><th align="center" style="padding-left:15px;padding-right:15px;text-align:center;font-weight:bold; border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

if ($i > 12) { $pm_time=$i-12;echo $pm_time.' pm';}
else {echo $i.' am';}

echo '</th><td style="border-bottom-color: #C0C0C0; border-bottom-style: solid; border-bottom-width: 1px;">';

// query for the north stop times here
/* $north_stop_times_hour_query="select service_id,time_format(arrival_time, ':%i') as arrival_time from temp_stop_times where trip_id in ($north_trips) and arrival_time between '$i:00:00' and '$i:59:59'"; */

$north_stop_times_hour_query="select route_id,trip_id,service_id,time_format(arrival_time, ':%i') as arrival_time,direction_id from temp_stop_times where route_id=1 and direction_id=5 and arrival_time BETWEEN '$i:00:00' and '$i:59:59' order by arrival_time asc";
$north_stop_times_hour_result = mysql_query($north_stop_times_hour_query);

// then loop over the result
while ($row = mysql_fetch_array($north_stop_times_hour_result, MYSQL_ASSOC)) {
if ($row['service_id']==11) {echo '<span style="background-color:#a4cbe7;padding:6px;">';}
echo '<a style="font-weight:normal;color:black;" href="http://www.redwoodtransit.org/schedules/display_schedule.php?route_id='.$row['route_id'].'&service='.$row['service_id'].'&trip_id='.$row['trip_id'].'&direction_id='.$row['direction_id'].'">'.$row['arrival_time'].'</a>';
if ($row['service_id']==11) {echo '<sup>*</sup></span>';$supplemental=true;}
echo '&#160;&#160;&#160;';}

echo '</td></tr>
';

++$i;

}

if ($supplemental==true) {echo '<tr><td colspan="3" style="text-align:center;background-color:#a4cbe7;"><sup>*</sup>Blue highlighted times <br/>indicate the supplemental<br/>(Mon-Thurs) schedule.</td></tr>';}

echo '</table></div>';




}


if ($printable==0) {echo '

</div>

</div>
<br clear="all" />
</div>

<div id="Footer">
<p><a href="http://groups.google.com/group/humboldttransit/">Email updates</a> &#8226; <a href="../contact.php">Contact/Feedback</a> &#8226; <a href="../link_to/">Link to redwoodtransit.org</a>
<br/><a href="credits.html">Site Credits</a> &#8226; <a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=219"><img border="0" alt="Firefox 2" title="Firefox 2" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox2/ff2b80x15.gif"/></a></p>
</div>';}

?>

		
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2025592-1";
urchinTracker();
</script>

</body>

</html>