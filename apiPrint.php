<?php

// require vendor
require_once(__DIR__ . '/vendor/autoload.php');

// use
use apiERP\apiERP;

// Inicializar instancia
$apiERP = new apiERP();

// Data Print
$authToken; // Auth Token
$printerName; // Nombre Impresora Ejm: TM-T20III
$pdfUrl; // PDF link Url Web Ejm: https://mydomain.com/pdf/invoice.pdf

// Datos de ejemplo para enviar al API
$dataPrint = [
    "setAuthToken" => $authToken,
    "setPrinterName" => $printerName,
    "setPdfUrl" => $pdfUrl
];

// Intentar hacer la solicitud al API
try {
    $apiResponse = $apiERP->apiPrint($dataPrint);

    // Verificar si la respuesta es válida
    if (!$apiResponse || !isset($apiResponse['success'])) {
        throw new \Exception("Respuesta no válida desde la API.");
    }

    // Extraer Respuesta
    $response = $apiResponse['data'];

    // Establecer encabezado para JSON
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (\Exception $e) {
    // En caso de error, devolver mensaje de error en JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
    exit();
}
