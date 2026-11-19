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

//EJEMPLO A EJECUTAR
//CAMBIAR ESTE VALOR POR CUALQUIERA DE LOS CASOS DEL SWITCH
$ai_example = 'chat_text';

//PAYLOAD BASE PARA CHAT
$payload_call_artificial_intelligence = [
'setAuthToken' => $setAuthToken,
'process_type' => 'chat',
'user_message' => 'Genera un saludo comercial para el Día del Niño.',
'system_message' => 'Eres un especialista en marketing. Responde en español.',
'model' => 'gpt-4o-mini',
'temperature' => 0.6,
'max_tokens' => 3000
];

//DOCUMENTACION DE LOS PROCESOS SOPORTADOS POR LA API
switch($ai_example){
case 'chat_text':
//CHAT DE TEXTO SIN ARCHIVOS
break;

case 'chat_json':
//RESPUESTA ESTRUCTURADA COMO OBJETO JSON
$payload_call_artificial_intelligence['user_message'] = 'Devuelve un objeto JSON con las claves titulo y mensaje para una promoción.';
$payload_call_artificial_intelligence['response_format'] = ['type' => 'json_object'];
break;

case 'chat_history':
//CHAT CON HISTORIAL DE CONVERSACION
$payload_call_artificial_intelligence['user_message'] = 'Ahora crea una versión para Instagram.';
$payload_call_artificial_intelligence['history'] = [
['role' => 'user', 'content' => 'Necesito un saludo para el Día del Niño.'],
['role' => 'assistant', 'content' => '¡Feliz Día del Niño! Celebremos su alegría e imaginación.']
];
break;

case 'chat_audio':
//TRANSCRIPCION DE AUDIO Y RESPUESTA DE TEXTO
$payload_call_artificial_intelligence['user_message'] = 'Resume el audio y detecta la intención del cliente.';
$payload_call_artificial_intelligence['media'] = [
'type' => 'audio',
'url' => 'https://ejemplo.com/audio.ogg',
'caption' => 'Audio recibido por WhatsApp'
];
break;

case 'chat_image_url':
//ANALISIS DE IMAGEN DISPONIBLE POR HTTPS
$payload_call_artificial_intelligence['user_message'] = 'Describe la imagen y los elementos visuales relevantes.';
$payload_call_artificial_intelligence['media'] = [
'type' => 'image',
'url' => 'https://ejemplo.com/imagen.jpg',
'caption' => 'Imagen enviada por el cliente'
];
break;

case 'chat_pdf':
//LECTURA Y ANALISIS DE DOCUMENTO PDF
$payload_call_artificial_intelligence['user_message'] = 'Resume el PDF en cinco puntos.';
$payload_call_artificial_intelligence['media'] = [
'type' => 'document',
'url' => 'https://ejemplo.com/documento.pdf',
'caption' => 'Documento de referencia'
];
break;

case 'chat_images_base64':
//ADJUNTAR IMAGEN LOCAL DE MAXIMO 1 MB Y 1600 PIXELES POR LADO
$ai_imageBytes = @file_get_contents(__DIR__ . '/imagen_ejemplo.jpg');
if($ai_imageBytes === false || strlen($ai_imageBytes) > 1048576) throw new RuntimeException('La imagen de ejemplo no existe o supera 1 MB.');
$payload_call_artificial_intelligence['user_message'] = 'Analiza esta imagen adjunta.';
$payload_call_artificial_intelligence['images'] = ['data:image/jpeg;base64,' . base64_encode($ai_imageBytes)];
break;

case 'chat_deepseek':
//CHAT CON DEEPSEEK CONFIGURADO EN EL SERVIDOR
$payload_call_artificial_intelligence['model'] = 'deepseek-flash';
break;

case 'chat_gemini':
//CHAT CON GEMINI Y SU CREDENCIAL CONFIGURADA EN EL SERVIDOR
$payload_call_artificial_intelligence['model'] = 'gemini-2.5-flash';
break;

case 'image_generation':
//GENERACION DE IMAGEN DESDE TEXTO Y CARGA A S3
$payload_call_artificial_intelligence = [
'setAuthToken' => $setAuthToken,
'process_type' => 'image_generation',
'image_prompt' => 'Diseña un flyer comercial profesional para el Día del Niño.',
'image_model' => 'gpt-image-1',
'image_size' => '1024x1024',
'image_quality' => 'medium',
'image_output_format' => 'jpeg',
'image_output_compression' => 75,
'image_max_bytes' => 6000000,
'upload_to_s3' => true,
'return_base64' => false
];
break;

case 'image_edit':
//EDICION DE IMAGEN A PARTIR DE UNA URL DE REFERENCIA
$payload_call_artificial_intelligence = [
'setAuthToken' => $setAuthToken,
'process_type' => 'image_generation',
'image_prompt' => 'Mejora el diseño respetando el contenido original.',
'image_model' => 'gpt-image-1',
'image_size' => '1024x1024',
'image_quality' => 'high',
'image_output_format' => 'png',
'image_background' => 'opaque',
'upload_to_s3' => true,
'return_base64' => false,
'media' => ['type' => 'image', 'url' => 'https://ejemplo.com/referencia.png']
];
break;

case 'image_base64':
//GENERACION DE IMAGEN DEVUELTA EN BASE64 SOLO PARA PRUEBAS
$payload_call_artificial_intelligence = [
'setAuthToken' => $setAuthToken,
'process_type' => 'image_generation',
'image_prompt' => 'Crea una ilustración comercial de una cafetería.',
'image_model' => 'gpt-image-1',
'image_size' => '1024x1024',
'image_quality' => 'low',
'image_output_format' => 'webp',
'image_output_compression' => 70,
'upload_to_s3' => false,
'return_base64' => true
];
break;

default:
throw new InvalidArgumentException('Ejemplo de IA no reconocido.');
}


//PROCESS APIERP - CALL ARTIFICIAL INTELLIGENCE
$apiResponse_call_artificial_intelligence = initializeApiERP()->callArtificialIntelligence($payload_call_artificial_intelligence, $setMasterAuthToken, false);

//RESPONSE
$apierp_success = $apiResponse_call_artificial_intelligence['success'];
$apierp_message = $apiResponse_call_artificial_intelligence['message'];

//PRINT RESPONSE
header('Content-Type: application/json; charset=utf-8');
echo json_encode($apierp_message, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

} catch (Throwable $e){
echo json_encode(['success' => false, 'message' => 'No se pudo procesar la solicitud.'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
}