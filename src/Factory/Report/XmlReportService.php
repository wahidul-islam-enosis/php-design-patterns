<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use Override;

final class XmlReportService extends ReportService
{
    public function __construct(
        private readonly string $rootEleent = 'report'
    ) {}

    #[Override]
    protected function createExporter(): ReportExporter
    {
        return new XmlReportExporter($this->rootEleent);
    }
}
