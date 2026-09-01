<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

abstract class ReportService
{
    abstract protected function createExporter(): ReportExporter;

    final public function generate(array $data): void
    {
        $reportExporter = $this->createExporter();
        print($reportExporter->export($data) . PHP_EOL);
    }
}
