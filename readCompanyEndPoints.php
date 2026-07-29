<?php

//STRICT TYPES
declare(strict_types=1);

//REQUIRE APIERP
require_once(__DIR__ . '/apiERP/apierp_init.php');

//SECURITY TRY/CATCH
try {

//PAYLOAD
$payload = [
'setAuthToken' => '',
'setCompanyEndPointType' => 2 //OPCIONAL SOLO RETORNAR ENDPOINT DE READ COMPANY
];

//PROCESS APIERP - CREATE COMPANY
$apiResponse = initializeApiERP()->readCompanyEndPoints($payload, false);

//RESPONSE
$apierp_success = $apiResponse['success'];
$apierp_message = $apiResponse['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}