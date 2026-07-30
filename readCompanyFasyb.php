<?php

//STRICT TYPES
declare(strict_types=1);

//REQUIRE APIERP
require_once(__DIR__ . '/apiERP/apierp_init.php');

//DEFINIR AUTH TOKEN
$setAuthToken = '';

//SECURITY TRY/CATCH
try {

//PAYLOAD
$payload = [
'setAuthToken' => $setAuthToken,
'setCompanyEndPointType' => 8 //OPCIONAL SOLO RETORNAR ENDPOINT DE READ COMPANY FASYB
];

//PROCESS APIERP - READ COMPANY ENDPOINTS
$apiResponse = initializeApiERP()->readCompanyEndPoints($payload, false);

//ENDPOINT READ COMPANY FASYB
$endpoint = $apiResponse['message']['setCompanyEndPoints'][0]['setCompanyEndPoint'];

//PAYLOAD READ COMPANY FASYB
$payload_read_company_fasyb = [
'setAuthToken' => $setAuthToken,
'apiPOS_getAccessData' => 1
];

//PROCESS APIERP - READ COMPANY FASYB
$apiResponse_read_company_fasyb = initializeApiERP()->readCompanyFasyb($payload_read_company_fasyb, $endpoint, false);

//RESPONSE
$apierp_success = $apiResponse_read_company_fasyb['success'];
$apierp_message = $apiResponse_read_company_fasyb['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}