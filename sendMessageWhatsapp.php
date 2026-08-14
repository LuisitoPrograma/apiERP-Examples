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
'setCompanyEndPointType' => 23 //OPCIONAL SOLO RETORNAR ENDPOINT DE SEND MESSAGE WHATSAPP
];

//PROCESS APIERP - READ COMPANY ENDPOINTS
$apiResponse = initializeApiERP()->readCompanyEndPoints($payload, false);

//ENDPOINT SEND MESSAGE WHATSAPP
$endpoint = $apiResponse['message']['setCompanyEndPoints'][0]['setCompanyEndPoint'];

//PAYLOAD SEND MESSAGE WHATSAPP
$payload_send_message_whatsapp = [
'setAuthToken' => $setAuthToken,
'setCredentialsApiWAChatId' => 1,
'to' => '51999999999',
'payload' => [
'type' => 'text',
'content' => 'Hola, este es un mensaje de prueba.'
]
];

//PROCESS APIERP - SEND MESSAGE WHATSAPP
$apiResponse_send_message_whatsapp = initializeApiERP()->sendMessageWhatsapp($payload_send_message_whatsapp, $endpoint, false);

//RESPONSE
$apierp_success = $apiResponse_send_message_whatsapp['success'];
$apierp_message = $apiResponse_send_message_whatsapp['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}