<?php

//STRICT TYPES
declare(strict_types=1);

//REQUIRE APIERP
require_once(__DIR__ . '/apiERP/apierp_init.php');

//DEFINIR MASTER AUTH TOKEN
$setMasterAuthToken = '';

//SECURITY TRY/CATCH
try {

//PAYLOAD
$payload = [
'setMasterAuthToken' => $setMasterAuthToken,
'setCompanyEndPointType' => 14 //OPCIONAL SOLO RETORNAR ENDPOINT DE CREATE COMPANY FASYB OPERATIONS
];

//PROCESS APIERP - READ COMPANY ENDPOINTS
$apiResponse = initializeApiERP()->readCompanyEndPoints($payload, false);

//ENDPOINT CREATE COMPANY FASYB OPERATIONS
$endpoint = $apiResponse['message']['setCompanyEndPoints'][0]['setCompanyEndPoint'];

//DEFINIR AUTH TOKEN API
$setAuthToken = '';

//PAYLOAD CREATE COMPANY FASYB OPERATIONS
$payload_create_company_fasyb_operations = [
'setAuthToken' => $setAuthToken,

];

//PROCESS APIERP - CREATE COMPANY FASYB OPERATIONS
$apiResponse_create_company_fasyb_operations = initializeApiERP()->createCompanyFasybOperations($payload_create_company_fasyb_operations, $endpoint, false);

//RESPONSE
$apierp_success = $apiResponse_create_company_fasyb_operations['success'];
$apierp_message = $apiResponse_create_company_fasyb_operations['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}