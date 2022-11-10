<?php

/*
bardata
contacts
geography
invoices
line
pie
team
transaction
*/

require_once './bardata.php';
require_once './contacts.php';
require_once './geography.php';
require_once './invoices.php';
require_once './line.php';
require_once './pie.php';
require_once './team.php';
require_once './transaction.php';

if ( filter_has_var(INPUT_POST, 'packet') ) {
    $packet = filter_input(INPUT_POST, 'packet');
} else if ( filter_has_var(INPUT_GET, 'packet') ) {
    $packet = filter_input(INPUT_GET, 'packet');
}

if( $packet == 'team' )
{
    $data = $teamdata;
}

header('Content-Type: application/json; charset=utf-8;');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');

echo json_encode($data);