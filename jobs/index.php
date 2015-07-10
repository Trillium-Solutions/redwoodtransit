<?php

// Start output buffering.
ob_start();
// Initialize a session.
session_start();



require_once ('../postgres_connect.php');

$jobs_query = "select news_id,title,body from news where news_category_id=3 and agency_id = 1 and start_date < now() and end_date > now() order by start_date desc";
$jobs_result = db_query($jobs_query);

?>

<html>

	<head><link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png" />
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Humboldt Transit Authority - employment opportunities</title>
		<link href="http://www.hta.org/fares.css" rel="stylesheet" type="text/css" media="all">
	</head>

	<body>
	
	<?php require_once ('../includes/google_translate.html'); ?>


<div align="left" id="content">
<a href="http://www.hta.org"><img src="http://www.hta.org/images/hta_logo.jpg" width="256.8" height="100" border="0"></a><br/>

<h1>Work for Humboldt Transit Authority (HTA)</h1>
<p style="font-style:italic">HTA operates <a href="http://www.redwoodtransit.org">Redwood Transit System</a> and <a href="http://www.eurekatransit.org">Eureka Transit Service</a>.</p>

<p>Respond to any opportunities by faxing, emailing, mailing or delivering a completed application: <strong><a href="http://www.hta.org/HTA%20employment%20application.pdf">Download employment application (PDF)</a></strong></p>

<h2>Current opportunities</h2>

<?php

if (db_num_rows($jobs_result) != 0) {

$i=0;

while ($row = db_fetch_array($jobs_result, MYSQL_ASSOC)) {
echo "<h3";

if ($i != 0) {echo ' style="border-bottom:1px solid #ccc; padding-top:5px;"';}

echo ">&#xBB; ".$row['title']."</h3>

<blockquote>".$row['body']."</blockquote>";
$i++;
}

}

else {echo "<p><i>There are no current opportunities posted.</i></p>";}

?>


<p style="line-height:130%;border-top:1px solid black;font-size:75%;padding-top:15px;"><strong>HTA contact/location:</strong>
<br/>133 'V' Street, Eureka, CA
<br/>707-443-0826
<br/>admin &#xAB;at&#xBB; hta.org</p>

<p><span style="color:#666; font-size:75%;">(To use the above email address, replace &#xAB;at&#xBB; with "@".  <nobr><a href="http://en.wikipedia.org/wiki/Address_munging">See why we did this.</a></nobr>)</p></p>

</div>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2025592-3";
urchinTracker();
</script>
		
</body>


</html>