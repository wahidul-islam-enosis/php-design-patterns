<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use Override;

final class CsvReportService extends ReportService
{
    #[Override]
    protected function createExporter(): ReportExporter
    {
        return new CsvReportExporter();
    }
}
