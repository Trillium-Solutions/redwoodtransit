<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-us">

<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="css/main.css" rel="stylesheet" type="text/css" media="all" />
<meta name="description" content="RTS is the public bus system for Humboldt County, California offering intercity Monday through Saturday service between Scotia, Fortuna, Loleta, Fields Landing, Eureka, Arcata, McKinleyville, Westhaven, and Trinidad and Monday through Friday service to Willow Creek from Arcata." />
<title>Redwood Transit System</title>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">

<style type="text/css">
#ui-datepicker-div {font-size:60%;}
.obscure { 
position: absolute !important; 
clip: rect(1px 1px 1px 1px); /* IE6, IE7 */ 
clip: rect(1px, 1px, 1px, 1px); 
} 
</style>


<script>

function initialize() {


var defaultBounds = new google.maps.LatLngBounds(
	new google.maps.LatLng(40.802089, -124.163751)
	);

var origin_input = document.getElementById('saddr');
var destination_input = document.getElementById('daddr');


var options = {
	bounds: defaultBounds,
	componentRestrictions: {country: 'us'}
};


var autocomplete_origin = new google.maps.places.Autocomplete(origin_input, options);    
var autocomplete_destination = new google.maps.places.Autocomplete(destination_input, options);
}

google.maps.event.addDomListener(window, 'load', initialize);


</script>

<style type="text/css">
#logo_header {
	display: block;
	width: 200px;
	padding:10px;
	height: 75px;
	float:left
	}
</style>



</head>

<body onload="MM_preloadImages('images/nav_bar2/symbol%20icon%20row%20v3_r1_c1_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c3_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c5_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c7_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c9_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c11_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f3.gif');">


<a href="#Content" class="hidden">Skip to Content</a>
<div id="Container">

<?php require_once ('includes/google_translate.html'); ?>

<div id="ContentWrapper">



<div id="logo_header">
<img src="images/rts_logo.gif" alt="Redwood Transit System logo" border="0" width="252" height="81" />
</div>

<div id="nav_links">


<?php require_once ('includes/nav_bar.html'); ?>



</div>

<br clear="all"/>

<hr size="2"  width="98%" style="padding-left:10px;padding-right:10px;"/>

<div id="trip_planner">

<h2 class="green_bar_header" style="width:230px;padding-left:4px;margin:0px; line-height:0px float:left">Trip Planner</h2>

<span style="font-size:10px;">
Read <a href="trip_planner.html">info and terms &amp; conditions</a>.  Trip planning is provided using <a href="http://www.google.com/transit">Google Maps</a>.
</span>

<form name="f" action="https://www.google.com/transit"><input type="hidden" name="ie" value="UTF8"/><input type="hidden" name="f" value="d"/>
    <table>
        <tr>
            <td style="font-size:14px;"><strong>Start</strong></td>
		</tr>
		
 <tr>
            <td valign="top"><input type="text" alt="Start address" style="width:15em" size="15" name="saddr" tabindex="1" maxlength="2048" id="saddr"/><br/>
            <font size="-2" color="#555555">e.g. 5th &amp; D Streets, Eureka, CA</font></td>
</tr>

<tr>
<td style="font-size:14px;"><strong>End</strong>&nbsp;&nbsp;</td></tr>
<tr>
<td><input type="text" alt="Destination address" style="width:15em" size="15" name="daddr" id="daddr" tabindex="1" maxlength="2048"/><input type="hidden" name="sll" value="40.823060,-124.090109"/><br/>
<font size="-2" color="#555555">e.g. 1 Harpst Street, Arcata, CA</font></td></tr>
<tr>
<td valign="top"><input type="submit" value="Get Directions" tabindex="1"/></td>
</tr>

