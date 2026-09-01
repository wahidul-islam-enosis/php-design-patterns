<?php

declare(strict_types=1);

use Patterns\Factory\Report\CsvReportService;
use Patterns\Factory\Report\JsonReportService;
use Patterns\Factory\Report\ReportService;
use Patterns\Factory\Report\XmlReportService;

require_once __DIR__ . '/../vendor/autoload.php';

$data = [
    ['id' => 1, 'name' => 'Keyboard', 'price' => 80],
    ['id' => 2, 'name' => 'Mouse', 'price' => 40],
];

function generateReport(
    ReportService $reportService,
    array $data
) {
    $reportService->generate($data);
};

generateReport(
    new JsonReportService(),
    $data
);

generateReport(
    new CsvReportService(),
    $data
);

generateReport(
    new XmlReportService('products'),
    $data
);
