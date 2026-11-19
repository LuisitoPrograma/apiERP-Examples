<?php

//STRICT TYPES
declare(strict_types=1);

//REQUIRE APIERP
require_once(__DIR__ . '/apiERP/apierp_init.php');

//DEFINIR MASTER AUTH TOKEN
$setMasterAuthToken = '';

//SECURITY TRY/CATCH
try {

//DEFINIR AUTH TOKEN API
$setAuthToken = '';

//PAYLOAD SEND MESSAGE EMAIL
$payload_send_message_email = [
'setAuthToken' => $setAuthToken,
'senderName' => $senderName,
'senderEmail' => $senderEmail,
'senderPassword' => $senderPassword,
'smtpHost' => $smtpHost,
'smtpPort' => $smtpPort,
'emailsDestination' => $emailsDestination,
'subject' => $subject,
'message' => $message,
'attachFiles' => $attachFiles,
];

//PROCESS APIERP - SEND MESSAGE EMAIL
$apiResponse_send_message_email = initializeApiERP()->sendMessageEmail($payload_send_message_email, $setMasterAuthToken, false);

//RESPONSE
$apierp_success = $apiResponse_send_message_email['success'];
$apierp_message = $apiResponse_send_message_email['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}