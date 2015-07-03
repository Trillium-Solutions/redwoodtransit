<?php

// Supplemental schedule service_ids
$supplemental_service_id = array(934);

// Mainline / Northound / Weekday
$mainline_north_weekday_url = 'weekday/north';
$mainline_north_weekday_route_id = 1;
$mainline_north_weekday_direction_id = 5;
$mainline_north_weekday_common_stop_id = 1252;
$mainline_north_weekday_order = 'ASC';
$mainline_north_weekday_service_label = 'Weekday, effective 19-January-2014';
$mainline_north_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$mainline_north_weekday_url || $_GET['urlvar']==$mainline_north_weekday_url.'/')
{$route_id=$mainline_north_weekday_route_id;
$direction_id=$mainline_north_weekday_direction_id;
$service_label=$mainline_north_weekday_service_label;
$order=$mainline_north_weekday_order;
$common_stop=$mainline_north_weekday_common_stop_id;
$service_ids = $mainline_north_weekday_service_ids;
}



// Mainline / Southbound / Weekday
$mainline_south_weekday_url = 'weekday/south';
$mainline_south_weekday_route_id = 1;
$mainline_south_weekday_direction_id = 6;
$mainline_south_weekday_common_stop_id = 1252;
$mainline_south_weekday_common_order = 'DESC';
$mainline_south_weekday_service_label = 'Weekday, effective 19-January-2014';
$mainline_south_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$mainline_south_weekday_url || $_GET['urlvar']==$mainline_south_weekday_url.'/')
{$route_id=$mainline_south_weekday_route_id;
$direction_id=$mainline_south_weekday_direction_id;
$service_label=$mainline_south_weekday_service_label;
$order=$mainline_south_weekday_common_order;
$common_stop=$mainline_south_weekday_common_stop_id;
$service_ids = $mainline_south_weekday_service_ids;
}

// Mainline / Northound / Saturday
$mainline_north_saturday_url = 'saturday/north';
$mainline_north_saturday_route_id = 1;
$mainline_north_saturday_direction_id = 5;
$mainline_north_saturday_common_stop_id = 1252;
$mainline_north_saturday_common_order = 'ASC';
$mainline_north_saturday_service_label = 'saturday';
$mainline_north_saturday_service_ids = array(791);

if ($_GET['urlvar']==$mainline_north_saturday_url || $_GET['urlvar']==$mainline_north_saturday_url.'/')
{$route_id=$mainline_north_saturday_route_id;
$direction_id=$mainline_north_saturday_direction_id;
$service_label=$mainline_north_saturday_service_label;
$order=$mainline_north_saturday_common_order;
$common_stop=$mainline_north_saturday_common_stop_id;
$service_ids = $mainline_north_saturday_service_ids;}

// Mainline / Southbound / Saturday
$mainline_south_saturday_url = 'saturday/south';
$mainline_south_saturday_route_id = 1;
$mainline_south_saturday_direction_id = 6;
$mainline_south_saturday_common_stop_id = 1252;
$mainline_south_saturday_common_order = 'DESC';
$mainline_south_saturday_service_label = 'Saturday';
$mainline_south_saturday_service_ids = array(791);

if ($_GET['urlvar']==$mainline_south_saturday_url || $_GET['urlvar']==$mainline_south_saturday_url.'/')
{$route_id=$mainline_south_saturday_route_id;
$direction_id=$mainline_south_saturday_direction_id;
$service_label=$mainline_south_saturday_service_label;
$order=$mainline_south_saturday_common_order;
$common_stop=$mainline_south_saturday_common_stop_id;
$service_ids = $mainline_south_saturday_service_ids;}


// Mainline / Northound / Sunday
$mainline_north_sunday_url = 'sunday/north';
$mainline_north_sunday_route_id = 1;
$mainline_north_sunday_direction_id = 5;
$mainline_north_sunday_common_stop_id = 1252;
$mainline_north_sunday_common_order = 'ASC';
$mainline_north_sunday_service_label = 'sunday';
$mainline_north_sunday_service_ids = array(790);

if ($_GET['urlvar']==$mainline_north_sunday_url || $_GET['urlvar']==$mainline_north_sunday_url.'/')
{$route_id=$mainline_north_sunday_route_id;
$direction_id=$mainline_north_sunday_direction_id;
$service_label=$mainline_north_sunday_service_label;
$order=$mainline_north_sunday_common_order;
$common_stop=$mainline_north_sunday_common_stop_id;
$service_ids = $mainline_north_sunday_service_ids;}

// Mainline / Southbound / Sunday
$mainline_south_sunday_url = 'sunday/south';
$mainline_south_sunday_route_id = 1;
$mainline_south_sunday_direction_id = 6;
$mainline_south_sunday_common_stop_id = 1252;
$mainline_south_sunday_common_order = 'DESC';
$mainline_south_sunday_service_label = 'sunday';
$mainline_south_sunday_service_ids = array(790);

if ($_GET['urlvar']==$mainline_south_sunday_url || $_GET['urlvar']==$mainline_south_sunday_url.'/')
{$route_id=$mainline_south_sunday_route_id;
$direction_id=$mainline_south_sunday_direction_id;
$service_label=$mainline_south_sunday_service_label;
$order=$mainline_south_sunday_common_order;
$common_stop=$mainline_south_sunday_common_stop_id;
$service_ids = $mainline_south_sunday_service_ids;
}


