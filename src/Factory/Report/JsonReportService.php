<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use Override;

final class JsonReportService extends ReportService
{
    #[Override]
    protected function createExporter(): ReportExporter
    {
        return new JsonReportExporter();
    }
}
