<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use Override;

final class JsonReportExporter implements ReportExporter
{
    #[Override]
    public function export(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