// SoHum intercity / North
$sohum_intercity_north_weekday_url = 'sohum-intercity/north';
$sohum_intercity_north_weekday_route_id = 822;
$sohum_intercity_north_weekday_direction_id = 5;
$sohum_intercity_north_weekday_common_stop_id = 1276;
$sohum_intercity_north_weekday_common_order = 'ASC';
$sohum_intercity_north_weekday_service_label = 'Weekday';
$sohum_intercity_north_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$sohum_intercity_north_weekday_url || $_GET['urlvar']==$sohum_intercity_north_weekday_url.'/')
{$route_id=$sohum_intercity_north_weekday_route_id;
$direction_id=$sohum_intercity_north_weekday_direction_id;
$service_label=$sohum_intercity_north_weekday_service_label;
$order=$sohum_intercity_north_weekday_common_order;
$common_stop=$sohum_intercity_north_weekday_common_stop_id;
$service_ids = $sohum_intercity_north_weekday_service_ids;
}

// SoHum intercity / South
$sohum_intercity_south_weekday_url = 'sohum-intercity/south';
$sohum_intercity_south_weekday_route_id = 822;
$sohum_intercity_south_weekday_direction_id = 6;
$sohum_intercity_south_weekday_common_stop_id = 1255;
$sohum_intercity_south_weekday_common_order = 'DESC';
$sohum_intercity_south_weekday_service_label = 'Weekday';
$sohum_intercity_south_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$sohum_intercity_south_weekday_url || $_GET['urlvar']==$sohum_intercity_south_weekday_url.'/')
{$route_id=$sohum_intercity_south_weekday_route_id;
$direction_id=$sohum_intercity_south_weekday_direction_id;
$service_label=$sohum_intercity_south_weekday_service_label;
$order=$sohum_intercity_south_weekday_common_order;
$common_stop=$sohum_intercity_south_weekday_common_stop_id;
$service_ids = $sohum_intercity_south_weekday_service_ids;
}


// SoHum local / North
$sohum_local_north_weekday_url = 'sohum-local/north';
$sohum_local_north_weekday_route_id = 303;
$sohum_local_north_weekday_direction_id = 5;
$sohum_local_north_weekday_common_stop_id = 10070;
$sohum_local_north_weekday_common_order = 'ASC';
$sohum_local_north_weekday_service_label = 'Weekday';
$sohum_local_north_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$sohum_local_north_weekday_url || $_GET['urlvar']==$sohum_local_north_weekday_url.'/')
{$route_id=$sohum_local_north_weekday_route_id;
$direction_id=$sohum_local_north_weekday_direction_id;
$service_label=$sohum_local_north_weekday_service_label;
$order=$sohum_local_north_weekday_common_order;
$common_stop=$sohum_local_north_weekday_common_stop_id;
$service_ids = $sohum_local_north_weekday_service_ids;
}

// SoHum local / South
$sohum_local_south_weekday_url = 'sohum-local/south';
$sohum_local_south_weekday_route_id = 303;
$sohum_local_south_weekday_direction_id = 6;
$sohum_local_south_weekday_common_stop_id = 10070;
$sohum_local_south_weekday_common_order = 'DESC';
$sohum_local_south_weekday_service_label = 'Weekday';
$sohum_local_south_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$sohum_local_south_weekday_url || $_GET['urlvar']==$sohum_local_south_weekday_url.'/')
{$route_id=$sohum_local_south_weekday_route_id;
$direction_id=$sohum_local_south_weekday_direction_id;
$service_label=$sohum_local_south_weekday_service_label;
$order=$sohum_local_south_weekday_common_order;
$common_stop=$sohum_local_south_weekday_common_stop_id;
$service_ids = $sohum_local_south_weekday_service_ids;
}



// Willow Creek / Weekday
$willowcreek_weekday_url = 'weekday/willowcreek';
$willowcreek_weekday_route_id = 8;
$willowcreek_weekday_common_order = 'DESC';
$willowcreek_weekday_service_label = 'Weekday';
$willowcreek_weekday_service_ids = array(792,810,813,934);

if ($_GET['urlvar']==$willowcreek_weekday_url || $_GET['urlvar']==$willowcreek_weekday_url.'/')
{$route_id=$willowcreek_weekday_route_id;
$service_label=$willowcreek_weekday_service_label;
$order=$willowcreek_weekday_common_order;
$service_ids = $willowcreek_weekday_service_ids;
}

// Willow Creek / Saturday
$willowcreek_saturday_url = 'saturday/willowcreek';
$willowcreek_saturday_route_id = 8;
$willowcreek_saturday_common_order = 'DESC';
$willowcreek_saturday_service_label = 'Saturday';
$willowcreek_saturday_service_ids = array(791);

if ($_GET['urlvar']==$willowcreek_saturday_url || $_GET['urlvar']==$willowcreek_saturday_url.'/')
{$route_id=$willowcreek_saturday_route_id;
$service_label=$willowcreek_saturday_service_label;
$order=$willowcreek_saturday_common_order;
$service_ids = $willowcreek_saturday_service_ids;
}

?>