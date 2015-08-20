<?php

// Start output buffering.
ob_start();
// Initialize a session.
session_start();

// require_once ('../mysql_connect.php');
require_once ('../postgres_connect.php');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>Redwood Transit System Schedules</title>
		<link href="../css/main.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
#instruction {float:left; width:200px;height:300px;margin-left:10px;margin-right:10px;}
li {margin-left:20px; padding-right:7px;}
#route_name {font-size:50px;font-weight:bold;}
</style>




</head>

<body onload="MM_preloadImages('images/nav_bar2/symbol%20icon%20row%20v3_r1_c1_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c3_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c5_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c7_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c9_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c11_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f2.gif','images/nav_bar2/symbol%20icon%20row%20v3_r1_c13_f3.gif');">


<a href="#Content" class="hidden">Skip to Content</a>
<div id="Container">

<?php require_once ('../includes/google_translate.html'); ?>

<div id="ContentWrapper">




<div id="logo_header_left">
<a href="../"><img src="../images/rts_logo.gif" alt="" border="0" livesrc="../../Documents/Transit%20info%20work/HTA/HTA%20../images/RTS%20LOGO.psd" width="252" height="81" /></a>
</div>

<div id="nav_links">

<?php require_once ('../includes/nav_bar.html'); ?>

</div>

<br clear="all">

<hr size="2"  width="784" style="padding-left:10px;padding-right:10px;">

<div id="page_text_itself" style="width:670;margin-left:3px; padding-left:30px;">

<a href="../">RTS Home</a> &#xBB;







<h1>Schedules</h1>

<a name="101"/></a>
<h3>Mainline (101 Corridor)</h3>
<p><i>Scotia - Rio Dell - Fortuna - Fields Landing - King Salmon - Eureka - Arcata - Mckinleyville - Westhaven - Trinidad</i></p>


<table>

<tr><td colspan="2">Weekday (Mon-Fri)</td></tr>

<tr>

<tr><td style="padding-left:20px"><a href="weekday/north/">Northbound</a></td><td style="padding-left:20px"><a href="weekday/south/"> Southbound<a></td>

<td style="padding-left:20px"><a href="print/Mainline NB:SB M-F 7:5:2015.pdf">Northbound/Southbound PDF </i></a></td></tr>

<tr><td colspan="2">Saturday</td></tr>

<tr><td style="padding-left:20px"><a href="saturday/north/">Northbound</a></td>

<td style="padding-left:20px"><a href="saturday/south/">Southbound<a></td>

</tr>

<tr>

<td style="padding-left:20px" colspan="2"><a href="print/RTS%20Northbound%20Weekend%2005-July-2015.png">Sat/Sun Northbound printable</a></td>

</tr>

<tr><td colspan="2">Sunday</td></tr>

<tr>

<td style="padding-left:20px"><a href="sunday/north/">Northbound</a></td><td style="padding-left:20px"><a href="sunday/south/">Southbound<a></td>

</tr>

<tr>

<td style="padding-left:20px" colspan="2"><a href="print/RTS%20Northbound%20Weekend%2005-July-2015.png">Sat/Sun Northbound printable</a></td>


</tr>


</table>

<a name="willow_creek"/></a>
<h3>Willow Creek / Arcata</h3>



<table>

<tr><td colspan="2">Weekday (Mon-Fri)</td></tr>

<tr><td style="padding-left:20px"><a href="weekday/willowcreek/east">Eastbound</a></td>
<td style="padding-left:20px"><a href="weekday/willowcreek/west">Westbound</a></td>
<td style="padding-left:20px" colspan="2"><a href="print/Willow Creek M-F_S 2015.pdf">PDF</a></td></tr>



</table>

<a name="sohum-intercity"/></a>
<h3>Southern Humboldt Intercity Transit</h3>

<p><i>Garberville - Redwood - Phillipsville - South Fork - Myers Flat - Weott - Rio Dell - Fortuna - Eureka</i></p>



<table>


<tr><td colspan="3">Weekday (Mon-Fri)</td></tr>



<tr>

<td style="padding-left:20px"><a href="sohum-intercity/north/">Northbound</a></td><td style="padding-left:20px"><a href="sohum-intercity/south/">Southbound</a></td>

</tr>

</table>


<a name="sohum-local"/></a>
<h3>Southern Humboldt Local Transit</h3>

<p><i>Local Deviated fixed-route service - South Fork - Phillipsville - Redway - Garberville - Benbow</i></p>

<table>

<tr>

<tr><td>Weekday (Mon-Fri)</td></tr>

<td style="padding-left:20px"><a href="sohum-local/north">Northbound</a></td><td style="padding-left:20px"><a href="sohum-local/south">Southbound</a></td>

</tr>

<table>


</table>



<a name="tish-non"/></a>
<h3>Tish Non Village</i></h3>


<table>

<table>

<tr>

<tr><td>Weekday (Mon-Fri)</td></tr>

<tr>
<td style="padding-left:20px"><a href="tishnon/north">Northbound</a></td><td style="padding-left:20px"><a href="tishnon/south">Southbound</a></td>
<td style="padding-left:20px"><a href="images/Tish-Non-schedule.jpg">JPEG image</a></td>

</tr>

</table>


<h3>Holiday service calendar</h3>

<p style="padding-left:20px">
<a href="holidays.php">Holiday service calendar for limited service and no service days</a></p>





</div>

</div>
<br clear="all" />
</div>

<?php require_once ('../includes/footer.html'); ?>

</body>

</html>