<tr>
<td><font size="-1"><input type="radio" id="leave" alt="Leave at" name="ttype" value="dep" checked="checked" tabindex="1"/><label for="leave">Depart at</label> &nbsp;<font color="#888888">or</font> <input type="radio" alt="Arrive by at" id="arrive" name="ttype" value="arr" tabindex="1"/><label for="arrive">Arrive by</label></font></td></tr>
<tr>
<td><font size="-1"><input type="text" alt="Date" id="fdate" size="10" name="date" value="" tabindex="1" maxlength="100"/>  <input type="text" id="ftime" alt="Time" size="10" name="time" value="" tabindex="1" maxlength="100"/></font></td>
        </tr>
    </table>
</form>


</div>

<script type="text/javascript">
var thisdate = new Date();
 
function formatDate(date) { 
var d = new Date(date); 
var hh = d.getHours(); 
var m = d.getMinutes(); 
var dd = "AM"; 
var h = hh; 
if (h >= 12) { 
h = hh-12; 
dd = "PM"; 
} 
if (h == 0) { 
h = 12; 
} 
m = m<10?"0"+m:m; 
 
return h+':'+m+' '+dd 
}
 
document.getElementById('ftime').value=formatDate(thisdate); 

var d = new Date(),
month = d.getMonth() + 1,
day = d.getDate(),
year = d.getFullYear();

document.getElementById('fdate').value = month + '/' + day + '/' +  year ;

var format = 'g:i A';
var step = 1;

function parseTime(time, format, step) {
 
 var hour, minute, stepMinute,
 defaultFormat = 'g:ia',
 pm = time.match(/p/i) !== null,
 num = time.replace(/[^0-9]/g, '');
 
 // Parse for hour and minute
 switch(num.length) {
 case 4:
 hour = parseInt(num[0] + num[1], 10);
 minute = parseInt(num[2] + num[3], 10);
 break;
 case 3:
 hour = parseInt(num[0], 10);
 minute = parseInt(num[1] + num[2], 10);
 break;
 case 2:
 case 1:
 hour = parseInt(num[0] + (num[1] || ''), 10);
 minute = 0;
 break;
 default:
 return '';
 }
 
 if( pm === true && hour > 0 && hour < 12 ) hour += 12;
 
 if( hour >= 13 && hour <= 23 ) pm = true;
 
 if( step ) {
 if( step === 0 ) step = 60;
 stepMinute = (Math.round(minute / step) * step) % 60;
 if( stepMinute === 0 && minute >= 30 ) {
 hour++;
 if( hour === 12 || hour === 24 ) pm = !pm;
 }
 minute = stepMinute;
 }
 
 if( hour <= 0 || hour >= 24 ) hour = 0;
 if( minute < 0 || minute > 59 ) minute = 0;
 
 return (format || defaultFormat)
        .replace(/g/g, hour === 0 ? '12' : 'g')
 .replace(/g/g, hour > 12 ? hour - 12 : hour)
 .replace(/G/g, hour)
 .replace(/h/g, hour.toString().length > 1 ? (hour > 12 ? hour - 12 : hour) : '0' + (hour > 12 ? hour - 12 : hour))
 .replace(/H/g, hour.toString().length > 1 ? hour : '0' + hour)
 .replace(/i/g, minute.toString().length > 1 ? minute : '0' + minute)
 .replace(/s/g, '00')
 .replace(/a/g, pm ? 'pm' : 'am')
 .replace(/A/g, pm ? 'PM' : 'AM');
 
}


function update() {
    $('#ftime').val(parseTime($('#ftime').val(), format, step));   
}

$(document).ready( function() {
    
    $('#ftime').blur(update);

 $(function() {
    $( "#fdate" ).datepicker({dateFormat: "mm/dd/yy"});
  });
    

});
</script>


<div id="feature_image">

<img src="images/rts_bus.jpg" alt="RTS bus in redwoods" border="0" width="527" height="248" />
</div>


<br clear="all" />

<div id="three_columns">

