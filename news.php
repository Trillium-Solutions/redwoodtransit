<?php
require_once ('postgres_connect.php');

		// Prepare a query for execution
		$news_result = pg_prepare($dbc, "news_query", 'select title,body from news where news_id=$1');

		// Execute the prepared query.  Note that it is not necessary to escape
		// the string "Joe's Widgets" in any way
		$news_result = pg_execute($dbc, "news_query", array($_GET['id']));

// $news_query = "select title,body from news where news_id=".$_GET['id'];
// $news_result = db_query($news_query);
while ($row = db_fetch_array($news_result, MYSQL_ASSOC)) {
$title = $row['title'];
$body = $row['body']; }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
<link rel="icon" type="image/png" href="http://www.hta.org/images/icon.png"/>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="generator" content="Adobe GoLive" />
		<title><?php echo $title; ?> | Redwood Transit System</title>
		<link href="css/main.css" rel="stylesheet" type="text/css" media="all" />

<style type="text/css">
#instruction {float:left; width:200px;height:300px;margin-left:10px;margin-right:10px;}
li {margin-left:20px; padding-right:7px;}
#zone_name {text-align:center; font-size:20px; line-height:25px; width:40px; font-weight:bold;padding:0px}
td {border-bottom:1px solid #ccc;padding:1px;padding-right:10px}
#page_title {font-size:16px;font-weight:bold;text-align:left;padding:25px 0px 0px 17px;margin:0px}
</style>

<script type="text/javascript">
</script>

</head>

<body>

<a href="#Content" class="hidden">Skip to Content</a>
<div id="Container">
<div id="ContentWrapper">




<div id="logo_header">
<a href="http://www.redwoodtransit.org/"><img src="images/rts_logo.gif" alt="Link to RTS homepage" border="0" width="252" height="81" /></a>
</div>

<div id="header_area">

<div id="nav_path"><a href="index.php">RTS Home</a> ></div>

<br clear="left"/>

<h1 id="page_title">News & service updates</h1>

</div>

<br clear="all">

<hr size="2"  width="784" style="padding-left:10px;padding-right:10px;">

<div id="page_text_itself">


<?php

echo $body;

?>

</div>

</div>
<br clear="all" />
</div>

<div id="Footer">
<p><a href="http://groups.google.com/group/humboldttransit/">Email updates</a> • <a href="http://www.redwoodtransit.org/jobs/"> Jobs @ HTA</a> • <a href="contact.php">Contact/Feedback</a> • <a href="link_to/">Link to redwoodtransit.org</a>
<br/><a href="credits.html">Site Credits</a> • <a href="http://www.spreadfirefox.com/?q=affiliates&amp;id=0&amp;t=219"><img border="0" alt="Firefox 2" title="Firefox 2" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox2/ff2b80x15.gif"/></a></p>
</div>
		
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2025592-1";
urchinTracker();
</script>

</body>

</html>