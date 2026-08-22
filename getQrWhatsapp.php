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
'setCompanyEndPointType' => 22 //OPCIONAL SOLO RETORNAR ENDPOINT DE GET QR WHATSAPP
];

//PROCESS APIERP - READ COMPANY ENDPOINTS
$apiResponse = initializeApiERP()->readCompanyEndPoints($payload, false);

//ENDPOINT GET QR WHATSAPP
$endpoint = $apiResponse['message']['setCompanyEndPoints'][0]['setCompanyEndPoint'];

//DEFINIR AUTH TOKEN API
$setAuthToken = '';

//PAYLOAD GET QR WHATSAPP
$payload_get_qr_whatsapp = [
'setAuthToken' => $setAuthToken,
'setCredentialsApiWAChatId' => 1
];

//PROCESS APIERP - GET QR WHATSAPP
$apiResponse_get_qr_whatsapp = initializeApiERP()->sendMessageWhatsapp($payload_get_qr_whatsapp, $endpoint, false);

//RESPONSE
$apierp_success = $apiResponse_get_qr_whatsapp['success'];
$apierp_message = $apiResponse_get_qr_whatsapp['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}