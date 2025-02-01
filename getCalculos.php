<?php

// require vendor
require_once(__DIR__ . '/vendor/autoload.php');

// use
use apiERP\apiERP;

// Inicializar instancia
$apiERP = new apiERP();

// Datos de ejemplo para enviar al API
$productosAPI = [
    "descuentoGlobalMonto" => 5,
    "setPorcentajeIgv" => 18,
    "items" => [
        [
            "valorUnit" => 0,
            "precioUnit" => 10,
            "valorCantidad" => 1,
            "valorPorcentajeIgv" => 18,
            "setTipAfeIgv" => "10" // Gravado
        ],
        [
            "valorUnit" => 0,
            "precioUnit" => 10,
            "valorCantidad" => 1,
            "valorPorcentajeIgv" => 18,
            "setTipAfeIgv" => "20" // Exonerado
        ],
        [
            "valorUnit" => 0,
            "precioUnit" => 10,
            "valorCantidad" => 1,
            "valorPorcentajeIgv" => 18,
            "setTipAfeIgv" => "30" // Inafecto
        ],
        [
            "valorUnit" => 0,
            "precioUnit" => 10,
            "valorCantidad" => 1,
            "valorPorcentajeIgv" => 18,
            "setTipAfeIgv" => "13" // Gravado Gratuito
        ],
        [
            "valorUnit" => 0,
            "precioUnit" => 10,
            "valorCantidad" => 1,
            "valorPorcentajeIgv" => 18,
            "setTipAfeIgv" => "32" // Inafecto Gratuito
        ]
    ]
];

// Intentar hacer la solicitud al API
try {
    $apiResponse = $apiERP->getCalculos($productosAPI);

    // Verificar si la respuesta es válida
    if (!$apiResponse || !isset($apiResponse['setInvoice'])) {
        throw new \Exception("Respuesta no válida desde la API.");
    }

    // Extraer totales de la operación
    $totales = $apiResponse['setInvoice'];
    $detalles = $apiResponse['setInvoiceDetails'];

    // Formar la respuesta en JSON
    $response = [
        'totales' => $totales,
        'detalles' => $detalles
    ];

    // Establecer encabezado para JSON
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);

} catch (\Exception $e) {
    // En caso de error, devolver mensaje de error en JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT);
    exit();
}
