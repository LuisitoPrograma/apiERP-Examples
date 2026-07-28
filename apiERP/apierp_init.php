<?php

//STRICT TYPES
declare(strict_types=1);

//REQUIRE COMPOSER VENDOR APIERP
require_once(__DIR__ . '/vendor/autoload.php');

//USES APIERP
use apiERP\apiERP;

//FUNCTION INITIALIZE APIERP
function initializeApiERP(): apiERP {
static $instance = null;
if(!$instance instanceof apiERP){
$instance = new apiERP();
}
return $instance;
}