<div class="third_column" style="width:250px">
<h2 class="green_bar_header" style="padding-left:4px;width:250px;margin:0px; line-height:0px float:left">Schedules</h2>

<p><a href="schedules/">See schedules page for Mainline, Willow Creek, Southern Humboldt Intercity and Southern Humboldt Local services.</a></p>

<!--
<ul style="padding:0px 10px 0px 20px;margin: 0px 0px 10px 0px;">
<li>Weekdays: <a href="schedules/weekday/north/">Mainline Northbound</a>, <a href="schedules/weekday/south/">Mainline Southbound</a>, <a href="schedules/weekday/willowcreek/">Willow Creek</a>, <a href="schedules/#sohum-intercity">Southern Humboldt Local & Intercity</a></li>
<li>Saturday service: <a href="schedules/saturday/north/">Mainline Northbound</a>, <a href="schedules/saturday/south/">Mainline Southbound</a>, <a href="schedules/saturday/willowcreek/">Willow Creek</a></li>
<li>Sunday service: <a href="schedules/sunday/north/">Mainline Northbound</a>, <a href="schedules/sunday/south/">Mainline Southbound</a></li>

</ul>

-->

</div>

<?php 

require_once ('postgres_connect.php');

$service_update_query = "select news_id,title from news where news_category_id=1 and agency_id = 1 and start_date < now() and end_date > now() order by start_date desc";
$service_update_result = db_query($service_update_query);

?>


<div class="third_column">
<h2 class="green_bar_header" style="padding-left:0px;margin:0px; line-height:0px float:left;">Service updates</h2>

<?php

echo "<ul style=\"height:120px;border-left:1px solid gray;border-right:1px solid gray; padding:0px 0px 0px 20px;margin: 0px 0px 10px 0px;\">";

if (db_num_rows($service_update_result) != 0) {



while ($row = db_fetch_array($service_update_result, MYSQL_ASSOC)) {
echo "<li><a href=\"news.php?id=".$row['news_id']."\">".$row['title']."</a></li>";}

}

else {echo "<p><i>There are no current service updates.</i></p>";}


echo '<li><a href="schedules/holidays.php">Holiday service calendar</a></li>
</ul>';

$news_query = "select news_id,title from news where news_category_id=2 and agency_id = 1 and start_date < now() and end_date > now() order by start_date desc";
$news_result = db_query($news_query);

?>

</div>

<div class="third_column">
<h2 class="green_bar_header" style="padding-left:0px;margin:0px; line-height:0px float:left">News &amp; announcements</h2>

<?php

if (db_num_rows($news_result) != 0) {

echo "<ul style=\"height:120px;border-left:1px solid gray;border-right:1px solid gray; padding:0px 0px 0px 20px;margin: 0px 0px 10px 0px;\">";

while ($row = db_fetch_array($news_result, MYSQL_ASSOC)) {
echo "<li><a href=\"news.php?id=".$row['news_id']."\">".$row['title']."</a></li>";}
echo "</ul>";

}

else {echo "<p><i>There is no current news.</i></p>";}

?>

</div>


<br clear="all"/>
<hr size="2"  width="784" style="padding-left:10px;padding-right:10px;"/>
<p><strong>Redwood Transit System (RTS)</strong> is the public bus system for <a style="font-weight:normal;" href="http://en.wikipedia.org/wiki/Humboldt_County,_California">Humboldt County, California</a>.  RTS offers service between Scotia, Fortuna, Loleta, Fields Landing, Eureka, Arcata, McKinleyville, Westhaven, and Trinidad Monday through 7 days per week.  RTS offers service between Willow Creek and Arcata Monday through Saturday.  RTS provides more than 400,000 passenger-trips per year. RTS is operated by <a href="http://www.hta.org/">Humboldt Transit Authority (HTA)</a>.
</p>

</div>

</div>
<br clear="all" />
</div>

<?php require_once ('includes/footer.html'); ?>

</body>

</html>