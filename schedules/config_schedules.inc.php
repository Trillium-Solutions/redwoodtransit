<?php

// Supplemental schedule service_ids
$supplemental_service_id = array(934);


$routes_config = array(

// Starting 7/5/2015 (Mon-Fri)
// ID 2361
// Year round calendar (Mon-Fri) 
// ID 792

// Mainline / Northound / Weekday
    'weekday/north'  => array(
    'route_id' => 1,
    'direction_id' => 5,
    'common_stop_id' => 1252,
    'order' => 'ASC',
    'service_label' => 'Weekday',
    'service_ids' => array(792,2361)
    ),
        
// Mainline / Southbound / Weekday
'weekday/south' => array(
	'route_id' => 1,
	'direction_id' => 6,
	'common_stop_id' => 1252,
	'service_label' => 'Weekday',
	'service_ids' => array(792,2361)
),

// Mainline / Northound / Saturday

'saturday/north' => array(
	'route_id' => 1,
	'direction_id' => 5,
	'common_stop_id' => 1252,
	'service_label' => 'Saturday',
	'service_ids' => array(791,2366)
),


// Mainline / Southbound / Saturday
'saturday/south' => array(
	'route_id' => 1,
	'direction_id' => 6,
	'common_stop_id' => 1252,
	'service_label' => 'Saturday',
	'service_ids' => array(791,2366)
),

// Mainline / Southbound / Sunday
'sunday/south' => array(
	'route_id' => 1,
	'direction_id' => 6,
	'common_stop_id' => 1252,
	'service_label' => 'Sunday',
	'service_ids' => array(790)
),

// Mainline / Northbound / Sunday
'sunday/north' => array(
	'route_id' => 1,
	'direction_id' => 5,
	'common_stop_id' => 1252,
	'service_label' => 'Sunday',
	'service_ids' => array(790)
),

// SoHum intercity / North
'sohum-intercity/north' =>
	array(
		'route_id' => 822,
		'direction_id' => 5,
		'common_stop_id' => 1276,
		'common_order' => 'ASC',
		'service_label' => 'Weekday',
		'service_ids' => array(792,810,813,934)
	),

// SoHum intercity / South
'sohum-intercity/south' =>
array (
	'route_id' => 822,
	'direction_id' => 6,
	'common_stop_id' => 1255,
	'service_label' => 'Weekday',
	'service_ids' => array(792,810,813,934)
),

// http://gtfs.trilliumtransit.com/copy_service_for_route.php?agency_id=1&route_id=303&service_id=792&direction_id=6
// SoHum local / North
'sohum-local/north' => array(
	'route_id' => 303,
	'direction_id' => 5,
	'common_stop_id' => 10075,
	'service_label' => 'Weekday',
	'service_ids' => array(792)
),

// SoHum local / South
'sohum-local/south' => array(
	'route_id' => 303,
	'direction_id' => 6,
	'common_stop_id' => 780763,
	'service_label' => 'Weekday',
	'service_ids' => array(792)
),


//  http://gtfs.trilliumtransit.com/copy_service_for_route.php?agency_id=1&route_id=2597&service_id=2361&direction_id=6
// Tish Non Village
'tishnon/north' => array(
	'route_id' => 2597,
	'direction_id' => 5,
	'common_stop_id' => 1250,
	'service_label' => 'Weekday, beginning July 6, 2015',
	'service_ids' => array(2361)
),


'tishnon/south' => array(
	'route_id' => 2597,
	'direction_id' => 6,
	'common_stop_id' => 1250,
	'service_label' => 'Weekday, beginning July 6, 2015',
	'service_ids' => array(2361)
),


// Willow Creek / Weekday / East
'weekday/willowcreek/east' => array('route_id' => 8,
'direction_id' => 7,
'common_stop_id' => 1260,
'service_label' => 'Mon-Fri',
'service_ids' => array(792)
),

// Willow Creek / Weekday / West
'weekday/willowcreek/west' => array('route_id' => 8,
'direction_id' => 8,
'common_stop_id' => 1260,
'service_label' => 'Mon-Fri',
'service_ids' => array(792)
),

// Willow Creek / Saturday / East
'saturday/willowcreek/east' => array('route_id' => 8,
'direction_id' => 7,
'common_stop_id' => 1260,
'service_label' => 'Saturday',
'service_ids' => array(791)
),

// Willow Creek / Saturday / West
'saturday/willowcreek/west' => array('route_id' => 8,
'direction_id' => 8,
'common_stop_id' => 1260,
'service_label' => 'Saturday',
'service_ids' => array(791)
)

);

$urlvar = rtrim( $_GET['urlvar'] ,'/' );

$selected_route_vars = $routes_config[$urlvar];

if (isset($selected_route_vars['route_id'])) {$route_id=$selected_route_vars['route_id'];}
if (isset($selected_route_vars['direction_id'])) {$direction_id=$selected_route_vars['direction_id'];}
if (isset($selected_route_vars['service_label'])) {$service_label=$selected_route_vars['service_label'];}
if (isset($selected_route_vars['order'])) {$order=$selected_route_vars['order'];}
if (isset($selected_route_vars['common_stop_id'])) {$common_stop=$selected_route_vars['common_stop_id'];}
if (isset($selected_route_vars['service_ids'])) {$service_ids = $selected_route_vars['service_ids'];}

?>